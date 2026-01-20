<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Kursus') }}: {{ $course->title }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-xs bg-gray-500 text-white px-3 py-1 rounded-lg font-bold hover:bg-gray-600 transition">
                KEMBALI
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-8">
                    <form action="{{ route('admin.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Judul Kursus</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $course->title) }}" 
                                    class="w-full border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm" required>
                                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                                <select name="category" id="category" class="w-full border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                                    <option value="Programming" {{ $course->category == 'Programming' ? 'selected' : '' }}>Programming</option>
                                    <option value="Design" {{ $course->category == 'Design' ? 'selected' : '' }}>Design</option>
                                    <option value="Business" {{ $course->category == 'Business' ? 'selected' : '' }}>Business</option>
                                    <option value="Marketing" {{ $course->category == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                </select>
                                @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="price" class="block text-sm font-bold text-gray-700 mb-2">Harga (Rp)</label>
                                <input type="number" name="price" id="price" value="{{ old('price', $course->price) }}" 
                                    class="w-full border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm" required>
                                @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Thumbnail Kursus</label>
                                <div class="flex items-start gap-4">
                                    @if($course->image)
                                        <div class="shrink-0">
                                            <p class="text-[10px] text-gray-400 mb-1">Preview Saat Ini:</p>
                                            <img src="{{ asset('storage/' . $course->image) }}" class="w-24 h-16 object-cover rounded-lg border">
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <input type="file" name="image" id="image" 
                                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                        <p class="text-[10px] text-gray-400 mt-2 italic">*Kosongkan jika tidak ingin mengganti gambar.</p>
                                    </div>
                                </div>
                                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <hr class="border-gray-100">
                            <div>
                                <label for="duration" class="block text-sm font-bold text-gray-700 mb-2">Durasi (Menit)</label>
                                <input type="number" name="duration" id="duration" value="{{ old('duration', $course->duration) }}" 
                                    class="w-full border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm" required>
                                @error('duration') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                                <textarea name="description" id="description" rows="4" 
                                    class="w-full border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm" required>{{ old('description', $course->description) }}</textarea>
                                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-blue-700 transition shadow-md">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>