<x-layout title="BookEase • Cart" bodyClass="user-page">
    <x-user-header />

    <main class="user-cart-main">
        <div style="max-width: 1400px; margin: 0 auto; padding: 0 20px;">
            <!-- Hero Section -->
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 50px 40px; border-radius: 16px; margin: 30px 0 40px; text-align: center; box-shadow: 0 8px 32px rgba(0,0,0,.15); position: relative; overflow: hidden;">
                <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: absolute; bottom: -30px; left: -30px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: relative; z-index: 1;">
                    <h1 style="font-size: 42px; font-weight: 800; margin: 0 0 15px 0; text-shadow: 0 2px 10px rgba(0,0,0,.2); display: flex; align-items: center; justify-content: center; gap: 15px;">
                        <i class="fa-solid fa-cart-shopping"></i> Your Shopping Cart
                    </h1>
                    <p style="font-size: 20px; margin: 0; opacity: 0.95; font-weight: 500;">Review your selected books before borrowing</p>
                </div>
            </div>

            @if(session('success'))
                <div style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); color: #155724; padding: 18px 22px; border-radius: 12px; margin-bottom: 30px; border-left: 4px solid #28a745; display: flex; align-items: center; gap: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.1);">
                    <i class="fa-solid fa-check-circle" style="font-size: 22px;"></i>
                    <strong style="font-size: 16px;">{{ session('success') }}</strong>
                </div>
            @endif

            @if(session('error'))
                <div style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); color: #721c24; padding: 18px 22px; border-radius: 12px; margin-bottom: 30px; border-left: 4px solid #dc3545; display: flex; align-items: center; gap: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.1);">
                    <i class="fa-solid fa-exclamation-circle" style="font-size: 22px;"></i>
                    <strong style="font-size: 16px;">{{ session('error') }}</strong>
                </div>
            @endif

            @if(isset($cartItems) && $cartItems->isEmpty())
                <div style="text-align: center; padding: 100px 40px; background: #fff; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,.1);">
                    <i class="fa-solid fa-cart-arrow-down" style="font-size: 80px; color: #ccc; margin-bottom: 25px; display: block;"></i>
                    <h3 style="color: #999; margin: 0 0 15px 0; font-size: 28px;">Your cart is empty</h3>
                    <p style="color: #999; margin: 0 0 35px 0; font-size: 16px;">Start adding books to your cart!</p>
                    <a href="{{ route('books') }}" class="btn primary" style="text-decoration: none; display: inline-flex; align-items: center; gap: 10px; padding: 14px 28px; font-size: 16px; font-weight: 600; box-shadow: 0 4px 16px rgba(46,125,50,0.3); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 6px 24px rgba(46,125,50,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(46,125,50,0.3)'">
                        <i class="fa-solid fa-book"></i> Browse Books
                    </a>
                </div>
            @endif

            @if(isset($cartItems) && $cartItems->isNotEmpty())
                <div style="display: grid; grid-template-columns: 1fr 400px; gap: 30px; margin-bottom: 40px;">
                    <!-- Cart Items -->
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                            <h2 style="color: #2e7d32; margin: 0; font-size: 28px; display: flex; align-items: center; gap: 12px;">
                                <i class="fa-solid fa-book"></i> Cart Items ({{ $cartItems->count() }})
                            </h2>
                            <a href="{{ route('books') }}" style="text-decoration: none; color: #2e7d32; font-weight: 600; display: flex; align-items: center; gap: 8px; padding: 10px 20px; background: #e8f5e9; border-radius: 10px; transition: all 0.3s; font-size: 15px;" onmouseover="this.style.background='#c8e6c9'" onmouseout="this.style.background='#e8f5e9'">
                                <i class="fa-solid fa-arrow-left"></i> Continue Shopping
                            </a>
                        </div>

                        <div style="display: grid; gap: 25px;">
                            @foreach ($cartItems as $item)
                            <div style="background: #fff; padding: 25px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,.1); display: flex; gap: 25px; align-items: start; position: relative; transition: all 0.3s;" onmouseover="this.style.boxShadow='0 8px 32px rgba(0,0,0,.15)'; this.style.transform='translateY(-5px)'" onmouseout="this.style.boxShadow='0 4px 20px rgba(0,0,0,.1)'; this.style.transform='translateY(0)'">
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="position: absolute; top: 20px; right: 20px; z-index: 10;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Remove item" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: #fff; border: none; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(240,147,251,0.3); transition: all 0.3s; font-size: 16px;" onmouseover="this.style.transform='scale(1.15)'; this.style.boxShadow='0 6px 20px rgba(240,147,251,0.5)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 12px rgba(240,147,251,0.3)'">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                                
                                <img src="{{ $item->book->image ? asset($item->book->image) : asset('images/book1.jpg') }}" 
                                     alt="{{ $item->book->title }}" 
                                     style="width: 140px; height: 200px; object-fit: cover; border-radius: 12px; flex-shrink: 0; box-shadow: 0 4px 12px rgba(0,0,0,.15);"
                                     onerror="this.src='{{ asset('images/book1.jpg') }}'">
                                
                                <div style="flex: 1; padding-right: 50px;">
                                    <h3 style="margin: 0 0 10px 0; color: #1b1f1b; font-size: 22px; font-weight: 700;">{{ $item->book->title }}</h3>
                                    <p style="margin: 0 0 12px 0; color: #666; font-size: 16px; font-weight: 500;">{{ $item->book->author }}</p>
                                    
                                    @if($item->book->category)
                                        <div style="margin-bottom: 18px;">
                                            <span style="display: inline-block; background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); color: #2e7d32; padding: 5px 12px; border-radius: 15px; font-size: 13px; font-weight: 600; border: 1px solid #2e7d32;">
                                                <i class="fa-solid fa-tag"></i> {{ $item->book->category }}
                                            </span>
                                        </div>
                                    @endif

                                    <!-- Days to Borrow - Editable -->
                                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px; flex-wrap: wrap; padding: 15px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 10px;">
                                        <label style="font-weight: 600; color: #333; display: flex; align-items: center; gap: 8px; font-size: 15px;">
                                            <i class="fa-solid fa-calendar-days" style="color: #2e7d32; font-size: 18px;"></i> Days to borrow:
                                        </label>
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display: flex; align-items: center; gap: 10px;">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" 
                                                   name="days" 
                                                   value="{{ $item->days }}" 
                                                   min="1" 
                                                   max="365" 
                                                   required
                                                   style="width: 90px; padding: 10px 14px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; text-align: center; font-weight: 600; transition: all 0.3s;"
                                                   onfocus="this.style.borderColor='#2e7d32'; this.style.boxShadow='0 0 0 3px rgba(46,125,50,0.1)'"
                                                   onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'"
                                                   onchange="this.form.submit()">
                                            <span style="color: #666; font-weight: 500;">days</span>
                                        </form>
                                    </div>

                                    <!-- Fee Information -->
                                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 18px; border-radius: 12px; border-left: 4px solid #2e7d32;">
                                        <div>
                                            <div style="font-size: 13px; color: #666; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                                                <i class="fa-solid fa-dollar-sign" style="color: #2e7d32;"></i> Daily Fee
                                            </div>
                                            <div style="font-weight: 700; color: #1b1f1b; font-size: 16px;">
                                                ₱{{ number_format($item->book->rent_fee ?? 0, 2) }}/day
                                            </div>
                                        </div>
                                        <div>
                                            <div style="font-size: 13px; color: #666; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                                                <i class="fa-solid fa-calculator" style="color: #2e7d32;"></i> Rental Fee ({{ $item->days }} days)
                                            </div>
                                            <div style="font-weight: 700; color: #1b1f1b; font-size: 16px;">
                                                ₱{{ number_format($item->fee, 2) }}
                                            </div>
                                        </div>
                                        @if($item->deposit > 0)
                                        <div>
                                            <div style="font-size: 13px; color: #666; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                                                <i class="fa-solid fa-shield-halved" style="color: #2e7d32;"></i> Deposit
                                            </div>
                                            <div style="font-weight: 700; color: #1b1f1b; font-size: 16px;">
                                                ₱{{ number_format($item->deposit, 2) }}
                                            </div>
                                        </div>
                                        @endif
                                        <div>
                                            <div style="font-size: 13px; color: #666; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                                                <i class="fa-solid fa-money-bill-wave" style="color: #2e7d32;"></i> Subtotal
                                            </div>
                                            <div style="font-weight: 800; color: #2e7d32; font-size: 20px;">
                                                ₱{{ number_format($item->fee + $item->deposit, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div style="background: #fff; padding: 30px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,.1); height: fit-content; position: sticky; top: 100px;">
                        <h3 style="color: #2e7d32; margin-bottom: 25px; font-size: 24px; display: flex; align-items: center; gap: 12px;">
                            <i class="fa-solid fa-receipt"></i> Order Summary
                        </h3>
                        
                        <div style="display: grid; gap: 18px; margin-bottom: 25px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 10px;">
                                <span style="color: #666; font-size: 15px; display: flex; align-items: center; gap: 8px;">
                                    <i class="fa-solid fa-book" style="color: #2e7d32;"></i> Items
                                </span>
                                <span style="font-weight: 700; color: #1b1f1b; font-size: 16px;">{{ $cartItems->count() }} book(s)</span>
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 10px;">
                                <span style="color: #666; font-size: 15px; display: flex; align-items: center; gap: 8px;">
                                    <i class="fa-solid fa-money-bill" style="color: #2e7d32;"></i> Total Rental Fee
                                </span>
                                <span style="font-weight: 700; color: #1b1f1b; font-size: 16px;">₱{{ number_format($cartItems->sum('fee'), 2) }}</span>
                            </div>
                            
                            @if($cartItems->sum('deposit') > 0)
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 10px;">
                                <span style="color: #666; font-size: 15px; display: flex; align-items: center; gap: 8px;">
                                    <i class="fa-solid fa-shield-halved" style="color: #2e7d32;"></i> Total Deposit
                                </span>
                                <span style="font-weight: 700; color: #1b1f1b; font-size: 16px;">₱{{ number_format($cartItems->sum('deposit'), 2) }}</span>
                            </div>
                            @endif
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px; background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); border-radius: 12px; border: 2px solid #2e7d32; margin-top: 10px;">
                                <span style="font-size: 20px; font-weight: 700; color: #1b1f1b; display: flex; align-items: center; gap: 10px;">
                                    <i class="fa-solid fa-calculator" style="color: #2e7d32;"></i> Grand Total
                                </span>
                                <span style="font-size: 26px; font-weight: 800; color: #2e7d32;">
                                    ₱{{ number_format($cartItems->sum('fee') + $cartItems->sum('deposit'), 2) }}
                                </span>
                            </div>
                        </div>
                        
                        <form action="{{ route('borrow.confirm') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn primary" style="width: 100%; padding: 16px; font-size: 18px; font-weight: 600; box-shadow: 0 4px 16px rgba(46,125,50,0.3); transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 6px 24px rgba(46,125,50,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(46,125,50,0.3)'">
                                <i class="fa-solid fa-check"></i> Proceed to Borrow
                            </button>
                        </form>

                        <div style="margin-top: 20px; padding: 15px; background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); border-radius: 10px; border-left: 4px solid #ffc107;">
                            <p style="margin: 0; color: #856404; font-size: 13px; line-height: 1.6; display: flex; align-items: start; gap: 10px;">
                                <i class="fa-solid fa-info-circle" style="font-size: 16px; margin-top: 2px;"></i>
                                <span><strong>Note:</strong> Deposit is refundable upon return of books in good condition.</span>
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>
</x-layout>
