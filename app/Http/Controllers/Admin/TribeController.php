<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TribeController extends Controller
{
    /**
     * Display a listing of tribes.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $query = Tribe::query()->orderBy('name');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $tribes = $query->paginate(15)->withQueryString();

        return view('admin.tribes.index', compact('tribes', 'search'));
    }

    /**
     * Show the form for creating a new tribe.
     */
    public function create()
    {
        return view('admin.tribes.create');
    }

    /**
     * Store a newly created tribe.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:tribes,name',
            'description' => 'nullable|string|max:1000',
            'is_active'   => 'boolean',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('tribes', 'public');
        }

        Tribe::create([
            'name'        => trim($request->name),
            'description' => trim($request->description ?? ''),
            'is_active'   => $request->boolean('is_active', true),
            'photo'       => $photoPath,
        ]);

        return redirect()->route('admin.tribes.index')
                         ->with('success', 'Tribe "' . $request->name . '" has been added successfully.');
    }

    /**
     * Show the form for editing the specified tribe.
     */
    public function edit(Tribe $tribe)
    {
        return view('admin.tribes.edit', compact('tribe'));
    }

    /**
     * Update the specified tribe.
     */
    public function update(Request $request, Tribe $tribe)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:tribes,name,' . $tribe->id,
            'description' => 'nullable|string|max:1000',
            'is_active'   => 'boolean',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'name'        => trim($request->name),
            'description' => trim($request->description ?? ''),
            'is_active'   => $request->boolean('is_active', true),
        ];

        if ($request->hasFile('photo')) {
            // Delete old photo if it exists
            if ($tribe->photo) {
                Storage::disk('public')->delete($tribe->photo);
            }
            $data['photo'] = $request->file('photo')->store('tribes', 'public');
        }

        // Handle photo removal
        if ($request->input('remove_photo') === '1' && !$request->hasFile('photo')) {
            if ($tribe->photo) {
                Storage::disk('public')->delete($tribe->photo);
            }
            $data['photo'] = null;
        }

        $tribe->update($data);

        return redirect()->route('admin.tribes.index')
                         ->with('success', 'Tribe "' . $tribe->name . '" has been updated successfully.');
    }

    /**
     * Remove the specified tribe.
     */
    public function destroy(Tribe $tribe)
    {
        $name = $tribe->name;

        // Delete the photo from storage if it exists
        if ($tribe->photo) {
            Storage::disk('public')->delete($tribe->photo);
        }

        $tribe->delete();

        return redirect()->route('admin.tribes.index')
                         ->with('success', 'Tribe "' . $name . '" has been deleted.');
    }
}
