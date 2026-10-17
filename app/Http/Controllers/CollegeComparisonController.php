<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CollegeComparisonController extends Controller
{
    /**
     * Display the side-by-side college comparison matrix.
     */
    public function index(Request $request): View
    {
        $rawParam = $request->query('colleges', '');

        $slugs = [];
        if (is_array($rawParam)) {
            $slugs = array_values(array_filter(array_map('trim', $rawParam)));
        } elseif (is_string($rawParam) && trim($rawParam) !== '') {
            $slugs = array_values(array_filter(array_map('trim', explode(',', $rawParam))));
        }

        // Limit comparison to maximum 4 colleges
        $slugs = array_slice(array_unique($slugs), 0, 4);

        $selectedColleges = collect();

        if (! empty($slugs)) {
            $selectedColleges = College::whereIn('slug', $slugs)
                ->where('status', true)
                ->with([
                    'stateRelation',
                    'cityRelation',
                    'collegeCourses.course.stream',
                    'collegeCourses.specialization',
                    'collegeHighlights',
                    'accreditations',
                    'placementStats',
                    'recruiters',
                    'collegeFacilities',
                    'scholarships',
                    'admissionSections',
                    'approvedReviews',
                ])
                ->get()
                ->sortBy(fn (College $college) => array_search($college->slug, $slugs))
                ->values();
        }

        // Lightweight published list for switcher dropdowns
        $allColleges = College::where('status', true)
            ->select(['id', 'name', 'short_name', 'slug', 'logo', 'mode', 'city', 'state'])
            ->orderBy('name')
            ->get();

        // Curated benchmark pairs for empty / launcher state
        $popularPairs = [
            [
                'title' => 'Bennett University vs Galgotias University',
                'slugs' => ['bennett-university', 'galgotias-university'],
                'desc' => 'Leading Private Tech, AI & Management Hubs in Greater Noida NCR',
                'tag' => 'NCR Tech Benchmark',
                'badge_color' => 'primary',
            ],
            [
                'title' => 'Graphic Era University vs COER University',
                'slugs' => ['graphic-era-deemed-to-be-university-dehradun', 'coer-university-roorkee'],
                'desc' => 'Premier Deemed & Private Engineering Universities in Uttarakhand',
                'tag' => 'Uttarakhand Benchmark',
                'badge_color' => 'success',
            ],
            [
                'title' => 'IIMT University vs Teerthanker Mahaveer University (TMU)',
                'slugs' => ['iimt-university-meerut', 'teerthanker-mahaveer-university-tmu-moradabad'],
                'desc' => 'Comprehensive Multi-Disciplinary, Medical & Law Campuses in Western UP',
                'tag' => 'Western UP Hubs',
                'badge_color' => 'warning',
            ],
            [
                'title' => 'MUIT Noida vs Noida International University (NIU)',
                'slugs' => ['maharishi-university-of-information-technology-noida', 'noida-international-university-niu-greater-noida'],
                'desc' => 'High-Growth Tech, Law & Professional Campuses in Noida/Greater Noida',
                'tag' => 'Noida Express Hubs',
                'badge_color' => 'info',
            ],
        ];

        $siteSettings = SystemSetting::getAllCached();

        $pageTitle = $selectedColleges->count() >= 2
            ? 'Compare: '.$selectedColleges->pluck('short_name')->filter()->join(' vs ')
            : 'Compare Top Universities & Colleges in India';

        return view('colleges.compare', compact(
            'selectedColleges',
            'allColleges',
            'popularPairs',
            'slugs',
            'siteSettings',
            'pageTitle'
        ));
    }
}
