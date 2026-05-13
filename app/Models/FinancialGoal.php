<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FinancialGoal extends Model
{
    protected $fillable = [
        'user_id', 
        'goal_name', 
        'target_amount', 
        'current_amount', 
        'filling_plan',      // DAILY, WEEKLY, MONTHLY
        'amount_per_period', // Jumlah menabung per periode
        'start_date', 
        'target_date',      // Tanggal ekspektasi tercapai
    ];

    // Kolom virtual tambahan untuk dikirim ke React
    protected $appends = [
        'progress_percentage', 
        'remaining_amount', 
        'estimated_days_left',
        'time_remaining_human'
    ];

    /**
     * Menghitung % Progres (untuk Progress Bar & Donut Chart)
     */
    public function getProgressPercentageAttribute()
    {
        if ($this->target_amount <= 0) return 0;
        $percentage = ($this->current_amount / $this->target_amount) * 100;
        return round($percentage > 100 ? 100 : $percentage, 1);
    }

    /**
     * Menghitung sisa uang yang masih kurang (Target - Terkumpul)
     */
    public function getRemainingAmountAttribute()
    {
        $remaining = $this->target_amount - $this->current_amount;
        return $remaining < 0 ? 0 : (float) $remaining;
    }

    /**
     * Menghitung sisa hari secara matematis berdasarkan rencana menabung
     */
    public function getEstimatedDaysLeftAttribute()
    {
        if ($this->amount_per_period <= 0 || $this->remaining_amount <= 0) return 0;

        // Hitung berapa kali lagi harus menabung
        $periodsNeeded = ceil($this->remaining_amount / $this->amount_per_period);

        // Konversi ke hari berdasarkan filling_plan
        return match ($this->filling_plan) {
            'DAILY'   => $periodsNeeded,
            'WEEKLY'  => $periodsNeeded * 7,
            'MONTHLY' => $periodsNeeded * 30,
            default   => $periodsNeeded * 30,
        };
    }

    /**
     * Mengonversi sisa hari ke bahasa manusia (cth: "5 Months Left")
     * Ini sangat berguna untuk label di bawah progress bar di React
     */
    public function getTimeRemainingHumanAttribute()
    {
        if ($this->remaining_amount <= 0) return "Goal Achieved!";
        
        $days = $this->estimated_days_left;

        if ($days >= 30) {
            $months = ceil($days / 30);
            return $months . " Months Left";
        }

        return $days . " Days Left";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}