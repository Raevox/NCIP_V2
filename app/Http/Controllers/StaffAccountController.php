<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StaffAccountController extends Controller
{
    public function index()
    {
        // Ipakita lang yung mga staff accounts
        $accounts = User::where('role', 'staff')->paginate(10);
        return view('staff.accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('staff.accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|string|min:8',
        ]);

        User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'name'       => $request->first_name.' '.$request->last_name,
            'email'      => $request->email,
            'password'   => bcrypt($request->password),
            'role'       => 'staff', // 👈 siguradong staff lang
            'status'     => 'active',
        ]);

        return redirect()->route('staff.accounts.index')->with('success', 'Staff account created successfully!');
    }

    public function show(User $account)
    {
        return view('staff.accounts.show', compact('account'));
    }
}
