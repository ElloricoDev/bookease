<x-layout title="BookEase • Admin Dashboard" bodyClass="user-page admin-page">
    <x-admin-header />
    
    <div class="dashboard-layout">
        <x-admin-sidebar />

        <main class="dashboard-main">
            <div class="panel">
                <h2><i class="fa-solid fa-gauge"></i> Dashboard</h2>

                <div class="stats">
                    <div class="stat">
                        <div class="stat-title"><i class="fa-solid fa-book"></i> Total Books</div>
                        <div class="stat-value">{{ number_format($totalBooks) }}</div>
                    </div>
                    <div class="stat">
                        <div class="stat-title"><i class="fa-solid fa-book-open"></i> Borrowed Books</div>
                        <div class="stat-value">{{ number_format($borrowedBooks) }}</div>
                    </div>
                    <div class="stat">
                        <div class="stat-title"><i class="fa-solid fa-users"></i> Registered Users</div>
                        <div class="stat-value">{{ number_format($totalUsers) }}</div>
                    </div>
                    <div class="stat">
                        <div class="stat-title"><i class="fa-solid fa-exclamation-triangle"></i> Overdue Books</div>
                        <div class="stat-value">{{ number_format($overdueBooks) }}</div>
                    </div>
                </div>

                <div class="charts">
                    <div class="chart-card">
                        <div class="chart-title">Books Borrowed per Month (Last 6 Months)</div>
                        <svg id="barChart" viewBox="0 0 320 180" aria-label="Borrowed per month"></svg>
                    </div>
                    <div class="chart-card">
                        <div class="chart-title">Books by Category</div>
                        <svg id="pieChart" viewBox="0 0 220 180" aria-label="Books by Category"></svg>
                        <ul class="legend" id="categoryLegend"></ul>
                    </div>
                </div>

                <div class="recent">
                    <div class="recent-title">Recent Activity</div>
                    <div class="recent-grid">
                        @forelse($recentBorrowings as $borrowing)
                            <div>
                                @if($borrowing->returned_at)
                                    <i class="fa-solid fa-rotate-left"></i> 
                                    {{ $borrowing->user->name }} returned {{ $borrowing->book->title }}
                                    <span class="muted" style="color: #999; font-size: 12px;">
                                        {{ $borrowing->returned_at->diffForHumans() }}
                                    </span>
                                @else
                                    <i class="fa-solid fa-book"></i> 
                                    {{ $borrowing->user->name }} borrowed {{ $borrowing->book->title }}
                                    <span class="muted" style="color: #999; font-size: 12px;">
                                        {{ $borrowing->created_at->diffForHumans() }}
                                    </span>
                                @endif
                            </div>
                        @empty
                            <div style="color: #666; text-align: center; padding: 20px;">
                                No recent activity
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </main>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/charts.css') }}">
    @endpush

    @push('scripts')
        <script>
            // Pass PHP data to JavaScript
            window.monthlyData = @json($monthlyData);
            window.categoryData = @json($categoryData);
        </script>
        <script src="{{ asset('js/charts/dashboard.js') }}"></script>
    @endpush
</x-layout>
