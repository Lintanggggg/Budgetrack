<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingsGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'goal_name',
        'target_amount',
        'current_amount',
        'target_date',
    ];

    protected $casts = [
        'target_date' => 'date',
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper: hitung persentase progress
    public function getProgressPercentageAttribute(): float
    {
        if ($this->target_amount <= 0) return 0;
        $percent = ($this->current_amount / $this->target_amount) * 100;
        return min(round($percent, 1), 100);
    }
}