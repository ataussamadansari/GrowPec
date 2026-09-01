@extends('admin.layout')

@section('title', 'Edit Banner - GrowPec Admin')
@section('header', 'Edit Banner')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="bg-white p-4 rounded-4 shadow-sm border">
            <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- 1. Banner Image with Existing Preview -->
                <div class="mb-3">
                    <label class="form-label small fw-bold">Change Banner Image</label>
                    <input type="file" name="image" id="bannerImgInput" class="form-control" accept="image/*">
                    <div class="mt-2">
                        <img id="bannerImgPreview" src="{{ $banner->image_url }}" class="img-fluid rounded-3 border w-100" style="max-height: 160px; object-fit: cover;" alt="Current Banner">
                        <small class="text-muted d-block mt-1">Current image preview above</small>
                    </div>
                </div>

                <!-- 2. Title -->
                <div class="mb-3">
                    <label class="form-label small fw-bold">Banner Title (Optional)</label>
                    <input type="text" name="title" value="{{ old('title', $banner->title) }}" class="form-control">
                </div>

                <!-- 3. Sort Order Index -->
                <div class="mb-3">
                    <label class="form-label small fw-bold">Display Order Index</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}" class="form-control">
                </div>

                <!-- 4. Status Toggle -->
                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" name="status" value="1" id="bannerStatus" {{ $banner->status ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold small" for="bannerStatus">Active (Visible on Website)</label>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning fw-bold px-4">
                        <i class="bi bi-check-circle me-1"></i> Update Banner
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
        };
        reader.readAsDataURL(this.files[0]);
    }
});
</script>
@endpush
@endsection