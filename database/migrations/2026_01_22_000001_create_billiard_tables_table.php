<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('billiard_tables', function (Blueprint $table) {
            $table->id();
            $table->string('table_name'); // Nama meja (Meja 1, Meja 2, dll)
            $table->integer('table_number'); // Nomor meja
            $table->text('description')->nullable();
            $table->enum('status', ['available', 'booked', 'maintenance'])->default('available');
            $table->integer('price_per_hour'); // Harga per jam dalam rupiah
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billiard_tables');
    }
};
