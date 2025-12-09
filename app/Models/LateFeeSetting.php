<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LateFeeSetting extends Model
{
    protected $fillable = [
        'daily_rate',
        'grace_period_days',
        'max_late_fee',
        'is_active',
    ];

    protected $casts = [
        'daily_rate' => 'decimal:2',
        'max_late_fee' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the active late fee settings
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first() ?? static::first();
    }

    /**
     * Calculate late fee for given days overdue
     */
    public function calculateLateFee(int $daysOverdue): float
    {
        if ($daysOverdue <= $this->grace_period_days) {
            return 0;
        }

        $daysToCharge = $daysOverdue - $this->grace_period_days;
        $fee = $daysToCharge * $this->daily_rate;

        if ($this->max_late_fee && $fee > $this->max_late_fee) {
            return (float) $this->max_late_fee;
        }

        return (float) $fee;
    }
}
