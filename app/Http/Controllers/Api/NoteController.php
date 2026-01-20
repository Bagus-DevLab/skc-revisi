<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note; // Pastikan Model Note sudah ada
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        // Ini yang menyebabkan error karena ->notes() tidak ada di model User
        $notes = $request->user()->notes()->get(); 
        
        return response()->json($notes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        // Pastikan user_id ikut disimpan
        $note = Note::create([
            'user_id' => auth()->id(), // Ambil ID dari token Sanctum
            'content' => $request->content,
        ]);

        return response()->json($note, 201);
    }

    public function destroy($id)
    {
        // 1. Cari note berdasarkan ID
        $note = Note::find($id);

        // 2. Jika tidak ada, beri respon 404 (bukan 500)
        if (!$note) {
            return response()->json(['message' => 'Catatan tidak ditemukan'], 404);
        }

        // 3. Pastikan yang menghapus adalah pemiliknya
        if ($note->user_id !== auth()->id()) {
            return response()->json(['message' => 'Anda tidak punya akses'], 403);
        }

        // 4. Eksekusi hapus
        $note->delete();

        return response()->json(['message' => 'Catatan berhasil dihapus'], 200);
    }
}   