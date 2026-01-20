<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Konfirmasi Pembayaran') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase">User</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase">Kursus</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase">Bukti</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-bold uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($payments as $payment)
                        <tr>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('admin.payments.show', $payment->id) }}" class="text-blue-600 underline">
                                    {{ $payment->user->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold">{{ $payment->course->title }}</td>
                            <td class="px-6 py-4">
                                @if($payment->proof_of_payment)
                                    <a href="{{ asset('storage/' . $payment->proof_of_payment) }}" target="_blank" class="text-blue-600 underline text-xs">Lihat Bukti</a>
                                @else
                                    <span class="text-red-500 text-xs font-bold italic">Belum Upload</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-full text-[10px] font-bold {{ $payment->status == 'success' ? 'bg-green-100 text-green-700' : ($payment->status == 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ strtoupper($payment->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($payment->status == 'pending' && $payment->proof_of_payment)
                                <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-green-700">Setujui</button>
                                    </form>
                                    <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-red-700">Tolak</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout> 