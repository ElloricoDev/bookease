<x-layout title="BookEase • My Reservations" bodyClass="user-page">
    <x-user-header />

    <div class="user-dashboard-layout">
        <aside class="user-sidebar">
            <a class="user-side-link {{ request()->routeIs('home') || request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('home') }}">
                <i class="fa-solid fa-home"></i>
                <span>Home</span>
            </a>
            <a class="user-side-link {{ request()->routeIs('books') ? 'active' : '' }}" href="{{ route('books') }}">
                <i class="fa-solid fa-book"></i>
                <span>Books</span>
            </a>
            <a class="user-side-link {{ request()->routeIs('my.borrowed') ? 'active' : '' }}" href="{{ route('my.borrowed') }}">
                <i class="fa-solid fa-book-open-reader"></i>
                <span>My Borrowed Books</span>
            </a>
            <a class="user-side-link {{ request()->routeIs('my.reservations') ? 'active' : '' }}" href="{{ route('my.reservations') }}">
                <i class="fa-solid fa-bookmark"></i>
                <span>My Reservations</span>
            </a>
            <a class="user-side-link {{ request()->routeIs('payment.history') ? 'active' : '' }}" href="{{ route('payment.history') }}">
                <i class="fa-solid fa-peso-sign"></i>
                <span>Payment History</span>
            </a>
            <a class="user-side-link {{ request()->routeIs('info') ? 'active' : '' }}" href="{{ route('info') }}">
                <i class="fa-solid fa-user"></i>
                <span>Account</span>
            </a>
            <a class="user-side-link user-side-logout" href="{{ url('/logout') }}">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout</span>
            </a>
        </aside>

        <main class="user-dashboard-main">
            <div class="user-panel">
                <h1 class="user-panel-title"><i class="fa-solid fa-bookmark"></i> My Reservations</h1>

                <div style="background: #f8f9fa; border-radius: 10px; padding: 14px 16px; margin-bottom: 18px; border-left: 4px solid #17a2b8; font-size: 13px; color: #495057;">
                    <strong style="display: block; margin-bottom: 4px;">
                        <i class="fa-solid fa-circle-info"></i> How reservations work
                    </strong>
                    <span><strong>Pending</strong>: waiting for a copy to be returned. </span>
                    <span><strong>Available</strong>: a copy is held for you until the shown expiry time. </span>
                    <span><strong>Fulfilled</strong>: you already borrowed this reserved book. </span>
                    <span><strong>Expired / Cancelled</strong>: the reservation is no longer active.</span>
                </div>

                @if(session('success'))
                    <div class="alert success" style="background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
                        <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert danger" style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
                        <i class="fa-solid fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

                @forelse($reservations as $reservation)
                    <div class="book-card" style="margin-bottom: 20px; padding: 20px; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <div style="display: flex; gap: 20px;">
                            <div style="flex-shrink: 0;">
                                <img src="{{ asset($reservation->book->image ?? 'images/book1.jpg') }}" 
                                     alt="{{ $reservation->book->title }}" 
                                     style="width: 120px; height: 180px; object-fit: cover; border-radius: 8px;">
                            </div>
                            <div style="flex: 1;">
                                <h3 style="margin: 0 0 10px 0; color: #1b1f1b;">{{ $reservation->book->title }}</h3>
                                <p style="color: #666; margin: 0 0 15px 0;"><i class="fa-solid fa-user"></i> {{ $reservation->book->author }}</p>
                                
                                <div style="display: flex; gap: 15px; margin-bottom: 15px; flex-wrap: wrap;">
                                    <div>
                                        <strong>Status:</strong>
                                        @if($reservation->status === 'pending')
                                            <span class="badge warning" style="background: #ffc107; color: #000; padding: 4px 12px; border-radius: 12px; font-size: 12px;">
                                                <i class="fa-solid fa-clock"></i> Pending
                                            </span>
                                        @elseif($reservation->status === 'available')
                                            <span class="badge success" style="background: #28a745; color: #fff; padding: 4px 12px; border-radius: 12px; font-size: 12px;">
                                                <i class="fa-solid fa-check-circle"></i> Available Now!
                                            </span>
                                        @elseif($reservation->status === 'fulfilled')
                                            <span class="badge" style="background: #17a2b8; color: #fff; padding: 4px 12px; border-radius: 12px; font-size: 12px;">
                                                <i class="fa-solid fa-check"></i> Fulfilled
                                            </span>
                                        @elseif($reservation->status === 'expired')
                                            <span class="badge danger" style="background: #dc3545; color: #fff; padding: 4px 12px; border-radius: 12px; font-size: 12px;">
                                                <i class="fa-solid fa-times"></i> Expired
                                            </span>
                                        @else
                                            <span class="badge" style="background: #6c757d; color: #fff; padding: 4px 12px; border-radius: 12px; font-size: 12px;">
                                                <i class="fa-solid fa-ban"></i> Cancelled
                                            </span>
                                        @endif
                                    </div>
                                    <div>
                                        <strong>Reserved:</strong> {{ $reservation->created_at->format('M d, Y') }}
                                    </div>
                                    @if($reservation->expires_at)
                                        <div>
                                            <strong>Expires:</strong> {{ $reservation->expires_at->format('M d, Y h:i A') }}
                                        </div>
                                    @endif
                                </div>

                                @if($reservation->status === 'available')
                                    <div style="background: #d1ecf1; padding: 15px; border-radius: 8px; margin-bottom: 15px; border-left: 4px solid #17a2b8;">
                                        <strong><i class="fa-solid fa-info-circle"></i> Book Available!</strong>
                                        <p style="margin: 8px 0 0 0; font-size: 14px;">
                                            This book is now available. You have until {{ $reservation->expires_at->format('M d, Y h:i A') }} to borrow it.
                                            <a href="{{ route('books') }}" style="color: #17a2b8; text-decoration: underline; margin-left: 5px;">Go to Books</a>
                                        </p>
                                    </div>
                                @endif

                                <div style="display: flex; gap: 10px;">
                                    @if(in_array($reservation->status, ['pending', 'available']))
                                        <form action="{{ route('reserve.cancel', $reservation->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn small danger" onclick="return confirm('Are you sure you want to cancel this reservation?');">
                                                <i class="fa-solid fa-times"></i> Cancel Reservation
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('books') }}" class="btn small" style="background: #17a2b8; color: #fff;">
                                        <i class="fa-solid fa-book"></i> View Book
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 60px 20px; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <i class="fa-solid fa-bookmark" style="font-size: 64px; color: #ccc; margin-bottom: 20px;"></i>
                        <h3 style="color: #666; margin-bottom: 10px;">No Reservations Yet</h3>
                        <p style="color: #999; margin-bottom: 25px;">You haven't reserved any books. Reserve unavailable books to get notified when they become available!</p>
                        <a href="{{ route('books') }}" class="btn primary">
                            <i class="fa-solid fa-book"></i> Browse Books
                        </a>
                    </div>
                @endforelse

                @if($reservations->hasPages())
                    <div style="margin-top: 30px; display: flex; justify-content: center;">
                        {{ $reservations->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</x-layout>

