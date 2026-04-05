<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request; // Ye add karna zaroori hai

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Default redirect hata kar hum apna custom logic lagayenge
    protected function authenticated(Request $request, $user)
    {
        // Agar Admin login karta hai
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } 
           
        // Agar Seller login karta hai
        elseif ($user->role === 'seller') {
            return redirect()->route('seller.dashboard'); // Ye route hum aage banayenge
        }

        // Agar aam User login karta hai
        return redirect('/'); // Ya jo bhi aapke website ka front page ho
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}