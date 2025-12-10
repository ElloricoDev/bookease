<aside class="sidebar">
    <a class="side-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
        <i class="fa-solid fa-gauge"></i> Dashboard
    </a>
    <a class="side-link {{ request()->routeIs('user_management') || request()->routeIs('users.create') || request()->routeIs('users.edit') ? 'active' : '' }}" href="{{ route('user_management') }}">
        <i class="fa-solid fa-users"></i> User Management
    </a>
    <a class="side-link {{ request()->routeIs('book_management') || request()->routeIs('books.create') || request()->routeIs('books.edit') ? 'active' : '' }}" href="{{ route('book_management') }}">
        <i class="fa-solid fa-book"></i> Book Management
    </a>
    <a class="side-link {{ request()->routeIs('borrow_return') || request()->routeIs('return.show') || request()->routeIs('return.process') ? 'active' : '' }}" href="{{ route('borrow_return') }}">
        <i class="fa-solid fa-exchange-alt"></i> Borrow and Return
    </a>
    <a class="side-link {{ request()->routeIs('fines') ? 'active' : '' }}" href="{{ route('fines') }}">
        <i class="fa-solid fa-peso-sign"></i> Fine Management
    </a>
    <a class="side-link {{ request()->routeIs('reports') ? 'active' : '' }}" href="{{ route('reports') }}">
        <i class="fa-solid fa-chart-bar"></i> Reports
    </a>
    <a class="side-link {{ request()->routeIs('notifications') ? 'active' : '' }}" href="{{ route('notifications') }}">
        <i class="fa-solid fa-bell"></i> Notifications
    </a>
    <a class="side-link {{ request()->routeIs('admin.contact_messages') || request()->routeIs('admin.contact_messages.show') ? 'active' : '' }}" href="{{ route('admin.contact_messages') }}">
        <i class="fa-solid fa-envelope"></i> Contact Messages
        @php
            $newContactMessagesCount = \App\Models\ContactMessage::where('status', 'new')->count();
        @endphp
        @if($newContactMessagesCount > 0)
            <span class="badge primary" style="margin-left: auto;">{{ $newContactMessagesCount }} New</span>
        @endif
    </a>
    <a class="side-link side-logout" href="{{ url('/logout') }}">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>
</aside>

