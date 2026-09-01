@extends('layouts.app')
@section('title', $pageTitle . ' - GrowPec')

@push('styles')
<style>
    .listing-header {
        background: linear-gradient(135deg, #1E1346 0%, #2E1E6B 100%);
        color: #ffffff;
        padding: 35px 0;
    }

    .filter-sidebar {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #E5E7EB;
        padding: 20px;
        position: sticky;
        top: 90px;
        max-height: calc(100vh - 110px);
        overflow-y: auto;
    }

    .filter-sidebar::-webkit-scrollbar {
        width: 5px;
    }

    .filter-sidebar::-webkit-scrollbar-thumb {
        background: #CBD5E1;
        border-radius: 4px;
    }

    .filter-group {
        border-bottom: 1px solid #F3F4F6;
        padding-bottom: 14px;
        margin-bottom: 14px;
    }

    .filter-group:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .filter-title {
        font-weight: 700;
        font-size: 0.92rem;
        color: var(--primary-purple);
        margin-bottom: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .filter-inner-search {
        border-radius: 8px;
        font-size: 0.8rem;
        padding: 5px 10px;
        margin-bottom: 8px;
        border: 1px solid #E2E8F0;
        background: #F8FAFC;
    }

    .filter-options {
        max-height: 150px;
        overflow-y: auto;
        padding-right: 5px;
    }

    .filter-options::-webkit-scrollbar {
        width: 4px;
    }

    .filter-options::-webkit-scrollbar-thumb {
        background: #E2E8F0;
        border-radius: 4px;
    }

    .form-check-label {
        font-size: 0.84rem;
        color: #475569;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: var(--primary-purple);
        border-color: var(--primary-purple);
    }

    /* Result Card */
    .college-list-card {
        background: #ffffff;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 18px;
        margin-bottom: 18px;
        transition: all 0.25s ease;
    }

    .college-list-card:hover {
        border-color: var(--primary-purple);
        box-shadow: 0 10px 25px rgba(46, 30, 107, 0.08);
        transform: translateY(-2px);
    }

    .college-list-img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 12px;
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
        <h2 class="fw-bold mb-1">{{ $pageTitle }}</h2>
        <p class="text-white-50 small mb-0">Showing {{ $colleges->total() }} institutes matching your criteria</p>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">
        <!-- Left Filter Sidebar -->
        <div class="col-lg-3">
            <form action="{{ url()->current() }}" method="GET" id="filterForm">
                <div class="filter-sidebar shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-funnel-fill text-warning me-1"></i> Filter By</h6>
                        <a href="{{ url()->current() }}" class="text-danger small fw-bold text-decoration-none">Reset All</a>
                    </div>

                    <!-- Search Input -->
                    <div class="mb-3">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0" placeholder="Search college, city...">
                        </div>
                    </div>

                    <!-- 1. Degree Level (UG, PG, PhD, Diploma) -->
                    <div class="filter-group">
                        <div class="filter-title">1. Education Level</div>
                        <div class="filter-options">
                            @foreach(['UG' => 'Undergraduate (UG)', 'PG' => 'Postgraduate (PG)', 'Diploma' => 'Diploma', 'PhD' => 'Ph.D. / Doctorate', 'Certificate' => 'Certificate'] as $val => $label)
                            <div class="form-check mb-1">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="levels[]" value="{{ $val }}" id="level_{{ $val }}" {{ in_array($val, (array)request('levels')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="level_{{ $val }}">{{ $label }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 2. Academic Stream (Admin Managed) -->
                    <div class="filter-group">
                        <div class="filter-title">2. Stream</div>
                        <input type="text" class="form-control form-control-sm filter-inner-search" placeholder="Search stream (e.g. Arts, Commerce)..." data-target="#streamFilterOptions">
                        <div class="filter-options" id="streamFilterOptions">
                            @foreach($allStreams as $st)
                            <div class="form-check mb-1 filter-item-row">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="streams[]" value="{{ $st->slug }}" id="stream_{{ $st->id }}" {{ in_array($st->slug, (array)request('streams')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="stream_{{ $st->id }}">{{ $st->name }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 3. Course (Admin Managed) -->
                    <div class="filter-group">
                        <div class="filter-title">3. Course / Program</div>
                        <input type="text" class="form-control form-control-sm filter-inner-search" placeholder="Search course (e.g. BCA, ANM, B.Tech)..." data-target="#courseFilterOptions">
                        <div class="filter-options" id="courseFilterOptions">
                            @foreach($allCourses as $c)
                            <div class="form-check mb-1 filter-item-row">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="courses[]" value="{{ $c->slug }}" id="course_{{ $c->id }}" {{ in_array($c->slug, (array)request('courses')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="course_{{ $c->id }}">{{ $c->name }} <small class="text-muted">({{ $c->level }})</small></label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 4. Degree Type (Degree, Diploma) -->
                    <div class="filter-group">
                        <div class="filter-title">4. Degree Type</div>
                        <div class="filter-options">
                            @foreach(['Degree' => 'Degree Program', 'Diploma' => 'Diploma Program', 'Certificate' => 'Certificate Program'] as $dtVal => $dtLabel)
                            <div class="form-check mb-1">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="degree_types[]" value="{{ $dtVal }}" id="dt_{{ $dtVal }}" {{ in_array($dtVal, (array)request('degree_types')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="dt_{{ $dtVal }}">{{ $dtLabel }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 5. Duration (1 Year, 2 Years, 3 Years, etc.) -->
                    @if($allDurations->count() > 0)
                    <div class="filter-group">
                        <div class="filter-title">5. Course Duration</div>
                        <div class="filter-options">
                            @foreach($allDurations as $dur)
                            <div class="form-check mb-1">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="durations[]" value="{{ $dur }}" id="dur_{{ $loop->index }}" {{ in_array($dur, (array)request('durations')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="dur_{{ $loop->index }}">{{ $dur }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- 6. State (Admin Managed) -->
                    <div class="filter-group">
                        <div class="filter-title">6. State</div>
                        <input type="text" class="form-control form-control-sm filter-inner-search" placeholder="Search state (e.g. Uttar Pradesh, Bihar)..." data-target="#stateFilterOptions">
                        <div class="filter-options" id="stateFilterOptions">
                            @foreach($allStates as $state)
                            <div class="form-check mb-1 filter-item-row">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="states[]" value="{{ $state }}" id="state_{{ $loop->index }}" {{ in_array($state, (array)request('states')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="state_{{ $loop->index }}">{{ $state }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 7. City (Admin Managed) -->
                    <div class="filter-group">
                        <div class="filter-title">7. City</div>
                        <input type="text" class="form-control form-control-sm filter-inner-search" placeholder="Search city (e.g. Lucknow, Noida, Mumbai)..." data-target="#cityFilterOptions">
                        <div class="filter-options" id="cityFilterOptions">
                            @foreach($allCities as $city)
                            <div class="form-check mb-1 filter-item-row">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="cities[]" value="{{ $city }}" id="city_{{ $loop->index }}" {{ in_array($city, (array)request('cities')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="city_{{ $loop->index }}">{{ $city }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 8. College Type (Govt, Private) -->
                    <div class="filter-group">
                        <div class="filter-title">8. College Ownership</div>
                        <div class="filter-options">
                            @foreach(['Govt' => 'Government University', 'Private' => 'Private University', 'Deemed' => 'Deemed University', 'Autonomous' => 'Autonomous Institute'] as $tVal => $tLabel)
                            <div class="form-check mb-1">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="types[]" value="{{ $tVal }}" id="type_{{ $tVal }}" {{ in_array($tVal, (array)request('types')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="type_{{ $tVal }}">{{ $tLabel }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 9. Fee Range (Less than 1L to Greater than 10L) -->
                    <div class="filter-group">
                        <div class="filter-title">9. Annual Fee Range</div>
                        <div class="filter-options">
                            @php
                            $feeOptions = [
                            'under_1l' => 'Less than ₹1 Lac',
                            '1l_to_2l' => '₹1 Lac - ₹2 Lac',
                            '2l_to_3l' => '₹2 Lac - ₹3 Lac',
                            '3l_to_5l' => '₹3 Lac - ₹5 Lac',
                            '5l_to_10l' => '₹5 Lac - ₹10 Lac',
                            'above_10l' => 'Greater than ₹10+ Lac',
                            ];
                            @endphp
                            @foreach($feeOptions as $fVal => $fLabel)
                            <div class="form-check mb-1">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="fee_ranges[]" value="{{ $fVal }}" id="fee_{{ $fVal }}" {{ in_array($fVal, (array)request('fee_ranges')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="fee_{{ $fVal }}">{{ $fLabel }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 10. Hostel Facilities -->
                    <div class="filter-group">
                        <div class="filter-title">10. Hostel Facilities</div>
                        <div class="form-check mb-1">
                            <input class="form-check-input filter-checkbox" type="checkbox" name="boys_hostel" value="1" id="boys_hostel" {{ request('boys_hostel') ? 'checked' : '' }}>
                            <label class="form-check-label" for="boys_hostel"><i class="bi bi-house text-primary me-1"></i> Boys Hostel</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input filter-checkbox" type="checkbox" name="girls_hostel" value="1" id="girls_hostel" {{ request('girls_hostel') ? 'checked' : '' }}>
                            <label class="form-check-label" for="girls_hostel"><i class="bi bi-house-heart text-danger me-1"></i> Girls Hostel</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-purple btn-sm w-100 mt-3 fw-bold">Apply Filters</button>
                </div>
            </form>
        </div>

        <!-- Right Results Listing -->
        <div class="col-lg-9">
            <!-- Active Filter Badges Counter -->
            @php
            $activeCount = count(array_filter([
            request('search'), request('levels'), request('streams'), request('courses'),
            request('degree_types'), request('durations'), request('states'), request('cities'),
            request('types'), request('fee_ranges'), request('boys_hostel'), request('girls_hostel')
            ]));
            @endphp

            @if($activeCount > 0)
            <div class="d-flex justify-content-between align-items-center mb-3 bg-white p-2 px-3 rounded-3 border">
                <small class="text-muted"><strong>{{ $activeCount }}</strong> active filter(s) applied</small>
                <a href="{{ url()->current() }}" class="btn btn-sm btn-outline-danger py-0 px-2 small">Clear Filters</a>
            </div>
            @endif

            @forelse($colleges as $college)
            <div class="college-list-card shadow-sm">
                <div class="row g-3 align-items-center">
                    <div class="col-md-3">
                        <img src="{{ $college->banner_url }}" class="college-list-img" alt="{{ $college->name }}">
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge bg-primary-subtle text-primary border small">{{ $college->college_type }}</span>
                            <span class="badge bg-{{ $college->college_mode == 'online' ? 'success' : 'dark' }}-subtle text-dark border small">
                                {{ strtoupper($college->college_mode) }}
                            </span>
                            <span class="badge bg-warning-subtle text-dark small fw-bold">
                                <i class="bi bi-star-fill text-warning me-1"></i>{{ $college->rating }} ({{ $college->reviews_count }})
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
                            <a href="tel:8858285271" class="btn btn-gold btn-sm fw-bold">
                                <i class="bi bi-telephone-fill me-1"></i> Free Counseling
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5 bg-white rounded-4 border">
                <i class="bi bi-search fs-1 text-muted d-block mb-2"></i>
                <h5 class="fw-bold text-dark">No colleges match your filters</h5>
                <p class="text-muted small">Try broadening your stream, course, or location selections.</p>
                <a href="{{ url()->current() }}" class="btn btn-outline-primary btn-sm">Reset All Filters</a>
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
    // 1. Auto-submit filter on any checkbox change
    document.querySelectorAll('.filter-checkbox').forEach(input => {
        input.addEventListener('change', () => {
            document.getElementById('filterForm').submit();
        });
    });

    // 2. Real-time Instant Search inside Filter Lists (Streams, Courses, States, Cities)
    document.querySelectorAll('.filter-inner-search').forEach(searchBox => {
        searchBox.addEventListener('keyup', function() {
            const targetContainer = document.querySelector(this.getAttribute('data-target'));
            const term = this.value.toLowerCase().trim();
            const items = targetContainer.querySelectorAll('.filter-item-row');
            items.forEach(item => {
                const label = item.querySelector('label').innerText.toLowerCase();
                if (label.includes(term)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush
@endsection