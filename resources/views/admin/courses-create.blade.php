<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Kursus Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                
                <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Judul --}}
                        <div class="col-span-2">
                            <x-label for="title" value="Judul Kursus" />
                            <x-input id="title" name="title" type="text" class="mt-1 block w-full" placeholder="Contoh: Laravel Web Development" required />
                        </div>

                        {{-- Kategori --}}
                        <div>
                            <x-label for="category" value="Kategori" />
                            <select id="category" name="category" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                <option value="Programming">Programming</option>
                                <option value="Design">UI/UX Design</option>
                                <option value="Marketing">Digital Marketing</option>
                            </select>
                        </div>

                        {{-- Durasi --}}
                        <div>
                            <x-label for="duration" value="Durasi (Minggu)" />
                            <x-input id="duration" name="duration" type="number" class="mt-1 block w-full" placeholder="Misal: 12" required />
                        </div>

                        {{-- Harga --}}
                        <div>
                            <x-label for="price" value="Harga (Rp)" />
                            <x-input id="price" name="price" type="number" class="mt-1 block w-full" placeholder="750000" required />
                        </div>

                        {{-- Gambar --}}
                        <div>
                            <x-label for="image" value="Thumbnail Kursus" />
                            <input type="file" id="image" name="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <x-label for="description" value="Deskripsi Kursus" />
                        <textarea id="description" name="description" rows="5" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Tuliskan materi apa saja yang akan dipelajari..."></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-4 border-t pt-6">
                        <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
                        <x-button class="bg-blue-600 hover:bg-blue-700">
                            Simpan Kursus
                        </x-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>