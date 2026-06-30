<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                    {{ __('Create Course') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Tambahkan informasi course, harga, metrik rekomendasi, dan gambar utama.</p>
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
                    <p class="mt-1 text-sm text-gray-600">Field bertanda wajib harus diisi sebelum course dipublikasikan.</p>
                </div>

                <form action="{{ route('admin.courses.store', absolute: false) }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <x-label for="title" value="{{ __('Title') }}" />
                            <x-input id="title" class="mt-2 block w-full border-gray-400 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500" type="text" name="title" :value="old('title')" required autofocus autocomplete="title" placeholder="Contoh: Laravel Fundamental" />
                            <x-input-error for="title" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="category" value="{{ __('Category') }}" />
                            <x-input id="category" class="mt-2 block w-full border-gray-400 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500" type="text" name="category" :value="old('category')" required placeholder="Web Development" />
                            <x-input-error for="category" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="price" value="{{ __('Price') }}" />
                            <x-input id="price" class="mt-2 block w-full border-gray-400 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500" type="number" name="price" :value="old('price')" required min="0" step="1000" placeholder="150000" />
                            <p class="mt-1 text-xs text-gray-500">Masukkan nominal tanpa titik atau koma.</p>
                            <x-input-error for="price" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="duration" value="{{ __('Duration') }}" />
                            <x-input id="duration" class="mt-2 block w-full border-gray-400 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500" type="number" name="duration" :value="old('duration')" required min="1" placeholder="12" />
                            <p class="mt-1 text-xs text-gray-500">Durasi dalam jam belajar.</p>
                            <x-input-error for="duration" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="rating" value="{{ __('Rating') }}" />
                            <x-input id="rating" class="mt-2 block w-full border-gray-400 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500" type="number" name="rating" :value="old('rating')" required min="0" max="5" step="0.1" placeholder="4.8" />
                            <p class="mt-1 text-xs text-gray-500">Nilai antara 0 sampai 5.</p>
                            <x-input-error for="rating" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="students_count" value="{{ __('Students Count') }}" />
                            <x-input id="students_count" class="mt-2 block w-full border-gray-400 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500" type="number" name="students_count" :value="old('students_count')" required min="0" placeholder="120" />
                            <x-input-error for="students_count" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="difficulty_level" value="{{ __('Difficulty Level') }}" />
                            <select id="difficulty_level" name="difficulty_level" required class="mt-2 block w-full rounded-md border-gray-400 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Pilih tingkat kesulitan</option>
                                @foreach ([1 => '1 - Beginner', 2 => '2 - Basic', 3 => '3 - Intermediate', 4 => '4 - Advanced', 5 => '5 - Expert'] as $value => $label)
                                    <option value="{{ $value }}" @selected((string) old('difficulty_level') === (string) $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <x-input-error for="difficulty_level" class="mt-2" />
                        </div>

                        <div class="md:col-span-2">
                            <x-label for="description" value="{{ __('Description') }}" />
                            <textarea id="description" name="description" rows="6" required class="mt-2 block w-full rounded-md border-gray-400 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Tuliskan ringkasan materi, target peserta, dan hasil belajar.">{{ old('description') }}</textarea>
                            <x-input-error for="description" class="mt-2" />
                        </div>

                        <div class="md:col-span-2">
                            <x-label for="image" value="{{ __('Image') }}" />
                            <div class="mt-2 rounded-lg border border-dashed border-gray-400 bg-gray-50 p-4">
                                <input id="image" class="block w-full text-sm text-gray-700 file:mr-4 file:rounded-md file:border-0 file:bg-blue-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-blue-700" type="file" name="image" accept="image/jpeg,image/png,image/jpg" required />
                                <p class="mt-2 text-xs text-gray-500">Format JPG atau PNG, maksimal 2 MB.</p>
                            </div>
                            <x-input-error for="image" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col-reverse gap-3 border-t border-gray-200 pt-6 sm:flex-row sm:items-center sm:justify-end">
                        <a href="{{ route('admin.courses.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Batal
                        </a>
                        <x-button class="justify-center bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:ring-blue-500">
                            {{ __('Create') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
