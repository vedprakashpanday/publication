<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\ImageManagerTrait; // Trait ko import kiya


class ProfileController extends Controller
{
    use ImageManagerTrait; // Class ke andar Trait ko use kiya

    public function index() {
        return view('admin.profile'); // Aapki file ka path agar admin.profile.index hai toh wo likhna
    }

  // app/Http/Controllers/Admin/ProfileController.php

public function update(Request $request) {
    /** @var \App\Models\User $user */
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    // Data set karna shuru
    $user->name = $request->name;
    $user->email = $request->email;

    // Image Handle Logic
    if ($request->remove_image == '1') {
        if ($user->profile_image && \File::exists(public_path($user->profile_image))) {
            \File::delete(public_path($user->profile_image));
        }
        $user->profile_image = null;
    } 
    elseif ($request->hasFile('profile_image')) {
        $user->profile_image = $this->uploadAndConvertToWebp(
            $request->file('profile_image'), 
            'uploads/profile', 
            $user->profile_image
        );
    }

    // Save - Ye 100% database me entry karega
    $user->save();

    return back()->with('success', 'Profile updated successfully!');
}


    public function updatePassword(Request $request) {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|min:8|confirmed',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password changed successfully!');
    }
}