<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuyerStory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BuyerStoryController extends Controller
{
    public function index()
    {
        $stories = BuyerStory::latest()->get();
        return view('admin.buyer-stories.index', compact('stories'));
    }

    public function create()
    {
        return view('admin.buyer-stories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image_path' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'buyer_name' => 'nullable|string|max:255',
            'event_date' => 'required|date',
        ]);

        $data = $request->all();

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/stories');
            
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }
            
            $image->move($destinationPath, $name);
            $data['image_path'] = 'uploads/stories/' . $name;
        }

        BuyerStory::create($data);

        return redirect()->route('admin.buyer-stories.index')->with('success', 'Buyer Story added successfully!');
    }

    public function edit($id)
    {
        $story = BuyerStory::findOrFail($id);
        return view('admin.buyer-stories.edit', compact('story'));
    }

    public function update(Request $request, $id)
    {
        $story = BuyerStory::findOrFail($id);
        
        $request->validate([
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image_path')) {
            // Purani image delete karna
            if (File::exists(public_path($story->image_path))) {
                File::delete(public_path($story->image_path));
            }

            $image = $request->file('image_path');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/stories'), $name);
            $data['image_path'] = 'uploads/stories/' . $name;
        }

        $story->update($data);

        return redirect()->route('admin.buyer-stories.index')->with('success', 'Story updated successfully!');
    }

    public function destroy($id)
    {
        $story = BuyerStory::findOrFail($id);
        if (File::exists(public_path($story->image_path))) {
            File::delete(public_path($story->image_path));
        }
        $story->delete();

        return redirect()->route('admin.buyer-stories.index')->with('success', 'Story deleted successfully!');
    }

    public function toggle($id)
    {
        $story = BuyerStory::findOrFail($id);
        $story->is_active = !$story->is_active;
        $story->save();

        return back()->with('success', 'Status updated!');
    }
}