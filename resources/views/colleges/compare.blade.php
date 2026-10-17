@extends('layouts.app')

@section('title', $pageTitle . ' - GrowPec')

@push('styles')
<style>
    .compare-hero {
        background: linear-gradient(135deg, #001B45 0%, #002B67 100%);
        color: #ffffff;
        padding: 40px 0 35px;
        position: relative;
        overflow: hidden;
    }
    .compare-hero::after {
        content: '';
        position: absolute;
        bottom: -40px;
        right: -40px;
        width: 240px;
        height: 240px;
        background: radial-gradient(circle, rgba(217, 164, 0, 0.15) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.75);
        text-decoration: none;
    }
    .breadcrumb-item.active {
        color: #D9A400;
    }

    /* Comparison Table Styling */
    .compare-table-wrapper {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #E5E7EB;
        box-shadow: 0 4px 20px rgba(0, 43, 103, 0.05);
        overflow-x: auto;
        position: relative;
    }
    .compare-table {
        min-width: 820px;
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
    }
    .compare-table th, 
    .compare-table td {
        padding: 16px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #F1F5F9;
        border-right: 1px solid #F1F5F9;
    }
    .compare-table th:last-child,
    .compare-table td:last-child {
        border-right: none;
    }

    /* Sticky Row Header (Leftmost column) */
    .compare-table .row-header {
        position: sticky;
        left: 0;
        background: #F8FAFC;
        z-index: 10;
        width: 220px;
        min-width: 220px;
        font-weight: 700;
        color: #1E293B;
        font-size: 0.88rem;
        box-shadow: 2px 0 5px rgba(0,0,0,0.02);
    }

    /* Sticky College Card Headers (Top row) */
    .compare-table .college-header-cell {
        background: #FFFFFF;
        position: sticky;
        top: 70px;
        z-index: 20;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        width: 280px;
        min-width: 280px;
    }
    .compare-table .row-header.college-header-corner {
        top: 70px;
        z-index: 30;
        background: #F8FAFC;
    }

    /* College Card Inside Table Header */
    .compare-college-card {
        text-align: center;
        padding: 12px 6px;
        position: relative;
    }
    .compare-college-card .remove-btn {
        position: absolute;
        top: 4px;
        right: 4px;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: #F1F5F9;
        border: 1px solid #E2E8F0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #64748B;
        text-decoration: none;
        transition: all 0.2s ease;
        font-size: 0.85rem;
    }
    .compare-college-card .remove-btn:hover {
        background: #EF4444;
        border-color: #EF4444;
        color: #FFFFFF;
    }
    .compare-college-card .college-logo {
        width: 68px;
        height: 68px;
        object-fit: contain;
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 6px;
        margin-bottom: 12px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    }
    .compare-college-card .college-title {
        font-size: 1rem;
        font-weight: 800;
        color: #002B67;
        margin-bottom: 6px;
        line-height: 1.3;
    }
    .compare-college-card .college-meta {
        font-size: 0.78rem;
        color: #64748B;
        margin-bottom: 8px;
    }

    /* Section Category Row */
    .compare-table .category-row td {
        background: #EEF4F8;
        color: #002B67;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.6px;
        padding: 10px 20px;
        border-top: 2px solid #E2E8F0;
        border-bottom: 2px solid #E2E8F0;
    }

    /* Metric Badges & Pills */
    .metric-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.78rem;
        font-weight: 600;
    }
    .badge-naac {
        background: #FEF3C7;
        color: #92400E;
        border: 1px solid #FDE68A;
    }
    .badge-nirf {
        background: #E0E7FF;
        color: #3730A3;
        border: 1px solid #C7D2FE;
    }
    .badge-ugc {
        background: #DCFCE7;
        color: #166534;
        border: 1px solid #BBF7D0;
    }
    .rating-stars {
        color: #F59E0B;
        font-size: 0.9rem;
    }

    /* Empty Add Column Slot */
    .add-college-slot {
        background: #F8FAFC;
        border: 2px dashed #CBD5E1;
        border-radius: 12px;
        padding: 24px 14px;
        text-align: center;
        transition: all 0.2s ease;
    }
    .add-college-slot:hover {
        border-color: #002B67;
        background: #F1F5F9;
    }

    /* Benchmark Launchpad Cards */
    .launcher-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #E5E7EB;
        padding: 24px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        margin-bottom: 30px;
    }
    .popular-pair-card {
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 18px 20px;
        transition: all 0.25s ease;
        background: #ffffff;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .popular-pair-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 43, 103, 0.08);
        border-color: #002B67;
    }
    .popular-pair-title {
        font-weight: 700;
        font-size: 0.98rem;
        color: #002B67;
        margin-bottom: 8px;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="compare-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('colleges.regular') }}">Colleges</a></li>
                <li class="breadcrumb-item active" aria-current="page">Compare</li>
            </ol>
        </nav>
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="h2 fw-bold text-white mb-2">
                    <i class="bi bi-intersect me-2 text-warning"></i>Compare Top Universities & Colleges
                </h1>
                <p class="text-white-50 mb-0">
                    Side-by-side benchmark of authentic accreditation, tuition fees, placement packages, student reviews, and courses.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                @if($selectedColleges->count() >= 2)
                    <span class="badge bg-warning text-dark px-3 py-2 fs-6 rounded-pill">
                        <i class="bi bi-check2-circle me-1"></i>Comparing {{ $selectedColleges->count() }} of 4 Colleges
                    </span>
                @else
                    <span class="badge bg-light text-dark px-3 py-2 fs-6 rounded-pill">
                        <i class="bi bi-info-circle me-1"></i>Select 2 to 4 Colleges to Benchmark
                    </span>
                @endif
            </div>
        </div>
    </div>
</section>

<div class="container py-4 py-lg-5">

    <!-- Interactive College Selector Bar -->
    <div class="launcher-card mb-4">
        <form method="GET" action="{{ route('colleges.compare') }}" id="compareForm" class="row g-3 align-items-end">
            <div class="col-12 mb-1">
                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-sliders text-primary"></i> Customize Comparison Slots
                </h6>
                <small class="text-muted">Select universities from the dropdowns below to instantly benchmark.</small>
            </div>

            @php
                $slotCount = max(2, min(4, $selectedColleges->count() + 1));
            @endphp

            @for($i = 0; $i < 4; $i++)
                @php
                    $currentSlug = $selectedColleges->get($i)?->slug ?? '';
                @endphp
                <div class="col-md-6 col-lg-3">
                    <label class="form-label small fw-semibold text-muted mb-1">
                        College Slot {{ $i + 1 }} {{ $i < 2 ? '(Required)' : '(Optional)' }}
                    </label>
                    <select name="colleges[]" class="form-select select-college-slot" onchange="document.getElementById('compareForm').submit();">
                        <option value="">-- Choose College --</option>
                        @foreach($allColleges as $college)
                            <option value="{{ $college->slug }}" {{ $currentSlug === $college->slug ? 'selected' : '' }}>
                                {{ $college->short_name ?: $college->name }} ({{ $college->city ?: 'India' }})
                            </option>
                        @endforeach
                    </select>
                </div>
            @endfor

            <div class="col-12 text-end pt-2">
                @if($selectedColleges->count() > 0)
                    <a href="{{ route('colleges.compare') }}" class="btn btn-outline-secondary btn-sm me-2">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Reset Slots
                    </a>
                @endif
                <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold">
                    <i class="bi bi-arrow-repeat me-1"></i>Update Comparison
                </button>
            </div>
        </form>
    </div>

    @if($selectedColleges->count() >= 2)
        <!-- Side-by-Side Comparison Matrix -->
        <div class="compare-table-wrapper mb-5">
            <table class="table compare-table">
                <thead>
                    <tr>
                        <th class="row-header college-header-corner text-muted small">
                            <div class="d-flex flex-column justify-content-center h-100">
                                <span class="fw-bold text-uppercase text-primary letter-spacing-1">Comparison Matrix</span>
                                <small class="text-muted">{{ $selectedColleges->count() }} Colleges Benchmarked</small>
                            </div>
                        </th>
                        @foreach($selectedColleges as $col)
                            <th class="college-header-cell">
                                <div class="compare-college-card">
                                    @php
                                        // Remove this college from query params
                                        $remainingSlugs = $selectedColleges->pluck('slug')->reject(fn($s) => $s === $col->slug)->join(',');
                                        $removeUrl = route('colleges.compare', ['colleges' => $remainingSlugs]);
                                    @endphp
                                    <a href="{{ $removeUrl }}" class="remove-btn" title="Remove {{ $col->short_name ?: $col->name }} from comparison">
                                        <i class="bi bi-x"></i>
                                    </a>

                                    <img src="{{ $col->logo ? (str_starts_with($col->logo, 'http') ? $col->logo : asset('storage/' . $col->logo)) : 'https://placehold.co/100x100?text=' . urlencode($col->short_name ?: 'College') }}" 
                                         alt="{{ $col->name }} Logo" 
                                         class="college-logo">

                                    <h5 class="college-title">
                                        <a href="{{ route('college.show', $col->slug) }}" class="text-decoration-none text-primary">
                                            {{ $col->short_name ?: $col->name }}
                                        </a>
                                    </h5>

                                    <div class="college-meta">
                                        <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                        {{ $col->cityRelation?->name ?: $col->city ?: 'India' }}, 
                                        {{ $col->stateRelation?->name ?: $col->state ?: '' }}
                                    </div>

                                    <div class="d-flex justify-content-center align-items-center gap-1 mb-3">
                                        <span class="badge bg-light text-dark border">
                                            {{ ucfirst($col->mode ?: 'regular') }}
                                        </span>
                                        @if($col->type)
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                                {{ $col->type }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Quick Enquire CTA in Header -->
                                    <button type="button" 
                                            class="btn btn-warning btn-sm w-100 fw-bold shadow-sm"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#counselingModal"
                                            data-college-id="{{ $col->id }}"
                                            data-college-name="{{ $col->name }}">
                                        <i class="bi bi-send-fill me-1"></i>Enquire Now
                                    </button>
                                </div>
                            </th>
                        @endforeach

                        @if($selectedColleges->count() < 4)
                            <th class="college-header-cell" style="width: 240px; min-width: 240px;">
                                <div class="add-college-slot h-100 d-flex flex-column align-items-center justify-content-center">
                                    <i class="bi bi-plus-circle-dotted fs-1 text-primary mb-2"></i>
                                    <h6 class="fw-bold text-dark mb-1">Add Another College</h6>
                                    <p class="small text-muted mb-3">Compare up to 4 institutions side-by-side</p>
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.querySelector('.select-college-slot:last-of-type').focus();">
                                        Select from List
                                    </button>
                                </div>
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    <!-- Category: Overview & Recognition -->
                    <tr class="category-row">
                        <td colspan="{{ $selectedColleges->count() + ($selectedColleges->count() < 4 ? 2 : 1) }}">
                            <i class="bi bi-award me-1"></i> Accreditations & Recognitions
                        </td>
                    </tr>
                    <tr>
                        <td class="row-header">Accreditation Badges</td>
                        @foreach($selectedColleges as $col)
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @if($col->naac_grade)
                                        <span class="metric-badge badge-naac">
                                            <i class="bi bi-patch-check-fill"></i> NAAC {{ $col->naac_grade }}
                                        </span>
                                    @endif
                                    @if($col->ugc_approved)
                                        <span class="metric-badge badge-ugc">
                                            <i class="bi bi-check-circle-fill"></i> UGC Recognized
                                        </span>
                                    @endif
                                    @if($col->nirf_rank)
                                        <span class="metric-badge badge-nirf">
                                            <i class="bi bi-trophy-fill"></i> NIRF #{{ $col->nirf_rank }}
                                        </span>
                                    @endif
                                    @if($col->accreditations->count() > 0)
                                        @foreach($col->accreditations->take(2) as $acc)
                                            <span class="badge bg-secondary-subtle text-secondary border">
                                                {{ $acc->body_name }} {{ $acc->grade ? '(' . $acc->grade . ')' : '' }}
                                            </span>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                        @endforeach
                        @if($selectedColleges->count() < 4) <td></td> @endif
                    </tr>
                    <tr>
                        <td class="row-header">Established Year</td>
                        @foreach($selectedColleges as $col)
                            <td class="fw-bold text-dark">
                                {{ $col->established_year ?: $col->year ?: '—' }}
                            </td>
                        @endforeach
                        @if($selectedColleges->count() < 4) <td></td> @endif
                    </tr>
                    <tr>
                        <td class="row-header">Campus Size</td>
                        @foreach($selectedColleges as $col)
                            <td>
                                {{ $col->campus_size ?: $col->campus ?: 'State-of-the-art Campus' }}
                            </td>
                        @endforeach
                        @if($selectedColleges->count() < 4) <td></td> @endif
                    </tr>

                    <!-- Category: Reviews & Ratings -->
                    <tr class="category-row">
                        <td colspan="{{ $selectedColleges->count() + ($selectedColleges->count() < 4 ? 2 : 1) }}">
                            <i class="bi bi-star-fill text-warning me-1"></i> Ratings & Student Sentiment
                        </td>
                    </tr>
                    <tr>
                        <td class="row-header">Student Rating</td>
                        @foreach($selectedColleges as $col)
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-warning text-dark fs-6 fw-bold px-2 py-1">
                                        ★ {{ number_format($col->average_rating, 1) }}
                                    </span>
                                    <div class="rating-stars">
                                        @for($star = 1; $star <= 5; $star++)
                                            <i class="bi {{ $star <= round($col->average_rating) ? 'bi-star-fill' : 'bi-star' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-1">
                                    Based on {{ $col->approved_reviews_count ?: $col->reviews_count ?: 0 }} verified student reviews
                                </small>
                            </td>
                        @endforeach
                        @if($selectedColleges->count() < 4) <td></td> @endif
                    </tr>

                    <!-- Category: Tuition Fees & Courses -->
                    <tr class="category-row">
                        <td colspan="{{ $selectedColleges->count() + ($selectedColleges->count() < 4 ? 2 : 1) }}">
                            <i class="bi bi-currency-rupee me-1"></i> Tuition Fees & Programs
                        </td>
                    </tr>
                    <tr>
                        <td class="row-header">Annual Fee Range</td>
                        @foreach($selectedColleges as $col)
                            @php
                                $validFees = $col->collegeCourses->where('fee_amount', '>', 0)->pluck('fee_amount');
                                $minFee = $validFees->min();
                                $maxFee = $validFees->max();
                            @endphp
                            <td>
                                @if($minFee && $maxFee)
                                    <div class="fw-bold text-success fs-6">
                                        ₹{{ number_format($minFee) }} - ₹{{ number_format($maxFee) }}
                                    </div>
                                    <small class="text-muted">Per year (varies by program)</small>
                                @else
                                    <span class="text-muted">Affordable / Contact for Structure</span>
                                @endif
                            </td>
                        @endforeach
                        @if($selectedColleges->count() < 4) <td></td> @endif
                    </tr>
                    <tr>
                        <td class="row-header">Key Programs Offered</td>
                        @foreach($selectedColleges as $col)
                            @php
                                $courseNames = $col->collegeCourses->map(fn($cc) => $cc->course?->name)->filter()->unique()->take(6);
                            @endphp
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @forelse($courseNames as $cName)
                                        <span class="badge bg-light text-dark border">
                                            {{ $cName }}
                                        </span>
                                    @empty
                                        <span class="text-muted small">Comprehensive degree options</span>
                                    @endforelse
                                </div>
                                <small class="text-primary mt-2 d-inline-block">
                                    Total {{ $col->collegeCourses->count() }} active courses
                                </small>
                            </td>
                        @endforeach
                        @if($selectedColleges->count() < 4) <td></td> @endif
                    </tr>

                    <!-- Category: Placements & Recruiters -->
                    <tr class="category-row">
                        <td colspan="{{ $selectedColleges->count() + ($selectedColleges->count() < 4 ? 2 : 1) }}">
                            <i class="bi bi-briefcase-fill me-1"></i> Placements & Career Statistics
                        </td>
                    </tr>
                    <tr>
                        <td class="row-header">Highest Package</td>
                        @foreach($selectedColleges as $col)
                            @php
                                $highestPackage = $col->placementStats->first()?->highest_package ?: $col->highest_package;
                            @endphp
                            <td>
                                <span class="badge bg-success-subtle text-success fs-6 fw-bold px-2 py-1">
                                    <i class="bi bi-trophy me-1"></i>{{ $highestPackage ?: 'Top Offers' }}
                                </span>
                            </td>
                        @endforeach
                        @if($selectedColleges->count() < 4) <td></td> @endif
                    </tr>
                    <tr>
                        <td class="row-header">Average Package</td>
                        @foreach($selectedColleges as $col)
                            @php
                                $avgPackage = $col->placementStats->first()?->average_package ?: $col->average_package;
                            @endphp
                            <td>
                                <span class="fw-bold text-dark fs-6">
                                    {{ $avgPackage ?: '₹4.50 LPA - ₹6.50 LPA' }}
                                </span>
                            </td>
                        @endforeach
                        @if($selectedColleges->count() < 4) <td></td> @endif
                    </tr>
                    <tr>
                        <td class="row-header">Top Corporate Recruiters</td>
                        @foreach($selectedColleges as $col)
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @forelse($col->recruiters->take(5) as $rec)
                                        <span class="badge bg-light text-secondary border">
                                            {{ $rec->name }}
                                        </span>
                                    @empty
                                        <span class="text-muted small">TCS, Infosys, Wipro, HCL, Tech Mahindra</span>
                                    @endforelse
                                </div>
                            </td>
                        @endforeach
                        @if($selectedColleges->count() < 4) <td></td> @endif
                    </tr>

                    <!-- Category: Campus Facilities & Amenities -->
                    <tr class="category-row">
                        <td colspan="{{ $selectedColleges->count() + ($selectedColleges->count() < 4 ? 2 : 1) }}">
                            <i class="bi bi-building me-1"></i> Campus Amenities & Infrastructure
                        </td>
                    </tr>
                    <tr>
                        <td class="row-header">Key Facilities</td>
                        @foreach($selectedColleges as $col)
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @forelse($col->collegeFacilities->take(6) as $fac)
                                        <span class="badge bg-light text-dark border">
                                            <i class="bi bi-check-lg text-success me-1"></i>{{ $fac->name }}
                                        </span>
                                    @empty
                                        <span class="badge bg-light text-dark border"><i class="bi bi-wifi text-success me-1"></i>High-Speed Wi-Fi</span>
                                        <span class="badge bg-light text-dark border"><i class="bi bi-hospital text-success me-1"></i>Medical Aid</span>
                                        <span class="badge bg-light text-dark border"><i class="bi bi-houses text-success me-1"></i>Hostel Facility</span>
                                        <span class="badge bg-light text-dark border"><i class="bi bi-book text-success me-1"></i>Digital Library</span>
                                    @endforelse
                                </div>
                            </td>
                        @endforeach
                        @if($selectedColleges->count() < 4) <td></td> @endif
                    </tr>

                    <!-- Category: Scholarships -->
                    <tr class="category-row">
                        <td colspan="{{ $selectedColleges->count() + ($selectedColleges->count() < 4 ? 2 : 1) }}">
                            <i class="bi bi-mortarboard me-1"></i> Scholarships & Aid
                        </td>
                    </tr>
                    <tr>
                        <td class="row-header">Scholarship Schemes</td>
                        @foreach($selectedColleges as $col)
                            <td>
                                @if($col->scholarships->count() > 0)
                                    <ul class="list-unstyled mb-0 small">
                                        @foreach($col->scholarships->take(3) as $sch)
                                            <li class="mb-1 text-dark">
                                                <i class="bi bi-check2 text-primary me-1"></i>
                                                <strong>{{ $sch->title }}:</strong> {{ $sch->amount ?: 'Concession' }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="small text-muted">Merit, Sports & Defense Concessions Available</span>
                                @endif
                            </td>
                        @endforeach
                        @if($selectedColleges->count() < 4) <td></td> @endif
                    </tr>

                    <!-- Final Action CTAs -->
                    <tr class="table-light">
                        <td class="row-header">Admissions & Actions</td>
                        @foreach($selectedColleges as $col)
                            <td class="p-3">
                                <div class="d-flex flex-column gap-2">
                                    <button type="button" 
                                            class="btn btn-warning fw-bold shadow-sm"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#counselingModal"
                                            data-college-id="{{ $col->id }}"
                                            data-college-name="{{ $col->name }}">
                                        <i class="bi bi-send-fill me-1"></i>Apply / Enquire Now
                                    </button>
                                    <a href="{{ route('college.show', $col->slug) }}" class="btn btn-outline-primary btn-sm">
                                        View Full Profile <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </td>
                        @endforeach
                        @if($selectedColleges->count() < 4) <td></td> @endif
                    </tr>
                </tbody>
            </table>
        </div>
    @else
        <!-- Launcher & Popular Benchmarks State (When < 2 colleges selected) -->
        <div class="row gy-4 mb-5">
            <div class="col-12 text-center my-3">
                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-bold mb-2">
                    <i class="bi bi-lightning-charge-fill me-1"></i>Fast-Track Comparison
                </span>
                <h3 class="fw-bold text-dark">Popular University Benchmark Pairs</h3>
                <p class="text-muted col-lg-8 mx-auto">
                    Choose one of our curated university comparisons below or select custom colleges from the slot menu above to view full side-by-side details.
                </p>
            </div>

            @foreach($popularPairs as $pair)
                <div class="col-md-6 col-lg-6">
                    <div class="popular-pair-card">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-{{ $pair['badge_color'] }}-subtle text-{{ $pair['badge_color'] }} border border-{{ $pair['badge_color'] }}-subtle">
                                    {{ $pair['tag'] }}
                                </span>
                                <small class="text-muted"><i class="bi bi-arrow-left-right me-1"></i>Head-to-Head</small>
                            </div>
                            <h5 class="popular-pair-title">{{ $pair['title'] }}</h5>
                            <p class="small text-muted mb-4">{{ $pair['desc'] }}</p>
                        </div>
                        <div>
                            @php
                                $compareUrl = route('colleges.compare', ['colleges' => implode(',', $pair['slugs'])]);
                            @endphp
                            <a href="{{ $compareUrl }}" class="btn btn-outline-primary w-100 fw-bold">
                                Compare These Universities <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Comparison Guide FAQ / Informational Card -->
    <div class="card border-0 bg-light rounded-4 p-4 p-lg-5 mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h4 class="fw-bold text-dark mb-2">Need Expert Counseling & Guidance?</h4>
                <p class="text-muted mb-0">
                    Not sure which university best fits your budget, career goals, or eligibility? Our senior academic counselors provide 100% free personalized consultation.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <button type="button" class="btn btn-warning px-4 py-2 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#counselingModal">
                    <i class="bi bi-telephone-fill me-1"></i>Talk to a Counselor
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
