<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('Admin123456'),
            'role' => 'admin',
        ]);

        // Create Test User
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('Test123456'),
            'role' => 'user',
        ]);

        $this->call(BilliardTableSeeder::class);
    }
}
