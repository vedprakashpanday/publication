<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\BuyerStory; // Model import kar lena

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class HomeController extends Controller
{
    // 1. Initial Load (Sirf wahi jo bina scroll kiye dikhta hai)
    public function index()
{
    $newArrivals = Book::with(['author', 'images'])->where('is_active', true)->latest()->take(4)->get();
    $exclusiveBooks = Book::with('images')->where('is_exclusive', true)->where('is_active', true)->take(3)->get();
    
    // Logged-in user ki wishlist IDs nikaal rahe hain
    $wishlistIds = [];
    if (Auth::check()) {
        $wishlistIds = \App\Models\Wishlist::where('user_id', Auth::id())->pluck('book_id')->toArray();
    }
    

    
    $stats = [
        'books_sold' => '15K+', 
        'happy_customers' => '12K+',
        'authors' => '150+',
        'delivery_cities' => '500+'
    ];

    // wishlistIds variable ko view me bhej diya
    return view('frontend.home', compact('newArrivals', 'exclusiveBooks', 'stats', 'wishlistIds'));
}

    // 2. AJAX Load (Scroll karne par chalega)
    public function loadSection(Request $request)
    {
        if ($request->ajax()) {
            $section = $request->section;
            $html = '';

            // Author Section Data
            if ($section == 'authors') {
                $topAuthors = Author::withCount('books')->take(4)->get();
                $booksByTopAuthors = Book::with(['author', 'images'])->where('is_active', true)->inRandomOrder()->take(4)->get();

                $wishlistIds = [];
    if (Auth::check()) {
        $wishlistIds = \App\Models\Wishlist::where('user_id', Auth::id())->pluck('book_id')->toArray();
    }
                
                // Ise partial view me bhejna hoga
                $html = view('frontend.partials.home_authors', compact('topAuthors', 'booksByTopAuthors','wishlistIds'))->render();
            }
            
            // Trending & Top Rated Section Data
            elseif ($section == 'trending') {
                $topRatedBooks = Book::with('images')->where('is_active', true)->latest('updated_at')->take(4)->get();
                $trendingBooks = Book::with(['author', 'images'])->where('is_active', true)->inRandomOrder()->take(4)->get();

                 $wishlistIds = [];
    if (Auth::check()) {
        $wishlistIds = \App\Models\Wishlist::where('user_id', Auth::id())->pluck('book_id')->toArray();
    }
                
                $html = view('frontend.partials.home_trending', compact('topRatedBooks', 'trendingBooks','wishlistIds'))->render();
            }
            
            // Buyer Stories Section Data
            elseif ($section == 'stories') {
                $buyerStories = BuyerStory::latest()->take(6)->get();
                
                     $wishlistIds = [];
    if (Auth::check()) {
        $wishlistIds = \App\Models\Wishlist::where('user_id', Auth::id())->pluck('book_id')->toArray();
    }



                $html = view('frontend.partials.home_stories', compact('buyerStories', 'wishlistIds'))->render();
            }

            return response()->json(['html' => $html]);
        }
        
        return response()->json(['error' => 'Invalid request'], 400);
    }
}