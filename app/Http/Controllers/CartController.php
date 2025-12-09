<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Cart; // Assuming you are using a package like "gloudemans/shoppingcart"

class CartController extends Controller
{
    // Display the cart
    public function index()
    {
        // Get the content of the cart (using Cart package or your own custom logic)
        $cartItems = Cart::getContent();

        // Pass the cart items to the view
        return view('cart.index', compact('cartItems'));
    }

    // Add book to the cart
    public function addToCart($id)
    {
        // Find the book by ID
        $book = Book::findOrFail($id);

        // Add the book to the cart
        Cart::add([
            'id' => $book->id,
            'name' => $book->title,
            'price' => $book->price,  // Assuming the book model has a price attribute
            'quantity' => 1, // Default to 1 book added
            'attributes' => [
                'author' => $book->author,
                'image' => $book->image,
            ]
        ]);

        // Redirect back to the books page or wherever you want
        return redirect()->route('books.index')->with('success', 'Book added to cart!');
    }
}
