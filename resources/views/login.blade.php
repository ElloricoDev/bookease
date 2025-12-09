<x-layout title="BookEase • User Login">
    <x-user-header :showSearch="false" />

    <main>
        <section class="auth-card">
            <div class="auth-logo">
                <svg class="logo-mark" width="56" height="56" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <rect x="3" y="3" width="14" height="18" rx="2" ry="2" fill="#4CAF50"/>
                    <path d="M7 7h6M7 10h6M7 13h6" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M17 5c1.105 0 2 .895 2 2v11c-1.143-.762-2.857-.762-4 0V7c0-1.105.895-2 2-2Z" fill="#2e7d32"/>
                </svg>
                <h1>User Login</h1>
            </div>

            @if(session('success'))
                <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-check-circle" style="font-size: 20px;"></i>
                    <div>
                        <strong style="display: block; margin-bottom: 5px;">{{ session('success') }}</strong>
                        <span style="font-size: 14px;">Please login to continue.</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-exclamation-circle" style="font-size: 20px;"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                    <i class="fa-solid fa-exclamation-circle" style="margin-right: 8px;"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul style="margin: 10px 0 0 20px; padding: 0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="auth-form" id="userLoginForm" method="POST" action="{{ route('login.perform') }}">
                @csrf

                <div class="input-wrapper">
                    <i class="fa-solid fa-envelope input-icon"></i>
                    <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                </div>

                <div class="password-field">
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input type="password" name="password" placeholder="Password" minlength="6" required>
                    </div>
                    <button type="button" class="toggle-pass" aria-label="Show password">
                        <i class="fa-solid fa-eye"></i> Show
                    </button>
                </div>

                <div class="auth-links">
                    <a href=""><i class="fa-solid fa-key"></i> Forgot password?</a>
                </div>

                <button type="submit" class="btn primary">
                    <i class="fa-solid fa-right-to-bracket"></i> Log in
                </button>
                <a class="btn" href="{{ route('register')}}">
                    <i class="fa-solid fa-user-plus"></i> Sign-up
                </a>
            </form>
        </section>
    </main>
</x-layout>
