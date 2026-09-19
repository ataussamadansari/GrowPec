@extends('admin.layout')

@section('title', 'Manage Locations - GrowPec Admin')
@section('header', 'Location Directory (States & Cities)')

@section('content')

<style>
    .gp-locations {
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
        max-width: none;
        min-width: 0;
        padding: 0 0 28px;
    }

    .gp-locations * {
        box-sizing: border-box;
    }

    /* Hero */
    .gp-location-hero {
        position: relative;
        width: 100%;
        min-width: 0;
        overflow: hidden;
        margin-bottom: 18px;
        padding: 23px 25px;
        border-radius: 17px;
        color: #fff;
        background: linear-gradient(135deg, var(--gp-navy-dark), var(--gp-navy) 58%, var(--gp-blue));
        box-shadow: 0 12px 30px rgba(0, 43, 103, .14);
    }

    .gp-location-hero:before {
        content: "";
        position: absolute;
        width: 190px;
        height: 190px;
        right: -70px;
        top: -90px;
        border: 1px solid rgba(255, 255, 255, .12);
        border-radius: 50%;
        box-shadow: 0 0 0 30px rgba(255, 255, 255, .025);
    }

    .gp-location-hero>* {
        position: relative;
        z-index: 1;
    }

    .gp-kicker {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border: 1px solid rgba(255, 255, 255, .16);
        border-radius: 999px;
        background: rgba(255, 255, 255, .09);
        font-size: .62rem;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .gp-location-hero h2 {
        margin: 10px 0 4px;
        font-size: 1.4rem;
        font-weight: 850;
    }

    .gp-location-hero p {
        margin: 0;
        max-width: 800px;
        color: rgba(255, 255, 255, .76);
        font-size: .73rem;
        line-height: 1.5;
    }

    /* Main layout: full width, no narrow fixed columns */
    .gp-location-layout {
        display: grid;
        grid-template-columns: minmax(0, 430px) minmax(0, 1fr);
        gap: 18px;
        width: 100%;
        min-width: 0;
        align-items: start;
    }

    .gp-panel {
        width: 100%;
        min-width: 0;
        overflow: hidden;
        margin: 0;
        border: 1px solid var(--gp-border);
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 7px 24px rgba(20, 35, 60, .055);
    }

    .gp-panel-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        width: 100%;
        min-width: 0;
        padding: 14px 16px;
        border-bottom: 1px solid var(--gp-border);
        background: #FCFDFE;
    }

    .gp-heading {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }

    .gp-heading-icon {
        width: 38px;
        height: 38px;
        flex: 0 0 38px;
        display: grid;
        place-items: center;
        border: 1px solid #D6E5F4;
        border-radius: 10px;
        background: #EAF2FB;
        color: var(--gp-blue);
        font-size: .9rem;
    }

    .gp-heading h3 {
        margin: 0;
        color: var(--gp-text);
        font-size: .84rem;
        font-weight: 850;
    }

    .gp-heading small {
        display: block;
        margin-top: 2px;
        color: var(--gp-muted);
        font-size: .59rem;
        font-weight: 600;
    }

    .gp-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
        min-height: 28px;
        padding: 0 9px;
        border: 1px solid #DCE5EF;
        border-radius: 999px;
        background: #F5F8FC;
        color: var(--gp-blue);
        font-size: .59rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .gp-add-btn {
        min-height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        flex: 0 0 auto;
        padding: 0 12px;
        border: 1px solid #C5E5D3;
        border-radius: 9px;
        background: #F1FBF5;
        color: var(--gp-green-dark);
        font-size: .63rem;
        font-weight: 850;
        white-space: nowrap;
    }

    .gp-add-btn:hover {
        border-color: var(--gp-green);
        background: var(--gp-green);
        color: #fff;
    }

    .gp-panel-body {
        width: 100%;
        min-width: 0;
        padding: 15px;
    }

    /* Search */
    .gp-filter {
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(180px, .8fr) auto;
        gap: 8px;
        width: 100%;
        margin-bottom: 13px;
    }

    .gp-search,
    .gp-select-wrap {
        position: relative;
        min-width: 0;
    }

    .gp-search i,
    .gp-select-wrap i {
        position: absolute;
        left: 11px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 2;
        color: #8A96A8;
        font-size: .72rem;
        pointer-events: none;
    }

    .gp-control {
        width: 100% !important;
        min-width: 0;
        min-height: 39px;
        padding: .45rem .68rem .45rem 32px !important;
        border: 1px solid #D7E0EA !important;
        border-radius: 9px !important;
        background: #fff !important;
        color: var(--gp-text) !important;
        font-size: .68rem !important;
        font-weight: 600;
        box-shadow: none !important;
    }

    .gp-control:focus {
        border-color: var(--gp-blue) !important;
        box-shadow: 0 0 0 3px rgba(23, 75, 143, .08) !important;
    }

    select.gp-control {
        cursor: pointer;
    }

    .gp-filter-actions {
        display: flex;
        gap: 7px;
        min-width: 0;
    }

    .gp-filter-btn,
    .gp-reset-btn {
        min-height: 39px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        font-size: .65rem;
        font-weight: 800;
        text-decoration: none;
    }

    .gp-filter-btn {
        min-width: 88px;
        padding: 0 12px;
        border: 1px solid var(--gp-navy);
        background: var(--gp-navy);
        color: #fff;
    }

    .gp-filter-btn:hover {
        background: var(--gp-blue);
        color: #fff;
    }

    .gp-reset-btn {
        width: 39px;
        padding: 0;
        border: 1px solid #D8DEE8;
        background: #fff;
        color: #667085;
    }

    .gp-reset-btn:hover {
        border-color: #C0392B;
        color: #C0392B;
    }

    /* Tables */
    .gp-table-wrap {
        width: 100%;
        min-width: 0;
        overflow-x: auto;
        border: 1px solid var(--gp-border);
        border-radius: 11px;
    }

    .gp-table {
        width: 100%;
        min-width: 650px;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .gp-table th {
        padding: 11px 12px;
        border-bottom: 1px solid var(--gp-border);
        background: #F7F9FC;
        color: #657186;
        font-size: .59rem;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: .045em;
        white-space: nowrap;
    }

    .gp-table td {
        padding: 11px 12px;
        border-bottom: 1px solid #EDF1F5;
        color: var(--gp-text);
        font-size: .67rem;
        font-weight: 600;
        vertical-align: middle;
        white-space: nowrap;
    }

    .gp-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .gp-table tbody tr {
        transition: background .16s ease;
    }

    .gp-table tbody tr:hover {
        background: #FAFCFF;
    }

    .gp-name {
        display: flex;
        align-items: center;
        gap: 9px;
        min-width: 150px;
        font-weight: 800;
    }

    .gp-row-icon {
        width: 30px;
        height: 30px;
        flex: 0 0 30px;
        display: grid;
        place-items: center;
        border-radius: 8px;
        background: #EDF4FC;
        color: var(--gp-blue);
        font-size: .7rem;
    }

    .gp-name-text {
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .gp-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        min-height: 25px;
        padding: 0 8px;
        border: 1px solid transparent;
        border-radius: 999px;
        font-size: .58rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .gp-badge-blue {
        border-color: #D5E4F4;
        background: #EFF6FD;
        color: var(--gp-blue);
        text-decoration: none;
    }

    .gp-badge-green {
        border-color: #C9E7D5;
        background: #F0FAF4;
        color: var(--gp-green-dark);
    }

    .gp-badge-gray {
        border-color: #DFE4EA;
        background: #F7F8FA;
        color: #697586;
    }

    .gp-badge-gold {
        border-color: #F0DF9C;
        background: #FFF9DF;
        color: #866A00;
    }

    .gp-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 5px;
    }

    .gp-action {
        width: 31px;
        height: 31px;
        display: grid;
        place-items: center;
        padding: 0;
        border: 1px solid #D8E0EA;
        border-radius: 8px;
        background: #fff;
        font-size: .68rem;
    }

    .gp-edit {
        color: var(--gp-blue);
    }

    .gp-edit:hover {
        background: #EDF5FE;
        border-color: #BFD4E9;
    }

    .gp-delete {
        color: #C0392B;
    }

    .gp-delete:hover {
        background: #FFF5F4;
        border-color: #E8B8B3;
    }

    .gp-empty {
        padding: 38px 15px !important;
        text-align: center;
        color: #8A95A6 !important;
        white-space: normal !important;
    }

    .gp-empty-icon {
        width: 44px;
        height: 44px;
        margin: 0 auto 9px;
        display: grid;
        place-items: center;
        border-radius: 12px;
        background: #F3F6FA;
        color: #7A8799;
        font-size: 1rem;
    }

    .gp-pagination {
        display: flex;
        justify-content: center;
        width: 100%;
        margin-top: 14px;
        overflow-x: auto;
    }

    .gp-pagination nav {
        margin: 0 auto;
    }

    /* Modals */
    .gp-modal .modal-content {
        overflow: hidden;
        border: 1px solid var(--gp-border) !important;
        border-radius: 15px !important;
        box-shadow: 0 18px 50px rgba(10, 30, 60, .18) !important;
    }

    .gp-modal-head {
        padding: 15px 17px;
        border: 0;
        color: #fff;
        background: linear-gradient(135deg, var(--gp-navy-dark), var(--gp-blue));
    }

    .gp-modal-head h5 {
        margin: 0;
        font-size: .82rem;
        font-weight: 850;
    }

    .gp-modal-head small {
        display: block;
        margin-top: 3px;
        color: rgba(255, 255, 255, .68);
        font-size: .59rem;
    }

    .gp-modal-body {
        padding: 17px;
    }

    .gp-modal-label {
        display: block;
        margin-bottom: 6px;
        color: var(--gp-text);
        font-size: .66rem;
        font-weight: 800;
    }

    .gp-modal-control {
        width: 100%;
        min-height: 40px;
        border: 1px solid #D7E0EA !important;
        border-radius: 9px !important;
        font-size: .68rem !important;
        box-shadow: none !important;
    }

    .gp-modal-control:focus {
        border-color: var(--gp-blue) !important;
        box-shadow: 0 0 0 3px rgba(23, 75, 143, .08) !important;
    }

    .gp-check {
        display: flex;
        align-items: center;
        gap: 7px;
        color: #59677A;
        font-size: .65rem;
        font-weight: 650;
    }

    .gp-check input {
        margin: 0;
        accent-color: var(--gp-green);
    }

    .gp-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 7px;
        padding: 11px 17px;
        border-top: 1px solid var(--gp-border);
        background: #F8FAFC;
    }

    .gp-modal-btn {
        min-height: 37px;
        padding: 0 13px;
        border-radius: 9px;
        font-size: .64rem;
        font-weight: 800;
    }

    .gp-modal-cancel {
        border: 1px solid #D8DEE8;
        background: #fff;
        color: #59677A;
    }

    .gp-modal-save {
        border: 1px solid var(--gp-gold);
        background: var(--gp-gold);
        color: #172033;
    }

    .gp-modal-save:hover {
        background: #B78300;
        color: #fff;
    }

    /* Prevent admin layout from forcing this page narrow */
    @media (max-width:1199.98px) {
        .gp-location-layout {
            grid-template-columns: minmax(0, 1fr);
        }
    }

    @media (max-width:767.98px) {
        .gp-locations {
            padding-bottom: 18px;
        }

        .gp-location-hero {
            margin-bottom: 12px;
            padding: 18px 14px;
            border-radius: 13px;
        }

        .gp-location-hero h2 {
            font-size: 1.12rem;
        }

        .gp-location-hero p {
            font-size: .67rem;
        }

        .gp-location-layout {
            width: 100%;
            grid-template-columns: minmax(0, 1fr);
            gap: 12px;
        }

        .gp-panel {
            border-radius: 13px;
        }

        .gp-panel-head {
            padding: 11px 12px;
        }

        .gp-panel-body {
            padding: 10px;
        }

        .gp-heading {
            gap: 8px;
        }

        .gp-heading-icon {
            width: 34px;
            height: 34px;
            flex-basis: 34px;
        }

        .gp-heading h3 {
            font-size: .77rem;
        }

        .gp-heading small {
            font-size: .55rem;
        }

        .gp-add-btn {
            width: 35px;
            min-width: 35px;
            height: 35px;
            padding: 0;
        }

        .gp-add-btn span {
            display: none;
        }

        .gp-count {
            min-height: 24px;
            padding: 0 7px;
            font-size: .55rem;
        }

        .gp-filter {
            grid-template-columns: minmax(0, 1fr);
            gap: 7px;
        }

        .gp-filter-actions {
            width: 100%;
        }

        .gp-filter-btn {
            flex: 1 1 auto;
        }

        .gp-reset-btn {
            flex: 0 0 39px;
        }

        .gp-table-wrap {
            border-radius: 9px;
        }

        .gp-table {
            min-width: 620px;
        }

        .gp-table th,
        .gp-table td {
            padding: 9px 10px;
        }

        .gp-modal .modal-dialog {
            margin: 12px;
        }

        .gp-modal-body {
            padding: 14px;
        }

        .gp-modal-footer {
            padding: 10px 14px;
        }
    }

    @media (max-width:420px) {
        .gp-location-hero {
            padding: 16px 12px;
        }

        .gp-panel-head {
            padding: 10px;
        }

        .gp-panel-body {
            padding: 9px;
        }

        .gp-table {
            min-width: 600px;
        }
    }
</style>

<div class="gp-locations">

    <div class="gp-location-hero">
        <span class="gp-kicker"><i class="bi bi-geo-alt-fill"></i> Location Management</span>
        <h2>States & Cities</h2>
        <p>Manage your education location directory, keep states and cities organized, and highlight popular cities across GrowPec.</p>
    </div>

    <div class="gp-location-layout">
        <section class="gp-panel">
            <div class="gp-panel-head">
                <div class="gp-heading">
                    <span class="gp-heading-icon"><i class="bi bi-map-fill"></i></span>
                    <div>
                        <h3>States</h3>
                        <small>Manage registered states</small>
                    </div>
                </div>

                <div class="gp-heading" style="gap:7px;">
                    <span class="gp-count">{{ $states->count() }} States</span>
                    <button type="button"
                        class="gp-add-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#addStateModal">
                        <i class="bi bi-plus-circle-fill"></i>
                        <span>Add State</span>
                    </button>
                </div>
            </div>

            <div class="gp-panel-body">
                <div class="gp-table-wrap">
                    <table class="gp-table">
                        <thead>
                            <tr>
                                <th>State</th>
                                <th>Cities</th>
                                <th>Status</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($states as $st)
                            <tr>
                                <td>
                                    <div class="gp-name">
                                        <span class="gp-row-icon"><i class="bi bi-geo-alt"></i></span>
                                        <span class="gp-name-text">{{ $st->name }}</span>
                                    </div>
                                </td>

                                <td>
                                    <a href="{{ route('admin.locations.index', ['state_id' => $st->id]) }}"
                                        class="gp-badge gp-badge-blue"
                                        title="Filter cities by {{ $st->name }}">
                                        {{ $st->cities_count }} Cities
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </td>

                                <td>
                                    @if($st->status)
                                    <span class="gp-badge gp-badge-green">
                                        <i class="bi bi-check-circle-fill"></i> Active
                                    </span>
                                    @else
                                    <span class="gp-badge gp-badge-gray">
                                        <i class="bi bi-dash-circle"></i> Inactive
                                    </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="gp-actions">
                                        <button type="button"
                                            class="gp-action gp-edit edit-state-btn"
                                            data-id="{{ $st->id }}"
                                            data-name="{{ $st->name }}"
                                            data-status="{{ $st->status ? '1' : '0' }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editStateModal"
                                            title="Edit State">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <form action="{{ route('admin.locations.state.destroy', $st->id) }}"
                                            method="POST"
                                            style="margin:0;"
                                            onsubmit="return confirm('Delete state {{ $st->name }}?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="gp-action gp-delete"
                                                title="Delete State">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="gp-empty">
                                    <div class="gp-empty-icon"><i class="bi bi-map"></i></div>
                                    No states added yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <section class="gp-panel">
            <div class="gp-panel-head">
                <div class="gp-heading">
                    <span class="gp-heading-icon"><i class="bi bi-buildings-fill"></i></span>
                    <div>
                        <h3>Cities</h3>
                        <small>{{ $cities->total() }} total cities in directory</small>
                    </div>
                </div>

                <button type="button"
                    class="gp-add-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#addCityModal">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span>Add City</span>
                </button>
            </div>

            <div class="gp-panel-body">

                <form action="{{ route('admin.locations.index') }}" method="GET" class="gp-filter">
                    <div class="gp-search">
                        <i class="bi bi-search"></i>
                        <input type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control gp-control"
                            placeholder="Search city name..."
                            autocomplete="off">
                    </div>

                    <div class="gp-select-wrap">
                        <i class="bi bi-map"></i>
                        <select name="state_id" class="form-select gp-control" onchange="this.form.submit()">
                            <option value="">All States</option>
                            @foreach($states as $st)
                            <option value="{{ $st->id }}"
                                {{ request('state_id') == $st->id ? 'selected' : '' }}>
                                {{ $st->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="gp-filter-actions">
                        <button type="submit" class="gp-filter-btn">
                            <i class="bi bi-funnel-fill"></i>
                            Filter
                        </button>

                        @if(request('search') || request('state_id'))
                        <a href="{{ route('admin.locations.index') }}"
                            class="gp-reset-btn"
                            title="Reset Filters">
                            <i class="bi bi-x-lg"></i>
                        </a>
                        @endif
                    </div>
                </form>

                <div class="gp-table-wrap">
                    <table class="gp-table">
                        <thead>
                            <tr>
                                <th>City</th>
                                <th>Image</th>
                                <th>State</th>
                                <th>Popular</th>
                                <th>Status</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($cities as $ct)
                            <tr>
                                <td>
                                    <div class="gp-name">
                                        <span class="gp-name-text">{{ $ct->name }}</span>
                                    </div>
                                </td>

                                <td>
                                    @if($ct->image)
                                    <img src="{{ asset('storage/' . $ct->image) }}"
                                        alt="{{ $ct->name }}"
                                        style="width:48px;height:36px;object-fit:cover;border-radius:7px;border:1px solid #E1E8F0;">
                                    @else
                                    <span style="color:#A0A9B7;font-size:.68rem;">No image</span>
                                    @endif
                                </td>

                                <td>
                                    <span class="gp-badge gp-badge-gray">
                                        <i class="bi bi-geo-alt"></i>
                                        {{ $ct->state->name ?? 'N/A' }}
                                    </span>
                                </td>

                                <td>
                                    @if($ct->is_popular)
                                    <span class="gp-badge gp-badge-gold">
                                        <i class="bi bi-star-fill"></i> Popular
                                    </span>
                                    @else
                                    <span style="color:#A0A9B7;">—</span>
                                    @endif
                                </td>

                                <td>
                                    @if($ct->status)
                                    <span class="gp-badge gp-badge-green">
                                        <i class="bi bi-check-circle-fill"></i> Active
                                    </span>
                                    @else
                                    <span class="gp-badge gp-badge-gray">
                                        <i class="bi bi-dash-circle"></i> Inactive
                                    </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="gp-actions">
                                        <button type="button"
                                            class="gp-action gp-edit edit-city-btn"
                                            data-id="{{ $ct->id }}"
                                            data-name="{{ $ct->name }}"
                                            data-image="{{ $ct->image ? asset('storage/' . $ct->image) : '' }}"
                                            data-state-id="{{ $ct->state_id }}"
                                            data-popular="{{ $ct->is_popular ? '1' : '0' }}"
                                            data-status="{{ $ct->status ? '1' : '0' }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editCityModal"
                                            title="Edit City">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <form action="{{ route('admin.locations.city.destroy', $ct->id) }}"
                                            method="POST"
                                            style="margin:0;"
                                            onsubmit="return confirm('Delete city {{ $ct->name }}?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="gp-action gp-delete"
                                                title="Delete City">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="gp-empty">
                                    <div class="gp-empty-icon"><i class="bi bi-buildings"></i></div>
                                    No cities found matching your criteria.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="gp-pagination">
                    {{ $cities->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </section>

    </div>
</div>
<div class="modal fade gp-modal" id="addStateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="gp-modal-head">
                <h5><i class="bi bi-plus-circle-fill me-1"></i> Add New State</h5>
                <small>Add a state to the location directory</small>
            </div>

            <form action="{{ route('admin.locations.state.store') }}" method="POST">
                @csrf

                <div class="gp-modal-body">
                    <label class="gp-modal-label" for="addStateName">State Name *</label>
                    <input type="text"
                        id="addStateName"
                        name="name"
                        class="form-control gp-modal-control"
                        placeholder="e.g. Uttar Pradesh, Bihar"
                        required>
                </div>

                <div class="gp-modal-footer">
                    <button type="button" class="gp-modal-btn gp-modal-cancel" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="gp-modal-btn gp-modal-save">
                        Save State
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade gp-modal" id="editStateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="gp-modal-head">
                <h5><i class="bi bi-pencil-square me-1"></i> Edit State</h5>
                <small>Update state details and availability</small>
            </div>

            <form id="editStateForm" method="POST">
                @csrf
                @method('PUT')

                <div class="gp-modal-body">
                    <div class="mb-3">
                        <label class="gp-modal-label" for="editStateName">State Name *</label>
                        <input type="text"
                            name="name"
                            id="editStateName"
                            class="form-control gp-modal-control"
                            required>
                    </div>

                    <label class="gp-check">
                        <input type="checkbox"
                            name="status"
                            value="1"
                            id="editStateStatus">
                        Active State
                    </label>
                </div>

                <div class="gp-modal-footer">
                    <button type="button" class="gp-modal-btn gp-modal-cancel" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="gp-modal-btn gp-modal-save">
                        Update State
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade gp-modal" id="addCityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="gp-modal-head">
                <h5><i class="bi bi-plus-circle-fill me-1"></i> Add New City</h5>
                <small>Add a city and assign it to a state</small>
            </div>

            <form action="{{ route('admin.locations.city.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="gp-modal-body">
                    <div class="mb-3">
                        <label class="gp-modal-label" for="addCityState">Select State *</label>
                        <select name="state_id"
                            id="addCityState"
                            class="form-select gp-modal-control"
                            required>
                            <option value="">Choose State</option>
                            @foreach($states as $st)
                            <option value="{{ $st->id }}"
                                {{ request('state_id') == $st->id ? 'selected' : '' }}>
                                {{ $st->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="gp-modal-label" for="addCityImage">City Image</label>
                        <input type="file" name="image" id="addCityImage" class="form-control gp-modal-control" accept="image/jpeg,image/png,image/jpg,image/webp">
                        <small class="text-muted d-block mt-1">Required when Popular is selected. Max 4MB.</small>
                    </div>

                    <div class="mb-3">
                        <label class="gp-modal-label" for="addCityName">City Name *</label>
                        <input type="text"
                            name="name"
                            id="addCityName"
                            class="form-control gp-modal-control"
                            placeholder="e.g. Lucknow, Varanasi, Noida"
                            required>
                    </div>

                    <label class="gp-check">
                        <input type="checkbox"
                            name="is_popular"
                            value="1"
                            id="addCityPopular">
                        Mark as Popular City
                    </label>
                    <div id="addCityImagePreview" class="mt-2" style="display:none;"></div>
                </div>

                <div class="gp-modal-footer">
                    <button type="button" class="gp-modal-btn gp-modal-cancel" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="gp-modal-btn gp-modal-save">
                        Save City
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade gp-modal" id="editCityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="gp-modal-head">
                <h5><i class="bi bi-pencil-square me-1"></i> Edit City</h5>
                <small>Update city, state and visibility settings</small>
            </div>

            <form id="editCityForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="gp-modal-body">
                    <div class="mb-3">
                        <label class="gp-modal-label" for="editCityStateId">Select State *</label>
                        <select name="state_id"
                            id="editCityStateId"
                            class="form-select gp-modal-control"
                            required>
                            @foreach($states as $st)
                            <option value="{{ $st->id }}">{{ $st->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="gp-modal-label" for="editCityImage">City Image</label>
                        <input type="file" name="image" id="editCityImage" class="form-control gp-modal-control" accept="image/jpeg,image/png,image/jpg,image/webp">
                        <small id="editCityImageHint" class="text-muted d-block mt-1">Required when Popular is selected if no image exists.</small>
                        <div id="editCityImagePreview" class="mt-2"></div>
                    </div>

                    <div class="mb-3">
                        <label class="gp-modal-label" for="editCityName">City Name *</label>
                        <input type="text"
                            name="name"
                            id="editCityName"
                            class="form-control gp-modal-control"
                            required>
                    </div>

                    <div class="d-grid gap-2">
                        <label class="gp-check">
                            <input type="checkbox"
                                name="is_popular"
                                value="1"
                                id="editCityPopular">
                            Mark as Popular City
                        </label>

                        <label class="gp-check">
                            <input type="checkbox"
                                name="status"
                                value="1"
                                id="editCityStatus">
                            Active City
                        </label>
                    </div>
                </div>

                <div class="gp-modal-footer">
                    <button type="button" class="gp-modal-btn gp-modal-cancel" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="gp-modal-btn gp-modal-save">
                        Update City
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll('.edit-state-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const name = this.dataset.name;
                const status = this.dataset.status === '1';

                document.getElementById('editStateForm').action =
                    `/admin/locations/states/${id}`;

                document.getElementById('editStateName').value = name;
                document.getElementById('editStateStatus').checked = status;
            });
        });

        function toggleCityImageRequired(type) {
            const popular = document.getElementById(type === 'add' ? 'addCityPopular' : 'editCityPopular');
            const input = document.getElementById(type === 'add' ? 'addCityImage' : 'editCityImage');
            const hint = type === 'edit' ? document.getElementById('editCityImageHint') : null;
            if (!popular || !input) return;

            if (type === 'add') {
                input.required = popular.checked;
            } else {
                const hasExistingImage = document.getElementById('editCityImagePreview').querySelector('img') !== null;
                input.required = popular.checked && !hasExistingImage;
            }

            if (hint) {
                hint.textContent = popular.checked ?
                    (input.required ? 'Required because this city is popular. Max 4MB.' : 'Popular city. Upload a new image only if you want to replace it. Max 4MB.') :
                    'Optional. Image can be kept even when the city is not popular.';
            }
        }

        document.getElementById('addCityPopular')?.addEventListener('change', function() {
            toggleCityImageRequired('add');
        });

        document.getElementById('editCityPopular')?.addEventListener('change', function() {
            toggleCityImageRequired('edit');
        });

        document.getElementById('addCityImage')?.addEventListener('change', function() {
            const preview = document.getElementById('addCityImagePreview');
            if (this.files && this.files[0]) {
                preview.style.display = 'block';
                preview.innerHTML = `<img src="${URL.createObjectURL(this.files[0])}" alt="City image preview" style="width:90px;height:65px;object-fit:cover;border-radius:8px;border:1px solid #E1E8F0;">`;
            } else {
                preview.style.display = 'none';
                preview.innerHTML = '';
            }
        });

        document.querySelectorAll('.edit-city-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const name = this.dataset.name;
                const stateId = this.dataset.stateId;
                const image = this.dataset.image || '';
                const popular = this.dataset.popular === '1';
                const status = this.dataset.status === '1';

                document.getElementById('editCityForm').action =
                    `/admin/locations/cities/${id}`;

                document.getElementById('editCityName').value = name;
                document.getElementById('editCityStateId').value = stateId;
                document.getElementById('editCityPopular').checked = popular;

                const preview = document.getElementById('editCityImagePreview');
                preview.innerHTML = image ?
                    `<img src="${image}" alt="City image" style="width:90px;height:65px;object-fit:cover;border-radius:8px;border:1px solid #E1E8F0;">` :
                    '<span class="text-muted" style="font-size:.7rem;">No image uploaded</span>';

                toggleCityImageRequired('edit');
                document.getElementById('editCityStatus').checked = status;
            });
        });

    });
</script>
@endpush

@endsection