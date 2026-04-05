<?php

namespace App\Http\Controllers\Frontend; // Casing fix: 'Frontend'

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return redirect()->route('shop')->with('error', 'Your bag is empty!');
        }
        return view('frontend.checkout', compact('cart'));
    }

    public function placeOrder(Request $request)
    {
        // 1. Pehle check karein ki user login hai ya nahi
    if (!Auth::check()) {
        return redirect()->back()->withInput()->with('auth_required', 'Authentication Required: Please sign in to your account to complete your purchase and ensure secure order processing.');
    }

        // Validation (Name attributes ke saath sync)
        $request->validate([
            'email'      => 'required|email',
            'phone'      => 'required',
            'first_name' => 'required',
            'last_name'  => 'required',
            'address'    => 'required',
            'city'       => 'required',
            'state'      => 'required',
            'pincode'    => 'required',
        ]);

        $cart = session()->get('cart', []);
        
        // Totals Calculation
        $subtotal = 0;
        foreach($cart as $item) { $subtotal += $item['price'] * $item['quantity']; }
        $handling = round($subtotal * 0.02);
        $shipping = ($subtotal < 500) ? 50 : 0;
        $total = $subtotal + $handling + $shipping;

        // Address concatenation
        $full_address = $request->first_name . ' ' . $request->last_name . ", " . 
                        $request->address . " " . ($request->apartment ?? '') . ", " . 
                        $request->city . ", " . $request->state . " - " . $request->pincode;

        // Create Order
      $order = Order::create([
            'customer_id'     => Auth::id(), // YAHAN customer_id likhna zaroori hai
            'order_number'    => 'DP-' . strtoupper(uniqid()),
            'total_amount'    => $total,
            'status'          => 'pending',
            'payment_status'  => 'unpaid',
            'shipping_address' => $full_address,
        ]);

        // Create Order Items
        foreach($cart as $bookId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'book_id'  => $bookId,
                'quantity' => $item['quantity'],
                'price'    => $item['price'],
            ]);
        }

        session()->forget('cart');
        return redirect()->route('checkout.success', $order->order_number);
    }

    public function success($order_number)
    {
        return view('frontend.order-success', compact('order_number'));
    }
}