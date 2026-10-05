@extends('layouts.app')

@section('title', '404 - Page Not Found | ' . ($siteSettings['general.site_name'] ?? 'GrowPEC'))
@section('meta_description', 'The page you were looking for could not be found. Explore top colleges, online degrees, and admission guidance on GrowPEC.')

@section('content')
<style>
    /* =========================================================
       GrowPEC 404 Experience Design System
       ========================================================= */
    .gp-404-wrapper {
        position: relative;
        padding: 60px 0 85px;
        overflow: hidden;
        min-height: 70vh;
        display: flex;
        align-items: center;
    }

    .gp-404-bg-glow-1 {
        position: absolute;
        width: 480px;
        height: 480px;
        top: -160px;
        left: 50%;
        transform: translateX(-50%);
        background: radial-gradient(circle, rgba(0, 43, 103, 0.08) 0%, rgba(0, 138, 67, 0.05) 50%, transparent 70%);
        pointer-events: none;
        z-index: 0;
        filter: blur(40px);
    }

    .gp-404-bg-glow-2 {
        position: absolute;
        width: 320px;
        height: 320px;
        bottom: 20px;
        right: -80px;
        background: radial-gradient(circle, rgba(217, 164, 0, 0.08) 0%, transparent 70%);
        pointer-events: none;
        z-index: 0;
        filter: blur(30px);
    }

    .gp-404-card {
        position: relative;
        z-index: 1;
        background: #ffffff;
        border: 1px solid rgba(0, 43, 103, 0.08);
        border-radius: 28px;
        box-shadow: 0 20px 60px rgba(0, 43, 103, 0.07);
        padding: 50px 40px;
    }

    /* Badge */
    .gp-404-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #FEF7E6;
        border: 1px solid #F8DE96;
        color: #9A6F00;
        font-size: 0.8rem;
        font-weight: 800;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding: 7px 16px;
        border-radius: 50px;
        margin-bottom: 20px;
    }

    .gp-404-badge i {
        font-size: 0.95rem;
        color: #D9A400;
    }

    /* Huge 404 Typography */
    .gp-404-number {
        font-size: clamp(6.2rem, 15vw, 10.5rem);
        font-weight: 900;
        line-height: 0.92;
        letter-spacing: -0.05em;
        margin-bottom: 16px;
        background: linear-gradient(135deg, #001B45 0%, #002B67 45%, #008A43 78%, #D9A400 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 12px 30px rgba(0, 43, 103, 0.12);
        user-select: none;
    }

    .gp-404-title {
        font-size: clamp(1.4rem, 3.5vw, 2.1rem);
        font-weight: 800;
        color: #001B45;
        margin-bottom: 12px;
        letter-spacing: -0.02em;
    }

    .gp-404-subtitle {
        font-size: clamp(0.92rem, 1.8vw, 1.05rem);
        color: #5A6A80;
        line-height: 1.65;
        max-width: 640px;
        margin: 0 auto 32px;
    }

    /* Search Box */
    .gp-404-search-box {
        max-width: 580px;
        margin: 0 auto 40px;
    }

    .gp-404-search-inner {
        position: relative;
        display: flex;
        align-items: center;
        background: #F8FAFD;
        border: 2px solid #E1E8F2;
        border-radius: 16px;
        padding: 5px 6px 5px 18px;
        transition: all 0.25s ease;
    }

    .gp-404-search-inner:focus-within {
        background: #ffffff;
        border-color: #002B67;
        box-shadow: 0 8px 25px rgba(0, 43, 103, 0.12);
    }

    .gp-404-search-inner i.search-icon {
        color: #8A98A8;
        font-size: 1.15rem;
        margin-right: 12px;
    }

    .gp-404-search-input {
        flex: 1;
        border: none;
        outline: none;
        background: transparent;
        font-size: 0.95rem;
        font-weight: 600;
        color: #172033;
    }

    .gp-404-search-input::placeholder {
        color: #9BA8B8;
        font-weight: 500;
    }

    .gp-404-search-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #002B67;
        color: #ffffff;
        border: none;
        border-radius: 12px;
        padding: 10px 20px;
        font-size: 0.88rem;
        font-weight: 750;
        transition: all 0.22s ease;
        white-space: nowrap;
    }

    .gp-404-search-btn:hover {
        background: #001B45;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(0, 43, 103, 0.25);
    }

    /* Shortcut Navigation Cards */
    .gp-404-shortcuts-title {
        font-size: 0.76rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #8C99A8;
        margin-bottom: 16px;
    }

    .gp-404-nav-card {
        display: flex;
        flex-direction: column;
        height: 100%;
        background: #F8FAFD;
        border: 1px solid #E5ECF4;
        border-radius: 18px;
        padding: 22px 20px;
        text-decoration: none;
        text-align: left;
        transition: all 0.25s ease;
    }

    .gp-404-nav-card:hover {
        background: #ffffff;
        border-color: #002B67;
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0, 43, 103, 0.08);
    }

    .gp-404-card-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin-bottom: 14px;
        transition: transform 0.25s ease;
    }

    .gp-404-nav-card:hover .gp-404-card-icon {
        transform: scale(1.08);
    }

    .gp-icon-blue {
        background: rgba(0, 43, 103, 0.10);
        color: #002B67;
    }

    .gp-icon-green {
        background: rgba(0, 138, 67, 0.12);
        color: #008A43;
    }

    .gp-icon-gold {
        background: rgba(217, 164, 0, 0.14);
        color: #B78300;
    }

    .gp-icon-purple {
        background: rgba(105, 69, 165, 0.12);
        color: #553488;
    }

    .gp-404-card-heading {
        font-size: 0.98rem;
        font-weight: 800;
        color: #001B45;
        margin-bottom: 6px;
    }

    .gp-404-card-text {
        font-size: 0.8rem;
        color: #6C7A8C;
        line-height: 1.45;
        margin-bottom: 12px;
        flex: 1;
    }

    .gp-404-card-link {
        font-size: 0.82rem;
        font-weight: 750;
        color: #002B67;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .gp-404-card-link i {
        transition: transform 0.2s ease;
    }

    .gp-404-nav-card:hover .gp-404-card-link i {
        transform: translateX(4px);
    }

    /* Popular Course Tags */
    .gp-404-tags {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 34px;
        padding-top: 26px;
        border-top: 1px solid #EDF2F7;
    }

    .gp-404-tags-label {
        font-size: 0.78rem;
        font-weight: 750;
        color: #64748B;
        margin-right: 4px;
    }

    .gp-404-tag {
        font-size: 0.78rem;
        font-weight: 650;
        color: #002B67;
        background: #EEF4F9;
        border: 1px solid #D8E4EE;
        padding: 5px 12px;
        border-radius: 20px;
        text-decoration: none;
        transition: all 0.18s ease;
    }

    .gp-404-tag:hover {
        background: #002B67;
        border-color: #002B67;
        color: #ffffff;
    }

    /* Help Banner */
    .gp-404-help-banner {
        margin-top: 36px;
        background: linear-gradient(135deg, #001B45 0%, #002B67 100%);
        border-radius: 20px;
        padding: 24px 30px;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
        text-align: left;
    }

    .gp-404-help-info h5 {
        font-size: 1.1rem;
        font-weight: 800;
        color: #ffffff;
        margin: 0 0 4px;
    }

    .gp-404-help-info p {
        font-size: 0.86rem;
        color: rgba(255, 255, 255, 0.78);
        margin: 0;
    }

    .gp-404-help-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .gp-404-btn-gold {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #D9A400;
        color: #101A12;
        font-size: 0.85rem;
        font-weight: 800;
        padding: 10px 18px;
        border-radius: 10px;
        text-decoration: none;
        border: none;
        transition: all 0.22s ease;
    }

    .gp-404-btn-gold:hover {
        background: #ffffff;
        color: #002B67;
        transform: translateY(-2px);
    }

    .gp-404-btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.25);
        color: #ffffff;
        font-size: 0.85rem;
        font-weight: 750;
        padding: 10px 16px;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.22s ease;
    }

    .gp-404-btn-outline:hover {
        background: rgba(255, 255, 255, 0.2);
        color: #ffffff;
    }

    @media (max-width: 767.98px) {
        .gp-404-card {
            padding: 35px 20px;
            border-radius: 20px;
        }

        .gp-404-search-inner {
            flex-direction: column;
            padding: 10px;
            gap: 10px;
        }

        .gp-404-search-inner i.search-icon {
            display: none;
        }

        .gp-404-search-input {
            width: 100%;
            text-align: center;
            padding: 4px;
        }

        .gp-404-search-btn {
            width: 100%;
            justify-content: center;
        }

        .gp-404-help-banner {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }

        .gp-404-help-actions {
            width: 100%;
            justify-content: center;
        }

        .gp-404-help-actions a,
        .gp-404-help-actions button {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="gp-404-wrapper">
    <div class="gp-404-bg-glow-1"></div>
    <div class="gp-404-bg-glow-2"></div>

    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="col-xl-11 col-xxl-10">
                <div class="gp-404-card text-center">
                    
                    <!-- Top Pill Badge -->
                    <div class="gp-404-badge">
                        <i class="bi bi-compass-fill"></i>
                        <span>Error 404 • Destination Unknown</span>
                    </div>

                    <!-- Giant 404 Graphic -->
                    <div class="gp-404-number">404</div>

                    <!-- Heading & Subtitle -->
                    <h1 class="gp-404-title">Oops! We Couldn't Find That College or Page</h1>
                    <p class="gp-404-subtitle">
                        The URL you entered might be misspelled, outdated, or the course page may have moved. 
                        Don't worry — your admission and higher education journey continues right here!
                    </p>

                    <!-- Interactive Direct Search -->
                    <form action="{{ route('colleges.regular') }}" method="GET" class="gp-404-search-box">
                        <div class="gp-404-search-inner">
                            <i class="bi bi-search search-icon"></i>
                            <input type="text" name="search" class="gp-404-search-input" placeholder="Search 500+ verified colleges, courses (MBA, B.Tech), or cities..." required>
                            <button type="submit" class="gp-404-search-btn">
                                <span>Search Colleges</span>
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </form>

                    <!-- Shortcut Navigation Cards Grid -->
                    <div class="text-center">
                        <div class="gp-404-shortcuts-title">Helpful Shortcuts to Continue Your Search</div>
                    </div>

                    <div class="row g-3 g-md-4 text-start">
                        <!-- Card 1: Regular Colleges -->
                        <div class="col-lg-3 col-sm-6">
                            <a href="{{ route('colleges.regular') }}" class="gp-404-nav-card">
                                <span class="gp-404-card-icon gp-icon-blue">
                                    <i class="bi bi-buildings-fill"></i>
                                </span>
                                <div class="gp-404-card-heading">Regular Colleges</div>
                                <div class="gp-404-card-text">
                                    Explore verified on-campus universities, NIRF rankings, and placement packages.
                                </div>
                                <div class="gp-404-card-link">
                                    <span>Browse Campuses</span>
                                    <i class="bi bi-arrow-right"></i>
                                </div>
                            </a>
                        </div>

                        <!-- Card 2: Online & Distance Degrees -->
                        <div class="col-lg-3 col-sm-6">
                            <a href="{{ route('colleges.online') }}" class="gp-404-nav-card">
                                <span class="gp-404-card-icon gp-icon-green">
                                    <i class="bi bi-laptop-fill"></i>
                                </span>
                                <div class="gp-404-card-heading">Online Universities</div>
                                <div class="gp-404-card-text">
                                    UGC-DEB approved flexible online degrees tailored for students and working professionals.
                                </div>
                                <div class="gp-404-card-link text-success">
                                    <span>View Online Degrees</span>
                                    <i class="bi bi-arrow-right"></i>
                                </div>
                            </a>
                        </div>

                        <!-- Card 3: Free Counseling -->
                        <div class="col-lg-3 col-sm-6">
                            <a href="#" class="gp-404-nav-card" data-bs-toggle="modal" data-bs-target="#counselingModal">
                                <span class="gp-404-card-icon gp-icon-gold">
                                    <i class="bi bi-headset"></i>
                                </span>
                                <div class="gp-404-card-heading">Free Counseling</div>
                                <div class="gp-404-card-text">
                                    Speak directly with certified admission experts to choose the right college and stream.
                                </div>
                                <div class="gp-404-card-link" style="color: #B78300;">
                                    <span>Talk to Expert</span>
                                    <i class="bi bi-chat-dots-fill"></i>
                                </div>
                            </a>
                        </div>

                        <!-- Card 4: Return Home -->
                        <div class="col-lg-3 col-sm-6">
                            <a href="{{ route('home') }}" class="gp-404-nav-card">
                                <span class="gp-404-card-icon gp-icon-purple">
                                    <i class="bi bi-house-door-fill"></i>
                                </span>
                                <div class="gp-404-card-heading">Homepage</div>
                                <div class="gp-404-card-text">
                                    Return to the GrowPEC portal to discover top colleges, live search, and latest updates.
                                </div>
                                <div class="gp-404-card-link" style="color: #553488;">
                                    <span>Go to Home</span>
                                    <i class="bi bi-arrow-right"></i>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Popular Academic Programs Tags -->
                    <div class="gp-404-tags">
                        <span class="gp-404-tags-label"><i class="bi bi-fire text-warning me-1"></i> Popular Courses:</span>
                        <a href="{{ route('colleges.regular') }}?courses[]=mba" class="gp-404-tag">MBA / PGDM</a>
                        <a href="{{ route('colleges.regular') }}?courses[]=btech" class="gp-404-tag">B.Tech Engineering</a>
                        <a href="{{ route('colleges.regular') }}?courses[]=bca" class="gp-404-tag">BCA / MCA</a>
                        <a href="{{ route('colleges.regular') }}?courses[]=bpharm" class="gp-404-tag">B.Pharm / D.Pharm</a>
                        <a href="{{ route('colleges.regular') }}?courses[]=bba" class="gp-404-tag">BBA / Management</a>
                        <a href="{{ route('colleges.regular') }}" class="gp-404-tag">All Programs &rarr;</a>
                    </div>

                    <!-- Urgent Guidance Call / WhatsApp Banner -->
                    <div class="gp-404-help-banner">
                        <div class="gp-404-help-info">
                            <h5><i class="bi bi-telephone-inbound-fill text-warning me-2"></i> Need Urgent Admission Assistance?</h5>
                            <p>Our dedicated education advisors are available to help you find the right seat &amp; fee structure.</p>
                        </div>
                        <div class="gp-404-help-actions">
                            <button type="button" class="gp-404-btn-gold" data-bs-toggle="modal" data-bs-target="#counselingModal">
                                <i class="bi bi-chat-square-text-fill"></i>
                                <span>Enquiry Now</span>
                            </button>
                            <a href="tel:{{ $siteSettings['general.support_phone'] ?? '+919876543210' }}" class="gp-404-btn-outline">
                                <i class="bi bi-telephone-fill"></i>
                                <span>{{ $siteSettings['general.support_phone'] ?? '+91 9876543210' }}</span>
                            </a>
                            @if(!empty($siteSettings['general.whatsapp_number']))
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['general.whatsapp_number']) }}?text=Hello%20GrowPEC,%20I%20need%20admission%20help." target="_blank" rel="noopener noreferrer" class="gp-404-btn-outline" style="background: rgba(37, 211, 102, 0.2); border-color: rgba(37, 211, 102, 0.4);">
                                    <i class="bi bi-whatsapp text-success"></i>
                                    <span>WhatsApp</span>
                                </a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
