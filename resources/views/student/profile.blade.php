@extends('layouts.app')

@section('title', 'My Dashboard - ' . $user->name . ' | ' . ($siteSettings['general.site_name'] ?? 'GrowPEC'))

@push('styles')
<style>
    .profile-hero {
        background: linear-gradient(135deg, var(--primary-dark, #1E1346) 0%, var(--primary-purple, #2E1E6B) 100%);
        border-radius: 24px;
        color: #ffffff;
        padding: 35px 40px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }
    .profile-avatar-wrapper {
        position: relative;
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: #ffffff;
        padding: 4px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.25);
    }
    .profile-avatar-img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }
    .profile-nav-card {
        background: #ffffff;
        border: 1px solid #E5E7EB;
        border-radius: 20px;
        padding: 16px;
    }
    .profile-nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 18px;
        border-radius: 14px;
        font-weight: 600;
        font-size: 0.9rem;
        color: #475569;
        text-decoration: none;
        margin-bottom: 8px;
        transition: all 0.2s ease;
        background: #F8FAFC;
        border: none;
        width: 100%;
        text-align: left;
    }
    .profile-nav-item:hover {
        background: #FAF8FF;
        color: var(--primary-purple);
    }
    .profile-nav-item.active {
        background: var(--primary-purple) !important;
        color: #ffffff !important;
    }
    .profile-form-card {
        background: #ffffff;
        border: 1px solid #E5E7EB;
        border-radius: 24px;
        padding: 35px;
    }
    .form-control-pill {
        border-radius: 25px !important;
        border: 1px solid #CBD5E1 !important;
        padding: 10px 20px !important;
        font-size: 0.9rem !important;
    }
    .btn-save-pill {
        background: var(--primary-purple);
        color: #ffffff;
        font-weight: 700;
        border-radius: 25px;
        padding: 10px 36px;
        border: none;
        transition: all 0.2s;
    }
    .btn-save-pill:hover {
        opacity: 0.90;
        color: #ffffff;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <!-- Top Hero Card -->
    <div class="profile-hero shadow-sm">
        <div class="d-flex align-items-center gap-4 flex-wrap">
            <div class="profile-avatar-wrapper">
                <img src="{{ $user->avatar_url }}" class="profile-avatar-img" alt="{{ $user->name }}">
            </div>
            <div>
                <h3 class="fw-extrabold mb-1 text-white">{{ $user->name }}</h3>
                <p class="mb-1 text-white-50 small">
                    <i class="bi bi-telephone-fill text-warning me-2"></i>+91 {{ $user->phone }}
                </p>
                <p class="mb-0 text-white-50 small">
                    <i class="bi bi-geo-alt-fill text-danger me-2"></i>{{ $user->city ? $user->city . ', ' . $user->state : 'Location not set' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Main Tabs & Content -->
    <div class="row g-4">
        <!-- Left Side: Tabs -->
        <div class="col-lg-3">
            <div class="profile-nav-card shadow-sm">
                <div class="nav flex-column" id="studentTab" role="tablist">
                    <button class="profile-nav-item active" id="tab-profile-btn" data-bs-toggle="pill" data-bs-target="#tab-profile" type="button">
                        <i class="bi bi-person-vcard"></i> Profile Details
                    </button>
                    <button class="profile-nav-item" id="tab-enquiries-btn" data-bs-toggle="pill" data-bs-target="#tab-enquiries" type="button">
                        <i class="bi bi-card-checklist"></i> My Applications ({{ $myLeads->count() }})
                    </button>
                    <a href="{{ route('colleges.regular') }}" class="profile-nav-item text-decoration-none">
                        <i class="bi bi-search"></i> Explore Colleges
                    </a>
                    <a href="tel:{{ $siteSettings['general.support_phone'] ?? '8858285271' }}" class="profile-nav-item text-decoration-none">
                        <i class="bi bi-headset"></i> Call Counselor
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Side: Panes -->
        <div class="col-lg-9">
            <div class="profile-form-card shadow-sm">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 py-2 px-3 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <div class="tab-content" id="studentTabContent">
                    <!-- Tab 1: Edit Profile -->
                    <div class="tab-pane fade show active" id="tab-profile" role="tabpanel">
                        <h5 class="fw-bold mb-4 pb-2 border-bottom text-dark">
                            <i class="bi bi-person-circle text-primary me-2"></i> Edit Personal Profile
                        </h5>

                        <form action="{{ route('student.profile.update') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted">Full Name *</label>
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control form-control-pill" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted">Gender</label>
                                        <select name="gender" class="form-select form-control-pill">
                                            <option value="">Select Gender</option>
                                            <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                            <option value="Other" {{ old('gender', $user->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted">Date of Birth</label>
                                        <input type="date" name="dob" value="{{ old('dob', $user->dob ? $user->dob->format('Y-m-d') : '') }}" class="form-control form-control-pill">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted">City</label>
                                        <input type="text" name="city" value="{{ old('city', $user->city) }}" class="form-control form-control-pill" placeholder="e.g. Varanasi, Lucknow">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted">Phone Number (Strictly 10 Digits) *</label>
                                        <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control form-control-pill" maxlength="10" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted">Email Address</label>
                                        <input type="email" name="email" value="{{ old('email', str_ends_with($user->email ?? '', '@growpec.local') ? '' : $user->email) }}" class="form-control form-control-pill" placeholder="name@example.com">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted">State</label>
                                        <input type="text" name="state" value="{{ old('state', $user->state) }}" class="form-control form-control-pill" placeholder="e.g. Uttar Pradesh">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted">Address</label>
                                        <input type="text" name="address" value="{{ old('address', $user->address) }}" class="form-control form-control-pill" placeholder="Area, Landmark">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-top text-end">
                                <button type="submit" class="btn btn-save-pill">
                                    Save Profile Changes
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Tab 2: My Applications & Inquiries (Real Database Data) -->
                    <div class="tab-pane fade" id="tab-enquiries" role="tabpanel">
                        <h5 class="fw-bold mb-4 pb-2 border-bottom text-dark">
                            <i class="bi bi-card-checklist text-primary me-2"></i> My Admission Inquiries & Applications
                        </h5>

                        @forelse($myLeads as $inq)
                        <div class="p-3 border rounded-4 bg-light mb-3 shadow-sm d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div>
                                <h6 class="fw-bold text-dark mb-1">
                                    {{ $inq->college->name ?? 'General Admission Inquiry' }}
                                </h6>
                                <div class="small text-muted mb-1">
                                    <i class="bi bi-mortarboard me-1 text-primary"></i> Program: <strong>{{ $inq->course->name ?? 'General' }}</strong>
                                    @if($inq->city) • <i class="bi bi-geo-alt me-1 text-danger"></i> {{ $inq->city }} @endif
                                </div>
                                <small class="text-secondary">Submitted on: {{ $inq->created_at->format('d M Y, h:i A') }}</small>
                            </div>

                            <div class="text-md-end">
                                <span class="badge bg-{{ $inq->status == 'admitted' ? 'success' : ($inq->status == 'counseling' ? 'warning' : 'primary') }}-subtle text-dark px-3 py-2 fw-bold d-block mb-2">
                                    Status: {{ strtoupper($inq->status) }}
                                </span>
                                @if($inq->college)
                                <a href="{{ route('college.show', $inq->college->slug) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    View College Details
                                </a>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                            <h6 class="fw-bold text-dark">No inquiries submitted yet</h6>
                            <p class="small text-muted">Explore colleges and submit free counseling inquiries to track status here.</p>
                            <a href="{{ route('colleges.regular') }}" class="btn btn-warning btn-sm fw-bold rounded-pill px-4">
                                Browse Colleges
                            </a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection