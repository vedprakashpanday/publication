<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale; 
use Illuminate\Http\Request;

class SalesController extends Controller
{
   public function index(Request $request)
{
    // 'user' relationship use karenge kyunki user_id column hai
    $query = Sale::with(['seller', 'book.publisher']);

    // Date filter logic: created_at column par lagega
    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    // Order by created_at (kyunki sale_date column nahi hai)
    $sales = $query->latest()->get();

    return view('admin.sales.index', compact('sales'));
}
}