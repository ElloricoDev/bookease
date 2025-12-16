@props([
    'book',
    'showActions' => true,
    'showAvailability' => true,
    'showCategory' => true,
    'showPrice' => true
])

<a href="{{ route('books.show', $book->id) }}" style="text-decoration: none; color: inherit; display: block; background: #fff; border-radius: 16px; padding: 18px; box-shadow: 0 4px 20px rgba(0,0,0,.1); transition: all 0.3s; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 12px 40px rgba(0,0,0,.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,.1)'">
        @if($showAvailability)
            @if(!$book->isAvailable() && $book->status === 'unavailable')
            <div style="position: absolute; top: 15px; right: 15px; z-index: 10; background: rgba(220, 53, 69, 0.95); color: white; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 5px; box-shadow: 0 2px 8px rgba(0,0,0,.2);">
                <i class="fa-solid fa-ban"></i> Unavailable
            </div>
        @elseif($book->available_quantity <= 2)
            <div style="position: absolute; top: 15px; right: 15px; z-index: 10; background: rgba(255, 193, 7, 0.95); color: #333; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 5px; box-shadow: 0 2px 8px rgba(0,0,0,.2);">
                <i class="fa-solid fa-exclamation-triangle"></i> Only {{ $book->available_quantity }} left
            </div>
        @else
            <div style="position: absolute; top: 15px; right: 15px; z-index: 10; background: rgba(40, 167, 69, 0.95); color: white; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 5px; box-shadow: 0 2px 8px rgba(0,0,0,.2);">
                <i class="fa-solid fa-check-circle"></i> Available
            </div>
        @endif
    @endif
    
    <div style="position: relative; margin-bottom: 18px;">
        <img src="{{ $book->image ? asset($book->image) : asset('images/book1.jpg') }}" 
             alt="{{ $book->title }}" 
             style="width: 100%; height: 300px; object-fit: cover; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,.15); transition: transform 0.3s;"
             onerror="this.src='{{ asset('images/book1.jpg') }}'"
             onmouseover="this.style.transform='scale(1.05)'"
             onmouseout="this.style.transform='scale(1)'">
        
        @if($showActions)
            @if($book->isAvailable())
                <form action="{{ route('cart.add', $book->id) }}" method="POST" style="position: absolute; bottom: 15px; right: 15px; z-index: 10;" onclick="event.stopPropagation();">
                    @csrf
                    <button type="submit" title="Add to cart" style="background: #2e7d32; color: #fff; border: none; width: 50px; height: 50px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 16px rgba(0,0,0,.3); transition: all 0.3s; font-size: 20px;" onmouseover="this.style.transform='scale(1.15)'; this.style.background='#1b5e20'" onmouseout="this.style.transform='scale(1)'; this.style.background='#2e7d32'">
                        <i class="fa-solid fa-cart-plus"></i>
                    </button>
                </form>
            @elseif($book->canBeReserved())
                <form action="{{ route('reserve', $book->id) }}" method="POST" style="position: absolute; bottom: 15px; right: 15px; z-index: 10;" onclick="event.stopPropagation();">
                    @csrf
                    <button type="submit" title="Reserve this book" style="background: #17a2b8; color: #fff; border: none; width: 50px; height: 50px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 16px rgba(0,0,0,.3); transition: all 0.3s; font-size: 20px;" onmouseover="this.style.transform='scale(1.15)'; this.style.background='#138496'" onmouseout="this.style.transform='scale(1)'; this.style.background='#17a2b8'">
                        <i class="fa-solid fa-bookmark"></i>
                    </button>
                </form>
            @endif
        @endif
    </div>
    
    <div style="padding: 0 5px;">
        <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 8px 0; color: #1b1f1b; line-height: 1.4; min-height: 50px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $book->title }}</h3>
        <p style="font-size: 14px; color: #666; margin: 0 0 12px 0; font-weight: 500;">{{ $book->author }}</p>
        
        @if($showCategory && $book->category)
            <div style="margin-bottom: 12px;">
                <span style="display: inline-block; background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); color: #2e7d32; padding: 5px 12px; border-radius: 15px; font-size: 12px; font-weight: 600; border: 1px solid #2e7d32;">
                    <i class="fa-solid fa-tag"></i> {{ $book->category }}
                </span>
            </div>
        @endif
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; padding-top: 15px; border-top: 2px solid #f0f0f0;">
            @if($showAvailability)
                <div style="display: flex; align-items: center; gap: 8px; font-size: 13px;">
                    <i class="fa-solid fa-{{ $book->isAvailable() ? 'check' : 'ban' }}-circle" style="color: {{ $book->isAvailable() ? '#2e7d32' : '#dc3545' }}; font-size: 16px;"></i>
                    <span style="color: #666; font-weight: 600;">{{ $book->available_quantity }} left</span>
                </div>
            @endif
            @if($showPrice && $book->rent_fee > 0)
                <div style="color: #2e7d32; font-weight: 700; font-size: 15px;">
                    <i class="fa-solid fa-peso-sign"></i> {{ number_format($book->rent_fee, 2) }}/day
                </div>
            @endif
        </div>
    </div>
</a>

