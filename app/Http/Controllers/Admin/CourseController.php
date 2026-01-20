<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::latest()->get();
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        return redirect()->route('admin.courses.index')->with('success', 'Kursus berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
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
        return redirect()->route('admin.courses.index')->with('success', 'Kursus berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->back()->with('success', 'Kursus berhasil dihapus');
    }
}
