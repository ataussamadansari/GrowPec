@extends('layouts.app')

@section('title', 'Contact Us - ' . ($siteSettings['general.site_name'] ?? 'GrowPEC'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <!-- Header -->
    <div class="text-center max-w-2xl mx-auto mb-16">
        <h2 class="text-4xl font-bold text-purple-900 mb-4">Get in Touch with Our Counselors</h2>
        <p class="text-gray-600 text-lg">Have questions about college admissions, fees, or approvals? We are here to help.</p>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Contact Information -->
        <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-lg">
            <h3 class="text-xl font-bold text-gray-900 mb-8">Contact Information</h3>

            <div class="space-y-6">
                <!-- Address -->
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-red-100 rounded-full text-red-600 text-xl flex-shrink-0">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm mb-1">Head Office Address</h4>
                        <p class="text-gray-600 text-sm">{{ $siteSettings['general.office_address'] ?? 'Varanasi, Uttar Pradesh, India' }}</p>
                    </div>
                </div>

                <!-- Phone -->
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-green-100 rounded-full text-green-600 text-xl flex-shrink-0">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm mb-1">Support Helpline</h4>
                        <a href="tel:{{ $siteSettings['general.support_phone'] ?? '+918858285271' }}" class="text-gray-900 font-bold text-sm no-underline hover:text-purple-900 transition">
                            {{ $siteSettings['general.support_phone'] ?? '+91 8858285271' }}
                        </a>
                    </div>
                </div>

                <!-- WhatsApp -->
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-green-100 rounded-full text-green-600 text-xl flex-shrink-0">
                        <i class="bi bi-whatsapp"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm mb-1">WhatsApp Desk</h4>
                        <a href="https://wa.me/{{ $siteSettings['general.whatsapp_number'] ?? '918858285271' }}" target="_blank" class="text-green-600 font-bold text-sm no-underline hover:text-green-700 transition">
                            +{{ $siteSettings['general.whatsapp_number'] ?? '918858285271' }}
                        </a>
                    </div>
                </div>

                <!-- Email -->
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-yellow-100 rounded-full text-yellow-600 text-xl flex-shrink-0">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm mb-1">Official Email</h4>
                        <a href="mailto:{{ $siteSettings['general.support_email'] ?? 'info@growpec.com' }}" class="text-gray-600 text-sm no-underline hover:text-gray-900 transition">
                            {{ $siteSettings['general.support_email'] ?? 'info@growpec.com' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-lg">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Send Us A Message</h3>
            <form id="contactPageLeadForm" action="{{ route('lead.submit') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="source" value="contact_page">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Your Name *</label>
                    <input type="text" name="name" value="{{ Auth::user()->name ?? '' }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent transition" placeholder="Enter full name" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number *</label>
                    <input type="tel" name="phone" value="{{ Auth::user()->phone ?? '' }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent transition" placeholder="10-digit mobile number" maxlength="10" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ str_ends_with(Auth::user()->email ?? '', '@growpec.local') ? '' : (Auth::user()->email ?? '') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent transition" placeholder="Enter email address">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Your City *</label>
                    <input type="text" name="city" value="{{ Auth::user()->city ?? '' }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent transition" placeholder="e.g. Varanasi, Lucknow" required>
                </div>

                <div id="contactFormResp"></div>

                <button type="submit" id="contactSubmitBtn" class="w-full bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-3 px-4 rounded-lg transition transform hover:-translate-y-0.5">
                    Send Message & Request Guidance
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('contactPageLeadForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('contactSubmitBtn');
    const resp = document.getElementById('contactFormResp');
    btn.disabled = true;
    btn.innerText = 'Sending...';

    fetch(this.action, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            "Accept": "application/json"
        },
        body: new FormData(this)
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        btn.innerText = 'Send Message & Request Guidance';
        resp.innerHTML = `<div class="alert alert-success py-2 small mb-3">${data.message}</div>`;
        this.reset();
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerText = 'Send Message & Request Guidance';
        resp.innerHTML = `<div class="alert alert-danger py-2 small mb-3">Something went wrong. Please try again.</div>`;
    });
});
</script>
@endpush
@endsection