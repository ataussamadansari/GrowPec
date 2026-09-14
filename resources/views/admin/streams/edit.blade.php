@extends('admin.layout')

@section('title', 'Edit Stream: ' . $stream->name . ' - GrowPec Admin')
@section('header', 'Edit Stream: ' . $stream->name)

@section('content')

<style>
    .stream-edit-page {
        --gp-navy: #002B67;
        --gp-navy-dark: #001B45;
        --gp-blue: #174B8F;
        --gp-green: #008A43;
        --gp-green-dark: #006B35;
        --gp-gold: #D9A400;
        --gp-border: #E5EAF0;
        --gp-text: #172033;
        --gp-muted: #718096;
    }

    .edit-wrap {
        max-width: 720px;
        margin: 8px auto 0;
    }

    .edit-hero {
        position: relative;
        overflow: hidden;
        padding: 22px 24px;
        border-radius: 18px 18px 0 0;
        background: linear-gradient(135deg, var(--gp-navy-dark), var(--gp-navy) 62%, var(--gp-blue));
        color: #fff;
        box-shadow: 0 10px 25px rgba(0, 43, 103, .12);
    }

    .edit-hero::after {
        content: "";
        position: absolute;
        width: 175px;
        height: 175px;
        right: -58px;
        top: -88px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .07);
    }

    .edit-hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .edit-hero-icon {
        width: 46px;
        height: 46px;
        flex: 0 0 46px;
        border-radius: 13px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, .12);
        font-size: 1.15rem;
    }

    .edit-hero h3 {
        margin: 0 0 4px;
        font-size: 1.15rem;
        font-weight: 800;
    }

    .edit-hero p {
        margin: 0;
        color: rgba(255, 255, 255, .73);
        font-size: .79rem;
    }

    .edit-card {
        background: #fff;
        border: 1px solid var(--gp-border);
        border-top: 0;
        border-radius: 0 0 18px 18px;
        padding: 24px;
        box-shadow: 0 8px 25px rgba(15, 35, 65, .06);
    }

    .details-strip {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding-bottom: 16px;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--gp-border);
    }

    .details-title {
        display: flex;
        align-items: center;
        gap: 9px;
        color: var(--gp-text);
        font-size: .87rem;
        font-weight: 800;
    }

    .details-title-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #EAF1FA;
        color: var(--gp-blue);
    }

    .courses-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 10px;
        border-radius: 999px;
        background: #EDF4FC;
        border: 1px solid #D9E7F7;
        color: var(--gp-blue);
        font-size: .67rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .error-box {
        border: 1px solid #F2C5C2;
        background: #FEF3F2;
        color: #B42318;
        border-radius: 11px;
        padding: 11px 13px;
        margin-bottom: 18px;
        font-size: .72rem;
    }

    .error-box ul {
        margin: 0;
        padding-left: 18px;
    }

    .field-group {
        margin-bottom: 17px;
    }

    .field-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 7px;
        color: var(--gp-text);
        font-size: .75rem;
        font-weight: 800;
    }

    .required-mark {
        color: #D92D20;
    }

    .optional-text {
        color: var(--gp-muted);
        font-size: .66rem;
        font-weight: 500;
    }

    .input-shell {
        position: relative;
    }

    .input-shell>i {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gp-blue);
        pointer-events: none;
        z-index: 2;
    }

    .edit-input {
        min-height: 44px;
        border: 1px solid #D8DEE8;
        border-radius: 10px;
        padding: 9px 12px 9px 38px;
        color: var(--gp-text);
        font-size: .8rem;
        box-shadow: none;
    }

    .edit-input:focus {
        border-color: var(--gp-blue);
        box-shadow: 0 0 0 3px rgba(23, 75, 143, .09);
    }

    .edit-input.is-invalid {
        padding-right: 38px;
    }

    .slug-box {
        position: relative;
    }

    .slug-box i {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #98A2B3;
        z-index: 2;
    }

    .slug-input {
        min-height: 41px;
        padding-left: 38px;
        background: #F8FAFC !important;
        color: #667085 !important;
        border-color: #E2E7ED;
        border-radius: 10px;
        font-size: .76rem;
    }

    .field-help {
        display: block;
        margin-top: 6px;
        color: var(--gp-muted);
        font-size: .67rem;
    }

    .icon-preview {
        min-width: 43px;
        border: 1px solid #D8DEE8;
        border-right: 0;
        border-radius: 10px 0 0 10px;
        background: #F8FAFC;
        color: var(--gp-blue);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icon-input {
        min-height: 41px;
        border-radius: 0 10px 10px 0;
        border-color: #D8DEE8;
        font-size: .76rem;
        box-shadow: none;
    }

    .icon-input:focus {
        border-color: var(--gp-blue);
        box-shadow: none;
    }

    .form-actions {
        display: flex;
        align-items: center;
        gap: 9px;
        padding-top: 19px;
        margin-top: 20px;
        border-top: 1px solid var(--gp-border);
    }

    .update-btn,
    .cancel-btn {
        min-height: 42px;
        border-radius: 10px;
        padding: 0 17px;
        font-size: .77rem;
        font-weight: 800;
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
        transition: all .18s ease;
    }

    .update-btn {
        border: 1px solid var(--gp-gold);
        background: var(--gp-gold);
        color: #1B1B1B;
        box-shadow: 0 5px 13px rgba(217, 164, 0, .17);
    }

    .update-btn:hover {
        background: #C89400;
        border-color: #C89400;
        color: #111;
        transform: translateY(-1px);
        box-shadow: 0 7px 16px rgba(217, 164, 0, .22);
    }

    .cancel-btn {
        border: 1px solid #D8DEE8;
        background: #fff;
        color: #526176;
    }

    .cancel-btn:hover {
        background: #F8FAFC;
        border-color: #B8C2D0;
        color: var(--gp-navy);
        transform: translateY(-1px);
    }

    .update-btn:active,
    .cancel-btn:active {
        transform: translateY(0);
    }


    .icon-section {
        margin-top: 6px;
        padding: 15px;
        border: 1px solid var(--gp-border);
        border-radius: 12px;
        background: #FBFCFE;
    }

    .icon-section-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 10px;
        color: var(--gp-text);
        font-size: .75rem;
        font-weight: 800;
    }

    .icon-section-title span:last-child {
        color: var(--gp-muted);
        font-size: .65rem;
        font-weight: 600;
    }

    .selected-icon {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 10px;
    }

    .selected-icon-preview {
        width: 40px;
        height: 40px;
        flex: 0 0 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #EAF1FA;
        color: var(--gp-blue);
        font-size: 1.05rem;
    }

    .selected-icon-text {
        color: var(--gp-muted);
        font-size: .67rem;
    }

    .selected-icon-text strong {
        display: block;
        color: var(--gp-text);
        font-size: .73rem;
        margin-bottom: 2px;
    }

    .icon-grid {
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        gap: 7px;
    }

    .icon-option {
        min-height: 58px;
        padding: 6px 4px;
        border: 1px solid #E0E6ED;
        border-radius: 9px;
        background: #fff;
        color: #526176;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
        transition: .16s ease;
    }

    .icon-option i {
        font-size: 1.05rem;
        color: var(--gp-blue);
    }

    .icon-option small {
        width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        text-align: center;
        font-size: .56rem;
    }

    .icon-option:hover,
    .icon-option.active {
        border-color: var(--gp-blue);
        background: #F1F6FC;
        color: var(--gp-navy);
    }

    .icon-option.active {
        box-shadow: 0 0 0 2px rgba(23, 75, 143, .08);
    }

    @media (max-width: 767.98px) {
        .icon-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .edit-wrap {
            margin-top: 0;
        }

        .edit-hero {
            padding: 18px;
            border-radius: 15px 15px 0 0;
        }

        .edit-card {
            padding: 18px;
            border-radius: 0 0 15px 15px;
        }

        .edit-hero-icon {
            width: 42px;
            height: 42px;
            flex-basis: 42px;
        }

        .edit-hero h3 {
            font-size: 1.02rem;
        }

        .edit-hero p {
            font-size: .72rem;
        }

        .details-strip {
            align-items: flex-start;
            flex-direction: column;
        }

        .courses-badge {
            align-self: flex-start;
        }

        .form-actions {
            flex-direction: column;
        }

        .update-btn,
        .cancel-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
    }
</style>

<div class="stream-edit-page">
    <div class="edit-wrap">

        <div class="edit-hero">
            <div class="edit-hero-content">
                <div class="edit-hero-icon">
                    <i class="bi bi-pencil-square"></i>
                </div>

                <div>
                    <h3>Edit Academic Stream</h3>
                    <p>Update the stream details used across your GrowPec academic catalog.</p>
                </div>
            </div>
        </div>

        <div class="edit-card">

            <div class="details-strip">
                <div class="details-title">
                    <span class="details-title-icon">
                        <i class="bi bi-diagram-3-fill"></i>
                    </span>
                    Edit Stream Details
                </div>

                <span class="courses-badge">
                    <i class="bi bi-book-half"></i>
                    {{ $stream->courses()->count() }} Associated Courses
                </span>
            </div>

            @if ($errors->any())
            <div class="error-box">
                <div class="fw-bold mb-1">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                    Please fix the following:
                </div>

                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.streams.update', $stream->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="field-group">
                    <label for="streamName" class="field-label">
                        <span>
                            Stream Name <span class="required-mark">*</span>
                        </span>
                        <span class="optional-text">Required</span>
                    </label>

                    <div class="input-shell">
                        <i class="bi bi-mortarboard-fill"></i>

                        <input type="text"
                            id="streamName"
                            name="name"
                            value="{{ old('name', $stream->name) }}"
                            class="form-control edit-input @error('name') is-invalid @enderror"
                            placeholder="e.g. Management, Engineering, Pharmacy"
                            required>

                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="field-group">
                    <label class="field-label">
                        <span>Stream Slug</span>
                        <span class="optional-text">Auto-generated</span>
                    </label>

                    <div class="slug-box">
                        <i class="bi bi-link-45deg"></i>
                        <input type="text"
                            value="{{ $stream->slug }}"
                            class="form-control slug-input"
                            disabled>
                    </div>

                    <small class="field-help">
                        <i class="bi bi-info-circle me-1"></i>
                        The slug is automatically generated from the stream name.
                    </small>
                </div>

                <div class="field-group mb-0">
                    <label for="streamIcon" class="field-label">
                        <span>Stream Icon</span>
                        <span class="optional-text">Optional</span>
                    </label>

                    <div class="icon-section">
                        <div class="selected-icon">
                            <span class="selected-icon-preview">
                                <i id="streamIconPreview"></i>
                            </span>
                            <span class="selected-icon-text">
                                <strong id="selectedIconName">Default icon</strong>
                                Choose an icon below for this stream.
                            </span>
                        </div>

                        <div class="icon-grid" id="streamIconGrid"></div>

                        <input type="hidden"
                            id="streamIcon"
                            name="icon"
                            value="{{ old('icon', $stream->icon) }}">
                    </div>

                    <small class="field-help">
                        <i class="bi bi-info-circle me-1"></i>
                        Select an icon instead of entering a Bootstrap class manually.
                    </small>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn update-btn">
                        <i class="bi bi-check2-circle me-1"></i>
                        Update Stream
                    </button>

                    <a href="{{ route('admin.streams.index') }}"
                        class="action-btn cancel-btn">
                        <i class="bi bi-arrow-left"></i>
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const grid = document.getElementById('streamIconGrid');
        const input = document.getElementById('streamIcon');
        const preview = document.getElementById('streamIconPreview');
        const name = document.getElementById('selectedIconName');

        if (!grid || !input || !preview || !name) return;

        const icons = [
            ['bi-laptop', 'Engineering / IT'],
            ['bi-gear-wide-connected', 'Engineering'],
            ['bi-cpu', 'Technology'],
            ['bi-code-slash', 'Computer Science'],
            ['bi-briefcase-fill', 'Management'],
            ['bi-bar-chart-fill', 'Commerce'],
            ['bi-calculator-fill', 'Finance'],
            ['bi-bank', 'Banking'],
            ['bi-capsule', 'Pharmacy'],
            ['bi-heart-pulse-fill', 'Medical'],
            ['bi-hospital-fill', 'Healthcare'],
            ['bi-flask-fill', 'Science'],
            ['bi-atom', 'Physics / Science'],
            ['bi-beaker-fill', 'Chemistry'],
            ['bi-book-half', 'Arts / Humanities'],
            ['bi-journal-bookmark-fill', 'Education'],
            ['bi-mortarboard-fill', 'Education'],
            ['bi-people-fill', 'Social Science'],
            ['bi-globe2', 'International'],
            ['bi-palette-fill', 'Design / Arts'],
            ['bi-camera-fill', 'Media'],
            ['bi-megaphone-fill', 'Mass Communication'],
            ['bi-shield-fill-check', 'Law / Security'],
            ['bi-building', 'Architecture'],
            ['bi-tree-fill', 'Agriculture'],
            ['bi-lightbulb-fill', 'General'],
            ['bi-diagram-3-fill', 'General']
        ];

        icons.forEach(([icon, label]) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'icon-option';
            button.dataset.icon = icon;
            button.title = label;
            button.innerHTML = '<i class="bi ' + icon + '"></i><small>' + label + '</small>';

            button.addEventListener('click', function() {
                input.value = icon;
                updateSelected();
            });

            grid.appendChild(button);
        });

        function updateSelected() {
            let current = input.value.trim() || 'bi-diagram-3-fill';
            const selected = icons.find(item => item[0] === current);
            const label = selected ? selected[1] : 'Custom icon';

            preview.className = 'bi ' + current;
            name.textContent = current;

            grid.querySelectorAll('.icon-option').forEach(el => {
                el.classList.toggle('active', el.dataset.icon === current);
            });
        }

        updateSelected();
    });
</script>
@endpush

@endsection