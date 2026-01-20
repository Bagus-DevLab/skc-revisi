<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full border border-red-200 uppercase tracking-wider">
                Administrator Mode
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 1. QUICK STATS (Real Data) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 bg-blue-100 text-blue-600 rounded-lg mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total User</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalUsers }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 bg-green-100 text-green-600 rounded-lg mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Pendapatan</p>
                        <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 bg-yellow-100 text-yellow-600 rounded-lg mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Pending Bayar</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $pendingPaymentsCount }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 bg-purple-100 text-purple-600 rounded-lg mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Kursus</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalCourses }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- LEFT: TABEL DAFTAR KURSUS ASLI --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                            <h3 class="font-bold text-gray-800">Manajemen Kursus</h3>
                            <a href="{{ route('admin.courses.create') }}" class="text-xs bg-blue-600 text-white px-3 py-1 rounded-lg font-bold hover:bg-blue-700 transition"> + TAMBAH </a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-white text-gray-400 text-[10px] uppercase font-bold border-b">
                                    <tr>
                                        <th class="px-6 py-3">Kursus</th>
                                        <th class="px-6 py-3">Kategori</th>
                                        <th class="px-6 py-3 text-right">Harga</th>
                                        <th class="px-6 py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-sm">
                                    @forelse ($courses as $course)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    @if($course->image)
                                                        <img src="{{ asset('storage/' . $course->image) }}" class="w-10 h-7 object-cover rounded shadow-sm">
                                                    @else
                                                        <div class="w-10 h-7 bg-gray-200 rounded flex items-center justify-center text-[8px]">NO IMG</div>
                                                    @endif
                                                    <span class="font-bold text-gray-900">{{ $course->title }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="px-2 py-0.5 bg-blue-50 text-blue-600 rounded text-xs font-semibold">{{ $course->category }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-right font-bold text-gray-700">
                                                Rp {{ number_format($course->price, 0, ',', '.') }}
                                            </td>
                                            
                                            <td class="px-6 py-4">
                                                <div class="flex justify-center items-center gap-2">
                                                    <a href="{{ route('admin.courses.edit', $course->id) }}" class="p-2 bg-amber-100 text-amber-600 rounded-lg hover:bg-amber-200 transition shadow-sm" title="Edit Kursus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>

                                                    <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kursus ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition shadow-sm" title="Hapus Kursus">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">Belum ada data kursus.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- RIGHT: QUICK ACTIONS & REAL RECENT USERS --}}
                <div class="space-y-6">
                    {{-- Quick Action Card --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-gray-800 mb-4">Aksi Cepat</h3>
                        <div class="grid grid-cols-1 gap-3">
                            <a href="{{ route('admin.courses.create') }}" class="w-full flex items-center justify-center gap-2 bg-blue-600 text-white py-2.5 rounded-lg font-bold hover:bg-blue-700 transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Kursus
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="w-full flex items-center justify-center gap-2 border border-gray-200 py-2.5 rounded-lg font-bold hover:bg-gray-50 transition text-gray-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Kelola User
                            </a>
                        </div>
                    </div>

                    {{-- User Baru (Real dari Database) --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-gray-800 mb-4">User Baru Bergabung</h3>
                        <div class="space-y-4">
                            @forelse($recentUsers as $user)
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-600 uppercase text-xs">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 leading-none">{{ $user->name }}</p>
                                        <p class="text-[10px] text-gray-400 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 text-center py-2">Belum ada user baru.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>