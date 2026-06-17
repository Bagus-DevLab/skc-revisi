<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Concerns\RespondsWithApiJson;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use RespondsWithApiJson;

    public function index()
    {
        $payments = Payment::with('user', 'course')->latest()->paginate(15);

        return $this->paginated($payments);
    }

    public function approve(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = 'success';
        $payment->save();

        if (! $payment->user->courses()->where('course_id', $payment->course_id)->exists()) {
            $payment->user->courses()->attach($payment->course_id, [
                'status' => 'active',
                'progress' => 0,
                'last_accessed_at' => now(),
            ]);
        }

        return $this->success(null, 'Pembayaran berhasil disetujui & user telah didaftarkan ke kursus.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'nullable|string',
        ]);

        $payment = Payment::findOrFail($id);
        $payment->status = 'rejected';
        $payment->rejection_reason = $request->rejection_reason;
        $payment->save();

        return $this->success(null, 'Pembayaran berhasil ditolak.');
    }
}
