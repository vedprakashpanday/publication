<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // 1. Base Query build karna
        $query = Book::with(['author', 'images', 'category'])->where('is_active', true);

        // 2. Search Box Filter
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhereHas('author', function ($authorQ) use ($searchTerm) {
                      $authorQ->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // 3. Category Filter
        if ($request->filled('categories')) {
            // categories ek array aayega (checkboxes se)
            $query->whereIn('category_id', $request->categories);
        }

        // 4. Author Filter
        if ($request->filled('authors')) {
            $query->whereIn('author_id', $request->authors);
        }

        // 5. Price Range Filter
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        // 6. Sorting Logic
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'latest':
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest(); // Default sort
        }

        // 7. Pagination (12 kitabein per page)
        $books = $query->paginate(12)->withQueryString();

        // 8. Sidebar Filters ke liye Data
        $categories = Category::withCount('books')->where('is_active', true)->get();
        $authors = Author::withCount('books')->get();

        return view('frontend.shop', compact('books', 'categories', 'authors'));
    }

    public function show($slug)
    {
        // Single Book Detail page ke liye
        $book = Book::with(['author', 'category', 'images', 'publisher'])->where('id', $slug)->firstOrFail();
        
        // Related Books (Same Category)
        $relatedBooks = Book::with(['author', 'images'])
                            ->where('category_id', $book->category_id)
                            ->where('id', '!=', $book->id)
                            ->take(4)
                            ->get();

        return view('frontend.book-details', compact('book', 'relatedBooks'));
    }
}