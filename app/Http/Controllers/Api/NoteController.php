<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note; // Pastikan Model Note sudah ada
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index() {
        return response()->json(auth()->user()->notes()->latest()->get());
    }

    public function store(Request $request) {
        $note = auth()->user()->notes()->create($request->only('content'));
        return response()->json($note, 201);
    }

    public function destroy($id) {
        $note = auth()->user()->notes()->findOrFail($id);
        $note->delete();
        return response()->json(['message' => 'Catatan dihapus']);
    }
}   