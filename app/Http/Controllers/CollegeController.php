<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\College;
use App\Models\Course;
use App\Models\State;
use App\Models\Stream;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class CollegeController extends Controller
{
    /**
     * Regular campus colleges listing with filters.
     */
    public function regularColleges(Request $request)
    {
        return $this->getFilteredColleges($request, 'regular', 'colleges.index', 'Regular Colleges in India');
    }

    /**
     * Online & distance universities listing with filters.
     */
    public function onlineColleges(Request $request)
    {
        return $this->getFilteredColleges($request, 'online', 'colleges.index', 'Online & Distance Universities in India');
    }

    /**
     * College detail page — loads all child relations needed for the UI.
     */
    public function show(string $slug)
    {
        $college = College::where('slug', $slug)
            ->where('status', true)
            ->with([
                // Academic
                'collegeCourses.course.stream',
                'collegeCourses.specialization',
                'collegeCourses.specializationFees.specialization',

                // Content
                'collegeHighlights',
                'accreditations',
                'admissionSections',
                'scholarships',
                'placementStats',
                'recruiters',
                'careerOutcomes',
                'collegeFacilities',
                'loanOptions',
                'collegeFaqs',
                'gallery',
                'alumni',
                'reviews',
            ])
            ->firstOrFail();

        $siteSettings = SystemSetting::getAllCached();

        // ---------------------------------------------------------------
        // Dynamic left sticky nav — only include sections that have data
        // ---------------------------------------------------------------
        $quickNav = [];

        $quickNav[] = ['id' => 'sec-overview',    'title' => 'Overview',         'icon' => 'bi-info-circle'];
        $quickNav[] = ['id' => 'sec-quickfacts',  'title' => 'Quick Facts',      'icon' => 'bi-table'];

        if ($college->collegeHighlights->count() > 0) {
            $quickNav[] = ['id' => 'sec-highlights', 'title' => 'Key Highlights', 'icon' => 'bi-star'];
        }

        if ($college->collegeCourses->count() > 0) {
            $quickNav[] = ['id' => 'sec-courses', 'title' => 'Courses & Fees', 'icon' => 'bi-mortarboard'];
        }

        if ($college->admissionSections->count() > 0 || ! empty($college->admission_process)) {
            $quickNav[] = ['id' => 'sec-admission', 'title' => 'Admission', 'icon' => 'bi-card-checklist'];
        }

        if ($college->accreditations->count() > 0 || ! empty($college->approvals)) {
            $quickNav[] = ['id' => 'sec-accreditations', 'title' => 'Approvals', 'icon' => 'bi-shield-check'];
        }

        if ($college->placementStats->count() > 0 || ! empty($college->highest_package) || ! empty($college->average_package)) {
            $quickNav[] = ['id' => 'sec-placements', 'title' => 'Placements', 'icon' => 'bi-briefcase'];
        }

        if ($college->scholarships->count() > 0 || ! empty($college->scholarship_info)) {
            $quickNav[] = ['id' => 'sec-scholarships', 'title' => 'Scholarships', 'icon' => 'bi-award'];
        }

        if ($college->certificate_url) {
            $quickNav[] = ['id' => 'sec-certificate', 'title' => 'Sample Degree', 'icon' => 'bi-patch-check'];
        }

        if ($college->isRegular() && ($college->collegeFacilities->count() > 0 || $college->has_boys_hostel || $college->has_girls_hostel || ! empty($college->campus_size))) {
            $quickNav[] = ['id' => 'sec-facilities', 'title' => 'Facilities', 'icon' => 'bi-buildings'];
        }

        if ($college->collegeFaqs->count() > 0) {
            $quickNav[] = ['id' => 'sec-faqs', 'title' => 'FAQs', 'icon' => 'bi-question-circle'];
        }

        // Related colleges from same state
        $relatedColleges = College::where('id', '!=', $college->id)
            ->where('status', true)
            ->where('college_mode', $college->college_mode)
            ->where('state', $college->state)
            ->select(['id', 'name', 'slug', 'logo', 'banner_image', 'city', 'state', 'rating', 'college_type'])
            ->take(3)
            ->get();

        return view('colleges.show', compact('college', 'quickNav', 'relatedColleges', 'siteSettings'));
    }

    /**
     * Shared filter & query engine for both listing pages.
     */
    private function getFilteredColleges(
        Request $request,
        string $mode,
        string $view,
        string $pageTitle
    ) {
        $query = College::query()
            ->where('status', true)
            ->where('college_mode', $mode)            // strict: no 'both' anymore
            ->with(['courses.stream', 'collegeCourses.course']);

        // 1. Text search
        if ($request->filled('search')) {
            $searchTerm = '%'.$request->search.'%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', $searchTerm)
                    ->orWhere('city', 'LIKE', $searchTerm)
                    ->orWhere('state', 'LIKE', $searchTerm)
                    ->orWhere('university_name', 'LIKE', $searchTerm);
            });
        }

        // 2. Course levels (UG, PG, Diploma, PhD, Certificate)
        if ($request->filled('levels')) {
            $levels = (array) $request->levels;
            $query->whereHas('courses', fn ($q) => $q->whereIn('level', $levels));
        }

        // 3. Streams
        if ($request->filled('streams')) {
            $streams = (array) $request->streams;
            $query->whereHas('courses.stream', fn ($q) => $q->whereIn('slug', $streams)->orWhereIn('id', $streams)
            );
        }

        // 4. Specific courses
        if ($request->filled('courses')) {
            $courses = (array) $request->courses;
            $query->whereHas('courses', fn ($q) => $q->whereIn('slug', $courses)->orWhereIn('courses.id', $courses)
            );
        }

        // 5. Degree types
        if ($request->filled('degree_types')) {
            $degreeTypes = (array) $request->degree_types;
            $query->whereHas('courses', fn ($q) => $q->whereIn('degree_type', $degreeTypes));
        }

        // 6. Durations
        if ($request->filled('durations')) {
            $durations = (array) $request->durations;
            $query->whereHas('courses', fn ($q) => $q->whereIn('duration', $durations));
        }

        // 7. States
        if ($request->filled('states')) {
            $query->whereIn('state', (array) $request->states);
        }

        // 8. Cities
        if ($request->filled('cities')) {
            $query->whereIn('city', (array) $request->cities);
        }

        // 9. College type (Govt / Private / Deemed / Autonomous)
        if ($request->filled('types')) {
            $query->whereIn('college_type', (array) $request->types);
        }

        // 10. Hostel availability (regular only)
        if ($request->boolean('boys_hostel')) {
            $query->where('has_boys_hostel', true);
        }
        if ($request->boolean('girls_hostel')) {
            $query->where('has_girls_hostel', true);
        }

        // 11. Fee ranges
        if ($request->filled('fee_ranges')) {
            $ranges = (array) $request->fee_ranges;
            $query->whereHas('collegeCourses', function ($q) use ($ranges) {
                $q->where(function ($sub) use ($ranges) {
                    foreach ($ranges as $range) {
                        match ($range) {
                            'under_1l' => $sub->orWhere('fee_amount', '<', 100000),
                            '1l_to_2l' => $sub->orWhereBetween('fee_amount', [100000, 200000]),
                            '2l_to_3l' => $sub->orWhereBetween('fee_amount', [200000, 300000]),
                            '3l_to_5l' => $sub->orWhereBetween('fee_amount', [300000, 500000]),
                            '5l_to_10l' => $sub->orWhereBetween('fee_amount', [500000, 1000000]),
                            'above_10l' => $sub->orWhere('fee_amount', '>', 1000000),
                            default => null,
                        };
                    }
                });
            });
        }

        $colleges = $query
            ->orderByDesc('is_featured')
            ->orderByDesc('rating')
            ->paginate(12)
            ->withQueryString();

        // Filter sidebar data
        $allStreams = Stream::withCount('courses')->orderBy('name')->get();
        $allCourses = Course::with('stream')->orderBy('name')->get();
        $allStates = State::where('status', true)->orderBy('name')->pluck('name');
        if ($allStates->isEmpty()) {
            $allStates = College::where('status', true)->distinct()->pluck('state')->filter();
        }
        $allCities = City::where('status', true)->orderBy('name')->pluck('name');
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
