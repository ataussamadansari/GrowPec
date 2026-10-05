@extends('admin.layout')

@section('title', 'Manage Center Logins - GrowPec Admin')
@section('header', 'Center Logins')

@section('content')

<style>
    .gp-center-login-page {
        --gp-navy: #002B67;
        --gp-navy-dark: #001B45;
        --gp-blue: #174B8F;
        --gp-green: #008A43;
        --gp-green-dark: #006B35;
        --gp-gold: #D9A400;
        --gp-border: #E1E8F0;
        --gp-text: #172033;
        --gp-muted: #718096;
        width: 100%;
        padding-bottom: 30px;
    }

    .gp-hero {
        position: relative;
        overflow: hidden;
        margin-bottom: 20px;
        padding: 22px 24px;
        border-radius: 18px;
        color: #fff;
        background: linear-gradient(135deg, var(--gp-navy-dark), var(--gp-navy) 60%, var(--gp-blue));
        box-shadow: 0 10px 28px rgba(0, 43, 103, .12);
    }

    .gp-hero::after {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        right: -60px;
        top: -80px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .07);
    }

    .gp-hero-content {
        position: relative;
        z-index: 1;
    }

    .gp-hero-icon {
        width: 44px;
        height: 44px;
        flex: 0 0 44px;
        margin-right: 14px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, .12);
        color: #fff;
        font-size: 1.25rem;
    }

    .gp-hero h3 {
        margin: 0 0 4px;
        font-size: 1.2rem;
        font-weight: 800;
    }

    .gp-hero p {
        margin: 0;
        color: rgba(255, 255, 255, .75);
        font-size: .8rem;
    }

    .gp-panel {
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--gp-border);
        border-radius: 18px;
        box-shadow: 0 5px 18px rgba(15, 35, 65, .05);
    }

    .gp-toolbar {
        padding: 16px 20px;
        background: #fff;
        border-bottom: 1px solid var(--gp-border);
    }

    .search-wrap {
        position: relative;
        min-width: 240px;
    }

    .search-wrap .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #98A2B3;
        pointer-events: none;
    }

    .search-wrap input {
        width: 100%;
        height: 40px;
        padding: 0 12px 0 37px;
        border: 1px solid #D8DEE8;
        border-radius: 10px;
        font-size: .82rem;
    }

    .search-wrap input:focus {
        border-color: var(--gp-blue);
        box-shadow: 0 0 0 3px rgba(23, 75, 143, .1);
    }

    .gp-select {
        height: 40px;
        padding: 0 32px 0 12px;
        border: 1px solid #D8DEE8;
        border-radius: 10px;
        font-size: .82rem;
        color: var(--gp-text);
    }

    .gp-btn-gold {
        height: 40px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0 16px;
        border: 0;
        border-radius: 10px;
        background: var(--gp-gold);
        color: #111;
        font-size: .78rem;
        font-weight: 800;
        box-shadow: 0 4px 12px rgba(217, 164, 0, .2);
        text-decoration: none;
        transition: all .2s ease;
    }

    .gp-btn-gold:hover {
        background: #C49200;
        color: #000;
        transform: translateY(-1px);
    }

    .gp-table thead th {
        padding: 13px 18px;
        background: #F8FAFC;
        border-bottom: 1px solid var(--gp-border);
        color: #64748B;
        font-size: .68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .04em;
        white-space: nowrap;
    }

    .gp-table tbody td {
        padding: 14px 18px;
        border-color: #EEF2F6;
        font-size: .82rem;
        vertical-align: middle;
    }

    .gp-table tbody tr:hover {
        background: #FBFCFE;
    }

    .title-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 750;
        color: var(--gp-navy);
    }

    .title-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #EAF1FA;
        color: var(--gp-blue);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: .95rem;
    }

    .url-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        max-width: 320px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #475467;
        font-size: .76rem;
        background: #F8FAFC;
        padding: 5px 9px;
        border-radius: 7px;
        border: 1px solid #E2E8F0;
        text-decoration: none;
        transition: color .18s ease;
    }

    .url-badge:hover {
        color: var(--gp-blue);
        border-color: #CBD5E1;
    }

    .index-pill {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 999px;
        background: #F1F5F9;
        color: #475467;
        font-weight: 700;
        font-size: .72rem;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 750;
        border: 0;
        cursor: pointer;
        transition: all .2s ease;
    }

    .status-badge.active {
        background: #DEF7EC;
        color: #03543F;
    }

    .status-badge.active:hover {
        background: #BCF0DA;
    }

    .status-badge.inactive {
        background: #FDE8E8;
        color: #9B1C1C;
    }

    .status-badge.inactive:hover {
        background: #FBD5D5;
    }

    .action-btn {
        width: 34px;
        height: 34px;
        padding: 0;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: .8rem;
        transition: all .16s ease;
    }

    .action-edit {
        color: var(--gp-blue);
        background: #F7FAFE;
        border: 1px solid #BFD2E8;
    }

    .action-edit:hover {
        color: #fff;
        background: var(--gp-blue);
        border-color: var(--gp-blue);
    }

    .action-del {
        color: #C92A2A;
        background: #FFF9F9;
        border: 1px solid #F0C5C5;
    }

    .action-del:hover {
        color: #fff;
        background: #C92A2A;
        border-color: #C92A2A;
    }

    .empty-box {
        padding: 48px 20px;
        text-align: center;
        color: var(--gp-muted);
    }

    .empty-icon {
        width: 56px;
        height: 56px;
        margin: 0 auto 12px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #F1F5F9;
        color: #94A3B8;
        font-size: 1.3rem;
    }
</style>

<div class="gp-center-login-page">

    <!-- Hero Banner -->
    <div class="gp-hero">
        <div class="gp-hero-content d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center">
                <span class="gp-hero-icon">
                    <i class="bi bi-box-arrow-in-right"></i>
                </span>
                <div>
                    <h3>Center Logins Manager</h3>
                    <p>Manage quick login access links for authorized centers displayed on website header and footer.</p>
                </div>
            </div>

            <a href="{{ route('admin.center-logins.create') }}" class="gp-btn-gold">
                <i class="bi bi-plus-lg"></i>
                <span>Add Center Login</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Main Panel -->
    <div class="gp-panel">

        <!-- Toolbar -->
        <div class="gp-toolbar">
            <form action="{{ route('admin.center-logins.index') }}" method="GET" class="d-flex flex-wrap gap-2 justify-content-between align-items-center">

                <div class="d-flex flex-wrap gap-2 flex-grow-1">
                    <div class="search-wrap flex-grow-1">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title or URL..." aria-label="Search">
                    </div>

                    <select name="status" class="gp-select" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active Only</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive Only</option>
                    </select>

                    <button type="submit" class="btn btn-dark btn-sm rounded-3 px-3 fw-bold">
                        <i class="bi bi-funnel-fill me-1"></i> Filter
                    </button>

                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('admin.center-logins.index') }}" class="btn btn-light border btn-sm rounded-3 px-3 fw-bold text-muted">
                            <i class="bi bi-x-circle me-1"></i> Reset
                        </a>
                    @endif
                </div>

                <div class="text-muted small fw-bold">
                    Total: {{ method_exists($centerLogins, 'total') ? $centerLogins->total() : $centerLogins->count() }} Logins
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table gp-table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 70px;">#</th>
                        <th>Title</th>
                        <th>Destination URL</th>
                        <th style="width: 120px;" class="text-center">Order (Index)</th>
                        <th style="width: 130px;" class="text-center">Status</th>
                        <th style="width: 150px;">Created</th>
                        <th style="width: 120px;" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($centerLogins as $login)
                        <tr>
                            <td class="text-muted fw-bold">#{{ $login->id }}</td>

                            <td>
                                <div class="title-pill">
                                    <span class="title-icon">
                                        <i class="bi bi-person-badge-fill"></i>
                                    </span>
                                    <span>{{ $login->title }}</span>
                                </div>
                            </td>

                            <td>
                                <a href="{{ $login->url }}" target="_blank" rel="noopener noreferrer" class="url-badge" title="{{ $login->url }}">
                                    <span>{{ $login->url }}</span>
                                    <i class="bi bi-box-arrow-up-right"></i>
                                </a>
                            </td>

                            <td class="text-center">
                                <span class="index-pill">{{ $login->index }}</span>
                            </td>

                            <td class="text-center">
                                <form action="{{ route('admin.center-logins.toggleStatus', $login) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="status-badge {{ $login->is_active ? 'active' : 'inactive' }}" title="Click to toggle status">
                                        <i class="bi {{ $login->is_active ? 'bi-check-circle-fill' : 'bi-dash-circle-fill' }}"></i>
                                        <span>{{ $login->is_active ? 'Active' : 'Inactive' }}</span>
                                    </button>
                                </form>
                            </td>

                            <td class="text-muted small">
                                {{ $login->created_at ? $login->created_at->format('d M, Y') : '—' }}
                            </td>

                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('admin.center-logins.edit', $login) }}" class="action-btn action-edit" title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    <form action="{{ route('admin.center-logins.destroy', $login) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Center Login?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn action-del" title="Delete">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-box">
                                    <div class="empty-icon">
                                        <i class="bi bi-box-arrow-in-right"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">No Center Logins Found</h6>
                                    <p class="small text-muted mb-3">Add center login portal links to show in the website header and footer.</p>
                                    <a href="{{ route('admin.center-logins.create') }}" class="gp-btn-gold">
                                        <i class="bi bi-plus-lg"></i>
                                        <span>Add First Center Login</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($centerLogins, 'hasPages') && $centerLogins->hasPages())
            <div class="p-3 border-top bg-light">
                {{ $centerLogins->links() }}
            </div>
        @endif

    </div>

</div>

@endsection
