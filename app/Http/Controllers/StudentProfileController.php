<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Lead;
use App\Models\State;
use App\Models\City;

class StudentProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $states = State::where('status', true)->orderBy('name')->get();
        $cities = City::where('status', true)->orderBy('name')->get();
        
        // 🎯 Fetch student's real submitted inquiries
        $cleanPhone = User::sanitizePhone($user->phone);
        $myLeads = Lead::where('phone', $cleanPhone)
            ->with(['college', 'course'])
            ->latest()
            ->get();

        return view('student.profile', compact('user', 'states', 'cities', 'myLeads'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ($request->filled('phone')) {
            $request->merge(['phone' => User::sanitizePhone($request->phone)]);
        }

        $validated = $request->validate([
            'name'    => 'required|string|max:150',
            'email'   => ['nullable', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user->id)],
            'phone'   => ['required', 'regex:/^[6-9]\d{9}$/', Rule::unique('users', 'phone')->ignore($user->id)],
            'gender'  => 'nullable|in:Male,Female,Other',
            'dob'     => 'nullable|date',
            'state'   => 'nullable|string|max:100',
            'city'    => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
        ], [
            'phone.regex'  => 'Please enter a valid 10-digit Indian mobile number.',
            'phone.unique' => 'This mobile number is already registered with another account.',
        ]);

        $user->update($validated);

        return back()->with('success', 'Your profile details have been saved successfully!');
    }
}