<?php

/**
 * ============================================================================
 * BookingController - Controller untuk mengelola booking meja billiard
 * ============================================================================
 * Controller ini bertanggung jawab atas:
 * - Menampilkan daftar booking pengguna
 * - Membuat booking baru
 * - Menampilkan detail booking
 * - Membatalkan booking
 * ============================================================================
 */

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BilliardTable;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * index - Menampilkan daftar booking milik pengguna yang login
     * @return \Illuminate\View\View - View dengan daftar booking pengguna
     * 
     * Proses:
     * 1. Ambil user yang sedang login
     * 2. Cari semua booking milik user, dengan relasi table dan payment
     * 3. Urutkan berdasarkan tanggal booking terbaru
     * 4. Pass data ke view bookings.index
     */
    public function index()
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        // Cari booking milik user, load relasi table dan payment
        // orderBy descending untuk menampilkan booking terbaru dulu
        $bookings = Booking::where('user_id', $user->id)
            ->with('table', 'payment')
            ->orderBy('booking_date', 'desc')
            ->get();

        // Pass data ke view dengan variabel 'bookings'
        return view('bookings.index', compact('bookings'));
    }

    /**
     * create - Menampilkan form untuk membuat booking baru
     * @return \Illuminate\View\View - View form create booking
     * 
     * Proses:
     * 1. Ambil semua meja yang status 'available'
     * 2. Pass data ke view bookings.create untuk ditampilkan dalam select list
     */
    public function create()
    {
        // Ambil meja yang tersedia (status = available)
        $tables = BilliardTable::where('status', 'available')->get();
        // Pass data ke view
        return view('bookings.create', compact('tables'));
    }

    /**
     * store - Menyimpan booking baru ke database
     * @param Request $request - Form data dari booking create
     * @return \Illuminate\Http\RedirectResponse - Redirect ke payment page
     * 
     * Proses:
     * 1. Validasi input: table_id, booking_date, start_time, duration, notes
     * 2. Hitung waktu berakhir booking
     * 3. Cek conflict dengan booking lain di waktu yang sama
     * 4. Hitung total harga
     * 5. Simpan booking ke database
     * 6. Buat payment record dengan status pending
     * 7. Redirect ke halaman pembayaran
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_id' => 'required|exists:billiard_tables,id',
            'booking_date' => 'required|date|after:today',
            'start_time' => 'required|date_format:H:i',
            'duration_hours' => 'required|integer|min:1|max:12',
            'category' => 'required|in:regular,vip',
            'notes' => 'nullable|string|max:500',
        ]);

        $table = BilliardTable::find($validated['table_id']);
        $durationHours = (int)$validated['duration_hours'];
        
        // Calculate end time
        $startTime = \Carbon\Carbon::createFromFormat('H:i', $validated['start_time']);
        $endTime = $startTime->copy()->addHours($durationHours);

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

        $totalPrice = $table->price_per_hour * $durationHours;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'table_id' => $validated['table_id'],
            'booking_date' => $validated['booking_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $endTime->format('H:i'),
            'duration_hours' => $durationHours,
            'category' => $validated['category'],
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
        try {
            $booking = Booking::with('table', 'payment')->findOrFail($id);
            
            if ($booking->user_id !== Auth::id()) {
                abort(403);
            }

            // Ensure payment exists, if not set it to null for the view
            $payment = $booking->payment;

            return view('bookings.show', compact('booking', 'payment'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memuat pesanan: ' . $e->getMessage()]);
        }
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