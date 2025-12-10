<x-layout title="BookEase • Borrow and Return" bodyClass="user-page admin-page">
    <x-admin-header />
    
    <div class="dashboard-layout">
        <x-admin-sidebar />

        <main class="dashboard-main">
            <div class="panel">
                <h2><i class="fa-solid fa-exchange-alt"></i> Borrow and Return</h2>

                @if(session('success'))
                    <div class="alert success" style="background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                        <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 2px solid #f5c6cb; font-weight: 600;">
                        <i class="fa-solid fa-exclamation-circle"></i> <strong>Error:</strong> {{ session('error') }}
                    </div>
                @endif

                @if(session('debug'))
                    <div class="alert" style="background: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 2px solid #bee5eb;">
                        <i class="fa-solid fa-info-circle"></i> <strong>Debug:</strong> {{ session('debug') }}
                    </div>
                @endif

                <div class="table-toolbar">
                    <x-admin-search 
                        id="borrowSearch" 
                        placeholder="Search by Name, Book Title, or ID"
                        tableId="borrowTable"
                        :searchFields="['user', 'book']"
                    />
                </div>

                <div class="table-wrap">
                    <table class="table" id="borrowTable">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Book</th>
                                <th>Borrowed Date</th>
                                <th>Due Date</th>
                                <th>Days</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($borrowedBooks as $borrowed)
                            <tr data-user="{{ strtolower($borrowed->user->name) }}" data-book="{{ strtolower($borrowed->book->title) }}">
                                <td>{{ $borrowed->user->name }}</td>
                                <td>{{ $borrowed->book->title }}</td>
                                <td>{{ $borrowed->borrowed_at ? $borrowed->borrowed_at->format('M d, Y') : 'N/A' }}</td>
                                <td>
                                    {{ $borrowed->due_date ? $borrowed->due_date->format('M d, Y') : 'N/A' }}
                                    @if($borrowed->isOverdue())
                                        <span class="badge danger" style="margin-left: 8px;">
                                            {{ $borrowed->daysOverdue() }} days overdue
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $borrowed->days }} days</td>
                                <td>
                                    @if($borrowed->isOverdue())
                                        <span class="badge danger">Overdue</span>
                                    @else
                                        <span class="badge info">Borrowed</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('return.show', $borrowed->id) }}" 
                                       class="btn small" 
                                       style="text-decoration: none;"
                                       onclick="console.log('Clicking Process Return for ID: {{ $borrowed->id }}'); return true;">
                                        <i class="fa-solid fa-check"></i> Process Return
                                    </a>
                                    <br>
                                    <small style="color: #666; font-size: 10px;">ID: {{ $borrowed->id }} | Book: {{ $borrowed->book_id }} | User: {{ $borrowed->user_id }}</small>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 60px 40px; color: #666;">
                                    <i class="fa-solid fa-inbox" style="font-size: 64px; margin-bottom: 20px; display: block; color: #ccc;"></i>
                                    <h3 style="color: #999; margin-bottom: 10px;">No Active Borrowings</h3>
                                    <p style="color: #999; margin-bottom: 25px;">There are currently no books that need to be returned.</p>
                                    <p style="color: #666; font-size: 14px;">
                                        <i class="fa-solid fa-info-circle"></i> When users borrow books, they will appear here for return processing.
                                    </p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
    </script>
</x-layout>
