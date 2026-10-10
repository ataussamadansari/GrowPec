@extends('admin.layout')

@section('title', 'College Reviews Moderation - GrowPec Admin')
@section('header', 'College Reviews Moderation')

@section('content')

<style>
    .reviews-page {
        --gp-navy: #002B67;
        --gp-navy-dark: #001B45;
        --gp-blue: #174B8F;
        --gp-green: #008A43;
        --gp-green-dark: #006B35;
        --gp-gold: #D9A400;
        --gp-gold-light: #FFF8E7;
        --gp-border: #E5EAF0;
        --gp-text: #172033;
        --gp-muted: #718096;
        width: 100%;
        min-width: 0;
    }

    .reviews-page * {
        box-sizing: border-box;
    }

    /* Hero Banner */
    .reviews-hero {
        position: relative;
        overflow: hidden;
        padding: 22px 24px;
        margin-bottom: 16px;
        border-radius: 18px;
        background: linear-gradient(135deg, var(--gp-navy-dark), var(--gp-navy) 62%, var(--gp-blue));
        color: #fff;
        box-shadow: 0 10px 28px rgba(0, 43, 103, .12);
    }

    .reviews-hero:before, .reviews-hero:after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .reviews-hero:before {
        width: 210px; height: 210px; right: -80px; top: -120px;
        background: rgba(255, 255, 255, .07);
    }

    .reviews-hero:after {
        width: 110px; height: 110px; right: 130px; bottom: -75px;
        background: rgba(0, 138, 67, .16);
    }

    .hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
    }

    .hero-left {
        display: flex;
        align-items: center;
        gap: 13px;
        min-width: 0;
    }

    .hero-icon {
        width: 50px;
        height: 50px;
        flex: 0 0 50px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: rgba(255, 255, 255, .12);
        border: 1px solid rgba(255, 255, 255, .14);
        font-size: 1.25rem;
        color: #FFDF6D;
    }

    .hero-title {
        margin: 0 0 4px;
        font-size: 1.18rem;
        font-weight: 800;
    }

    .hero-subtitle {
        margin: 0;
        color: rgba(255, 255, 255, .72);
        font-size: .76rem;
    }

    .hero-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .10);
        border: 1px solid rgba(255, 255, 255, .13);
        color: rgba(255, 255, 255, .9);
        font-size: .68rem;
        font-weight: 800;
        white-space: nowrap;
    }

    /* Main Container Card */
    .reviews-card {
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--gp-border);
        border-radius: 18px;
        box-shadow: 0 8px 26px rgba(15, 35, 65, .055);
    }

    /* Stats Ribbon */
    .crm-summary {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        border-bottom: 1px solid var(--gp-border);
    }

    .summary-item {
        padding: 15px 18px;
        border-right: 1px solid var(--gp-border);
        min-width: 0;
    }

    .summary-item:last-child {
        border-right: 0;
    }

    .summary-label {
        display: flex;
        align-items: center;
        gap: 6px;
        color: var(--gp-muted);
        font-size: .62rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .summary-value {
        margin-top: 5px;
        color: var(--gp-navy);
        font-size: 1.25rem;
        font-weight: 900;
        line-height: 1.1;
    }

    .summary-value.gold { color: #D97706; }
    .summary-value.green { color: var(--gp-green); }
    .summary-value.red { color: #DC2626; }

    /* Moderation Filter & Navigation Bar */
    .filter-section {
        padding: 16px 20px;
        background: #FAFCFE;
        border-bottom: 1px solid var(--gp-border);
    }

    .tabs-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 14px;
    }

    .tab-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 14px;
        border-radius: 999px;
        border: 1px solid #D9E2EC;
        background: #fff;
        color: #486581;
        font-size: .74rem;
        font-weight: 750;
        text-decoration: none;
        transition: all .16s ease;
    }

    .tab-pill:hover {
        background: #F0F4F8;
        color: var(--gp-navy);
        border-color: #BCCCDC;
    }

    .tab-pill.active {
        background: var(--gp-navy);
        color: #fff;
        border-color: var(--gp-navy);
        box-shadow: 0 4px 12px rgba(0, 43, 103, .18);
    }

    .tab-pill.active .badge {
        background: rgba(255, 255, 255, .22) !important;
        color: #fff !important;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: 1fr 260px auto;
        gap: 12px;
        align-items: center;
    }

    .search-input-wrap {
        position: relative;
    }

    .search-input-wrap i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gp-muted);
        font-size: .85rem;
    }

    .search-input {
        width: 100%;
        min-height: 38px;
        padding: 6px 12px 6px 36px;
        border-radius: 10px;
        border: 1px solid var(--gp-border);
        font-size: .78rem;
        background: #fff;
        color: var(--gp-text);
    }

    .search-input:focus, .filter-select:focus {
        border-color: var(--gp-blue);
        box-shadow: 0 0 0 3px rgba(23, 75, 143, .12);
        outline: none;
    }

    .filter-select {
        min-height: 38px;
        padding: 6px 12px;
        border-radius: 10px;
        border: 1px solid var(--gp-border);
        font-size: .78rem;
        background: #fff;
        color: var(--gp-text);
        width: 100%;
    }

    /* Table Styling */
    .table-shell {
        width: 100%;
        overflow-x: auto;
    }

    .reviews-table {
        width: 100%;
        min-width: 1100px;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .reviews-table thead th {
        padding: 12px 14px;
        background: #F8FAFC;
        border-bottom: 1px solid var(--gp-border);
        color: #667085;
        font-size: .63rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .045em;
        white-space: nowrap;
        vertical-align: middle;
    }

    .reviews-table tbody td {
        padding: 13px 14px;
        border-bottom: 1px solid #EEF1F5;
        color: #475467;
        font-size: .74rem;
        vertical-align: middle;
    }

    .reviews-table tbody tr:hover {
        background: #FBFCFE;
    }

    /* Reviewer Cell */
    .reviewer-cell {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 180px;
    }

    .reviewer-avatar {
        width: 36px;
        height: 36px;
        flex: 0 0 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #EAF1FA;
        border: 1px solid #D9E7F7;
        color: var(--gp-blue);
        font-size: .84rem;
        font-weight: 800;
    }

    .reviewer-info {
        min-width: 0;
    }

    .reviewer-name {
        font-weight: 800;
        color: var(--gp-navy-dark);
        font-size: .78rem;
        margin: 0;
    }

    .reviewer-meta {
        font-size: .65rem;
        color: var(--gp-muted);
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 2px;
    }

    /* Rating Star Display */
    .star-display {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        color: #F59E0B;
        font-size: .78rem;
    }

    .rating-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 8px;
        border-radius: 999px;
        background: var(--gp-gold-light);
        border: 1px solid #FDE68A;
        color: #92400E;
        font-size: .68rem;
        font-weight: 850;
    }

    /* College Cell */
    .college-cell {
        max-width: 200px;
    }

    .college-link {
        color: var(--gp-navy);
        font-weight: 750;
        text-decoration: none;
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .college-link:hover {
        color: var(--gp-green);
        text-decoration: underline;
    }

    .course-badge {
        display: inline-block;
        font-size: .62rem;
        color: var(--gp-muted);
        margin-top: 2px;
    }

    /* Review Text Cell */
    .review-body-cell {
        max-width: 320px;
        min-width: 220px;
    }

    .review-text-clamp {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.4;
        font-size: .74rem;
        color: #334155;
    }

    .read-more-btn {
        background: none;
        border: none;
        padding: 0;
        color: var(--gp-blue);
        font-size: .65rem;
        font-weight: 750;
        cursor: pointer;
        margin-top: 2px;
    }

    .read-more-btn:hover {
        text-decoration: underline;
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 9px;
        border-radius: 999px;
        font-size: .64rem;
        font-weight: 850;
        text-transform: capitalize;
    }

    .status-pending {
        background: #FEF3C7;
        border: 1px solid #FCD34D;
        color: #92400E;
    }

    .status-approved {
        background: #ECFDF5;
        border: 1px solid #A7F3D0;
        color: #065F46;
    }

    .status-rejected {
        background: #FEE2E2;
        border: 1px solid #FECACA;
        color: #991B1B;
    }

    /* Action Buttons */
    .actions-wrap {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .act-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 8px;
        border: 1px solid transparent;
        font-size: .82rem;
        cursor: pointer;
        transition: all .14s ease;
    }

    .act-approve {
        background: #ECFDF5;
        border-color: #A7F3D0;
        color: #059669;
    }

    .act-approve:hover {
        background: #059669;
        border-color: #059669;
        color: #fff;
    }

    .act-reject {
        background: #FFFBEB;
        border-color: #FDE68A;
        color: #D97706;
    }

    .act-reject:hover {
        background: #D97706;
        border-color: #D97706;
        color: #fff;
    }

    .act-delete {
        background: #FEF2F2;
        border-color: #FECACA;
        color: #DC2626;
    }

    .act-delete:hover {
        background: #DC2626;
        border-color: #DC2626;
        color: #fff;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 48px 20px;
        color: var(--gp-muted);
    }

    .empty-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 14px;
        border-radius: 18px;
        background: #F1F5F9;
        display: grid;
        place-items: center;
        font-size: 1.8rem;
        color: #94A3B8;
    }

    @media (max-width: 991.98px) {
        .crm-summary {
            grid-template-columns: repeat(2, 1fr);
        }
        .filter-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="reviews-page">

    {{-- Hero Banner --}}
    <div class="reviews-hero">
        <div class="hero-content">
            <div class="hero-left">
                <div class="hero-icon">
                    <i class="bi bi-star-half"></i>
                </div>
                <div>
                    <h2 class="hero-title">College Reviews Moderation</h2>
                    <p class="hero-subtitle">Moderate public guest ratings, approve legitimate student feedback, and protect profile integrity.</p>
                </div>
            </div>
            <div class="d-none d-md-flex">
                <span class="hero-pill">
                    <i class="bi bi-shield-check text-warning"></i>
                    <span>Spam Honeypot & Rate-Limit Guard Active</span>
                </span>
            </div>
        </div>
    </div>

    {{-- Main Container Card --}}
    <div class="reviews-card">

        {{-- Statistics Ribbon --}}
        <div class="crm-summary">
            <div class="summary-item">
                <div class="summary-label">
                    <i class="bi bi-hourglass-split text-warning"></i>
                    Pending Moderation
                </div>
                <div class="summary-value gold">
                    {{ number_format($pendingCount) }}
                </div>
            </div>

            <div class="summary-item">
                <div class="summary-label">
                    <i class="bi bi-check-circle text-success"></i>
                    Approved & Published
                </div>
                <div class="summary-value green">
                    {{ number_format($approvedCount) }}
                </div>
            </div>

            <div class="summary-item">
                <div class="summary-label">
                    <i class="bi bi-x-circle text-danger"></i>
                    Rejected
                </div>
                <div class="summary-value red">
                    {{ number_format($rejectedCount) }}
                </div>
            </div>

            <div class="summary-item">
                <div class="summary-label">
                    <i class="bi bi-chat-square-text text-primary"></i>
                    Total Submissions
                </div>
                <div class="summary-value">
                    {{ number_format($allCount) }}
                </div>
            </div>
        </div>

        {{-- Filter & Moderation Navigation Bar --}}
        <div class="filter-section">
            {{-- Status Tabs --}}
            <div class="tabs-pills">
                <a href="{{ route('admin.reviews.index', array_merge(request()->except('status', 'page'), ['status' => 'pending'])) }}"
                   class="tab-pill {{ $status === 'pending' ? 'active' : '' }}">
                    <i class="bi bi-hourglass-split"></i>
                    <span>Pending</span>
                    <span class="badge rounded-pill bg-warning text-dark ms-1">{{ $pendingCount }}</span>
                </a>

                <a href="{{ route('admin.reviews.index', array_merge(request()->except('status', 'page'), ['status' => 'approved'])) }}"
                   class="tab-pill {{ $status === 'approved' ? 'active' : '' }}">
                    <i class="bi bi-check2-circle"></i>
                    <span>Approved</span>
                    <span class="badge rounded-pill bg-success ms-1">{{ $approvedCount }}</span>
                </a>

                <a href="{{ route('admin.reviews.index', array_merge(request()->except('status', 'page'), ['status' => 'rejected'])) }}"
                   class="tab-pill {{ $status === 'rejected' ? 'active' : '' }}">
                    <i class="bi bi-x-circle"></i>
                    <span>Rejected</span>
                    <span class="badge rounded-pill bg-danger ms-1">{{ $rejectedCount }}</span>
                </a>

                <a href="{{ route('admin.reviews.index', array_merge(request()->except('status', 'page'), ['status' => 'all'])) }}"
                   class="tab-pill {{ $status === 'all' ? 'active' : '' }}">
                    <i class="bi bi-collection"></i>
                    <span>All Reviews</span>
                    <span class="badge rounded-pill bg-secondary ms-1">{{ $allCount }}</span>
                </a>
            </div>

            {{-- Filter Form --}}
            <form action="{{ route('admin.reviews.index') }}" method="GET" class="filter-grid">
                <input type="hidden" name="status" value="{{ $status }}">

                <div class="search-input-wrap">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" class="search-input"
                           placeholder="Search reviewer name, email, course, review text, or college..."
                           value="{{ request('search') }}">
                </div>

                <div>
                    <select name="college_id" class="filter-select" onchange="this.form.submit()">
                        <option value="">All Colleges ({{ $colleges->count() }})</option>
                        @foreach($colleges as $col)
                            <option value="{{ $col->id }}" {{ request('college_id') == $col->id ? 'selected' : '' }}>
                                {{ $col->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-primary px-3 fw-bold" style="min-height: 38px; border-radius: 10px; background: var(--gp-navy); border-color: var(--gp-navy);">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>
                    @if(request('search') || request('college_id'))
                        <a href="{{ route('admin.reviews.index', ['status' => $status]) }}" class="btn btn-sm btn-light border px-2 d-inline-flex align-items-center" style="min-height: 38px; border-radius: 10px;" title="Reset filters">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Table Shell --}}
        <div class="table-shell">
            @if($reviews->isNotEmpty())
                <table class="reviews-table">
                    <thead>
                        <tr>
                            <th style="width: 220px;">Reviewer Details</th>
                            <th style="width: 200px;">Target College</th>
                            <th style="width: 130px;">Rating</th>
                            <th>Review Content</th>
                            <th style="width: 110px;">Status</th>
                            <th style="width: 120px;">Submitted</th>
                            <th style="width: 120px;" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reviews as $item)
                            <tr>
                                {{-- Reviewer Details --}}
                                <td>
                                    <div class="reviewer-cell">
                                        <div class="reviewer-avatar">
                                            {{ strtoupper(substr($item->reviewer_name ?? 'G', 0, 1)) }}
                                        </div>
                                        <div class="reviewer-info">
                                            <p class="reviewer-name">{{ $item->reviewer_name }}</p>
                                            <div class="reviewer-meta">
                                                <span>{{ $item->email ?: 'No email' }}</span>
                                            </div>
                                            @if($item->ip_address)
                                                <div class="reviewer-meta">
                                                    <span class="badge bg-light text-muted border px-1" style="font-size: 0.58rem;">
                                                        <i class="bi bi-geo-alt"></i> {{ $item->ip_address }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- College & Course --}}
                                <td>
                                    <div class="college-cell">
                                        @if($item->college)
                                            <a href="{{ route('college.show', $item->college->slug) }}" target="_blank" class="college-link" title="{{ $item->college->name }}">
                                                {{ $item->college->name }}
                                                <i class="bi bi-box-arrow-up-right ms-1 text-muted" style="font-size: .65rem;"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">Unknown College</span>
                                        @endif
                                        @if($item->course)
                                            <span class="course-badge">
                                                <i class="bi bi-mortarboard text-secondary me-1"></i>{{ $item->course }}
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Star Rating --}}
                                <td>
                                    <div class="d-flex flex-column align-items-start gap-1">
                                        <div class="star-display">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $item->rating)
                                                    <i class="bi bi-star-fill"></i>
                                                @else
                                                    <i class="bi bi-star text-muted" style="opacity: .35;"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="rating-badge">
                                            {{ number_format($item->rating, 1) }} / 5.0
                                        </span>
                                    </div>
                                </td>

                                {{-- Review Text Excerpt --}}
                                <td>
                                    <div class="review-body-cell">
                                        <div class="review-text-clamp" id="text-{{ $item->id }}">
                                            {{ $item->review }}
                                        </div>
                                        @if(strlen($item->review) > 130)
                                            <button type="button" class="read-more-btn" data-bs-toggle="modal" data-bs-target="#reviewModal-{{ $item->id }}">
                                                View complete text &raquo;
                                            </button>

                                            {{-- Detail Modal --}}
                                            <div class="modal fade" id="reviewModal-{{ $item->id }}" tabindex="-1" aria-labelledby="modalLabel-{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                                                        <div class="modal-header border-bottom py-3">
                                                            <div>
                                                                <h6 class="modal-title fw-bold text-navy" id="modalLabel-{{ $item->id }}">
                                                                    Review by {{ $item->reviewer_name }}
                                                                </h6>
                                                                <small class="text-muted">{{ $item->college->name ?? 'College' }} &bull; {{ $item->course ?: 'General Student' }}</small>
                                                            </div>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body py-4">
                                                            <div class="d-flex align-items-center gap-2 mb-3">
                                                                <div class="star-display">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                        <i class="bi {{ $i <= $item->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                                                    @endfor
                                                                </div>
                                                                <span class="fw-bold">{{ $item->rating }} out of 5 stars</span>
                                                            </div>
                                                            <p class="text-secondary" style="line-height: 1.6; white-space: pre-line;">{{ $item->review }}</p>

                                                            <hr class="my-3">
                                                            <div class="small text-muted d-flex justify-content-between">
                                                                <span>Submitted: {{ $item->created_at->format('M d, Y h:i A') }}</span>
                                                                @if($item->ip_address)
                                                                    <span>IP: {{ $item->ip_address }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-0 pt-0">
                                                            <button type="button" class="btn btn-sm btn-light border" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                {{-- Status Badge --}}
                                <td>
                                    @if($item->status === 'approved')
                                        <span class="status-badge status-approved">
                                            <i class="bi bi-check-circle-fill"></i> Approved
                                        </span>
                                    @elseif($item->status === 'rejected')
                                        <span class="status-badge status-rejected">
                                            <i class="bi bi-x-circle-fill"></i> Rejected
                                        </span>
                                    @else
                                        <span class="status-badge status-pending">
                                            <i class="bi bi-clock-fill"></i> Pending
                                        </span>
                                    @endif
                                </td>

                                {{-- Submitted Date --}}
                                <td>
                                    <span class="text-nowrap" style="font-size: .72rem; font-weight: 650; color: #475467;">
                                        {{ $item->created_at->format('M d, Y') }}
                                    </span>
                                    <div class="text-muted" style="font-size: .62rem;">
                                        {{ $item->created_at->diffForHumans() }}
                                    </div>
                                </td>

                                {{-- Actions Toolbar --}}
                                <td>
                                    <div class="actions-wrap justify-content-end">
                                        {{-- Approve Button (if not already approved) --}}
                                        @if($item->status !== 'approved')
                                            <form action="{{ route('admin.reviews.approve', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="act-btn act-approve" title="Approve & Publish Review">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Reject Button (if not already rejected) --}}
                                        @if($item->status !== 'rejected')
                                            <form action="{{ route('admin.reviews.reject', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="act-btn act-reject" title="Reject Review">
                                                    <i class="bi bi-slash-circle"></i>
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Delete Button (Permanent) --}}
                                        <form action="{{ route('admin.reviews.destroy', $item->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to permanently delete this review? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="act-btn act-delete" title="Permanently Delete">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-star"></i>
                    </div>
                    <h6 class="fw-bold text-navy mb-1">No Reviews Found</h6>
                    <p class="small text-muted mb-3">
                        @if(request('search') || request('college_id'))
                            No reviews match your search and filter criteria. Try resetting your filters.
                        @else
                            There are currently no {{ $status !== 'all' ? $status : '' }} reviews in the database.
                        @endif
                    </p>
                    @if(request('search') || request('college_id'))
                        <a href="{{ route('admin.reviews.index', ['status' => $status]) }}" class="btn btn-sm btn-outline-primary">
                            Reset Filters
                        </a>
                    @endif
                </div>
            @endif
        </div>

        {{-- Pagination Footer --}}
        @if($reviews->hasPages())
            <div class="p-3 border-top d-flex justify-content-between align-items-center bg-light">
                <span class="small text-muted">
                    Showing {{ $reviews->firstItem() }} to {{ $reviews->lastItem() }} of {{ $reviews->total() }} reviews
                </span>
                <div>
                    {{ $reviews->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif

    </div>

</div>

@endsection
