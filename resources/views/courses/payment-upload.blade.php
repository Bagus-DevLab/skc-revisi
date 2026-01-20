<x-app-layout>
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 text-blue-600 rounded-full mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Instruksi Pembayaran</h2>
                <p class="text-gray-500 mb-8">Silakan selesaikan transfer Anda agar kursus dapat segera diaktifkan.</p>
                
                <div class="bg-gray-50 rounded-2xl p-6 mb-8 border border-gray-100">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Nomor Rekening {{ $payment->payment_method }}</p>
                    <p class="text-3xl font-black text-gray-800 tracking-tighter">1234-567-890</p>
                    <p class="text-sm font-medium text-gray-600 mt-2 italic underline">A/N SkillConnect Indonesia</p>
                </div>

                <div class="flex justify-between items-center text-left mb-8 bg-blue-50 p-4 rounded-xl border border-blue-100">
                    <span class="text-blue-800 font-medium">Total Tagihan:</span>
                    <span class="text-xl font-black text-blue-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                </div>

                <form action="{{ route('payment.process', $payment->id) }}" method="POST" enctype="multipart/form-data" class="text-left">
                    @csrf
                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase">Upload Bukti Transfer (JPG/PNG)</label>
                    <input type="file" name="proof" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border p-3 rounded-xl mb-6">
                    
                    <button type="submit" class="w-full bg-green-600 text-white py-4 rounded-xl font-bold shadow-lg shadow-green-100 hover:bg-green-700 transition">
                        Konfirmasi Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>