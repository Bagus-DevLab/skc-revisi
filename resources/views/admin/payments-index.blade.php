<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ __('Validasi Pembayaran') }}</h2>
                <p class="text-sm text-gray-500">Review bukti bayar, setujui akses course, atau tolak dengan alasan yang jelas.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Kembali ke dashboard</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="mb-5 grid gap-3 sm:grid-cols-3">
                <div class="rounded-lg border border-yellow-200 bg-yellow-50 p-4">
                    <p class="text-xs font-bold uppercase tracking-wide text-yellow-700">Pending</p>
                    <p class="mt-1 text-2xl font-black text-yellow-800">{{ $payments->where('status', 'pending')->count() }}</p>
                </div>
                <div class="rounded-lg border border-green-200 bg-green-50 p-4">
                    <p class="text-xs font-bold uppercase tracking-wide text-green-700">Diterima</p>
                    <p class="mt-1 text-2xl font-black text-green-800">{{ $payments->where('status', 'success')->count() }}</p>
                </div>
                <div class="rounded-lg border border-red-200 bg-red-50 p-4">
                    <p class="text-xs font-bold uppercase tracking-wide text-red-700">Ditolak</p>
                    <p class="mt-1 text-2xl font-black text-red-800">{{ $payments->where('status', 'rejected')->count() }}</p>
                </div>
            </div>

            <div class="space-y-4">
                @forelse($payments as $payment)
                    @php
                        $statusClass = match ($payment->status) {
                            'success' => 'bg-green-100 text-green-700 border-green-200',
                            'rejected' => 'bg-red-100 text-red-700 border-red-200',
                            default => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                        };
                        $statusLabel = match ($payment->status) {
                            'success' => 'Diterima',
                            'rejected' => 'Ditolak',
                            default => $payment->proof_of_payment ? 'Menunggu review' : 'Menunggu bukti',
                        };
                    @endphp

                    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                        <div class="grid gap-0 lg:grid-cols-[220px_1fr]">
                            <div class="bg-gray-50">
                                @if($payment->proof_of_payment)
                                    <a href="{{ asset('storage/' . $payment->proof_of_payment) }}" target="_blank" class="block">
                                        <img src="{{ asset('storage/' . $payment->proof_of_payment) }}" alt="Bukti pembayaran {{ $payment->course->title }}" class="h-56 w-full object-cover lg:h-full">
                                    </a>
                                @else
                                    <div class="flex h-56 items-center justify-center px-6 text-center text-sm font-bold text-gray-500 lg:h-full">
                                        User belum upload bukti pembayaran
                                    </div>
                                @endif
                            </div>

                            <div class="p-5">
                                <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                                    <div>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <h3 class="text-lg font-black text-gray-900">{{ $payment->course->title }}</h3>
                                            <span class="rounded-full border px-2.5 py-1 text-xs font-black {{ $statusClass }}">{{ $statusLabel }}</span>
                                        </div>
                                        <p class="mt-1 text-sm font-semibold text-gray-600">{{ $payment->user->name }} · {{ $payment->user->email }}</p>
                                        <p class="mt-2 text-sm text-gray-500">{{ $payment->payment_method }} · Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                                    </div>
                                    <a href="{{ route('admin.payments.show', $payment->id) }}" class="text-sm font-bold text-blue-600 hover:text-blue-700">Detail</a>
                                </div>

                                @if($payment->status === 'rejected' && $payment->rejection_reason)
                                    <div class="mt-4 rounded-lg border border-red-100 bg-red-50 p-3 text-sm font-semibold text-red-700">
                                        Alasan penolakan: {{ $payment->rejection_reason }}
                                    </div>
                                @endif

                                <div class="mt-5 flex flex-col gap-2 sm:flex-row sm:justify-end">
                                    @if($payment->proof_of_payment)
                                        <a href="{{ asset('storage/' . $payment->proof_of_payment) }}" target="_blank" class="inline-flex justify-center rounded-md border border-gray-300 px-4 py-2 text-sm font-bold text-gray-700 hover:bg-gray-50">
                                            Lihat Bukti
                                        </a>
                                    @endif

                                    @if($payment->status === 'pending' && $payment->proof_of_payment)
                                        <form action="{{ route('admin.payments.approve', $payment->id, absolute: false) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full rounded-md bg-green-600 px-4 py-2 text-sm font-bold text-white hover:bg-green-700 sm:w-auto">
                                                Setujui
                                            </button>
                                        </form>
                                        <button type="button" onclick="openRejectModal('{{ route('admin.payments.reject', $payment->id, absolute: false) }}', @js($payment->course->title))" class="rounded-md border border-red-200 px-4 py-2 text-sm font-bold text-red-700 hover:bg-red-50">
                                            Tolak
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-lg border border-gray-200 bg-white p-10 text-center">
                        <p class="text-lg font-black text-gray-900">Belum ada pembayaran</p>
                        <p class="mt-1 text-sm text-gray-500">Checkout user akan muncul di halaman ini.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $payments->links() }}
            </div>
        </div>
    </div>

    <div id="reject-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center px-4 py-8">
            <button type="button" onclick="closeRejectModal()" class="fixed inset-0 bg-gray-900/50" aria-label="Tutup modal"></button>
            <div class="relative w-full max-w-lg rounded-lg bg-white shadow-xl">
                <form id="modal-reject-form" method="POST" action="">
                    @csrf
                    <div class="border-b border-gray-100 px-6 py-4">
                        <h3 class="text-lg font-black text-gray-900">Tolak Pembayaran</h3>
                        <p id="reject-course-title" class="mt-1 text-sm font-semibold text-gray-500"></p>
                    </div>
                    <div class="px-6 py-5">
                        <label for="rejection_reason" class="text-sm font-bold text-gray-700">Alasan penolakan</label>
                        <textarea name="rejection_reason" id="rejection_reason" rows="4" minlength="5" maxlength="1000" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="Contoh: bukti transfer tidak terbaca" required></textarea>
                        <p class="mt-2 text-xs font-semibold text-gray-500">Alasan ini akan tampil pada status pembelian user.</p>
                    </div>
                    <div class="flex flex-col-reverse gap-2 bg-gray-50 px-6 py-4 sm:flex-row sm:justify-end">
                        <button type="button" onclick="closeRejectModal()" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-bold text-gray-700 hover:bg-white">
                            Batal
                        </button>
                        <button type="submit" class="rounded-md bg-red-600 px-4 py-2 text-sm font-bold text-white hover:bg-red-700">
                            Tolak Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRejectModal(action, courseTitle) {
            const modal = document.getElementById('reject-modal');
            const form = document.getElementById('modal-reject-form');
            const title = document.getElementById('reject-course-title');
            const reason = document.getElementById('rejection_reason');

            form.action = action;
            title.textContent = courseTitle;
            reason.value = '';
            modal.classList.remove('hidden');
            reason.focus();
        }

        function closeRejectModal() {
            document.getElementById('reject-modal').classList.add('hidden');
        }
    </script>
</x-app-layout>
