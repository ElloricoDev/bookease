<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    /**
     * Display payment history for the logged-in user
     */
    public function index()
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Please login to view payment history.');
        }

        $payments = Payment::where('user_id', $userId)
            ->with('borrowedBook.book')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $totalPaid = Payment::where('user_id', $userId)
            ->where('status', 'completed')
            ->whereIn('type', ['rent_fee', 'deposit', 'late_fee'])
            ->sum('amount');

        $totalRefunded = Payment::where('user_id', $userId)
            ->where('type', 'refund')
            ->where('status', 'completed')
            ->sum('amount');

        return view('user.payments', compact('payments', 'totalPaid', 'totalRefunded'));
    }
}
