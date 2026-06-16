<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase">Lunas</p>
                    <p class="mt-1 text-2xl font-black text-green-600">{{ $paymentSummary->success_count ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase">Menunggu</p>
                    <p class="mt-1 text-2xl font-black text-yellow-600">{{ $paymentSummary->pending_count ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase">Ditolak</p>
                    <p class="mt-1 text-2xl font-black text-red-600">{{ $paymentSummary->rejected_count ?? 0 }}</p>
                </div>
            </div>

            {{-- Table Transaction --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No. Invoice
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kursus
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Metode
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                       <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($payments as $payment)
                            <tr class="hover:bg-gray-50 transition {{ $payment->status === 'rejected' ? 'opacity-60' : '' }}">
                                {{-- No. Invoice --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $payment->status === 'success' ? 'text-blue-600' : 'text-gray-500' }}">
                                    #INV-{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}
                                </td>
                                
                                {{-- Kursus --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $payment->course->title }}</div>
                                    <div class="text-xs text-gray-500">{{ $payment->course->category }}</div>
                                </td>
                                
                                {{-- Tanggal --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $payment->created_at->format('d M Y') }}
                                </td>
                                
                                {{-- Metode Pembayaran --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}
                                </td>
                                
                                {{-- Total --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800">
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </td>
                                
                                {{-- Status --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        @if($payment->status === 'success')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Lunas
                                            </span>
                                        @elseif($payment->status === 'pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Menunggu
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Gagal
                                            </span>
                                        @endif
                                        @if($payment->status === 'rejected')
                                        <p class="text-xs text-gray-500 mt-1 max-w-[200px] truncate" title="{{ $payment->rejection_reason ?? 'Tidak ada alasan penolakan' }}">
                                            {{ $payment->rejection_reason ?? 'Tidak ada alasan penolakan' }}
                                        </p>
                                        @endif
                                    </div>
                                </td>
                                
                                {{-- Aksi --}}
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if($payment->status === 'success')
                                        <a href="{{ route('course.learn', $payment->course->id) }}" 
                                        class="text-blue-600 hover:text-blue-900 inline-flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                            </svg>
                                            Akses Kursus
                                        </a>
                                    @elseif($payment->status === 'pending')
                                        <a href="{{ route('payment.upload', $payment->id) }}" 
                                        class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700 inline-block">
                                            Upload Bukti
                                        </a>
                                    @else
                                        <span class="text-gray-400 cursor-not-allowed">Gagal</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="text-gray-400 mb-2">
                                        <svg class="w-16 h-16 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-medium">Belum ada riwayat pembayaran</p>
                                    <a href="/" class="text-blue-600 hover:underline text-sm mt-2 inline-block">
                                        Jelajahi Kursus →
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($payments->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $payments->links() }}
                    </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>
