<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    /**
     * Display a listing of partners.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $sector = $request->get('sector');

        $query = Partner::query()->orderBy('sector')->orderBy('sort_order')->orderBy('name');

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($sector && in_array($sector, ['government', 'private'])) {
            $query->where('sector', $sector);
        }

        $partners = $query->paginate(15)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html'  => view('admin.partners.partials.table', compact('partners', 'search', 'sector'))->render(),
                'total' => $partners->total(),
            ]);
        }

        return view('admin.partners.index', compact('partners', 'search', 'sector'));
    }

    /**
     * Show the form for creating a new partner.
     */
    public function create()
    {
        return view('admin.partners.create');
    }

    /**
     * Store a newly created partner.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'sector'     => 'required|in:government,private',
            'is_active'  => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'logo'       => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('partners', 'public');
        }

        Partner::create([
            'name'       => trim($request->name),
            'sector'     => $request->sector,
            'is_active'  => $request->boolean('is_active', true),
            'sort_order' => $request->input('sort_order', 0),
            'logo'       => $logoPath,
        ]);

        return redirect()->route('admin.partners.index')
                         ->with('success', 'Partner "' . $request->name . '" has been added successfully.');
    }

    /**
     * Show the form for editing the specified partner.
     */
    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    /**
     * Update the specified partner.
     */
    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'sector'     => 'required|in:government,private',
            'is_active'  => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'logo'       => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
        ]);

        $data = [
            'name'       => trim($request->name),
            'sector'     => $request->sector,
            'is_active'  => $request->boolean('is_active', true),
            'sort_order' => $request->input('sort_order', 0),
        ];

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($partner->logo) {
                Storage::disk('public')->delete($partner->logo);
            }
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }

        // Handle logo removal
        if ($request->input('remove_logo') === '1' && !$request->hasFile('logo')) {
            if ($partner->logo) {
                Storage::disk('public')->delete($partner->logo);
            }
            $data['logo'] = null;
        }

        $partner->update($data);

        return redirect()->route('admin.partners.index')
                         ->with('success', 'Partner "' . $partner->name . '" has been updated successfully.');
    }

    /**
     * Remove the specified partner.
     */
    public function destroy(Partner $partner)
    {
        $name = $partner->name;

        if ($partner->logo) {
            Storage::disk('public')->delete($partner->logo);
        }

        $partner->delete();

        return redirect()->route('admin.partners.index')
                         ->with('success', 'Partner "' . $name . '" has been deleted.');
    }
}
