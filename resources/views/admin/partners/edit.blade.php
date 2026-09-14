@extends('admin.layout')

@section('title', 'Edit Partner: ' . $partner->name . ' - GrowPec Admin')
@section('header', 'Edit Partner University')

@section('content')
<style>
    .gp-partner-edit {
        --gp-navy:#002B67;
        --gp-navy-dark:#001B45;
        --gp-blue:#174B8F;
        --gp-green:#008A43;
        --gp-green-dark:#006B35;
        --gp-gold:#D9A400;
        --gp-gold-dark:#B78300;
        --gp-border:#E1E8F0;
        --gp-text:#172033;
        --gp-muted:#718096;
        width:100%;
        max-width:none;
        min-width:0;
        padding:0 0 28px;
    }

    .gp-partner-edit * { box-sizing:border-box; }

    .gp-edit-hero {
        position:relative;
        overflow:hidden;
        width:100%;
        margin-bottom:18px;
        padding:24px 26px;
        border-radius:17px;
        color:#fff;
        background:linear-gradient(135deg,var(--gp-navy-dark),var(--gp-navy) 58%,var(--gp-blue));
        box-shadow:0 12px 30px rgba(0,43,103,.14);
    }

    .gp-edit-hero:after {
        content:"";
        position:absolute;
        width:220px;
        height:220px;
        right:-85px;
        bottom:-140px;
        border:1px solid rgba(255,255,255,.14);
        border-radius:50%;
        box-shadow:0 0 0 30px rgba(255,255,255,.025);
    }

    .gp-edit-hero > * { position:relative; z-index:1; }

    .gp-kicker {
        display:inline-flex;
        align-items:center;
        gap:7px;
        padding:6px 10px;
        border:1px solid rgba(255,255,255,.16);
        border-radius:999px;
        background:rgba(255,255,255,.09);
        color:rgba(255,255,255,.9);
        font-size:.62rem;
        font-weight:800;
        letter-spacing:.08em;
        text-transform:uppercase;
    }

    .gp-edit-hero h2 {
        margin:10px 0 5px;
        font-size:1.42rem;
        font-weight:850;
        letter-spacing:-.02em;
    }

    .gp-edit-hero p {
        margin:0;
        max-width:820px;
        color:rgba(255,255,255,.76);
        font-size:.73rem;
        line-height:1.5;
    }

    .gp-name-pill {
        display:inline-flex;
        align-items:center;
        gap:6px;
        max-width:100%;
        margin-top:11px;
        padding:6px 10px;
        border:1px solid rgba(255,255,255,.16);
        border-radius:999px;
        background:rgba(255,255,255,.08);
        color:#fff;
        font-size:.62rem;
        font-weight:750;
    }

    .gp-name-pill span {
        max-width:520px;
        overflow:hidden;
        text-overflow:ellipsis;
        white-space:nowrap;
    }

    .gp-edit-layout {
        display:grid;
        grid-template-columns:minmax(0,1fr) 320px;
        gap:18px;
        align-items:start;
        width:100%;
        min-width:0;
    }

    .gp-card {
        width:100%;
        min-width:0;
        overflow:hidden;
        border:1px solid var(--gp-border);
        border-radius:16px;
        background:#fff;
        box-shadow:0 8px 25px rgba(20,35,60,.055);
    }

    .gp-card + .gp-card { margin-top:18px; }

    .gp-card-head {
        display:flex;
        align-items:center;
        gap:11px;
        padding:15px 18px;
        border-bottom:1px solid var(--gp-border);
        background:#FCFDFE;
    }

    .gp-card-icon {
        width:40px;
        height:40px;
        flex:0 0 40px;
        display:grid;
        place-items:center;
        border:1px solid #D7E5F4;
        border-radius:11px;
        background:#EAF2FB;
        color:var(--gp-blue);
        font-size:.92rem;
    }

    .gp-card-title {
        margin:0;
        color:var(--gp-text);
        font-size:.88rem;
        font-weight:850;
    }

    .gp-card-subtitle {
        display:block;
        margin-top:2px;
        color:var(--gp-muted);
        font-size:.61rem;
        font-weight:600;
        line-height:1.4;
    }

    .gp-card-body { padding:19px; }

    .gp-field { margin-bottom:17px; }
    .gp-field:last-child { margin-bottom:0; }

    .gp-label {
        display:flex;
        align-items:center;
        gap:7px;
        margin-bottom:7px;
        color:var(--gp-text);
        font-size:.68rem;
        font-weight:800;
    }

    .gp-label i { color:var(--gp-blue); font-size:.78rem; }

    .gp-input,
    .gp-file {
        width:100%;
        min-height:43px;
        border:1px solid #D8E1EB;
        border-radius:10px;
        background:#fff;
        color:var(--gp-text);
        font-size:.72rem;
        font-weight:600;
        transition:border-color .18s ease, box-shadow .18s ease;
    }

    .gp-input { padding:10px 12px; }
    .gp-file { padding:8px 10px; }

    .gp-input::placeholder { color:#9AA5B5; font-weight:500; }

    .gp-input:focus,
    .gp-file:focus {
        border-color:#7EA8D4;
        box-shadow:0 0 0 3px rgba(23,75,143,.09);
        outline:none;
    }

    .gp-help {
        display:block;
        margin-top:6px;
        color:#8A95A6;
        font-size:.59rem;
        font-weight:600;
        line-height:1.45;
    }

    .gp-upload-box {
        padding:13px;
        border:1px dashed #C8D5E4;
        border-radius:12px;
        background:#F8FAFC;
    }

    .gp-current-logo {
        display:flex;
        align-items:center;
        justify-content:center;
        min-height:110px;
        margin-top:10px;
        padding:13px;
        border:1px solid #DCE5EF;
        border-radius:11px;
        background:#fff;
    }

    .gp-current-logo img {
        max-width:100%;
        max-height:76px;
        object-fit:contain;
    }

    .gp-logo-caption {
        margin-top:7px;
        color:#8A95A6;
        font-size:.56rem;
        font-weight:650;
        text-align:center;
    }

    .gp-status-box {
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:14px;
        padding:13px 14px;
        border:1px solid #DCE7E1;
        border-radius:12px;
        background:#F4FBF7;
    }

    .gp-status-copy strong {
        display:block;
        color:var(--gp-text);
        font-size:.69rem;
        font-weight:850;
    }

    .gp-status-copy span {
        display:block;
        margin-top:3px;
        color:#748294;
        font-size:.58rem;
        font-weight:600;
    }

    .gp-switch {
        width:42px !important;
        height:23px !important;
        margin:0 !important;
        cursor:pointer;
    }

    .gp-switch:checked {
        background-color:var(--gp-green);
        border-color:var(--gp-green);
    }

    .gp-info {
        padding:14px;
        border:1px solid #DCE7F2;
        border-radius:12px;
        background:#F5F9FD;
    }

    .gp-info-title {
        display:flex;
        align-items:center;
        gap:7px;
        margin-bottom:8px;
        color:var(--gp-navy);
        font-size:.68rem;
        font-weight:850;
    }

    .gp-info p {
        margin:0;
        color:#68768A;
        font-size:.61rem;
        line-height:1.55;
        font-weight:600;
    }

    .gp-meta {
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:8px;
        margin-bottom:13px;
    }

    .gp-meta-item {
        padding:10px;
        border:1px solid #E2E8F0;
        border-radius:10px;
        background:#FAFBFD;
    }

    .gp-meta-label {
        display:block;
        margin-bottom:3px;
        color:#8A95A6;
        font-size:.55rem;
        font-weight:700;
        text-transform:uppercase;
        letter-spacing:.04em;
    }

    .gp-meta-value {
        display:block;
        overflow:hidden;
        color:var(--gp-text);
        font-size:.68rem;
        font-weight:850;
        text-overflow:ellipsis;
        white-space:nowrap;
    }

    .gp-actions {
        display:flex;
        align-items:center;
        justify-content:center;
        gap:9px;
        margin-top:18px;
        padding-top:18px;
        border-top:1px solid #E8EDF3;
    }

    .gp-btn {
        min-height:42px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:7px;
        padding:0 17px;
        border-radius:10px;
        font-size:.68rem;
        font-weight:850;
        white-space:nowrap;
        text-decoration:none;
        transition:all .18s ease;
    }

    .gp-btn-update {
        border:1px solid var(--gp-gold);
        background:var(--gp-gold);
        color:#172033;
    }

    .gp-btn-update:hover {
        border-color:var(--gp-gold-dark);
        background:var(--gp-gold-dark);
        color:#fff;
        transform:translateY(-1px);
    }

    .gp-btn-cancel {
        border:1px solid #D5DDE7;
        background:#fff;
        color:#526176;
    }

    .gp-btn-cancel:hover {
        border-color:#B9C6D5;
        background:#F7F9FC;
        color:var(--gp-text);
    }

    @media (max-width:1199.98px) {
        .gp-edit-layout { grid-template-columns:minmax(0,1fr); }
        .gp-side {
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:18px;
        }
        .gp-side .gp-card + .gp-card { margin-top:0; }
    }

    @media (max-width:767.98px) {
        .gp-partner-edit { padding-bottom:18px; }

        .gp-edit-hero {
            margin-bottom:12px;
            padding:18px 14px;
            border-radius:13px;
        }

        .gp-edit-hero h2 { font-size:1.12rem; }
        .gp-edit-hero p { font-size:.67rem; }

        .gp-name-pill { max-width:100%; }
        .gp-name-pill span { max-width:calc(100vw - 90px); }

        .gp-card { border-radius:13px; }
        .gp-card-head { padding:11px 12px; }
        .gp-card-body { padding:12px; }
        .gp-card-icon { width:35px; height:35px; flex-basis:35px; }
        .gp-card-title { font-size:.78rem; }
        .gp-card-subtitle { font-size:.55rem; }

        .gp-side {
            grid-template-columns:minmax(0,1fr);
            gap:12px;
        }

        .gp-field { margin-bottom:14px; }
        .gp-input, .gp-file { min-height:41px; }

        .gp-actions {
            flex-direction:column;
            align-items:stretch;
        }

        .gp-btn {
            width:100%;
            min-height:43px;
        }
    }
</style>

<div class="gp-partner-edit">
    <div class="gp-edit-hero">
        <span class="gp-kicker">
            <i class="bi bi-pencil-square"></i>
            Partner Management
        </span>

        <h2>Edit Partner University</h2>

        <p>
            Update partner information, replace the university logo, change its marquee order
            or control whether it is visible on the GrowPec homepage.
        </p>

        <div class="gp-name-pill">
            <i class="bi bi-building-check"></i>
            <span>{{ $partner->name }}</span>
        </div>
    </div>

    <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="gp-edit-layout">
            <div class="gp-main">
                <section class="gp-card">
                    <div class="gp-card-head">
                        <span class="gp-card-icon">
                            <i class="bi bi-building-gear"></i>
                        </span>
                        <div>
                            <h3 class="gp-card-title">Partner Details</h3>
                            <small class="gp-card-subtitle">Update the university partner information</small>
                        </div>
                    </div>

                    <div class="gp-card-body">
                        <div class="gp-field">
                            <label for="partnerName" class="gp-label">
                                <i class="bi bi-building"></i>
                                University / Partner Name
                                <span style="color:#C0392B;">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="partnerName"
                                value="{{ old('name', $partner->name) }}"
                                class="gp-input"
                                placeholder="e.g. Amity University"
                                required
                            >
                        </div>

                        <div class="gp-field">
                            <label for="partnerLogoInput" class="gp-label">
                                <i class="bi bi-image"></i>
                                Change University Logo
                            </label>

                            <div class="gp-upload-box">
                                <input
                                    type="file"
                                    name="logo"
                                    id="partnerLogoInput"
                                    class="gp-file"
                                    accept="image/png,image/jpeg,image/jpg,image/svg+xml,image/webp"
                                >

                                <small class="gp-help">
                                    Upload only when you want to replace the current logo.
                                    PNG with transparent background is recommended.
                                </small>

                                <div class="gp-current-logo">
                                    <img
                                        id="partnerLogoPreview"
                                        src="{{ $partner->logo_url }}"
                                        alt="{{ $partner->name }} Logo"
                                    >
                                </div>

                                <div class="gp-logo-caption" id="logoCaption">
                                    Current Active Logo
                                </div>
                            </div>
                        </div>

                        <div class="gp-field">
                            <label for="sortOrder" class="gp-label">
                                <i class="bi bi-arrow-down-up"></i>
                                Display Order Index
                            </label>

                            <input
                                type="number"
                                name="sort_order"
                                id="sortOrder"
                                value="{{ old('sort_order', $partner->sort_order) }}"
                                class="gp-input"
                                min="0"
                                step="1"
                            >

                            <small class="gp-help">
                                Lower number appears first in the homepage marquee.
                            </small>
                        </div>

                        <div class="gp-field">
                            <div class="gp-status-box">
                                <div class="gp-status-copy">
                                    <strong>Show on Homepage Marquee</strong>
                                    <span>Active partners are displayed on the public homepage.</span>
                                </div>

                                <div class="form-check form-switch">
                                    <input
                                        class="form-check-input gp-switch"
                                        type="checkbox"
                                        name="status"
                                        value="1"
                                        id="partnerStatus"
                                        {{ old('status', $partner->status) ? 'checked' : '' }}
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="gp-actions">
                            <button type="submit" class="gp-btn gp-btn-update">
                                <i class="bi bi-check-circle-fill"></i>
                                Update Partner
                            </button>

                            <a href="{{ route('admin.partners.index') }}" class="gp-btn gp-btn-cancel">
                                <i class="bi bi-arrow-left"></i>
                                Cancel
                            </a>
                        </div>
                    </div>
                </section>
            </div>

            <aside class="gp-side">
                <section class="gp-card">
                    <div class="gp-card-head">
                        <span class="gp-card-icon">
                            <i class="bi bi-bar-chart-line-fill"></i>
                        </span>
                        <div>
                            <h3 class="gp-card-title">Partner Overview</h3>
                            <small class="gp-card-subtitle">Current partner information</small>
                        </div>
                    </div>

                    <div class="gp-card-body">
                        <div class="gp-meta">
                            <div class="gp-meta-item">
                                <span class="gp-meta-label">Partner ID</span>
                                <span class="gp-meta-value">#{{ $partner->id }}</span>
                            </div>

                            <div class="gp-meta-item">
                                <span class="gp-meta-label">Order</span>
                                <span class="gp-meta-value">{{ $partner->sort_order }}</span>
                            </div>
                        </div>

                        <div class="gp-info">
                            <div class="gp-info-title">
                                <i class="bi bi-info-circle-fill"></i>
                                Homepage Visibility
                            </div>

                            <p>
                                The partner appears in the homepage marquee only when its status
                                is active. Use the display order to control its sequence.
                            </p>
                        </div>
                    </div>
                </section>

                <section class="gp-card">
                    <div class="gp-card-head">
                        <span class="gp-card-icon">
                            <i class="bi bi-shield-check"></i>
                        </span>
                        <div>
                            <h3 class="gp-card-title">Logo Guidelines</h3>
                            <small class="gp-card-subtitle">Keep the marquee presentation clean</small>
                        </div>
                    </div>

                    <div class="gp-card-body">
                        <div class="gp-info">
                            <div class="gp-info-title">
                                <i class="bi bi-stars"></i>
                                Recommended
                            </div>

                            <p>
                                Use the official university logo in high resolution.
                                Transparent PNG or SVG works best against the homepage marquee background.
                            </p>
                        </div>
                    </div>
                </section>
            </aside>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('partnerLogoInput');
    const preview = document.getElementById('partnerLogoPreview');
    const caption = document.getElementById('logoCaption');

    input?.addEventListener('change', function () {
        const file = this.files?.[0];

        if (!file) {
            return;
        }

        const reader = new FileReader();

        reader.onload = function (event) {
            preview.src = event.target.result;
            caption.textContent = 'New Logo Preview';
        };

        reader.readAsDataURL(file);
    });
});
</script>
@endpush
@endsection
