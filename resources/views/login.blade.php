<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookEase • User Login</title>

  <!-- Load your CSS -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

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

<main>
  <section class="auth-card">
    <div class="auth-logo">
      <svg class="logo-mark" width="56" height="56" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <rect x="3" y="3" width="14" height="18" rx="2" ry="2" fill="#4CAF50"/>
        <path d="M7 7h6M7 10h6M7 13h6" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"/>
        <path d="M17 5c1.105 0 2 .895 2 2v11c-1.143-.762-2.857-.762-4 0V7c0-1.105.895-2 2-2Z" fill="#2e7d32"/>
      </svg>
      <h1>User Login</h1>
    </div>

    <form class="auth-form" id="userLoginForm" method="POST" action="">
      @csrf

      <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">

      <div class="password-field">
        <input type="password" name="password" placeholder="Password" minlength="6" required>
        <button type="button" class="toggle-pass" aria-label="Show password">Show</button>
      </div>

      <div class="auth-links">
        <a href="">Forgot password?</a>
      </div>

      <button type="submit" class="btn primary">Log in</button>
      <a class="btn" href="{{ route('register')}}">Sign-up</a>
    </form>
  </section>
</main>

<!-- Load your JS -->
<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
