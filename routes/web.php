<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserBooksController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;

// Public routes (no authentication required)
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.perform');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.perform');

// Logout (accessible to all authenticated users)
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin routes (admin only)
Route::middleware(['auth.check', 'role.check:admin'])->group(function () {
    Route::get('/admin/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('user_management');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/book_management', [\App\Http\Controllers\BookController::class, 'index'])->name('book_management');
    Route::get('/books/create', [\App\Http\Controllers\BookController::class, 'create'])->name('books.create');
    Route::post('/books', [\App\Http\Controllers\BookController::class, 'store'])->name('books.store');
    Route::get('/books/{id}/edit', [\App\Http\Controllers\BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{id}', [\App\Http\Controllers\BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{id}', [\App\Http\Controllers\BookController::class, 'destroy'])->name('books.destroy');

    Route::get('/borrow_return', function () {
        $borrowedBooks = \App\Models\BorrowedBook::whereNull('returned_at')
            ->with(['book', 'user'])
            ->orderBy('due_date', 'asc')
            ->get();
        return view('admin.borrow_return', compact('borrowedBooks'));
    })->name('borrow_return');

    Route::post('/borrow/{id}/approve', [BorrowController::class, 'approve'])->name('borrow.approve');

    Route::get('/return/{id}', [\App\Http\Controllers\ReturnController::class, 'showReturnForm'])->name('return.show');
    Route::post('/return/{id}', [\App\Http\Controllers\ReturnController::class, 'processReturn'])->name('return.process');

    Route::get('/fines', [\App\Http\Controllers\FineController::class, 'index'])->name('fines');
    Route::delete('/fines/{id}', [\App\Http\Controllers\FineController::class, 'destroy'])->name('fines.destroy');

    Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports');

    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('/notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/notifications/read/all', [\App\Http\Controllers\NotificationController::class, 'deleteAllRead'])->name('notifications.delete-read');

    Route::get('/contact-messages', [\App\Http\Controllers\Admin\ContactMessageController::class, 'index'])->name('admin.contact_messages');
    Route::get('/contact-messages/{id}', [\App\Http\Controllers\Admin\ContactMessageController::class, 'show'])->name('admin.contact_messages.show');
    Route::put('/contact-messages/{id}/status', [\App\Http\Controllers\Admin\ContactMessageController::class, 'updateStatus'])->name('admin.contact_messages.update_status');
    Route::delete('/contact-messages/{id}', [\App\Http\Controllers\Admin\ContactMessageController::class, 'destroy'])->name('admin.contact_messages.destroy');

    // Admin Profile
    Route::get('/admin/info', [\App\Http\Controllers\ProfileController::class, 'adminIndex'])->name('admin.info');
    Route::put('/admin/info/update', [\App\Http\Controllers\ProfileController::class, 'update'])->name('admin.info.update');
    Route::put('/admin/info/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('admin.info.password');
});

// User routes (user only)
Route::middleware(['auth.check', 'role.check:user'])->group(function () {
    Route::get('/user/dashboard', [\App\Http\Controllers\HomeController::class, 'index'])->name('user.dashboard');

    Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/user/books', [UserBooksController::class, 'index'])->name('books');
    Route::get('/user/books/{id}', [\App\Http\Controllers\BookController::class, 'show'])->name('books.show');
    Route::post('/cart/add/{book}', [UserBooksController::class, 'addToCart'])->name('cart.add');

    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    Route::post('/borrow/confirm', [BorrowController::class, 'confirm'])->name('borrow.confirm');

    Route::get('/my-borrowed-books', [\App\Http\Controllers\ReturnController::class, 'myBorrowedBooks'])->name('my.borrowed');

    Route::post('/renew/{id}', [\App\Http\Controllers\RenewalController::class, 'renew'])->name('renew');

    Route::get('/my-reservations', [\App\Http\Controllers\ReservationController::class, 'index'])->name('my.reservations');
    Route::post('/reserve/{book}', [\App\Http\Controllers\ReservationController::class, 'store'])->name('reserve');
    Route::delete('/reserve/{id}', [\App\Http\Controllers\ReservationController::class, 'cancel'])->name('reserve.cancel');

    Route::get('/payment-history', [\App\Http\Controllers\PaymentController::class, 'index'])->name('payment.history');

    Route::get('/info', [\App\Http\Controllers\ProfileController::class, 'index'])->name('info');
    Route::put('/info/update', [\App\Http\Controllers\ProfileController::class, 'update'])->name('info.update');
    Route::put('/info/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('info.password');

    Route::get('/about', [\App\Http\Controllers\AboutController::class, 'index'])->name('about');
    Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'index'])->name('contact');
    Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');
    
    Route::get('/search/suggestions', [\App\Http\Controllers\SearchController::class, 'suggestions'])->name('search.suggestions');
});
