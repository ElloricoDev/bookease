<x-layout title="BookEase • Edit Book" bodyClass="user-page admin-page">
    <x-admin-header />
    
    <div class="dashboard-layout">
        <x-admin-sidebar />

        <main class="dashboard-main">
            <div class="panel">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px;">
                    <h2 style="margin: 0;"><i class="fa-solid fa-edit"></i> Edit Book</h2>
                    <a href="{{ route('book_management') }}" class="btn" style="background: #6c757d; color: #fff; text-decoration: none;">
                        <i class="fa-solid fa-arrow-left"></i> Back to Books
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

                <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data" style="background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom: 30px;">
                        <h3 style="color: #2e7d32; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #e0e0e0;">
                            <i class="fa-solid fa-book-open"></i> Basic Information
                        </h3>
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; font-weight: 600; color: #333;">
                                    <i class="fa-solid fa-book" style="color: #2e7d32;"></i> Title *
                                </label>
                                <div style="position: relative;">
                                    <i class="fa-solid fa-book" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                                    <input type="text" name="title" value="{{ old('title', $book->title) }}" required 
                                           style="width: 100%; padding: 12px 12px 12px 40px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s;"
                                           onfocus="this.style.borderColor='#2e7d32'" onblur="this.style.borderColor='#e0e0e0'">
                                </div>
                                @error('title')<span style="color: #dc3545; font-size: 12px; display: block; margin-top: 5px;"><i class="fa-solid fa-exclamation-circle"></i> {{ $message }}</span>@enderror
                            </div>

                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; font-weight: 600; color: #333;">
                                    <i class="fa-solid fa-user-pen" style="color: #2e7d32;"></i> Author *
                                </label>
                                <div style="position: relative;">
                                    <i class="fa-solid fa-user-pen" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                                    <input type="text" name="author" value="{{ old('author', $book->author) }}" required 
                                           style="width: 100%; padding: 12px 12px 12px 40px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s;"
                                           onfocus="this.style.borderColor='#2e7d32'" onblur="this.style.borderColor='#e0e0e0'">
                                </div>
                                @error('author')<span style="color: #dc3545; font-size: 12px; display: block; margin-top: 5px;"><i class="fa-solid fa-exclamation-circle"></i> {{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div style="margin-bottom: 30px;">
                        <h3 style="color: #2e7d32; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #e0e0e0;">
                            <i class="fa-solid fa-info-circle"></i> Book Details
                        </h3>
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; font-weight: 600; color: #333;">
                                    <i class="fa-solid fa-barcode" style="color: #2e7d32;"></i> ISBN
                                </label>
                                <div style="position: relative;">
                                    <i class="fa-solid fa-barcode" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                                    <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}" placeholder="978-0-123456-78-9"
                                           style="width: 100%; padding: 12px 12px 12px 40px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s;"
                                           onfocus="this.style.borderColor='#2e7d32'" onblur="this.style.borderColor='#e0e0e0'">
                                </div>
                                @error('isbn')<span style="color: #dc3545; font-size: 12px; display: block; margin-top: 5px;"><i class="fa-solid fa-exclamation-circle"></i> {{ $message }}</span>@enderror
                            </div>

                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; font-weight: 600; color: #333;">
                                    <i class="fa-solid fa-tags" style="color: #2e7d32;"></i> Category
                                </label>
                                <div style="position: relative;">
                                    <i class="fa-solid fa-tags" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #999; z-index: 1;"></i>
                                    @php
                                        $commonCategories = ['Fiction', 'Science Fiction', 'Fantasy', 'Mystery', 'Thriller', 'Romance', 'History', 'Biography', 'Science', 'Technology', 'Business', 'Self-Help', 'Education', 'Philosophy', 'Religion', 'Art', 'Poetry', 'Drama', 'Children', 'Young Adult'];
                                        $currentCategory = old('category', $book->category);
                                        $isOther = $currentCategory && !in_array($currentCategory, $commonCategories);
                                    @endphp
                                    <select name="category" id="categorySelect" 
                                            style="width: 100%; padding: 12px 12px 12px 40px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; background: #fff; cursor: pointer; transition: border-color 0.3s;"
                                            onfocus="this.style.borderColor='#2e7d32'" onblur="this.style.borderColor='#e0e0e0'">
                                        <option value="">Select a category...</option>
                                        <option value="Fiction" {{ $currentCategory == 'Fiction' ? 'selected' : '' }}>Fiction</option>
                                        <option value="Science Fiction" {{ $currentCategory == 'Science Fiction' ? 'selected' : '' }}>Science Fiction</option>
                                        <option value="Fantasy" {{ $currentCategory == 'Fantasy' ? 'selected' : '' }}>Fantasy</option>
                                        <option value="Mystery" {{ $currentCategory == 'Mystery' ? 'selected' : '' }}>Mystery</option>
                                        <option value="Thriller" {{ $currentCategory == 'Thriller' ? 'selected' : '' }}>Thriller</option>
                                        <option value="Romance" {{ $currentCategory == 'Romance' ? 'selected' : '' }}>Romance</option>
                                        <option value="History" {{ $currentCategory == 'History' ? 'selected' : '' }}>History</option>
                                        <option value="Biography" {{ $currentCategory == 'Biography' ? 'selected' : '' }}>Biography</option>
                                        <option value="Science" {{ $currentCategory == 'Science' ? 'selected' : '' }}>Science</option>
                                        <option value="Technology" {{ $currentCategory == 'Technology' ? 'selected' : '' }}>Technology</option>
                                        <option value="Business" {{ $currentCategory == 'Business' ? 'selected' : '' }}>Business</option>
                                        <option value="Self-Help" {{ $currentCategory == 'Self-Help' ? 'selected' : '' }}>Self-Help</option>
                                        <option value="Education" {{ $currentCategory == 'Education' ? 'selected' : '' }}>Education</option>
                                        <option value="Philosophy" {{ $currentCategory == 'Philosophy' ? 'selected' : '' }}>Philosophy</option>
                                        <option value="Religion" {{ $currentCategory == 'Religion' ? 'selected' : '' }}>Religion</option>
                                        <option value="Art" {{ $currentCategory == 'Art' ? 'selected' : '' }}>Art</option>
                                        <option value="Poetry" {{ $currentCategory == 'Poetry' ? 'selected' : '' }}>Poetry</option>
                                        <option value="Drama" {{ $currentCategory == 'Drama' ? 'selected' : '' }}>Drama</option>
                                        <option value="Children" {{ $currentCategory == 'Children' ? 'selected' : '' }}>Children's Books</option>
                                        <option value="Young Adult" {{ $currentCategory == 'Young Adult' ? 'selected' : '' }}>Young Adult</option>
                                        <option value="Other" {{ $isOther ? 'selected' : '' }}>Other (Specify)</option>
                                    </select>
                                </div>
                                <div id="categoryOtherInput" style="margin-top: 10px; display: {{ $isOther ? 'block' : 'none' }};">
                                    <div style="position: relative;">
                                        <i class="fa-solid fa-pen" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                                        <input type="text" name="category_other" id="categoryOtherText" value="{{ $isOther ? $currentCategory : old('category_other') }}" 
                                               placeholder="Enter custom category..."
                                               style="width: 100%; padding: 12px 12px 12px 40px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s;"
                                               onfocus="this.style.borderColor='#2e7d32'" onblur="this.style.borderColor='#e0e0e0'">
                                    </div>
                                    <div id="categoryError" style="display: none; color: #dc3545; font-size: 12px; margin-top: 5px;">
                                        <i class="fa-solid fa-exclamation-circle"></i> <span id="categoryErrorText"></span>
                                    </div>
                                </div>
                                @error('category')<span style="color: #dc3545; font-size: 12px; display: block; margin-top: 5px;"><i class="fa-solid fa-exclamation-circle"></i> {{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; font-weight: 600; color: #333;">
                                    <i class="fa-solid fa-building" style="color: #2e7d32;"></i> Publisher
                                </label>
                                <div style="position: relative;">
                                    <i class="fa-solid fa-building" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                                    <input type="text" name="publisher" value="{{ old('publisher', $book->publisher) }}"
                                           style="width: 100%; padding: 12px 12px 12px 40px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s;"
                                           onfocus="this.style.borderColor='#2e7d32'" onblur="this.style.borderColor='#e0e0e0'">
                                </div>
                                @error('publisher')<span style="color: #dc3545; font-size: 12px; display: block; margin-top: 5px;"><i class="fa-solid fa-exclamation-circle"></i> {{ $message }}</span>@enderror
                            </div>

                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; font-weight: 600; color: #333;">
                                    <i class="fa-solid fa-calendar-days" style="color: #2e7d32;"></i> Publication Year
                                </label>
                                <div style="position: relative;">
                                    <i class="fa-solid fa-calendar-days" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                                    <input type="number" name="publication_year" value="{{ old('publication_year', $book->publication_year) }}" min="1000" max="{{ date('Y') }}"
                                           style="width: 100%; padding: 12px 12px 12px 40px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s;"
                                           onfocus="this.style.borderColor='#2e7d32'" onblur="this.style.borderColor='#e0e0e0'">
                                </div>
                                @error('publication_year')<span style="color: #dc3545; font-size: 12px; display: block; margin-top: 5px;"><i class="fa-solid fa-exclamation-circle"></i> {{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 20px;">
                            <label style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; font-weight: 600; color: #333;">
                                <i class="fa-solid fa-align-left" style="color: #2e7d32;"></i> Description
                            </label>
                            <textarea name="description" rows="4" placeholder="Book synopsis or description..."
                                      style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; font-family: inherit; resize: vertical; transition: border-color 0.3s;"
                                      onfocus="this.style.borderColor='#2e7d32'" onblur="this.style.borderColor='#e0e0e0'">{{ old('description', $book->description) }}</textarea>
                            @error('description')<span style="color: #dc3545; font-size: 12px; display: block; margin-top: 5px;"><i class="fa-solid fa-exclamation-circle"></i> {{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div style="margin-bottom: 30px;">
                        <h3 style="color: #2e7d32; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #e0e0e0;">
                            <i class="fa-solid fa-cog"></i> Additional Information
                        </h3>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; font-weight: 600; color: #333;">
                                    <i class="fa-solid fa-language" style="color: #2e7d32;"></i> Language
                                </label>
                                <div style="position: relative;">
                                    <i class="fa-solid fa-language" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                                    <input type="text" name="language" value="{{ old('language', $book->language ?? 'English') }}"
                                           style="width: 100%; padding: 12px 12px 12px 40px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s;"
                                           onfocus="this.style.borderColor='#2e7d32'" onblur="this.style.borderColor='#e0e0e0'">
                                </div>
                                @error('language')<span style="color: #dc3545; font-size: 12px; display: block; margin-top: 5px;"><i class="fa-solid fa-exclamation-circle"></i> {{ $message }}</span>@enderror
                            </div>

                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; font-weight: 600; color: #333;">
                                    <i class="fa-solid fa-clipboard-check" style="color: #2e7d32;"></i> Condition
                                </label>
                                <div style="position: relative;">
                                    <i class="fa-solid fa-clipboard-check" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #999; z-index: 1;"></i>
                                    <select name="condition" style="width: 100%; padding: 12px 12px 12px 40px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; background: #fff; cursor: pointer; transition: border-color 0.3s;"
                                            onfocus="this.style.borderColor='#2e7d32'" onblur="this.style.borderColor='#e0e0e0'">
                                        <option value="new" {{ old('condition', $book->condition) == 'new' ? 'selected' : '' }}>New</option>
                                        <option value="good" {{ old('condition', $book->condition ?? 'good') == 'good' ? 'selected' : '' }}>Good</option>
                                        <option value="fair" {{ old('condition', $book->condition) == 'fair' ? 'selected' : '' }}>Fair</option>
                                        <option value="poor" {{ old('condition', $book->condition) == 'poor' ? 'selected' : '' }}>Poor</option>
                                    </select>
                                </div>
                                @error('condition')<span style="color: #dc3545; font-size: 12px; display: block; margin-top: 5px;"><i class="fa-solid fa-exclamation-circle"></i> {{ $message }}</span>@enderror
                            </div>

                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; font-weight: 600; color: #333;">
                                    <i class="fa-solid fa-image" style="color: #2e7d32;"></i> Book Cover
                                </label>
                                @if($book->image)
                                    <div style="margin-bottom: 10px;">
                                        <img src="{{ asset('storage/' . $book->image) }}" alt="Current cover" style="width: 100px; height: 150px; object-fit: cover; border-radius: 8px; border: 2px solid #e0e0e0;">
                                    </div>
                                @endif
                                <div style="position: relative;">
                                    <input type="file" name="image" accept="image/*" 
                                           style="width: 100%; padding: 12px; border: 2px dashed #e0e0e0; border-radius: 8px; font-size: 14px; cursor: pointer; transition: border-color 0.3s;"
                                           onchange="this.style.borderColor='#2e7d32'">
                                </div>
                                <small style="color: #666; display: block; margin-top: 5px;"><i class="fa-solid fa-info-circle"></i> Leave empty to keep current image</small>
                                @error('image')<span style="color: #dc3545; font-size: 12px; display: block; margin-top: 5px;"><i class="fa-solid fa-exclamation-circle"></i> {{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div style="margin-bottom: 30px;">
                        <h3 style="color: #2e7d32; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #e0e0e0;">
                            <i class="fa-solid fa-dollar-sign"></i> Pricing & Inventory
                        </h3>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; font-weight: 600; color: #333;">
                                    <i class="fa-solid fa-money-bill-wave" style="color: #2e7d32;"></i> Rent Fee (per day) *
                                </label>
                                <div style="position: relative;">
                                    <i class="fa-solid fa-money-bill-wave" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                                    <input type="number" name="rent_fee" value="{{ old('rent_fee', $book->rent_fee) }}" step="0.01" min="0" required
                                           style="width: 100%; padding: 12px 12px 12px 40px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s;"
                                           onfocus="this.style.borderColor='#2e7d32'" onblur="this.style.borderColor='#e0e0e0'">
                                </div>
                                @error('rent_fee')<span style="color: #dc3545; font-size: 12px; display: block; margin-top: 5px;"><i class="fa-solid fa-exclamation-circle"></i> {{ $message }}</span>@enderror
                            </div>

                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; font-weight: 600; color: #333;">
                                    <i class="fa-solid fa-coins" style="color: #2e7d32;"></i> Deposit *
                                </label>
                                <div style="position: relative;">
                                    <i class="fa-solid fa-coins" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                                    <input type="number" name="deposit" value="{{ old('deposit', $book->deposit) }}" step="0.01" min="0" required
                                           style="width: 100%; padding: 12px 12px 12px 40px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s;"
                                           onfocus="this.style.borderColor='#2e7d32'" onblur="this.style.borderColor='#e0e0e0'">
                                </div>
                                @error('deposit')<span style="color: #dc3545; font-size: 12px; display: block; margin-top: 5px;"><i class="fa-solid fa-exclamation-circle"></i> {{ $message }}</span>@enderror
                            </div>

                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; font-weight: 600; color: #333;">
                                    <i class="fa-solid fa-boxes-stacked" style="color: #2e7d32;"></i> Quantity *
                                </label>
                                <div style="position: relative;">
                                    <i class="fa-solid fa-boxes-stacked" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                                    <input type="number" name="quantity" value="{{ old('quantity', $book->quantity) }}" min="1" required
                                           style="width: 100%; padding: 12px 12px 12px 40px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s;"
                                           onfocus="this.style.borderColor='#2e7d32'" onblur="this.style.borderColor='#e0e0e0'">
                                </div>
                                <small style="color: #666; display: block; margin-top: 5px;"><i class="fa-solid fa-info-circle"></i> Available: {{ $book->available_quantity }}</small>
                                @error('quantity')<span style="color: #dc3545; font-size: 12px; display: block; margin-top: 5px;"><i class="fa-solid fa-exclamation-circle"></i> {{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 15px; justify-content: flex-end; margin-top: 30px; padding-top: 20px; border-top: 2px solid #e0e0e0;">
                        <a href="{{ route('book_management') }}" id="cancelBtn" class="btn" style="background: #6c757d; color: #fff; text-decoration: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-arrow-left"></i> Cancel
                        </a>
                        <button type="submit" class="btn primary" style="padding: 12px 24px; border-radius: 8px; font-weight: 600; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px; border: none; cursor: pointer;">
                            <i class="fa-solid fa-save"></i> Update Book
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
                <a id="confirmProceed" href="{{ route('book_management') }}" style="padding: 12px 24px; background: #dc3545; color: #fff; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s; font-size: 16px;">
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
                        initialValues[input.name] = input.value || '';
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
                        // If a new file is selected, it's a change
                        if (currentValue > 0 && initialValues[input.name] === 0) {
                            return true;
                        }
                    } else if (input.type === 'checkbox' || input.type === 'radio') {
                        currentValue = input.checked;
                    } else {
                        currentValue = input.value || '';
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

            // Category dropdown handler
            const categorySelect = document.getElementById('categorySelect');
            const categoryOtherInput = document.getElementById('categoryOtherInput');
            const categoryOtherText = document.getElementById('categoryOtherText');
            
            categorySelect.addEventListener('change', function() {
                if (this.value === 'Other') {
                    categoryOtherInput.style.display = 'block';
                    categoryOtherText.required = true;
                } else {
                    categoryOtherInput.style.display = 'none';
                    categoryOtherText.required = false;
                    categoryOtherText.value = '';
                }
            });

            // Before form submit, validate if "Other" is selected
            form.addEventListener('submit', function(e) {
                if (categorySelect.value === 'Other') {
                    const otherValue = categoryOtherText.value.trim();
                    const categoryError = document.getElementById('categoryError');
                    const categoryErrorText = document.getElementById('categoryErrorText');
                    
                    if (!otherValue) {
                        e.preventDefault();
                        categoryErrorText.textContent = 'Please enter a custom category or select a category from the list.';
                        categoryError.style.display = 'block';
                        categoryOtherText.style.borderColor = '#dc3545';
                        categoryOtherText.focus();
                        
                        // Remove error on input
                        categoryOtherText.addEventListener('input', function() {
                            categoryError.style.display = 'none';
                            categoryOtherText.style.borderColor = '#e0e0e0';
                        }, { once: true });
                        
                        return false;
                    } else {
                        categoryError.style.display = 'none';
                        categoryOtherText.style.borderColor = '#e0e0e0';
                    }
                }
            });
        });
    </script>
</x-layout>
