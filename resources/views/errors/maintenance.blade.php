<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Maintenance - {{ $siteSettings['general.site_name'] ?? 'GrowPEC' }}</title>

    @if(!empty($siteSettings['general.favicon']))
    <link rel="icon" type="image/png" href="{{ asset($siteSettings['general.favicon']) }}">
    @else
    <link rel="icon" type="image/png" href="{{ asset('assets/growpec.png') }}">
    @endif

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gradient-to-br from-purple-900 via-purple-800 to-purple-900 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-lg bg-white rounded-3xl shadow-2xl p-10 text-center">
    <!-- Logo -->
    <div class="mb-6">
        <img src="{{ asset($siteSettings['general.logo'] ?? 'assets/growpec.png') }}"
             alt="{{ $siteSettings['general.site_name'] ?? 'GrowPEC' }} Logo"
             class="h-14 w-auto object-contain mx-auto">
    </div>

    <!-- Icon -->
    <div class="w-24 h-24 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center text-5xl mx-auto mb-6 shadow-lg">
        <i class="bi bi-tools"></i>
    </div>

    <!-- Heading -->
    <h2 class="text-3xl font-bold text-purple-900 mb-3">We'll Be Back Soon!</h2>

    <!-- Description -->
    <p class="text-gray-600 text-lg mb-6">
        Our portal is currently undergoing scheduled system upgrades to improve your college admission and counselling experience. We appreciate your patience.
    </p>

    <!-- Urgent Help Box -->
    <div class="bg-gray-50 border-l-4 border-yellow-500 p-4 rounded-lg mb-6 text-left">
        <h4 class="font-bold text-gray-900 mb-2 flex items-center gap-2">
            <i class="bi bi-headset text-yellow-600"></i>
            Need Urgent Admission Guidance?
        </h4>
        <p class="text-gray-600 text-sm mb-4">
            Our counselors are actively available on call and WhatsApp to assist with college forms and fees.
        </p>
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-1">
            <a href="tel:{{ $siteSettings['general.support_phone'] ?? '+918858285271' }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-purple-900 text-white font-bold rounded-lg hover:bg-purple-800 transition transform hover:-translate-y-0.5">
                <i class="bi bi-telephone-fill"></i>
                <span class="hidden sm:inline">{{ $siteSettings['general.support_phone'] ?? '+91 8858285271' }}</span>
                <span class="sm:hidden">Call</span>
            </a>
            <a href="https://wa.me/{{ $siteSettings['general.whatsapp_number'] ?? '918858285271' }}?text=Hello%20GrowPEC,%20I%20need%20urgent%20admission%20guidance." target="_blank" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-green-500 text-white font-bold rounded-lg hover:bg-green-600 transition transform hover:-translate-y-0.5">
                <i class="bi bi-whatsapp"></i>
                <span>WhatsApp</span>
            </a>
        </div>
    </div>

    <!-- Footer -->
    <div class="pt-4 border-t border-gray-200 text-gray-500 text-sm flex justify-between items-center">
        <span>© {{ date('Y') }} {{ $siteSettings['general.site_name'] ?? 'GrowPEC' }}</span>
    </div>
</div>

</body>
</html>