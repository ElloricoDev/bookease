<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'borrowed_book_id',
        'type',
        'amount',
        'method',
        'status',
        'transaction_id',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Get the user who made the payment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the borrowed book associated with payment
     */
    public function borrowedBook()
    {
        return $this->belongsTo(BorrowedBook::class);
    }
}
