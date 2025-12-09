<?php

namespace App\Http\Controllers;

use App\Models\BorrowedBook;
use App\Models\CartItem;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Notification;
use Carbon\Carbon;

class BorrowController extends Controller
{
    public function confirm()
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Please login to continue.');
        }

        $cartItems = CartItem::where('user_id', $userId)
            ->where('status', 'in-cart')
            ->with('book')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        // Check availability before processing
        foreach ($cartItems as $item) {
            $book = $item->book;
            if (!$book->isAvailable()) {
                return redirect()->route('cart')->with('error', $book->title . ' is no longer available. Please remove it from your cart.');
            }
        }

        // Process each cart item
        foreach ($cartItems as $item) {
            $book = $item->book;
            
            // Check if this is a fulfilled reservation
            $reservation = Reservation::where('user_id', $userId)
                ->where('book_id', $item->book_id)
                ->where('status', 'available')
                ->first();

            // Create borrowed book record
            $borrowedBook = BorrowedBook::create([
                'user_id' => $userId,
                'book_id' => $item->book_id,
                'days' => $item->days,
                'fee' => $item->fee,
                'deposit' => $item->deposit,
                'borrowed_at' => Carbon::now(),
                'due_date' => Carbon::now()->addDays($item->days),
                'payment_type' => 'cash',
                'borrow_status' => 'borrowed',
                'max_renewals' => 2,
            ]);

            // Create payment records
            Payment::create([
                'user_id' => $userId,
                'borrowed_book_id' => $borrowedBook->id,
                'type' => 'rent_fee',
                'amount' => $item->fee,
                'method' => 'cash',
                'status' => 'completed',
            ]);

            Payment::create([
                'user_id' => $userId,
                'borrowed_book_id' => $borrowedBook->id,
                'type' => 'deposit',
                'amount' => $item->deposit,
                'method' => 'cash',
                'status' => 'completed',
            ]);

            // Mark reservation as fulfilled if exists
            if ($reservation) {
                $reservation->update(['status' => 'fulfilled']);
            }

            // Update book availability
            $book->available_quantity = max(0, $book->available_quantity - 1);
            if ($book->available_quantity == 0) {
                $book->status = 'borrowed';
            }
            $book->save();

            // Create notification for admin
            Notification::createNotification(
                'borrow',
                'New Book Borrowed',
                $borrowedBook->user->name . ' borrowed "' . $book->title . '" (Due: ' . $borrowedBook->due_date->format('M d, Y') . ')',
                null, // Admin notification (no specific user)
                $book->id,
                $borrowedBook->id
            );

            // Delete cart item
            $item->delete();
        }

        return redirect()->route('cart')->with('success', 'Borrowing complete! You can view your borrowed books in "My Borrowed Books".');
    }
}
