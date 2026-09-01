@extends('layouts.app')

@section('title', $college->name . ' - Admission, Courses, Fees, Placements & Brochure | GrowPec')

@push('styles')
<style>
    .college-header-section {
        background: #ffffff;
        border-bottom: 1px solid #E2E8F0;
        padding: 25px 0;
    }

    .college-main-banner {
        width: 100%;
        height: 320px;
        object-fit: cover;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    /* 🎯 Dynamic Left Quick Jump Sticky Navigation */
    .quick-nav-sidebar {
        position: sticky;
        top: 90px;
        background: #ffffff;
        border: 1px solid #E2E8F0;
        border-radius: 14px;
        padding: 10px 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    }

    .quick-nav-link {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 9px 12px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #475569;
        text-decoration: none;
        border-radius: 8px;
        margin-bottom: 4px;
        transition: all 0.2s ease-in-out;
    }

    .quick-nav-link:hover {
        background: #FAF8FF;
        color: #4E3797;
    }

    .quick-nav-link.active {
        background: #ECE8F6;
        color: #4E3797;
        font-weight: 700;
        border-left: 4px solid #4E3797;
    }

    /* Content Cards */
    .content-block {
        background: #ffffff;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 25px;
        scroll-margin-top: 105px;
    }

    .content-block-header {
        font-size: 1.25rem;
        font-weight: 800;
        color: #2E1E6B;
        margin-bottom: 18px;
        padding-bottom: 10px;
        border-bottom: 2px solid #F1EEF9;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* BoostMyTalent Yellow Header Table */
    .table-yellow-header thead th {
        background: #F59E0B !important;
        color: #000000 !important;
        font-weight: 700;
        padding: 12px 16px;
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
        border-left: 4px solid #4E3797;
        border-radius: 8px;
        padding: 15px 18px;
        margin-bottom: 12px;
    }

    .step-number {
        width: 32px;
        height: 32px;
        background: #4E3797;
        color: #fff;
        font-weight: bold;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.88rem;
    }

    /* Right Sticky Admission Card */
    .admission-support-card {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid #EEF2F6;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        position: sticky;
        top: 90px;
    }

    .form-label-custom {
        font-size: 0.82rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 4px;
        display: block;
    }

    .form-control-pill {
        border-radius: 25px !important;
        border: 1px solid #CBD5E1 !important;
        padding: 9px 18px !important;
        font-size: 0.88rem !important;
        color: #1E293B !important;
    }

    .btn-save-custom {
        background: #4E3797 !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        border-radius: 25px !important;
        font-size: 0.95rem !important;
    }
</style>
@endpush

@section('content')

<!-- Breadcrumb -->
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

<!-- Header Section: Full Banner, Info & Buttons -->
<div class="college-header-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <img src="{{ $college->banner_url }}" class="college-main-banner mb-4" alt="{{ $college->name }}">
                
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                    <div>
                        <div class="d-flex flex-wrap gap-2 mb-2">
                            <span class="badge bg-primary-subtle text-primary fw-bold">{{ $college->college_type }} University</span>
                            <span class="badge bg-{{ $college->college_mode == 'online' ? 'success' : 'dark' }}-subtle text-dark fw-bold">{{ strtoupper($college->college_mode) }}</span>
                            @if($college->approvals)
                            <span class="badge bg-warning-subtle text-dark fw-bold"><i class="bi bi-shield-check me-1"></i>{{ $college->approvals }}</span>
                            @endif
                            <span class="badge bg-light text-dark border fw-bold"><i class="bi bi-star-fill text-warning me-1"></i>{{ $college->rating }} ({{ $college->reviews_count }} Reviews)</span>
                        </div>

                        <h2 class="fw-bold mb-1" style="color: #2E1E6B;">{{ $college->name }}</h2>
                        <p class="text-muted small mb-3">
                            <i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $college->address ?? $college->city . ', ' . $college->state }}
                            @if($college->university_name) • Affiliated to: <strong>{{ $college->university_name }}</strong> @endif
                            @if($college->established_year) • Estd: <strong>{{ $college->established_year }}</strong> @endif
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap gap-2 align-self-md-center">
                        <a href="#admissionSupportForm" class="btn btn-purple btn-sm fw-bold px-4 py-2" style="background: #4E3797; color: #fff;">
                            <i class="bi bi-send-fill me-1"></i> Apply Now
                        </a>
                        @if($college->brochure_pdf)
                        <a href="{{ asset('storage/' . $college->brochure_pdf) }}" target="_blank" class="btn btn-warning btn-sm fw-bold px-4 py-2 text-dark">
                            <i class="bi bi-download me-1"></i> Download Brochure
                        </a>
                        @endif
                        <a href="https://wa.me/918858285271?text=Hello,%20I%20am%20interested%20in%20{{ urlencode($college->name) }}" target="_blank" class="btn btn-success btn-sm fw-bold px-3 py-2">
                            <i class="bi bi-whatsapp me-1"></i> WhatsApp Query
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Body: Dynamic Left Nav (2) + Content Blocks (6) + Sticky Form (4) = 12 Cols -->
<div class="container py-4">
    <div class="row g-4">

        <!-- 🎯 1. Dynamic Left Sticky Navigation (col-lg-2) -->
        <div class="col-lg-2 d-none d-lg-block">
            <div class="quick-nav-sidebar">
                <small class="text-muted fw-bold d-block mb-2 px-2">QUICK JUMP</small>
                @foreach($quickNav as $index => $nav)
                <a href="#{{ $nav['id'] }}" class="quick-nav-link {{ $index === 0 ? 'active' : '' }}" data-target="{{ $nav['id'] }}">
                    <i class="bi {{ $nav['icon'] }}"></i>
                    <span>{{ $nav['title'] }}</span>
                </a>
                @endforeach
            </div>
        </div>

        <!-- 2. Main Content Blocks (col-lg-6) -->
        <div class="col-lg-6">

            <!-- A. Quick Facts Table & Overview -->
            <div class="content-block" id="sec-overview">
                <h5 class="content-block-header"><i class="bi bi-info-circle-fill text-warning"></i> Quick Facts & Snapshot</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-yellow-header mb-0">
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
                                <td class="fw-semibold text-muted">Ownership / Status</td>
                                <td>{{ $college->college_type }} University</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">Approvals & Accreditations</td>
                                <td><span class="badge bg-success-subtle text-success border">{{ $college->approvals ?? 'UGC / AICTE Approved' }}</span></td>
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
                                <td class="fw-bold">{{ $college->average_package }}</td>
                            </tr>
                            @endif
                            @if($college->college_mode !== 'online')
                            <tr>
                                <td class="fw-semibold text-muted">Hostel Availability</td>
                                <td>
                                    @if($college->has_boys_hostel) <span class="badge bg-light text-dark border me-1">Boys Hostel</span> @endif
                                    @if($college->has_girls_hostel) <span class="badge bg-light text-dark border">Girls Hostel</span> @endif
                                    @if(!$college->has_boys_hostel && !$college->has_girls_hostel) <span class="text-muted">Day Scholar</span> @endif
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <h6 class="fw-bold text-dark mb-2">About {{ $college->name }}</h6>
                    <p class="text-secondary leading-relaxed mb-0 small">
                        {{ $college->overview ?? $college->name . ' is a premier institution located in '.$college->city.', '.$college->state.'. Offering industry-aligned programs with experienced faculty and career placement assistance.' }}
                    </p>
                </div>
            </div>

            <!-- B. Dynamic Key Highlights -->
            @if(!empty($college->highlights) && count($college->highlights) > 0)
            <div class="content-block" id="sec-highlights">
                <h5 class="content-block-header"><i class="bi bi-star-fill text-warning"></i> Key Highlights & USPs</h5>
                @foreach($college->highlights as $highlight)
                <div class="highlight-pill">
                    <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                    <span>{{ $highlight }}</span>
                </div>
                @endforeach
            </div>
            @endif

            <!-- C. Courses, Fees & Specializations -->
            @if($college->collegeCourses->count() > 0)
            <div class="content-block" id="sec-courses">
                <h5 class="content-block-header"><i class="bi bi-mortarboard-fill text-primary"></i> Courses, Fees & Specializations</h5>

                @foreach($college->collegeCourses as $cc)
                <div class="border rounded-3 p-3 mb-3 bg-light">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">{{ $cc->course->name }} <span class="badge bg-primary-subtle text-primary small">{{ $cc->course->level }}</span></h6>
                            <small class="text-muted">{{ $cc->course->duration }} • {{ $cc->specialization ?? 'General' }}</small>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-success fs-5">₹{{ number_format($cc->fee_amount) }}</div>
                            <small class="text-muted">/ {{ str_replace('_', ' ', $cc->fee_type) }}</small>
                        </div>
                    </div>

                    <div class="small text-secondary mb-3">
                        <strong>Eligibility:</strong> {{ $cc->eligibility ?? '10+2 / Graduation with required minimum aggregate' }}
                    </div>

                    <div class="d-flex gap-2">
                        <a href="#admissionSupportForm" class="btn btn-warning btn-sm fw-bold px-3 text-dark">
                            Apply for {{ $cc->course->name }}
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- D. Admission Process -->
            @if(!empty($college->admission_process))
            <div class="content-block" id="sec-admission">
                <h5 class="content-block-header"><i class="bi bi-card-checklist text-success"></i> Admission Process</h5>
                <div class="small text-secondary leading-relaxed">
                    {!! nl2br(e($college->admission_process)) !!}
                </div>
            </div>
            @endif

            <!-- E. Placements & Recruiters -->
            @if(!empty($college->highest_package) || !empty($college->average_package) || !empty($college->top_recruiters))
            <div class="content-block" id="sec-placements">
                <h5 class="content-block-header"><i class="bi bi-briefcase-fill text-danger"></i> Placement Records & Recruiters</h5>
                <div class="row g-3 mb-3 text-center">
                    @if($college->highest_package)
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <small class="text-muted d-block">Highest Package</small>
                            <h4 class="fw-bold text-success mb-0">{{ $college->highest_package }}</h4>
                        </div>
                    </div>
                    @endif
                    @if($college->average_package)
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <small class="text-muted d-block">Average Package</small>
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

            <!-- F. Scholarships -->
            @if(!empty($college->scholarship_info))
            <div class="content-block" id="sec-scholarships">
                <h5 class="content-block-header"><i class="bi bi-award-fill text-warning"></i> Scholarships & Financial Aid</h5>
                <p class="small text-secondary mb-0 leading-relaxed">{{ $college->scholarship_info }}</p>
            </div>
            @endif

            <!-- G. Sample Degree Certificate Preview -->
            @if($college->certificate_url)
            <div class="content-block" id="sec-certificate">
                <h5 class="content-block-header"><i class="bi bi-patch-check-fill text-success"></i> Sample Degree & Certification</h5>
                <p class="small text-muted mb-3">Degrees are approved by UGC, AICTE, and globally validated for government and corporate careers.</p>
                <div class="text-center p-3 bg-light rounded-3 border">
                    <img src="{{ $college->certificate_url }}" class="img-fluid rounded border shadow-sm" style="max-height: 340px;" alt="Sample Certificate">
                </div>
            </div>
            @endif

            <!-- H. Facilities -->
            @if($college->college_mode !== 'online' && ($college->has_boys_hostel || $college->has_girls_hostel || $college->campus_size))
            <div class="content-block" id="sec-facilities">
                <h5 class="content-block-header"><i class="bi bi-buildings-fill text-info"></i> Campus Amenities & Infrastructure</h5>
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

            <!-- I. Dynamic FAQs -->
            @if(!empty($college->faqs) && count($college->faqs) > 0)
            <div class="content-block" id="sec-faqs">
                <h5 class="content-block-header"><i class="bi bi-question-circle-fill text-warning"></i> Frequently Asked Questions</h5>
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

        <!-- 3. Right Sticky Admission Support Form (col-lg-4) -->
        <div class="col-lg-4">
            <div class="admission-support-card shadow-sm p-4">
                <h5 class="fw-bold mb-4" style="color: #2E1E6B; font-size: 1.15rem;">Get 1-on-1 Admission Support</h5>

                <form action="{{ route('lead.submit') }}" method="POST" id="admissionSupportForm">
                    @csrf
                    <input type="hidden" name="college_id" value="{{ $college->id }}">
                    <input type="hidden" name="source" value="college_detail_right_card">

                    <!-- Name -->
                    <div class="mb-3">
                        <label class="form-label form-label-custom">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-pill" placeholder="Enter your full name" required>
                    </div>

                    <!-- Mobile -->
                    <div class="mb-3">
                        <label class="form-label form-label-custom">Mobile <span class="text-danger">*</span></label>
                        <input type="tel" name="phone" class="form-control form-control-pill" placeholder="Enter WhatsApp number" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label form-label-custom">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control form-control-pill" placeholder="Enter email address" required>
                    </div>

                    <!-- Course -->
                    <div class="mb-3">
                        <label class="form-label form-label-custom">Course <span class="text-danger">*</span></label>
                        <select name="course_id" class="form-select form-control-pill" required>
                            <option value="">Select Options</option>
                            @foreach($college->collegeCourses as $cc)
                            <option value="{{ $cc->course_id }}">{{ $cc->course->name }} @if($cc->specialization) ({{ $cc->specialization }}) @endif</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- State -->
                    <div class="mb-3">
                        <label class="form-label form-label-custom">Current State <span class="text-danger">*</span></label>
                        <select name="state" id="leadCardStateSelect" class="form-select form-control-pill" required>
                            <option value="">Select Options</option>
                            @php
                            $leadStates = \App\Models\State::where('status', true)->orderBy('name')->get();
                            @endphp
                            @foreach($leadStates as $st)
                            <option value="{{ $st->name }}" data-id="{{ $st->id }}">{{ $st->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- City -->
                    <div class="mb-4">
                        <label class="form-label form-label-custom">Current City <span class="text-danger">*</span></label>
                        <select name="city" id="leadCardCitySelect" class="form-select form-control-pill" required>
                            <option value="">Select Options</option>
                        </select>
                    </div>

                    <div id="admissionSupportMsg"></div>

                    <button type="submit" id="admissionSupportBtn" class="btn btn-save-custom w-100 py-2">
                        Save
                    </button>

                    <p class="text-center text-muted mt-3 mb-0" style="font-size: 0.8rem;">
                        I accept and agree to the <a href="#" class="fw-bold text-dark text-decoration-none">Terms of Use</a>
                    </p>
                </form>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
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

    // Dynamic State -> City loading
    const stateDropdown = document.getElementById('leadCardStateSelect');
    const cityDropdown = document.getElementById('leadCardCitySelect');

    if (stateDropdown) {
        stateDropdown.addEventListener('change', function () {
            const selectedOpt = this.options[this.selectedIndex];
            const stateId = selectedOpt ? selectedOpt.getAttribute('data-id') : null;

            cityDropdown.innerHTML = '<option value="">Loading...</option>';

            if (stateId) {
                fetch(`/api/states/${stateId}/cities`)
                    .then(res => res.json())
                    .then(cities => {
                        cityDropdown.innerHTML = '<option value="">Select Options</option>';
                        cities.forEach(c => {
                            cityDropdown.innerHTML += `<option value="${c.name}">${c.name}</option>`;
                        });
                    })
                    .catch(() => {
                        cityDropdown.innerHTML = '<option value="">Select Options</option>';
                    });
            } else {
                cityDropdown.innerHTML = '<option value="">Select Options</option>';
            }
        });
    }

    // AJAX Lead Submission
    const leadForm = document.getElementById('admissionSupportForm');
    if (leadForm) {
        leadForm.addEventListener('submit', function (e) {
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
                btn.innerText = 'Save';
                msg.innerHTML = `<div class="alert alert-success py-2 small rounded-pill text-center mb-3">${data.message || 'Thank you! We will contact you soon.'}</div>`;
                leadForm.reset();
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerText = 'Save';
                msg.innerHTML = `<div class="alert alert-danger py-2 small rounded-pill text-center mb-3">Something went wrong. Try again.</div>`;
            });
        });
    }
});
</script>
@endpush

@endsection