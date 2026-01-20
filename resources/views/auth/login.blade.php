<x-guest-layout>
    <div class="min-h-screen flex">
        
        {{-- BAGIAN KIRI: BRANDING & IMAGE (Hanya muncul di Desktop) --}}
        <div class="hidden lg:flex w-1/2 bg-blue-600 items-center justify-center relative overflow-hidden">
            {{-- Background Pattern Sederhana --}}
            <div class="absolute inset-0 opacity-10">
                <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
                </svg>
            </div>
            
            <div class="relative z-10 px-12 text-center text-white">
                <h2 class="text-4xl font-bold mb-4">Mulai Perjalanan Belajar Anda</h2>
                <p class="text-blue-100 text-lg">
                    Bergabunglah dengan 10,000+ peserta lainnya dan tingkatkan karier Anda bersama SkillConnect.
                </p>
                {{-- Ilustrasi/Icon Besar (Opsional) --}}
                <div class="mt-8 flex justify-center">
                   <svg class="w-32 h-32 text-blue-300 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
            </div>
        </div>

        {{-- BAGIAN KANAN: FORM LOGIN --}}
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center bg-white px-8 md:px-16 py-12">
            <div class="w-full max-w-md">
                
                {{-- Logo & Heading --}}
                <div class="mb-8 text-center lg:text-left">
                    <a href="/" class="text-2xl font-bold text-blue-600 inline-flex items-center gap-2 mb-2">
                        SkillConnect<span class="text-gray-800">.id</span>
                    </a>
                    <h2 class="text-2xl font-bold text-gray-900 mt-4">Selamat Datang Kembali! 👋</h2>
                    <p class="text-sm text-gray-500 mt-2">Silakan masuk untuk melanjutkan belajar.</p>
                </div>

                <x-validation-errors class="mb-4" />

                @session('status')
                    <div class="mb-4 font-medium text-sm text-green-600 p-3 bg-green-50 rounded-lg border border-green-200">
                        {{ $value }}
                    </div>
                @endsession

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-label for="email" value="{{ __('Email') }}" class="text-gray-700 font-medium" />
                        <x-input id="email" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm py-3" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Masukkan email Anda" />
                    </div>

                    <div>
                        <div class="flex justify-between items-center">
                            <x-label for="password" value="{{ __('Password') }}" class="text-gray-700 font-medium" />
                            @if (Route::has('password.request'))
                                <a class="text-sm text-blue-600 hover:text-blue-800 font-medium" href="{{ route('password.request') }}">
                                    {{ __('Lupa password?') }}
                                </a>
                            @endif
                        </div>
                        <x-input id="password" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm py-3" type="password" name="password" required autocomplete="current-password" placeholder="********" />
                    </div>

                    <div class="block">
                        <label for="remember_me" class="flex items-center cursor-pointer">
                            <x-checkbox id="remember_me" name="remember" class="text-blue-600 focus:ring-blue-500 rounded border-gray-300" />
                            <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
                        </label>
                    </div>

                    <div>
                        <x-button class="w-full justify-center py-3 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 focus:ring-blue-500 text-base font-bold rounded-lg transition duration-150 ease-in-out shadow-lg hover:shadow-xl">
                            {{ __('Masuk Sekarang') }}
                        </x-button>
                    </div>
                </form>

                {{-- Link Daftar --}}
                <div class="mt-8 text-center text-sm text-gray-500">
                    Belum memiliki akun? 
                    <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-800 hover:underline">
                        Daftar Gratis
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>