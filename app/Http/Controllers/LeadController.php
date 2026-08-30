<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewLeadAlertMail;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        // Enforce Login Wall for student enquiry
        if (!Auth::check()) {
            return response()->json([
                'status'       => 'unauthenticated',
                'require_auth' => true,
                'message'      => 'Please sign in with your phone number to submit admission enquiry.'
            ], 401);
        }

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'phone'      => 'required|string|max:20',
            'email'      => 'nullable|email|max:255',
            'city'       => 'nullable|string|max:100',
            'state'      => 'nullable|string|max:100',
            'college_id' => 'nullable|exists:colleges,id',
            'course_id'  => 'nullable|exists:courses,id',
            'source'     => 'nullable|string'
        ]);

        $lead = Lead::create($validated);

        // Safe background mail alert
        try {
            Mail::to('admin@growpec.com')->send(new NewLeadAlertMail($lead));
        } catch (\Exception $e) {
            \Log::error('Lead mail failed: ' . $e->getMessage());
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Thank you! Your enquiry has been submitted. Our expert counselor will contact you shortly.'
        ]);
    }
}