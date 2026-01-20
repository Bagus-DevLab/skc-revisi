<x-guest-layout>
    <div class="min-h-screen flex">
        
        {{-- BAGIAN KIRI: BRANDING (Hanya muncul di Desktop) --}}
        <div class="hidden lg:flex w-1/2 bg-blue-600 items-center justify-center relative overflow-hidden">
            {{-- Background Pattern --}}
            <div class="absolute inset-0 opacity-10">
                <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 0 C 50 100 80 100 100 0 Z" fill="white"></path>
                </svg>
            </div>
            
            <div class="relative z-10 px-12 text-center text-white">
                <h2 class="text-4xl font-bold mb-4">Investasi Terbaik Adalah Leher ke Atas</h2>
                <p class="text-blue-100 text-lg">
                    Buat akun sekarang dan dapatkan akses seumur hidup ke materi pembelajaran premium.
                </p>
                {{-- Ilustrasi Icon --}}
                <div class="mt-8 flex justify-center">
                    <svg class="w-32 h-32 text-blue-300 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
            </div>
        </div>

        {{-- BAGIAN KANAN: FORM REGISTER --}}
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center bg-white px-8 md:px-16 py-12">
            <div class="w-full max-w-md">
                
                {{-- Logo & Heading --}}
                <div class="mb-8 text-center lg:text-left">
                    <a href="/" class="text-2xl font-bold text-blue-600 inline-flex items-center gap-2 mb-2">
                        SkillConnect<span class="text-gray-800">.id</span>
                    </a>
                    <h2 class="text-2xl font-bold text-gray-900 mt-4">Buat Akun Baru 🚀</h2>
                    <p class="text-sm text-gray-500 mt-2">Lengkapi data diri Anda untuk mulai belajar.</p>
                </div>

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-label for="name" value="{{ __('Nama Lengkap') }}" class="text-gray-700 font-medium" />
                        <x-input id="name" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm py-3" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
                    </div>

                    <div>
                        <x-label for="email" value="{{ __('Email Address') }}" class="text-gray-700 font-medium" />
                        <x-input id="email" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm py-3" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
                    </div>

                    <div>
                        <x-label for="password" value="{{ __('Password') }}" class="text-gray-700 font-medium" />
                        <x-input id="password" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm py-3" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
                    </div>

                    <div>
                        <x-label for="password_confirmation" value="{{ __('Konfirmasi Password') }}" class="text-gray-700 font-medium" />
                        <x-input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm py-3" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" />
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="block">
                            <x-label for="terms">
                                <div class="flex items-center">
                                    <x-checkbox name="terms" id="terms" required class="text-blue-600 focus:ring-blue-500 rounded border-gray-300" />
                                    <div class="ms-2 text-sm text-gray-600">
                                        {!! __('Saya setuju dengan :terms_of_service dan :privacy_policy', [
                                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-blue-600 hover:text-blue-800 font-bold">'.__('Syarat Layanan').'</a>',
                                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-blue-600 hover:text-blue-800 font-bold">'.__('Kebijakan Privasi').'</a>',
                                        ]) !!}
                                    </div>
                                </div>
                            </x-label>
                        </div>
                    @endif

                    <div class="pt-2">
                        <x-button class="w-full justify-center py-3 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 focus:ring-blue-500 text-base font-bold rounded-lg transition duration-150 ease-in-out shadow-lg hover:shadow-xl">
                            {{ __('Daftar Sekarang') }}
                        </x-button>
                    </div>
                </form>

                {{-- Link Login --}}
                <div class="mt-8 text-center text-sm text-gray-500">
                    Sudah memiliki akun? 
                    <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-800 hover:underline">
                        Masuk di sini
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>