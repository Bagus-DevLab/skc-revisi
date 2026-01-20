<x-app-layout>
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-2xl font-bold mb-2 text-gray-800 tracking-tight">Checkout Kursus</h2>
                <p class="text-gray-500 mb-8">Anda akan mendaftar pada: <span class="font-bold text-gray-800">{{ $course->title }}</span></p>
                
                <form action="{{ route('course.store', $course->id) }}" method="POST">
                    @csrf
                    <p class="text-sm font-bold text-gray-700 mb-4 uppercase tracking-widest">Pilih Metode Pembayaran</p>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border rounded-xl cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition group">
                            <input type="radio" name="payment_method" value="BCA" required class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="ml-4 font-medium text-gray-700 group-hover:text-blue-700">Transfer Bank BCA</span>
                        </label>
                        <label class="flex items-center p-4 border rounded-xl cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition group">
                            <input type="radio" name="payment_method" value="Mandiri" required class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="ml-4 font-medium text-gray-700 group-hover:text-blue-700">Transfer Bank Mandiri</span>
                        </label>
                    </div>

                    <div class="mt-10 border-t pt-6">
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-gray-500">Total yang harus dibayar:</span>
                            <span class="text-2xl font-black text-blue-600">Rp {{ number_format($course->price, 0, ',', '.') }}</span>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 transition">
                            Proses Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>