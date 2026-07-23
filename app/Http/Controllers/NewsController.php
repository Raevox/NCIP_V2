<?php
namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    // 🌐 Public news listing
    public function publicIndex()
    {
        $news = News::where('status', 'Published')
            ->latest()
            ->paginate(6);

        return view('admin.content.website.news', compact('news')); // ✅ public view
    }

public function publicShow($id)
{
    $news = News::where('id', $id)->where('status', 'Published')->first();

    if (!$news) {
        abort(404); // Optional: show 404 if not found
    }

    return view('admin.content.website.news-show', compact('news'));
}

    // 🛠 Admin news listing
    public function index()
    {
        $news = News::latest()->paginate(10);
        return view('admin.news.index', compact('news')); // ✅ admin view
    }

    public function create()
    {
        return view('admin.news.create');
    }

 public function store(Request $request)
{
    $data = $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'image'       => 'nullable|image',
        'date'        => 'required|date',
        'status'      => 'required|string'
    ]);

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = $file->hashName();
        $file->store('news', 'public');
        $data['image'] = 'news/' . $filename;
    }

    News::create($data);
    return redirect()->route('admin.news.index')->with('success', 'News added successfully.');
}


    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image',
            'date'        => 'required|date',
            'status'      => 'required|string'
        ]);

        if ($request->hasFile('image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);
        return redirect()->route('admin.news.index')->with('success', 'News updated successfully.');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'News deleted successfully.');
    }
    // 🌐 Latest news for landing page preview
public function latestNewsPreview()
{
    $latestNews = \App\Models\News::where('status', 'Published')
                    ->latest()
                    ->take(5)
                    ->get(); // fetch only published news
    return view('admin.content.website.landingpage', compact('latestNews'));
}
}
