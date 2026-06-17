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

        $payments->getCollection()->transform(function (Payment $payment) {
            return [
                'id' => $payment->id,
                'course_id' => $payment->course_id,
                'payment_method' => $payment->payment_method,
                'amount' => $payment->amount,
                'status' => $payment->status,
                'proof_of_payment' => $payment->proof_of_payment,
                'proof_of_payment_url' => $payment->proof_of_payment ? asset('storage/'.$payment->proof_of_payment) : null,
                'rejection_reason' => $payment->rejection_reason,
                'created_at' => $payment->created_at,
                'user' => $payment->user ? [
                    'id' => $payment->user->id,
                    'name' => $payment->user->name,
                    'email' => $payment->user->email,
                    'role' => $payment->user->role,
                    'avatar_url' => $payment->user->avatar_url,
                ] : null,
                'course' => $payment->course ? [
                    'id' => $payment->course->id,
                    'title' => $payment->course->title,
                    'category' => $payment->course->category,
                    'price' => $payment->course->price,
                    'image' => $payment->course->image,
                    'image_url' => $payment->course->image ? asset('storage/'.$payment->course->image) : null,
                ] : null,
            ];
        });

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
