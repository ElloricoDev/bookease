<?php

namespace App\Http\Controllers;

use App\Models\BorrowedBook;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BorrowController extends Controller
{
    public function confirm()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->get();

        foreach ($cartItems as $item) {

            BorrowedBook::create([
                'user_id' => Auth::id(),
                'book_id' => $item->book_id,
                'days' => $item->days,
                'fee' => $item->fee,
                'deposit' => $item->deposit,

                'borrowed_at' => Carbon::now(),
                'due_date' => Carbon::now()->addDays($item->days),

                'payment_type' => 'cash'
            ]);

            $item->delete();
        }

        return redirect()->route('cart')->with('success', 'Borrowing complete!');
    }
}
