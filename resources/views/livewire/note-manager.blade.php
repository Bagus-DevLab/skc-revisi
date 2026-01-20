<div class="p-4 bg-white">
    
    {{-- Notifikasi Sukses --}}
    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-2 mb-4 text-xs" role="alert">
            {{ session('message') }}
        </div>
    @endif

    {{-- Form Input (Bisa Mode Tambah / Edit) --}}
    <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}" class="mb-4">
        <div class="relative">
            <textarea 
                wire:model="content" 
                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm resize-none" 
                placeholder="Tulis ide atau tugas..." 
                rows="3" 
                required
            ></textarea>
            
            {{-- Tombol Aksi --}}
            <div class="flex justify-end mt-2 gap-2">
                @if($isEditing)
                    <button type="button" wire:click="resetInput" class="text-xs text-gray-500 hover:text-gray-700 underline">
                        Batal
                    </button>
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-bold py-1.5 px-3 rounded shadow-sm transition">
                        Update
                    </button>
                @else
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-1.5 px-3 rounded shadow-sm transition flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Simpan
                    </button>
                @endif
            </div>
        </div>
        @error('content') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
    </form>

    {{-- Daftar Catatan --}}
    <div class="space-y-3 max-h-[300px] overflow-y-auto pr-1 scrollbar-thin scrollbar-thumb-gray-300">
        @forelse($notes as $note)
            <div class="bg-yellow-50 p-3 rounded-lg border border-yellow-100 group relative hover:shadow-sm transition">
                <p class="text-gray-700 text-sm leading-relaxed whitespace-pre-wrap">{{ $note->content }}</p>
                <div class="text-[10px] text-gray-400 mt-2 text-right">
                    {{ $note->created_at->diffForHumans() }}
                </div>

                {{-- Tombol Edit & Hapus (Muncul saat hover) --}}
                <div class="absolute top-2 right-2 hidden group-hover:flex gap-1 bg-yellow-50 p-1 rounded shadow-sm">
                    <button wire:click="edit({{ $note->id }})" class="p-1 text-blue-600 hover:bg-blue-100 rounded" title="Edit">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </button>
                    <button wire:click="delete({{ $note->id }})" wire:confirm="Yakin ingin menghapus catatan ini?" class="p-1 text-red-600 hover:bg-red-100 rounded" title="Hapus">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            </div>
        @empty
            <div class="text-center py-4 border-2 border-dashed border-gray-200 rounded-lg">
                <p class="text-gray-400 text-xs">Belum ada catatan.</p>
            </div>
        @endforelse
    </div>
</div>