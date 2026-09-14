<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LeadManagerController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::with([
            'college',
            'collegeCourse.course',
            'course',
            'specialization',
            'stateRelation',
            'cityRelation',
            'assignedCounselor',
        ])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = '%' . trim($request->search) . '%';

            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', $search)
                    ->orWhere('phone', 'LIKE', $search)
                    ->orWhere('email', 'LIKE', $search)
                    ->orWhere('city', 'LIKE', $search)
                    ->orWhere('state', 'LIKE', $search)
                    ->orWhereHas('college', fn ($college) =>
                        $college->where('name', 'LIKE', $search)
                    )
                    ->orWhereHas('course', fn ($course) =>
                        $course->where('name', 'LIKE', $search)
                    )
                    ->orWhereHas('collegeCourse', fn ($collegeCourse) =>
                        $collegeCourse->where('specialization', 'LIKE', $search)
                    )
                    ->orWhereHas('specialization', fn ($specialization) =>
                        $specialization->where('name', 'LIKE', $search)
                    );
            });
        }

        $leads = $query->paginate(15)->withQueryString();

        return view('admin.leads.index', compact('leads'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,contacted,counseling,admitted,closed'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'next_followup_at' => ['nullable', 'date'],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ]);

        $lead = Lead::findOrFail($id);

        $data = [
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? $lead->notes,
            'next_followup_at' => $validated['next_followup_at'] ?? $lead->next_followup_at,
            'assigned_to' => $validated['assigned_to'] ?? $lead->assigned_to,
        ];

        if ($validated['status'] === 'contacted' && !$lead->contacted_at) {
            $data['contacted_at'] = now();
        }

        if ($validated['status'] === 'closed' && !$lead->closed_at) {
            $data['closed_at'] = now();
        }

        $lead->update($data);

        return back()->with('success', 'Lead status updated successfully.');
    }

    public function exportCsv(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="growpec_leads_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            fwrite($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'ID', 'Student Name', 'Phone', 'Email', 'City', 'State',
                'College', 'Course', 'Specialization', 'Source', 'Status',
                'Counselor', 'Next Follow-up', 'Date',
            ]);

            Lead::with([
                'college',
                'collegeCourse.course',
                'course',
                'specialization',
                'assignedCounselor',
            ])->chunk(100, function ($leads) use ($file) {
                foreach ($leads as $lead) {
                    $course = $lead->collegeCourse?->course ?? $lead->course;

                    // college_courses.specialization is a text value, not an Eloquent relation.
                    $specialization = $lead->collegeCourse?->specialization
                        ?? $lead->specialization?->name;

                    fputcsv($file, [
                        $lead->id,
                        $lead->name,
                        $lead->phone,
                        $lead->email ?? 'N/A',
                        $lead->city ?? 'N/A',
                        $lead->state ?? 'N/A',
                        $lead->college?->name ?? 'Direct/General',
                        $course?->name ?? 'General',
                        $specialization ?? 'General/Core',
                        $lead->source,
                        strtoupper($lead->status),
                        $lead->assignedCounselor?->name ?? 'Unassigned',
                        $lead->next_followup_at?->format('d M Y, h:i A') ?? 'N/A',
                        $lead->created_at?->format('d M Y, h:i A'),
                    ]);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
