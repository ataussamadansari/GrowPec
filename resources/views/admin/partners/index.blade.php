@extends('admin.layout')

@section('title', 'Manage Partner Universities - GrowPec Admin')
@section('header', 'Partner Universities Marquee Strip')

@section('content')

<style>
    .gp-partners-page {
        --gp-navy:#002B67;
        --gp-navy-dark:#001B45;
        --gp-blue:#174B8F;
        --gp-green:#008A43;
        --gp-green-dark:#006B35;
        --gp-gold:#D9A400;
        --gp-border:#E1E8F0;
        --gp-text:#172033;
        --gp-muted:#718096;

        width:100%;
        max-width:none;
        min-width:0;
        padding:0 0 28px;
    }

    .gp-partners-page * {
        box-sizing:border-box;
    }

    .gp-partners-hero {
        position:relative;
        width:100%;
        min-width:0;
        overflow:hidden;
        margin-bottom:18px;
        padding:24px 26px;
        border-radius:17px;
        color:#fff;
        background:linear-gradient(135deg,var(--gp-navy-dark),var(--gp-navy) 58%,var(--gp-blue));
        box-shadow:0 12px 30px rgba(0,43,103,.14);
    }

    .gp-partners-hero:after {
        content:"";
        position:absolute;
        width:220px;
        height:220px;
        right:-90px;
        bottom:-135px;
        border:1px solid rgba(255,255,255,.14);
        border-radius:50%;
        box-shadow:0 0 0 30px rgba(255,255,255,.025);
    }

    .gp-partners-hero > * {
        position:relative;
        z-index:1;
    }

    .gp-kicker {
        display:inline-flex;
        align-items:center;
        gap:7px;
        padding:6px 10px;
        border:1px solid rgba(255,255,255,.16);
        border-radius:999px;
        background:rgba(255,255,255,.09);
        font-size:.62rem;
        font-weight:800;
        letter-spacing:.08em;
        text-transform:uppercase;
    }

    .gp-partners-hero h2 {
        margin:10px 0 4px;
        font-size:1.42rem;
        font-weight:850;
    }

    .gp-partners-hero p {
        max-width:850px;
        margin:0;
        color:rgba(255,255,255,.76);
        font-size:.73rem;
        line-height:1.5;
    }

    .gp-partners-card {
        width:100%;
        min-width:0;
        overflow:hidden;
        border:1px solid var(--gp-border);
        border-radius:16px;
        background:#fff;
        box-shadow:0 8px 25px rgba(20,35,60,.055);
    }

    .gp-card-head {
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:14px;
        width:100%;
        min-width:0;
        padding:15px 18px;
        border-bottom:1px solid var(--gp-border);
        background:#FCFDFE;
    }

    .gp-card-heading {
        display:flex;
        align-items:center;
        gap:10px;
        min-width:0;
    }

    .gp-card-icon {
        width:39px;
        height:39px;
        flex:0 0 39px;
        display:grid;
        place-items:center;
        border:1px solid #D7E5F4;
        border-radius:10px;
        background:#EAF2FB;
        color:var(--gp-blue);
        font-size:.9rem;
    }

    .gp-card-title {
        margin:0;
        color:var(--gp-text);
        font-size:.86rem;
        font-weight:850;
    }

    .gp-card-subtitle {
        display:block;
        margin-top:2px;
        color:var(--gp-muted);
        font-size:.6rem;
        font-weight:600;
        line-height:1.4;
    }

    .gp-card-count {
        display:inline-flex;
        align-items:center;
        justify-content:center;
        min-height:28px;
        padding:0 10px;
        border:1px solid #DCE5EF;
        border-radius:999px;
        background:#F5F8FC;
        color:var(--gp-blue);
        font-size:.59rem;
        font-weight:800;
        white-space:nowrap;
    }

    .gp-card-body {
        width:100%;
        min-width:0;
        padding:17px;
    }

    .gp-toolbar {
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:10px;
        margin-bottom:14px;
        padding:11px 12px;
        border:1px solid #E5EBF2;
        border-radius:11px;
        background:#F8FAFC;
    }

    .gp-toolbar-info {
        display:flex;
        align-items:center;
        gap:8px;
        min-width:0;
        color:#657186;
        font-size:.63rem;
        font-weight:650;
    }

    .gp-toolbar-info i {
        color:var(--gp-green);
        font-size:.78rem;
    }

    .gp-toolbar-actions {
        display:flex;
        align-items:center;
        gap:7px;
        flex:0 0 auto;
    }

    .gp-btn {
        min-height:36px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:6px;
        padding:0 12px;
        border-radius:9px;
        font-size:.62rem;
        font-weight:850;
        text-decoration:none;
        white-space:nowrap;
    }

    .gp-btn-settings {
        border:1px solid #D5DDE7;
        background:#fff;
        color:#526176;
    }

    .gp-btn-settings:hover {
        border-color:var(--gp-blue);
        color:var(--gp-blue);
        background:#F5F9FD;
    }

    .gp-btn-add {
        border:1px solid var(--gp-gold);
        background:var(--gp-gold);
        color:#172033;
    }

    .gp-btn-add:hover {
        border-color:#B78300;
        background:#B78300;
        color:#fff;
    }

    .gp-table-wrap {
        width:100%;
        min-width:0;
        overflow-x:auto;
        border:1px solid var(--gp-border);
        border-radius:11px;
    }

    .gp-table {
        width:100%;
        min-width:720px;
        margin:0;
        border-collapse:separate;
        border-spacing:0;
    }

    .gp-table th {
        padding:11px 13px;
        border-bottom:1px solid var(--gp-border);
        background:#F7F9FC;
        color:#657186;
        font-size:.58rem;
        font-weight:850;
        letter-spacing:.045em;
        text-transform:uppercase;
        white-space:nowrap;
    }

    .gp-table td {
        padding:12px 13px;
        border-bottom:1px solid #EDF1F5;
        color:var(--gp-text);
        font-size:.67rem;
        font-weight:600;
        vertical-align:middle;
        white-space:nowrap;
    }

    .gp-table tbody tr:last-child td {
        border-bottom:0;
    }

    .gp-table tbody tr {
        transition:background .16s ease;
    }

    .gp-table tbody tr:hover {
        background:#FAFCFF;
    }

    .gp-logo-cell {
        width:64px;
    }

    .gp-logo-box {
        width:55px;
        height:48px;
        display:grid;
        place-items:center;
        padding:5px;
        overflow:hidden;
        border:1px solid #DCE4ED;
        border-radius:9px;
        background:#fff;
    }

    .gp-logo-box img {
        width:100%;
        height:100%;
        object-fit:contain;
    }

    .gp-university {
        display:flex;
        align-items:center;
        gap:10px;
        min-width:230px;
    }

    .gp-university-name {
        max-width:420px;
        overflow:hidden;
        text-overflow:ellipsis;
        color:var(--gp-text);
        font-size:.69rem;
        font-weight:850;
    }

    .gp-date {
        display:block;
        margin-top:3px;
        color:#8A95A6;
        font-size:.56rem;
        font-weight:600;
    }

    .gp-sort {
        display:inline-flex;
        align-items:center;
        gap:5px;
        min-height:27px;
        padding:0 9px;
        border:1px solid #DDE4EC;
        border-radius:999px;
        background:#F7F9FC;
        color:#526176;
        font-size:.58rem;
        font-weight:800;
    }

    .gp-sort i {
        color:var(--gp-blue);
    }

    .gp-status {
        display:inline-flex;
        align-items:center;
        gap:5px;
        min-height:27px;
        padding:0 9px;
        border-radius:999px;
        font-size:.57rem;
        font-weight:850;
    }

    .gp-status-active {
        border:1px solid #C7E7D3;
        background:#F0FAF4;
        color:var(--gp-green-dark);
    }

    .gp-status-hidden {
        border:1px solid #DFE4EA;
        background:#F6F7F9;
        color:#697586;
    }

    .gp-actions {
        display:flex;
        align-items:center;
        justify-content:flex-end;
        gap:5px;
    }

    .gp-action {
        width:32px;
        height:32px;
        display:grid;
        place-items:center;
        padding:0;
        border:1px solid #D8E0EA;
        border-radius:8px;
        background:#fff;
        font-size:.68rem;
        transition:all .16s ease;
    }

    .gp-edit {
        color:var(--gp-blue);
    }

    .gp-edit:hover {
        border-color:#BFD5EB;
        background:#EDF5FE;
        color:var(--gp-blue);
    }

    .gp-delete {
        color:#C0392B;
    }

    .gp-delete:hover {
        border-color:#E8B8B3;
        background:#FFF5F4;
        color:#C0392B;
    }

    .gp-empty {
        padding:50px 15px !important;
        text-align:center;
        white-space:normal !important;
        color:#8A95A6 !important;
    }

    .gp-empty-icon {
        width:48px;
        height:48px;
        margin:0 auto 10px;
        display:grid;
        place-items:center;
        border-radius:13px;
        background:#F2F5F9;
        color:#778497;
        font-size:1rem;
    }

    .gp-pagination {
        display:flex;
        justify-content:center;
        width:100%;
        margin-top:15px;
        overflow-x:auto;
    }

    .gp-pagination nav {
        margin:0 auto;
    }

    @media (max-width:991.98px) {
        .gp-toolbar {
            align-items:stretch;
            flex-direction:column;
        }

        .gp-toolbar-actions {
            width:100%;
        }

        .gp-toolbar-actions .gp-btn {
            flex:1 1 0;
        }
    }

    @media (max-width:767.98px) {
        .gp-partners-page {
            padding-bottom:18px;
        }

        .gp-partners-hero {
            margin-bottom:12px;
            padding:18px 14px;
            border-radius:13px;
        }

        .gp-partners-hero h2 {
            font-size:1.12rem;
        }

        .gp-partners-hero p {
            font-size:.67rem;
        }

        .gp-partners-card {
            border-radius:13px;
        }

        .gp-card-head {
            padding:11px 12px;
        }

        .gp-card-body {
            padding:10px;
        }

        .gp-card-icon {
            width:34px;
            height:34px;
            flex-basis:34px;
        }

        .gp-card-title {
            font-size:.77rem;
        }

        .gp-card-subtitle {
            font-size:.55rem;
        }

        .gp-card-count {
            min-height:25px;
            padding:0 7px;
            font-size:.54rem;
        }

        .gp-toolbar {
            margin-bottom:10px;
            padding:9px;
        }

        .gp-toolbar-info {
            font-size:.59rem;
            line-height:1.4;
        }

        .gp-btn {
            min-height:37px;
            font-size:.59rem;
        }

        .gp-table {
            min-width:690px;
        }

        .gp-table th,
        .gp-table td {
            padding:9px 10px;
        }
    }

    @media (max-width:480px) {
        .gp-partners-hero {
            padding:16px 12px;
        }

        .gp-card-head {
            padding:10px;
        }

        .gp-card-body {
            padding:9px;
        }

        .gp-toolbar-actions {
            gap:6px;
        }

        .gp-btn {
            padding:0 9px;
        }

        .gp-table {
            min-width:650px;
        }
    }
</style>

<div class="gp-partners-page">

    <div class="gp-partners-hero">
        <span class="gp-kicker">
            <i class="bi bi-award-fill"></i>
            Partner Management
        </span>

        <h2>Partner Universities</h2>

        <p>
            Manage the university logos and names displayed in the GrowPec homepage marquee strip.
            Control visibility, ordering and partner information from one place.
        </p>
    </div>

    <section class="gp-partners-card">

        <div class="gp-card-head">
            <div class="gp-card-heading">
                <span class="gp-card-icon">
                    <i class="bi bi-building-check"></i>
                </span>

                <div>
                    <h3 class="gp-card-title">Partner Universities List</h3>
                    <small class="gp-card-subtitle">
                        Universities shown in the homepage partner strip
                    </small>
                </div>
            </div>

            <span class="gp-card-count">
                {{ $partners->total() }} Partners
            </span>
        </div>

        <div class="gp-card-body">

            <div class="gp-toolbar">
                <div class="gp-toolbar-info">
                    <i class="bi bi-info-circle-fill"></i>
                    <span>Use sort order to control the sequence of logos in the homepage marquee.</span>
                </div>

                <div class="gp-toolbar-actions">
                    <a href="{{ route('admin.settings.index') }}" class="gp-btn gp-btn-settings">
                        <i class="bi bi-sliders"></i>
                        Section Settings
                    </a>

                    <a href="{{ route('admin.partners.create') }}" class="gp-btn gp-btn-add">
                        <i class="bi bi-plus-circle-fill"></i>
                        Add Partner
                    </a>
                </div>
            </div>

            <div class="gp-table-wrap">
                <table class="gp-table">
                    <thead>
                        <tr>
                            <th class="gp-logo-cell">Logo</th>
                            <th>University / Partner</th>
                            <th>Sort Order</th>
                            <th>Status</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($partners as $partner)
                            <tr>
                                <td class="gp-logo-cell">
                                    <div class="gp-logo-box">
                                        <img src="{{ $partner->logo_url }}"
                                             alt="{{ $partner->name }}"
                                             loading="lazy">
                                    </div>
                                </td>

                                <td>
                                    <div class="gp-university">
                                        <span class="gp-university-name">
                                            {{ $partner->name }}
                                        </span>
                                    </div>

                                    <small class="gp-date">
                                        Added {{ $partner->created_at->format('d M Y') }}
                                    </small>
                                </td>

                                <td>
                                    <span class="gp-sort">
                                        <i class="bi bi-arrow-down-up"></i>
                                        #{{ $partner->sort_order }}
                                    </span>
                                </td>

                                <td>
                                    @if($partner->status)
                                        <span class="gp-status gp-status-active">
                                            <i class="bi bi-check-circle-fill"></i>
                                            Active
                                        </span>
                                    @else
                                        <span class="gp-status gp-status-hidden">
                                            <i class="bi bi-eye-slash-fill"></i>
                                            Hidden
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="gp-actions">
                                        <a href="{{ route('admin.partners.edit', $partner->id) }}"
                                           class="gp-action gp-edit"
                                           title="Edit Partner"
                                           aria-label="Edit Partner">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('admin.partners.destroy', $partner->id) }}"
                                              method="POST"
                                              style="margin:0;"
                                              onsubmit="return confirm('Delete this partner university?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="gp-action gp-delete"
                                                    title="Delete Partner"
                                                    aria-label="Delete Partner">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="gp-empty">
                                    <div class="gp-empty-icon">
                                        <i class="bi bi-building-x"></i>
                                    </div>
                                    No partner universities added yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($partners->hasPages())
                <div class="gp-pagination">
                    {{ $partners->links('pagination::bootstrap-5') }}
                </div>
            @endif

        </div>
    </section>

</div>

@endsection
