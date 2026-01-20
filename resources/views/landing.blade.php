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
                <a href="#recommendation-form" class="px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:text-lg shadow-lg transform hover:scale-105 transition">
                    Cari Kursus Cocok (AI)
                </a>
                <a href="#courses" class="px-8 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 md:text-lg">
                    Lihat Semua
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
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Rekomendasi AI</h3>
                    <p class="text-gray-500 text-sm mb-4">Temukan kursus terbaik berdasarkan budget dan minat Anda dengan metode AHP.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. INTERACTIVE AI RECOMMENDATION FORM --}}
    <section id="recommendation-form" class="py-16 bg-blue-600 overflow-hidden relative">
        {{-- Background Decoration --}}
        <div class="absolute top-0 right-0 -mt-20 -mr-20 opacity-10">
            <svg class="w-96 h-96 text-white" fill="currentColor" viewBox="0 0 200 200"><path d="M44.7,-76.4C58.8,-69.2,71.8,-59.1,79.6,-45.8C87.4,-32.5,90,-16.3,88.5,-0.9C86.9,14.6,81.2,29.1,72.1,41.4C63,53.7,50.4,63.8,36.5,71.2C22.6,78.5,7.3,83.1,-7.7,81.4C-22.7,79.7,-37.4,71.6,-50.3,61.1C-63.2,50.6,-74.3,37.6,-80.7,22.7C-87.1,7.8,-88.8,-9,-84.6,-24.6C-80.4,-40.1,-70.4,-54.4,-57.1,-62C-43.8,-69.6,-27.2,-70.4,-11.2,-74.5C4.7,-78.6,20.6,-83.6,34.7,-81.4C38.6,-80.8,41.7,-78.6,44.7,-76.4Z" transform="translate(100 100)" /></svg>
        </div>

        <div class="max-w-4xl mx-auto px-4 relative z-10">
            <div class="bg-white p-8 md:p-12 rounded-3xl shadow-2xl">
                <div class="text-center mb-10">
                    <span class="bg-blue-100 text-blue-600 text-xs font-black px-4 py-1.5 rounded-full uppercase tracking-widest">AI Matching Engine</span>
                    <h2 class="text-3xl font-extrabold text-gray-900 mt-4">Apa yang Paling Penting Bagi Anda?</h2>
                    <p class="text-gray-500 mt-2">Bantu AI kami memberikan rekomendasi yang paling "Dekat" dengan keinginan Anda.</p>
                </div>
                
                <form action="{{ route('course.recommend') }}#results" method="GET" class="space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6"> {{-- Ubah jadi 3 kolom --}}
                        
                        {{-- Pilih Kategori --}}
                        <div>
                            <label class="block text-sm font-black text-gray-700 mb-2">Bidang apa yang ingin dipelajari?</label>
                            <select name="category" class="w-full border-gray-200 rounded-lg focus:ring-blue-500 shadow-sm" required>
                                <option value="">-- Pilih Kategori --</option>
                                {{-- Kita ambil unik kategori dari data kursus --}}
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Prioritas Harga --}}
                        <div>
                            <label class="block text-sm font-black text-gray-700 mb-2">Prioritas Harga Murah?</label>
                            <select name="pref_price" class="w-full border-gray-200 rounded-lg focus:ring-blue-500 shadow-sm">
                                <option value="1">Biasa Saja</option>
                                <option value="3">Cukup Penting</option>
                                <option value="5">Sangat Penting</option>
                            </select>
                        </div>

                        {{-- Prioritas Rating --}}
                        <div>
                            <label class="block text-sm font-black text-gray-700 mb-2">Prioritas Rating Tinggi?</label>
                            <select name="pref_rating" class="w-full border-gray-200 rounded-lg focus:ring-blue-500 shadow-sm">
                                <option value="1">Biasa Saja</option>
                                <option value="3">Cukup Penting</option>
                                <option value="5">Sangat Penting</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-center mt-6">
                        <button type="submit" class="bg-blue-600 text-white px-10 py-3 rounded-xl font-black hover:bg-blue-700 transition">
                            Cari di Kategori Ini →
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    {{-- 4. RESULTS / BEST MATCH SECTION --}}
    <section id="results" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(isset($bestMatch))
                {{-- Notifikasi Sukses --}}
                <div class="bg-green-100 border-l-4 border-green-500 p-4 rounded-r-xl mb-12 animate-pulse">
                    <p class="text-green-800 font-bold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                        AI Berhasil Menghitung! Berikut adalah pilihan yang paling cocok untuk kamu:
                    </p>
                </div>

                <div class="mb-16">
                    <div class="bg-white p-2 rounded-3xl shadow-2xl border-2 border-blue-500 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 bg-blue-500 text-white px-6 py-2 rounded-bl-2xl font-black text-sm uppercase tracking-tighter">
                            🔥 Skor Kecocokan Tertinggi
                        </div>
                        <div class="flex flex-col lg:flex-row gap-8 p-6 md:p-10">
                            <div class="lg:w-1/3">
                                <img src="{{ asset('storage/' . $bestMatch->image) }}" class="w-full h-64 object-cover rounded-2xl shadow-lg group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="lg:w-2/3 flex flex-col">
                                <span class="text-blue-600 font-bold uppercase tracking-widest text-sm mb-2">{{ $bestMatch->category }}</span>
                                <h3 class="text-4xl font-black text-gray-900 mb-4">{{ $bestMatch->title }}</h3>
                                <p class="text-gray-500 text-lg mb-6 leading-relaxed">{{ Str::limit($bestMatch->description, 200) }}</p>
                                
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                                    <div class="bg-gray-50 p-3 rounded-xl text-center">
                                        <p class="text-[10px] text-gray-400 uppercase font-bold">Rating</p>
                                        <p class="text-lg font-black text-yellow-500">{{ $bestMatch->rating }}/5</p>
                                    </div>
                                    <div class="bg-gray-50 p-3 rounded-xl text-center">
                                        <p class="text-[10px] text-gray-400 uppercase font-bold">Peminat</p>
                                        <p class="text-lg font-black text-blue-600">{{ $bestMatch->students_count }}</p>
                                    </div>
                                    <div class="bg-gray-50 p-3 rounded-xl text-center">
                                        <p class="text-[10px] text-gray-400 uppercase font-bold">Durasi</p>
                                        <p class="text-lg font-black text-gray-800">{{ $bestMatch->duration }} mgu</p>
                                    </div>
                                    <div class="bg-gray-50 p-3 rounded-xl text-center border-2 border-blue-200">
                                        <p class="text-[10px] text-blue-400 uppercase font-bold">Match Score</p>
                                        <p class="text-lg font-black text-blue-600">{{ round(($bestMatch->user_match_score ?? $bestMatch->ai_score) * 100) }}%</p>
                                    </div>
                                </div>

                                <div class="mt-auto flex flex-col md:flex-row items-center gap-6 pt-6 border-t border-gray-100">
                                    <div class="text-3xl font-black text-blue-600">
                                        Rp {{ number_format($bestMatch->price, 0, ',', '.') }}
                                    </div>
                                    <a href="{{ route('course.checkout', $bestMatch->id) }}" class="w-full md:w-auto px-10 py-4 bg-blue-600 text-white font-black rounded-2xl hover:bg-blue-700 transition shadow-lg text-center">
                                        Daftar Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- 5. ALL COURSES LIST --}}
            <div id="courses">
                <div class="flex justify-between items-end mb-10">
                    <div>
                        <h2 class="text-3xl font-black text-gray-900">Daftar Kursus</h2>
                        <p class="text-gray-500">Urutan berdasarkan kecocokan AI</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    @forelse($courses as $course)
                        <div class="group bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-2xl transition duration-500 relative">
                            
                            {{-- AI Match Badge --}}
                            @php $score = $course->user_match_score ?? $course->ai_score ?? 0; @endphp
                            @if($score > 0)
                                <div class="absolute top-4 right-4 z-10">
                                    <div class="bg-white/90 backdrop-blur-sm border border-blue-100 shadow-xl px-3 py-1.5 rounded-2xl flex items-center gap-2">
                                        <div class="relative flex h-2 w-2">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                                        </div>
                                        <span class="text-xs font-black text-blue-700">
                                            {{ round($score * 100) }}% MATCH
                                        </span>
                                    </div>
                                </div>
                            @endif

                            <div class="h-56 bg-gray-200 relative overflow-hidden">
                                @if($course->image)
                                    <img src="{{ asset('storage/' . $course->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                                <span class="absolute bottom-4 left-4 bg-white/20 backdrop-blur-md text-white text-[10px] font-black px-3 py-1 rounded-lg uppercase border border-white/30">
                                    {{ $course->category }}
                                </span>
                            </div>

                            <div class="p-8 flex-1 flex flex-col">
                                <h3 class="text-xl font-black text-gray-900 mb-3 group-hover:text-blue-600 transition">{{ $course->title }}</h3>
                                
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="flex items-center text-xs font-bold text-gray-400">
                                        <svg class="w-4 h-4 mr-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        {{ $course->rating }}
                                    </div>
                                    <div class="flex items-center text-xs font-bold text-gray-400">
                                        <svg class="w-4 h-4 mr-1 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        {{ $course->students_count }} Siswa
                                    </div>
                                </div>

                                <div class="mt-auto flex justify-between items-center pt-6 border-t border-gray-50">
                                    <span class="text-2xl font-black text-blue-600">Rp {{ number_format($course->price, 0, ',', '.') }}</span>
                                    <a href="{{ route('course.checkout', $course->id) }}" class="p-3 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
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
        </div>
    </section>

    {{-- 6. CTA SECTION --}}
    <section class="bg-blue-600 py-20 relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
            <h2 class="text-4xl font-black text-white sm:text-5xl mb-6">Siap Memulai Perjalanan Belajar Anda?</h2>
            <p class="text-blue-100 text-xl mb-10 opacity-90">Bergabunglah dengan ribuan peserta lain dan tingkatkan keterampilan Anda hari ini.</p>
            <a href="{{ route('register') }}" class="inline-block px-12 py-5 bg-white text-blue-600 font-black rounded-2xl shadow-2xl hover:bg-gray-100 transition transform hover:-translate-y-2">
                Daftar Akun Gratis Sekarang
            </a>
        </div>
    </section>

</x-layouts.landing>