<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BorrowedBook;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\CartItem;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Display the user profile page
     */
    public function index()
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Please login to view your profile.');
        }

        $user = User::findOrFail($userId);

        // Get user statistics
        $stats = [
            'total_borrowed' => BorrowedBook::where('user_id', $userId)->count(),
            'currently_borrowed' => BorrowedBook::where('user_id', $userId)
                ->whereNull('returned_at')
                ->count(),
            'total_returned' => BorrowedBook::where('user_id', $userId)
                ->whereNotNull('returned_at')
                ->count(),
            'overdue' => BorrowedBook::where('user_id', $userId)
                ->whereNull('returned_at')
                ->where('due_date', '<', Carbon::now())
                ->count(),
            'reservations' => Reservation::where('user_id', $userId)
                ->whereIn('status', ['pending', 'available'])
                ->count(),
            'total_payments' => Payment::where('user_id', $userId)
                ->where('status', 'completed')
                ->count(),
            'total_spent' => Payment::where('user_id', $userId)
                ->where('status', 'completed')
                ->whereIn('type', ['rent_fee', 'late_fee', 'deposit'])
                ->sum('amount'),
        ];

        return view('user.info', compact('user', 'stats'));
    }

    /**
     * Update user profile information
     */
    public function update(Request $request)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Please login to update your profile.');
        }

        $user = User::findOrFail($userId);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $userId,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update session
        Session::put('name', $user->name);
        Session::put('email', $user->email);

        return redirect()->route('info')->with('success', 'Profile updated successfully!');
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Please login to update your password.');
        }

        $user = User::findOrFail($userId);

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('info')->with('success', 'Password updated successfully!');
    }
}
