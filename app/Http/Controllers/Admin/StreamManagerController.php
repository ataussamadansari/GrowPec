<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stream;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StreamManagerController extends Controller
{
    public function index(Request $request)
    {
        $query = Stream::withCount('courses');
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $streams = $query->latest()->paginate(15)->withQueryString();

        return view('admin.streams.index', compact('streams'));
    }

    public function create()
    {
        return view('admin.streams.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:streams,name',
            'icon' => 'nullable|string|max:50',
        ]);

        $validated['slug'] = Str::slug($request->name);
        Stream::create($validated);

        return redirect()->route('admin.streams.index')->with('success', 'Stream created successfully!');
    }

    public function edit($id)
    {
        $stream = Stream::findOrFail($id);
        return view('admin.streams.edit', compact('stream'));
    }

    public function update(Request $request, $id)
    {
        $stream = Stream::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:streams,name,' . $id,
            'icon' => 'nullable|string|max:50',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $stream->update($validated);

        return redirect()->route('admin.streams.index')->with('success', 'Stream updated successfully!');
    }

    public function destroy($id)
    {
        $stream = Stream::findOrFail($id);
        if ($stream->courses()->count() > 0) {
            return back()->with('error', 'Cannot delete stream because it contains courses. Delete courses first.');
        }
        $stream->delete();

        return back()->with('success', 'Stream deleted successfully.');
    }
}