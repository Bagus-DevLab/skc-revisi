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

            {{-- Stats Area --}}
            <div class="grid grid-cols-2 gap-8 md:grid-cols-4 border-t border-gray-200 pt-10">
                <div>
                    <div class="text-3xl font-bold text-blue-600">10,000+</div>
                    <div class="text-sm text-gray-500 font-medium uppercase tracking-wide">Peserta Aktif</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-blue-600">{{ $courses->count() }}+</div>
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

    {{-- 2. FEATURES SECTION --}}
    <section id="features" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">Fitur Unggulan</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Mengapa Memilih SkillConnect.id?
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Belajar Fleksibel</h3>
                    <p class="text-gray-500 text-sm mb-4">Akses kursus 24/7 kapan saja, di mana saja sesuai jadwal Anda.</p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Sertifikat Resmi</h3>
                    <p class="text-gray-500 text-sm mb-4">Dapatkan sertifikat digital yang diakui industri dan dapat diverifikasi.</p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Harga Terjangkau</h3>
                    <p class="text-gray-500 text-sm mb-4">Sistem pembayaran fleksibel dengan sekali bayar akses selamanya.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. COURSES SECTION (Data Real dari Admin) --}}
    <section id="courses" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Kursus Tersedia</h2>
                <p class="mt-2 text-gray-500">Pilih kursus terbaik untuk meningkatkan keterampilan profesional Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($courses as $course)
                    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden flex flex-col hover:shadow-lg transition">
                        <div class="h-48 bg-gray-200 relative">
                            @if($course->image)
                                <img src="{{ asset('storage/' . $course->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                            @endif
                            <span class="absolute top-4 left-4 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase">{{ $course->category }}</span>
                        </div>
                        <div class="p-6 flex-1 flex flex-col">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $course->title }}</h3>
                            <div class="flex items-center text-sm text-gray-500 gap-4 mb-4">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 
                                    {{ $course->duration }} Minggu
                                </span>
                            </div>
                            <div class="mt-auto flex justify-between items-center pt-4 border-t border-gray-100">
                                <span class="text-xl font-bold text-blue-600">Rp {{ number_format($course->price, 0, ',', '.') }}</span>
                                <a href="{{ route('course.checkout', $course->id) }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition">
                                    Daftar Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20 text-gray-400 italic">
                        Belum ada kursus yang tersedia saat ini.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- 4. CTA SECTION --}}
    <section class="bg-blue-600 py-16">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white sm:text-4xl mb-6">Siap Memulai Perjalanan Belajar Anda?</h2>
            <p class="text-blue-100 text-lg mb-8">Bergabunglah dengan ribuan peserta lain dan tingkatkan keterampilan Anda hari ini.</p>
            <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-white text-blue-600 font-bold rounded-lg shadow-lg hover:bg-gray-100 transition transform hover:-translate-y-1">
                Daftar Akun Gratis
            </a>
        </div>
    </section>

</x-layouts.landing>