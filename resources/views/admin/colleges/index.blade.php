@extends('admin.layout')
@section('title', 'Colleges List - GrowPec Admin')
@section('header', 'Manage Colleges')

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
        --gp-border: #E3E8F0;
        --gp-text: #172033;
        --gp-muted: #68758A;
    }

    .college-page {
        max-width: 1600px;
        margin: 0 auto;
    }

    .college-hero {
        position: relative;
        overflow: hidden;
        padding: 24px 26px;
        margin-bottom: 18px;
        border-radius: 18px;
        color: #fff;
        background:
            radial-gradient(circle at 91% 18%, rgba(217,164,0,.18), transparent 27%),
            linear-gradient(135deg, var(--gp-navy-dark), var(--gp-navy) 56%, var(--gp-blue));
        box-shadow: 0 12px 30px rgba(0,43,103,.16);
    }

    .college-hero::after {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        right: -70px;
        bottom: -105px;
        border: 1px solid rgba(255,255,255,.13);
        border-radius: 50%;
        box-shadow: 0 0 0 32px rgba(255,255,255,.035);
    }

    .college-hero-content {
        position: relative;
        z-index: 1;
    }

    .college-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 10px;
        border-radius: 999px;
        background: rgba(255,255,255,.10);
        border: 1px solid rgba(255,255,255,.14);
        font-size: .66rem;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .college-hero h2 {
        margin: 11px 0 5px;
        font-size: 1.45rem;
        font-weight: 800;
        letter-spacing: -.02em;
    }

    .college-hero p {
        margin: 0;
        max-width: 700px;
        color: rgba(255,255,255,.76);
        font-size: .81rem;
    }

    .college-panel {
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--gp-border);
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(20,35,60,.06);
    }

    .college-toolbar {
        padding: 16px 17px;
        border-bottom: 1px solid var(--gp-border);
        background: #fff;
    }

    .college-toolbar-form {
        display: grid;
        grid-template-columns: minmax(250px, 1fr) auto auto;
        gap: 9px;
        align-items: center;
    }

    .college-search-wrap {
        position: relative;
    }

    .college-search-icon {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #8290A5;
        pointer-events: none;
        z-index: 2;
    }

    .college-search {
        height: 42px;
        padding-left: 38px;
        border: 1px solid #D8E0EA;
        border-radius: 10px;
        color: var(--gp-text);
        font-size: .78rem;
        font-weight: 600;
        box-shadow: none !important;
    }

    .college-search:focus {
        border-color: var(--gp-blue);
        box-shadow: 0 0 0 3px rgba(23,75,143,.09) !important;
    }

    .college-btn {
        height: 42px;
        padding: 0 15px;
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

    .college-search-btn {
        color: #fff;
        background: var(--gp-navy);
        border: 1px solid var(--gp-navy);
    }

    .college-search-btn:hover {
        color: #fff;
        background: var(--gp-navy-dark);
        border-color: var(--gp-navy-dark);
        transform: translateY(-1px);
    }

    .college-add-btn {
        color: #152033;
        background: var(--gp-gold);
        border: 1px solid var(--gp-gold);
    }

    .college-add-btn:hover {
        color: #fff;
        background: var(--gp-gold-dark);
        border-color: var(--gp-gold-dark);
        transform: translateY(-1px);
    }

    .college-clear-btn {
        color: var(--gp-muted);
        background: #fff;
        border: 1px solid #D8E0EA;
    }

    .college-clear-btn:hover {
        color: var(--gp-navy);
        background: #F7F9FC;
        border-color: #BCC8D7;
    }

    .college-filter-row {
        display: flex;
        align-items: center;
        gap: 7px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .college-filter-label {
        color: var(--gp-muted);
        font-size: .66rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .college-filter-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 9px;
        border-radius: 999px;
        color: var(--gp-blue);
        background: #EEF4FB;
        border: 1px solid #D8E6F7;
        font-size: .67rem;
        font-weight: 750;
    }

    .college-list-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 15px 17px 13px;
        border-bottom: 1px solid var(--gp-border);
    }

    .college-list-title {
        margin: 0;
        color: var(--gp-text);
        font-size: .92rem;
        font-weight: 800;
    }

    .college-list-count {
        color: var(--gp-muted);
        font-size: .69rem;
        font-weight: 750;
    }

    .college-table-wrap {
        overflow-x: auto;
    }

    .college-table {
        min-width: 1080px;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .college-table thead th {
        padding: 12px 16px;
        background: #F8FAFD;
        border-bottom: 1px solid var(--gp-border);
        color: #68758A;
        font-size: .65rem;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: .055em;
        white-space: nowrap;
    }

    .college-table tbody td {
        padding: 13px 16px;
        border-bottom: 1px solid #EDF1F5;
        color: var(--gp-text);
        font-size: .75rem;
        vertical-align: middle;
    }

    .college-table tbody tr {
        transition: background .15s ease;
    }

    .college-table tbody tr:hover {
        background: #FAFCFF;
    }

    .college-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .college-name-cell {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 280px;
    }

    .college-avatar {
        width: 43px;
        height: 43px;
        flex: 0 0 43px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-radius: 11px;
        background: #EAF2FB;
        color: var(--gp-blue);
        border: 1px solid #D7E5F4;
        font-size: 1rem;
    }

    .college-avatar img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 5px;
        background: #fff;
    }

    .college-name {
        color: var(--gp-text);
        font-size: .77rem;
        font-weight: 800;
        line-height: 1.3;
    }

    .college-university {
        margin-top: 3px;
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: var(--gp-muted);
        font-size: .65rem;
        font-weight: 600;
    }

    .college-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 9px;
        border-radius: 8px;
        font-size: .65rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .college-mode-online {
        color: var(--gp-green-dark);
        background: #EAF8F0;
        border: 1px solid #CBEBD9;
    }

    .college-mode-regular {
        color: var(--gp-blue);
        background: #EEF4FB;
        border: 1px solid #D8E6F7;
    }

    .college-type {
        color: #526176;
        background: #F7F9FB;
        border: 1px solid #E0E5EC;
    }

    .college-location {
        display: flex;
        align-items: flex-start;
        gap: 6px;
        color: #526176;
        font-size: .7rem;
        font-weight: 650;
        line-height: 1.4;
    }

    .college-location i {
        color: var(--gp-green);
        margin-top: 1px;
    }

    .college-courses {
        color: var(--gp-blue);
        background: #F0F5FB;
        border: 1px solid #DCE7F3;
    }

    .college-rating {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #4F5C70;
        font-size: .73rem;
        font-weight: 800;
    }

    .college-rating i {
        color: var(--gp-gold);
        font-size: .78rem;
    }

    .college-actions {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .college-action {
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

    .college-view {
        color: #526176;
        background: #F7F9FB;
        border: 1px solid #DCE2EA;
    }

    .college-view:hover {
        color: #fff;
        background: #526176;
        border-color: #526176;
        transform: translateY(-1px);
    }

    .college-edit {
        color: var(--gp-blue);
        background: #F5F9FE;
        border: 1px solid #C9D9ED;
    }

    .college-edit:hover {
        color: #fff;
        background: var(--gp-blue);
        border-color: var(--gp-blue);
        transform: translateY(-1px);
    }

    .college-delete {
        color: #C0392B;
        background: #FFF8F7;
        border: 1px solid #F0C9C5;
    }

    .college-delete:hover {
        color: #fff;
        background: #C0392B;
        border-color: #C0392B;
        transform: translateY(-1px);
    }

    .college-empty {
        padding: 58px 20px !important;
        text-align: center;
    }

    .college-empty-icon {
        width: 56px;
        height: 56px;
        margin: 0 auto 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        color: #7E8CA0;
        background: #F0F4F9;
        font-size: 1.25rem;
    }

    .college-empty-title {
        margin-bottom: 3px;
        color: var(--gp-text);
        font-size: .84rem;
        font-weight: 800;
    }

    .college-empty-text {
        margin: 0;
        color: var(--gp-muted);
        font-size: .7rem;
    }

    .college-pagination {
        padding: 14px 17px;
        border-top: 1px solid var(--gp-border);
        background: #FCFDFE;
    }

    .college-pagination nav {
        display: flex;
        justify-content: center;
    }

    .college-pagination .pagination {
        margin: 0;
    }

    .college-pagination .page-link {
        min-width: 34px;
        height: 34px;
        margin: 0 2px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px !important;
        border: 1px solid #DCE3EC;
        color: var(--gp-blue);
        font-size: .7rem;
        font-weight: 750;
    }

    .college-pagination .page-item.active .page-link {
        color: #fff;
        background: var(--gp-navy);
        border-color: var(--gp-navy);
    }

    .college-pagination .page-link:hover {
        background: #EEF4FB;
        border-color: #C9D9ED;
    }

    @media (max-width: 900px) {
        .college-toolbar-form {
            grid-template-columns: 1fr 1fr;
        }

        .college-search-wrap {
            grid-column: 1 / -1;
        }

        .college-search-btn,
        .college-add-btn,
        .college-clear-btn {
            width: 100%;
        }
    }

    @media (max-width: 767.98px) {
        .college-hero {
            padding: 19px 17px;
            border-radius: 15px;
        }

        .college-hero h2 {
            font-size: 1.2rem;
        }

        .college-hero p {
            font-size: .73rem;
        }

        .college-toolbar {
            padding: 13px;
        }

        .college-toolbar-form {
            grid-template-columns: 1fr;
            gap: 8px;
        }

        .college-search-wrap {
            grid-column: auto;
        }

        .college-btn {
            width: 100%;
        }

        .college-list-head {
            padding: 13px;
            align-items: flex-start;
            flex-direction: column;
        }

        .college-table {
            min-width: 1020px;
        }

        .college-table thead th,
        .college-table tbody td {
            padding-left: 13px;
            padding-right: 13px;
        }

        .college-pagination {
            padding: 12px 8px;
            overflow-x: auto;
        }

        .college-pagination nav {
            min-width: max-content;
        }
    }
</style>

<div class="college-page">

    <div class="college-hero">
        <div class="college-hero-content">
            <span class="college-eyebrow">
                <i class="bi bi-buildings-fill"></i>
                College Management
            </span>

            <h2>Manage Colleges</h2>

            <p>
                Manage GrowPec's college directory, review institution details,
                and keep regular and online colleges organized.
            </p>
        </div>
    </div>

    <div class="college-panel">

        <div class="college-toolbar">
            <form action="{{ route('admin.colleges.index') }}" method="GET">

                <div class="college-toolbar-form">

                    <div class="college-search-wrap">
                        <i class="bi bi-search college-search-icon"></i>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control college-search"
                            placeholder="Search by college name, city or university..."
                            autocomplete="off"
                        >
                    </div>

                    <button type="submit" class="btn college-btn college-search-btn">
                        <i class="bi bi-search"></i>
                        <span>Search</span>
                    </button>

                    @if(request('search'))
                        <a href="{{ route('admin.colleges.index') }}" class="btn college-btn college-clear-btn">
                            <i class="bi bi-x-lg"></i>
                            <span>Clear</span>
                        </a>
                    @else
                        <a href="{{ route('admin.colleges.create') }}" class="btn college-btn college-add-btn">
                            <i class="bi bi-plus-circle-fill"></i>
                            <span>Add New College</span>
                        </a>
                    @endif

                </div>

                @if(request('search'))
                    <div class="college-filter-row">
                        <span class="college-filter-label">Active Search:</span>

                        <span class="college-filter-chip">
                            <i class="bi bi-search"></i>
                            {{ request('search') }}
                        </span>
                    </div>
                @endif

            </form>
        </div>

        <div class="college-list-head">
            <h3 class="college-list-title">
                <i class="bi bi-list-ul me-1"></i>
                College Directory
            </h3>

            <span class="college-list-count">
                {{ $colleges->total() }} {{ $colleges->total() === 1 ? 'college' : 'colleges' }}
            </span>
        </div>

        <div class="college-table-wrap">
            <table class="table college-table align-middle mb-0">
                <thead>
                    <tr>
                        <th>College Name</th>
                        <th>Mode</th>
                        <th>Type</th>
                        <th>Location</th>
                        <th>Courses</th>
                        <th>Rating</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($colleges as $col)
                        <tr>

                            <td>
                                <div class="college-name-cell">
                                    <div class="college-avatar">
                                        @if($col->logo)
                                            <img
                                                src="{{ str_starts_with($col->logo, 'http') ? $col->logo : asset('storage/' . $col->logo) }}"
                                                alt="{{ $col->name }}"
                                                loading="lazy"
                                            >
                                        @else
                                            <i class="bi bi-building-fill"></i>
                                        @endif
                                    </div>

                                    <div>
                                        <div class="college-name">
                                            {{ $col->name }}
                                        </div>

                                        @if($col->university_name)
                                            <div class="college-university" title="{{ $col->university_name }}">
                                                {{ $col->university_name }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td>
                                @if($col->college_mode === 'online')
                                    <span class="college-badge college-mode-online">
                                        <i class="bi bi-globe2"></i>
                                        Online
                                    </span>
                                @else
                                    <span class="college-badge college-mode-regular">
                                        <i class="bi bi-building"></i>
                                        Regular
                                    </span>
                                @endif
                            </td>

                            <td>
                                <span class="college-badge college-type">
                                    <i class="bi bi-mortarboard-fill"></i>
                                    {{ $col->college_type ?: 'N/A' }}
                                </span>
                            </td>

                            <td>
                                <div class="college-location">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <span>
                                        {{ $col->city ?: 'N/A' }}
                                        @if($col->state)
                                            <br>{{ $col->state }}
                                        @endif
                                    </span>
                                </div>
                            </td>

                            <td>
                                <span class="college-badge college-courses">
                                    <i class="bi bi-book-half"></i>
                                    {{ $col->courses->count() }} Courses
                                </span>
                            </td>

                            <td>
                                <span class="college-rating">
                                    <i class="bi bi-star-fill"></i>
                                    {{ $col->rating !== null ? number_format((float) $col->rating, 1) : 'N/A' }}
                                </span>
                            </td>

                            <td>
                                <div class="college-actions">

                                    <a
                                        href="{{ route('college.show', $col->slug) }}"
                                        target="_blank"
                                        rel="noopener"
                                        class="btn college-action college-view"
                                        title="View Public Page"
                                        aria-label="View public page"
                                    >
                                        <i class="bi bi-eye-fill"></i>
                                    </a>

                                    <a
                                        href="{{ route('admin.colleges.edit', $col->id) }}"
                                        class="btn college-action college-edit"
                                        title="Edit College"
                                        aria-label="Edit college"
                                    >
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    <form
                                        action="{{ route('admin.colleges.destroy', $col->id) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this college?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn college-action college-delete"
                                            title="Delete College"
                                            aria-label="Delete college"
                                        >
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="college-empty">
                                <div class="college-empty-icon">
                                    <i class="bi bi-buildings"></i>
                                </div>

                                <div class="college-empty-title">
                                    No colleges found
                                </div>

                                <p class="college-empty-text">
                                    Try a different search term or add a new college to the directory.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="college-pagination">
            {{ $colleges->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>

@endsection
