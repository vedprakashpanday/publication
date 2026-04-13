<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order; 
use App\Models\Address; 




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

                                     // 🌟 NAYA: Addresses fetch karein
    $addresses = \App\Models\Address::where('user_id', $user->id)->latest()->get();
    
    // Compact mein 'wishlists' bhi add kar diya
    return view('frontend.user-dashboard', compact('user', 'orders', 'wishlists', 'addresses'));
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

    // Upar import zaroor karein: use App\Models\Address;

public function storeAddress(Request $request)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'address_line' => 'required|string',
        'city' => 'required|string|max:100',
        'state' => 'required|string|max:100',
        'pincode' => 'required|string|max:10',
    ]);

    $data = $request->all();
    $data['user_id'] = Auth::id();
    
    // Checkbox array me value '1' bhejta hai agar checked ho
    $data['is_default'] = $request->has('is_default') ? true : false;

    // Agar isko default banaya hai, toh baaki sabko non-default kardo
    if ($data['is_default']) {
        Address::where('user_id', Auth::id())->update(['is_default' => false]);
    }

    // Agar pehla address hai, toh usko auto-default kardo
    if (Address::where('user_id', Auth::id())->count() == 0) {
        $data['is_default'] = true;
    }

    Address::create($data);

    // Wapas usi tab par bhejne ke liye url fragment use karte hain
    return redirect()->to(route('dashboard').'?tab=address')->with('success', 'Address added successfully!');
}

public function updateAddress(Request $request, $id)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'address_line' => 'required|string',
        'city' => 'required|string|max:100',
        'state' => 'required|string|max:100',
        'pincode' => 'required|string|max:10',
    ]);

    // Pehle address dhoondho aur make sure karo ki logged-in user ka hi hai
    $address = Address::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
    
    $data = $request->all();
    $data['is_default'] = $request->has('is_default') ? true : false;

    // Agar isko default banaya hai, toh baaki sabko non-default kardo
    if ($data['is_default']) {
        Address::where('user_id', Auth::id())->where('id', '!=', $id)->update(['is_default' => false]);
    }

    $address->update($data);

    return redirect()->to(route('dashboard').'?tab=address')->with('success', 'Address updated successfully!');
}

public function destroyAddress($id)
{
    $address = Address::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
    $address->delete();

    return redirect()->to(route('dashboard').'?tab=address')->with('success', 'Address deleted successfully!');
}
}