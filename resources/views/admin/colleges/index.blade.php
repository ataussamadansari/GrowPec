@extends('admin.layout')
@section('title', 'Colleges List - GrowPec Admin')
@section('header', 'Manage Colleges')

@section('content')
<div class="bg-white p-4 rounded-4 shadow-sm border">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <form action="{{ route('admin.colleges.index') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search by name, city...">
            <button type="submit" class="btn btn-sm btn-dark">Search</button>
        </form>

        <a href="{{ route('admin.colleges.create') }}" class="btn btn-sm btn-warning fw-bold">
            <i class="bi bi-plus-circle-fill me-1"></i> + Add New College
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>College Name</th>
                    <th>Mode</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Courses</th>
                    <th>Rating</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($colleges as $col)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark">{{ $col->name }}</div>
                            <small class="text-muted">{{ $col->university_name }}</small>
                        </td>
                        <td>
                            <span class="badge bg-{{ $col->college_mode == 'online' ? 'success' : 'primary' }}-subtle text-dark">
                                {{ ucfirst($col->college_mode) }}
                            </span>
                        </td>
                        <td><span class="badge bg-light text-secondary border">{{ $col->college_type }}</span></td>
                        <td>{{ $col->city }}, {{ $col->state }}</td>
                        <td><span class="badge bg-info-subtle text-dark">{{ $col->courses->count() }} Courses</span></td>
                        <td><i class="bi bi-star-fill text-warning me-1"></i>{{ $col->rating }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('college.show', $col->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="View Public Page">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.colleges.edit', $col->id) }}" class="btn btn-sm btn-outline-primary" title="Edit College">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.colleges.destroy', $col->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this college?');">
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
                        <td colspan="7" class="text-center py-4 text-muted">No colleges found in directory.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $colleges->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection