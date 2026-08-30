<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SpecializationManagerController extends Controller
{
    public function index(Request $request)
    {
        $query = Specialization::with('course.stream');
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        $specializations = $query->latest()->paginate(15)->withQueryString();
        $courses = Course::with('stream')->orderBy('name')->get();

        return view('admin.specializations.index', compact('specializations', 'courses'));
    }

    public function create()
    {
        $courses = Course::with('stream')->orderBy('name')->get();
        return view('admin.specializations.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name'      => 'required|string|max:150',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['status'] = true;

        if (Specialization::where('course_id', $validated['course_id'])->where('slug', $validated['slug'])->exists()) {
            return back()->withErrors(['name' => 'This specialization already exists under the selected course.'])->withInput();
        }

        Specialization::create($validated);

        return redirect()->route('admin.specializations.index')->with('success', 'Specialization added successfully!');
    }

    public function edit($id)
    {
        $specialization = Specialization::findOrFail($id);
        $courses = Course::with('stream')->orderBy('name')->get();

        return view('admin.specializations.edit', compact('specialization', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $specialization = Specialization::findOrFail($id);
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name'      => 'required|string|max:150',
            'status'    => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['status'] = $request->has('status');

        $duplicate = Specialization::where('course_id', $validated['course_id'])
            ->where('slug', $validated['slug'])
            ->where('id', '!=', $id)
            ->exists();

        if ($duplicate) {
            return back()->withErrors(['name' => 'This specialization already exists under the selected course.'])->withInput();
        }

        $specialization->update($validated);

        return redirect()->route('admin.specializations.index')->with('success', 'Specialization updated successfully!');
    }

    public function destroy($id)
    {
        $specialization = Specialization::findOrFail($id);
        $specialization->delete();

        return back()->with('success', 'Specialization deleted successfully.');
    }
}