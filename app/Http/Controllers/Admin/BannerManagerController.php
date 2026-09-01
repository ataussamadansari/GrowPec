<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerManagerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order', 'asc')->latest()->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image'      => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'title'      => 'nullable|string|max:150',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['sort_order'] = $request->input('sort_order', 0);
        $validated['status']     = $request->has('status');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('banners', 'public');
        }

        Banner::create($validated);

        return redirect()->route('admin.banners.index')->with('success', 'Banner uploaded successfully!');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'title'      => 'nullable|string|max:150',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['sort_order'] = $request->input('sort_order', 0);
        $validated['status']     = $request->has('status');

        if ($request->hasFile('image')) {
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }
            $validated['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($validated);

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully!');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }
        $banner->delete();

        return back()->with('success', 'Banner removed.');
    }
}