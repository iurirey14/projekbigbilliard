<?php

namespace App\Http\Controllers;

use App\Models\BilliardTable;
use App\Models\Booking;
use Illuminate\Http\Request;

class BilliardTableController extends Controller
{
    public function index()
    {
        $tables = BilliardTable::all();
        return view('tables.index', compact('tables'));
    }

    public function show($id)
    {
        $table = BilliardTable::findOrFail($id);
        return view('tables.show', compact('table'));
    }

    public function getAvailableTables(Request $request)
    {
        $date = $request->query('date');
        $startTime = $request->query('start_time');
        $endTime = $request->query('end_time');

        $tables = BilliardTable::where('status', 'available')
            ->get()
            ->filter(function ($table) use ($date, $startTime, $endTime) {
                $conflictingBookings = Booking::where('table_id', $table->id)
                    ->where('booking_date', $date)
                    ->where(function ($query) use ($startTime, $endTime) {
                        $query->whereBetween('start_time', [$startTime, $endTime])
                            ->orWhereBetween('end_time', [$startTime, $endTime])
                            ->orWhere(function ($q) use ($startTime, $endTime) {
                                $q->where('start_time', '<=', $startTime)
                                    ->where('end_time', '>=', $endTime);
                            });
                    })
                    ->where('status', '!=', 'cancelled')
                    ->count();

                return $conflictingBookings === 0;
            });

        return response()->json($tables);
    }
}
