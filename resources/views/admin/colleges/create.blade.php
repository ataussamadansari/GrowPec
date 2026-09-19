@extends('admin.layout')
@section('title', 'Add New College - GrowPec Admin')
@section('header', 'Add New College')

@section('content')

@if ($errors->any())
<div class="alert alert-danger mb-3" role="alert">
    <strong>College save nahi hua.</strong>
    <ul class="mb-0 mt-2">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<style>
    :root {
        --gp-navy: #002B67;
        --gp-navy-dark: #001B45;
        --gp-blue: #174B8F;
        --gp-green: #008A43;
        --gp-green-dark: #006B35;
        --gp-gold: #D9A400;
        --gp-gold-dark: #B78300;
        --gp-border: #E2E8F0;
        --gp-text: #172033;
        --gp-muted: #68758A;
        --gp-soft: #F6F8FB;
    }

    .gc-page,
    .gc-page * {
        box-sizing: border-box
    }

    .gc-page {
        width: 100%;
        max-width: 1600px;
        margin: 0 auto;
        padding: 0
    }

    .gc-hero {
        position: relative;
        overflow: hidden;
        margin: 0 0 16px;
        padding: 22px 24px;
        border-radius: 17px;
        color: #fff;
        background: radial-gradient(circle at 92% 15%, rgba(217, 164, 0, .18), transparent 27%), linear-gradient(135deg, var(--gp-navy-dark), var(--gp-navy) 56%, var(--gp-blue));
        box-shadow: 0 10px 26px rgba(0, 43, 103, .14)
    }

    .gc-hero:after {
        content: "";
        position: absolute;
        width: 190px;
        height: 190px;
        right: -70px;
        bottom: -115px;
        border: 1px solid rgba(255, 255, 255, .13);
        border-radius: 50%;
        box-shadow: 0 0 0 32px rgba(255, 255, 255, .035)
    }

    .gc-hero-content {
        position: relative;
        z-index: 1
    }

    .gc-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 9px;
        border: 1px solid rgba(255, 255, 255, .15);
        border-radius: 999px;
        background: rgba(255, 255, 255, .1);
        font-size: .62rem;
        font-weight: 800;
        letter-spacing: .07em;
        text-transform: uppercase
    }

    .gc-hero h2 {
        margin: 10px 0 4px;
        font-size: 1.35rem;
        font-weight: 800;
        letter-spacing: -.02em
    }

    .gc-hero p {
        margin: 0;
        max-width: 850px;
        color: rgba(255, 255, 255, .76);
        font-size: .72rem;
        line-height: 1.45
    }

    .gc-layout {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
        align-items: start
    }

    .gc-main,
    .gc-side {
        min-width: 0
    }

    .gc-card {
        margin: 0 0 16px;
        background: #fff;
        border: 1px solid var(--gp-border);
        border-radius: 15px;
        box-shadow: 0 7px 22px rgba(20, 35, 60, .055);
        overflow: hidden
    }

    .gc-card:last-child,
    .gc-side .gc-card:last-child {
        margin-bottom: 0
    }

    .gc-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 13px 16px;
        border-bottom: 1px solid var(--gp-border);
        background: #fcfdfe
    }

    .gc-card-heading {
        display: flex;
        align-items: center;
        gap: 9px;
        min-width: 0
    }

    .gc-card-icon {
        width: 36px;
        height: 36px;
        flex: 0 0 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        color: var(--gp-blue);
        background: #eaf2fb;
        border: 1px solid #d7e5f4;
        font-size: .9rem
    }

    .gc-card-title {
        margin: 0;
        color: var(--gp-text);
        font-size: .8rem;
        font-weight: 800;
        line-height: 1.2
    }

    .gc-card-subtitle {
        display: block;
        margin-top: 2px;
        color: var(--gp-muted);
        font-size: .59rem;
        font-weight: 600;
        line-height: 1.3
    }

    .gc-card-body {
        padding: 16px
    }

    .gc-grid-2 {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px
    }

    .gc-field {
        min-width: 0;
        margin: 0 0 13px
    }

    .gc-field:last-child {
        margin-bottom: 0
    }

    .gc-label {
        display: flex;
        align-items: center;
        gap: 5px;
        margin: 0 0 5px;
        color: var(--gp-text);
        font-size: .66rem;
        font-weight: 800;
        line-height: 1.25
    }

    .gc-label i {
        color: var(--gp-green)
    }

    .gc-required {
        color: #c0392b
    }

    .gc-control {
        width: 100%;
        min-width: 0;
        min-height: 39px;
        padding: 7px 10px;
        border: 1px solid #d8e0ea !important;
        border-radius: 8px !important;
        background: #fff !important;
        color: var(--gp-text) !important;
        font-size: .68rem !important;
        font-weight: 600;
        box-shadow: none !important
    }

    .gc-control:focus {
        border-color: var(--gp-blue) !important;
        box-shadow: 0 0 0 3px rgba(23, 75, 143, .08) !important
    }

    textarea.gc-control {
        min-height: 78px;
        resize: vertical
    }

    .gc-upload {
        padding: 6px 8px
    }

    .gc-upload::file-selector-button {
        margin: -6px 9px -6px -8px;
        padding: 7px 9px;
        border: 0;
        border-right: 1px solid #d8e0ea;
        background: #f3f6fa;
        color: var(--gp-blue);
        font-size: .63rem;
        font-weight: 800
    }

    .gc-card-header .gc-add-btn {
        flex: 0 0 auto
    }

    .gc-add-btn {
        min-height: 34px;
        padding: 0 10px;
        border: 1px solid #bfe4cf;
        border-radius: 8px;
        background: #f2fbf6;
        color: var(--gp-green-dark);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        font-size: .63rem;
        font-weight: 800;
        white-space: nowrap;
        transition: .18s
    }

    .gc-add-btn:hover {
        background: var(--gp-green);
        border-color: var(--gp-green);
        color: #fff
    }

    .gc-course-row {
        position: relative;
        margin: 0 0 10px;
        padding: 12px !important;
        border: 1px solid #dfe6ee !important;
        border-radius: 11px !important;
        background: #fafbfd !important
    }

    .gc-course-row:last-child {
        margin-bottom: 0
    }

    .gc-course-row .row {
        --bs-gutter-x: 10px;
        --bs-gutter-y: 10px
    }

    .gc-remove-course {
        position: absolute;
        right: 9px;
        top: 9px;
        z-index: 2;
        width: 29px;
        height: 29px;
        padding: 0;
        border: 1px solid #f0c9c5;
        border-radius: 7px;
        background: #fff8f7;
        color: #c0392b;
        display: inline-flex;
        align-items: center;
        justify-content: center
    }

    .gc-remove-course:hover {
        background: #c0392b;
        color: #fff;
        border-color: #c0392b
    }

    .gc-repeat-row {
        display: flex;
        align-items: stretch;
        margin: 0 0 8px;
        padding: 0;
        border: 1px solid #e1e7ef;
        border-radius: 9px;
        overflow: hidden;
        background: #fafbfd
    }

    .gc-repeat-row .input-group-text {
        border: 0;
        border-right: 1px solid #e1e7ef;
        background: #f6f8fb
    }

    .gc-repeat-row .gc-control {
        border: 0 !important;
        border-radius: 0 !important
    }

    .gc-repeat-row .remove-highlight-btn {
        border: 0;
        border-left: 1px solid #f0c9c5;
        border-radius: 0;
        color: #c0392b;
        background: #fff
    }

    .gc-faq-row {
        margin: 0 0 8px;
        padding: 10px;
        border: 1px solid #e1e7ef;
        border-radius: 9px;
        background: #fafbfd
    }

    .gc-remove-link {
        padding: 0 !important;
        color: #c0392b !important;
        font-size: .61rem;
        font-weight: 750
    }

    .gc-side-card {
        margin: 0 0 16px;
        background: #fff;
        border: 1px solid var(--gp-border);
        border-radius: 15px;
        box-shadow: 0 7px 22px rgba(20, 35, 60, .055);
        overflow: hidden
    }

    .gc-publish-card {
        position: sticky;
        top: 72px
    }

    .gc-save-btn {
        width: 100%;
        min-height: 44px;
        border: 1px solid var(--gp-gold);
        border-radius: 9px;
        background: var(--gp-gold);
        color: #152033;
        font-size: .7rem;
        font-weight: 850;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: .18s
    }

    .gc-save-btn:hover {
        background: var(--gp-gold-dark);
        border-color: var(--gp-gold-dark);
        color: #fff;
        transform: translateY(-1px)
    }

    .gc-check {
        margin-bottom: 7px
    }

    .gc-check .form-check-input {
        box-shadow: none !important;
        border-color: #bfc9d7
    }

    .gc-check .form-check-input:checked {
        background-color: var(--gp-green);
        border-color: var(--gp-green)
    }

    .gc-check .form-check-label {
        color: #526176;
        font-size: .65rem;
        font-weight: 650
    }

    .gc-mini-note {
        display: flex;
        gap: 7px;
        margin-top: 10px;
        padding: 9px;
        border-radius: 8px;
        background: #f3fbf7;
        border: 1px solid #dcefe5;
        color: #476454;
        font-size: .59rem;
        line-height: 1.4
    }

    .gc-mini-note i {
        color: var(--gp-green)
    }

    @container (min-width: 1180px) {
        .gc-layout {
            grid-template-columns: minmax(0, 1fr) 340px
        }
    }

    @media (min-width: 1280px) {
        .gc-page {
            container-type: inline-size
        }
    }

    @media (max-width: 767.98px) {
        .gc-page {
            max-width: none
        }

        .gc-hero {
            padding: 18px 16px;
            border-radius: 13px;
            margin-bottom: 12px
        }

        .gc-hero h2 {
            font-size: 1.12rem
        }

        .gc-hero p {
            font-size: .66rem
        }

        .gc-card,
        .gc-side-card {
            margin-bottom: 12px;
            border-radius: 12px
        }

        .gc-card-header {
            padding: 11px 12px;
            gap: 8px
        }

        .gc-card-body {
            padding: 12px
        }

        .gc-card-icon {
            width: 33px;
            height: 33px;
            flex-basis: 33px
        }

        .gc-card-title {
            font-size: .74rem
        }

        .gc-card-subtitle {
            font-size: .56rem
        }

        .gc-grid-2 {
            grid-template-columns: 1fr;
            gap: 0
        }

        .gc-card-header .gc-add-btn {
            width: 34px;
            min-width: 34px;
            padding: 0
        }

        .gc-card-header .gc-add-btn span {
            display: none
        }

        .gc-control {
            min-height: 38px;
            font-size: .66rem !important
        }

        .gc-course-row {
            padding: 10px !important
        }

        .gc-course-row .row {
            --bs-gutter-x: 7px;
            --bs-gutter-y: 8px
        }

        .gc-repeat-row {
            min-width: 0
        }

        .gc-publish-card {
            position: static
        }
    }

    @media (max-width: 420px) {
        .gc-hero {
            padding: 16px 13px
        }

        .gc-card-header {
            align-items: flex-start
        }

        .gc-card-body {
            padding: 10px
        }

        .gc-card-title {
            font-size: .7rem
        }

        .gc-label {
            font-size: .63rem
        }

        .gc-control {
            font-size: .62rem !important
        }

        .gc-add-btn {
            height: 32px
        }
    }
</style>
<div class="gc-page">
    <div class="gc-hero">
        <div class="gc-hero-content">
            <span class="gc-eyebrow"><i class="bi bi-building-add"></i> College Management</span>
            <h2>Add New College</h2>
            <p>Create a complete college profile with academic programs, location, placements, facilities, highlights and FAQs.</p>
        </div>
    </div>

    <form action="{{ route('admin.colleges.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="gc-layout">
            <main class="gc-main">

                <section class="gc-card">
                    <div class="gc-card-header">
                        <div class="gc-card-heading">
                            <span class="gc-card-icon"><i class="bi bi-building-fill"></i></span>
                            <div>
                                <h3 class="gc-card-title">Basic College Information</h3><small class="gc-card-subtitle">Core identity, mode and branding details</small>
                            </div>
                        </div>
                    </div>
                    <div class="gc-card-body">
                        <div class="gc-field">
                            <label class="gc-label">College Name <span class="gc-required">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" class="gc-control" placeholder="e.g. Amity University / Ganpat University Online" required>
                        </div>

                        <div class="gc-grid-2">
                            <div class="gc-field">
                                <label class="gc-label">College Mode <span class="gc-required">*</span></label>
                                <select name="college_mode" id="modeSelect" class="gc-control" required>
                                    <option value="regular">Regular Campus College</option>
                                    <option value="online">100% Online & Distance University</option>
                                    <option value="both">Both (Regular & Online)</option>
                                </select>
                            </div>
                            <div class="gc-field">
                                <label class="gc-label">Ownership / Type <span class="gc-required">*</span></label>
                                <select name="college_type" class="gc-control" required>
                                    <option value="Private">Private University</option>
                                    <option value="Govt">Government University</option>
                                    <option value="Deemed">Deemed University</option>
                                    <option value="Autonomous">Autonomous Institute</option>
                                </select>
                            </div>
                        </div>

                        <div class="gc-field">
                            <label class="gc-label">Affiliated University</label>
                            <input type="text" name="university_name" value="{{ old('university_name') }}" class="gc-control" placeholder="e.g. UGC Recognized / AKTU Affiliated">
                        </div>

                        <div class="gc-grid-2">
                            <div class="gc-field"><label class="gc-label">Banner Image</label><input type="file" name="banner_image" class="gc-control gc-upload" accept="image/*"></div>
                            <div class="gc-field"><label class="gc-label">College Logo</label><input type="file" name="logo" class="gc-control gc-upload" accept="image/*"></div>
                            <div class="gc-field"><label class="gc-label">Sample Degree Certificate</label><input type="file" name="sample_certificate_image" class="gc-control gc-upload" accept="image/*"></div>
                            <div class="gc-field"><label class="gc-label">Brochure (PDF)</label><input type="file" name="brochure_pdf" class="gc-control gc-upload" accept=".pdf"></div>
                        </div>

                        <div class="gc-field">
                            <label class="gc-label">About / Overview Narrative</label>
                            <textarea name="overview" rows="3" class="gc-control" placeholder="Write university background, vision, faculty...">{{ old('overview') }}</textarea>
                        </div>
                        <div class="gc-field">
                            <label class="gc-label">Admission Process Steps</label>
                            <textarea name="admission_process" rows="3" class="gc-control" placeholder="Step 1: Application, Step 2: Verification...">{{ old('admission_process') }}</textarea>
                        </div>
                    </div>
                </section>

                <section class="gc-card">
                    <div class="gc-card-header">
                        <div class="gc-card-heading">
                            <span class="gc-card-icon"><i class="bi bi-mortarboard-fill"></i></span>
                            <div>
                                <h3 class="gc-card-title">Courses, Streams & Specializations</h3><small class="gc-card-subtitle">Select Stream → Course → Specialization with fee details</small>
                            </div>
                        </div>
                        <button type="button" class="gc-add-btn" id="addCourseRowBtn"><i class="bi bi-plus-circle-fill"></i><span>Add Course Row</span></button>
                    </div>
                    <div class="gc-card-body">
                        <div id="coursesContainer">
                            <div class="course-card-row gc-course-row">
                                <button type="button" class="gc-remove-course remove-course-btn" title="Remove Course"><i class="bi bi-trash"></i></button>
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="gc-field">
                                            <label class="gc-label">1. Stream</label>
                                            <select class="form-select form-select-sm gc-control stream-dropdown">
                                                <option value="">-- All Streams --</option>
                                                @foreach($streams as $st)
                                                <option value="{{ $st->id }}">{{ $st->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="gc-field">
                                            <label class="gc-label">2. Course <span class="gc-required">*</span></label>
                                            <select name="course_ids[]" class="form-select form-select-sm gc-control course-dropdown" required>
                                                <option value="">-- Select Course --</option>
                                                @foreach($courses as $c)
                                                <option value="{{ $c->id }}" data-stream-id="{{ $c->stream_id }}">{{ $c->name }} ({{ $c->level }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="gc-field">
                                            <label class="gc-label">3. Specialization</label>
                                            <select name="specializations[]" class="form-select form-select-sm gc-control specialization-dropdown">
                                                <option value="">General / Core</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="gc-field">
                                            <label class="gc-label">Fee Amount (₹) <span class="gc-required">*</span></label>
                                            <input type="number" name="fee_amounts[]" class="gc-control" placeholder="e.g. 75000" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="gc-field">
                                            <label class="gc-label">Fee Frequency</label>
                                            <select name="fee_types[]" class="gc-control">
                                                <option value="per_year">Per Year</option>
                                                <option value="per_semester">Per Semester</option>
                                                <option value="total_course">Total Course</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="gc-field">
                                            <label class="gc-label">Eligibility Criteria</label>
                                            <input type="text" name="eligibilities[]" class="gc-control" placeholder="e.g. 10+2 with 50% / Graduation">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="gc-card">
                    <div class="gc-card-header">
                        <div class="gc-card-heading">
                            <span class="gc-card-icon"><i class="bi bi-stars"></i></span>
                            <div>
                                <h3 class="gc-card-title">Key Highlights / USPs</h3><small class="gc-card-subtitle">Add the strongest reasons students should consider this college</small>
                            </div>
                        </div>
                        <button type="button" class="gc-add-btn" id="addHighlightBtn"><i class="bi bi-plus-circle-fill"></i><span>Add Highlight</span></button>
                    </div>
                    <div class="gc-card-body">
                        <div id="highlightsContainer">
                            <div class="gc-repeat-row highlight-row">
                                <span class="input-group-text">⭐</span>
                                <input type="text" name="highlights[]" class="gc-control" placeholder="e.g. 100% Placement & Interview Training Assistance">
                                <button type="button" class="remove-highlight-btn" title="Remove"><i class="bi bi-x"></i></button>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="gc-card">
                    <div class="gc-card-header">
                        <div class="gc-card-heading">
                            <span class="gc-card-icon"><i class="bi bi-question-circle-fill"></i></span>
                            <div>
                                <h3 class="gc-card-title">Frequently Asked Questions</h3><small class="gc-card-subtitle">Answer common student and parent queries</small>
                            </div>
                        </div>
                        <button type="button" class="gc-add-btn" id="addFaqBtn"><i class="bi bi-plus-circle-fill"></i><span>Add FAQ</span></button>
                    </div>
                    <div class="gc-card-body">
                        <div id="faqsContainer">
                            <div class="gc-faq-row faq-row">
                                <input type="text" name="faq_questions[]" class="gc-control mb-2" placeholder="Question: e.g. Is this degree UGC approved?">
                                <textarea name="faq_answers[]" rows="2" class="gc-control mb-1" placeholder="Answer: e.g. Yes, all degrees are fully approved and recognized..."></textarea>
                                <button type="button" class="btn btn-sm text-danger p-0 remove-faq-btn"><small><i class="bi bi-trash"></i> Remove FAQ</small></button>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

            <aside class="gc-side">
                <section class="gc-side-card">
                    <div class="gc-card-header">
                        <div class="gc-card-heading">
                            <span class="gc-card-icon"><i class="bi bi-geo-alt-fill"></i></span>
                            <div>
                                <h3 class="gc-card-title">Location & Campus</h3><small class="gc-card-subtitle">Where the institution is located</small>
                            </div>
                        </div>
                    </div>
                    <div class="gc-card-body">
                        <div class="gc-field"><label class="gc-label">State <span class="gc-required">*</span></label>
                            <select name="state" id="stateSelect" class="gc-control" required>
                                <option value="">Select State</option>
                                @foreach($states as $st)<option value="{{ $st->name }}" data-id="{{ $st->id }}" {{ old('state') == $st->name ? 'selected' : '' }}>{{ $st->name }}</option>@endforeach
                            </select>
                        </div>
                        <div class="gc-field"><label class="gc-label">City <span class="gc-required">*</span></label>
                            <select name="city" id="citySelect" class="gc-control" required>
                                <option value="">Choose State First</option>
                            </select>
                        </div>
                        <div class="gc-field"><label class="gc-label">Established Year</label><input type="text" name="established_year" value="{{ old('established_year') }}" class="gc-control" placeholder="e.g. 2004"></div>
                        <div class="gc-field"><label class="gc-label">Campus Size</label><input type="text" name="campus_size" value="{{ old('campus_size') }}" class="gc-control" placeholder="e.g. 50 Acres"></div>
                        <div class="gc-field"><label class="gc-label">Approvals (Badges)</label><input type="text" name="approvals" value="{{ old('approvals') }}" class="gc-control" placeholder="UGC, AICTE, NAAC A+"></div>
                    </div>
                </section>

                <section class="gc-side-card gc-publish-card">
                    <div class="gc-card-header">
                        <div class="gc-card-heading">
                            <span class="gc-card-icon"><i class="bi bi-briefcase-fill"></i></span>
                            <div>
                                <h3 class="gc-card-title">Placements & Hostels</h3><small class="gc-card-subtitle">Career outcomes, scholarships and accommodation</small>
                            </div>
                        </div>
                    </div>
                    <div class="gc-card-body">
                        <div class="gc-field"><label class="gc-label">Highest Package</label><input type="text" name="highest_package" value="{{ old('highest_package') }}" class="gc-control" placeholder="e.g. 18.0 LPA"></div>
                        <div class="gc-field"><label class="gc-label">Average Package</label><input type="text" name="average_package" value="{{ old('average_package') }}" class="gc-control" placeholder="e.g. 5.5 LPA"></div>
                        <div class="gc-field"><label class="gc-label">Top Recruiters</label><input type="text" name="top_recruiters" value="{{ old('top_recruiters') }}" class="gc-control" placeholder="TCS, Infosys, Wipro, Amazon"></div>
                        <div class="gc-field"><label class="gc-label">Scholarships Info</label><textarea name="scholarship_info" rows="2" class="gc-control" placeholder="Merit scholarships up to 25% waiver...">{{ old('scholarship_info') }}</textarea></div>
                        <div class="gc-field">
                            <label class="gc-label">Hostel Facilities</label>
                            <div class="form-check gc-check"><input class="form-check-input" type="checkbox" name="has_boys_hostel" value="1" id="cbBoys" {{ old('has_boys_hostel') ? 'checked' : '' }}><label class="form-check-label" for="cbBoys">Boys Hostel Available</label></div>
                            <div class="form-check gc-check"><input class="form-check-input" type="checkbox" name="has_girls_hostel" value="1" id="cbGirls" {{ old('has_girls_hostel') ? 'checked' : '' }}><label class="form-check-label" for="cbGirls">Girls Hostel Available</label></div>
                        </div>
                        <div class="gc-field">
                            <label class="gc-label">College Status</label>

                            {{-- Always send a status value: 0 when unchecked, 1 when checked --}}
                            <input type="hidden" name="status" value="0">

                            <div class="form-check gc-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="status"
                                    value="1"
                                    id="collegeStatus"
                                    {{ old('status', '1') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="collegeStatus">
                                    Publish College
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="gc-save-btn"><i class="bi bi-check2-circle"></i> Save & Publish College</button>
                        <div class="gc-mini-note"><i class="bi bi-shield-check"></i><span>Review all academic and location details before publishing the college profile.</span></div>
                    </div>
                </section>
            </aside>
        </div>
    </form>
</div>

<script id="streamsJson" type="application/json">
    @json($streams)
</script>
<script id="coursesJson" type="application/json">
    @json($courses)
</script>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const streamsData = JSON.parse(document.getElementById('streamsJson')?.textContent || '[]');
        const coursesData = JSON.parse(document.getElementById('coursesJson')?.textContent || '[]');

        function setupCascadeRow(row) {
            const streamSelect = row.querySelector('.stream-dropdown');
            const courseSelect = row.querySelector('.course-dropdown');
            const specSelect = row.querySelector('.specialization-dropdown');
            if (!streamSelect || !courseSelect || !specSelect) return;

            streamSelect.addEventListener('change', function() {
                const streamId = this.value;
                const filteredCourses = streamId ?
                    coursesData.filter(c => c.stream_id == streamId) :
                    coursesData;

                courseSelect.innerHTML = '<option value="">-- Select Course --</option>';
                filteredCourses.forEach(c => {
                    courseSelect.insertAdjacentHTML(
                        'beforeend',
                        `<option value="${c.id}" data-stream-id="${c.stream_id}">${escapeHtml(c.name)} (${escapeHtml(c.level || '')})</option>`
                    );
                });
                specSelect.innerHTML = '<option value="">General / Core</option>';
            });

            courseSelect.addEventListener('change', function() {
                const courseId = this.value;
                specSelect.innerHTML = '<option value="">General / Core</option>';
                if (!courseId) return;

                const selectedCourse = coursesData.find(c => c.id == courseId);
                if (!selectedCourse) return;

                if (selectedCourse.stream_id) {
                    streamSelect.value = selectedCourse.stream_id;
                }

                if (Array.isArray(selectedCourse.specializations)) {
                    selectedCourse.specializations.forEach(s => {
                        if (s.status) {
                            specSelect.insertAdjacentHTML(
                                'beforeend',
                                `<option value="${escapeHtml(s.name)}">${escapeHtml(s.name)}</option>`
                            );
                        }
                    });
                }
            });
        }

        function escapeHtml(value) {
            return String(value ?? '').replace(/[&<>"']/g, char => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            } [char]));
        }

        document.querySelectorAll('.course-card-row').forEach(setupCascadeRow);

        const stateSelect = document.getElementById('stateSelect');
        const citySelect = document.getElementById('citySelect');

        // Restore city list after a validation error.
        if (stateSelect?.value) {
            stateSelect.dispatchEvent(new Event('change'));
        }

        stateSelect?.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const stateId = selectedOption?.getAttribute('data-id');

            citySelect.innerHTML = '<option value="">Loading...</option>';

            if (!stateId) {
                citySelect.innerHTML = '<option value="">Choose State First</option>';
                return;
            }

            fetch(`/api/states/${stateId}/cities`)
                .then(res => {
                    if (!res.ok) throw new Error('Unable to load cities.');
                    return res.json();
                })
                .then(cities => {
                    citySelect.innerHTML = '<option value="">Choose City</option>';
                    cities.forEach(c => {
                        citySelect.insertAdjacentHTML('beforeend', `<option value="${escapeHtml(c.name)}">${escapeHtml(c.name)}</option>`);
                    });
                })
                .catch(() => {
                    citySelect.innerHTML = '<option value="">Unable to load cities</option>';
                });
        });

        // Prevent accidental double submission and show browser validation normally.
        const collegeForm = document.querySelector('form[action="{{ route("admin.colleges.store") }}"]');
        collegeForm?.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn && !this.checkValidity()) return;
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Saving...';
            }
        });

        document.getElementById('addCourseRowBtn')?.addEventListener('click', function() {
            const container = document.getElementById('coursesContainer');
            const firstRow = container?.querySelector('.course-card-row');
            if (!firstRow) return;

            const clone = firstRow.cloneNode(true);
            clone.querySelectorAll('input').forEach(input => input.value = '');
            clone.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

            const courseSelect = clone.querySelector('.course-dropdown');
            courseSelect.innerHTML = '<option value="">-- Select Course --</option>';
            coursesData.forEach(c => {
                courseSelect.insertAdjacentHTML(
                    'beforeend',
                    `<option value="${c.id}" data-stream-id="${c.stream_id}">${escapeHtml(c.name)} (${escapeHtml(c.level || '')})</option>`
                );
            });

            container.appendChild(clone);
            setupCascadeRow(clone);
        });

        document.getElementById('addHighlightBtn')?.addEventListener('click', function() {
            document.getElementById('highlightsContainer')?.insertAdjacentHTML('beforeend', `
            <div class="gc-repeat-row highlight-row">
                <span class="input-group-text">⭐</span>
                <input type="text" name="highlights[]" class="gc-control" placeholder="Enter key highlight...">
                <button type="button" class="remove-highlight-btn" title="Remove"><i class="bi bi-x"></i></button>
            </div>
        `);
        });

        document.getElementById('addFaqBtn')?.addEventListener('click', function() {
            document.getElementById('faqsContainer')?.insertAdjacentHTML('beforeend', `
            <div class="gc-faq-row faq-row">
                <input type="text" name="faq_questions[]" class="gc-control mb-2" placeholder="Question...">
                <textarea name="faq_answers[]" rows="2" class="gc-control mb-1" placeholder="Answer..."></textarea>
                <button type="button" class="btn btn-sm text-danger p-0 remove-faq-btn"><small><i class="bi bi-trash"></i> Remove FAQ</small></button>
            </div>
        `);
        });

        document.addEventListener('click', function(event) {
            const removeCourse = event.target.closest('.remove-course-btn');
            if (removeCourse) {
                const rows = document.querySelectorAll('.course-card-row');
                if (rows.length > 1) removeCourse.closest('.course-card-row')?.remove();
                else alert('At least one course entry is required.');
                return;
            }

            const removeHighlight = event.target.closest('.remove-highlight-btn');
            if (removeHighlight) {
                removeHighlight.closest('.highlight-row')?.remove();
                return;
            }

            const removeFaq = event.target.closest('.remove-faq-btn');
            if (removeFaq) {
                removeFaq.closest('.faq-row')?.remove();
            }
        });
    });
</script>
@endpush

@endsection