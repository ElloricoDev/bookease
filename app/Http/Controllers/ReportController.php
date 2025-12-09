<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowedBook;
use App\Models\Book;
use App\Models\User;
use App\Models\Payment;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Get date range from request or use default (last 7 months)
        $startDate = $request->input('start_date', Carbon::now()->subMonths(6)->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $period = $request->input('period', '7months'); // 7months, 12months, year, custom

        // Adjust date range based on period
        if ($period === '7months') {
            $startDate = Carbon::now()->subMonths(6)->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        } elseif ($period === '12months') {
            $startDate = Carbon::now()->subMonths(11)->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        } elseif ($period === 'year') {
            $startDate = Carbon::now()->startOfYear()->format('Y-m-d');
            $endDate = Carbon::now()->endOfYear()->format('Y-m-d');
        }

        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        // Monthly borrowing statistics
        $monthlyBorrowings = [];
        $monthLabels = [];
        $current = $start->copy()->startOfMonth();
        
        while ($current <= $end) {
            $count = BorrowedBook::whereYear('borrowed_at', $current->year)
                ->whereMonth('borrowed_at', $current->month)
                ->count();
            $monthlyBorrowings[] = (int)$count;
            $monthLabels[] = $current->format('M Y');
            $current->addMonth();
        }

        // Overdue books trend (same months)
        $monthlyOverdue = [];
        $current = $start->copy()->startOfMonth();
        while ($current <= $end) {
            $count = BorrowedBook::whereNull('returned_at')
                ->whereYear('due_date', $current->year)
                ->whereMonth('due_date', $current->month)
                ->where('due_date', '<', Carbon::now())
                ->count();
            $monthlyOverdue[] = (int)$count;
            $current->addMonth();
        }

        // Active users trend (same months)
        $monthlyActiveUsers = [];
        $current = $start->copy()->startOfMonth();
        while ($current <= $end) {
            $count = BorrowedBook::whereYear('borrowed_at', $current->year)
                ->whereMonth('borrowed_at', $current->month)
                ->distinct('user_id')
                ->count('user_id');
            $monthlyActiveUsers[] = (int)$count;
            $current->addMonth();
        }

        // Revenue trend (same months)
        $monthlyRevenue = [];
        $current = $start->copy()->startOfMonth();
        while ($current <= $end) {
            $revenue = Payment::where('type', 'rent_fee')
                ->where('status', 'completed')
                ->whereYear('created_at', $current->year)
                ->whereMonth('created_at', $current->month)
                ->sum('amount');
            $monthlyRevenue[] = (float)$revenue;
            $current->addMonth();
        }
        
        // Ensure all arrays have the same length
        $maxLength = max(count($monthlyBorrowings), count($monthlyOverdue), count($monthlyActiveUsers), count($monthlyRevenue));
        while (count($monthlyBorrowings) < $maxLength) $monthlyBorrowings[] = 0;
        while (count($monthlyOverdue) < $maxLength) $monthlyOverdue[] = 0;
        while (count($monthlyActiveUsers) < $maxLength) $monthlyActiveUsers[] = 0;
        while (count($monthlyRevenue) < $maxLength) $monthlyRevenue[] = 0;

        // Total statistics
        $totalBorrowings = BorrowedBook::count();
        $totalReturns = BorrowedBook::whereNotNull('returned_at')->count();
        $totalRevenue = Payment::where('type', 'rent_fee')
            ->where('status', 'completed')
            ->sum('amount');
        $totalLateFees = Payment::where('type', 'late_fee')
            ->where('status', 'completed')
            ->sum('amount');
        
        // Additional statistics
        $activeBorrowings = BorrowedBook::whereNull('returned_at')->count();
        $overdueCount = BorrowedBook::whereNull('returned_at')
            ->where('due_date', '<', Carbon::now())
            ->count();
        $totalUsers = User::where('role', 'user')->count();
        $totalBooks = Book::count();

        // Top 5 most borrowed books
        $topBooks = BorrowedBook::selectRaw('book_id, COUNT(*) as borrow_count')
            ->with('book')
            ->groupBy('book_id')
            ->orderBy('borrow_count', 'desc')
            ->limit(5)
            ->get();

        // Top 5 most active users
        $topUsers = BorrowedBook::selectRaw('user_id, COUNT(*) as borrow_count')
            ->with('user')
            ->groupBy('user_id')
            ->orderBy('borrow_count', 'desc')
            ->limit(5)
            ->get();

        // Revenue by type
        $revenueByType = [
            'rent_fee' => Payment::where('type', 'rent_fee')
                ->where('status', 'completed')
                ->sum('amount'),
            'late_fee' => Payment::where('type', 'late_fee')
                ->where('status', 'completed')
                ->sum('amount'),
            'deposit' => Payment::where('type', 'deposit')
                ->where('status', 'completed')
                ->sum('amount'),
        ];

        return view('admin.reports', compact(
            'monthlyBorrowings',
            'monthlyOverdue',
            'monthlyActiveUsers',
            'monthlyRevenue',
            'monthLabels',
            'totalBorrowings',
            'totalReturns',
            'totalRevenue',
            'totalLateFees',
            'activeBorrowings',
            'overdueCount',
            'totalUsers',
            'totalBooks',
            'topBooks',
            'topUsers',
            'revenueByType',
            'startDate',
            'endDate',
            'period'
        ));
    }
}
