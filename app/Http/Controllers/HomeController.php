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
        // Fetch all active banners
        $heroBanners = Banner::where('status', true)->orderBy('sort_order', 'asc')->get();

        // 🎯 Fetch active partner universities for marquee strip
        $partners = Partner::where('status', true)->orderBy('sort_order', 'asc')->get();

        $regularColleges = College::where('college_mode', 'regular')
            ->where('status', true)
            ->with(['courses'])
            ->orderBy('is_featured', 'desc')
            ->take(8)
            ->get();

        $onlineColleges = College::where('college_mode', 'online')
            ->where('status', true)
            ->with(['courses'])
            ->orderBy('is_featured', 'desc')
            ->take(8)
            ->get();

        $popularCourses = Course::take(8)->get();
        $streams = Stream::take(6)->get();

        $popularCities = City::where('is_popular', true)->where('status', true)->take(8)->get();
        if ($popularCities->isEmpty()) {
            $popularCities = City::where('status', true)->take(8)->get();
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
        $term = $request->get('q', '');
        if (strlen($term) < 2) {
            return response()->json([]);
        }

        $colleges = College::where('status', true)
            ->where(function ($q) use ($term) {
                $q->where('name', 'LIKE', "%{$term}%")
                    ->orWhere('city', 'LIKE', "%{$term}%");
            })
            ->select('id', 'name', 'slug', 'city', 'college_mode')
            ->take(5)
            ->get();

        $courses = Course::where('name', 'LIKE', "%{$term}%")
            ->select('id', 'name', 'slug', 'level')
            ->take(4)
            ->get();

        return response()->json([
            'colleges' => $colleges,
            'courses'  => $courses
        ]);
    }
}
