@extends('layouts.app')
@section('title', 'Contact Us - GrowPec')
@section('content')
<div class="container py-5">
    <div class="text-center max-w-xl mx-auto mb-5">
        <h2 class="fw-bold" style="color: var(--primary-purple);">Get in Touch with Us</h2>
        <p class="text-secondary">Have questions about college admissions or fees? We are here to help.</p>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="bg-white p-4 shadow-sm rounded-4 border">
                <form id="contactPageLeadForm" action="{{ route('lead.submit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="source" value="contact_page">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Your Name *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Phone Number *</label>
                        <input type="tel" name="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Email Address</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Your City</label>
                        <input type="text" name="city" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-gold w-100 py-2">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection