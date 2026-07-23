<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\IpAccount;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        // 1️⃣ Admin / Staff login
        if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::guard('web')->user();

            if ($user->role === 'admin') return redirect()->route('admin.dashboard');
            if ($user->role === 'staff') return redirect()->route('staff.profile');

            return redirect()->route('dashboard');
        }

        // 2️⃣ Applicant login
        $applicant = IpAccount::where('email', $credentials['email'])->first();
        if ($applicant && Hash::check($credentials['password'], $applicant->password)) {
            Auth::guard('applicant')->login($applicant, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->route('applicant.dashboard');
        }

        // 3️⃣ Invalid credentials
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        if (Auth::guard('applicant')->check()) {
            Auth::guard('applicant')->logout();
        } else {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
