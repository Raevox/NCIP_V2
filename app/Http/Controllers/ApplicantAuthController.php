<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicantAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.applicant-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check kung status ay approved bago i-attempt ang login
        if (Auth::guard('applicant')->attempt(array_merge($credentials, ['status' => 'approved']))) {
            $request->session()->regenerate();
            return redirect()->route('applicant.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials or account not approved yet.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('applicant')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('applicant.login');
    }
}
