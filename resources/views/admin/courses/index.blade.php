@extends('admin.layout')
@section('title', 'Manage Courses - GrowPec Admin')
@section('header', 'Manage Courses & Programs')

@section('content')
<div class="bg-white p-4 rounded-4 shadow-sm border">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <form action="{{ route('admin.courses.index') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search course (e.g. BCA, MBA)...">
            <select name="stream_id" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">All Streams</option>
                @foreach($streams as $st)
                    <option value="{{ $st->id }}" {{ request('stream_id') == $st->id ? 'selected' : '' }}>{{ $st->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-sm btn-dark">Filter</button>
        </form>

        <a href="{{ route('admin.courses.create') }}" class="btn btn-sm btn-warning fw-bold">
            <i class="bi bi-plus-circle-fill me-1"></i> + Add New Course
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Course Name</th>
                    <th>Stream</th>
                    <th>Level</th>
                    <th>Degree Type</th>
                    <th>Duration</th>
                    <th>Offering Colleges</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                    <tr>
                        <td>{{ $course->id }}</td>
                        <td class="fw-bold text-dark">{{ $course->name }}</td>
                        <td><span class="badge bg-primary-subtle text-primary border">{{ $course->stream->name ?? 'N/A' }}</span></td>
                        <td><span class="badge bg-light text-dark border">{{ $course->level }}</span></td>
                        <td>{{ $course->degree_type }}</td>
                        <td>{{ $course->duration }}</td>
                        <td><span class="badge bg-info-subtle text-dark">{{ $course->college_courses_count }} Colleges</span></td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Delete this course?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">No courses found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $courses->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
