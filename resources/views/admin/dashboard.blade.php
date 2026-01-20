<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold">Selamat Datang, Admin!</h1>
                <p>Ini adalah halaman khusus admin. User biasa tidak bisa masuk sini.</p>
            </div>
        </div>
    </div>
</x-app-layout>