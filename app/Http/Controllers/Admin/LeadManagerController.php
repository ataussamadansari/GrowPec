<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LeadManagerController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::with(['college', 'course'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = '%' . $request->search . '%';
            $query->where(function($q) use ($s) {
                $q->where('name', 'LIKE', $s)
                  ->orWhere('phone', 'LIKE', $s)
                  ->orWhere('city', 'LIKE', $s);
            });
        }

        $leads = $query->paginate(15)->withQueryString();

        return view('admin.leads.index', compact('leads'));
    }

    public function updateStatus(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);
        $lead->update([
            'status' => $request->status,
            'notes'  => $request->notes ?? $lead->notes
        ]);

        return back()->with('success', 'Lead status updated successfully.');
    }

    // Export Leads to CSV (Excel compatible)
    public function exportCsv(): StreamedResponse
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="growpec_leads_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Student Name', 'Phone', 'Email', 'City', 'College', 'Course', 'Source', 'Status', 'Date']);

            Lead::with(['college', 'course'])->chunk(100, function ($leads) use ($file) {
                foreach ($leads as $lead) {
                    fputcsv($file, [
                        $lead->id,
                        $lead->name,
                        $lead->phone,
                        $lead->email ?? 'N/A',
                        $lead->city ?? 'N/A',
                        $lead->college->name ?? 'Direct/General',
                        $lead->course->name ?? 'General',
                        $lead->source,
                        strtoupper($lead->status),
                        $lead->created_at->format('d M Y, h:i A')
                    ]);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}