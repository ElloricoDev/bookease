<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookEase • Home</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="user-page">

    <!-- HEADER -->
    <header class="user-header">
        <div class="nav-inner">

            <!-- BRAND -->
            <a href="{{ url('/user/home') }}" class="brand">BookEase</a>

            <!-- HEADER SEARCH -->
            <div class="header-search">
                <input type="search" placeholder="Search" id="headerSearch">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2"/>
                    <path d="m21 21-4.35-4.35" stroke="currentColor"
                          stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>

            <!-- NAVIGATION -->
            <nav>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ url('/user/books') }}">Books</a></li>
                    <li><a href="#">About us</a></li>
                    <li><a href="#">Contact us</a></li>
                    <li><a href="{{ route('info') }}" class="profile-link" title="Account Settings">👤</a></li>
                    <li>
                        <a href="{{ url('/logout') }}"
                           class="logout-link"
                           id="userHeaderLogoutBtn"
                           title="Sign out">
                           Sign out
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="user-main">

        <!-- WELCOME BANNER -->
        <section class="welcome-banner">
            <h1>Welcome to BookEase!</h1>
            <p>Find It. Borrow it. Love it.</p>
        </section>

        <!-- POPULAR BOOKS -->
        <section class="popular-books">
            <h2>Popular this week:</h2>

            <div class="books-grid">

                <!-- Book 1 -->
                <div class="book-card">
                    <img src="https://m.media-amazon.com/images/I/81qk21S0qVL._AC_UF1000,1000_QL80_.jpg"
                         alt="Crime and Punishment">

                    <div class="book-info">
                        <h3>CRIME AND PUNISHMENT</h3>
                        <p>Fyodor Dostoevsky</p>
                    </div>
                </div>

                <!-- Book 2 -->
                <div class="book-card">
                    <img src="https://covers.openlibrary.org/b/isbn/9780547928227-L.jpg"
                         alt="The Hobbit"
                         onerror="this.src='https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1546071216i/5907.jpg'">

                    <div class="book-info">
                        <h3>THE HOBBIT</h3>
                        <p>J.R.R. Tolkien</p>
                        <p class="edition">75th Anniversary Edition</p>
                    </div>
                </div>

                <!-- Book 3 -->
                <div class="book-card">
                    <img src="https://covers.openlibrary.org/b/isbn/9780143039693-L.jpg"
                         alt="Noli Me Tangere"
                         onerror="this.src='https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1327942880i/112493.jpg'">

                    <div class="book-info">
                        <h3>NOLI ME TANGERE</h3>
                        <p>José Rizal</p>
                    </div>
                </div>

            </div>

            <a href="{{ route('books') }}" class="discover-link">
                Discover more books here &gt;&gt;&gt;
            </a>
        </section>

    </main>

    <!-- JS -->
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
