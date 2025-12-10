<x-layout title="BookEase • Admin Profile" bodyClass="user-page admin-page">
    <x-admin-header />
    
    <div class="dashboard-layout">
        <x-admin-sidebar />

        <main class="dashboard-main">
            <div class="panel">
                <h2><i class="fa-solid fa-user"></i> Admin Profile</h2>

                @if(session('success'))
                    <div class="alert success"><i class="fa-solid fa-check-circle"></i> {{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert danger">
                        <i class="fa-solid fa-exclamation-circle"></i>
                        <div>
                            <strong>Please fix the following errors:</strong>
                            <ul style="margin: 10px 0 0 20px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Profile Header -->
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 40px; border-radius: 16px; margin-bottom: 35px; display: flex; align-items: center; gap: 30px; box-shadow: 0 8px 32px rgba(0,0,0,.15); position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                    <div style="position: relative; z-index: 1; display: flex; align-items: center; gap: 30px; width: 100%;">
                        <div style="width: 120px; height: 120px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 70px; flex-shrink: 0; box-shadow: 0 4px 16px rgba(0,0,0,.2);">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>
                        <div style="flex: 1;">
                            <h2 style="margin: 0 0 12px 0; font-size: 36px; font-weight: 800;">{{ $user->name }}</h2>
                            <p style="margin: 0 0 10px 0; font-size: 18px; opacity: 0.95; display: flex; align-items: center; gap: 10px;">
                                <i class="fa-solid fa-envelope"></i> {{ $user->email }}
                            </p>
                            <p style="margin: 0; font-size: 15px; opacity: 0.85; display: flex; align-items: center; gap: 10px;">
                                <i class="fa-solid fa-shield-halved"></i> Administrator
                            </p>
                            <p style="margin: 5px 0 0 0; font-size: 14px; opacity: 0.8; display: flex; align-items: center; gap: 10px;">
                                <i class="fa-solid fa-calendar"></i> Admin since {{ $user->created_at->format('F Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; margin-bottom: 35px;">
                    <x-stat-card 
                        icon="fa-solid fa-users"
                        value="{{ $stats['total_users'] }}"
                        label="Total Users"
                        variant="primary"
                        style="simple" />
                    
                    <x-stat-card 
                        icon="fa-solid fa-book"
                        value="{{ $stats['total_books'] }}"
                        label="Total Books"
                        variant="info"
                        style="simple" />
                    
                    <x-stat-card 
                        icon="fa-solid fa-book-open-reader"
                        value="{{ $stats['active_borrowings'] }}"
                        label="Active Borrowings"
                        variant="warning"
                        style="simple" />
                    
                    <x-stat-card 
                        icon="fa-solid fa-exclamation-triangle"
                        value="{{ $stats['overdue_books'] }}"
                        label="Overdue Books"
                        variant="danger"
                        style="simple" />
                    
                    <x-stat-card 
                        icon="fa-solid fa-bookmark"
                        value="{{ $stats['pending_reservations'] }}"
                        label="Pending Reservations"
                        variant="secondary"
                        style="simple" />
                    
                    <x-stat-card 
                        icon="fa-solid fa-dollar-sign"
                        value="₱{{ number_format($stats['total_revenue'], 2) }}"
                        label="Total Revenue"
                        variant="success"
                        style="simple" />
                </div>

                <!-- Personal Information Section -->
                <div style="background: #fff; border-radius: 12px; padding: 30px; margin-bottom: 25px; box-shadow: 0 2px 8px rgba(0,0,0,.1);">
                    <h3 style="color: #2e7d32; margin: 0 0 25px 0; font-size: 24px; display: flex; align-items: center; gap: 12px;">
                        <i class="fa-solid fa-user-edit"></i> Personal Information
                    </h3>
                    
                    <form action="{{ route('admin.info.update') }}" method="POST" style="max-width: 600px;">
                        @csrf
                        @method('PUT')
                        
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
                                <i class="fa-solid fa-user"></i> Full Name
                            </label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 16px; transition: border-color 0.3s;"
                                   onfocus="this.style.borderColor='#2e7d32';" onblur="this.style.borderColor='#ddd';">
                        </div>
                        
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
                                <i class="fa-solid fa-envelope"></i> Email Address
                            </label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 16px; transition: border-color 0.3s;"
                                   onfocus="this.style.borderColor='#2e7d32';" onblur="this.style.borderColor='#ddd';">
                        </div>
                        
                        <button type="submit" style="background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%); color: #fff; padding: 12px 30px; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; display: inline-flex; align-items: center; gap: 10px; box-shadow: 0 4px 12px rgba(46,125,50,.3);"
                                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(46,125,50,.4)';"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(46,125,50,.3)';">
                            <i class="fa-solid fa-save"></i> Update Profile
                        </button>
                    </form>
                </div>

                <!-- Change Password Section -->
                <div style="background: #fff; border-radius: 12px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,.1);">
                    <h3 style="color: #2e7d32; margin: 0 0 25px 0; font-size: 24px; display: flex; align-items: center; gap: 12px;">
                        <i class="fa-solid fa-lock"></i> Change Password
                    </h3>
                    
                    <form action="{{ route('admin.info.password') }}" method="POST" style="max-width: 600px;">
                        @csrf
                        @method('PUT')
                        
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
                                <i class="fa-solid fa-key"></i> Current Password
                            </label>
                            <input type="password" name="current_password" required
                                   style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 16px; transition: border-color 0.3s;"
                                   onfocus="this.style.borderColor='#2e7d32';" onblur="this.style.borderColor='#ddd';">
                        </div>
                        
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
                                <i class="fa-solid fa-lock"></i> New Password
                            </label>
                            <input type="password" name="new_password" required
                                   style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 16px; transition: border-color 0.3s;"
                                   onfocus="this.style.borderColor='#2e7d32';" onblur="this.style.borderColor='#ddd';">
                        </div>
                        
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
                                <i class="fa-solid fa-lock"></i> Confirm New Password
                            </label>
                            <input type="password" name="new_password_confirmation" required
                                   style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 16px; transition: border-color 0.3s;"
                                   onfocus="this.style.borderColor='#2e7d32';" onblur="this.style.borderColor='#ddd';">
                        </div>
                        
                        <button type="submit" style="background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%); color: #fff; padding: 12px 30px; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; display: inline-flex; align-items: center; gap: 10px; box-shadow: 0 4px 12px rgba(46,125,50,.3);"
                                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(46,125,50,.4)';"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(46,125,50,.3)';">
                            <i class="fa-solid fa-key"></i> Change Password
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</x-layout>

