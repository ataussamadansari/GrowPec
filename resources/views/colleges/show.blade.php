@extends('layouts.app')

@section('title', $college->name . ' - Admission, Courses, Fees, Placements & Brochure | GrowPec')

@push('styles')
<style>
    :root {
        --primary-purple: #2E1E6B;
        --secondary-purple: #4E3797;
        --accent-gold: #F5A623;
        --accent-gold-hover: #E09612;
        --table-yellow: #F59E0B;
        --table-purple: #ECE8F6;
        --bg-light: #F8F9FC;
    }

    /* =========================================================
       1. HERO HEADER SECTION
       ========================================================= */
    .college-hero-section {
        background: #ffffff;
        border-bottom: 1px solid #E2E8F0;
        padding: 25px 0 35px;
    }

    .college-banner-container {
        position: relative;
        width: 100%;
        height: 330px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        background: #000;
    }

    .college-main-banner-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* Overlapping Logo on Top-Left of Banner */
    .college-logo-overlay {
        position: absolute;
        top: 18px;
        left: 18px;
        width: 72px;
        height: 72px;
        background: #ffffff;
        border-radius: 16px;
        padding: 6px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .college-logo-overlay img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 12px;
    }

    .college-hero-title {
        font-size: 1.65rem;
        font-weight: 800;
        color: var(--primary-purple);
        line-height: 1.3;
    }

    /* Action Buttons */
    .btn-apply-purple {
        background: var(--primary-purple);
        color: #ffffff;
        font-weight: 700;
        border-radius: 25px;
        padding: 8px 22px;
        border: none;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-apply-purple:hover {
        background: var(--secondary-purple);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-brochure-gold {
        background: var(--accent-gold);
        color: #17120a;
        font-weight: 700;
        border-radius: 25px;
        padding: 8px 22px;
        border: none;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-brochure-gold:hover {
        background: var(--accent-gold-hover);
        color: #17120a;
        transform: translateY(-1px);
    }

    .btn-whatsapp-green {
        background: #25D366;
        color: #ffffff;
        font-weight: 700;
        border-radius: 25px;
        padding: 8px 20px;
        border: none;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-whatsapp-green:hover {
        background: #1EBE5D;
        color: #ffffff;
        transform: translateY(-1px);
    }

    /* Right Admission Support Card */
    .admission-support-card {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid #EEF2F6;
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.06);
        padding: 24px;
    }

    .form-control-pill {
        border-radius: 25px !important;
        border: 1px solid #CBD5E1 !important;
        padding: 8px 16px !important;
        font-size: 0.86rem !important;
        color: #1E293B !important;
        background-color: #ffffff;
    }

    .form-control-pill:focus {
        border-color: var(--secondary-purple) !important;
        box-shadow: 0 0 0 3px rgba(78, 55, 151, 0.12) !important;
    }

    .btn-save-pill {
        background: var(--secondary-purple) !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        border-radius: 25px !important;
        padding: 9px !important;
        border: none !important;
        font-size: 0.95rem !important;
        transition: all 0.2s ease;
    }

    .btn-save-pill:hover {
        background: var(--primary-purple) !important;
        transform: translateY(-1px);
    }

    /* =========================================================
       2. DYNAMIC LEFT QUICK JUMP STICKY NAVIGATION
       ========================================================= */
    .quick-nav-sidebar {
        position: sticky;
        top: 90px;
        background: #ffffff;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 10px 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }

    .quick-nav-link {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 9px 14px;
        font-size: 0.84rem;
        font-weight: 600;
        color: #475569;
        text-decoration: none;
        border-radius: 10px;
        margin-bottom: 4px;
        transition: all 0.2s ease-in-out;
    }

    .quick-nav-link:hover {
        background: #FAF8FF;
        color: var(--secondary-purple);
    }

    .quick-nav-link.active {
        background: var(--table-purple);
        color: var(--secondary-purple);
        font-weight: 700;
        border-left: 4px solid var(--secondary-purple);
    }

    /* =========================================================
       3. CONTENT BLOCKS & TABLES
       ========================================================= */
    .content-block {
        background: #ffffff;
        border: 1px solid #E2E8F0;
        border-radius: 18px;
        padding: 28px;
        margin-bottom: 25px;
        scroll-margin-top: 105px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
    }

    .content-block-header {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--primary-purple);
        margin-bottom: 18px;
        padding-bottom: 10px;
        border-bottom: 2px solid #F1EEF9;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Yellow Header Table (BoostMyTalent Style) */
    .table-yellow-header thead th {
        background: var(--table-yellow) !important;
        color: #000000 !important;
        font-weight: 700;
        padding: 12px 16px;
        border: 1px solid #E5E7EB;
        font-size: 0.9rem;
    }

    .table-yellow-header tbody td {
        padding: 11px 16px;
        border: 1px solid #E5E7EB;
        font-size: 0.88rem;
    }

    /* Purple Header Course Table (BoostMyTalent Style) */
    .table-course-header thead th {
        background: var(--table-purple) !important;
        color: var(--primary-purple) !important;
        font-weight: 700;
        padding: 11px 14px;
        border: 1px solid #E2E8F0;
        font-size: 0.85rem;
    }

    .table-course-header tbody td {
        padding: 11px 14px;
        border: 1px solid #E2E8F0;
        font-size: 0.85rem;
        vertical-align: middle;
    }

    .highlight-pill {
        background: #FAF8FF;
        border: 1px solid #E4DEF7;
        border-radius: 10px;
        padding: 11px 16px;
        margin-bottom: 10px;
        font-size: 0.88rem;
        color: #334155;
        display: flex;
        align-items: center;
    }

    .step-card {
        background: #F8FAFC;
        border-left: 4px solid var(--secondary-purple);
        border-radius: 10px;
        padding: 16px 18px;
        margin-bottom: 12px;
    }

    .step-number {
        width: 32px;
        height: 32px;
        background: var(--secondary-purple);
        color: #fff;
        font-weight: bold;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.88rem;
        flex-shrink: 0;
    }

    .certificate-frame-box {
        background: #FAF8FF;
        border: 2px dashed #CBD5E1;
        border-radius: 16px;
        padding: 20px;
        text-align: center;
    }

    @media (max-width: 991.98px) {
        .college-banner-container {
            height: 240px;
        }
    }
</style>
@endpush

@section('content')

<!-- Top Breadcrumb -->
<div class="bg-light py-2 border-bottom small">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ $college->college_mode == 'online' ? route('colleges.online') : route('colleges.regular') }}" class="text-decoration-none text-muted">{{ $college->college_mode == 'online' ? 'Online Colleges' : 'Regular Colleges' }}</a></li>
                <li class="breadcrumb-item active fw-bold text-dark">{{ $college->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<!-- =========================================================
     1. HERO HEADER (Banner, Logo Overlay, Info & Admission Form)
     ========================================================= -->
<div class="college-hero-section">
    <div class="container">
        <div class="row g-4 align-items-start">

            <!-- Left Side: Banner, Info, Badges & Actions (col-lg-8) -->
            <div class="col-lg-8">

                <!-- Banner Image with Logo Overlay -->
                <div class="college-banner-container mb-3">
                    <div class="college-logo-overlay">
                        <img src="{{ $college->logo_url ?? $college->banner_url }}" alt="{{ $college->name }} logo">
                    </div>
                    <img src="{{ $college->banner_url }}" class="college-main-banner-img" alt="{{ $college->name }}">
                </div>

                <!-- Badges -->
                <div class="d-flex flex-wrap gap-2 mb-2">
                    <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-1">{{ $college->college_type }} University</span>
                    <span class="badge bg-{{ $college->college_mode == 'online' ? 'success' : 'dark' }}-subtle text-dark fw-bold px-3 py-1">{{ strtoupper($college->college_mode) }}</span>
                    @if($college->approvals)
                    <span class="badge bg-warning-subtle text-dark fw-bold px-3 py-1"><i class="bi bi-shield-check me-1"></i>{{ $college->approvals }}</span>
                    @endif
                    <span class="badge bg-light text-dark border fw-bold px-3 py-1"><i class="bi bi-star-fill text-warning me-1"></i>{{ $college->rating }} ({{ $college->reviews_count }} Reviews)</span>
                </div>

                <!-- Title & Affiliation -->
                <h2 class="college-hero-title mb-1">{{ $college->name }}</h2>
                <p class="text-muted small mb-3">
                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $college->address ?? $college->city . ', ' . $college->state }}
                    @if($college->university_name) • Affiliated to: <strong>{{ $college->university_name }}</strong> @endif
                    @if($college->established_year) • Estd. Year: <strong>{{ $college->established_year }}</strong> @endif
                </p>

                <!-- Action Buttons -->
                <div class="d-flex flex-wrap gap-2">
                    <a href="tel:8858285271" class="btn-apply-purple">
                        <i class="bi bi-telephone-forward me-1"></i> Get in Touch
                    </a>
                    @if($college->brochure_pdf)
                    <a href="{{ asset('storage/' . $college->brochure_pdf) }}" target="_blank" class="btn-brochure-gold">
                        <i class="bi bi-download me-1"></i> Download Brochure
                    </a>
                    @endif
                    <a href="https://wa.me/918858285271?text=Hello,%20I%20am%20interested%20in%20{{ urlencode($college->name) }} {{ urlencode($college->city) }} Admission, Please guide with official Fees and Scholarship options." target="_blank" class="btn-whatsapp-green">
                        <i class="bi bi-whatsapp me-1"></i> WhatsApp Query
                    </a>
                </div>

            </div>

            <!-- Right Side: Admission Support Form Card (col-lg-4) -->
            <div class="col-lg-4">
                <div class="admission-support-card">
                    <h5 class="fw-bold mb-3" style="color: var(--primary-purple); font-size: 1.15rem;">
                        Get 1-on-1 Admission Support
                    </h5>

                    <form action="{{ route('lead.submit') }}" method="POST" id="admissionSupportForm">
                        @csrf
                        <input type="hidden" name="college_id" value="{{ $college->id }}">
                        <input type="hidden" name="source" value="college_detail_page">

                        <!-- Name -->
                        <div class="mb-2">
                            <label class="form-label small fw-bold text-muted mb-1">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-pill" placeholder="Enter your full name" required>
                        </div>

                        <!-- Mobile -->
                        <div class="mb-2">
                            <label class="form-label small fw-bold text-muted mb-1">Mobile <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control form-control-pill" placeholder="WhatsApp number" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-2">
                            <label class="form-label small fw-bold text-muted mb-1">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control form-control-pill" placeholder="Enter email address" required>
                        </div>

                        <!-- Course -->
                        <div class="mb-2">
                            <label class="form-label small fw-bold text-muted mb-1">Course <span class="text-danger">*</span></label>
                            <select name="course_id" class="form-select form-control-pill" required>
                                <option value="">Select Course</option>
                                @foreach($college->collegeCourses as $cc)
                                <option value="{{ $cc->course_id }}">{{ $cc->course->name }} @if($cc->specialization) ({{ $cc->specialization }}) @endif</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- State -->
                        <div class="mb-2">
                            <label class="form-label small fw-bold text-muted mb-1">Current State <span class="text-danger">*</span></label>
                            <select name="state" id="leadCardStateSelect" class="form-select form-control-pill" required>
                                <option value="">Select State</option>
                                @php
                                $leadStates = \App\Models\State::where('status', true)->orderBy('name')->get();
                                @endphp
                                @foreach($leadStates as $st)
                                <option value="{{ $st->name }}" data-id="{{ $st->id }}">{{ $st->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- City -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted mb-1">Current City <span class="text-danger">*</span></label>
                            <select name="city" id="leadCardCitySelect" class="form-select form-control-pill" required>
                                <option value="">Select City</option>
                            </select>
                        </div>

                        <div id="admissionSupportMsg"></div>

                        <button type="submit" id="admissionSupportBtn" class="btn btn-save-pill w-100 shadow-sm">
                            Save & Request Callback
                        </button>

                        <p class="text-center text-muted mt-2 mb-0" style="font-size: 0.76rem;">
                            I accept and agree to the <a href="#" class="fw-bold text-dark text-decoration-none">Terms of Use</a>
                        </p>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- =========================================================
     2. MAIN CONTENT (Dynamic Left Sticky Nav + Content Blocks)
     ========================================================= -->
<div class="container py-4">
    <div class="row g-4">

        <!-- 🎯 Left Side: Dynamic Sticky Navigation (col-lg-2) -->
        <div class="col-lg-2 d-none d-lg-block">
            <div class="quick-nav-sidebar">
                <small class="text-muted fw-bold d-block mb-2 px-2 text-uppercase" style="letter-spacing: 0.5px; font-size: 0.72rem;">QUICK JUMP</small>
                @foreach($quickNav as $index => $nav)
                <a href="#{{ $nav['id'] }}" class="quick-nav-link {{ $index === 0 ? 'active' : '' }}" data-target="{{ $nav['id'] }}">
                    <i class="bi {{ $nav['icon'] }}"></i>
                    <span>{{ $nav['title'] }}</span>
                </a>
                @endforeach
            </div>
        </div>

        <!-- 🎯 Right Side: Detailed Content Blocks (col-lg-10) -->
        <div class="col-lg-10">

            <!-- 1. Quick Facts Table & Overview (BoostMyTalent Yellow Header) -->
            <div class="content-block" id="sec-overview">
                <h5 class="content-block-header">
                    <i class="bi bi-info-circle-fill text-warning"></i> Quick Facts & Snapshot
                </h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-yellow-header mb-0">
                        <thead>
                            <tr>
                                <th style="width: 38%;">Particulars</th>
                                <th>Statistics & Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold text-muted">Mode of Education</td>
                                <td class="fw-bold text-dark">{{ ucfirst($college->college_mode) }} Mode</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">Ownership / Status</td>
                                <td>{{ $college->college_type }} University</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">Approvals & Accreditations</td>
                                <td><span class="badge bg-success-subtle text-success border">{{ $college->approvals ?? 'UGC / AICTE / DEB Approved' }}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">Campus Location</td>
                                <td>{{ $college->city }}, {{ $college->state }} {{ $college->campus_size ? '('.$college->campus_size.')' : '' }}</td>
                            </tr>
                            @if($college->highest_package)
                            <tr>
                                <td class="fw-semibold text-muted">Highest Salary Package</td>
                                <td class="text-success fw-bold">{{ $college->highest_package }}</td>
                            </tr>
                            @endif
                            @if($college->average_package)
                            <tr>
                                <td class="fw-semibold text-muted">Average Salary Package</td>
                                <td class="fw-bold text-dark">{{ $college->average_package }}</td>
                            </tr>
                            @endif
                            @if($college->college_mode !== 'online')
                            <tr>
                                <td class="fw-semibold text-muted">Hostel Facilities</td>
                                <td>
                                    @if($college->has_boys_hostel) <span class="badge bg-light text-dark border me-1">Boys Hostel</span> @endif
                                    @if($college->has_girls_hostel) <span class="badge bg-light text-dark border">Girls Hostel</span> @endif
                                    @if(!$college->has_boys_hostel && !$college->has_girls_hostel) <span class="text-muted">Day Scholar Campus</span> @endif
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <h6 class="fw-bold text-dark mb-2">About {{ $college->name }}</h6>
                    <p class="text-secondary leading-relaxed mb-0 small">
                        {{ $college->overview ?? $college->name . ' is a recognized premier institution located in '.$college->city.', '.$college->state.'. Offering industry-aligned programs with experienced faculty, modern research labs, and dedicated career placement support.' }}
                    </p>
                </div>
            </div>

            <!-- 2. Dynamic Key Highlights -->
            @if(!empty($college->highlights) && count($college->highlights) > 0)
            <div class="content-block" id="sec-highlights">
                <h5 class="content-block-header">
                    <i class="bi bi-star-fill text-warning"></i> Key Highlights & USPs
                </h5>
                @foreach($college->highlights as $highlight)
                <div class="highlight-pill">
                    <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                    <span>{{ $highlight }}</span>
                </div>
                @endforeach
            </div>
            @endif

            <!-- 3. Courses, Specializations & Fee Structure Table (Purple Header) -->
            @if($college->collegeCourses->count() > 0)
            <div class="content-block" id="sec-courses">
                <h5 class="content-block-header">
                    <i class="bi bi-mortarboard-fill text-primary"></i> Courses, Fees & Specializations
                </h5>

                <div class="table-responsive">
                    <table class="table table-bordered table-course-header mb-0">
                        <thead>
                            <tr>
                                <th>Course / Program</th>
                                <th>Specialization</th>
                                <th>Duration</th>
                                <th>Eligibility</th>
                                <th>Fee Structure</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($college->collegeCourses as $cc)
                            <tr>
                                <td class="fw-bold text-dark">
                                    {{ $cc->course->name }}
                                    <span class="badge bg-primary-subtle text-primary ms-1" style="font-size: 0.7rem;">{{ $cc->course->level }}</span>
                                </td>
                                <td>{{ $cc->specialization ?: 'General / Core' }}</td>
                                <td>{{ $cc->course->duration }}</td>
                                <td class="small text-muted">{{ $cc->eligibility ?: '10+2 with 50% / Graduation' }}</td>
                                <td>
                                    <strong class="text-success fs-6">₹{{ number_format($cc->fee_amount) }}</strong>
                                    <small class="text-muted d-block" style="font-size: 0.72rem;">/ {{ str_replace('_', ' ', $cc->fee_type) }}</small>
                                </td>
                                <td class="text-center">
                                    <a href="#admissionSupportForm" class="btn btn-warning btn-sm fw-bold px-3 text-dark rounded-pill" style="font-size: 0.78rem;">
                                        Apply Now
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- 4. Step-by-Step Admission Process -->
            @if(!empty($college->admission_process))
            <div class="content-block" id="sec-admission">
                <h5 class="content-block-header">
                    <i class="bi bi-card-checklist text-success"></i> Step-by-Step Admission Process
                </h5>
                <div class="step-card">
                    <div class="d-flex gap-3 align-items-center">
                        <span class="step-number">1</span>
                        <div>
                            <h6 class="fw-bold mb-1 text-dark">Online Application Registration</h6>
                            <p class="text-muted small mb-0">Fill out the online application form with personal, academic, and contact details.</p>
                        </div>
                    </div>
                </div>
                <div class="step-card">
                    <div class="d-flex gap-3 align-items-center">
                        <span class="step-number">2</span>
                        <div>
                            <h6 class="fw-bold mb-1 text-dark">Document Upload & Verification</h6>
                            <p class="text-muted small mb-0">Submit marksheets, photo ID, and previous qualifying degree certificates for administrative verification.</p>
                        </div>
                    </div>
                </div>
                <div class="step-card">
                    <div class="d-flex gap-3 align-items-center">
                        <span class="step-number">3</span>
                        <div>
                            <h6 class="fw-bold mb-1 text-dark">Fee Payment & Enrollment Confirmation</h6>
                            <p class="text-muted small mb-0">Complete the course fee payment or opt for Easy No-Cost EMI to generate your student ID.</p>
                        </div>
                    </div>
                </div>
                <div class="small text-secondary mt-3">
                    {!! nl2br(e($college->admission_process)) !!}
                </div>
            </div>
            @endif

            <!-- 5. Approvals & Accreditations -->
            <div class="content-block" id="sec-approvals">
                <h5 class="content-block-header">
                    <i class="bi bi-shield-check text-warning"></i> Approvals & Accreditations
                </h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-yellow-header mb-0">
                        <thead>
                            <tr>
                                <th>Statutory Body</th>
                                <th>Accreditation & Approval Status</th>
                                <th>Validity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold">University Grants Commission (UGC)</td>
                                <td>Fully Recognized under section 2(f) / 12(B)</td>
                                <td><span class="badge bg-success-subtle text-success">Valid Nationwide</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">AICTE / Distance Education Bureau (DEB)</td>
                                <td>Approved for Technical & Management Programs</td>
                                <td><span class="badge bg-success-subtle text-success">Approved</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">NAAC Accreditation</td>
                                <td>{{ $college->approvals ?: 'Accredited with Grade A+' }}</td>
                                <td><span class="badge bg-primary-subtle text-primary">Certified</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 6. Sample Degree / Certificate Preview -->
            @if($college->certificate_url)
            <div class="content-block" id="sec-certificate">
                <h5 class="content-block-header">
                    <i class="bi bi-patch-check-fill text-success"></i> Sample Degree & Certification
                </h5>
                <p class="small text-muted mb-3">
                    Degrees awarded by {{ $college->name }} carry full government approvals and are valid for all state/central government jobs, corporate hiring, and higher studies worldwide.
                </p>
                <div class="certificate-frame-box">
                    <img src="{{ $college->certificate_url }}" class="img-fluid rounded shadow-sm" style="max-height: 380px; object-fit: contain;" alt="Sample Certificate">
                </div>
            </div>
            @endif

            <!-- 7. Placements & Top Recruiters -->
            @if(!empty($college->highest_package) || !empty($college->average_package) || !empty($college->top_recruiters))
            <div class="content-block" id="sec-placements">
                <h5 class="content-block-header">
                    <i class="bi bi-briefcase-fill text-danger"></i> Placement Records & Recruiters
                </h5>
                <div class="row g-3 mb-3 text-center">
                    @if($college->highest_package)
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <small class="text-muted d-block">Highest Salary Package</small>
                            <h4 class="fw-bold text-success mb-0">{{ $college->highest_package }}</h4>
                        </div>
                    </div>
                    @endif
                    @if($college->average_package)
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <small class="text-muted d-block">Average Salary Package</small>
                            <h4 class="fw-bold text-dark mb-0">{{ $college->average_package }}</h4>
                        </div>
                    </div>
                    @endif
                </div>
                @if($college->top_recruiters)
                <div class="p-3 bg-light rounded-3">
                    <strong class="small d-block text-dark mb-1">Prominent Hiring Partners:</strong>
                    <p class="small text-muted mb-0">{{ $college->top_recruiters }}</p>
                </div>
                @endif
            </div>
            @endif

            <!-- 8. Scholarships & Financial Aid -->
            @if(!empty($college->scholarship_info))
            <div class="content-block" id="sec-scholarships">
                <h5 class="content-block-header">
                    <i class="bi bi-award-fill text-warning"></i> Scholarships & Financial Support
                </h5>
                <p class="small text-secondary mb-0 leading-relaxed">{{ $college->scholarship_info }}</p>
            </div>
            @endif

            <!-- 9. Campus Facilities -->
            @if($college->college_mode !== 'online' && ($college->has_boys_hostel || $college->has_girls_hostel || $college->campus_size))
            <div class="content-block" id="sec-facilities">
                <h5 class="content-block-header">
                    <i class="bi bi-buildings-fill text-info"></i> Campus Infrastructure & Facilities
                </h5>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-light text-dark border p-2"><i class="bi bi-wifi text-primary me-1"></i> High-Speed Wi-Fi</span>
                    <span class="badge bg-light text-dark border p-2"><i class="bi bi-book text-success me-1"></i> Central Digital Library</span>
                    @if($college->has_boys_hostel) <span class="badge bg-light text-dark border p-2"><i class="bi bi-house text-dark me-1"></i> Boys Hostel</span> @endif
                    @if($college->has_girls_hostel) <span class="badge bg-light text-dark border p-2"><i class="bi bi-house-heart text-danger me-1"></i> Girls Hostel</span> @endif
                    <span class="badge bg-light text-dark border p-2"><i class="bi bi-cup-hot text-warning me-1"></i> Cafeteria & Food Court</span>
                    <span class="badge bg-light text-dark border p-2"><i class="bi bi-dribbble text-danger me-1"></i> Sports Arena</span>
                </div>
            </div>
            @endif

            <!-- 10. Dynamic FAQs -->
            @if(!empty($college->faqs) && count($college->faqs) > 0)
            <div class="content-block" id="sec-faqs">
                <h5 class="content-block-header">
                    <i class="bi bi-question-circle-fill text-warning"></i> Frequently Asked Questions
                </h5>
                <div class="accordion" id="collegeFaqs">
                    @foreach($college->faqs as $idx => $faq)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button {{ $idx > 0 ? 'collapsed' : '' }} fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq_{{ $idx }}">
                                {{ $faq['question'] ?? 'Question' }}
                            </button>
                        </h2>
                        <div id="faq_{{ $idx }}" class="accordion-collapse collapse {{ $idx === 0 ? 'show' : '' }}" data-bs-parent="#collegeFaqs">
                            <div class="accordion-body small text-secondary">
                                {{ $faq['answer'] ?? '' }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 🎯 Dynamic ScrollSpy for Left Quick Navigation
        const navLinks = document.querySelectorAll('.quick-nav-link');
        const sections = Array.from(navLinks).map(link => document.getElementById(link.getAttribute('data-target'))).filter(Boolean);

        window.addEventListener('scroll', () => {
            let currentSectionId = '';
            const scrollPosition = window.scrollY + 140;

            sections.forEach(section => {
                if (section.offsetTop <= scrollPosition) {
                    currentSectionId = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('data-target') === currentSectionId) {
                    link.classList.add('active');
                }
            });
        });

        // Dynamic State -> City loading in Admission Card
        const stateDropdown = document.getElementById('leadCardStateSelect');
        const cityDropdown = document.getElementById('leadCardCitySelect');

        if (stateDropdown) {
            stateDropdown.addEventListener('change', function() {
                const selectedOpt = this.options[this.selectedIndex];
                const stateId = selectedOpt ? selectedOpt.getAttribute('data-id') : null;

                cityDropdown.innerHTML = '<option value="">Loading...</option>';

                if (stateId) {
                    fetch(`/api/states/${stateId}/cities`)
                        .then(res => res.json())
                        .then(cities => {
                            cityDropdown.innerHTML = '<option value="">Select City</option>';
                            cities.forEach(c => {
                                cityDropdown.innerHTML += `<option value="${c.name}">${c.name}</option>`;
                            });
                        })
                        .catch(() => {
                            cityDropdown.innerHTML = '<option value="">Select City</option>';
                        });
                } else {
                    cityDropdown.innerHTML = '<option value="">Select City</option>';
                }
            });
        }

        // AJAX Lead Submission in Admission Card
        const leadForm = document.getElementById('admissionSupportForm');
        if (leadForm) {
            leadForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const btn = document.getElementById('admissionSupportBtn');
                const msg = document.getElementById('admissionSupportMsg');

                btn.disabled = true;
                btn.innerText = 'Saving...';

                fetch("{{ route('lead.submit') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            "Accept": "application/json"
                        },
                        body: new FormData(this)
                    })
                    .then(res => res.json())
                    .then(data => {
                        btn.disabled = false;
                        btn.innerText = 'Save & Request Callback';
                        msg.innerHTML = `<div class="alert alert-success py-2 small rounded-pill text-center mb-3">${data.message || 'Thank you! We will contact you soon.'}</div>`;
                        leadForm.reset();
                    })
                    .catch(() => {
                        btn.disabled = false;
                        btn.innerText = 'Save & Request Callback';
                        msg.innerHTML = `<div class="alert alert-danger py-2 small rounded-pill text-center mb-3">Something went wrong. Try again.</div>`;
                    });
            });
        }
    });
</script>
@endpush

@endsection