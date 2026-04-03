<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Http\Request;
use App\Traits\ImageManagerTrait; // 1. Trait import kiya

class PublisherController extends Controller
{
    use ImageManagerTrait; // 2. Class mein Trait ko use kiya

    public function index()
    {
        // Har publisher ki total books count ke sath fetch karenge.
        // DataTables use karne ke liye paginate(10) ki jagah get() best hai.
        $publishers = Publisher::withCount('books')->latest()->get();
        return view('admin.publishers.index', compact('publishers'));
    }

    public function create()
    {
        return view('admin.publishers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // WebP allowed
            'contact_no' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        // 3. Logo Upload & Convert to WebP via Trait
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $this->uploadAndConvertToWebp($request->file('logo'), 'uploads/publishers/logos');
        }

        Publisher::create([
            'name' => $request->name,
            'logo' => $logoPath,
            'contact_no' => $request->contact_no,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.publishers.index')->with('success', 'Publication added & logo optimized successfully!');
    }

    public function edit(Publisher $publisher)
    {
        return view('admin.publishers.edit', compact('publisher'));
    }

    public function update(Request $request, Publisher $publisher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'contact_no' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        // Basic data array prepare karein
        $data = [
            'name' => $request->name,
            'contact_no' => $request->contact_no,
            'address' => $request->address,
        ];

        // 4. Update Image Logic (Trait khud purani image delete karega)
        if ($request->hasFile('logo')) {
            $data['logo'] = $this->uploadAndConvertToWebp(
                $request->file('logo'), 
                'uploads/publishers/logos', 
                $publisher->logo // Purana logo path, taaki wo delete ho jaye
            );
        }

        $publisher->update($data);

        return redirect()->route('admin.publishers.index')->with('success', 'Publication updated successfully!');
    }

    public function destroy(Publisher $publisher)
    {
        // 5. Database se record delete karne se pehle uska logo server se delete karein via Trait
        $this->deleteImage($publisher->logo);

        // Database se record delete karein
        $publisher->delete();

        return redirect()->route('admin.publishers.index')->with('success', 'Publication deleted successfully!');
    }
}