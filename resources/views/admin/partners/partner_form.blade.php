@php($isEdit = isset($partner))

<style>
    .gp-partner-form {
        --gp-navy: #002B67;
        --gp-navy-dark: #001B45;
        --gp-blue: #174B8F;
        --gp-green: #008A43;
        --gp-green-dark: #006B35;
        --gp-gold: #D9A400;
        --gp-gold-dark: #B78300;
        --gp-border: #E1E8F0;
        --gp-text: #172033;
        --gp-muted: #718096;
        width: 100%;
        max-width: none;
        min-width: 0;
        padding: 0 0 28px;
    }

    .gp-partner-form * {
        box-sizing: border-box;
    }

    .gp-hero {
        position: relative;
        overflow: hidden;
        width: 100%;
        margin-bottom: 18px;
        padding: 24px 26px;
        border-radius: 17px;
        color: #fff;
        background: linear-gradient(135deg, var(--gp-navy-dark), var(--gp-navy) 58%, var(--gp-blue));
        box-shadow: 0 12px 30px rgba(0, 43, 103, .14);
    }

    .gp-hero:after {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        right: -85px;
        bottom: -140px;
        border: 1px solid rgba(255, 255, 255, .14);
        border-radius: 50%;
        box-shadow: 0 0 0 30px rgba(255, 255, 255, .025);
    }

    .gp-hero>* {
        position: relative;
        z-index: 1;
    }

    .gp-kicker {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 10px;
        border: 1px solid rgba(255, 255, 255, .16);
        border-radius: 999px;
        background: rgba(255, 255, 255, .09);
        color: rgba(255, 255, 255, .9);
        font-size: .62rem;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .gp-hero h2 {
        margin: 10px 0 5px;
        font-size: 1.42rem;
        font-weight: 850;
        letter-spacing: -.02em;
    }

    .gp-hero p {
        margin: 0;
        max-width: 820px;
        color: rgba(255, 255, 255, .76);
        font-size: .73rem;
        line-height: 1.5;
    }

    .gp-name-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        max-width: 100%;
        margin-top: 11px;
        padding: 6px 10px;
        border: 1px solid rgba(255, 255, 255, .16);
        border-radius: 999px;
        background: rgba(255, 255, 255, .08);
        color: #fff;
        font-size: .62rem;
        font-weight: 750;
    }

    .gp-name-pill span {
        max-width: 520px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .gp-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        gap: 18px;
        align-items: start;
        width: 100%;
        min-width: 0;
    }

    .gp-card {
        width: 100%;
        min-width: 0;
        overflow: hidden;
        border: 1px solid var(--gp-border);
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 8px 25px rgba(20, 35, 60, .055);
    }

    .gp-card+.gp-card {
        margin-top: 18px;
    }

    .gp-card-head {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 15px 18px;
        border-bottom: 1px solid var(--gp-border);
        background: #FCFDFE;
    }

    .gp-card-icon {
        width: 40px;
        height: 40px;
        flex: 0 0 40px;
        display: grid;
        place-items: center;
        border: 1px solid #D7E5F4;
        border-radius: 11px;
        background: #EAF2FB;
        color: var(--gp-blue);
        font-size: .92rem;
    }

    .gp-card-title {
        margin: 0;
        color: var(--gp-text);
        font-size: .88rem;
        font-weight: 850;
    }

    .gp-card-subtitle {
        display: block;
        margin-top: 2px;
        color: var(--gp-muted);
        font-size: .61rem;
        font-weight: 600;
        line-height: 1.4;
    }

    .gp-card-body {
        padding: 19px;
    }

    .gp-field {
        margin-bottom: 17px;
    }

    .gp-field:last-child {
        margin-bottom: 0;
    }

    .gp-label {
        display: flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 7px;
        color: var(--gp-text);
        font-size: .68rem;
        font-weight: 800;
    }

    .gp-label i {
        color: var(--gp-blue);
        font-size: .78rem;
    }

    .gp-required {
        color: #C0392B;
    }

    .gp-input,
    .gp-file {
        width: 100%;
        min-height: 43px;
        border: 1px solid #D8E1EB;
        border-radius: 10px;
        background: #fff;
        color: var(--gp-text);
        font-size: .72rem;
        font-weight: 600;
        transition: border-color .18s ease, box-shadow .18s ease;
    }

    .gp-input {
        padding: 10px 12px;
    }

    .gp-file {
        padding: 8px 10px;
    }

    .gp-input::placeholder {
        color: #9AA5B5;
        font-weight: 500;
    }

    .gp-input:focus,
    .gp-file:focus {
        border-color: #7EA8D4;
        box-shadow: 0 0 0 3px rgba(23, 75, 143, .09);
        outline: none;
    }

    .gp-help {
        display: block;
        margin-top: 6px;
        color: #8A95A6;
        font-size: .59rem;
        font-weight: 600;
        line-height: 1.45;
    }

    .gp-upload-box {
        padding: 13px;
        border: 1px dashed #C8D5E4;
        border-radius: 12px;
        background: #F8FAFC;
    }

    .gp-preview,
    .gp-current-logo {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 92px;
        margin-top: 10px;
        padding: 12px;
        border: 1px solid #DCE5EF;
        border-radius: 10px;
        background: #fff;
    }

    .gp-preview {
        display: none;
    }

    .gp-preview img,
    .gp-current-logo img {
        max-width: 100%;
        max-height: 76px;
        object-fit: contain;
    }

    .gp-preview-label,
    .gp-logo-caption {
        display: block;
        margin-top: 6px;
        color: #8A95A6;
        font-size: .56rem;
        font-weight: 650;
        text-align: center;
    }

    .gp-status-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 13px 14px;
        border: 1px solid #DCE7E1;
        border-radius: 12px;
        background: #F4FBF7;
    }

    .gp-status-copy strong {
        display: block;
        color: var(--gp-text);
        font-size: .69rem;
        font-weight: 850;
    }

    .gp-status-copy span {
        display: block;
        margin-top: 3px;
        color: #748294;
        font-size: .58rem;
        font-weight: 600;
    }

    .gp-switch {
        width: 42px !important;
        height: 23px !important;
        margin: 0 !important;
        cursor: pointer;
    }

    .gp-switch:checked {
        background-color: var(--gp-green);
        border-color: var(--gp-green);
    }

    .gp-info {
        padding: 14px;
        border: 1px solid #DCE7F2;
        border-radius: 12px;
        background: #F5F9FD;
    }

    .gp-info-title {
        display: flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 8px;
        color: var(--gp-navy);
        font-size: .68rem;
        font-weight: 850;
    }

    .gp-info p {
        margin: 0;
        color: #68768A;
        font-size: .61rem;
        line-height: 1.55;
        font-weight: 600;
    }

    .gp-meta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-bottom: 13px;
    }

    .gp-meta-item {
        padding: 10px;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        background: #FAFBFD;
    }

    .gp-meta-label {
        display: block;
        margin-bottom: 3px;
        color: #8A95A6;
        font-size: .55rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .gp-meta-value {
        display: block;
        overflow: hidden;
        color: var(--gp-text);
        font-size: .68rem;
        font-weight: 850;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .gp-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        margin-top: 18px;
        padding-top: 18px;
        border-top: 1px solid #E8EDF3;
    }

    .gp-btn {
        min-height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 0 17px;
        border-radius: 10px;
        font-size: .68rem;
        font-weight: 850;
        white-space: nowrap;
        text-decoration: none;
        transition: all .18s ease;
    }

    .gp-btn-submit {
        border: 1px solid var(--gp-gold);
        background: var(--gp-gold);
        color: #172033;
    }

    .gp-btn-submit:hover {
        border-color: var(--gp-gold-dark);
        background: var(--gp-gold-dark);
        color: #fff;
        transform: translateY(-1px);
    }

    .gp-btn-cancel {
        border: 1px solid #D5DDE7;
        background: #fff;
        color: #526176;
    }

    .gp-btn-cancel:hover {
        border-color: #B9C6D5;
        background: #F7F9FC;
        color: var(--gp-text);
    }

    .gp-error-box {
        margin-bottom: 18px;
        padding: 12px 14px;
        border: 1px solid #F2C5C2;
        border-radius: 11px;
        background: #FEF3F2;
        color: #B42318;
        font-size: .68rem;
    }

    .gp-error-box ul {
        margin: 5px 0 0;
        padding-left: 18px;
    }

    .gp-submit-disabled {
        opacity: .7;
        pointer-events: none;
    }

    @media (max-width:1199.98px) {
        .gp-layout {
            grid-template-columns: minmax(0, 1fr);
        }

        .gp-side {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .gp-side .gp-card+.gp-card {
            margin-top: 0;
        }
    }

    @media (max-width:767.98px) {
        .gp-partner-form {
            padding-bottom: 18px;
        }

        .gp-hero {
            margin-bottom: 12px;
            padding: 18px 14px;
            border-radius: 13px;
        }

        .gp-hero h2 {
            font-size: 1.12rem;
        }

        .gp-hero p {
            font-size: .67rem;
        }

        .gp-name-pill {
            max-width: 100%;
        }

        .gp-name-pill span {
            max-width: calc(100vw - 90px);
        }

        .gp-card {
            border-radius: 13px;
        }

        .gp-card-head {
            padding: 11px 12px;
        }

        .gp-card-body {
            padding: 12px;
        }

        .gp-card-icon {
            width: 35px;
            height: 35px;
            flex-basis: 35px;
        }

        .gp-card-title {
            font-size: .78rem;
        }

        .gp-card-subtitle {
            font-size: .55rem;
        }

        .gp-side {
            grid-template-columns: minmax(0, 1fr);
            gap: 12px;
        }

        .gp-field {
            margin-bottom: 14px;
        }

        .gp-input,
        .gp-file {
            min-height: 41px;
        }

        .gp-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .gp-btn {
            width: 100%;
            min-height: 43px;
        }
    }
</style>

<div class="gp-partner-form">

    <div class="gp-hero">
        <span class="gp-kicker">
            <i class="bi bi-award-fill"></i>
            Partner Management
        </span>

        <h2>{{ $isEdit ? 'Edit Partner University' : 'Add Partner University' }}</h2>

        <p>
            {{ $isEdit
                ? 'Update partner information, replace the university logo, change its marquee order or control whether it is visible on the GrowPec homepage.'
                : 'Add a university partner for the GrowPec homepage marquee. Upload a clean logo, set its display order and control its visibility.'
            }}
        </p>

        @if($isEdit)
        <div class="gp-name-pill">
            <i class="bi bi-building-check"></i>
            <span>{{ $partner->name }}</span>
        </div>
        @endif
    </div>

    @if ($errors->any())
    <div class="gp-error-box">
        <strong><i class="bi bi-exclamation-triangle-fill me-1"></i>Please fix the following:</strong>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form
        id="partnerForm"
        action="{{ $isEdit ? route('admin.partners.update', $partner->id) : route('admin.partners.store') }}"
        method="POST"
        enctype="multipart/form-data"
        data-is-edit="{{ $isEdit ? '1' : '0' }}">
        @csrf
        @if($isEdit)
        @method('PUT')
        @endif

        <div class="gp-layout">
            <div class="gp-main">
                <section class="gp-card">
                    <div class="gp-card-head">
                        <span class="gp-card-icon">
                            <i class="bi {{ $isEdit ? 'bi-building-gear' : 'bi-building-add' }}"></i>
                        </span>
                        <div>
                            <h3 class="gp-card-title">Partner Details</h3>
                            <small class="gp-card-subtitle">
                                {{ $isEdit ? 'Update the university partner information' : 'Basic information for the university partner' }}
                            </small>
                        </div>
                    </div>

                    <div class="gp-card-body">

                        <div class="gp-field">
                            <label for="partnerName" class="gp-label">
                                <i class="bi bi-building"></i>
                                University / Partner Name
                                <span class="gp-required">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="partnerName"
                                class="gp-input @error('name') is-invalid @enderror"
                                value="{{ old('name', $partner->name ?? '') }}"
                                placeholder="e.g. Amity University"
                                required
                                autofocus>

                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="gp-field">
                            <label for="partnerLogoInput" class="gp-label">
                                <i class="bi bi-image"></i>
                                {{ $isEdit ? 'Change University Logo' : 'University Logo' }}
                            </label>

                            <div class="gp-upload-box">
                                <input
                                    type="file"
                                    name="logo"
                                    id="partnerLogoInput"
                                    class="gp-file @error('logo') is-invalid @enderror"
                                    accept="image/png,image/jpeg,image/jpg,image/svg+xml,image/webp">

                                <small class="gp-help">
                                    {{ $isEdit
                                        ? 'Upload only when you want to replace the current logo. PNG with transparent background is recommended.'
                                        : 'PNG, JPG, JPEG, SVG or WebP. Transparent PNG is recommended for the homepage marquee.'
                                    }}
                                </small>

                                @if($isEdit)
                                <div class="gp-current-logo">
                                    <div>
                                        <img
                                            id="partnerLogoPreview"
                                            src="{{ $partner->logo_url }}"
                                            alt="{{ $partner->name }} Logo">
                                        <span class="gp-logo-caption" id="logoCaption">Current Active Logo</span>
                                    </div>
                                </div>
                                @else
                                <div class="gp-preview" id="logoPreviewBox">
                                    <div>
                                        <img id="partnerLogoPreview" src="#" alt="Logo preview">
                                        <span class="gp-preview-label">Logo Preview</span>
                                    </div>
                                </div>
                                @endif

                                @error('logo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="gp-field">
                            <label for="sortOrder" class="gp-label">
                                <i class="bi bi-arrow-down-up"></i>
                                Display Order Index
                            </label>

                            <input
                                type="number"
                                name="sort_order"
                                id="sortOrder"
                                class="gp-input @error('sort_order') is-invalid @enderror"
                                value="{{ old('sort_order', $partner->sort_order ?? 0) }}"
                                min="0"
                                step="1">

                            <small class="gp-help">
                                Lower numbers appear first in the homepage marquee: 0, 1, 2, 3...
                            </small>

                            @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="gp-field">
                            <div class="gp-status-box">
                                <div class="gp-status-copy">
                                    <strong>Show on Homepage Marquee</strong>
                                    <span>
                                        {{ $isEdit
                                            ? 'Active partners are displayed on the public homepage.'
                                            : 'Keep this partner visible on the public homepage.'
                                        }}
                                    </span>
                                </div>

                                <div class="form-check form-switch">
                                    <input type="hidden" name="status" value="0">

                                    <input
                                        class="form-check-input gp-switch"
                                        type="checkbox"
                                        name="status"
                                        value="1"
                                        id="partnerStatus"
                                        {{ old('status', $partner->status ?? 1) ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>

                        <div class="gp-actions">
                            <button type="submit" id="partnerSubmitBtn" class="gp-btn gp-btn-submit">
                                <i class="bi check-icon bi-check-circle-fill"></i>
                                {{ $isEdit ? 'Update Partner' : 'Save Partner' }}
                            </button>

                            <a href="{{ route('admin.partners.index') }}" class="gp-btn gp-btn-cancel">
                                <i class="bi bi-arrow-left"></i>
                                Cancel
                            </a>
                        </div>

                    </div>
                </section>
            </div>

            <aside class="gp-side">

                @if($isEdit)
                <section class="gp-card">
                    <div class="gp-card-head">
                        <span class="gp-card-icon">
                            <i class="bi bi-bar-chart-line-fill"></i>
                        </span>
                        <div>
                            <h3 class="gp-card-title">Partner Overview</h3>
                            <small class="gp-card-subtitle">Current partner information</small>
                        </div>
                    </div>

                    <div class="gp-card-body">
                        <div class="gp-meta">
                            <div class="gp-meta-item">
                                <span class="gp-meta-label">Partner ID</span>
                                <span class="gp-meta-value">#{{ $partner->id }}</span>
                            </div>

                            <div class="gp-meta-item">
                                <span class="gp-meta-label">Order</span>
                                <span class="gp-meta-value">{{ $partner->sort_order }}</span>
                            </div>
                        </div>

                        <div class="gp-info">
                            <div class="gp-info-title">
                                <i class="bi bi-info-circle-fill"></i>
                                Homepage Visibility
                            </div>
                            <p>
                                The partner appears in the homepage marquee only when its status
                                is active. Use the display order to control its sequence.
                            </p>
                        </div>
                    </div>
                </section>

                <section class="gp-card">
                    <div class="gp-card-head">
                        <span class="gp-card-icon">
                            <i class="bi bi-shield-check"></i>
                        </span>
                        <div>
                            <h3 class="gp-card-title">Logo Guidelines</h3>
                            <small class="gp-card-subtitle">Keep the marquee presentation clean</small>
                        </div>
                    </div>

                    <div class="gp-card-body">
                        <div class="gp-info">
                            <div class="gp-info-title">
                                <i class="bi bi-stars"></i>
                                Recommended
                            </div>
                            <p>
                                Use the official university logo in high resolution.
                                Transparent PNG or SVG works best against the homepage marquee background.
                            </p>
                        </div>
                    </div>
                </section>
                @else
                <section class="gp-card">
                    <div class="gp-card-head">
                        <span class="gp-card-icon">
                            <i class="bi bi-eye-fill"></i>
                        </span>
                        <div>
                            <h3 class="gp-card-title">Marquee Preview</h3>
                            <small class="gp-card-subtitle">How the partner logo will be presented</small>
                        </div>
                    </div>

                    <div class="gp-card-body">
                        <div class="gp-preview" id="marqueePreview" style="display:flex;">
                            <i class="bi bi-building" style="font-size:2.2rem;color:#A0ADBD;"></i>
                        </div>

                        <div class="gp-info mt-3">
                            <div class="gp-info-title">
                                <i class="bi bi-lightbulb-fill"></i>
                                Logo Tip
                            </div>
                            <p>
                                Use a high-quality logo with a transparent background.
                                Keep extra whitespace around the logo to a minimum for a cleaner marquee.
                            </p>
                        </div>
                    </div>
                </section>

                <section class="gp-card">
                    <div class="gp-card-head">
                        <span class="gp-card-icon">
                            <i class="bi bi-info-circle-fill"></i>
                        </span>
                        <div>
                            <h3 class="gp-card-title">Publishing Guide</h3>
                            <small class="gp-card-subtitle">Quick checklist before saving</small>
                        </div>
                    </div>

                    <div class="gp-card-body">
                        <div class="gp-info">
                            <div class="gp-info-title">
                                <i class="bi bi-check2-circle"></i>
                                Recommended
                            </div>
                            <p>
                                Add the official university name, upload the official logo,
                                choose the correct display order and keep the status active
                                when the partner should appear on the homepage.
                            </p>
                        </div>
                    </div>
                </section>
                @endif

            </aside>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('partnerForm');
        const input = document.getElementById('partnerLogoInput');
        const preview = document.getElementById('partnerLogoPreview');
        const submitBtn = document.getElementById('partnerSubmitBtn');
        const previewBox = document.getElementById('logoPreviewBox');
        const marqueePreview = document.getElementById('marqueePreview');
        const caption = document.getElementById('logoCaption');

        // The form exposes whether this is create or edit mode through data-is-edit.
        const isEdit = form?.dataset.isEdit === '1';

        input?.addEventListener('change', function() {
            const file = this.files?.[0];

            if (!file) {
                if (!isEdit) {
                    if (previewBox) {
                        previewBox.style.display = 'none';
                    }

                    if (marqueePreview) {
                        marqueePreview.innerHTML =
                            '<i class="bi bi-building" style="font-size:2.2rem;color:#A0ADBD;"></i>';
                    }
                }

                return;
            }

            if (!file.type.startsWith('image/')) {
                this.value = '';
                return;
            }

            const reader = new FileReader();

            reader.onload = function(event) {
                if (preview) {
                    preview.src = event.target.result;
                }

                if (isEdit) {
                    if (caption) {
                        caption.textContent = 'New Logo Preview';
                    }
                } else {
                    if (previewBox) {
                        previewBox.style.display = 'flex';
                    }

                    if (marqueePreview) {
                        marqueePreview.innerHTML =
                            '<img src="' + event.target.result +
                            '" alt="Marquee logo preview" style="max-width:100%;max-height:72px;object-fit:contain;">';
                    }
                }
            };

            reader.readAsDataURL(file);
        });

        form?.addEventListener('submit', function(event) {
            if (!this.checkValidity() || !submitBtn) {
                return;
            }

            submitBtn.disabled = true;
            submitBtn.classList.add('gp-submit-disabled');
            submitBtn.innerHTML =
                '<i class="bi bi-hourglass-split"></i> ' +
                (isEdit ? 'Updating...' : 'Saving...');
        });
    });
</script>
@endpush