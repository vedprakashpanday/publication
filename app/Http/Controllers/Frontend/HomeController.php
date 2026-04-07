<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. New Arrivals (Latest 4 books)
        $newArrivals = Book::with(['author', 'images'])->where('is_active', true)->latest()->take(4)->get();

        // 2. Only on Divyansh (Exclusive 3 books)
        // Assuming 'is_exclusive' column humne migration me add kiya tha
        $exclusiveBooks = Book::with('images')->where('is_exclusive', true)->where('is_active', true)->take(3)->get();

        // 3. Top Authors (4 authors)
        $topAuthors = Author::withCount('books')
        ->take(4)
        ->get();

        // 4. Books by Top Authors (4 books)
        $booksByTopAuthors = Book::with(['author', 'images'])->where('is_active', true)->inRandomOrder()->take(4)->get();

        // 5. Top Rated Books (4 books - assuming random or by highest rating logic)
        $topRatedBooks = Book::with('images')->where('is_active', true)->latest('updated_at')->take(4)->get();

        // 6. Trending Now / Most Read (4 books)
        $trendingBooks = Book::with(['author', 'images'])->where('is_active', true)->inRandomOrder()->take(4)->get();

        // 1. Fetching Buyer Stories (Latest 6)
    $buyerStories = \App\Models\BuyerStory::latest()->take(6)->get();

    // 2. Stats (Aap inhe dynamic bhi kar sakte hain Count query se)
    $stats = [
        'books_sold' => '15K+', 
        'happy_customers' => '12K+',
        'authors' => '150+',
        'delivery_cities' => '500+'
    ];

        return view('frontend.home', compact(
            'newArrivals', 
            'exclusiveBooks', 
            'topAuthors', 
            'booksByTopAuthors', 
            'topRatedBooks', 
            'trendingBooks',
            'buyerStories', 
            'stats'
        ));
    }
}