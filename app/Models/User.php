<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Get borrowed books for this user
     */
    public function borrowedBooks()
    {
        return $this->hasMany(BorrowedBook::class);
    }

    /**
     * Get active borrowings (not returned)
     */
    public function activeBorrowings()
    {
        return $this->borrowedBooks()->whereNull('returned_at');
    }

    /**
     * Get reservations for this user
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Get payments for this user
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
