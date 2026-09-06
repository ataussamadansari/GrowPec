@extends('admin.layout')

@section('title', 'Edit Partner: ' . $partner->name . ' - GrowPec Admin')
@section('header', 'Edit Partner University')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="bg-white p-4 rounded-4 shadow-sm border">
            <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-3">
                    <label class="form-label small fw-bold">University / Partner Name *</label>
                    <input type="text" name="name" value="{{ old('name', $partner->name) }}" class="form-control" required>
                </div>

                <!-- Current & New Logo -->
                <div class="mb-3">
                    <label class="form-label small fw-bold">Change University Logo</label>
                    <input type="file" name="logo" id="partnerLogoInput" class="form-control" accept="image/*">
                    <div class="mt-2 text-center p-2 border rounded-3 bg-light">
                        <img id="partnerLogoPreview" src="{{ $partner->logo_url }}" style="max-height: 70px; object-fit: contain;" alt="Current Logo">
                        <small class="text-muted d-block mt-1">Current Active Logo</small>
                    </div>
                </div>

                <!-- Sort Order -->
                <div class="mb-3">
                    <label class="form-label small fw-bold">Display Order Index</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $partner->sort_order) }}" class="form-control">
                </div>

                <!-- Status Toggle -->
                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" name="status" value="1" id="partnerStatus" {{ $partner->status ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold small" for="partnerStatus">Active (Show in Homepage Marquee)</label>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning fw-bold px-4">
                        <i class="bi bi-check-circle me-1"></i> Update Partner
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
    const preview = document.getElementById('partnerLogoPreview');
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = e => preview.src = e.target.result;
        reader.readAsDataURL(this.files[0]);
    }
});
</script>
@endpush
@endsection