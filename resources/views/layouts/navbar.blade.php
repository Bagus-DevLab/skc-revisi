<div class="flex items-center gap-4">
    @if (Route::has('login'))
        @auth
            {{-- Jika sudah login, cek role --}}
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-red-600 hover:text-red-800 border border-red-200 bg-red-50 px-3 py-2 rounded-lg">
                    Admin Panel
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 border border-blue-200 bg-blue-50 px-3 py-2 rounded-lg">
                    Dashboard Saya
                </a>
            @endif

            {{-- Tombol Logout (Opsional ditaruh di navbar depan) --}}
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-sm text-gray-500 hover:text-gray-900 ml-2">
                    Keluar
                </button>
            </form>

        @else
            {{-- Jika belum login --}}
            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600">Masuk</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">Daftar</a>
            @endif
        @endauth
    @endif
</div>