@extends('admin.layout')

@section('title', 'Edit Banner - GrowPec Admin')
@section('header', 'Edit Banner')

@section('content')

<style>
    .gp-banner-edit {
        --gp-navy:#002B67;
        --gp-navy-dark:#001B45;
        --gp-blue:#174B8F;
        --gp-green:#008A43;
        --gp-green-dark:#006B35;
        --gp-gold:#D9A400;
        --gp-gold-dark:#B78300;
        --gp-border:#DCE5EF;
        --gp-text:#172033;
        --gp-muted:#718096;
        width:100%;
        max-width:none;
        min-width:0;
        color:var(--gp-text);
    }

    .gp-banner-edit,
    .gp-banner-edit * {
        box-sizing:border-box;
    }

    .gp-edit-hero {
        position:relative;
        isolation:isolate;
        overflow:hidden;
        width:100%;
        margin-bottom:20px;
        padding:28px 30px;
        border-radius:20px;
        color:#fff;
        background:linear-gradient(135deg,var(--gp-navy-dark) 0%,var(--gp-navy) 58%,var(--gp-blue) 100%);
        box-shadow:0 16px 34px rgba(0,43,103,.13);
    }

    .gp-edit-hero::before,
    .gp-edit-hero::after {
        content:"";
        position:absolute;
        pointer-events:none;
        border:1px solid rgba(255,255,255,.13);
        border-radius:50%;
    }

    .gp-edit-hero::before {
        width:290px;
        height:290px;
        right:-115px;
        bottom:-205px;
        box-shadow:0 0 0 30px rgba(255,255,255,.025),0 0 0 60px rgba(255,255,255,.018);
    }

    .gp-edit-hero::after {
        width:170px;
        height:170px;
        right:-65px;
        bottom:-108px;
    }

    .gp-edit-hero-content {
        position:relative;
        z-index:1;
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:20px;
    }

    .gp-edit-kicker {
        display:inline-flex;
        align-items:center;
        gap:7px;
        min-height:30px;
        padding:6px 12px;
        border:1px solid rgba(255,255,255,.18);
        border-radius:999px;
        background:rgba(255,255,255,.08);
        color:rgba(255,255,255,.94);
        font-size:.62rem;
        font-weight:850;
        letter-spacing:.08em;
        text-transform:uppercase;
    }

    .gp-edit-hero h2 {
        margin:11px 0 5px;
        font-size:1.55rem;
        line-height:1.18;
        font-weight:850;
        letter-spacing:-.03em;
    }

    .gp-edit-hero p {
        max-width:760px;
        margin:0;
        color:rgba(255,255,255,.76);
        font-size:.74rem;
        line-height:1.6;
    }

    .gp-current-pill {
        display:inline-flex;
        align-items:center;
        gap:7px;
        max-width:420px;
        margin-top:10px;
        padding:6px 10px;
        border:1px solid rgba(255,255,255,.16);
        border-radius:8px;
        background:rgba(255,255,255,.07);
        color:rgba(255,255,255,.9);
        font-size:.62rem;
        font-weight:700;
    }

    .gp-current-pill span {
        overflow:hidden;
        text-overflow:ellipsis;
        white-space:nowrap;
    }

    .gp-back-btn {
        position:relative;
        z-index:2;
        flex:0 0 auto;
        min-height:43px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:7px;
        padding:0 16px;
        border:1px solid rgba(255,255,255,.22);
        border-radius:10px;
        background:rgba(255,255,255,.08);
        color:#fff;
        font-size:.68rem;
        font-weight:800;
        text-decoration:none;
        white-space:nowrap;
        transition:all .18s ease;
    }

    .gp-back-btn:hover {
        border-color:rgba(255,255,255,.4);
        background:rgba(255,255,255,.15);
        color:#fff;
        transform:translateY(-1px);
    }

    .gp-edit-layout {
        display:grid;
        grid-template-columns:minmax(0,1fr) minmax(285px,350px);
        gap:20px;
        align-items:start;
        width:100%;
        min-width:0;
    }

    .gp-edit-card {
        width:100%;
        min-width:0;
        padding:22px;
        border:1px solid var(--gp-border);
        border-radius:18px;
        background:#fff;
        box-shadow:0 10px 30px rgba(20,35,60,.055);
    }

    .gp-section-head {
        display:flex;
        align-items:flex-start;
        gap:11px;
        margin-bottom:19px;
        padding-bottom:13px;
        border-bottom:1px solid var(--gp-border);
    }

    .gp-section-icon {
        flex:0 0 40px;
        width:40px;
        height:40px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        border-radius:11px;
        background:#EEF5FC;
        color:var(--gp-blue);
        font-size:1rem;
    }

    .gp-section-head h5 {
        margin:0;
        color:var(--gp-navy);
        font-size:.95rem;
        line-height:1.35;
        font-weight:850;
    }

    .gp-section-head p {
        margin:3px 0 0;
        color:var(--gp-muted);
        font-size:.64rem;
        line-height:1.5;
    }

    .gp-form-label {
        display:flex;
        align-items:center;
        gap:6px;
        margin-bottom:7px;
        color:var(--gp-text);
        font-size:.68rem;
        font-weight:800;
    }

    .gp-form-label i {
        color:var(--gp-green);
        font-size:.76rem;
    }

    .gp-edit-card .form-control {
        width:100%;
        min-width:0;
        min-height:44px;
        border:1px solid #D5DFEA;
        border-radius:10px;
        background:#fff;
        color:var(--gp-text);
        font-size:.71rem;
        font-weight:600;
        box-shadow:none;
    }

    .gp-edit-card .form-control:focus {
        border-color:#7DA8D4;
        box-shadow:0 0 0 3px rgba(23,75,143,.09);
    }

    .gp-image-upload {
        padding:15px;
        border:1px dashed #BFD0E1;
        border-radius:13px;
        background:#F8FAFC;
    }

    .gp-file-input {
        padding:8px 10px;
        background:#fff !important;
    }

    .gp-file-input::file-selector-button {
        margin:-8px 12px -8px -10px;
        padding:9px 12px;
        border:0;
        border-right:1px solid #DCE5EF;
        background:#F2F6FA;
        color:var(--gp-navy);
        font-size:.65rem;
        font-weight:800;
        cursor:pointer;
    }

    .gp-help {
        display:flex;
        align-items:flex-start;
        gap:6px;
        margin-top:7px;
        color:var(--gp-muted);
        font-size:.61rem;
        line-height:1.5;
    }

    .gp-help i {
        flex:0 0 auto;
        color:var(--gp-green);
        margin-top:1px;
    }

    .gp-current-preview {
        margin-top:13px;
        overflow:hidden;
        border:1px solid var(--gp-border);
        border-radius:12px;
        background:#F3F6F9;
    }

    .gp-preview-top {
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:10px;
        padding:9px 11px;
        border-bottom:1px solid var(--gp-border);
        background:#fff;
    }

    .gp-preview-top strong {
        color:var(--gp-text);
        font-size:.64rem;
    }

    .gp-preview-top span {
        color:var(--gp-muted);
        font-size:.57rem;
    }

    .gp-banner-preview {
        display:block;
        width:100%;
        height:185px;
        object-fit:cover;
        background:#EEF2F6;
    }

    .gp-side-card {
        position:sticky;
        top:92px;
    }

    .gp-info-box {
        display:flex;
        align-items:flex-start;
        gap:11px;
        padding:14px;
        border:1px solid #DDE7F0;
        border-radius:12px;
        background:#F8FAFC;
    }

    .gp-info-icon {
        flex:0 0 42px;
        width:42px;
        height:42px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        border-radius:11px;
        background:#EAF4EF;
        color:var(--gp-green);
        font-size:1rem;
    }

    .gp-info-box strong {
        display:block;
        color:var(--gp-text);
        font-size:.69rem;
    }

    .gp-info-box span {
        display:block;
        margin-top:3px;
        color:var(--gp-muted);
        font-size:.6rem;
        line-height:1.5;
    }

    .gp-meta-list {
        margin-top:14px;
        overflow:hidden;
        border:1px solid var(--gp-border);
        border-radius:12px;
        background:#fff;
    }

    .gp-meta-row {
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:12px;
        padding:11px 13px;
        border-bottom:1px solid #EDF1F5;
    }

    .gp-meta-row:last-child {
        border-bottom:0;
    }

    .gp-meta-row span {
        color:var(--gp-muted);
        font-size:.61rem;
    }

    .gp-meta-row strong {
        color:var(--gp-text);
        font-size:.64rem;
        text-align:right;
    }

    .gp-status-box {
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:15px;
        margin-top:14px;
        padding:14px;
        border:1px solid #DDE7F0;
        border-radius:12px;
        background:#F8FAFC;
    }

    .gp-status-info {
        min-width:0;
    }

    .gp-status-info strong {
        display:block;
        color:var(--gp-text);
        font-size:.69rem;
    }

    .gp-status-info span {
        display:block;
        margin-top:3px;
        color:var(--gp-muted);
        font-size:.59rem;
        line-height:1.45;
    }

    .gp-status-box .form-check {
        flex:0 0 auto;
        margin:0;
    }

    .gp-status-box .form-check-input {
        width:43px;
        height:24px;
        margin:0;
        cursor:pointer;
    }

    .gp-status-box .form-check-input:checked {
        border-color:var(--gp-green);
        background-color:var(--gp-green);
    }

    .gp-tip {
        display:flex;
        align-items:flex-start;
        gap:10px;
        margin-top:14px;
        padding:13px;
        border:1px solid #F1E1A9;
        border-radius:12px;
        background:#FFFBEB;
    }

    .gp-tip i {
        flex:0 0 auto;
        color:var(--gp-gold-dark);
        font-size:.95rem;
    }

    .gp-tip strong {
        display:block;
        margin-bottom:3px;
        color:#6D5300;
        font-size:.64rem;
    }

    .gp-tip span {
        display:block;
        color:#806F3A;
        font-size:.59rem;
        line-height:1.5;
    }

    .gp-form-actions {
        display:flex;
        align-items:center;
        justify-content:center;
        gap:9px;
        margin-top:20px;
        padding-top:18px;
        border-top:1px solid var(--gp-border);
    }

    .gp-update-btn,
    .gp-cancel-btn {
        min-height:45px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:7px;
        padding:0 18px;
        border-radius:10px;
        font-size:.68rem;
        font-weight:850;
        text-decoration:none;
        transition:all .18s ease;
        cursor:pointer;
    }

    .gp-update-btn {
        border:1px solid var(--gp-gold);
        background:linear-gradient(135deg,#E0AB00,#C79200);
        color:#172033;
        box-shadow:0 7px 16px rgba(217,164,0,.2);
    }

    .gp-update-btn:hover {
        border-color:var(--gp-gold-dark);
        background:linear-gradient(135deg,#C79200,#B78300);
        color:#fff;
        transform:translateY(-1px);
    }

    .gp-cancel-btn {
        border:1px solid #D6DEE8;
        background:#fff;
        color:#58667A;
    }

    .gp-cancel-btn:hover {
        border-color:#B7C3D1;
        background:#F7F9FB;
        color:var(--gp-navy);
    }

    @media (max-width:1199.98px) {
        .gp-edit-layout {
            grid-template-columns:minmax(0,1fr) minmax(260px,310px);
            gap:15px;
        }

        .gp-edit-card {
            padding:19px;
        }

        .gp-side-card {
            top:84px;
        }
    }

    @media (max-width:991.98px) {
        .gp-edit-hero {
            padding:23px;
        }

        .gp-edit-hero-content {
            align-items:flex-start;
            flex-direction:column;
        }

        .gp-back-btn {
            width:auto;
        }

        .gp-edit-layout {
            grid-template-columns:minmax(0,1fr);
            gap:14px;
        }

        .gp-side-card {
            position:relative;
            top:auto;
        }
    }

    @media (max-width:767.98px) {
        .gp-edit-hero {
            margin-bottom:13px;
            padding:19px 16px;
            border-radius:15px;
        }

        .gp-edit-hero h2 {
            font-size:1.18rem;
        }

        .gp-edit-hero p {
            font-size:.65rem;
        }

        .gp-current-pill {
            max-width:100%;
            font-size:.59rem;
        }

        .gp-back-btn {
            width:100%;
            min-height:42px;
        }

        .gp-edit-card {
            padding:14px;
            border-radius:14px;
        }

        .gp-section-head {
            margin-bottom:15px;
        }

        .gp-section-icon {
            flex-basis:36px;
            width:36px;
            height:36px;
        }

        .gp-section-head h5 {
            font-size:.84rem;
        }

        .gp-section-head p {
            font-size:.6rem;
        }

        .gp-edit-card .row {
            --bs-gutter-x:.75rem;
            --bs-gutter-y:.75rem;
        }

        .gp-edit-card .form-control {
            min-height:42px;
            font-size:.68rem;
        }

        .gp-banner-preview {
            height:145px;
        }

        .gp-form-actions {
            flex-direction:column;
            align-items:stretch;
        }

        .gp-update-btn,
        .gp-cancel-btn {
            width:100%;
            min-height:44px;
        }
    }

    @media (max-width:480px) {
        .gp-edit-hero {
            padding:16px 13px;
        }

        .gp-edit-hero h2 {
            font-size:1.05rem;
        }

        .gp-edit-hero p {
            font-size:.61rem;
        }

        .gp-edit-card {
            padding:11px;
        }

        .gp-image-upload,
        .gp-status-box,
        .gp-info-box {
            padding:11px;
        }

        .gp-banner-preview {
            height:125px;
        }
    }
</style>

<div class="gp-banner-edit">

    <div class="gp-edit-hero">
        <div class="gp-edit-hero-content">
            <div>
                <span class="gp-edit-kicker">
                    <i class="bi bi-pencil-square"></i>
                    GrowPec Control Center
                </span>

                <h2>Edit Homepage Banner</h2>

                <p>
                    Update the banner image, title, display priority and website visibility
                    without changing the existing banner record.
                </p>

                <span class="gp-current-pill">
                    <i class="bi bi-image"></i>
                    Current:
                    <span>{{ $banner->title ?: 'Hero Banner #' . $banner->id }}</span>
                </span>
            </div>

            <a href="{{ route('admin.banners.index') }}" class="gp-back-btn">
                <i class="bi bi-arrow-left"></i>
                Back to Banners
            </a>
        </div>
    </div>

    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="gp-edit-layout">

            <div class="gp-edit-card">

                <div class="gp-section-head">
                    <span class="gp-section-icon">
                        <i class="bi bi-image-fill"></i>
                    </span>

                    <div>
                        <h5>Banner Details</h5>
                        <p>Change the existing banner image or update its basic information.</p>
                    </div>
                </div>

                <div class="gp-image-upload mb-4">
                    <label for="bannerImgInput" class="gp-form-label">
                        <i class="bi bi-file-earmark-image"></i>
                        Change Banner Image
                    </label>

                    <input
                        type="file"
                        name="image"
                        id="bannerImgInput"
                        class="form-control gp-file-input"
                        accept="image/*"
                    >

                    <div class="gp-help">
                        <i class="bi bi-info-circle-fill"></i>
                        <span>
                            Upload only if you want to replace the current image.
                            Recommended size: <strong>1920 × 600 px</strong>.
                        </span>
                    </div>

                    <div class="gp-current-preview">
                        <div class="gp-preview-top">
                            <strong>
                                <i class="bi bi-eye me-1"></i>
                                Banner Preview
                            </strong>

                            <span id="previewLabel">Current image</span>
                        </div>

                        <img
                            id="bannerImgPreview"
                            src="{{ $banner->image_url }}"
                            class="gp-banner-preview"
                            alt="{{ $banner->title ?: 'Current Banner' }}"
                        >
                    </div>
                </div>

                <div class="row g-3">

                    <div class="col-12">
                        <label for="bannerTitle" class="gp-form-label">
                            <i class="bi bi-type"></i>
                            Banner Title
                            <span class="text-muted fw-normal">(Optional)</span>
                        </label>

                        <input
                            type="text"
                            name="title"
                            id="bannerTitle"
                            value="{{ old('title', $banner->title) }}"
                            class="form-control"
                            placeholder="e.g. Admission 2026 Hero Banner"
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="sortOrder" class="gp-form-label">
                            <i class="bi bi-list-ol"></i>
                            Display Order Index
                        </label>

                        <input
                            type="number"
                            name="sort_order"
                            id="sortOrder"
                            value="{{ old('sort_order', $banner->sort_order) }}"
                            class="form-control"
                            min="0"
                            placeholder="0"
                        >

                        <div class="gp-help">
                            <i class="bi bi-arrow-down-up"></i>
                            <span>Lower number appears first: 0, 1, 2...</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="gp-info-box h-100">
                            <span class="gp-info-icon">
                                <i class="bi bi-sort-numeric-down"></i>
                            </span>

                            <div>
                                <strong>Banner Priority</strong>
                                <span>
                                    Adjust the index to control the order in which
                                    active homepage banners are displayed.
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="gp-form-actions">
                    <button type="submit" class="gp-update-btn">
                        <i class="bi bi-check-circle-fill"></i>
                        Update Banner
                    </button>

                    <a href="{{ route('admin.banners.index') }}" class="gp-cancel-btn">
                        <i class="bi bi-x-lg"></i>
                        Cancel
                    </a>
                </div>

            </div>

            <aside class="gp-edit-card gp-side-card">

                <div class="gp-section-head">
                    <span class="gp-section-icon">
                        <i class="bi bi-sliders2"></i>
                    </span>

                    <div>
                        <h5>Publishing Settings</h5>
                        <p>Control banner visibility and review its record details.</p>
                    </div>
                </div>

                <div class="gp-status-box">
                    <div class="gp-status-info">
                        <strong>Active Banner</strong>
                        <span>Show this banner on the website.</span>
                    </div>

                    <div class="form-check form-switch">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="status"
                            value="1"
                            id="bannerStatus"
                            {{ old('status', $banner->status) ? 'checked' : '' }}
                        >
                    </div>
                </div>

                <div class="gp-meta-list">
                    <div class="gp-meta-row">
                        <span>Banner ID</span>
                        <strong>#{{ $banner->id }}</strong>
                    </div>

                    <div class="gp-meta-row">
                        <span>Current Order</span>
                        <strong>{{ $banner->sort_order }}</strong>
                    </div>

                    <div class="gp-meta-row">
                        <span>Created</span>
                        <strong>{{ $banner->created_at->format('d M Y') }}</strong>
                    </div>

                    <div class="gp-meta-row">
                        <span>Last Updated</span>
                        <strong>{{ $banner->updated_at->format('d M Y') }}</strong>
                    </div>
                </div>

                <div class="gp-tip">
                    <i class="bi bi-lightbulb-fill"></i>

                    <div>
                        <strong>Banner Tip</strong>
                        <span>
                            Keep important text and faces near the center so the banner
                            remains readable on desktop, tablet and mobile screens.
                        </span>
                    </div>
                </div>

            </aside>

        </div>
    </form>
</div>

@push('scripts')
<script>
document.getElementById('bannerImgInput')?.addEventListener('change', function () {
    const preview = document.getElementById('bannerImgPreview');
    const label = document.getElementById('previewLabel');

    if (!preview) return;

    if (this.files && this.files[0]) {
        const file = this.files[0];

        if (!file.type.startsWith('image/')) {
            return;
        }

        const reader = new FileReader();

        reader.onload = function (event) {
            preview.src = event.target.result;

            if (label) {
                label.textContent = 'New image preview';
            }
        };

        reader.readAsDataURL(file);
    }
});
</script>
@endpush

@endsection
