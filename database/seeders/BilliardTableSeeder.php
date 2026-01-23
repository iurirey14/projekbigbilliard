<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BilliardTable;

class BilliardTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama jika ada
        BilliardTable::truncate();

        // Buat data meja billiard
        $tables = [
            [
                'table_name' => 'Meja Premium A',
                'table_type' => 'Premium',
                'status' => 'available',
                'price_per_hour' => 50000,
                'description' => 'Meja billiard premium dengan kondisi terbaik',
            ],
            [
                'table_name' => 'Meja Premium B',
                'table_type' => 'Premium',
                'status' => 'available',
                'price_per_hour' => 50000,
                'description' => 'Meja billiard premium dengan kondisi terbaik',
            ],
            [
                'table_name' => 'Meja Standard 1',
                'table_type' => 'Standard',
                'status' => 'available',
                'price_per_hour' => 30000,
                'description' => 'Meja billiard standar kualitas bagus',
            ],
            [
                'table_name' => 'Meja Standard 2',
                'table_type' => 'Standard',
                'status' => 'available',
                'price_per_hour' => 30000,
                'description' => 'Meja billiard standar kualitas bagus',
            ],
            [
                'table_name' => 'Meja VIP Eksklusif',
                'table_type' => 'VIP',
                'status' => 'available',
                'price_per_hour' => 75000,
                'description' => 'Meja billiard VIP dengan fasilitas lengkap',
            ],
        ];

        // Insert data ke database
        foreach ($tables as $table) {
            BilliardTable::create($table);
        }
    }
}
