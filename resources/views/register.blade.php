<x-layout title="BookEase • User Register">
    <x-user-header :showSearch="false" />

    <main>
        <section class="auth-card">
            <div class="auth-title">
                <i class="fa-solid fa-user-plus"></i> REGISTER
            </div>

            <form class="auth-form" method="POST" action="{{ route('register.perform') }}">
                @csrf

                <div class="input-wrapper">
                    <i class="fa-solid fa-user input-icon"></i>
                    <input type="text" name="name" placeholder="Full Name" required>
                </div>

                <div class="input-wrapper">
                    <i class="fa-solid fa-envelope input-icon"></i>
                    <input type="email" name="email" placeholder="Email" required>
                </div>

                <div class="password-field">
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input type="password" name="password" placeholder="Password" minlength="6" required>
                    </div>
                    <button type="button" class="toggle-pass">
                        <i class="fa-solid fa-eye"></i> Show
                    </button>
                </div>

                <div class="auth-links">
                    <a href="{{ route('login') }}">
                        <i class="fa-solid fa-sign-in-alt"></i> Already have an account? Login here.
                    </a>
                </div>

                <button type="submit" class="btn primary">
                    <i class="fa-solid fa-user-plus"></i> Register
                </button>
            </form>
        </section>
    </main>
</x-layout>
