@extends('admin.layout')

@section('title', 'Master System Settings - GrowPec Admin')
@section('header', 'Master Platform Management')

@push('styles')
<style>
    .settings-nav .nav-link {
        color: #475569;
        font-weight: 600;
        border-radius: 12px;
        padding: 12px 18px;
        margin-bottom: 6px;
        border: none;
        transition: all 0.2s;
    }

    .settings-nav .nav-link:hover {
        background: #F1EFF8;
        color: #2E1E6B;
    }

    .settings-nav .nav-link.active {
        background: #2E1E6B !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(46, 30, 107, 0.2);
    }

    .card-setting-box {
        background: #ffffff;
        border: 1px solid #E2E8F0;
        border-radius: 18px;
        padding: 28px;
    }

    .color-picker-box {
        height: 44px;
        padding: 4px;
        border-radius: 10px;
        cursor: pointer;
    }

    /* Pre-set Color Palette Cards */
    .palette-preset-card {
        border: 2px solid #E2E8F0;
        border-radius: 14px;
        padding: 12px 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #F8FAFC;
    }

    .palette-preset-card:hover {
        border-color: #2E1E6B;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .palette-color-dot {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        display: inline-block;
        border: 2px solid #ffffff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
    }

    /* 🎯 BRANDING & LOGO CARDS CSS */
    .branding-card {
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        background: #F8FAFC;
        padding: 18px;
        transition: all 0.2s ease;
    }

    .branding-card:hover {
        border-color: #CBD5E1;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.04);
    }

    .logo-preview-stage {
        height: 85px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        border: 1px dashed #CBD5E1;
        margin-bottom: 12px;
    }

    .logo-preview-stage.light-stage {
        background: #ffffff;
        background-image: radial-gradient(#E2E8F0 1px, transparent 1px);
        background-size: 12px 12px;
    }

    .logo-preview-stage.dark-stage {
        background: #0F0A2A;
        border-color: #312E55;
    }

    .logo-display-img {
        max-height: 52px;
        max-width: 220px;
        object-fit: contain;
        display: block;
    }

    .browser-tab-preview {
        background: #E2E8F0;
        border-radius: 10px 10px 0 0;
        padding: 6px 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.78rem;
        font-weight: 600;
        color: #334155;
    }
</style>
@endpush

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
        <!-- 👈 Left Sidebar Navigation Tabs -->
        <div class="col-lg-3">
            <div class="card-setting-box shadow-sm p-3">
                <small class="text-muted fw-bold d-block mb-3 px-2 text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">Control Tabs</small>

                <div class="nav flex-column settings-nav" id="settingsTab" role="tablist">
                    <button class="nav-link active text-start" id="tab-general-btn" data-bs-toggle="pill" data-bs-target="#tab-general" type="button">
                        <i class="bi bi-sliders me-2"></i> General & SEO
                    </button>
                    <button class="nav-link text-start" id="tab-features-btn" data-bs-toggle="pill" data-bs-target="#tab-features" type="button">
                        <i class="bi bi-toggles me-2"></i> Feature Switches
                    </button>
                    <button class="nav-link text-start" id="tab-ads-btn" data-bs-toggle="pill" data-bs-target="#tab-ads" type="button">
                        <i class="bi bi-badge-ad me-2"></i> Ad Banners (Ads)
                    </button>
                    <!-- <button class="nav-link text-start" id="tab-apis-btn" data-bs-toggle="pill" data-bs-target="#tab-apis" type="button">
                        <i class="bi bi-cpu me-2"></i> APIs (OTP / FCM)
                    </button> -->
                </div>

                <div class="mt-4 pt-3 border-top px-2">
                    <button type="submit" class="btn btn-warning w-100 fw-bold shadow-sm py-2">
                        <i class="bi bi-check-circle me-1"></i> Save Changes
                    </button>
                </div>
            </div>
        </div>

        <!-- 👉 Right Settings Panes -->
        <div class="col-lg-9">
            <div class="card-setting-box shadow-sm">
                <div class="tab-content" id="settingsTabContent">

                    <!-- 1. GENERAL, BRANDING & SEO -->
                    <div class="tab-pane fade show active" id="tab-general" role="tabpanel">
                        <h5 class="fw-bold text-primary mb-3 pb-2 border-bottom">
                            <i class="bi bi-sliders me-1"></i> 1. Website Branding, SEO & Contact Info
                        </h5>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Website Name *</label>
                                <input type="text" name="general___site_name" value="{{ $settings['general.site_name'] ?? 'GrowPEC' }}" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Website Tagline</label>
                                <input type="text" name="general___site_tagline" value="{{ $settings['general.site_tagline'] ?? '' }}" class="form-control" placeholder="e.g. Your Career Deserves A Better College">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">SEO Meta Description</label>
                            <textarea name="general___site_description" rows="2" class="form-control" placeholder="Brief summary of the portal for Google search results...">{{ $settings['general.site_description'] ?? '' }}</textarea>
                            <small class="text-muted">Appears in search engine snippets and meta tags.</small>
                        </div>

                        <!-- 🎯 BRANDING & LOGOS SECTION (100% FIXED INLINE SIZING) -->
                        <h6 class="fw-bold text-dark mb-3 mt-4 pt-2 border-top">
                            <i class="bi bi-images me-1 text-warning"></i> Website Logos & Favicon Assets
                        </h6>

                        <div class="row g-3 mb-4">
                            <!-- 1. Header Logo (Light Navbar) -->
                            <div class="col-md-4">
                                <div class="p-3 border rounded-3 bg-light h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <strong class="small text-dark">Header Logo</strong>
                                        <span class="badge bg-white text-muted border">Navbar (Light)</span>
                                    </div>

                                    <!-- Constrained Stage -->
                                    <div class="border rounded-3 p-2 text-center bg-white shadow-sm mb-2"
                                        style="height: 85px; display: flex; align-items: center; justify-content: center; overflow: hidden; background-image: radial-gradient(#E2E8F0 1px, transparent 1px); background-size: 10px 10px;">
                                        <img id="headerLogoLivePreview"
                                            src="{{ asset($settings['general.logo'] ?? 'assets/growpec.png') }}"
                                            alt="Header Logo"
                                            style="max-height: 55px; max-width: 100%; width: auto; height: auto; object-fit: contain; display: block; margin: 0 auto;">
                                    </div>

                                    <label class="form-label small text-muted mb-1 fw-bold">Change Header Logo</label>
                                    <input type="file" name="logo" id="headerLogoInput" class="form-control form-control-sm" accept="image/*">
                                    <small class="text-muted d-block mt-1" style="font-size: 0.72rem;">Rec: Transparent PNG (240x60 px)</small>
                                </div>
                            </div>

                            <!-- 2. Footer Logo (Dark Footer) -->
                            <div class="col-md-4">
                                <div class="p-3 border rounded-3 bg-light h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <strong class="small text-dark">Footer Logo</strong>
                                        <span class="badge bg-dark text-white">Footer (Dark #0F0A2A)</span>
                                    </div>

                                    <!-- Constrained Stage -->
                                    <div class="border rounded-3 p-2 text-center shadow-sm mb-2"
                                        style="height: 85px; display: flex; align-items: center; justify-content: center; overflow: hidden; background: #0F0A2A; border-color: #312E55 !important;">
                                        <img id="footerLogoLivePreview"
                                            src="{{ asset($settings['general.footer_logo'] ?? $settings['general.logo'] ?? 'assets/growpec.png') }}"
                                            alt="Footer Logo"
                                            style="max-height: 55px; max-width: 100%; width: auto; height: auto; object-fit: contain; display: block; margin: 0 auto;">
                                    </div>

                                    <label class="form-label small text-muted mb-1 fw-bold">Change Footer Logo</label>
                                    <input type="file" name="footer_logo" id="footerLogoInput" class="form-control form-control-sm" accept="image/*">
                                    <small class="text-muted d-block mt-1" style="font-size: 0.72rem;">White/Light logo for dark background</small>
                                </div>
                            </div>

                            <!-- 3. Browser Favicon -->
                            <div class="col-md-4">
                                <div class="p-3 border rounded-3 bg-light h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <strong class="small text-dark">Website Favicon</strong>
                                        <span class="badge bg-white text-muted border">Browser Tab</span>
                                    </div>

                                    <!-- Constrained Stage -->
                                    <div class="border rounded-3 p-2 text-center bg-white shadow-sm mb-2"
                                        style="height: 85px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                        <div class="shadow-sm px-3 py-1 rounded-3 d-inline-flex align-items-center gap-2 border bg-light">
                                            <img id="faviconLivePreview"
                                                src="{{ asset($settings['general.favicon'] ?? 'assets/growpec.png') }}"
                                                style="height: 22px; width: 22px; object-fit: contain;"
                                                alt="Favicon">
                                            <span class="small fw-bold text-secondary">{{ $settings['general.site_name'] ?? 'GrowPEC' }}</span>
                                        </div>
                                    </div>

                                    <label class="form-label small text-muted mb-1 fw-bold">Change Favicon</label>
                                    <input type="file" name="favicon" id="faviconInput" class="form-control form-control-sm" accept=".png,.ico,.svg">
                                    <small class="text-muted d-block mt-1" style="font-size: 0.72rem;">Square 32x32 px or 64x64 px icon</small>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <h6 class="fw-bold text-dark mb-3 mt-4 pt-2 border-top">
                            <i class="bi bi-telephone-fill me-1 text-primary"></i> Support & Contact Details
                        </h6>
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Support Phone</label>
                                <input type="text" name="general___support_phone" value="{{ $settings['general.support_phone'] ?? '+91 8858285271' }}" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">WhatsApp Helpline</label>
                                <input type="text" name="general___whatsapp_number" value="{{ $settings['general.whatsapp_number'] ?? '918858285271' }}" class="form-control" placeholder="e.g. 918858285271">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Support Email</label>
                                <input type="email" name="general___support_email" value="{{ $settings['general.support_email'] ?? 'info@growpec.com' }}" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Office Address</label>
                            <textarea name="general___office_address" rows="2" class="form-control">{{ $settings['general.office_address'] ?? 'Varanasi, Uttar Pradesh, India' }}</textarea>
                        </div>
                    </div>

                    <!-- 2. UI THEME & PRE-SET COLOR PALETTES -->
                    <div class="tab-pane fade" id="tab-theme" role="tabpanel">
                        <h5 class="fw-bold text-primary mb-2 pb-2 border-bottom">
                            <i class="bi bi-palette-fill me-1"></i> 2. UI Theme & Color Management
                        </h5>
                        <p class="text-muted small mb-3">Pre-set curated theme par click karein ya fir individual colors ko customize karein. Text color background ke hisaab se <strong>automatically adjust</strong> hoga.</p>

                        <!-- Live Button Contrast Preview Box -->
                        <div class="p-3 mb-4 rounded-3 border bg-light shadow-sm">
                            <small class="text-muted fw-bold d-block mb-2 text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                                Live Automatic Contrast Preview
                            </small>

                            <div class="d-flex flex-wrap gap-3 align-items-center">

                                <!-- Topbar Preview -->
                                <div
                                    id="previewTopbar"
                                    class="px-3 py-2 rounded-pill small fw-bold shadow-sm"
                                    data-color="{{ $settings['theme.topbar_color'] ?? '#F5A623' }}">
                                    Top Notice Bar Phone Link
                                </div>

                                <!-- Primary Button Preview -->
                                <button
                                    type="button"
                                    id="previewPrimaryBtn"
                                    class="btn btn-sm px-4 py-2 rounded-pill fw-bold shadow-sm"
                                    data-color="{{ $settings['theme.primary_color'] ?? '#2E1E6B' }}">
                                    Primary Button (Free Counselling)
                                </button>

                                <!-- Accent Button Preview -->
                                <button
                                    type="button"
                                    id="previewAccentBtn"
                                    class="btn btn-sm px-4 py-2 rounded-pill fw-bold shadow-sm"
                                    data-color="{{ $settings['theme.accent_gold'] ?? '#F5A623' }}">
                                    Accent Button (Apply Now)
                                </button>

                            </div>
                        </div>

                        <!-- A. ONE-CLICK PRESET PALETTES -->
                        <label class="form-label small fw-bold text-dark mb-2">🎯 Curated One-Click Color Palettes</label>
                        <div class="row g-2 mb-4">
                            <!-- Preset 1 -->
                            <div class="col-md-4">
                                <div class="palette-preset-card" onclick="applyPalette('#2E1E6B', '#4E3797', '#F5A623', '#F5A623', '#F8F9FC')">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong class="small text-dark">Royal Purple & Gold (Default)</strong>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <span class="palette-color-dot" style="background: #2E1E6B;"></span>
                                        <span class="palette-color-dot" style="background: #4E3797;"></span>
                                        <span class="palette-color-dot" style="background: #F5A623;"></span>
                                        <span class="palette-color-dot" style="background: #F8F9FC;"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Preset 2 -->
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

                            <!-- Preset 3 -->
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

                            <!-- Preset 4 -->
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

                            <!-- Preset 5 -->
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

                        <!-- B. INDIVIDUAL COLOR PICKERS -->
                        <label class="form-label small fw-bold text-dark mb-2">🎨 Fine-Tune Individual Color Tokens</label>
                        <div class="row g-3 mb-3">
                            <!-- Primary Color -->
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded-3 border">
                                    <label class="form-label small fw-bold">Primary Brand Color</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" id="primaryColorPicker" name="theme___primary_color" value="{{ $settings['theme.primary_color'] ?? '#2E1E6B' }}" class="form-control form-control-color color-picker-box w-25">
                                        <input type="text" id="primaryColorText" class="form-control form-control-sm font-monospace" value="{{ $settings['theme.primary_color'] ?? '#2E1E6B' }}" readonly>
                                    </div>
                                    <small class="text-muted d-block mt-1">Navbar, Footers & Main Headings</small>
                                </div>
                            </div>

                            <!-- Secondary Purple -->
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded-3 border">
                                    <label class="form-label small fw-bold">Secondary Accent Color</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" id="secondaryColorPicker" name="theme___secondary_purple" value="{{ $settings['theme.secondary_purple'] ?? '#4E3797' }}" class="form-control form-control-color color-picker-box w-25">
                                        <input type="text" id="secondaryColorText" class="form-control form-control-sm font-monospace" value="{{ $settings['theme.secondary_purple'] ?? '#4E3797' }}" readonly>
                                    </div>
                                    <small class="text-muted d-block mt-1">Subheadings, active tabs, hovers</small>
                                </div>
                            </div>

                            <!-- Accent CTA Color -->
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded-3 border">
                                    <label class="form-label small fw-bold">Accent / CTA Button Color</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" id="accentColorPicker" name="theme___accent_gold" value="{{ $settings['theme.accent_gold'] ?? '#F5A623' }}" class="form-control form-control-color color-picker-box w-25">
                                        <input type="text" id="accentColorText" class="form-control form-control-sm font-monospace" value="{{ $settings['theme.accent_gold'] ?? '#F5A623' }}" readonly>
                                    </div>
                                    <small class="text-muted d-block mt-1">Apply Now, View Details, Badges</small>
                                </div>
                            </div>

                            <!-- Topbar Color -->
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded-3 border">
                                    <label class="form-label small fw-bold">Top Notice Bar Color</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" id="topbarColorPicker" name="theme___topbar_color" value="{{ $settings['theme.topbar_color'] ?? '#F5A623' }}" class="form-control form-control-color color-picker-box w-25">
                                        <input type="text" id="topbarColorText" class="form-control form-control-sm font-monospace" value="{{ $settings['theme.topbar_color'] ?? '#F5A623' }}" readonly>
                                    </div>
                                    <small class="text-muted d-block mt-1">Top announcement strip</small>
                                </div>
                            </div>

                            <!-- Body Background -->
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded-3 border">
                                    <label class="form-label small fw-bold">Body Background Color</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" id="bodyBgPicker" name="theme___body_bg" value="{{ $settings['theme.body_bg'] ?? '#F8F9FC' }}" class="form-control form-control-color color-picker-box w-25">
                                        <input type="text" id="bodyBgText" class="form-control form-control-sm font-monospace" value="{{ $settings['theme.body_bg'] ?? '#F8F9FC' }}" readonly>
                                    </div>
                                    <small class="text-muted d-block mt-1">Light canvas background</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. FEATURE SWITCHES & ACTIONS -->
                    <div class="tab-pane fade" id="tab-features" role="tabpanel">
                        <h5 class="fw-bold text-primary mb-3 pb-2 border-bottom">
                            <i class="bi bi-toggles me-1"></i> 3. Platform Action & Feature Switches
                        </h5>

                        <div class="list-group list-group-flush mb-3">
                            <!-- Toggle 2: Online Colleges Section -->
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                                <div>
                                    <div class="fw-bold text-dark">Enable Online & Distance Universities Section</div>
                                    <small class="text-muted">Controls whether the Online Universities section and filter options are active.</small>
                                </div>
                                <div class="form-check form-switch fs-5">
                                    <input class="form-check-input" type="checkbox" name="features___enable_online_colleges" value="1" {{ ($settings['features.enable_online_colleges'] ?? '1') == '1' ? 'checked' : '' }}>
                                </div>
                            </div>

                            <!-- Toggle 3: Partner Universities Marquee Strip -->
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                                <div>
                                    <div class="fw-bold text-dark">Partner Universities Marquee Logo Strip</div>
                                    <small class="text-muted">Turn off to completely hide the scrolling university logos banner from the homepage.</small>
                                </div>
                                <div class="form-check form-switch fs-5">
                                    <input class="form-check-input" type="checkbox" name="features___enable_partner_strip" value="1" {{ ($settings['features.enable_partner_strip'] ?? '1') == '1' ? 'checked' : '' }}>
                                </div>
                            </div>

                            <!-- Toggle 4: Floating WhatsApp Button -->
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                                <div>
                                    <div class="fw-bold text-dark">Floating WhatsApp Quick Chat Button</div>
                                    <small class="text-muted">Displays sticky round WhatsApp button on the bottom-right of every user screen.</small>
                                </div>
                                <div class="form-check form-switch fs-5">
                                    <input class="form-check-input" type="checkbox" name="features___enable_floating_whatsapp" value="1" {{ ($settings['features.enable_floating_whatsapp'] ?? '1') == '1' ? 'checked' : '' }}>
                                </div>
                            </div>

                            <!-- Toggle 5: Lead Email Notification -->
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                                <div>
                                    <div class="fw-bold text-dark">Instant Lead Email Alerts</div>
                                    <small class="text-muted">Sends automated notification email to admin whenever a student submits an inquiry.</small>
                                </div>
                                <div class="form-check form-switch fs-5">
                                    <input class="form-check-input" type="checkbox" name="features___enable_lead_email_alert" value="1" {{ ($settings['features.enable_lead_email_alert'] ?? '1') == '1' ? 'checked' : '' }}>
                                </div>
                            </div>

                            <!-- Toggle 6: Maintenance Mode -->
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                                <div>
                                    <div class="fw-bold text-danger">Website Maintenance Mode</div>
                                    <small class="text-muted">Displays temporary maintenance page to public visitors while admin panel remains accessible.</small>
                                </div>
                                <div class="form-check form-switch fs-5">
                                    <input class="form-check-input" type="checkbox" name="features___maintenance_mode" value="1" {{ ($settings['features.maintenance_mode'] ?? '0') == '1' ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 🎯 5. ADVERTISEMENT BANNERS (ONLY IMAGE + SHOW/HIDE) -->
                    <div class="tab-pane fade" id="tab-ads" role="tabpanel">
                        <h5 class="fw-bold text-primary mb-2 pb-2 border-bottom">
                            <i class="bi bi-badge-ad me-1"></i> 5. Advertisement Banners Management
                        </h5>
                        <p class="text-muted small mb-4">Website par aane wale ad banners ko yahan se manage karein. Sirf banner image upload karein aur switch se show/hide karein.</p>

                        <!-- Card 1: College Listing In-Feed Ad Banner -->
                        <div class="card p-4 rounded-4 border shadow-sm mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                <div>
                                    <h6 class="fw-bold text-dark mb-0">1. Colleges Listing Page Ad Banner</h6>
                                    <small class="text-muted">Colleges feed ke beech mein (har 4 cards ke baad) scroll hone wala banner.</small>
                                </div>
                                <div class="form-check form-switch fs-5">
                                    <input class="form-check-input" type="checkbox" name="ads___enable_listing_ad" value="1" {{ ($settings['ads.enable_listing_ad'] ?? '1') == '1' ? 'checked' : '' }}>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center">
                                <div class="col-md-7">
                                    <label class="form-label small fw-bold">Upload Listing Ad Banner Image</label>
                                    <input type="file" name="listing_banner" id="listingAdInput" class="form-control" accept="image/*">
                                    <small class="text-muted d-block mt-1">Recommended: 1200x200 px (Landscape wide banner)</small>

                                    <div class="mt-3">
                                        <label class="form-label small fw-bold">Click Action / Target Link (Optional)</label>
                                        <input type="text" name="ads___listing_banner_link" value="{{ $settings['ads.listing_banner_link'] ?? '' }}" class="form-control form-control-sm" placeholder="e.g. tel:+918858285271 or https://wa.me/918858285271">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label small text-muted d-block fw-bold">Active Banner Preview</label>
                                    <div class="p-2 border rounded-3 bg-light text-center" style="max-height: 120px; overflow: hidden;">
                                        <img id="listingAdPreview"
                                            src="{{ asset($settings['ads.listing_banner'] ?? 'assets/hero_b1.jpg') }}"
                                            class="img-fluid rounded border shadow-sm w-100"
                                            style="max-height: 100px; object-fit: cover;"
                                            alt="Listing Ad">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: Homepage Mid-Page Ad Banner -->
                        <div class="card p-4 rounded-4 border shadow-sm">
                            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                <div>
                                    <h6 class="fw-bold text-dark mb-0">2. Homepage Mid-Page Promo Banner</h6>
                                    <small class="text-muted">Home page ke beech mein full-width attractive offer/promo image.</small>
                                </div>
                                <div class="form-check form-switch fs-5">
                                    <input class="form-check-input" type="checkbox" name="ads___enable_home_ad" value="1" {{ ($settings['ads.enable_home_ad'] ?? '1') == '1' ? 'checked' : '' }}>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center">
                                <div class="col-md-7">
                                    <label class="form-label small fw-bold">Upload Homepage Banner Image</label>
                                    <input type="file" name="home_banner" id="homeAdInput" class="form-control" accept="image/*">
                                    <small class="text-muted d-block mt-1">Recommended: 1200x260 px</small>

                                    <div class="mt-3">
                                        <label class="form-label small fw-bold">Click Action / Target Link (Optional)</label>
                                        <input type="text" name="ads___home_banner_link" value="{{ $settings['ads.home_banner_link'] ?? '' }}" class="form-control form-control-sm" placeholder="e.g. tel:+918858285271 or https://wa.me/918858285271">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label small text-muted d-block fw-bold">Active Banner Preview</label>
                                    <div class="p-2 border rounded-3 bg-light text-center" style="max-height: 120px; overflow: hidden;">
                                        <img id="homeAdPreview"
                                            src="{{ asset($settings['ads.home_banner'] ?? 'assets/hero_b2.jpg') }}"
                                            class="img-fluid rounded border shadow-sm w-100"
                                            style="max-height: 100px; object-fit: cover;"
                                            alt="Home Ad">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4. APIS & GATEWAYS (OTP, FCM, ANALYTICS) -->
                    <div class="tab-pane fade" id="tab-apis" role="tabpanel">
                        <h5 class="fw-bold text-primary mb-3 pb-2 border-bottom">
                            <i class="bi bi-cpu me-1"></i> 4. Third-Party APIs (SMS Gateway, Firebase FCM, Analytics)
                        </h5>

                        <!-- SMS / OTP Provider -->
                        <div class="bg-light p-3 rounded-3 border mb-4">
                            <h6 class="fw-bold text-dark mb-2"><i class="bi bi-chat-dots-fill text-warning me-1"></i> SMS & OTP Gateway Setup</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Provider</label>
                                    <select name="api___sms_provider" class="form-select form-select-sm">
                                        <option value="demo" {{ ($settings['api.sms_provider'] ?? 'demo') == 'demo' ? 'selected' : '' }}>Demo Mode (Fixed OTP: 1234)</option>
                                        <option value="fast2sms" {{ ($settings['api.sms_provider'] ?? '') == 'fast2sms' ? 'selected' : '' }}>Fast2SMS (India)</option>
                                        <option value="twilio" {{ ($settings['api.sms_provider'] ?? '') == 'twilio' ? 'selected' : '' }}>Twilio SMS</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label small fw-bold">SMS API Key / Auth Token</label>
                                    <input type="password" name="api___fast2sms_key" value="{{ $settings['api.fast2sms_key'] ?? '' }}" class="form-control form-control-sm" placeholder="Enter API auth key">
                                </div>
                            </div>
                        </div>

                        <!-- Firebase Cloud Messaging (FCM) -->
                        <div class="bg-light p-3 rounded-3 border mb-4">
                            <h6 class="fw-bold text-dark mb-2"><i class="bi bi-bell-fill text-danger me-1"></i> Firebase Cloud Messaging (Push Notifications)</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Firebase Project ID</label>
                                    <input type="text" name="api___fcm_project_id" value="{{ $settings['api.fcm_project_id'] ?? '' }}" class="form-control form-control-sm" placeholder="e.g. growpec-app">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Firebase Server Key</label>
                                    <input type="password" name="api___fcm_server_key" value="{{ $settings['api.fcm_server_key'] ?? '' }}" class="form-control form-control-sm" placeholder="Enter FCM Server Key">
                                </div>
                            </div>
                        </div>

                        <!-- Google Analytics -->
                        <div class="bg-light p-3 rounded-3 border mb-3">
                            <h6 class="fw-bold text-dark mb-2"><i class="bi bi-graph-up text-primary me-1"></i> Google Analytics Tracking</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Measurement ID (GA4)</label>
                                    <input type="text" name="api___google_analytics_id" value="{{ $settings['api.google_analytics_id'] ?? '' }}" class="form-control form-control-sm" placeholder="G-XXXXXXXXXX">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    // ============================================================
    // 1. AUTOMATIC TEXT CONTRAST
    // ============================================================

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


    // ============================================================
    // 2. UPDATE LIVE PREVIEW
    // ============================================================

    function updateLivePreviews() {

        const primaryPicker =
            document.getElementById('primaryColorPicker');

        const accentPicker =
            document.getElementById('accentColorPicker');

        const topbarPicker =
            document.getElementById('topbarColorPicker');


        const primary =
            primaryPicker?.value || '#2E1E6B';

        const accent =
            accentPicker?.value || '#F5A623';

        const topbar =
            topbarPicker?.value || '#F5A623';


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


    // ============================================================
    // 3. APPLY PRESET COLOR PALETTE
    // ============================================================

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


    // ============================================================
    // 4. COLOR PICKER → TEXT INPUT SYNC
    // ============================================================

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


    // ============================================================
    // 5. HEADER LOGO LIVE PREVIEW
    // ============================================================

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


    // ============================================================
    // 6. FOOTER LOGO LIVE PREVIEW
    // ============================================================

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


    // ============================================================
    // 7. FAVICON LIVE PREVIEW
    // ============================================================

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


    // ============================================================
    // 8. INITIALIZE EVERYTHING AFTER PAGE LOAD
    // ============================================================

    document.addEventListener(
        'DOMContentLoaded',
        function() {

            updateLivePreviews();

        }
    );

    //

    // Live preview for Ad Banners
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
@endpush
@endsection
