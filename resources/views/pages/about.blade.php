@extends('layouts.app')
@section('title', 'About Us - GrowPec')
@section('content')
<div class="container py-5">
    <div class="row align-items-center g-5">
        <div class="col-lg-6">
            <span class="badge bg-warning text-dark px-3 py-2 fw-bold mb-3">About GrowPec</span>
            <h2 class="fw-bold mb-4" style="color: var(--primary-purple);">Helping Students Choose The Right College & Career</h2>
            <p class="text-secondary leading-relaxed">
                GrowPec is dedicated to simplifying college selection for students across India. We provide verified data, accurate fee structures, and personalized counseling to help you make informed decisions for regular and online degree programs.
            </p>
            <button class="btn btn-gold mt-3" data-bs-toggle="modal" data-bs-target="#counselingModal">Get Free Counselling</button>
        </div>
        <div class="col-lg-6">
            <div class="p-4 bg-white shadow-sm rounded-4 border">
                <h5 class="fw-bold text-dark mb-3">Why Trust GrowPec?</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-3 d-flex align-items-center"><i class="bi bi-check-circle-fill text-success me-2 fs-5"></i> 100% Free & Unbiased Counselling</li>
                    <li class="mb-3 d-flex align-items-center"><i class="bi bi-check-circle-fill text-success me-2 fs-5"></i> Verified Fee Structures & Approvals</li>
                    <li class="mb-3 d-flex align-items-center"><i class="bi bi-check-circle-fill text-success me-2 fs-5"></i> Direct Admission & Scholarship Assistance</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection