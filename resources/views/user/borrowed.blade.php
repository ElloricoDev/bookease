<x-layout title="BookEase • My Borrowed Books" bodyClass="user-page">
    <x-user-header />

    <main class="user-main">
        <div style="max-width: 1400px; margin: 0 auto; padding: 0 20px;">
            <!-- Page Header -->
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 50px 40px; border-radius: 16px; margin: 30px 0 40px; text-align: center; box-shadow: 0 8px 32px rgba(0,0,0,.15); position: relative; overflow: hidden;">
                <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: absolute; bottom: -30px; left: -30px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: relative; z-index: 1;">
                    <h1 style="font-size: 42px; font-weight: 800; margin: 0 0 15px 0; text-shadow: 0 2px 10px rgba(0,0,0,.2); display: flex; align-items: center; justify-content: center; gap: 15px;">
                        <i class="fa-solid fa-book-open-reader"></i> My Borrowed Books
                    </h1>
                    <p style="font-size: 20px; margin: 0; opacity: 0.95; font-weight: 500;">Manage your current borrowings and view history</p>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 25px; margin-bottom: 40px;">
                <x-stat-card 
                    icon="fa-solid fa-book-open-reader"
                    value="{{ $stats['total_borrowed'] }}"
                    label="Currently Borrowed"
                    variant="primary" />
                
                <x-stat-card 
                    icon="fa-solid fa-exclamation-triangle"
                    value="{{ $stats['overdue'] }}"
                    label="Overdue"
                    variant="danger" />
                
                <x-stat-card 
                    icon="fa-solid fa-clock"
                    value="{{ $stats['due_soon'] }}"
                    label="Due Soon"
                    variant="info" />
                
                <x-stat-card 
                    icon="fa-solid fa-check-circle"
                    value="{{ $stats['total_returned'] }}"
                    label="Total Returned"
                    variant="success" />
            </div>

            <!-- Filter Tabs -->
            <div style="background: #fff; padding: 20px; border-radius: 16px; margin-bottom: 30px; box-shadow: 0 4px 20px rgba(0,0,0,.1); display: flex; gap: 12px; flex-wrap: wrap;">
                <a href="{{ route('my.borrowed', ['filter' => 'active']) }}" 
                   style="text-decoration: none; padding: 12px 24px; border-radius: 10px; font-weight: 600; font-size: 15px; transition: all 0.3s; display: flex; align-items: center; gap: 8px; {{ $filter === 'active' ? 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; box-shadow: 0 4px 12px rgba(102,126,234,0.4);' : 'background: #f8f9fa; color: #666;' }}"
                   onmouseover="{{ $filter !== 'active' ? "this.style.background='#e9ecef'; this.style.color='#333'" : '' }}"
                   onmouseout="{{ $filter !== 'active' ? "this.style.background='#f8f9fa'; this.style.color='#666'" : '' }}">
                    <i class="fa-solid fa-clock"></i> Active
                </a>
                <a href="{{ route('my.borrowed', ['filter' => 'overdue']) }}" 
                   style="text-decoration: none; padding: 12px 24px; border-radius: 10px; font-weight: 600; font-size: 15px; transition: all 0.3s; display: flex; align-items: center; gap: 8px; {{ $filter === 'overdue' ? 'background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: #fff; box-shadow: 0 4px 12px rgba(240,147,251,0.4);' : 'background: #f8f9fa; color: #666;' }}"
                   onmouseover="{{ $filter !== 'overdue' ? "this.style.background='#e9ecef'; this.style.color='#333'" : '' }}"
                   onmouseout="{{ $filter !== 'overdue' ? "this.style.background='#f8f9fa'; this.style.color='#666'" : '' }}">
                    <i class="fa-solid fa-exclamation-triangle"></i> Overdue
                </a>
                <a href="{{ route('my.borrowed', ['filter' => 'returned']) }}" 
                   style="text-decoration: none; padding: 12px 24px; border-radius: 10px; font-weight: 600; font-size: 15px; transition: all 0.3s; display: flex; align-items: center; gap: 8px; {{ $filter === 'returned' ? 'background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: #fff; box-shadow: 0 4px 12px rgba(79,172,254,0.4);' : 'background: #f8f9fa; color: #666;' }}"
                   onmouseover="{{ $filter !== 'returned' ? "this.style.background='#e9ecef'; this.style.color='#333'" : '' }}"
                   onmouseout="{{ $filter !== 'returned' ? "this.style.background='#f8f9fa'; this.style.color='#666'" : '' }}">
                    <i class="fa-solid fa-history"></i> History
                </a>
                <div style="margin-left: auto; display: flex; align-items: center;">
                    <a href="{{ route('books') }}" class="btn primary" style="text-decoration: none; padding: 12px 24px; font-size: 15px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-book"></i> Browse More Books
                    </a>
                </div>
            </div>

            @if($filter === 'returned')
                <!-- Returned Books History -->
                <div style="background: #fff; padding: 35px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,.1);">
                    <h2 style="color: #2e7d32; margin-bottom: 25px; font-size: 28px; display: flex; align-items: center; gap: 12px;">
                        <i class="fa-solid fa-history"></i> Borrowing History
                    </h2>
                    
                    @if($returnedBooks->isEmpty())
                        <div style="text-align: center; padding: 80px 40px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px;">
                            <i class="fa-solid fa-history" style="font-size: 72px; color: #ccc; margin-bottom: 25px; display: block;"></i>
                            <h3 style="color: #999; font-size: 24px; margin: 0 0 10px 0;">No borrowing history yet</h3>
                            <p style="color: #999; font-size: 16px; margin: 0 0 30px 0;">Start borrowing books to see your history here.</p>
                            <a href="{{ route('books') }}" class="btn primary" style="text-decoration: none; display: inline-flex; align-items: center; gap: 10px; padding: 14px 28px; font-size: 16px; font-weight: 600;">
                                <i class="fa-solid fa-book"></i> Browse Books
                            </a>
                        </div>
                    @else
                        <div style="display: grid; gap: 20px;">
                            @foreach($returnedBooks as $returned)
                            <div style="background: #f8f9fa; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.08); display: flex; gap: 25px; align-items: center; transition: all 0.3s; border-left: 4px solid #28a745;" onmouseover="this.style.boxShadow='0 4px 16px rgba(0,0,0,.15)'; this.style.transform='translateX(5px)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,.08)'; this.style.transform='translateX(0)'">
                                <img src="{{ $returned->book->image ? asset($returned->book->image) : asset('images/book1.jpg') }}" 
                                     alt="{{ $returned->book->title }}" 
                                     style="width: 100px; height: 140px; object-fit: cover; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,.15);"
                                     onerror="this.src='{{ asset('images/book1.jpg') }}'">
                                <div style="flex: 1;">
                                    <h4 style="margin: 0 0 8px 0; color: #1b1f1b; font-size: 22px; font-weight: 700;">{{ $returned->book->title }}</h4>
                                    <p style="margin: 0 0 15px 0; color: #666; font-size: 16px; font-weight: 500;">{{ $returned->book->author }}</p>
                                    <div style="display: flex; gap: 30px; flex-wrap: wrap; font-size: 14px; color: #666;">
                                        <span style="display: flex; align-items: center; gap: 8px;">
                                            <i class="fa-solid fa-calendar-check" style="color: #2e7d32;"></i>
                                            <strong>Borrowed:</strong> {{ $returned->borrowed_at->format('M d, Y') }}
                                        </span>
                                        <span style="display: flex; align-items: center; gap: 8px;">
                                            <i class="fa-solid fa-calendar-times" style="color: #2e7d32;"></i>
                                            <strong>Returned:</strong> {{ $returned->returned_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                </div>
                                <span style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: #fff; font-size: 14px; padding: 10px 20px; border-radius: 20px; font-weight: 700; display: flex; align-items: center; gap: 8px; box-shadow: 0 2px 8px rgba(40,167,69,0.3);">
                                    <i class="fa-solid fa-check-circle"></i> Returned
                                </span>
                            </div>
                            @endforeach
                        </div>
                        
                        @if($returnedBooks->hasPages())
                            <div style="margin-top: 30px; display: flex; justify-content: center;">
                                {{ $returnedBooks->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            @else
                <!-- Currently Borrowed Books -->
                <div style="background: #fff; padding: 35px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,.1);">
                    <h2 style="color: #2e7d32; margin-bottom: 25px; font-size: 28px; display: flex; align-items: center; gap: 12px;">
                        <i class="fa-solid fa-clock"></i> Currently Borrowed ({{ $borrowedBooks->count() }})
                    </h2>
                    
                    @if($borrowedBooks->isEmpty())
                        <div style="text-align: center; padding: 80px 40px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px;">
                            <i class="fa-solid fa-book" style="font-size: 72px; color: #ccc; margin-bottom: 25px; display: block;"></i>
                            <h3 style="color: #999; font-size: 24px; margin: 0 0 10px 0;">No borrowed books at the moment</h3>
                            <p style="color: #999; font-size: 16px; margin: 0 0 30px 0;">Start exploring our collection and borrow your favorite books!</p>
                            <a href="{{ route('books') }}" class="btn primary" style="text-decoration: none; display: inline-flex; align-items: center; gap: 10px; padding: 14px 28px; font-size: 16px; font-weight: 600;">
                                <i class="fa-solid fa-book"></i> Browse Books
                            </a>
                        </div>
                    @else
                        <div style="display: grid; gap: 25px;">
                            @foreach($borrowedBooks as $borrowed)
                            <div style="background: #f8f9fa; padding: 28px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.08); border-left: 5px solid {{ $borrowed->borrow_status === 'pending' ? '#ffc107' : ($borrowed->isOverdue() ? '#dc3545' : '#2e7d32') }}; transition: all 0.3s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(0,0,0,.15)'; this.style.transform='translateX(5px)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,.08)'; this.style.transform='translateX(0)'">
                                <div style="display: flex; gap: 25px; align-items: start;">
                                    <img src="{{ $borrowed->book->image ? asset($borrowed->book->image) : asset('images/book1.jpg') }}" 
                                         alt="{{ $borrowed->book->title }}" 
                                         style="width: 120px; height: 170px; object-fit: cover; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,.15);"
                                         onerror="this.src='{{ asset('images/book1.jpg') }}'">
                                    
                                    <div style="flex: 1;">
                                        <h4 style="margin: 0 0 12px 0; color: #1b1f1b; font-size: 24px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                                            {{ $borrowed->book->title }}
                                            @if($borrowed->borrow_status === 'pending')
                                                <span style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); color: #856404; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                                    <i class="fa-solid fa-hourglass-half"></i> Pending Approval
                                                </span>
                                            @endif
                                        </h4>
                                        <p style="color: #666; margin: 0 0 20px 0; font-size: 16px; font-weight: 500;">{{ $borrowed->book->author }}</p>
                                        
                                        <div style="display: grid; gap: 12px; margin-bottom: 20px;">
                                            <div style="display: flex; align-items: center; gap: 12px; font-size: 15px;">
                                                <i class="fa-solid fa-calendar-check" style="color: #2e7d32; font-size: 18px;"></i>
                                                <span><strong>Borrowed:</strong> {{ $borrowed->borrowed_at->format('M d, Y') }}</span>
                                            </div>
                                            <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                                                <i class="fa-solid fa-calendar-times" style="color: {{ $borrowed->isOverdue() ? '#dc3545' : '#2e7d32' }}; font-size: 18px;"></i>
                                                <span><strong>Due Date:</strong> {{ $borrowed->due_date->format('M d, Y') }}</span>
                                                @if($borrowed->isOverdue())
                                                    <span style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: #fff; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(240,147,251,0.3); margin-left: 10px;">
                                                        <i class="fa-solid fa-exclamation-triangle"></i> {{ $borrowed->daysOverdue() }} days overdue
                                                    </span>
                                                @else
                                                    <span style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: #fff; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(67,233,123,0.3); margin-left: 10px;">
                                                        <i class="fa-solid fa-check-circle"></i> Due in {{ $borrowed->daysUntilDue() }} days
                                                    </span>
                                                @endif
                                            </div>
                                            <div style="display: flex; align-items: center; gap: 12px; font-size: 15px;">
                                                <i class="fa-solid fa-dollar-sign" style="color: #2e7d32; font-size: 18px;"></i>
                                                <span><strong>Fee:</strong> ₱{{ number_format($borrowed->fee, 2) }}</span>
                                            </div>
                                        </div>
                                        
                                        @if($borrowed->isOverdue())
                                            <div style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); padding: 15px; border-radius: 10px; margin-top: 15px; border-left: 4px solid #ffc107; display: flex; align-items: center; gap: 12px;">
                                                <i class="fa-solid fa-exclamation-triangle" style="color: #856404; font-size: 20px;"></i>
                                                <div>
                                                    <strong style="color: #856404; font-size: 15px;">Late Fee:</strong>
                                                    <span style="color: #856404; font-size: 16px; font-weight: 700; margin-left: 8px;">₱{{ number_format($borrowed->daysOverdue() * 1.00, 2) }}</span>
                                                </div>
                                            </div>
                                        @endif

                                        @if($borrowed->canBeRenewed())
                                            <form action="{{ route('renew', $borrowed->id) }}" method="POST" style="margin-top: 20px;">
                                                @csrf
                                                <button type="submit" class="btn primary" style="width: 100%; padding: 14px; font-size: 16px; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 10px;">
                                                    <i class="fa-solid fa-redo"></i> Renew Book ({{ $borrowed->max_renewals - $borrowed->renewal_count }} renewals left)
                                                </button>
                                            </form>
                                        @elseif($borrowed->renewal_count >= $borrowed->max_renewals)
                                            <p style="color: #666; font-size: 14px; margin-top: 15px; padding: 12px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; gap: 8px;">
                                                <i class="fa-solid fa-info-circle" style="color: #17a2b8;"></i> Maximum renewals reached
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </main>
</x-layout>
