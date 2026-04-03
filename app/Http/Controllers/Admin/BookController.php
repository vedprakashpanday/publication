<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\BookImage;
use App\Models\Author;
use App\Traits\ImageManagerTrait; // 1. Trait ko import kiya

class BookController extends Controller
{
    use ImageManagerTrait; // 2. Class ke andar Trait ko use kiya

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
        // 1. Basic Validation (Image validation updated for WebP conversion)
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'isbn_13' => 'required|unique:books,isbn_13',
            'price' => 'required|numeric',
            'published_date' => 'nullable|date',
            'binding' => 'required|in:Paperback,Hardbound,Spiral',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // Max 2MB allowed
            'extra_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048' // Multiple images validation
        ]);

        // 2. Cover Image Upload & Convert
        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $this->uploadAndConvertToWebp($request->file('cover_image'), 'uploads/books/covers');
        }

       // 3. Save Book Data (Yahan se 'cover_image' hata diya hai)
        $book = Book::create([
            'publisher_id' => $request->publisher_id,
            'author_id' => $request->author_id,
            'title' => $request->title,
            'isbn_13' => $request->isbn_13,
            'edition' => $request->edition,
            'published_date' => $request->published_date,
            'binding' => $request->binding,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'is_active' => true,
        ]);

        // 4. MAIN FIX: Cover Image ko book_images table mein save karein
        if ($coverPath) {
            BookImage::create([
                'book_id' => $book->id,
                'image_path' => $coverPath,
                'image_type' => 'cover' // Isse pata chalega ki ye main cover hai
            ]);
        }

        // 5. Handle Multiple Extra Images (Front, Back, Side)
        if ($request->hasFile('extra_images')) {
            foreach ($request->file('extra_images') as $image) {
                $path = $this->uploadAndConvertToWebp($image, 'uploads/books/gallery');
                
                BookImage::create([
                    'book_id' => $book->id,
                    'image_path' => $path,
                    'image_type' => 'gallery' // Ye extra/gallery images hain
                ]);
            }
        }

       return redirect()->route('admin.books.index')->with('success', 'Book added & Images optimized successfully!');
    }

    public function toggleStatus(Book $book)
    {
        // Status ko flip (ulta) kar do: True ko False, False ko True
        $book->is_active = !$book->is_active;
        $book->save();

        return back()->with('success', 'Book status updated successfully!');
    }

    public function show(Book $book)
    {
        // Author aur Publisher ka data load karein
        $book->load('author', 'publisher');

        // Main cover image get karein
        $cover = BookImage::where('book_id', $book->id)->where('image_type', 'cover')->first();
        
        // Extra/Gallery images get karein
        $galleryImages = BookImage::where('book_id', $book->id)->where('image_type', 'gallery')->get();

        return view('admin.books.show', compact('book', 'cover', 'galleryImages'));
    }

    // 1. Edit Form Dikhane Ka Method
    public function edit(Book $book)
    {
        $publishers = Publisher::all();
        $authors = Author::all();
        
        // Purani images fetch karein taaki form mein dikha sakein
        $cover = \App\Models\BookImage::where('book_id', $book->id)->where('image_type', 'cover')->first();
        $galleryImages = \App\Models\BookImage::where('book_id', $book->id)->where('image_type', 'gallery')->get();

        return view('admin.books.edit', compact('book', 'publishers', 'authors', 'cover', 'galleryImages'));
    }

    // 2. Data Update Karne Ka Method
    public function update(Request $request, Book $book)
    {
        // 1. Validation (Dhyan de: isbn unique check mein current book ko ignore kiya hai)
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'isbn_13' => 'required|unique:books,isbn_13,' . $book->id, // Important fix
            'price' => 'required|numeric',
            'published_date' => 'nullable|date',
            'binding' => 'required|in:Paperback,Hardbound,Spiral',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Ab nullable hai
            'extra_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        // 2. Text Data Update
        $book->update([
            'publisher_id' => $request->publisher_id,
            'author_id' => $request->author_id,
            'title' => $request->title,
            'isbn_13' => $request->isbn_13,
            'edition' => $request->edition,
            'published_date' => $request->published_date,
            'binding' => $request->binding,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
        ]);

        // 3. Cover Image Update (Agar nayi upload ki gayi hai)
        if ($request->hasFile('cover_image')) {
            $oldCover = \App\Models\BookImage::where('book_id', $book->id)->where('image_type', 'cover')->first();
            $oldPath = $oldCover ? $oldCover->image_path : null;

            // Trait automatically purani image delete karke nayi WebP save karega!
            $coverPath = $this->uploadAndConvertToWebp($request->file('cover_image'), 'uploads/books/covers', $oldPath);

            // Database record update ya create karein
            \App\Models\BookImage::updateOrCreate(
                ['book_id' => $book->id, 'image_type' => 'cover'],
                ['image_path' => $coverPath]
            );
        }

        // 4. Extra Images Update (Nayi images ko add kar dega)
        if ($request->hasFile('extra_images')) {
            foreach ($request->file('extra_images') as $image) {
                $path = $this->uploadAndConvertToWebp($image, 'uploads/books/gallery');
                \App\Models\BookImage::create([
                    'book_id' => $book->id,
                    'image_path' => $path,
                    'image_type' => 'gallery' 
                ]);
            }
        }

        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully!');
    }
}