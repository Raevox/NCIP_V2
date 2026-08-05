<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accomplishment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AccomplishmentController extends Controller
{
    /**
     * Display a listing of accomplishments.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $query = Accomplishment::query()->orderBy('sort_order')->orderBy('id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('year_group', 'like', "%{$search}%");
            });
        }

        $accomplishments = $query->paginate(15)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html'  => view('admin.accomplishments.partials.table', compact('accomplishments', 'search'))->render(),
                'total' => $accomplishments->total(),
            ]);
        }

        return view('admin.accomplishments.index', compact('accomplishments', 'search'));
    }

    /**
     * Show the form for creating a new accomplishment.
     */
    public function create()
    {
        return view('admin.accomplishments.create');
    }

    /**
     * Store a newly created accomplishment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'date_label'   => 'nullable|string|max:100',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'extra_images' => 'nullable|array|max:4',
            'extra_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096',
            'layout_type'  => 'required|in:1,2,4,5',
            'year_group'   => 'nullable|string|max:20',
            'sort_order'   => 'nullable|integer|min:0',
            'is_active'    => 'boolean',
        ]);

        // Upload main image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('accomplishments', 'public');
        }

        // Upload extra images (for layout 5)
        $extraImagePaths = null;
        if ($request->hasFile('extra_images')) {
            $extraImagePaths = [];
            foreach ($request->file('extra_images') as $file) {
                $extraImagePaths[] = $file->store('accomplishments', 'public');
            }
        }

        Accomplishment::create([
            'title'        => trim($request->title),
            'description'  => trim($request->description ?? ''),
            'date_label'   => trim($request->date_label ?? ''),
            'image'        => $imagePath,
            'extra_images' => $extraImagePaths,
            'layout_type'  => $request->layout_type,
            'year_group'   => trim($request->year_group ?? ''),
            'sort_order'   => $request->sort_order ?? 0,
            'is_active'    => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.accomplishments.index')
                         ->with('success', 'Accomplishment "' . $request->title . '" has been added successfully.');
    }

    /**
     * Show the form for editing the specified accomplishment.
     */
    public function edit(Accomplishment $accomplishment)
    {
        return view('admin.accomplishments.edit', compact('accomplishment'));
    }

    /**
     * Update the specified accomplishment.
     */
    public function update(Request $request, Accomplishment $accomplishment)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'date_label'   => 'nullable|string|max:100',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'extra_images' => 'nullable|array|max:4',
            'extra_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096',
            'layout_type'  => 'required|in:1,2,4,5',
            'year_group'   => 'nullable|string|max:20',
            'sort_order'   => 'nullable|integer|min:0',
            'is_active'    => 'boolean',
        ]);

        $data = [
            'title'       => trim($request->title),
            'description' => trim($request->description ?? ''),
            'date_label'  => trim($request->date_label ?? ''),
            'layout_type' => $request->layout_type,
            'year_group'  => trim($request->year_group ?? ''),
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => $request->boolean('is_active', true),
        ];

        // Replace main image if a new one is uploaded
        if ($request->hasFile('image')) {
            if ($accomplishment->image && Storage::disk('public')->exists($accomplishment->image)) {
                Storage::disk('public')->delete($accomplishment->image);
            }
            $data['image'] = $request->file('image')->store('accomplishments', 'public');
        }

        // Handle main image removal
        if ($request->input('remove_image') === '1' && !$request->hasFile('image')) {
            if ($accomplishment->image && Storage::disk('public')->exists($accomplishment->image)) {
                Storage::disk('public')->delete($accomplishment->image);
            }
            $data['image'] = null;
        }

        // Replace extra images if new ones are uploaded
        if ($request->hasFile('extra_images')) {
            // Delete old extra images from storage (only if they are stored files, not content/ paths)
            if ($accomplishment->extra_images) {
                foreach ($accomplishment->extra_images as $old) {
                    if (Storage::disk('public')->exists($old)) {
                        Storage::disk('public')->delete($old);
                    }
                }
            }
            $extraImagePaths = [];
            foreach ($request->file('extra_images') as $file) {
                $extraImagePaths[] = $file->store('accomplishments', 'public');
            }
            $data['extra_images'] = $extraImagePaths;
        }

        $accomplishment->update($data);

        return redirect()->route('admin.accomplishments.index')
                         ->with('success', 'Accomplishment "' . $accomplishment->title . '" has been updated successfully.');
    }

    /**
     * Remove the specified accomplishment.
     */
    public function destroy(Accomplishment $accomplishment)
    {
        $title = $accomplishment->title;

        // Delete main image from storage (only stored files, not legacy content/ paths)
        if ($accomplishment->image && Storage::disk('public')->exists($accomplishment->image)) {
            Storage::disk('public')->delete($accomplishment->image);
        }

        // Delete extra images from storage
        if ($accomplishment->extra_images) {
            foreach ($accomplishment->extra_images as $path) {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        }

        $accomplishment->delete();

        return redirect()->route('admin.accomplishments.index')
                         ->with('success', 'Accomplishment "' . $title . '" has been deleted.');
    }
}
