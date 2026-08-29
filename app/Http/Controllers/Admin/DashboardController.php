<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Course;
use App\Models\Lead;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_colleges' => College::count(),
            'regular_colleges' => College::where('college_mode', 'regular')->count(),
            'online_colleges'  => College::where('college_mode', 'online')->count(),
            'total_courses'   => Course::count(),
            'total_leads'     => Lead::count(),
            'new_leads_today' => Lead::whereDate('created_at', today())->count(),
        ];

        $recentLeads = Lead::with(['college', 'course'])
                           ->latest()
                           ->take(8)
                           ->get();

        return view('admin.dashboard', compact('stats', 'recentLeads'));
    }
}