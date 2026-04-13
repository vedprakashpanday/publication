<?php

namespace App\Http\Controllers\Frontend; // Casing fix: 'Frontend'

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use Razorpay\Api\Api;

class CheckoutController extends Controller
{
   public function index()
    {
        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return redirect()->route('shop')->with('error', 'Your bag is empty!');
        }

        // 🌟 NAYA LOGIC: User ke saved addresses fetch karna
        $addresses = [];
        if (Auth::check()) {
            $addresses = Address::where('user_id', Auth::id())->latest()->get();
        }

        return view('frontend.checkout', compact('cart', 'addresses'));
    }

    public function placeOrder(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'auth_error', 'message' => 'Please login.']);
        }

        // Aapka purana validation aur Totals Calculation yahan rahega...
        $subtotal = 0;
        $cart = session()->get('cart', []);
        foreach($cart as $item) { $subtotal += $item['price'] * $item['quantity']; }
        $handling = round($subtotal * 0.02);
        $shipping = ($subtotal < 500) ? 50 : 0;
        $total = $subtotal + $handling + $shipping;

        $full_address = $request->first_name . ' ' . $request->last_name . ", " . 
                        $request->address . " " . ($request->apartment ?? '') . ", " . 
                        $request->city . ", " . $request->state . " - " . $request->pincode;

        // Create Order (Database me save hoga)
        $order = Order::create([
            'customer_id'         => Auth::id(), // Ya customer_id jo bhi aapke DB me ho
            'order_number'    => 'DP-' . strtoupper(uniqid()),
            'total_amount'    => $total,
            'status'          => 'pending',
            'payment_status'  => 'unpaid', // Abhi unpaid hai
            'shipping_address'=> $full_address,
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

        // 🌟 NAYA LOGIC: Payment Method Check
        if ($request->payment_method === 'online') {
            // Razorpay Order Generate karein
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            
            $razorpayOrder = $api->order->create([
                'receipt'         => $order->order_number,
                'amount'          => $total * 100, // Paise me convert karna zaroori hai (₹1 = 100 paise)
                'currency'        => 'INR',
                'payment_capture' => 1 
            ]);

            // Frontend ko Razorpay ID bhej rahe hain
            return response()->json([
                'status' => 'online',
                'razorpay_order_id' => $razorpayOrder['id'],
                'amount' => $total * 100,
                'order_number' => $order->order_number,
                'user_name' => $request->first_name . ' ' . $request->last_name,
                'user_email' => $request->email,
                'user_phone' => $request->phone,
            ]);
        } 
        else {
            // COD Logic
            session()->forget('cart');
            return response()->json([
                'status' => 'cod',
                'redirect_url' => route('checkout.success', $order->order_number)
            ]);
        }
    }

    // 🌟 NAYA METHOD: Razorpay Verification ke liye
    public function verifyPayment(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        
        try {
            // Signature verify karna (Security ke liye)
            $attributes = [
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature
            ];
            $api->utility->verifyPaymentSignature($attributes);

            // Agar verify ho gaya, toh Order ko 'Paid' mark kar do
            $order = Order::where('order_number', $request->order_number)->first();
            $order->update(['payment_status' => 'paid']);

            session()->forget('cart');
            
            return response()->json([
                'status' => 'success', 
                'redirect_url' => route('checkout.success', $order->order_number)
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    public function success($order_number)
    {
        return view('frontend.order-success', compact('order_number'));
    }
}