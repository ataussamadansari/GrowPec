<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\City;
use App\Models\College;
use App\Models\Course;
use App\Models\LeadershipMessage;
use App\Models\Partner;
use App\Models\Stream;
use App\Models\SystemSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Dynamic System Settings
        |-------------------------------------------------------------------------- | Settings are managed from Admin > Settings. | Example: | general.support_phone | general.whatsapp_number
        | general.support_email
        | general.office_address
        | general.site_name
        | theme.primary_color
        | theme.accent_gold
        | etc.
        */
        $settings = SystemSetting::getAllCached();

        /*
        |--------------------------------------------------------------------------
        | Hero Banners
        |--------------------------------------------------------------------------
        */
        $heroBanners = Banner::where('status', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Partners
        |--------------------------------------------------------------------------
        */
        $partners = Partner::where('status', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        $leadershipMessages = LeadershipMessage::query()
            ->where('status', true)
            ->orderByRaw("CASE role WHEN 'director' THEN 0 WHEN 'ceo' THEN 1 ELSE 2 END")
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Regular Colleges
        |--------------------------------------------------------------------------
        */
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
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Online Colleges
        |--------------------------------------------------------------------------
        */
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
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Popular Courses
        |--------------------------------------------------------------------------
        | courses table currently has no status column.
        */
        $popularCourses = Course::select([
            'id',
            'stream_id',
            'name',
            'slug',
            'level',
            'degree_type',
            'duration',
        ])->orderBy('name')
            ->take(8)
            ->get();

        /*
    |--------------------------------------------------------------------------
    | Streams
    |--------------------------------------------------------------------------
    | streams table currently has no status column.
    */
        $streams = Stream::select([
            'id',
            'name',
            'slug',
            'icon',
        ])
            ->orderBy('name')
            ->take(6)
            ->get();

        /*
    |--------------------------------------------------------------------------
    | Popular Cities
    |--------------------------------------------------------------------------
    */
        $popularCities = City::where('is_popular', true)
            ->where('status', true)
            ->select(
                [
                    'id',
                    'state_id',
                    'name',
                    'slug',
                    'image',
                    'is_popular',
                ]
            )->orderBy('name')
            ->take(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Home View
        |--------------------------------------------------------------------------
        */
        return view(
            'home',
            compact(
                'settings',
                'heroBanners',
                'partners',
                'leadershipMessages',
                'regularColleges',
                'onlineColleges',
                'popularCourses',
                'streams',
                'popularCities'
            )
        );
    }

    public function liveSearch(Request $request)
    {
        $term = trim($request->get('q', ''));
        if (strlen($term) < 2) {
            return response()->json(['colleges' => [], 'courses' => []]);
        }
        $colleges = College::where('status', true)->where(function ($q) use ($term) {
            $q->where('name', 'LIKE', "%{$term}%")->orWhere('city', 'LIKE', "%{$term}%");
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

        return response()
            ->json([
                'colleges' => $colleges,
                'courses' => $courses,
            ]);
    }
}
