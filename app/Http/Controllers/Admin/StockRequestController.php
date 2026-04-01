<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\StockRequest;
use App\Http\Controllers\Controller;

class StockRequestController extends Controller
{
    public function index() {
    // Eager loading: user, book, and book's publisher/author
    $requests = StockRequest::with(['user', 'book.publisher', 'book.author'])
                ->latest()
                ->paginate(15);
                
    return view('admin.stock_request.index', compact('requests'));
}

public function approve(StockRequest $request) {
    // Logic: Jab Admin approve kare, toh main stock se quantity kam ho jaye
    if($request->book->stock >= $request->quantity) {
        $request->book->decrement('stock', $request->quantity);
        $request->update(['status' => 'approved']);
        return back()->with('success', 'Request Approved & Stock Adjusted!');
    }
    return back()->with('error', 'Insufficient Main Stock!');
}
}
