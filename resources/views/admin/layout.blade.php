<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - GrowPec')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #F4F6F9;
            font-family: system-ui, -apple-system, sans-serif;
        }

        .admin-sidebar {
            width: 250px;
            min-height: 100vh;
            background: #1E1346;
            color: #fff;
            position: fixed;
            z-index: 100;
        }

        .admin-content {
            margin-left: 250px;
            padding: 25px;
        }

        .sidebar-link {
            color: #A5A1B8;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            font-weight: 500;
            border-radius: 8px;
            margin: 4px 10px;
            transition: all 0.2s ease;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: #2E1E6B;
            color: #fff;
        }

        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #E2E8F0;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="admin-sidebar p-3 d-flex flex-column justify-content-between">
        <div>
            <div class="mb-4 px-2">
                <a href="{{ route('admin.dashboard') }}" class="d-inline-block">
                    <img src="{{ asset('assets/growpec.png') }}" alt="GrowPEC Admin" class="bg-white p-1 rounded-2" style="height: 42px; max-width: 190px; object-fit: contain;">
                </a>
                <small class="d-block text-white-50 mt-1" style="font-size: 0.75rem;">Admin Management Portal</small>
            </div>
            <nav class="nav flex-column">
                <a class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
                <!-- 🎯 Hero Banners Manager -->
                <a class="sidebar-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}" href="{{ route('admin.banners.index') }}">
                    <i class="bi bi-image me-2"></i> Hero Banners
                </a>
                <a class="sidebar-link {{ request()->routeIs('admin.streams.*') ? 'active' : '' }}" href="{{ route('admin.streams.index') }}">
                    <i class="bi bi-diagram-3 me-2"></i> Streams
                </a>
                <a class="sidebar-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}" href="{{ route('admin.courses.index') }}">
                    <i class="bi bi-mortarboard me-2"></i> Courses
                </a>
                <a class="sidebar-link {{ request()->routeIs('admin.specializations.*') ? 'active' : '' }}" href="{{ route('admin.specializations.index') }}">
                    <i class="bi bi-tags me-2"></i> Specializations
                </a>
                <a class="sidebar-link {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}" href="{{ route('admin.locations.index') }}">
                    <i class="bi bi-geo-alt me-2"></i> States & Cities
                </a>
                <a class="sidebar-link {{ request()->routeIs('admin.colleges.*') ? 'active' : '' }}" href="{{ route('admin.colleges.index') }}">
                    <i class="bi bi-building me-2"></i> Colleges List
                </a>
                <a class="sidebar-link {{ request()->routeIs('admin.leads.*') ? 'active' : '' }}" href="{{ route('admin.leads.index') }}">
                    <i class="bi bi-person-lines-fill me-2"></i> Leads CRM
                </a>
                <a class="sidebar-link" href="{{ route('home') }}" target="_blank">
                    <i class="bi bi-box-arrow-up-right me-2"></i> Visit Website
                </a>
            </nav>
        </div>

        <!-- Sidebar Bottom Logout -->
        <div class="px-2 pt-3 border-top border-secondary">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger w-100 fw-bold">
                    <i class="bi bi-box-arrow-right me-1"></i> Sign Out
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="admin-content">
        <!-- Top Navigation Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded-4 shadow-sm border">
            <h4 class="fw-bold mb-0 text-dark">@yield('header', 'Dashboard')</h4>
            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-sm-block">
                    <div class="fw-bold text-dark">{{ Auth::user()->name ?? 'Administrator' }}</div>
                    <small class="text-muted">{{ Auth::user()->email ?? 'admin@growpec.com' }}</small>
                </div>
                <span class="badge bg-warning text-dark fw-bold px-3 py-2">
                    {{ ucfirst(str_replace('_', ' ', Auth::user()->role ?? 'super_admin')) }}
                </span>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>