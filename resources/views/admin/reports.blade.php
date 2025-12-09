<x-layout title="BookEase • Reports" bodyClass="user-page admin-page">
    <x-admin-header />
    
    <div class="dashboard-layout">
        <x-admin-sidebar />

        <main class="dashboard-main">
            <div class="panel">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <h2 style="margin: 0;"><i class="fa-solid fa-chart-bar"></i> Reports</h2>
                    <div style="display: flex; gap: 10px;">
                        <button onclick="window.print()" class="btn" style="background: #6c757d; color: #fff;">
                            <i class="fa-solid fa-print"></i> Print
                        </button>
                        <button onclick="exportReport()" class="btn primary">
                            <i class="fa-solid fa-download"></i> Export
                        </button>
                    </div>
                </div>

                <!-- Date Range Filter -->
                <form method="GET" action="{{ route('reports') }}" style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 25px;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #333;">
                                <i class="fa-solid fa-calendar"></i> Period
                            </label>
                            <select name="period" onchange="this.form.submit()" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 6px; font-size: 14px;">
                                <option value="7months" {{ $period === '7months' ? 'selected' : '' }}>Last 7 Months</option>
                                <option value="12months" {{ $period === '12months' ? 'selected' : '' }}>Last 12 Months</option>
                                <option value="year" {{ $period === 'year' ? 'selected' : '' }}>This Year</option>
                                <option value="custom" {{ $period === 'custom' ? 'selected' : '' }}>Custom Range</option>
                            </select>
                        </div>
                        <div id="customDateRange" style="display: {{ $period === 'custom' ? 'block' : 'none' }};">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #333;">Start Date</label>
                            <input type="date" name="start_date" value="{{ $startDate }}" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 6px; font-size: 14px;">
                        </div>
                        <div id="customDateRangeEnd" style="display: {{ $period === 'custom' ? 'block' : 'none' }};">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #333;">End Date</label>
                            <input type="date" name="end_date" value="{{ $endDate }}" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 6px; font-size: 14px;">
                        </div>
                        <div>
                            <button type="submit" class="btn primary" style="width: 100%;">
                                <i class="fa-solid fa-filter"></i> Apply Filter
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Summary Stats -->
                <div class="stats" style="margin-bottom: 30px;">
                    <div class="stat">
                        <div class="stat-title"><i class="fa-solid fa-book"></i> Total Borrowings</div>
                        <div class="stat-value">{{ number_format($totalBorrowings) }}</div>
                    </div>
                    <div class="stat">
                        <div class="stat-title"><i class="fa-solid fa-rotate-left"></i> Total Returns</div>
                        <div class="stat-value">{{ number_format($totalReturns) }}</div>
                    </div>
                    <div class="stat">
                        <div class="stat-title"><i class="fa-solid fa-book-open"></i> Active Borrowings</div>
                        <div class="stat-value">{{ number_format($activeBorrowings) }}</div>
                    </div>
                    <div class="stat">
                        <div class="stat-title"><i class="fa-solid fa-exclamation-triangle"></i> Overdue Books</div>
                        <div class="stat-value">{{ number_format($overdueCount) }}</div>
                    </div>
                    <div class="stat">
                        <div class="stat-title"><i class="fa-solid fa-dollar-sign"></i> Total Revenue</div>
                        <div class="stat-value">₱{{ number_format($totalRevenue, 0) }}</div>
                    </div>
                    <div class="stat">
                        <div class="stat-title"><i class="fa-solid fa-money-bill-wave"></i> Late Fees</div>
                        <div class="stat-value">₱{{ number_format($totalLateFees, 0) }}</div>
                    </div>
                    <div class="stat">
                        <div class="stat-title"><i class="fa-solid fa-users"></i> Total Users</div>
                        <div class="stat-value">{{ number_format($totalUsers) }}</div>
                    </div>
                    <div class="stat">
                        <div class="stat-title"><i class="fa-solid fa-book"></i> Total Books</div>
                        <div class="stat-value">{{ number_format($totalBooks) }}</div>
                    </div>
                </div>

                <!-- Revenue Breakdown -->
                <div style="background: #fff; padding: 20px; border-radius: 8px; margin-bottom: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <h3 style="margin: 0 0 15px 0; color: #2e7d32;"><i class="fa-solid fa-chart-pie"></i> Revenue Breakdown</h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                        <div style="text-align: center; padding: 15px; background: #e8f5e9; border-radius: 6px;">
                            <div style="font-size: 12px; color: #666; margin-bottom: 5px;">Rent Fees</div>
                            <div style="font-size: 20px; font-weight: 700; color: #2e7d32;">₱{{ number_format($revenueByType['rent_fee'], 2) }}</div>
                        </div>
                        <div style="text-align: center; padding: 15px; background: #fff3e0; border-radius: 6px;">
                            <div style="font-size: 12px; color: #666; margin-bottom: 5px;">Late Fees</div>
                            <div style="font-size: 20px; font-weight: 700; color: #f57c00;">₱{{ number_format($revenueByType['late_fee'], 2) }}</div>
                        </div>
                        <div style="text-align: center; padding: 15px; background: #e3f2fd; border-radius: 6px;">
                            <div style="font-size: 12px; color: #666; margin-bottom: 5px;">Deposits</div>
                            <div style="font-size: 20px; font-weight: 700; color: #1976d2;">₱{{ number_format($revenueByType['deposit'], 2) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="charts" style="margin-bottom: 30px;">
                    <div class="chart-card">
                        <div class="chart-title">Books Borrowed Trend</div>
                        <svg id="reportsChart1" viewBox="0 0 320 160"></svg>
                    </div>
                    <div class="chart-card">
                        <div class="chart-title">Overdue Books Trend</div>
                        <svg id="reportsChart2" viewBox="0 0 320 160"></svg>
                    </div>
                    <div class="chart-card">
                        <div class="chart-title">Active Users Trend</div>
                        <svg id="reportsChart3" viewBox="0 0 320 160"></svg>
                    </div>
                    <div class="chart-card">
                        <div class="chart-title">Revenue Trend</div>
                        <svg id="reportsChart4" viewBox="0 0 320 160"></svg>
                    </div>
                </div>

                <!-- Top Books and Users -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 20px; margin-bottom: 30px;">
                    <!-- Top 5 Most Borrowed Books -->
                    <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <h3 style="margin: 0 0 15px 0; color: #2e7d32;"><i class="fa-solid fa-trophy"></i> Top 5 Most Borrowed Books</h3>
                        <div class="table-wrap">
                            <table class="table" style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Book Title</th>
                                        <th>Borrows</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topBooks as $index => $item)
                                    <tr>
                                        <td>
                                            @if($index === 0)
                                                <span style="color: #ffd700;"><i class="fa-solid fa-medal"></i> 1st</span>
                                            @elseif($index === 1)
                                                <span style="color: #c0c0c0;"><i class="fa-solid fa-medal"></i> 2nd</span>
                                            @elseif($index === 2)
                                                <span style="color: #cd7f32;"><i class="fa-solid fa-medal"></i> 3rd</span>
                                            @else
                                                <strong>#{{ $index + 1 }}</strong>
                                            @endif
                                        </td>
                                        <td>{{ $item->book->title ?? 'N/A' }}</td>
                                        <td><span class="badge">{{ $item->borrow_count }}</span></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" style="text-align: center; padding: 20px; color: #666;">
                                            <i class="fa-solid fa-inbox" style="font-size: 32px; margin-bottom: 10px; display: block; color: #ccc;"></i>
                                            No data available
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Top 5 Most Active Users -->
                    <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <h3 style="margin: 0 0 15px 0; color: #2e7d32;"><i class="fa-solid fa-star"></i> Top 5 Most Active Users</h3>
                        <div class="table-wrap">
                            <table class="table" style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>User Name</th>
                                        <th>Borrows</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topUsers as $index => $item)
                                    <tr>
                                        <td>
                                            @if($index === 0)
                                                <span style="color: #ffd700;"><i class="fa-solid fa-medal"></i> 1st</span>
                                            @elseif($index === 1)
                                                <span style="color: #c0c0c0;"><i class="fa-solid fa-medal"></i> 2nd</span>
                                            @elseif($index === 2)
                                                <span style="color: #cd7f32;"><i class="fa-solid fa-medal"></i> 3rd</span>
                                            @else
                                                <strong>#{{ $index + 1 }}</strong>
                                            @endif
                                        </td>
                                        <td>{{ $item->user->name ?? 'N/A' }}</td>
                                        <td><span class="badge">{{ $item->borrow_count }}</span></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" style="text-align: center; padding: 20px; color: #666;">
                                            <i class="fa-solid fa-inbox" style="font-size: 32px; margin-bottom: 10px; display: block; color: #ccc;"></i>
                                            No data available
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/charts.css') }}">
        <style>
            @media print {
                .dashboard-sidebar, .admin-header, button, form { display: none !important; }
                .dashboard-main { margin: 0 !important; padding: 0 !important; }
                .panel { box-shadow: none !important; }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Pass PHP data to JavaScript
            window.monthlyBorrowings = @json($monthlyBorrowings);
            window.monthlyOverdue = @json($monthlyOverdue);
            window.monthlyActiveUsers = @json($monthlyActiveUsers);
            window.monthlyRevenue = @json($monthlyRevenue);
            window.monthLabels = @json($monthLabels);

            // Show/hide custom date range
            document.querySelector('select[name="period"]')?.addEventListener('change', function() {
                const customRange = document.getElementById('customDateRange');
                const customRangeEnd = document.getElementById('customDateRangeEnd');
                if (this.value === 'custom') {
                    customRange.style.display = 'block';
                    customRangeEnd.style.display = 'block';
                } else {
                    customRange.style.display = 'none';
                    customRangeEnd.style.display = 'none';
                }
            });

            // Export report function
            function exportReport() {
                const data = {
                    totalBorrowings: {{ $totalBorrowings }},
                    totalReturns: {{ $totalReturns }},
                    totalRevenue: {{ $totalRevenue }},
                    totalLateFees: {{ $totalLateFees }},
                    activeBorrowings: {{ $activeBorrowings }},
                    overdueCount: {{ $overdueCount }},
                    period: '{{ $period }}',
                    startDate: '{{ $startDate }}',
                    endDate: '{{ $endDate }}'
                };
                
                const csv = `Report Period: ${data.startDate} to ${data.endDate}\n` +
                    `Total Borrowings,${data.totalBorrowings}\n` +
                    `Total Returns,${data.totalReturns}\n` +
                    `Active Borrowings,${data.activeBorrowings}\n` +
                    `Overdue Books,${data.overdueCount}\n` +
                    `Total Revenue,₱${data.totalRevenue}\n` +
                    `Late Fees Collected,₱${data.totalLateFees}\n`;
                
                const blob = new Blob([csv], { type: 'text/csv' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `bookease-report-${data.startDate}-to-${data.endDate}.csv`;
                a.click();
                window.URL.revokeObjectURL(url);
            }
        </script>
        <script src="{{ asset('js/charts/reports.js') }}"></script>
    @endpush
</x-layout>
