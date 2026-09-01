@extends('layouts.app')

@section('title', 'GrowPec - Your Career Deserves A Better College | Admission Guidance')

@push('styles')
<style>
    :root {
        --gp-purple: #4b2e83;
        --gp-purple-dark: #2E1E6B;
        --gp-gold: #F5A623;
        --gp-gold-hover: #E09612;
        --gp-bg: #F8F8FA;
        --gp-border: #E7E5EB;
    }

    /* =========================================================
       1. 🎯 100% FULL WIDTH & FULL SCREEN HEIGHT HERO SLIDER
       ========================================================= */
    .hero-slider-section {
        width: 100%;
        padding: 0;
        margin: 0;
        overflow: hidden;
        background: #000;
    }

    .hero-carousel-container {
        width: 100%;
        border-radius: 0;
        overflow: hidden;
    }

    /* Full screen viewport height (Screen size minus Navbar) */
    .hero-banner-img {
        width: 100%;
        height: calc(100vh - 280px);
        min-height: 520px;
        object-fit: cover;
        display: block;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.45);
        border-radius: 50%;
        background-size: 50%;
        width: 48px;
        height: 48px;
    }

    .carousel-indicators [data-bs-target] {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: #ffffff;
        margin: 0 6px;
        border: none;
        opacity: 0.6;
    }

    .carousel-indicators .active {
        background-color: var(--gp-gold);
        opacity: 1;
        width: 32px;
        border-radius: 12px;
    }

    /* =========================================================
       2. PROGRAM CARDS
       ========================================================= */
    .program-section {
        background: #ffffff;
    }

    .program-card {
        background: #ffffff;
        border: 1px solid var(--gp-border);
        border-radius: 14px;
        padding: 18px 12px;
        text-align: center;
        font-weight: 700;
        color: var(--gp-purple);
        transition: all 0.25s ease;
        text-decoration: none;
        display: block;
        height: 100%;
    }

    .program-card:hover {
        transform: translateY(-3px);
        background: var(--gp-purple);
        color: #ffffff;
        border-color: var(--gp-purple);
        box-shadow: 0 10px 24px rgba(75, 46, 131, 0.16);
    }

    .program-card:hover .program-meta {
        color: rgba(255, 255, 255, 0.75) !important;
    }

    .program-icon {
        font-size: 1.5rem;
        margin-bottom: 6px;
        color: var(--gp-gold);
    }

    .program-meta {
        color: #777;
        font-size: 0.76rem;
        font-weight: 500;
    }

    /* =========================================================
       3. SECTION HEADINGS
       ========================================================= */
    .section-title {
        color: var(--gp-purple);
        font-weight: 800;
        letter-spacing: -0.3px;
    }

    .section-subtitle {
        color: #777;
        font-size: 0.9rem;
    }

    .section-link {
        color: var(--gp-purple);
        border-color: var(--gp-purple);
        font-weight: 700;
        border-radius: 8px;
    }

    .section-link:hover {
        background: var(--gp-purple);
        color: #ffffff;
    }

    /* =========================================================
       4. COLLEGE CARDS
       ========================================================= */
    .college-grid-section {
        background: var(--gp-bg);
    }

    .online-section {
        background: #F1EFF8;
    }

    .college-card {
        background: #ffffff;
        border: 0;
        border-radius: 24px;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 8px 24px rgba(32, 25, 48, 0.08);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        text-decoration: none;
        color: inherit;
        cursor: pointer;
    }

    .college-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 35px rgba(32, 25, 48, 0.14);
        color: inherit;
    }

    .college-image-wrapper {
        height: 165px;
        width: 100%;
        position: relative;
    }

    .college-card-img {
        width: 100%;
        height: 165px;
        object-fit: cover;
        display: block;
        border-radius: 24px 24px 0 0;
    }

    .college-image-wrapper::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: -1px;
        height: 34px;
        background: linear-gradient(to bottom, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.95));
        pointer-events: none;
    }

    .college-logo-wrapper {
        position: absolute;
        left: 20px;
        bottom: -35px;
        width: 72px;
        height: 72px;
        background: #ffffff;
        border-radius: 50%;
        padding: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 5;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.12);
    }

    .college-logo {
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 50%;
        display: block;
        background: #ffffff;
    }

    .college-type-pill {
        position: absolute;
        top: 12px;
        left: 12px;
        background: rgba(0, 0, 0, 0.72);
        color: #ffffff;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 700;
        backdrop-filter: blur(4px);
        z-index: 3;
    }

    .college-type-pill.online {
        background: rgba(25, 135, 84, 0.92);
    }

    .college-card-body {
        padding: 42px 18px 16px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .college-name {
        color: var(--gp-purple);
        font-size: 1rem;
        line-height: 1.45;
        font-weight: 700;
        margin: 0 0 12px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
        min-height: 46px;
    }

    .college-info {
        margin-top: auto;
    }

    .college-info-row {
        min-height: 38px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 1px solid #E6E4E8;
        color: #44404A;
        font-size: 0.82rem;
        line-height: 1.35;
    }

    .college-info-row:last-child {
        border-bottom: 0;
    }

    .college-info-icon {
        width: 18px;
        min-width: 18px;
        text-align: center;
        color: #475569;
        font-size: 0.9rem;
    }

    .college-info-text {
        min-width: 0;
        flex: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* =========================================================
       5. FEATURE VALUE PROPOSITIONS
       ========================================================= */
    .feature-box {
        background: #ffffff;
        border-radius: 16px;
        padding: 25px;
        border: 1px solid #EEEAF5;
        transition: all 0.25s ease;
    }

    .feature-box:hover {
        background: #FAF8FF;
        border-color: #D9D0EF;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(75, 46, 131, 0.08);
    }

    .feature-icon {
        width: 50px;
        height: 50px;
        background: #EDE9FE;
        color: var(--gp-purple);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 15px;
    }

    @media (max-width: 991.98px) {
        .hero-banner-img {
            height: 50vh;
            min-height: 320px;
        }
    }

    @media (max-width: 575.98px) {
        .hero-banner-img {
            height: 38vh;
            min-height: 220px;
        }
    }
</style>
@endpush

@section('content')

{{-- =========================================================
     1. 🎯 100% FULL WIDTH & FULL SCREEN BANNER SLIDER (AUTO SLIDE ONLY)
     ========================================================= --}}
<section class="hero-slider-section">
    <div id="heroBannerCarousel" class="carousel slide carousel-fade hero-carousel-container" data-bs-ride="carousel" data-bs-interval="3000">
        
        <!-- Bottom Indicators (Dots) -->
        @php
            $bannerCount = isset($heroBanners) ? $heroBanners->count() : 0;
        @endphp

        @if($bannerCount > 1 || $bannerCount === 0)
        <div class="carousel-indicators mb-3">
            @if($bannerCount > 0)
                @foreach($heroBanners as $index => $banner)
                <button type="button" data-bs-target="#heroBannerCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}"></button>
                @endforeach
            @else
                <button type="button" data-bs-target="#heroBannerCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
                <button type="button" data-bs-target="#heroBannerCarousel" data-bs-slide-to="1"></button>
            @endif
        </div>
        @endif

        <!-- Banner Slides -->
        <div class="carousel-inner">
            @if($bannerCount > 0)
                @foreach($heroBanners as $index => $banner)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" data-bs-interval="3000">
                    <img src="{{ $banner->image_url }}" class="d-block w-100 hero-banner-img" alt="{{ $banner->title ?: 'GrowPEC Banner' }}">
                </div>
                @endforeach
            @else
                <!-- Fallback Images -->
                <div class="carousel-item active" data-bs-interval="3000">
                    <img src="{{ asset('assets/hero_b1.jpg') }}" class="d-block w-100 hero-banner-img" alt="GrowPEC Banner 1">
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <img src="{{ asset('assets/hero_b2.jpg') }}" class="d-block w-100 hero-banner-img" alt="GrowPEC Banner 2">
                </div>
            @endif
        </div>

    </div>
</section>

{{-- =========================================================
     2. EXPLORE TOP PROGRAMS
     ========================================================= --}}
<section class="py-5 program-section">
    <div class="container">
        <div class="text-center mb-4">
            <h3 class="section-title">Explore Top Programs</h3>
            <p class="section-subtitle mb-0">Choose your desired degree and explore top institutes</p>
        </div>

        <div class="row row-cols-2 row-cols-md-4 g-3">
            @foreach($popularCourses as $course)
            <div class="col">
                <a href="{{ route('colleges.regular') }}?courses[]={{ $course->slug }}" class="program-card">
                    <i class="bi bi-mortarboard program-icon d-block"></i>
                    {{ $course->name }}
                    <div class="program-meta mt-1">
                        {{ $course->level }} • {{ $course->duration }}
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- =========================================================
     3. TOP REGULAR COLLEGES
     ========================================================= --}}
<section class="py-5 college-grid-section">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="badge bg-primary-subtle text-primary fw-bold mb-1">Campus Programs</span>
                <h3 class="section-title mb-0">Top Regular Colleges</h3>
            </div>
            <a href="{{ route('colleges.regular') }}" class="btn btn-outline-primary btn-sm section-link">
                View All <i class="bi bi-chevron-right"></i>
            </a>
        </div>

        <div class="row g-4 college-grid">
            @forelse($regularColleges as $college)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <a href="{{ route('college.show', $college->slug) }}" class="college-card">
                    <div class="college-image-wrapper">
                        <img src="{{ $college->banner_url }}" class="college-card-img" alt="{{ $college->name }}" loading="lazy">
                        @if($college->college_type)
                        <span class="college-type-pill">{{ $college->college_type }}</span>
                        @endif
                        <div class="college-logo-wrapper">
                            <img src="{{ $college->logo_url ?? $college->banner_url }}" class="college-logo" alt="{{ $college->name }} logo" loading="lazy">
                        </div>
                    </div>

                    <div class="college-card-body">
                        <h5 class="college-name">{{ $college->name }}</h5>
                        <div class="college-info">
                            <div class="college-info-row">
                                <span class="college-info-icon"><i class="bi bi-bank2"></i></span>
                                <span class="college-info-text">{{ $college->college_type ?: 'University / College' }}</span>
                            </div>
                            <div class="college-info-row">
                                <span class="college-info-icon"><i class="bi bi-geo-alt-fill text-danger"></i></span>
                                <span class="college-info-text">{{ $college->state }}, {{ $college->city }}</span>
                            </div>
                            <div class="college-info-row">
                                <span class="college-info-icon"><i class="bi bi-gear-fill"></i></span>
                                <span class="college-info-text">
                                    @if($college->established_year)
                                    Estd year {{ $college->established_year }}
                                    @else
                                    Established info unavailable
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted mb-0">Colleges are being updated. Check back soon!</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- =========================================================
     4. TOP ONLINE & DISTANCE UNIVERSITIES
     ========================================================= --}}
<section class="py-5 online-section">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="badge bg-success-subtle text-success fw-bold mb-1">UGC-DEB Approved</span>
                <h3 class="section-title mb-0">Top Online Universities</h3>
            </div>
            <a href="{{ route('colleges.online') }}" class="btn btn-outline-primary btn-sm section-link">
                View All <i class="bi bi-chevron-right"></i>
            </a>
        </div>

        <div class="row g-4 college-grid">
            @forelse($onlineColleges as $college)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <a href="{{ route('college.show', $college->slug) }}" class="college-card">
                    <div class="college-image-wrapper">
                        <img src="{{ $college->banner_url }}" class="college-card-img" alt="{{ $college->name }}" loading="lazy">
                        <span class="college-type-pill online">100% Online</span>
                        <div class="college-logo-wrapper">
                            <img src="{{ $college->logo_url ?? $college->banner_url }}" class="college-logo" alt="{{ $college->name }} logo" loading="lazy">
                        </div>
                    </div>

                    <div class="college-card-body">
                        <h5 class="college-name">{{ $college->name }}</h5>
                        <div class="college-info">
                            <div class="college-info-row">
                                <span class="college-info-icon"><i class="bi bi-bank2"></i></span>
                                <span class="college-info-text">{{ $college->college_type ?: 'University' }}</span>
                            </div>
                            <div class="college-info-row">
                                <span class="college-info-icon"><i class="bi bi-geo-alt-fill text-danger"></i></span>
                                <span class="college-info-text">{{ $college->state }}, {{ $college->city }}</span>
                            </div>
                            <div class="college-info-row">
                                <span class="college-info-icon"><i class="bi bi-gear-fill"></i></span>
                                <span class="college-info-text">
                                    @if($college->established_year)
                                    Estd year {{ $college->established_year }}
                                    @else
                                    Established info unavailable
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted mb-0">Online universities data coming soon.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- =========================================================
     5. WHY CHOOSE GROWPEC
     ========================================================= --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center max-w-xl mx-auto mb-5">
            <h2 class="section-title">Why Choose GrowPec?</h2>
            <p class="text-secondary">We bridge the gap between students and the best colleges across India.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-box h-100">
                    <div class="feature-icon"><i class="bi bi-patch-check"></i></div>
                    <h5 class="fw-bold mb-2">Verified University Data</h5>
                    <p class="text-muted small mb-0">Direct fees, UGC & AICTE accreditation, and verified placement reports.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box h-100">
                    <div class="feature-icon"><i class="bi bi-wallet2"></i></div>
                    <h5 class="fw-bold mb-2">Scholarships Assistance</h5>
                    <p class="text-muted small mb-0">Access merit scholarships and guidance on education loan approvals.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box h-100">
                    <div class="feature-icon"><i class="bi bi-shield-lock"></i></div>
                    <h5 class="fw-bold mb-2">1-on-1 Guidance</h5>
                    <p class="text-muted small mb-0">Connect directly with experienced counselors after simple verification.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection