<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\CartItem;

class BookController extends Controller
{
    /**
     * Display a single book's details
     */
    public function show($id)
    {
        $book = Book::findOrFail($id);
        
        $userId = session('user_id');
        $cartCount = $userId ? CartItem::where('user_id', $userId)->where('status', 'in-cart')->count() : 0;
        
        // Check if book is already in cart
        $inCart = false;
        if ($userId) {
            $inCart = CartItem::where('user_id', $userId)
                ->where('book_id', $book->id)
                ->where('status', 'in-cart')
                ->exists();
        }

        // Get related books (same category)
        $relatedBooks = Book::where('category', $book->category)
            ->where('id', '!=', $book->id)
            ->where('status', 'available')
            ->limit(4)
            ->get();

        return view('user.book_detail', compact('book', 'cartCount', 'inCart', 'relatedBooks'));
    }
}
