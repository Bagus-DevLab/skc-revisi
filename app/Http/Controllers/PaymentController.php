<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller {
    // 1. Pilih Metode Pembayaran
    public function checkout($id) {
        $course = Course::findOrFail($id);
        return view('courses.checkout', compact('course'));
    }

    // 2. Simpan Transaksi & Lanjut ke Halaman Instruksi
    public function store(Request $request, $id) {
        $course = Course::findOrFail($id);
        
        $payment = Payment::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'payment_method' => $request->payment_method,
            'amount' => $course->price,
            'status' => 'pending'
        ]);

        return redirect()->route('payment.upload', $payment->id);
    }

    // 3. Halaman Upload Bukti
    public function uploadPage($id) {
        $payment = Payment::with('course')->findOrFail($id);
        return view('courses.payment-upload', compact('payment'));
    }

    // 4. Proses Upload File
    public function processUpload(Request $request, $id) {
        $payment = Payment::findOrFail($id);
        $request->validate(['proof' => 'required|image|max:2048']);

        $path = $request->file('proof')->store('payments', 'public');
        $payment->update(['proof_of_payment' => $path]);

        return redirect()->route('dashboard')->with('success', 'Bukti berhasil diupload, tunggu konfirmasi admin.');
    }
}