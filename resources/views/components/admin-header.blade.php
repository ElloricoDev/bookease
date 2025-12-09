<header class="user-header admin-header">
    <div class="nav-inner">
        <a href="{{ route('dashboard') }}" class="brand">
            <i class="fa-solid fa-book"></i> BookEase Admin
        </a>
        <nav>
            <ul>
                <li>
                    <a href="{{ route('info') }}" class="profile-link" title="Account Settings">
                        <i class="fa-solid fa-user"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/logout') }}" class="logout-link" title="Logout">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>

