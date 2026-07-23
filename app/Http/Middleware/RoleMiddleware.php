<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles Comma-separated roles (e.g., 'admin,staff,applicant')
     * @param  string|null $guard Optional guard ('web' or 'applicant')
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roles, $guard = null)
    {
        $rolesArray = explode(',', $roles);

        // Default guard = 'web'
        $guard = $guard ?? 'web';

        if ($guard === 'applicant') {
            if (!Auth::guard('applicant')->check()) {
                return redirect('/login');
            }

            $user = Auth::guard('applicant')->user();
        } else {
            if (!Auth::guard('web')->check()) {
                return redirect('/login');
            }

            $user = Auth::guard('web')->user();
        }

        if (!in_array($user->role, $rolesArray)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
