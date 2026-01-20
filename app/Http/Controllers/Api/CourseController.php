<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // List kursus untuk landing page Flutter
    public function index() {
        $courses = Course::latest()->get()->map(function($course) {
            $course->image = url('storage/' . $course->image);
            return $course;
        });
        return response()->json($courses);
    }

    // Kursus yang sudah dibeli user
    public function myCourses() {
        $courses = auth()->user()->courses()->withPivot('progress', 'status')->get()->map(function($course) {
            $course->image = url('storage/' . $course->image);
            return $course;
        });
        return response()->json($courses);
    }

    // Sertifikat (kursus status finished)
    public function myCertificates() {
        $certs = auth()->user()->courses()
                    ->wherePivot('status', 'finished')
                    ->get();
        return response()->json($certs);
    }
}