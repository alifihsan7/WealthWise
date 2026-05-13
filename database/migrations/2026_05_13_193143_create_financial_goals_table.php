<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_goals', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke User
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // 1. Nama Goal
            $table->string('goal_name'); 
            
            // 2. Goal Amount (Target Total)
            $table->decimal('target_amount', 15, 2); 
            
            // Melacak tabungan yang sudah terkumpul saat ini
            $table->decimal('current_amount', 15, 2)->default(0); 

            // 3. Filling Plan (Frequensi)
            // Menggunakan ENUM agar data konsisten
            $table->enum('filling_plan', ['DAILY', 'WEEKLY', 'MONTHLY', 'YEARLY']); 

            // 4. Amount Per Period (Jumlah menabung per periode)
            $table->decimal('amount_per_period', 15, 2);

            // Kolom Tambahan untuk Smart Planning
            // $table->date('start_date'); // Kapan mulai menabung
            // $table->date('target_date')->nullable(); // Prediksi tanggal tercapai (bisa dihitung otomatis)
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_goals');
    }
};