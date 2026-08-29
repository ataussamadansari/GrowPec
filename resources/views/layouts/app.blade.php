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

        /* Top Bar */
        .top-notice-bar {
            background-color: var(--accent-gold);
            color: #000;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 6px 0;
            text-align: center;
        }

        /* Navbar */
        .main-navbar {
            background: #ffffff;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
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
        .nav-link:hover, .nav-link.active {
            color: var(--primary-purple) !important;
        }

        /* Buttons */
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
        .btn-purple:hover {
            background-color: var(--primary-dark);
            color: #fff;
        }

        /* Footer */
        footer {
            background-color: #0F0A2A;
            color: #9CA3AF;
            padding: 50px 0 20px;
            font-size: 0.9rem;
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
    </style>
    @stack('styles')
</head>
<body>

    <!-- Top Announcement Bar -->
    <div class="top-notice-bar">
        ⚡ Need Admission Guidance? Call our Expert Counselors: <a href="tel:+918858285271" class="text-dark fw-bold text-decoration-underline">+91 8858285271</a> | 100% Free Service
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
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-gold btn-sm" data-bs-toggle="modal" data-bs-target="#counselingModal">
                        <i class="bi bi-telephone-outbound-fill me-1"></i> Free Counselling
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- Global Lead Capture Modal (Popup) -->
    <div class="modal fade" id="counselingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header text-white" style="background: var(--primary-purple);">
                    <div>
                        <h5 class="modal-title fw-bold mb-0">🎯 Free College Counselling</h5>
                        <small class="text-white-50">Fill details & get guidance within 15 minutes</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="globalLeadForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Full Name *</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Mobile Number *</label>
                            <input type="tel" name="phone" class="form-control" placeholder="10-digit WhatsApp number" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="name@example.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Your City</label>
                            <input type="text" name="city" class="form-control" placeholder="e.g. Lucknow, Varanasi, Noida">
                        </div>
                        <div id="leadFormResponse"></div>
                        <button type="submit" id="leadSubmitBtn" class="btn btn-gold w-100 py-2 mt-2">
                            Request Callback Now 🚀
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
                        GrowPec is India's trusted college discovery and admission guidance platform. Helping students choose the right regular and online university programs.
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
                    <h6>Talk to an Expert</h6>
                    <p class="small text-secondary mb-3">Get 100% unbiased expert guidance for your career and college admissions.</p>
                    <button class="btn btn-outline-warning btn-sm w-100 py-2" data-bs-toggle="modal" data-bs-target="#counselingModal">
                        Book Free Consultation
                    </button>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <div class="text-center small text-secondary">
                © {{ date('Y') }} GrowPec. All rights reserved. Designed & Developed with Laravel.
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Global Lead Capture AJAX Script -->
    <script>
        document.getElementById('globalLeadForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const btn = document.getElementById('leadSubmitBtn');
            const respDiv = document.getElementById('leadFormResponse');
            
            btn.disabled = true;
            btn.innerText = 'Submitting...';

            const formData = new FormData(form);

            fetch("{{ route('lead.submit') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    "Accept": "application/json"
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                btn.innerText = 'Request Callback Now 🚀';
                respDiv.innerHTML = `<div class="alert alert-success py-2 small mt-2">${data.message}</div>`;
                form.reset();
                setTimeout(() => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('counselingModal'));
                    if (modal) modal.hide();
                    respDiv.innerHTML = '';
                }, 2500);
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerText = 'Request Callback Now 🚀';
                respDiv.innerHTML = `<div class="alert alert-danger py-2 small mt-2">Something went wrong. Please try again.</div>`;
            });
        });
    </script>
    @stack('scripts')
</body>
</html>