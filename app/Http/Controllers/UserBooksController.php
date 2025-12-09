<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Session;

class UserBooksController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->q) {
            $query->where('title', 'like', '%' . $request->q . '%')
                  ->orWhere('author', 'like', '%' . $request->q . '%');
        }

        $books = $query->orderBy('popularity', 'desc')->paginate(12);

        $cartCount = session('cart') ? count(session('cart')) : 0;

        return view('user.books', compact('books', 'cartCount'));
    }

    public function addToCart(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $cart = session('cart', []);
        $cart[$id] = $book;
        session(['cart' => $cart]);

        return redirect()->back()->with('success', $book->title . ' added to cart!');
    }
}
