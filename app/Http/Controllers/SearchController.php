<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class SearchController extends Controller
{
    /**
     * Get search suggestions (AJAX endpoint)
     */
    public function suggestions(Request $request)
    {
        $query = $request->input('q', '');
        
        if (strlen($query) < 2) {
            return response()->json(['suggestions' => []]);
        }

        // Search books by title, author, ISBN, or category
        $books = Book::where(function($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                  ->orWhere('author', 'like', '%' . $query . '%')
                  ->orWhere('isbn', 'like', '%' . $query . '%')
                  ->orWhere('category', 'like', '%' . $query . '%');
            })
            ->where('status', 'available')
            ->where('available_quantity', '>', 0)
            ->limit(5)
            ->get(['id', 'title', 'author', 'category', 'image']);

        $suggestions = [];
        
        // Add book suggestions
        foreach ($books as $book) {
            $suggestions[] = [
                'type' => 'book',
                'title' => $book->title,
                'author' => $book->author,
                'category' => $book->category,
                'url' => route('books', ['q' => $book->title]),
            ];
        }

        // Add category suggestions if query matches a category
        $categories = Book::selectRaw('category, COUNT(*) as count')
            ->where('category', 'like', '%' . $query . '%')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->groupBy('category')
            ->limit(3)
            ->get();

        foreach ($categories as $category) {
            $suggestions[] = [
                'type' => 'category',
                'title' => $category->category,
                'count' => $category->count,
                'url' => route('books', ['category' => $category->category]),
            ];
        }

        return response()->json(['suggestions' => $suggestions]);
    }
}
