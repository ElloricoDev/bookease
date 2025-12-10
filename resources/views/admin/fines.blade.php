<x-layout title="BookEase • Fine Management" bodyClass="user-page admin-page">
    <x-admin-header />
    
    <div class="dashboard-layout">
        <x-admin-sidebar />

        <main class="dashboard-main">
            <div class="panel">
                <h2><i class="fa-solid fa-dollar-sign"></i> Fine Management</h2>

                @if(session('success'))
                    <div class="alert success"><i class="fa-solid fa-check-circle"></i> {{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert danger" style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
                        <i class="fa-solid fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

                <div class="table-toolbar">
                    <x-admin-search 
                        id="fineSearch" 
                        placeholder="Search by User or Book"
                        tableId="finesTable"
                        :searchFields="['userName', 'bookTitle']"
                    />
                </div>

                <div class="table-wrap">
                    <table class="table" id="finesTable">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Book Title</th>
                                <th>Amount</th>
                                <th>Due Date</th>
                                <th>Return Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($fines as $fine)
                            <tr data-user-name="{{ strtolower($fine->user->name ?? '') }}" 
                                data-book-title="{{ strtolower($fine->borrowedBook->book->title ?? 'N/A') }}">
                                <td>{{ $fine->user->name ?? 'N/A' }}</td>
                                <td>{{ $fine->borrowedBook->book->title ?? 'N/A' }}</td>
                                <td><strong>₱{{ number_format($fine->amount, 2) }}</strong></td>
                                <td>{{ $fine->borrowedBook && $fine->borrowedBook->due_date ? $fine->borrowedBook->due_date->format('Y-m-d') : 'N/A' }}</td>
                                <td>{{ $fine->borrowedBook && $fine->borrowedBook->returned_at ? $fine->borrowedBook->returned_at->format('Y-m-d') : 'N/A' }}</td>
                                <td>
                                    @if($fine->status === 'completed')
                                        <span class="badge success">Paid</span>
                                    @elseif($fine->status === 'pending')
                                        <span class="badge warning">Pending</span>
                                    @else
                                        <span class="badge danger">{{ ucfirst($fine->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn small danger delete-fine-btn" type="button" 
                                            data-fine-id="{{ $fine->id }}" 
                                            data-user-name="{{ $fine->user->name ?? 'N/A' }}" 
                                            data-book-title="{{ $fine->borrowedBook->book->title ?? 'N/A' }}" 
                                            data-fine-amount="₱{{ number_format($fine->amount, 2) }}">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 40px; color: #666;">
                                    <i class="fa-solid fa-inbox" style="font-size: 48px; margin-bottom: 15px; display: block; color: #ccc;"></i>
                                    No fine records found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($fines->hasPages())
                    <div style="margin-top: 20px;">
                        {{ $fines->links() }}
                    </div>
                @endif
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
            // Delete confirmation modal
            const deleteModal = document.getElementById('deleteModal');
            const deleteMessage = document.getElementById('deleteMessage');
            const deleteCancel = document.getElementById('deleteCancel');
            const deleteForm = document.getElementById('deleteForm');
            const deleteButtons = document.querySelectorAll('.delete-fine-btn');

            // Show delete confirmation modal
            function showDeleteModal(fineId, userName, bookTitle, fineAmount) {
                deleteMessage.innerHTML = `Are you sure you want to delete the fine record for <strong>${userName}</strong> - "${bookTitle}" (${fineAmount})?<br><br>This action cannot be undone and will permanently remove the fine record from the system.`;
                deleteForm.action = `/fines/${fineId}`;
                deleteModal.style.display = 'flex';
            }

            // Hide delete modal
            function hideDeleteModal() {
                deleteModal.style.display = 'none';
            }

            // Handle delete button clicks
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const fineId = this.getAttribute('data-fine-id');
                    const userName = this.getAttribute('data-user-name');
                    const bookTitle = this.getAttribute('data-book-title');
                    const fineAmount = this.getAttribute('data-fine-amount');
                    showDeleteModal(fineId, userName, bookTitle, fineAmount);
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
