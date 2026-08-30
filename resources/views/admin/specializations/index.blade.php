@extends('admin.layout')
@section('title', 'Manage Specializations - GrowPec Admin')
@section('header', 'Manage Specializations')

@section('content')
<div class="bg-white p-4 rounded-4 shadow-sm border">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <form action="{{ route('admin.specializations.index') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search specialization...">
            <select name="course_id" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">All Courses</option>
                @foreach($courses as $c)
                    <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>{{ $c->name }} ({{ $c->stream->name ?? '' }})</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-sm btn-dark">Filter</button>
        </form>
        <a href="{{ route('admin.specializations.create') }}" class="btn btn-sm btn-warning fw-bold">
            <i class="bi bi-plus-circle-fill me-1"></i> + Add Specialization
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Specialization Name</th>
                    <th>Associated Course</th>
                    <th>Stream</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($specializations as $sp)
                    <tr>
                        <td>{{ $sp->id }}</td>
                        <td class="fw-bold text-dark">{{ $sp->name }}</td>
                        <td><span class="badge bg-primary-subtle text-primary border">{{ $sp->course->name ?? 'N/A' }}</span></td>
                        <td><small class="text-muted">{{ $sp->course->stream->name ?? 'N/A' }}</small></td>
                        <td>
                            <span class="badge bg-{{ $sp->status ? 'success' : 'secondary' }}-subtle text-dark">
                                {{ $sp->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.specializations.edit', $sp->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.specializations.destroy', $sp->id) }}" method="POST" onsubmit="return confirm('Delete this specialization?');">
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
                        <td colspan="6" class="text-center py-4 text-muted">No specializations found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $specializations->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection