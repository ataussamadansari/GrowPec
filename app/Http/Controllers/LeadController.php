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
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'email' => ['nullable', 'email', 'max:255'],

            'college_id' => ['nullable', 'exists:colleges,id'],
            'college_course_id' => ['nullable', 'exists:college_courses,id'],
            'course_id' => ['nullable', 'exists:courses,id'],
            'specialization_id' => ['nullable', 'exists:specializations,id'],

            'state_id' => ['nullable', 'exists:states,id'],
            'city_id' => ['nullable', 'exists:cities,id'],

            // Kept for existing forms/backward compatibility.
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],

            'source' => ['nullable', 'string', 'max:100'],
            'preferred_mode' => ['nullable', 'string', 'max:50'],
            'message' => ['nullable', 'string', 'max:5000'],

            'utm_source' => ['nullable', 'string', 'max:255'],
            'utm_medium' => ['nullable', 'string', 'max:255'],
            'utm_campaign' => ['nullable', 'string', 'max:255'],
        ]);

        // Never allow a college course belonging to another college.
        if (!empty($validated['college_course_id'])) {
            $collegeCourse = \App\Models\CollegeCourse::find($validated['college_course_id']);

            if (!$collegeCourse) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Selected program is not available.',
                ], 422);
            }

            if (!empty($validated['college_id']) &&
                (int) $collegeCourse->college_id !== (int) $validated['college_id']) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Selected program does not belong to the selected college.',
                ], 422);
            }

            $validated['college_id'] = $collegeCourse->college_id;
            $validated['course_id'] = $collegeCourse->course_id;
            $validated['specialization_id'] = $collegeCourse->specialization_id;
        }

        // If only course_id is supplied, keep the existing flow working.
        if (empty($validated['college_course_id']) && !empty($validated['college_id']) && !empty($validated['course_id'])) {
            $collegeCourse = \App\Models\CollegeCourse::where('college_id', $validated['college_id'])
                ->where('course_id', $validated['course_id'])
                ->first();

            if ($collegeCourse) {
                $validated['college_course_id'] = $collegeCourse->id;
                $validated['specialization_id'] = $collegeCourse->specialization_id;
            }
        }

        // Keep old text location fields synchronized when IDs are submitted.
        if (!empty($validated['state_id'])) {
            $state = \App\Models\State::find($validated['state_id']);
            if ($state) {
                $validated['state'] = $state->name;
            }
        }

        if (!empty($validated['city_id'])) {
            $city = \App\Models\City::find($validated['city_id']);
            if ($city) {
                $validated['city'] = $city->name;
            }
        }

        $validated['source'] = $validated['source'] ?? 'popup_modal';

        $lead = Lead::create($validated);

        try {
            Mail::to('admin@growpec.com')->send(new NewLeadAlertMail($lead));
        } catch (\Throwable $e) {
            Log::error('Lead mail failed: ' . $e->getMessage(), [
                'lead_id' => $lead->id,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Thank you! Your enquiry has been submitted. Our expert counselor will contact you shortly.',
        ]);
    }
}
