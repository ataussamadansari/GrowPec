<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - GrowPec')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #F4F6F9; font-family: system-ui, -apple-system, sans-serif; }
        .admin-sidebar { width: 250px; min-height: 100vh; background: #1E1346; color: #fff; position: fixed; }
        .admin-content { margin-left: 250px; padding: 25px; }
        .sidebar-link { color: #A5A1B8; text-decoration: none; padding: 12px 20px; display: block; font-weight: 500; border-radius: 8px; margin: 4px 10px; }
        .sidebar-link:hover, .sidebar-link.active { background: #2E1E6B; color: #fff; }
        .stat-card { background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #E2E8F0; }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="admin-sidebar p-3">
        <h4 class="fw-bold text-white mb-4 px-2">Grow<span class="text-warning">Pec</span> <small class="fs-6 text-white-50">Admin</small></h4>
        <nav class="nav flex-column">
            <a class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
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

    <!-- Main Content -->
    <div class="admin-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">@yield('header', 'Dashboard')</h4>
            <div>
                <span class="badge bg-warning text-dark fw-bold px-3 py-2">Super Admin</span>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>