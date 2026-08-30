<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\State;
use App\Models\City;

class StudentProfileController extends Controller
{
    /**
     * Show Student Profile Dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $states = State::where('status', true)->orderBy('name')->get();
        $cities = City::where('status', true)->orderBy('name')->get();

        return view('student.profile', compact('user', 'states', 'cities'));
    }

    /**
     * Update Student Profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'    => 'required|string|max:150',
            'email'   => 'nullable|email|max:150|unique:users,email,' . $user->id,
            'phone'   => 'required|string|max:20|unique:users,phone,' . $user->id,
            'gender'  => 'nullable|in:Male,Female,Other',
            'dob'     => 'nullable|date',
            'state'   => 'nullable|string|max:100',
            'city'    => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
        ]);

        $user->update($validated);

        return back()->with('success', 'Your profile details have been saved successfully!');
    }
}