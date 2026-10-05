@extends('admin.layout')
@section('title', 'Manage Courses - GrowPec Admin')
@section('header', 'Manage Courses & Programs')

@section('content')

<style>
    .courses-page {
        --gp-navy: #002B67;
        --gp-navy-dark: #001B45;
        --gp-blue: #174B8F;
        --gp-green: #008A43;
        --gp-green-dark: #006B35;
        --gp-gold: #D9A400;
        --gp-border: #E5EAF0;
        --gp-text: #172033;
        --gp-muted: #718096;
        color: var(--gp-text);
    }

    .courses-wrap {
        width: 100%;
    }

    /* Hero */
    .courses-hero {
        position: relative;
        overflow: hidden;
        padding: 22px 24px;
        margin-bottom: 16px;
        border-radius: 18px;
        background: linear-gradient(135deg, var(--gp-navy-dark), var(--gp-navy) 62%, var(--gp-blue));
        color: #fff;
        box-shadow: 0 10px 28px rgba(0, 43, 103, .12);
    }

    .courses-hero::before,
    .courses-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .courses-hero::before {
        width: 190px;
        height: 190px;
        right: -75px;
        top: -105px;
        background: rgba(255,255,255,.07);
    }

    .courses-hero::after {
        width: 110px;
        height: 110px;
        right: 110px;
        bottom: -75px;
        background: rgba(0,138,67,.14);
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
    }

    .hero-icon {
        width: 48px;
        height: 48px;
        flex: 0 0 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.12);
        font-size: 1.2rem;
    }

    .hero-title {
        margin: 0 0 4px;
        font-size: 1.18rem;
        font-weight: 800;
        letter-spacing: -.2px;
    }

    .hero-subtitle {
        margin: 0;
        color: rgba(255,255,255,.72);
        font-size: .76rem;
    }

    .hero-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(255,255,255,.10);
        border: 1px solid rgba(255,255,255,.13);
        color: rgba(255,255,255,.9);
        font-size: .68rem;
        font-weight: 800;
        white-space: nowrap;
    }

    /* Main card */
    .courses-card {
        background: #fff;
        border: 1px solid var(--gp-border);
        border-radius: 18px;
        box-shadow: 0 8px 26px rgba(15,35,65,.055);
        overflow: hidden;
    }

    /* Toolbar */
    .courses-toolbar {
        padding: 17px 18px;
        border-bottom: 1px solid var(--gp-border);
        background: #fff;
    }

    .filter-form {
        display: flex;
        align-items: center;
        gap: 9px;
        width: 100%;
    }

    .search-wrap {
        position: relative;
        flex: 1 1 320px;
        min-width: 190px;
    }

    .search-wrap > i {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gp-blue);
        pointer-events: none;
        z-index: 2;
    }

    .course-search,
    .stream-select {
        height: 42px;
        border: 1px solid #D8DEE8;
        border-radius: 10px;
        background: #fff;
        color: var(--gp-text);
        font-size: .76rem;
        box-shadow: none;
    }

    .course-search {
        padding-left: 38px;
    }

    .course-search:focus,
    .stream-select:focus {
        border-color: var(--gp-blue);
        box-shadow: 0 0 0 3px rgba(23,75,143,.09);
    }

    .stream-select {
        flex: 0 0 190px;
        padding-left: 12px;
    }

    .filter-btn,
    .add-course-btn {
        height: 42px;
        border-radius: 10px;
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

    .filter-btn {
        min-width: 84px;
        padding: 0 15px;
        border: 1px solid var(--gp-navy);
        background: var(--gp-navy);
        color: #fff;
    }

    .filter-btn:hover {
        background: var(--gp-blue);
        border-color: var(--gp-blue);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(0,43,103,.16);
    }

    .add-course-btn {
        flex: 0 0 auto;
        padding: 0 16px;
        border: 1px solid var(--gp-gold);
        background: var(--gp-gold);
        color: #1B1B1B;
        box-shadow: 0 5px 13px rgba(217,164,0,.14);
    }

    .add-course-btn:hover {
        background: #C89400;
        border-color: #C89400;
        color: #111;
        transform: translateY(-1px);
        box-shadow: 0 7px 16px rgba(217,164,0,.20);
    }

    /* Active filters */
    .active-filter {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
        font-size: .67rem;
        color: var(--gp-muted);
    }

    .active-filter-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 9px;
        border-radius: 999px;
        background: #F1F6FC;
        border: 1px solid #D9E7F7;
        color: var(--gp-blue);
        font-weight: 800;
    }

    .clear-filter {
        color: #B42318;
        text-decoration: none;
        font-weight: 800;
    }

    .clear-filter:hover {
        color: #8F1C13;
        text-decoration: underline;
    }

    /* Table */
    .table-shell {
        overflow-x: auto;
    }

    .courses-table {
        min-width: 900px;
        margin: 0;
    }

    .courses-table thead th {
        padding: 12px 15px;
        background: #F8FAFC;
        border-bottom: 1px solid var(--gp-border);
        color: #667085;
        font-size: .64rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .045em;
        white-space: nowrap;
    }

    .courses-table tbody td {
        padding: 13px 15px;
        border-color: #EEF1F5;
        color: #475467;
        font-size: .74rem;
        vertical-align: middle;
        white-space: nowrap;
    }

    .courses-table tbody tr {
        transition: background .15s ease;
    }

    .courses-table tbody tr:hover {
        background: #FBFCFE;
    }

    .course-id {
        width: 45px;
        color: #98A2B3 !important;
        font-weight: 700;
    }

    .course-name {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 180px;
    }

    .course-avatar {
        width: 36px;
        height: 36px;
        flex: 0 0 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #EAF1FA;
        color: var(--gp-blue);
        border: 1px solid #D9E7F7;
        font-size: .9rem;
    }

    .course-name-text {
        min-width: 0;
    }

    .course-name-text strong {
        display: block;
        color: var(--gp-text);
        font-size: .77rem;
        font-weight: 800;
        max-width: 220px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .course-name-text small {
        display: block;
        margin-top: 2px;
        color: var(--gp-muted);
        font-size: .61rem;
    }

    .stream-badge,
    .level-badge,
    .college-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border-radius: 999px;
        padding: 5px 9px;
        font-size: .62rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .stream-badge {
        color: var(--gp-blue);
        background: #EDF4FC;
        border: 1px solid #D9E7F7;
    }

    .level-badge {
        color: #475467;
        background: #F8FAFC;
        border: 1px solid #E2E7ED;
    }

    .college-badge {
        color: var(--gp-green-dark);
        background: #ECFDF3;
        border: 1px solid #CDEBD9;
    }

    .degree-text,
    .duration-text {
        color: #475467;
        font-weight: 600;
    }

    /* Actions */
    .course-actions {
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        padding: 0;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        font-size: .82rem;
        transition: all .18s ease;
    }

    .edit-btn {
        border: 1px solid #C9D9ED;
        background: #F4F8FD;
        color: var(--gp-blue);
    }

    .edit-btn:hover {
        border-color: var(--gp-blue);
        background: var(--gp-blue);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 5px 12px rgba(23,75,143,.18);
    }

    .delete-btn {
        border: 1px solid #F0C8C5;
        background: #FFF7F6;
        color: #C43227;
    }

    .delete-btn:hover {
        border-color: #D92D20;
        background: #D92D20;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 5px 12px rgba(217,45,32,.15);
    }

    /* Empty */
    .empty-state {
        padding: 50px 20px !important;
        text-align: center;
    }

    .empty-icon {
        width: 54px;
        height: 54px;
        margin: 0 auto 11px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        background: #F1F6FC;
        color: var(--gp-blue);
        font-size: 1.25rem;
    }

    .empty-state strong {
        display: block;
        color: var(--gp-text);
        font-size: .82rem;
        margin-bottom: 3px;
    }

    .empty-state span {
        color: var(--gp-muted);
        font-size: .68rem;
    }

    /* Pagination */
    .pagination-wrap {
        display: flex;
        justify-content: center;
        padding: 15px 18px 17px;
        border-top: 1px solid var(--gp-border);
    }

    .pagination {
        margin: 0;
    }

    .pagination .page-link {
        min-width: 34px;
        height: 34px;
        margin: 0 2px;
        border-radius: 8px !important;
        border: 1px solid #E0E6ED;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--gp-blue);
        font-size: .69rem;
        font-weight: 700;
    }

    .pagination .page-item.active .page-link {
        background: var(--gp-navy);
        border-color: var(--gp-navy);
        color: #fff;
    }

    .pagination .page-link:hover {
        background: #F1F6FC;
        border-color: #C9D9ED;
    }

    /* Tablet */
    @media (max-width: 991.98px) {
        .courses-hero {
            padding: 20px;
        }

        .hero-pill {
            display: none;
        }

        .filter-form {
            flex-wrap: wrap;
        }

        .search-wrap {
            flex: 1 1 100%;
        }

        .stream-select {
            flex: 1 1 0;
        }

        .filter-btn {
            min-width: 100px;
        }

        .add-course-btn {
            margin-top: 2px;
        }
    }

    /* Mobile */
    @media (max-width: 575.98px) {
        .courses-hero {
            padding: 17px;
            border-radius: 15px;
        }

        .hero-icon {
            width: 42px;
            height: 42px;
            flex-basis: 42px;
            border-radius: 11px;
        }

        .hero-title {
            font-size: 1rem;
        }

        .hero-subtitle {
            font-size: .68rem;
        }

        .courses-card {
            border-radius: 15px;
        }

        .courses-toolbar {
            padding: 14px;
        }

        .filter-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .search-wrap {
            grid-column: 1 / -1;
            min-width: 0;
        }

        .stream-select,
        .filter-btn,
        .add-course-btn {
            width: 100%;
            min-width: 0;
            flex: none;
        }

        .add-course-btn {
            margin: 0;
        }

        .filter-btn,
        .add-course-btn {
            height: 40px;
        }

        .active-filter {
            flex-wrap: wrap;
        }

        .courses-table {
            min-width: 850px;
        }

        .pagination-wrap {
            overflow-x: auto;
            justify-content: flex-start;
            padding-left: 12px;
            padding-right: 12px;
        }
    }
</style>

<div class="courses-page">
    <div class="courses-wrap">

        {{-- Header --}}
        <div class="courses-hero">
            <div class="hero-content">
                <div class="hero-left">
                    <span class="hero-icon">
                        <i class="bi bi-journal-bookmark-fill"></i>
                    </span>

                    <div>
                        <h3 class="hero-title">Manage Courses & Programs</h3>
                        <p class="hero-subtitle">
                            Manage academic programs, streams, duration and college offerings.
                        </p>
                    </div>
                </div>

                <span class="hero-pill">
                    <i class="bi bi-mortarboard-fill"></i>
                    Academic Catalog
                </span>
            </div>
        </div>

        <div class="courses-card">

            {{-- Toolbar --}}
            <div class="courses-toolbar">
                <form action="{{ route('admin.courses.index') }}" method="GET" class="filter-form">

                    <div class="search-wrap">
                        <i class="bi bi-search"></i>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control course-search"
                            placeholder="Search course (e.g. BCA, MBA)..."
                            autocomplete="off"
                        >
                    </div>

                    <select name="stream_id" class="form-select stream-select" onchange="this.form.submit()">
                        <option value="">All Streams</option>

                        @foreach($streams as $st)
                            <option
                                value="{{ $st->id }}"
                                {{ request('stream_id') == $st->id ? 'selected' : '' }}
                            >
                                {{ $st->name }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn filter-btn">
                        <i class="bi bi-funnel-fill"></i>
                        <span>Filter</span>
                    </button>

                    <a href="{{ route('admin.courses.create') }}" class="btn add-course-btn">
                        <i class="bi bi-plus-circle-fill"></i>
                        <span>Add New Course</span>
                    </a>
                </form>

                @if(request('search') || request('stream_id'))
                    <div class="active-filter">
                        <span>Active:</span>

                        @if(request('search'))
                            <span class="active-filter-badge">
                                <i class="bi bi-search"></i>
                                {{ request('search') }}
                            </span>
                        @endif

                        @if(request('stream_id'))
                            @php
                                $selectedStream = $streams->firstWhere('id', request('stream_id'));
                            @endphp

                            @if($selectedStream)
                                <span class="active-filter-badge">
                                    <i class="bi bi-diagram-3-fill"></i>
                                    {{ $selectedStream->name }}
                                </span>
                            @endif
                        @endif

                        <a href="{{ route('admin.courses.index') }}" class="clear-filter">
                            Clear
                        </a>
                    </div>
                @endif
            </div>

            {{-- Table --}}
            <div class="table-shell">
                <table class="table courses-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Course Name</th>
                            <th>Stream</th>
                            <th>Level</th>
                            <th>Degree Type</th>
                            <th>Duration</th>
                            <th>Offering Colleges</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($courses as $course)
                            <tr>
                                <td class="course-id">
                                    {{ $course->id }}
                                </td>

                                <td>
                                    <div class="course-name">
                                        <span class="course-avatar">
                                            <i class="bi bi-book-half"></i>
                                        </span>

                                        <div class="course-name-text">
                                            <strong title="{{ $course->name }}">
                                                {{ $course->name }}
                                            </strong>

                                            @if($course->slug)
                                                <small>{{ $course->slug }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="stream-badge">
                                        <i class="bi bi-diagram-3-fill"></i>
                                        {{ $course->stream->name ?? 'N/A' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="level-badge">
                                        {{ $course->level ?: 'N/A' }}
                                    </span>
                                </td>

                                <td class="degree-text">
                                    {{ $course->degree_type ?: 'N/A' }}
                                </td>

                                <td class="duration-text">
                                    {{ $course->duration ?: 'N/A' }}
                                </td>

                                <td>
                                    <span class="college-badge">
                                        <i class="bi bi-building"></i>
                                        {{ $course->college_courses_count }} Colleges
                                    </span>
                                </td>

                                <td class="text-center">
                                    <div class="course-actions">
                                        <a
                                            href="{{ route('admin.courses.edit', $course->id) }}"
                                            class="btn action-btn edit-btn"
                                            title="Edit Course"
                                            aria-label="Edit Course"
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form
                                            action="{{ route('admin.courses.destroy', $course->id) }}"
                                            method="POST"
                                            class="m-0"
                                            onsubmit="return confirm('Delete this course?');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn action-btn delete-btn"
                                                title="Delete Course"
                                                aria-label="Delete Course"
                                            >
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="8" class="empty-state">
                                    <div class="empty-icon">
                                        <i class="bi bi-journal-x"></i>
                                    </div>

                                    <strong>No courses found</strong>
                                    <span>
                                        Try changing your search or stream filter.
                                    </span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($courses->hasPages())
                <div class="pagination-wrap">
                    {{ $courses->links('pagination::bootstrap-5') }}
                </div>
            @endif

        </div>
    </div>
</div>

@endsection
