<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Abhi ke liye dummy data bhej rahe hain UI check karne ke liye
        return view('admin.dashboard');
    }
}