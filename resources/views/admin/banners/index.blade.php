@extends('admin.layout')

@section('title', 'Manage Banners - GrowPec Admin')
@section('header', 'Homepage Banners')

@section('content')

<style>
    .gp-banner-page {
        --gp-navy: #002B67;
        --gp-navy-dark: #001B45;
        --gp-blue: #174B8F;
        --gp-green: #008A43;
        --gp-green-dark: #006B35;
        --gp-gold: #D9A400;
        --gp-gold-dark: #B78300;
        --gp-bg: #F5F7FA;
        --gp-border: #DCE5EF;
        --gp-text: #172033;
        --gp-muted: #718096;
        width: 100%;
        max-width: none;
        min-width: 0;
        color: var(--gp-text);
    }

    .gp-banner-page,
    .gp-banner-page * {
        box-sizing: border-box;
    }

    .gp-banner-hero {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        width: 100%;
        margin-bottom: 20px;
        padding: 25px 28px;
        border-radius: 20px;
        background: linear-gradient(135deg, var(--gp-navy-dark), var(--gp-navy) 58%, var(--gp-blue));
        color: #fff;
        box-shadow: 0 16px 34px rgba(0, 43, 103, .13);
    }

    .gp-banner-hero::before,
    .gp-banner-hero::after {
        content: "";
        position: absolute;
        pointer-events: none;
        border: 1px solid rgba(255,255,255,.13);
        border-radius: 50%;
    }

    .gp-banner-hero::before {
        width: 280px;
        height: 280px;
        right: -105px;
        bottom: -195px;
        box-shadow:
            0 0 0 28px rgba(255,255,255,.025),
            0 0 0 56px rgba(255,255,255,.018);
    }

    .gp-banner-hero::after {
        width: 165px;
        height: 165px;
        right: -60px;
        bottom: -105px;
    }

    .gp-banner-hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .gp-banner-kicker {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        min-height: 30px;
        padding: 6px 12px;
        border: 1px solid rgba(255,255,255,.18);
        border-radius: 999px;
        background: rgba(255,255,255,.08);
        color: rgba(255,255,255,.94);
        font-size: .62rem;
        font-weight: 850;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .gp-banner-hero h2 {
        margin: 11px 0 5px;
        font-size: 1.42rem;
        line-height: 1.18;
        font-weight: 850;
        letter-spacing: -.03em;
    }

    .gp-banner-hero p {
        max-width: 760px;
        margin: 0;
        color: rgba(255,255,255,.76);
        font-size: .74rem;
        line-height: 1.6;
    }

    .gp-upload-btn {
        position: relative;
        z-index: 2;
        flex: 0 0 auto;
        min-height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 0 17px;
        border: 1px solid var(--gp-gold);
        border-radius: 11px;
        background: linear-gradient(135deg, #E0AB00, #C79200);
        color: #172033;
        font-size: .69rem;
        font-weight: 850;
        text-decoration: none;
        box-shadow: 0 7px 16px rgba(217,164,0,.22);
        transition: all .18s ease;
        white-space: nowrap;
    }

    .gp-upload-btn:hover {
        color: #fff;
        background: linear-gradient(135deg, #C79200, #B78300);
        border-color: var(--gp-gold-dark);
        transform: translateY(-1px);
        box-shadow: 0 9px 20px rgba(183,131,0,.24);
    }

    .gp-banner-card {
        width: 100%;
        min-width: 0;
        overflow: hidden;
        border: 1px solid var(--gp-border);
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 10px 30px rgba(20,35,60,.055);
    }

    .gp-banner-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 16px 19px;
        border-bottom: 1px solid var(--gp-border);
    }

    .gp-banner-heading {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        min-width: 0;
    }

    .gp-banner-heading-icon {
        flex: 0 0 40px;
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        background: #EEF5FC;
        color: var(--gp-blue);
        font-size: 1rem;
    }

    .gp-banner-heading h5 {
        margin: 0;
        color: var(--gp-navy);
        font-size: .94rem;
        line-height: 1.35;
        font-weight: 850;
    }

    .gp-banner-heading small {
        display: block;
        margin-top: 3px;
        color: var(--gp-muted);
        font-size: .65rem;
        line-height: 1.5;
    }

    .gp-banner-count {
        flex: 0 0 auto;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        min-height: 31px;
        padding: 5px 10px;
        border: 1px solid #D8E6F3;
        border-radius: 999px;
        background: #F7FAFD;
        color: var(--gp-navy);
        font-size: .62rem;
        font-weight: 800;
    }

    .gp-banner-table-wrap {
        width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
    }

    .gp-banner-table {
        width: 100%;
        min-width: 760px;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .gp-banner-table thead th {
        padding: 13px 16px;
        border-bottom: 1px solid var(--gp-border);
        background: #F8FAFC;
        color: #65748A;
        font-size: .59rem;
        font-weight: 850;
        letter-spacing: .04em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .gp-banner-table tbody td {
        padding: 15px 16px;
        border-bottom: 1px solid #EDF1F5;
        vertical-align: middle;
        background: #fff;
    }

    .gp-banner-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .gp-banner-table tbody tr {
        transition: background .16s ease;
    }

    .gp-banner-table tbody tr:hover td {
        background: #FBFDFF;
    }

    .gp-banner-preview {
        width: 156px;
        height: 70px;
        overflow: hidden;
        border: 1px solid #D8E2EC;
        border-radius: 10px;
        background: #F4F7FA;
        box-shadow: 0 4px 12px rgba(20,35,60,.06);
    }

    .gp-banner-preview img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .gp-banner-title {
        color: var(--gp-text);
        font-size: .72rem;
        line-height: 1.45;
        font-weight: 800;
    }

    .gp-banner-date {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 4px;
        color: #8793A4;
        font-size: .61rem;
    }

    .gp-order-badge,
    .gp-status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 31px;
        border-radius: 9px;
        font-size: .62rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .gp-order-badge {
        padding: 5px 10px;
        border: 1px solid #DCE5EF;
        background: #F8FAFC;
        color: #4D5B70;
    }

    .gp-status-badge {
        gap: 6px;
        padding: 5px 10px;
    }

    .gp-status-active {
        border: 1px solid #BDE4D0;
        background: #ECF9F2;
        color: #08713B;
    }

    .gp-status-inactive {
        border: 1px solid #D9DEE6;
        background: #F3F5F7;
        color: #687386;
    }

    .gp-status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .gp-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 7px;
    }

    .gp-action-btn {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid;
        border-radius: 9px;
        background: #fff;
        font-size: .82rem;
        text-decoration: none;
        transition: all .17s ease;
        cursor: pointer;
    }

    .gp-edit-btn {
        border-color: #BCD2E8;
        color: var(--gp-blue);
    }

    .gp-edit-btn:hover {
        border-color: var(--gp-blue);
        background: var(--gp-blue);
        color: #fff;
        transform: translateY(-1px);
    }

    .gp-delete-btn {
        border-color: #F0C7CC;
        color: #C33B48;
    }

    .gp-delete-btn:hover {
        border-color: #C33B48;
        background: #C33B48;
        color: #fff;
        transform: translateY(-1px);
    }

    .gp-empty-state {
        padding: 55px 20px !important;
        text-align: center;
    }

    .gp-empty-icon {
        width: 62px;
        height: 62px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        border-radius: 17px;
        background: #EEF5FC;
        color: var(--gp-blue);
        font-size: 1.35rem;
    }

    .gp-empty-state strong {
        display: block;
        color: var(--gp-text);
        font-size: .78rem;
    }

    .gp-empty-state span {
        display: block;
        margin-top: 4px;
        color: var(--gp-muted);
        font-size: .64rem;
    }

    .gp-pagination {
        display: flex;
        justify-content: center;
        padding: 17px 20px;
        border-top: 1px solid var(--gp-border);
    }

    .gp-pagination .pagination {
        margin: 0;
    }

    .gp-pagination .page-link {
        min-width: 34px;
        min-height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-color: #DCE5EF;
        color: var(--gp-navy);
        font-size: .64rem;
        font-weight: 750;
    }

    .gp-pagination .page-item.active .page-link {
        border-color: var(--gp-navy);
        background: var(--gp-navy);
        color: #fff;
    }

    .gp-pagination .page-link:hover {
        background: #EEF5FC;
        color: var(--gp-navy);
    }


    .gp-banner-table tbody td:first-child {
        padding-left: 19px;
    }

    .gp-banner-table tbody td:last-child {
        padding-right: 19px;
    }

    .gp-banner-table tbody tr {
        position: relative;
    }

    .gp-banner-title {
        max-width: 320px;
        overflow-wrap: anywhere;
    }

    .gp-banner-table tbody tr:hover .gp-banner-preview {
        border-color: #BFD3E7;
        box-shadow: 0 7px 18px rgba(23,75,143,.10);
        transform: translateY(-1px);
    }

    .gp-banner-preview {
        transition: all .18s ease;
    }

    .gp-upload-btn i,
    .gp-action-btn i {
        line-height: 1;
    }

    .gp-banner-count {
        box-shadow: inset 0 1px 0 rgba(255,255,255,.75);
    }

    .gp-pagination nav {
        margin: 0;
    }

    .gp-pagination .page-item:first-child .page-link,
    .gp-pagination .page-item:last-child .page-link {
        border-radius: 8px;
    }

    @media (min-width: 1200px) {
        .gp-banner-page {
            padding-bottom: 10px;
        }

        .gp-banner-table thead th {
            padding-top: 12px;
            padding-bottom: 12px;
        }

        .gp-banner-table tbody td {
            padding-top: 13px;
            padding-bottom: 13px;
        }
    }

    @media (max-width: 991.98px) {
        .gp-banner-hero {
            padding: 23px;
        }

        .gp-banner-hero-content {
            align-items: flex-start;
            flex-direction: column;
        }

        .gp-upload-btn {
            width: auto;
        }

        .gp-banner-toolbar {
            padding: 15px 17px;
        }
    }

    @media (max-width: 767.98px) {
        .gp-banner-hero {
            margin-bottom: 13px;
            padding: 19px 16px;
            border-radius: 15px;
        }

        .gp-banner-hero h2 {
            font-size: 1.18rem;
        }

        .gp-banner-hero p {
            font-size: .66rem;
        }

        .gp-upload-btn {
            width: 100%;
            min-height: 43px;
        }

        .gp-banner-card {
            border-radius: 14px;
        }

        .gp-banner-toolbar {
            align-items: flex-start;
            flex-direction: column;
            gap: 11px;
            padding: 14px;
        }

        .gp-banner-heading {
            width: 100%;
        }

        .gp-banner-count {
            align-self: flex-start;
        }

        .gp-banner-heading-icon {
            flex-basis: 36px;
            width: 36px;
            height: 36px;
        }

        .gp-banner-heading h5 {
            font-size: .84rem;
        }

        .gp-banner-heading small {
            font-size: .61rem;
        }

        .gp-banner-table {
            min-width: 690px;
        }

        .gp-banner-table thead th,
        .gp-banner-table tbody td {
            padding: 12px 13px;
        }

        .gp-banner-preview {
            width: 135px;
            height: 63px;
        }

        .gp-pagination {
            padding: 13px 10px;
            overflow-x: auto;
            justify-content: flex-start;
        }
    }

    @media (max-width: 480px) {
        .gp-banner-hero {
            padding: 16px 13px;
        }

        .gp-banner-hero h2 {
            font-size: 1.05rem;
        }

        .gp-banner-hero p {
            font-size: .61rem;
        }

        .gp-banner-heading small {
            max-width: 270px;
        }

        .gp-banner-table {
            min-width: 650px;
        }

        .gp-banner-preview {
            width: 118px;
            height: 57px;
        }

        .gp-action-btn {
            width: 35px;
            height: 35px;
        }
    }
</style>

<div class="gp-banner-page">

    <div class="gp-banner-hero">
        <div class="gp-banner-hero-content">
            <div>
                <span class="gp-banner-kicker">
                    <i class="bi bi-images"></i>
                    GrowPec Control Center
                </span>

                <h2>Homepage Banner Management</h2>

                <p>
                    Manage your homepage hero banners, display order and visibility
                    from one clean responsive control panel.
                </p>
            </div>

            <a href="{{ route('admin.banners.create') }}" class="gp-upload-btn">
                <i class="bi bi-cloud-arrow-up-fill"></i>
                Upload Banner
            </a>
        </div>
    </div>

    <div class="gp-banner-card">

        <div class="gp-banner-toolbar">
            <div class="gp-banner-heading">
                <span class="gp-banner-heading-icon">
                    <i class="bi bi-image-fill"></i>
                </span>

                <div>
                    <h5>Banners List</h5>
                    <small>
                        Manage background images, display order and active status.
                    </small>
                </div>
            </div>

            <span class="gp-banner-count">
                <i class="bi bi-collection"></i>
                {{ $banners->total() }} {{ $banners->total() == 1 ? 'Banner' : 'Banners' }}
            </span>
        </div>

        <div class="gp-banner-table-wrap">
            <table class="gp-banner-table align-middle">
                <thead>
                    <tr>
                        <th>Image Preview</th>
                        <th>Banner Name / Title</th>
                        <th>Order Index</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($banners as $banner)
                        <tr>
                            <td>
                                <div class="gp-banner-preview">
                                    <img
                                        src="{{ $banner->image_url }}"
                                        alt="{{ $banner->title ?: 'Hero Banner #' . $banner->id }}"
                                        loading="lazy"
                                    >
                                </div>
                            </td>

                            <td>
                                <div class="gp-banner-title">
                                    {{ $banner->title ?: 'Hero Banner #' . $banner->id }}
                                </div>

                                <span class="gp-banner-date">
                                    <i class="bi bi-calendar3"></i>
                                    {{ $banner->created_at->format('d M Y') }}
                                </span>
                            </td>

                            <td>
                                <span class="gp-order-badge">
                                    <i class="bi bi-list-ol me-1"></i>
                                    Index: {{ $banner->sort_order }}
                                </span>
                            </td>

                            <td>
                                @if($banner->status)
                                    <span class="gp-status-badge gp-status-active">
                                        <span class="gp-status-dot"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="gp-status-badge gp-status-inactive">
                                        <span class="gp-status-dot"></span>
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="gp-actions">
                                    <a
                                        href="{{ route('admin.banners.edit', $banner->id) }}"
                                        class="gp-action-btn gp-edit-btn"
                                        title="Edit Banner"
                                        aria-label="Edit Banner"
                                    >
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    <form
                                        action="{{ route('admin.banners.destroy', $banner->id) }}"
                                        method="POST"
                                        class="m-0"
                                        onsubmit="return confirm('Delete this banner?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="gp-action-btn gp-delete-btn"
                                            title="Delete Banner"
                                            aria-label="Delete Banner"
                                        >
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="gp-empty-state">
                                <span class="gp-empty-icon">
                                    <i class="bi bi-images"></i>
                                </span>

                                <strong>No banners uploaded yet</strong>

                                <span>
                                    Default theme image will remain active until you upload a banner.
                                </span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($banners->hasPages())
            <div class="gp-pagination">
                {{ $banners->links('pagination::bootstrap-5') }}
            </div>
        @endif

    </div>
</div>

@endsection
