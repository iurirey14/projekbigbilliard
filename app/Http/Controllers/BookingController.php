<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BilliardTable;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $bookings = Booking::where('user_id', $user->id)
            ->with('table', 'payment')
            ->orderBy('booking_date', 'desc')
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $tables = BilliardTable::where('status', 'available')->get();
        return view('bookings.create', compact('tables'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_id' => 'required|exists:billiard_tables,id',
            'booking_date' => 'required|date|after:today',
            'start_time' => 'required|date_format:H:i',
            'duration_hours' => 'required|integer|min:1|max:12',
            'notes' => 'nullable|string|max:500',
        ]);

        $table = BilliardTable::find($validated['table_id']);
        
        // Calculate end time
        $startTime = \Carbon\Carbon::createFromFormat('H:i', $validated['start_time']);
        $endTime = $startTime->copy()->addHours($validated['duration_hours']);

        // Check for conflicts
        $conflictingBookings = Booking::where('table_id', $validated['table_id'])
            ->where('booking_date', $validated['booking_date'])
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime->format('H:i'), $endTime->format('H:i')])
                    ->orWhereBetween('end_time', [$startTime->format('H:i'), $endTime->format('H:i')])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<=', $startTime->format('H:i'))
                            ->where('end_time', '>=', $endTime->format('H:i'));
                    });
            })
            ->where('status', '!=', 'cancelled')
            ->count();

        if ($conflictingBookings > 0) {
            return back()->withErrors(['error' => 'Waktu booking tidak tersedia untuk meja ini.']);
        }

        $totalPrice = $table->price_per_hour * $validated['duration_hours'];

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'table_id' => $validated['table_id'],
            'booking_date' => $validated['booking_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $endTime->format('H:i'),
            'duration_hours' => $validated['duration_hours'],
            'total_price' => $totalPrice,
            'notes' => $validated['notes'] ?? null,
        ]);

        // Create payment record
        Payment::create([
            'booking_id' => $booking->id,
            'user_id' => Auth::id(),
            'amount' => $totalPrice,
            'status' => 'pending',
        ]);

        return redirect()->route('payments.show', $booking->id)->with('success', 'Booking berhasil dibuat. Lanjutkan ke pembayaran.');
    }

    public function show($id)
    {
        $booking = Booking::with('table', 'payment', 'user')->findOrFail($id);
        
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('bookings.show', compact('booking'));
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->status === 'completed') {
            return back()->withErrors(['error' => 'Tidak bisa membatalkan booking yang sudah selesai.']);
        }

        $booking->update(['status' => 'cancelled']);

        // Refund payment if completed
        if ($booking->payment && $booking->payment->status === 'completed') {
            $booking->payment->update(['status' => 'refunded']);
        }

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }
}
