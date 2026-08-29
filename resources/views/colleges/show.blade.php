@extends('layouts.app')

@section('title', $college->name . ' - Admission, Courses, Fees & Placements | GrowPec')

@push('styles')
<style>
    .college-header-banner {
        background: #ffffff;
        border-bottom: 1px solid #E5E7EB;
        padding: 30px 0 20px;
    }
    .college-banner-img {
        width: 100%;
        height: 320px;
        object-fit: cover;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    .college-logo-box {
        width: 70px;
        height: 70px;
        background: #ffffff;
        border: 2px solid #E5E7EB;
        border-radius: 12px;
        padding: 5px;
        object-fit: contain;
    }

    /* Sticky Right Lead Form */
    .sticky-lead-card {
        position: sticky;
        top: 90px;
        background: #ffffff;
        border-radius: 16px;
        border: 2px solid var(--primary-purple);
        box-shadow: 0 10px 25px rgba(46, 30, 107, 0.08);
    }

    /* BoostMyTalent Snapshot Table */
    .snapshot-table th {
        background-color: var(--accent-gold);
        color: #000;
        font-weight: 700;
        padding: 12px 16px;
    }
    .snapshot-table td {
        padding: 12px 16px;
        font-size: 0.92rem;
        vertical-align: middle;
    }

    /* Detail Content Cards */
    .detail-card {
        background: #ffffff;
        border: 1px solid #E5E7EB;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 25px;
    }
    .detail-card-title {
        font-weight: 800;
        color: var(--primary-purple);
        font-size: 1.25rem;
        margin-bottom: 18px;
        padding-bottom: 10px;
        border-bottom: 2px solid #F0EDFA;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Courses Table */
    .courses-table thead th {
        background: #F4F1FA;
        color: var(--primary-purple);
        font-weight: 700;
        font-size: 0.88rem;
    }
    .courses-table tbody td {
        vertical-align: middle;
        font-size: 0.9rem;
    }

    /* Facilities Badges */
    .facility-badge {
        background: #FAF8FF;
        border: 1px solid #E4DEF7;
        padding: 10px 16px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.88rem;
        color: var(--primary-purple);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
</style>
@endpush

@section('content')

<!-- 1. Breadcrumb & Top Bar -->
<div class="bg-light py-2 border-bottom small">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ $college->college_mode == 'online' ? route('colleges.online') : route('colleges.regular') }}" class="text-decoration-none text-muted">{{ $college->college_mode == 'online' ? 'Online Colleges' : 'Regular Colleges' }}</a></li>
                <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">{{ $college->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<!-- 2. College Banner & Top Info -->
<div class="college-header-banner">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-8">
                <div class="position-relative mb-3">
                    <img src="{{ $college->banner_image ?? 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=1200&q=80' }}" class="college-banner-img" alt="{{ $college->name }}">
                </div>

                <div class="d-flex align-items-start gap-3">
                    <div>
                        <div class="d-flex flex-wrap gap-2 mb-2">
                            <span class="badge bg-primary-subtle text-primary fw-bold">{{ $college->college_type }} University</span>
                            <span class="badge bg-{{ $college->college_mode == 'online' ? 'success' : 'dark' }}-subtle text-dark fw-bold">
                                {{ strtoupper($college->college_mode) }}
                            </span>
                            @if($college->approvals)
                                <span class="badge bg-warning-subtle text-dark fw-bold"><i class="bi bi-shield-check me-1"></i>{{ $college->approvals }}</span>
                            @endif
                            <span class="badge bg-light text-dark border fw-bold"><i class="bi bi-star-fill text-warning me-1"></i>{{ $college->rating }} / 5 ({{ $college->reviews_count }} Reviews)</span>
                        </div>

                        <h2 class="fw-bold mb-1" style="color: var(--primary-purple);">{{ $college->name }}</h2>
                        <p class="text-muted small mb-0">
                            <i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $college->address ?? $college->city . ', ' . $college->state }}
                            @if($college->university_name) • Affiliated to: <strong>{{ $college->university_name }}</strong> @endif
                            @if($college->established_year) • Estd: <strong>{{ $college->established_year }}</strong> @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Sticky Direct Enquiry Form -->
            <div class="col-lg-4">
                <div class="sticky-lead-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold mb-0" style="color: var(--primary-purple);">🎯 Apply for Admission</h5>
                        <span class="badge bg-success-subtle text-success small">Free Guidance</span>
                    </div>
                    <p class="text-muted small mb-3">Get detailed fee structures, brochures & scholarship options.</p>

                    <form action="{{ route('lead.submit') }}" method="POST" id="collegeDetailLeadForm">
                        @csrf
                        <input type="hidden" name="college_id" value="{{ $college->id }}">
                        <input type="hidden" name="source" value="college_detail_sidebar">

                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Full Name *</label>
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="Enter student name" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">WhatsApp Number *</label>
                            <input type="tel" name="phone" class="form-control form-control-sm" placeholder="10-digit mobile number" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-sm" placeholder="student@example.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Select Course</label>
                            <select name="course_id" class="form-select form-select-sm">
                                <option value="">Select Interested Course</option>
                                @foreach($college->collegeCourses as $cc)
                                    <option value="{{ $cc->course_id }}">{{ $cc->course->name }} ({{ $cc->course->level }}) - ₹{{ number_format($cc->fee_amount) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="collegeDetailFormMsg"></div>
                        <button type="submit" class="btn btn-gold w-100 py-2 fw-bold">
                            Get Free Counselling & Brochure
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3. Main Detail Tabs & Content -->
<div class="container py-4">
    <div class="row g-4">
        <div class="col-lg-8">

            <!-- A. Quick Facts Table (BoostMyTalent Style) -->
            <div class="detail-card">
                <h5 class="detail-card-title"><i class="bi bi-info-circle-fill text-warning"></i> Quick Facts & Snapshot</h5>
                <div class="table-responsive">
                    <table class="table table-bordered snapshot-table mb-0">
                        <thead>
                            <tr>
                                <th style="width: 40%;">Particulars</th>
                                <th>Statistics & Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold text-muted">Mode of Education</td>
                                <td class="fw-bold">{{ ucfirst($college->college_mode) }} Mode</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">Institute Ownership</td>
                                <td>{{ $college->college_type }} University</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">Approvals & Accreditations</td>
                                <td><span class="badge bg-success-subtle text-success border">{{ $college->approvals ?? 'UGC / AICTE Approved' }}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">Campus Location & Area</td>
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
                                <td class="fw-bold">{{ $college->average_package }}</td>
                            </tr>
                            @endif
                            @if($college->top_recruiters)
                            <tr>
                                <td class="fw-semibold text-muted">Top Hiring Partners</td>
                                <td>{{ $college->top_recruiters }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="fw-semibold text-muted">Hostel Availability</td>
                                <td>
                                    @if($college->has_boys_hostel) <span class="badge bg-light text-dark border me-1">Boys Hostel</span> @endif
                                    @if($college->has_girls_hostel) <span class="badge bg-light text-dark border">Girls Hostel</span> @endif
                                    @if(!$college->has_boys_hostel && !$college->has_girls_hostel) <span class="text-muted">Day Scholar / Off-Campus</span> @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- B. About & Overview -->
            <div class="detail-card">
                <h5 class="detail-card-title"><i class="bi bi-file-text-fill text-primary"></i> About {{ $college->name }}</h5>
                <p class="text-secondary leading-relaxed mb-0">
                    {{ $college->overview ?? $college->name . ' is a premier institution located in '.$college->city.', '.$college->state.'. Offering industry-aligned programs with excellent academic faculty, state-of-the-art laboratory infrastructure, and dedicated placement training.' }}
                </p>
            </div>

            <!-- C. Courses, Fees & Eligibility Table -->
            <div class="detail-card">
                <h5 class="detail-card-title"><i class="bi bi-mortarboard-fill text-success"></i> Courses, Fees & Eligibility</h5>
                <div class="table-responsive">
                    <table class="table table-hover courses-table mb-0">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Duration</th>
                                <th>Annual Fee</th>
                                <th>Eligibility</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($college->collegeCourses as $cc)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $cc->course->name }}</div>
                                        @if($cc->specialization) <small class="text-muted">{{ $cc->specialization }}</small> @endif
                                    </td>
                                    <td><span class="badge bg-light text-secondary border">{{ $cc->course->duration }}</span></td>
                                    <td>
                                        <span class="fw-bold text-dark">₹{{ number_format($cc->fee_amount) }}</span>
                                        <small class="text-muted d-block">/ {{ str_replace('_', ' ', $cc->fee_type) }}</small>
                                    </td>
                                    <td><small class="text-secondary">{{ $cc->eligibility ?? '10+2 / Graduation with required aggregate' }}</small></td>
                                    <td>
                                        <button class="btn btn-gold btn-sm fw-bold px-3" data-bs-toggle="modal" data-bs-target="#counselingModal" onclick="document.querySelector('#counselingModal select[name=course_id]').value='{{ $cc->course_id }}'">
                                            Apply
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-3 text-muted">Courses information is being updated. Contact support for instant fee quotation.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- D. Facilities & Amenities -->
            <div class="detail-card">
                <h5 class="detail-card-title"><i class="bi bi-buildings-fill text-warning"></i> Campus Facilities & Infrastructure</h5>
                <div class="d-flex flex-wrap gap-2">
                    <div class="facility-badge"><i class="bi bi-wifi text-primary"></i> High-Speed Wi-Fi</div>
                    <div class="facility-badge"><i class="bi bi-book text-success"></i> Central Library</div>
                    @if($college->has_boys_hostel) <div class="facility-badge"><i class="bi bi-house text-dark"></i> Boys Hostel</div> @endif
                    @if($college->has_girls_hostel) <div class="facility-badge"><i class="bi bi-house-heart text-danger"></i> Girls Hostel</div> @endif
                    <div class="facility-badge"><i class="bi bi-cup-hot text-warning"></i> Cafeteria</div>
                    <div class="facility-badge"><i class="bi bi-dribbble text-danger"></i> Sports Complex</div>
                    <div class="facility-badge"><i class="bi bi-hospital text-info"></i> Medical Center</div>
                    <div class="facility-badge"><i class="bi bi-bus-front text-secondary"></i> Transport Services</div>
                </div>
            </div>

            <!-- E. Frequently Asked Questions (FAQs) -->
            <div class="detail-card">
                <h5 class="detail-card-title"><i class="bi bi-question-circle-fill text-info"></i> Frequently Asked Questions</h5>
                <div class="accordion" id="collegeFaqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Is {{ $college->name }} UGC & Government Approved?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#collegeFaqAccordion">
                            <div class="accordion-body text-secondary small">
                                Yes, {{ $college->name }} holds proper accreditations including {{ $college->approvals ?? 'UGC and statutory regulatory approvals' }}, making degrees valid for government and private sector jobs globally.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Are scholarships or No-Cost EMI options available?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#collegeFaqAccordion">
                            <div class="accordion-body text-secondary small">
                                Yes, merit-based scholarships and zero-interest EMI loan assistance are provided to eligible students during counseling.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Related Colleges Column -->
        <div class="col-lg-4">
            <div class="detail-card">
                <h6 class="fw-bold mb-3" style="color: var(--primary-purple);"><i class="bi bi-building me-1 text-warning"></i> Similar Colleges Nearby</h6>
                @forelse($relatedColleges as $rel)
                    <div class="d-flex gap-3 mb-3 pb-3 border-bottom">
                        <img src="{{ $rel->banner_image ?? 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=150&q=80' }}" class="rounded-3" style="width: 75px; height: 60px; object-fit: cover;">
                        <div>
                            <a href="{{ route('college.show', $rel->slug) }}" class="fw-bold text-dark text-decoration-none small d-block mb-1">
                                {{ $rel->name }}
                            </a>
                            <small class="text-muted"><i class="bi bi-geo-alt me-1 text-danger"></i>{{ $rel->city }} • <i class="bi bi-star-fill text-warning"></i> {{ $rel->rating }}</small>
                        </div>
                    </div>
                @empty
                    <p class="text-muted small mb-0">Explore more colleges in our directory.</p>
                @endforelse
                <a href="{{ route('colleges.regular') }}" class="btn btn-outline-purple btn-sm w-100 mt-2">View All Colleges</a>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    document.getElementById('collegeDetailLeadForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const btn = form.querySelector('button[type=submit]');
        const msgDiv = document.getElementById('collegeDetailFormMsg');

        btn.disabled = true;
        btn.innerText = 'Submitting Application...';

        fetch("{{ route('lead.submit') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                "Accept": "application/json"
            },
            body: new FormData(form)
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerText = 'Get Free Counselling & Brochure';
            msgDiv.innerHTML = `<div class="alert alert-success py-2 small mt-2">${data.message}</div>`;
            form.reset();
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerText = 'Get Free Counselling & Brochure';
            msgDiv.innerHTML = `<div class="alert alert-danger py-2 small mt-2">Submission failed. Please try again.</div>`;
        });
    });
</script>
@endpush

@endsection