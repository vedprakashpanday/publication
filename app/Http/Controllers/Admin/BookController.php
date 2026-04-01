<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\BookImage;
use App\Models\Author;

class BookController extends Controller
{

public function index()
    {
        // Books ko latest order mein 10 per page ke hisaab se get karenge
        $books = Book::with('publisher')->latest()->paginate(10);
        return view('admin.books.index', compact('books'));
    }

   public function create()
{
    $publishers = Publisher::all();
    $authors = Author::all(); // Authors fetch kar rahe hain
    return view('admin.books.create', compact('publishers', 'authors'));
}

    public function store(Request $request)
    {
        // 1. Basic Validation
       $request->validate([
        'title' => 'required|string|max:255',
        'author_id' => 'required|exists:authors,id',
        'publisher_id' => 'required|exists:publishers,id',
        'isbn_13' => 'required|unique:books,isbn_13',
        'price' => 'required|numeric',
        'published_date' => 'nullable|date',
        'binding' => 'required|in:Paperback,Hardbound,Spiral',
        'cover_image' => 'required|image|max:2048',
    ]);

        // 2. Cover Image Upload
        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('books/covers', 'public');
        }

        // Save Book Data
    $book = Book::create([
        'publisher_id' => $request->publisher_id,
        'author_id' => $request->author_id, // Naya addition
        'title' => $request->title,
        'isbn_13' => $request->isbn_13,
        'edition' => $request->edition,
        'published_date' => $request->published_date, // Naya addition
        'binding' => $request->binding, // Naya addition
        'price' => $request->price,
        'quantity' => $request->quantity,
        'description' => $request->description, // Summernote HTML content
        'cover_image' => $coverPath,
        'is_active' => true,
    ]);

        // 4. Handle Multiple Extra Images (Front, Back, Side)
        if ($request->hasFile('extra_images')) {
            foreach ($request->file('extra_images') as $image) {
                $path = $image->store('books/extra_images', 'public');
                BookImage::create([
                    'book_id' => $book->id,
                    'image_path' => $path,
                    'image_type' => 'gallery' 
                ]);
            }
        }

       return redirect()->route('admin.books.index')->with('success', 'Book added successfully!');
    }
}