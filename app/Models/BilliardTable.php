<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BilliardTable extends Model
{
    use HasFactory;

    protected $table = 'billiard_tables';

    protected $fillable = [
        'table_name',
        'table_number',
        'description',
        'status',
        'price_per_hour',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'table_id');
    }

    public function isAvailable()
    {
        return $this->status === 'available';
    }
}
