<x-layout title="BookEase • Home" bodyClass="user-page">
    <x-user-header />

    <main class="user-main">
        <div style="max-width: 1400px; margin: 0 auto; padding: 0 20px;">
            <!-- WELCOME BANNER -->
            <section class="welcome-banner" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 60px 40px; text-align: center; border-radius: 16px; margin: 30px auto 50px; box-shadow: 0 8px 32px rgba(0,0,0,.15); position: relative; overflow: hidden;">
                <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: absolute; bottom: -30px; left: -30px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: relative; z-index: 1;">
                    <h1 style="font-size: 48px; font-weight: 800; margin: 0 0 15px 0; text-shadow: 0 2px 10px rgba(0,0,0,.2);">
                        Welcome{{ session('name') ? ' back, ' . session('name') . '!' : ' to BookEase!' }}
                    </h1>
                    <p style="font-size: 22px; margin: 0; opacity: 0.95; font-weight: 500;">Find It. Borrow it. Love it.</p>
                </div>
            </section>

            @if(session('logged_in') && isset($userStats))
            <!-- USER STATS -->
            <section class="user-stats-section" style="margin-bottom: 50px;">
                <h2 style="color: #2e7d32; margin-bottom: 25px; font-size: 28px; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-chart-line"></i> Your Activity at a Glance
                </h2>
                <div class="user-stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px;">
                    <x-stat-card 
                        icon="fa-solid fa-book-open-reader"
                        value="{{ $userStats['borrowed_count'] }}"
                        label="Books Borrowed"
                        link="{{ route('my.borrowed') }}"
                        linkText="View My Books"
                        variant="primary" />
                    
                    <x-stat-card 
                        icon="fa-solid fa-exclamation-triangle"
                        value="{{ $userStats['overdue_count'] }}"
                        label="Overdue Books"
                        link="{{ route('my.borrowed') }}"
                        linkText="Resolve Now"
                        variant="{{ $userStats['overdue_count'] > 0 ? 'danger' : 'success' }}" />
                    
                    <x-stat-card 
                        icon="fa-solid fa-bookmark"
                        value="{{ $userStats['reservations_count'] }}"
                        label="Active Reservations"
                        link="{{ route('my.reservations') }}"
                        linkText="View Reservations"
                        variant="info" />
                    
                    <x-stat-card 
                        icon="fa-solid fa-cart-shopping"
                        value="{{ $userStats['cart_count'] }}"
                        label="Items in Cart"
                        link="{{ route('cart') }}"
                        linkText="Go to Cart"
                        variant="secondary" />
                </div>
            </section>
            @endif

            <!-- POPULAR BOOKS -->
            <section class="popular-books" style="background: #fff; padding: 40px; border-radius: 16px; margin-bottom: 40px; box-shadow: 0 4px 20px rgba(0,0,0,.1);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
                    <h2 style="color: #2e7d32; margin: 0; font-size: 28px; display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-fire" style="color: #ff6b35;"></i> Popular This Week
                    </h2>
                    <a href="{{ route('books') }}" class="discover-link" style="text-decoration: none; color: #2e7d32; font-weight: 600; display: flex; align-items: center; gap: 8px; padding: 10px 20px; background: #e8f5e9; border-radius: 8px; transition: all 0.3s;" onmouseover="this.style.background='#c8e6c9'" onmouseout="this.style.background='#e8f5e9'">
                        View All <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div class="books-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 25px;">
                    @forelse($popularBooks as $book)
                        <x-book-card :book="$book" />
                    @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #666;">
                        <i class="fa-solid fa-book-open" style="font-size: 64px; margin-bottom: 20px; display: block; color: #ccc;"></i>
                        <h3 style="margin: 0 0 10px 0; color: #999;">No popular books available yet</h3>
                        <p style="margin: 0; color: #999;">Check back soon!</p>
                    </div>
                    @endforelse
                </div>
            </section>

            <!-- RECENTLY ADDED BOOKS -->
            @if(isset($recentBooks) && $recentBooks->isNotEmpty())
            <section class="recently-added-books" style="background: #fff; padding: 40px; border-radius: 16px; margin-bottom: 40px; box-shadow: 0 4px 20px rgba(0,0,0,.1);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
                    <h2 style="color: #2e7d32; margin: 0; font-size: 28px; display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-plus-circle" style="color: #17a2b8;"></i> Recently Added
                    </h2>
                    <a href="{{ route('books') }}" class="discover-link" style="text-decoration: none; color: #2e7d32; font-weight: 600; display: flex; align-items: center; gap: 8px; padding: 10px 20px; background: #e8f5e9; border-radius: 8px; transition: all 0.3s;" onmouseover="this.style.background='#c8e6c9'" onmouseout="this.style.background='#e8f5e9'">
                        View All <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div class="books-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 25px;">
                    @foreach($recentBooks as $book)
                        <x-book-card :book="$book" />
                    @endforeach
                </div>
            </section>
            @endif

            <!-- BROWSE BY CATEGORY -->
            @if(isset($categories) && $categories->isNotEmpty())
            <section class="browse-categories" style="background: #fff; padding: 40px; border-radius: 16px; margin-bottom: 40px; box-shadow: 0 4px 20px rgba(0,0,0,.1);">
                <h2 style="color: #2e7d32; margin: 0 0 30px 0; font-size: 28px; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-tags" style="color: #17a2b8;"></i> Browse by Category
                </h2>
                <div class="category-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;">
                    @foreach($categories as $category)
                    <a href="{{ route('books', ['category' => $category->category]) }}" 
                       class="category-card" 
                       style="background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); color: #2e7d32; padding: 20px; border-radius: 12px; text-decoration: none; font-weight: 600; border: 2px solid #2e7d32; transition: all 0.3s; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,.1);"
                       onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 4px 16px rgba(0,0,0,.2)'; this.style.background='linear-gradient(135deg, #c8e6c9 0%, #a5d6a7 100%)'"
                       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,.1)'; this.style.background='linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%)'">
                        <span style="display: flex; align-items: center; gap: 8px; font-size: 16px;">
                            <i class="fa-solid fa-tag"></i> {{ $category->category }}
                        </span>
                        <span class="category-count" style="background: #2e7d32; color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 14px; font-weight: 700;">{{ $category->count }}</span>
                    </a>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- QUICK ACTIONS -->
            <section class="quick-actions-section" style="margin-bottom: 40px;">
                <h2 style="color: #2e7d32; margin: 0 0 30px 0; font-size: 28px; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-bolt" style="color: #ffc107;"></i> Quick Actions
                </h2>
                <div class="quick-actions-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px;">
                    <a href="{{ route('books') }}" class="action-card browse-books" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 30px; border-radius: 16px; text-decoration: none; box-shadow: 0 4px 20px rgba(0,0,0,.15); transition: all 0.3s; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 8px 32px rgba(0,0,0,.25)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,.15)'">
                        <div style="font-size: 48px; margin-bottom: 15px; opacity: 0.9;">
                            <i class="fa-solid fa-book-reader"></i>
                        </div>
                        <h3 style="margin: 0 0 10px 0; font-size: 22px; font-weight: 700;">Browse All Books</h3>
                        <p style="margin: 0; opacity: 0.9; font-size: 14px; line-height: 1.6;">Explore our extensive collection of books</p>
                    </a>
                    
                    <a href="{{ route('my.borrowed') }}" class="action-card my-books" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: #fff; padding: 30px; border-radius: 16px; text-decoration: none; box-shadow: 0 4px 20px rgba(0,0,0,.15); transition: all 0.3s; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 8px 32px rgba(0,0,0,.25)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,.15)'">
                        <div style="font-size: 48px; margin-bottom: 15px; opacity: 0.9;">
                            <i class="fa-solid fa-book-open-reader"></i>
                        </div>
                        <h3 style="margin: 0 0 10px 0; font-size: 22px; font-weight: 700;">My Borrowed Books</h3>
                        <p style="margin: 0; opacity: 0.9; font-size: 14px; line-height: 1.6;">Check due dates and renew your books</p>
                    </a>
                    
                    <a href="{{ route('my.reservations') }}" class="action-card my-reservations" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: #fff; padding: 30px; border-radius: 16px; text-decoration: none; box-shadow: 0 4px 20px rgba(0,0,0,.15); transition: all 0.3s; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 8px 32px rgba(0,0,0,.25)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,.15)'">
                        <div style="font-size: 48px; margin-bottom: 15px; opacity: 0.9;">
                            <i class="fa-solid fa-bookmark"></i>
                        </div>
                        <h3 style="margin: 0 0 10px 0; font-size: 22px; font-weight: 700;">My Reservations</h3>
                        <p style="margin: 0; opacity: 0.9; font-size: 14px; line-height: 1.6;">Manage your reserved titles</p>
                    </a>
                    
                    <a href="{{ route('cart') }}" class="action-card my-cart" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: #fff; padding: 30px; border-radius: 16px; text-decoration: none; box-shadow: 0 4px 20px rgba(0,0,0,.15); transition: all 0.3s; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 8px 32px rgba(0,0,0,.25)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,.15)'">
                        <div style="font-size: 48px; margin-bottom: 15px; opacity: 0.9;">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </div>
                        <h3 style="margin: 0 0 10px 0; font-size: 22px; font-weight: 700;">My Cart</h3>
                        <p style="margin: 0; opacity: 0.9; font-size: 14px; line-height: 1.6;">Review items before borrowing</p>
                    </a>
                </div>
            </section>
        </div>
    </main>
</x-layout>
