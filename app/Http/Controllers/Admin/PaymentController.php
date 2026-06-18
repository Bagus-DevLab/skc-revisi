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
        $payment = Payment::with('user')->findOrFail($id);

        if ($payment->status !== 'pending') {
            return redirect()->route('admin.payments.index')->with('error', 'Pembayaran ini sudah diproses.');
        }

        $payment->status = 'success';
        $payment->save();

        if (! $payment->user->courses()->where('course_id', $payment->course_id)->exists()) {
            $payment->user->courses()->attach($payment->course_id, [
                'status' => 'active',
                'progress' => 0,
                'last_accessed_at' => now(),
            ]);
        }

        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran berhasil disetujui & user telah didaftarkan ke kursus.');
    }

    public function reject(Request $request, $id)
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'min:5', 'max:1000'],
        ]);

        $payment = Payment::findOrFail($id);

        if ($payment->status !== 'pending') {
            return redirect()->route('admin.payments.index')->with('error', 'Pembayaran ini sudah diproses.');
        }

        $payment->status = 'rejected';
        $payment->rejection_reason = $validated['rejection_reason'];
        $payment->save();

        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran berhasil ditolak.');
    }

    public function show($id)
    {
        $payment = Payment::with('user', 'course')->findOrFail($id);

        return view('admin.payments.show', compact('payment'));
    }
}
