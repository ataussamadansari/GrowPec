<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;

use Illuminate\Support\Facades\Mail;
use App\Mail\NewLeadAlertMail;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'phone'      => 'required|string|max:20',
            'email'      => 'nullable|email|max:255',
            'city'       => 'nullable|string|max:100',
            'college_id' => 'nullable|exists:colleges,id',
            'course_id'  => 'nullable|exists:courses,id',
            'source'     => 'nullable|string'
        ]);

        Lead::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Thank you! Our expert counselor will contact you shortly.'
        ]);

$lead = Lead::create($validated);

// Send Email Alert to Admin (runs if SMTP configured)
try {
    Mail::to('admin@growpec.com')->send(new NewLeadAlertMail($lead));
} catch (\Exception $e) {
    // Log error if mail fails, without blocking user
    \Log::error('Lead mail failed: ' . $e->getMessage());
}
    }
}