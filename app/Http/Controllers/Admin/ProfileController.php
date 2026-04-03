<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function index() {
        return view('admin.profile');
    }

   public function update(Request $request) {
    $userId = Auth::id();
    
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $userId,
    ]);

    User::where('id', $userId)->update($request->only('name', 'email'));
    return back()->with('success', 'Profile updated successfully!');
}

    public function updatePassword(Request $request) {
    $request->validate([
        'current_password' => 'required|current_password',
        'password' => 'required|min:8|confirmed',
    ]);

    
    User::where('id', Auth::id())->update([
        'password' => Hash::make($request->password)
    ]);

    return back()->with('success', 'Password changed successfully!');
}
}