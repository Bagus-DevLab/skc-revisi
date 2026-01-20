<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function indexAdmin()
    {
        $payments = Payment::with('user', 'course')->latest()->paginate(15);
        return view('admin.payments-index', compact('payments'));
    }

    public function approve(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = 'completed';
        $payment->save();

        // Daftarkan user ke kursus
        $payment->user->courses()->attach($payment->course_id, [
            'status' => 'active',
            'progress' => 0,
            'last_accessed_at' => now(),
        ]);

        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran berhasil disetujui & user telah didaftarkan ke kursus.');
    }
}
