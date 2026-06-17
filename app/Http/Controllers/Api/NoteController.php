<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\RespondsWithApiJson;
use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    use RespondsWithApiJson;

    public function index(Request $request)
    {
        $notes = $request->user()->notes()->latest()->get();

        return $this->success($notes);
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

        return $this->success($note, 'Catatan berhasil dibuat', 201);
    }

    public function show(Note $note)
    {
        if ($note->user_id !== auth()->id()) {
            return $this->error('Anda tidak punya akses', 403);
        }

        return $this->success($note);
    }

    public function update(Request $request, Note $note)
    {
        if ($note->user_id !== auth()->id()) {
            return $this->error('Anda tidak punya akses', 403);
        }

        $request->validate([
            'content' => 'required|string',
        ]);

        $note->update([
            'content' => $request->content,
        ]);

        return $this->success($note, 'Catatan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $note = Note::find($id);

        if (! $note) {
            return $this->error('Catatan tidak ditemukan', 404);
        }

        if ($note->user_id !== auth()->id()) {
            return $this->error('Anda tidak punya akses', 403);
        }

        $note->delete();

        return $this->success(null, 'Catatan berhasil dihapus');
    }
}
