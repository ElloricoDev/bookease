<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $books = Book::where('available_quantity', 0)->get();

        if ($users->isEmpty() || $books->isEmpty()) {
            return;
        }

        // Create some pending reservations
        for ($i = 0; $i < 5; $i++) {
            $user = $users->random();
            $book = $books->random();

            Reservation::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'status' => 'pending',
            ]);
        }

        // Create some available reservations (books that just became available)
        for ($i = 0; $i < 2; $i++) {
            $user = $users->random();
            $book = $books->random();

            Reservation::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'status' => 'available',
                'notified_at' => Carbon::now()->subHours(rand(1, 12)),
                'expires_at' => Carbon::now()->addHours(rand(24, 48)),
            ]);
        }
    }
}
