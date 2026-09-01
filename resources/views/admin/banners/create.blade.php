@extends('admin.layout')

@section('title', 'Upload Banner - GrowPec Admin')
@section('header', 'Upload New Banner')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="bg-white p-4 rounded-4 shadow-sm border">
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- 1. Banner Image -->
                <div class="mb-3">
                    <label class="form-label small fw-bold">Banner Image * (Recommended: 1920x600 px)</label>
                    <input type="file" name="image" id="bannerImgInput" class="form-control" accept="image/*" required>
                    <img id="bannerImgPreview" class="img-fluid rounded-3 border mt-2 w-100" style="max-height: 160px; object-fit: cover; display: none;" alt="Preview">
                </div>

                <!-- 2. Optional Title -->
                <div class="mb-3">
                    <label class="form-label small fw-bold">Banner Title (Optional)</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Admission 2026 Hero Banner">
                </div>

                <!-- 3. Sort Order Index -->
                <div class="mb-3">
                    <label class="form-label small fw-bold">Display Order Index</label>
                    <input type="number" name="sort_order" class="form-control" value="0" placeholder="0">
                    <small class="text-muted">Lowest number shows first (e.g. 0, 1, 2).</small>
                </div>

                <!-- 4. Status Toggle -->
                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" name="status" value="1" id="bannerStatus" checked>
                    <label class="form-check-label fw-bold small" for="bannerStatus">Active (Visible on Website)</label>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning fw-bold px-4">
                        <i class="bi bi-upload me-1"></i> Upload Banner
                    </button>
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('bannerImgInput')?.addEventListener('change', function() {
    const preview = document.getElementById('bannerImgPreview');
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(this.files[0]);
    }
});
</script>
@endpush
@endsection