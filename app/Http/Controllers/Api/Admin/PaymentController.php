<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('user', 'course')->latest()->paginate(15);
        return response()->json($payments);
    }

    public function approve(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = 'success';
        $payment->save();

        // Daftarkan user ke kursus
        $payment->user->courses()->attach($payment->course_id, [
            'status' => 'active',
            'progress' => 0,
            'last_accessed_at' => now(),
        ]);

        return response()->json(['message' => 'Pembayaran berhasil disetujui & user telah didaftarkan ke kursus.']);
    }

    public function reject(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = 'rejected';
        $payment->save();

        return response()->json(['message' => 'Pembayaran berhasil ditolak.']);
    }
}
