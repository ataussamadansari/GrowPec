<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Course;
use App\Models\Stream;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;

class CollegeController extends Controller
{
    /**
     * 1. Regular Campus Colleges Listing with Filters
     */
    public function regularColleges(Request $request)
    {
        return $this->getFilteredColleges($request, 'regular', 'colleges.index', 'Regular Colleges in India');
    }

    /**
     * 2. Online & Distance Universities Listing with Filters
     */
    public function onlineColleges(Request $request)
    {
        return $this->getFilteredColleges($request, 'online', 'colleges.index', 'Online & Distance Universities in India');
    }

    /**
     * 3. College Detail Page (Fixed show method)
     */
    public function show($slug)
    {
        $college = College::where('slug', $slug)
            ->where('status', true)
            ->with(['collegeCourses.course.stream'])
            ->firstOrFail();

        // Dynamic Left Sticky Navigation Builder based on available sections
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

    /**
     * 4. Common Filter & Query Engine
     */
    private function getFilteredColleges(Request $request, string $mode, string $view, string $pageTitle)
    {
        $query = College::query()
            ->where('status', true)
            ->where(function ($q) use ($mode) {
                $q->where('college_mode', $mode)->orWhere('college_mode', 'both');
            })
            ->with(['courses.stream', 'collegeCourses.course']);

        // 1. Text Search
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', $searchTerm)
                    ->orWhere('city', 'LIKE', $searchTerm)
                    ->orWhere('state', 'LIKE', $searchTerm)
                    ->orWhere('university_name', 'LIKE', $searchTerm);
            });
        }

        // 2. Levels (UG, PG, Diploma, PhD, Certificate)
        if ($request->filled('levels')) {
            $levels = (array) $request->levels;
            $query->whereHas('courses', function ($q) use ($levels) {
                $q->whereIn('level', $levels);
            });
        }

        // 3. Streams
        if ($request->filled('streams')) {
            $streams = (array) $request->streams;
            $query->whereHas('courses.stream', function ($q) use ($streams) {
                $q->whereIn('slug', $streams)->orWhereIn('id', $streams);
            });
        }

        // 4. Specific Courses
        if ($request->filled('courses')) {
            $courses = (array) $request->courses;
            $query->whereHas('courses', function ($q) use ($courses) {
                $q->whereIn('slug', $courses)->orWhereIn('courses.id', $courses);
            });
        }

        // 5. Degree Types
        if ($request->filled('degree_types')) {
            $degreeTypes = (array) $request->degree_types;
            $query->whereHas('courses', function ($q) use ($degreeTypes) {
                $q->whereIn('degree_type', $degreeTypes);
            });
        }

        // 6. Course Durations
        if ($request->filled('durations')) {
            $durations = (array) $request->durations;
            $query->whereHas('courses', function ($q) use ($durations) {
                $q->whereIn('duration', $durations);
            });
        }

        // 7. States
        if ($request->filled('states')) {
            $query->whereIn('state', (array) $request->states);
        }

        // 8. Cities
        if ($request->filled('cities')) {
            $query->whereIn('city', (array) $request->cities);
        }

        // 9. College Ownership / Type
        if ($request->filled('types')) {
            $query->whereIn('college_type', (array) $request->types);
        }

        // 10. Hostel Facilities
        if ($request->boolean('boys_hostel')) {
            $query->where('has_boys_hostel', true);
        }
        if ($request->boolean('girls_hostel')) {
            $query->where('has_girls_hostel', true);
        }

        // 11. Fees Ranges
        if ($request->filled('fee_ranges')) {
            $ranges = (array) $request->fee_ranges;
            $query->whereHas('collegeCourses', function ($q) use ($ranges) {
                $q->where(function ($subQ) use ($ranges) {
                    foreach ($ranges as $range) {
                        if ($range === 'under_1l') {
                            $subQ->orWhere('fee_amount', '<', 100000);
                        } elseif ($range === '1l_to_2l') {
                            $subQ->orWhereBetween('fee_amount', [100000, 200000]);
                        } elseif ($range === '2l_to_3l') {
                            $subQ->orWhereBetween('fee_amount', [200000, 300000]);
                        } elseif ($range === '3l_to_5l') {
                            $subQ->orWhereBetween('fee_amount', [300000, 500000]);
                        } elseif ($range === '5l_to_10l') {
                            $subQ->orWhereBetween('fee_amount', [500000, 1000000]);
                        } elseif ($range === 'above_10l') {
                            $subQ->orWhere('fee_amount', '>', 1000000);
                        }
                    }
                });
            });
        }

        $colleges = $query->orderBy('is_featured', 'desc')
            ->orderBy('rating', 'desc')
            ->paginate(12)
            ->withQueryString();

        // Dynamic Filter Data
        $allStreams   = Stream::withCount('courses')->orderBy('name')->get();
        $allCourses   = Course::with('stream')->orderBy('name')->get();
        $allStates    = State::where('status', true)->orderBy('name')->pluck('name');
        if ($allStates->isEmpty()) {
            $allStates = College::where('status', true)->distinct()->pluck('state')->filter();
        }
        $allCities    = City::where('status', true)->orderBy('name')->pluck('name');
        if ($allCities->isEmpty()) {
            $allCities = College::where('status', true)->distinct()->pluck('city')->filter();
        }
        $allDurations = Course::distinct()->pluck('duration')->filter()->values();

        return view($view, compact(
            'colleges',
            'allStreams',
            'allCourses',
            'allStates',
            'allCities',
            'allDurations',
            'pageTitle',
            'mode'
        ));
    }
}