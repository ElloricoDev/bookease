<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowedBook extends Model
{
    protected $fillable = [
        'user_id', 'book_id', 'days', 'fee', 'deposit',
        'borrowed_at', 'due_date', 'returned_at',
        'late_fee', 'payment_type'
    ];
}
