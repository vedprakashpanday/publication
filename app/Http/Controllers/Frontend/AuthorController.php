<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Category;

class AuthorController extends Controller
{
   public function index(Request $request)
{
    $query = Author::query()->withCount('books');

    // 🔍 Search Filter
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // 📚 Category Filter (Optional: Authors who write in specific categories)
    if ($request->filled('categories')) {
        $query->whereHas('books', function($q) use ($request) {
            $q->whereIn('category_id', $request->categories);
        });
    }

    $authors = $query->paginate(12);
    $categories = \App\Models\Category::withCount('books')->get();

    return view('frontend.authors.index', compact('authors', 'categories'));
}

  public function show(Request $request, $id)
{
    $author = Author::findOrFail($id);

    // 1. Author ki books ki base query banayein
    $query = $author->books()->with('images');

    // 2. 🔍 Search Filter
    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    // 3. 📚 Category Filter
    if ($request->filled('categories')) {
        $query->whereIn('category_id', $request->categories);
    }

    // 4. 💰 Price Filter
    if ($request->filled('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }
    if ($request->filled('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }

    // Final filtered books
    $books = $query->get();

    // 5. 📊 Categories (Dynamic Counts ke liye)
    // Hum sirf wahi categories dikhayenge jo is Author ne likhi hain
    $categories = Category::whereHas('books', function($q) use ($id) {
        $q->where('author_id', $id);
    })->withCount(['books' => function($q) use ($id) {
        $q->where('author_id', $id);
    }])->get();

    return view('frontend.author-single.show', compact('author', 'books', 'categories'));
}
}