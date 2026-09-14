@extends('layouts.app')
@section('title', 'My Profile - ' . $user->name . ' | GrowPec')

@push('styles')
<style>
    /* Profile Hero Card */
    .profile-hero {
        background: linear-gradient(135deg, #1E1346 0%, #2E1E6B 60%, #442B8D 100%);
        border-radius: 24px;
        color: #ffffff;
        padding: 35px 40px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }
    .profile-avatar-wrapper {
        position: relative;
        width: 100px;
        height: 100px;
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
    .profile-avatar-edit {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 28px;
        height: 28px;
        background: #2E1E6B;
        color: #ffffff;
        border-radius: 50%;
        border: 2px solid #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
    }
    /* Left Sidebar Tabs */
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
    }
    .profile-nav-item:hover {
        background: #FAF8FF;
        color: #2E1E6B;
    }
    .profile-nav-item.active {
        background: #2E1E6B;
        color: #ffffff;
    }
    /* Form Inputs */
    .profile-form-card {
        background: #ffffff;
        border: 1px solid #E5E7EB;
        border-radius: 24px;
        padding: 35px;
    }
    .form-control-pill {
        border-radius: 25px !important;
        border: 1px solid #CBD5E1 !important;
        padding: 11px 20px !important;
        font-size: 0.9rem !important;
        color: #1E293B !important;
        background-color: #ffffff;
    }
    .form-control-pill:focus {
        border-color: #2E1E6B !important;
        box-shadow: 0 0 0 3px rgba(46, 30, 107, 0.12) !important;
    }
    .btn-save-pill {
        background: #2E1E6B;
        color: #ffffff;
        font-weight: 700;
        border-radius: 25px;
        padding: 10px 36px;
        border: none;
        transition: all 0.2s;
    }
    .btn-save-pill:hover {
        background: #1E1346;
        color: #ffffff;
    }
    .btn-logout-pill {
        background: #EF4444;
        color: #ffffff;
        font-weight: 700;
        border-radius: 25px;
        padding: 10px 28px;
        border: none;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <!-- 1. Top Profile Hero Banner -->
    <div class="profile-hero shadow-sm">
        <div class="d-flex align-items-center gap-4 flex-wrap">
            <div class="profile-avatar-wrapper">
                <img src="{{ $user->avatar_url }}" class="profile-avatar-img" alt="{{ $user->name }}">
                <div class="profile-avatar-edit"><i class="bi bi-pencil-fill"></i></div>
            </div>
            <div>
                <h3 class="fw-extrabold mb-1 text-white">{{ $user->name }}</h3>
                <p class="mb-1 text-white-50 small">
                    <i class="bi bi-envelope-fill text-warning me-2"></i>{{ $user->email ?? 'No email provided' }}
                </p>
                <p class="mb-0 text-white-50 small">
                    <i class="bi bi-geo-alt-fill text-danger me-2"></i>{{ $user->city ? $user->city . ', ' . $user->state : 'Location not set' }}
                </p>
            </div>
        </div>
    </div>

    <!-- 2. Main Content (Tabs + Form) -->
    <div class="row g-4">
        <!-- Left Side: Tabs Sidebar (col-lg-3) -->
        <div class="col-lg-3">
            <div class="profile-nav-card shadow-sm">
                <a href="{{ route('student.profile') }}" class="profile-nav-item active">
                    <i class="bi bi-person-vcard"></i> Profile
                </a>
                <a href="#brochure" class="profile-nav-item">
                    <i class="bi bi-file-earmark-pdf"></i> Brochure
                </a>
                <a href="#referral" class="profile-nav-item">
                    <i class="bi bi-people"></i> Referral
                </a>
                <a href="#reviews" class="profile-nav-item">
                    <i class="bi bi-pencil-square"></i> Write Review
                </a>
                <a href="#comparison" class="profile-nav-item">
                    <i class="bi bi-arrow-left-right"></i> Comparison
                </a>
                <a href="#fee-details" class="profile-nav-item">
                    <i class="bi bi-wallet2"></i> Fee details
                </a>
            </div>
        </div>

        <!-- Right Side: Profile Edit Form (col-lg-9) -->
        <div class="col-lg-9">
            <div class="profile-form-card shadow-sm">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 py-2 px-3 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <form action="{{ route('student.profile.update') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <!-- Column 1 -->
                        <div class="col-md-6">
                            <!-- Full Name -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Full Name *</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control form-control-pill" placeholder="Ataussamad Ansari" required>
                            </div>
                            <!-- Gender -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Gender</label>
                                <select name="gender" class="form-select form-control-pill">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender', $user->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <!-- Date of Birth -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Date of Birth</label>
                                <input type="date" name="dob" value="{{ old('dob', $user->dob ? $user->dob->format('Y-m-d') : '') }}" class="form-control form-control-pill">
                            </div>
                            <!-- City -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">City</label>
                                <input type="text" name="city" value="{{ old('city', $user->city) }}" class="form-control form-control-pill" placeholder="e.g. Varanasi, Lucknow">
                            </div>
                        </div>

                        <!-- Column 2 -->
                        <div class="col-md-6">
                            <!-- Phone -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Phone Number *</label>
                                <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control form-control-pill" placeholder="8858285271" required>
                            </div>
                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Email Address</label>
                                <input type="email" name="email" value="{{ old('email', str_ends_with($user->email ?? '', '@growpec.local') ? '' : $user->email) }}" class="form-control form-control-pill" placeholder="samadvns1@gmail.com">
                            </div>
                            <!-- State -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">State</label>
                                <input type="text" name="state" value="{{ old('state', $user->state) }}" class="form-control form-control-pill" placeholder="e.g. Uttar Pradesh">
                            </div>
                            <!-- Address -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Address</label>
                                <input type="text" name="address" value="{{ old('address', $user->address) }}" class="form-control form-control-pill" placeholder="House no, Area, Landmark">
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Buttons -->
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-save-pill">
                            Save
                        </button>

                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-logout-pill btn-sm">
                                Logout
                            </button>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection