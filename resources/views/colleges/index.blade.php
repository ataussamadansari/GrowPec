@extends('layouts.app')

@section('title', $pageTitle . ' - GrowPec')

@push('styles')
<style>
    .listing-header {
        background: var(--primary-purple);
        color: #ffffff;
        padding: 35px 0;
    }
    .filter-sidebar {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #E5E7EB;
        padding: 20px;
    }
    .filter-group {
        border-bottom: 1px solid #F3F4F6;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }
    .filter-group:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }
    .filter-title {
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--primary-purple);
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .filter-options {
        max-height: 180px;
        overflow-y: auto;
        padding-right: 5px;
    }
    .filter-options::-webkit-scrollbar {
        width: 4px;
    }
    .filter-options::-webkit-scrollbar-thumb {
        background: #CBD5E1;
        border-radius: 4px;
    }
    .form-check-label {
        font-size: 0.88rem;
        color: #4B5563;
        cursor: pointer;
    }
    .form-check-input:checked {
        background-color: var(--primary-purple);
        border-color: var(--primary-purple);
    }

    /* College Result Card */
    .college-list-card {
        background: #ffffff;
        border: 1px solid #E5E7EB;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 20px;
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
    }
    .college-list-card:hover {
        border-color: var(--primary-purple);
        box-shadow: 0 10px 25px rgba(0,0,0,0.06);
    }
    .college-list-img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: 12px;
    }
    .promo-banner {
        background: linear-gradient(135deg, #2E1E6B 0%, #1E1346 100%);
        color: #ffffff;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 25px;
    }
</style>
@endpush

@section('content')

<!-- Header Banner -->
<div class="listing-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small text-white-50">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-warning text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ $pageTitle }}</li>
            </ol>
        </nav>
        <h2 class="fw-bold mb-0">{{ $pageTitle }}</h2>
        <p class="text-white-50 small mb-0">Showing {{ $colleges->total() }} verified institutes matching your criteria</p>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">
        
        <!-- Left Filter Sidebar -->
        <div class="col-lg-3">
            <form action="{{ url()->current() }}" method="GET" id="filterForm">
                <div class="filter-sidebar shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-funnel me-1 text-warning"></i> Filters</h6>
                        <a href="{{ url()->current() }}" class="text-danger small fw-bold text-decoration-none">Reset All</a>
                    </div>

                    <!-- Search Input -->
                    <div class="mb-3">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search by name, city...">
                    </div>

                    <!-- 1. Degree Level -->
                    <div class="filter-group">
                        <div class="filter-title">Level</div>
                        <div class="filter-options">
                            @foreach(['UG' => 'Undergraduate (UG)', 'PG' => 'Postgraduate (PG)', 'Diploma' => 'Diploma', 'PhD' => 'Ph.D.'] as $val => $label)
                                <div class="form-check mb-1">
                                    <input class="form-check-input filter-checkbox" type="checkbox" name="levels[]" value="{{ $val }}" id="level_{{ $val }}" {{ in_array($val, (array)request('levels')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="level_{{ $val }}">{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 2. Course Stream -->
                    <div class="filter-group">
                        <div class="filter-title">Stream</div>
                        <div class="filter-options">
                            @foreach($allStreams as $st)
                                <div class="form-check mb-1">
                                    <input class="form-check-input filter-checkbox" type="checkbox" name="streams[]" value="{{ $st->slug }}" id="stream_{{ $st->id }}" {{ in_array($st->slug, (array)request('streams')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="stream_{{ $st->id }}">{{ $st->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 3. Specific Courses -->
                    <div class="filter-group">
                        <div class="filter-title">Course</div>
                        <div class="filter-options">
                            @foreach($allCourses as $c)
                                <div class="form-check mb-1">
                                    <input class="form-check-input filter-checkbox" type="checkbox" name="courses[]" value="{{ $c->slug }}" id="course_{{ $c->id }}" {{ in_array($c->slug, (array)request('courses')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="course_{{ $c->id }}">{{ $c->name }} ({{ $c->level }})</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 4. State -->
                    <div class="filter-group">
                        <div class="filter-title">State</div>
                        <div class="filter-options">
                            @foreach($allStates as $st)
                                <div class="form-check mb-1">
                                    <input class="form-check-input filter-checkbox" type="checkbox" name="states[]" value="{{ $st }}" id="state_{{ $loop->index }}" {{ in_array($st, (array)request('states')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="state_{{ $loop->index }}">{{ $st }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 5. City -->
                    <div class="filter-group">
                        <div class="filter-title">City</div>
                        <div class="filter-options">
                            @foreach($allCities as $city)
                                <div class="form-check mb-1">
                                    <input class="form-check-input filter-checkbox" type="checkbox" name="cities[]" value="{{ $city }}" id="city_{{ $loop->index }}" {{ in_array($city, (array)request('cities')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="city_{{ $loop->index }}">{{ $city }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 6. College Type -->
                    <div class="filter-group">
                        <div class="filter-title">College Type</div>
                        <div class="filter-options">
                            @foreach(['Private' => 'Private University', 'Govt' => 'Government University', 'Deemed' => 'Deemed University'] as $tVal => $tLabel)
                                <div class="form-check mb-1">
                                    <input class="form-check-input filter-checkbox" type="checkbox" name="types[]" value="{{ $tVal }}" id="type_{{ $tVal }}" {{ in_array($tVal, (array)request('types')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="type_{{ $tVal }}">{{ $tLabel }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 7. Fee Range -->
                    <div class="filter-group">
                        <div class="filter-title">Fee Range (Annual)</div>
                        <div>
                            @foreach(['under_1l' => 'Under ₹1 Lakh', '1l_to_2l' => '₹1 Lakh - ₹2 Lakh', '2l_to_3l' => '₹2 Lakh - ₹3 Lakh', 'above_3l' => 'Above ₹3 Lakh'] as $fVal => $fLabel)
                                <div class="form-check mb-1">
                                    <input class="form-check-input filter-checkbox" type="radio" name="fee_range" value="{{ $fVal }}" id="fee_{{ $fVal }}" {{ request('fee_range') == $fVal ? 'checked' : '' }}>
                                    <label class="form-check-label" for="fee_{{ $fVal }}">{{ $fLabel }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 8. Hostel Facility -->
                    <div class="filter-group">
                        <div class="filter-title">Hostel Facilities</div>
                        <div class="form-check mb-1">
                            <input class="form-check-input filter-checkbox" type="checkbox" name="boys_hostel" value="1" id="boys_hostel" {{ request('boys_hostel') ? 'checked' : '' }}>
                            <label class="form-check-label" for="boys_hostel"><i class="bi bi-gender-male text-primary me-1"></i> Boys Hostel</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input filter-checkbox" type="checkbox" name="girls_hostel" value="1" id="girls_hostel" {{ request('girls_hostel') ? 'checked' : '' }}>
                            <label class="form-check-label" for="girls_hostel"><i class="bi bi-gender-female text-danger me-1"></i> Girls Hostel</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-purple btn-sm w-100 mt-3">Apply Filters</button>
                </div>
            </form>
        </div>

        <!-- Right Results Listing -->
        <div class="col-lg-9">
            @forelse($colleges as $index => $college)
                
                <!-- Promo Banner after every 3 items -->
                @if($index === 2)
                    <div class="promo-banner d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <span class="badge bg-warning text-dark fw-bold mb-1">Expert Mentorship</span>
                            <h5 class="fw-bold mb-1">Crack Your GD & Personal Interviews With Confidence</h5>
                            <small class="text-white-50">Free 1-on-1 Mock Interviews, Resume Screening & Profile Assessment.</small>
                        </div>
                        <button class="btn btn-gold btn-sm fw-bold px-4" data-bs-toggle="modal" data-bs-target="#counselingModal">
                            Book Free Session
                        </button>
                    </div>
                @endif

                <!-- College Card -->
                <div class="college-list-card shadow-sm">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-3">
                            <img src="{{ $college->banner_image ?? 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=500&q=80' }}" class="college-list-img" alt="{{ $college->name }}">
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-purple-subtle text-dark border small">{{ $college->college_type }}</span>
                                <span class="badge bg-warning-subtle text-dark small fw-bold">
                                    <i class="bi bi-star-fill text-warning me-1"></i>{{ $college->rating }} ({{ $college->reviews_count }} Reviews)
                                </span>
                            </div>
                            <h5 class="fw-bold mb-1">
                                <a href="{{ route('college.show', $college->slug) }}" class="text-decoration-none" style="color: var(--primary-purple);">
                                    {{ $college->name }}
                                </a>
                            </h5>
                            <p class="text-muted small mb-2">
                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $college->city }}, {{ $college->state }}
                                @if($college->established_year) • Estd. {{ $college->established_year }} @endif
                            </p>

                            @if($college->approvals)
                                <div class="small text-secondary mb-2">
                                    <i class="bi bi-shield-check text-success me-1"></i><strong>Approvals:</strong> {{ $college->approvals }}
                                </div>
                            @endif

                            <div class="d-flex flex-wrap gap-2 small text-muted">
                                @if($college->has_boys_hostel)
                                    <span class="badge bg-light text-secondary border"><i class="bi bi-house me-1"></i>Boys Hostel</span>
                                @endif
                                @if($college->has_girls_hostel)
                                    <span class="badge bg-light text-secondary border"><i class="bi bi-house-heart me-1"></i>Girls Hostel</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-3 text-md-end border-start-md pt-3 pt-md-0">
                            @if($college->highest_package)
                                <div class="mb-2">
                                    <small class="text-muted d-block">Highest Package</small>
                                    <span class="fw-bold text-success">{{ $college->highest_package }}</span>
                                </div>
                            @endif

                            <div class="d-grid gap-2">
                                <a href="{{ route('college.show', $college->slug) }}" class="btn btn-outline-primary btn-sm fw-bold">
                                    View Details
                                </a>
                                <button class="btn btn-gold btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#counselingModal" onclick="document.querySelector('#counselingModal input[name=city]').value='{{ $college->city }}'">
                                    Apply / Enquire
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <div class="text-center py-5 bg-white rounded-4 border">
                    <i class="bi bi-search fs-1 text-muted d-block mb-2"></i>
                    <h5 class="fw-bold text-dark">No colleges found</h5>
                    <p class="text-muted small">Try changing your filters or search keywords.</p>
                    <a href="{{ url()->current() }}" class="btn btn-outline-purple btn-sm">Reset All Filters</a>
                </div>
            @endforelse

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $colleges->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    // Auto submit filter on checkbox click
    document.querySelectorAll('.filter-checkbox').forEach(input => {
        input.addEventListener('change', () => {
            document.getElementById('filterForm').submit();
        });
    });
</script>
@endpush

@endsection