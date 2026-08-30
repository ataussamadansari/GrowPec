<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\CollegeCourse;
use App\Models\Course;
use App\Models\State;
use App\Models\Stream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CollegeManagerController extends Controller
{
    public function index(Request $request)
    {
        $query = College::with('courses')->latest();
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('city', 'LIKE', '%' . $request->search . '%');
        }
        $colleges = $query->paginate(10)->withQueryString();
        return view('admin.colleges.index', compact('colleges'));
    }

    public function create()
    {
        $streams = Stream::with(['courses.specializations'])->orderBy('name')->get();
        $courses = Course::with(['stream', 'specializations'])->orderBy('name')->get();
        $states  = State::where('status', true)->orderBy('name')->get();

        return view('admin.colleges.create', compact('streams', 'courses', 'states'));
    }

    // public function create()
    // {
    //     $courses = Course::orderBy('name')->get();
    //     $states  = State::where('status', true)->orderBy('name')->get();
    //     return view('admin.colleges.create', compact('courses', 'states'));
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                     => 'required|string|max:255',
            'college_mode'             => 'required|in:regular,online,both',
            'college_type'             => 'required|in:Govt,Private,Deemed,Autonomous',
            'university_name'          => 'nullable|string|max:255',
            'state'                    => 'required|string|max:100',
            'city'                     => 'required|string|max:100',
            'address'                  => 'nullable|string',
            'established_year'         => 'nullable|string|max:10',
            'campus_size'              => 'nullable|string|max:50',
            'approvals'                => 'nullable|string|max:255',
            'highest_package'          => 'nullable|string|max:50',
            'average_package'          => 'nullable|string|max:50',
            'top_recruiters'           => 'nullable|string',
            'overview'                 => 'nullable|string',
            'admission_process'        => 'nullable|string',
            'scholarship_info'         => 'nullable|string',
            'banner_image'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'logo'                     => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:1024',
            'sample_certificate_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'brochure_pdf'             => 'nullable|mimes:pdf|max:10240',
        ]);

        $validated['slug'] = Str::slug($request->name) . '-' . rand(100, 999);
        $validated['has_boys_hostel'] = $request->has('has_boys_hostel');
        $validated['has_girls_hostel'] = $request->has('has_girls_hostel');

        // File uploads
        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('colleges/banners', 'public');
        }
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('colleges/logos', 'public');
        }
        if ($request->hasFile('sample_certificate_image')) {
            $validated['sample_certificate_image'] = $request->file('sample_certificate_image')->store('colleges/certificates', 'public');
        }
        if ($request->hasFile('brochure_pdf')) {
            $validated['brochure_pdf'] = $request->file('brochure_pdf')->store('colleges/brochures', 'public');
        }

        // Dynamic Highlights & FAQs
        if ($request->filled('highlights')) {
            $validated['highlights'] = array_values(array_filter($request->highlights));
        }
        if ($request->filled('faq_questions')) {
            $faqs = [];
            foreach ($request->faq_questions as $idx => $q) {
                if (!empty($q) && !empty($request->faq_answers[$idx])) {
                    $faqs[] = ['question' => $q, 'answer' => $request->faq_answers[$idx]];
                }
            }
            $validated['faqs'] = $faqs;
        }

        $college = College::create($validated);

        // Attach Courses
        if ($request->filled('course_ids')) {
            foreach ($request->course_ids as $index => $courseId) {
                if ($courseId) {
                    CollegeCourse::create([
                        'college_id'     => $college->id,
                        'course_id'      => $courseId,
                        'specialization' => $request->specializations[$index] ?? null,
                        'fee_amount'     => $request->fee_amounts[$index] ?? 50000,
                        'fee_type'       => $request->fee_types[$index] ?? 'per_year',
                        'eligibility'    => $request->eligibilities[$index] ?? '10+2',
                    ]);
                }
            }
        }

        return redirect()->route('admin.colleges.index')->with('success', 'College created and published successfully!');
    }


    public function edit($id)
    {
        $college = College::with(['collegeCourses.course.stream'])->findOrFail($id);
        $streams = Stream::with(['courses.specializations'])->orderBy('name')->get();
        $courses = Course::with(['stream', 'specializations'])->orderBy('name')->get();
        $states  = State::where('status', true)->orderBy('name')->get();

        return view('admin.colleges.edit', compact('college', 'streams', 'courses', 'states'));
    }

    // public function edit($id)
    // {
    //     $college = College::with('collegeCourses')->findOrFail($id);
    //     $courses = Course::orderBy('name')->get();
    //     $states  = State::where('status', true)->orderBy('name')->get();
    //     return view('admin.colleges.edit', compact('college', 'courses', 'states'));
    // }

    public function update(Request $request, $id)
    {
        $college = College::findOrFail($id);

        $validated = $request->validate([
            'name'                     => 'required|string|max:255',
            'college_mode'             => 'required|in:regular,online,both',
            'college_type'             => 'required|in:Govt,Private,Deemed,Autonomous',
            'university_name'          => 'nullable|string|max:255',
            'state'                    => 'required|string|max:100',
            'city'                     => 'required|string|max:100',
            'address'                  => 'nullable|string',
            'established_year'         => 'nullable|string|max:10',
            'campus_size'              => 'nullable|string|max:50',
            'approvals'                => 'nullable|string|max:255',
            'highest_package'          => 'nullable|string|max:50',
            'average_package'          => 'nullable|string|max:50',
            'top_recruiters'           => 'nullable|string',
            'overview'                 => 'nullable|string',
            'admission_process'        => 'nullable|string',
            'scholarship_info'         => 'nullable|string',
            'banner_image'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'logo'                     => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:1024',
            'sample_certificate_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'brochure_pdf'             => 'nullable|mimes:pdf|max:10240',
        ]);

        $validated['has_boys_hostel'] = $request->has('has_boys_hostel');
        $validated['has_girls_hostel'] = $request->has('has_girls_hostel');

        if ($request->hasFile('banner_image')) {
            if ($college->banner_image && Storage::disk('public')->exists($college->banner_image)) {
                Storage::disk('public')->delete($college->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')->store('colleges/banners', 'public');
        }
        if ($request->hasFile('logo')) {
            if ($college->logo && Storage::disk('public')->exists($college->logo)) {
                Storage::disk('public')->delete($college->logo);
            }
            $validated['logo'] = $request->file('logo')->store('colleges/logos', 'public');
        }
        if ($request->hasFile('sample_certificate_image')) {
            if ($college->sample_certificate_image && Storage::disk('public')->exists($college->sample_certificate_image)) {
                Storage::disk('public')->delete($college->sample_certificate_image);
            }
            $validated['sample_certificate_image'] = $request->file('sample_certificate_image')->store('colleges/certificates', 'public');
        }
        if ($request->hasFile('brochure_pdf')) {
            if ($college->brochure_pdf && Storage::disk('public')->exists($college->brochure_pdf)) {
                Storage::disk('public')->delete($college->brochure_pdf);
            }
            $validated['brochure_pdf'] = $request->file('brochure_pdf')->store('colleges/brochures', 'public');
        }

        $validated['highlights'] = $request->filled('highlights') ? array_values(array_filter($request->highlights)) : [];

        $faqs = [];
        if ($request->filled('faq_questions')) {
            foreach ($request->faq_questions as $idx => $q) {
                if (!empty($q) && !empty($request->faq_answers[$idx])) {
                    $faqs[] = ['question' => $q, 'answer' => $request->faq_answers[$idx]];
                }
            }
        }
        $validated['faqs'] = $faqs;

        $college->update($validated);

        // Sync Courses
        if ($request->filled('course_ids')) {
            CollegeCourse::where('college_id', $college->id)->delete();
            foreach ($request->course_ids as $index => $courseId) {
                if ($courseId) {
                    CollegeCourse::create([
                        'college_id'     => $college->id,
                        'course_id'      => $courseId,
                        'specialization' => $request->specializations[$index] ?? null,
                        'fee_amount'     => $request->fee_amounts[$index] ?? 50000,
                        'fee_type'       => $request->fee_types[$index] ?? 'per_year',
                        'eligibility'    => $request->eligibilities[$index] ?? '10+2',
                    ]);
                }
            }
        }

        return redirect()->route('admin.colleges.index')->with('success', 'College updated successfully!');
    }

    public function destroy($id)
    {
        $college = College::findOrFail($id);
        if ($college->banner_image) Storage::disk('public')->delete($college->banner_image);
        if ($college->logo) Storage::disk('public')->delete($college->logo);
        if ($college->sample_certificate_image) Storage::disk('public')->delete($college->sample_certificate_image);
        if ($college->brochure_pdf) Storage::disk('public')->delete($college->brochure_pdf);
        $college->delete();

        return back()->with('success', 'College deleted.');
    }
}
