<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kursus Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Statistik Ringkas (Opsional) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm font-medium">Total Kursus</div>
                    <div class="text-2xl font-bold text-gray-800">3 Kursus</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-gray-500 text-sm font-medium">Sedang Dipelajari</div>
                    <div class="text-2xl font-bold text-gray-800">2 Kursus</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm font-medium">Selesai</div>
                    <div class="text-2xl font-bold text-gray-800">1 Kursus</div>
                </div>
            </div>

            {{-- Grid Daftar Kursus --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- CARD 1: Kursus Sedang Berjalan --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-md transition">
                    <div class="h-40 bg-gray-200 relative">
                        <img src="https://images.unsplash.com/photo-1526498460520-4c246339dccb?auto=format&fit=crop&q=80&w=800" alt="Mobile App" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 hover:opacity-100 transition duration-300">
                            <span class="text-white font-semibold border border-white px-4 py-2 rounded">Lanjut Belajar</span>
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="flex justify-between items-start mb-2">
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">Programming</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Mobile App Development</h3>
                        <p class="text-gray-500 text-sm mb-4 line-clamp-2">Pelajari cara membuat aplikasi Android dan iOS menggunakan Flutter.</p>
                        
                        <div class="mt-auto">
                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                <span>Progress</span>
                                <span class="font-bold">45%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 45%"></div>
                            </div>
                            <button class="w-full bg-blue-600 text-white text-sm font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                                Lanjutkan Belajar
                            </button>
                        </div>
                    </div>
                </div>

                {{-- CARD 2: Kursus Baru Mulai --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-md transition">
                    <div class="h-40 bg-gray-200 relative">
                        <img src="https://images.unsplash.com/photo-1547658719-da2b51169166?auto=format&fit=crop&q=80&w=800" alt="Web Dev" class="w-full h-full object-cover">
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="flex justify-between items-start mb-2">
                            <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-0.5 rounded">Web Dev</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Fullstack Web Development</h3>
                        <p class="text-gray-500 text-sm mb-4 line-clamp-2">Membangun website modern dengan Laravel dan React JS.</p>
                        
                        <div class="mt-auto">
                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                <span>Progress</span>
                                <span class="font-bold">10%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                                <div class="bg-purple-600 h-2.5 rounded-full" style="width: 10%"></div>
                            </div>
                            <button class="w-full bg-blue-600 text-white text-sm font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                                Mulai Belajar
                            </button>
                        </div>
                    </div>
                </div>

                {{-- CARD 3: Kursus Selesai --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-md transition opacity-90">
                    <div class="h-40 bg-gray-200 relative grayscale">
                        <img src="https://images.unsplash.com/photo-1561070791-2526d30994b5?auto=format&fit=crop&q=80&w=800" alt="UI UX" class="w-full h-full object-cover">
                        <div class="absolute top-2 right-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow">
                            Selesai
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="flex justify-between items-start mb-2">
                            <span class="bg-pink-100 text-pink-800 text-xs font-semibold px-2.5 py-0.5 rounded">Design</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">UI/UX Design Masterclass</h3>
                        <p class="text-gray-500 text-sm mb-4 line-clamp-2">Prinsip desain antarmuka yang ramah pengguna.</p>
                        
                        <div class="mt-auto">
                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                <span>Progress</span>
                                <span class="font-bold text-green-600">100%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                                <div class="bg-green-500 h-2.5 rounded-full" style="width: 100%"></div>
                            </div>
                            <div class="flex gap-2">
                                <button class="flex-1 bg-gray-100 text-gray-700 text-sm font-bold py-2 px-4 rounded-lg hover:bg-gray-200 transition">
                                    Review
                                </button>
                                <button class="flex-1 bg-green-600 text-white text-sm font-bold py-2 px-4 rounded-lg hover:bg-green-700 transition flex justify-center items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Sertifikat
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>