<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show($bookingId)
    {
        try {
            $booking = Booking::with('table', 'payment')->findOrFail($bookingId);

            if ($booking->user_id !== Auth::id()) {
                abort(403);
            }

            $payment = $booking->payment;
            
            if (!$payment) {
                return back()->withErrors(['error' => 'Pembayaran tidak ditemukan untuk booking ini.']);
            }

            return view('payments.show', compact('booking', 'payment'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function process(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:transfer_bank,credit_card,cash,e_wallet',
        ]);

        $payment = $booking->payment;

        // Simulate payment processing
        // In production, integrate with real payment gateway like Midtrans, PayPal, etc.
        $payment->update([
            'status' => 'completed',
            'payment_method' => $validated['payment_method'],
            'paid_at' => now(),
            'transaction_id' => 'TXN-' . uniqid(),
        ]);

        $booking->update(['status' => 'confirmed']);

        return redirect()->route('bookings.show', $booking->id)->with('success', 'Pembayaran berhasil! Booking Anda telah dikonfirmasi.');
    }

    public function list()
    {
        $user = Auth::user();
        $payments = Payment::where('user_id', $user->id)
            ->with('booking.table')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('payments.list', compact('payments'));
    }

    public function receipt($bookingId)
    {
        $booking = Booking::with('table', 'payment')->findOrFail($bookingId);

        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('payments.receipt', compact('booking'));
    }
}
