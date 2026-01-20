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
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase">Alasan Penolakan</th>
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
                            <td class="px-6 py-4 text-sm">
                                @if($payment->status == 'rejected')
                                    {{ $payment->rejection_reason }}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($payment->status == 'pending' && $payment->proof_of_payment)
                                <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-green-700">Setujui</button>
                                    </form>
                                <form id="reject-form" action="" method="POST" class="inline">
                                    @csrf
                                    <x-danger-button type="button" onclick="openModal('{{ route('admin.payments.reject', $payment->id) }}')">
                                        Tolak
                                    </x-danger-button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Reject Modal -->
                <div id="reject-modal" class="fixed z-10 inset-0 overflow-y-auto hidden">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <form id="modal-reject-form" method="POST" action="">
                                @csrf
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                Alasan Penolakan
                                            </h3>
                                            <div class="mt-2">
                                                <textarea name="rejection_reason" id="rejection_reason" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Tolak Pembayaran
                                    </button>
                                    <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    function openModal(action) {
                        const modal = document.getElementById('reject-modal');
                        const form = document.getElementById('modal-reject-form');
                        form.action = action;
                        modal.classList.remove('hidden');
                    }

                    function closeModal() {
                        const modal = document.getElementById('reject-modal');
                        modal.classList.add('hidden');
                    }
                </script>
            </div>
        </div>
    </div>
</x-app-layout> 