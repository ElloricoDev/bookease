<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowedBook;
use App\Models\Reservation;
use Carbon\Carbon;

class RenewalController extends Controller
{
    /**
     * Renew a borrowed book
     */
    public function renew($id)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Please login to renew books.');
        }

        $borrowedBook = BorrowedBook::where('id', $id)
            ->where('user_id', $userId)
            ->whereNull('returned_at')
            ->firstOrFail();

        // Check if book can be renewed
        if (!$borrowedBook->canBeRenewed()) {
            $reason = $borrowedBook->isOverdue() 
                ? 'Overdue books cannot be renewed.' 
                : 'Maximum renewals reached.';
            return redirect()->back()->with('error', $reason);
        }

        // Check if book has pending reservations
        $hasReservations = Reservation::where('book_id', $borrowedBook->book_id)
            ->where('status', 'pending')
            ->exists();

        if ($hasReservations) {
            return redirect()->back()->with('error', 'This book has pending reservations and cannot be renewed.');
        }

        // Renew the book
        $borrowedBook->renewal_count += 1;
        $borrowedBook->due_date = Carbon::now()->addDays($borrowedBook->days);
        $borrowedBook->save();

        return redirect()->back()->with('success', 'Book renewed successfully! New due date: ' . $borrowedBook->due_date->format('M d, Y'));
    }
}
