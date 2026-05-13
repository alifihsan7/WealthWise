<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->enum('budget_period', ['WEEKLY', 'MONTHLY', 'YEARLY'])->nullable()->after('budget_limit');
            $table->date('start_date')->nullable()->after('budget_period');
            $table->date('end_date')->nullable()->after('start_date');
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['budget_period', 'start_date', 'end_date']);
        });
    }
};
