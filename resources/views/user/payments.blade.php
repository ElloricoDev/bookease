<x-layout title="BookEase • Payment History" bodyClass="user-page">
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
                <h1 class="user-panel-title"><i class="fa-solid fa-dollar-sign"></i> Payment History</h1>

                <!-- Summary Cards -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
                    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <p style="margin: 0 0 8px 0; opacity: 0.9; font-size: 14px;">Total Paid</p>
                                <h2 style="margin: 0; font-size: 28px; font-weight: 700;">₱{{ number_format($totalPaid, 2) }}</h2>
                            </div>
                            <i class="fa-solid fa-arrow-up" style="font-size: 32px; opacity: 0.8;"></i>
                        </div>
                    </div>
                    <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <p style="margin: 0 0 8px 0; opacity: 0.9; font-size: 14px;">Total Refunded</p>
                                <h2 style="margin: 0; font-size: 28px; font-weight: 700;">₱{{ number_format($totalRefunded, 2) }}</h2>
                            </div>
                            <i class="fa-solid fa-arrow-down" style="font-size: 32px; opacity: 0.8;"></i>
                        </div>
                    </div>
                    <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <p style="margin: 0 0 8px 0; opacity: 0.9; font-size: 14px;">Net Amount</p>
                                <h2 style="margin: 0; font-size: 28px; font-weight: 700;">₱{{ number_format($totalPaid - $totalRefunded, 2) }}</h2>
                            </div>
                            <i class="fa-solid fa-wallet" style="font-size: 32px; opacity: 0.8;"></i>
                        </div>
                    </div>
                </div>

                <!-- Payment List -->
                <div style="background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;">
                    <div style="padding: 20px; border-bottom: 1px solid #e0e0e0;">
                        <h2 style="margin: 0; font-size: 18px; color: #1b1f1b;"><i class="fa-solid fa-list"></i> Transaction History</h2>
                    </div>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead style="background: #f8f9fa;">
                                <tr>
                                    <th style="padding: 15px; text-align: left; font-weight: 600; color: #666; border-bottom: 2px solid #e0e0e0;">Date</th>
                                    <th style="padding: 15px; text-align: left; font-weight: 600; color: #666; border-bottom: 2px solid #e0e0e0;">Type</th>
                                    <th style="padding: 15px; text-align: left; font-weight: 600; color: #666; border-bottom: 2px solid #e0e0e0;">Book</th>
                                    <th style="padding: 15px; text-align: left; font-weight: 600; color: #666; border-bottom: 2px solid #e0e0e0;">Amount</th>
                                    <th style="padding: 15px; text-align: left; font-weight: 600; color: #666; border-bottom: 2px solid #e0e0e0;">Method</th>
                                    <th style="padding: 15px; text-align: left; font-weight: 600; color: #666; border-bottom: 2px solid #e0e0e0;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                    <tr style="border-bottom: 1px solid #f0f0f0;">
                                        <td style="padding: 15px; color: #666;">
                                            {{ $payment->created_at->format('M d, Y') }}<br>
                                            <small style="color: #999;">{{ $payment->created_at->format('h:i A') }}</small>
                                        </td>
                                        <td style="padding: 15px;">
                                            @if($payment->type === 'rent_fee')
                                                <span style="background: #007bff; color: #fff; padding: 4px 10px; border-radius: 12px; font-size: 12px;">
                                                    <i class="fa-solid fa-book"></i> Rent Fee
                                                </span>
                                            @elseif($payment->type === 'deposit')
                                                <span style="background: #ffc107; color: #000; padding: 4px 10px; border-radius: 12px; font-size: 12px;">
                                                    <i class="fa-solid fa-money-bill"></i> Deposit
                                                </span>
                                            @elseif($payment->type === 'late_fee')
                                                <span style="background: #dc3545; color: #fff; padding: 4px 10px; border-radius: 12px; font-size: 12px;">
                                                    <i class="fa-solid fa-exclamation-triangle"></i> Late Fee
                                                </span>
                                            @else
                                                <span style="background: #28a745; color: #fff; padding: 4px 10px; border-radius: 12px; font-size: 12px;">
                                                    <i class="fa-solid fa-undo"></i> Refund
                                                </span>
                                            @endif
                                        </td>
                                        <td style="padding: 15px; color: #333;">
                                            @if($payment->borrowedBook && $payment->borrowedBook->book)
                                                <strong>{{ $payment->borrowedBook->book->title }}</strong>
                                            @else
                                                <span style="color: #999;">N/A</span>
                                            @endif
                                        </td>
                                        <td style="padding: 15px;">
                                            <strong style="color: {{ $payment->type === 'refund' ? '#28a745' : '#333' }}; font-size: 16px;">
                                                {{ $payment->type === 'refund' ? '+' : '-' }}₱{{ number_format($payment->amount, 2) }}
                                            </strong>
                                        </td>
                                        <td style="padding: 15px; color: #666;">
                                            <i class="fa-solid fa-{{ $payment->method === 'cash' ? 'money-bill' : ($payment->method === 'card' ? 'credit-card' : 'globe') }}"></i>
                                            {{ ucfirst($payment->method) }}
                                        </td>
                                        <td style="padding: 15px;">
                                            @if($payment->status === 'completed')
                                                <span style="background: #28a745; color: #fff; padding: 4px 10px; border-radius: 12px; font-size: 12px;">
                                                    <i class="fa-solid fa-check"></i> Completed
                                                </span>
                                            @elseif($payment->status === 'pending')
                                                <span style="background: #ffc107; color: #000; padding: 4px 10px; border-radius: 12px; font-size: 12px;">
                                                    <i class="fa-solid fa-clock"></i> Pending
                                                </span>
                                            @elseif($payment->status === 'refunded')
                                                <span style="background: #17a2b8; color: #fff; padding: 4px 10px; border-radius: 12px; font-size: 12px;">
                                                    <i class="fa-solid fa-undo"></i> Refunded
                                                </span>
                                            @else
                                                <span style="background: #dc3545; color: #fff; padding: 4px 10px; border-radius: 12px; font-size: 12px;">
                                                    <i class="fa-solid fa-times"></i> Failed
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="padding: 60px 20px; text-align: center; color: #999;">
                                            <i class="fa-solid fa-receipt" style="font-size: 48px; margin-bottom: 15px; display: block; color: #ccc;"></i>
                                            <p style="margin: 0;">No payment history found.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($payments->hasPages())
                    <div style="margin-top: 30px; display: flex; justify-content: center;">
                        {{ $payments->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</x-layout>

