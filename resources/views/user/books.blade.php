<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookEase • Books</title>
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
                <li><a href="{{ route('info') }}" class="profile-link">👤</a></li>
                <li><a href="{{ url('/logout') }}">Sign out</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="user-books-main">
    <div class="books-container">

        <!-- Toolbar -->
        <div class="books-toolbar">
            <button class="btn primary">Filter</button>
            <div class="sort-section">
                <span>Sort by: Popularity</span>
                <a href="{{ route('cart') }}" class="cart-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 
                        2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 1 
                        0 0 4 2 2 0 0 0 0-4zm-8 2a2 2 0 1 1-4 0 2 2 0 0 1 4 
                        0z" stroke="currentColor" stroke-width="2"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="cart-badge">{{ $cartCount ?? 0 }}</span>
                </a>
            </div>
        </div>

        <!-- Search -->
        <div class="books-search">
            <input type="search" placeholder="Search">
        </div>

        <!-- Books Grid -->
        <div class="books-grid-large">
           @foreach ($books as $book)
    <div class="book-item">
        <!-- Book Image -->
        <img src="{{ asset($book->image) }}" alt="{{ $book->title }}">

        <!-- Add to Cart Button -->
        <form action="{{ route('cart.add', $book->id) }}" method="POST">
    @csrf
    <button type="submit" class="add-to-cart-btn">+</button>
</form>


        <div class="book-item-info">
            <h4>{{ $book->title }}</h4>
            <p>{{ $book->author }}</p>
        </div>
    </div>
@endforeach

        </div>

        <!-- Pagination -->
        <div class="pagination">
            {{ $books->links() }}
        </div>

    </div>
</main>

<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
