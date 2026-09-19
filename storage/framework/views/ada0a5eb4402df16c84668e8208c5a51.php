<?php $__env->startSection('title', 'Master System Settings - GrowPec Admin'); ?>
<?php $__env->startSection('header', 'Master Platform Management'); ?>



<?php $__env->startSection('content'); ?>
<style>
    .gp-settings-page {
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
        --gp-muted: #6F7D91;
        width: 100%;
        max-width: none;
        min-width: 0;
        color: var(--gp-text);
    }

    .gp-settings-page,
    .gp-settings-page * {
        box-sizing: border-box
    }

    .gp-settings-hero {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        width: 100%;
        margin: 0 0 20px;
        padding: 30px 32px;
        border-radius: 20px;
        color: #fff;
        background: linear-gradient(135deg, #001B45 0%, #002B67 58%, #174B8F 100%);
        box-shadow: 0 16px 34px rgba(0, 43, 103, .14);
    }

    .gp-settings-hero::before,
    .gp-settings-hero::after {
        content: "";
        position: absolute;
        pointer-events: none;
        border: 1px solid rgba(255, 255, 255, .13);
        border-radius: 50%;
    }

    .gp-settings-hero::before {
        width: 300px;
        height: 300px;
        right: -125px;
        bottom: -205px;
        box-shadow: 0 0 0 32px rgba(255, 255, 255, .025), 0 0 0 64px rgba(255, 255, 255, .018);
    }

    .gp-settings-hero::after {
        width: 180px;
        height: 180px;
        right: -72px;
        bottom: -112px;
    }

    .gp-settings-hero>* {
        position: relative;
        z-index: 1
    }

    .gp-settings-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 30px;
        padding: 6px 12px;
        border: 1px solid rgba(255, 255, 255, .18);
        border-radius: 999px;
        background: rgba(255, 255, 255, .09);
        color: rgba(255, 255, 255, .96);
        font-size: .63rem;
        font-weight: 850;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .gp-settings-hero h2 {
        margin: 12px 0 6px;
        font-size: 1.65rem;
        line-height: 1.15;
        font-weight: 850;
        letter-spacing: -.03em;
    }

    .gp-settings-hero p {
        max-width: 980px;
        margin: 0;
        color: rgba(255, 255, 255, .79);
        font-size: .76rem;
        line-height: 1.6;
    }

    .gp-settings-layout {
        display: grid;
        grid-template-columns: minmax(230px, 270px) minmax(0, 1fr);
        gap: 20px;
        align-items: start;
        width: 100%;
        min-width: 0;
    }

    .gp-settings-sidebar,
    .gp-settings-content {
        width: 100%;
        max-width: none;
        min-width: 0;
        border: 1px solid var(--gp-border);
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 10px 30px rgba(20, 35, 60, .055);
    }

    .gp-settings-sidebar {
        position: sticky;
        top: 92px;
        padding: 14px;
        z-index: 5;
    }

    .gp-settings-content {
        padding: 24px;
        overflow: hidden;
    }

    .gp-control-label {
        display: block;
        padding: 7px 10px 10px;
        color: #7A8799;
        font-size: .59rem;
        font-weight: 850;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .gp-settings-nav {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .gp-settings-nav .nav-link {
        width: 100%;
        min-height: 46px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border: 1px solid transparent;
        border-radius: 11px;
        background: #fff;
        color: #536177;
        font-size: .71rem;
        font-weight: 750;
        line-height: 1.3;
        text-align: left;
        transition: all .18s ease;
    }

    .gp-settings-nav .nav-link i {
        flex: 0 0 21px;
        width: 21px;
        color: #8291A5;
        font-size: .95rem;
        text-align: center;
    }

    .gp-settings-nav .nav-link:hover {
        border-color: #D8E5F2;
        background: #F5F9FD;
        color: var(--gp-navy);
        transform: translateX(2px);
    }

    .gp-settings-nav .nav-link.active {
        border-color: #B8D2EA !important;
        background: linear-gradient(135deg, #EDF5FC, #E5F0FA) !important;
        color: var(--gp-navy) !important;
        box-shadow: none !important;
    }

    .gp-settings-nav .nav-link.active i {
        color: var(--gp-green)
    }

    .gp-save-box {
        margin-top: 14px;
        padding-top: 14px;
        border-top: 1px solid var(--gp-border);
    }

    .gp-save-btn {
        width: 100%;
        min-height: 47px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 0 16px;
        border: 1px solid var(--gp-gold);
        border-radius: 11px;
        background: linear-gradient(135deg, #E0AB00, #C79200);
        color: #172033;
        font-size: .7rem;
        font-weight: 850;
        box-shadow: 0 7px 16px rgba(217, 164, 0, .2);
        transition: all .18s ease;
        cursor: pointer;
    }

    .gp-save-btn:hover {
        border-color: var(--gp-gold-dark);
        background: linear-gradient(135deg, #C79200, #B78300);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 9px 20px rgba(183, 131, 0, .22);
    }

    .gp-save-btn:active {
        transform: translateY(0)
    }

    .gp-save-btn:focus-visible {
        outline: 0;
        box-shadow: 0 0 0 4px rgba(217, 164, 0, .18);
    }

    .gp-settings-page .tab-content,
    .gp-settings-page .tab-pane {
        width: 100%;
        min-width: 0
    }

    .gp-settings-page .tab-pane>h5 {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        margin: 0 0 16px !important;
        padding: 0 0 12px !important;
        border-bottom: 1px solid var(--gp-border) !important;
        color: var(--gp-navy) !important;
        font-size: 1rem;
        line-height: 1.35;
        font-weight: 850 !important;
    }

    .gp-settings-page .tab-pane>h5 i {
        color: var(--gp-green)
    }

    .gp-settings-page .tab-pane>p.text-muted {
        margin-top: -7px;
        color: var(--gp-muted) !important;
        font-size: .68rem;
        line-height: 1.6;
    }

    .gp-settings-page h6 {
        color: var(--gp-text);
        font-size: .75rem;
        line-height: 1.4;
    }

    .gp-settings-page .form-label {
        margin-bottom: 6px;
        color: var(--gp-text);
        font-size: .68rem;
        font-weight: 800;
    }

    .gp-settings-page .form-control,
    .gp-settings-page .form-select {
        width: 100%;
        min-width: 0;
        min-height: 43px;
        border: 1px solid #D5DFEA;
        border-radius: 10px;
        background: #fff;
        color: var(--gp-text);
        font-size: .71rem;
        font-weight: 600;
    }

    .gp-settings-page textarea.form-control {
        min-height: 90px;
        resize: vertical;
    }

    .gp-settings-page .form-control::placeholder {
        color: #9AA6B6
    }

    .gp-settings-page .form-control:focus,
    .gp-settings-page .form-select:focus {
        border-color: #7DA8D4;
        box-shadow: 0 0 0 3px rgba(23, 75, 143, .09);
    }

    .gp-settings-page small.text-muted {
        color: #7A8798 !important;
        font-size: .61rem !important;
        line-height: 1.5;
    }

    .gp-settings-page .bg-light {
        background: #F8FAFC !important
    }

    .gp-settings-page .border {
        border-color: var(--gp-border) !important
    }

    .gp-settings-page .rounded-3,
    .gp-settings-page .rounded-4 {
        border-radius: 13px !important
    }

    .gp-settings-page .shadow-sm {
        box-shadow: 0 7px 20px rgba(20, 35, 60, .045) !important
    }

    .gp-settings-page .tab-pane .row {
        min-width: 0
    }

    .gp-settings-page .tab-pane .row>[class*="col-"] {
        min-width: 0
    }

    .gp-settings-page .tab-pane .p-3.bg-light.rounded-3.border,
    .gp-settings-page .tab-pane .card.p-4 {
        height: 100%;
        min-width: 0;
    }

    .gp-settings-page .tab-pane .card.p-4 {
        padding: 17px !important;
        border-color: var(--gp-border);
        border-radius: 13px !important;
    }

    .gp-settings-page .tab-pane .form-check-input {
        width: 42px;
        height: 23px;
        margin-top: 0;
        cursor: pointer;
    }

    .gp-settings-page .tab-pane .form-check-input:checked {
        border-color: var(--gp-green);
        background-color: var(--gp-green);
    }

    .gp-settings-page .tab-pane .list-group-item {
        background: transparent;
        border-color: #EAF0F5;
    }

    .gp-settings-page .btn {
        min-height: 41px;
        border-radius: 10px;
        font-weight: 800;
    }

    .gp-settings-page .btn-primary {
        border-color: var(--gp-navy);
        background: var(--gp-navy);
    }

    .gp-settings-page .btn-primary:hover {
        border-color: var(--gp-navy-dark);
        background: var(--gp-navy-dark);
    }

    .gp-settings-page .btn-warning {
        border-color: var(--gp-gold);
        background: var(--gp-gold);
        color: #172033;
    }

    .gp-settings-page .btn-outline-primary {
        border-color: #BFD3E7;
        color: var(--gp-navy);
    }

    .gp-settings-page .btn-outline-primary:hover {
        border-color: var(--gp-navy);
        background: var(--gp-navy);
        color: #fff;
    }

    .gp-settings-page .form-switch .form-check-input {
        margin-left: 0
    }

    .gp-settings-page input[type="color"] {
        flex: 0 0 48px;
        width: 48px !important;
        min-width: 48px;
        min-height: 43px;
        height: 43px;
        padding: 4px;
        border-radius: 9px;
        cursor: pointer;
    }

    .gp-settings-page .font-monospace {
        font-size: .67rem !important
    }

    .gp-settings-page .palette-preset-card {
        height: 100%;
        min-height: 92px;
        padding: 13px;
        border: 2px solid var(--gp-border);
        border-radius: 12px;
        background: #fff;
        cursor: pointer;
        transition: all .18s ease;
    }

    .gp-settings-page .palette-preset-card:hover {
        border-color: #9FBEDB;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(20, 35, 60, .07);
    }

    .gp-settings-page .palette-color-dot {
        width: 23px;
        height: 23px;
        display: block;
        border: 2px solid #fff;
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, .12);
    }

    .gp-settings-page #previewTopbar,
    .gp-settings-page #previewPrimaryBtn,
    .gp-settings-page #previewAccentBtn {
        min-height: 45px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 18px;
        border-radius: 999px;
        border: 0 !important;
        font-size: .71rem;
        font-weight: 800;
        box-shadow: 0 6px 13px rgba(20, 35, 60, .1);
    }

    .gp-settings-page #previewPrimaryBtn,
    .gp-settings-page #previewAccentBtn {
        cursor: default
    }

    .gp-settings-page .gp-ad-preview {
        width: 100%;
        min-height: 100px;
        max-height: 145px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin-top: 10px;
        padding: 7px;
        border: 1px solid var(--gp-border);
        border-radius: 10px;
        background: #F8FAFC;
    }

    .gp-settings-page .gp-ad-preview img {
        width: 100%;
        max-height: 125px;
        object-fit: cover;
        border-radius: 7px;
    }

    .gp-settings-page .settings-section-card {
        padding: 16px;
        border: 1px solid var(--gp-border);
        border-radius: 13px;
        background: #F8FAFC;
    }

    .gp-settings-page .settings-section-card+.settings-section-card {
        margin-top: 14px
    }

    @media (max-width:1199.98px) {
        .gp-settings-layout {
            grid-template-columns: minmax(210px, 240px) minmax(0, 1fr);
            gap: 15px;
        }

        .gp-settings-sidebar {
            top: 84px
        }

        .gp-settings-content {
            padding: 19px
        }

        .gp-settings-sidebar {
            padding: 11px
        }
    }

    @media (max-width:991.98px) {
        .gp-settings-layout {
            grid-template-columns: minmax(0, 1fr);
            gap: 14px;
        }

        .gp-settings-sidebar {
            position: relative;
            top: auto;
            padding: 13px;
        }

        .gp-settings-nav {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 7px;
        }

        .gp-settings-nav .nav-link {
            min-height: 47px;
        }

        .gp-save-box {
            margin-top: 12px;
            padding-top: 12px
        }

        .gp-save-btn {
            min-height: 47px
        }

        .gp-settings-content {
            padding: 18px
        }
    }

    @media (max-width:767.98px) {
        .gp-settings-hero {
            margin-bottom: 13px;
            padding: 20px 17px;
            border-radius: 15px;
        }

        .gp-settings-hero h2 {
            font-size: 1.22rem
        }

        .gp-settings-hero p {
            font-size: .68rem
        }

        .gp-settings-layout {
            gap: 12px
        }

        .gp-settings-sidebar,
        .gp-settings-content {
            border-radius: 14px
        }

        .gp-settings-sidebar {
            padding: 10px
        }

        .gp-control-label {
            padding: 5px 7px 8px
        }

        .gp-settings-nav {
            grid-template-columns: 1fr;
            gap: 5px;
        }

        .gp-settings-nav .nav-link {
            min-height: 44px;
            padding: 9px 10px;
            font-size: .68rem;
        }

        .gp-settings-content {
            padding: 13px
        }

        .gp-settings-page .tab-pane>h5 {
            font-size: .88rem;
            line-height: 1.4;
        }

        .gp-settings-page .tab-pane>p.text-muted {
            font-size: .61rem
        }

        .gp-settings-page .row.g-3,
        .gp-settings-page .row.g-4 {
            --bs-gutter-x: .75rem;
            --bs-gutter-y: .75rem;
        }

        .gp-settings-page .form-label {
            font-size: .65rem
        }

        .gp-settings-page .form-control,
        .gp-settings-page .form-select {
            min-height: 42px;
            font-size: .68rem;
        }

        .gp-settings-page textarea.form-control {
            min-height: 84px
        }

        .gp-settings-page #previewTopbar,
        .gp-settings-page #previewPrimaryBtn,
        .gp-settings-page #previewAccentBtn {
            width: 100%;
            min-height: 43px;
            font-size: .68rem;
        }

        .gp-settings-page .d-flex.justify-content-between.align-items-center {
            align-items: flex-start !important;
        }

        .gp-settings-page .tab-pane .list-group-item {
            gap: 12px;
            padding-top: 14px !important;
            padding-bottom: 14px !important;
        }

        .gp-settings-page .tab-pane .list-group-item>div:first-child {
            min-width: 0;
            padding-right: 8px;
        }

        .gp-settings-page .tab-pane .list-group-item .fw-bold {
            font-size: .72rem;
            line-height: 1.4;
        }

        .gp-settings-page .tab-pane .list-group-item small {
            display: block;
            margin-top: 3px;
        }

        .gp-settings-page .palette-preset-card {
            min-height: 80px;
        }
    }

    @media (max-width:480px) {
        .gp-settings-hero {
            padding: 17px 13px
        }

        .gp-settings-hero h2 {
            font-size: 1.08rem
        }

        .gp-settings-hero p {
            font-size: .63rem
        }

        .gp-settings-content {
            padding: 10px
        }

        .gp-settings-sidebar {
            padding: 8px
        }

        .gp-settings-page .tab-pane>h5 {
            font-size: .82rem
        }

        .gp-settings-page .tab-pane .p-3.bg-light.rounded-3.border,
        .gp-settings-page .tab-pane .card.p-4 {
            padding: 12px !important;
        }

        .gp-settings-page input[type="color"] {
            flex-basis: 44px;
            width: 44px !important;
            min-width: 44px;
            height: 42px;
        }

        .gp-settings-page .font-monospace {
            min-width: 0;
            font-size: .62rem !important;
        }

        .gp-save-btn {
            min-height: 45px
        }
    }
</style>

<style>
    /* Guaranteed page-local styling: this block is rendered inside the content section. */
    .gp-settings-page {
        width: 100% !important;
        max-width: none !important;
        min-width: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .gp-settings-page .gp-settings-layout {
        width: 100% !important;
        max-width: none !important;
        min-width: 0 !important;
    }

    .gp-settings-page .gp-settings-content {
        width: 100% !important;
        max-width: none !important;
        min-width: 0 !important;
    }

    .gp-settings-page .gp-settings-content>.tab-content,
    .gp-settings-page .gp-settings-content .tab-pane {
        width: 100% !important;
        max-width: none !important;
        min-width: 0 !important;
    }

    .gp-settings-page .row {
        width: 100%;
        max-width: none;
        min-width: 0;
    }

    .gp-settings-page [class*="col-"] {
        min-width: 0;
    }

    .gp-settings-page img {
        max-width: 100%;
    }

    .gp-settings-page input,
    .gp-settings-page select,
    .gp-settings-page textarea,
    .gp-settings-page button {
        max-width: 100%;
    }

    .gp-settings-page .form-control,
    .gp-settings-page .form-select {
        box-shadow: none;
    }

    .gp-settings-page .form-control:focus,
    .gp-settings-page .form-select:focus {
        box-shadow: 0 0 0 3px rgba(23, 75, 143, .10);
    }

    @media (max-width:991.98px) {
        .gp-settings-page .gp-settings-layout {
            display: grid !important;
            grid-template-columns: 1fr !important;
        }

        .gp-settings-page .gp-settings-sidebar,
        .gp-settings-page .gp-settings-content {
            width: 100% !important;
        }

        .gp-settings-page .gp-settings-sidebar {
            position: relative !important;
            top: auto !important;
        }
    }

    @media (max-width:767.98px) {
        .gp-settings-page .row {
            --bs-gutter-x: .75rem;
            --bs-gutter-y: .75rem;
        }
    }
</style>
<div class="gp-settings-page">
    <div class="gp-settings-hero">
        <span class="gp-settings-kicker">
            <i class="bi bi-sliders2"></i>
            GrowPec Control Center
        </span>
        <h2>Master Platform Settings</h2>
        <p>Manage website identity, contact details, theme, homepage features, advertisements and integrations from one responsive control panel.</p>
    </div>

    <form action="<?php echo e(route('admin.settings.update')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <div class="gp-settings-layout">
            <aside class="gp-settings-sidebar">
                <div>
                    <small class="gp-control-label">Control Tabs</small>

                    <div class="nav flex-column gp-settings-nav" id="settingsTab" role="tablist">
                        <button class="nav-link active text-start" id="tab-general-btn" data-bs-toggle="pill" data-bs-target="#tab-general" type="button">
                            <i class="bi bi-sliders me-2"></i> General & Branding
                        </button>
                        <!-- <button class="nav-link text-start" id="tab-features-btn" data-bs-toggle="pill" data-bs-target="#tab-features" type="button">
                            <i class="bi bi-toggles me-2"></i> Feature Controls
                        </button> -->
                        <!-- <button class="nav-link text-start" id="tab-theme-btn" data-bs-toggle="pill" data-bs-target="#tab-theme" type="button">
                            <i class="bi bi-palette-fill me-2"></i> Theme & Colors
                        </button> -->
                        <!-- <button class="nav-link text-start" id="tab-ads-btn" data-bs-toggle="pill" data-bs-target="#tab-ads" type="button">
                            <i class="bi bi-badge-ad me-2"></i> Ad Banners
                        </button> -->
                        <!-- <button class="nav-link text-start" id="tab-apis-btn" data-bs-toggle="pill" data-bs-target="#tab-apis" type="button">
                            <i class="bi bi-cpu-fill me-2"></i> APIs & Gateways
                        </button> -->
                    </div>

                    <div class="gp-save-box">
                        <button type="submit" class="gp-save-btn">
                            <i class="bi bi-check-circle me-1"></i> Save Changes
                        </button>
                    </div>
                </div>
            </aside>
            <section class="gp-settings-content">
                <div class="tab-content" id="settingsTabContent">
                    <div class="tab-pane fade show active" id="tab-general" role="tabpanel">
                        <h5 class="fw-bold text-primary mb-3 pb-2 border-bottom">
                            <i class="bi bi-sliders me-1"></i> 1. Website Branding, SEO & Contact Info
                        </h5>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Website Name *</label>
                                <input type="text" name="general___site_name" value="<?php echo e($settings['general.site_name'] ?? 'GrowPEC'); ?>" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Website Tagline</label>
                                <input type="text" name="general___site_tagline" value="<?php echo e($settings['general.site_tagline'] ?? ''); ?>" class="form-control" placeholder="e.g. Your Career Deserves A Better College">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">SEO Meta Description</label>
                            <textarea name="general___site_description" rows="2" class="form-control" placeholder="Brief summary of the portal for Google search results..."><?php echo e($settings['general.site_description'] ?? ''); ?></textarea>
                            <small class="text-muted">Appears in search engine snippets and meta tags.</small>
                        </div>
                        <h6 class="fw-bold text-dark mb-3 mt-4 pt-2 border-top">
                            <i class="bi bi-images me-1 text-warning"></i> Website Logos & Favicon Assets
                        </h6>

                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="p-3 border rounded-3 bg-light h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <strong class="small text-dark">Header Logo</strong>
                                        <span class="badge bg-white text-muted border">Navbar (Light)</span>
                                    </div>
                                    <div class="border rounded-3 p-2 text-center bg-white shadow-sm mb-2"
                                        style="height: 85px; display: flex; align-items: center; justify-content: center; overflow: hidden; background-image: radial-gradient(#E2E8F0 1px, transparent 1px); background-size: 10px 10px;">
                                        <img id="headerLogoLivePreview"
                                            src="<?php echo e(asset($settings['general.logo'] ?? 'assets/growpec.png')); ?>"
                                            alt="Header Logo"
                                            style="max-height: 55px; max-width: 100%; width: auto; height: auto; object-fit: contain; display: block; margin: 0 auto;">
                                    </div>

                                    <label class="form-label small text-muted mb-1 fw-bold">Change Header Logo</label>
                                    <input type="file" name="logo" id="headerLogoInput" class="form-control form-control-sm" accept="image/*">
                                    <small class="text-muted d-block mt-1" style="font-size: 0.72rem;">Rec: Transparent PNG (240x60 px)</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 border rounded-3 bg-light h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <strong class="small text-dark">Footer Logo</strong>
                                        <span class="badge bg-dark text-white">Footer (Dark #001B45)</span>
                                    </div>
                                    <div class="border rounded-3 p-2 text-center shadow-sm mb-2"
                                        style="height: 85px; display: flex; align-items: center; justify-content: center; overflow: hidden; background: #001B45; border-color: #174B8F !important;">
                                        <img id="footerLogoLivePreview"
                                            src="<?php echo e(asset($settings['general.footer_logo'] ?? $settings['general.logo'] ?? 'assets/growpec.png')); ?>"
                                            alt="Footer Logo"
                                            style="max-height: 55px; max-width: 100%; width: auto; height: auto; object-fit: contain; display: block; margin: 0 auto;">
                                    </div>

                                    <label class="form-label small text-muted mb-1 fw-bold">Change Footer Logo</label>
                                    <input type="file" name="footer_logo" id="footerLogoInput" class="form-control form-control-sm" accept="image/*">
                                    <small class="text-muted d-block mt-1" style="font-size: 0.72rem;">White/Light logo for dark background</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 border rounded-3 bg-light h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <strong class="small text-dark">Website Favicon</strong>
                                        <span class="badge bg-white text-muted border">Browser Tab</span>
                                    </div>
                                    <div class="border rounded-3 p-2 text-center bg-white shadow-sm mb-2"
                                        style="height: 85px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                        <div class="shadow-sm px-3 py-1 rounded-3 d-inline-flex align-items-center gap-2 border bg-light">
                                            <img id="faviconLivePreview"
                                                src="<?php echo e(asset($settings['general.favicon'] ?? 'assets/growpec.png')); ?>"
                                                style="height: 22px; width: 22px; object-fit: contain;"
                                                alt="Favicon">
                                            <span class="small fw-bold text-secondary"><?php echo e($settings['general.site_name'] ?? 'GrowPEC'); ?></span>
                                        </div>
                                    </div>

                                    <label class="form-label small text-muted mb-1 fw-bold">Change Favicon</label>
                                    <input type="file" name="favicon" id="faviconInput" class="form-control form-control-sm" accept=".png,.ico,.svg">
                                    <small class="text-muted d-block mt-1" style="font-size: 0.72rem;">Square 32x32 px or 64x64 px icon</small>
                                </div>
                            </div>
                        </div>
                        <h6 class="fw-bold text-dark mb-3 mt-4 pt-2 border-top">
                            <i class="bi bi-telephone-fill me-1 text-primary"></i> Support & Contact Details
                        </h6>
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Support Phone</label>
                                <input type="text" name="general___support_phone" value="<?php echo e($settings['general.support_phone'] ?? '+91 8858285271'); ?>" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">WhatsApp Helpline</label>
                                <input type="text" name="general___whatsapp_number" value="<?php echo e($settings['general.whatsapp_number'] ?? '918858285271'); ?>" class="form-control" placeholder="e.g. 918858285271">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Support Email</label>
                                <input type="email" name="general___support_email" value="<?php echo e($settings['general.support_email'] ?? 'info@growpec.com'); ?>" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Office Address</label>
                            <textarea name="general___office_address" rows="2" class="form-control"><?php echo e($settings['general.office_address'] ?? 'Varanasi, Uttar Pradesh, India'); ?></textarea>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-theme" role="tabpanel">
                        <h5 class="fw-bold text-primary mb-2 pb-2 border-bottom">
                            <i class="bi bi-palette-fill me-1"></i> 2. UI Theme & Color Management
                        </h5>
                        <p class="text-muted small mb-3">Pre-set curated theme par click karein ya fir individual colors ko customize karein. Text color background ke hisaab se <strong>automatically adjust</strong> hoga.</p>
                        <div class="p-3 mb-4 rounded-3 border bg-light shadow-sm">
                            <small class="text-muted fw-bold d-block mb-2 text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                                Live Automatic Contrast Preview
                            </small>

                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                <div
                                    id="previewTopbar"
                                    class="px-3 py-2 rounded-pill small fw-bold shadow-sm"
                                    data-color="<?php echo e($settings['theme.topbar_color'] ?? '#D9A400'); ?>">
                                    Top Notice Bar Phone Link
                                </div>
                                <button
                                    type="button"
                                    id="previewPrimaryBtn"
                                    class="btn btn-sm px-4 py-2 rounded-pill fw-bold shadow-sm"
                                    data-color="<?php echo e($settings['theme.primary_color'] ?? '#002B67'); ?>">
                                    Primary Button (Free Counselling)
                                </button>
                                <button
                                    type="button"
                                    id="previewAccentBtn"
                                    class="btn btn-sm px-4 py-2 rounded-pill fw-bold shadow-sm"
                                    data-color="<?php echo e($settings['theme.accent_gold'] ?? '#D9A400'); ?>">
                                    Accent Button (Apply Now)
                                </button>

                            </div>
                        </div>
                        <label class="form-label small fw-bold text-dark mb-2">🎯 Curated One-Click Color Palettes</label>
                        <div class="row g-2 mb-4">
                            <div class="col-md-4">
                                <div class="palette-preset-card" onclick="applyPalette('#002B67', '#174B8F', '#D9A400', '#D9A400', '#F5F7FA')">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong class="small text-dark">GrowPec Navy & Gold (Default)</strong>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <span class="palette-color-dot" style="background: #002B67;"></span>
                                        <span class="palette-color-dot" style="background: #174B8F;"></span>
                                        <span class="palette-color-dot" style="background: #D9A400;"></span>
                                        <span class="palette-color-dot" style="background: #F5F7FA;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="palette-preset-card" onclick="applyPalette('#0F2C59', '#1E40AF', '#F97316', '#F97316', '#F8FAFC')">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong class="small text-dark">Navy Blue & Orange</strong>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <span class="palette-color-dot" style="background: #0F2C59;"></span>
                                        <span class="palette-color-dot" style="background: #1E40AF;"></span>
                                        <span class="palette-color-dot" style="background: #F97316;"></span>
                                        <span class="palette-color-dot" style="background: #F8FAFC;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="palette-preset-card" onclick="applyPalette('#581845', '#900C3F', '#FFC300', '#FFC300', '#FAFAFA')">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong class="small text-dark">Deep Maroon & Amber</strong>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <span class="palette-color-dot" style="background: #581845;"></span>
                                        <span class="palette-color-dot" style="background: #900C3F;"></span>
                                        <span class="palette-color-dot" style="background: #FFC300;"></span>
                                        <span class="palette-color-dot" style="background: #FAFAFA;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="palette-preset-card" onclick="applyPalette('#064E3B', '#047857', '#F59E0B', '#F59E0B', '#F0FDF4')">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong class="small text-dark">Emerald Green & Gold</strong>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <span class="palette-color-dot" style="background: #064E3B;"></span>
                                        <span class="palette-color-dot" style="background: #047857;"></span>
                                        <span class="palette-color-dot" style="background: #F59E0B;"></span>
                                        <span class="palette-color-dot" style="background: #F0FDF4;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="palette-preset-card" onclick="applyPalette('#881337', '#BE123C', '#4F46E5', '#4F46E5', '#FFF1F2')">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong class="small text-dark">Crimson & Indigo</strong>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <span class="palette-color-dot" style="background: #881337;"></span>
                                        <span class="palette-color-dot" style="background: #BE123C;"></span>
                                        <span class="palette-color-dot" style="background: #4F46E5;"></span>
                                        <span class="palette-color-dot" style="background: #FFF1F2;"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label class="form-label small fw-bold text-dark mb-2">🎨 Fine-Tune Individual Color Tokens</label>
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded-3 border">
                                    <label class="form-label small fw-bold">Primary Brand Color</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" id="primaryColorPicker" name="theme___primary_color" value="<?php echo e($settings['theme.primary_color'] ?? '#002B67'); ?>" class="form-control form-control-color color-picker-box w-25">
                                        <input type="text" id="primaryColorText" class="form-control form-control-sm font-monospace" value="<?php echo e($settings['theme.primary_color'] ?? '#002B67'); ?>" readonly>
                                    </div>
                                    <small class="text-muted d-block mt-1">Navbar, Footers & Main Headings</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded-3 border">
                                    <label class="form-label small fw-bold">Secondary Accent Color</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" id="secondaryColorPicker" name="theme___secondary_purple" value="<?php echo e($settings['theme.secondary_purple'] ?? '#174B8F'); ?>" class="form-control form-control-color color-picker-box w-25">
                                        <input type="text" id="secondaryColorText" class="form-control form-control-sm font-monospace" value="<?php echo e($settings['theme.secondary_purple'] ?? '#174B8F'); ?>" readonly>
                                    </div>
                                    <small class="text-muted d-block mt-1">Subheadings, active tabs, hovers</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded-3 border">
                                    <label class="form-label small fw-bold">Accent / CTA Button Color</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" id="accentColorPicker" name="theme___accent_gold" value="<?php echo e($settings['theme.accent_gold'] ?? '#D9A400'); ?>" class="form-control form-control-color color-picker-box w-25">
                                        <input type="text" id="accentColorText" class="form-control form-control-sm font-monospace" value="<?php echo e($settings['theme.accent_gold'] ?? '#D9A400'); ?>" readonly>
                                    </div>
                                    <small class="text-muted d-block mt-1">Apply Now, View Details, Badges</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded-3 border">
                                    <label class="form-label small fw-bold">Top Notice Bar Color</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" id="topbarColorPicker" name="theme___topbar_color" value="<?php echo e($settings['theme.topbar_color'] ?? '#D9A400'); ?>" class="form-control form-control-color color-picker-box w-25">
                                        <input type="text" id="topbarColorText" class="form-control form-control-sm font-monospace" value="<?php echo e($settings['theme.topbar_color'] ?? '#D9A400'); ?>" readonly>
                                    </div>
                                    <small class="text-muted d-block mt-1">Top announcement strip</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded-3 border">
                                    <label class="form-label small fw-bold">Body Background Color</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" id="bodyBgPicker" name="theme___body_bg" value="<?php echo e($settings['theme.body_bg'] ?? '#F5F7FA'); ?>" class="form-control form-control-color color-picker-box w-25">
                                        <input type="text" id="bodyBgText" class="form-control form-control-sm font-monospace" value="<?php echo e($settings['theme.body_bg'] ?? '#F5F7FA'); ?>" readonly>
                                    </div>
                                    <small class="text-muted d-block mt-1">Light canvas background</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-features" role="tabpanel">
                        <h5 class="fw-bold text-primary mb-3 pb-2 border-bottom">
                            <i class="bi bi-toggles me-1"></i> 3. Platform Action & Feature Controls
                        </h5>

                        <div class="list-group list-group-flush mb-3">
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                                <div>
                                    <div class="fw-bold text-dark">Enable Online & Distance Universities Section</div>
                                    <small class="text-muted">Controls whether the Online Universities section and filter options are active.</small>
                                </div>
                                <div class="form-check form-switch fs-5">
                                    <input class="form-check-input" type="checkbox" name="features___enable_online_colleges" value="1" <?php echo e(($settings['features.enable_online_colleges'] ?? '1') == '1' ? 'checked' : ''); ?>>
                                </div>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                                <div>
                                    <div class="fw-bold text-dark">Partner Universities Marquee Logo Strip</div>
                                    <small class="text-muted">Turn off to completely hide the scrolling university logos banner from the homepage.</small>
                                </div>
                                <div class="form-check form-switch fs-5">
                                    <input class="form-check-input" type="checkbox" name="features___enable_partner_strip" value="1" <?php echo e(($settings['features.enable_partner_strip'] ?? '1') == '1' ? 'checked' : ''); ?>>
                                </div>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                                <div>
                                    <div class="fw-bold text-dark">Floating WhatsApp Quick Chat Button</div>
                                    <small class="text-muted">Displays sticky round WhatsApp button on the bottom-right of every user screen.</small>
                                </div>
                                <div class="form-check form-switch fs-5">
                                    <input class="form-check-input" type="checkbox" name="features___enable_floating_whatsapp" value="1" <?php echo e(($settings['features.enable_floating_whatsapp'] ?? '1') == '1' ? 'checked' : ''); ?>>
                                </div>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                                <div>
                                    <div class="fw-bold text-dark">Instant Lead Email Alerts</div>
                                    <small class="text-muted">Sends automated notification email to admin whenever a student submits an inquiry.</small>
                                </div>
                                <div class="form-check form-switch fs-5">
                                    <input class="form-check-input" type="checkbox" name="features___enable_lead_email_alert" value="1" <?php echo e(($settings['features.enable_lead_email_alert'] ?? '1') == '1' ? 'checked' : ''); ?>>
                                </div>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                                <div>
                                    <div class="fw-bold text-danger">Website Maintenance Mode</div>
                                    <small class="text-muted">Displays temporary maintenance page to public visitors while admin panel remains accessible.</small>
                                </div>
                                <div class="form-check form-switch fs-5">
                                    <input class="form-check-input" type="checkbox" name="features___maintenance_mode" value="1" <?php echo e(($settings['features.maintenance_mode'] ?? '0') == '1' ? 'checked' : ''); ?>>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-ads" role="tabpanel">
                        <h5 class="fw-bold text-primary mb-2 pb-2 border-bottom">
                            <i class="bi bi-badge-ad me-1"></i> 5. Advertisement Banners Management
                        </h5>
                        <p class="text-muted small mb-4">Website par aane wale ad banners ko yahan se manage karein. Sirf banner image upload karein aur switch se show/hide karein.</p>
                        <div class="card p-4 rounded-4 border shadow-sm mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                <div>
                                    <h6 class="fw-bold text-dark mb-0">1. Colleges Listing Page Ad Banner</h6>
                                    <small class="text-muted">Colleges feed ke beech mein (har 4 cards ke baad) scroll hone wala banner.</small>
                                </div>
                                <div class="form-check form-switch fs-5">
                                    <input class="form-check-input" type="checkbox" name="ads___enable_listing_ad" value="1" <?php echo e(($settings['ads.enable_listing_ad'] ?? '1') == '1' ? 'checked' : ''); ?>>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center">
                                <div class="col-md-7">
                                    <label class="form-label small fw-bold">Upload Listing Ad Banner Image</label>
                                    <input type="file" name="listing_banner" id="listingAdInput" class="form-control" accept="image/*">
                                    <small class="text-muted d-block mt-1">Recommended: 1200x200 px (Landscape wide banner)</small>

                                    <div class="mt-3">
                                        <label class="form-label small fw-bold">Click Action / Target Link (Optional)</label>
                                        <input type="text" name="ads___listing_banner_link" value="<?php echo e($settings['ads.listing_banner_link'] ?? ''); ?>" class="form-control form-control-sm" placeholder="e.g. tel:+918858285271 or https://wa.me/918858285271">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label small text-muted d-block fw-bold">Active Banner Preview</label>
                                    <div class="p-2 border rounded-3 bg-light text-center" style="max-height: 120px; overflow: hidden;">
                                        <img id="listingAdPreview"
                                            src="<?php echo e(asset($settings['ads.listing_banner'] ?? 'assets/hero_b1.jpg')); ?>"
                                            class="img-fluid rounded border shadow-sm w-100"
                                            style="max-height: 100px; object-fit: cover;"
                                            alt="Listing Ad">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card p-4 rounded-4 border shadow-sm">
                            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                <div>
                                    <h6 class="fw-bold text-dark mb-0">2. Homepage Mid-Page Promo Banner</h6>
                                    <small class="text-muted">Home page ke beech mein full-width attractive offer/promo image.</small>
                                </div>
                                <div class="form-check form-switch fs-5">
                                    <input class="form-check-input" type="checkbox" name="ads___enable_home_ad" value="1" <?php echo e(($settings['ads.enable_home_ad'] ?? '1') == '1' ? 'checked' : ''); ?>>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center">
                                <div class="col-md-7">
                                    <label class="form-label small fw-bold">Upload Homepage Banner Image</label>
                                    <input type="file" name="home_banner" id="homeAdInput" class="form-control" accept="image/*">
                                    <small class="text-muted d-block mt-1">Recommended: 1200x260 px</small>

                                    <div class="mt-3">
                                        <label class="form-label small fw-bold">Click Action / Target Link (Optional)</label>
                                        <input type="text" name="ads___home_banner_link" value="<?php echo e($settings['ads.home_banner_link'] ?? ''); ?>" class="form-control form-control-sm" placeholder="e.g. tel:+918858285271 or https://wa.me/918858285271">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label small text-muted d-block fw-bold">Active Banner Preview</label>
                                    <div class="p-2 border rounded-3 bg-light text-center" style="max-height: 120px; overflow: hidden;">
                                        <img id="homeAdPreview"
                                            src="<?php echo e(asset($settings['ads.home_banner'] ?? 'assets/hero_b2.jpg')); ?>"
                                            class="img-fluid rounded border shadow-sm w-100"
                                            style="max-height: 100px; object-fit: cover;"
                                            alt="Home Ad">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-apis" role="tabpanel">
                        <h5 class="fw-bold text-primary mb-3 pb-2 border-bottom">
                            <i class="bi bi-cpu me-1"></i> 4. Third-Party APIs (SMS Gateway, Firebase FCM, Analytics)
                        </h5>
                        <div class="bg-light p-3 rounded-3 border mb-4">
                            <h6 class="fw-bold text-dark mb-2"><i class="bi bi-chat-dots-fill text-warning me-1"></i> SMS & OTP Gateway Setup</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Provider</label>
                                    <select name="api___sms_provider" class="form-select form-select-sm">
                                        <option value="demo" <?php echo e(($settings['api.sms_provider'] ?? 'demo') == 'demo' ? 'selected' : ''); ?>>Demo Mode (Fixed OTP: 1234)</option>
                                        <option value="fast2sms" <?php echo e(($settings['api.sms_provider'] ?? '') == 'fast2sms' ? 'selected' : ''); ?>>Fast2SMS (India)</option>
                                        <option value="twilio" <?php echo e(($settings['api.sms_provider'] ?? '') == 'twilio' ? 'selected' : ''); ?>>Twilio SMS</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label small fw-bold">SMS API Key / Auth Token</label>
                                    <input type="password" name="api___fast2sms_key" value="<?php echo e($settings['api.fast2sms_key'] ?? ''); ?>" class="form-control form-control-sm" placeholder="Enter API auth key">
                                </div>
                            </div>
                        </div>
                        <div class="bg-light p-3 rounded-3 border mb-4">
                            <h6 class="fw-bold text-dark mb-2"><i class="bi bi-bell-fill text-danger me-1"></i> Firebase Cloud Messaging (Push Notifications)</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Firebase Project ID</label>
                                    <input type="text" name="api___fcm_project_id" value="<?php echo e($settings['api.fcm_project_id'] ?? ''); ?>" class="form-control form-control-sm" placeholder="e.g. growpec-app">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Firebase Server Key</label>
                                    <input type="password" name="api___fcm_server_key" value="<?php echo e($settings['api.fcm_server_key'] ?? ''); ?>" class="form-control form-control-sm" placeholder="Enter FCM Server Key">
                                </div>
                            </div>
                        </div>
                        <div class="bg-light p-3 rounded-3 border mb-3">
                            <h6 class="fw-bold text-dark mb-2"><i class="bi bi-graph-up text-primary me-1"></i> Google Analytics Tracking</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Measurement ID (GA4)</label>
                                    <input type="text" name="api___google_analytics_id" value="<?php echo e($settings['api.google_analytics_id'] ?? ''); ?>" class="form-control form-control-sm" placeholder="G-XXXXXXXXXX">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
        </div>
        </section>
</div>
</form>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function getContrastYIQ(hexcolor) {

        if (!hexcolor) {
            return '#FFFFFF';
        }

        hexcolor = hexcolor.replace('#', '').trim();

        // Convert 3-digit HEX to 6-digit HEX
        if (hexcolor.length === 3) {
            hexcolor =
                hexcolor[0] + hexcolor[0] +
                hexcolor[1] + hexcolor[1] +
                hexcolor[2] + hexcolor[2];
        }

        // Invalid HEX fallback
        if (hexcolor.length !== 6) {
            return '#FFFFFF';
        }

        const r = parseInt(hexcolor.substring(0, 2), 16);
        const g = parseInt(hexcolor.substring(2, 4), 16);
        const b = parseInt(hexcolor.substring(4, 6), 16);

        const yiq =
            ((r * 299) +
                (g * 587) +
                (b * 114)) / 1000;

        return yiq >= 150 ?
            '#111827' :
            '#FFFFFF';
    }

    function updateLivePreviews() {

        const primaryPicker =
            document.getElementById('primaryColorPicker');

        const accentPicker =
            document.getElementById('accentColorPicker');

        const topbarPicker =
            document.getElementById('topbarColorPicker');


        const primary =
            primaryPicker?.value || '#002B67';

        const accent =
            accentPicker?.value || '#D9A400';

        const topbar =
            topbarPicker?.value || '#D9A400';


        // --------------------------------------------------------
        // Primary Button
        // --------------------------------------------------------

        const primaryBtn =
            document.getElementById('previewPrimaryBtn');

        if (primaryBtn) {

            primaryBtn.style.backgroundColor = primary;
            primaryBtn.style.color = getContrastYIQ(primary);

            primaryBtn.setAttribute(
                'data-color',
                primary
            );
        }


        // --------------------------------------------------------
        // Accent Button
        // --------------------------------------------------------

        const accentBtn =
            document.getElementById('previewAccentBtn');

        if (accentBtn) {

            accentBtn.style.backgroundColor = accent;
            accentBtn.style.color = getContrastYIQ(accent);

            accentBtn.setAttribute(
                'data-color',
                accent
            );
        }


        // --------------------------------------------------------
        // Topbar
        // --------------------------------------------------------

        const topbarDiv =
            document.getElementById('previewTopbar');

        if (topbarDiv) {

            topbarDiv.style.backgroundColor = topbar;
            topbarDiv.style.color = getContrastYIQ(topbar);

            topbarDiv.setAttribute(
                'data-color',
                topbar
            );
        }
    }

    function applyPalette(
        primary,
        secondary,
        accent,
        topbar,
        bg
    ) {

        const primaryPicker =
            document.getElementById('primaryColorPicker');

        const primaryText =
            document.getElementById('primaryColorText');

        const secondaryPicker =
            document.getElementById('secondaryColorPicker');

        const secondaryText =
            document.getElementById('secondaryColorText');

        const accentPicker =
            document.getElementById('accentColorPicker');

        const accentText =
            document.getElementById('accentColorText');

        const topbarPicker =
            document.getElementById('topbarColorPicker');

        const topbarText =
            document.getElementById('topbarColorText');

        const bodyBgPicker =
            document.getElementById('bodyBgPicker');

        const bodyBgText =
            document.getElementById('bodyBgText');


        // Primary
        if (primaryPicker) {
            primaryPicker.value = primary;
        }

        if (primaryText) {
            primaryText.value = primary;
        }


        // Secondary
        if (secondaryPicker) {
            secondaryPicker.value = secondary;
        }

        if (secondaryText) {
            secondaryText.value = secondary;
        }


        // Accent
        if (accentPicker) {
            accentPicker.value = accent;
        }

        if (accentText) {
            accentText.value = accent;
        }


        // Topbar
        if (topbarPicker) {
            topbarPicker.value = topbar;
        }

        if (topbarText) {
            topbarText.value = topbar;
        }


        // Body Background
        if (bodyBgPicker) {
            bodyBgPicker.value = bg;
        }

        if (bodyBgText) {
            bodyBgText.value = bg;
        }


        // Update preview
        updateLivePreviews();
    }
    const colorPickerGroups = [
        'primaryColor',
        'secondaryColor',
        'accentColor',
        'topbarColor',
        'bodyBg'
    ];


    colorPickerGroups.forEach(function(id) {

        const picker =
            document.getElementById(id + 'Picker');

        const text =
            document.getElementById(id + 'Text');


        if (picker && text) {

            picker.addEventListener(
                'input',
                function() {

                    text.value = this.value;

                    updateLivePreviews();
                }
            );


            picker.addEventListener(
                'change',
                function() {

                    text.value = this.value;

                    updateLivePreviews();
                }
            );
        }
    });
    const headerLogoInput =
        document.getElementById('headerLogoInput');

    if (headerLogoInput) {

        headerLogoInput.addEventListener(
            'change',
            function() {

                const preview =
                    document.getElementById(
                        'headerLogoLivePreview'
                    );


                if (
                    this.files &&
                    this.files[0] &&
                    preview
                ) {

                    const reader =
                        new FileReader();


                    reader.onload =
                        function(event) {

                            preview.src =
                                event.target.result;
                        };


                    reader.readAsDataURL(
                        this.files[0]
                    );
                }
            }
        );
    }
    const footerLogoInput =
        document.getElementById('footerLogoInput');

    if (footerLogoInput) {

        footerLogoInput.addEventListener(
            'change',
            function() {

                const preview =
                    document.getElementById(
                        'footerLogoLivePreview'
                    );


                if (
                    this.files &&
                    this.files[0] &&
                    preview
                ) {

                    const reader =
                        new FileReader();


                    reader.onload =
                        function(event) {

                            preview.src =
                                event.target.result;
                        };


                    reader.readAsDataURL(
                        this.files[0]
                    );
                }
            }
        );
    }
    const faviconInput =
        document.getElementById('faviconInput');

    if (faviconInput) {

        faviconInput.addEventListener(
            'change',
            function() {

                const preview =
                    document.getElementById(
                        'faviconLivePreview'
                    );


                if (
                    this.files &&
                    this.files[0] &&
                    preview
                ) {

                    const reader =
                        new FileReader();


                    reader.onload =
                        function(event) {

                            preview.src =
                                event.target.result;
                        };


                    reader.readAsDataURL(
                        this.files[0]
                    );
                }
            }
        );
    }
    document.addEventListener(
        'DOMContentLoaded',
        function() {

            updateLivePreviews();

        }
    );


    document.getElementById('listingAdInput')?.addEventListener('change', function() {
        const preview = document.getElementById('listingAdPreview');
        if (this.files && this.files[0] && preview) {
            const reader = new FileReader();
            reader.onload = e => preview.src = e.target.result;
            reader.readAsDataURL(this.files[0]);
        }
    });

    document.getElementById('homeAdInput')?.addEventListener('change', function() {
        const preview = document.getElementById('homeAdPreview');
        if (this.files && this.files[0] && preview) {
            const reader = new FileReader();
            reader.onload = e => preview.src = e.target.result;
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\GrowPec Version Controll\growpec\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>