@extends('layouts.app')

@section('title', $pageTitle . ' - ' . ($siteSettings['general.site_name'] ?? 'GrowPEC'))

@section('content')
<!-- Header Banner -->
<div class="bg-gradient-to-r from-purple-900 via-purple-800 to-purple-900 text-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-sm text-purple-200 mb-4">
            <a href="{{ route('home') }}" class="text-yellow-400 hover:text-yellow-300">Home</a>
            <span>/</span>
            <span class="text-white">{{ $pageTitle }}</span>
        </nav>
        <h1 class="text-4xl font-bold mb-2">{{ $pageTitle }}</h1>
        <p class="text-purple-100">Showing {{ $colleges->total() }} institutes matching your criteria</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Active Filter Counter - Mobile -->
    @php
    $activeCount = count(array_filter([
        request('search'), request('levels'), request('streams'), request('courses'),
        request('degree_types'), request('durations'), request('states'), request('cities'),
        request('types'), request('fee_ranges'), request('boys_hostel'), request('girls_hostel')
    ]));
    @endphp

    <div class="lg:hidden mb-4 flex justify-between items-center bg-white p-4 rounded-xl shadow border border-gray-200">
        <div>
            <h6 class="font-bold text-gray-900">Found {{ $colleges->total() }} Colleges</h6>
            <p class="text-sm text-gray-600">{{ $activeCount > 0 ? $activeCount . ' filter(s) active' : 'Filter by Stream, City, Fees...' }}</p>
        </div>
        <button class="px-4 py-2 bg-purple-900 text-white font-bold rounded-full text-sm hover:bg-purple-800 transition flex items-center gap-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas">
            <i class="bi bi-funnel-fill text-yellow-500"></i> Filter
            @if($activeCount > 0)
            <span class="inline-block bg-yellow-500 text-gray-900 text-xs font-bold px-2.5 py-0.5 rounded-full">{{ $activeCount }}</span>
            @endif
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        
        <!-- SIDEBAR FILTERS (Desktop) -->
        <div class="lg:col-span-1">
            <div class="offcanvas-lg offcanvas-start" tabindex="-1" id="filterOffcanvas">
                <!-- Mobile Header -->
                <div class="offcanvas-header lg:hidden border-b border-gray-200 p-4">
                    <h3 class="text-lg font-bold text-purple-900 flex items-center gap-2">
                        <i class="bi bi-funnel-fill text-yellow-500"></i> Filter Colleges
                    </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>

                <!-- Filter Content -->
                <div class="offcanvas-body lg:offcanvas-body-reset p-0 lg:p-0">
                    <div class="bg-white rounded-xl border border-gray-200 p-5 sticky top-32 max-h-[calc(100vh-150px)] overflow-y-auto lg:top-32">
                        <form action="{{ url()->current() }}" method="GET" id="filterForm">
                            <!-- Filter Header -->
                            <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-200">
                                <h4 class="font-bold text-gray-900 flex items-center gap-2">
                                    <i class="bi bi-funnel-fill text-yellow-500"></i> Filter By
                                </h4>
                                <a href="{{ url()->current() }}" class="text-red-600 text-sm font-bold hover:text-red-700">Reset</a>
                            </div>

                            <!-- Search Input -->
                            <div class="mb-5">
                                <div class="flex items-center border border-gray-300 rounded-lg bg-gray-50 px-3 focus-within:border-purple-600 focus-within:ring-1 focus-within:ring-purple-600">
                                    <i class="bi bi-search text-gray-400"></i>
                                    <input type="text" name="search" value="{{ request('search') }}" class="w-full bg-transparent border-0 focus:outline-none px-3 py-2.5 text-gray-900 placeholder-gray-500" placeholder="Search college, city...">
                                </div>
                            </div>

                            <!-- 1. Degree Level -->
                            <div class="border-b border-gray-200 pb-4 mb-4">
                                <h5 class="font-bold text-purple-900 mb-3 text-sm">1. Education Level</h5>
                                <div class="space-y-2">
                                    @foreach(['UG' => 'Undergraduate (UG)', 'PG' => 'Postgraduate (PG)', 'Diploma' => 'Diploma', 'PhD' => 'Ph.D. / Doctorate', 'Certificate' => 'Certificate'] as $val => $label)
                                    <div class="flex items-center">
                                        <input class="filter-checkbox w-4 h-4 text-purple-900 border-gray-300 rounded focus:ring-purple-600 cursor-pointer" type="checkbox" name="levels[]" value="{{ $val }}" id="level_{{ $val }}" {{ in_array($val, (array)request('levels')) ? 'checked' : '' }}>
                                        <label class="ml-2.5 text-gray-700 text-sm cursor-pointer font-medium" for="level_{{ $val }}">{{ $label }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- 2. Academic Stream -->
                            <div class="border-b border-gray-200 pb-4 mb-4">
                                <h5 class="font-bold text-purple-900 mb-3 text-sm">2. Stream</h5>
                                <input type="text" class="filter-inner-search w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-50 text-gray-900 placeholder-gray-500 mb-3 focus:border-purple-600 focus:ring-1 focus:ring-purple-600" placeholder="Search stream..." data-target="#streamFilterOptions">
                                <div class="space-y-2 max-h-48 overflow-y-auto" id="streamFilterOptions">
                                    @foreach($allStreams as $st)
                                    <div class="flex items-center filter-item-row">
                                        <input class="filter-checkbox w-4 h-4 text-purple-900 border-gray-300 rounded focus:ring-purple-600 cursor-pointer" type="checkbox" name="streams[]" value="{{ $st->slug }}" id="stream_{{ $st->id }}" {{ in_array($st->slug, (array)request('streams')) ? 'checked' : '' }}>
                                        <label class="ml-2.5 text-gray-700 text-sm cursor-pointer font-medium" for="stream_{{ $st->id }}">{{ $st->name }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- 3. Course -->
                            <div class="border-b border-gray-200 pb-4 mb-4">
                                <h5 class="font-bold text-purple-900 mb-3 text-sm">3. Course / Program</h5>
                                <input type="text" class="filter-inner-search w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-50 text-gray-900 placeholder-gray-500 mb-3 focus:border-purple-600 focus:ring-1 focus:ring-purple-600" placeholder="Search course (e.g. BCA, MBA)..." data-target="#courseFilterOptions">
                                <div class="space-y-2 max-h-48 overflow-y-auto" id="courseFilterOptions">
                                    @foreach($allCourses as $c)
                                    <div class="flex items-center filter-item-row">
                                        <input class="filter-checkbox w-4 h-4 text-purple-900 border-gray-300 rounded focus:ring-purple-600 cursor-pointer" type="checkbox" name="courses[]" value="{{ $c->slug }}" id="course_{{ $c->id }}" {{ in_array($c->slug, (array)request('courses')) ? 'checked' : '' }}>
                                        <label class="ml-2.5 text-gray-700 text-sm cursor-pointer font-medium" for="course_{{ $c->id }}">{{ $c->name }} <span class="text-gray-500">({{ $c->level }})</span></label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- 4. Degree Type -->
                            <div class="border-b border-gray-200 pb-4 mb-4">
                                <h5 class="font-bold text-purple-900 mb-3 text-sm">4. Degree Type</h5>
                                <div class="space-y-2">
                                    @foreach(['Degree' => 'Degree Program', 'Diploma' => 'Diploma Program', 'Certificate' => 'Certificate Program'] as $dtVal => $dtLabel)
                                    <div class="flex items-center">
                                        <input class="filter-checkbox w-4 h-4 text-purple-900 border-gray-300 rounded focus:ring-purple-600 cursor-pointer" type="checkbox" name="degree_types[]" value="{{ $dtVal }}" id="dt_{{ $dtVal }}" {{ in_array($dtVal, (array)request('degree_types')) ? 'checked' : '' }}>
                                        <label class="ml-2.5 text-gray-700 text-sm cursor-pointer font-medium" for="dt_{{ $dtVal }}">{{ $dtLabel }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- 5. Course Duration -->
                            @if($allDurations->count() > 0)
                            <div class="border-b border-gray-200 pb-4 mb-4">
                                <h5 class="font-bold text-purple-900 mb-3 text-sm">5. Course Duration</h5>
                                <div class="space-y-2">
                                    @foreach($allDurations as $dur)
                                    <div class="flex items-center">
                                        <input class="filter-checkbox w-4 h-4 text-purple-900 border-gray-300 rounded focus:ring-purple-600 cursor-pointer" type="checkbox" name="durations[]" value="{{ $dur }}" id="dur_{{ $loop->index }}" {{ in_array($dur, (array)request('durations')) ? 'checked' : '' }}>
                                        <label class="ml-2.5 text-gray-700 text-sm cursor-pointer font-medium" for="dur_{{ $loop->index }}">{{ $dur }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- 6. State -->
                            <div class="border-b border-gray-200 pb-4 mb-4">
                                <h5 class="font-bold text-purple-900 mb-3 text-sm">6. State</h5>
                                <input type="text" class="filter-inner-search w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-50 text-gray-900 placeholder-gray-500 mb-3 focus:border-purple-600 focus:ring-1 focus:ring-purple-600" placeholder="Search state..." data-target="#stateFilterOptions">
                                <div class="space-y-2 max-h-48 overflow-y-auto" id="stateFilterOptions">
                                    @foreach($allStates as $state)
                                    <div class="flex items-center filter-item-row">
                                        <input class="filter-checkbox w-4 h-4 text-purple-900 border-gray-300 rounded focus:ring-purple-600 cursor-pointer" type="checkbox" name="states[]" value="{{ $state }}" id="state_{{ $loop->index }}" {{ in_array($state, (array)request('states')) ? 'checked' : '' }}>
                                        <label class="ml-2.5 text-gray-700 text-sm cursor-pointer font-medium" for="state_{{ $loop->index }}">{{ $state }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- 7. City -->
                            <div class="border-b border-gray-200 pb-4 mb-4">
                                <h5 class="font-bold text-purple-900 mb-3 text-sm">7. City</h5>
                                <input type="text" class="filter-inner-search w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-50 text-gray-900 placeholder-gray-500 mb-3 focus:border-purple-600 focus:ring-1 focus:ring-purple-600" placeholder="Search city..." data-target="#cityFilterOptions">
                                <div class="space-y-2 max-h-48 overflow-y-auto" id="cityFilterOptions">
                                    @foreach($allCities as $city)
                                    <div class="flex items-center filter-item-row">
                                        <input class="filter-checkbox w-4 h-4 text-purple-900 border-gray-300 rounded focus:ring-purple-600 cursor-pointer" type="checkbox" name="cities[]" value="{{ $city }}" id="city_{{ $loop->index }}" {{ in_array($city, (array)request('cities')) ? 'checked' : '' }}>
                                        <label class="ml-2.5 text-gray-700 text-sm cursor-pointer font-medium" for="city_{{ $loop->index }}">{{ $city }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- 8. College Type -->
                            <div class="border-b border-gray-200 pb-4 mb-4">
                                <h5 class="font-bold text-purple-900 mb-3 text-sm">8. College Ownership</h5>
                                <div class="space-y-2">
                                    @foreach(['Govt' => 'Government University', 'Private' => 'Private University', 'Deemed' => 'Deemed University', 'Autonomous' => 'Autonomous Institute'] as $tVal => $tLabel)
                                    <div class="flex items-center">
                                        <input class="filter-checkbox w-4 h-4 text-purple-900 border-gray-300 rounded focus:ring-purple-600 cursor-pointer" type="checkbox" name="types[]" value="{{ $tVal }}" id="type_{{ $tVal }}" {{ in_array($tVal, (array)request('types')) ? 'checked' : '' }}>
                                        <label class="ml-2.5 text-gray-700 text-sm cursor-pointer font-medium" for="type_{{ $tVal }}">{{ $tLabel }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- 9. Fee Range -->
                            <div class="border-b border-gray-200 pb-4 mb-4">
                                <h5 class="font-bold text-purple-900 mb-3 text-sm">9. Annual Fee Range</h5>
                                <div class="space-y-2">
                                    @php
                                    $feeOptions = [
                                        'under_1l'  => 'Less than 1 Lac',
                                        '1l_to_2l'  => '1 Lac - 2 Lac',
                                        '2l_to_3l'  => '2 Lac - 3 Lac',
                                        '3l_to_5l'  => '3 Lac - 5 Lac',
                                        '5l_to_10l' => '5 Lac - 10 Lac',
                                        'above_10l' => 'Greater than 10+ Lac',
                                    ];
                                    @endphp
                                    @foreach($feeOptions as $fVal => $fLabel)
                                    <div class="flex items-center">
                                        <input class="filter-checkbox w-4 h-4 text-purple-900 border-gray-300 rounded focus:ring-purple-600 cursor-pointer" type="checkbox" name="fee_ranges[]" value="{{ $fVal }}" id="fee_{{ $fVal }}" {{ in_array($fVal, (array)request('fee_ranges')) ? 'checked' : '' }}>
                                        <label class="ml-2.5 text-gray-700 text-sm cursor-pointer font-medium" for="fee_{{ $fVal }}">{{ $fLabel }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- 10. Hostel Facilities -->
                            <div class="pb-4 mb-5">
                                <h5 class="font-bold text-purple-900 mb-3 text-sm">10. Hostel Facilities</h5>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <input class="filter-checkbox w-4 h-4 text-purple-900 border-gray-300 rounded focus:ring-purple-600 cursor-pointer" type="checkbox" name="boys_hostel" value="1" id="boys_hostel" {{ request('boys_hostel') ? 'checked' : '' }}>
                                        <label class="ml-2.5 text-gray-700 text-sm cursor-pointer font-medium flex items-center" for="boys_hostel">
                                            <i class="bi bi-house text-blue-600 me-1"></i> Boys Hostel
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input class="filter-checkbox w-4 h-4 text-purple-900 border-gray-300 rounded focus:ring-purple-600 cursor-pointer" type="checkbox" name="girls_hostel" value="1" id="girls_hostel" {{ request('girls_hostel') ? 'checked' : '' }}>
                                        <label class="ml-2.5 text-gray-700 text-sm cursor-pointer font-medium flex items-center" for="girls_hostel">
                                            <i class="bi bi-house-heart text-red-600 me-1"></i> Girls Hostel
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="w-full py-2.5 bg-purple-900 text-white font-bold rounded-lg text-sm hover:bg-purple-800 transition">Apply Filters</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- RESULTS LISTING -->
        <div class="lg:col-span-3">
            @if($activeCount > 0)
            <div class="hidden lg:flex justify-between items-center mb-4 bg-white p-3 px-4 rounded-lg border border-gray-200 text-sm">
                <span class="text-gray-700"><strong>{{ $activeCount }}</strong> active filter(s) applied</span>
                <a href="{{ url()->current() }}" class="px-3 py-1 text-red-600 font-bold hover:text-red-700 text-sm border border-red-300 rounded-lg hover:bg-red-50">Clear Filters</a>
            </div>
            @endif

            <!-- LIST OF COLLEGES -->
            @forelse($colleges as $index => $college)
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg hover:border-purple-300 transition-all mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
                    <!-- College Image -->
                    <div class="md:col-span-1">
                        <a href="{{ route('college.show', $college->slug) }}" class="block overflow-hidden rounded-xl group">
                            <img src="{{ $college->banner_url }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300" alt="{{ $college->name }}" loading="lazy">
                        </a>
                    </div>

                    <!-- College Details -->
                    <div class="md:col-span-2 flex flex-col justify-between">
                        <!-- Header -->
                        <div>
                            <h3 class="text-xl font-bold text-purple-900 mb-3">
                                <a href="{{ route('college.show', $college->slug) }}" class="hover:text-purple-700">{{ $college->name }}</a>
                            </h3>

                            <!-- Location & Type -->
                            <div class="flex flex-wrap gap-3 text-gray-700 text-sm mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="bi bi-geo-alt text-red-600"></i> {{ $college->city }}, {{ $college->state }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="bi bi-flag text-blue-600"></i> {{ $college->college_type }} University
                                </span>
                                @if($college->rating)
                                <span class="flex items-center gap-1">
                                    <i class="bi bi-star-fill text-yellow-500"></i> {{ $college->rating }} ({{ $college->reviews_count }} reviews)
                                </span>
                                @endif
                            </div>

                            <!-- Badges -->
                            <div class="flex flex-wrap gap-2 mb-4">
                                @php
                                    $cCount = $college->courses_count ?? $college->courses->count();
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 text-gray-700 text-xs font-semibold rounded-lg">
                                    <i class="bi bi-book text-gray-600"></i>
                                    {{ $cCount > 0 ? $cCount . ' Course' . ($cCount > 1 ? 's' : '') : 'Courses Available' }}
                                </span>
                                @if($college->established_year)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-700 text-xs font-semibold rounded-lg">
                                    <i class="bi bi-calendar text-blue-600"></i> Estd. {{ $college->established_year }}
                                </span>
                                @endif
                                @if($college->entrance_exams)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-purple-50 text-purple-700 text-xs font-semibold rounded-lg">
                                    <i class="bi bi-pencil-square text-purple-600"></i> {{ $college->entrance_exams }}
                                </span>
                                @endif
                                @if($college->approvals)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-50 text-green-700 text-xs font-semibold rounded-lg">
                                    <i class="bi bi-shield-check text-green-600"></i> {{ $college->approvals }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('college.show', $college->slug) }}" class="flex-1 min-w-max px-5 py-2.5 bg-yellow-500 text-gray-900 font-bold rounded-lg text-sm hover:bg-yellow-600 transition flex items-center justify-center gap-2">
                                <i class="bi bi-eye"></i> View Details
                            </a>
                            <button type="button" 
                                    class="flex-1 min-w-max px-5 py-2.5 bg-purple-900 text-white font-bold rounded-lg text-sm hover:bg-purple-800 transition flex items-center justify-center gap-2" 
                                    onclick="openEnquiryModal({{ $college->id }}, '{{ addslashes($college->name) }}')">
                                <i class="bi bi-telephone-plus"></i> Free Counseling
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- IN-FEED AD BANNER -->
            @if(($index + 1) % 4 === 0 && ($siteSettings['ads.enable_listing_ad'] ?? '1') == '1' && !empty($siteSettings['ads.listing_banner']))
            <div class="my-6 text-center">
                <a href="{{ $siteSettings['ads.listing_banner_link'] ?: 'tel:' . ($siteSettings['general.support_phone'] ?? '8858285271') }}"
                    class="block overflow-hidden rounded-2xl shadow-md hover:shadow-lg transition"
                    @if(!str_starts_with($siteSettings['ads.listing_banner_link'] ?? '' , 'tel:' )) target="_blank" @endif>
                    <img src="{{ asset($siteSettings['ads.listing_banner']) }}"
                        class="w-full h-auto rounded-2xl"
                        style="max-height: 165px; object-fit: cover;"
                        alt="Sponsored Ad Banner"
                        loading="lazy">
                </a>
            </div>
            @endif

            @empty
            <div class="text-center py-12 bg-white rounded-xl border border-gray-200">
                <i class="bi bi-search text-5xl text-gray-400 mb-4 block"></i>
                <h4 class="text-xl font-bold text-gray-900 mb-2">No colleges match your filters</h4>
                <p class="text-gray-600 mb-6">Try broadening your stream, course, or location selections.</p>
                <a href="{{ url()->current() }}" class="px-6 py-2.5 bg-purple-900 text-white font-bold rounded-lg text-sm hover:bg-purple-800 inline-flex items-center gap-2">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset All Filters
                </a>
            </div>
            @endforelse

            <!-- Pagination -->
            <div class="flex justify-center mt-8">
                {{ $colleges->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- MOBILE FLOATING FILTER BUTTON -->
<div class="lg:hidden fixed bottom-6 left-1/2 transform -translate-x-1/2 z-40">
    <button class="px-6 py-3 bg-gray-900 text-white font-bold rounded-full shadow-lg hover:bg-gray-800 transition flex items-center gap-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas">
        <i class="bi bi-funnel-fill text-yellow-500"></i>
        <span>Filters</span>
        @if($activeCount > 0)
        <span class="inline-block bg-yellow-500 text-gray-900 text-xs font-bold px-2.5 py-0.5 rounded-full">{{ $activeCount }}</span>
        @endif
    </button>
</div>

@push('scripts')
<script>
    // Auto-submit filter form on checkbox change
    document.querySelectorAll('.filter-checkbox').forEach(input => {
        input.addEventListener('change', () => {
            document.getElementById('filterForm').submit();
        });
    });

    // Real-time filter search
    document.querySelectorAll('.filter-inner-search').forEach(searchBox => {
        searchBox.addEventListener('keyup', function() {
            const targetContainer = document.querySelector(this.getAttribute('data-target'));
            const term = this.value.toLowerCase().trim();
            const items = targetContainer.querySelectorAll('.filter-item-row');
            items.forEach(item => {
                const label = item.querySelector('label').innerText.toLowerCase();
                if (label.includes(term)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush
@endsection
