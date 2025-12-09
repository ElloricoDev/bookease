<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserBooksController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;



Route::get('/users', [UserController::class, 'index'])->name('user_management');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');


Route::get('/user/books', [UserBooksController::class, 'index'])->name('books');

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{book}', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

Route::post('/borrow/confirm', [BorrowController::class, 'confirm'])->name('borrow.confirm');



Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.perform');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.perform');

// Logout
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Dashboard
Route::get('/admin/dashboard', function () {
    if(session('logged_in') && session('role') === 'admin') {
        return view('admin.dashboard');
    }
    return redirect('/login');
})->name('admin.dashboard');

// User Dashboard
Route::get('/user/dashboard', function () {
    if(session('logged_in') && session('role') === 'user') {
        return view('user.home');
    }
    return redirect('/login');
})->name('user.dashboard');





Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('user.home');
})->name('home');

/*Route::get('/books', function () {
    return view('user.books');
})->name('books');

Route::get('/cart', function () {
    return view('user.cart');
})->name('cart');

Route::get('/borrowed', function () {
    return view('user.borrowed');
});*/

Route::get('/info', function () {
    return view('user.info');
})->name('info');





Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');

/*Route::get('/user_management', function () {
    return view('admin.user_management');
})->name('user_management');*/

Route::get('/book_management', function () {
    return view('admin.book_management');
})->name('book_management');

Route::get('/borrow_return', function () {
    return view('admin.borrow_return');
})->name('borrow_return');

Route::get('/fines', function () {
    return view('admin.fines');
})->name('fines');

Route::get('/reports', function () {
    return view('admin.reports');
})->name('reports');

Route::get('/notifications', function () {
    return view('admin.notifications');
})->name('notifications');