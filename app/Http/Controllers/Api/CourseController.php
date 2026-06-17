<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\RespondsWithApiJson;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    use RespondsWithApiJson;

    public function index()
    {
        $courses = Course::withCount('lessons')
            ->latest()
            ->get()
            ->map(fn (Course $course) => $this->coursePayload($course));

        return $this->success($courses);
    }

    public function show($id)
    {
        $course = Course::withCount('lessons')->find($id);

        if (! $course) {
            return $this->error('Kursus tidak ditemukan', 404);
        }

        return $this->success($this->coursePayload($course));
    }

    public function lessons(Request $request, $course_id)
    {
        $course = Course::find($course_id);
        if (! $course) {
            return $this->error('Kursus tidak ditemukan', 404);
        }

        $enrollment = Enrollment::query()
            ->where('user_id', $request->user()->id)
            ->where('course_id', $course_id)
            ->first();

        if (! $enrollment) {
            return $this->error('Anda belum terdaftar', 403);
        }

        $completedLessons = $enrollment->completed_lessons ?? [];

        $lessons = $course->lessons()
            ->orderBy('order')
            ->orderBy('id')
            ->get()
            ->map(fn (Lesson $lesson) => $this->lessonPayload($lesson, in_array($lesson->id, $completedLessons)));

        return $this->success($lessons);
    }

    public function completeLessonByLesson(Request $request, $lesson_id)
    {
        $user = $request->user();
        $lesson = Lesson::find($lesson_id);

        if (! $lesson) {
            return $this->error('Materi tidak ditemukan', 404);
        }

        $enrollment = Enrollment::query()
            ->where('user_id', $user->id)
            ->where('course_id', $lesson->course_id)
            ->first();

        if (! $enrollment) {
            return $this->error('Anda belum terdaftar', 403);
        }

        $completedLessons = $enrollment->completed_lessons ?? [];
        $alreadyCompleted = in_array($lesson->id, $completedLessons);

        if (! $alreadyCompleted) {
            $completedLessons[] = $lesson->id;
        }

        $lessonCount = max($lesson->course->lessons()->count(), 1);
        $newProgress = min((int) round((count(array_unique($completedLessons)) / $lessonCount) * 100), 100);
        $status = $newProgress >= 100 ? 'finished' : 'active';

        $enrollment->update([
            'completed_lessons' => array_values(array_unique($completedLessons)),
            'progress' => $newProgress,
            'status' => $status,
            'last_accessed_at' => now(),
        ]);

        return $this->success([
            'lesson_id' => $lesson->id,
            'progress' => $enrollment->fresh()->progress,
            'status' => $status,
            'is_completed' => $newProgress >= 100,
            'already_completed' => $alreadyCompleted,
        ], 'Progress berhasil diupdate');
    }

    public function completeLesson(Request $request, $id)
    {
        $user = $request->user();
        $course = Course::find($id);

        if (! $course) {
            return $this->error('Kursus tidak ditemukan', 404);
        }

        $enrollment = Enrollment::query()
            ->where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (! $enrollment) {
            return $this->error('Anda belum terdaftar', 403);
        }

        $completedLessons = $enrollment->completed_lessons ?? [];
        $nextLesson = $course->lessons()
            ->whereNotIn('id', $completedLessons)
            ->orderBy('order')
            ->orderBy('id')
            ->first();

        if ($nextLesson) {
            return $this->completeLessonByLesson($request, $nextLesson->id);
        }

        $newProgress = min($enrollment->progress + 10, 100);
        $status = $newProgress >= 100 ? 'finished' : 'active';

        $enrollment->update([
            'progress' => $newProgress,
            'status' => $status,
            'last_accessed_at' => now(),
        ]);

        return $this->success([
            'progress' => $newProgress,
            'status' => $status,
            'is_completed' => $newProgress >= 100,
        ], 'Progress berhasil diupdate');
    }

    public function myCourses(Request $request)
    {
        $courses = $request->user()
            ->courses()
            ->withCount('lessons')
            ->get()
            ->map(fn (Course $course) => $this->coursePayload($course, true));

        return $this->success($courses);
    }

    public function myCertificates(Request $request)
    {
        $courses = $request->user()
            ->courses()
            ->withCount('lessons')
            ->wherePivot('status', 'finished')
            ->get()
            ->map(fn (Course $course) => $this->coursePayload($course, true));

        return $this->success($courses);
    }

    public function recommendations(Request $request)
    {
        $validated = $request->validate([
            'category' => ['nullable', 'string'],
            'pref_price' => ['nullable', 'integer', 'min:1', 'max:5'],
            'pref_rating' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        $courses = Course::query()
            ->withCount('lessons')
            ->when($validated['category'] ?? null, fn ($query, $category) => $query->where('category', $category))
            ->get();

        if ($courses->isEmpty()) {
            return $this->success([], 'Tidak ada kursus yang cocok.');
        }

        $minPrice = Course::min('price') ?: 1;
        $maxRating = Course::max('rating') ?: 1;
        $prefPrice = $validated['pref_price'] ?? 1;
        $prefRating = $validated['pref_rating'] ?? 1;

        $recommended = $courses
            ->map(function (Course $course) use ($minPrice, $maxRating, $prefPrice, $prefRating) {
                $priceScore = $minPrice / ($course->price ?: 1);
                $ratingScore = ($course->rating ?: 0) / $maxRating;
                $course->match_score = ($priceScore * 0.515 * $prefPrice) + ($ratingScore * 0.222 * $prefRating);

                return $course;
            })
            ->sortByDesc('match_score')
            ->values()
            ->map(fn (Course $course) => $this->coursePayload($course) + [
                'match_score' => round($course->match_score, 4),
            ]);

        return $this->success($recommended);
    }

    private function coursePayload(Course $course, bool $includeEnrollment = false): array
    {
        $payload = [
            'id' => $course->id,
            'title' => $course->title,
            'category' => $course->category,
            'price' => $course->price,
            'duration' => $course->duration,
            'description' => $course->description,
            'image' => $course->image,
            'image_url' => $this->storageUrl($course->image),
            'rating' => $course->rating,
            'students_count' => $course->students_count,
            'difficulty_level' => $course->difficulty_level,
            'instructor' => 'Admin',
            'lesson_count' => $course->lessons_count ?? $course->lessons()->count(),
        ];

        if ($includeEnrollment && $course->pivot) {
            $payload['enrollment'] = [
                'progress' => $course->pivot->progress,
                'status' => $course->pivot->status,
                'last_accessed_at' => $course->pivot->last_accessed_at,
                'completed_lessons' => $course->pivot->completed_lessons ? json_decode($course->pivot->completed_lessons, true) : [],
            ];
        }

        return $payload;
    }

    private function lessonPayload(Lesson $lesson, bool $isCompleted = false): array
    {
        return [
            'id' => $lesson->id,
            'course_id' => $lesson->course_id,
            'title' => $lesson->title,
            'description' => $lesson->description,
            'video_url' => $lesson->video_url,
            'content' => $lesson->content,
            'order' => $lesson->order,
            'is_completed' => $isCompleted,
        ];
    }

    private function storageUrl(?string $path): ?string
    {
        return $path ? asset('storage/'.$path) : null;
    }
}
