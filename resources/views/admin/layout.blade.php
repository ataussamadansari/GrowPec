<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - GrowPec')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --gp-navy: #002B67;
            --gp-navy-dark: #001B45;
            --gp-blue: #174B8F;
            --gp-green: #008A43;
            --gp-green-dark: #006B35;
            --gp-gold: #D9A400;
            --gp-bg: #F5F7FA;
            --gp-border: #E4E9F0;
            --gp-text: #172033;
            --gp-muted: #718096;
            --sidebar-width: 258px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--gp-bg);
            color: var(--gp-text);
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        a {
            text-decoration: none;
        }

        /* SIDEBAR */
        .admin-sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: var(--sidebar-width);
            height: 100vh;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            background: linear-gradient(180deg, var(--gp-navy-dark) 0%, var(--gp-navy) 100%);
            color: #fff;
            box-shadow: 8px 0 28px rgba(0, 27, 69, .08);
            transition: transform .25s ease;
        }

        .admin-brand {
            padding: 22px 19px 18px;
            border-bottom: 1px solid rgba(255, 255, 255, .09);
        }

        .admin-brand-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            padding: 5px 9px;
            border-radius: 10px;
        }

        .admin-brand-logo img {
            width: auto;
            height: 38px;
            max-width: 175px;
            object-fit: contain;
        }

        .admin-brand small {
            display: block;
            margin-top: 9px;
            color: rgba(255, 255, 255, .56);
            font-size: .68rem;
            font-weight: 600;
            letter-spacing: .02em;
        }

        .sidebar-scroll {
            flex: 1;
            overflow-y: auto;
            padding: 15px 10px;
        }

        .sidebar-label {
            padding: 8px 12px 6px;
            color: rgba(255, 255, 255, .35);
            font-size: .62rem;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .sidebar-link {
            position: relative;
            display: flex;
            align-items: center;
            gap: 11px;
            width: 100%;
            min-height: 43px;
            margin: 3px 0;
            padding: 10px 12px;
            border-radius: 10px;
            color: rgba(255, 255, 255, .66);
            font-size: .79rem;
            font-weight: 650;
            transition: .18s ease;
        }

        .sidebar-link i {
            width: 20px;
            text-align: center;
            font-size: 1rem;
            color: rgba(255, 255, 255, .52);
        }

        .sidebar-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, .075);
        }

        .sidebar-link:hover i {
            color: #fff;
        }

        .sidebar-link.active {
            color: #fff;
            background: linear-gradient(90deg, rgba(0, 138, 67, .95), rgba(0, 138, 67, .62));
            box-shadow: 0 7px 18px rgba(0, 0, 0, .12);
        }

        .sidebar-link.active i {
            color: #fff;
        }

        .sidebar-link.active::before {
            content: "";
            position: absolute;
            left: -10px;
            width: 3px;
            height: 22px;
            border-radius: 0 4px 4px 0;
            background: var(--gp-gold);
        }

        .sidebar-footer {
            padding: 14px 15px;
            border-top: 1px solid rgba(255, 255, 255, .09);
        }

        .sidebar-website {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            margin-bottom: 9px;
            color: rgba(255, 255, 255, .58);
            font-size: .68rem;
            font-weight: 700;
        }

        .sidebar-website:hover {
            color: #fff;
        }

        .logout-btn {
            min-height: 40px;
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 10px;
            background: rgba(255, 255, 255, .055);
            color: rgba(255, 255, 255, .78);
            font-size: .76rem;
        }

        .logout-btn:hover {
            border-color: rgba(255, 255, 255, .2);
            background: rgba(255, 255, 255, .1);
            color: #fff;
        }

        /* MAIN */
        .admin-main {
            min-height: 100vh;
            margin-left: var(--sidebar-width);
        }

        .admin-topbar {
            position: sticky;
            top: 0;
            z-index: 900;
            min-height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 13px 28px;
            background: rgba(255, 255, 255, .96);
            border-bottom: 1px solid var(--gp-border);
            backdrop-filter: blur(12px);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .mobile-menu-btn {
            display: none;
            width: 39px;
            height: 39px;
            border: 1px solid var(--gp-border);
            border-radius: 10px;
            background: #fff;
            color: var(--gp-navy);
        }

        .page-title {
            margin: 0;
            color: var(--gp-navy-dark);
            font-size: 1.16rem;
            font-weight: 800;
            letter-spacing: -.02em;
        }

        .page-subtitle {
            margin: 3px 0 0;
            color: var(--gp-muted);
            font-size: .67rem;
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-avatar {
            width: 39px;
            height: 39px;
            display: grid;
            place-items: center;
            flex: 0 0 39px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--gp-navy), var(--gp-blue));
            color: #fff;
            font-size: .88rem;
            font-weight: 800;
        }

        .admin-user-name {
            color: var(--gp-text);
            font-size: .76rem;
            font-weight: 800;
            line-height: 1.25;
        }

        .admin-user-email {
            color: var(--gp-muted);
            font-size: .63rem;
        }

        .role-badge {
            margin-left: 4px;
            padding: 6px 9px;
            border-radius: 999px;
            background: #FFF5D5;
            color: #765800;
            font-size: .59rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .admin-content {
            padding: 26px 28px 35px;
        }

        .admin-alert {
            border: 0;
            border-radius: 12px;
            font-size: .76rem;
            box-shadow: 0 5px 16px rgba(0, 0, 0, .04);
        }

        /* Mobile overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 1030;
            background: rgba(0, 18, 45, .45);
        }

        @media (max-width: 991.98px) {
            :root {
                --sidebar-width: 245px;
            }

            .admin-sidebar {
                transform: translateX(-100%);
            }

            body.sidebar-open .admin-sidebar {
                transform: translateX(0);
            }

            body.sidebar-open .sidebar-overlay {
                display: block;
            }

            .admin-main {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: inline-grid;
                place-items: center;
            }

            .admin-topbar {
                padding: 12px 20px;
            }

            .admin-content {
                padding: 22px 20px 30px;
            }
        }

        @media (max-width: 575.98px) {
            .admin-topbar {
                min-height: 65px;
                padding: 10px 14px;
            }

            .admin-content {
                padding: 18px 14px 28px;
            }

            .page-title {
                font-size: 1rem;
            }

            .page-subtitle {
                display: none;
            }

            .admin-user-info,
            .role-badge {
                display: none;
            }

            .admin-avatar {
                width: 36px;
                height: 36px;
                flex-basis: 36px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="admin-sidebar" id="adminSidebar">

        <div class="admin-brand">
            <a href="{{ route('admin.dashboard') }}" class="admin-brand-logo">
                <img src="{{ asset('assets/growpec.png') }}" alt="GrowPec Admin">
            </a>
            <small>Admin Management Portal</small>
        </div>

        <div class="sidebar-scroll">
            <div class="sidebar-label">Main</div>

            <nav>
                <a class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.dashboard') ? 'page' : 'false' }}"
                    href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>

                <a class="sidebar-link {{ request()->routeIs('admin.streams.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.streams.*') ? 'page' : 'false' }}"
                    href="{{ route('admin.streams.index') }}">
                    <i class="bi bi-diagram-3-fill"></i>
                    <span>Streams</span>
                </a>

                <a class="sidebar-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.courses.*') ? 'page' : 'false' }}"
                    href="{{ route('admin.courses.index') }}">
                    <i class="bi bi-mortarboard-fill"></i>
                    <span>Courses</span>
                </a>

                <a class="sidebar-link {{ request()->routeIs('admin.specializations.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.specializations.*') ? 'page' : 'false' }}"
                    href="{{ route('admin.specializations.index') }}">
                    <i class="bi bi-tags-fill"></i>
                    <span>Specializations</span>
                </a>


                <a class="sidebar-link {{ request()->routeIs('admin.colleges.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.colleges.*') ? 'page' : 'false' }}"
                    href="{{ route('admin.colleges.index') }}">
                    <i class="bi bi-building-fill"></i>
                    <span>Colleges List</span>
                </a>

                <a class="sidebar-link {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.locations.*') ? 'page' : 'false' }}"
                    href="{{ route('admin.locations.index') }}">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>States & Cities</span>
                </a>
                <div class="sidebar-label mt-3">Management</div>

                <a class="sidebar-link {{ request()->routeIs('admin.leads.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.leads.*') ? 'page' : 'false' }}"
                    href="{{ route('admin.leads.index') }}">
                    <i class="bi bi-person-lines-fill"></i>
                    <span>Leads CRM</span>
                </a>

                <a class="sidebar-link {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.partners.*') ? 'page' : 'false' }}"
                    href="{{ route('admin.partners.index') }}">
                    <i class="bi bi-award-fill"></i>
                    <span>Partner Universities</span>
                </a>

                <!-- <a class="sidebar-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.banners.*') ? 'page' : 'false' }}"
                    href="{{ route('admin.banners.index') }}">
                    <i class="bi bi-award-fill"></i>
                    <span>Hero Banner</span>
                </a> -->

                <a class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.settings.*') ? 'page' : 'false' }}"
                    href="{{ route('admin.settings.index') }}">
                    <i class="bi bi-sliders2"></i>
                    <span>Settings</span>
                </a>

                <div class="sidebar-label mt-3">System</div>

                <a class="sidebar-link" href="{{ route('home') }}" target="_blank">
                    <i class="bi bi-box-arrow-up-right"></i>
                    <span>Visit Website</span>
                </a>
            </nav>
        </div>

        <div class="sidebar-footer">
            <div class="sidebar-website">
                <i class="bi bi-shield-check"></i>
                GrowPec Admin
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn logout-btn w-100 fw-bold">
                    <i class="bi bi-box-arrow-right me-1"></i>
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

<main class="admin-main">

        <header class="admin-topbar">
            <div class="topbar-left">
                <button type="button" class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Open menu">
                    <i class="bi bi-list fs-5"></i>
                </button>

                <div>
                    <h1 class="page-title">@yield('header', 'Dashboard')</h1>
                    <p class="page-subtitle">Manage your GrowPec platform from one place.</p>
                </div>
            </div>

            <div class="admin-user">
                <div class="admin-user-info text-end">
                    <div class="admin-user-name">
                        {{ Auth::user()->name ?? 'Administrator' }}
                    </div>
                    <div class="admin-user-email">
                        {{ Auth::user()->email ?? 'admin@growpec.com' }}
                    </div>
                </div>

                <div class="admin-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>

                <span class="role-badge">
                    {{ ucfirst(str_replace('_', ' ', Auth::user()->role ?? 'super_admin')) }}
                </span>
            </div>
        </header>

        <div class="admin-content">

            @if(session('success'))
            <div class="alert alert-success admin-alert alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger admin-alert alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @yield('content')

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.getElementById('mobileMenuBtn');
            const overlay = document.getElementById('sidebarOverlay');

            function closeSidebar() {
                document.body.classList.remove('sidebar-open');
            }

            menuBtn?.addEventListener('click', function() {
                document.body.classList.toggle('sidebar-open');
            });

            overlay?.addEventListener('click', closeSidebar);

            document.querySelectorAll('.sidebar-link').forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 991) closeSidebar();
                });
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth > 991) closeSidebar();
            });
        });
    </script>

    @stack('scripts')
</body>

</html>