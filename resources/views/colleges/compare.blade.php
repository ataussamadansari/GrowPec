@extends('layouts.app')

@section('title', $pageTitle . ' - GrowPec')

@push('styles')
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        corePlugins: {
            preflight: false,
        },
        theme: {
            extend: {
                colors: {
                    brand: {
                        navy: '#002B67',
                        darkNavy: '#001B45',
                        darkerNavy: '#00122E',
                        gold: '#D9A400',
                        goldHover: '#B78300',
                        goldLight: '#FEF9C3',
                        green: '#008A43',
                        greenLight: '#DCFCE7',
                    }
                }
            }
        }
    };
</script>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-[#00122E] via-[#001B45] to-[#002B67] text-white py-10 lg:py-12 overflow-hidden">
    <!-- Ambient Backdrop Light -->
    <div class="absolute -bottom-20 -right-20 w-96 h-96 rounded-full bg-amber-400/10 blur-3xl pointer-events-none"></div>
    <div class="absolute -top-20 -left-20 w-72 h-72 rounded-full bg-blue-500/10 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="flex items-center gap-2 text-xs text-slate-300">
                <li>
                    <a href="{{ route('home') }}" class="hover:text-amber-400 transition-colors">Home</a>
                </li>
                <li><span class="text-slate-500">/</span></li>
                <li>
                    <a href="{{ route('colleges.regular') }}" class="hover:text-amber-400 transition-colors">Colleges</a>
                </li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-amber-400 font-semibold" aria-current="page">Compare</li>
            </ol>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight flex items-center gap-3">
                    <i class="bi bi-intersect text-amber-400 text-2xl lg:text-3xl"></i>
                    Compare Top Universities & Colleges
                </h1>
                <p class="mt-2 text-sm sm:text-base text-slate-300 max-w-2xl leading-relaxed">
                    Side-by-side benchmark of authentic accreditation, tuition fees, placement packages, student reviews, and courses.
                </p>
            </div>

            <div class="shrink-0">
                @if($selectedColleges->count() >= 2)
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold bg-amber-400 text-slate-950 shadow-md">
                        <i class="bi bi-check2-circle text-sm"></i>
                        Comparing {{ $selectedColleges->count() }} of 4 Colleges
                    </span>
                @else
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold bg-white/15 text-white border border-white/20 backdrop-blur-sm">
                        <i class="bi bi-info-circle text-sm text-amber-400"></i>
                        Select 2 to 4 Colleges to Benchmark
                    </span>
                @endif
            </div>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    <!-- Interactive College Selector Bar -->
    <div class="bg-white/95 backdrop-blur-md rounded-2xl border border-slate-200/90 shadow-xs p-5 lg:p-6" id="compareSelectorBar">
        <form method="GET" action="{{ route('colleges.compare') }}" id="compareForm" class="space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-slate-100 pb-3">
                <div>
                    <h6 class="text-sm lg:text-base font-bold text-slate-900 flex items-center gap-2 mb-0">
                        <i class="bi bi-sliders text-[#002B67]"></i> Customize Comparison Slots
                    </h6>
                    <p class="text-xs text-slate-500 mt-0.5 mb-0">Select universities from the dropdowns below to instantly benchmark.</p>
                </div>
                <div class="text-xs text-slate-400">
                    Max 4 institutions
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @for($i = 0; $i < 4; $i++)
                    @php
                        $currentSlug = $selectedColleges->get($i)?->slug ?? '';
                    @endphp
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                            College Slot {{ $i + 1 }}
                            <span class="font-normal text-[11px] {{ $i < 2 ? 'text-amber-600 font-semibold' : 'text-slate-400' }}">
                                {{ $i < 2 ? '(Required)' : '(Optional)' }}
                            </span>
                        </label>
                        <select name="colleges[]" 
                                class="w-full rounded-xl border border-slate-300 bg-slate-50/50 px-3.5 py-2.5 text-xs lg:text-sm font-medium text-slate-800 focus:border-[#002B67] focus:ring-2 focus:ring-[#002B67]/20 focus:bg-white transition-all shadow-xs outline-none select-college-slot"
                                onchange="document.getElementById('compareForm').submit();">
                            <option value="">-- Choose College --</option>
                            @foreach($allColleges as $college)
                                <option value="{{ $college->slug }}" {{ $currentSlug === $college->slug ? 'selected' : '' }}>
                                    {{ $college->short_name ?: $college->name }} ({{ $college->cityRelation?->name ?: $college->city ?: 'India' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endfor
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                @if($selectedColleges->count() > 0)
                    <a href="{{ route('colleges.compare') }}" 
                       class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-white border border-slate-200 hover:bg-slate-50 rounded-xl transition-all shadow-xs">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset Slots
                    </a>
                @endif
                <button type="submit" 
                        class="inline-flex items-center gap-1.5 px-5 py-2 text-xs font-bold text-white bg-[#002B67] hover:bg-[#001B45] rounded-xl shadow-xs transition-all cursor-pointer">
                    <i class="bi bi-arrow-repeat"></i> Update Comparison
                </button>
            </div>
        </form>
    </div>

    @if($selectedColleges->count() >= 2)
        <!-- Side-by-Side Comparison Matrix Table -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden relative">
            <div class="overflow-x-auto scroll-smooth">
                <table class="w-full min-w-[860px] border-collapse text-left text-sm">
                    <thead>
                        <tr>
                            <!-- Sticky Left Header -->
                            <th class="sticky left-0 top-0 z-30 bg-slate-50/95 backdrop-blur-sm border-r border-b border-slate-200/80 w-60 min-w-60 p-5 align-top shadow-[2px_0_8px_rgba(0,0,0,0.02)]">
                                <div class="flex flex-col justify-center h-full">
                                    <span class="text-xs font-extrabold uppercase tracking-wider text-[#002B67]">
                                        Comparison Matrix
                                    </span>
                                    <span class="text-xs text-slate-500 mt-1">
                                        {{ $selectedColleges->count() }} Colleges Benchmarked
                                    </span>
                                </div>
                            </th>

                            <!-- College Header Cards -->
                            @foreach($selectedColleges as $col)
                                <th class="w-72 min-w-72 p-5 border-b border-r border-slate-200/80 last:border-r-0 align-top relative bg-white">
                                    @php
                                        $remainingSlugs = $selectedColleges->pluck('slug')->reject(fn($s) => $s === $col->slug)->join(',');
                                        $removeUrl = route('colleges.compare', ['colleges' => $remainingSlugs]);
                                    @endphp
                                    <a href="{{ $removeUrl }}" 
                                       class="absolute top-3 right-3 w-7 h-7 rounded-full bg-slate-100 hover:bg-rose-50 text-slate-400 hover:text-rose-600 border border-slate-200 flex items-center justify-center transition-all shadow-xs" 
                                       title="Remove {{ $col->short_name ?: $col->name }} from comparison" 
                                       onclick="GP_COMPARE.remove('{{ $col->slug }}')">
                                        <i class="bi bi-x text-lg"></i>
                                    </a>

                                    <div class="text-center">
                                        <img src="{{ $col->logo ? (str_starts_with($col->logo, 'http') ? $col->logo : asset('storage/' . $col->logo)) : 'https://placehold.co/100x100?text=' . urlencode($col->short_name ?: 'College') }}" 
                                             alt="{{ $col->name }} Logo" 
                                             class="w-16 h-16 p-2 rounded-xl border border-slate-200 bg-white object-contain shadow-xs mx-auto mb-3">

                                        <h5 class="text-sm font-bold text-[#002B67] hover:text-blue-700 transition-colors line-clamp-2 leading-snug">
                                            <a href="{{ route('college.show', $col->slug) }}">
                                                {{ $col->short_name ?: $col->name }}
                                            </a>
                                        </h5>

                                        <div class="flex items-center justify-center gap-1 text-xs text-slate-500 font-medium mt-1.5">
                                            <i class="bi bi-geo-alt-fill text-rose-500"></i>
                                            <span>
                                                {{ $col->cityRelation?->name ?: $col->city ?: 'India' }}, 
                                                {{ $col->stateRelation?->name ?: $col->state ?: '' }}
                                            </span>
                                        </div>

                                        <div class="flex items-center justify-center gap-1.5 mt-2.5">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-700 border border-slate-200 uppercase tracking-wide">
                                                {{ ucfirst($col->mode ?: 'regular') }}
                                            </span>
                                            @if($col->type)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                                    {{ $col->type }}
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Quick Enquire CTA -->
                                        <button type="button" 
                                                class="w-full mt-3.5 py-2 px-3 text-xs font-bold rounded-xl bg-gradient-to-r from-[#D9A400] to-[#E5AC00] hover:from-[#B78300] hover:to-[#D9A400] text-slate-950 shadow-xs transition-all flex items-center justify-center gap-1.5 cursor-pointer"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#counselingModal"
                                                data-college-id="{{ $col->id }}"
                                                data-college-name="{{ $col->name }}">
                                            <i class="bi bi-send-fill text-xs"></i> Enquire Now
                                        </button>
                                    </div>
                                </th>
                            @endforeach

                            <!-- Empty Add Slot -->
                            @if($selectedColleges->count() < 4)
                                <th class="w-60 min-w-60 p-5 border-b border-slate-200/80 align-middle bg-slate-50/40 text-center">
                                    <div class="h-full min-h-[220px] rounded-2xl border-2 border-dashed border-slate-300 hover:border-[#002B67] p-5 flex flex-col items-center justify-center transition-all hover:bg-white group">
                                        <i class="bi bi-plus-circle text-2xl text-slate-400 group-hover:text-[#002B67] mb-2 transition-colors"></i>
                                        <h6 class="text-xs font-bold text-slate-800 mb-0.5">Add Another College</h6>
                                        <p class="text-[11px] text-slate-500 mb-3 leading-relaxed">Compare up to 4 institutions side-by-side</p>
                                        <button type="button" 
                                                class="px-3 py-1.5 text-xs font-semibold text-[#002B67] bg-white border border-[#002B67]/30 hover:bg-[#002B67] hover:text-white rounded-lg transition-all shadow-xs cursor-pointer" 
                                                onclick="focusAddCollegeSlot()">
                                            Select from List
                                        </button>
                                    </div>
                                </th>
                            @endif
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        <!-- Category: Accreditations & Recognitions -->
                        <tr>
                            <td colspan="{{ $selectedColleges->count() + ($selectedColleges->count() < 4 ? 2 : 1) }}" 
                                class="bg-slate-100/90 text-[#002B67] font-bold text-xs uppercase tracking-wider px-5 py-3 border-y border-slate-200">
                                <div class="flex items-center gap-2">
                                    <i class="bi bi-award text-[#002B67]"></i> Accreditations & Recognitions
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="sticky left-0 z-20 bg-slate-50/95 backdrop-blur-sm font-semibold text-xs text-slate-700 px-5 py-4 border-r border-slate-200/80 shadow-[2px_0_8px_rgba(0,0,0,0.02)]">
                                Accreditation Badges
                            </td>
                            @foreach($selectedColleges as $col)
                                <td class="px-5 py-4 border-r border-slate-100 last:border-r-0 align-middle">
                                    <div class="flex flex-wrap gap-1.5">
                                        @if($col->naac_grade)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-50 text-amber-900 border border-amber-200">
                                                <i class="bi bi-patch-check-fill text-amber-600"></i> NAAC {{ $col->naac_grade }}
                                            </span>
                                        @endif
                                        @if($col->ugc_approved)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-900 border border-emerald-200">
                                                <i class="bi bi-check-circle-fill text-emerald-600"></i> UGC Recognized
                                            </span>
                                        @endif
                                        @if($col->nirf_rank)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-indigo-50 text-indigo-900 border border-indigo-200">
                                                <i class="bi bi-trophy-fill text-indigo-600"></i> NIRF #{{ $col->nirf_rank }}
                                            </span>
                                        @endif
                                        @if($col->accreditations->count() > 0)
                                            @foreach($col->accreditations->take(2) as $acc)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                                    {{ $acc->body_name }} {{ $acc->grade ? '(' . $acc->grade . ')' : '' }}
                                                </span>
                                            @endforeach
                                        @endif
                                    </div>
                                </td>
                            @endforeach
                            @if($selectedColleges->count() < 4) <td class="bg-slate-50/20"></td> @endif
                        </tr>
                        <tr>
                            <td class="sticky left-0 z-20 bg-slate-50/95 backdrop-blur-sm font-semibold text-xs text-slate-700 px-5 py-4 border-r border-slate-200/80 shadow-[2px_0_8px_rgba(0,0,0,0.02)]">
                                Established Year
                            </td>
                            @foreach($selectedColleges as $col)
                                <td class="px-5 py-4 border-r border-slate-100 last:border-r-0 font-bold text-slate-800 text-sm align-middle">
                                    {{ $col->established_year ?: $col->year ?: '—' }}
                                </td>
                            @endforeach
                            @if($selectedColleges->count() < 4) <td class="bg-slate-50/20"></td> @endif
                        </tr>
                        <tr>
                            <td class="sticky left-0 z-20 bg-slate-50/95 backdrop-blur-sm font-semibold text-xs text-slate-700 px-5 py-4 border-r border-slate-200/80 shadow-[2px_0_8px_rgba(0,0,0,0.02)]">
                                Campus Size
                            </td>
                            @foreach($selectedColleges as $col)
                                <td class="px-5 py-4 border-r border-slate-100 last:border-r-0 text-slate-700 text-sm align-middle">
                                    {{ $col->campus_size ?: $col->campus ?: 'State-of-the-art Campus' }}
                                </td>
                            @endforeach
                            @if($selectedColleges->count() < 4) <td class="bg-slate-50/20"></td> @endif
                        </tr>

                        <!-- Category: Ratings & Student Sentiment -->
                        <tr>
                            <td colspan="{{ $selectedColleges->count() + ($selectedColleges->count() < 4 ? 2 : 1) }}" 
                                class="bg-slate-100/90 text-[#002B67] font-bold text-xs uppercase tracking-wider px-5 py-3 border-y border-slate-200">
                                <div class="flex items-center gap-2">
                                    <i class="bi bi-star-fill text-amber-500"></i> Ratings & Student Sentiment
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="sticky left-0 z-20 bg-slate-50/95 backdrop-blur-sm font-semibold text-xs text-slate-700 px-5 py-4 border-r border-slate-200/80 shadow-[2px_0_8px_rgba(0,0,0,0.02)]">
                                Student Rating
                            </td>
                            @foreach($selectedColleges as $col)
                                <td class="px-5 py-4 border-r border-slate-100 last:border-r-0 align-middle">
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-amber-50 border border-amber-200 text-amber-900 font-extrabold text-xs">
                                            ★ {{ number_format($col->average_rating, 1) }}
                                        </span>
                                        <div class="text-amber-500 text-xs flex items-center gap-0.5">
                                            @for($star = 1; $star <= 5; $star++)
                                                <i class="bi {{ $star <= round($col->average_rating) ? 'bi-star-fill' : 'bi-star' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <small class="text-slate-500 text-xs block mt-1">
                                        Based on {{ $col->approved_reviews_count ?: $col->reviews_count ?: 0 }} verified student reviews
                                    </small>
                                </td>
                            @endforeach
                            @if($selectedColleges->count() < 4) <td class="bg-slate-50/20"></td> @endif
                        </tr>

                        <!-- Category: Tuition Fees & Programs -->
                        <tr>
                            <td colspan="{{ $selectedColleges->count() + ($selectedColleges->count() < 4 ? 2 : 1) }}" 
                                class="bg-slate-100/90 text-[#002B67] font-bold text-xs uppercase tracking-wider px-5 py-3 border-y border-slate-200">
                                <div class="flex items-center gap-2">
                                    <i class="bi bi-currency-rupee text-[#002B67]"></i> Tuition Fees & Programs
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="sticky left-0 z-20 bg-slate-50/95 backdrop-blur-sm font-semibold text-xs text-slate-700 px-5 py-4 border-r border-slate-200/80 shadow-[2px_0_8px_rgba(0,0,0,0.02)]">
                                Annual Fee Range
                            </td>
                            @foreach($selectedColleges as $col)
                                @php
                                    $validFees = $col->collegeCourses->where('fee_amount', '>', 0)->pluck('fee_amount');
                                    $minFee = $validFees->min();
                                    $maxFee = $validFees->max();
                                @endphp
                                <td class="px-5 py-4 border-r border-slate-100 last:border-r-0 align-middle">
                                    @if($minFee && $maxFee)
                                        <div class="font-extrabold text-emerald-700 text-base">
                                            ₹{{ number_format($minFee) }} - ₹{{ number_format($maxFee) }}
                                        </div>
                                        <span class="text-xs text-slate-500 block mt-0.5">Per year (varies by program)</span>
                                    @else
                                        <span class="text-xs text-slate-500">Affordable / Contact for Structure</span>
                                    @endif
                                </td>
                            @endforeach
                            @if($selectedColleges->count() < 4) <td class="bg-slate-50/20"></td> @endif
                        </tr>
                        <tr>
                            <td class="sticky left-0 z-20 bg-slate-50/95 backdrop-blur-sm font-semibold text-xs text-slate-700 px-5 py-4 border-r border-slate-200/80 shadow-[2px_0_8px_rgba(0,0,0,0.02)]">
                                Key Programs Offered
                            </td>
                            @foreach($selectedColleges as $col)
                                @php
                                    $courseNames = $col->collegeCourses->map(fn($cc) => $cc->course?->name)->filter()->unique()->take(6);
                                @endphp
                                <td class="px-5 py-4 border-r border-slate-100 last:border-r-0 align-middle">
                                    <div class="flex flex-wrap gap-1.5">
                                        @forelse($courseNames as $cName)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                                {{ $cName }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-slate-400">Comprehensive degree options</span>
                                        @endforelse
                                    </div>
                                    <span class="text-xs font-semibold text-[#002B67] mt-2 block">
                                        Total {{ $col->collegeCourses->count() }} active courses
                                    </span>
                                </td>
                            @endforeach
                            @if($selectedColleges->count() < 4) <td class="bg-slate-50/20"></td> @endif
                        </tr>

                        <!-- Category: Placements & Career Statistics -->
                        <tr>
                            <td colspan="{{ $selectedColleges->count() + ($selectedColleges->count() < 4 ? 2 : 1) }}" 
                                class="bg-slate-100/90 text-[#002B67] font-bold text-xs uppercase tracking-wider px-5 py-3 border-y border-slate-200">
                                <div class="flex items-center gap-2">
                                    <i class="bi bi-briefcase-fill text-[#002B67]"></i> Placements & Career Statistics
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="sticky left-0 z-20 bg-slate-50/95 backdrop-blur-sm font-semibold text-xs text-slate-700 px-5 py-4 border-r border-slate-200/80 shadow-[2px_0_8px_rgba(0,0,0,0.02)]">
                                Highest Package
                            </td>
                            @foreach($selectedColleges as $col)
                                @php
                                    $highestPackage = $col->placementStats->first()?->highest_package ?: $col->highest_package;
                                @endphp
                                <td class="px-5 py-4 border-r border-slate-100 last:border-r-0 align-middle">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        <i class="bi bi-trophy-fill text-emerald-600"></i>
                                        {{ $highestPackage ?: 'Top Offers' }}
                                    </span>
                                </td>
                            @endforeach
                            @if($selectedColleges->count() < 4) <td class="bg-slate-50/20"></td> @endif
                        </tr>
                        <tr>
                            <td class="sticky left-0 z-20 bg-slate-50/95 backdrop-blur-sm font-semibold text-xs text-slate-700 px-5 py-4 border-r border-slate-200/80 shadow-[2px_0_8px_rgba(0,0,0,0.02)]">
                                Average Package
                            </td>
                            @foreach($selectedColleges as $col)
                                @php
                                    $avgPackage = $col->placementStats->first()?->average_package ?: $col->average_package;
                                @endphp
                                <td class="px-5 py-4 border-r border-slate-100 last:border-r-0 font-bold text-slate-800 text-sm align-middle">
                                    {{ $avgPackage ?: '₹4.50 LPA - ₹6.50 LPA' }}
                                </td>
                            @endforeach
                            @if($selectedColleges->count() < 4) <td class="bg-slate-50/20"></td> @endif
                        </tr>
                        <tr>
                            <td class="sticky left-0 z-20 bg-slate-50/95 backdrop-blur-sm font-semibold text-xs text-slate-700 px-5 py-4 border-r border-slate-200/80 shadow-[2px_0_8px_rgba(0,0,0,0.02)]">
                                Top Corporate Recruiters
                            </td>
                            @foreach($selectedColleges as $col)
                                <td class="px-5 py-4 border-r border-slate-100 last:border-r-0 align-middle">
                                    <div class="flex flex-wrap gap-1.5">
                                        @forelse($col->recruiters->take(5) as $rec)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-medium bg-slate-50 text-slate-700 border border-slate-200">
                                                {{ $rec->name }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-slate-400">TCS, Infosys, Wipro, HCL, Tech Mahindra</span>
                                        @endforelse
                                    </div>
                                </td>
                            @endforeach
                            @if($selectedColleges->count() < 4) <td class="bg-slate-50/20"></td> @endif
                        </tr>

                        <!-- Category: Campus Amenities & Infrastructure -->
                        <tr>
                            <td colspan="{{ $selectedColleges->count() + ($selectedColleges->count() < 4 ? 2 : 1) }}" 
                                class="bg-slate-100/90 text-[#002B67] font-bold text-xs uppercase tracking-wider px-5 py-3 border-y border-slate-200">
                                <div class="flex items-center gap-2">
                                    <i class="bi bi-building text-[#002B67]"></i> Campus Amenities & Infrastructure
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="sticky left-0 z-20 bg-slate-50/95 backdrop-blur-sm font-semibold text-xs text-slate-700 px-5 py-4 border-r border-slate-200/80 shadow-[2px_0_8px_rgba(0,0,0,0.02)]">
                                Key Facilities
                            </td>
                            @foreach($selectedColleges as $col)
                                <td class="px-5 py-4 border-r border-slate-100 last:border-r-0 align-middle">
                                    <div class="flex flex-wrap gap-1.5">
                                        @forelse($col->collegeFacilities->take(6) as $fac)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-50 text-slate-700 border border-slate-200">
                                                <i class="bi bi-check-lg text-emerald-600 font-bold"></i> {{ $fac->name }}
                                            </span>
                                        @empty
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-50 text-slate-700 border border-slate-200"><i class="bi bi-wifi text-emerald-600"></i> High-Speed Wi-Fi</span>
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-50 text-slate-700 border border-slate-200"><i class="bi bi-hospital text-emerald-600"></i> Medical Aid</span>
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-50 text-slate-700 border border-slate-200"><i class="bi bi-houses text-emerald-600"></i> Hostel Facility</span>
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-50 text-slate-700 border border-slate-200"><i class="bi bi-book text-emerald-600"></i> Digital Library</span>
                                        @endforelse
                                    </div>
                                </td>
                            @endforeach
                            @if($selectedColleges->count() < 4) <td class="bg-slate-50/20"></td> @endif
                        </tr>

                        <!-- Category: Scholarships & Aid -->
                        <tr>
                            <td colspan="{{ $selectedColleges->count() + ($selectedColleges->count() < 4 ? 2 : 1) }}" 
                                class="bg-slate-100/90 text-[#002B67] font-bold text-xs uppercase tracking-wider px-5 py-3 border-y border-slate-200">
                                <div class="flex items-center gap-2">
                                    <i class="bi bi-mortarboard text-[#002B67]"></i> Scholarships & Aid
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="sticky left-0 z-20 bg-slate-50/95 backdrop-blur-sm font-semibold text-xs text-slate-700 px-5 py-4 border-r border-slate-200/80 shadow-[2px_0_8px_rgba(0,0,0,0.02)]">
                                Scholarship Schemes
                            </td>
                            @foreach($selectedColleges as $col)
                                <td class="px-5 py-4 border-r border-slate-100 last:border-r-0 align-middle">
                                    @if(($col->scholarships?->count() ?? 0) > 0)
                                        <ul class="space-y-1.5 text-xs text-slate-700 list-none p-0 m-0">
                                            @foreach(($col->scholarships?->take(3) ?? []) as $sch)
                                                <li class="flex items-start gap-1.5">
                                                    <i class="bi bi-check2 text-[#002B67] font-bold shrink-0 mt-0.5"></i>
                                                    <span><strong>{{ $sch->name }}:</strong> {{ $sch->display_amount }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-xs text-slate-400">Merit, Sports & Defense Concessions Available</span>
                                    @endif
                                </td>
                            @endforeach
                            @if($selectedColleges->count() < 4) <td class="bg-slate-50/20"></td> @endif
                        </tr>

                        <!-- Final Action CTAs -->
                        <tr class="bg-slate-50/70">
                            <td class="sticky left-0 z-20 bg-slate-100/95 backdrop-blur-sm font-bold text-xs text-slate-800 px-5 py-5 border-r border-slate-200/80 shadow-[2px_0_8px_rgba(0,0,0,0.02)]">
                                Admissions & Actions
                            </td>
                            @foreach($selectedColleges as $col)
                                <td class="px-5 py-5 border-r border-slate-200/80 last:border-r-0 align-middle">
                                    <div class="flex flex-col gap-2">
                                        <button type="button" 
                                                class="w-full py-2.5 px-4 text-xs font-bold rounded-xl bg-gradient-to-r from-[#D9A400] to-[#E5AC00] hover:from-[#B78300] hover:to-[#D9A400] text-slate-950 shadow-xs transition-all flex items-center justify-center gap-1.5 cursor-pointer"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#counselingModal"
                                                data-college-id="{{ $col->id }}"
                                                data-college-name="{{ $col->name }}">
                                            <i class="bi bi-send-fill text-xs"></i> Apply / Enquire Now
                                        </button>
                                        <a href="{{ route('college.show', $col->slug) }}" 
                                           class="w-full py-2 px-3 text-xs font-semibold text-[#002B67] hover:text-white bg-white hover:bg-[#002B67] border border-[#002B67]/30 rounded-xl transition-all flex items-center justify-center gap-1.5 shadow-xs text-center">
                                            View Full Profile <i class="bi bi-arrow-right text-xs"></i>
                                        </a>
                                    </div>
                                </td>
                            @endforeach
                            @if($selectedColleges->count() < 4) <td class="bg-slate-50/20"></td> @endif
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- Fast-Track Benchmark Pairs Launcher State (When < 2 colleges selected) -->
        <div class="space-y-6">
            <div class="text-center max-w-2xl mx-auto pt-2 pb-4">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-[#002B67] border border-blue-200 mb-2">
                    <i class="bi bi-lightning-charge-fill text-amber-500"></i> Fast-Track Comparison
                </span>
                <h3 class="text-xl sm:text-2xl font-bold text-slate-900">Popular University Benchmark Pairs</h3>
                <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-relaxed">
                    Choose one of our curated university comparisons below or select custom colleges from the slot menu above to view full side-by-side details.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @foreach($popularPairs as $pair)
                    <div class="bg-white rounded-2xl border border-slate-200/90 p-5 lg:p-6 flex flex-col justify-between hover:-translate-y-1 hover:shadow-md hover:border-[#002B67]/40 transition-all group">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-2.5">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                    {{ $pair['tag'] }}
                                </span>
                                <small class="text-slate-400 text-xs flex items-center gap-1">
                                    <i class="bi bi-arrow-left-right text-slate-400"></i> Head-to-Head
                                </small>
                            </div>
                            <h5 class="text-base font-bold text-slate-900 group-hover:text-[#002B67] transition-colors leading-snug">
                                {{ $pair['title'] }}
                            </h5>
                            <p class="text-xs text-slate-500 mt-1.5 mb-5 leading-relaxed">
                                {{ $pair['desc'] }}
                            </p>
                        </div>
                        <div>
                            @php
                                $compareUrl = route('colleges.compare', ['colleges' => implode(',', $pair['slugs'])]);
                            @endphp
                            <a href="{{ $compareUrl }}" 
                               class="w-full py-2.5 px-4 text-xs font-bold text-[#002B67] group-hover:bg-[#002B67] group-hover:text-white bg-blue-50/60 rounded-xl border border-blue-200 transition-all flex items-center justify-center gap-1.5 shadow-xs">
                                Compare These Universities <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Expert Counseling & Guidance Banner -->
    <div class="bg-gradient-to-r from-slate-50 to-blue-50/60 rounded-2xl border border-slate-200/80 p-6 lg:p-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 shadow-xs">
        <div>
            <h4 class="text-base sm:text-lg font-bold text-slate-900 flex items-center gap-2 mb-1">
                <i class="bi bi-headset text-[#002B67]"></i> Need Expert Counseling & Guidance?
            </h4>
            <p class="text-xs sm:text-sm text-slate-600 mb-0 leading-relaxed max-w-2xl">
                Not sure which university best fits your budget, career goals, or eligibility? Our senior academic counselors provide 100% free personalized consultation.
            </p>
        </div>
        <div class="shrink-0">
            <button type="button" 
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 text-xs font-bold text-slate-950 bg-gradient-to-r from-[#D9A400] to-[#E5AC00] hover:from-[#B78300] hover:to-[#D9A400] rounded-xl shadow-xs transition-all cursor-pointer" 
                    data-bs-toggle="modal" 
                    data-bs-target="#counselingModal">
                <i class="bi bi-telephone-fill text-xs"></i> Talk to a Counselor
            </button>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function focusAddCollegeSlot() {
        const selectorBar = document.getElementById('compareSelectorBar');
        if (selectorBar) {
            selectorBar.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        setTimeout(() => {
            const slots = document.querySelectorAll('.select-college-slot');
            for (let i = 0; i < slots.length; i++) {
                if (!slots[i].value) {
                    slots[i].focus();
                    slots[i].classList.add('ring-2', 'ring-[#002B67]', 'border-[#002B67]');
                    break;
                }
            }
        }, 400);
    }

    document.addEventListener('DOMContentLoaded', function () {
        @if($selectedColleges->count() > 0)
            @php
                $activeList = $selectedColleges->map(function ($col) {
                    return [
                        'id' => $col->id,
                        'slug' => $col->slug,
                        'name' => $col->short_name ?: $col->name,
                        'logo' => $col->logo ? (str_starts_with($col->logo, 'http') ? $col->logo : asset('storage/' . $col->logo)) : '',
                    ];
                })->values()->toArray();
            @endphp
            const activeColleges = {!! json_encode($activeList) !!};

            // Synchronize localStorage with active colleges in view
            if (activeColleges && activeColleges.length > 0 && typeof GP_COMPARE !== 'undefined') {
                GP_COMPARE.save(activeColleges);
            }
        @endif
    });
</script>
@endpush
