<nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            {{-- Logo --}}
            <div class="flex-shrink-0 flex items-center gap-2">
                <a href="{{ url('/') }}" class="text-2xl font-bold text-blue-600">
                    SkillConnect<span class="text-gray-800">.id</span>
                </a>
            </div>

            {{-- Desktop Menu --}}
            <div class="hidden md:flex space-x-8 items-center">
                <a href="{{ url('/') }}" class="text-gray-600 hover:text-blue-600 font-medium">Beranda</a>
                <a href="#courses" class="text-gray-600 hover:text-blue-600 font-medium">Kursus</a>
                <a href="#features" class="text-gray-600 hover:text-blue-600 font-medium">Tentang</a>
                <a href="#contact" class="text-gray-600 hover:text-blue-600 font-medium">Kontak</a>
            </div>

            {{-- Auth Buttons (Login/Register) --}}
            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-900 hover:text-blue-600">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">Daftar</a>
                        @endif
                    @endauth
                @else
                    {{-- Tampilan Default jika route login belum dibuat --}}
                    <a href="#" class="text-sm font-medium text-gray-600 hover:text-blue-600">Masuk</a>
                    <a href="#" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">Daftar</a>
                @endif
            </div>
        </div>
    </div>
</nav>