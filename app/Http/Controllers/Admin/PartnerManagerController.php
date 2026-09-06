<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerManagerController extends Controller
{
    public function index()
    {
        $partners = Partner::orderBy('sort_order', 'asc')->latest()->paginate(15);
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:150',
            'logo'       => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['sort_order'] = $request->input('sort_order', 0);
        $validated['status']     = $request->has('status');

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('partners', 'public');
        }

        Partner::create($validated);

        return redirect()->route('admin.partners.index')->with('success', 'Partner university added successfully!');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:150',
            'logo'       => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['sort_order'] = $request->input('sort_order', 0);
        $validated['status']     = $request->has('status');

        if ($request->hasFile('logo')) {
            if ($partner->logo && Storage::disk('public')->exists($partner->logo)) {
                Storage::disk('public')->delete($partner->logo);
            }
            $validated['logo'] = $request->file('logo')->store('partners', 'public');
        }

        $partner->update($validated);

        return redirect()->route('admin.partners.index')->with('success', 'Partner university updated successfully!');
    }

    public function destroy(Partner $partner)
    {
        if ($partner->logo && Storage::disk('public')->exists($partner->logo)) {
            Storage::disk('public')->delete($partner->logo);
        }
        $partner->delete();

        return back()->with('success', 'Partner university removed.');
    }
}