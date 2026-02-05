<?php

/**
 * ============================================================================
 * BilliardTableController - Controller untuk mengelola meja billiard
 * ============================================================================
 * Controller ini bertanggung jawab atas:
 * - Menampilkan daftar semua meja billiard
 * - Menampilkan detail meja billiard tertentu
 * - Mengambil data meja yang tersedia berdasarkan tanggal dan waktu
 * ============================================================================
 */

namespace App\Http\Controllers;

use App\Models\BilliardTable;
use App\Models\Booking;
use Illuminate\Http\Request;

class BilliardTableController extends Controller
{
    /**
     * index - Menampilkan daftar semua meja billiard
     * @return \Illuminate\View\View - View dengan data semua meja
     * 
     * Proses:
     * 1. Ambil semua data meja dari database
     * 2. Pass data ke view tables.index untuk ditampilkan
     */
    public function index()
    {
        // Ambil semua data meja billiard dari database
        $tables = BilliardTable::all();
        // Pass data ke view dengan variabel 'tables'
        return view('tables.index', compact('tables'));
    }

    /**
     * show - Menampilkan detail meja billiard tertentu
     * @param int $id - ID meja yang ingin dilihat
     * @return \Illuminate\View\View - View dengan detail meja
     * 
     * Proses:
     * 1. Cari meja dengan ID tertentu dari database
     * 2. Jika tidak ditemukan, tampilkan 404 error
     * 3. Pass data ke view tables.show untuk ditampilkan
     */
    public function show($id)
    {
        // Cari meja berdasarkan ID, jika tidak ditemukan throw 404 error
        $table = BilliardTable::findOrFail($id);
        // Pass data ke view dengan variabel 'table'
        return view('tables.show', compact('table'));
    }

    /**
     * getAvailableTables - Mendapatkan daftar meja yang tersedia sesuai kriteria booking
     * @param Request $request - Query parameters: date, start_time, end_time
     * @return \Illuminate\Http\JsonResponse - JSON response dengan array meja yang tersedia
     * 
     * Proses:
     * 1. Ambil parameter tanggal dan waktu dari request
     * 2. Cari meja yang status 'available' (tidak sedang maintenance)
     * 3. Filter meja yang tidak memiliki booking konflik di tanggal dan waktu yang diminta
     * 4. Return hasil sebagai JSON untuk digunakan di frontend
     */
    public function getAvailableTables(Request $request)
    {
        // Ambil parameter dari query string
        // date: tanggal booking (format: YYYY-MM-DD)
        // start_time: jam mulai booking (format: HH:mm)
        // end_time: jam selesai booking (format: HH:mm)
        $date = $request->query('date');
        $startTime = $request->query('start_time');
        $endTime = $request->query('end_time');

        // Cari semua meja dengan status 'available' (siap digunakan)
        $tables = BilliardTable::where('status', 'available')
            ->get()
            // Filter meja berdasarkan ketersediaan slot waktu
            ->filter(function ($table) use ($date, $startTime, $endTime) {
                // Cari booking yang conflict dengan waktu yang diminta
                // Booking conflict jika:
                // 1. Booking ada di tanggal yang sama
                // 2. Waktu booking overlap dengan start_time dan end_time yang diminta
                // 3. Status booking bukan 'cancelled' (pembatalan tidak dihitung)
                $conflictingBookings = Booking::where('table_id', $table->id)
                    ->where('booking_date', $date)
                    // Cek 3 kondisi conflict booking:
                    ->where(function ($query) use ($startTime, $endTime) {
                        // Kondisi 1: Booking dimulai dalam range waktu yang diminta
                        $query->whereBetween('start_time', [$startTime, $endTime])
                            // Kondisi 2: Booking berakhir dalam range waktu yang diminta
                            ->orWhereBetween('end_time', [$startTime, $endTime])
                            // Kondisi 3: Booking mulai sebelum dan berakhir setelah range waktu
                            ->orWhere(function ($q) use ($startTime, $endTime) {
                                $q->where('start_time', '<=', $startTime)
                                    ->where('end_time', '>=', $endTime);
                            });
                    })
                    // Hanya hitung booking yang tidak dibatalkan
                    ->where('status', '!=', 'cancelled')
                    ->count();

                // Meja tersedia jika tidak ada booking yang conflict
                return $conflictingBookings === 0;
            });

        // Return data meja dalam format JSON
        return response()->json($tables);
    }
}
