<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- 1. STATS ROW (Ringkasan dari View Lain) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Kursus Aktif</p>
                        <p class="text-2xl font-bold text-gray-800">2</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Sertifikat</p>
                        <p class="text-2xl font-bold text-gray-800">2</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Investasi</p>
                        <p class="text-xl font-bold text-gray-800">Rp 1.5jt</p>
                    </div>
                </div>
            </div>

            {{-- 2. MAIN CONTENT GRID --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- LEFT COLUMN: Priority Learning (Span 2) --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- Banner: Lanjut Belajar Terakhir --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                            <h3 class="font-bold text-gray-800">Lanjutkan Pembelajaran</h3>
                            <a href="{{ route('my-courses') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Lihat Semua</a>
                        </div>
                        <div class="p-6 flex flex-col sm:flex-row gap-6">
                            <img src="https://images.unsplash.com/photo-1526498460520-4c246339dccb?auto=format&fit=crop&q=80&w=400" class="w-full sm:w-48 h-32 object-cover rounded-lg" alt="Course">
                            <div class="flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-0.5 rounded">Programming</span>
                                        <span class="text-xs text-gray-500">Terakhir akses: 2 jam lalu</span>
                                    </div>
                                    <h4 class="text-xl font-bold text-gray-900">Mobile App Development</h4>
                                    <p class="text-gray-500 text-sm mt-1">Modul: State Management dengan Provider</p>
                                </div>
                                <div class="mt-4">
                                    <div class="flex justify-between text-xs text-gray-600 mb-1">
                                        <span>Progress</span>
                                        <span class="font-bold">45%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: 45%"></div>
                                    </div>
                                    <div class="mt-4">
                                        <button class="bg-blue-600 text-white text-sm font-bold py-2 px-6 rounded-lg hover:bg-blue-700 transition">
                                            Lanjut Belajar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section: Rekomendasi / Info Lain (Opsional) --}}
                    <div class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl shadow-lg p-6 text-white relative overflow-hidden">
                        <div class="relative z-10">
                            <h3 class="text-xl font-bold mb-2">Ingin sertifikat baru?</h3>
                            <p class="text-blue-100 mb-4 text-sm max-w-md">Selesaikan kursus "Fullstack Web Development" Anda yang masih 10% untuk mendapatkan sertifikat keahlian.</p>
                            <button class="bg-white text-blue-600 text-sm font-bold py-2 px-4 rounded shadow hover:bg-gray-50 transition">
                                Cek Kursus
                            </button>
                        </div>
                        {{-- Decor --}}
                        <div class="absolute right-0 bottom-0 opacity-20 transform translate-x-10 translate-y-10">
                            <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.298-2.26a2.427 2.427 0 01.386-.798 1 1 0 00-1.448-1.353 4.426 4.426 0 00-.416.71c-.13.3-.23.63-.306.963a6.45 6.45 0 00.12 2.668 4.634 4.634 0 001.372 2.43 4.63 4.63 0 001.69 1.05l.385.115c.16.046.326.082.493.11 1.026.173 1.94.49 2.715 1.058.756.555 1.254 1.34 1.285 2.378a1 1 0 001.996.09c.045-1.498-.674-2.85-1.92-3.765-.96-.704-2.095-1.07-3.276-1.27l-.427-.067a2.636 2.636 0 01-1.087-.414 2.63 2.63 0 01-1.03-1.637 4.453 4.453 0 01-.065-1.554 4.43 4.43 0 01.168-.788c.05-.157.112-.307.185-.448.275-1.18.59-2.28.946-3.142.18-.432.38-.834.6-1.198.216-.358.465-.67.753-.902z" clip-rule="evenodd" /></svg>
                        </div>
                    </div>

                </div>

                {{-- RIGHT COLUMN: Notes (Span 1) --}}
                <div class="lg:col-span-1">
                    {{-- Quick Note Widget --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-yellow-50 flex justify-between items-center">
                            <h3 class="font-bold text-yellow-800 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Catatan Cepat
                            </h3>
                        </div>
                        
                        {{-- Memanggil Component Livewire Note Manager --}}
                        <div class="p-0">
                           @livewire('note-manager')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>