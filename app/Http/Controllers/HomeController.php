<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\CartItem;
use App\Models\Reservation;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $userId = session('user_id');
        
        // Popular books (most borrowed in last 30 days)
        $popularBooks = Book::whereHas('borrowedBooks', function($query) {
            $query->where('borrowed_at', '>=', Carbon::now()->subDays(30));
        })
        ->withCount(['borrowedBooks' => function($query) {
            $query->where('borrowed_at', '>=', Carbon::now()->subDays(30));
        }])
        ->orderBy('borrowed_books_count', 'desc')
        ->limit(6)
        ->get();

        // If no popular books, get most borrowed overall
        if ($popularBooks->isEmpty()) {
            $popularBooks = Book::whereHas('borrowedBooks')
                ->withCount('borrowedBooks')
                ->orderBy('borrowed_books_count', 'desc')
                ->limit(6)
                ->get();
        }

        // If still empty, get available books
        if ($popularBooks->isEmpty()) {
            $popularBooks = Book::where('status', 'available')
                ->orderBy('created_at', 'desc')
                ->limit(6)
                ->get();
        }

        // Recently added books
        $recentBooks = Book::orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Featured books (available books with high popularity)
        $featuredBooks = Book::where('status', 'available')
            ->where('available_quantity', '>', 0)
            ->orderBy('popularity', 'desc')
            ->limit(4)
            ->get();

        // User statistics
        $userStats = [];
        if ($userId) {
            $userStats = [
                'borrowed_count' => BorrowedBook::where('user_id', $userId)
                    ->whereNull('returned_at')
                    ->count(),
                'overdue_count' => BorrowedBook::where('user_id', $userId)
                    ->whereNull('returned_at')
                    ->where('due_date', '<', Carbon::now())
                    ->count(),
                'reservations_count' => Reservation::where('user_id', $userId)
                    ->whereIn('status', ['pending', 'available'])
                    ->count(),
                'cart_count' => CartItem::where('user_id', $userId)
                    ->where('status', 'in-cart')
                    ->count(),
            ];
        }

        // Categories with book counts
        $categories = Book::selectRaw('category, COUNT(*) as count')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->limit(8)
            ->get();

        return view('user.home', compact(
            'popularBooks',
            'recentBooks',
            'featuredBooks',
            'userStats',
            'categories'
        ));
    }
}
