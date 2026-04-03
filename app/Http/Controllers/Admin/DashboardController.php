<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
public function index() {
    $data = [
        'total_books'     => \App\Models\Book::count(),
        'total_orders'    => \App\Models\Order::count(),
        'total_revenue'   => \App\Models\Sale::sum('total_amount'),
        'pending_stocks'  => \App\Models\StockRequest::where('status', 'pending')->count(),
        'recent_orders'   => \App\Models\Order::with('user')->latest()->take(5)->get(),
       
    ];

    $salesData = \App\Models\Sale::selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
    ->groupByRaw('DATE(created_at)')
    ->orderBy('date', 'desc')
    ->take(7)
    ->get()
    ->reverse(); // reverse isliye taaki chart left-to-right (purane se naya) dikhe

$data['sales_labels'] = $salesData->pluck('date');
$data['sales_values'] = $salesData->pluck('total');
    return view('admin.dashboard', $data);
}
}