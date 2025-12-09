<x-layout title="BookEase • {{ $book->title }}" bodyClass="user-page">
    <x-user-header />

    <main class="user-main">
        <div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
            <!-- Back Button -->
            <a href="{{ route('books') }}" style="display: inline-flex; align-items: center; gap: 8px; color: #2e7d32; text-decoration: none; margin-bottom: 20px; font-weight: 600;">
                <i class="fa-solid fa-arrow-left"></i> Back to Books
            </a>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 40px; margin-bottom: 40px;">
                <!-- Book Image -->
                <div style="background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center;">
                    <img src="{{ $book->image ? asset($book->image) : asset('images/book1.jpg') }}" 
                         alt="{{ $book->title }}" 
                         style="width: 100%; max-width: 400px; height: auto; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);"
                         onerror="this.src='{{ asset('images/book1.jpg') }}'">
                    
                    @if(!$book->isAvailable())
                        <div style="margin-top: 20px; padding: 12px; background: #dc3545; color: white; border-radius: 8px; font-weight: 600;">
                            <i class="fa-solid fa-ban"></i> Currently Unavailable
                        </div>
                    @elseif($book->available_quantity <= 2)
                        <div style="margin-top: 20px; padding: 12px; background: #ffc107; color: #333; border-radius: 8px; font-weight: 600;">
                            <i class="fa-solid fa-exclamation-triangle"></i> Only {{ $book->available_quantity }} left in stock
                        </div>
                    @else
                        <div style="margin-top: 20px; padding: 12px; background: #28a745; color: white; border-radius: 8px; font-weight: 600;">
                            <i class="fa-solid fa-check-circle"></i> Available for Borrowing
                        </div>
                    @endif
                </div>

                <!-- Book Information -->
                <div>
                    <h1 style="color: #2e7d32; margin-bottom: 10px; font-size: 36px;">{{ $book->title }}</h1>
                    <p style="font-size: 20px; color: #666; margin-bottom: 20px;">by <strong>{{ $book->author }}</strong></p>

                    <!-- Book Details Grid -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 30px;">
                        @if($book->isbn)
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                            <div style="font-size: 12px; color: #666; margin-bottom: 5px;">
                                <i class="fa-solid fa-barcode"></i> ISBN
                            </div>
                            <div style="font-weight: 600; color: #333;">{{ $book->isbn }}</div>
                        </div>
                        @endif

                        @if($book->category)
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                            <div style="font-size: 12px; color: #666; margin-bottom: 5px;">
                                <i class="fa-solid fa-tag"></i> Category
                            </div>
                            <div style="font-weight: 600; color: #333;">{{ $book->category }}</div>
                        </div>
                        @endif

                        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                            <div style="font-size: 12px; color: #666; margin-bottom: 5px;">
                                <i class="fa-solid fa-box"></i> Availability
                            </div>
                            <div style="font-weight: 600; color: #333;">
                                {{ $book->available_quantity }} of {{ $book->quantity }} available
                            </div>
                        </div>

                        @if($book->publication_date)
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                            <div style="font-size: 12px; color: #666; margin-bottom: 5px;">
                                <i class="fa-solid fa-calendar"></i> Published
                            </div>
                            <div style="font-weight: 600; color: #333;">
                                {{ $book->publication_year ?? 'N/A' }}
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Pricing Information -->
                    <div style="background: #e8f5e9; padding: 20px; border-radius: 8px; margin-bottom: 30px; border-left: 4px solid #2e7d32;">
                        <h3 style="color: #2e7d32; margin-bottom: 15px;">
                            <i class="fa-solid fa-dollar-sign"></i> Pricing
                        </h3>
                        <div style="display: grid; gap: 10px;">
                            @if($book->rent_fee > 0)
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span><i class="fa-solid fa-calendar-days"></i> Daily Rental Fee:</span>
                                <strong style="font-size: 18px; color: #2e7d32;">₱{{ number_format($book->rent_fee, 2) }}</strong>
                            </div>
                            @endif
                            @if($book->deposit > 0)
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span><i class="fa-solid fa-shield-halved"></i> Deposit (Refundable):</span>
                                <strong style="font-size: 18px; color: #2e7d32;">₱{{ number_format($book->deposit, 2) }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    @if($book->description)
                    <div style="margin-bottom: 30px;">
                        <h3 style="color: #2e7d32; margin-bottom: 15px;">
                            <i class="fa-solid fa-book-open"></i> Description
                        </h3>
                        <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); line-height: 1.8; color: #333;">
                            {{ $book->description }}
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                        @if($book->isAvailable())
                            @if($inCart)
                                <div style="flex: 1; padding: 15px; background: #d1ecf1; border-radius: 8px; text-align: center; color: #0c5460;">
                                    <i class="fa-solid fa-check-circle"></i> Already in Cart
                                </div>
                                <a href="{{ route('cart') }}" class="btn primary" style="text-decoration: none; padding: 15px 30px;">
                                    <i class="fa-solid fa-cart-shopping"></i> View Cart
                                </a>
                            @else
                                <form action="{{ route('cart.add', $book->id) }}" method="POST" style="flex: 1;">
                                    @csrf
                                    <button type="submit" class="btn primary" style="width: 100%; padding: 15px; font-size: 18px; font-weight: 600;">
                                        <i class="fa-solid fa-cart-plus"></i> Add to Cart
                                    </button>
                                </form>
                            @endif
                        @else
                            <form action="{{ route('reserve', $book->id) }}" method="POST" style="flex: 1;">
                                @csrf
                                <button type="submit" class="btn" style="width: 100%; padding: 15px; font-size: 18px; font-weight: 600; background: #17a2b8; color: white;">
                                    <i class="fa-solid fa-bookmark"></i> Reserve This Book
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Related Books -->
            @if($relatedBooks->isNotEmpty())
            <div style="margin-top: 60px;">
                <h2 style="color: #2e7d32; margin-bottom: 30px;">
                    <i class="fa-solid fa-book"></i> Related Books
                </h2>
                <div class="books-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
                    @foreach($relatedBooks as $relatedBook)
                    <a href="{{ route('books.show', $relatedBook->id) }}" class="book-card" style="text-decoration: none; color: inherit;">
                        <img src="{{ $relatedBook->image ? asset($relatedBook->image) : asset('images/book1.jpg') }}" 
                             alt="{{ $relatedBook->title }}"
                             onerror="this.src='{{ asset('images/book1.jpg') }}'">
                        <div class="book-info">
                            <h3>{{ $relatedBook->title }}</h3>
                            <p>{{ $relatedBook->author }}</p>
                            @if($relatedBook->category)
                                <span class="book-category">{{ $relatedBook->category }}</span>
                            @endif
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </main>
</x-layout>

