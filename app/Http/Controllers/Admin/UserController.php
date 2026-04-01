<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DailySale;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        // Sirf aam customers (role = user)
        $users = User::where('role', 'user')->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function sellers() {
        // Sirf sellers (role = seller)
        $sellers = User::where('role', 'seller')->latest()->paginate(10);
        return view('admin.users.sellers', compact('sellers'));
    }

    public function toggleStatus(User $user) {
        // User ko block/unblock karne ke liye
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success', 'Status updated successfully!');
    }

    public function salesReports(Request $request) {
    $sales = DailySale::with(['seller', 'book.publisher'])
            ->when($request->date, function($q) use ($request) {
                return $q->whereDate('sale_date', $request->date);
            })
            ->latest()
            ->paginate(20);

    return view('admin.sales.index', compact('sales'));
}
}