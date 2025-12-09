<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BorrowedBook;
use App\Models\Book;
use App\Models\User;
use App\Models\Payment;
use Carbon\Carbon;

class BorrowedBookSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $books = Book::all();

        if ($users->isEmpty() || $books->isEmpty()) {
            return;
        }

        // Create some active borrowings (not returned)
        for ($i = 0; $i < 8; $i++) {
            $user = $users->random();
            $book = $books->random();
            
            // Make sure book is available
            if ($book->available_quantity > 0) {
                $days = rand(7, 30);
                $borrowedAt = Carbon::now()->subDays(rand(1, $days));
                $dueDate = $borrowedAt->copy()->addDays($days);
                
                $borrowedBook = BorrowedBook::create([
                    'user_id' => $user->id,
                    'book_id' => $book->id,
                    'days' => $days,
                    'fee' => $book->rent_fee * $days,
                    'deposit' => $book->deposit,
                    'borrowed_at' => $borrowedAt,
                    'due_date' => $dueDate,
                    'payment_type' => 'cash',
                    'borrow_status' => $dueDate->isPast() ? 'overdue' : 'borrowed',
                    'late_fee' => $dueDate->isPast() ? rand(50, 200) : 0,
                    'max_renewals' => 2,
                    'renewal_count' => 0,
                ]);

                // Update book availability
                $book->available_quantity = max(0, $book->available_quantity - 1);
                if ($book->available_quantity == 0) {
                    $book->status = 'borrowed';
                }
                $book->save();

                // Create payment records
                Payment::create([
                    'user_id' => $user->id,
                    'borrowed_book_id' => $borrowedBook->id,
                    'type' => 'rent_fee',
                    'amount' => $borrowedBook->fee,
                    'method' => 'cash',
                    'status' => 'completed',
                ]);

                Payment::create([
                    'user_id' => $user->id,
                    'borrowed_book_id' => $borrowedBook->id,
                    'type' => 'deposit',
                    'amount' => $borrowedBook->deposit,
                    'method' => 'cash',
                    'status' => 'completed',
                ]);
            }
        }

        // Create some returned books (for history)
        for ($i = 0; $i < 15; $i++) {
            $user = $users->random();
            $book = $books->random();
            
            $days = rand(7, 30);
            $borrowedAt = Carbon::now()->subDays(rand(30, 90));
            $dueDate = $borrowedAt->copy()->addDays($days);
            $returnedAt = $dueDate->copy()->addDays(rand(-5, 10));
            
            $lateFee = 0;
            if ($returnedAt->gt($dueDate)) {
                $lateDays = $returnedAt->diffInDays($dueDate);
                $lateFee = $lateDays * 1.00; // $1 per day
            }

            $borrowedBook = BorrowedBook::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'days' => $days,
                'fee' => $book->rent_fee * $days,
                'deposit' => $book->deposit,
                'borrowed_at' => $borrowedAt,
                'due_date' => $dueDate,
                'returned_at' => $returnedAt,
                'payment_type' => 'cash',
                'borrow_status' => 'returned',
                'return_condition' => ['good', 'fair', 'good', 'good', 'fair'][rand(0, 4)],
                'late_fee' => $lateFee,
                'deposit_refunded' => true,
                'max_renewals' => 2,
                'renewal_count' => rand(0, 2),
            ]);

            // Create payment records
            Payment::create([
                'user_id' => $user->id,
                'borrowed_book_id' => $borrowedBook->id,
                'type' => 'rent_fee',
                'amount' => $borrowedBook->fee,
                'method' => 'cash',
                'status' => 'completed',
            ]);

            if ($lateFee > 0) {
                Payment::create([
                    'user_id' => $user->id,
                    'borrowed_book_id' => $borrowedBook->id,
                    'type' => 'late_fee',
                    'amount' => $lateFee,
                    'method' => 'cash',
                    'status' => 'completed',
                ]);
            }

            Payment::create([
                'user_id' => $user->id,
                'borrowed_book_id' => $borrowedBook->id,
                'type' => 'refund',
                'amount' => $borrowedBook->deposit,
                'method' => 'cash',
                'status' => 'completed',
                'notes' => 'Deposit refund for book return',
            ]);
        }
    }
}
