<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $notes = $request->user()->notes()->latest()->get();

        return response()->json($notes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $note = Note::create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return response()->json($note, 201);
    }

    public function show(Note $note)
    {
        if ($note->user_id !== auth()->id()) {
            return response()->json(['message' => 'Anda tidak punya akses'], 403);
        }

        return response()->json($note);
    }

    public function update(Request $request, Note $note)
    {
        if ($note->user_id !== auth()->id()) {
            return response()->json(['message' => 'Anda tidak punya akses'], 403);
        }

        $request->validate([
            'content' => 'required|string',
        ]);

        $note->update([
            'content' => $request->content,
        ]);

        return response()->json($note);
    }

    public function destroy($id)
    {
        $note = Note::find($id);

        if (! $note) {
            return response()->json(['message' => 'Catatan tidak ditemukan'], 404);
        }

        if ($note->user_id !== auth()->id()) {
            return response()->json(['message' => 'Anda tidak punya akses'], 403);
        }

        $note->delete();

        return response()->json(['message' => 'Catatan berhasil dihapus'], 200);
    }
}
