<x-layout title="BookEase • Book Management" bodyClass="user-page admin-page">
    <x-admin-header />
    
    <div class="dashboard-layout">
        <x-admin-sidebar />

        <main class="dashboard-main">
            <div class="panel">
                <h2><i class="fa-solid fa-book"></i> Book Management</h2>

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
                        id="bookSearch" 
                        placeholder="Search by Title, Author, ISBN, or Category"
                        tableId="booksTable"
                        :searchFields="['title', 'author', 'isbn', 'category']"
                    />
                    <a class="btn primary" href="{{ route('books.create') }}"><i class="fa-solid fa-plus"></i> Add Book</a>
                </div>

                <div class="table-wrap">
                    <table class="table" id="booksTable">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>ISBN</th>
                                <th>Category</th>
                                <th>Available</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($books as $book)
                            <tr data-title="{{ strtolower($book->title) }}" 
                                data-author="{{ strtolower($book->author) }}" 
                                data-isbn="{{ strtolower($book->isbn ?? '') }}"
                                data-category="{{ strtolower($book->category ?? '') }}">
                                <td><strong>{{ $book->title }}</strong></td>
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->isbn ?? 'N/A' }}</td>
                                <td>{{ $book->category ?? 'N/A' }}</td>
                                <td>{{ $book->available_quantity }}/{{ $book->quantity }}</td>
                                <td>
                                    @if($book->status === 'available')
                                        <span class="badge success">Available</span>
                                    @elseif($book->status === 'borrowed')
                                        <span class="badge warning">Borrowed</span>
                                    @else
                                        <span class="badge danger">{{ ucfirst($book->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('books.edit', $book->id) }}" class="btn small">
                                        <i class="fa-solid fa-edit"></i> Edit
                                    </a>
                                    <button class="btn small danger delete-book-btn" type="button" data-book-id="{{ $book->id }}" data-book-title="{{ $book->title }}" data-book-author="{{ $book->author }}">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 40px; color: #666;">
                                    <i class="fa-solid fa-inbox" style="font-size: 48px; margin-bottom: 15px; display: block; color: #ccc;"></i>
                                    No books found. <a href="{{ route('books.create') }}">Add your first book</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($books->hasPages())
                    <div style="margin-top: 20px;">
                        {{ $books->links() }}
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
            const deleteButtons = document.querySelectorAll('.delete-book-btn');

            // Show delete confirmation modal
            function showDeleteModal(bookId, bookTitle, bookAuthor) {
                deleteMessage.innerHTML = `Are you sure you want to delete <strong>"${bookTitle}"</strong> by ${bookAuthor}?<br><br>This action cannot be undone and will permanently remove the book from the system.`;
                deleteForm.action = `/books/${bookId}`;
                deleteModal.style.display = 'flex';
            }

            // Hide delete modal
            function hideDeleteModal() {
                deleteModal.style.display = 'none';
            }

            // Handle delete button clicks
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const bookId = this.getAttribute('data-book-id');
                    const bookTitle = this.getAttribute('data-book-title');
                    const bookAuthor = this.getAttribute('data-book-author');
                    showDeleteModal(bookId, bookTitle, bookAuthor);
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
