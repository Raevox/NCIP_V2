<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAccountStatus
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->status !== 'approved') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account is not yet approved.');
        }

        return $next($request);
    }
}
