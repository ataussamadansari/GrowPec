<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    /**
     * Display combined State and City listing.
     */
    public function index(Request $request)
    {
        $states = State::withCount('cities')->orderBy('name')->get();

        $cityQuery = City::with('state');

        // Search by city name
        if ($request->filled('search')) {
            $cityQuery->where('name', 'LIKE', '%' . $request->search . '%');
        }

        // Filter by specific state
        if ($request->filled('state_id')) {
            $cityQuery->where('state_id', $request->state_id);
        }

        $cities = $cityQuery->latest()->paginate(15)->withQueryString();

        return view('admin.locations.index', compact('states', 'cities'));
    }

    // ==========================================
    // STATE OPERATIONS
    // ==========================================

    public function storeState(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:states,name',
        ]);

        State::create([
            'name'   => trim($validated['name']),
            'slug'   => Str::slug($validated['name']),
            'status' => true,
        ]);

        return back()->with('success', 'State "' . $validated['name'] . '" added successfully!');
    }

    public function updateState(Request $request, $id)
    {
        $state = State::findOrFail($id);

        $validated = $request->validate([
            'name'   => 'required|string|max:100|unique:states,name,' . $id,
            'status' => 'nullable|boolean',
        ]);

        $state->update([
            'name'   => trim($validated['name']),
            'slug'   => Str::slug($validated['name']),
            'status' => $request->has('status'),
        ]);

        return back()->with('success', 'State updated successfully!');
    }

    public function destroyState($id)
    {
        $state = State::findOrFail($id);

        if ($state->cities()->count() > 0) {
            return back()->with('error', 'Cannot delete state "' . $state->name . '" because it has associated cities. Please remove its cities first.');
        }

        $state->delete();
        return back()->with('success', 'State deleted successfully.');
    }

    // ==========================================
    // CITY OPERATIONS
    // ==========================================

    public function storeCity(Request $request)
    {
        $validated = $request->validate([
            'state_id'   => 'required|exists:states,id',
            'name'       => 'required|string|max:100',
            'is_popular' => 'nullable|boolean',
        ]);

        $cityName = trim($validated['name']);
        $slug     = Str::slug($cityName);

        // Prevent duplicate city in same state
        if (City::where('state_id', $validated['state_id'])->where('name', $cityName)->exists()) {
            return back()->with('error', 'City "' . $cityName . '" already exists in the selected state.');
        }

        City::create([
            'state_id'   => $validated['state_id'],
            'name'       => $cityName,
            'slug'       => $slug,
            'is_popular' => $request->has('is_popular'),
            'status'     => true,
        ]);

        return back()->with('success', 'City "' . $cityName . '" added successfully!');
    }

    public function updateCity(Request $request, $id)
    {
        $city = City::findOrFail($id);

        $validated = $request->validate([
            'state_id'   => 'required|exists:states,id',
            'name'       => 'required|string|max:100',
            'is_popular' => 'nullable|boolean',
            'status'     => 'nullable|boolean',
        ]);

        $cityName = trim($validated['name']);

        // Check duplicate within target state excluding current city
        $duplicate = City::where('state_id', $validated['state_id'])
            ->where('name', $cityName)
            ->where('id', '!=', $id)
            ->exists();

        if ($duplicate) {
            return back()->with('error', 'City "' . $cityName . '" already exists in that state.');
        }

        $city->update([
            'state_id'   => $validated['state_id'],
            'name'       => $cityName,
            'slug'       => Str::slug($cityName),
            'is_popular' => $request->has('is_popular'),
            'status'     => $request->has('status'),
        ]);

        return back()->with('success', 'City updated successfully!');
    }

    public function destroyCity($id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        return back()->with('success', 'City deleted successfully.');
    }
}