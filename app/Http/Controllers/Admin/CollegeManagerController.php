<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\CollegeAccreditation;
use App\Models\CollegeAdmissionSection;
use App\Models\CollegeAlumni;
use App\Models\CollegeCareerOutcome;
use App\Models\CollegeCourse;
use App\Models\CollegeFacility;
use App\Models\CollegeFaq;
use App\Models\CollegeGallery;
use App\Models\CollegeHighlight;
use App\Models\CollegeLearningExperience;
use App\Models\CollegeLoanOption;
use App\Models\CollegePlacementStat;
use App\Models\CollegeRecruiter;
use App\Models\CollegeReview;
use App\Models\CollegeScholarship;
use App\Models\Course;
use App\Models\State;
use App\Models\Stream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CollegeManagerController extends Controller
{
    public function index(Request $request)
    {
        $query = College::with('courses')->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('city', 'LIKE', '%'.$request->search.'%');
            });
        }

        if ($request->filled('mode')) {
            $query->where('college_mode', $request->mode);
        }

        $colleges = $query->paginate(12)->withQueryString();

        return view('admin.colleges.index', compact('colleges'));
    }

    public function create()
    {
        $streams = Stream::with(['courses.specializations'])->orderBy('name')->get();
        $courses = Course::with(['stream', 'specializations'])->orderBy('name')->get();
        $states = State::where('status', true)->orderBy('name')->get();
        $allColleges = College::orderBy('name')->get(['id', 'name']);

        return view('admin.colleges.create', compact('streams', 'courses', 'states', 'allColleges'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateCollegeRequest($request);

        $validated['slug'] = Str::slug($request->name).'-'.rand(100, 999);
        $validated['has_boys_hostel'] = $request->boolean('has_boys_hostel');
        $validated['has_girls_hostel'] = $request->boolean('has_girls_hostel');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['ugc_approved'] = $request->boolean('ugc_approved');
        $validated['status'] = $request->boolean('status');
        $validated['rating'] = $request->input('rating', 4.5);
        $validated['reviews_count'] = $request->input('reviews_count', 150);

        $this->handleFileUploads($request, $validated, null);

        DB::transaction(function () use ($request, &$validated) {
            $college = College::create($validated);
            $id = $college->id;

            $this->syncCollegeCourses($request, $id);
            $this->syncHighlights($request, $id);
            $this->syncAccreditations($request, $id);
            $this->syncAdmissionSections($request, $id);
            $this->syncScholarships($request, $id);
            $this->syncPlacementStats($request, $id);
            $this->syncRecruiters($request, $id);
            $this->syncCareerOutcomes($request, $id);
            $this->syncFacilities($request, $id);
            $this->syncFaqs($request, $id);
            $this->syncLoanOptions($request, $id);
            $this->syncLearningExperiences($request, $id);
            $this->syncGallery($request, $id, null);
            $this->syncAlumni($request, $id, null);
            $this->syncReviews($request, $id);
        });

        return redirect()->route('admin.colleges.index')
            ->with('success', 'College created and published successfully!');
    }

    public function edit(int $id)
    {
        $college = College::with([
            'collegeCourses.course.stream',
            'collegeCourses.specialization',
            'collegeHighlights',
            'accreditations',
            'admissionSections',
            'scholarships',
            'placementStats',
            'recruiters',
            'careerOutcomes',
            'collegeFacilities',
            'collegeFaqs',
            'loanOptions',
            'learningExperiences',
            'gallery',
            'alumni',
            'reviews',
        ])->findOrFail($id);

        $streams = Stream::with(['courses.specializations'])->orderBy('name')->get();
        $courses = Course::with(['stream', 'specializations'])->orderBy('name')->get();
        $states = State::where('status', true)->orderBy('name')->get();
        $allColleges = College::where('id', '!=', $id)->orderBy('name')->get(['id', 'name']);

        return view('admin.colleges.edit', compact(
            'college', 'streams', 'courses', 'states', 'allColleges'
        ));
    }

    public function update(Request $request, int $id)
    {
        $college = College::findOrFail($id);
        $validated = $this->validateCollegeRequest($request);

        $validated['has_boys_hostel'] = $request->boolean('has_boys_hostel');
        $validated['has_girls_hostel'] = $request->boolean('has_girls_hostel');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['ugc_approved'] = $request->boolean('ugc_approved');
        $validated['status'] = $request->boolean('status');
        $validated['rating'] = $request->input('rating', $college->rating);
        $validated['reviews_count'] = $request->input('reviews_count', $college->reviews_count);

        $this->handleFileUploads($request, $validated, $college);

        DB::transaction(function () use ($request, $college, $validated) {
            $college->update($validated);
            $id = $college->id;

            $this->syncCollegeCourses($request, $id);
            $this->syncHighlights($request, $id);
            $this->syncAccreditations($request, $id);
            $this->syncAdmissionSections($request, $id);
            $this->syncScholarships($request, $id);
            $this->syncPlacementStats($request, $id);
            $this->syncRecruiters($request, $id);
            $this->syncCareerOutcomes($request, $id);
            $this->syncFacilities($request, $id);
            $this->syncFaqs($request, $id);
            $this->syncLoanOptions($request, $id);
            $this->syncLearningExperiences($request, $id);
            $this->syncGallery($request, $id, $college);
            $this->syncAlumni($request, $id, $college);
            $this->syncReviews($request, $id);
        });

        return redirect()->route('admin.colleges.index')
            ->with('success', 'College updated successfully!');
    }

    public function destroy(int $id)
    {
        $college = College::findOrFail($id);

        foreach (['banner_image', 'logo', 'sample_certificate_image', 'brochure_pdf'] as $field) {
            if ($college->{$field} && Storage::disk('public')->exists($college->{$field})) {
                Storage::disk('public')->delete($college->{$field});
            }
        }

        $college->delete();

        return back()->with('success', 'College deleted.');
    }

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    /** @return array<string, mixed> */
    private function validateCollegeRequest(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:100',
            'college_mode' => 'required|in:regular,online',
            'college_type' => 'required|in:Govt,Private,Deemed,Autonomous',
            'university_name' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'nullable|string',
            'established_year' => 'nullable|string|max:10',
            'campus_size' => 'nullable|string|max:255',
            'approvals' => 'nullable|string|max:255',
            'entrance_exams' => 'nullable|string|max:255',
            'naac_grade' => 'nullable|string|max:20',
            'nirf_rank' => 'nullable|string|max:20',
            'nirf_year' => 'nullable|string|max:10',
            'rating' => 'nullable|numeric|between:1,5',
            'reviews_count' => 'nullable|integer|min:0',
            'highest_package' => 'nullable|string|max:50',
            'average_package' => 'nullable|string|max:50',
            'top_recruiters' => 'nullable|string',
            'overview' => 'nullable|string',
            'admission_process' => 'nullable|string',
            'scholarship_info' => 'nullable|string',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'sample_certificate_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'brochure_pdf' => 'nullable|mimes:pdf|max:10240',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | File Uploads — colleges table
    |--------------------------------------------------------------------------
    */

    /** @param array<string, mixed> $validated */
    private function handleFileUploads(Request $request, array &$validated, ?College $existing): void
    {
        $uploads = [
            'banner_image' => 'colleges/banners',
            'logo' => 'colleges/logos',
            'sample_certificate_image' => 'colleges/certificates',
            'brochure_pdf' => 'colleges/brochures',
        ];

        foreach ($uploads as $field => $path) {
            if ($request->hasFile($field)) {
                if ($existing && $existing->{$field} && Storage::disk('public')->exists($existing->{$field})) {
                    Storage::disk('public')->delete($existing->{$field});
                }
                $validated[$field] = $request->file($field)->store($path, 'public');
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Child Table Sync Methods
    |--------------------------------------------------------------------------
    | Each method: delete all existing rows for this college, re-insert from POST.
    | Guard: if the key is absent from the request, leave existing rows untouched.
    |--------------------------------------------------------------------------
    */

    private function syncCollegeCourses(Request $request, int $collegeId): void
    {
        if (! $request->has('course_ids')) {
            return;
        }

        CollegeCourse::where('college_id', $collegeId)->delete();

        foreach ((array) $request->input('course_ids', []) as $i => $courseId) {
            if (! $courseId) {
                continue;
            }

            CollegeCourse::create([
                'college_id' => $collegeId,
                'course_id' => $courseId,
                'specialization' => $request->input("specializations.$i"),
                'fee_amount' => $request->input("fee_amounts.$i", 0),
                'fee_type' => $request->input("fee_types.$i", 'per_year'),
                'eligibility' => $request->input("eligibilities.$i"),
                'seats' => $request->input("seats.$i"),
                'entrance_exam' => $request->input("course_entrance_exams.$i"),
                'academic_session' => $request->input("academic_sessions.$i"),
                'duration' => $request->input("durations.$i"),
                'application_url' => $request->input("application_urls.$i"),
                'sort_order' => $i,
                'status' => true,
            ]);
        }
    }

    private function syncHighlights(Request $request, int $collegeId): void
    {
        if (! $request->has('highlights')) {
            return;
        }

        CollegeHighlight::where('college_id', $collegeId)->delete();

        foreach ((array) $request->input('highlights', []) as $i => $row) {
            if (empty($row['title'])) {
                continue;
            }

            CollegeHighlight::create([
                'college_id' => $collegeId,
                'title' => $row['title'],
                'value' => $row['value'] ?? null,
                'description' => $row['description'] ?? null,
                'icon' => $row['icon'] ?? 'bi-check-circle-fill',
                'sort_order' => $row['sort_order'] ?? $i,
                'status' => isset($row['status']) ? (bool) $row['status'] : true,
            ]);
        }
    }

    private function syncAccreditations(Request $request, int $collegeId): void
    {
        if (! $request->has('accreditations')) {
            return;
        }

        CollegeAccreditation::where('college_id', $collegeId)->delete();

        foreach ((array) $request->input('accreditations', []) as $i => $row) {
            if (empty($row['authority'])) {
                continue;
            }

            CollegeAccreditation::create([
                'college_id' => $collegeId,
                'authority' => $row['authority'],
                'accreditation' => $row['accreditation'] ?? null,
                'grade' => $row['grade'] ?? null,
                'rank' => $row['rank'] ?? null,
                'year' => $row['year'] ?? null,
                'description' => $row['description'] ?? null,
                'sort_order' => $row['sort_order'] ?? $i,
                'status' => isset($row['status']) ? (bool) $row['status'] : true,
            ]);
        }
    }

    private function syncAdmissionSections(Request $request, int $collegeId): void
    {
        if (! $request->has('admission_sections')) {
            return;
        }

        CollegeAdmissionSection::where('college_id', $collegeId)->delete();

        foreach ((array) $request->input('admission_sections', []) as $i => $row) {
            if (empty($row['title'])) {
                continue;
            }

            // items may come as newline-separated text or JSON
            $items = null;
            if (! empty($row['items'])) {
                $decoded = json_decode($row['items'], true);
                $items = $decoded !== null
                    ? json_encode($decoded)
                    : json_encode(array_values(array_filter(
                        array_map('trim', explode("\n", $row['items']))
                    )));
            }

            CollegeAdmissionSection::create([
                'college_id' => $collegeId,
                'section_key' => $row['section_key'] ?? null,
                'title' => $row['title'],
                'content' => $row['content'] ?? null,
                'items' => $items,
                'sort_order' => $row['sort_order'] ?? $i,
                'status' => isset($row['status']) ? (bool) $row['status'] : true,
            ]);
        }
    }

    private function syncScholarships(Request $request, int $collegeId): void
    {
        if (! $request->has('scholarships')) {
            return;
        }

        CollegeScholarship::where('college_id', $collegeId)->delete();

        foreach ((array) $request->input('scholarships', []) as $i => $row) {
            if (empty($row['name'])) {
                continue;
            }

            CollegeScholarship::create([
                'college_id' => $collegeId,
                'name' => $row['name'],
                'eligibility' => $row['eligibility'] ?? null,
                'criteria' => $row['criteria'] ?? null,
                'amount' => isset($row['amount']) && $row['amount'] !== '' ? $row['amount'] : null,
                'amount_label' => $row['amount_label'] ?? null,
                'percentage' => $row['percentage'] ?? null,
                'description' => $row['description'] ?? null,
                'sort_order' => $row['sort_order'] ?? $i,
                'status' => isset($row['status']) ? (bool) $row['status'] : true,
            ]);
        }
    }

    private function syncPlacementStats(Request $request, int $collegeId): void
    {
        if (! $request->has('placement_stats')) {
            return;
        }

        CollegePlacementStat::where('college_id', $collegeId)->delete();

        foreach ((array) $request->input('placement_stats', []) as $i => $row) {
            if (empty($row['label'])) {
                continue;
            }

            CollegePlacementStat::create([
                'college_id' => $collegeId,
                'label' => $row['label'],
                'value' => $row['value'] ?? null,
                'placement_percentage' => $row['placement_percentage'] ?? null,
                'year' => $row['year'] ?? null,
                'course' => $row['course'] ?? null,
                'description' => $row['description'] ?? null,
                'sort_order' => $row['sort_order'] ?? $i,
                'status' => isset($row['status']) ? (bool) $row['status'] : true,
            ]);
        }
    }

    private function syncRecruiters(Request $request, int $collegeId): void
    {
        if (! $request->has('recruiters')) {
            return;
        }

        // Collect existing logo paths before delete for cleanup
        $existingLogos = CollegeRecruiter::where('college_id', $collegeId)->pluck('logo')->filter();
        CollegeRecruiter::where('college_id', $collegeId)->delete();

        $uploadedFiles = $request->file('recruiter_logos', []);

        foreach ((array) $request->input('recruiters', []) as $i => $row) {
            if (empty($row['name'])) {
                continue;
            }

            $logo = $row['existing_logo'] ?? null;

            if (isset($uploadedFiles[$i]) && $uploadedFiles[$i]->isValid()) {
                // Delete old logo if replacing
                if ($logo && Storage::disk('public')->exists($logo)) {
                    Storage::disk('public')->delete($logo);
                }
                $logo = $uploadedFiles[$i]->store('colleges/recruiters', 'public');
            }

            CollegeRecruiter::create([
                'college_id' => $collegeId,
                'name' => $row['name'],
                'logo' => $logo,
                'description' => $row['description'] ?? null,
                'sort_order' => $row['sort_order'] ?? $i,
                'status' => isset($row['status']) ? (bool) $row['status'] : true,
            ]);
        }
    }

    private function syncCareerOutcomes(Request $request, int $collegeId): void
    {
        if (! $request->has('career_outcomes')) {
            return;
        }

        CollegeCareerOutcome::where('college_id', $collegeId)->delete();

        foreach ((array) $request->input('career_outcomes', []) as $i => $row) {
            if (empty($row['career_role'])) {
                continue;
            }

            CollegeCareerOutcome::create([
                'college_id' => $collegeId,
                'career_role' => $row['career_role'],
                'industry' => $row['industry'] ?? null,
                'average_salary' => $row['average_salary'] ?? null,
                'salary_range' => $row['salary_range'] ?? null,
                'job_scope' => $row['job_scope'] ?? null,
                'description' => $row['description'] ?? null,
                'sort_order' => $row['sort_order'] ?? $i,
                'status' => isset($row['status']) ? (bool) $row['status'] : true,
            ]);
        }
    }

    private function syncFacilities(Request $request, int $collegeId): void
    {
        if (! $request->has('facilities_list')) {
            return;
        }

        CollegeFacility::where('college_id', $collegeId)->delete();

        foreach ((array) $request->input('facilities_list', []) as $i => $row) {
            if (empty($row['name'])) {
                continue;
            }

            CollegeFacility::create([
                'college_id' => $collegeId,
                'name' => $row['name'],
                'icon' => $row['icon'] ?? null,
                'description' => $row['description'] ?? null,
                'image' => null,
                'sort_order' => $row['sort_order'] ?? $i,
                'status' => isset($row['status']) ? (bool) $row['status'] : true,
            ]);
        }
    }

    private function syncFaqs(Request $request, int $collegeId): void
    {
        if (! $request->has('faqs_list')) {
            return;
        }

        CollegeFaq::where('college_id', $collegeId)->delete();

        foreach ((array) $request->input('faqs_list', []) as $i => $row) {
            if (empty($row['question'])) {
                continue;
            }

            CollegeFaq::create([
                'college_id' => $collegeId,
                'question' => $row['question'],
                'answer' => $row['answer'] ?? '',
                'sort_order' => $row['sort_order'] ?? $i,
                'status' => isset($row['status']) ? (bool) $row['status'] : true,
            ]);
        }
    }

    private function syncLoanOptions(Request $request, int $collegeId): void
    {
        if (! $request->has('loan_options')) {
            return;
        }

        CollegeLoanOption::where('college_id', $collegeId)->delete();

        foreach ((array) $request->input('loan_options', []) as $i => $row) {
            if (empty($row['provider'])) {
                continue;
            }

            CollegeLoanOption::create([
                'college_id' => $collegeId,
                'provider' => $row['provider'],
                'loan_type' => $row['loan_type'] ?? null,
                'amount' => isset($row['amount']) && $row['amount'] !== '' ? $row['amount'] : null,
                'interest_rate' => $row['interest_rate'] ?? null,
                'tenure' => $row['tenure'] ?? null,
                'emi_from' => $row['emi_from'] ?? null,
                'description' => $row['description'] ?? null,
                'sort_order' => $row['sort_order'] ?? $i,
                'status' => isset($row['status']) ? (bool) $row['status'] : true,
            ]);
        }
    }

    private function syncLearningExperiences(Request $request, int $collegeId): void
    {
        if (! $request->has('learning_experiences')) {
            return;
        }

        CollegeLearningExperience::where('college_id', $collegeId)->delete();

        foreach ((array) $request->input('learning_experiences', []) as $i => $row) {
            if (empty($row['title'])) {
                continue;
            }

            CollegeLearningExperience::create([
                'college_id' => $collegeId,
                'title' => $row['title'],
                'description' => $row['description'] ?? null,
                'icon' => $row['icon'] ?? null,
                'type' => $row['type'] ?? null,
                'sort_order' => $row['sort_order'] ?? $i,
                'status' => isset($row['status']) ? (bool) $row['status'] : true,
            ]);
        }
    }

    private function syncGallery(Request $request, int $collegeId, ?College $existing): void
    {
        if (! $request->has('gallery_items')) {
            return;
        }

        // Clean up removed images
        $keepImages = collect($request->input('gallery_items', []))
            ->pluck('existing_image')
            ->filter()
            ->values();

        CollegeGallery::where('college_id', $collegeId)
            ->whereNotIn('image', $keepImages)
            ->each(function ($g) {
                if ($g->image && Storage::disk('public')->exists($g->image)) {
                    Storage::disk('public')->delete($g->image);
                }
                $g->delete();
            });

        CollegeGallery::where('college_id', $collegeId)->delete();

        $uploadedFiles = $request->file('gallery_files', []);

        foreach ((array) $request->input('gallery_items', []) as $i => $row) {
            $image = $row['existing_image'] ?? null;

            if (isset($uploadedFiles[$i]) && $uploadedFiles[$i]->isValid()) {
                $image = $uploadedFiles[$i]->store('colleges/gallery', 'public');
            }

            if (! $image) {
                continue;
            }

            CollegeGallery::create([
                'college_id' => $collegeId,
                'title' => $row['title'] ?? null,
                'image' => $image,
                'category' => $row['category'] ?? null,
                'alt_text' => $row['alt_text'] ?? null,
                'sort_order' => $row['sort_order'] ?? $i,
                'status' => isset($row['status']) ? (bool) $row['status'] : true,
            ]);
        }
    }

    private function syncAlumni(Request $request, int $collegeId, ?College $existing): void
    {
        if (! $request->has('alumni_list')) {
            return;
        }

        CollegeAlumni::where('college_id', $collegeId)->delete();

        $uploadedFiles = $request->file('alumni_images', []);

        foreach ((array) $request->input('alumni_list', []) as $i => $row) {
            if (empty($row['name'])) {
                continue;
            }

            $image = $row['existing_image'] ?? null;

            if (isset($uploadedFiles[$i]) && $uploadedFiles[$i]->isValid()) {
                if ($image && Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
                $image = $uploadedFiles[$i]->store('colleges/alumni', 'public');
            }

            CollegeAlumni::create([
                'college_id' => $collegeId,
                'name' => $row['name'],
                'designation' => $row['designation'] ?? null,
                'company' => $row['company'] ?? null,
                'batch' => $row['batch'] ?? null,
                'image' => $image,
                'description' => $row['description'] ?? null,
                'sort_order' => $row['sort_order'] ?? $i,
                'status' => isset($row['status']) ? (bool) $row['status'] : true,
            ]);
        }
    }

    private function syncReviews(Request $request, int $collegeId): void
    {
        if (! $request->has('reviews_list')) {
            return;
        }

        CollegeReview::where('college_id', $collegeId)->delete();

        foreach ((array) $request->input('reviews_list', []) as $i => $row) {
            if (empty($row['reviewer_name'])) {
                continue;
            }

            CollegeReview::create([
                'college_id' => $collegeId,
                'user_id' => null,
                'reviewer_name' => $row['reviewer_name'],
                'course' => $row['course'] ?? null,
                'rating' => max(1, min(5, (int) ($row['rating'] ?? 5))),
                'review' => $row['review'] ?? '',
                'is_verified' => isset($row['is_verified']) ? (bool) $row['is_verified'] : false,
                'status' => isset($row['status']) ? (bool) $row['status'] : true,
            ]);
        }
    }
}
