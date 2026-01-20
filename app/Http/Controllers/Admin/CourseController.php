<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function create() {
        return view('admin.courses-create');
    }

    public function store(Request $request) {
        // 1. Validasi Input
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required',
            'price' => 'required|numeric',
            'duration' => 'required|numeric',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
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
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Kursus berhasil ditambahkan!');
    }
}
