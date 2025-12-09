<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    protected $fillable = [
        'type',
        'title',
        'message',
        'user_id',
        'book_id',
        'borrowed_book_id',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Get the user associated with the notification
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book associated with the notification
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the borrowed book associated with the notification
     */
    public function borrowedBook()
    {
        return $this->belongsTo(BorrowedBook::class);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => Carbon::now(),
        ]);
    }

    /**
     * Get icon based on notification type
     */
    public function getIconAttribute()
    {
        return match($this->type) {
            'borrow' => 'fa-book',
            'return' => 'fa-rotate-left',
            'overdue' => 'fa-exclamation-triangle',
            'reservation' => 'fa-bookmark',
            'payment' => 'fa-dollar-sign',
            'system' => 'fa-info-circle',
            default => 'fa-bell',
        };
    }

    /**
     * Get color class based on notification type
     */
    public function getColorClassAttribute()
    {
        return match($this->type) {
            'borrow' => 'primary',
            'return' => 'success',
            'overdue' => 'danger',
            'reservation' => 'warning',
            'payment' => 'info',
            'system' => 'secondary',
            default => 'secondary',
        };
    }

    /**
     * Create a notification
     */
    public static function createNotification($type, $title, $message, $userId = null, $bookId = null, $borrowedBookId = null)
    {
        return self::create([
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'user_id' => $userId,
            'book_id' => $bookId,
            'borrowed_book_id' => $borrowedBookId,
            'is_read' => false,
        ]);
    }
}
