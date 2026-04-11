<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Please login to add to wishlist.'], 401);
        }

        $bookId = $request->book_id;
        $userId = Auth::id();

        $wishlist = Wishlist::where('user_id', $userId)->where('book_id', $bookId)->first();

        if ($wishlist) {
            // Agar pehle se hai, toh hata do (Toggle Off)
            $wishlist->delete();
            return response()->json(['status' => 'removed', 'message' => 'Removed from wishlist.']);
        } else {
            // Agar nahi hai, toh add kar do (Toggle On)
            Wishlist::create([
                'user_id' => $userId,
                'book_id' => $bookId
            ]);
            return response()->json(['status' => 'added', 'message' => 'Added to wishlist!']);
        }
    }
}