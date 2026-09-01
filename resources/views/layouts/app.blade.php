<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GrowPec - Discover Top Colleges & Online Degrees in India')</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/growpec.png') }}">

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-purple: #2E1E6B;
            --primary-dark: #1E1346;
            --accent-gold: #F5A623;
            --accent-gold-hover: #E09612;
            --bg-light: #F8F9FC;
            --text-dark: #1F2937;
            --text-muted: #6B7280;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
        }

        .top-notice-bar {
            background-color: var(--accent-gold);
            color: #000;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 6px 0;
            text-align: center;
        }

        /* Navbar & Logo */
        .main-navbar {
            background: #ffffff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            padding: 10px 0;
        }

        .navbar-brand {
            padding: 0;
            display: inline-flex;
            align-items: center;
        }

        .navbar-logo-img {
            height: 46px;
            max-width: 210px;
            object-fit: contain;
            transition: transform 0.2s ease;
        }

        /* Header Search Bar */
        .header-search-wrap {
            position: relative;
            min-width: 260px;
            max-width: 320px;
            width: 100%;
        }

        .header-search-input {
            border-radius: 25px !important;
            border: 1px solid #CBD5E1 !important;
            padding: 7px 16px 7px 36px !important;
            font-size: 0.85rem !important;
            background-color: #F8FAFC !important;
            color: #1E293B !important;
        }

        .header-search-input:focus {
            background-color: #ffffff !important;
            border-color: var(--primary-purple) !important;
            box-shadow: 0 0 0 3px rgba(46, 30, 107, 0.12) !important;
        }

        .header-search-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
            font-size: 0.9rem;
            pointer-events: none;
            z-index: 5;
        }

        .live-search-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
            z-index: 1050;
            max-height: 350px;
            overflow-y: auto;
            margin-top: 6px;
        }

        .live-search-item {
            padding: 9px 12px;
            display: block;
            text-decoration: none;
            color: #1E293B;
            border-bottom: 1px solid #F1F5F9;
        }

        .live-search-item:hover {
            background: #FAF8FF;
        }

        @media (max-width: 991.98px) {
            .header-search-wrap {
                min-width: 100%;
                max-width: 100%;
            }
        }

        .nav-link {
            font-weight: 600;
            color: #374151 !important;
            margin: 0 8px;
            transition: color 0.2s;
            font-size: 0.92rem;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-purple) !important;
        }

        .btn-gold {
            background-color: var(--accent-gold);
            color: #000;
            font-weight: 700;
            border-radius: 8px;
            padding: 8px 18px;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-gold:hover {
            background-color: var(--accent-gold-hover);
            color: #000;
            transform: translateY(-1px);
        }

        /* Footer & Logo */
        footer {
            background-color: #0F0A2A;
            color: #9CA3AF;
            padding: 50px 0 20px;
            font-size: 0.9rem;
        }

        .footer-logo-img {
            height: 52px;
            max-width: 220px;
            object-fit: contain;
            background: #ffffff;
            padding: 6px 12px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        footer a {
            color: #D1D5DB;
            text-decoration: none;
            transition: color 0.2s;
        }

        footer a:hover {
            color: var(--accent-gold);
        }

        footer h6 {
            color: #fff;
            font-weight: 700;
            margin-bottom: 20px;
        }

        @media (max-width: 991.98px) {
            .header-search-wrap {
                max-width: 100%;
                margin: 10px 0;
            }

            .navbar-logo-img {
                height: 38px;
                max-width: 160px;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Top Announcement Bar -->
    <div class="top-notice-bar">
        Need Admission Guidance? Call our Expert Counselors: <a href="tel:+918858285271" class="text-dark fw-bold text-decoration-underline">+91 8858285271</a> | 100% Verified Information
    </div>

    <!-- Main Navigation Header -->
    <nav class="navbar navbar-expand-lg main-navbar sticky-top">
        <div class="container">

            <!-- 1. Header Logo -->
            <a class="navbar-brand me-3" href="{{ route('home') }}">
                <img src="{{ asset('assets/growpec.png') }}" alt="GrowPEC Logo" class="navbar-logo-img">
            </a>

            <!-- Mobile Toggler Button (Mobile view ke liye zaroori) -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- 2. Navigation Links, Search & User Area -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('colleges.regular') ? 'active' : '' }}" href="{{ route('colleges.regular') }}">Regular Colleges</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('colleges.online') ? 'active' : '' }}" href="{{ route('colleges.online') }}">Online Colleges</a>
                    </li>

                    <!-- 3. 🔍 Header Search Bar -->
                    <li class="nav-item my-2 my-lg-0">
                        <div class="header-search-wrap mx-lg-2">
                            <i class="bi bi-search header-search-icon"></i>
                            <form action="{{ route('colleges.regular') }}" method="GET" id="headerSearchForm" class="m-0">
                                <input type="text"
                                    name="search"
                                    id="headerSearchInput"
                                    class="form-control header-search-input"
                                    placeholder="Search colleges, courses, city..."
                                    autocomplete="off"
                                    value="{{ request('search') }}">
                            </form>

                            <!-- Live Auto-Suggest Results Dropdown -->
                            <div id="headerSearchResults" class="live-search-dropdown d-none"></div>
                        </div>
                    </li>
                </ul>

                <!-- 4. User Profile / Auth Area -->
                <div class="d-flex align-items-center gap-2 mt-2 mt-lg-0">
                    @auth
                    <div class="dropdown">
                        <button class="btn btn-white btn-sm rounded-3 fw-semibold px-3 py-2 dropdown-toggle d-flex align-items-center gap-2 shadow-sm"
                            type="button"
                            id="studentDropdownBtn"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            style="background: #ffffff; border: 1px solid #CBD5E1; color: #1E293B;">
                            <i class="bi bi-person-circle fs-5" style="color: #1E293B;"></i>
                            <span>Hi, {{ explode(' ', Auth::user()->name)[0] }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-2 mt-2"
                            aria-labelledby="studentDropdownBtn"
                            style="border-radius: 12px; min-width: 190px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;">
                            @if(in_array(Auth::user()->role, ['super_admin', 'sub_admin']))
                            <li>
                                <a class="dropdown-item py-2 px-3 fw-semibold text-primary d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2 fs-6"></i>
                                    <span>Admin Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider my-1">
                            </li>
                            @endif
                            <li>
                                <a class="dropdown-item py-2 px-3 fw-semibold d-flex align-items-center gap-2"
                                    href="{{ route('student.profile') }}"
                                    style="color: #2E1E6B;">
                                    <i class="bi bi-person-fill fs-5" style="color: #2E1E6B;"></i>
                                    <span>User Profile</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider my-1" style="border-color: #F1EFF8;">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 px-3 fw-semibold d-flex align-items-center gap-2" style="color: #2E1E6B;">
                                        <i class="bi bi-box-arrow-left fs-5" style="color: #2E1E6B;"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @else
                    <!-- Guest: Sign In Button -->
                    <button class="btn btn-gold btn-sm fw-bold px-3 py-2 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#studentAuthModal">
                        <i class="bi bi-person-fill me-1"></i> Sign In / Register
                    </button>
                    @endauth
                </div>

            </div>
        </div>
    </nav>

    <!-- Main Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- 1. Phone + OTP Auth Modal -->
    <div class="modal fade" id="studentAuthModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" style="max-width: 380px;">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                <div class="modal-header text-white" style="background: var(--primary-purple);">
                    <div>
                        <h6 class="modal-title fw-bold mb-0">Student Sign In / Register</h6>
                        <small class="text-white-50" style="font-size: 0.75rem;">Fast OTP verification without password</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- STEP 1: Enter Name & Phone -->
                    <div id="otpStep1">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Your Name</label>
                            <input type="text" id="authUserName" class="form-control form-control-sm" placeholder="Enter your full name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Mobile Number *</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light fw-bold">+91</span>
                                <input type="tel" id="authUserPhone" class="form-control" placeholder="10-digit mobile number" maxlength="10" required>
                            </div>
                        </div>
                        <div id="otpSendMsg"></div>
                        <button type="button" id="sendOtpBtn" class="btn btn-gold btn-sm w-100 py-2 fw-bold mt-1 shadow-sm">
                            Get OTP <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                    </div>

                    <!-- STEP 2: Enter 4-digit OTP -->
                    <div id="otpStep2" style="display: none;">
                        <div class="text-center mb-3">
                            <div class="mb-2">
                                <span class="badge bg-warning-subtle text-dark border px-3 py-2 fw-bold">Demo OTP: 1234</span>
                            </div>
                            <h6 class="fw-bold mb-1 text-dark">Enter 4-Digit Code</h6>
                            <small class="text-muted">Code sent to +91 <strong id="displayPhone"></strong></small>
                        </div>
                        <div class="mb-3">
                            <input type="text" id="otpInput" class="form-control text-center fw-extrabold fs-3"
                                placeholder="• • • •" maxlength="4" style="letter-spacing: 12px;">
                        </div>
                        <div id="otpVerifyMsg"></div>
                        <button type="button" id="verifyOtpBtn" class="btn btn-purple btn-sm w-100 py-2 fw-bold mb-2 shadow-sm">
                            Verify & Continue <i class="bi bi-check-circle ms-1"></i>
                        </button>
                        <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top small">
                            <button type="button" id="resendOtpBtn" class="btn btn-link btn-sm p-0 text-decoration-none text-muted" disabled>
                                Resend in <span id="timerCount">30</span>s
                            </button>
                            <button type="button" id="backToStep1Btn" class="btn btn-link btn-sm p-0 text-decoration-none text-primary fw-semibold">
                                Edit Number
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Global Enquiry Modal -->
    <div class="modal fade" id="counselingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header text-white" style="background: var(--primary-purple);">
                    <div>
                        <h5 class="modal-title fw-bold mb-0">Admission Guidance Enquiry</h5>
                        <small class="text-white-50">Direct connection with certified university experts</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="globalLeadForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Full Name *</label>
                            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name ?? '' }}" placeholder="Your name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Mobile Number *</label>
                            <input type="tel" name="phone" class="form-control" value="{{ Auth::user()->phone ?? '' }}" placeholder="WhatsApp number" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ str_ends_with(Auth::user()->email ?? '', '@growpec.local') ? '' : (Auth::user()->email ?? '') }}" placeholder="name@example.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Your City *</label>
                            <input type="text" name="city" class="form-control" placeholder="e.g. Varanasi, Lucknow, Delhi" required>
                        </div>
                        <div id="leadFormResponse"></div>
                        <button type="submit" id="leadSubmitBtn" class="btn btn-gold w-100 py-2 mt-2 fw-bold">
                            Submit Application Enquiry
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-4 col-md-6">
                    <div class="mb-3">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('assets/growpec.png') }}" alt="GrowPEC Logo" class="footer-logo-img">
                        </a>
                    </div>
                    <p class="small text-secondary mb-3">
                        <strong>Grow Pinnacle Education Consulting Pvt. Ltd.</strong> — India's trusted college discovery and admission guidance platform.
                    </p>
                    <p class="small mb-1"><i class="bi bi-geo-alt text-warning me-2"></i>Varanasi, Uttar Pradesh, India</p>
                    <p class="small mb-1"><i class="bi bi-telephone text-warning me-2"></i>+91 8858285271</p>
                    <p class="small"><i class="bi bi-envelope text-warning me-2"></i>info@growpec.com</p>
                </div>

                <div class="col-lg-2 col-md-6 col-6">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('colleges.regular') }}">Regular Colleges</a></li>
                        <li class="mb-2"><a href="{{ route('colleges.online') }}">Online Colleges</a></li>
                        <li class="mb-2"><a href="{{ route('about') }}">About Us</a></li>
                        <li class="mb-2"><a href="{{ route('contact') }}">Contact Support</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 col-6">
                    <h6>Top Programs</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('colleges.regular') }}?courses[]=mba">MBA / PGDM</a></li>
                        <li class="mb-2"><a href="{{ route('colleges.regular') }}?courses[]=btech">B.Tech Engineering</a></li>
                        <li class="mb-2"><a href="{{ route('colleges.regular') }}?courses[]=bca">BCA / MCA</a></li>
                        <li class="mb-2"><a href="{{ route('colleges.regular') }}?courses[]=bpharm">B.Pharm / D.Pharm</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6>Support</h6>
                    <p class="small text-secondary mb-3">Get 100% unbiased expert guidance for your career and college admissions.</p>
                </div>
            </div>

            <hr class="border-secondary my-4">
            <div class="text-center small text-secondary">
                © {{ date('Y') }} GrowPEC. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- 🔍 Live Header Search Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('headerSearchInput');
            const resultsBox = document.getElementById('headerSearchResults');
            let debounceTimer;

            if (searchInput && resultsBox) {
                searchInput.addEventListener('input', function() {
                    const query = this.value.trim();
                    clearTimeout(debounceTimer);

                    if (query.length < 2) {
                        resultsBox.classList.add('d-none');
                        resultsBox.innerHTML = '';
                        return;
                    }

                    debounceTimer = setTimeout(() => {
                        fetch(`{{ route('api.liveSearch') }}?q=${encodeURIComponent(query)}`)
                            .then(res => res.json())
                            .then(data => {
                                let html = '';
                                const colleges = data.colleges || [];
                                const courses = data.courses || [];

                                if (colleges.length === 0 && courses.length === 0) {
                                    html = `<div class="p-3 text-muted text-center small"><i class="bi bi-search me-1"></i> No matching colleges or courses.</div>`;
                                } else {
                                    if (colleges.length > 0) {
                                        html += `<div class="px-3 py-1 bg-light small fw-bold text-uppercase text-muted" style="font-size: 0.72rem; letter-spacing: 0.5px;">Colleges</div>`;
                                        colleges.forEach(col => {
                                            const collegeUrl = `{{ url('/college') }}/${col.slug}`;
                                            html += `
                                            <a href="${collegeUrl}" class="live-search-item d-flex align-items-center justify-content-between">
                                                <div>
                                                    <div class="fw-semibold text-dark small mb-0">${col.name}</div>
                                                    <small class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-geo-alt me-1 text-danger"></i>${col.city}</small>
                                                </div>
                                                <span class="badge bg-primary-subtle text-primary small">${col.college_mode.toUpperCase()}</span>
                                            </a>
                                        `;
                                        });
                                    }

                                    if (courses.length > 0) {
                                        html += `<div class="px-3 py-1 bg-light small fw-bold text-uppercase text-muted mt-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">Programs / Courses</div>`;
                                        courses.forEach(c => {
                                            const courseUrl = `{{ route('colleges.regular') }}?courses[]=${c.slug}`;
                                            html += `
                                            <a href="${courseUrl}" class="live-search-item d-flex align-items-center justify-content-between">
                                                <div class="small fw-semibold text-dark"><i class="bi bi-mortarboard text-warning me-2"></i>${c.name}</div>
                                                <span class="badge bg-light text-dark border small">${c.level}</span>
                                            </a>
                                        `;
                                        });
                                    }

                                    html += `
                                    <div class="p-2 border-top text-center bg-light">
                                        <a href="{{ route('colleges.regular') }}?search=${encodeURIComponent(query)}" class="small fw-bold text-primary text-decoration-none">
                                            View all results for "${query}" <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                `;
                                }

                                resultsBox.innerHTML = html;
                                resultsBox.classList.remove('d-none');
                            })
                            .catch(() => {
                                resultsBox.classList.add('d-none');
                            });
                    }, 220);
                });

                // Close dropdown on outside click
                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !resultsBox.contains(e.target)) {
                        resultsBox.classList.add('d-none');
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>