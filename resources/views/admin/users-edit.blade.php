<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User: ') }} {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <x-label for="name" value="Nama Lengkap" />
                        <x-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ $user->name }}" required />
                    </div>

                    <div class="mb-4">
                        <x-label for="email" value="Alamat Email" />
                        <x-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ $user->email }}" required />
                    </div>

                    <div class="mb-6">
                        <x-label for="role" value="Role Akses" />
                        <select id="role" name="role" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User (Pelajar)</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin (Pengelola)</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 hover:underline">Kembali</a>
                        <x-button class="bg-indigo-600 hover:bg-indigo-700">
                            Simpan Perubahan
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>