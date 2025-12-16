<x-layout title="BookEase • Process Return" bodyClass="user-page admin-page">
    <x-admin-header />
    
    <div class="dashboard-layout">
        <x-admin-sidebar />

        <main class="dashboard-main">
            <div class="panel">
                <h2><i class="fa-solid fa-rotate-left"></i> Process Book Return</h2>

                @if(!isset($borrowedBook))
                    <div class="alert danger" style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                        <i class="fa-solid fa-exclamation-circle"></i> Error: Borrowed book data not found.
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert danger" style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                        <i class="fa-solid fa-exclamation-circle"></i>
                        <strong>Please fix the following errors:</strong>
                        <ul style="margin: 10px 0 0 20px; padding: 0;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div style="background: #fff; padding: 25px; border-radius: 12px; margin-bottom: 25px; border: 1px solid #e0e0e0;">
                    <h3 style="margin-top: 0; color: #1b1f1b;">Borrowing Information</h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 20px;">
                        <div>
                            <strong style="color: #666;">User:</strong>
                            <p style="margin: 5px 0 0 0;">{{ $borrowedBook->user->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <strong style="color: #666;">Book:</strong>
                            <p style="margin: 5px 0 0 0;">{{ $borrowedBook->book->title ?? 'N/A' }}</p>
                            <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;">{{ $borrowedBook->book->author ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <strong style="color: #666;">Borrowed Date:</strong>
                            <p style="margin: 5px 0 0 0;">{{ $borrowedBook->borrowed_at ? $borrowedBook->borrowed_at->format('M d, Y') : 'N/A' }}</p>
                        </div>
                        <div>git 
                            <strong style="color: #666;">Due Date:</strong>
                            <p style="margin: 5px 0 0 0;">
                                {{ $borrowedBook->due_date ? $borrowedBook->due_date->format('M d, Y') : 'N/A' }}
                                @if($borrowedBook->due_date && $borrowedBook->isOverdue())
                                    <span class="badge danger" style="margin-left: 8px;">{{ $borrowedBook->daysOverdue() }} days overdue</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($borrowedBook->isOverdue())
                        <div style="background: #fff3cd; padding: 15px; border-radius: 8px; border-left: 4px solid #ffc107;">
                            <strong style="color: #856404;">
                                <i class="fa-solid fa-exclamation-triangle"></i> Late Fee:
                            </strong>
                            <span style="color: #856404; font-size: 18px; font-weight: 700;">
                                ₱{{ number_format($borrowedBook->daysOverdue() * 1.00, 2) }}
                            </span>
                            <p style="margin: 5px 0 0 0; color: #856404; font-size: 14px;">
                                {{ $borrowedBook->daysOverdue() }} days × ₱1.00 per day
                            </p>
                        </div>
                    @endif
                </div>

                <form action="{{ route('return.process', $borrowedBook->id) }}" method="POST" style="background: #fff; padding: 25px; border-radius: 12px; border: 1px solid #e0e0e0;">
                    @csrf
                    
                    <h3 style="margin-top: 0; color: #1b1f1b; margin-bottom: 20px;">Return Details</h3>

                    <div class="form-group" style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
                            <i class="fa-solid fa-clipboard-check"></i> Book Condition *
                        </label>
                        <select name="return_condition" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px;">
                            <option value="">Select condition...</option>
                            <option value="good">Good - No damage</option>
                            <option value="fair">Fair - Minor wear</option>
                            <option value="damaged">Damaged - Significant damage</option>
                            <option value="lost">Lost - Book not returned</option>
                        </select>
                        <small style="color: #666; display: block; margin-top: 5px;">
                            Note: Lost or damaged books may result in deposit forfeiture.
                        </small>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
                            <i class="fa-solid fa-comment"></i> Return Notes (Optional)
                        </label>
                        <textarea name="return_notes" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; font-family: inherit;" placeholder="Add any notes about the return condition..."></textarea>
                    </div>

                    <div style="display: flex; gap: 15px; margin-top: 25px;">
                        <button type="submit" class="btn primary">
                            <i class="fa-solid fa-check"></i> Process Return
                        </button>
                        <a href="{{ route('borrow_return') }}" class="btn" style="background: #6c757d; color: #fff;">
                            <i class="fa-solid fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-layout>
