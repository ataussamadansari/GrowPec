@extends('admin.layout')
@section('title', 'Edit College: ' . $college->name . ' - GrowPec Admin')
@section('header', 'Edit College: ' . $college->name)

@section('content')

<style>
/* =========================================================
   GrowPec Admin - Edit College
   Width-first responsive layout
   ========================================================= */
.ge-edit-page,
.ge-edit-page * {
    box-sizing: border-box;
}

.ge-edit-page {
    overflow-x:hidden;
    --gp-navy:#002B67;
    --gp-navy-dark:#001B45;
    --gp-blue:#174B8F;
    --gp-green:#008A43;
    --gp-green-dark:#006B35;
    --gp-gold:#D9A400;
    --gp-border:#E1E8F0;
    --gp-text:#172033;
    --gp-muted:#6B778C;
    width:100%;
    max-width:none;
    min-width:0;
    margin:0;
    padding:0 0 28px;
}

.ge-edit-hero {
    width:100%;
    margin:0 0 18px;
    padding:24px 26px;
    position:relative;
    overflow:hidden;
    border-radius:17px;
    color:#fff;
    background:linear-gradient(135deg,var(--gp-navy-dark),var(--gp-navy) 58%,var(--gp-blue));
    box-shadow:0 10px 28px rgba(0,43,103,.14);
}

.ge-edit-hero:after {
    content:"";
    position:absolute;
    width:220px;
    height:220px;
    right:-90px;
    bottom:-140px;
    border:1px solid rgba(255,255,255,.15);
    border-radius:50%;
}

.ge-edit-hero > * { position:relative; z-index:1; }

.ge-edit-kicker {
    display:inline-flex;
    align-items:center;
    gap:7px;
    padding:6px 10px;
    border:1px solid rgba(255,255,255,.15);
    border-radius:999px;
    background:rgba(255,255,255,.1);
    font-size:.64rem;
    font-weight:800;
    letter-spacing:.07em;
    text-transform:uppercase;
}

.ge-edit-hero h2 {
    margin:10px 0 4px;
    font-size:1.45rem;
    font-weight:800;
}

.ge-edit-hero p {
    margin:0;
    max-width:900px;
    color:rgba(255,255,255,.76);
    font-size:.74rem;
}

.ge-edit-name {
    display:inline-flex;
    align-items:center;
    gap:6px;
    max-width:100%;
    margin-top:8px;
    padding:5px 9px;
    border:1px solid rgba(255,255,255,.14);
    border-radius:8px;
    background:rgba(255,255,255,.08);
    color:rgba(255,255,255,.9);
    font-size:.64rem;
    font-weight:700;
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
}

/* THIS is the important fix: grid is always based on the actual parent width. */
.ge-edit-layout {
    width:100%;
    max-width:none;
    min-width:0;
    display:grid;
    grid-template-columns:minmax(0,1fr) minmax(290px,350px);
    gap:18px;
    align-items:start;
}

.ge-edit-main,
.ge-edit-side {
    width:100%;
    min-width:0;
    max-width:none;
}

.ge-edit-card {
    width:100%;
    min-width:0;
    margin:0 0 18px;
    padding:0 !important;
    overflow:hidden;
    background:#fff !important;
    border:1px solid var(--gp-border) !important;
    border-radius:15px !important;
    box-shadow:0 7px 22px rgba(20,35,60,.055) !important;
}

.ge-edit-card-head {
    width:100%;
    min-width:0;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    padding:14px 17px;
    border-bottom:1px solid var(--gp-border);
    background:#FCFDFE;
}

.ge-edit-heading {
    min-width:0;
    display:flex;
    align-items:center;
    gap:10px;
}

.ge-edit-icon {
    width:37px;
    height:37px;
    flex:0 0 37px;
    display:grid;
    place-items:center;
    border:1px solid #D6E4F3;
    border-radius:10px;
    background:#EAF2FB;
    color:var(--gp-blue);
}

.ge-edit-title {
    margin:0;
    color:var(--gp-text);
    font-size:.86rem;
    font-weight:800;
}

.ge-edit-sub {
    display:block;
    margin-top:2px;
    color:var(--gp-muted);
    font-size:.6rem;
    font-weight:600;
    line-height:1.35;
}

.ge-edit-body {
    width:100%;
    min-width:0;
    padding:17px;
}

.ge-fields-2 {
    width:100%;
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:12px;
}

.ge-field {
    width:100%;
    min-width:0;
    margin-bottom:13px;
}

.ge-field-full { grid-column:1 / -1; }

.ge-label {
    display:block;
    margin-bottom:6px;
    color:var(--gp-text);
    font-size:.68rem;
    font-weight:800;
}

.ge-control {
    width:100% !important;
    max-width:100%;
    min-width:0;
    min-height:40px;
    border:1px solid #D7E0EA !important;
    border-radius:9px !important;
    background:#fff !important;
    color:var(--gp-text) !important;
    font-size:.71rem !important;
    font-weight:600;
    box-shadow:none !important;
}

.ge-control:focus {
    border-color:var(--gp-blue) !important;
    box-shadow:0 0 0 3px rgba(23,75,143,.08) !important;
}

textarea.ge-control { resize:vertical; }

.ge-file {
    padding:6px 8px;
}

.ge-file::file-selector-button {
    margin:-6px 9px -6px -8px;
    padding:7px 9px;
    border:0;
    border-right:1px solid #D7E0EA;
    background:#F3F6FA;
    color:var(--gp-blue);
    font-size:.64rem;
    font-weight:800;
}

.ge-media-preview {
    width:100%;
    min-width:0;
    margin-top:8px;
}

.ge-media-preview img {
    max-width:100%;
    height:58px;
    object-fit:contain;
    border:1px solid var(--gp-border);
    border-radius:8px;
    background:#fff;
}

.ge-media-preview.banner img {
    width:100%;
    height:60px;
    object-fit:cover;
}

.ge-media-label {
    display:block;
    margin-top:4px;
    color:var(--gp-muted);
    font-size:.59rem;
}

.ge-edit-card .row {
    width:100%;
    max-width:100%;
    margin-left:0;
    margin-right:0;
}

.ge-course-row {
    width:100%;
    min-width:0;
    position:relative;
    margin-bottom:10px !important;
    padding:13px !important;
    border:1px solid #DCE4ED !important;
    border-radius:11px !important;
    background:#FAFBFD !important;
}

.ge-course-row > .row {
    --bs-gutter-x:10px;
    --bs-gutter-y:10px;
    padding-right:30px;
}

.ge-course-row .form-control,
.ge-course-row .form-select {
    width:100%;
    min-width:0;
}

.ge-remove-course {
    width:30px;
    height:30px;
    position:absolute;
    top:9px;
    right:9px;
    z-index:3;
    display:grid;
    place-items:center;
    padding:0;
    border:1px solid #F0C9C5 !important;
    border-radius:8px !important;
    background:#FFF8F7 !important;
    color:#C0392B !important;
}

.ge-add-btn {
    min-height:35px;
    flex:0 0 auto;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:5px;
    padding:0 11px;
    border:1px solid #BFE4CF;
    border-radius:9px;
    background:#F2FBF6;
    color:var(--gp-green-dark);
    font-size:.64rem;
    font-weight:800;
    white-space:nowrap;
}

.ge-add-btn:hover {
    background:var(--gp-green);
    border-color:var(--gp-green);
    color:#fff;
}

.ge-highlight-row {
    width:100%;
    min-width:0;
    display:flex;
    align-items:center;
    gap:7px;
    margin-bottom:8px;
    padding:6px;
    border:1px solid #E1E7EF;
    border-radius:9px;
    background:#FAFBFD;
}

.ge-highlight-row input {
    min-width:0;
    flex:1 1 auto;
}

.ge-star {
    width:31px;
    height:31px;
    flex:0 0 31px;
    display:grid;
    place-items:center;
    border:1px solid var(--gp-border);
    border-radius:7px;
    background:#fff;
}

.ge-remove {
    width:31px;
    height:31px;
    flex:0 0 31px;
    display:grid;
    place-items:center;
    padding:0;
    border:1px solid #F0C9C5;
    border-radius:7px;
    background:#FFF8F7;
    color:#C0392B;
}

.ge-faq-row {
    width:100%;
    min-width:0;
    margin-bottom:8px;
    padding:11px !important;
    border:1px solid #E1E7EF !important;
    border-radius:10px !important;
    background:#FAFBFD !important;
}

.ge-remove-faq {
    padding:0;
    border:0;
    background:none;
    color:#C0392B;
    font-size:.61rem;
    font-weight:700;
}

.ge-side-card {
    width:100%;
    min-width:0;
    margin-bottom:18px;
}

.ge-publish-card {
    position:sticky;
    top:78px;
}

.ge-save {
    width:100%;
    min-height:44px;
    border:1px solid var(--gp-gold);
    border-radius:9px;
    background:var(--gp-gold);
    color:#172033;
    font-size:.72rem;
    font-weight:850;
}

.ge-save:hover {
    background:#B78300;
    color:#fff;
}

.ge-cancel {
    width:100%;
    min-height:38px;
    display:flex;
    align-items:center;
    justify-content:center;
    border:1px solid #D8DEE8;
    border-radius:9px;
    background:#fff;
    color:#526176;
    text-decoration:none;
    font-size:.66rem;
    font-weight:750;
}

@media (max-width:1199px) {
    .ge-edit-layout {
        grid-template-columns:minmax(0,1fr) 300px;
    }
}

@media (max-width:991px) {
    .ge-edit-layout {
        grid-template-columns:minmax(0,1fr);
        gap:12px;
    }

    .ge-edit-side {
        display:grid;
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:12px;
    }

    .ge-edit-side .ge-side-card {
        margin:0;
    }

    .ge-edit-side .ge-side-card:last-child {
        grid-column:1 / -1;
    }

    .ge-publish-card {
        position:static;
    }
}

@media (max-width:767px) {
    .ge-edit-page {
        padding-bottom:16px;
    }

    .ge-edit-hero {
        padding:18px 15px;
        border-radius:13px;
        margin-bottom:12px;
    }

    .ge-edit-hero h2 {
        font-size:1.12rem;
    }

    .ge-edit-hero p {
        font-size:.68rem;
        line-height:1.45;
    }

    .ge-edit-layout {
        width:100%;
        grid-template-columns:minmax(0,1fr);
    }

    .ge-edit-main,
    .ge-edit-side,
    .ge-edit-card {
        width:100%;
        max-width:100%;
    }

    .ge-edit-card {
        margin-bottom:12px;
        border-radius:13px !important;
    }

    .ge-edit-card-head {
        padding:11px 12px;
    }

    .ge-edit-body {
        padding:12px;
    }

    .ge-fields-2 {
        grid-template-columns:minmax(0,1fr);
        gap:0;
    }

    .ge-field-full {
        grid-column:auto;
    }

    .ge-edit-side {
        grid-template-columns:minmax(0,1fr);
    }

    .ge-edit-side .ge-side-card:last-child {
        grid-column:auto;
    }

    .ge-add-btn {
        width:35px;
        min-width:35px;
        height:35px;
        padding:0;
    }

    .ge-add-btn span {
        display:none;
    }

    .ge-course-row {
        padding:11px !important;
    }

    .ge-course-row > .row {
        padding-right:0;
        --bs-gutter-x:8px;
        --bs-gutter-y:8px;
    }

    .ge-course-row .col-md-4 {
        width:100%;
        flex:0 0 100%;
    }

    .ge-remove-course {
        top:8px;
        right:8px;
    }

    .ge-highlight-row {
        padding:5px;
    }
}

@media (max-width:480px) {
    .ge-edit-hero {
        padding:16px 12px;
    }

    .ge-edit-card-head {
        padding:10px;
    }

    .ge-edit-body {
        padding:10px;
    }

    .ge-edit-title {
        font-size:.76rem;
    }

    .ge-edit-sub {
        font-size:.55rem;
    }

    .ge-edit-icon {
        width:33px;
        height:33px;
        flex-basis:33px;
    }

    .ge-control {
        min-height:39px;
        font-size:.68rem !important;
    }

    .ge-star,
    .ge-remove {
        width:29px;
        height:29px;
        flex-basis:29px;
    }
}

/* FINAL WIDTH / PIXEL FIX */
.ge-edit-page {
    display:block !important;
    width:100% !important;
    max-width:none !important;
    min-width:0 !important;
}

.ge-edit-page .ge-edit-layout {
    display:grid !important;
    width:100% !important;
    max-width:none !important;
    min-width:0 !important;
    grid-template-columns:minmax(0,1fr) !important;
    gap:18px !important;
}

.ge-edit-page .ge-edit-main,
.ge-edit-page .ge-edit-side,
.ge-edit-page .ge-edit-card {
    width:100% !important;
    max-width:none !important;
    min-width:0 !important;
}

.ge-edit-page .ge-edit-side {
    display:block !important;
}

.ge-edit-page .ge-edit-side .ge-side-card {
    width:100% !important;
    margin-bottom:18px !important;
}

.ge-edit-page .ge-edit-side .ge-side-card:last-child {
    margin-bottom:0 !important;
}

.ge-edit-page .ge-course-row,
.ge-edit-page #coursesContainer,
.ge-edit-page #highlightsContainer,
.ge-edit-page #faqsContainer {
    width:100% !important;
    max-width:none !important;
    min-width:0 !important;
}

.ge-edit-page .ge-course-row .row {
    width:100% !important;
    max-width:none !important;
}

/* Only wide desktop gets the side column. */
@media (min-width:1200px) {
    .ge-edit-page .ge-edit-layout {
        grid-template-columns:minmax(0,1fr) 330px !important;
    }

    .ge-edit-page .ge-edit-side {
        display:block !important;
    }

    .ge-edit-page .ge-publish-card {
        position:sticky !important;
        top:78px !important;
    }
}

/* Tablet and everything below: absolutely no side-by-side page columns. */
@media (max-width:1199.98px) {
    .ge-edit-page .ge-edit-layout {
        grid-template-columns:minmax(0,1fr) !important;
    }

    .ge-edit-page .ge-edit-side {
        display:block !important;
    }

    .ge-edit-page .ge-edit-side .ge-side-card {
        width:100% !important;
    }

    .ge-edit-page .ge-publish-card {
        position:static !important;
    }
}

@media (max-width:767.98px) {
    .ge-edit-page {
        width:100% !important;
        padding-left:0 !important;
        padding-right:0 !important;
    }

    .ge-edit-page .ge-edit-layout,
    .ge-edit-page .ge-edit-main,
    .ge-edit-page .ge-edit-side,
    .ge-edit-page .ge-edit-card {
        width:100% !important;
        max-width:100% !important;
    }

    .ge-edit-page .ge-fields-2 {
        grid-template-columns:minmax(0,1fr) !important;
    }

    .ge-edit-page .ge-course-row .row {
        display:grid !important;
        grid-template-columns:minmax(0,1fr) !important;
        gap:9px !important;
    }

    .ge-edit-page .ge-course-row .row > [class*="col-"] {
        width:100% !important;
        max-width:100% !important;
        flex:none !important;
        min-width:0 !important;
    }

    .ge-edit-page .ge-course-row .row {
        padding-right:0 !important;
    }
}

</style>

<div class="ge-edit-page">
<div class="ge-edit-hero">
    <span class="ge-edit-kicker"><i class="bi bi-pencil-square"></i> College Management</span>
    <h2>Edit College</h2>
    <p>Update academic programs, location, placements, facilities, highlights and FAQs.</p>
    <div class="ge-edit-name"><i class="bi bi-building"></i> {{ $college->name }}</div>
</div>
<form action="{{ route('admin.colleges.update', $college->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="ge-edit-layout">
<div class="ge-edit-main">
<div class="ge-edit-card">
                <div class="ge-edit-card-head"><div class="ge-edit-heading"><span class="ge-edit-icon"><i class="bi bi-building-fill"></i></span><div><h3 class="ge-edit-title">Basic College Information</h3><small class="ge-edit-sub">Core identity, mode and branding details</small></div></div></div><div class="ge-edit-body">

                <div class="mb-3">
                    <label class="form-label small fw-bold">College Name *</label>
                    <input type="text" name="name" value="{{ old('name', $college->name) }}" class="form-control ge-control" required>
                </div>
                <div class="ge-fields-2">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">College Mode *</label>
                        <select name="college_mode" id="modeSelect" class="form-select fw-bold ge-control" required>
                            <option value="regular" {{ old('college_mode', $college->college_mode) == 'regular' ? 'selected' : '' }}>Regular Campus College</option>
                            <option value="online" {{ old('college_mode', $college->college_mode) == 'online' ? 'selected' : '' }}>100% Online & Distance University</option>
                            <option value="both" {{ old('college_mode', $college->college_mode) == 'both' ? 'selected' : '' }}>Both (Regular & Online)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Ownership / Type *</label>
                        <select name="college_type" class="form-select ge-control" required>
                            <option value="Private" {{ old('college_type', $college->college_type) == 'Private' ? 'selected' : '' }}>Private University</option>
                            <option value="Govt" {{ old('college_type', $college->college_type) == 'Govt' ? 'selected' : '' }}>Government University</option>
                            <option value="Deemed" {{ old('college_type', $college->college_type) == 'Deemed' ? 'selected' : '' }}>Deemed University</option>
                            <option value="Autonomous" {{ old('college_type', $college->college_type) == 'Autonomous' ? 'selected' : '' }}>Autonomous Institute</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Affiliated University</label>
                    <input type="text" name="university_name" value="{{ old('university_name', $college->university_name) }}" class="form-control ge-control" placeholder="e.g. UGC Recognized / AKTU Affiliated">
                </div>
<div class="ge-fields-2">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Banner Image</label>
                        <input type="file" name="banner_image" class="form-control form-control-sm ge-control ge-file" accept="image/*">
                        @if($college->banner_image)
                        <div class="mt-2">
                            <img src="{{ $college->banner_url }}" class="rounded border" style="height: 60px; width: 100%; object-fit: cover;" alt="Current Banner">
                            <small class="text-muted d-block mt-1">Current Banner</small>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">College Logo</label>
                        <input type="file" name="logo" class="form-control form-control-sm ge-control ge-file" accept="image/*">
                        @if($college->logo)
                        <div class="mt-2 d-flex align-items-center gap-2">
                            <img src="{{ $college->logo_url }}" class="rounded border p-1" style="width: 50px; height: 50px; object-fit: contain;" alt="Current Logo">
                            <small class="text-muted">Current Logo</small>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="ge-fields-2">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Sample Degree Certificate</label>
                        <input type="file" name="sample_certificate_image" class="form-control form-control-sm ge-control ge-file" accept="image/*">
                        @if($college->certificate_url)
                        <div class="mt-2 d-flex align-items-center gap-2">
                            <img src="{{ $college->certificate_url }}" class="rounded border" style="height: 50px; object-fit: contain;" alt="Current Certificate">
                            <small class="text-muted">Current Certificate Attached</small>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Brochure PDF</label>
                        <input type="file" name="brochure_pdf" class="form-control form-control-sm ge-control ge-file" accept=".pdf">
                        @if($college->brochure_pdf)
                        <div class="mt-2">
                            <a href="{{ asset('storage/' . $college->brochure_pdf) }}" target="_blank" class="btn btn-sm btn-outline-danger py-1">
                                <i class="bi bi-file-earmark-pdf me-1"></i> View Current PDF
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">About / Overview Narrative</label>
                    <textarea name="overview" rows="3" class="form-control ge-control">{{ old('overview', $college->overview) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Admission Process Steps</label>
                    <textarea name="admission_process" rows="3" class="form-control ge-control">{{ old('admission_process', $college->admission_process) }}</textarea>
                </div>
            </div>
<div class="ge-edit-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <div class="ge-edit-heading"><span class="ge-edit-icon"><i class="bi bi-mortarboard-fill"></i></span><div><h3 class="ge-edit-title">Courses, Streams & Specializations</h3><small class="ge-edit-sub">Manage offerings, streams and specializations</small></div></div>
                        <small class="text-muted">Manage offerings, streams & specializations</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-success fw-bold" id="addCourseRowBtn">
                        <i class="bi bi-plus-circle me-1"></i> + Add Course Row
                    </button>
                </div>
                <div class="ge-edit-body">
                <div id="coursesContainer">
                    @forelse($college->collegeCourses as $cc)
                    <div class="ge-course-row course-card-row position-relative"
                        data-initial-course-id="{{ $cc->course_id }}"
                        data-initial-stream-id="{{ $cc->course->stream_id ?? '' }}"
                        data-initial-specialization="{{ $cc->specialization ?? '' }}">
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-course-btn" title="Remove Course">
                            <i class="bi bi-trash"></i>
                        </button>
                        <div class="row g-2 mb-2">
<div class="col-md-4">
                                <label class="form-label small fw-bold">1. Stream</label>
                                <select class="form-select form-select-sm stream-dropdown ge-control">
                                    <option value="">-- All Streams --</option>
                                    @foreach($streams as $st)
                                    <option value="{{ $st->id }}" {{ ($cc->course->stream_id ?? '') == $st->id ? 'selected' : '' }}>{{ $st->name }}</option>
                                    @endforeach
                                </select>
                            </div>
<div class="col-md-4">
                                <label class="form-label small fw-bold">2. Course *</label>
                                <select name="course_ids[]" class="form-select form-select-sm course-dropdown ge-control" required>
                                    <option value="">-- Select Course --</option>
                                    @foreach($courses as $c)
                                    <option value="{{ $c->id }}" data-stream-id="{{ $c->stream_id }}" {{ $cc->course_id == $c->id ? 'selected' : '' }}>
                                        {{ $c->name }} ({{ $c->level }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
<div class="col-md-4">
                                <label class="form-label small fw-bold">3. Specialization</label>
                                <select name="specializations[]" class="form-select form-select-sm specialization-dropdown ge-control">
                                    <option value="">General / Core</option>
                                    @if($cc->course && $cc->course->specializations)
                                    @foreach($cc->course->specializations as $sp)
                                    <option value="{{ $sp->name }}" {{ $cc->specialization == $sp->name ? 'selected' : '' }}>{{ $sp->name }}</option>
                                    @endforeach
                                    @endif
                                    @if($cc->specialization && (!$cc->course || !$cc->course->specializations->contains('name', $cc->specialization)))
                                    <option value="{{ $cc->specialization }}" selected>{{ $cc->specialization }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Fee Amount (₹) *</label>
                                <input type="number" name="fee_amounts[]" value="{{ (int)$cc->fee_amount }}" class="form-control form-control-sm ge-control" placeholder="e.g. 75000" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Fee Frequency</label>
                                <select name="fee_types[]" class="form-select form-select-sm ge-control">
                                    <option value="per_year" {{ $cc->fee_type == 'per_year' ? 'selected' : '' }}>Per Year</option>
                                    <option value="per_semester" {{ $cc->fee_type == 'per_semester' ? 'selected' : '' }}>Per Semester</option>
                                    <option value="total_course" {{ $cc->fee_type == 'total_course' ? 'selected' : '' }}>Total Course</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Eligibility Criteria</label>
                                <input type="text" name="eligibilities[]" value="{{ $cc->eligibility }}" class="form-control form-control-sm ge-control" placeholder="e.g. 10+2 with 50% / Graduation">
                            </div>
                        </div>
                    </div>
                    @empty
<div class="ge-course-row course-card-row position-relative">
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-course-btn"><i class="bi bi-trash"></i></button>
                        <div class="row g-2 mb-2">
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">1. Stream</label>
                                <select class="form-select form-select-sm stream-dropdown ge-control">
                                    <option value="">-- All Streams --</option>
                                    @foreach($streams as $st)
                                    <option value="{{ $st->id }}">{{ $st->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">2. Course *</label>
                                <select name="course_ids[]" class="form-select form-select-sm course-dropdown ge-control" required>
                                    <option value="">-- Select Course --</option>
                                    @foreach($courses as $c)
                                    <option value="{{ $c->id }}" data-stream-id="{{ $c->stream_id }}">{{ $c->name }} ({{ $c->level }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">3. Specialization</label>
                                <select name="specializations[]" class="form-select form-select-sm specialization-dropdown ge-control">
                                    <option value="">General / Core</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Fee Amount (₹) *</label>
                                <input type="number" name="fee_amounts[]" class="form-control form-control-sm ge-control" placeholder="e.g. 50000" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Fee Frequency</label>
                                <select name="fee_types[]" class="form-select form-select-sm ge-control">
                                    <option value="per_year">Per Year</option>
                                    <option value="per_semester">Per Semester</option>
                                    <option value="total_course">Total Course</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Eligibility Criteria</label>
                                <input type="text" name="eligibilities[]" class="form-control form-control-sm ge-control" placeholder="e.g. 10+2">
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
<div class="ge-edit-card">
                <div class="ge-edit-card-head">
                    <div class="ge-edit-heading"><span class="ge-edit-icon"><i class="bi bi-stars"></i></span><div><h3 class="ge-edit-title">Key Highlights / USPs</h3><small class="ge-edit-sub">Strong reasons students should consider this college</small></div></div>
                    <button type="button" class="ge-add-btn" id="addHighlightBtn"><i class="bi bi-plus-circle-fill"></i><span>Add Highlight</span></button>
                </div>
                <div class="ge-edit-body">
                <div id="highlightsContainer">
                    @if(!empty($college->highlights) && count($college->highlights) > 0)
                    @foreach($college->highlights as $hl)
                    <div class="ge-highlight-row highlight-row">
                        <span class="ge-star">⭐</span>
                        <input type="text" name="highlights[]" value="{{ $hl }}" class="form-control form-control-sm ge-control" placeholder="Enter highlight...">
                        <button type="button" class="ge-remove remove-highlight-btn"><i class="bi bi-x"></i></button>
                    </div>
                    @endforeach
                    @else
                    <div class="ge-highlight-row highlight-row">
                        <span class="ge-star">⭐</span>
                        <input type="text" name="highlights[]" class="form-control form-control-sm ge-control" placeholder="e.g. 100% Placement Assistance">
                        <button type="button" class="ge-remove remove-highlight-btn"><i class="bi bi-x"></i></button>
                    </div>
                    @endif
                </div>
            </div>
<div class="ge-edit-card">
                <div class="ge-edit-card-head">
                    <div class="ge-edit-heading"><span class="ge-edit-icon"><i class="bi bi-question-circle-fill"></i></span><div><h3 class="ge-edit-title">Frequently Asked Questions</h3><small class="ge-edit-sub">Answer common student and parent queries</small></div></div>
                    <button type="button" class="ge-add-btn" id="addFaqBtn"><i class="bi bi-plus-circle-fill"></i><span>Add FAQ</span></button>
                </div>
                <div class="ge-edit-body">
                <div id="faqsContainer">
                    @if(!empty($college->faqs) && count($college->faqs) > 0)
                    @foreach($college->faqs as $f)
                    <div class="ge-faq-row faq-row">
                        <input type="text" name="faq_questions[]" value="{{ $f['question'] ?? '' }}" class="form-control form-control-sm mb-2 fw-bold ge-control" placeholder="Question: e.g. Is this degree UGC approved?">
                        <textarea name="faq_answers[]" rows="2" class="form-control form-control-sm ge-control" placeholder="Answer...">{{ $f['answer'] ?? '' }}</textarea>
                        <button type="button" class="ge-remove-faq remove-faq-btn"><small><i class="bi bi-trash"></i> Remove FAQ</small></button>
                    </div>
                    @endforeach
                    @else
                    <div class="ge-faq-row faq-row">
                        <input type="text" name="faq_questions[]" class="form-control form-control-sm mb-2 fw-bold ge-control" placeholder="Question...">
                        <textarea name="faq_answers[]" rows="2" class="form-control form-control-sm ge-control" placeholder="Answer..."></textarea>
                        <button type="button" class="ge-remove-faq remove-faq-btn"><small><i class="bi bi-trash"></i> Remove FAQ</small></button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
<div class="ge-edit-side">
<div class="ge-edit-card">
                <div class="ge-edit-card-head"><div class="ge-edit-heading"><span class="ge-edit-icon"><i class="bi bi-geo-alt-fill"></i></span><div><h3 class="ge-edit-title">Location & Campus</h3><small class="ge-edit-sub">Where the institution is located</small></div></div></div><div class="ge-edit-body">
                <div class="mb-2">
                    <label class="form-label small fw-bold">State *</label>
                    <select name="state" id="stateSelect" class="form-select form-select-sm ge-control" required>
                        <option value="">Select State</option>
                        @foreach($states as $st)
                        <option value="{{ $st->name }}" data-id="{{ $st->id }}" {{ old('state', $college->state) == $st->name ? 'selected' : '' }}>
                            {{ $st->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">City *</label>
                    <select name="city" id="citySelect" class="form-select form-select-sm ge-control" required>
                        <option value="{{ $college->city }}">{{ $college->city }}</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Established Year</label>
                    <input type="text" name="established_year" value="{{ old('established_year', $college->established_year) }}" class="form-control form-control-sm ge-control" placeholder="e.g. 2004">
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Campus Size</label>
                    <input type="text" name="campus_size" value="{{ old('campus_size', $college->campus_size) }}" class="form-control form-control-sm ge-control" placeholder="e.g. 50 Acres">
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Approvals (Badges)</label>
                    <input type="text" name="approvals" value="{{ old('approvals', $college->approvals) }}" class="form-control form-control-sm ge-control" placeholder="UGC, AICTE, NAAC A+">
                </div>
            </div>
<div class="ge-edit-card">
                <div class="ge-edit-card-head"><div class="ge-edit-heading"><span class="ge-edit-icon"><i class="bi bi-briefcase-fill"></i></span><div><h3 class="ge-edit-title">Placements & Hostels</h3><small class="ge-edit-sub">Career outcomes, scholarships and accommodation</small></div></div></div><div class="ge-edit-body">
                <div class="mb-2">
                    <label class="form-label small fw-bold">Highest Package</label>
                    <input type="text" name="highest_package" value="{{ old('highest_package', $college->highest_package) }}" class="form-control form-control-sm ge-control" placeholder="e.g. 18.0 LPA">
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Average Package</label>
                    <input type="text" name="average_package" value="{{ old('average_package', $college->average_package) }}" class="form-control form-control-sm ge-control" placeholder="e.g. 5.5 LPA">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Top Recruiters</label>
                    <input type="text" name="top_recruiters" value="{{ old('top_recruiters', $college->top_recruiters) }}" class="form-control form-control-sm ge-control" placeholder="TCS, Infosys, Wipro, Amazon">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Scholarship Info</label>
                    <textarea name="scholarship_info" rows="2" class="form-control form-control-sm ge-control" placeholder="Merit scholarships...">{{ old('scholarship_info', $college->scholarship_info) }}</textarea>
                </div>
                <div id="hostelFacilitiesWrapper">
                    <label class="form-label small fw-bold d-block">Hostel Facilities</label>
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="checkbox" name="has_boys_hostel" value="1" id="cbBoys" {{ old('has_boys_hostel', $college->has_boys_hostel) ? 'checked' : '' }}>
                        <label class="form-check-label small" for="cbBoys">Boys Hostel Available</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="has_girls_hostel" value="1" id="cbGirls" {{ old('has_girls_hostel', $college->has_girls_hostel) ? 'checked' : '' }}>
                        <label class="form-check-label small" for="cbGirls">Girls Hostel Available</label>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-warning py-2 fw-bold shadow-sm">
                        <i class="bi bi-check-circle me-1"></i> Update College Details
                    </button>
                    <a href="{{ route('admin.colleges.index') }}" class="btn btn-outline-secondary btn-sm">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
</div>

<script id="streamsJsonEdit" type="application/json">
    @json($streams)
</script>
<script id="coursesJsonEdit" type="application/json">
    @json($courses)
</script>

@push('scripts')
<script>
    const streamsData = JSON.parse(document.getElementById('streamsJsonEdit').textContent || '[]');
    const coursesData = JSON.parse(document.getElementById('coursesJsonEdit').textContent || '[]');

    function setupCascadeRow(row) {
        const streamSelect = row.querySelector('.stream-dropdown');
        const courseSelect = row.querySelector('.course-dropdown');
        const specSelect = row.querySelector('.specialization-dropdown');

        // 1. Stream filter -> updates course dropdown
        streamSelect.addEventListener('change', function() {
            const streamId = this.value;
            const currentCourseVal = courseSelect.value;

            let filteredCourses = coursesData;
            if (streamId) {
                filteredCourses = coursesData.filter(c => c.stream_id == streamId);
            }

            courseSelect.innerHTML = '<option value="">-- Select Course --</option>';
            filteredCourses.forEach(c => {
                const isSelected = (c.id == currentCourseVal) ? 'selected' : '';
                courseSelect.innerHTML += `<option value="${c.id}" data-stream-id="${c.stream_id}" ${isSelected}>${c.name} (${c.level})</option>`;
            });

            // Trigger change to refresh specializations
            courseSelect.dispatchEvent(new Event('change'));
        });

        // 2. Course change -> populates specializations
        courseSelect.addEventListener('change', function() {
            const courseId = this.value;
            const currentSpecVal = specSelect.value || row.getAttribute('data-initial-specialization');

            if (!courseId) {
                specSelect.innerHTML = '<option value="">General / Core</option>';
                return;
            }

            const selectedCourse = coursesData.find(c => c.id == courseId);
            if (selectedCourse) {
                // Sync stream if not selected
                if (selectedCourse.stream_id && !streamSelect.value) {
                    streamSelect.value = selectedCourse.stream_id;
                }

                specSelect.innerHTML = '<option value="">General / Core</option>';
                let foundMatch = false;

                if (selectedCourse.specializations && selectedCourse.specializations.length > 0) {
                    selectedCourse.specializations.forEach(s => {
                        if (s.status) {
                            const isSelected = (currentSpecVal && currentSpecVal.toLowerCase() === s.name.toLowerCase()) ? 'selected' : '';
                            if (isSelected) foundMatch = true;
                            specSelect.innerHTML += `<option value="${s.name}" ${isSelected}>${s.name}</option>`;
                        }
                    });
                }

                // If existing custom specialization is not in the list, preserve it as an option
                if (currentSpecVal && !foundMatch && currentSpecVal !== 'General / Core') {
                    specSelect.innerHTML += `<option value="${currentSpecVal}" selected>${currentSpecVal}</option>`;
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Setup cascading for all rows on Edit load
        document.querySelectorAll('.course-card-row').forEach(row => setupCascadeRow(row));

        // Dynamic State -> City loading on Edit page
        const stateSelect = document.getElementById('stateSelect');
        const citySelect = document.getElementById('citySelect');
        const currentCity = "{{ $college->city }}";

        function loadCities(stateId, selectedCity = null) {
            if (!stateId) return;
            fetch(`/api/states/${stateId}/cities`)
                .then(res => res.json())
                .then(cities => {
                    citySelect.innerHTML = '<option value="">Choose City</option>';
                    cities.forEach(c => {
                        const isSelected = (selectedCity && selectedCity === c.name) ? 'selected' : '';
                        citySelect.innerHTML += `<option value="${c.name}" ${isSelected}>${c.name}</option>`;
                    });
                })
                .catch(() => {
                    citySelect.innerHTML = '<option value="">Error loading cities</option>';
                });
        }

        if (stateSelect) {
            stateSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const stateId = selectedOption ? selectedOption.getAttribute('data-id') : null;
                citySelect.innerHTML = '<option value="">Loading cities...</option>';
                loadCities(stateId);
            });

            const initialOpt = stateSelect.options[stateSelect.selectedIndex];
            if (initialOpt && initialOpt.getAttribute('data-id')) {
                loadCities(initialOpt.getAttribute('data-id'), currentCity);
            }
        }

        // Add Course Row
        document.getElementById('addCourseRowBtn')?.addEventListener('click', function() {
            const container = document.getElementById('coursesContainer');
            const firstRow = container.querySelector('.course-card-row');
            if (firstRow) {
                const clone = firstRow.cloneNode(true);
                clone.removeAttribute('data-initial-course-id');
                clone.removeAttribute('data-initial-stream-id');
                clone.removeAttribute('data-initial-specialization');
                clone.querySelectorAll('input').forEach(i => i.value = '');
                clone.querySelectorAll('select').forEach(s => s.selectedIndex = 0);

                // Re-populate all courses into cloned select
                const courseSelect = clone.querySelector('.course-dropdown');
                courseSelect.innerHTML = '<option value="">-- Select Course --</option>';
                coursesData.forEach(c => {
                    courseSelect.innerHTML += `<option value="${c.id}" data-stream-id="${c.stream_id}">${c.name} (${c.level})</option>`;
                });

                container.appendChild(clone);
                setupCascadeRow(clone);
            }
        });

        // Add Highlight & FAQ listeners
        document.getElementById('addHighlightBtn')?.addEventListener('click', function() {
            const container = document.getElementById('highlightsContainer');
            const div = document.createElement('div');
            div.className = 'ge-highlight-row highlight-row';
            div.innerHTML = `
            <span class="ge-star">⭐</span>
            <input type="text" name="highlights[]" class="form-control form-control-sm ge-control" placeholder="Enter highlight...">
            <button type="button" class="ge-remove remove-highlight-btn"><i class="bi bi-x"></i></button>
        `;
            container.appendChild(div);
        });

        document.getElementById('addFaqBtn')?.addEventListener('click', function() {
            const container = document.getElementById('faqsContainer');
            const div = document.createElement('div');
            div.className = 'ge-faq-row faq-row';
            div.innerHTML = `
            <input type="text" name="faq_questions[]" class="form-control form-control-sm mb-2 fw-bold ge-control" placeholder="Question...">
            <textarea name="faq_answers[]" rows="2" class="form-control form-control-sm ge-control" placeholder="Answer..."></textarea>
            <button type="button" class="ge-remove-faq remove-faq-btn"><small><i class="bi bi-trash"></i> Remove FAQ</small></button>
        `;
            container.appendChild(div);
        });

        // Global removal listener
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-course-btn')) {
                const rows = document.querySelectorAll('.course-card-row');
                if (rows.length > 1) {
                    e.target.closest('.course-card-row').remove();
                } else {
                    alert('At least one course entry is required.');
                }
            }
            if (e.target.closest('.remove-highlight-btn')) {
                e.target.closest('.highlight-row').remove();
            }
            if (e.target.closest('.remove-faq-btn')) {
                e.target.closest('.faq-row').remove();
            }
        });
    });
</script>
@endpush
@endsection