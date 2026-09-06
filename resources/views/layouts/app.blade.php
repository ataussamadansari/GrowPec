<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', ($siteSettings['general.site_name'] ?? 'GrowPEC') . ' - ' . ($siteSettings['general.site_tagline'] ?? 'Admission Guidance'))</title>
    <meta name="description" content="{{ $siteSettings['general.site_description'] ?? 'Compare verified college fees, check UGC & AICTE approvals, scholarships, and connect with top counselors.' }}">

    @if(!empty($siteSettings['general.favicon']))
    <link rel="icon" type="image/png" href="{{ asset($siteSettings['general.favicon']) }}">
    @else
    <link rel="icon" type="image/png" href="{{ asset('assets/growpec.png') }}">
    @endif

    <!-- Icons & Assets -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @php
        $primaryBg     = $siteSettings['theme.primary_color'] ?? '#2E1E6B';
        $secondaryBg   = $siteSettings['theme.secondary_purple'] ?? '#4E3797';
        $accentBg      = $siteSettings['theme.accent_gold'] ?? '#F5A623';
        $topbarBg      = $siteSettings['theme.topbar_color'] ?? '#F5A623';
        $bodyBg        = $siteSettings['theme.body_bg'] ?? '#F8F9FC';
    @endphp

    <style>
        :root {
            --primary-purple: #2E1E6B;
            --secondary-purple: #4E3797;
            --accent-gold: #F5A623;
            --topbar-bg: #F5A623;
            --bg-light: #F8F9FC;
        }
        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--bg-light);
            color: #1F2937;
        }
        a {
            text-decoration: none;
            color: inherit;
        }
    </style>

    @if(!empty($siteSettings['api.google_analytics_id']))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $siteSettings['api.google_analytics_id'] }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){ dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', @json($siteSettings['api.google_analytics_id']));
    </script>
    @endif

    @stack('styles')
</head>
<body class="min-h-screen flex flex-col">

    <!-- Maintenance Alert -->
    @if(($siteSettings['features.maintenance_mode'] ?? '0') == '1' && Auth::check() && in_array(Auth::user()->role, ['super_admin', 'sub_admin']))
    <div class="sticky top-0 z-50 w-full bg-red-600 text-white py-2 px-4 text-center font-bold text-sm">
        <i class="bi bi-exclamation-triangle-fill mr-2"></i>
        MAINTENANCE MODE IS ACTIVE! Public visitors see the maintenance screen.
        <a href="{{ route('admin.settings.index') }}" class="text-white underline ml-2">Turn Off in Settings</a>
    </div>
    @endif

    <!-- Top Notice Bar -->
    <div class="w-full bg-amber-400 text-gray-950 py-1.5 px-4 text-center text-xs sm:text-sm font-semibold fixed top-0 z-50 left-0 right-0">
        Need Admission Guidance? Call our Expert Counselors:
        <a href="tel:{{ $siteSettings['general.support_phone'] ?? '+918858285271' }}" class="font-bold underline ml-1">
            {{ $siteSettings['general.support_phone'] ?? '+91 8858285271' }}
        </a>
        <span class="ml-2 hidden sm:inline">| 100% Verified Information</span>
    </div>

    <!-- Main Navigation Header -->
    <nav class="fixed top-7 left-0 right-0 z-40 w-full bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex-shrink-0">
                    <img src="{{ asset($siteSettings['general.logo'] ?? 'assets/growpec.png') }}" alt="{{ $siteSettings['general.site_name'] ?? 'GrowPEC' }}" class="h-11 w-auto object-contain">
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center gap-6 lg:gap-8 flex-1 ml-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-purple-900 font-semibold text-sm transition {{ request()->routeIs('home') ? 'text-purple-900 font-bold' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('colleges.regular') }}" class="text-gray-700 hover:text-purple-900 font-semibold text-sm transition {{ request()->routeIs('colleges.regular') ? 'text-purple-900 font-bold' : '' }}">
                        Regular Colleges
                    </a>
                    @if(($siteSettings['features.enable_online_colleges'] ?? '1') == '1')
                    <a href="{{ route('colleges.online') }}" class="text-gray-700 hover:text-purple-900 font-semibold text-sm transition {{ request()->routeIs('colleges.online') ? 'text-purple-900 font-bold' : '' }}">
                        Online Colleges
                    </a>
                    @endif

                    <!-- Search Bar -->
                    <div class="relative flex-1 max-w-xs">
                        <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm z-10"></i>
                        <form action="{{ route('colleges.regular') }}" method="GET" id="headerSearchForm" class="w-full">
                            <input type="text" name="search" id="headerSearchInput" class="w-full pl-9 pr-4 py-2 text-sm border border-gray-300 rounded-full bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:bg-white transition" placeholder="Search colleges, courses..." value="{{ request('search') }}" autocomplete="off">
                        </form>
                        <div id="headerSearchResults" class="absolute top-full left-0 right-0 bg-white border border-gray-200 rounded-xl shadow-xl mt-1 max-h-96 overflow-y-auto hidden z-50"></div>
                    </div>
                </div>

                <!-- User Profile / Auth Area -->
                <div class="flex items-center gap-4">
                    @auth
                    <div class="relative group">
                        <button class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-gray-900 bg-white border border-gray-300 rounded-full hover:bg-gray-50 transition">
                            <i class="bi bi-person-circle text-lg text-purple-900"></i>
                            <span class="hidden sm:inline">Hi, {{ explode(' ', Auth::user()->name)[0] }}</span>
                        </button>
                        <div class="absolute right-0 mt-1 w-48 bg-white border border-gray-200 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-150 z-50 py-1">
                            @if(in_array(Auth::user()->role, ['super_admin', 'sub_admin']))
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-purple-900 font-semibold hover:bg-purple-50">
                                <i class="bi bi-speedometer2"></i> Admin Dashboard
                            </a>
                            <hr class="my-1 border-gray-100">
                            @endif
                            <a href="{{ route('student.profile') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-800 font-semibold hover:bg-purple-50">
                                <i class="bi bi-person-badge"></i> User Profile
                            </a>
                            <hr class="my-1 border-gray-100">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 flex items-center gap-2">
                                    <i class="bi bi-box-arrow-left"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden ml-4 p-2 text-gray-700 hover:bg-gray-100 rounded-lg" id="mobileMenuBtn" aria-label="Toggle navigation">
                    <i class="bi bi-list text-2xl"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div class="md:hidden hidden pb-4 border-t border-gray-200 mt-2 space-y-1" id="mobileMenu">
                <a href="{{ route('home') }}" class="block px-4 py-2.5 rounded-lg text-gray-700 hover:bg-purple-50 hover:text-purple-900 font-semibold text-sm">Home</a>
                <a href="{{ route('colleges.regular') }}" class="block px-4 py-2.5 rounded-lg text-gray-700 hover:bg-purple-50 hover:text-purple-900 font-semibold text-sm">Regular Colleges</a>
                @if(($siteSettings['features.enable_online_colleges'] ?? '1') == '1')
                <a href="{{ route('colleges.online') }}" class="block px-4 py-2.5 rounded-lg text-gray-700 hover:bg-purple-50 hover:text-purple-900 font-semibold text-sm">Online Colleges</a>
                @endif
            </div>
        </div>
    </nav>

    <!-- Main Page Content -->
    <main class="pt-28 flex-1">
        @yield('content')
    </main>

    <!-- Tailwind Global Enquiry Modal -->
    <div id="counselingModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-opacity" role="dialog" aria-modal="true">
        <div class="relative w-full max-w-lg rounded-2xl bg-white shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200">
            <!-- Modal Header -->
            <div class="flex items-center justify-between bg-violet-950 px-6 py-4 text-white">
                <div>
                    <h5 class="text-lg font-bold" id="globalModalTitle">Admission Guidance Enquiry</h5>
                    <p class="text-xs text-violet-200">Direct connection with certified university counselors</p>
                </div>
                <button type="button" onclick="closeEnquiryModal()" class="text-white/80 hover:text-white rounded-lg p-1 text-xl focus:outline-none" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="p-6">
                <form id="globalLeadForm" class="space-y-4">
                    @csrf
                    <input type="hidden" name="college_id" id="modalTargetCollegeId" value="">
                    <input type="hidden" name="source" id="modalLeadSource" value="popup_modal">

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Full Name *</label>
                        <input type="text" name="name" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-purple-600 focus:ring-2 focus:ring-purple-100" value="{{ Auth::user()->name ?? '' }}" placeholder="Your full name" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Mobile Number *</label>
                        <input type="tel" name="phone" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-purple-600 focus:ring-2 focus:ring-purple-100" value="{{ Auth::user()->phone ?? '' }}" placeholder="WhatsApp mobile number" maxlength="10" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Email Address</label>
                        <input type="email" name="email" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-purple-600 focus:ring-2 focus:ring-purple-100" value="{{ str_ends_with(Auth::user()->email ?? '', '@growpec.local') ? '' : (Auth::user()->email ?? '') }}" placeholder="name@example.com">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Your City *</label>
                        <input type="text" name="city" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-purple-600 focus:ring-2 focus:ring-purple-100" value="{{ Auth::user()->city ?? '' }}" placeholder="e.g. Varanasi, Lucknow, Delhi" required>
                    </div>

                    <div id="leadFormResponse"></div>

                    <button type="submit" id="leadSubmitBtn" class="w-full rounded-xl bg-amber-400 hover:bg-amber-300 py-3 text-sm font-extrabold text-violet-950 transition transform hover:-translate-y-0.5 shadow-md">
                        Submit Application Enquiry
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Floating WhatsApp Quick Chat Button -->
    @if(($siteSettings['features.enable_floating_whatsapp'] ?? '1') == '1')
    <a href="https://wa.me/{{ $siteSettings['general.whatsapp_number'] ?? '918858285271' }}?text=Hello%20GrowPEC,%20I%20am%20looking%20for%20admission%20guidance."
       target="_blank"
       class="fixed bottom-6 right-6 w-14 h-14 bg-green-500 text-white rounded-full flex items-center justify-center text-2xl shadow-xl hover:bg-green-600 transition z-40"
       title="Chat on WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>
    @endif

    <!-- Footer -->
    <footer class="bg-slate-950 text-gray-400 py-16 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <div>
                    <a href="{{ route('home') }}" class="inline-block mb-4">
                        <img src="{{ asset($siteSettings['general.footer_logo'] ?? $siteSettings['general.logo'] ?? 'assets/growpec.png') }}" alt="{{ $siteSettings['general.site_name'] ?? 'GrowPEC' }}" class="h-12 w-auto object-contain">
                    </a>
                    <p class="text-sm text-gray-400 mb-4">
                        <strong>{{ $siteSettings['general.site_name'] ?? 'GrowPEC' }}</strong> — {{ $siteSettings['general.site_tagline'] ?? 'India\'s trusted college discovery and admission guidance platform.' }}
                    </p>
                    <div class="space-y-2 text-sm">
                        <p class="flex items-center gap-2">
                            <i class="bi bi-geo-alt text-amber-400"></i>
                            {{ $siteSettings['general.office_address'] ?? 'Varanasi, Uttar Pradesh, India' }}
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="bi bi-telephone text-amber-400"></i>
                            {{ $siteSettings['general.support_phone'] ?? '+91 8858285271' }}
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="bi bi-envelope text-amber-400"></i>
                            {{ $siteSettings['general.support_email'] ?? 'info@growpec.com' }}
                        </p>
                    </div>
                </div>
                <div>
                    <h3 class="text-white font-bold text-lg mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('colleges.regular') }}" class="text-gray-400 hover:text-amber-400 transition">Regular Colleges</a></li>
                        @if(($siteSettings['features.enable_online_colleges'] ?? '1') == '1')
                        <li><a href="{{ route('colleges.online') }}" class="text-gray-400 hover:text-amber-400 transition">Online Colleges</a></li>
                        @endif
                        <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-amber-400 transition">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-amber-400 transition">Contact Support</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-bold text-lg mb-4">Top Programs</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('colleges.regular') }}?courses[]=mba" class="text-gray-400 hover:text-amber-400 transition">MBA / PGDM</a></li>
                        <li><a href="{{ route('colleges.regular') }}?courses[]=btech" class="text-gray-400 hover:text-amber-400 transition">B.Tech Engineering</a></li>
                        <li><a href="{{ route('colleges.regular') }}?courses[]=bca" class="text-gray-400 hover:text-amber-400 transition">BCA / MCA</a></li>
                        <li><a href="{{ route('colleges.regular') }}?courses[]=bpharm" class="text-gray-400 hover:text-amber-400 transition">B.Pharm / D.Pharm</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-bold text-lg mb-4">Support</h3>
                    <p class="text-sm text-gray-400">Get 100% unbiased expert guidance for your career and college admissions.</p>
                </div>
            </div>
            <hr class="border-gray-800 my-8">
            <div class="text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} {{ $siteSettings['general.site_name'] ?? 'GrowPEC' }}. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Header Live Search Script -->
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
                    resultsBox.classList.add('hidden');
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
                                html = `<div class="p-4 text-gray-500 text-center text-sm"><i class="bi bi-search mr-1"></i> No matching colleges or courses.</div>`;
                            } else {
                                if (colleges.length > 0) {
                                    html += `<div class="px-4 py-2 bg-gray-50 text-[11px] font-bold uppercase tracking-wider text-gray-500">Colleges</div>`;
                                    colleges.forEach(col => {
                                        const collegeUrl = `{{ url('/college') }}/${col.slug}`;
                                        html += `
                                            <a href="${collegeUrl}" class="flex items-center justify-between px-4 py-2.5 hover:bg-purple-50 transition border-b border-gray-100 last:border-b-0">
                                                <div>
                                                    <div class="font-semibold text-gray-900 text-sm">${col.name}</div>
                                                    <small class="text-gray-500 text-xs flex items-center gap-1 mt-0.5"><i class="bi bi-geo-alt text-red-600"></i>${col.city}</small>
                                                </div>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-purple-100 text-purple-800">${col.college_mode.toUpperCase()}</span>
                                            </a>
                                        `;
                                    });
                                }
                                if (courses.length > 0) {
                                    html += `<div class="px-4 py-2 bg-gray-50 text-[11px] font-bold uppercase tracking-wider text-gray-500">Programs / Courses</div>`;
                                    courses.forEach(c => {
                                        const courseUrl = `{{ route('colleges.regular') }}?courses[]=${c.slug}`;
                                        html += `
                                            <a href="${courseUrl}" class="flex items-center justify-between px-4 py-2.5 hover:bg-purple-50 transition border-b border-gray-100 last:border-b-0">
                                                <div class="text-sm font-semibold text-gray-900 flex items-center gap-2"><i class="bi bi-mortarboard text-amber-500"></i>${c.name}</div>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-gray-100 text-gray-700">${c.level}</span>
                                            </a>
                                        `;
                                    });
                                }
                                html += `
                                    <div class="p-2.5 border-t border-gray-100 text-center bg-gray-50">
                                        <a href="{{ route('colleges.regular') }}?search=${encodeURIComponent(query)}" class="text-xs font-bold text-purple-900 hover:text-purple-700 inline-flex items-center gap-1">
                                            View all results for "${query}" <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                `;
                            }
                            resultsBox.innerHTML = html;
                            resultsBox.classList.remove('hidden');
                        })
                        .catch(() => {
                            resultsBox.classList.add('hidden');
                        });
                }, 220);
            });
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !resultsBox.contains(e.target)) {
                    resultsBox.classList.add('hidden');
                }
            });
        }
    });

    // Pure Tailwind Modal Functions
    window.openEnquiryModal = function(collegeId = null, collegeName = null) {
        const modalEl = document.getElementById('counselingModal');
        if (!modalEl) return;
        const collegeInput = document.getElementById('modalTargetCollegeId');
        const modalTitle   = document.getElementById('globalModalTitle');
        const sourceInput  = document.getElementById('modalLeadSource');
        if (collegeId) {
            collegeInput.value = collegeId;
            sourceInput.value  = 'college_card_btn';
            if (collegeName && modalTitle) {
                modalTitle.innerText = 'Inquiry: ' + collegeName;
            }
        } else {
            collegeInput.value = '';
            sourceInput.value  = 'popup_modal';
            if (modalTitle) {
                modalTitle.innerText = 'Admission Guidance Enquiry';
            }
        }
        modalEl.classList.remove('hidden');
        modalEl.classList.add('flex');
    };

    window.closeEnquiryModal = function() {
        const modalEl = document.getElementById('counselingModal');
        if (!modalEl) return;
        modalEl.classList.add('hidden');
        modalEl.classList.remove('flex');
    };

    // Close on click outside modal window
    document.getElementById('counselingModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeEnquiryModal();
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeEnquiryModal();
    });

    // Global Lead Submit AJAX
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
            respDiv.innerHTML = `<div class="p-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl text-center my-2">${data.message}</div>`;
            form.reset();
            setTimeout(() => {
                closeEnquiryModal();
                window.location.reload();
            }, 1200);
        })
        .catch(() => {
            btn.disabled = false;
            btn.innerText = 'Submit Application Enquiry';
            respDiv.innerHTML = `<div class="p-3 bg-red-50 border border-red-200 text-red-800 text-sm rounded-xl text-center my-2">Something went wrong. Please try again.</div>`;
        });
    });

    // Mobile Navigation Toggle
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }
    });
    </script>
    @stack('scripts')
</body>
</html>