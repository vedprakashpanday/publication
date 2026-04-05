<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;


class CartController extends Controller
{
    // Cart Page dikhane ke liye
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('frontend.cart', compact('cart'));
    }

    // Book add karne ke liye (AJAX ya Form dono se chalega)
   public function add(Request $request)
{
    $book = Book::with('images')->findOrFail($request->book_id);
    $cart = session()->get('cart', []);

    // Agar book pehle se cart mein hai toh quantity badhao
    if(isset($cart[$book->id])) {
        $cart[$book->id]['quantity'] += $request->quantity ?? 1;
    } else {
        // 1. Pehle 'front' image dhoondo
        $frontImage = $book->images->where('image_type', 'front')->first();
        
        // 2. Agar 'front' nahi mili, toh koi bhi pehli image utha lo (SMART FALLBACK)
        if(!$frontImage) {
            $frontImage = $book->images->first();
        }

        // Nayi book add karo
        $cart[$book->id] = [
            "title" => $book->title,
            "quantity" => $request->quantity ?? 1,
            "price" => $book->price,
            "image" => $frontImage ? $frontImage->image_path : null, // Null jayega agar koi image nahi hai
            "author" => $book->author->name ?? 'Unknown'
        ];
    }

    session()->put('cart', $cart);
    
   return back()->with(['status' => 'success', 'message' => 'Book added to cart!', 'cart_count' => count($cart)]);
}

    // Cart update karne ke liye
    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            return response()->json(['status' => 'success']);
        }
    }

    // Item remove karne ke liye
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return response()->json(['status' => 'success', 'message' => 'Item removed!']);
        }
    }

    // Cart items ko Save for Later mein bhejney ke liye
public function saveForLater($id)
{
    $cart = session()->get('cart');
    $saved = session()->get('saved_for_later', []);

    if(isset($cart[$id])) {
        $saved[$id] = $cart[$id]; // Item saved session mein copy karo
        unset($cart[$id]); // Cart se hatao
        
        session()->put('cart', $cart);
        session()->put('saved_for_later', $saved);
    }

    return response()->json(['status' => 'success', 'message' => 'Item saved for later!']);
}

// Saved items ko wapas Cart mein laane ke liye
public function moveToCart($id)
{
    $saved = session()->get('saved_for_later');
    $cart = session()->get('cart', []);

    if(isset($saved[$id])) {
        $cart[$id] = $saved[$id]; // Cart session mein wapas dalo
        unset($saved[$id]); // Saved se hatao
        
        session()->put('cart', $cart);
        session()->put('saved_for_later', $saved);
    }

    return response()->json(['status' => 'success', 'message' => 'Moved back to cart!']);
}

}