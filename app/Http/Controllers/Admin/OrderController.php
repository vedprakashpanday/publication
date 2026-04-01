<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index() {
        $orders = Order::with('user')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order) {
        $order->load('items.book', 'user');
        return view('admin.orders.show', compact('order'));
    }

    // Merged & Smart Tracking + Inventory Logic
    public function updateTracking(Request $request, Order $order) {
        $request->validate([
            'status' => 'required',
            'courier_name' => 'nullable|string',
            'tracking_id' => 'nullable|string',
            'tracking_msg' => 'nullable|string',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // DB Transaction taaki agar stock update fail ho to data kharab na ho
        DB::transaction(function () use ($request, $order, $oldStatus, $newStatus) {
            
            // 1. STOCK MINUS LOGIC: Jab order dispatch ho raha ho
            // Hum check kar rahe hain ki status pehle dispatch nahi tha, par ab ho gaya hai
            $dispatchedStatuses = ['shipped', 'delivered'];
            if (!in_array($oldStatus, $dispatchedStatuses) && in_array($newStatus, $dispatchedStatuses)) {
                foreach ($order->items as $item) {
                    $item->book->decrement('stock', $item->quantity);
                }
            }

            // 2. STOCK PLUS LOGIC: Jab order Cancel ho aur Admin confirm kare ki book mil gayi hai
            if ($newStatus == 'cancelled' && in_array($oldStatus, $dispatchedStatuses)) {
                if ($request->has('stock_restored')) { 
                    foreach ($order->items as $item) {
                        $item->book->increment('stock', $item->quantity);
                    }
                    $order->tracking_msg = "Order Cancelled & Stock Restored. " . $request->tracking_msg;
                }
            }

            // 3. Update Order Table
            $order->update([
                'status' => $newStatus,
                'courier_name' => $request->courier_name,
                'tracking_id' => $request->tracking_id,
                'tracking_msg' => $request->tracking_msg ?? $order->tracking_msg,
            ]);
        });

        return back()->with('success', 'Order and Inventory updated successfully!');
    }

    public function refund(Order $order) {
        if ($order->status == 'cancelled' && $order->payment_status == 'paid') {
            $order->update([
                'refund_status' => 'processed',
                'tracking_msg' => 'Refund of ₹' . $order->total_amount . ' has been processed.'
            ]);
            return back()->with('success', 'Refund marked as processed!');
        }
        return back()->with('error', 'Unable to process refund.');
    }

    public function cancel(Request $request, Order $order) {
        $order->update([
            'status' => 'cancelled',
            'cancel_reason' => $request->reason ?? 'Cancelled by Admin',
        ]);

        if($order->payment_status == 'paid') {
            $order->update(['refund_status' => 'pending']);
        }

        return back()->with('success', 'Order has been cancelled.');
    }
}