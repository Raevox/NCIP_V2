<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Get the last activity timestamp
            $lastActivity = session('last_activity');
            
            // If last activity exists and it's been more than 30 minutes
            if ($lastActivity && Carbon::parse($lastActivity)->diffInMinutes(now()) >= 30) {
                // Clear all sessions
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                // Redirect with message
                return redirect()->route('login')->with('timeout', 'Your session has expired due to inactivity. Please log in again.');
            }
        }

        // For applicant guard
        if (Auth::guard('applicant')->check()) {
            $lastActivity = session('last_activity');
            if ($lastActivity && Carbon::parse($lastActivity)->diffInMinutes(now()) >= 30) {
                Auth::guard('applicant')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->with('timeout', 'Your session has expired due to inactivity. Please log in again.');
            }
        }

        // Update last activity timestamp
        session(['last_activity' => now()]);

        return $next($request);
    }
}