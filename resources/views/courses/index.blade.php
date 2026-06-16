<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Semua Course') }}
            </h2>
            <p class="text-sm text-gray-500">Jelajahi katalog kursus dan lanjutkan kursus yang sudah Anda miliki.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-8">
                <form method="GET" action="{{ route('courses.index') }}" class="grid grid-cols-1 md:grid-cols-[1fr_220px_auto] gap-3">
                    <div>
                        <label for="search" class="sr-only">Cari course</label>
                        <input
                            id="search"
                            name="search"
                            value="{{ request('search') }}"
                            type="search"
                            placeholder="Cari judul atau deskripsi course..."
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <div>
                        <label for="category" class="sr-only">Kategori</label>
                        <select id="category" name="category" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-bold text-white hover:bg-blue-700">
                            Filter
                        </button>
                        @if(request()->hasAny(['search', 'category']))
                            <a href="{{ route('courses.index') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-bold text-gray-600 hover:bg-gray-50">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($courses as $course)
                    @php
                        $owned = in_array($course->id, $enrolledCourseIds, true);
                        $courseImage = $course->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($course->image)
                            ? asset('storage/'.$course->image)
                            : null;
                    @endphp

                    <article class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-lg transition">
                        <div class="h-44 relative overflow-hidden bg-slate-100">
                            @if($courseImage)
                                <img src="{{ $courseImage }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-600 to-slate-800 text-white flex items-center justify-center p-6 text-center">
                                    <span class="text-lg font-black">{{ $course->title }}</span>
                                </div>
                            @endif

                            <div class="absolute top-3 left-3">
                                <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-blue-700">
                                    {{ $course->category }}
                                </span>
                            </div>

                            @if($owned)
                                <div class="absolute top-3 right-3">
                                    <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow">
                                        Dimiliki
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="text-lg font-black text-gray-900">{{ $course->title }}</h3>
                            <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $course->description }}</p>

                            <div class="grid grid-cols-3 gap-2 my-5 text-center">
                                <div class="bg-gray-50 rounded-lg p-2">
                                    <p class="text-[10px] uppercase font-bold text-gray-400">Rating</p>
                                    <p class="font-black text-yellow-500">{{ $course->rating }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-2">
                                    <p class="text-[10px] uppercase font-bold text-gray-400">Siswa</p>
                                    <p class="font-black text-blue-600">{{ $course->students_count }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-2">
                                    <p class="text-[10px] uppercase font-bold text-gray-400">Durasi</p>
                                    <p class="font-black text-gray-800">{{ $course->duration }}</p>
                                </div>
                            </div>

                            <div class="mt-auto flex items-center justify-between gap-4 pt-4 border-t border-gray-100">
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase">Harga</p>
                                    <p class="text-lg font-black text-blue-600">Rp {{ number_format($course->price, 0, ',', '.') }}</p>
                                </div>

                                @if($owned)
                                    <a href="{{ route('course.learn', $course->id) }}" class="rounded-lg bg-green-600 px-4 py-2 text-sm font-bold text-white hover:bg-green-700">
                                        Lanjutkan
                                    </a>
                                @else
                                    <a href="{{ route('course.checkout', $course->id) }}" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-bold text-white hover:bg-blue-700">
                                        Beli Course
                                    </a>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full bg-white rounded-xl p-12 border-2 border-dashed text-center">
                        <p class="font-bold text-gray-700">Course tidak ditemukan</p>
                        <p class="text-sm text-gray-500 mt-1">Coba ubah kata kunci atau kategori pencarian.</p>
                    </div>
                @endforelse
            </div>

            @if($courses->hasPages())
                <div class="mt-8">
                    {{ $courses->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
