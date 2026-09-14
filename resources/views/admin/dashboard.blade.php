@extends('admin.layout')

@section('title', 'Admin Dashboard - GrowPec')
@section('header', 'Dashboard Overview')

@section('content')

<style>
    .dashboard-page {
        --gp-navy: #002B67;
        --gp-navy-dark: #001B45;
        --gp-blue: #174B8F;
        --gp-green: #008A43;
        --gp-green-dark: #006B35;
        --gp-gold: #D9A400;
        --gp-bg: #F5F7FA;
        --gp-border: #E6EBF2;
        --gp-text: #172033;
        --gp-muted: #718096;
    }

    .dashboard-welcome {
        position: relative;
        overflow: hidden;
        border-radius: 20px;
        padding: 24px 26px;
        margin-bottom: 22px;
        background: linear-gradient(135deg, var(--gp-navy-dark), var(--gp-navy) 60%, var(--gp-blue));
        color: #fff;
        box-shadow: 0 12px 30px rgba(0, 43, 103, .14);
    }

    .dashboard-welcome::after {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        right: -55px;
        top: -90px;
        border-radius: 50%;
        background: rgba(255,255,255,.07);
    }

    .dashboard-welcome h2 {
        position: relative;
        z-index: 1;
        margin: 0 0 5px;
        font-size: 1.45rem;
        font-weight: 800;
    }

    .dashboard-welcome p {
        position: relative;
        z-index: 1;
        margin: 0;
        color: rgba(255,255,255,.76);
        font-size: .92rem;
    }

    .dashboard-date {
        position: relative;
        z-index: 1;
        font-size: .78rem;
        color: rgba(255,255,255,.7);
        margin-top: 12px;
    }

    .dashboard-stat {
        position: relative;
        height: 100%;
        background: #fff;
        border: 1px solid var(--gp-border);
        border-radius: 18px;
        padding: 19px;
        box-shadow: 0 5px 18px rgba(15, 35, 65, .05);
        transition: transform .2s ease, box-shadow .2s ease;
        overflow: hidden;
    }

    .dashboard-stat:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(15, 35, 65, .09);
    }

    .dashboard-stat::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 100%;
        background: var(--stat-color, var(--gp-blue));
    }

    .stat-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
    }

    .stat-label {
        color: var(--gp-muted);
        font-size: .72rem;
        font-weight: 800;
        letter-spacing: .07em;
    }

    .stat-icon {
        width: 43px;
        height: 43px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--icon-bg);
        color: var(--stat-color);
        font-size: 1.12rem;
        flex-shrink: 0;
    }

    .stat-number {
        margin: 12px 0 4px;
        color: var(--gp-text);
        font-size: 1.9rem;
        line-height: 1;
        font-weight: 800;
    }

    .stat-meta {
        color: var(--gp-muted);
        font-size: .78rem;
    }

    .stat-meta strong {
        color: var(--gp-green);
    }

    .quick-actions {
        height: 100%;
        background: linear-gradient(145deg, #fff, #fbfcfe);
        border: 1px solid var(--gp-border);
        border-radius: 18px;
        padding: 19px;
        box-shadow: 0 5px 18px rgba(15, 35, 65, .05);
    }

    .quick-title {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 13px;
        color: var(--gp-text);
        font-size: .88rem;
        font-weight: 800;
    }

    .quick-title i {
        color: var(--gp-gold);
        font-size: 1.05rem;
    }

    .quick-btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        min-height: 42px;
        border-radius: 11px;
        font-size: .8rem;
        font-weight: 700;
        margin-bottom: 8px;
        transition: all .2s ease;
    }

    .quick-btn:last-child {
        margin-bottom: 0;
    }

    .quick-btn:hover {
        transform: translateX(2px);
    }

    .dashboard-panel {
        margin-top: 22px;
        background: #fff;
        border: 1px solid var(--gp-border);
        border-radius: 20px;
        box-shadow: 0 5px 18px rgba(15, 35, 65, .05);
        overflow: hidden;
    }

    .panel-header {
        padding: 18px 20px;
        border-bottom: 1px solid var(--gp-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .panel-heading {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .panel-icon {
        width: 38px;
        height: 38px;
        border-radius: 11px;
        background: #EAF7F0;
        color: var(--gp-green);
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .panel-header h5 {
        margin: 0;
        color: var(--gp-text);
        font-size: .98rem;
        font-weight: 800;
    }

    .panel-header small {
        color: var(--gp-muted);
        display: block;
        margin-top: 2px;
        font-size: .72rem;
    }

    .view-all-btn {
        border-radius: 10px;
        font-size: .76rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .dashboard-table {
        margin: 0;
    }

    .dashboard-table thead th {
        background: #F8FAFC;
        border-bottom: 1px solid var(--gp-border);
        color: #667085;
        font-size: .69rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .045em;
        padding: 12px 18px;
        white-space: nowrap;
    }

    .dashboard-table tbody td {
        padding: 14px 18px;
        border-color: #EEF2F6;
        color: var(--gp-text);
        font-size: .82rem;
        vertical-align: middle;
    }

    .student-name {
        font-weight: 750;
        color: var(--gp-text);
    }

    .student-phone {
        color: var(--gp-green);
        font-weight: 650;
        text-decoration: none;
        white-space: nowrap;
    }

    .student-phone:hover {
        color: var(--gp-green-dark);
    }

    .student-phone i {
        margin-right: 4px;
    }

    .lead-main {
        font-weight: 650;
    }

    .lead-sub {
        display: block;
        color: var(--gp-muted);
        font-size: .7rem;
        margin-top: 2px;
    }

    .lead-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 9px;
        border-radius: 999px;
        font-size: .65rem;
        font-weight: 800;
        letter-spacing: .03em;
    }

    .status-new {
        color: #B42318;
        background: #FEF3F2;
    }

    .status-admitted {
        color: #067647;
        background: #ECFDF3;
    }

    .status-other {
        color: #9A6700;
        background: #FFF8E1;
    }

    .empty-state {
        padding: 42px 20px !important;
        text-align: center;
        color: var(--gp-muted);
    }

    .empty-state-icon {
        width: 52px;
        height: 52px;
        margin: 0 auto 10px;
        border-radius: 15px;
        background: #F1F5F9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94A3B8;
        font-size: 1.25rem;
    }

    @media (max-width: 991.98px) {
        .dashboard-welcome {
            padding: 21px;
        }
    }

    @media (max-width: 767.98px) {
        .dashboard-welcome {
            border-radius: 16px;
            padding: 19px;
            margin-bottom: 16px;
        }

        .dashboard-welcome h2 {
            font-size: 1.2rem;
        }

        .dashboard-stat,
        .quick-actions {
            border-radius: 15px;
        }

        .dashboard-panel {
            margin-top: 16px;
            border-radius: 16px;
        }

        .panel-header {
            padding: 15px;
            align-items: flex-start;
        }

        .view-all-btn {
            padding: 7px 9px;
        }

        .dashboard-table thead th,
        .dashboard-table tbody td {
            padding: 11px 13px;
        }

        .mobile-hide {
            display: none;
        }
    }
</style>

<div class="dashboard-page">

    <div class="dashboard-welcome">
        <h2>Welcome to GrowPec Admin</h2>
        <p>Manage colleges, courses, student enquiries and your education platform from one place.</p>
        <div class="dashboard-date">
            <i class="bi bi-shield-check me-1"></i>
            Admin Management Portal
        </div>
    </div>

    <div class="row g-3">

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-stat" style="--stat-color:#174B8F; --icon-bg:#EAF1FA;">
                <div class="stat-top">
                    <div class="stat-label">TOTAL COLLEGES</div>
                    <div class="stat-icon"><i class="bi bi-building"></i></div>
                </div>
                <div class="stat-number">{{ $stats['total_colleges'] }}</div>
                <div class="stat-meta">
                    {{ $stats['regular_colleges'] }} Regular
                    <span class="mx-1">•</span>
                    {{ $stats['online_colleges'] }} Online
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-stat" style="--stat-color:#D9A400; --icon-bg:#FFF8E1;">
                <div class="stat-top">
                    <div class="stat-label">TOTAL LEADS</div>
                    <div class="stat-icon"><i class="bi bi-person-lines-fill"></i></div>
                </div>
                <div class="stat-number">{{ $stats['total_leads'] }}</div>
                <div class="stat-meta">
                    <strong>+{{ $stats['new_leads_today'] }} today</strong>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-stat" style="--stat-color:#008A43; --icon-bg:#EAF7F0;">
                <div class="stat-top">
                    <div class="stat-label">TOTAL COURSES</div>
                    <div class="stat-icon"><i class="bi bi-mortarboard-fill"></i></div>
                </div>
                <div class="stat-number">{{ $stats['total_courses'] }}</div>
                <div class="stat-meta">UG, PG &amp; Diploma programs</div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="quick-actions">
                <div class="quick-title">
                    <i class="bi bi-lightning-charge-fill"></i>
                    Quick Actions
                </div>

                <a href="{{ route('admin.colleges.create') }}"
                   class="btn btn-warning quick-btn px-3">
                    <span><i class="bi bi-plus-lg me-2"></i>Add New College</span>
                    <i class="bi bi-arrow-right"></i>
                </a>

                <a href="{{ route('admin.leads.export') }}"
                   class="btn btn-outline-dark quick-btn px-3">
                    <span><i class="bi bi-download me-2"></i>Export Leads CSV</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

    </div>

    <div class="dashboard-panel">
        <div class="panel-header">
            <div class="panel-heading">
                <div class="panel-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <h5>Recent Student Inquiries</h5>
                    <small>Latest enquiries received through GrowPec</small>
                </div>
            </div>

            <a href="{{ route('admin.leads.index') }}"
               class="btn btn-sm btn-outline-primary view-all-btn">
                View All Leads
                <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle dashboard-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Phone / WhatsApp</th>
                        <th>College / Course</th>
                        <th>City</th>
                        <th>Status</th>
                        <th>Received</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($recentLeads as $lead)
                        @php
                            $statusClass = match($lead->status) {
                                'new' => 'status-new',
                                'admitted' => 'status-admitted',
                                default => 'status-other',
                            };
                        @endphp

                        <tr>
                            <td>
                                <span class="student-name">{{ $lead->name }}</span>
                            </td>

                            <td>
                                <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $lead->phone) }}"
                                   target="_blank"
                                   rel="noopener"
                                   class="student-phone">
                                    <i class="bi bi-whatsapp"></i>
                                    {{ $lead->phone }}
                                </a>
                            </td>

                            <td>
                                <span class="lead-main">
                                    {{ $lead->college->name ?? 'General' }}
                                </span>
                                @if($lead->course->name ?? false)
                                    <span class="lead-sub">{{ $lead->course->name }}</span>
                                @endif
                            </td>

                            <td>{{ $lead->city ?? 'N/A' }}</td>

                            <td>
                                <span class="lead-status {{ $statusClass }}">
                                    <i class="bi bi-circle-fill" style="font-size:5px;"></i>
                                    {{ strtoupper($lead->status) }}
                                </span>
                            </td>

                            <td>
                                <small class="text-muted">
                                    {{ $lead->created_at->diffForHumans() }}
                                </small>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="bi bi-inbox"></i>
                                </div>
                                <div class="fw-semibold">No student inquiries yet</div>
                                <small>New enquiries will appear here automatically.</small>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
