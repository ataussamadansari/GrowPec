<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\College;
use App\Models\Course;
use App\Models\Stream;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Featured Regular Colleges
        $regularColleges = College::where('college_mode', 'regular')
            ->where('status', true)
            ->with(['courses'])
            ->orderBy('is_featured', 'desc')
            ->take(6)
            ->get();

        // 2. Featured Online Colleges
        $onlineColleges = College::where('college_mode', 'online')
            ->where('status', true)
            ->with(['courses'])
            ->orderBy('is_featured', 'desc')
            ->take(6)
            ->get();

        // 3. Top Courses & Streams for Quick Badges
        $popularCourses = Course::take(8)->get();
        $streams = Stream::take(6)->get();

        return view('home', compact('regularColleges', 'onlineColleges', 'popularCourses', 'streams'));
    }

    public function liveSearch(Request $request)
{
    $term = $request->get('q', '');
    if (strlen($term) < 2) {
        return response()->json([]);
    }

    $colleges = College::where('status', true)
        ->where(function($q) use ($term) {
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