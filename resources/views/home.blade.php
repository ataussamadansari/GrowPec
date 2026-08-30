@extends('layouts.app')

@section('title', 'GrowPec - Your Career Deserves A Better College | Admission Guidance')

@push('styles')
<style>
    /* =========================================================
       GROWPEC HOMEPAGE
       ========================================================= */

    :root {
        --gp-purple: #4b2e83;
        --gp-purple-dark: #321d61;
        --gp-purple-light: #f4f1fb;
        --gp-gold: #f5a623;
        --gp-text: #252331;
        --gp-muted: #6b6875;
        --gp-border: #e7e5eb;
        --gp-bg: #f8f8fa;
    }

    /* =========================================================
       HERO
       ========================================================= */

    .hero-banner {
        background:
            radial-gradient(circle at 10% 20%,
                rgba(255, 255, 255, .08),
                transparent 30%),
            radial-gradient(circle at 90% 80%,
                rgba(245, 166, 35, .10),
                transparent 30%),
            linear-gradient(135deg,
                #1e1346 0%,
                #2e1e6b 50%,
                #4a2e9e 100%);

        color: #fff;
        padding: 85px 0 95px;
        position: relative;
        overflow: hidden;
        text-align: center;
    }

    .hero-banner::before,
    .hero-banner::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .hero-banner::before {
        width: 420px;
        height: 420px;
        top: -220px;
        left: -160px;
        background: rgba(255, 255, 255, .04);
    }

    .hero-banner::after {
        width: 500px;
        height: 500px;
        right: -220px;
        bottom: -300px;
        background: rgba(245, 166, 35, .05);
    }

    .hero-banner .container {
        position: relative;
        z-index: 2;
    }

    .hero-badge {
        background: rgba(245, 166, 35, .15);
        color: var(--gp-gold);
        border: 1px solid var(--gp-gold);
        font-weight: 700;
        font-size: .85rem;
        padding: 7px 16px;
        border-radius: 30px;
        display: inline-block;
        margin-bottom: 20px;
    }

    .hero-banner h1 {
        letter-spacing: -.8px;
    }

    .hero-search-box {
        background: #fff;
        border-radius: 16px;
        padding: 10px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, .24);
        max-width: 780px;
        margin: 0 auto 30px;
    }

    .hero-search-input {
        border: none;
        padding: 12px 20px;
        font-size: 1rem;
        width: 100%;
        outline: none;
        color: #222;
        background: transparent;
    }

    .hero-search-input::placeholder {
        color: #888;
    }

    .btn-gold {
        background: var(--gp-gold);
        border-color: var(--gp-gold);
        color: #17120a;
        font-weight: 700;
        border-radius: 10px;
    }

    .btn-gold:hover {
        background: #e89a13;
        border-color: #e89a13;
        color: #17120a;
    }

    /* =========================================================
       PROGRAM CARDS
       ========================================================= */

    .program-section {
        background: #fff;
    }

    .program-card {
        background: #fff;
        border: 1px solid var(--gp-border);
        border-radius: 14px;
        padding: 17px 12px;
        text-align: center;
        font-weight: 700;
        color: var(--gp-purple);
        transition: .25s ease;
        text-decoration: none;
        display: block;
        height: 100%;
    }

    .program-card:hover {
        transform: translateY(-3px);
        background: var(--gp-purple);
        color: #fff;
        border-color: var(--gp-purple);
        box-shadow: 0 10px 24px rgba(75, 46, 131, .16);
    }

    .program-card:hover .program-meta {
        color: rgba(255, 255, 255, .75) !important;
    }

    .program-icon {
        font-size: 1.5rem;
        margin-bottom: 5px;
        color: var(--gp-gold);
    }

    .program-meta {
        color: #777;
        font-size: .76rem;
        font-weight: 500;
    }

    /* =========================================================
       SECTION HEADINGS
       ========================================================= */

    .section-title {
        color: var(--gp-purple);
        font-weight: 800;
        letter-spacing: -.3px;
    }

    .section-subtitle {
        color: #777;
        font-size: .9rem;
    }

    .section-link {
        color: var(--gp-purple);
        border-color: var(--gp-purple);
        font-weight: 700;
        border-radius: 8px;
    }

    .section-link:hover {
        background: var(--gp-purple);
        color: #fff;
    }

    /* =========================================================
       COLLEGE GRID
       ========================================================= */

    .college-grid-section {
        background: var(--gp-bg);
    }

    .online-section {
        background: #f1eff8;
    }

    .college-grid {
        align-items: stretch;
    }

    /* =========================================================
       COLLEGE CARD
       ========================================================= */

    .college-card {
        background: #fff;
        border: 0;
        border-radius: 27px;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow:
            0 8px 24px rgba(32, 25, 48, .08);

        transition:
            transform .25s ease,
            box-shadow .25s ease;
    }

    .college-card:hover {
        transform: translateY(-5px);
        box-shadow:
            0 16px 35px rgba(32, 25, 48, .14);
    }

    /* =========================================================
       IMAGE AREA
       ========================================================= */

    .college-image-wrapper {
        height: 165px;
        width: 100%;
        position: relative;
        overflow: visible;
    }

    .college-card-img {
        width: 100%;
        height: 165px;
        object-fit: cover;
        display: block;
        border-radius: 27px 27px 0 0;
    }

    /*
     * White fade at bottom of image.
     * This gives the same clean transition as reference.
     */
    .college-image-wrapper::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: -1px;
        height: 34px;
        background: linear-gradient(to bottom,
                rgba(255, 255, 255, 0),
                rgba(255, 255, 255, .95));
        pointer-events: none;
    }

    /* =========================================================
       COLLEGE LOGO
       ========================================================= */

    .college-logo-wrapper {
        position: absolute;
        left: 20px;
        bottom: -37px;

        width: 76px;
        height: 76px;

        background: #fff;
        border-radius: 50%;

        padding: 7px;

        display: flex;
        align-items: center;
        justify-content: center;

        z-index: 5;

        box-shadow:
            0 5px 15px rgba(0, 0, 0, .13);
    }

    .college-logo {
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 50%;
        display: block;
        background: #fff;
    }

    /* =========================================================
       ONLINE / REGULAR LABEL
       ========================================================= */

    .college-type-pill {
        position: absolute;
        top: 13px;
        left: 13px;

        background: rgba(0, 0, 0, .72);
        color: #fff;

        padding: 5px 10px;
        border-radius: 7px;

        font-size: .7rem;
        font-weight: 700;

        backdrop-filter: blur(5px);
        z-index: 3;
    }

    .college-type-pill.online {
        background: rgba(25, 135, 84, .92);
    }

    /* =========================================================
       CARD BODY
       ========================================================= */

    .college-card-body {
        padding: 42px 17px 15px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .college-name {
        color: var(--gp-purple);
        font-size: 1rem;
        line-height: 1.55;
        font-weight: 700;

        margin: 0 0 12px;

        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;

        min-height: 49px;
    }

    /* =========================================================
       COLLEGE INFORMATION ROWS
       ========================================================= */

    .college-info {
        margin-top: auto;
    }

    .college-info-row {
        min-height: 42px;

        display: flex;
        align-items: center;
        gap: 11px;

        border-bottom: 1px solid #e6e4e8;

        color: #44404a;
        font-size: .83rem;
        line-height: 1.35;
    }

    .college-info-row:last-child {
        border-bottom: 0;
    }

    .college-info-icon {
        width: 20px;
        min-width: 20px;

        text-align: center;

        color: #111;
        font-size: .95rem;
    }

    .college-info-text {
        min-width: 0;
        flex: 1;

        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* =========================================================
       FULL CARD CLICK
       ========================================================= */

    .college-card {
        color: inherit;
        text-decoration: none;
        cursor: pointer;
    }

    .college-card:hover,
    .college-card:focus,
    .college-card:active {
        color: inherit;
        text-decoration: none;
    }

    .college-card:focus-visible {
        outline: 3px solid rgba(75, 46, 131, .25);
        outline-offset: 3px;
    }

    /* =========================================================
       FEATURE BOX
       ========================================================= */

    .feature-box {
        background: #fff;
        border-radius: 16px;
        padding: 25px;
        border: 1px solid #eeeaf5;
        transition: .25s ease;
    }

    .feature-box:hover {
        background: #faf8ff;
        border-color: #d9d0ef;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(75, 46, 131, .08);
    }

    .feature-icon {
        width: 50px;
        height: 50px;

        background: #ede9fe;
        color: var(--gp-purple);

        border-radius: 12px;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 1.5rem;
        margin-bottom: 15px;
    }

    /* =========================================================
       RESPONSIVE
       ========================================================= */

    @media (max-width: 991.98px) {

        .college-image-wrapper,
        .college-card-img {
            height: 175px;
        }

        .college-card-body {
            padding-left: 16px;
            padding-right: 16px;
        }
    }

    @media (max-width: 767.98px) {

        .hero-banner {
            padding: 60px 0 70px;
        }

        .hero-banner h1 {
            font-size: 2rem;
        }

        .hero-search-box {
            padding: 8px;
        }

        .college-image-wrapper,
        .college-card-img {
            height: 170px;
        }

        .college-card {
            border-radius: 22px;
        }

        .college-card-img {
            border-radius: 22px 22px 0 0;
        }

        .college-logo-wrapper {
            left: 17px;
            width: 70px;
            height: 70px;
            bottom: -34px;
        }

        .college-card-body {
            padding-top: 39px;
        }

        .college-name {
            font-size: .95rem;
        }

        .section-heading-mobile {
            align-items: flex-start !important;
            gap: 15px;
        }

        .section-heading-mobile .section-link {
            white-space: nowrap;
        }
    }

    @media (max-width: 575.98px) {

        .hero-banner h1 {
            font-size: 1.8rem;
        }

        .hero-search-input {
            padding-left: 10px;
            padding-right: 10px;
        }

        .hero-search-box button {
            width: 100%;
        }

        .college-grid>.col-12 {
            width: 100%;
        }

        .college-image-wrapper,
        .college-card-img {
            height: 175px;
        }
    }
</style>
@endpush


@section('content')

{{-- =========================================================
     1. HERO
     ========================================================= --}}
<section class="hero-banner">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-10">

                <span class="hero-badge">
                    <i class="bi bi-patch-check-fill me-1"></i>
                    India's #1 College Discovery Portal
                </span>

                <h1 class="display-4 fw-extrabold mb-3">
                    Your Career Deserves A
                    <span style="color: var(--gp-gold);">
                        Better College
                    </span>
                </h1>

                <p class="lead mb-4 text-white-50 max-w-xl mx-auto">
                    Compare verified fees, check NAAC & UGC approvals,
                    get scholarship assistance, and connect with top counselors.
                </p>


                {{-- SEARCH --}}
                <div class="hero-search-box">

                    <form
                        action="{{ route('colleges.regular') }}"
                        method="GET"
                        class="d-flex flex-column flex-md-row gap-2">

                        <div class="d-flex align-items-center flex-grow-1 px-2">

                            <i class="bi bi-search text-muted fs-5 me-2"></i>

                            <input
                                type="text"
                                name="search"
                                class="hero-search-input"
                                placeholder="Search college name, course (e.g. BCA, MBA, B.Tech), or city...">

                        </div>

                        <button
                            type="submit"
                            class="btn btn-gold px-4 py-3">
                            Explore Colleges
                            <i class="bi bi-arrow-right ms-1"></i>
                        </button>

                    </form>

                </div>


                {{-- STATS --}}
                <div class="d-flex flex-wrap gap-4 justify-content-center text-white mt-2">

                    <div>
                        <h4 class="fw-bold mb-0 text-warning">500+</h4>
                        <small class="text-white-50">
                            Verified Colleges
                        </small>
                    </div>

                    <div class="vr bg-secondary"></div>

                    <div>
                        <h4 class="fw-bold mb-0 text-warning">15,000+</h4>
                        <small class="text-white-50">
                            Students Guided
                        </small>
                    </div>

                    <div class="vr bg-secondary"></div>

                    <div>
                        <h4 class="fw-bold mb-0 text-warning">100%</h4>
                        <small class="text-white-50">
                            Verified Details
                        </small>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



{{-- =========================================================
     2. POPULAR PROGRAMS
     ========================================================= --}}
<section class="py-5 program-section">

    <div class="container">

        <div class="text-center mb-4">

            <h3 class="section-title">
                Explore Top Programs
            </h3>

            <p class="section-subtitle mb-0">
                Choose your desired degree and explore top institutes
            </p>

        </div>


        <div class="row row-cols-2 row-cols-md-4 g-3">

            @foreach($popularCourses as $course)

            <div class="col">

                <a
                    href="{{ route('colleges.regular') }}?courses[]={{ $course->slug }}"
                    class="program-card">

                    <i class="bi bi-mortarboard program-icon d-block"></i>

                    {{ $course->name }}

                    <div class="program-meta mt-1">
                        {{ $course->level }}
                        •
                        {{ $course->duration }}
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

        <div class="d-flex justify-content-between align-items-end mb-4 section-heading-mobile">

            <div>

                <span class="badge bg-primary-subtle text-primary fw-bold mb-1">
                    Campus Programs
                </span>

                <h3 class="section-title mb-0">
                    Top Regular Colleges
                </h3>

            </div>

            <a
                href="{{ route('colleges.regular') }}"
                class="btn btn-outline-primary btn-sm section-link">
                View All
                <i class="bi bi-chevron-right"></i>
            </a>

        </div>


        <div class="row g-4 college-grid">

            @forelse($regularColleges as $college)

            <div class="col-xl-3 col-lg-4 col-md-6">

                <a href="{{ route('college.show', $college->slug) }}" class="college-card text-decoration-none">

                    {{-- IMAGE --}}
                    <div class="college-image-wrapper">

                        <img
                            src="{{ $college->banner_url }}"
                            class="college-card-img"
                            alt="{{ $college->name }}"
                            loading="lazy">


                        {{-- TYPE --}}
                        @if($college->college_type)

                        <span class="college-type-pill">

                            {{ $college->college_type }}

                        </span>

                        @endif


                        {{-- LOGO --}}
                        <div class="college-logo-wrapper">

                            <img
                                src="{{ $college->logo_url ?? $college->logo ?? $college->banner_url }}"
                                class="college-logo"
                                alt="{{ $college->name }} logo"
                                loading="lazy">

                        </div>

                    </div>


                    {{-- BODY --}}
                    <div class="college-card-body">

                        <h5 class="college-name">
                            {{ $college->name }}
                        </h5>


                        <div class="college-info">

                            {{-- TYPE --}}
                            <div class="college-info-row">

                                <span class="college-info-icon">
                                    <i class="bi bi-bank2"></i>
                                </span>

                                <span
                                    class="college-info-text"
                                    title="{{ $college->college_type }}">
                                    {{ $college->college_type ?: 'University / College' }}
                                </span>

                            </div>


                            {{-- LOCATION --}}
                            <div class="college-info-row">

                                <span class="college-info-icon">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </span>

                                <span
                                    class="college-info-text"
                                    title="{{ $college->state }}, {{ $college->city }}">
                                    {{ $college->state }}, {{ $college->city }}
                                </span>

                            </div>


                            {{-- ESTABLISHED --}}
                            <div class="college-info-row">

                                <span class="college-info-icon">
                                    <i class="bi bi-gear-fill"></i>
                                </span>

                                <span class="college-info-text">

                                    @if($college->established_year)
                                    Estd year {{ $college->established_year }}
                                    @else
                                    Established information unavailable
                                    @endif

                                </span>

                            </div>

                        </div>

                    </div>

                </a>

            </div>

            @empty

            <div class="col-12 text-center py-5">

                <p class="text-muted mb-0">
                    Colleges are being updated.
                    Check back soon!
                </p>

            </div>

            @endforelse

        </div>

    </div>

</section>



{{-- =========================================================
     4. TOP ONLINE UNIVERSITIES
     ========================================================= --}}
<section class="py-5 online-section">

    <div class="container">

        <div class="d-flex justify-content-between align-items-end mb-4 section-heading-mobile">

            <div>

                <span class="badge bg-success-subtle text-success fw-bold mb-1">
                    UGC-DEB Approved
                </span>

                <h3 class="section-title mb-0">
                    Top Online Universities
                </h3>

            </div>

            <a
                href="{{ route('colleges.online') }}"
                class="btn btn-outline-primary btn-sm section-link">
                View All
                <i class="bi bi-chevron-right"></i>
            </a>

        </div>


        <div class="row g-4 college-grid">

            @forelse($onlineColleges as $college)

            <div class="col-xl-3 col-lg-4 col-md-6">

                <a href="{{ route('college.show', $college->slug) }}" class="college-card text-decoration-none">

                    {{-- IMAGE --}}
                    <div class="college-image-wrapper">

                        <img
                            src="{{ $college->banner_url }}"
                            class="college-card-img"
                            alt="{{ $college->name }}"
                            loading="lazy">


                        {{-- ONLINE LABEL --}}
                        <span class="college-type-pill online">
                            100% Online
                        </span>


                        {{-- LOGO --}}
                        <div class="college-logo-wrapper">

                            <img
                                src="{{ $college->logo_url ?? $college->logo ?? $college->banner_url }}"
                                class="college-logo"
                                alt="{{ $college->name }} logo"
                                loading="lazy">

                        </div>

                    </div>


                    {{-- BODY --}}
                    <div class="college-card-body">

                        <h5 class="college-name">
                            {{ $college->name }}
                        </h5>


                        <div class="college-info">

                            {{-- DELIVERY --}}
                            <div class="college-info-row">

                                <span class="college-info-icon">
                                    <i class="bi bi-bank2"></i>
                                </span>

                                <span class="college-info-text">
                                    {{ $college->college_type ?: 'University' }}
                                </span>

                            </div>


                            {{-- LOCATION --}}
                            <div class="college-info-row">

                                <span class="college-info-icon">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </span>

                                <span
                                    class="college-info-text"
                                    title="{{ $college->state }}, {{ $college->city }}">
                                    {{ $college->state }}, {{ $college->city }}
                                </span>

                            </div>


                            {{-- ESTABLISHED --}}
                            <div class="college-info-row">

                                <span class="college-info-icon">
                                    <i class="bi bi-gear-fill"></i>
                                </span>

                                <span class="college-info-text">

                                    @if($college->established_year)
                                    Estd year {{ $college->established_year }}
                                    @else
                                    Established information unavailable
                                    @endif

                                </span>

                            </div>

                        </div>

                    </div>

                </a>

            </div>

            @empty

            <div class="col-12 text-center py-5">

                <p class="text-muted mb-0">
                    Online universities data coming soon.
                </p>

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
            <h2 class="section-title">
                Why Choose GrowPec?
            </h2>
            <p class="text-secondary">
                We bridge the gap between students and the best colleges across India.
            </p>
        </div>
        <div class="row g-4">

            {{-- FEATURE 1 --}}
            <div class="col-md-4">
                <div class="feature-box h-100">
                    <div class="feature-icon">
                        <i class="bi bi-patch-check"></i>
                    </div>
                    <h5 class="fw-bold mb-2">
                        Verified University Data
                    </h5>
                    <p class="text-muted small mb-0">
                        Direct fees, UGC & AICTE accreditation,
                        and verified placement reports.
                    </p>
                </div>
            </div>

            {{-- FEATURE 2 --}}
            <div class="col-md-4">
                <div class="feature-box h-100">
                    <div class="feature-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <h5 class="fw-bold mb-2">
                        Scholarships Assistance
                    </h5>
                    <p class="text-muted small mb-0">
                        Access merit scholarships and guidance
                        on education loan approvals.
                    </p>
                </div>
            </div>

            {{-- FEATURE 3 --}}
            <div class="col-md-4">
                <div class="feature-box h-100">
                    <div class="feature-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <h5 class="fw-bold mb-2">
                        1-on-1 Guidance
                    </h5>
                    <p class="text-muted small mb-0">
                        Connect directly with experienced counselors
                        after simple verification.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection