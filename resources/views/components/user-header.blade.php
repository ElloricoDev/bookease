<header class="user-header {{ $variant ?? '' }}">
    <div class="nav-inner">
        <!-- BRAND -->
        <a href="{{ session('logged_in') ? route('home') : route('login') }}" class="brand">
            <i class="fa-solid fa-book"></i> BookEase
        </a>

        <!-- HEADER SEARCH -->
        @if(session('logged_in') && ($showSearch ?? true))
        <form action="{{ route('books') }}" method="GET" class="header-search-form" style="display: flex; align-items: center;">
            <div class="header-search" style="position: relative;">
                <input type="search" 
                       name="q" 
                       id="headerSearch" 
                       placeholder="Search books..." 
                       value="{{ request('q') }}"
                       autocomplete="off"
                       aria-label="Search books">
                <i class="fa-solid fa-magnifying-glass" id="headerSearchIcon" style="cursor: pointer;"></i>
                <div id="searchSuggestions" class="search-suggestions" style="display: none;"></div>
            </div>
        </form>
        <script>
            // Make route available to JavaScript
            window.booksRoute = '{{ route("books") }}';
        </script>
        @endif

        <!-- NAVIGATION -->
        <nav>
            <ul>
                @if(session('logged_in'))
                    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') || request()->routeIs('user.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-house"></i> Home</a></li>
                    <li><a href="{{ url('/user/books') }}" class="{{ request()->routeIs('books') ? 'active' : '' }}"><i class="fa-solid fa-book-open"></i> Books</a></li>
                    <li><a href="{{ route('my.borrowed') }}" class="{{ request()->routeIs('my.borrowed') ? 'active' : '' }}"><i class="fa-solid fa-book-open-reader"></i> My Books</a></li>
                    <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}"><i class="fa-solid fa-info-circle"></i> About us</a></li>
                    <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}"><i class="fa-solid fa-envelope"></i> Contact us</a></li>
                    <li>
                        <a href="{{ route('info') }}" class="profile-link {{ request()->routeIs('info') ? 'active' : '' }}" title="Account Settings">
                            <i class="fa-solid fa-user"></i> Profile
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/logout') }}" class="logout-link" title="Logout">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </a>
                    </li>
                @else
                    @if(request()->routeIs('login'))
                        <li><a href="{{ route('register') }}"><i class="fa-solid fa-user-plus"></i> Register</a></li>
                    @else
                        <li><a href="{{ route('login') }}"><i class="fa-solid fa-right-to-bracket"></i> Login</a></li>
                    @endif
                @endif
            </ul>
        </nav>
    </div>
</header>

