<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                    {{ __('Edit Course') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Perbarui detail course, metrik rekomendasi, atau gambar utama.</p>
            </div>
            <a href="{{ route('admin.courses.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-lg border border-gray-300 bg-white shadow-sm ring-1 ring-gray-200">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-5">
                    <h3 class="text-base font-semibold text-gray-900">Informasi Course</h3>
                    <p class="mt-1 text-sm text-gray-600">Pastikan perubahan sudah sesuai sebelum disimpan.</p>
                </div>

                <form action="{{ route('admin.courses.update', $course, absolute: false) }}" method="POST" enctype="multipart/form-data" class="p-6" x-data="{ imageError: '', validateImage(event) { const file = event.target.files[0]; this.imageError = ''; if (file && file.size > 2 * 1024 * 1024) { this.imageError = 'Ukuran gambar maksimal 2 MB. Pilih gambar yang lebih kecil.'; event.target.value = ''; } } }" @submit="if (imageError) $event.preventDefault()">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <x-label for="title" value="{{ __('Title') }}" />
                            <x-input id="title" class="mt-2 block w-full border-gray-400 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500" type="text" name="title" :value="old('title', $course->title)" required autofocus autocomplete="title" />
                            <x-input-error for="title" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="category" value="{{ __('Category') }}" />
                            <x-input id="category" class="mt-2 block w-full border-gray-400 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500" type="text" name="category" :value="old('category', $course->category)" required />
                            <x-input-error for="category" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="price" value="{{ __('Price') }}" />
                            <x-input id="price" class="mt-2 block w-full border-gray-400 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500" type="number" name="price" :value="old('price', $course->price)" required min="0" step="1000" />
                            <p class="mt-1 text-xs text-gray-500">Masukkan nominal tanpa titik atau koma.</p>
                            <x-input-error for="price" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="duration" value="{{ __('Duration') }}" />
                            <x-input id="duration" class="mt-2 block w-full border-gray-400 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500" type="number" name="duration" :value="old('duration', $course->duration)" required min="1" />
                            <p class="mt-1 text-xs text-gray-500">Durasi dalam jam belajar.</p>
                            <x-input-error for="duration" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="rating" value="{{ __('Rating') }}" />
                            <x-input id="rating" class="mt-2 block w-full border-gray-400 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500" type="number" name="rating" :value="old('rating', $course->rating)" required min="0" max="5" step="0.1" />
                            <p class="mt-1 text-xs text-gray-500">Nilai antara 0 sampai 5.</p>
                            <x-input-error for="rating" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="students_count" value="{{ __('Students Count') }}" />
                            <x-input id="students_count" class="mt-2 block w-full border-gray-400 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500" type="number" name="students_count" :value="old('students_count', $course->students_count)" required min="0" />
                            <x-input-error for="students_count" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="difficulty_level" value="{{ __('Difficulty Level') }}" />
                            <select id="difficulty_level" name="difficulty_level" required class="mt-2 block w-full rounded-md border-gray-400 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Pilih tingkat kesulitan</option>
                                @foreach ([1 => '1 - Beginner', 2 => '2 - Basic', 3 => '3 - Intermediate', 4 => '4 - Advanced', 5 => '5 - Expert'] as $value => $label)
                                    <option value="{{ $value }}" @selected((string) old('difficulty_level', $course->difficulty_level) === (string) $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <x-input-error for="difficulty_level" class="mt-2" />
                        </div>

                        <div class="md:col-span-2">
                            <x-label for="description" value="{{ __('Description') }}" />
                            <textarea id="description" name="description" rows="6" required class="mt-2 block w-full rounded-md border-gray-400 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $course->description) }}</textarea>
                            <x-input-error for="description" class="mt-2" />
                        </div>

                        <div class="md:col-span-2">
                            <x-label for="image" value="{{ __('Image') }}" />
                            <div class="mt-2 grid gap-4 rounded-lg border border-dashed border-gray-400 bg-gray-50 p-4 sm:grid-cols-[auto,1fr] sm:items-center">
                                @if ($course->image)
                                    <img src="{{ asset('storage/'.$course->image) }}" alt="{{ $course->title }}" class="h-28 w-28 rounded-md border border-gray-300 object-cover shadow-sm">
                                @else
                                    <div class="flex h-28 w-28 items-center justify-center rounded-md border border-gray-300 bg-white text-xs text-gray-500">
                                        No image
                                    </div>
                                @endif

                                <div>
                                    <input id="image" class="block w-full text-sm text-gray-700 file:mr-4 file:rounded-md file:border-0 file:bg-blue-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-blue-700" type="file" name="image" accept="image/jpeg,image/png,image/jpg" @change="validateImage" />
                                    <p class="mt-2 text-xs text-gray-500">Kosongkan jika tidak ingin mengganti gambar. Format JPG atau PNG, maksimal 2 MB.</p>
                                    <p x-show="imageError" x-text="imageError" class="mt-2 text-sm text-red-600" style="display: none;"></p>
                                </div>
                            </div>
                            <x-input-error for="image" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col-reverse gap-3 border-t border-gray-200 pt-6 sm:flex-row sm:items-center sm:justify-end">
                        <a href="{{ route('admin.courses.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Batal
                        </a>
                        <x-button class="justify-center bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:ring-blue-500">
                            {{ __('Update') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
