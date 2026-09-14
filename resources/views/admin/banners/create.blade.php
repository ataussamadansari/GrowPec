@extends('admin.layout')

@section('title', 'Upload Banner - GrowPec Admin')
@section('header', 'Upload New Banner')

@section('content')

<style>
    .gp-banner-create {
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

    .gp-banner-create,
    .gp-banner-create * {
        box-sizing:border-box;
    }

    .gp-create-hero {
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

    .gp-create-hero::before,
    .gp-create-hero::after {
        content:"";
        position:absolute;
        pointer-events:none;
        border:1px solid rgba(255,255,255,.13);
        border-radius:50%;
    }

    .gp-create-hero::before {
        width:290px;
        height:290px;
        right:-115px;
        bottom:-205px;
        box-shadow:0 0 0 30px rgba(255,255,255,.025),0 0 0 60px rgba(255,255,255,.018);
    }

    .gp-create-hero::after {
        width:170px;
        height:170px;
        right:-65px;
        bottom:-108px;
    }

    .gp-create-hero-content {
        position:relative;
        z-index:1;
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:20px;
    }

    .gp-create-kicker {
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

    .gp-create-hero h2 {
        margin:11px 0 5px;
        font-size:1.55rem;
        line-height:1.18;
        font-weight:850;
        letter-spacing:-.03em;
    }

    .gp-create-hero p {
        max-width:760px;
        margin:0;
        color:rgba(255,255,255,.76);
        font-size:.74rem;
        line-height:1.6;
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

    .gp-create-layout {
        display:grid;
        grid-template-columns:minmax(0,1fr) minmax(285px,350px);
        gap:20px;
        align-items:start;
        width:100%;
        min-width:0;
    }

    .gp-create-card {
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

    .gp-required {
        color:#D13C49;
    }

    .gp-create-card .form-control,
    .gp-create-card .form-select {
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

    .gp-create-card textarea.form-control {
        min-height:105px;
        resize:vertical;
    }

    .gp-create-card .form-control::placeholder {
        color:#9AA6B6;
    }

    .gp-create-card .form-control:focus,
    .gp-create-card .form-select:focus {
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

    .gp-preview-wrap {
        display:none;
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
        height:180px;
        object-fit:cover;
        background:#EEF2F6;
    }

    .gp-preview-placeholder {
        display:flex;
        align-items:center;
        justify-content:center;
        width:100%;
        height:180px;
        color:#95A2B2;
        font-size:.67rem;
    }

    .gp-side-card {
        position:sticky;
        top:92px;
    }

    .gp-side-card .gp-section-head {
        margin-bottom:15px;
    }

    .gp-order-preview {
        display:flex;
        align-items:center;
        gap:12px;
        padding:14px;
        border:1px solid #DDE7F0;
        border-radius:12px;
        background:#F8FAFC;
    }

    .gp-order-icon {
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

    .gp-order-preview strong {
        display:block;
        color:var(--gp-text);
        font-size:.69rem;
    }

    .gp-order-preview span {
        display:block;
        margin-top:3px;
        color:var(--gp-muted);
        font-size:.6rem;
        line-height:1.45;
    }

    .gp-status-box {
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:15px;
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
        margin-top:15px;
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

    .gp-save-btn,
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

    .gp-save-btn {
        border:1px solid var(--gp-gold);
        background:linear-gradient(135deg,#E0AB00,#C79200);
        color:#172033;
        box-shadow:0 7px 16px rgba(217,164,0,.2);
    }

    .gp-save-btn:hover {
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
        .gp-create-layout {
            grid-template-columns:minmax(0,1fr) minmax(260px,310px);
            gap:15px;
        }

        .gp-create-card {
            padding:19px;
        }

        .gp-side-card {
            top:84px;
        }
    }

    @media (max-width:991.98px) {
        .gp-create-hero {
            padding:23px;
        }

        .gp-create-hero-content {
            align-items:flex-start;
            flex-direction:column;
        }

        .gp-back-btn {
            width:auto;
        }

        .gp-create-layout {
            grid-template-columns:minmax(0,1fr);
            gap:14px;
        }

        .gp-side-card {
            position:relative;
            top:auto;
        }
    }

    @media (max-width:767.98px) {
        .gp-create-hero {
            margin-bottom:13px;
            padding:19px 16px;
            border-radius:15px;
        }

        .gp-create-hero h2 {
            font-size:1.18rem;
        }

        .gp-create-hero p {
            font-size:.65rem;
        }

        .gp-back-btn {
            width:100%;
            min-height:42px;
        }

        .gp-create-card {
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

        .gp-create-card .row {
            --bs-gutter-x:.75rem;
            --bs-gutter-y:.75rem;
        }

        .gp-create-card .form-control,
        .gp-create-card .form-select {
            min-height:42px;
            font-size:.68rem;
        }

        .gp-banner-preview,
        .gp-preview-placeholder {
            height:145px;
        }

        .gp-form-actions {
            flex-direction:column;
            align-items:stretch;
        }

        .gp-save-btn,
        .gp-cancel-btn {
            width:100%;
            min-height:44px;
        }
    }

    @media (max-width:480px) {
        .gp-create-hero {
            padding:16px 13px;
        }

        .gp-create-hero h2 {
            font-size:1.05rem;
        }

        .gp-create-hero p {
            font-size:.61rem;
        }

        .gp-create-card {
            padding:11px;
        }

        .gp-image-upload,
        .gp-status-box,
        .gp-order-preview {
            padding:11px;
        }

        .gp-banner-preview,
        .gp-preview-placeholder {
            height:125px;
        }
    }
</style>

<div class="gp-banner-create">

    <div class="gp-create-hero">
        <div class="gp-create-hero-content">
            <div>
                <span class="gp-create-kicker">
                    <i class="bi bi-cloud-arrow-up"></i>
                    GrowPec Control Center
                </span>

                <h2>Upload New Homepage Banner</h2>

                <p>
                    Add a high-quality hero banner, set its display order and control
                    whether it should be visible on the website.
                </p>
            </div>

            <a href="{{ route('admin.banners.index') }}" class="gp-back-btn">
                <i class="bi bi-arrow-left"></i>
                Back to Banners
            </a>
        </div>
    </div>

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="gp-create-layout">

            <div class="gp-create-card">

                <div class="gp-section-head">
                    <span class="gp-section-icon">
                        <i class="bi bi-image-fill"></i>
                    </span>

                    <div>
                        <h5>Banner Details</h5>
                        <p>Upload the image and provide the basic information for your homepage hero section.</p>
                    </div>
                </div>

                <div class="gp-image-upload mb-4">
                    <label for="bannerImgInput" class="gp-form-label">
                        <i class="bi bi-file-earmark-image"></i>
                        Banner Image <span class="gp-required">*</span>
                    </label>

                    <input
                        type="file"
                        name="image"
                        id="bannerImgInput"
                        class="form-control gp-file-input"
                        accept="image/*"
                        required
                    >

                    <div class="gp-help">
                        <i class="bi bi-info-circle-fill"></i>
                        <span>Recommended size: <strong>1920 × 600 px</strong>. Use a clear, high-quality JPG, PNG or WebP image.</span>
                    </div>

                    <div id="bannerPreviewWrap" class="gp-preview-wrap">
                        <div class="gp-preview-top">
                            <strong><i class="bi bi-eye me-1"></i> Live Preview</strong>
                            <span>Homepage hero preview</span>
                        </div>

                        <img id="bannerImgPreview" class="gp-banner-preview" src="" alt="Banner Preview">
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
                            class="form-control"
                            value="{{ old('title') }}"
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
                            class="form-control"
                            value="{{ old('sort_order', 0) }}"
                            placeholder="0"
                            min="0"
                        >

                        <div class="gp-help">
                            <i class="bi bi-arrow-down-up"></i>
                            <span>Lower number appears first: 0, 1, 2...</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="gp-order-preview h-100">
                            <span class="gp-order-icon">
                                <i class="bi bi-sort-numeric-down"></i>
                            </span>

                            <div>
                                <strong>Banner Priority</strong>
                                <span>Use a lower index for the banner you want displayed first.</span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="gp-form-actions">
                    <button type="submit" class="gp-save-btn">
                        <i class="bi bi-cloud-arrow-up-fill"></i>
                        Upload Banner
                    </button>

                    <a href="{{ route('admin.banners.index') }}" class="gp-cancel-btn">
                        <i class="bi bi-x-lg"></i>
                        Cancel
                    </a>
                </div>

            </div>

            <aside class="gp-create-card gp-side-card">

                <div class="gp-section-head">
                    <span class="gp-section-icon">
                        <i class="bi bi-sliders2"></i>
                    </span>

                    <div>
                        <h5>Publishing Settings</h5>
                        <p>Control the visibility of this banner.</p>
                    </div>
                </div>

                <div class="gp-status-box">
                    <div class="gp-status-info">
                        <strong>Active Banner</strong>
                        <span>Show this banner on the website immediately after upload.</span>
                    </div>

                    <div class="form-check form-switch">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="status"
                            value="1"
                            id="bannerStatus"
                            {{ old('status', true) ? 'checked' : '' }}
                        >
                    </div>
                </div>

                <div class="gp-tip">
                    <i class="bi bi-lightbulb-fill"></i>

                    <div>
                        <strong>Banner Tip</strong>
                        <span>
                            Keep important text and faces near the center of the image
                            so the banner remains readable across desktop and mobile.
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
    const wrap = document.getElementById('bannerPreviewWrap');

    if (!preview || !wrap) return;

    if (this.files && this.files[0]) {
        const file = this.files[0];

        if (!file.type.startsWith('image/')) {
            wrap.style.display = 'none';
            preview.removeAttribute('src');
            return;
        }

        const reader = new FileReader();

        reader.onload = function (event) {
            preview.src = event.target.result;
            wrap.style.display = 'block';
        };

        reader.readAsDataURL(file);
    } else {
        wrap.style.display = 'none';
        preview.removeAttribute('src');
    }
});
</script>
@endpush

@endsection
