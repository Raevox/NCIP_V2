<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\IpAccount;
use App\Models\IpRecord;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contact', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $accounts = $query->paginate(10);

        return view('admin.accounts.index', compact('accounts'));
    }

    /**
     * Display the specified account.
     */
    public function show(User $account)
    {
        return view('admin.accounts.show', compact('account'));
    }

    public function create()
    {
        return view('admin.accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'       => 'required|string|max:100',
            'last_name'        => 'required|string|max:100',
            'email'            => 'required|email|unique:users',
            'password'         => 'required|string|min:8',
            'contact'          => 'nullable|string|max:20',
            'address'          => 'nullable|string|max:255',
            'role'             => 'nullable|string|in:staff,admin',
            'status'           => 'nullable|in:active,inactive',
            'profile_picture'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $profilePath = $request->hasFile('profile_picture') 
                       ? $request->file('profile_picture')->store('profiles', 'public') 
                       : null;

        $role = $request->role ?? 'staff';

        User::create([
            'first_name'      => $request->first_name,
            'last_name'       => $request->last_name,
            'name'            => $request->first_name . ' ' . $request->last_name,
            'email'           => $request->email,
            'contact'         => $request->contact,
            'address'         => $request->address,
            'role'            => $role,
            'status'          => $request->status ?? 'active',
            'profile_picture' => $profilePath,
            'password'        => bcrypt($request->password),
        ]);

        return redirect()->route('admin.accounts.index')->with('success', 'Account created successfully!');
    }

    public function edit(User $account)
    {
        return view('admin.accounts.edit', compact('account'));
    }

    public function update(Request $request, User $account)
    {
        $request->validate([
            'first_name'       => 'required|string|max:100',
            'last_name'        => 'required|string|max:100',
            'email'            => 'required|email|unique:users,email,' . $account->id,
            'contact'          => 'nullable|string|max:20',
            'address'          => 'nullable|string|max:255',
            'role'             => 'nullable|string|in:staff,admin',
            'status'           => 'nullable|in:active,inactive',
            'profile_picture'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            if ($account->profile_picture) {
                Storage::disk('public')->delete($account->profile_picture);
            }
            $account->profile_picture = $request->file('profile_picture')->store('profiles', 'public');
        }

        $role = $request->role ?? 'staff';

        $account->update([
            'first_name'      => $request->first_name,
            'last_name'        => $request->last_name,
            'name'            => $request->first_name . ' ' . $request->last_name,
            'email'           => $request->email,
            'contact'         => $request->contact,
            'address'         => $request->address,
            'role'            => $role,
            'status'          => $request->status ?? 'active',
            'profile_picture' => $account->profile_picture,
        ]);

        return redirect()->route('admin.accounts.index')->with('success', 'Account updated successfully!');
    }

    public function destroy(User $account)
    {
        try {
            $account->delete();
            return redirect()->back()->with('success', 'Account archived successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to archive account: ' . $e->getMessage());
        }
    }

    public function restore($type, $id)
    {
        if ($type === 'admin' || $type === 'staff') {
            $account = User::withTrashed()->findOrFail($id);
            $account->restore();
        } elseif ($type === 'applicant') {
            $account = IpAccount::withTrashed()->findOrFail($id);
            $account->restore();

            \App\Models\CocApplication::withTrashed()
                ->where('user_id', $account->id)
                ->restore();

            IpRecord::withTrashed()
                ->where('user_id', $account->id)
                ->restore();
        } else {
            return redirect()->back()->with('error', 'Invalid account type.');
        }

        return redirect()->back()->with('success', ucfirst($type) . ' account restored successfully.');
    }

    public function archive()
    {
        $accounts = User::onlyTrashed()->get();
        return view('admin.accounts.archive', compact('accounts'));
    }
}
