<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BuyerStory;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        // Hum yahan Laravel ka default Simple Pagination use karenge lazy loading ke liye
        $stories = BuyerStory::where('is_active', true)
                             ->latest('event_date')
                             ->paginate(9); // Ek baar mein 9 stories aayengi

        // Agar AJAX request aati hai (jaise user ne Load More scroll kiya)
        if ($request->ajax()) {
            $view = view('frontend.partials.memory_items', compact('stories'))->render();
            return response()->json(['html' => $view]);
        }

        return view('frontend.memories.index', compact('stories'));
    }
}