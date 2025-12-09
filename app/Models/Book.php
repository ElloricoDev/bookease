<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'category',
        'publisher',
        'publication_year',
        'description',
        'language',
        'condition',
        'image',
        'popularity',
        'rent_fee',
        'deposit',
        'quantity',
        'available_quantity',
        'status',
    ];

    /**
     * Check if book is available for borrowing
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available' && $this->available_quantity > 0;
    }

    /**
     * Get borrowed books relationship
     */
    public function borrowedBooks()
    {
        return $this->hasMany(BorrowedBook::class);
    }

    /**
     * Get active borrowed books (not returned)
     */
    public function activeBorrows()
    {
        return $this->borrowedBooks()->whereNull('returned_at');
    }

    /**
     * Get reservations for this book
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Get pending reservations
     */
    public function pendingReservations()
    {
        return $this->reservations()->where('status', 'pending');
    }
}
