<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Utama') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- 1. STATS ROW (Data Real) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Kursus Aktif</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $activeCoursesCount }}</p>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Sertifikat Selesai</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $finishedCoursesCount }}</p>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Investasi</p>
                        <p class="text-xl font-bold text-gray-800">Rp {{ number_format($totalInvestment, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- 2. DYNAMIC BANNER --}}
                    @if($lastCourse)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                                <h3 class="font-bold text-gray-800 text-sm">LANJUTKAN BELAJAR</h3>
                                <a href="{{ route('my-courses') }}" class="text-xs text-blue-600 font-bold hover:underline">LIHAT SEMUA</a>
                            </div>
                            <div class="p-6 flex flex-col md:flex-row gap-6">
                                <img src="{{ asset('storage/' . $lastCourse->image) }}" class="w-full md:w-40 h-28 object-cover rounded-lg shadow-sm" alt="Course Image">
                                <div class="flex-1 flex flex-col justify-between">
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-900">{{ $lastCourse->title }}</h4>
                                        <p class="text-xs text-gray-500 mt-1 uppercase">{{ $lastCourse->category }}</p>
                                    </div>
                                    <div class="mt-4">
                                        <div class="flex justify-between text-[10px] text-gray-600 mb-1 font-bold">
                                            <span>PROGRESS BELAJAR</span>
                                            <span>{{ $lastCourse->pivot->progress }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-100 rounded-full h-1.5">
                                            <div class="bg-blue-600 h-1.5 rounded-full transition-all duration-500" style="width: {{ $lastCourse->pivot->progress }}%"></div>
                                        </div>
                                        <a href="{{ route('course.learn', $lastCourse->id) }}" 
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                                                LANJUTKAN
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- Jika user belum punya kursus sama sekali --}}
                        <div class="bg-white rounded-xl shadow-sm border-2 border-dashed border-gray-200 p-12 text-center text-gray-500 italic">
                            <p>Anda belum terdaftar di kursus manapun.</p>
                            <a href="/" class="mt-4 inline-block text-blue-600 font-bold hover:underline">Cari Kursus Sekarang &rarr;</a>
                        </div>
                    @endif

                </div>

                {{-- SIDEBAR: NOTES --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-yellow-50 flex items-center gap-2">
                            <svg class="w-5 h-5 text-yellow-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            <h3 class="font-bold text-yellow-800 text-sm">CATATAN PRIBADI</h3>
                        </div>
                        @livewire('note-manager')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>