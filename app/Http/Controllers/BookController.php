<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\CartItem;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of books (Admin)
     */
    public function index()
    {
        $books = Book::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.book_management', compact('books'));
    }

    /**
     * Show the form for creating a new book
     */
    public function create()
    {
        return view('admin.books.create');
    }

    /**
     * Store a newly created book
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'description' => 'nullable|string|max:2000',
            'language' => 'nullable|string|max:100',
            'condition' => 'nullable|string|in:new,like_new,good,fair,poor',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rent_fee' => 'required|numeric|min:0',
            'deposit' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
        ]);

        // Handle category (if "Other" is selected, use category_other)
        $category = $request->category;
        if ($category === 'Other' && $request->filled('category_other')) {
            $category = $request->category_other;
        }

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = 'storage/' . $image->store('images', 'public');
        }

        // Create book
        $book = Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'isbn' => $request->isbn,
            'category' => $category,
            'publisher' => $request->publisher,
            'publication_year' => $request->publication_year,
            'description' => $request->description,
            'language' => $request->language ?? 'English',
            'condition' => $request->condition ?? 'good',
            'image' => $imagePath,
            'rent_fee' => $request->rent_fee,
            'deposit' => $request->deposit,
            'quantity' => $request->quantity,
            'available_quantity' => $request->quantity, // Initially all are available
            'status' => 'available',
            'popularity' => 0,
        ]);

        return redirect()->route('book_management')->with('success', 'Book created successfully!');
    }

    /**
     * Show the form for editing the specified book
     */
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('admin.books.edit', compact('book'));
    }

    /**
     * Update the specified book
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'description' => 'nullable|string|max:2000',
            'language' => 'nullable|string|max:100',
            'condition' => 'nullable|string|in:new,like_new,good,fair,poor',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rent_fee' => 'required|numeric|min:0',
            'deposit' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
        ]);

        // Handle category (if "Other" is selected, use category_other)
        $category = $request->category;
        if ($category === 'Other' && $request->filled('category_other')) {
            $category = $request->category_other;
        }

        // Handle image upload
        $imagePath = $book->image;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($book->image) {
                $oldImagePath = str_replace('storage/', '', $book->image);
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }
            
            $image = $request->file('image');
            $storedPath = $image->store('images', 'public');
            $imagePath = 'storage/' . $storedPath;
        }

        // Calculate available_quantity adjustment
        $oldQuantity = $book->quantity;
        $newQuantity = $request->quantity;
        $quantityDifference = $newQuantity - $oldQuantity;
        
        // Adjust available_quantity based on quantity change
        $newAvailableQuantity = $book->available_quantity + $quantityDifference;
        // Ensure available_quantity doesn't exceed quantity or go below 0
        $newAvailableQuantity = max(0, min($newAvailableQuantity, $newQuantity));

        // Update book
        $book->update([
            'title' => $request->title,
            'author' => $request->author,
            'isbn' => $request->isbn,
            'category' => $category,
            'publisher' => $request->publisher,
            'publication_year' => $request->publication_year,
            'description' => $request->description,
            'language' => $request->language ?? 'English',
            'condition' => $request->condition ?? 'good',
            'image' => $imagePath,
            'rent_fee' => $request->rent_fee,
            'deposit' => $request->deposit,
            'quantity' => $newQuantity,
            'available_quantity' => $newAvailableQuantity,
            // Update status if needed
            'status' => $newAvailableQuantity > 0 ? 'available' : ($book->status === 'available' ? 'borrowed' : $book->status),
        ]);

        return redirect()->route('book_management')->with('success', 'Book updated successfully!');
    }

    /**
     * Remove the specified book
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        // Check if book has active borrowings
        $activeBorrowings = $book->activeBorrows()->count();
        if ($activeBorrowings > 0) {
            return redirect()->route('book_management')
                ->with('error', "Cannot delete book '{$book->title}'. It has {$activeBorrowings} active borrowing(s).");
        }

        // Delete image if exists
        if ($book->image) {
            $imagePath = str_replace('storage/', '', $book->image);
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $book->delete();

        return redirect()->route('book_management')->with('success', 'Book deleted successfully!');
    }

    /**
     * Display a single book's details (User)
     */
    public function show($id)
    {
        $book = Book::findOrFail($id);
        
        $userId = session('user_id');
        $cartCount = $userId ? CartItem::where('user_id', $userId)->where('status', 'in-cart')->count() : 0;
        
        // Check if book is already in cart
        $inCart = false;
        if ($userId) {
            $inCart = CartItem::where('user_id', $userId)
                ->where('book_id', $book->id)
                ->where('status', 'in-cart')
                ->exists();
        }

        // Get related books (same category)
        $relatedBooks = Book::where('category', $book->category)
            ->where('id', '!=', $book->id)
            ->where('status', 'available')
            ->limit(4)
            ->get();

        return view('user.book_detail', compact('book', 'cartCount', 'inCart', 'relatedBooks'));
    }
}
