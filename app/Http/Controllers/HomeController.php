<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\College;
use App\Models\Course;
use App\Models\Stream;
use App\Models\Banner;
use App\Models\City;
use App\Models\Partner;

class HomeController extends Controller
{
    public function index()
    {
        $heroBanners = Banner::where('status', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        $partners = Partner::where('status', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        $regularColleges = College::where('college_mode', 'regular')
            ->where('status', true)
            ->select([
                'id',
                'name',
                'slug',
                'logo',
                'banner_image',
                'college_mode',
                'college_type',
                'university_name',
                'state',
                'city',
                'established_year',
                'rating',
                'is_featured',
            ])
            ->orderByDesc('is_featured')
            ->orderByDesc('rating')
            ->take(8)
            ->get();

        $onlineColleges = College::where('college_mode', 'online')
            ->where('status', true)
            ->select([
                'id',
                'name',
                'slug',
                'logo',
                'banner_image',
                'college_mode',
                'college_type',
                'university_name',
                'state',
                'city',
                'established_year',
                'rating',
                'is_featured',
            ])
            ->orderByDesc('is_featured')
            ->orderByDesc('rating')
            ->take(8)
            ->get();

        // courses table has no status column
        $popularCourses = Course::select([
            'id',
            'stream_id',
            'name',
            'slug',
            'level',
            'degree_type',
            'duration',
        ])
            ->orderBy('name')
            ->take(8)
            ->get();

        // streams table has no status column
        $streams = Stream::select([
            'id',
            'name',
            'slug',
            'icon',
        ])
            ->orderBy('name')
            ->take(6)
            ->get();

        $popularCities = City::where('is_popular', true)
            ->where('status', true)
            ->select([
                'id',
                'state_id',
                'name',
                'slug',
                'is_popular',
            ])
            ->orderBy('name')
            ->take(8)
            ->get();

        if ($popularCities->isEmpty()) {
            $popularCities = City::where('status', true)
                ->select([
                    'id',
                    'state_id',
                    'name',
                    'slug',
                    'is_popular',
                ])
                ->orderBy('name')
                ->take(8)
                ->get();
        }

        return view('home', compact(
            'heroBanners',
            'partners',
            'regularColleges',
            'onlineColleges',
            'popularCourses',
            'streams',
            'popularCities'
        ));
    }

    public function liveSearch(Request $request)
    {
        $term = trim($request->get('q', ''));

        if (strlen($term) < 2) {
            return response()->json([
                'colleges' => [],
                'courses' => [],
            ]);
        }

        $colleges = College::where('status', true)
            ->where(function ($q) use ($term) {
                $q->where('name', 'LIKE', "%{$term}%")
                    ->orWhere('city', 'LIKE', "%{$term}%");
            })
            ->select([
                'id',
                'name',
                'slug',
                'city',
                'college_mode',
            ])
            ->orderBy('name')
            ->take(5)
            ->get();

        $courses = Course::where('name', 'LIKE', "%{$term}%")
            ->select([
                'id',
                'name',
                'slug',
                'level',
            ])
            ->orderBy('name')
            ->take(4)
            ->get();

        return response()->json([
            'colleges' => $colleges,
            'courses' => $courses,
        ]);
    }
}
