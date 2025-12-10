<x-layout title="BookEase • User Management" bodyClass="user-page admin-page">
    <x-admin-header />
    
    <div class="dashboard-layout">
        <x-admin-sidebar />

        <main class="dashboard-main">
            <div class="panel">
                <h2><i class="fa-solid fa-users"></i> User Management</h2>

                <div class="table-toolbar">
                    <x-admin-search 
                        id="userSearch" 
                        placeholder="Search by Name, Email, or ID"
                        tableId="usersTable"
                        :searchFields="['name', 'email', 'id']"
                    >
                        <select id="roleFilter" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 6px; background: #fff; cursor: pointer; font-size: 14px; color: #333; outline: none;">
                            <option value="all">All Roles</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </x-admin-search>
                    <a href="{{ route('users.create') }}" class="btn primary"><i class="fa-solid fa-plus"></i> Add User</a>
                </div>

                <div class="table-wrap">
                    @if(session('success'))
                        <div class="alert success"><i class="fa-solid fa-check-circle"></i> {{ session('success') }}</div>
                    @endif

                    <table class="table" id="usersTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr 
                                data-id="{{ $user->id }}" 
                                data-name="{{ strtolower($user->name) }}" 
                                data-email="{{ strtolower($user->email) }}" 
                                data-role="{{ strtolower($user->role) }}"
                            >
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><span class="badge">{{ ucfirst($user->role) }}</span></td>
                                <td><span class="badge success">Active</span></td>
                                <td>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn small">
                                        <i class="fa-solid fa-edit"></i> Edit
                                    </a>
                                    <button class="btn small danger delete-user-btn" type="button" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" data-user-email="{{ $user->email }}">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10000; align-items: center; justify-content: center;">
        <div style="background: #fff; border-radius: 12px; padding: 30px; max-width: 500px; width: 90%; box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
            <div style="text-align: center; margin-bottom: 25px;">
                <div style="width: 60px; height: 60px; background: #f8d7da; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                    <i class="fa-solid fa-trash" style="font-size: 30px; color: #dc3545;"></i>
                </div>
                <h3 style="margin: 0 0 10px 0; color: #333; font-size: 22px;">Confirm Delete</h3>
                <p id="deleteMessage" style="margin: 0; color: #666; font-size: 16px; line-height: 1.5;"></p>
            </div>
            <div style="display: flex; gap: 15px; justify-content: flex-end;">
                <button id="deleteCancel" style="padding: 12px 24px; border: 2px solid #6c757d; background: #fff; color: #6c757d; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s; font-size: 16px;">
                    <i class="fa-solid fa-times"></i> Cancel
                </button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="padding: 12px 24px; background: #dc3545; color: #fff; border-radius: 8px; font-weight: 600; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s; font-size: 16px;">
                        <i class="fa-solid fa-trash"></i> Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Role filter functionality (works together with search)
            const roleFilter = document.getElementById('roleFilter');
            const searchInput = document.getElementById('userSearch');
            
            function applyFilters() {
                const selectedRole = roleFilter ? roleFilter.value.toLowerCase() : 'all';
                const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
                const rows = document.querySelectorAll('#usersTable tbody tr');
                
                rows.forEach(row => {
                    const rowRole = (row.dataset.role || '').toLowerCase();
                    const rowName = (row.dataset.name || '').toLowerCase();
                    const rowEmail = (row.dataset.email || '').toLowerCase();
                    const rowId = String(row.dataset.id || '').toLowerCase();
                    
                    // Check role filter
                    let roleMatch = selectedRole === 'all' || rowRole === selectedRole;
                    
                    // Check search filter
                    let searchMatch = searchTerm === '' || 
                        rowName.includes(searchTerm) || 
                        rowEmail.includes(searchTerm) || 
                        rowId.includes(searchTerm);
                    
                    // Show row only if both filters match
                    if (roleMatch && searchMatch) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
            
            if (roleFilter) {
                roleFilter.addEventListener('change', applyFilters);
            }
            
            if (searchInput) {
                searchInput.addEventListener('input', applyFilters);
            }

            const deleteModal = document.getElementById('deleteModal');
            const deleteMessage = document.getElementById('deleteMessage');
            const deleteCancel = document.getElementById('deleteCancel');
            const deleteForm = document.getElementById('deleteForm');
            const deleteButtons = document.querySelectorAll('.delete-user-btn');

            // Show delete confirmation modal
            function showDeleteModal(userId, userName, userEmail) {
                deleteMessage.innerHTML = `Are you sure you want to delete <strong>${userName}</strong> (${userEmail})?<br><br>This action cannot be undone.`;
                deleteForm.action = `/users/${userId}`;
                deleteModal.style.display = 'flex';
            }

            // Hide delete modal
            function hideDeleteModal() {
                deleteModal.style.display = 'none';
            }

            // Handle delete button clicks
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    const userName = this.getAttribute('data-user-name');
                    const userEmail = this.getAttribute('data-user-email');
                    showDeleteModal(userId, userName, userEmail);
                });
            });

            // Handle modal buttons
            deleteCancel.addEventListener('click', hideDeleteModal);
            deleteModal.addEventListener('click', function(e) {
                if (e.target === deleteModal) {
                    hideDeleteModal();
                }
            });
        });
    </script>
</x-layout>
