<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Book;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Create a reservation for a book
     */
    public function store($bookId)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Please login to reserve books.');
        }

        $book = Book::findOrFail($bookId);

        // If book is available, user should borrow directly (no reservation)
        if ($book->isAvailable()) {
            return redirect()->back()->with('info', 'Book is available. You can borrow it directly.');
        }

        // If book is permanently unavailable (lost/removed), do not allow reservation
        if ($book->status === 'unavailable') {
            return redirect()->back()->with('error', 'This book is currently unavailable and cannot be reserved.');
        }

        // Check if user already has a pending reservation for this book
        $existingReservation = Reservation::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->whereIn('status', ['pending', 'available'])
            ->first();

        if ($existingReservation) {
            return redirect()->back()->with('info', 'You already have a reservation for this book.');
        }

        // Create reservation
        Reservation::create([
            'user_id' => $userId,
            'book_id' => $bookId,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Book reserved! You will be notified when it becomes available.');
    }

    /**
     * Cancel a reservation
     */
    public function cancel($id)
    {
        $userId = session('user_id');
        
        $reservation = Reservation::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();

        $reservation->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Reservation cancelled.');
    }

    /**
     * Fulfill a reservation (when book becomes available)
     */
    public function fulfill($id)
    {
        $reservation = Reservation::findOrFail($id);
        
        if ($reservation->status !== 'available') {
            return redirect()->back()->with('error', 'Reservation cannot be fulfilled.');
        }

        $reservation->update([
            'status' => 'fulfilled',
            'expires_at' => null,
        ]);

        return redirect()->back()->with('success', 'Reservation fulfilled.');
    }

    /**
     * Display user's reservations
     */
    public function index()
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Please login to view reservations.');
        }

        $reservations = Reservation::where('user_id', $userId)
            ->with('book')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('user.reservations', compact('reservations'));
    }
}
