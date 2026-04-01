<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Image delete karne ke liye zaroori hai

class PublisherController extends Controller
{
    public function index()
    {
        // Har publisher ki total books count ke sath fetch karenge
        $publishers = Publisher::withCount('books')->latest()->paginate(10);
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
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'contact_no' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        // Logo Upload Logic
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('publishers/logos', 'public');
        }

        Publisher::create([
            'name' => $request->name,
            'logo' => $logoPath,
            'contact_no' => $request->contact_no,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.publishers.index')->with('success', 'Publication added successfully!');
    }

    // --- NAYE METHODS YAHAN SE HAIN --- //

    public function edit(Publisher $publisher)
    {
        // Edit form dikhane ke liye publisher ka data bhej rahe hain
        return view('admin.publishers.edit', compact('publisher'));
    }

    public function update(Request $request, Publisher $publisher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'contact_no' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        // Basic data array prepare karein
        $data = [
            'name' => $request->name,
            'contact_no' => $request->contact_no,
            'address' => $request->address,
        ];

        // Agar user ne naya logo upload kiya hai
        if ($request->hasFile('logo')) {
            // 1. Purana logo storage se delete karein (agar exist karta hai)
            if ($publisher->logo && Storage::disk('public')->exists($publisher->logo)) {
                Storage::disk('public')->delete($publisher->logo);
            }
            
            // 2. Naya logo save karein aur array mein add karein
            $data['logo'] = $request->file('logo')->store('publishers/logos', 'public');
        }

        // Database mein record update karein
        $publisher->update($data);

        return redirect()->route('admin.publishers.index')->with('success', 'Publication updated successfully!');
    }

    public function destroy(Publisher $publisher)
    {
        // 1. Database se record delete karne se pehle uska logo server se delete karein
        if ($publisher->logo && Storage::disk('public')->exists($publisher->logo)) {
            Storage::disk('public')->delete($publisher->logo);
        }

        // 2. Database se record delete karein
        $publisher->delete();

        return redirect()->route('admin.publishers.index')->with('success', 'Publication deleted successfully!');
    }
}