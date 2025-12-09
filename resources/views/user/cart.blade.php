<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookEase • Cart</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="user-page">

<header class="user-header-light">
    <div class="nav-inner">
        <a href="{{ url('/user/home') }}" class="brand">BookEase</a>
        <nav>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ url('/user/books') }}">Books</a></li>
                <li><a href="#">About us</a></li>
                <li><a href="#">Contact us</a></li>
                <li><a href="{{ route('info') }}">👤</a></li>
                <li><a href="{{ url('/logout') }}">Sign out</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="user-cart-main">
    <div class="cart-container">

        <h2>Your Cart</h2>

        @if ($cartItems->isEmpty())
            <p>Your cart is empty.</p>
        @endif

        @foreach ($cartItems as $item)
        <div class="cart-item">

            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="remove-item-btn">🗑️</button>
            </form>

            <img src="{{ $item->book->image }}" alt="{{ $item->book->title }}">

            <div class="cart-item-details">
                <h3>{{ $item->book->title }}</h3>
                <p>{{ $item->book->author }}</p>
            </div>

        </div>
        @endforeach

        @if ($cartItems->isNotEmpty())
        <div class="borrowing-details">

            <div class="detail-row">
                <label>Days want to borrow:</label>
                <span>{{ $cartItems->first()->days }} days</span>
            </div>

            <div class="detail-row">
                <span>Borrowing fee:</span>
                <span>Php{{ number_format($cartItems->sum('fee'), 2) }}</span>
            </div>

            <div class="detail-row">
                <span><strong>Total:</strong></span>
                <span><strong>
                    Php{{ number_format($cartItems->sum('fee') + $cartItems->sum('deposit'), 2) }}
                </strong></span>
            </div>

            <form action="{{ route('borrow.confirm') }}" method="POST">
                @csrf
                <button class="btn primary">Proceed to Borrow</button>
            </form>

        </div>
        @endif

    </div>
</main>

<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
