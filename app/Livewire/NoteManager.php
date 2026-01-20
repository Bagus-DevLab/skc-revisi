<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NoteManager extends Component
{
    public $notes; // Menampung list data (READ)
    public $content; // Menampung input form
    public $note_id; // Menyimpan ID saat edit
    public $isEditing = false; // Status mode edit

    // Validasi form
    protected $rules = [
        'content' => 'required|min:3|max:500',
    ];

    // [READ] Mengambil data saat komponen dimuat
    public function render()
    {
        $this->notes = Note::where('user_id', Auth::id())
                        ->latest() // Urutkan dari yang terbaru
                        ->get();
                        
        return view('livewire.note-manager');
    }

    // [CREATE] Membuat catatan baru
    public function store()
    {
        $this->validate();

        Note::create([
            'user_id' => Auth::id(),
            'content' => $this->content,
        ]);

        $this->resetInput();
        session()->flash('message', 'Catatan berhasil ditambahkan.');
    }

    // [UPDATE - Tahap 1] Mengambil data untuk diedit
    public function edit($id)
    {
        $note = Note::findOrFail($id);
        
        // Security Check: Pastikan note milik user yang login
        if($note->user_id !== Auth::id()) {
            abort(403);
        }

        $this->note_id = $id;
        $this->content = $note->content;
        $this->isEditing = true;
    }

    // [UPDATE - Tahap 2] Menyimpan perubahan
    public function update()
    {
        $this->validate();

        $note = Note::findOrFail($this->note_id);
        
        if($note->user_id !== Auth::id()) {
            abort(403);
        }

        $note->update([
            'content' => $this->content,
        ]);

        $this->resetInput();
        session()->flash('message', 'Catatan berhasil diperbarui.');
    }

    // [DELETE] Menghapus catatan
    public function delete($id)
    {
        $note = Note::findOrFail($id);
        
        if($note->user_id === Auth::id()) {
            $note->delete();
            session()->flash('message', 'Catatan dihapus.');
        }
    }

    // Helper: Reset form ke kondisi awal
    public function resetInput()
    {
        $this->content = '';
        $this->note_id = null;
        $this->isEditing = false;
        $this->resetErrorBag();
    }
}