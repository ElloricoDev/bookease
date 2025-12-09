<!-- resources/views/user-borrowed.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookEase • My Borrowed Books</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="user-page">
    <header class="user-header-light">
        <div class="nav-inner">
            <a href="{{ url('/') }}" class="brand">BookEase</a>
            <nav>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ url('/books') }}">Books</a></li>
                    <li><a href="#">About us</a></li>
                    <li><a href="#">Contact us</a></li>
                    <li><a href="{{ route('info') }}" class="profile-link" title="Account Settings">👤</a></li>
                    <li>
                        <form method="POST" action="#">
                            @csrf
                             <a href="{{ url('/logout') }}" class="logout-link" id="userHeaderLogoutBtn">Sign out</a>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="user-borrowed-main">
        <div class="borrowed-container">
            <h2 class="borrowed-title">My Borrowed Books</h2>
            
            <div class="borrowed-table-wrap">
                <table class="borrowed-table" id="borrowedTable">
                    <thead>
                        <tr>
                            <th>Book Title</th>
                            <th>Due Date</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>The Great Gatsby</td>
                            <td>Jan 15, 2026</td>
                            <td>
                                <form method="POST" action="#">
                                    @csrf
                                    <button class="icon-btn" type="submit">🗑️</button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>Hunger Games</td>
                            <td>Jan 15, 2026</td>
                            <td>
                                <form method="POST" action="#">
                                    @csrf
                                    <button class="icon-btn" type="submit">🗑️</button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>1984</td>
                            <td>Feb 22, 2026</td>
                            <td>
                                <form method="POST" action="#">
                                    @csrf
                                    <button class="icon-btn" type="submit">🗑️</button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>Sapiens</td>
                            <td>Feb 22, 2026</td>
                            <td>
                                <form method="POST" action="#">
                                    @csrf
                                    <button class="icon-btn" type="submit">🗑️</button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>Harry Potter</td>
                            <td>Feb 22, 2026</td>
                            <td>
                                <form method="POST" action="#">
                                    @csrf
                                    <button class="icon-btn" type="submit">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
