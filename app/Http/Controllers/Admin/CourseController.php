<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth yang benar
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf; // Import PDF Facade

class CourseController extends Controller
{
    public function create()
    {
        return view('admin.courses-create');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required',
            'price' => 'required|numeric',
            'duration' => 'required|numeric',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'rating' => 'required|numeric|min:0|max:5',
            'students_count' => 'required|numeric|min:0',
            'difficulty_level' => 'required|in:1,2,3,4,5',
        ]);

        // 2. Handle Upload Gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courses', 'public');
        }

        // 3. Simpan ke Database
        Course::create([
            'title' => $request->title,
            'category' => $request->category,
            'price' => $request->price,
            'duration' => $request->duration,
            'description' => $request->description,
            'image' => $imagePath,
            'rating' => $request->rating,
            'students_count' => $request->students_count,
            'difficulty_level' => $request->difficulty_level,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Kursus berhasil ditambahkan!');
    }

    public function downloadCertificate($courseId)
    {
        $user = Auth::user();

        // Ambil data kursus dan pastikan statusnya 'finished'
        $course = $user->courses()
            ->where('course_id', $courseId)
            ->wherePivot('status', 'finished')
            ->firstOrFail();

        $data = [
            'name' => $user->name,
            'course_title' => $course->title,
            'date' => now()->format('d F Y'),
            'cert_id' => 'SC-' . $course->id . $user->id . '-' . rand(1000, 9999)
        ];

        /** * CATATAN PENTING:
         * Pilih salah satu opsi di bawah ini.
         */

        // OPSI A: Jika library DomPDF BELUM terinstall (Hanya menampilkan HTML di browser)
        // return view('pdf.certificate', $data);

        // OPSI B: Jika library DomPDF SUDAH terinstall (Download PDF otomatis)
        $pdf = Pdf::loadView('pdf.certificate', $data)->setPaper('a4', 'landscape');
        return $pdf->download('Sertifikat-' . $course->title . '.pdf');
    }

    public function learn(Course $course)
    {
        // Pastikan user sudah enroll di kursus ini
        if (!auth()->user()->courses()->where('course_id', $course->id)->exists()) {
            return redirect()->route('courses.index')
                ->with('error', 'Anda belum terdaftar di kursus ini.');
        }

        // Ambil data enrollment user
        $enrollment = auth()->user()->courses()
            ->where('course_id', $course->id)
            ->first();

        return view('courses.learn', compact('course', 'enrollment'));
    }   
    public function edit(Course $course) {
        return view('admin.courses-edit', compact('course'));
    }

    public function destroy(Course $course) {
        $course->delete();
        return redirect()->back()->with('success', 'Kursus berhasil dihapus');
    }

    public function update(Request $request, Course $course)
    {
        // 1. Validasi Input (Sesuaikan dengan field di database kamu)
        $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required',
            'price'       => 'required|numeric',
            'duration'    => 'required|numeric',
            'description' => 'required',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Nullable karena tidak wajib ganti gambar
            'rating' => 'required|numeric|min:0|max:5',
            'students_count' => 'required|numeric|min:0',
            'difficulty_level' => 'required|in:1,2,3,4,5',
        ]);

        // Ambil semua data input kecuali gambar
        $data = $request->only(['title', 'category', 'price', 'duration', 'description', 'rating', 'students_count', 'difficulty_level']);

        // 2. Handle Ganti Gambar (Jika ada file baru yang diunggah)
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari storage agar tidak memenuhi server
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }
            
            // Simpan gambar baru
            $imagePath = $request->file('image')->store('courses', 'public');
            $data['image'] = $imagePath;
        }

        // 3. Update Data di Database
        $course->update($data);

        // 4. Redirect kembali ke dashboard dengan pesan sukses
        return redirect()->route('admin.dashboard')->with('success', 'Kursus berhasil diperbarui!');
    }
}