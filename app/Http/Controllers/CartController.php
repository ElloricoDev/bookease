<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\CartItem;

class CartController extends Controller
{
    // Display the cart
    public function index()
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Please login to view your cart.');
        }

        $cartItems = CartItem::where('user_id', $userId)
            ->where('status', 'in-cart')
            ->with('book')
            ->get();

        return view('user.cart', compact('cartItems'));
    }

    // Remove item from cart
    public function remove($id)
    {
        $userId = session('user_id');
        
        $cartItem = CartItem::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if ($cartItem) {
            $cartItem->delete();
            return redirect()->route('cart')->with('success', 'Item removed from cart.');
        }

        return redirect()->route('cart')->with('error', 'Item not found.');
    }

    // Update cart item (days, fee)
    public function update(Request $request, $id)
    {
        $userId = session('user_id');
        
        $request->validate([
            'days' => 'required|integer|min:1|max:365',
        ]);

        $cartItem = CartItem::where('id', $id)
            ->where('user_id', $userId)
            ->with('book')
            ->first();

        if (!$cartItem) {
            return redirect()->route('cart')->with('error', 'Item not found.');
        }

        $book = $cartItem->book;
        $days = $request->days;
        $fee = $book->rent_fee * $days;
        $deposit = $book->deposit ?? 0;

        $cartItem->update([
            'days' => $days,
            'fee' => $fee,
            'deposit' => $deposit,
        ]);

        return redirect()->route('cart')->with('success', 'Cart updated successfully.');
    }
}
