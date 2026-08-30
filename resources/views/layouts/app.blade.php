<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GrowPec - Discover Top Colleges & Online Degrees in India')</title>

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

        .main-navbar {
            background: #ffffff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            padding: 12px 0;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--primary-purple) !important;
        }

        .navbar-brand span {
            color: var(--accent-gold);
        }

        .nav-link {
            font-weight: 600;
            color: #374151 !important;
            margin: 0 10px;
            transition: color 0.2s;
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
            padding: 8px 20px;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-gold:hover {
            background-color: var(--accent-gold-hover);
            color: #000;
            transform: translateY(-1px);
        }

        .btn-purple {
            background-color: var(--primary-purple);
            color: #fff;
            font-weight: 600;
            border-radius: 8px;
            padding: 8px 20px;
            border: none;
        }

        footer {
            background-color: #0F0A2A;
            color: #9CA3AF;
            padding: 50px 0 20px;
            font-size: 0.9rem;
        }

        footer a {
            color: #D1D5DB;
            text-decoration: none;
        }

        footer h6 {
            color: #fff;
            font-weight: 700;
            margin-bottom: 20px;
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Top Announcement Bar -->
    <div class="top-notice-bar">
        Need Admission Guidance? Call our Expert Counselors: <a href="tel:+918858285271" class="text-dark fw-bold text-decoration-underline">+91 8858285271</a> | 100% Verified Information
    </div>

    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg main-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-mortarboard-fill text-warning me-1"></i>Grow<span>Pec</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('colleges.regular') ? 'active' : '' }}" href="{{ route('colleges.regular') }}">Regular Colleges</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('colleges.online') ? 'active' : '' }}" href="{{ route('colleges.online') }}">Online Colleges</a>
                    </li>
                </ul>

                <!-- User Auth Area in Navbar (Dropdown Menu matching screenshot) -->
                <div class="d-flex align-items-center gap-2">
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

                            <!-- 1. User Profile Link -->
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

                            <!-- 2. Logout Action -->
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
                                placeholder="••••" maxlength="4" style="letter-spacing: 12px;">
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

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let timerInterval = null;

            function startResendTimer() {
                let count = 30;
                const timerSpan = document.getElementById('timerCount');
                const resendBtn = document.getElementById('resendOtpBtn');
                resendBtn.disabled = true;
                resendBtn.innerHTML = `Resend in <span id="timerCount">${count}</span>s`;

                clearInterval(timerInterval);
                timerInterval = setInterval(() => {
                    count--;
                    if (count <= 0) {
                        clearInterval(timerInterval);
                        resendBtn.disabled = false;
                        resendBtn.innerText = 'Resend OTP';
                    } else {
                        const currentSpan = document.getElementById('timerCount');
                        if (currentSpan) currentSpan.innerText = count;
                    }
                }, 1000);
            }

            // 1. Send OTP
            const sendOtpAction = function() {
                const phone = document.getElementById('authUserPhone').value.trim();
                const name = document.getElementById('authUserName').value.trim();
                const msgDiv = document.getElementById('otpSendMsg');
                const btn = document.getElementById('sendOtpBtn');

                if (!phone || phone.length !== 10 || !/^[6-9]\d{9}$/.test(phone)) {
                    msgDiv.innerHTML = '<div class="alert alert-danger py-1 small">Please enter a valid 10-digit mobile number.</div>';
                    return;
                }

                btn.disabled = true;
                btn.innerText = 'Sending...';

                fetch("{{ route('api.auth.sendOtp') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            "Accept": "application/json"
                        },
                        body: JSON.stringify({
                            phone: phone,
                            name: name
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        btn.disabled = false;
                        btn.innerText = 'Get OTP';
                        if (data.status === 'success') {
                            document.getElementById('displayPhone').innerText = phone;
                            document.getElementById('otpStep1').style.display = 'none';
                            document.getElementById('otpStep2').style.display = 'block';
                            document.getElementById('otpInput').value = '1234'; // Pre-filled for demo ease
                            document.getElementById('otpInput').focus();
                            startResendTimer();
                        } else {
                            msgDiv.innerHTML = `<div class="alert alert-danger py-1 small">${data.message}</div>`;
                        }
                    })
                    .catch(() => {
                        btn.disabled = false;
                        btn.innerText = 'Get OTP';
                        msgDiv.innerHTML = '<div class="alert alert-danger py-1 small">Failed to send OTP. Try again.</div>';
                    });
            };

            document.getElementById('sendOtpBtn')?.addEventListener('click', sendOtpAction);
            document.getElementById('resendOtpBtn')?.addEventListener('click', sendOtpAction);

            // 2. Verify OTP
            const verifyOtpAction = function() {
                const otp = document.getElementById('otpInput').value.trim();
                const phone = document.getElementById('authUserPhone').value.trim();
                const name = document.getElementById('authUserName').value.trim();
                const msgDiv = document.getElementById('otpVerifyMsg');
                const btn = document.getElementById('verifyOtpBtn');

                if (!otp || otp.length !== 4) {
                    msgDiv.innerHTML = '<div class="alert alert-danger py-1 small">Please enter the 4-digit code (1234).</div>';
                    return;
                }

                btn.disabled = true;
                btn.innerText = 'Verifying...';

                fetch("{{ route('api.auth.verifyOtp') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            "Accept": "application/json"
                        },
                        body: JSON.stringify({
                            otp: otp,
                            phone: phone,
                            name: name
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        btn.disabled = false;
                        btn.innerText = 'Verify & Continue';
                        if (data.status === 'success') {
                            msgDiv.innerHTML = `<div class="alert alert-success py-1 small">${data.message}</div>`;
                            setTimeout(() => {
                                window.location.reload();
                            }, 600);
                        } else {
                            msgDiv.innerHTML = `<div class="alert alert-danger py-1 small">${data.message}</div>`;
                        }
                    })
                    .catch(() => {
                        btn.disabled = false;
                        btn.innerText = 'Verify & Continue';
                        msgDiv.innerHTML = '<div class="alert alert-danger py-1 small">Verification failed. Try again.</div>';
                    });
            };

            document.getElementById('verifyOtpBtn')?.addEventListener('click', verifyOtpAction);

            // Press Enter to submit in OTP field
            document.getElementById('otpInput')?.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') verifyOtpAction();
            });

            document.getElementById('backToStep1Btn')?.addEventListener('click', function() {
                document.getElementById('otpStep2').style.display = 'none';
                document.getElementById('otpStep1').style.display = 'block';
            });
        });
    </script>
    @endpush

    <!-- 2. Global Enquiry Modal (Only for Authenticated Users) -->
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
                    <h5 class="text-white fw-bold mb-3">Grow<span class="text-warning">Pec</span></h5>
                    <p class="small text-secondary">
                        India's trusted college discovery and admission guidance platform.
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
                        <li class="mb-2"><a href="{{ route('colleges.regular') }}?course=mba">MBA / PGDM</a></li>
                        <li class="mb-2"><a href="{{ route('colleges.regular') }}?course=btech">B.Tech Engineering</a></li>
                        <li class="mb-2"><a href="{{ route('colleges.regular') }}?course=bca">BCA / MCA</a></li>
                        <li class="mb-2"><a href="{{ route('colleges.regular') }}?course=bpharm">B.Pharm / D.Pharm</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6>Support</h6>
                    <p class="small text-secondary mb-3">Get 100% unbiased expert guidance for your career and college admissions.</p>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <div class="text-center small text-secondary">
                © {{ date('Y') }} GrowPec. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Global Auth State & OTP Handling -->
    <script>
        window.isLoggedIn = {
            {
                Auth::check() ? 'true' : 'false'
            }
        };
        window.currentUser = @json(Auth::user());

        // Global Helper: Open Enquiry Modal or Trigger Login first
        window.openEnquiryModal = function(city = '') {
            if (!window.isLoggedIn) {
                const authModal = new bootstrap.Modal(document.getElementById('studentAuthModal'));
                authModal.show();
                return;
            }
            if (city) {
                const cityInput = document.querySelector('#counselingModal input[name=city]');
                if (cityInput) cityInput.value = city;
            }
            const modal = new bootstrap.Modal(document.getElementById('counselingModal'));
            modal.show();
        };

        // 1. Send OTP Request
        document.getElementById('sendOtpBtn')?.addEventListener('click', function() {
            const phone = document.getElementById('authUserPhone').value.trim();
            const name = document.getElementById('authUserName').value.trim();
            const msgDiv = document.getElementById('otpSendMsg');
            const btn = this;

            if (!phone || phone.length !== 10) {
                msgDiv.innerHTML = '<div class="alert alert-danger py-1 small">Please enter a valid 10-digit number.</div>';
                return;
            }

            btn.disabled = true;
            btn.innerText = 'Sending OTP...';

            fetch("{{ route('api.auth.sendOtp') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        phone: phone,
                        name: name
                    })
                })
                .then(res => res.json())
                .then(data => {
                    btn.disabled = false;
                    btn.innerText = 'Send OTP';
                    if (data.status === 'success') {
                        document.getElementById('displayPhone').innerText = phone;
                        document.getElementById('otpStep1').style.display = 'none';
                        document.getElementById('otpStep2').style.display = 'block';
                        document.getElementById('otpInput').value = '1234';
                    } else {
                        msgDiv.innerHTML = `<div class="alert alert-danger py-1 small">${data.message}</div>`;
                    }
                })
                .catch(() => {
                    btn.disabled = false;
                    btn.innerText = 'Send OTP';
                    msgDiv.innerHTML = '<div class="alert alert-danger py-1 small">Failed to send OTP. Try again.</div>';
                });
        });

        // 2. Verify OTP
        document.getElementById('verifyOtpBtn')?.addEventListener('click', function() {
            const otp = document.getElementById('otpInput').value.trim();
            const phone = document.getElementById('authUserPhone').value.trim();
            const name = document.getElementById('authUserName').value.trim();
            const msgDiv = document.getElementById('otpVerifyMsg');
            const btn = this;

            if (!otp || otp.length !== 4) {
                msgDiv.innerHTML = '<div class="alert alert-danger py-1 small">Please enter 4-digit OTP.</div>';
                return;
            }

            btn.disabled = true;
            btn.innerText = 'Verifying...';

            fetch("{{ route('api.auth.verifyOtp') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        otp: otp,
                        phone: phone,
                        name: name
                    })
                })
                .then(res => res.json())
                .then(data => {
                    btn.disabled = false;
                    btn.innerText = 'Verify & Continue';
                    if (data.status === 'success') {
                        msgDiv.innerHTML = `<div class="alert alert-success py-1 small">${data.message}</div>`;
                        setTimeout(() => {
                            window.location.reload();
                        }, 800);
                    } else {
                        msgDiv.innerHTML = `<div class="alert alert-danger py-1 small">${data.message}</div>`;
                    }
                })
                .catch(() => {
                    btn.disabled = false;
                    btn.innerText = 'Verify & Continue';
                    msgDiv.innerHTML = '<div class="alert alert-danger py-1 small">Verification failed.</div>';
                });
        });

        document.getElementById('backToStep1Btn')?.addEventListener('click', function() {
            document.getElementById('otpStep2').style.display = 'none';
            document.getElementById('otpStep1').style.display = 'block';
        });

        // 3. Global Lead Form Submission
        document.getElementById('globalLeadForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const btn = document.getElementById('leadSubmitBtn');
            const respDiv = document.getElementById('leadFormResponse');

            btn.disabled = true;
            btn.innerText = 'Submitting...';

            fetch("{{ route('lead.submit') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        "Accept": "application/json"
                    },
                    body: new FormData(form)
                })
                .then(res => res.json())
                .then(data => {
                    btn.disabled = false;
                    btn.innerText = 'Submit Application Enquiry';
                    if (data.status === 'success') {
                        respDiv.innerHTML = `<div class="alert alert-success py-2 small mt-2">${data.message}</div>`;
                        form.reset();
                        setTimeout(() => {
                            const modal = bootstrap.Modal.getInstance(document.getElementById('counselingModal'));
                            if (modal) modal.hide();
                            respDiv.innerHTML = '';
                        }, 2500);
                    } else if (data.require_auth) {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('counselingModal'));
                        if (modal) modal.hide();
                        const authModal = new bootstrap.Modal(document.getElementById('studentAuthModal'));
                        authModal.show();
                    }
                })
                .catch(() => {
                    btn.disabled = false;
                    btn.innerText = 'Submit Application Enquiry';
                    respDiv.innerHTML = `<div class="alert alert-danger py-2 small mt-2">Error submitting form. Try again.</div>`;
                });
        });
    </script>
    @stack('scripts')
</body>

</html>