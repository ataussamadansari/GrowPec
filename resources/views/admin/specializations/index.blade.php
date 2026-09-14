@extends('admin.layout')
@section('title', 'Manage Specializations - GrowPec Admin')
@section('header', 'Manage Specializations')

@section('content')

<style>
    :root {
        --gp-navy: #002B67;
        --gp-navy-dark: #001B45;
        --gp-blue: #174B8F;
        --gp-green: #008A43;
        --gp-green-dark: #006B35;
        --gp-gold: #D9A400;
        --gp-gold-dark: #B78300;
        --gp-bg: #F5F7FB;
        --gp-border: #E3E8F0;
        --gp-text: #172033;
        --gp-muted: #68758A;
    }

    .sp-page {
        max-width: 1500px;
        margin: 0 auto;
    }

    .sp-hero {
        position: relative;
        overflow: hidden;
        border-radius: 18px;
        padding: 24px 26px;
        margin-bottom: 18px;
        background:
            radial-gradient(circle at 92% 15%, rgba(217,164,0,.18), transparent 28%),
            linear-gradient(135deg, var(--gp-navy-dark), var(--gp-navy) 55%, var(--gp-blue));
        color: #fff;
        box-shadow: 0 12px 30px rgba(0,43,103,.16);
    }

    .sp-hero::after {
        content: "";
        position: absolute;
        width: 170px;
        height: 170px;
        right: -70px;
        bottom: -100px;
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 50%;
        box-shadow: 0 0 0 30px rgba(255,255,255,.035);
    }

    .sp-hero-content {
        position: relative;
        z-index: 1;
    }

    .sp-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 10px;
        border-radius: 999px;
        background: rgba(255,255,255,.10);
        border: 1px solid rgba(255,255,255,.14);
        font-size: .68rem;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .sp-hero h2 {
        margin: 11px 0 5px;
        font-size: 1.45rem;
        font-weight: 800;
        letter-spacing: -.02em;
    }

    .sp-hero p {
        margin: 0;
        color: rgba(255,255,255,.76);
        font-size: .84rem;
        max-width: 650px;
    }

    .sp-panel {
        background: #fff;
        border: 1px solid var(--gp-border);
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(20,35,60,.06);
        overflow: hidden;
    }

    .sp-toolbar {
        padding: 17px;
        border-bottom: 1px solid var(--gp-border);
        background: #fff;
    }

    .sp-toolbar-grid {
        display: grid;
        grid-template-columns: minmax(220px, 1fr) minmax(230px, 310px) auto auto;
        gap: 10px;
        align-items: center;
    }

    .sp-input-wrap {
        position: relative;
    }

    .sp-input-icon {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #8290A5;
        pointer-events: none;
        z-index: 2;
    }

    .sp-search,
    .sp-select {
        height: 42px;
        border: 1px solid #D8E0EA;
        border-radius: 10px;
        font-size: .78rem;
        font-weight: 600;
        color: var(--gp-text);
        background-color: #fff;
        box-shadow: none !important;
    }

    .sp-search {
        padding-left: 38px;
    }

    .sp-search:focus,
    .sp-select:focus {
        border-color: var(--gp-blue);
        box-shadow: 0 0 0 3px rgba(23,75,143,.09) !important;
    }

    .sp-btn {
        height: 42px;
        border-radius: 10px;
        padding: 0 15px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        font-size: .74rem;
        font-weight: 800;
        line-height: 1;
        white-space: nowrap;
        transition: all .18s ease;
    }

    .sp-filter-btn {
        border: 1px solid var(--gp-navy);
        background: var(--gp-navy);
        color: #fff;
    }

    .sp-filter-btn:hover {
        background: var(--gp-navy-dark);
        border-color: var(--gp-navy-dark);
        color: #fff;
        transform: translateY(-1px);
    }

    .sp-add-btn {
        border: 1px solid var(--gp-gold);
        background: var(--gp-gold);
        color: #152033;
    }

    .sp-add-btn:hover {
        background: var(--gp-gold-dark);
        border-color: var(--gp-gold-dark);
        color: #fff;
        transform: translateY(-1px);
    }

    .sp-clear-btn {
        color: #68758A;
        border: 1px solid #D8E0EA;
        background: #fff;
    }

    .sp-clear-btn:hover {
        color: var(--gp-navy);
        border-color: #B8C4D4;
        background: #F7F9FC;
    }

    .sp-active-filters {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 7px;
        margin-top: 11px;
    }

    .sp-filter-label {
        color: var(--gp-muted);
        font-size: .68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .sp-filter-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 9px;
        border-radius: 999px;
        background: #EEF4FB;
        color: var(--gp-blue);
        border: 1px solid #D8E6F7;
        font-size: .68rem;
        font-weight: 750;
    }

    .sp-table-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 15px 17px 13px;
        border-bottom: 1px solid var(--gp-border);
    }

    .sp-section-title {
        margin: 0;
        color: var(--gp-text);
        font-size: .92rem;
        font-weight: 800;
    }

    .sp-result-count {
        color: var(--gp-muted);
        font-size: .7rem;
        font-weight: 700;
    }

    .sp-table-wrap {
        overflow-x: auto;
    }

    .sp-table {
        min-width: 900px;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .sp-table thead th {
        padding: 12px 17px;
        border-bottom: 1px solid var(--gp-border);
        background: #F8FAFD;
        color: #68758A;
        font-size: .66rem;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: .055em;
        white-space: nowrap;
    }

    .sp-table tbody td {
        padding: 13px 17px;
        border-bottom: 1px solid #EDF1F5;
        vertical-align: middle;
        color: var(--gp-text);
        font-size: .77rem;
    }

    .sp-table tbody tr {
        transition: background .15s ease;
    }

    .sp-table tbody tr:hover {
        background: #FAFCFF;
    }

    .sp-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .sp-id {
        color: #8793A5;
        font-weight: 800;
        font-size: .7rem;
    }

    .sp-name-cell {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 210px;
    }

    .sp-avatar {
        width: 38px;
        height: 38px;
        flex: 0 0 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        background: #EAF2FB;
        color: var(--gp-blue);
        border: 1px solid #D7E5F4;
        font-size: .95rem;
    }

    .sp-name {
        color: var(--gp-text);
        font-weight: 800;
        line-height: 1.25;
    }

    .sp-course-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        max-width: 260px;
        padding: 6px 9px;
        border-radius: 8px;
        background: #EEF4FB;
        color: var(--gp-blue);
        border: 1px solid #D8E6F7;
        font-size: .68rem;
        font-weight: 800;
        white-space: normal;
    }

    .sp-stream {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #526176;
        font-size: .72rem;
        font-weight: 700;
    }

    .sp-stream i {
        color: var(--gp-green);
    }

    .sp-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 9px;
        border-radius: 999px;
        font-size: .66rem;
        font-weight: 850;
        border: 1px solid transparent;
    }

    .sp-status.active {
        color: var(--gp-green-dark);
        background: #EAF8F0;
        border-color: #CBEBD9;
    }

    .sp-status.inactive {
        color: #68758A;
        background: #F1F3F6;
        border-color: #E0E4EA;
    }

    .sp-status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .sp-actions {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .sp-action-btn {
        width: 35px;
        height: 35px;
        padding: 0;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        transition: all .18s ease;
    }

    .sp-edit-btn {
        color: var(--gp-blue);
        border: 1px solid #C9D9ED;
        background: #F5F9FE;
    }

    .sp-edit-btn:hover {
        color: #fff;
        background: var(--gp-blue);
        border-color: var(--gp-blue);
        transform: translateY(-1px);
    }

    .sp-delete-btn {
        color: #C0392B;
        border: 1px solid #F0C9C5;
        background: #FFF8F7;
    }

    .sp-delete-btn:hover {
        color: #fff;
        background: #C0392B;
        border-color: #C0392B;
        transform: translateY(-1px);
    }

    .sp-empty {
        padding: 55px 20px !important;
        text-align: center;
    }

    .sp-empty-icon {
        width: 54px;
        height: 54px;
        margin: 0 auto 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        background: #F0F4F9;
        color: #8090A5;
        font-size: 1.25rem;
    }

    .sp-empty-title {
        margin-bottom: 3px;
        color: var(--gp-text);
        font-size: .84rem;
        font-weight: 800;
    }

    .sp-empty-text {
        margin: 0;
        color: var(--gp-muted);
        font-size: .72rem;
    }

    .sp-pagination {
        padding: 14px 17px;
        border-top: 1px solid var(--gp-border);
        background: #FCFDFE;
    }

    .sp-pagination nav {
        display: flex;
        justify-content: center;
    }

    .sp-pagination .pagination {
        margin: 0;
    }

    .sp-pagination .page-link {
        min-width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 2px;
        border-radius: 8px !important;
        border: 1px solid #DCE3EC;
        color: var(--gp-blue);
        font-size: .7rem;
        font-weight: 750;
    }

    .sp-pagination .page-item.active .page-link {
        color: #fff;
        background: var(--gp-navy);
        border-color: var(--gp-navy);
    }

    .sp-pagination .page-link:hover {
        background: #EEF4FB;
        border-color: #C9D9ED;
    }

    @media (max-width: 1100px) {
        .sp-toolbar-grid {
            grid-template-columns: 1fr 1fr;
        }

        .sp-add-btn,
        .sp-filter-btn,
        .sp-clear-btn {
            width: 100%;
        }
    }

    @media (max-width: 767.98px) {
        .sp-hero {
            padding: 20px 18px;
            border-radius: 15px;
        }

        .sp-hero h2 {
            font-size: 1.2rem;
        }

        .sp-hero p {
            font-size: .76rem;
        }

        .sp-toolbar {
            padding: 13px;
        }

        .sp-toolbar-grid {
            grid-template-columns: 1fr;
            gap: 8px;
        }

        .sp-btn {
            width: 100%;
        }

        .sp-table-head {
            padding: 13px;
            align-items: flex-start;
            flex-direction: column;
        }

        .sp-table thead th,
        .sp-table tbody td {
            padding-left: 13px;
            padding-right: 13px;
        }

        .sp-pagination {
            padding: 12px 8px;
            overflow-x: auto;
        }

        .sp-pagination nav {
            min-width: max-content;
        }
    }
</style>

<div class="sp-page">

    <div class="sp-hero">
        <div class="sp-hero-content">
            <span class="sp-eyebrow">
                <i class="bi bi-diagram-3-fill"></i>
                Academic Management
            </span>

            <h2>Manage Specializations</h2>
            <p>
                Organize course specializations, connect them with academic streams,
                and keep your program catalogue structured.
            </p>
        </div>
    </div>

    <div class="sp-panel">

        <div class="sp-toolbar">
            <form action="{{ route('admin.specializations.index') }}" method="GET">
                <div class="sp-toolbar-grid">

                    <div class="sp-input-wrap">
                        <i class="bi bi-search sp-input-icon"></i>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control sp-search"
                            placeholder="Search specialization..."
                            autocomplete="off"
                        >
                    </div>

                    <select name="course_id" class="form-select sp-select" onchange="this.form.submit()">
                        <option value="">All Courses</option>
                        @foreach($courses as $c)
                            <option
                                value="{{ $c->id }}"
                                {{ request('course_id') == $c->id ? 'selected' : '' }}
                            >
                                {{ $c->name }}{{ $c->stream ? ' (' . $c->stream->name . ')' : '' }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn sp-btn sp-filter-btn">
                        <i class="bi bi-funnel-fill"></i>
                        <span>Filter</span>
                    </button>

                    @if(request('search') || request('course_id'))
                        <a href="{{ route('admin.specializations.index') }}" class="btn sp-btn sp-clear-btn">
                            <i class="bi bi-x-lg"></i>
                            <span>Clear</span>
                        </a>
                    @else
                        <a href="{{ route('admin.specializations.create') }}" class="btn sp-btn sp-add-btn">
                            <i class="bi bi-plus-circle-fill"></i>
                            <span>Add Specialization</span>
                        </a>
                    @endif

                </div>

                @if(request('search') || request('course_id'))
                    <div class="sp-active-filters">
                        <span class="sp-filter-label">Active:</span>

                        @if(request('search'))
                            <span class="sp-filter-chip">
                                <i class="bi bi-search"></i>
                                {{ request('search') }}
                            </span>
                        @endif

                        @if(request('course_id'))
                            @php
                                $selectedCourse = $courses->firstWhere('id', request('course_id'));
                            @endphp

                            @if($selectedCourse)
                                <span class="sp-filter-chip">
                                    <i class="bi bi-book-fill"></i>
                                    {{ $selectedCourse->name }}
                                </span>
                            @endif
                        @endif
                    </div>
                @endif
            </form>
        </div>

        <div class="sp-table-head">
            <h3 class="sp-section-title">
                <i class="bi bi-list-ul me-1"></i>
                Specialization Directory
            </h3>

            <span class="sp-result-count">
                {{ $specializations->total() }} {{ $specializations->total() === 1 ? 'specialization' : 'specializations' }}
            </span>
        </div>

        <div class="sp-table-wrap">
            <table class="table sp-table align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Specialization</th>
                        <th>Associated Course</th>
                        <th>Stream</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($specializations as $sp)
                        <tr>
                            <td>
                                <span class="sp-id">#{{ $sp->id }}</span>
                            </td>

                            <td>
                                <div class="sp-name-cell">
                                    <div class="sp-avatar">
                                        <i class="bi bi-mortarboard-fill"></i>
                                    </div>

                                    <div>
                                        <div class="sp-name">{{ $sp->name }}</div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                @if($sp->course)
                                    <span class="sp-course-badge">
                                        <i class="bi bi-book-half"></i>
                                        {{ $sp->course->name }}
                                    </span>
                                @else
                                    <span class="text-muted small">N/A</span>
                                @endif
                            </td>

                            <td>
                                <span class="sp-stream">
                                    <i class="bi bi-diagram-3-fill"></i>
                                    {{ $sp->course->stream->name ?? 'N/A' }}
                                </span>
                            </td>

                            <td>
                                <span class="sp-status {{ $sp->status ? 'active' : 'inactive' }}">
                                    <span class="sp-status-dot"></span>
                                    {{ $sp->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            <td>
                                <div class="sp-actions">
                                    <a
                                        href="{{ route('admin.specializations.edit', $sp->id) }}"
                                        class="btn sp-action-btn sp-edit-btn"
                                        title="Edit specialization"
                                        aria-label="Edit specialization"
                                    >
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    <form
                                        action="{{ route('admin.specializations.destroy', $sp->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Delete this specialization?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn sp-action-btn sp-delete-btn"
                                            title="Delete specialization"
                                            aria-label="Delete specialization"
                                        >
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="sp-empty">
                                <div class="sp-empty-icon">
                                    <i class="bi bi-diagram-3"></i>
                                </div>
                                <div class="sp-empty-title">No specializations found</div>
                                <p class="sp-empty-text">
                                    Try changing your search or course filter.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="sp-pagination">
            {{ $specializations->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>

@endsection
