@extends('admin.layout')
@section('title', 'Manage Streams - GrowPec Admin')
@section('header', 'Manage Academic Streams')

@section('content')
<div class="bg-white p-4 rounded-4 shadow-sm border">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <form action="{{ route('admin.streams.index') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search stream name...">
            <button type="submit" class="btn btn-sm btn-dark">Search</button>
        </form>
        <a href="{{ route('admin.streams.create') }}" class="btn btn-sm btn-warning fw-bold">
            <i class="bi bi-plus-circle-fill me-1"></i> + Add New Stream
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Stream Name</th>
                    <th>Slug</th>
                    <th>Total Courses</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($streams as $st)
                    <tr>
                        <td>{{ $st->id }}</td>
                        <td class="fw-bold text-dark">{{ $st->name }}</td>
                        <td><code>{{ $st->slug }}</code></td>
                        <td><span class="badge bg-primary-subtle text-primary border">{{ $st->courses_count }} Courses</span></td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.streams.edit', $st->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.streams.destroy', $st->id) }}" method="POST" onsubmit="return confirm('Delete this stream?');">
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
                        <td colspan="5" class="text-center py-4 text-muted">No streams found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $streams->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection