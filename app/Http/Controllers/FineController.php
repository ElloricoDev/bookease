<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\BorrowedBook;

class FineController extends Controller
{
    /**
     * Display a listing of fines (late fees)
     */
    public function index()
    {
        $fines = Payment::where('type', 'late_fee')
            ->with(['user', 'borrowedBook.book'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.fines', compact('fines'));
    }

    /**
     * Remove the specified fine (payment record)
     */
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        
        // Only allow deletion of late_fee payments
        if ($payment->type !== 'late_fee') {
            return redirect()->route('fines')
                ->with('error', 'Only late fee payments can be deleted from this page.');
        }

        $payment->delete();

        return redirect()->route('fines')
            ->with('success', 'Fine record deleted successfully!');
    }
}
