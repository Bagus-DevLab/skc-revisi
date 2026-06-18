<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ __('Detail Pembayaran') }}</h2>
                <p class="text-sm text-gray-500">Periksa bukti pembayaran sebelum membuka akses course.</p>
            </div>
            <a href="{{ route('admin.payments.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Kembali ke pembayaran</a>
        </div>
    </x-slot>

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

    <div class="py-10">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
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

            <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
                <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                    @if($payment->proof_of_payment)
                        <a href="{{ asset('storage/' . $payment->proof_of_payment) }}" target="_blank" class="block bg-gray-50">
                            <img src="{{ asset('storage/' . $payment->proof_of_payment) }}" alt="Bukti pembayaran {{ $payment->course->title }}" class="max-h-[640px] w-full object-contain">
                        </a>
                    @else
                        <div class="flex min-h-[360px] items-center justify-center bg-gray-50 px-6 text-center">
                            <div>
                                <p class="text-lg font-black text-gray-900">Belum ada bukti pembayaran</p>
                                <p class="mt-1 text-sm text-gray-500">Minta user upload bukti dari aplikasi mobile atau halaman payment upload.</p>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h3 class="text-xl font-black text-gray-900">{{ $payment->course->title }}</h3>
                            <p class="mt-1 text-sm font-semibold text-gray-500">{{ $payment->course->category }}</p>
                        </div>
                        <span class="rounded-full border px-2.5 py-1 text-xs font-black {{ $statusClass }}">{{ $statusLabel }}</span>
                    </div>

                    <dl class="mt-6 space-y-4 text-sm">
                        <div>
                            <dt class="font-bold text-gray-500">User</dt>
                            <dd class="mt-1 font-semibold text-gray-900">{{ $payment->user->name }} · {{ $payment->user->email }}</dd>
                        </div>
                        <div>
                            <dt class="font-bold text-gray-500">Metode</dt>
                            <dd class="mt-1 font-semibold text-gray-900">{{ $payment->payment_method }}</dd>
                        </div>
                        <div>
                            <dt class="font-bold text-gray-500">Nominal</dt>
                            <dd class="mt-1 font-black text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</dd>
                        </div>
                        <div>
                            <dt class="font-bold text-gray-500">Tanggal checkout</dt>
                            <dd class="mt-1 font-semibold text-gray-900">{{ $payment->created_at->format('d M Y H:i') }}</dd>
                        </div>
                        @if($payment->status === 'rejected' && $payment->rejection_reason)
                            <div class="rounded-lg border border-red-100 bg-red-50 p-3">
                                <dt class="font-bold text-red-700">Alasan penolakan</dt>
                                <dd class="mt-1 font-semibold text-red-700">{{ $payment->rejection_reason }}</dd>
                            </div>
                        @endif
                    </dl>

                    <div class="mt-6 flex flex-col gap-2">
                        @if($payment->proof_of_payment)
                            <a href="{{ asset('storage/' . $payment->proof_of_payment) }}" target="_blank" class="inline-flex justify-center rounded-md border border-gray-300 px-4 py-2 text-sm font-bold text-gray-700 hover:bg-gray-50">
                                Buka Bukti di Tab Baru
                            </a>
                        @endif

                        @if($payment->status === 'pending' && $payment->proof_of_payment)
                            <form action="{{ route('admin.payments.approve', $payment->id, absolute: false) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full rounded-md bg-green-600 px-4 py-2 text-sm font-bold text-white hover:bg-green-700">
                                    Setujui dan Buka Akses
                                </button>
                            </form>

                            <form action="{{ route('admin.payments.reject', $payment->id, absolute: false) }}" method="POST" class="space-y-2">
                                @csrf
                                <label for="rejection_reason" class="text-sm font-bold text-gray-700">Alasan penolakan</label>
                                <textarea name="rejection_reason" id="rejection_reason" rows="4" minlength="5" maxlength="1000" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="Contoh: bukti transfer tidak terbaca" required>{{ old('rejection_reason') }}</textarea>
                                <button type="submit" class="w-full rounded-md border border-red-200 px-4 py-2 text-sm font-bold text-red-700 hover:bg-red-50">
                                    Tolak Pembayaran
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
