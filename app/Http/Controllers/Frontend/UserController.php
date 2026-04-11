<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order; 
class UserController extends Controller
{
  public function dashboard()
{
    /** @var \App\Models\User $user */
    $user = Auth::user();
    
    // Asli orders fetch karna
    $orders = Order::with('items.book')->where('customer_id', $user->id)->latest()->get();
    
    // 🌟 NAYA: Wishlist fetch karna (Book, Author aur Images ke sath)
    $wishlists = \App\Models\Wishlist::with(['book.author', 'book.images'])
                                     ->where('user_id', $user->id)
                                     ->latest()
                                     ->get();
    
    // Compact mein 'wishlists' bhi add kar diya
    return view('frontend.user-dashboard', compact('user', 'orders', 'wishlists'));
}

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Profile updated successfully!');
    }
}