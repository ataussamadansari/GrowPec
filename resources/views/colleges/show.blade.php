@extends('layouts.app')

@section('title', ($college->seo_title ?? $college->name . ' — Admission 2025, Courses, Fees, Placements & Brochure') . ' | GrowPec')

@push('styles')
<style>
    /* ═══════════════════════════════════════════════════════════════════
   COLLEGE DETAIL PAGE — GrowPec Design System
   Responsive: 4K · Desktop · Laptop · Tablet · Mobile
═══════════════════════════════════════════════════════════════════ */

    :root {
        --navy: #002B67;
        --navy-dark: #001B45;
        --green: #008A43;
        --green-dk: #005C32;
        --gold: #D9A400;
        --gold-dk: #B78300;
        --purple-bg: #EEF4F8;
        --border: #E2E8F0;
        --text: #1E293B;
        --muted: #64748B;
        --radius-lg: 18px;
        --radius-md: 12px;
        --radius-sm: 8px;
        --shadow-sm: 0 2px 8px rgba(0, 43, 103, .05);
        --shadow-md: 0 6px 24px rgba(0, 43, 103, .09);
        --shadow-lg: 0 12px 40px rgba(0, 43, 103, .12);
    }

    /* ── Reset helpers ── */
    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    /* ─────────────────────────────────────────
   1. HERO SECTION
───────────────────────────────────────── */
    .c-hero {
        background: #fff;
        border-bottom: 1px solid var(--border);
        padding: 24px 0 32px;
    }

    /* Banner */
    .c-banner {
        position: relative;
        width: 100%;
        height: 320px;
        border-radius: var(--radius-lg);
        overflow: hidden;
        background: #000;
        box-shadow: var(--shadow-md);
    }

    .c-banner__img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .c-banner__logo {
        position: absolute;
        top: 16px;
        left: 16px;
        z-index: 10;
        width: 72px;
        height: 72px;
        background: #fff;
        border-radius: 14px;
        padding: 6px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, .2);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .c-banner__logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 10px;
    }

    .c-banner__mode-badge {
        position: absolute;
        bottom: 14px;
        right: 14px;
        z-index: 10;
        padding: 5px 14px;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 800;
        letter-spacing: .04em;
        text-transform: uppercase;
        backdrop-filter: blur(8px);
    }

    .c-banner__mode-badge.regular {
        background: rgba(0, 43, 103, .82);
        color: #fff;
    }

    .c-banner__mode-badge.online {
        background: rgba(0, 138, 67, .85);
        color: #fff;
    }

    /* College title block */
    .c-title {
        font-size: 1.65rem;
        font-weight: 800;
        color: var(--navy);
        line-height: 1.3;
    }

    .c-subtitle {
        color: var(--muted);
        font-size: .88rem;
    }

    /* Badges row */
    .c-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 11px;
        border-radius: 999px;
        font-size: .7rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .c-badge--blue {
        background: #EAF1F8;
        color: var(--navy);
        border: 1px solid #C8D9EC;
    }

    .c-badge--green {
        background: #E6F8EF;
        color: var(--green-dk);
        border: 1px solid #B6DFC7;
    }

    .c-badge--gold {
        background: #FFF8E1;
        color: #7A5800;
        border: 1px solid #F5DFA0;
    }

    .c-badge--dark {
        background: #F1F3F6;
        color: #334155;
        border: 1px solid var(--border);
    }

    .c-badge--naac {
        background: #E8F6EF;
        color: var(--green-dk);
        border: 1px solid #B6DFC7;
        font-size: .68rem;
    }

    .c-badge--star {
        background: #fff;
        color: #334155;
        border: 1px solid var(--border);
    }

    /* CTA Buttons */
    .c-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 22px;
        border-radius: 25px;
        border: none;
        font-weight: 700;
        font-size: .86rem;
        text-decoration: none;
        transition: all .2s ease;
        cursor: pointer;
        white-space: nowrap;
    }

    .c-btn--navy {
        background: var(--navy);
        color: #fff;
    }

    .c-btn--navy:hover {
        background: var(--navy-dark);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(0, 43, 103, .3);
    }

    .c-btn--gold {
        background: var(--gold);
        color: #1a1200;
    }

    .c-btn--gold:hover {
        background: var(--gold-dk);
        color: #1a1200;
        transform: translateY(-1px);
    }

    .c-btn--green {
        background: var(--green);
        color: #fff;
    }

    .c-btn--green:hover {
        background: var(--green-dk);
        color: #fff;
        transform: translateY(-1px);
    }

    .c-btn--outline {
        background: #fff;
        color: var(--navy);
        border: 1.5px solid var(--navy);
    }

    .c-btn--outline:hover {
        background: var(--navy);
        color: #fff;
    }

    .c-btn--sm {
        padding: 6px 16px;
        font-size: .78rem;
    }

    /* Admission card (right sticky) */
    .c-admission-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 22px;
        box-shadow: var(--shadow-lg);
        padding: 24px 22px;
    }

    .c-form-field {
        border-radius: 22px !important;
        border: 1.5px solid #CBD5E1 !important;
        padding: 8px 14px !important;
        font-size: .84rem !important;
        color: var(--text) !important;
        background: #fff !important;
        transition: border-color .18s, box-shadow .18s;
    }

    .c-form-field:focus {
        border-color: var(--green) !important;
        box-shadow: 0 0 0 3px rgba(0, 138, 67, .1) !important;
        outline: none !important;
    }

    .c-form-submit {
        background: var(--green-dk);
        color: #fff;
        font-weight: 700;
        border-radius: 22px;
        padding: 11px;
        border: none;
        width: 100%;
        font-size: .95rem;
        transition: all .2s;
    }

    .c-form-submit:hover {
        background: var(--navy);
    }

    /* ─────────────────────────────────────────
   2. LEFT STICKY QUICK NAV
───────────────────────────────────────── */
    .c-nav {
        position: -webkit-sticky;
        position: sticky;
        top: 90px;
        z-index: 100;
        align-self: flex-start;
        height: fit-content;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        padding: 10px 6px;
        box-shadow: var(--shadow-sm);
        max-height: calc(100vh - 110px);
        overflow-y: auto;
    }

    .c-nav::-webkit-scrollbar {
        width: 3px;
    }

    .c-nav::-webkit-scrollbar-thumb {
        background: var(--border);
        border-radius: 3px;
    }

    .c-nav__label {
        display: block;
        padding: 4px 12px 8px;
        font-size: .62rem;
        font-weight: 800;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--muted);
    }

    .c-nav__link {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 9px;
        margin-bottom: 2px;
        font-size: .79rem;
        font-weight: 600;
        color: #475569;
        text-decoration: none;
        cursor: pointer;
        transition: all .18s;
        border-left: 3px solid transparent;
    }

    .c-nav__link:hover {
        background: #F1F7F4;
        color: var(--green);
    }

    .c-nav__link.active {
        background: var(--purple-bg);
        color: var(--green-dk);
        font-weight: 700;
        border-left-color: var(--gold);
    }

    .c-nav__link i {
        font-size: .88rem;
        flex-shrink: 0;
    }

    /* Mobile sticky nav bar (horizontal scroll) */
    .c-nav-mobile {
        display: none;
        position: sticky;
        top: 0;
        z-index: 200;
        background: #fff;
        border-bottom: 1px solid var(--border);
        box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
        overflow-x: auto;
        white-space: nowrap;
        padding: 0 16px;
        scrollbar-width: none;
    }

    .c-nav-mobile::-webkit-scrollbar {
        display: none;
    }

    .c-nav-mobile__link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 12px 14px;
        font-size: .77rem;
        font-weight: 700;
        color: var(--muted);
        text-decoration: none;
        border-bottom: 2.5px solid transparent;
        transition: all .18s;
        cursor: pointer;
    }

    .c-nav-mobile__link.active,
    .c-nav-mobile__link:hover {
        color: var(--navy);
        border-bottom-color: var(--gold);
    }

    /* ─────────────────────────────────────────
   3. CONTENT BLOCKS
───────────────────────────────────────── */
    .c-block {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 26px 28px;
        margin-bottom: 20px;
        scroll-margin-top: 90px;
        box-shadow: var(--shadow-sm);
    }

    .c-block__title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--navy);
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 2px solid #E8EFF6;
    }

    .c-block__title i {
        font-size: 1.05rem;
    }

    /* ─────────────────────────────────────────
   4. TABLES
───────────────────────────────────────── */

    /* Yellow-header table (Quick Facts, Approvals, Scholarships) */
    .tbl-yellow {
        width: 100%;
        border-collapse: collapse;
        font-size: .86rem;
    }

    .tbl-yellow thead th {
        background: var(--gold) !important;
        color: #1a1000 !important;
        font-weight: 800;
        padding: 12px 16px;
        border: 1px solid #e0be00;
        font-size: .84rem;
    }

    .tbl-yellow tbody tr:nth-child(even) td {
        background: #FAFBFD;
    }

    .tbl-yellow tbody td {
        padding: 10px 16px;
        border: 1px solid #E8ECF2;
        vertical-align: middle;
        color: var(--text);
    }

    .tbl-yellow tbody tr:hover td {
        background: #F8F9FC;
    }

    /* Purple-header table (Courses) */
    .tbl-purple {
        width: 100%;
        border-collapse: collapse;
        font-size: .84rem;
    }

    .tbl-purple thead th {
        background: var(--purple-bg) !important;
        color: var(--navy) !important;
        font-weight: 800;
        padding: 11px 14px;
        border: 1px solid var(--border);
        font-size: .82rem;
    }

    .tbl-purple tbody td {
        padding: 10px 14px;
        border: 1px solid var(--border);
        vertical-align: middle;
    }

    .tbl-purple tbody tr:hover td {
        background: #F8FAFB;
    }

    /* Course group header row */
    .tbl-course-group td {
        background: #F5F8FC !important;
        font-weight: 700 !important;
        color: var(--navy) !important;
        font-size: .86rem !important;
        padding: 8px 14px !important;
    }

    /* Apply Now btn in table */
    .btn-apply {
        display: inline-block;
        background: var(--gold);
        color: #1a1000;
        font-weight: 700;
        border-radius: 20px;
        padding: 5px 16px;
        font-size: .76rem;
        text-decoration: none;
        white-space: nowrap;
        transition: all .18s;
        border: none;
        cursor: pointer;
    }

    .btn-apply:hover {
        background: var(--gold-dk);
        color: #1a1000;
    }

    /* ─────────────────────────────────────────
   5. HIGHLIGHT PILLS
───────────────────────────────────────── */
    .c-highlight {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 11px 14px;
        margin-bottom: 8px;
        background: #F4F8FC;
        border: 1px solid #D8E6EF;
        border-radius: var(--radius-sm);
        font-size: .87rem;
        color: #334155;
    }

    .c-highlight i {
        color: var(--green);
        font-size: 1.05rem;
        flex-shrink: 0;
        margin-top: 1px;
    }

    /* ─────────────────────────────────────────
   6. ADMISSION STEP CARDS
───────────────────────────────────────── */
    .c-step {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 14px 16px;
        margin-bottom: 10px;
        background: #F8FAFC;
        border-left: 4px solid var(--green);
        border-radius: var(--radius-sm);
    }

    .c-step__num {
        min-width: 32px;
        height: 32px;
        background: var(--navy);
        color: #fff;
        font-weight: 700;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .82rem;
        flex-shrink: 0;
    }

    /* ─────────────────────────────────────────
   7. PLACEMENT STAT CARDS
───────────────────────────────────────── */
    .c-stat {
        text-align: center;
        padding: 18px 14px;
        background: #F8FAFD;
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        transition: box-shadow .2s;
    }

    .c-stat:hover {
        box-shadow: var(--shadow-md);
    }

    .c-stat__value {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--navy);
        line-height: 1.2;
    }

    .c-stat__label {
        font-size: .72rem;
        color: var(--muted);
        margin-top: 3px;
    }

    .c-stat__sub {
        font-size: .65rem;
        color: var(--muted);
        margin-top: 2px;
    }

    /* ─────────────────────────────────────────
   8. RECRUITER BADGES
───────────────────────────────────────── */
    .c-recruiter {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        background: #F8F9FC;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        font-size: .8rem;
        font-weight: 600;
        color: #334155;
    }

    .c-recruiter img {
        height: 20px;
        width: auto;
        object-fit: contain;
    }

    /* ─────────────────────────────────────────
   9. CERTIFICATE BOX
───────────────────────────────────────── */
    .c-cert-box {
        background: #F4F8FC;
        border: 2px dashed #CBD5E1;
        border-radius: 14px;
        padding: 20px;
        text-align: center;
    }

    /* ─────────────────────────────────────────
   10. RELATED COLLEGE CARDS
───────────────────────────────────────── */
    .c-related-card {
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        background: #fff;
        transition: box-shadow .2s, transform .2s;
        text-decoration: none;
        display: block;
        color: inherit;
        height: 100%;
    }

    .c-related-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
        color: inherit;
    }

    .c-related-card img {
        height: 130px;
        width: 100%;
        object-fit: cover;
    }

    .c-related-card__body {
        padding: 12px 14px;
    }

    .c-related-card__name {
        font-weight: 700;
        font-size: .82rem;
        color: var(--navy);
        line-height: 1.3;
    }

    .c-related-card__meta {
        font-size: .74rem;
        color: var(--muted);
        margin-top: 4px;
    }

    /* ─────────────────────────────────────────
   11. CAREER OUTCOME ROWS
───────────────────────────────────────── */
    .c-career-row {
        display: flex;
        align-items: center;
        padding: 12px 14px;
        border-bottom: 1px solid var(--border);
        gap: 12px;
    }

    .c-career-row:last-child {
        border-bottom: none;
    }

    .c-career-row__icon {
        width: 38px;
        height: 38px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--purple-bg);
        border-radius: var(--radius-sm);
        color: var(--navy);
        font-size: .95rem;
    }

    /* ─────────────────────────────────────────
   12. RESPONSIVE BREAKPOINTS
───────────────────────────────────────── */

    /* 4K / Large screens — wider content */
    @media (min-width: 1800px) {
        .c-block {
            padding: 32px 36px;
        }

        .c-block__title {
            font-size: 1.28rem;
        }

        .c-title {
            font-size: 2rem;
        }

        .c-banner {
            height: 400px;
        }

        .tbl-yellow,
        .tbl-purple {
            font-size: .92rem;
        }
    }

    /* Standard desktop + laptop (992px–1799px) — no changes needed */

    /* Tablet (768px–991px) */
    @media (max-width: 991.98px) {
        .c-banner {
            height: 240px;
        }

        .c-title {
            font-size: 1.3rem;
        }

        .c-block {
            padding: 20px;
        }

        .c-nav {
            display: none;
        }

        .c-nav-mobile {
            display: block;
        }

        /* Admission card goes below hero on tablet */
        .c-admission-col {
            order: 10;
            margin-top: 20px;
        }

        .c-admission-card {
            position: static !important;
        }
    }

    /* Large Mobile (576px–767px) */
    @media (max-width: 767.98px) {
        .c-hero {
            padding: 16px 0 24px;
        }

        .c-banner {
            height: 200px;
            border-radius: 12px;
        }

        .c-banner__logo {
            width: 54px;
            height: 54px;
            top: 12px;
            left: 12px;
        }

        .c-title {
            font-size: 1.18rem;
        }

        .c-block {
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 14px;
        }

        .c-block__title {
            font-size: 1rem;
        }

        .tbl-yellow thead th,
        .tbl-yellow tbody td {
            padding: 8px 10px;
            font-size: .78rem;
        }

        .tbl-purple thead th,
        .tbl-purple tbody td {
            padding: 8px 10px;
            font-size: .78rem;
        }

        .c-stat__value {
            font-size: 1.1rem;
        }

        .c-nav-mobile {
            top: 0;
        }
    }

    /* Small Mobile (< 576px) */
    @media (max-width: 575.98px) {
        .c-banner {
            height: 170px;
        }

        .c-title {
            font-size: 1.05rem;
        }

        .c-btn {
            padding: 8px 14px;
            font-size: .8rem;
        }

        .c-block {
            padding: 14px;
        }

        .c-block__title {
            font-size: .95rem;
            gap: 7px;
        }

        .c-block__title i {
            font-size: .9rem;
        }

        .c-admission-card {
            padding: 18px 16px;
            border-radius: 16px;
        }

        .c-stat {
            padding: 14px 10px;
        }

        .c-stat__value {
            font-size: 1rem;
        }

        .c-nav-mobile__link {
            padding: 11px 10px;
            font-size: .72rem;
        }
    }

    /* Table overflow on mobile */
    @media (max-width: 767.98px) {
        .c-table-scroll {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .c-table-scroll table {
            min-width: 560px;
        }
    }

    /* ================================================================
   GROWPEC COLLEGE DETAIL — REDESIGNED UI
   Visual direction: BoostMyTalent-style purple + yellow
   Keeps all existing Blade/data/JS functionality intact.
================================================================ */

    :root {
        --gp-purple: #46358F;
        --gp-purple-dark: #352875;
        --gp-purple-soft: #F2F0FF;
        --gp-yellow: #FFC400;
        --gp-yellow-soft: #FFF7D6;
        --gp-green: #00A651;
        --gp-green-soft: #EAF8F0;
        --gp-text: #202124;
        --gp-muted: #6B7280;
        --gp-border: #E7E7EC;
        --gp-bg: #FAFAFC;
        --gp-card: #FFFFFF;
        --gp-shadow: 0 4px 18px rgba(37, 30, 91, .08);
        --gp-shadow-hover: 0 8px 26px rgba(37, 30, 91, .13);
        --gp-radius: 14px;
    }

    /* Page */
    .c-hero {
        background: #fff;
        border-bottom: 1px solid var(--gp-border);
        padding: 14px 0 22px;
    }

    .c-hero .container-fluid,
    .container-fluid[style*="max-width:1600px"] {
        max-width: 1180px !important;
    }

    /* Breadcrumb */
    .bg-light.border-bottom.py-2 {
        background: #fff !important;
        border-bottom: 1px solid #eee !important;
    }

    .breadcrumb {
        font-size: .72rem !important;
    }

    .breadcrumb-item a {
        color: #777 !important;
    }

    .breadcrumb-item.active {
        color: var(--gp-purple) !important;
    }

    /* Hero layout */
    .c-banner {
        height: 245px;
        border-radius: 14px;
        box-shadow: none;
        border: 1px solid var(--gp-border);
    }

    .c-banner__logo {
        width: 58px;
        height: 58px;
        top: 12px;
        left: 12px;
        border-radius: 10px;
        padding: 5px;
    }

    .c-banner__mode-badge {
        bottom: 12px;
        right: 12px;
        padding: 5px 11px;
        font-size: .62rem;
        background: rgba(70, 53, 143, .92) !important;
    }

    .c-banner__mode-badge.online {
        background: rgba(0, 166, 81, .92) !important;
    }

    /* College title area */
    .c-title {
        color: var(--gp-purple);
        font-size: 1.22rem;
        line-height: 1.35;
        margin-top: 4px;
    }

    .c-subtitle {
        color: #666;
        font-size: .76rem;
    }

    .c-subtitle strong {
        color: #444;
    }

    .c-badge {
        padding: 4px 9px;
        font-size: .63rem;
        border-radius: 999px;
    }

    .c-badge--blue {
        background: var(--gp-purple-soft);
        color: var(--gp-purple);
        border-color: #D8D1FF;
    }

    .c-badge--green {
        background: var(--gp-green-soft);
        color: #08783d;
        border-color: #BFE8D0;
    }

    .c-badge--gold {
        background: var(--gp-yellow-soft);
        color: #765900;
        border-color: #F3D66B;
    }

    .c-badge--dark {
        background: #F7F7FA;
        color: #555;
        border-color: #E5E5EA;
    }

    .c-badge--star {
        background: #fff;
        color: #555;
    }

    /* Hero CTAs */
    .c-btn {
        padding: 7px 15px;
        font-size: .7rem;
        border-radius: 999px;
    }

    .c-btn--navy {
        background: var(--gp-purple);
        color: #fff;
    }

    .c-btn--navy:hover {
        background: var(--gp-purple-dark);
    }

    .c-btn--gold {
        background: var(--gp-yellow);
        color: #171200;
    }

    .c-btn--green {
        background: var(--gp-green);
    }

    /* Counselling card */
    .c-admission-card {
        border: 1px solid #ECEBF2;
        border-radius: 14px;
        box-shadow: var(--gp-shadow);
        padding: 18px 16px;
    }

    .c-admission-card h5 {
        color: var(--gp-purple) !important;
        font-size: .9rem !important;
    }

    .c-form-field {
        border-radius: 9px !important;
        border: 1px solid #DCDDE5 !important;
        min-height: 36px;
        padding: 7px 11px !important;
        font-size: .72rem !important;
    }

    .c-form-field:focus {
        border-color: var(--gp-purple) !important;
        box-shadow: 0 0 0 3px rgba(70, 53, 143, .08) !important;
    }

    .c-form-submit {
        background: var(--gp-purple);
        border-radius: 9px;
        padding: 9px;
        font-size: .78rem;
    }

    .c-form-submit:hover {
        background: var(--gp-purple-dark);
    }

    /* Mobile quick nav */
    .c-nav-mobile {
        background: #fff;
    }

    .c-nav-mobile__link {
        font-size: .68rem;
        padding: 10px 12px;
    }

    .c-nav-mobile__link.active,
    .c-nav-mobile__link:hover {
        color: var(--gp-purple);
        border-bottom-color: var(--gp-yellow);
    }

    /* Main content */
    .container-fluid.px-3.px-md-4.py-4[style*="max-width:1600px"] {
        max-width: 1180px !important;
        padding-top: 18px !important;
    }

    /* Quick jump */
    .c-nav {
        top: 82px;
        border: 0;
        border-radius: 12px;
        box-shadow: none;
        background: #F7F8FC;
        padding: 8px;
    }

    .c-nav__label {
        color: #777;
        font-size: .6rem;
    }

    .c-nav__link {
        font-size: .68rem;
        padding: 8px 9px;
        border-left: 3px solid transparent;
        color: #555;
    }

    .c-nav__link:hover {
        background: #EEECFF;
        color: var(--gp-purple);
    }

    .c-nav__link.active {
        background: #EEECFF;
        color: var(--gp-purple);
        border-left-color: var(--gp-yellow);
    }

    /* Content blocks: cleaner editorial layout */
    .c-block {
        background: transparent;
        border: 0;
        border-radius: 0;
        box-shadow: none;
        padding: 0 0 24px;
        margin-bottom: 22px;
    }

    .c-block__title {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--gp-purple);
        font-size: .98rem;
        margin: 0 0 9px;
        padding: 0 0 6px;
        border-bottom: 1px solid #D8D8DE;
        position: relative;
    }

    .c-block__title:after {
        content: "";
        position: absolute;
        left: 0;
        bottom: -1px;
        width: 42px;
        height: 2px;
        background: var(--gp-purple);
    }

    .c-block__title i {
        font-size: .86rem;
    }

    /* Quick facts / yellow tables */
    .tbl-yellow {
        font-size: .72rem;
    }

    .tbl-yellow thead th {
        background: var(--gp-yellow) !important;
        color: #171200 !important;
        padding: 7px 9px;
        border-color: #E5B500;
        font-size: .7rem;
    }

    .tbl-yellow tbody td {
        padding: 6px 9px;
        border-color: #D8D8DE;
        font-size: .7rem;
    }

    .tbl-yellow tbody tr:nth-child(even) td {
        background: #FCFCFD;
    }

    /* Purple course tables */
    .c-table-scroll {
        border-radius: 12px;
    }

    .tbl-purple {
        font-size: .7rem;
        background: #fff;
    }

    .tbl-purple thead th {
        background: #DCD8F8 !important;
        color: #30256C !important;
        padding: 7px 9px;
        border-color: #B9B4E2;
        font-size: .68rem;
    }

    .tbl-purple tbody td {
        padding: 7px 9px;
        border-color: #D9D9E0;
        font-size: .68rem;
    }

    .tbl-course-group td {
        background: #F8F8FC !important;
        color: var(--gp-purple) !important;
    }

    /* Course section cards */
    #sec-courses .c-table-scroll {
        background: #fff;
        border: 1px solid #E9E9EE;
        box-shadow: var(--gp-shadow);
        margin-bottom: 12px !important;
        padding: 0;
    }

    #sec-courses .tbl-purple {
        margin: 0;
    }

    #sec-courses .btn-apply {
        background: var(--gp-purple);
        color: #fff;
        padding: 4px 11px;
        font-size: .63rem;
    }

    #sec-courses .btn-apply:hover {
        background: var(--gp-purple-dark);
    }

    /* Highlights */
    .c-highlight {
        padding: 8px 10px;
        margin-bottom: 5px;
        background: #fff;
        border: 1px solid #ECECF1;
        border-radius: 8px;
        font-size: .72rem;
    }

    .c-highlight i {
        color: var(--gp-green);
        font-size: .82rem;
    }

    /* Admission */
    .c-step {
        padding: 10px 12px;
        margin-bottom: 7px;
        background: #fff;
        border: 1px solid #ECECF1;
        border-left: 3px solid var(--gp-purple);
        border-radius: 8px;
    }

    .c-step__num {
        min-width: 26px;
        height: 26px;
        background: var(--gp-purple);
        font-size: .68rem;
    }

    /* Placement stats */
    .c-stat {
        padding: 13px 10px;
        background: #fff;
        border: 1px solid #ECECF1;
        border-radius: 10px;
    }

    .c-stat__value {
        color: var(--gp-purple);
        font-size: 1.12rem;
    }

    .c-stat__label {
        font-size: .65rem;
    }

    /* Recruiters / facilities */
    .c-recruiter {
        padding: 5px 10px;
        font-size: .68rem;
        background: #fff;
        border: 1px solid #E7E7EC;
    }

    /* Certificate */
    .c-cert-box {
        background: #fff;
        border: 1px solid #E5E5EA;
        border-radius: 10px;
        padding: 14px;
    }

    /* FAQ */
    #faqAccordion .accordion-item {
        border: 1px solid #E6E6EB !important;
        border-radius: 9px !important;
    }

    #faqAccordion .accordion-button {
        font-size: .74rem !important;
        padding: 10px 12px;
        box-shadow: none !important;
    }

    #faqAccordion .accordion-button:not(.collapsed) {
        color: var(--gp-purple);
        background: #F4F2FF !important;
    }

    #faqAccordion .accordion-body {
        font-size: .72rem !important;
    }

    /* Related colleges */
    .c-related-card {
        border: 1px solid #E7E7EC;
        border-radius: 12px;
        box-shadow: none;
    }

    .c-related-card:hover {
        box-shadow: var(--gp-shadow-hover);
        transform: translateY(-2px);
    }

    .c-related-card img {
        height: 120px;
    }

    .c-related-card__body {
        padding: 10px 11px;
    }

    .c-related-card__name {
        color: var(--gp-purple);
        font-size: .74rem;
    }

    .c-related-card__meta {
        font-size: .65rem;
    }

    /* Section text */
    .c-block p,
    .c-block li {
        font-size: .72rem !important;
        line-height: 1.7 !important;
    }

    .c-block h6 {
        font-size: .76rem !important;
    }

    /* Make large content feel closer to reference screenshots */
    #sec-overview,
    #sec-highlights {
        padding-bottom: 15px;
    }

    #sec-quickfacts {
        padding-bottom: 18px;
    }

    #sec-courses {
        padding-top: 2px;
    }

    #sec-courses>.c-block__title {
        margin-bottom: 8px;
    }


    /* ================================================================
       PROGRAM SECTION — COURSE ONCE, SPECIALIZATIONS INSIDE
       Example:
       B.Tech
       ├── Computer Science & Engineering
       ├── AI & Machine Learning
       ├── Data Science
       └── ...
       B.Tech is NOT repeated for every specialization.
       ================================================================ */

    .gp-program-card {
        background: #fff;
        border: 1px solid #E5E3EC;
        border-radius: 15px;
        margin: 0 0 14px;
        overflow: hidden;
        box-shadow: 0 3px 14px rgba(37, 30, 91, .055);
        transition: box-shadow .18s ease, border-color .18s ease;
    }

    .gp-program-card:hover {
        border-color: #D8D2F5;
        box-shadow: 0 7px 22px rgba(37, 30, 91, .09);
    }

    .gp-program-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
        padding: 16px 18px 10px;
    }

    .gp-program-title-wrap {
        min-width: 0;
    }

    .gp-program-title-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .gp-program-title {
        margin: 0;
        color: #202124;
        font-size: 1.05rem;
        line-height: 1.25;
        font-weight: 800;
    }

    .gp-program-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 8px;
        color: #4B5563;
        font-size: .69rem;
    }

    .gp-program-meta span {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .gp-program-meta i {
        color: var(--gp-purple);
        font-size: .68rem;
    }

    .gp-brochure-btn {
        flex: 0 0 auto;
        min-width: 150px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 18px;
        border-radius: 999px;
        background: var(--gp-yellow);
        color: #171200 !important;
        font-size: .72rem;
        font-weight: 800;
        text-decoration: none !important;
        transition: transform .18s ease, background .18s ease;
    }

    .gp-brochure-btn:hover {
        background: #F0B900;
        color: #171200 !important;
        transform: translateY(-1px);
    }

    .gp-program-info {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px 24px;
        padding: 4px 18px 15px;
    }

    .gp-program-info>div {
        display: flex;
        flex-direction: column;
        gap: 3px;
        min-width: 0;
    }

    .gp-info-label {
        color: #8A8D96;
        font-size: .62rem;
        font-weight: 700;
    }

    .gp-info-value {
        color: #30343B;
        font-size: .72rem;
        line-height: 1.35;
    }

    .gp-specialization-box {
        margin: 0 12px 12px;
        border: 1px solid #E2DFEC;
        border-radius: 11px;
        overflow: hidden;
        background: #fff;
    }

    .gp-specialization-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 9px 12px;
        background: #F3F1FF;
        color: #30256C;
        border-bottom: 1px solid #DCD7F2;
        font-size: .73rem;
        font-weight: 800;
    }

    .gp-specialization-total {
        color: #08783D;
        background: #EAF8F0;
        border: 1px solid #BFE8D0;
        border-radius: 999px;
        padding: 3px 8px;
        font-size: .59rem;
        white-space: nowrap;
    }

    .gp-specialization-scroll {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .gp-specialization-table {
        width: 100%;
        min-width: 650px;
        border-collapse: collapse;
        font-size: .70rem;
    }

    .gp-specialization-table th {
        padding: 8px 10px;
        background: #FAFAFD;
        color: #5A566B;
        border-bottom: 1px solid #E5E3EC;
        font-size: .63rem;
        font-weight: 800;
        text-align: left;
        white-space: nowrap;
    }

    .gp-specialization-table td {
        padding: 9px 10px;
        color: #454952;
        border-bottom: 1px solid #ECEBF0;
        vertical-align: middle;
        line-height: 1.35;
    }

    .gp-specialization-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .gp-specialization-table tbody tr:hover td {
        background: #FCFBFF;
    }

    .gp-spec-name {
        color: #30256C;
        font-weight: 700;
    }

    .gp-fee {
        display: block;
        color: #008A43;
        font-size: .72rem;
        white-space: nowrap;
    }

    .gp-fee-type {
        display: block;
        margin-top: 1px;
        color: #8A8D96;
        font-size: .58rem;
        white-space: nowrap;
    }

    .gp-fee-na {
        color: #8A8D96;
        font-size: .65rem;
    }

    .gp-apply-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 84px;
        padding: 6px 11px;
        border-radius: 999px;
        background: var(--gp-purple);
        color: #fff !important;
        font-size: .61rem;
        font-weight: 800;
        text-decoration: none !important;
        white-space: nowrap;
        transition: background .18s ease, transform .18s ease;
    }

    .gp-apply-btn:hover {
        background: var(--gp-purple-dark);
        color: #fff !important;
        transform: translateY(-1px);
    }

    .gp-empty-row {
        padding: 16px !important;
        color: #8A8D96 !important;
    }

    @media (max-width: 991.98px) {
        .gp-program-head {
            padding: 14px 14px 9px;
        }

        .gp-program-title {
            font-size: .95rem;
        }

        .gp-program-meta {
            gap: 10px;
            font-size: .65rem;
        }

        .gp-program-info {
            padding-left: 14px;
            padding-right: 14px;
        }

        .gp-specialization-box {
            margin-left: 9px;
            margin-right: 9px;
        }
    }

    @media (max-width: 767.98px) {
        .gp-program-head {
            flex-direction: column;
            gap: 11px;
        }

        .gp-brochure-btn {
            width: 100%;
            min-width: 0;
        }

        .gp-program-info {
            grid-template-columns: 1fr 1fr;
            gap: 9px 14px;
        }

        .gp-specialization-table {
            min-width: 620px;
        }
    }

    @media (max-width: 575.98px) {
        .gp-program-card {
            border-radius: 12px;
        }

        .gp-program-title {
            font-size: .90rem;
        }

        .gp-program-info {
            grid-template-columns: 1fr;
        }

        .gp-specialization-heading {
            font-size: .68rem;
        }

        .gp-specialization-table {
            min-width: 600px;
        }
    }


    .faq-first-open {
        background: #F0F7FF !important;
    }

    /* Responsive */
    /* ================================================================
   FINAL RESPONSIVE SYSTEM
   768px–1199px = TABLET + LAPTOP STYLE
   1200px+      = WIDER LAPTOP/DESKTOP
   <768px       = MOBILE STYLE
   ================================================================ */

    /* Tablet + laptop: keep the same desktop structure */
    @media (min-width:768px) {
        .c-hero .row {
            --bs-gutter-x: 18px;
        }

        /* Hero: banner/info 70% + counselling 30% */
        .c-hero .col-md-8,
        .c-hero .col-lg-8 {
            width: 70%;
            flex: 0 0 70%;
        }

        .c-hero .col-md-4,
        .c-hero .col-lg-4 {
            width: 30%;
            flex: 0 0 30%;
        }

        /* Main: quick nav 18% + content 82% */
        .container-fluid.px-3.px-md-4.py-4 .col-md-2,
        .container-fluid.px-3.px-md-4.py-4 .col-lg-2 {
            width: 18%;
            flex: 0 0 18%;
        }

        .container-fluid.px-3.px-md-4.py-4 .col-md-10,
        .container-fluid.px-3.px-md-4.py-4 .col-lg-10 {
            width: 82%;
            flex: 0 0 82%;
        }

        /* Tablet must NOT switch to mobile stacking */
        .c-admission-col {
            order: initial !important;
            margin-top: 0 !important;
        }

        .c-admission-card {
            position: sticky !important;
            top: 90px;
            box-shadow: 0 3px 14px rgba(37, 30, 91, .08);
        }

        /* Desktop quick navigation stays visible */
        .c-nav {
            display: block !important;
        }

        /* Mobile horizontal navigation stays hidden */
        .c-nav-mobile {
            display: none !important;
        }

        .c-block {
            padding-bottom: 20px;
            margin-bottom: 18px;
        }
    }

    /* ================================================================
   768–991px : TABLET
   ================================================================ */
    @media (min-width:768px) and (max-width:991.98px) {
        .c-banner {
            height: 235px;
        }

        .c-title {
            font-size: 1.12rem;
        }

        .c-subtitle {
            font-size: .72rem;
        }

        .c-btn {
            padding: 7px 13px;
            font-size: .68rem;
        }

        .c-admission-card {
            padding: 16px 14px;
        }

        .c-block__title {
            font-size: .94rem;
        }

        .tbl-yellow thead th,
        .tbl-yellow tbody td,
        .tbl-purple thead th,
        .tbl-purple tbody td {
            font-size: .65rem;
            padding: 6px 8px;
        }
    }

    /* ================================================================
   992–1199px : LAPTOP
   1024px belongs here — do NOT use tablet-density styling.
   ================================================================ */
    @media (min-width:992px) and (max-width:1199.98px) {
        .c-hero .row {
            --bs-gutter-x: 20px;
        }

        .c-banner {
            height: 260px;
        }

        .c-title {
            font-size: 1.30rem;
            line-height: 1.2;
        }

        .c-subtitle {
            font-size: .80rem;
        }

        .c-btn {
            padding: 8px 16px;
            font-size: .73rem;
        }

        .c-admission-card {
            padding: 20px 18px;
        }

        .c-block {
            padding-bottom: 22px;
            margin-bottom: 20px;
        }

        .c-block__title {
            font-size: 1.02rem;
        }

        .tbl-yellow thead th,
        .tbl-yellow tbody td,
        .tbl-purple thead th,
        .tbl-purple tbody td {
            font-size: .72rem;
            padding: 8px 10px;
        }

        /* 1024 laptop Quick Jump */
        .c-detail-main .c-quick-jump-col .c-nav {
            padding: 13px 10px 11px !important;
        }

        .c-detail-main .c-nav__link {
            min-height: 42px;
            padding: 9px 10px !important;
            font-size: .73rem !important;
        }

        .c-detail-main .c-nav__link i {
            width: 28px;
            height: 28px;
            flex-basis: 28px;
            font-size: .80rem !important;
        }

        .c-detail-main .c-nav__label {
            font-size: .66rem !important;
            padding-bottom: 10px !important;
        }
    }

    /* 1200px+: wider desktop */
    @media (min-width:1200px) {
        .c-banner {
            height: 270px;
        }
    }

    /* Mobile only: <768px */
    @media (max-width:767.98px) {
        .c-hero {
            padding: 16px 0 24px;
        }

        /* Restore single-column hero on mobile */
        .c-hero .col-md-8,
        .c-hero .col-lg-8,
        .c-hero .col-md-4,
        .c-hero .col-lg-4 {
            width: 100%;
            flex: 0 0 100%;
        }

        .c-banner {
            height: 200px;
            border-radius: 11px;
        }

        .c-title {
            font-size: 1.02rem;
        }

        .c-subtitle {
            font-size: .70rem;
        }

        .c-btn {
            padding: 7px 12px;
            font-size: .66rem;
        }

        /* Mobile counselling card goes below hero */
        .c-admission-col {
            order: 10 !important;
            margin-top: 15px !important;
        }

        .c-admission-card {
            position: static !important;
        }

        /* Mobile nav only */
        .c-nav {
            display: none !important;
        }

        .c-nav-mobile {
            display: block !important;
        }

        .c-block__title {
            font-size: .90rem;
        }

        .tbl-yellow thead th,
        .tbl-yellow tbody td,
        .tbl-purple thead th,
        .tbl-purple tbody td {
            font-size: .66rem;
            padding: 6px 8px;
        }
    }

    @media (max-width:575.98px) {
        .c-banner {
            height: 175px;
        }

        .c-banner__logo {
            width: 48px;
            height: 48px;
        }

        .c-admission-card {
            padding: 15px 13px;
        }

        .c-block p,
        .c-block li {
            font-size: .69rem !important;
        }
    }



    /* ================================================================
   1024px LAPTOP WIDTH TUNING
   Keep the page desktop-like and use the full viewport.
   ================================================================ */
    @media (min-width:992px) and (max-width:1199.98px) {
        .c-detail-main {
            width: 100%;
            max-width: 100%;
        }

        .c-detail-main>.row {
            margin-left: 0;
            margin-right: 0;
        }

        .c-detail-main .c-quick-jump-col {
            padding-left: 14px;
            padding-right: 10px;
        }

        .c-detail-main .col-md-10,
        .c-detail-main .col-lg-10 {
            padding-left: 10px;
            padding-right: 14px;
        }
    }


    /* ================================================================
   TABLET: HIDE DESKTOP QUICK JUMP
   768–991px uses the mobile/compact navigation instead.
   Laptop starts at 992px.
   ================================================================ */
    @media (min-width:768px) and (max-width:991.98px) {
        .c-detail-main .c-quick-jump-col {
            display: none !important;
        }

        .c-detail-main .col-md-10,
        .c-detail-main .col-lg-10 {
            width: 100% !important;
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }
    }


    /* ================================================================
   MOBILE + TABLET: HIDE DESKTOP QUICK JUMP
   < 992px uses the mobile/compact navigation.
   992px+ keeps the desktop Quick Jump.
   ================================================================ */
    @media (max-width:991.98px) {
        .c-detail-main .c-quick-jump-col {
            display: none !important;
        }

        .c-detail-main .col-md-10,
        .c-detail-main .col-lg-10 {
            width: 100% !important;
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }
    }

    /* ================================================================
   QUICK JUMP — BOOSTMYTALENT-STYLE STICKY SIDEBAR
   Fixed while the content scrolls, bounded to .c-detail-main.
   JavaScript controls only the fixed/end state; layout width is
   always taken from the real sidebar column.
   ================================================================ */

    .c-detail-main {
        position: relative;
    }

    /* Do not stretch the sidebar column vertically. */
    .c-detail-main>.row {
        align-items: flex-start !important;
    }

    .c-detail-main .c-quick-jump-col {
        position: relative;
        align-self: flex-start !important;
        min-width: 0;
    }

    /* Base card */
    .c-detail-main .c-quick-jump-col .c-nav {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;

        background: #fff !important;
        border: 1px solid #E8E7EE !important;
        border-radius: 16px !important;
        padding: 12px 9px 10px !important;
        box-shadow: 0 8px 28px rgba(37, 30, 91, .08) !important;

        max-height: calc(100vh - 104px) !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;

        scrollbar-width: thin;
        scrollbar-color: #D9D7E8 transparent;
    }

    /* Fixed while scrolling */
    .c-detail-main .c-quick-jump-col .c-nav.is-fixed {
        position: fixed !important;
        top: 82px !important;
        left: var(--quick-jump-left) !important;
        width: var(--quick-jump-width) !important;
    }

    /* Stop exactly inside the main detail section */
    .c-detail-main .c-quick-jump-col .c-nav.is-end {
        position: absolute !important;
        top: var(--quick-jump-end, 0px) !important;
        left: 0 !important;
        width: 100% !important;
    }

    /* Header */
    .c-detail-main .c-nav__label {
        display: flex !important;
        align-items: center;
        gap: 8px;
        padding: 3px 10px 10px !important;
        color: #3B327D !important;
        font-size: .64rem !important;
        font-weight: 800 !important;
        letter-spacing: .08em !important;
        text-transform: uppercase;
    }

    .c-detail-main .c-nav__label::before {
        content: "";
        width: 4px;
        height: 17px;
        border-radius: 999px;
        background: var(--gp-yellow, #FFC400);
        flex: 0 0 4px;
    }

    /* Navigation item */
    .c-detail-main .c-nav__link {
        display: flex !important;
        align-items: center !important;
        gap: 9px !important;

        width: 100% !important;
        min-height: 40px;
        margin: 4px 0 !important;
        padding: 9px 10px !important;

        background: #F7F9FD;
        border: 1px solid transparent !important;
        border-left: 3px solid transparent !important;
        border-radius: 10px !important;

        color: #384152 !important;
        font-size: .70rem !important;
        font-weight: 600 !important;
        line-height: 1.25;
        text-decoration: none !important;

        transition:
            background .18s ease,
            color .18s ease,
            border-color .18s ease,
            transform .18s ease,
            box-shadow .18s ease;
    }

    .c-detail-main .c-nav__link i {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 27px;
        height: 27px;
        flex: 0 0 27px;

        border-radius: 8px;
        background: #EEF2F8;
        color: #667085;
        font-size: .78rem !important;
        transition: all .18s ease;
    }

    .c-detail-main .c-nav__link:hover {
        background: #F2F0FF !important;
        color: var(--gp-purple, #46358F) !important;
        border-color: #E5E0FF !important;
        border-left-color: var(--gp-yellow, #FFC400) !important;
        transform: translateX(2px);
    }

    .c-detail-main .c-nav__link:hover i {
        background: #E7E2FF;
        color: var(--gp-purple, #46358F);
    }

    .c-detail-main .c-nav__link.active {
        background: #F0EDFF !important;
        color: var(--gp-purple, #46358F) !important;
        font-weight: 800 !important;
        border-color: #DED8FF !important;
        border-left-color: var(--gp-yellow, #FFC400) !important;
        box-shadow: 0 3px 10px rgba(70, 53, 143, .07);
    }

    .c-detail-main .c-nav__link.active i {
        background: var(--gp-purple, #46358F);
        color: #fff;
    }

    /* 768–1199: compact but same visual language */
    @media (min-width:768px) and (max-width:1199.98px) {
        .c-detail-main .c-quick-jump-col .c-nav {
            border-radius: 14px !important;
            padding: 10px 7px 9px !important;
        }

        .c-detail-main .c-nav__label {
            font-size: .58rem !important;
            padding: 3px 8px 8px !important;
        }

        .c-detail-main .c-nav__link {
            min-height: 37px;
            padding: 7px 8px !important;
            font-size: .66rem !important;
            gap: 7px !important;
        }

        .c-detail-main .c-nav__link i {
            width: 24px;
            height: 24px;
            flex-basis: 24px;
            font-size: .72rem !important;
        }
    }

    /* Mobile */
    @media (max-width:767.98px) {
        .c-detail-main .c-quick-jump-col {
            display: none !important;
        }
    }

    /* Hide the oversized desktop title spacing inherited from old theme */
    .c-hero .mb-3 {
        margin-bottom: 9px !important;
    }



    /* Quick Jump must never visually overlap the page footer. */
    @media (min-width:768px) {
        .c-detail-main .c-quick-jump-col .c-nav {
            z-index: 1000 !important;
        }

        footer,
        .site-footer,
        #site-footer,
        [data-site-footer] {
            position: relative;
            z-index: 2000 !important;
        }
    }
</style>
@endpush

@section('content')

{{-- ──────────────────────────────────────────────────────────────────
     BREADCRUMB
────────────────────────────────────────────────────────────────── --}}
<div class="bg-light border-bottom py-2 small">
    <div class="container-fluid px-3 px-md-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size:.78rem;">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ $college->isOnline() ? route('colleges.online') : route('colleges.regular') }}"
                        class="text-decoration-none text-muted">
                        {{ $college->isOnline() ? 'Online Universities' : 'Regular Colleges' }}
                    </a>
                </li>
                <li class="breadcrumb-item active fw-semibold text-dark" aria-current="page">
                    {{ $college->short_name ?? $college->name }}
                </li>
            </ol>
        </nav>
    </div>
</div>

{{-- ──────────────────────────────────────────────────────────────────
     MOBILE QUICK NAV (horizontal sticky bar)
────────────────────────────────────────────────────────────────── --}}
<div class="c-nav-mobile d-md-none" id="mobileNav" role="navigation" aria-label="Page sections">
    @foreach($quickNav as $i => $nav)
    <a class="c-nav-mobile__link {{ $i === 0 ? 'active' : '' }}"
        data-target="{{ $nav['id'] }}" role="button">
        <i class="bi {{ $nav['icon'] }}"></i>
        <span>{{ $nav['title'] }}</span>
    </a>
    @endforeach
</div>

{{-- ──────────────────────────────────────────────────────────────────
     HERO — Banner · Info · Admission Form
────────────────────────────────────────────────────────────────── --}}
<section class="c-hero">
    <div class="container-fluid px-3 px-md-4" style="max-width:1600px;">
        <div class="row g-4 align-items-start">

            {{-- Left: Banner + Info --}}
            <div class="col-md-8 col-lg-8 col-xl-8">

                {{-- Banner --}}
                <div class="c-banner mb-3">
                    <div class="c-banner__logo">
                        <img src="{{ $college->logo_url }}" alt="{{ $college->name }} logo" loading="eager">
                    </div>
                    <img src="{{ $college->banner_url }}"
                        class="c-banner__img"
                        alt="{{ $college->name }} campus"
                        loading="eager">
                    <span class="c-banner__mode-badge {{ $college->college_mode }}">
                        {{ $college->isOnline() ? '100% Online' : 'Regular Campus' }}
                    </span>
                </div>

                {{-- Badges --}}
                <div class="d-flex flex-wrap gap-2 mb-2">
                    <span class="c-badge c-badge--blue">
                        <i class="bi bi-mortarboard-fill"></i>
                        {{ $college->college_type }} University
                    </span>
                    @if($college->naac_grade)
                    <span class="c-badge c-badge--naac">
                        <i class="bi bi-award-fill"></i>
                        NAAC {{ $college->naac_grade }}
                    </span>
                    @endif
                    @if($college->nirf_rank)
                    <span class="c-badge c-badge--gold">
                        <i class="bi bi-trophy-fill"></i>
                        NIRF Rank {{ $college->nirf_rank }}
                    </span>
                    @endif
                    @if($college->approvals)
                    <span class="c-badge c-badge--green">
                        <i class="bi bi-shield-check"></i>
                        {{ Str::limit($college->approvals, 30) }}
                    </span>
                    @endif
                    <span class="c-badge c-badge--star">
                        <i class="bi bi-star-fill" style="color:var(--gold);"></i>
                        {{ number_format($college->rating, 1) }}
                        <span class="text-muted">({{ number_format($college->reviews_count) }})</span>
                    </span>
                </div>

                {{-- Title --}}
                <h1 class="c-title mb-1">{{ $college->name }}</h1>
                @if($college->short_name && $college->short_name !== $college->name)
                <p class="mb-1" style="color:var(--muted);font-size:.85rem;">({{ $college->short_name }})</p>
                @endif

                {{-- Meta --}}
                <p class="c-subtitle mb-3 d-flex flex-wrap align-items-center gap-2">
                    <span><i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $college->city }}, {{ $college->state }}</span>
                    @if($college->university_name)
                    <span class="text-muted">·</span>
                    <span>Affiliated: <strong>{{ $college->university_name }}</strong></span>
                    @endif
                    @if($college->established_year)
                    <span class="text-muted">·</span>
                    <span>Estd. <strong>{{ $college->established_year }}</strong></span>
                    @endif
                    @if($college->website)
                    <span class="text-muted">·</span>
                    <a href="{{ $college->website }}" target="_blank" rel="noopener noreferrer"
                        class="text-decoration-none" style="color:var(--green);">
                        <i class="bi bi-globe2 me-1"></i>Website
                    </a>
                    @endif
                </p>

                {{-- CTA Buttons --}}
                <div class="d-flex flex-wrap gap-2">
                    <a href="tel:{{ $siteSettings['general.support_phone'] ?? '' }}"
                        class="c-btn c-btn--navy">
                        <i class="bi bi-telephone-fill"></i>
                        Get in Touch
                    </a>
                    @if($college->brochure_pdf)
                    <a href="{{ asset('storage/' . $college->brochure_pdf) }}"
                        target="_blank" class="c-btn c-btn--gold">
                        <i class="bi bi-download"></i>
                        Download Brochure
                    </a>
                    @endif
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $siteSettings['general.whatsapp_number'] ?? '919999999999') }}?text={{ urlencode('Hi, I want details about ' . $college->name . ' admission. Please guide me.') }}"
                        target="_blank" class="c-btn c-btn--green">
                        <i class="bi bi-whatsapp"></i>
                        WhatsApp
                    </a>
                </div>

            </div>

            {{-- Right: Admission Form Card --}}
            <div class="col-md-4 col-lg-4 col-xl-4 c-admission-col" id="admissionForm">
                <div class="c-admission-card" style="position:sticky;top:90px;">
                    <h5 class="fw-800 mb-1" style="color:var(--navy);font-size:1.1rem;font-weight:800;">
                        <i class="bi bi-person-check-fill me-2" style="color:var(--green);"></i>
                        Get Free 1-on-1 Counselling
                    </h5>
                    <p class="text-muted mb-3" style="font-size:.76rem;">
                        Expert counsellors will guide you through admission, fees & scholarships.
                    </p>

                    <form id="leadForm" action="{{ route('lead.submit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="college_id" value="{{ $college->id }}">
                        <input type="hidden" name="source" value="college_detail_page">

                        <div class="mb-2">
                            <input type="text" name="name" class="form-control c-form-field"
                                placeholder="Your Full Name *" required>
                        </div>
                        <div class="mb-2">
                            <input type="tel" name="phone" class="form-control c-form-field"
                                placeholder="WhatsApp Mobile Number *" required>
                        </div>
                        <div class="mb-2">
                            <input type="email" name="email" class="form-control c-form-field"
                                placeholder="Email Address">
                        </div>
                        <div class="mb-2">
                            <select name="course_id" class="form-select c-form-field" required>
                                <option value="">Select Course *</option>
                                @foreach($college->collegeCourses as $cc)
                                <option value="{{ $cc->course_id }}">
                                    {{ $cc->course->name }}
                                    @if($cc->specialization) — {{ $cc->specialization }} @endif
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <select name="state" id="formState" class="form-select c-form-field" required>
                                <option value="">Current State *</option>
                                @foreach(\App\Models\State::where('status', true)->orderBy('name')->get() as $st)
                                <option value="{{ $st->name }}" data-id="{{ $st->id }}">{{ $st->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <select name="city" id="formCity" class="form-select c-form-field" required>
                                <option value="">Current City *</option>
                            </select>
                        </div>

                        <div id="leadFormMsg"></div>

                        <button type="submit" id="leadFormBtn" class="c-form-submit">
                            <i class="bi bi-send-fill me-1"></i>
                            Get Free Counselling
                        </button>

                        <p class="text-center text-muted mt-2 mb-0" style="font-size:.7rem;">
                            By submitting you agree to our
                            <a href="#" class="text-dark fw-bold text-decoration-none">Terms of Use</a>
                        </p>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ──────────────────────────────────────────────────────────────────
     MAIN CONTENT — Left Sticky Nav + Content Blocks
────────────────────────────────────────────────────────────────── --}}
<div class="container-fluid px-3 px-md-4 py-4 c-detail-main" style="max-width:1600px;">
    <div class="row g-4">

        {{-- ── LEFT: Fixed Quick Jump Side Drawer ───────────────────── --}}
        <div class="col-md-2 col-lg-2 d-none d-md-block c-quick-jump-col">
            <nav class="c-nav" aria-label="Section navigation">
                <span class="c-nav__label">Quick Jump</span>
                @foreach($quickNav as $i => $nav)
                <a class="c-nav__link {{ $i === 0 ? 'active' : '' }}"
                    data-target="{{ $nav['id'] }}" role="button">
                    <i class="bi {{ $nav['icon'] }}"></i>
                    <span>{{ $nav['title'] }}</span>
                </a>
                @endforeach
            </nav>
        </div>

        {{-- ── RIGHT: Content Blocks ─────────────────────────────────── --}}
        <div class="col-md-10 col-lg-10">

            {{-- ══ 1. OVERVIEW ══════════════════════════════════════════ --}}
            <div class="c-block" id="sec-overview">
                <h2 class="c-block__title">
                    <i class="bi bi-info-circle-fill" style="color:var(--gold);"></i>
                    About {{ $college->name }}
                </h2>
                <p class="mb-0 text-secondary" style="line-height:1.85;font-size:.9rem;">
                    {{ $college->overview
                        ?? $college->name . ' is a premier institution located in '
                           . $college->city . ', ' . $college->state
                           . '. Offering industry-aligned programmes with experienced faculty, modern research facilities, and dedicated career placement support.' }}
                </p>
            </div>

            {{-- ══ 2. QUICK FACTS TABLE ════════════════════════════════ --}}
            <div class="c-block" id="sec-quickfacts">
                <h2 class="c-block__title">
                    <i class="bi bi-table" style="color:var(--gold);"></i>
                    Quick Facts &amp; Snapshot
                </h2>
                <div class="c-table-scroll">
                    <table class="tbl-yellow">
                        <thead>
                            <tr>
                                <th style="width:38%;">Particulars</th>
                                <th>Statistics &amp; Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold text-muted">Mode of Education</td>
                                <td><strong>{{ ucfirst($college->college_mode) }} Mode</strong></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">University Type</td>
                                <td>{{ $college->college_type }} University</td>
                            </tr>
                            @if($college->established_year)
                            <tr>
                                <td class="fw-semibold text-muted">Year of Establishment</td>
                                <td>{{ $college->established_year }}</td>
                            </tr>
                            @endif
                            @if($college->university_name)
                            <tr>
                                <td class="fw-semibold text-muted">Affiliated / Parent University</td>
                                <td>{{ $college->university_name }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="fw-semibold text-muted">Approvals &amp; Accreditations</td>
                                <td>
                                    <span class="c-badge c-badge--green">
                                        {{ $college->approvals ?? 'UGC / AICTE / DEB Approved' }}
                                    </span>
                                </td>
                            </tr>
                            @if($college->naac_grade)
                            <tr>
                                <td class="fw-semibold text-muted">NAAC Grade</td>
                                <td>
                                    <strong style="color:var(--green-dk);">{{ $college->naac_grade }}</strong>
                                    @if($college->ugc_approved)
                                    &nbsp;
                                    <span class="c-badge c-badge--green" style="font-size:.65rem;">UGC Approved</span>
                                    @endif
                                </td>
                            </tr>
                            @endif
                            @if($college->nirf_rank)
                            <tr>
                                <td class="fw-semibold text-muted">NIRF Ranking {{ $college->nirf_year ? '(' . $college->nirf_year . ')' : '' }}</td>
                                <td><strong>{{ $college->nirf_rank }}</strong></td>
                            </tr>
                            @endif
                            <tr>
                                <td class="fw-semibold text-muted">Campus Location</td>
                                <td>
                                    {{ $college->city }}, {{ $college->state }}
                                    @if($college->campus_size)
                                    &nbsp;<span class="text-muted small">({{ $college->campus_size }})</span>
                                    @endif
                                </td>
                            </tr>
                            @if($college->entrance_exams)
                            <tr>
                                <td class="fw-semibold text-muted">Entrance Exams Accepted</td>
                                <td>{{ $college->entrance_exams }}</td>
                            </tr>
                            @endif
                            @if($college->highest_package)
                            <tr>
                                <td class="fw-semibold text-muted">Highest Salary Package</td>
                                <td><strong style="color:var(--green);">{{ $college->highest_package }}</strong></td>
                            </tr>
                            @endif
                            @if($college->average_package)
                            <tr>
                                <td class="fw-semibold text-muted">Average Salary Package</td>
                                <td><strong>{{ $college->average_package }}</strong></td>
                            </tr>
                            @endif
                            @if($college->isRegular())
                            <tr>
                                <td class="fw-semibold text-muted">Hostel Facilities</td>
                                <td>
                                    @if($college->has_boys_hostel)
                                    <span class="c-badge c-badge--dark me-1"><i class="bi bi-house"></i> Boys Hostel</span>
                                    @endif
                                    @if($college->has_girls_hostel)
                                    <span class="c-badge c-badge--dark"><i class="bi bi-house-heart"></i> Girls Hostel</span>
                                    @endif
                                    @if(! $college->has_boys_hostel && ! $college->has_girls_hostel)
                                    <span class="text-muted">Day Scholar</span>
                                    @endif
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ══ 3. KEY HIGHLIGHTS ══════════════════════════════════ --}}
            @if($college->collegeHighlights->count() > 0)
            <div class="c-block" id="sec-highlights">
                <h2 class="c-block__title">
                    <i class="bi bi-star-fill" style="color:var(--gold);"></i>
                    Key Highlights &amp; USPs
                </h2>
                <div class="row g-2">
                    @foreach($college->collegeHighlights->where('status', true) as $hl)
                    <div class="col-md-6">
                        <div class="c-highlight">
                            <i class="bi {{ $hl->icon ?? 'bi-check-circle-fill' }}"></i>
                            <div>
                                <span class="fw-semibold">{{ $hl->title }}</span>
                                @if($hl->value)
                                <span class="text-muted"> — {{ $hl->value }}</span>
                                @endif
                                @if($hl->description)
                                <div class="text-muted small mt-1">{{ $hl->description }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ══ 4. COURSES, FEES & SPECIALIZATIONS ════════════════ --}}
            @if($college->collegeCourses->count() > 0)
            <div class="c-block" id="sec-courses">
                <h2 class="c-block__title">
                    <i class="bi bi-mortarboard-fill" style="color:var(--gp-purple);"></i>
                    Courses, Fees &amp; Specializations
                </h2>

                @php
                /*
                * One course can have many specializations.
                * Group directly by course so B.Tech is rendered ONCE.
                * Stream is intentionally not displayed or used for grouping.
                */
                $courseGroups = $college->collegeCourses->groupBy(
                fn($cc) => $cc->course_id ?? $cc->course?->id ?? $cc->course?->name ?? 'course'
                );
                @endphp

                @foreach($courseGroups as $courseKey => $courseEntries)

                @php
                $baseCourse = $courseEntries->first();
                $courseModel = $baseCourse->course;

                $programRows = collect();

                foreach ($courseEntries as $entry) {
                $specFees = $entry->specializationFees->where('status', true);

                if ($specFees->count() > 0) {
                foreach ($specFees as $sf) {
                $programRows->push([
                'specialization' => $sf->specialization?->name ?? $entry->specialization ?? 'General / Core',
                'duration' => $entry->duration ?? $courseModel?->duration ?? 'N/A',
                'eligibility' => $sf->eligibility ?? $entry->eligibility ?? '10+2 or Equivalent',
                'fee_amount' => $sf->fee_amount,
                'fee_type' => $sf->fee_type,
                ]);
                }
                } else {
                $programRows->push([
                'specialization' => $entry->specialization?->name ?? $entry->specialization ?? 'General / Core',
                'duration' => $entry->duration ?? $courseModel?->duration ?? 'N/A',
                'eligibility' => $entry->eligibility ?? '10+2 or Equivalent',
                'fee_amount' => $entry->fee_amount,
                'fee_type' => $entry->fee_type,
                ]);
                }
                }

                $programRows = $programRows
                ->filter(fn($row) => !empty($row['specialization']))
                ->values();

                $stream = $baseCourse->course?->stream?->name ?? 'General';
                $courseName = $courseModel?->name ?? 'Course';
                $courseLevel = $courseModel?->level ?? null;
                $courseDuration = $baseCourse->duration ?? $courseModel?->duration ?? 'N/A';
                $courseEligibility = $baseCourse->eligibility ?? '10+2 or Equivalent';

                $courseType = $courseModel?->type
                ?? $courseModel?->course_type
                ?? 'Degree';

                /*
                * Entrance exams are stored at COLLEGE level in the current schema,
                * not on college_courses or courses.
                *
                * CollegeController loads the College model normally, so
                * $college->entrance_exams is already available here.
                */
                $entranceExams = $baseCourse->entrance_exam;
                @endphp

                <article class="gp-program-card">

                    {{-- Course header: course name appears ONLY ONCE --}}
                    <div class="gp-program-head">
                        <div class="gp-program-title-wrap">
                            <div class="gp-program-title-row">
                                <h3 class="gp-program-title">{{ $courseName }}</h3>

                            </div>

                            <div class="gp-program-meta">
                                <span>
                                    <i class="bi bi-clock-fill"></i>
                                    {{ $courseDuration }}
                                </span>
                                <span style="fs:h3">
                                    <i class="bi bi-bookmark-fill"></i>
                                    {{ $stream }}
                                </span>
                                <span>
                                    <i class="bi bi-mortarboard-fill"></i>
                                    {{ $courseLevel }}
                                </span>
                            </div>
                        </div>

                        @if($college->brochure_pdf)
                        <a href="{{ asset('storage/' . $college->brochure_pdf) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="gp-brochure-btn">
                            Brochure
                            <i class="bi bi-arrow-right-circle-fill"></i>
                        </a>
                        @endif
                    </div>

                    <div class="gp-program-info">
                        <div>
                            <span class="gp-info-label">Course Type</span>
                            <span class="gp-info-value">{{ $courseType }}</span>
                        </div>

                        <div>
                            <span class="gp-info-label">Entrance Exam</span>
                            <span class="gp-info-value">{{ $entranceExams ?: '—' }}</span>
                        </div>
                    </div>

                    {{-- All specializations of this course stay together --}}
                    <div class="gp-specialization-box">
                        <div class="gp-specialization-heading">
                            <span>{{ $courseName }}</span>
                        </div>

                        <div class="gp-specialization-scroll">
                            <table class="gp-specialization-table">
                                <thead>
                                    <tr>
                                        <th>Specialization</th>
                                        <th>Eligibility</th>
                                        <th>Duration</th>
                                        <th>Fees</th>
                                        <th class="text-center">Explore</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($programRows as $row)
                                    <tr>
                                        <td>
                                            <span class="gp-spec-name">
                                                {{ $row['specialization'] }}
                                            </span>
                                        </td>

                                        <td>
                                            {{ $row['eligibility'] }}
                                        </td>

                                        <td>
                                            {{ $row['duration'] }}
                                        </td>

                                        <td>
                                            @if(!empty($row['fee_amount']))
                                            <strong class="gp-fee">
                                                ₹{{ number_format($row['fee_amount']) }}
                                            </strong>
                                            <small class="gp-fee-type">
                                                / {{ match($row['fee_type']) {
                                                            'per_year'     => 'Per Year',
                                                            'per_semester' => 'Per Semester',
                                                            'total_course' => 'Total Course',
                                                            default        => ucwords(str_replace('_', ' ', $row['fee_type'] ?? 'Per Year'))
                                                        } }}
                                            </small>
                                            @else
                                            <span class="gp-fee-na">As per college</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <a href="#admissionForm" class="gp-apply-btn">
                                                Apply Now
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center gp-empty-row">
                                            Course details will be updated soon.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </article>
                @endforeach
            </div>
            @endif

            {{-- ══ 5. ADMISSION PROCESS ═══════════════════════════════ --}}
            @if($college->admissionSections->count() > 0 || !empty($college->admission_process))
            <div class="c-block" id="sec-admission">
                <h2 class="c-block__title">
                    <i class="bi bi-card-checklist" style="color:var(--green);"></i>
                    Admission Process
                </h2>

                @if($college->admissionSections->count() > 0)
                @foreach($college->admissionSections->where('status', true) as $section)
                @if($section->title)
                <h6 class="fw-bold mt-3 mb-2" style="color:var(--navy);font-size:.92rem;">
                    {{ $section->title }}
                </h6>
                @endif
                @if($section->content)
                <p class="text-secondary small mb-2">{!! nl2br(e($section->content)) !!}</p>
                @endif
                @php
                    $sectionItems = $section->items;

                    // The items column may be returned as a JSON string.
                    if (is_string($sectionItems)) {
                        $decodedItems = json_decode($sectionItems, true);

                        if (json_last_error() === JSON_ERROR_NONE) {
                            $sectionItems = $decodedItems;
                        } else {
                            $sectionItems = [$sectionItems];
                        }
                    }

                    // Normalize a single associative item to a list.
                    if (
                        is_array($sectionItems)
                        && (
                            array_key_exists('title', $sectionItems)
                            || array_key_exists('description', $sectionItems)
                        )
                    ) {
                        $sectionItems = [$sectionItems];
                    }

                    // Final safety guard for foreach().
                    if (!is_array($sectionItems)) {
                        $sectionItems = [];
                    }
                @endphp

                @if(!empty($sectionItems))
                @foreach($sectionItems as $idx => $item)
                <div class="c-step">
                    <span class="c-step__num">{{ $idx + 1 }}</span>
                    <div>
                        <div class="fw-semibold text-dark" style="font-size:.88rem;">
                            {{ is_array($item) ? ($item['title'] ?? '') : $item }}
                        </div>
                        @if(is_array($item) && !empty($item['description']))
                        <div class="text-muted small mt-1">{{ $item['description'] }}</div>
                        @endif
                    </div>
                </div>
                @endforeach
                @endif
                @endforeach
                @else
                <div class="c-step">
                    <span class="c-step__num">1</span>
                    <div>
                        <div class="fw-semibold text-dark" style="font-size:.88rem;">Online Application Registration</div>
                        <div class="text-muted small mt-1">Fill the online form with personal, academic and contact details.</div>
                    </div>
                </div>
                <div class="c-step">
                    <span class="c-step__num">2</span>
                    <div>
                        <div class="fw-semibold text-dark" style="font-size:.88rem;">Document Upload &amp; Verification</div>
                        <div class="text-muted small mt-1">Submit marksheets, photo ID, and qualifying degree certificates.</div>
                    </div>
                </div>
                <div class="c-step">
                    <span class="c-step__num">3</span>
                    <div>
                        <div class="fw-semibold text-dark" style="font-size:.88rem;">Fee Payment &amp; Enrollment Confirmation</div>
                        <div class="text-muted small mt-1">Complete fee payment or opt for No-Cost EMI to generate your student ID.</div>
                    </div>
                </div>
                @if(!empty($college->admission_process))
                <div class="small text-secondary mt-3">{!! nl2br(e($college->admission_process)) !!}</div>
                @endif
                @endif
            </div>
            @endif

            {{-- ══ 6. APPROVALS & ACCREDITATIONS ══════════════════════ --}}
            @if($college->accreditations->count() > 0 || !empty($college->approvals))
            <div class="c-block" id="sec-accreditations">
                <h2 class="c-block__title">
                    <i class="bi bi-shield-check" style="color:var(--gold);"></i>
                    Approvals &amp; Accreditations
                </h2>
                <div class="c-table-scroll">
                    <table class="tbl-yellow">
                        <thead>
                            <tr>
                                <th>Statutory Body / Authority</th>
                                <th>Accreditation &amp; Status</th>
                                <th>Grade / Rank</th>
                                <th>Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($college->accreditations->count() > 0)
                            @foreach($college->accreditations->where('status', true) as $acc)
                            <tr>
                                <td class="fw-bold">{{ $acc->authority }}</td>
                                <td>{{ $acc->accreditation }}</td>
                                <td>
                                    @if($acc->grade)
                                    <span class="c-badge c-badge--green">{{ $acc->grade }}</span>
                                    @elseif($acc->rank)
                                    Rank {{ $acc->rank }}
                                    @else
                                    <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $acc->year ?? '—' }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td class="fw-bold">UGC</td>
                                <td>Recognized — Section 2(f) &amp; 12(B)</td>
                                <td><span class="c-badge c-badge--green">Approved</span></td>
                                <td class="text-muted">Valid</td>
                            </tr>
                            @if($college->naac_grade)
                            <tr>
                                <td class="fw-bold">NAAC</td>
                                <td>National Assessment &amp; Accreditation Council</td>
                                <td><span class="c-badge c-badge--naac">{{ $college->naac_grade }}</span></td>
                                <td class="text-muted">{{ $college->nirf_year ?? 'Current' }}</td>
                            </tr>
                            @endif
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- ══ 7. PLACEMENTS & RECRUITERS ═════════════════════════ --}}
            @if($college->placementStats->count() > 0 || !empty($college->highest_package) || !empty($college->average_package))
            <div class="c-block" id="sec-placements">
                <h2 class="c-block__title">
                    <i class="bi bi-briefcase-fill text-danger"></i>
                    Placement Records &amp; Top Recruiters
                </h2>

                {{-- Stat cards --}}
                @php $stats = $college->placementStats->where('status', true); @endphp
                @if($stats->count() > 0)
                <div class="row g-3 mb-4">
                    @foreach($stats as $stat)
                    <div class="col-6 col-md-4 col-xl-3">
                        <div class="c-stat">
                            <div class="c-stat__value">{{ $stat->value }}</div>
                            <div class="c-stat__label">{{ $stat->label }}</div>
                            @if($stat->year || $stat->course)
                            <div class="c-stat__sub">{{ $stat->course ?? '' }} {{ $stat->year ? '(' . $stat->year . ')' : '' }}</div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="row g-3 mb-4">
                    @if($college->highest_package)
                    <div class="col-6 col-md-4">
                        <div class="c-stat">
                            <div class="c-stat__value" style="color:var(--green);">{{ $college->highest_package }}</div>
                            <div class="c-stat__label">Highest Package</div>
                        </div>
                    </div>
                    @endif
                    @if($college->average_package)
                    <div class="col-6 col-md-4">
                        <div class="c-stat">
                            <div class="c-stat__value">{{ $college->average_package }}</div>
                            <div class="c-stat__label">Average Package</div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                {{-- Recruiters --}}
                @if($college->recruiters->count() > 0)
                <h6 class="fw-bold text-muted mb-3" style="font-size:.78rem;letter-spacing:.05em;text-transform:uppercase;">
                    Top Hiring Companies
                </h6>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($college->recruiters->where('status', true) as $rec)
                    <div class="c-recruiter">
                        @if($rec->logo_url)
                        <img src="{{ $rec->logo_url }}" alt="{{ $rec->name }}">
                        @else
                        <i class="bi bi-building text-muted"></i>
                        @endif
                        {{ $rec->name }}
                    </div>
                    @endforeach
                </div>
                @elseif(!empty($college->top_recruiters))
                <div class="p-3 bg-light rounded-3">
                    <strong class="small d-block text-dark mb-1">Top Hiring Partners:</strong>
                    <p class="small text-muted mb-0">{{ $college->top_recruiters }}</p>
                </div>
                @endif
            </div>
            @endif

            {{-- ══ 8. SCHOLARSHIPS ════════════════════════════════════ --}}
            @if($college->scholarships->count() > 0 || !empty($college->scholarship_info))
            <div class="c-block" id="sec-scholarships">
                <h2 class="c-block__title">
                    <i class="bi bi-award-fill" style="color:var(--gold);"></i>
                    Scholarships &amp; Financial Support
                </h2>

                @if($college->scholarships->count() > 0)
                <div class="c-table-scroll">
                    <table class="tbl-yellow">
                        <thead>
                            <tr>
                                <th>Scholarship Name</th>
                                <th>Eligibility</th>
                                <th>Criteria</th>
                                <th>Amount / Waiver</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($college->scholarships->where('status', true) as $sch)
                            <tr>
                                <td class="fw-bold">{{ $sch->name }}</td>
                                <td class="text-muted small">{{ $sch->eligibility ?? '—' }}</td>
                                <td class="text-muted small">{{ $sch->criteria ?? '—' }}</td>
                                <td>
                                    <strong style="color:var(--green);">{{ $sch->display_amount }}</strong>
                                    @if($sch->description)
                                    <div class="text-muted small">{{ $sch->description }}</div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-secondary small mb-0" style="line-height:1.8;">{{ $college->scholarship_info }}</p>
                @endif
            </div>
            @endif

            {{-- ══ 9. SAMPLE DEGREE ══════════════════════════════════ --}}
            @if($college->certificate_url)
            <div class="c-block" id="sec-certificate">
                <h2 class="c-block__title">
                    <i class="bi bi-patch-check-fill" style="color:var(--green);"></i>
                    Sample Degree &amp; Certification
                </h2>
                <p class="text-muted small mb-3">
                    Degrees from <strong>{{ $college->name }}</strong> carry full government approvals and are valid for government jobs, corporate hiring, and higher studies worldwide.
                </p>
                <div class="c-cert-box">
                    <img src="{{ $college->certificate_url }}"
                        class="img-fluid rounded shadow-sm"
                        style="max-height:380px;object-fit:contain;"
                        alt="Sample Certificate — {{ $college->name }}">
                </div>
            </div>
            @endif

            {{-- ══ 10. CAMPUS FACILITIES ══════════════════════════════ --}}
            @if($college->isRegular() && ($college->collegeFacilities->count() > 0 || $college->has_boys_hostel || $college->has_girls_hostel || $college->campus_size))
            <div class="c-block" id="sec-facilities">
                <h2 class="c-block__title">
                    <i class="bi bi-buildings-fill" style="color:#0EA5E9;"></i>
                    Campus Infrastructure &amp; Facilities
                </h2>

                @if($college->collegeFacilities->count() > 0)
                <div class="d-flex flex-wrap gap-2">
                    @foreach($college->collegeFacilities->where('status', true) as $fac)
                    <span class="c-badge c-badge--dark p-2">
                        <i class="bi {{ $fac->icon ?? 'bi-check-circle' }}" style="color:var(--navy);"></i>
                        {{ $fac->name }}
                    </span>
                    @endforeach
                </div>
                @else
                <div class="d-flex flex-wrap gap-2">
                    <span class="c-badge c-badge--dark p-2"><i class="bi bi-wifi" style="color:var(--navy);"></i> High-Speed Wi-Fi</span>
                    <span class="c-badge c-badge--dark p-2"><i class="bi bi-book" style="color:var(--green);"></i> Digital Library</span>
                    @if($college->has_boys_hostel)
                    <span class="c-badge c-badge--dark p-2"><i class="bi bi-house"></i> Boys Hostel</span>
                    @endif
                    @if($college->has_girls_hostel)
                    <span class="c-badge c-badge--dark p-2"><i class="bi bi-house-heart" style="color:#ef4444;"></i> Girls Hostel</span>
                    @endif
                    <span class="c-badge c-badge--dark p-2"><i class="bi bi-cup-hot" style="color:var(--gold);"></i> Cafeteria</span>
                    <span class="c-badge c-badge--dark p-2"><i class="bi bi-trophy" style="color:var(--gold);"></i> Sports Arena</span>
                    <span class="c-badge c-badge--dark p-2"><i class="bi bi-hospital" style="color:#0EA5E9;"></i> Medical Centre</span>
                    <span class="c-badge c-badge--dark p-2"><i class="bi bi-pc-display" style="color:var(--navy);"></i> Computer Labs</span>
                </div>
                @endif
            </div>
            @endif

            {{-- ══ 11. CAREER OUTCOMES ════════════════════════════════ --}}
            @if($college->careerOutcomes->count() > 0)
            <div class="c-block" id="sec-careers">
                <h2 class="c-block__title">
                    <i class="bi bi-person-workspace" style="color:var(--navy);"></i>
                    Career Outcomes &amp; Job Roles
                </h2>
                <div class="c-table-scroll">
                    <table class="tbl-yellow">
                        <thead>
                            <tr>
                                <th>Career Role</th>
                                <th>Industry</th>
                                <th>Avg. Salary</th>
                                <th>Salary Range</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($college->careerOutcomes->where('status', true) as $co)
                            <tr>
                                <td class="fw-bold">{{ $co->career_role }}</td>
                                <td class="text-muted small">{{ $co->industry }}</td>
                                <td><strong style="color:var(--green);">{{ $co->average_salary }}</strong></td>
                                <td class="text-muted small">{{ $co->salary_range ?? '—' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- ══ 12. FAQs ══════════════════════════════════════════ --}}
            @php $dbFaqs = $college->collegeFaqs->where('status', true); @endphp
            @if($dbFaqs->count() > 0)
            <div class="c-block" id="sec-faqs">
                <h2 class="c-block__title">
                    <i class="bi bi-question-circle-fill" style="color:var(--gold);"></i>
                    Frequently Asked Questions
                </h2>
                <div class="accordion" id="faqAccordion">
                    @foreach($dbFaqs as $idx => $faq)
                    <div class="accordion-item" style="border:1px solid var(--border);border-radius:var(--radius-sm);margin-bottom:6px;overflow:hidden;">
                        <h3 class="accordion-header">
                            <button class="accordion-button {{ $idx > 0 ? 'collapsed' : '' }} fw-semibold {{ $idx === 0 ? 'faq-first-open' : '' }}"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#faq_{{ $faq->id }}"
                                aria-expanded="{{ $idx === 0 ? 'true' : 'false' }}"
                                style="font-size:.88rem;">
                                {{ $faq->question }}
                            </button>
                        </h3>
                        <div id="faq_{{ $faq->id }}"
                            class="accordion-collapse collapse {{ $idx === 0 ? 'show' : '' }}"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-secondary" style="font-size:.86rem;line-height:1.75;">
                                {!! nl2br(e($faq->answer)) !!}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ══ 13. RELATED COLLEGES ═══════════════════════════════ --}}
            @if($relatedColleges->count() > 0)
            <div class="c-block">
                <h2 class="c-block__title">
                    <i class="bi bi-buildings" style="color:var(--navy);"></i>
                    Similar Colleges in {{ $college->state }}
                </h2>
                <div class="row g-3">
                    @foreach($relatedColleges as $rc)
                    <div class="col-sm-6 col-md-4">
                        <a href="{{ route('college.show', $rc->slug) }}" class="c-related-card">
                            <img src="{{ $rc->banner_url }}" alt="{{ $rc->name }}" loading="lazy">
                            <div class="c-related-card__body">
                                <div class="c-related-card__name">{{ $rc->name }}</div>
                                <div class="c-related-card__meta">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                    {{ $rc->city }}, {{ $rc->state }}
                                </div>
                                <div class="mt-1 d-flex align-items-center gap-2">
                                    <span class="c-badge c-badge--blue" style="font-size:.66rem;">{{ $rc->college_type }}</span>
                                    <span style="font-size:.76rem;color:var(--gold);">
                                        <i class="bi bi-star-fill"></i> {{ number_format($rc->rating, 1) }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>{{-- end col-lg-10 --}}
    </div>{{-- end row --}}
</div>{{-- end container --}}

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        /* ── Quick Jump: reliable fixed sidebar, bounded to content ─────
           The column remains in the Bootstrap grid as the anchor.
           The nav becomes fixed only while the main content is in view,
           then becomes absolute at the exact bottom of .c-detail-main. */
        const quickJumpWrap = document.querySelector('.c-detail-main');
        const quickJumpCol = document.querySelector('.c-detail-main .c-quick-jump-col');
        const quickJump = document.querySelector('.c-detail-main .c-quick-jump-col .c-nav');
        const pageFooter = document.querySelector('footer, .site-footer, #site-footer, [data-site-footer]');

        let quickJumpRaf = null;

        function updateQuickJumpDrawer() {
            if (!quickJumpWrap || !quickJumpCol || !quickJump) return;

            if (window.innerWidth < 768) {
                quickJump.classList.remove('is-fixed', 'is-end');
                quickJump.style.removeProperty('--quick-jump-width');
                quickJump.style.removeProperty('--quick-jump-left');
                quickJump.style.removeProperty('--quick-jump-end');
                return;
            }

            const headerOffset = 82;
            const bottomGap = 40;

            /* Measure before changing position so dimensions stay stable. */
            quickJump.classList.remove('is-fixed', 'is-end');

            const wrapRect = quickJumpWrap.getBoundingClientRect();
            const colRect = quickJumpCol.getBoundingClientRect();
            const navRect = quickJump.getBoundingClientRect();

            const wrapTop = wrapRect.top + window.scrollY;
            const wrapBottom = wrapRect.bottom + window.scrollY;
            const navHeight = navRect.height;

            /*
             * Never allow Quick Jump to enter the footer.
             * The main detail section is already the primary boundary, but
             * we also use the real footer position as a hard safety boundary.
             */
            let footerTop = Infinity;
            if (pageFooter) {
                const footerRect = pageFooter.getBoundingClientRect();
                footerTop = footerRect.top + window.scrollY;
            }

            const safeBottom = Math.min(wrapBottom, footerTop);
            const startScroll = Math.max(0, wrapTop - headerOffset);
            const endScroll = safeBottom - navHeight - bottomGap;
            const currentScroll = window.scrollY;

            const width = Math.round(colRect.width);
            const left = Math.round(colRect.left);

            quickJump.style.setProperty('--quick-jump-width', width + 'px');
            quickJump.style.setProperty('--quick-jump-left', left + 'px');

            if (currentScroll < startScroll) {
                /* Normal position at the top of the main detail section. */
                quickJump.style.setProperty('--quick-jump-end', '0px');
                return;
            }

            if (currentScroll >= endScroll) {
                /* Stop at the bottom of the main content, not the viewport. */
                /* Position the sidebar at the last safe point before the
                   detail section/footer boundary. */
                const safeBottomInsideWrap = Math.min(
                    quickJumpWrap.offsetHeight,
                    Math.max(0, footerTop - wrapTop)
                );

                const endTop = Math.max(
                    0,
                    Math.round(safeBottomInsideWrap - navHeight - bottomGap)
                );

                quickJump.style.setProperty('--quick-jump-end', endTop + 'px');
                quickJump.classList.add('is-end');
                return;
            }

            /* Main scrolling area: fixed like the reference layout. */
            quickJump.classList.add('is-fixed');
        }

        function scheduleQuickJumpUpdate() {
            if (quickJumpRaf) return;
            quickJumpRaf = requestAnimationFrame(() => {
                quickJumpRaf = null;
                updateQuickJumpDrawer();
            });
        }

        updateQuickJumpDrawer();
        window.addEventListener('scroll', scheduleQuickJumpUpdate, {
            passive: true
        });
        window.addEventListener('resize', scheduleQuickJumpUpdate, {
            passive: true
        });
        window.addEventListener('load', scheduleQuickJumpUpdate);

        /* ── Scroll Spy (desktop sidebar + mobile bar) ──────────────── */
        const allNavLinks = document.querySelectorAll('.c-nav__link[data-target], .c-nav-mobile__link[data-target]');
        const sectionIds = [...new Set([...allNavLinks].map(l => l.dataset.target))];
        const sections = sectionIds.map(id => document.getElementById(id)).filter(Boolean);

        allNavLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.getElementById(this.dataset.target);
                if (!target) return;
                const offset = window.innerWidth < 992 ? 58 : 0;
                const top = target.getBoundingClientRect().top + window.scrollY - offset - 10;
                window.scrollTo({
                    top,
                    behavior: 'smooth'
                });
            });
        });

        function updateActiveNav() {
            const scrollY = window.scrollY + (window.innerWidth < 992 ? 80 : 120);
            let current = sectionIds[0];
            sections.forEach(sec => {
                if (sec && sec.offsetTop <= scrollY) current = sec.id;
            });
            allNavLinks.forEach(l => {
                l.classList.toggle('active', l.dataset.target === current);
            });
        }

        window.addEventListener('scroll', updateActiveNav, {
            passive: true
        });
        updateActiveNav();

        /* ── State → City Cascade ───────────────────────────────────── */
        const stateEl = document.getElementById('formState');
        const cityEl = document.getElementById('formCity');

        if (stateEl && cityEl) {
            stateEl.addEventListener('change', function() {
                const stateId = this.options[this.selectedIndex]?.dataset?.id;
                cityEl.innerHTML = '<option value="">Loading…</option>';
                if (!stateId) {
                    cityEl.innerHTML = '<option value="">Current City *</option>';
                    return;
                }
                fetch(`/api/states/${stateId}/cities`)
                    .then(r => r.ok ? r.json() : Promise.reject())
                    .then(cities => {
                        cityEl.innerHTML = '<option value="">Current City *</option>';
                        cities.forEach(c => {
                            const opt = new Option(c.name, c.name);
                            cityEl.add(opt);
                        });
                    })
                    .catch(() => {
                        cityEl.innerHTML = '<option value="">Current City *</option>';
                    });
            });
        }

        /* ── AJAX Lead Form ─────────────────────────────────────────── */
        const form = document.getElementById('leadForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const btn = document.getElementById('leadFormBtn');
                const msg = document.getElementById('leadFormMsg');
                btn.disabled = true;
                btn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Submitting…';

                fetch("{{ route('lead.submit') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: new FormData(this),
                    })
                    .then(r => r.json())
                    .then(data => {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="bi bi-send-fill me-1"></i> Get Free Counselling';
                        if (data.status === 'success') {
                            msg.innerHTML = `<div class="alert alert-success py-2 small text-center rounded-pill mb-3">${data.message}</div>`;
                            form.reset();
                            cityEl && (cityEl.innerHTML = '<option value="">Current City *</option>');
                        } else {
                            msg.innerHTML = `<div class="alert alert-warning py-2 small text-center rounded-pill mb-3">${data.message ?? 'Please check the form.'}</div>`;
                        }
                    })
                    .catch(() => {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="bi bi-send-fill me-1"></i> Get Free Counselling';
                        msg.innerHTML = `<div class="alert alert-danger py-2 small text-center rounded-pill mb-3">Something went wrong. Please try again.</div>`;
                    });
            });
        }
    });
</script>
@endpush

@endsection