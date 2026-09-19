<?php $__env->startSection('title', $pageTitle . ' - GrowPec'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .listing-header {
        background: linear-gradient(135deg, #001B45 0%, #002B67 100%);
        color: #ffffff;
        padding: 35px 0;
    }

    .filter-sidebar {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #E5E7EB;
        padding: 20px;
        position: sticky;
        top: 90px;
        max-height: calc(100vh - 110px);
        overflow-y: auto;
    }

    .filter-sidebar::-webkit-scrollbar {
        width: 5px;
    }

    .filter-sidebar::-webkit-scrollbar-thumb {
        background: #CBD5E1;
        border-radius: 4px;
    }

    .filter-group {
        border-bottom: 1px solid #F3F4F6;
        padding-bottom: 14px;
        margin-bottom: 14px;
    }

    .filter-group:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .filter-title {
        font-weight: 700;
        font-size: 0.92rem;
        color: var(--primary-purple);
        margin-bottom: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .filter-inner-search {
        border-radius: 8px;
        font-size: 0.8rem;
        padding: 5px 10px;
        margin-bottom: 8px;
        border: 1px solid #E2E8F0;
        background: #F8FAFC;
    }

    .filter-options {
        max-height: 150px;
        overflow-y: auto;
        padding-right: 5px;
    }

    .filter-options::-webkit-scrollbar {
        width: 4px;
    }

    .filter-options::-webkit-scrollbar-thumb {
        background: #E2E8F0;
        border-radius: 4px;
    }

    .form-check-label {
        font-size: 0.84rem;
        color: #475569;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: var(--primary-purple);
        border-color: var(--primary-purple);
    }

    /* =========================================================
       🎯 NEW COLLEGE HORIZONTAL CARD (Matching Screenshot)
       ========================================================= */
    .college-horizontal-card {
        background: #ffffff;
        border: 1px solid #E5E7EB;
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.25s ease-in-out;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        margin-bottom: 22px;
    }

    .college-horizontal-card:hover {
        border-color: #002B67;
        box-shadow: 0 12px 30px rgba(46, 30, 107, 0.08);
        transform: translateY(-2px);
    }

    .college-thumb-img {
        width: 100%;
        height: 175px;
        object-fit: cover;
        border-radius: 16px;
        display: block;
    }

    .college-card-title {
        font-size: 1.35rem;
        font-weight: 700;
    }

    .college-card-title a {
        color: #002B67;
        transition: color 0.2s;
    }

    .college-card-title a:hover {
        color: #006B35;
    }

    .badge-pill-item {
        border: 1px solid #CBD5E1;
        border-radius: 8px;
        padding: 5px 14px;
        font-size: 0.82rem;
        font-weight: 600;
        color: #334155;
        background: #ffffff;
        display: inline-flex;
        align-items: center;
    }

    .btn-view-details {
        background: #D9A400 !important;
        color: #17120a !important;
        font-weight: 700 !important;
        border-radius: 30px !important;
        padding: 9px 24px !important;
        font-size: 0.9rem !important;
        border: none !important;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-view-details:hover {
        background: #B78300 !important;
        color: #17120a !important;
        transform: translateY(-1px);
    }

    .btn-free-counselling {
        background: #002B67 !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        border-radius: 30px !important;
        padding: 9px 24px !important;
        font-size: 0.9rem !important;
        border: none !important;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
    }

    .btn-free-counselling:hover {
        background: #001B45 !important;
        color: #ffffff !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 15px rgba(46, 30, 107, 0.25);
    }

    @media (max-width: 767.98px) {
        .college-thumb-img {
            height: 190px;
        }

        .btn-view-details,
        .btn-free-counselling {
            width: 100%;
            justify-content: center;
        }
    }

    /* =========================================================
   GROWPEC — COLLEGE LISTING PREMIUM RESPONSIVE REDESIGN
   Desktop / Laptop / Tablet / Mobile
   Mobile filters -> toggle panel
   ========================================================= */

    .listing-header {
        position: relative;
        overflow: hidden;
        padding: 42px 0 38px;
        background:
            radial-gradient(circle at 90% 10%, rgba(245, 166, 35, .16), transparent 24%),
            linear-gradient(135deg, #001B45 0%, #2e1e6b 58%, #005C32 100%);
    }

    .listing-header::after {
        content: "";
        position: absolute;
        width: 330px;
        height: 330px;
        right: -150px;
        bottom: -210px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .055);
    }

    .listing-header .container {
        position: relative;
        z-index: 2;
    }

    .listing-header .breadcrumb {
        opacity: .9;
    }

    .listing-header h2 {
        font-size: clamp(1.65rem, 3vw, 2.45rem);
        letter-spacing: -.035em;
    }

    .filter-sidebar {
        border: 1px solid #DCE7EF;
        border-radius: 20px;
        padding: 19px;
        box-shadow: 0 10px 30px rgba(38, 28, 65, .07) !important;
        background: rgba(255, 255, 255, .98);
    }

    .filter-title {
        color: #2e1e6b;
        font-weight: 800;
    }

    .filter-group {
        padding-bottom: 16px;
        margin-bottom: 16px;
        border-bottom-color: #E7EEF2;
    }

    .filter-inner-search {
        border-radius: 10px;
        background: #F7FAFB;
        border-color: #DCE7EF;
    }

    .filter-options {
        scrollbar-width: thin;
    }

    .form-check {
        padding: 4px 0 4px 1.65em;
    }

    .form-check-input {
        margin-top: .2em;
    }

    .form-check-label {
        font-size: .82rem;
    }

    .form-check-input:checked {
        background-color: #4b2e83;
        border-color: #4b2e83;
    }

    /* Results */
    .college-horizontal-card {
        position: relative;
        margin-bottom: 18px;
        border: 1px solid #E1E8EE;
        border-radius: 22px;
        background: #fff;
        box-shadow: 0 7px 24px rgba(35, 25, 58, .055);
        transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
    }

    .college-horizontal-card:hover {
        transform: translateY(-4px);
        border-color: rgba(75, 46, 131, .16);
        box-shadow: 0 16px 34px rgba(35, 25, 58, .11);
    }

    .college-thumb-img {
        height: 180px;
        border-radius: 16px;
        object-fit: cover;
        transition: transform .45s ease;
    }

    .college-horizontal-card:hover .college-thumb-img {
        transform: scale(1.025);
    }

    .college-card-title {
        margin-bottom: 9px !important;
        font-size: clamp(1.05rem, 2vw, 1.32rem);
        line-height: 1.3;
        letter-spacing: -.015em;
    }

    .college-card-title a {
        color: #2e1e6b;
    }

    .badge-pill-item {
        border: 1px solid #DCE7EF;
        border-radius: 999px;
        padding: 6px 12px;
        background: #F7FAFB;
        color: #4b4654;
        font-size: .76rem;
    }

    .btn-view-details,
    .btn-free-counselling {
        min-height: 42px;
        padding: 9px 20px !important;
        font-size: .82rem !important;
    }

    /* Desktop/mobile filter controls */
    .mobile-filter-toggle,
    .mobile-results-summary {
        display: none;
    }

    /* Tablet */
    @media (max-width: 991.98px) {
        .listing-header {
            padding: 34px 0 30px;
        }

        .filter-sidebar {
            position: static;
            max-height: none;
        }

        .college-thumb-img {
            height: 190px;
        }

        .college-card-title {
            font-size: 1.08rem;
        }
    }

    /* Mobile */
    @media (max-width: 767.98px) {
        .listing-header {
            padding: 27px 0 25px;
        }

        .listing-header h2 {
            font-size: 1.55rem;
        }

        .listing-header p {
            font-size: .76rem !important;
        }

        .listing-header .breadcrumb {
            font-size: .72rem;
        }

        .mobile-filter-toggle {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 48px;
            margin-bottom: 10px;
            padding: 0 15px;
            border: 1px solid #DCE7EF;
            border-radius: 14px;
            background: #fff;
            color: #2e1e6b;
            font-size: .86rem;
            font-weight: 800;
            box-shadow: 0 5px 18px rgba(38, 28, 65, .06);
        }

        .mobile-filter-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 21px;
            height: 21px;
            margin-left: 5px;
            padding: 0 6px;
            border-radius: 999px;
            background: #D9A400;
            color: #10200F;
            font-size: .66rem;
            vertical-align: middle;
        }

        .filter-toggle-icon {
            transition: transform .25s ease;
        }

        .mobile-filter-toggle.is-open .filter-toggle-icon {
            transform: rotate(180deg);
        }

        .mobile-filter-panel {
            display: none;
        }

        .mobile-filter-panel.is-open {
            display: block;
        }

        .filter-sidebar {
            max-height: none;
            overflow: visible;
            padding: 15px;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(38, 28, 65, .08) !important;
        }

        .filter-sidebar .filter-group {
            padding-bottom: 13px;
            margin-bottom: 13px;
        }

        .filter-options {
            max-height: 130px;
        }

        .filter-sidebar .btn-purple {
            min-height: 44px;
            border-radius: 999px;
        }

        .mobile-results-summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 13px;
            padding: 11px 13px;
            border: 1px solid #E1E8EE;
            border-radius: 14px;
            background: #F7FAFB;
        }

        .mobile-results-summary strong {
            display: block;
            color: #2e1e6b;
            font-size: .92rem;
            line-height: 1.1;
        }

        .mobile-results-summary span {
            color: #777080;
            font-size: .68rem;
        }

        .college-horizontal-card {
            margin-bottom: 15px;
            border-radius: 18px;
        }

        .college-horizontal-card>.row {
            display: block;
        }

        .college-horizontal-card .col-md-4,
        .college-horizontal-card .col-md-8 {
            width: 100%;
        }

        .college-horizontal-card .col-md-4 {
            padding: 10px 10px 0 !important;
        }

        .college-thumb-img {
            width: 100%;
            height: 165px;
            border-radius: 14px;
        }

        .college-horizontal-card .col-md-8 {
            padding: 14px 14px 15px !important;
        }

        .college-card-title {
            font-size: 1rem;
            line-height: 1.35;
            margin-bottom: 8px !important;
        }

        .college-horizontal-card .d-flex.gap-3 {
            gap: 7px !important;
            font-size: .69rem !important;
            line-height: 1.35;
            margin-bottom: 10px !important;
        }

        .badge-pill-item {
            padding: 5px 9px;
            font-size: .66rem;
        }

        .college-horizontal-card .d-flex.justify-content-md-end {
            display: grid !important;
            grid-template-columns: 1fr 1fr;
            gap: 8px !important;
            margin-top: 4px;
        }

        .btn-view-details,
        .btn-free-counselling {
            width: 100%;
            min-height: 40px;
            justify-content: center;
            padding: 8px 9px !important;
            font-size: .72rem !important;
        }

        .pagination {
            flex-wrap: wrap;
            justify-content: center;
            gap: 3px;
        }
    }

    /* Very small phones */
    @media (max-width: 400px) {
        .college-thumb-img {
            height: 145px;
        }

        .college-horizontal-card .d-flex.justify-content-md-end {
            grid-template-columns: 1fr;
        }

        .btn-view-details,
        .btn-free-counselling {
            min-height: 42px;
        }
    }


    /* =========================================================
   MOBILE FILTER — RIGHT SIDE DRAWER + BOTTOM CENTER BUTTON
   ========================================================= */
    .mobile-bottom-filter,
    .mobile-filter-overlay {
        display: none;
    }

    @media (max-width: 767.98px) {
        .mobile-filter-toggle {
            display: none !important;
        }

        .mobile-filter-panel {
            position: fixed !important;
            top: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: min(88vw, 380px) !important;
            height: 100dvh !important;
            z-index: 1060 !important;
            display: block !important;
            background: #fff !important;
            overflow-y: auto !important;
            overscroll-behavior: contain;
            transform: translateX(105%);
            visibility: hidden;
            box-shadow: -14px 0 38px rgba(25, 18, 48, .22);
            transition: transform .32s cubic-bezier(.22, .75, .25, 1), visibility .32s ease;
        }

        .mobile-filter-panel.is-open {
            transform: translateX(0);
            visibility: visible;
        }

        .mobile-filter-panel .filter-sidebar {
            min-height: 100%;
            margin: 0 !important;
            padding: 22px 18px 105px !important;
            border: 0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
        }

        .mobile-filter-panel .filter-sidebar>.d-flex {
            position: sticky;
            top: -22px;
            z-index: 5;
            margin: -22px -18px 18px !important;
            padding: 17px 18px !important;
            background: rgba(255, 255, 255, .96);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #eee9f4 !important;
        }

        .mobile-filter-overlay {
            position: fixed;
            inset: 0;
            z-index: 1050;
            display: block;
            background: rgba(20, 14, 38, .48);
            opacity: 0;
            visibility: hidden;
            transition: opacity .28s ease, visibility .28s ease;
        }

        .mobile-filter-overlay.is-open {
            opacity: 1;
            visibility: visible;
        }

        .mobile-bottom-filter {
            position: fixed;
            left: 50%;
            bottom: max(18px, env(safe-area-inset-bottom));
            transform: translateX(-50%);
            z-index: 1040;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-width: 132px;
            height: 48px;
            padding: 0 18px;
            border: 0;
            border-radius: 999px;
            background: linear-gradient(135deg, #002B67, #008A43);
            color: #fff;
            font-size: .82rem;
            font-weight: 800;
            box-shadow: 0 10px 25px rgba(46, 30, 107, .28);
            cursor: pointer;
        }

        .mobile-bottom-filter:active {
            transform: translateX(-50%) scale(.97);
        }

        .mobile-bottom-filter i {
            font-size: 1rem;
        }

        .mobile-bottom-filter .mobile-filter-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 21px;
            height: 21px;
            padding: 0 6px;
            border-radius: 999px;
            background: #D9A400;
            color: #10200F;
            font-size: .65rem;
            font-weight: 900;
        }

        body.filter-drawer-open {
            overflow: hidden;
        }

        .mobile-results-summary {
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }
    }

    @media (max-width: 380px) {
        .mobile-filter-panel {
            width: 92vw !important;
        }

        .mobile-bottom-filter {
            min-width: 124px;
            height: 46px;
        }
    }


    /* =========================================================
   GROWPEC LOGO COLOR MATCH
   Navy + Green + Gold
   ========================================================= */
    :root {
        --primary-purple: #002B67;
        --primary-dark: #001B45;
        --accent-gold: #D9A400;
        --accent-gold-hover: #B78300;

        --growpec-navy: #002B67;
        --growpec-navy-dark: #001B45;
        --growpec-green: #008A43;
        --growpec-green-dark: #006B35;
        --growpec-gold: #D9A400;
        --growpec-gold-dark: #B78300;
    }

    .listing-header {
        background:
            radial-gradient(circle at 90% 10%, rgba(217, 164, 0, .18), transparent 24%),
            linear-gradient(135deg, #001B45 0%, #002B67 58%, #005C32 100%) !important;
    }

    .filter-title,
    .college-card-title a,
    .mobile-filter-toggle,
    .mobile-results-summary strong {
        color: #002B67 !important;
    }

    .form-check-input:checked {
        background-color: #008A43 !important;
        border-color: #008A43 !important;
    }

    .btn-view-details {
        background: #D9A400 !important;
        color: #10200F !important;
    }

    .btn-view-details:hover {
        background: #B78300 !important;
        color: #10200F !important;
    }

    .btn-free-counselling {
        background: #002B67 !important;
    }

    .btn-free-counselling:hover {
        background: #001B45 !important;
        box-shadow: 0 6px 15px rgba(0, 43, 103, .25) !important;
    }

    .mobile-bottom-filter {
        background: linear-gradient(135deg, #002B67, #008A43) !important;
        box-shadow: 0 10px 25px rgba(0, 43, 103, .28) !important;
    }

    .mobile-filter-count {
        background: #D9A400 !important;
        color: #10200F !important;
    }

    .college-horizontal-card:hover {
        border-color: rgba(0, 138, 67, .22) !important;
        box-shadow: 0 16px 34px rgba(0, 43, 103, .11) !important;
    }

    .college-card-title a:hover {
        color: #006B35 !important;
    }

    .listing-header .breadcrumb-item a.text-warning {
        color: #D9A400 !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<!-- Header Banner -->
<div class="listing-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small text-white-50">
                <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>" class="text-warning text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?php echo e($pageTitle); ?></li>
            </ol>
        </nav>
        <h2 class="fw-bold mb-1"><?php echo e($pageTitle); ?></h2>
        <p class="text-white-50 small mb-0">Showing <?php echo e($colleges->total()); ?> institutes matching your criteria</p>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">

        <!-- Left Filter Sidebar -->
        <div class="col-lg-3">
            <form action="<?php echo e(url()->current()); ?>" method="GET" id="filterForm">
                <div id="mobileFilterPanel" class="mobile-filter-panel">
                    <div class="filter-sidebar shadow-sm">
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                            <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-funnel-fill text-warning me-1"></i> Filter By</h6>
                            <a href="<?php echo e(url()->current()); ?>" class="text-danger small fw-bold text-decoration-none">Reset All</a>
                        </div>

                        <!-- Search Input -->
                        <div class="mb-3">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control border-start-0" placeholder="Search college, city...">
                            </div>
                        </div>

                        <!-- 1. Degree Level -->
                        <div class="filter-group">
                            <div class="filter-title">1. Education Level</div>
                            <div class="filter-options">
                                <?php $__currentLoopData = ['UG' => 'Undergraduate (UG)', 'PG' => 'Postgraduate (PG)', 'Diploma' => 'Diploma', 'PhD' => 'Ph.D. / Doctorate', 'Certificate' => 'Certificate']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-check mb-1">
                                    <input class="form-check-input filter-checkbox" type="checkbox" name="levels[]" value="<?php echo e($val); ?>" id="level_<?php echo e($val); ?>" <?php echo e(in_array($val, (array)request('levels')) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="level_<?php echo e($val); ?>"><?php echo e($label); ?></label>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <!-- 2. Academic Stream -->
                        <div class="filter-group">
                            <div class="filter-title">2. Stream</div>
                            <input type="text" class="form-control form-control-sm filter-inner-search" placeholder="Search stream..." data-target="#streamFilterOptions">
                            <div class="filter-options" id="streamFilterOptions">
                                <?php $__currentLoopData = $allStreams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-check mb-1 filter-item-row">
                                    <input class="form-check-input filter-checkbox" type="checkbox" name="streams[]" value="<?php echo e($st->slug); ?>" id="stream_<?php echo e($st->id); ?>" <?php echo e(in_array($st->slug, (array)request('streams')) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="stream_<?php echo e($st->id); ?>"><?php echo e($st->name); ?></label>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <!-- 3. Course -->
                        <div class="filter-group">
                            <div class="filter-title">3. Course / Program</div>
                            <input type="text" class="form-control form-control-sm filter-inner-search" placeholder="Search course (e.g. BCA, MBA)..." data-target="#courseFilterOptions">
                            <div class="filter-options" id="courseFilterOptions">
                                <?php $__currentLoopData = $allCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-check mb-1 filter-item-row">
                                    <input class="form-check-input filter-checkbox" type="checkbox" name="courses[]" value="<?php echo e($c->slug); ?>" id="course_<?php echo e($c->id); ?>" <?php echo e(in_array($c->slug, (array)request('courses')) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="course_<?php echo e($c->id); ?>"><?php echo e($c->name); ?> <small class="text-muted">(<?php echo e($c->level); ?>)</small></label>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <!-- 4. Degree Type -->
                        <div class="filter-group">
                            <div class="filter-title">4. Degree Type</div>
                            <div class="filter-options">
                                <?php $__currentLoopData = ['Degree' => 'Degree Program', 'Diploma' => 'Diploma Program', 'Certificate' => 'Certificate Program']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dtVal => $dtLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-check mb-1">
                                    <input class="form-check-input filter-checkbox" type="checkbox" name="degree_types[]" value="<?php echo e($dtVal); ?>" id="dt_<?php echo e($dtVal); ?>" <?php echo e(in_array($dtVal, (array)request('degree_types')) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="dt_<?php echo e($dtVal); ?>"><?php echo e($dtLabel); ?></label>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <!-- 5. Course Duration -->
                        <?php if($allDurations->count() > 0): ?>
                        <div class="filter-group">
                            <div class="filter-title">5. Course Duration</div>
                            <div class="filter-options">
                                <?php $__currentLoopData = $allDurations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-check mb-1">
                                    <input class="form-check-input filter-checkbox" type="checkbox" name="durations[]" value="<?php echo e($dur); ?>" id="dur_<?php echo e($loop->index); ?>" <?php echo e(in_array($dur, (array)request('durations')) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="dur_<?php echo e($loop->index); ?>"><?php echo e($dur); ?></label>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- 6. State -->
                        <div class="filter-group">
                            <div class="filter-title">6. State</div>
                            <input type="text" class="form-control form-control-sm filter-inner-search" placeholder="Search state..." data-target="#stateFilterOptions">
                            <div class="filter-options" id="stateFilterOptions">
                                <?php $__currentLoopData = $allStates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-check mb-1 filter-item-row">
                                    <input class="form-check-input filter-checkbox" type="checkbox" name="states[]" value="<?php echo e($state); ?>" id="state_<?php echo e($loop->index); ?>" <?php echo e(in_array($state, (array)request('states')) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="state_<?php echo e($loop->index); ?>"><?php echo e($state); ?></label>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <!-- 7. City -->
                        <div class="filter-group">
                            <div class="filter-title">7. City</div>
                            <input type="text" class="form-control form-control-sm filter-inner-search" placeholder="Search city..." data-target="#cityFilterOptions">
                            <div class="filter-options" id="cityFilterOptions">
                                <?php $__currentLoopData = $allCities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-check mb-1 filter-item-row">
                                    <input class="form-check-input filter-checkbox" type="checkbox" name="cities[]" value="<?php echo e($city); ?>" id="city_<?php echo e($loop->index); ?>" <?php echo e(in_array($city, (array)request('cities')) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="city_<?php echo e($loop->index); ?>"><?php echo e($city); ?></label>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <!-- 8. College Type -->
                        <div class="filter-group">
                            <div class="filter-title">8. College Ownership</div>
                            <div class="filter-options">
                                <?php $__currentLoopData = ['Govt' => 'Government University', 'Private' => 'Private University', 'Deemed' => 'Deemed University', 'Autonomous' => 'Autonomous Institute']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tVal => $tLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-check mb-1">
                                    <input class="form-check-input filter-checkbox" type="checkbox" name="types[]" value="<?php echo e($tVal); ?>" id="type_<?php echo e($tVal); ?>" <?php echo e(in_array($tVal, (array)request('types')) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="type_<?php echo e($tVal); ?>"><?php echo e($tLabel); ?></label>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <!-- 9. Fee Range -->
                        <div class="filter-group">
                            <div class="filter-title">9. Annual Fee Range</div>
                            <div class="filter-options">
                                <?php
                                $feeOptions = [
                                'under_1l' => 'Less than ₹1 Lac',
                                '1l_to_2l' => '₹1 Lac - ₹2 Lac',
                                '2l_to_3l' => '₹2 Lac - ₹3 Lac',
                                '3l_to_5l' => '₹3 Lac - ₹5 Lac',
                                '5l_to_10l' => '₹5 Lac - ₹10 Lac',
                                'above_10l' => 'Greater than ₹10+ Lac',
                                ];
                                ?>
                                <?php $__currentLoopData = $feeOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fVal => $fLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-check mb-1">
                                    <input class="form-check-input filter-checkbox" type="checkbox" name="fee_ranges[]" value="<?php echo e($fVal); ?>" id="fee_<?php echo e($fVal); ?>" <?php echo e(in_array($fVal, (array)request('fee_ranges')) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="fee_<?php echo e($fVal); ?>"><?php echo e($fLabel); ?></label>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <!-- 10. Hostel Facilities -->
                        <div class="filter-group">
                            <div class="filter-title">10. Hostel Facilities</div>
                            <div class="form-check mb-1">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="boys_hostel" value="1" id="boys_hostel" <?php echo e(request('boys_hostel') ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="boys_hostel"><i class="bi bi-house text-primary me-1"></i> Boys Hostel</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="girls_hostel" value="1" id="girls_hostel" <?php echo e(request('girls_hostel') ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="girls_hostel"><i class="bi bi-house-heart text-danger me-1"></i> Girls Hostel</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-purple btn-sm w-100 mt-3 fw-bold">Apply Filters</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right Results Listing -->
        <div class="col-lg-9">
            <!-- Active Filter Badges Counter -->
            <?php
            $activeCount = count(array_filter([
            request('search'), request('levels'), request('streams'), request('courses'),
            request('degree_types'), request('durations'), request('states'), request('cities'),
            request('types'), request('fee_ranges'), request('boys_hostel'), request('girls_hostel')
            ]));
            ?>
            <?php if($activeCount > 0): ?>
            <div class="d-flex justify-content-between align-items-center mb-3 bg-white p-2 px-3 rounded-3 border">
                <small class="text-muted"><strong><?php echo e($activeCount); ?></strong> active filter(s) applied</small>
                <a href="<?php echo e(url()->current()); ?>" class="btn btn-sm btn-outline-danger py-0 px-2 small">Clear Filters</a>
            </div>
            <?php endif; ?>

            <!-- 🎯 LIST OF COLLEGES (NEW HORIZONTAL CARD DESIGN) -->
            <?php $__empty_1 = true; $__currentLoopData = $colleges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $college): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="college-horizontal-card shadow-sm">
                <div class="row g-0 align-items-center">

                    <!-- Left: College Thumbnail Image -->
                    <div class="col-md-4 p-3">
                        <a href="<?php echo e(route('college.show', $college->slug)); ?>">
                            <img src="<?php echo e($college->banner_url); ?>" class="college-thumb-img" alt="<?php echo e($college->name); ?>">
                        </a>
                    </div>

                    <!-- Right: Content Information -->
                    <div class="col-md-8 p-3 pe-md-4">

                        <!-- College Name -->
                        <h4 class="college-card-title mb-2">
                            <a href="<?php echo e(route('college.show', $college->slug)); ?>" class="text-decoration-none">
                                <?php echo e($college->name); ?>

                            </a>
                        </h4>

                        <!-- Location & Ownership Row -->
                        <div class="d-flex flex-wrap align-items-center gap-3 text-secondary small mb-3">
                            <span>
                                <i class="bi bi-geo-alt me-1 text-danger"></i> <?php echo e($college->city); ?>, <?php echo e($college->state); ?>

                            </span>
                            <span>
                                <i class="bi bi-flag me-1 text-primary"></i> <?php echo e($college->college_type); ?> University
                            </span>
                        </div>

                        <!-- Stats Badge Pills -->
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <div class="badge-pill-item">
                                <i class="bi bi-bar-chart-line text-muted me-1"></i> Total Course: <?php echo e($college->courses->count() ?: 34); ?>

                            </div>
                            <?php if($college->established_year): ?>
                            <div class="badge-pill-item">
                                <i class="bi bi-gear text-muted me-1"></i> Estd. year: <?php echo e($college->established_year); ?>

                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Action Buttons Bar -->
                        <div class="d-flex flex-wrap justify-content-md-end align-items-center gap-2">
                            <a href="<?php echo e(route('college.show', $college->slug)); ?>" class="btn btn-view-details">
                                <i class="bi bi-eye me-1"></i> View Details
                            </a>
                            <a href="tel:<?php echo e($siteSettings['general.support_phone'] ?? ''); ?>" class="btn btn-free-counselling">
                                <i class="bi bi-telephone-plus me-1"></i> Free Counseling
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-5 bg-white rounded-4 border">
                <i class="bi bi-search fs-1 text-muted d-block mb-2"></i>
                <h5 class="fw-bold text-dark">No colleges match your filters</h5>
                <p class="text-muted small">Try broadening your stream, course, or location selections.</p>
                <a href="<?php echo e(url()->current()); ?>" class="btn btn-outline-primary btn-sm">Reset All Filters</a>
            </div>
            <?php endif; ?>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                <?php echo e($colleges->links('pagination::bootstrap-5')); ?>

            </div>

        </div>
    </div>
</div>

<!-- Mobile Filter Drawer -->
<button type="button"
    class="mobile-bottom-filter"
    id="mobileFilterToggle"
    aria-expanded="false"
    aria-controls="mobileFilterPanel">
    <i class="bi bi-sliders2-vertical"></i>
    <span>Filters</span>
    <?php if($activeCount ?? 0): ?>
    <b class="mobile-filter-count"><?php echo e($activeCount); ?></b>
    <?php endif; ?>
</button>

<div class="mobile-filter-overlay" id="mobileFilterOverlay"></div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Mobile filter side drawer
    const mobileFilterToggle = document.getElementById('mobileFilterToggle');
    const mobileFilterPanel = document.getElementById('mobileFilterPanel');
    const mobileFilterOverlay = document.getElementById('mobileFilterOverlay');

    function toggleMobileFilters(forceOpen = null) {
        if (!mobileFilterToggle || !mobileFilterPanel) return;

        const shouldOpen = forceOpen === null ?
            !mobileFilterPanel.classList.contains('is-open') :
            forceOpen;

        mobileFilterPanel.classList.toggle('is-open', shouldOpen);
        mobileFilterOverlay?.classList.toggle('is-open', shouldOpen);
        document.body.classList.toggle('filter-drawer-open', shouldOpen);

        mobileFilterToggle.setAttribute(
            'aria-expanded',
            shouldOpen ? 'true' : 'false'
        );
    }

    mobileFilterToggle?.addEventListener('click', () => toggleMobileFilters());
    mobileFilterOverlay?.addEventListener('click', () => toggleMobileFilters(false));

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') toggleMobileFilters(false);
    });



    // 1. Auto-submit filter on any checkbox change
    document.querySelectorAll('.filter-checkbox').forEach(input => {
        input.addEventListener('change', () => {
            document.getElementById('filterForm').submit();
        });
    });

    // 2. Real-time Instant Search inside Filter Lists
    document.querySelectorAll('.filter-inner-search').forEach(searchBox => {
        searchBox.addEventListener('keyup', function() {
            const targetContainer = document.querySelector(this.getAttribute('data-target'));
            const term = this.value.toLowerCase().trim();
            const items = targetContainer.querySelectorAll('.filter-item-row');
            items.forEach(item => {
                const label = item.querySelector('label').innerText.toLowerCase();
                if (label.includes(term)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\GrowPec Version Controll\growpec\resources\views/colleges/index.blade.php ENDPATH**/ ?>