<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowedBook;
use App\Models\Book;
use App\Models\LateFeeSetting;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Notification;
use Carbon\Carbon;

class ReturnController extends Controller
{
    /**
     * Show return form (for admin)
     */
    public function showReturnForm($id)
    {
        // Find the borrowed book with relationships
        $borrowedBook = BorrowedBook::with(['book', 'user'])->find($id);
        
        if (!$borrowedBook) {
            return redirect()->route('borrow_return')
                ->with('error', '❌ Borrowed book not found (ID: ' . $id . '). This book may have already been returned or does not exist. Please check the Borrow and Return page for active borrowings.');
        }

        // Check if already returned
        if ($borrowedBook->returned_at) {
            return redirect()->route('borrow_return')
                ->with('error', '❌ This book has already been returned on ' . $borrowedBook->returned_at->format('M d, Y') . '.');
        }

        // Check if relationships are loaded - reload if missing
        if (!$borrowedBook->book) {
            $borrowedBook->load('book');
            if (!$borrowedBook->book) {
                return redirect()->route('borrow_return')
                    ->with('error', '❌ Book information not found. Book ID: ' . ($borrowedBook->book_id ?? 'N/A') . '. Please contact support.');
            }
        }

        if (!$borrowedBook->user) {
            $borrowedBook->load('user');
            if (!$borrowedBook->user) {
                return redirect()->route('borrow_return')
                    ->with('error', '❌ User information not found. User ID: ' . ($borrowedBook->user_id ?? 'N/A') . '. Please contact support.');
            }
        }

        // Calculate late fee
        $lateFee = 0;
        if ($borrowedBook->due_date < Carbon::now()) {
            $daysOverdue = Carbon::now()->diffInDays($borrowedBook->due_date);
            $lateFeeSetting = LateFeeSetting::first();
            $dailyLateFee = $lateFeeSetting ? $lateFeeSetting->daily_late_fee : 1.00;
            $lateFee = $daysOverdue * $dailyLateFee;
        }

        return view('admin.return_form', compact('borrowedBook', 'lateFee'));
    }

    /**
     * Process return (for admin)
     */
    public function processReturn(Request $request, $id)
    {
        $request->validate([
            'return_condition' => 'required|in:good,damaged,lost',
            'notes' => 'nullable|string|max:500',
        ]);

        $borrowedBook = BorrowedBook::with(['book', 'user'])->findOrFail($id);

        if ($borrowedBook->returned_at) {
            return redirect()->route('borrow_return')
                ->with('error', 'This book has already been returned.');
        }

        $book = $borrowedBook->book;
        $returnDate = Carbon::now();
        $lateFee = 0;

        // Calculate late fee
        if ($borrowedBook->due_date < $returnDate) {
            $daysOverdue = $returnDate->diffInDays($borrowedBook->due_date);
            $lateFeeSetting = LateFeeSetting::first();
            $dailyLateFee = $lateFeeSetting ? $lateFeeSetting->daily_late_fee : 1.00;
            $lateFee = $daysOverdue * $dailyLateFee;
        }

        // Update borrowed book record
        $borrowedBook->update([
            'returned_at' => $returnDate,
            'return_condition' => $request->return_condition,
            'return_notes' => $request->notes,
            'borrow_status' => 'returned',
        ]);

        // Create notification for return
        Notification::create([
            'user_id' => $borrowedBook->user_id,
            'type' => 'return',
            'title' => 'Book Returned!',
            'message' => "You have returned '{$book->title}'. " . ($lateFee > 0 ? "A late fee of Php" . number_format($lateFee, 2) . " was applied." : "Thank you for returning on time!"),
            'link' => route('my.borrowed'),
        ]);

        // Create payment records
        if ($lateFee > 0) {
            Payment::create([
                'user_id' => $borrowedBook->user_id,
                'borrowed_book_id' => $borrowedBook->id,
                'type' => 'late_fee',
                'amount' => $lateFee,
                'status' => 'completed',
                'payment_date' => $returnDate,
            ]);
        }

        // Refund deposit if condition is good or damaged (not lost)
        if ($request->return_condition !== 'lost' && $borrowedBook->deposit > 0) {
            Payment::create([
                'user_id' => $borrowedBook->user_id,
                'borrowed_book_id' => $borrowedBook->id,
                'type' => 'refund',
                'amount' => $borrowedBook->deposit,
                'status' => 'completed',
                'payment_date' => $returnDate,
            ]);
        }

        // Update book availability
        if ($request->return_condition !== 'lost') {
            $book->available_quantity = min($book->quantity, $book->available_quantity + 1);
            if ($book->status === 'borrowed' && $book->available_quantity > 0) {
                $book->status = 'available';
            }
            $book->save();

            // Check for pending reservations and notify first in queue
            $pendingReservation = Reservation::where('book_id', $book->id)
                ->where('status', 'pending')
                ->orderBy('created_at', 'asc')
                ->first();

            if ($pendingReservation) {
                $pendingReservation->update([
                    'status' => 'available',
                    'notified_at' => Carbon::now(),
                    'expires_at' => Carbon::now()->addHours(48), // 48 hours to borrow
                ]);

                // Create notification for reservation availability
                Notification::create([
                    'user_id' => $pendingReservation->user_id,
                    'type' => 'reservation',
                    'title' => 'Book Available for Borrowing!',
                    'message' => "The book '{$book->title}' you reserved is now available. Please borrow it within 48 hours.",
                    'link' => route('my.reservations'),
                ]);
            }
        } else {
            // Book is lost, don't increase availability
            $book->available_quantity = max(0, $book->available_quantity - 1);
            if ($book->available_quantity <= 0) {
                $book->status = 'unavailable';
            }
            $book->save();
        }

        return redirect()->route('borrow_return')
            ->with('success', 'Book returned successfully! ' . ($lateFee > 0 ? 'Late fee of Php' . number_format($lateFee, 2) . ' applied.' : ''));
    }

    /**
     * Display user's borrowed books
     */
    public function myBorrowedBooks(Request $request)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Please login to view your borrowed books.');
        }

        $filter = $request->input('filter', 'active'); // active, overdue, returned, all

        // Currently borrowed books
        $borrowedQuery = BorrowedBook::where('user_id', $userId)
            ->whereNull('returned_at')
            ->with('book')
            ->orderBy('due_date', 'asc');

        // Apply filter
        if ($filter === 'overdue') {
            $borrowedQuery->where('due_date', '<', Carbon::now());
        }

        $borrowedBooks = $borrowedQuery->get();

        // Returned books history
        $returnedQuery = BorrowedBook::where('user_id', $userId)
            ->whereNotNull('returned_at')
            ->with('book')
            ->orderBy('returned_at', 'desc');

        $returnedBooks = $returnedQuery->paginate(10);

        // Statistics
        $stats = [
            'total_borrowed' => $borrowedBooks->count(),
            'overdue' => $borrowedBooks->filter(function($book) {
                return $book->isOverdue();
            })->count(),
            'due_soon' => $borrowedBooks->filter(function($book) {
                return !$book->isOverdue() && $book->due_date->diffInDays(Carbon::now()) <= 3;
            })->count(),
            'total_returned' => BorrowedBook::where('user_id', $userId)
                ->whereNotNull('returned_at')
                ->count(),
        ];

        return view('user.borrowed', compact('borrowedBooks', 'returnedBooks', 'stats', 'filter'));
    }
}
