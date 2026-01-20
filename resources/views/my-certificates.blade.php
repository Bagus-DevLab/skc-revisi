<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sertifikat Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Info Banner --}}
            <div class="bg-blue-50 border-l-4 border-blue-600 p-4 mb-8 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Selamat! Anda telah mengumpulkan <strong>2 Sertifikat Kompetensi</strong>. Tingkatkan terus skill Anda!
                        </p>
                    </div>
                </div>
            </div>

            {{-- Grid Sertifikat --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                {{-- CERTIFICATE CARD 1 --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition duration-300">
                    {{-- Preview Area --}}
                    <div class="relative bg-gray-100 h-64 flex items-center justify-center border-b border-gray-100 group">
                        {{-- Mockup Image Sertifikat --}}
                        <img src="https://img.freepik.com/free-vector/modern-certificate-appreciation-template-golden-shapes_1017-38367.jpg" alt="Sertifikat Flutter" class="h-full object-contain p-4 opacity-90 group-hover:opacity-100 transition">
                        
                        {{-- Overlay Action (Muncul saat hover) --}}
                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 gap-4">
                            <button class="bg-white text-gray-800 rounded-full p-3 hover:bg-gray-100 shadow-lg" title="Lihat Detail">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                            <button class="bg-blue-600 text-white rounded-full p-3 hover:bg-blue-700 shadow-lg" title="Unduh PDF">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            </button>
                        </div>
                    </div>

                    {{-- Detail Area --}}
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Mobile App Development</h3>
                                <p class="text-gray-500 text-sm mt-1">Instruktur: Sandhika Galih</p>
                            </div>
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/LinkedIn_logo_initials.png/600px-LinkedIn_logo_initials.png" class="w-8 h-8 cursor-pointer hover:opacity-80" title="Tambahkan ke LinkedIn">
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-sm text-gray-600 mb-6 bg-gray-50 p-3 rounded-lg">
                            <div>
                                <span class="block text-xs text-gray-400 uppercase tracking-wider">Tanggal Selesai</span>
                                <span class="font-semibold text-gray-800">12 Jan 2026</span>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-400 uppercase tracking-wider">ID Sertifikat</span>
                                <span class="font-mono font-semibold text-gray-800">SC-2026-X899</span>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button class="flex-1 bg-blue-600 text-white text-sm font-bold py-2.5 px-4 rounded-lg hover:bg-blue-700 transition flex justify-center items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Unduh PDF
                            </button>
                            <button class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-sm font-semibold">
                                Verifikasi
                            </button>
                        </div>
                    </div>
                </div>

                {{-- CERTIFICATE CARD 2 --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition duration-300">
                    <div class="relative bg-gray-100 h-64 flex items-center justify-center border-b border-gray-100 group">
                         <img src="https://img.freepik.com/free-vector/modern-certificate-appreciation-template-golden-shapes_1017-38367.jpg" alt="Sertifikat UI UX" class="h-full object-contain p-4 opacity-90 group-hover:opacity-100 transition grayscale">
                        
                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 gap-4">
                            <button class="bg-white text-gray-800 rounded-full p-3 hover:bg-gray-100 shadow-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                            <button class="bg-blue-600 text-white rounded-full p-3 hover:bg-blue-700 shadow-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">UI/UX Design Masterclass</h3>
                                <p class="text-gray-500 text-sm mt-1">Instruktur: Budi Tanrim</p>
                            </div>
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/LinkedIn_logo_initials.png/600px-LinkedIn_logo_initials.png" class="w-8 h-8 cursor-pointer hover:opacity-80" title="Tambahkan ke LinkedIn">
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-sm text-gray-600 mb-6 bg-gray-50 p-3 rounded-lg">
                            <div>
                                <span class="block text-xs text-gray-400 uppercase tracking-wider">Tanggal Selesai</span>
                                <span class="font-semibold text-gray-800">20 Des 2025</span>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-400 uppercase tracking-wider">ID Sertifikat</span>
                                <span class="font-mono font-semibold text-gray-800">SC-2025-A112</span>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button class="flex-1 bg-blue-600 text-white text-sm font-bold py-2.5 px-4 rounded-lg hover:bg-blue-700 transition flex justify-center items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Unduh PDF
                            </button>
                            <button class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-sm font-semibold">
                                Verifikasi
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Empty State (Contoh jika belum ada sertifikat) --}}
            {{-- 
            <div class="text-center py-16">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada sertifikat</h3>
                <p class="mt-1 text-sm text-gray-500">Selesaikan kursus pertama Anda untuk mendapatkan sertifikat.</p>
                <div class="mt-6">
                    <a href="{{ route('my-courses') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Mulai Belajar
                    </a>
                </div>
            </div> 
            --}}

        </div>
    </div>
</x-app-layout>