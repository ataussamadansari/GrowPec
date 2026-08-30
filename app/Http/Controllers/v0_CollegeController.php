<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Course;
use App\Models\Stream;
use Illuminate\Http\Request;

class CollegeController extends Controller
{
    // 1. Regular Colleges Listing with Filters
    public function regularColleges(Request $request)
    {
        return $this->getFilteredColleges($request, 'regular', 'colleges.index', 'Regular Colleges in India');
    }

    // 2. Online Colleges Listing with Filters
    public function onlineColleges(Request $request)
    {
        return $this->getFilteredColleges($request, 'online', 'colleges.index', 'Online & Distance Universities in India');
    }

    // Common Filter Engine
    private function getFilteredColleges(Request $request, string $mode, string $view, string $pageTitle)
    {
        $query = College::query()
            ->where('status', true)
            ->where(function ($q) use ($mode) {
                $q->where('college_mode', $mode)->orWhere('college_mode', 'both');
            })
            ->with(['courses', 'collegeCourses.course']);

        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', $searchTerm)
                    ->orWhere('city', 'LIKE', $searchTerm)
                    ->orWhere('state', 'LIKE', $searchTerm)
                    ->orWhere('university_name', 'LIKE', $searchTerm);
            });
        }

        if ($request->filled('levels')) {
            $levels = (array) $request->levels;
            $query->whereHas('courses', function ($q) use ($levels) {
                $q->whereIn('level', $levels);
            });
        }

        if ($request->filled('streams')) {
            $streams = (array) $request->streams;
            $query->whereHas('courses.stream', function ($q) use ($streams) {
                $q->whereIn('slug', $streams)->orWhereIn('id', $streams);
            });
        }

        if ($request->filled('courses')) {
            $courses = (array) $request->courses;
            $query->whereHas('courses', function ($q) use ($courses) {
                $q->whereIn('slug', $courses)->orWhereIn('courses.id', $courses);
            });
        }

        if ($request->filled('states')) {
            $query->whereIn('state', (array) $request->states);
        }

        if ($request->filled('cities')) {
            $query->whereIn('city', (array) $request->cities);
        }

        if ($request->filled('types')) {
            $query->whereIn('college_type', (array) $request->types);
        }

        if ($request->boolean('boys_hostel')) {
            $query->where('has_boys_hostel', true);
        }
        if ($request->boolean('girls_hostel')) {
            $query->where('has_girls_hostel', true);
        }

        if ($request->filled('fee_range')) {
            $range = $request->fee_range;
            $query->whereHas('collegeCourses', function ($q) use ($range) {
                if ($range === 'under_1l') {
                    $q->where('fee_amount', '<', 100000);
                } elseif ($range === '1l_to_2l') {
                    $q->whereBetween('fee_amount', [100000, 200000]);
                } elseif ($range === '2l_to_3l') {
                    $q->whereBetween('fee_amount', [200000, 300000]);
                } elseif ($range === 'above_3l') {
                    $q->where('fee_amount', '>', 300000);
                }
            });
        }

        $colleges = $query->orderBy('is_featured', 'desc')
            ->orderBy('rating', 'desc')
            ->paginate(10)
            ->withQueryString();

        $allStreams = Stream::with('courses')->get();
        $allCourses = Course::all();
        $allStates  = College::where('status', true)->distinct()->pluck('state')->filter();
        $allCities  = College::where('status', true)->distinct()->pluck('city')->filter();

        return view($view, compact(
            'colleges', 'allStreams', 'allCourses', 'allStates', 'allCities', 'pageTitle', 'mode'
        ));
    }

    // 🎯 Dynamic College Detail Page
    public function show($slug)
    {
        $college = College::where('slug', $slug)
            ->where('status', true)
            ->with(['collegeCourses.course.stream'])
            ->firstOrFail();

        // 🎯 DYNAMIC LEFT STICKY NAVIGATION BUILDER
        $quickNav = [];
        $quickNav[] = ['id' => 'sec-overview', 'title' => 'Overview', 'icon' => 'bi-info-circle'];

        if (!empty($college->highlights) && count($college->highlights) > 0) {
            $quickNav[] = ['id' => 'sec-highlights', 'title' => 'Key Highlights', 'icon' => 'bi-star'];
        }

        if ($college->collegeCourses->count() > 0) {
            $quickNav[] = ['id' => 'sec-courses', 'title' => 'Courses & Fees', 'icon' => 'bi-mortarboard'];
        }

        if (!empty($college->admission_process)) {
            $quickNav[] = ['id' => 'sec-admission', 'title' => 'Admission Process', 'icon' => 'bi-card-checklist'];
        }

        if (!empty($college->highest_package) || !empty($college->average_package) || !empty($college->top_recruiters)) {
            $quickNav[] = ['id' => 'sec-placements', 'title' => 'Placements', 'icon' => 'bi-briefcase'];
        }

        if (!empty($college->scholarship_info)) {
            $quickNav[] = ['id' => 'sec-scholarships', 'title' => 'Scholarships', 'icon' => 'bi-award'];
        }

        if (!empty($college->sample_certificate_image)) {
            $quickNav[] = ['id' => 'sec-certificate', 'title' => 'Sample Degree', 'icon' => 'bi-patch-check'];
        }

        if ($college->college_mode !== 'online' && ($college->has_boys_hostel || $college->has_girls_hostel || !empty($college->campus_size))) {
            $quickNav[] = ['id' => 'sec-facilities', 'title' => 'Facilities', 'icon' => 'bi-buildings'];
        }

        if (!empty($college->faqs) && count($college->faqs) > 0) {
            $quickNav[] = ['id' => 'sec-faqs', 'title' => 'FAQs', 'icon' => 'bi-question-circle'];
        }

        $relatedColleges = College::where('id', '!=', $college->id)
            ->where('state', $college->state)
            ->where('status', true)
            ->take(3)
            ->get();

        return view('colleges.show', compact('college', 'quickNav', 'relatedColleges'));
    }
}