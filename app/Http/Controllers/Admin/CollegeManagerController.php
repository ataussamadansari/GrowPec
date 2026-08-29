<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\College;
use App\Models\Course;
use App\Models\CollegeCourse;
use Illuminate\Support\Str;

class CollegeManagerController extends Controller
{
    public function index(Request $request)
    {
        $query = College::with('courses')->latest();

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '\%' .$request->search . '%')
                  ->orWhere('city', 'LIKE', '%' . $request->search . '%');
        }

        $colleges =$query->paginate(10)->withQueryString();
        return view('admin.colleges.index', compact('colleges'));
    }

    public function create()
    {
        $courses = Course::orderBy('name')->get();
        return view('admin.colleges.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated =$request->validate([
            'name'             => 'required|string|max:255',
            'college_mode'     => 'required|in:regular,online,both',
            'college_type'     => 'required|in:Govt,Private,Deemed,Autonomous',
            'university_name'  => 'nullable|string|max:255',
            'state'            => 'required|string|max:100',
            'city'             => 'required|string|max:100',
            'address'          => 'nullable|string',
            'established_year' => 'nullable|string|max:10',
            'campus_size'      => 'nullable|string|max:50',
            'approvals'        => 'nullable|string|max:255',
            'highest_package'  => 'nullable|string|max:50',
            'average_package'  => 'nullable|string|max:50',
            'top_recruiters'   => 'nullable|string',
            'overview'         => 'nullable|string',
            'banner_image'     => 'nullable|url',
        ]);

        $validated['slug'] = Str::slug($request->name) . '-' . rand(100, 999);
        $validated['has_boys_hostel'] =$request->has('has_boys_hostel');
        $validated['has_girls_hostel'] =$request->has('has_girls_hostel');

        $college = College::create($validated);

        // Attach Courses
        if ($request->filled('course_ids')) {
            foreach ($request->course_ids as $index =>$courseId) {
                if ($courseId) {
                    CollegeCourse::create([
                        'college_id'  => $college->id,
                        'course_id'   => $courseId,
                        'fee_amount'  => $request->fee_amounts[$index] ?? 50000,
                        'fee_type'    => 'per_year',
                        'eligibility' => $request->eligibilities[$index] ?? '10+2',
                    ]);
                }
            }
        }

        return redirect()->route('admin.colleges.index')->with('success', 'College added successfully!');
    }

    public function edit($id)
    {
        $college = College::with('collegeCourses')->findOrFail($id);$courses = Course::orderBy('name')->get();
        return view('admin.colleges.edit', compact('college', 'courses'));
    }

    public function update(Request $request,$id)
    {
        $college = College::findOrFail($id);

        $validated =$request->validate([
            'name'             => 'required|string|max:255',
            'college_mode'     => 'required|in:regular,online,both',
            'college_type'     => 'required|in:Govt,Private,Deemed,Autonomous',
            'university_name'  => 'nullable|string|max:255',
            'state'            => 'required|string|max:100',
            'city'             => 'required|string|max:100',
            'address'          => 'nullable|string',
            'established_year' => 'nullable|string|max:10',
            'campus_size'      => 'nullable|string|max:50',
            'approvals'        => 'nullable|string|max:255',
            'highest_package'  => 'nullable|string|max:50',
            'average_package'  => 'nullable|string|max:50',
            'top_recruiters'   => 'nullable|string',
            'overview'         => 'nullable|string',
            'banner_image'     => 'nullable|url',
        ]);

        $validated['has_boys_hostel'] =$request->has('has_boys_hostel');
        $validated['has_girls_hostel'] =$request->has('has_girls_hostel');

        $college->update($validated);

        // Sync Courses
        if ($request->filled('course_ids')) {
            CollegeCourse::where('college_id', $college->id)->delete();
            foreach ($request->course_ids as $index =>$courseId) {
                if ($courseId) {
                    CollegeCourse::create([
                        'college_id'  => $college->id,
                        'course_id'   => $courseId,
                        'fee_amount'  => $request->fee_amounts[$index] ?? 50000,
                        'fee_type'    => 'per_year',
                        'eligibility' => $request->eligibilities[$index] ?? '10+2',
                    ]);
                }
            }
        }

        return redirect()->route('admin.colleges.index')->with('success', 'College updated successfully!');
    }

    public function destroy($id)
    {
        College::findOrFail($id)->delete();
        return back()->with('success', 'College deleted successfully.');
    }
}