<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'BookEase' }}</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Base CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!-- Admin CSS -->
    @if(str_contains($bodyClass ?? '', 'admin-page'))
        <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">
    @endif
    
    <!-- Charts CSS -->
    @stack('styles')
</head>
<body class="{{ $bodyClass ?? '' }}">
    {{ $slot }}
    
    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10000; align-items: center; justify-content: center;">
        <div style="background: #fff; border-radius: 12px; padding: 30px; max-width: 450px; width: 90%; box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
            <div style="text-align: center; margin-bottom: 25px;">
                <div style="width: 60px; height: 60px; background: #fff3cd; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                    <i class="fa-solid fa-right-from-bracket" style="font-size: 30px; color: #ffc107;"></i>
                </div>
                <h3 style="margin: 0 0 10px 0; color: #333; font-size: 22px;">Confirm Logout</h3>
                <p id="logoutMessage" style="margin: 0; color: #666; font-size: 16px; line-height: 1.5;">Are you sure you want to logout? You will need to login again to access your account.</p>
            </div>
            <div style="display: flex; gap: 15px; justify-content: flex-end;">
                <button id="logoutCancel" style="padding: 12px 24px; border: 2px solid #6c757d; background: #fff; color: #6c757d; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s; font-size: 16px;">
                    <i class="fa-solid fa-times"></i> Cancel
                </button>
                <a id="logoutConfirm" href="{{ url('/logout') }}" style="padding: 12px 24px; background: #dc3545; color: #fff; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s; font-size: 16px;">
                    <i class="fa-solid fa-right-from-bracket"></i> Yes, Logout
                </a>
            </div>
        </div>
    </div>
    
    <!-- Base JS -->
    <script src="{{ asset('js/script.js') }}"></script>
    
    <!-- Logout Confirmation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoutModal = document.getElementById('logoutModal');
            const logoutCancel = document.getElementById('logoutCancel');
            const logoutConfirm = document.getElementById('logoutConfirm');
            const logoutLinks = document.querySelectorAll('.logout-link, .side-logout, .user-side-logout');
            
            // Show logout confirmation modal
            function showLogoutModal() {
                logoutModal.style.display = 'flex';
            }
            
            // Hide logout confirmation modal
            function hideLogoutModal() {
                logoutModal.style.display = 'none';
            }
            
            // Handle logout link clicks
            logoutLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    showLogoutModal();
                });
            });
            
            // Handle modal buttons
            logoutCancel.addEventListener('click', hideLogoutModal);
            
            // Close modal when clicking outside
            logoutModal.addEventListener('click', function(e) {
                if (e.target === logoutModal) {
                    hideLogoutModal();
                }
            });
            
            // Close modal on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && logoutModal.style.display === 'flex') {
                    hideLogoutModal();
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>

