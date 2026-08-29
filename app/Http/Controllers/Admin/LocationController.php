<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    public function index()
    {
        $states = State::withCount('cities')->orderBy('name')->get();
        $cities = City::with('state')->latest()->paginate(15);
        return view('admin.locations.index', compact('states', 'cities'));
    }

    public function storeState(Request $request)
    {
        $request->validate(['name' => 'required|unique:states,name|max:100']);
        State::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => true
        ]);
        return back()->with('success', 'State added successfully!');
    }

    public function storeCity(Request $request)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'name' => 'required|max:100'
        ]);

        City::create([
            'state_id' => $request->state_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'is_popular' => $request->has('is_popular'),
            'status' => true
        ]);
        return back()->with('success', 'City added successfully!');
    }

    public function destroyCity($id)
    {
        City::findOrFail($id)->delete();
        return back()->with('success', 'City deleted.');
    }
}