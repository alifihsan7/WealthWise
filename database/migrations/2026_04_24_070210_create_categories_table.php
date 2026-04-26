<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            // Relasi ke users (jika user dihapus, kategorinya ikut terhapus)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); 
            $table->enum('category_type', ['INCOME', 'EXPENSE']);
            $table->timestamps(); // Membuat created_at & updated_at
            $table->softDeletes(); // Membuat deleted_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};