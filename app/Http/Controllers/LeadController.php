<?php

namespace App\Http\Controllers;

use App\Mail\NewLeadAlertMail;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'college_id' => 'nullable|exists:colleges,id',
            'course_id' => 'nullable|exists:courses,id',
            'source' => 'nullable|string',
        ]);

        $lead = Lead::create($validated);

        try {
            Mail::to('admin@growpec.com')->send(new NewLeadAlertMail($lead));
        } catch (\Exception $e) {
            Log::error('Lead mail failed: '.$e->getMessage());
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Thank you! Your enquiry has been submitted. Our expert counselor will contact you shortly.',
        ]);
    }
}
