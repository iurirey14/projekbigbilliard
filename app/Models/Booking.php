<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'table_id',
        'booking_date',
        'start_time',
        'end_time',
        'duration_hours',
        'total_price',
        'status',
        'notes',
    ];

    protected $casts = [
        'booking_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function table()
    {
        return $this->belongsTo(BilliardTable::class, 'table_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
