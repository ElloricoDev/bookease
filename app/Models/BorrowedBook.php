<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BorrowedBook extends Model
{
    protected $fillable = [
        'user_id', 'book_id', 'days', 'fee', 'deposit',
        'borrowed_at', 'due_date', 'returned_at',
        'late_fee', 'payment_type', 'borrow_status',
        'return_condition', 'return_notes', 'deposit_refunded',
        'renewal_count', 'max_renewals'
    ];

    protected $casts = [
        'borrowed_at' => 'date',
        'due_date' => 'date',
        'returned_at' => 'date',
    ];

    /**
     * Get the user that borrowed the book
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that was borrowed
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Check if the book is overdue
     */
    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date->isPast() && !$this->returned_at;
    }

    /**
     * Calculate days overdue
     */
    public function daysOverdue(): int
    {
        if (!$this->isOverdue()) {
            return 0;
        }
        return (int)Carbon::now()->diffInDays($this->due_date, false);
    }

    /**
     * Calculate days until due date
     */
    public function daysUntilDue(): int
    {
        if ($this->isOverdue() || $this->returned_at) {
            return 0;
        }
        $now = Carbon::now();
        $due = Carbon::parse($this->due_date);
        if ($due->isFuture()) {
            return (int)$now->diffInDays($due, false);
        }
        return 0;
    }

    /**
     * Check if book can be renewed
     */
    public function canBeRenewed(): bool
    {
        return !$this->returned_at 
            && $this->renewal_count < $this->max_renewals
            && !$this->isOverdue();
    }

    /**
     * Get payments for this borrowed book
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
