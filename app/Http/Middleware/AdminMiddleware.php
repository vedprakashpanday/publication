<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- Ye line add karein

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // auth() helper ki jagah Auth facade use karein, red line gayab ho jayegi
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        return redirect('/')->with('error', 'You do not have Admin access.');
    }
}