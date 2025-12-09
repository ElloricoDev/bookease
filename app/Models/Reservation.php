<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'status',
        'notified_at',
        'expires_at',
    ];

    protected $casts = [
        'notified_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the user who made the reservation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the reserved book
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Check if reservation is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast() && $this->status === 'available';
    }

    /**
     * Check if reservation can be fulfilled
     */
    public function canBeFulfilled(): bool
    {
        return $this->status === 'available' && !$this->isExpired();
    }
}
