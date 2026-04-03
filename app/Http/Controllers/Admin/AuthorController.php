<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Traits\ImageManagerTrait; // 1. Trait import kiya

class AuthorController extends Controller
{
    use ImageManagerTrait; // 2. Class mein Trait ko use kiya

    public function index() {
        $authors = Author::latest()->get();
        return view('admin.authors.index', compact('authors'));
    }

    public function create() {
        return view('admin.authors.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048', // webp allowed
        ]);

        // 3. Trait se image convert aur save karayi
        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $imagePath = $this->uploadAndConvertToWebp($request->file('profile_image'), 'uploads/authors');
        }

        Author::create([
            'name' => $request->name,
            'profile_image' => $imagePath,
            'born_date' => $request->born_date,
            'death_date' => $request->death_date,
            'about' => $request->about, // Summernote content
            'famous_works' => $request->famous_works,
        ]);

        return redirect()->route('admin.authors.index')->with('success', 'Author profile & image optimized successfully!');
    }

    public function edit(Author $author) {
        return view('admin.authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author) {
        $request->validate([
            'name' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'born_date' => $request->born_date,
            'death_date' => $request->death_date,
            'about' => $request->about,
            'famous_works' => $request->famous_works,
        ];

        // 4. Update Image Logic (Trait khud purani image delete karega)
        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $this->uploadAndConvertToWebp(
                $request->file('profile_image'), 
                'uploads/authors', 
                $author->profile_image // Purana path bhej diya delete karne ke liye
            );
        }

        $author->update($data);

        return redirect()->route('admin.authors.index')->with('success', 'Author updated successfully!');
    }

    public function destroy(Author $author) {
        // 5. Delete method from Trait
        $this->deleteImage($author->profile_image);

        $author->delete();

        return redirect()->route('admin.authors.index')->with('success', 'Author deleted successfully!');
    }
}