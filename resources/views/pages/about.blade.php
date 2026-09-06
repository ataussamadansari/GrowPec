@extends('layouts.app')

@section('title', 'About Us - ' . ($siteSettings['general.site_name'] ?? 'GrowPEC'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <!-- Left Column -->
        <div>
            <span class="inline-block bg-yellow-500 text-gray-900 px-4 py-2 rounded-full font-bold text-sm mb-6">
                About {{ $siteSettings['general.site_name'] ?? 'GrowPEC' }}
            </span>
            <h2 class="text-4xl font-bold text-purple-900 mb-6">
                {{ $siteSettings['general.site_tagline'] ?? 'Helping Students Choose The Right College & Career' }}
            </h2>
            <p class="text-gray-600 leading-relaxed mb-8">
                {{ $siteSettings['general.site_description'] ?? 'GrowPEC is dedicated to simplifying college selection for students across India. We provide verified data, accurate fee structures, and personalized counseling to help you make informed decisions for regular and online degree programs.' }}
            </p>
            <button onclick="openEnquiryModal()" class="inline-flex items-center gap-2 px-6 py-3 bg-yellow-500 text-gray-900 font-bold rounded-xl hover:bg-yellow-600 transition transform hover:-translate-y-0.5">
                <i class="bi bi-headset"></i> Get Free Counselling
            </button>
        </div>

        <!-- Right Column -->
        <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-lg">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Why Trust {{ $siteSettings['general.site_name'] ?? 'GrowPEC' }}?</h3>
            <ul class="space-y-4">
                <li class="flex items-start gap-3">
                    <i class="bi bi-check-circle-fill text-green-600 text-xl flex-shrink-0 mt-0.5"></i>
                    <span class="text-gray-700">100% Free & Unbiased Admission Counselling</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="bi bi-check-circle-fill text-green-600 text-xl flex-shrink-0 mt-0.5"></i>
                    <span class="text-gray-700">Verified Fee Structures, UGC & AICTE Approvals</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="bi bi-check-circle-fill text-green-600 text-xl flex-shrink-0 mt-0.5"></i>
                    <span class="text-gray-700">Direct Admission & Merit Scholarship Assistance</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="bi bi-check-circle-fill text-green-600 text-xl flex-shrink-0 mt-0.5"></i>
                    <span class="text-gray-700">Zero Fees or Hidden Processing Charges for Students</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection