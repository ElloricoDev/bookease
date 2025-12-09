<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookEase • User Register</title>

  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <header class="user-header">
        <div class="nav-inner">

            <!-- BRAND -->
            <a href="{{ url('/user/home') }}" class="brand">BookEase</a>


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

<main>
    <section class="auth-card">
        <div class="auth-title">REGISTER</div>

        <!-- REGISTER FORM -->
        <form class="auth-form" method="POST" action="{{ route('register.perform') }}">
            @csrf

            <input type="text" name="name" placeholder="Full Name" required>


            <input type="email" name="email" placeholder="Email" required>

            <div class="password-field">
                <input type="password" name="password" placeholder="Password" minlength="6" required>
                <button type="button" class="toggle-pass">Show</button>
            </div>

            <div class="auth-links">
                <a href="{{ route('login') }}">Already have an account? Login here.</a>
            </div>

            <button type="submit" class="btn primary">Register</button>
        </form>
    </section>
</main>

<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
