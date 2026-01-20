<x-layouts.landing>
    
    {{-- 1. HERO SECTION --}}
    <section class="bg-white pt-16 pb-20 lg:pt-24 lg:pb-28">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl max-w-4xl mx-auto mb-6">
                Belajar, Tumbuh, dan <span class="text-blue-600">Tersertifikasi</span> untuk Masa Depan
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500 mb-10">
                Platform pelatihan kerja online dengan sertifikasi resmi yang diakui industri. Fleksibel, terjangkau, dan praktis.
            </p>
            <div class="flex justify-center gap-4 mb-16">
                <a href="#courses" class="px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:text-lg">
                    Jelajahi Kursus
                </a>
                <a href="#features" class="px-8 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 md:text-lg">
                    Pelajari Lebih Lanjut
                </a>
            </div>

            {{-- Stats Area (Full 4 Kolom) --}}
            <div class="grid grid-cols-2 gap-8 md:grid-cols-4 border-t border-gray-200 pt-10">
                <div>
                    <div class="text-3xl font-bold text-blue-600">10,000+</div>
                    <div class="text-sm text-gray-500 font-medium uppercase tracking-wide">Peserta Aktif</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-blue-600">50+</div>
                    <div class="text-sm text-gray-500 font-medium uppercase tracking-wide">Kursus Tersedia</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-blue-600">95%</div>
                    <div class="text-sm text-gray-500 font-medium uppercase tracking-wide">Tingkat Kepuasan</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-blue-600">100%</div>
                    <div class="text-sm text-gray-500 font-medium uppercase tracking-wide">Sertifikat Resmi</div>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. FEATURES SECTION (Full 6 Fitur) --}}
    <section id="features" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">Fitur Unggulan</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Mengapa Memilih SkillConnect.id?
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Platform terlengkap untuk pengembangan keterampilan profesional Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Feature 1 --}}
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Belajar Fleksibel</h3>
                    <p class="text-gray-500 text-sm mb-4">Akses kursus 24/7 kapan saja, di mana saja sesuai jadwal Anda.</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Akses Selamanya</span>
                </div>

                {{-- Feature 2 --}}
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Sertifikat Resmi</h3>
                    <p class="text-gray-500 text-sm mb-4">Dapatkan sertifikat digital yang diakui industri dan dapat diverifikasi.</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Terverifikasi</span>
                </div>

                {{-- Feature 3 --}}
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Harga Terjangkau</h3>
                    <p class="text-gray-500 text-sm mb-4">Sistem pembayaran fleksibel dengan cicilan atau pay-after-job.</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Cicilan 0%</span>
                </div>

                {{-- Feature 4 --}}
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Keterampilan Praktis</h3>
                    <p class="text-gray-500 text-sm mb-4">Fokus pada skill yang langsung bisa diterapkan dengan studi kasus nyata.</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">Job-Ready</span>
                </div>

                {{-- Feature 5 --}}
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Mentoring Karier</h3>
                    <p class="text-gray-500 text-sm mb-4">Bimbingan 1-on-1 dari mentor profesional untuk persiapan kerja.</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">Expert Mentors</span>
                </div>

                {{-- Feature 6 --}}
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Komunitas Aktif</h3>
                    <p class="text-gray-500 text-sm mb-4">Bergabung dengan 10,000+ peserta lain, berbagi pengalaman, dan networking.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. COURSES SECTION (Full 3 Kartu) --}}
    <section id="courses" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Kursus Populer</h2>
                    <p class="mt-2 text-gray-500">Pilihan kursus terbaik untuk meningkatkan keterampilan profesional Anda</p>
                </div>
                <a href="#" class="hidden md:inline-flex items-center text-blue-600 font-semibold hover:text-blue-700">
                    Lihat Semua Kursus <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Course Card 1 --}}
                <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden flex flex-col hover:shadow-lg transition">
                    <div class="h-48 bg-gray-200 relative">
                        <img src="https://images.unsplash.com/photo-1526498460520-4c246339dccb?auto=format&fit=crop&q=80&w=800" alt="Mobile App" class="w-full h-full object-cover">
                        <span class="absolute top-4 left-4 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full">Programming</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Mobile App Development - Beginner</h3>
                        <div class="flex items-center text-sm text-gray-500 gap-4 mb-4">
                            <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 10 Minggu</span>
                            <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> 120 Peserta</span>
                        </div>
                        <div class="mt-auto flex justify-between items-center pt-4 border-t border-gray-100">
                            <span class="text-xl font-bold text-blue-600">Rp 750.000</span>
                        </div>
                    </div>
                </div>

                {{-- Course Card 2 --}}
                <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden flex flex-col hover:shadow-lg transition">
                    <div class="h-48 bg-gray-200 relative">
                        <img src="https://images.unsplash.com/photo-1551650975-87deedd944c3?auto=format&fit=crop&q=80&w=800" alt="Mobile App Advanced" class="w-full h-full object-cover">
                        <span class="absolute top-4 left-4 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full">Programming</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Mobile App Development - Advanced</h3>
                        <div class="flex items-center text-sm text-gray-500 gap-4 mb-4">
                            <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 10 Minggu</span>
                            <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> 85 Peserta</span>
                        </div>
                        <div class="mt-auto flex justify-between items-center pt-4 border-t border-gray-100">
                            <span class="text-xl font-bold text-blue-600">Rp 850.000</span>
                        </div>
                    </div>
                </div>

                {{-- Course Card 3 --}}
                <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden flex flex-col hover:shadow-lg transition">
                    <div class="h-48 bg-gray-200 relative">
                        <img src="https://images.unsplash.com/photo-1547658719-da2b51169166?auto=format&fit=crop&q=80&w=800" alt="Fullstack" class="w-full h-full object-cover">
                        <span class="absolute top-4 left-4 bg-purple-600 text-white text-xs font-bold px-3 py-1 rounded-full">Web Dev</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Fullstack Web Development</h3>
                        <div class="flex items-center text-sm text-gray-500 gap-4 mb-4">
                            <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 12 Minggu</span>
                            <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> 200+ Peserta</span>
                        </div>
                        <div class="mt-auto flex justify-between items-center pt-4 border-t border-gray-100">
                            <span class="text-xl font-bold text-blue-600">Rp 750.000</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 text-center md:hidden">
                <a href="#" class="inline-block px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Lihat Semua Kursus
                </a>
            </div>
        </div>
    </section>

    {{-- 4. CTA SECTION --}}
    <section class="bg-blue-600 py-16">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white sm:text-4xl mb-6">Siap Memulai Perjalanan Belajar Anda?</h2>
            <p class="text-blue-100 text-lg mb-8">Bergabunglah dengan ribuan peserta lain dan tingkatkan keterampilan Anda hari ini.</p>
            <a href="#" class="inline-block px-8 py-4 bg-white text-blue-600 font-bold rounded-lg shadow-lg hover:bg-gray-100 transition transform hover:-translate-y-1">
                Lihat Kursus Saya
            </a>
        </div>
    </section>

</x-layouts.landing>