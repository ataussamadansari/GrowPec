<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\College;
use App\Models\Stream;
use App\Models\Course;

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
    private function getFilteredColleges(Request $request, string$mode, string $view, string$pageTitle)
    {
        $query = College::query()
            ->where('status', true)
            ->where(function($q) use ($mode) {
                $q->where('college_mode',$mode)->orWhere('college_mode', 'both');
            })
            ->with(['courses', 'collegeCourses.course']);

        // 1. Search Query (Name, City, State)
        if ($request->filled('search')) {$searchTerm = '%' . $request->search . '\%';$query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE',$searchTerm)
                  ->orWhere('city', 'LIKE', $searchTerm)
                  ->orWhere('state', 'LIKE', $searchTerm)
                  ->orWhere('university_name', 'LIKE', $searchTerm);
            });
        }

        // 2. Filter by Level (UG, PG, Diploma, PhD)
        if ($request->filled('levels')) {
            $levels = (array)$request->levels;
            $query->whereHas('courses', function($q) use ($levels) {
                $q->whereIn('level',$levels);
            });
        }

        // 3. Filter by Stream
        if ($request->filled('streams')) {
            $streams = (array)$request->streams;
            $query->whereHas('courses.stream', function($q) use ($streams) {$q->whereIn('slug', $streams)->orWhereIn('id',$streams);
            });
        }

        // 4. Filter by Specific Course (e.g. BCA, MBA)
        if ($request->filled('courses')) {
            $courses = (array)$request->courses;
            $query->whereHas('courses', function($q) use ($courses) {$q->whereIn('slug', $courses)->orWhereIn('courses.id',$courses);
            });
        }

        // 5. Filter by State
        if ($request->filled('states')) {
            $query->whereIn('state', (array)$request->states);
        }

        // 6. Filter by City
        if ($request->filled('cities')) {
            $query->whereIn('city', (array)$request->cities);
        }

        // 7. Filter by College Type (Govt / Private)
        if ($request->filled('types')) {
            $query->whereIn('college_type', (array)$request->types);
        }

        // 8. Filter by Hostel Facility
        if ($request->boolean('boys_hostel')) {$query->where('has_boys_hostel', true);
        }
        if ($request->boolean('girls_hostel')) {$query->where('has_girls_hostel', true);
        }

        // 9. Filter by Fee Range
        if ($request->filled('fee_range')) {
            $range =$request->fee_range;
            $query->whereHas('collegeCourses', function($q) use ($range) {
                if ($range === 'under_1l') {$q->where('fee_amount', '<', 100000);
                } elseif ($range === '1l_to_2l') {$q->whereBetween('fee_amount', [100000, 200000]);
                } elseif ($range === '2l_to_3l') {$q->whereBetween('fee_amount', [200000, 300000]);
                } elseif ($range === 'above_3l') {$q->where('fee_amount', '>', 300000);
                }
            });
        }

        $colleges =$query->orderBy('is_featured', 'desc')
                          ->orderBy('rating', 'desc')
                          ->paginate(10)
                          ->withQueryString();

        // Data for Filter Sidebar Checkboxes
        $allStreams = Stream::with('courses')->get();$allCourses = Course::all();
        $allStates  = College::where('status', true)->distinct()->pluck('state')->filter();$allCities  = College::where('status', true)->distinct()->pluck('city')->filter();

        return view($view, compact(
            'colleges', 'allStreams', 'allCourses', 'allStates', 'allCities', 'pageTitle', 'mode'
        ));
    }

    // College Detail Page (Phase 5 me use hoga)
    public function show($slug)
    {
        $college = College::where('slug',$slug)
            ->where('status', true)
            ->with(['collegeCourses.course.stream'])
            ->firstOrFail();

        $relatedColleges = College::where('id', '!=',$college->id)
            ->where('state', $college->state)
            ->where('status', true)
            ->take(3)
            ->get();

        return view('colleges.show', compact('college', 'relatedColleges'));
    }
}