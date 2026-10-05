<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CenterLogin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CenterLoginManagerController extends Controller
{
    /**
     * Display a listing of center logins.
     */
    public function index(Request $request): View
    {
        $query = CenterLogin::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('url', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->input('status') === '1');
        }

        $centerLogins = $query->orderBy('index', 'asc')
            ->orderBy('id', 'asc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.center-logins.index', compact('centerLogins'));
    }

    /**
     * Show the form for creating a new center login.
     */
    public function create(): View
    {
        return view('admin.center-logins.create');
    }

    /**
     * Store a newly created center login in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:190',
            'url' => 'required|url|max:500',
            'index' => 'nullable|integer|min:0',
        ]);

        $validated['index'] = $request->input('index', 0) ?? 0;
        $validated['is_active'] = $request->boolean('is_active');

        CenterLogin::create($validated);

        return redirect()
            ->route('admin.center-logins.index')
            ->with('success', 'Center Login created successfully.');
    }

    /**
     * Show the form for editing the specified center login.
     */
    public function edit(CenterLogin $centerLogin): View
    {
        return view('admin.center-logins.edit', compact('centerLogin'));
    }

    /**
     * Update the specified center login in storage.
     */
    public function update(Request $request, CenterLogin $centerLogin): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:190',
            'url' => 'required|url|max:500',
            'index' => 'nullable|integer|min:0',
        ]);

        $validated['index'] = $request->input('index', 0) ?? 0;
        $validated['is_active'] = $request->boolean('is_active');

        $centerLogin->update($validated);

        return redirect()
            ->route('admin.center-logins.index')
            ->with('success', 'Center Login updated successfully.');
    }

    /**
     * Remove the specified center login from storage.
     */
    public function destroy(CenterLogin $centerLogin): RedirectResponse
    {
        $centerLogin->delete();

        return back()->with('success', 'Center Login deleted successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(CenterLogin $centerLogin)
    {
        $centerLogin->update([
            'is_active' => ! $centerLogin->is_active,
        ]);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $centerLogin->is_active,
                'message' => 'Status updated successfully.',
            ]);
        }

        return back()->with('success', 'Status updated successfully.');
    }
}
