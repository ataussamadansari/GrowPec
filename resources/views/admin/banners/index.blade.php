@extends('admin.layout')

@section('title', 'Manage Banners - GrowPec Admin')
@section('header', 'Homepage Banners')

@section('content')
<div class="bg-white p-4 rounded-4 shadow-sm border">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-images me-1"></i> Banners List</h5>
            <small class="text-muted">Manage background images, display order (index), and active status.</small>
        </div>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-warning btn-sm fw-bold">
            <i class="bi bi-plus-circle-fill me-1"></i> + Upload Banner
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Image Preview</th>
                    <th>Banner Name / Title</th>
                    <th>Order Index</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banners as $banner)
                <tr>
                    <td style="width: 180px;">
                        <img src="{{ $banner->image_url }}" class="rounded-3 border shadow-sm w-100" style="height: 75px; object-fit: cover;" alt="Banner Preview">
                    </td>
                    <td>
                        <div class="fw-bold text-dark">{{ $banner->title ?: 'Hero Banner #' . $banner->id }}</div>
                        <small class="text-muted">{{ $banner->created_at->format('d M Y') }}</small>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border px-3 py-2 fw-bold">
                            Index: {{ $banner->sort_order }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $banner->status ? 'success' : 'secondary' }}-subtle text-dark">
                            {{ $banner->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Delete this banner?');">
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
                        No banners uploaded yet. Default theme image is active.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $banners->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection