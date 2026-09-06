@extends('admin.layout')

@section('title', 'Manage Partner Universities - GrowPec Admin')
@section('header', 'Partner Universities Marquee Strip')

@section('content')
<div class="bg-white p-4 rounded-4 shadow-sm border">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom flex-wrap gap-2">
        <div>
            <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-award-fill me-1"></i> Partner Universities List</h5>
            <small class="text-muted">Homepage marquee strip par dikhne wale universities ke logo aur names manage karein.</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary btn-sm fw-bold">
                <i class="bi bi-sliders me-1"></i> Section Show/Hide Settings
            </a>
            <a href="{{ route('admin.partners.create') }}" class="btn btn-warning btn-sm fw-bold">
                <i class="bi bi-plus-circle-fill me-1"></i> + Add Partner University
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 90px;">Logo</th>
                    <th>University / Partner Name</th>
                    <th>Sort Order</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($partners as $partner)
                <tr>
                    <td>
                        <img src="{{ $partner->logo_url }}" class="rounded-3 border p-1 bg-white" style="width: 60px; height: 50px; object-fit: contain;" alt="{{ $partner->name }}">
                    </td>
                    <td>
                        <div class="fw-bold text-dark">{{ $partner->name }}</div>
                        <small class="text-muted">Added: {{ $partner->created_at->format('d M Y') }}</small>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border px-3 py-2 fw-bold">
                            Index: {{ $partner->sort_order }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $partner->status ? 'success' : 'secondary' }}-subtle text-dark">
                            {{ $partner->status ? 'Active (Visible)' : 'Hidden' }}
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.partners.edit', $partner->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Delete this partner university?');">
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
                    <td colspan="5" class="text-center py-5 text-muted">
                        No partner universities added yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $partners->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection