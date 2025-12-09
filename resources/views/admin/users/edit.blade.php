<x-layout title="BookEase • Edit User" bodyClass="user-page admin-page">
    <x-admin-header />
    
    <div class="dashboard-layout">
        <x-admin-sidebar />

        <main class="dashboard-main">
            <div class="panel">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px;">
                    <h2 style="margin: 0;"><i class="fa-solid fa-user-pen"></i> Edit User</h2>
                    <a href="{{ route('user_management') }}" class="btn" style="background: #6c757d; color: #fff; text-decoration: none;">
                        <i class="fa-solid fa-arrow-left"></i> Back to Users
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert success" style="background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                        <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert danger" style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                        <i class="fa-solid fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('users.update', $user->id) }}" method="POST" style="background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); max-width: 700px; margin: 0 auto;">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom: 30px;">
                        <h3 style="color: #2e7d32; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #e0e0e0;">
                            <i class="fa-solid fa-user"></i> Personal Information
                        </h3>
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; font-weight: 600; color: #333;">
                                    <i class="fa-solid fa-user" style="color: #2e7d32;"></i> Full Name *
                                </label>
                                <div style="position: relative;">
                                    <i class="fa-solid fa-user" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                                           style="width: 100%; padding: 12px 12px 12px 40px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s;"
                                           onfocus="this.style.borderColor='#2e7d32'" onblur="this.style.borderColor='#e0e0e0'"
                                           placeholder="Enter full name">
                                </div>
                                @error('name')<span style="color: #dc3545; font-size: 12px; display: block; margin-top: 5px;"><i class="fa-solid fa-exclamation-circle"></i> {{ $message }}</span>@enderror
                            </div>

                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; font-weight: 600; color: #333;">
                                    <i class="fa-solid fa-envelope" style="color: #2e7d32;"></i> Email Address *
                                </label>
                                <div style="position: relative;">
                                    <i class="fa-solid fa-envelope" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                                           style="width: 100%; padding: 12px 12px 12px 40px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s;"
                                           onfocus="this.style.borderColor='#2e7d32'" onblur="this.style.borderColor='#e0e0e0'"
                                           placeholder="user@example.com">
                                </div>
                                @error('email')<span style="color: #dc3545; font-size: 12px; display: block; margin-top: 5px;"><i class="fa-solid fa-exclamation-circle"></i> {{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div style="margin-bottom: 30px;">
                        <h3 style="color: #2e7d32; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #e0e0e0;">
                            <i class="fa-solid fa-user-shield"></i> Account Settings
                        </h3>
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; font-weight: 600; color: #333;">
                                    <i class="fa-solid fa-user-tag" style="color: #2e7d32;"></i> Role *
                                </label>
                                <div style="position: relative;">
                                    <i class="fa-solid fa-user-tag" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #999; z-index: 1;"></i>
                                    <select name="role" required 
                                            style="width: 100%; padding: 12px 12px 12px 40px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; background: #fff; cursor: pointer; transition: border-color 0.3s;"
                                            onfocus="this.style.borderColor='#2e7d32'" onblur="this.style.borderColor='#e0e0e0'">
                                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </div>
                                @error('role')<span style="color: #dc3545; font-size: 12px; display: block; margin-top: 5px;"><i class="fa-solid fa-exclamation-circle"></i> {{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div style="background: #fff3cd; padding: 15px; border-radius: 8px; border-left: 4px solid #ffc107; margin-top: 15px;">
                            <p style="margin: 0; color: #856404; font-size: 14px;">
                                <i class="fa-solid fa-info-circle"></i> <strong>Note:</strong> Password changes are not available through this form. Contact the administrator for password reset.
                            </p>
                        </div>
                    </div>

                    <div style="display: flex; gap: 15px; justify-content: flex-end; margin-top: 30px; padding-top: 20px; border-top: 2px solid #e0e0e0;">
                        <a href="{{ route('user_management') }}" id="cancelBtn" class="btn" style="background: #6c757d; color: #fff; text-decoration: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-arrow-left"></i> Cancel
                        </a>
                        <button type="submit" class="btn primary" style="padding: 12px 24px; border-radius: 8px; font-weight: 600; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px; border: none; cursor: pointer;">
                            <i class="fa-solid fa-save"></i> Update User
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10000; align-items: center; justify-content: center;">
        <div style="background: #fff; border-radius: 12px; padding: 30px; max-width: 500px; width: 90%; box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
            <div style="text-align: center; margin-bottom: 25px;">
                <div style="width: 60px; height: 60px; background: #fff3cd; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                    <i class="fa-solid fa-exclamation-triangle" style="font-size: 30px; color: #ffc107;"></i>
                </div>
                <h3 style="margin: 0 0 10px 0; color: #333; font-size: 22px;">Confirm Cancel</h3>
                <p id="confirmMessage" style="margin: 0; color: #666; font-size: 16px; line-height: 1.5;"></p>
            </div>
            <div style="display: flex; gap: 15px; justify-content: flex-end;">
                <button id="confirmCancel" style="padding: 12px 24px; border: 2px solid #6c757d; background: #fff; color: #6c757d; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s; font-size: 16px;">
                    <i class="fa-solid fa-times"></i> No, Keep Editing
                </button>
                <a id="confirmProceed" href="{{ route('user_management') }}" style="padding: 12px 24px; background: #dc3545; color: #fff; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s; font-size: 16px;">
                    <i class="fa-solid fa-check"></i> Yes, Cancel
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const cancelBtn = document.getElementById('cancelBtn');
            const confirmModal = document.getElementById('confirmModal');
            const confirmMessage = document.getElementById('confirmMessage');
            const confirmCancel = document.getElementById('confirmCancel');
            const initialValues = {};

            // Store initial form values
            function storeInitialValues() {
                const inputs = form.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    if (input.type === 'file') {
                        initialValues[input.name] = input.files.length;
                    } else if (input.type === 'checkbox' || input.type === 'radio') {
                        initialValues[input.name] = input.checked;
                    } else {
                        initialValues[input.name] = input.value;
                    }
                });
            }

            // Check if form data has changed
            function hasFormChanged() {
                const inputs = form.querySelectorAll('input, select, textarea');
                
                for (let input of inputs) {
                    let currentValue;
                    
                    if (input.type === 'file') {
                        currentValue = input.files.length;
                    } else if (input.type === 'checkbox' || input.type === 'radio') {
                        currentValue = input.checked;
                    } else {
                        currentValue = input.value;
                    }
                    
                    if (initialValues[input.name] !== currentValue) {
                        return true;
                    }
                }
                
                return false;
            }

            // Show confirmation modal
            function showConfirmModal(message) {
                confirmMessage.textContent = message;
                confirmModal.style.display = 'flex';
            }

            // Hide confirmation modal
            function hideConfirmModal() {
                confirmModal.style.display = 'none';
            }

            // Store initial values on page load
            storeInitialValues();

            // Handle cancel button click
            cancelBtn.addEventListener('click', function(e) {
                if (hasFormChanged()) {
                    e.preventDefault();
                    showConfirmModal('You have unsaved changes. Are you sure you want to cancel? All changes will be lost.');
                }
            });

            // Handle modal buttons
            confirmCancel.addEventListener('click', hideConfirmModal);
            confirmModal.addEventListener('click', function(e) {
                if (e.target === confirmModal) {
                    hideConfirmModal();
                }
            });
        });
    </script>
</x-layout>
