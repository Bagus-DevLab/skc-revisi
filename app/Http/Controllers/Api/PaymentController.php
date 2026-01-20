<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function checkout(Request $request, $id) {
        $course = Course::findOrFail($id);
        
        $payment = Payment::create([
            'user_id' => auth()->id(),
            'course_id' => $course->id,
            'payment_method' => $request->payment_method, // Misal: "BCA"
            'amount' => $course->price,
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Pesanan dibuat, silakan upload bukti',
            'payment_id' => $payment->id,
            'amount' => $payment->amount
        ]);
    }

    public function uploadProof(Request $request, $id) {
        $request->validate(['proof' => 'required|image|max:2048']);
        $payment = Payment::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        if ($request->hasFile('proof')) {
            $path = $request->file('proof')->store('payments', 'public');
            $payment->update(['proof_of_payment' => $path]);
            return response()->json(['message' => 'Bukti berhasil diunggah']);
        }
        
        return response()->json(['message' => 'Gagal mengunggah'], 400);
    }
}