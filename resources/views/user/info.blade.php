<x-layout title="BookEase • Account Information" bodyClass="user-page">
    <x-user-header variant="user-header-light" />

    <div class="user-dashboard-layout">
        <aside class="user-sidebar">
            <a class="user-side-link {{ request()->routeIs('home') || request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('home') }}">
                <i class="fa-solid fa-home"></i> Home
            </a>
            <a class="user-side-link {{ request()->routeIs('books') ? 'active' : '' }}" href="{{ route('books') }}">
                <i class="fa-solid fa-book"></i> Books
            </a>
            <a class="user-side-link {{ request()->routeIs('my.borrowed') ? 'active' : '' }}" href="{{ route('my.borrowed') }}">
                <i class="fa-solid fa-book-open-reader"></i> My Borrowed Books
            </a>
            <a class="user-side-link {{ request()->routeIs('my.reservations') ? 'active' : '' }}" href="{{ route('my.reservations') }}">
                <i class="fa-solid fa-bookmark"></i> My Reservations
            </a>
            <a class="user-side-link {{ request()->routeIs('payment.history') ? 'active' : '' }}" href="{{ route('payment.history') }}">
                <i class="fa-solid fa-dollar-sign"></i> Payment History
            </a>
            <a class="user-side-link {{ request()->routeIs('info') ? 'active' : '' }}" href="{{ route('info') }}">
                <i class="fa-solid fa-user"></i> Account
            </a>
            <a class="user-side-link user-side-logout" href="{{ url('/logout') }}">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </aside>

        <main class="user-dashboard-main">
            <div style="max-width: 1200px; margin: 0 auto;">
                <h1 style="color: #2e7d32; margin-bottom: 35px; font-size: 36px; display: flex; align-items: center; gap: 15px;">
                    <i class="fa-solid fa-user"></i> Account Information
                </h1>

                @if(session('success'))
                    <div style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); color: #155724; padding: 18px 22px; border-radius: 12px; margin-bottom: 30px; border-left: 4px solid #28a745; display: flex; align-items: center; gap: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.1);">
                        <i class="fa-solid fa-check-circle" style="font-size: 22px;"></i>
                        <strong style="font-size: 16px;">{{ session('success') }}</strong>
                    </div>
                @endif

                @if($errors->any())
                    <div style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); color: #721c24; padding: 18px 22px; border-radius: 12px; margin-bottom: 30px; border-left: 4px solid #dc3545; box-shadow: 0 2px 8px rgba(0,0,0,.1);">
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                            <i class="fa-solid fa-exclamation-circle" style="font-size: 22px;"></i>
                            <strong style="font-size: 16px;">Please fix the following errors:</strong>
                        </div>
                        <ul style="margin: 0; padding-left: 25px; font-size: 14px;">
                            @foreach($errors->all() as $error)
                                <li style="margin-bottom: 5px;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Profile Header -->
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 40px; border-radius: 16px; margin-bottom: 35px; display: flex; align-items: center; gap: 30px; box-shadow: 0 8px 32px rgba(0,0,0,.15); position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                    <div style="position: relative; z-index: 1; display: flex; align-items: center; gap: 30px; width: 100%;">
                        <div style="width: 120px; height: 120px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 70px; flex-shrink: 0; box-shadow: 0 4px 16px rgba(0,0,0,.2);">
                            <i class="fa-solid fa-user-circle"></i>
                        </div>
                        <div style="flex: 1;">
                            <h2 style="margin: 0 0 12px 0; font-size: 36px; font-weight: 800;">{{ $user->name }}</h2>
                            <p style="margin: 0 0 10px 0; font-size: 18px; opacity: 0.95; display: flex; align-items: center; gap: 10px;">
                                <i class="fa-solid fa-envelope"></i> {{ $user->email }}
                            </p>
                            <p style="margin: 0; font-size: 15px; opacity: 0.85; display: flex; align-items: center; gap: 10px;">
                                <i class="fa-solid fa-calendar"></i> Member since {{ $user->created_at->format('F Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; margin-bottom: 35px;">
                    <x-stat-card 
                        icon="fa-solid fa-book-open-reader"
                        value="{{ $stats['total_borrowed'] }}"
                        label="Total Borrowed"
                        variant="primary"
                        style="simple" />
                    
                    <x-stat-card 
                        icon="fa-solid fa-clock"
                        value="{{ $stats['currently_borrowed'] }}"
                        label="Currently Borrowed"
                        variant="info"
                        style="simple" />
                    
                    <x-stat-card 
                        icon="fa-solid fa-check-circle"
                        value="{{ $stats['total_returned'] }}"
                        label="Returned"
                        variant="success"
                        style="simple" />
                    
                    <x-stat-card 
                        icon="fa-solid fa-bookmark"
                        value="{{ $stats['reservations'] }}"
                        label="Reservations"
                        variant="secondary"
                        style="simple" />
                    
                    <x-stat-card 
                        icon="fa-solid fa-exclamation-triangle"
                        value="{{ $stats['overdue'] }}"
                        label="Overdue"
                        variant="danger"
                        style="simple" />
                    
                    <x-stat-card 
                        icon="fa-solid fa-dollar-sign"
                        value="₱{{ number_format($stats['total_spent'], 2) }}"
                        label="Total Spent"
                        variant="primary"
                        style="simple" />
                </div>

                <!-- Personal Information Section -->
                <div style="background: #fff; padding: 35px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,.1); margin-bottom: 30px;">
                    <h2 style="color: #2e7d32; margin-bottom: 28px; font-size: 28px; display: flex; align-items: center; gap: 12px;">
                        <i class="fa-solid fa-user-edit"></i> Personal Information
                    </h2>
                    <form action="{{ route('info.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div style="margin-bottom: 22px;">
                            <label style="display: block; margin-bottom: 10px; font-weight: 600; color: #333; font-size: 15px;">
                                <i class="fa-solid fa-user" style="color: #2e7d32; margin-right: 8px;"></i> Full Name
                            </label>
                            <input type="text" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   placeholder="Your full name" 
                                   required
                                   style="width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px; transition: all 0.3s;"
                                   onfocus="this.style.borderColor='#2e7d32'; this.style.boxShadow='0 0 0 3px rgba(46,125,50,0.1)'" 
                                   onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'">
                            @error('name')<span style="color: #dc3545; font-size: 13px; display: block; margin-top: 6px;">{{ $message }}</span>@enderror
                        </div>
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; margin-bottom: 10px; font-weight: 600; color: #333; font-size: 15px;">
                                <i class="fa-solid fa-envelope" style="color: #2e7d32; margin-right: 8px;"></i> Email Address
                            </label>
                            <input type="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   placeholder="your.email@example.com" 
                                   required
                                   style="width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px; transition: all 0.3s;"
                                   onfocus="this.style.borderColor='#2e7d32'; this.style.boxShadow='0 0 0 3px rgba(46,125,50,0.1)'" 
                                   onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'">
                            @error('email')<span style="color: #dc3545; font-size: 13px; display: block; margin-top: 6px;">{{ $message }}</span>@enderror
                        </div>
                        <div style="display: flex; gap: 12px;">
                            <button type="submit" class="btn primary" style="padding: 14px 32px; font-size: 16px; font-weight: 600; box-shadow: 0 4px 16px rgba(46,125,50,0.3); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 24px rgba(46,125,50,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(46,125,50,0.3)'">
                                <i class="fa-solid fa-save"></i> Save Changes
                            </button>
                            <button type="reset" style="background: #6c757d; color: #fff; padding: 14px 32px; font-size: 16px; font-weight: 600; border: none; border-radius: 10px; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='#5a6268'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='#6c757d'; this.style.transform='translateY(0)'">
                                <i class="fa-solid fa-undo"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Change Password Section -->
                <div style="background: #fff; padding: 35px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,.1); margin-bottom: 30px;">
                    <h2 style="color: #2e7d32; margin-bottom: 28px; font-size: 28px; display: flex; align-items: center; gap: 12px;">
                        <i class="fa-solid fa-lock"></i> Change Password
                    </h2>
                    <form action="{{ route('info.password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div style="margin-bottom: 22px;">
                            <label style="display: block; margin-bottom: 10px; font-weight: 600; color: #333; font-size: 15px;">
                                <i class="fa-solid fa-key" style="color: #2e7d32; margin-right: 8px;"></i> Current Password
                            </label>
                            <input type="password" 
                                   name="current_password" 
                                   placeholder="Enter your current password" 
                                   required
                                   style="width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px; transition: all 0.3s;"
                                   onfocus="this.style.borderColor='#2e7d32'; this.style.boxShadow='0 0 0 3px rgba(46,125,50,0.1)'" 
                                   onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'">
                            @error('current_password')<span style="color: #dc3545; font-size: 13px; display: block; margin-top: 6px;">{{ $message }}</span>@enderror
                        </div>
                        <div style="margin-bottom: 22px;">
                            <label style="display: block; margin-bottom: 10px; font-weight: 600; color: #333; font-size: 15px;">
                                <i class="fa-solid fa-lock" style="color: #2e7d32; margin-right: 8px;"></i> New Password
                            </label>
                            <input type="password" 
                                   name="new_password" 
                                   placeholder="Enter your new password (min. 6 characters)" 
                                   required
                                   minlength="6"
                                   style="width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px; transition: all 0.3s;"
                                   onfocus="this.style.borderColor='#2e7d32'; this.style.boxShadow='0 0 0 3px rgba(46,125,50,0.1)'" 
                                   onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'">
                            @error('new_password')<span style="color: #dc3545; font-size: 13px; display: block; margin-top: 6px;">{{ $message }}</span>@enderror
                        </div>
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; margin-bottom: 10px; font-weight: 600; color: #333; font-size: 15px;">
                                <i class="fa-solid fa-lock" style="color: #2e7d32; margin-right: 8px;"></i> Confirm New Password
                            </label>
                            <input type="password" 
                                   name="new_password_confirmation" 
                                   placeholder="Confirm your new password" 
                                   required
                                   minlength="6"
                                   style="width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px; transition: all 0.3s;"
                                   onfocus="this.style.borderColor='#2e7d32'; this.style.boxShadow='0 0 0 3px rgba(46,125,50,0.1)'" 
                                   onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'">
                        </div>
                        <div>
                            <button type="submit" class="btn primary" style="padding: 14px 32px; font-size: 16px; font-weight: 600; box-shadow: 0 4px 16px rgba(46,125,50,0.3); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 24px rgba(46,125,50,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(46,125,50,0.3)'">
                                <i class="fa-solid fa-key"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Account Activity -->
                <div style="background: #fff; padding: 35px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,.1);">
                    <h2 style="color: #2e7d32; margin-bottom: 28px; font-size: 28px; display: flex; align-items: center; gap: 12px;">
                        <i class="fa-solid fa-chart-line"></i> Account Activity
                    </h2>
                    <div style="display: grid; gap: 18px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px; transition: all 0.3s;" onmouseover="this.style.transform='translateX(5px)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,.1)'" onmouseout="this.style.transform='translateX(0)'; this.style.boxShadow='none'">
                            <div>
                                <strong style="color: #1b1f1b; font-size: 16px; display: block; margin-bottom: 6px;">Account Created</strong>
                                <p style="margin: 0; color: #666; font-size: 15px;">{{ $user->created_at->format('F d, Y') }}</p>
                            </div>
                            <i class="fa-solid fa-calendar-check" style="color: #2e7d32; font-size: 28px;"></i>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px; transition: all 0.3s;" onmouseover="this.style.transform='translateX(5px)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,.1)'" onmouseout="this.style.transform='translateX(0)'; this.style.boxShadow='none'">
                            <div>
                                <strong style="color: #1b1f1b; font-size: 16px; display: block; margin-bottom: 6px;">Last Updated</strong>
                                <p style="margin: 0; color: #666; font-size: 15px;">{{ $user->updated_at->format('F d, Y') }}</p>
                            </div>
                            <i class="fa-solid fa-clock" style="color: #2e7d32; font-size: 28px;"></i>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px; transition: all 0.3s;" onmouseover="this.style.transform='translateX(5px)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,.1)'" onmouseout="this.style.transform='translateX(0)'; this.style.boxShadow='none'">
                            <div>
                                <strong style="color: #1b1f1b; font-size: 16px; display: block; margin-bottom: 6px;">Account Status</strong>
                                <p style="margin: 0; color: #666; font-size: 15px;">Active</p>
                            </div>
                            <span style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: #fff; font-size: 14px; padding: 10px 20px; border-radius: 20px; font-weight: 700; display: flex; align-items: center; gap: 8px; box-shadow: 0 2px 8px rgba(40,167,69,0.3);">
                                <i class="fa-solid fa-check-circle"></i> Verified
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-layout>
