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
        return $this->getFilteredColleges($request, 'regular', 'colleges.index', 'Regular Universities in India');
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
                'approvedReviews',
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

        // Student Reviews (Always available so visitors can read & write reviews)
        $quickNav[] = ['id' => 'sec-reviews', 'title' => 'Reviews', 'icon' => 'bi-star-half'];

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
            ->where('college_mode', $mode)
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
        $levels = array_filter(array_merge(
            (array) $request->input('levels', []),
            $request->filled('level') ? [$request->input('level')] : []
        ));
        if (! empty($levels)) {
            $query->whereHas('courses', fn ($q) => $q->whereIn('level', $levels));
        }

        // 3. Streams (supports slug, ID, or name)
        $streams = array_values(array_filter(array_merge(
            (array) $request->input('streams', []),
            $request->filled('stream') ? [$request->input('stream')] : []
        )));
        if (! empty($streams)) {
            $numericStreams = array_filter($streams, 'is_numeric');
            $stringStreams = array_filter($streams, fn ($s) => ! is_numeric($s));

            $query->whereHas('courses.stream', function ($q) use ($numericStreams, $stringStreams) {
                $q->where(function ($sq) use ($numericStreams, $stringStreams) {
                    if (! empty($stringStreams)) {
                        $sq->whereIn('slug', $stringStreams)
                            ->orWhereIn('name', $stringStreams);
                    }
                    if (! empty($numericStreams)) {
                        $sq->orWhereIn('streams.id', $numericStreams);
                    }
                });
            });
        }

        // 4. Specific courses (supports slug, ID, or name)
        $courses = array_values(array_filter(array_merge(
            (array) $request->input('courses', []),
            $request->filled('course') ? [$request->input('course')] : []
        )));
        if (! empty($courses)) {
            $numericCourses = array_filter($courses, 'is_numeric');
            $stringCourses = array_filter($courses, fn ($c) => ! is_numeric($c));

            $query->whereHas('courses', function ($q) use ($numericCourses, $stringCourses) {
                $q->where(function ($cq) use ($numericCourses, $stringCourses) {
                    if (! empty($stringCourses)) {
                        $cq->whereIn('courses.slug', $stringCourses)
                            ->orWhereIn('courses.name', $stringCourses);
                    }
                    if (! empty($numericCourses)) {
                        $cq->orWhereIn('courses.id', $numericCourses);
                    }
                });
            });
        }

        // 5. Degree types
        $degreeTypes = array_filter(array_merge(
            (array) $request->input('degree_types', []),
            $request->filled('degree_type') ? [$request->input('degree_type')] : []
        ));
        if (! empty($degreeTypes)) {
            $query->whereHas('courses', fn ($q) => $q->whereIn('degree_type', $degreeTypes));
        }

        // 6. Durations
        $durations = array_filter(array_merge(
            (array) $request->input('durations', []),
            $request->filled('duration') ? [$request->input('duration')] : []
        ));
        if (! empty($durations)) {
            $query->whereHas('courses', fn ($q) => $q->whereIn('duration', $durations));
        }

        // 7. States (supports string, ID, or slug)
        $states = array_values(array_filter(array_merge(
            (array) $request->input('states', []),
            $request->filled('state') ? [$request->input('state')] : []
        )));
        if (! empty($states)) {
            $numericStates = array_filter($states, 'is_numeric');
            $stringStates = array_filter($states, fn ($s) => ! is_numeric($s));

            $query->where(function ($q) use ($numericStates, $stringStates) {
                if (! empty($stringStates)) {
                    $q->whereIn('state', $stringStates)
                        ->orWhereHas('stateRelation', fn ($sq) => $sq->whereIn('slug', $stringStates)->orWhereIn('name', $stringStates));
                }
                if (! empty($numericStates)) {
                    $q->orWhereIn('state_id', $numericStates);
                }
            });
        }

        // 8. Cities (supports string, ID, or slug)
        $cities = array_values(array_filter(array_merge(
            (array) $request->input('cities', []),
            $request->filled('city') ? [$request->input('city')] : []
        )));
        if (! empty($cities)) {
            $numericCities = array_filter($cities, 'is_numeric');
            $stringCities = array_filter($cities, fn ($c) => ! is_numeric($c));

            $query->where(function ($q) use ($numericCities, $stringCities) {
                if (! empty($stringCities)) {
                    $q->whereIn('city', $stringCities)
                        ->orWhereHas('cityRelation', fn ($cq) => $cq->whereIn('slug', $stringCities)->orWhereIn('name', $stringCities));
                }
                if (! empty($numericCities)) {
                    $q->orWhereIn('city_id', $numericCities);
                }
            });
        }

        // 9. College type (Govt / Private / Deemed / Autonomous)
        $types = array_filter(array_merge(
            (array) $request->input('types', []),
            $request->filled('type') ? [$request->input('type')] : []
        ));
        if (! empty($types)) {
            $query->whereIn('college_type', $types);
        }

        // 10. Hostel availability (regular only)
        if ($request->boolean('boys_hostel')) {
            $query->where('has_boys_hostel', true);
        }
        if ($request->boolean('girls_hostel')) {
            $query->where('has_girls_hostel', true);
        }

        // 11. Fee ranges
        $feeRanges = array_filter(array_merge(
            (array) $request->input('fee_ranges', []),
            $request->filled('fee_range') ? [$request->input('fee_range')] : []
        ));
        if (! empty($feeRanges)) {
            $query->whereHas('collegeCourses', function ($q) use ($feeRanges) {
                $q->where(function ($sub) use ($feeRanges) {
                    foreach ($feeRanges as $range) {
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

        // 12. Dynamic Sorting
        $sort = $request->input('sort', 'popular');
        match ($sort) {
            'rating_desc', 'rating' => $query->orderByDesc('rating')->orderByDesc('is_featured')->orderByDesc('id'),
            'name_asc' => $query->orderBy('name', 'asc'),
            'name_desc' => $query->orderBy('name', 'desc'),
            'established_desc' => $query->orderByDesc('established_year')->orderByDesc('is_featured'),
            'established_asc' => $query->orderBy('established_year', 'asc')->orderByDesc('is_featured'),
            default => $query->orderByDesc('is_featured')->orderByDesc('rating')->orderByDesc('id'),
        };

        $colleges = $query
            ->paginate(12)
            ->withQueryString();

        // Filter sidebar data
        $allStreams = Stream::withCount('courses')->orderBy('name')->get();
        $allCourses = Course::with('stream')->orderBy('name')->get();
        $allStates = State::where('status', true)->orderBy('name')->pluck('name');
        if ($allStates->isEmpty()) {
            $allStates = College::where('status', true)->distinct()->pluck('state')->filter();
        }

        $citiesQuery = City::where('status', true);
        if (! empty($states)) {
            $citiesQuery->whereHas('state', function ($sq) use ($states) {
                $sq->whereIn('name', $states)->orWhereIn('id', $states)->orWhereIn('slug', $states);
            });
        }
        $allCities = $citiesQuery->orderBy('name')->pluck('name');
        if ($allCities->isEmpty()) {
            $collegeCityQuery = College::where('status', true);
            if (! empty($states)) {
                $collegeCityQuery->whereIn('state', $states);
            }
            $allCities = $collegeCityQuery->distinct()->pluck('city')->filter();
        }

        $allDurations = Course::distinct()->pluck('duration')->filter()->values();
        $activeFilterChips = $this->buildActiveFilterChips($request);

        return view($view, compact(
            'colleges',
            'allStreams',
            'allCourses',
            'allStates',
            'allCities',
            'allDurations',
            'activeFilterChips',
            'pageTitle',
            'mode',
            'sort'
        ));
    }

    /**
     * Builds structured active filter chips metadata with individual removal URLs.
     */
    private function buildActiveFilterChips(Request $request): array
    {
        $chips = [];
        $allParams = $request->query();

        $makeRemoveUrl = function (string $key, ?string $val = null) use ($allParams, $request) {
            $params = $allParams;
            unset($params['page']);

            if ($val === null) {
                unset($params[$key]);
            } elseif (isset($params[$key]) && is_array($params[$key])) {
                $params[$key] = array_values(array_filter($params[$key], fn ($v) => (string) $v !== (string) $val));
                if (empty($params[$key])) {
                    unset($params[$key]);
                }
            } elseif (isset($params[$key])) {
                unset($params[$key]);
            }

            return $request->url().(empty($params) ? '' : '?'.http_build_query($params));
        };

        if ($request->filled('search')) {
            $chips[] = [
                'label' => 'Search: "'.$request->search.'"',
                'remove_url' => $makeRemoveUrl('search'),
            ];
        }

        if ($request->filled('stream')) {
            $chips[] = [
                'label' => 'Stream: '.ucwords(str_replace('-', ' ', (string) $request->stream)),
                'remove_url' => $makeRemoveUrl('stream'),
            ];
        }
        if ($request->filled('streams')) {
            foreach ((array) $request->streams as $s) {
                $chips[] = [
                    'label' => 'Stream: '.ucwords(str_replace('-', ' ', (string) $s)),
                    'remove_url' => $makeRemoveUrl('streams', $s),
                ];
            }
        }

        if ($request->filled('course')) {
            $chips[] = [
                'label' => 'Course: '.strtoupper(str_replace('-', ' ', (string) $request->course)),
                'remove_url' => $makeRemoveUrl('course'),
            ];
        }
        if ($request->filled('courses')) {
            foreach ((array) $request->courses as $c) {
                $chips[] = [
                    'label' => 'Course: '.strtoupper(str_replace('-', ' ', (string) $c)),
                    'remove_url' => $makeRemoveUrl('courses', $c),
                ];
            }
        }

        if ($request->filled('state')) {
            $chips[] = [
                'label' => 'State: '.$request->state,
                'remove_url' => $makeRemoveUrl('state'),
            ];
        }
        if ($request->filled('states')) {
            foreach ((array) $request->states as $st) {
                $chips[] = [
                    'label' => 'State: '.$st,
                    'remove_url' => $makeRemoveUrl('states', $st),
                ];
            }
        }

        if ($request->filled('city')) {
            $chips[] = [
                'label' => 'City: '.$request->city,
                'remove_url' => $makeRemoveUrl('city'),
            ];
        }
        if ($request->filled('cities')) {
            foreach ((array) $request->cities as $ct) {
                $chips[] = [
                    'label' => 'City: '.$ct,
                    'remove_url' => $makeRemoveUrl('cities', $ct),
                ];
            }
        }

        if ($request->filled('level')) {
            $chips[] = [
                'label' => 'Level: '.strtoupper((string) $request->level),
                'remove_url' => $makeRemoveUrl('level'),
            ];
        }
        if ($request->filled('levels')) {
            foreach ((array) $request->levels as $lvl) {
                $chips[] = [
                    'label' => 'Level: '.strtoupper((string) $lvl),
                    'remove_url' => $makeRemoveUrl('levels', $lvl),
                ];
            }
        }

        $feeLabels = [
            'under_1l' => '< ₹1 Lac',
            '1l_to_2l' => '₹1 - 2 Lac',
            '2l_to_3l' => '₹2 - 3 Lac',
            '3l_to_5l' => '₹3 - 5 Lac',
            '5l_to_10l' => '₹5 - 10 Lac',
            'above_10l' => '> ₹10 Lac',
        ];
        if ($request->filled('fee_range')) {
            $chips[] = [
                'label' => 'Fee: '.($feeLabels[$request->fee_range] ?? $request->fee_range),
                'remove_url' => $makeRemoveUrl('fee_range'),
            ];
        }
        if ($request->filled('fee_ranges')) {
            foreach ((array) $request->fee_ranges as $fr) {
                $chips[] = [
                    'label' => 'Fee: '.($feeLabels[$fr] ?? $fr),
                    'remove_url' => $makeRemoveUrl('fee_ranges', $fr),
                ];
            }
        }

        if ($request->filled('type')) {
            $chips[] = [
                'label' => 'Type: '.$request->type,
                'remove_url' => $makeRemoveUrl('type'),
            ];
        }
        if ($request->filled('types')) {
            foreach ((array) $request->types as $tp) {
                $chips[] = [
                    'label' => 'Type: '.$tp,
                    'remove_url' => $makeRemoveUrl('types', $tp),
                ];
            }
        }

        if ($request->boolean('boys_hostel')) {
            $chips[] = [
                'label' => 'Boys Hostel',
                'remove_url' => $makeRemoveUrl('boys_hostel'),
            ];
        }
        if ($request->boolean('girls_hostel')) {
            $chips[] = [
                'label' => 'Girls Hostel',
                'remove_url' => $makeRemoveUrl('girls_hostel'),
            ];
        }

        return $chips;
    }
}
