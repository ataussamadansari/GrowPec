@extends('admin.layout')

@section('title', 'Add New Stream - GrowPec Admin')
@section('header', 'Add New Stream')

@section('content')

<style>
    .stream-create-page {
        --gp-navy: #002B67;
        --gp-navy-dark: #001B45;
        --gp-blue: #174B8F;
        --gp-green: #008A43;
        --gp-green-dark: #006B35;
        --gp-gold: #D9A400;
        --gp-gold-dark: #B78300;
        --gp-border: #E3E8EF;
        --gp-text: #172033;
        --gp-muted: #667085;
    }

    .create-wrap {
        width: min(100%, 700px);
        margin: 4px auto 0;
    }

    .create-card {
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--gp-border);
        border-radius: 18px;
        box-shadow: 0 8px 26px rgba(15,35,65,.06);
    }

    .create-header {
        position: relative;
        overflow: hidden;
        padding: 21px 23px;
        background: linear-gradient(135deg, var(--gp-navy-dark), var(--gp-navy) 62%, var(--gp-blue));
        color: #fff;
    }

    .create-header::before {
        content: "";
        position: absolute;
        width: 170px;
        height: 170px;
        right: -65px;
        top: -95px;
        border-radius: 50%;
        background: rgba(255,255,255,.07);
    }

    .create-header::after {
        content: "";
        position: absolute;
        width: 80px;
        height: 80px;
        right: 70px;
        bottom: -48px;
        border-radius: 50%;
        background: rgba(217,164,0,.10);
    }

    .header-inner {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .header-icon {
        width: 46px;
        height: 46px;
        flex: 0 0 46px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.10);
        font-size: 1.15rem;
    }

    .create-header h3 {
        margin: 0 0 4px;
        font-size: 1.13rem;
        font-weight: 800;
    }

    .create-header p {
        margin: 0;
        max-width: 520px;
        color: rgba(255,255,255,.72);
        font-size: .78rem;
        line-height: 1.45;
    }

    .form-body {
        padding: 24px;
    }

    .field-group {
        margin-bottom: 18px;
    }

    .field-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 8px;
        color: var(--gp-text);
        font-size: .76rem;
        font-weight: 800;
    }

    .required {
        color: #D92D20;
    }

    .required-label {
        color: var(--gp-muted);
        font-size: .66rem;
        font-weight: 600;
    }

    .input-box {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 13px;
        top: 50%;
        z-index: 2;
        transform: translateY(-50%);
        color: var(--gp-blue);
        pointer-events: none;
        font-size: .9rem;
    }

    .stream-input {
        width: 100%;
        min-height: 46px;
        padding: 10px 13px 10px 39px;
        border: 1px solid #D5DCE6;
        border-radius: 11px;
        outline: none;
        color: var(--gp-text);
        background: #fff;
        font-size: .82rem;
        box-shadow: none;
        transition: border-color .18s ease, box-shadow .18s ease, background .18s ease;
    }

    .stream-input:hover {
        border-color: #B9C5D3;
    }

    .stream-input:focus {
        border-color: var(--gp-blue);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(23,75,143,.09);
    }

    .stream-input.is-invalid {
        border-color: #D92D20;
        box-shadow: 0 0 0 3px rgba(217,45,32,.07);
    }

    .stream-input::placeholder {
        color: #A0A8B5;
    }

    .error-text {
        display: block;
        margin-top: 6px;
        color: #B42318;
        font-size: .69rem;
        line-height: 1.4;
    }

    .info-box {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 12px 13px;
        margin-top: 3px;
        border: 1px solid #D9E8F7;
        border-radius: 11px;
        background: #F5F9FE;
        color: #53657A;
        font-size: .7rem;
        line-height: 1.5;
    }

    .info-icon {
        width: 27px;
        height: 27px;
        flex: 0 0 27px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #E7F0FA;
        color: var(--gp-blue);
    }

    .actions {
        display: flex;
        align-items: center;
        gap: 9px;
        padding-top: 20px;
        margin-top: 20px;
        border-top: 1px solid var(--gp-border);
    }

    .action-btn {
        min-height: 43px;
        border-radius: 10px;
        padding: 0 17px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-size: .77rem;
        font-weight: 800;
        line-height: 1;
        text-decoration: none;
        transition: all .18s ease;
    }

    .save-btn {
        border: 1px solid var(--gp-gold);
        background: var(--gp-gold);
        color: #1A1A1A;
        box-shadow: 0 5px 14px rgba(217,164,0,.17);
    }

    .save-btn:hover,
    .save-btn:focus {
        border-color: var(--gp-gold-dark);
        background: var(--gp-gold-dark);
        color: #fff;
        transform: translateY(-1px);
    }

    .cancel-btn {
        border: 1px solid #D4DAE2;
        background: #fff;
        color: #475467;
    }

    .cancel-btn:hover,
    .cancel-btn:focus {
        border-color: #B8C2CF;
        background: #F8FAFC;
        color: var(--gp-navy);
    }

    .save-btn:active,
    .cancel-btn:active {
        transform: translateY(0);
    }


    .icon-section {
        margin-top: 18px;
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
        box-shadow: 0 0 0 2px rgba(23,75,143,.08);
    }

    @media (max-width: 767.98px) {
        .icon-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .create-wrap {
            margin-top: 0;
        }

        .create-card {
            border-radius: 15px;
        }

        .create-header {
            padding: 18px;
        }

        .form-body {
            padding: 18px;
        }

        .header-icon {
            width: 42px;
            height: 42px;
            flex-basis: 42px;
            border-radius: 11px;
        }

        .create-header h3 {
            font-size: 1.02rem;
        }

        .create-header p {
            font-size: .71rem;
        }

        .stream-input {
            min-height: 44px;
        }

        .actions {
            flex-direction: column;
        }

        .action-btn {
            width: 100%;
        }
    }
</style>

<div class="stream-create-page">
    <div class="create-wrap">

        <div class="create-card">

            <div class="create-header">
                <div class="header-inner">
                    <div class="header-icon">
                        <i class="bi bi-diagram-3-fill"></i>
                    </div>

                    <div>
                        <h3>Create Academic Stream</h3>
                        <p>Add a new academic category to organize courses across GrowPec.</p>
                    </div>
                </div>
            </div>

            <div class="form-body">

                <form action="{{ route('admin.streams.store') }}" method="POST">
                    @csrf

                    <div class="field-group">
                        <label for="streamName" class="field-label">
                            <span>
                                Stream Name <span class="required">*</span>
                            </span>
                            <span class="required-label">Required</span>
                        </label>

                        <div class="input-box">
                            <i class="bi bi-mortarboard-fill input-icon"></i>

                            <input type="text"
                                   id="streamName"
                                   name="name"
                                   value="{{ old('name') }}"
                                   class="stream-input @error('name') is-invalid @enderror"
                                   placeholder="e.g. Engineering & Technology, Management, Pharmacy"
                                   autocomplete="off"
                                   required>
                        </div>

                        @error('name')
                            <span class="error-text">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="icon-section">
                        <div class="icon-section-title">
                            <span><i class="bi bi-stars me-1"></i>Choose Stream Icon</span>
                            <span>Optional</span>
                        </div>

                        <div class="icon-grid" id="streamIconGrid"></div>
                        <input type="hidden" name="icon" id="streamIcon" value="{{ old('icon') }}">
                    </div>

                    <div class="info-box">
                        <span class="info-icon">
                            <i class="bi bi-info-lg"></i>
                        </span>
                        <span>
                            Choose a clear category name such as Engineering, Management,
                            Commerce, Science or Pharmacy. The stream will be used to group related courses.
                        </span>
                    </div>

                    <div class="actions">
                        <button type="submit" class="action-btn save-btn">
                            <i class="bi bi-check2-circle"></i>
                            Save Stream
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
</div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const grid = document.getElementById('streamIconGrid');
    const input = document.getElementById('streamIcon');
    if (!grid || !input) return;

    const icons = [['bi-laptop','Engineering / IT'],['bi-gear-wide-connected','Engineering'],['bi-cpu','Technology'],['bi-code-slash','Computer Science'],['bi-briefcase-fill','Management'],['bi-bar-chart-fill','Commerce'],['bi-calculator-fill','Finance'],['bi-bank','Banking'],['bi-capsule','Pharmacy'],['bi-heart-pulse-fill','Medical'],['bi-hospital-fill','Healthcare'],['bi-flask-fill','Science'],['bi-atom','Physics / Science'],['bi-beaker-fill','Chemistry'],['bi-book-half','Arts / Humanities'],['bi-journal-bookmark-fill','Education'],['bi-mortarboard-fill','Education'],['bi-people-fill','Social Science'],['bi-globe2','International'],['bi-palette-fill','Design / Arts'],['bi-camera-fill','Media'],['bi-megaphone-fill','Mass Communication'],['bi-shield-fill-check','Law / Security'],['bi-building','Architecture'],['bi-tree-fill','Agriculture'],['bi-lightbulb-fill','General'],['bi-diagram-3-fill','General']];

    icons.forEach(([icon, label]) => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'icon-option';
        button.dataset.icon = icon;
        button.title = label;
        button.innerHTML = '<i class="bi ' + icon + '"></i><small>' + label + '</small>';

        button.addEventListener('click', function () {
            input.value = icon;
            grid.querySelectorAll('.icon-option').forEach(el => el.classList.remove('active'));
            button.classList.add('active');
        });

        grid.appendChild(button);
    });

    const current = input.value.trim();
    const active = grid.querySelector('[data-icon="' + current + '"]');
    if (active) active.classList.add('active');
});
</script>
@endpush

@endsection
