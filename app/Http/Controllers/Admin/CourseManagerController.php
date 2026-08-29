<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Stream;
use Illuminate\Support\Str;

class CourseManagerController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with('stream')->withCount('collegeCourses');

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->filled('stream_id')) {
            $query->where('stream_id', $request->stream_id);
        }

        $courses = $query->latest()->paginate(15)->withQueryString();
        $streams = Stream::orderBy('name')->get();

        return view('admin.courses.index', compact('courses', 'streams'));
    }

    public function create()
    {
        $streams = Stream::orderBy('name')->get();
        return view('admin.courses.create', compact('streams'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'stream_id'   => 'required|exists:streams,id',
            'name'        => 'required|string|max:150',
            'level'       => 'required|in:UG,PG,Diploma,PhD,Certificate',
            'degree_type' => 'required|in:Degree,Diploma,Certificate',
            'duration'    => 'required|string|max:50',
        ]);

        $validated['slug'] = Str::slug($request->name);

        // Avoid duplicate slug
        if (Course::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] .= '-' . strtolower($validated['level']);
        }

        Course::create($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Course added successfully!');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $streams = Stream::orderBy('name')->get();
        return view('admin.courses.edit', compact('course', 'streams'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'stream_id'   => 'required|exists:streams,id',
            'name'        => 'required|string|max:150',
            'level'       => 'required|in:UG,PG,Diploma,PhD,Certificate',
            'degree_type' => 'required|in:Degree,Diploma,Certificate',
            'duration'    => 'required|string|max:50',
        ]);

        $validated['slug'] = Str::slug($request->name);

        $course->update($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully!');
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return back()->with('success', 'Course deleted successfully.');
    }
}