@extends('layouts.app')

@section('title', 'GrowPec - Your Career Deserves A Better College | Admission Guidance')

@push('styles')
<style>
    /* Hero Section */
    .hero-banner {
        background: linear-gradient(135deg, #1E1346 0%, #2E1E6B 50%, #4A2E9E 100%);
        color: #ffffff;
        padding: 70px 0 90px;
        position: relative;
        overflow: hidden;
    }
    .hero-badge {
        background: rgba(245, 166, 35, 0.15);
        color: var(--accent-gold);
        border: 1px solid var(--accent-gold);
        font-weight: 700;
        font-size: 0.85rem;
        padding: 6px 16px;
        border-radius: 30px;
        display: inline-block;
        margin-bottom: 20px;
    }
    .hero-search-box {
        background: #ffffff;
        border-radius: 16px;
        padding: 10px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .hero-search-input {
        border: none;
        padding: 12px 20px;
        font-size: 1rem;
        width: 100%;
        outline: none;
    }

    /* College Cards */
    .college-card {
        background: #ffffff;
        border: 1px solid #E5E7EB;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .college-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        border-color: var(--primary-purple);
    }
    .college-card-img {
        height: 180px;
        width: 100%;
        object-fit: cover;
        position: relative;
    }
    .college-tag {
        position: absolute;
        top: 12px;
        left: 12px;
        background: rgba(0,0,0,0.7);
        color: #fff;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 6px;
        backdrop-filter: blur(4px);
    }
    .college-rating-badge {
        position: absolute;
        bottom: 12px;
        right: 12px;
        background: #fff;
        color: #111;
        font-weight: 700;
        font-size: 0.8rem;
        padding: 4px 10px;
        border-radius: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }

    /* Features Section */
    .feature-box {
        background: #ffffff;
        border-radius: 14px;
        padding: 25px;
        border: 1px solid #F0EDFA;
        transition: all 0.3s ease;
    }
    .feature-box:hover {
        background: #FAF8FF;
        border-color: var(--primary-purple);
    }
    .feature-icon {
        width: 50px;
        height: 50px;
        background: #EDE9FE;
        color: var(--primary-purple);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 15px;
    }

    /* Program Badges */
    .program-card {
        background: #ffffff;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        padding: 16px;
        text-align: center;
        font-weight: 700;
        color: var(--primary-purple);
        transition: all 0.2s;
        text-decoration: none;
        display: block;
    }
    .program-card:hover {
        background: var(--primary-purple);
        color: #ffffff;
        border-color: var(--primary-purple);
    }
</style>
@endpush

@section('content')

<!-- 1. Hero Section -->
<section class="hero-banner">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-8 text-center text-lg-start">
                <span class="hero-badge">
                    <i class="bi bi-patch-check-fill me-1"></i> India's #1 College Discovery Portal
                </span>
                <h1 class="display-4 fw-extrabold mb-3">
                    Your Career Deserves A <span style="color: var(--accent-gold);">Better College</span>
                </h1>
                <p class="lead mb-4 text-white-50">
                    Compare verified fees, check NAAC & UGC approvals, get scholarship assistance, and connect with top counselors 100% free.
                </p>

                <!-- Search Bar -->
                <div class="hero-search-box mb-4">
                    <form action="{{ route('colleges.regular') }}" method="GET" class="d-flex flex-column flex-md-row gap-2">
                        <div class="d-flex align-items-center flex-grow-1 px-2">
                            <i class="bi bi-search text-muted fs-5 me-2"></i>
                            <input type="text" name="search" class="hero-search-input" placeholder="Search college name, course (e.g. BCA, MBA), or city...">
                        </div>
                        <button type="submit" class="btn btn-gold px-4 py-3">
                            Explore Colleges <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                    </form>
                </div>

                <!-- Stats Bar -->
                <div class="d-flex flex-wrap gap-4 justify-content-center justify-content-lg-start text-white">
                    <div><h5 class="fw-bold mb-0 text-warning">500+</h5><small class="text-white-50">Verified Colleges</small></div>
                    <div class="vr bg-secondary"></div>
                    <div><h5 class="fw-bold mb-0 text-warning">15,000+</h5><small class="text-white-50">Students Guided</small></div>
                    <div class="vr bg-secondary"></div>
                    <div><h5 class="fw-bold mb-0 text-warning">100%</h5><small class="text-white-50">Free Counselling</small></div>
                </div>
            </div>

            <!-- Hero Right Card -->
            <div class="col-lg-4 d-none d-lg-block">
                <div class="bg-white text-dark p-4 rounded-4 shadow-lg border-top border-warning border-4">
                    <h5 class="fw-bold mb-1" style="color: var(--primary-purple);">⚡ Quick Admission Enquiry</h5>
                    <p class="text-muted small mb-3">Get custom college options matching your budget</p>
                    <form action="{{ route('lead.submit') }}" method="POST" id="heroLeadForm">
                        @csrf
                        <input type="hidden" name="source" value="hero_banner">
                        <div class="mb-2">
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="Your Name" required>
                        </div>
                        <div class="mb-2">
                            <input type="tel" name="phone" class="form-control form-control-sm" placeholder="WhatsApp Number" required>
                        </div>
                        <div class="mb-2">
                            <select name="course_id" class="form-select form-select-sm">
                                <option value="">Select Interested Course</option>
                                @foreach($popularCourses as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->level }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="city" class="form-control form-control-sm" placeholder="Your City (e.g. Varanasi, Lucknow)">
                        </div>
                        <button type="submit" class="btn btn-gold btn-sm w-100 py-2">
                            Get Free Callback Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. Explore Popular Programs -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-4">
            <h3 class="fw-bold" style="color: var(--primary-purple);">Explore Top Programs</h3>
            <p class="text-muted small">Choose your desired degree and explore top institutes</p>
        </div>
        <div class="row row-cols-2 row-cols-md-4 g-3">
            @foreach($popularCourses as $course)
                <div class="col">
                    <a href="{{ route('colleges.regular') }}?course={{ $course->slug }}" class="program-card">
                        <i class="bi bi-mortarboard fs-4 d-block mb-1 text-warning"></i>
                        {{ $course->name }}
                        <div class="small text-muted fw-normal">{{ $course->level }} • {{ $course->duration }}</div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 3. Top Regular Colleges -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="badge bg-primary-subtle text-primary fw-bold mb-1">Campus Programs</span>
                <h3 class="fw-bold mb-0" style="color: var(--primary-purple);">Top Regular Colleges</h3>
            </div>
            <a href="{{ route('colleges.regular') }}" class="btn btn-outline-dark btn-sm fw-bold">
                View All Regular Colleges <i class="bi bi-chevron-right"></i>
            </a>
        </div>

        <div class="row g-4">
            @forelse($regularColleges as $college)
                <div class="col-lg-4 col-md-6">
                    <div class="college-card">
                        <div class="position-relative">
                            <img src="{{ $college->banner_image ?? 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=600&q=80' }}" class="college-card-img" alt="{{ $college->name }}">
                            <span class="college-tag">{{ $college->college_type }}</span>
                            <span class="college-rating-badge">
                                <i class="bi bi-star-fill text-warning me-1"></i>{{ $college->rating }}
                            </span>
                        </div>
                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <h5 class="fw-bold mb-1" style="color: var(--primary-purple);">{{ $college->name }}</h5>
                            <p class="text-muted small mb-2"><i class="bi bi-geo-alt me-1 text-danger"></i>{{ $college->city }}, {{ $college->state }}</p>
                            
                            @if($college->approvals)
                                <div class="small text-secondary mb-3">
                                    <span class="badge bg-light text-dark border"><i class="bi bi-shield-check text-success me-1"></i>{{ $college->approvals }}</span>
                                </div>
                            @endif

                            <div class="mt-auto pt-3 border-top d-flex gap-2">
                                <a href="{{ route('college.show', $college->slug) }}" class="btn btn-outline-primary btn-sm flex-grow-1 fw-bold">
                                    View Details
                                </a>
                                <button class="btn btn-gold btn-sm fw-bold px-3" data-bs-toggle="modal" data-bs-target="#counselingModal">
                                    Apply Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4">
                    <p class="text-muted">Colleges are being updated. Check back soon!</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- 4. Top Online & Distance Universities -->
<section class="py-5" style="background: #F1EFF8;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="badge bg-success-subtle text-success fw-bold mb-1">UGC-DEB Approved</span>
                <h3 class="fw-bold mb-0" style="color: var(--primary-purple);">Top Online Universities</h3>
            </div>
            <a href="{{ route('colleges.online') }}" class="btn btn-purple btn-sm fw-bold">
                View All Online Degrees <i class="bi bi-chevron-right"></i>
            </a>
        </div>

        <div class="row g-4">
            @forelse($onlineColleges as $college)
                <div class="col-lg-4 col-md-6">
                    <div class="college-card">
                        <div class="position-relative">
                            <img src="{{ $college->banner_image ?? 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=600&q=80' }}" class="college-card-img" alt="{{ $college->name }}">
                            <span class="college-tag bg-success">100% Online</span>
                            <span class="college-rating-badge">
                                <i class="bi bi-star-fill text-warning me-1"></i>{{ $college->rating }}
                            </span>
                        </div>
                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <h5 class="fw-bold mb-1" style="color: var(--primary-purple);">{{ $college->name }}</h5>
                            <p class="text-muted small mb-2"><i class="bi bi-laptop me-1 text-primary"></i>Online Live & Recorded Classes</p>

                            @if($college->approvals)
                                <div class="small text-secondary mb-3">
                                    <span class="badge bg-light text-dark border"><i class="bi bi-award text-warning me-1"></i>{{ $college->approvals }}</span>
                                </div>
                            @endif

                            <div class="mt-auto pt-3 border-top d-flex gap-2">
                                <a href="{{ route('college.show', $college->slug) }}" class="btn btn-outline-primary btn-sm flex-grow-1 fw-bold">
                                    View Details
                                </a>
                                <button class="btn btn-gold btn-sm fw-bold px-3" data-bs-toggle="modal" data-bs-target="#counselingModal">
                                    Free Counselling
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4">
                    <p class="text-muted">Online universities data coming soon.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- 5. Why Choose GrowPec -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center max-w-xl mx-auto mb-5">
            <span class="badge bg-warning-subtle text-dark fw-bold mb-2">Our Value Proposition</span>
            <h2 class="fw-bold" style="color: var(--primary-purple);">Why Choose GrowPec for Admission Guidance?</h2>
            <p class="text-secondary">We bridge the gap between students and the best colleges across India.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-box h-100">
                    <div class="feature-icon"><i class="bi bi-patch-check"></i></div>
                    <h5 class="fw-bold mb-2">100% Free Counselling</h5>
                    <p class="text-muted small mb-0">Our expert guidance and college matching services are completely free for students and parents.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box h-100">
                    <div class="feature-icon"><i class="bi bi-wallet2"></i></div>
                    <h5 class="fw-bold mb-2">Scholarships & Education Loans</h5>
                    <p class="text-muted small mb-0">Get access to merit scholarships, government fee waivers, and no-cost EMI loan approval assistance.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box h-100">
                    <div class="feature-icon"><i class="bi bi-shield-lock"></i></div>
                    <h5 class="fw-bold mb-2">UGC & AICTE Verified Data</h5>
                    <p class="text-muted small mb-0">We only list recognized and accredited universities with verified placement reports.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 6. Call To Action Banner -->
<section class="py-5 text-white text-center" style="background: linear-gradient(135deg, #2E1E6B 0%, #1E1346 100%);">
    <div class="container py-4">
        <h2 class="fw-bold mb-3">Still Confused About Which College is Best for You?</h2>
        <p class="text-white-50 max-w-lg mx-auto mb-4">
            Speak directly with our senior admission counselors. Get personalized guidance on fees, placements, and eligibility.
        </p>
        <button class="btn btn-gold btn-lg px-5 py-3 shadow" data-bs-toggle="modal" data-bs-target="#counselingModal">
            <i class="bi bi-telephone-fill me-2"></i> Talk To A College Expert Now
        </button>
    </div>
</section>

@endsection