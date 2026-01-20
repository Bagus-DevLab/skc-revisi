<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $payment->course->title }}</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ $payment->user->name }}
                            </p>
                        </div>
                        <div>
                            @if($payment->proof_of_payment)
                                <img src="{{ asset('storage/' . $payment->proof_of_payment) }}" alt="Proof of Payment" class="w-full">
                            @else
                                <p>No proof of payment uploaded.</p>
                            @endif
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            @if($payment->status == 'pending' && $payment->proof_of_payment)
                                <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-green-700">Approve</button>
                                </form>
                                <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-red-700">Reject</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
