<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CocApplication;
use App\Models\Staff;

class StaffController extends Controller
{
    // ================================
    // Login & Logout
    // ================================
    public function showLoginForm()
    {
        return view('staff.login'); // Blade view for staff login
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('staff')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('staff.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('staff')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('staff.login');
    }

    // ================================
    // Dashboard & Profile
    // ================================
    public function index()
    {
        $staff = Auth::guard('staff')->user();
        return view('staff.profile', compact('staff'));
    }

    // ================================
    // Review Applications
    // ================================
    public function review()
    {
        $applications = CocApplication::with('user')->orderBy('created_at', 'desc')->get();

        $pending = $applications->where('status', 'Pending');
        $approved = $applications->where('status', 'Approved');
        $returned = $applications->where('status', 'Returned');

        return view('staff.review', compact('pending', 'approved', 'returned'));
    }

    public function show($id)
    {
        $application = CocApplication::with('user')->findOrFail($id);
        return view('staff.show_application', compact('application'));
    }

    public function approve($id)
    {
        $application = CocApplication::findOrFail($id);
        $application->status = 'Approved';
        $application->save();

        return redirect()->back()->with('success', 'Application approved.');
    }

    public function return(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'required|string|max:1000',
        ]);

        $application = CocApplication::findOrFail($id);
        $application->status = 'Returned';
        $application->remarks = $request->remarks;
        $application->save();

        return redirect()->back()->with('success', 'Application returned to applicant.');
    }
}
