<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\RespondsWithApiJson;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use RespondsWithApiJson;

    public function checkout(Request $request, $id)
    {
        $validated = $request->validate([
            'payment_method' => ['required', 'string', 'max:50'],
        ]);

        $course = Course::findOrFail($id);

        $payment = Payment::create([
            'user_id' => auth()->id(),
            'course_id' => $course->id,
            'payment_method' => $validated['payment_method'],
            'amount' => $course->price,
            'status' => 'pending',
        ]);

        return $this->success([
            'payment_id' => $payment->id,
            'amount' => $payment->amount,
            'status' => $payment->status,
        ], 'Pesanan dibuat, silakan upload bukti', 201);
    }

    public function uploadProof(Request $request, $id)
    {
        $request->validate(['proof' => 'required|image|max:2048']);
        $payment = Payment::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        if ($request->hasFile('proof')) {
            $path = $request->file('proof')->store('payments', 'public');
            $payment->update(['proof_of_payment' => $path]);

            return $this->success([
                'payment_id' => $payment->id,
                'proof_of_payment' => $path,
                'proof_of_payment_url' => asset('storage/'.$path),
                'status' => $payment->status,
            ], 'Bukti berhasil diunggah');
        }

        return $this->error('Gagal mengunggah', 400);
    }

    public function history(Request $request)
    {
        $payments = $request->user()->payments()->with('course')->latest()->paginate(10);

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
                'course' => $payment->course ? [
                    'id' => $payment->course->id,
                    'title' => $payment->course->title,
                    'image' => $payment->course->image,
                    'image_url' => $payment->course->image ? asset('storage/'.$payment->course->image) : null,
                ] : null,
            ];
        });

        return $this->paginated($payments);
    }
}
