<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\CartItem;
use Illuminate\Support\Facades\Session;

class UserBooksController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        // Search functionality
        if ($request->q) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('author', 'like', '%' . $searchTerm . '%')
                  ->orWhere('isbn', 'like', '%' . $searchTerm . '%')
                  ->orWhere('category', 'like', '%' . $searchTerm . '%');
            });
        }

        // Category filter
        if ($request->category) {
            $query->where('category', $request->category);
        }

        // Availability filter
        if ($request->availability) {
            if ($request->availability === 'available') {
                $query->where('status', 'available')->where('available_quantity', '>', 0);
            } elseif ($request->availability === 'unavailable') {
                $query->where(function($q) {
                    $q->where('status', '!=', 'available')
                      ->orWhere('available_quantity', '<=', 0);
                });
            }
        }

        // Sort functionality
        $sortBy = $request->sort ?? 'popularity';
        switch ($sortBy) {
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'author_asc':
                $query->orderBy('author', 'asc');
                break;
            case 'author_desc':
                $query->orderBy('author', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'price_low':
                $query->orderBy('rent_fee', 'asc');
                break;
            case 'price_high':
                $query->orderBy('rent_fee', 'desc');
                break;
            default:
                $query->orderBy('popularity', 'desc');
        }

        $books = $query->paginate(12)->withQueryString();

        $userId = session('user_id');
        $cartCount = $userId ? CartItem::where('user_id', $userId)->where('status', 'in-cart')->count() : 0;

        // Get all categories for filter
        $categories = Book::selectRaw('category, COUNT(*) as count')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->get();

        return view('user.books', compact('books', 'cartCount', 'categories'));
    }

    public function addToCart(Request $request, $id)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Please login to add items to cart.');
        }

        $book = Book::findOrFail($id);

        // Check if book is available
        if (!$book->isAvailable()) {
            return redirect()->back()->with('error', $book->title . ' is not available for borrowing.');
        }

        // Check if item already exists in cart
        $existingItem = CartItem::where('user_id', $userId)
            ->where('book_id', $book->id)
            ->where('status', 'in-cart')
            ->first();

        if ($existingItem) {
            return redirect()->back()->with('info', $book->title . ' is already in your cart.');
        }

        // Create cart item
        CartItem::create([
            'user_id' => $userId,
            'book_id' => $book->id,
            'days' => 1, // Default days
            'fee' => $book->rent_fee ?? 0,
            'deposit' => $book->deposit ?? 0,
            'status' => 'in-cart'
        ]);

        return redirect()->back()->with('success', $book->title . ' added to cart!');
    }
}
