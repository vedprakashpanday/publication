<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Image handle karne ke liye

class AuthorController extends Controller
{
    public function index() {
        $authors = Author::latest()->paginate(10);
        return view('admin.authors.index', compact('authors'));
    }

    public function create() {
        return view('admin.authors.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $imagePath = $request->file('profile_image') ? 
                     $request->file('profile_image')->store('authors', 'public') : null;

        Author::create([
            'name' => $request->name,
            'profile_image' => $imagePath,
            'born_date' => $request->born_date,
            'death_date' => $request->death_date,
            'about' => $request->about, // Summernote content
            'famous_works' => $request->famous_works,
        ]);

        return redirect()->route('admin.authors.index')->with('success', 'Author added successfully!');
    }

    // --- NAYE METHODS (EDIT, UPDATE, DESTROY) --- //

    public function edit(Author $author) {
        // Edit page par author ka data bhejenge
        return view('admin.authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author) {
        // Validation (Image optional hai update ke time)
        $request->validate([
            'name' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // Form ka baaki data ek array mein le lete hain
        $data = [
            'name' => $request->name,
            'born_date' => $request->born_date,
            'death_date' => $request->death_date,
            'about' => $request->about,
            'famous_works' => $request->famous_works,
        ];

        // Agar user ne nayi profile image upload ki hai
        if ($request->hasFile('profile_image')) {
            // 1. Purani image delete karein
            if ($author->profile_image && Storage::disk('public')->exists($author->profile_image)) {
                Storage::disk('public')->delete($author->profile_image);
            }
            
            // 2. Nayi image save karein aur array mein path update karein
            $data['profile_image'] = $request->file('profile_image')->store('authors', 'public');
        }

        // Database record update karein
        $author->update($data);

        return redirect()->route('admin.authors.index')->with('success', 'Author updated successfully!');
    }

    public function destroy(Author $author) {
        // 1. Database se record delete karne se pehle uski profile picture server se hatayein
        if ($author->profile_image && Storage::disk('public')->exists($author->profile_image)) {
            Storage::disk('public')->delete($author->profile_image);
        }

        // 2. Database se author ko delete karein
        $author->delete();

        return redirect()->route('admin.authors.index')->with('success', 'Author deleted successfully!');
    }
}