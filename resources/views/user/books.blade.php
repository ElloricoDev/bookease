<x-layout title="BookEase • Books" bodyClass="user-page">
    <x-user-header />

    <main class="user-main">
        <div style="max-width: 1400px; margin: 0 auto; padding: 0 20px;">
            <!-- Hero Section -->
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 50px 40px; border-radius: 16px; margin: 30px 0 40px; text-align: center; box-shadow: 0 8px 32px rgba(0,0,0,.15); position: relative; overflow: hidden;">
                <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: absolute; bottom: -30px; left: -30px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: relative; z-index: 1;">
                    <h1 style="font-size: 42px; font-weight: 800; margin: 0 0 15px 0; text-shadow: 0 2px 10px rgba(0,0,0,.2);">
                        <i class="fa-solid fa-book-open"></i> Browse Our Collection
                    </h1>
                    <p style="font-size: 20px; margin: 0; opacity: 0.95; font-weight: 500;">Discover thousands of books waiting for you</p>
                </div>
            </div>

            <!-- Toolbar -->
            <div style="background: #fff; padding: 20px; border-radius: 16px; margin-bottom: 30px; box-shadow: 0 4px 20px rgba(0,0,0,.1); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
                    <button onclick="toggleFilterPanel()" class="btn primary" style="display: flex; align-items: center; gap: 8px; padding: 12px 20px;">
                        <i class="fa-solid fa-filter"></i> Filters
                    </button>
                    <form method="GET" action="{{ route('books') }}" style="display: inline;">
                        @if(request('q'))<input type="hidden" name="q" value="{{ request('q') }}">@endif
                        @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                        @if(request('availability'))<input type="hidden" name="availability" value="{{ request('availability') }}">@endif
                        <select name="sort" onchange="this.form.submit()" style="padding: 12px 18px; border: 2px solid #2e7d32; border-radius: 10px; background: #fff; color: #333; font-weight: 600; cursor: pointer; font-size: 14px; transition: all 0.3s;" onmouseover="this.style.borderColor='#1b5e20'" onmouseout="this.style.borderColor='#2e7d32'">
                            <option value="popularity" {{ request('sort') == 'popularity' ? 'selected' : '' }}>Sort: Popularity</option>
                            <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Title (A-Z)</option>
                            <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Title (Z-A)</option>
                            <option value="author_asc" {{ request('sort') == 'author_asc' ? 'selected' : '' }}>Author (A-Z)</option>
                            <option value="author_desc" {{ request('sort') == 'author_desc' ? 'selected' : '' }}>Author (Z-A)</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </form>
                </div>
                <a href="{{ route('cart') }}" style="position: relative; text-decoration: none; color: #2e7d32; font-size: 24px; padding: 12px; background: #e8f5e9; border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,.1);" onmouseover="this.style.background='#c8e6c9'; this.style.transform='scale(1.1)'" onmouseout="this.style.background='#e8f5e9'; this.style.transform='scale(1)'">
                    <i class="fa-solid fa-cart-shopping"></i>
                    @if($cartCount > 0)
                        <span style="position: absolute; top: -2px; right: -2px; background: #dc3545; color: #fff; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; border: 3px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,.2);">{{ $cartCount }}</span>
                    @endif
                </a>
            </div>

            <!-- Filter Panel -->
            <div id="filterPanel" style="display: none; background: #fff; padding: 30px; border-radius: 16px; margin-bottom: 30px; box-shadow: 0 4px 20px rgba(0,0,0,.1);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <h3 style="color: #2e7d32; margin: 0; font-size: 24px; display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-filter"></i> Filter Books
                    </h3>
                    <button onclick="toggleFilterPanel()" style="background: none; border: none; color: #666; font-size: 24px; cursor: pointer; padding: 5px; transition: color 0.3s;" onmouseover="this.style.color='#dc3545'" onmouseout="this.style.color='#666'">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
                <form method="GET" action="{{ route('books') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px;">
                    @if(request('q'))<input type="hidden" name="q" value="{{ request('q') }}">@endif
                    @if(request('sort'))<input type="hidden" name="sort" value="{{ request('sort') }}">@endif
                    
                    <div>
                        <label style="display: block; margin-bottom: 10px; font-weight: 600; color: #333; font-size: 15px;">
                            <i class="fa-solid fa-tags" style="color: #2e7d32; margin-right: 8px;"></i> Category
                        </label>
                        <select name="category" style="width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s; cursor: pointer;" onfocus="this.style.borderColor='#2e7d32'; this.style.boxShadow='0 0 0 3px rgba(46,125,50,0.1)'" onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->category }}" {{ request('category') == $category->category ? 'selected' : '' }}>
                                    {{ $category->category }} ({{ $category->count }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 10px; font-weight: 600; color: #333; font-size: 15px;">
                            <i class="fa-solid fa-check-circle" style="color: #2e7d32; margin-right: 8px;"></i> Availability
                        </label>
                        <select name="availability" style="width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s; cursor: pointer;" onfocus="this.style.borderColor='#2e7d32'; this.style.boxShadow='0 0 0 3px rgba(46,125,50,0.1)'" onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'">
                            <option value="">All Books</option>
                            <option value="available" {{ request('availability') == 'available' ? 'selected' : '' }}>Available Only</option>
                            <option value="unavailable" {{ request('availability') == 'unavailable' ? 'selected' : '' }}>Unavailable Only</option>
                        </select>
                    </div>
                    
                    <div style="display: flex; align-items: flex-end; gap: 12px;">
                        <button type="submit" class="btn primary" style="flex: 1; padding: 14px; font-size: 16px; font-weight: 600;">
                            <i class="fa-solid fa-filter"></i> Apply Filters
                        </button>
                        <a href="{{ route('books') }}" class="btn" style="background: #6c757d; color: #fff; text-decoration: none; padding: 14px 24px; border-radius: 10px; display: flex; align-items: center; gap: 8px; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.background='#5a6268'" onmouseout="this.style.background='#6c757d'">
                            <i class="fa-solid fa-times"></i> Clear
                        </a>
                    </div>
                </form>
            </div>

            @if(session('success'))
                <div style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); color: #155724; padding: 18px 20px; border-radius: 12px; margin-bottom: 25px; border-left: 4px solid #28a745; display: flex; align-items: center; gap: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.1);">
                    <i class="fa-solid fa-check-circle" style="font-size: 22px;"></i>
                    <strong style="font-size: 16px;">{{ session('success') }}</strong>
                </div>
            @endif

            @if(session('error'))
                <div style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); color: #721c24; padding: 18px 20px; border-radius: 12px; margin-bottom: 25px; border-left: 4px solid #dc3545; display: flex; align-items: center; gap: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.1);">
                    <i class="fa-solid fa-exclamation-circle" style="font-size: 22px;"></i>
                    <strong style="font-size: 16px;">{{ session('error') }}</strong>
                </div>
            @endif

            @if(session('info'))
                <div style="background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%); color: #0c5460; padding: 18px 20px; border-radius: 12px; margin-bottom: 25px; border-left: 4px solid #17a2b8; display: flex; align-items: center; gap: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.1);">
                    <i class="fa-solid fa-info-circle" style="font-size: 22px;"></i>
                    <strong style="font-size: 16px;">{{ session('info') }}</strong>
                </div>
            @endif

            <!-- Search Bar -->
            <form method="GET" action="{{ route('books') }}" style="background: #fff; padding: 18px 24px; border-radius: 16px; margin-bottom: 30px; box-shadow: 0 4px 20px rgba(0,0,0,.1); display: flex; align-items: center; gap: 15px; border: 2px solid #e0e0e0; transition: all 0.3s;" onfocuswith="this.style.borderColor='#2e7d32'; this.style.boxShadow='0 0 0 4px rgba(46,125,50,0.1)'">
                @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                @if(request('availability'))<input type="hidden" name="availability" value="{{ request('availability') }}">@endif
                @if(request('sort'))<input type="hidden" name="sort" value="{{ request('sort') }}">@endif
                <i class="fa-solid fa-magnifying-glass" style="color: #2e7d32; font-size: 20px;"></i>
                <input type="search" name="q" placeholder="Search books by title, author, ISBN, or category..." value="{{ request('q') }}" style="flex: 1; border: none; outline: none; font-size: 16px; padding: 5px; color: #333;">
            </form>

            <!-- Results Count -->
            @if(request()->hasAny(['q', 'category', 'availability']))
                <div style="background: #fff; padding: 18px 24px; border-radius: 12px; margin-bottom: 25px; box-shadow: 0 2px 8px rgba(0,0,0,.1); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                    <div style="color: #666; font-size: 15px; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-info-circle" style="color: #2e7d32;"></i>
                        Found <strong style="color: #2e7d32; font-size: 18px; margin: 0 5px;">{{ $books->total() }}</strong> book(s)
                        @if(request('q'))
                            matching "<strong>{{ request('q') }}</strong>"
                        @endif
                    </div>
                    <a href="{{ route('books') }}" style="color: #2e7d32; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 6px; font-size: 14px; padding: 8px 16px; background: #e8f5e9; border-radius: 8px; transition: all 0.3s;" onmouseover="this.style.background='#c8e6c9'" onmouseout="this.style.background='#e8f5e9'">
                        <i class="fa-solid fa-times-circle"></i> Clear All Filters
                    </a>
                </div>
            @endif

            <!-- Books Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px; margin-bottom: 40px;">
                @forelse($books as $book)
                    <x-book-card :book="$book" />
                @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 100px 20px; background: #fff; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,.1);">
                    <i class="fa-solid fa-book-open" style="font-size: 80px; margin-bottom: 25px; display: block; color: #ccc;"></i>
                    <h3 style="margin: 0 0 15px 0; color: #999; font-size: 28px;">No books found</h3>
                    <p style="margin: 0 0 35px 0; color: #999; font-size: 16px;">Try adjusting your search or filters.</p>
                    <a href="{{ route('books') }}" class="btn primary" style="text-decoration: none; display: inline-flex; align-items: center; gap: 10px; padding: 14px 28px; font-size: 16px; font-weight: 600;">
                        <i class="fa-solid fa-arrow-left"></i> Clear Filters
                    </a>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($books->hasPages())
                <div style="margin-top: 50px; display: flex; justify-content: center;">
                    {{ $books->links() }}
                </div>
            @endif
        </div>
    </main>

    <script>
        function toggleFilterPanel() {
            const panel = document.getElementById('filterPanel');
            panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</x-layout>
