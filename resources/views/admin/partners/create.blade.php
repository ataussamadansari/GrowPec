@extends('admin.layout')

@section('title', 'Add Partner University - GrowPec Admin')
@section('header', 'Add Partner University')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="bg-white p-4 rounded-4 shadow-sm border">
            <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label class="form-label small fw-bold">University / Partner Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Amity University" required>
                </div>

                <!-- Logo Image Upload -->
                <div class="mb-3">
                    <label class="form-label small fw-bold">University Logo Image (PNG / JPG / SVG)</label>
                    <input type="file" name="logo" id="partnerLogoInput" class="form-control" accept="image/*">
                    <div class="mt-2 text-center p-2 border rounded-3 bg-light" id="logoPreviewBox" style="display: none;">
                        <img id="partnerLogoPreview" src="#" style="max-height: 70px; object-fit: contain;" alt="Preview">
                    </div>
                    <small class="text-muted">Transparent PNG logo recommended.</small>
                </div>

                <!-- Sort Order -->
                <div class="mb-3">
                    <label class="form-label small fw-bold">Display Order Index</label>
                    <input type="number" name="sort_order" class="form-control" value="0">
                    <small class="text-muted">Lowest number shows first (0, 1, 2...).</small>
                </div>

                <!-- Status Toggle -->
                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" name="status" value="1" id="partnerStatus" checked>
                    <label class="form-check-label fw-bold small" for="partnerStatus">Active (Show in Homepage Marquee)</label>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning fw-bold px-4">
                        <i class="bi bi-check-circle me-1"></i> Save Partner
                    </button>
                    <a href="{{ route('admin.partners.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('partnerLogoInput')?.addEventListener('change', function() {
    const previewBox = document.getElementById('logoPreviewBox');
    const preview = document.getElementById('partnerLogoPreview');
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            previewBox.style.display = 'block';
        };
        reader.readAsDataURL(this.files[0]);
    }
});
</script>
@endpush
@endsection