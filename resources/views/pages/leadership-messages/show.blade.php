@extends('layouts.app')

@section('title', $leadershipMessage->name . ' | ' . ucfirst($leadershipMessage->role) . ' Message - GrowPec')

@push('styles')
<style>
    .leader-detail-page { --leader-accent:#07985E; --leader-soft:#DDF5EB; position:relative; isolation:isolate; overflow:hidden; padding:30px 0 76px; background:radial-gradient(ellipse at 3% 8%,rgba(87,199,159,.12),transparent 28%),radial-gradient(ellipse at 96% 76%,rgba(89,164,233,.13),transparent 31%),linear-gradient(135deg,#F1FAF8 0%,#fff 48%,#F1F8FF 100%); }
    .leader-detail-page:before,.leader-detail-page:after { position:absolute; z-index:-1; width:310px; height:310px; border:1px solid rgba(43,184,136,.16); border-radius:50%; content:""; pointer-events:none; }
    .leader-detail-page:before { top:110px; right:-215px; box-shadow:0 0 0 35px rgba(43,184,136,.035),0 0 0 75px rgba(43,184,136,.025); }
    .leader-detail-page:after { bottom:150px; left:-225px; border-color:rgba(67,145,225,.15); box-shadow:0 0 0 35px rgba(67,145,225,.035),0 0 0 75px rgba(67,145,225,.025); }
    .leader-detail-wrap { max-width:1240px; margin:0 auto; }
    .leader-breadcrumbs { display:flex; flex-wrap:wrap; align-items:center; gap:9px; margin:0 0 27px; color:#7887A0; font-size:.82rem; }
    .leader-breadcrumbs a { color:#647795; text-decoration:none; }
    .leader-breadcrumbs a:hover { color:#078D59; }
    .leader-breadcrumbs i { color:#93A3BA; font-size:.7rem; }
    .leader-breadcrumbs span { color:#172849; font-weight:700; }
    .leader-detail-toolbar { display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:20px; }
    .leader-back-link,.leader-switch-link { display:inline-flex; align-items:center; justify-content:center; gap:10px; min-height:44px; color:#142746; font-size:.88rem; font-weight:750; text-decoration:none; }
    .leader-back-link i { display:grid; width:38px; height:38px; place-items:center; border:1px solid #E1EAF3; border-radius:50%; background:rgba(255,255,255,.86); box-shadow:0 5px 15px rgba(27,62,92,.06); }
    .leader-back-link:hover,.leader-switch-link:hover { color:#078D59; }
    .leader-switches { display:flex; gap:10px; }
    .leader-switch-link { padding:0 17px; border:1px solid #E0EAF3; border-radius:999px; background:rgba(255,255,255,.88); box-shadow:0 5px 15px rgba(27,62,92,.05); }
    .leader-switch-link.is-disabled { opacity:.42; pointer-events:none; }
    .leader-detail-card { --leader-accent:#07985E; --leader-soft:#DDF5EB; position:relative; display:grid; grid-template-columns:minmax(300px,.76fr) minmax(0,1.24fr); gap:clamp(28px,5vw,60px); overflow:hidden; padding:16px; border:1px solid rgba(255,255,255,.94); border-radius:30px; background:rgba(255,255,255,.94); box-shadow:0 24px 68px rgba(25,77,91,.1); }
    .leader-detail-card-ceo { --leader-accent:#1677E8; --leader-soft:#DCEBFF; }
    .leader-detail-profile-column { display:flex; min-width:0; flex-direction:column; gap:18px; }
    .leader-detail-profile { position:relative; display:flex; min-height:465px; align-items:flex-end; justify-content:center; overflow:hidden; border-radius:23px; background:radial-gradient(ellipse at 50% 30%,#fff 0%,transparent 54%),linear-gradient(145deg,var(--leader-soft),#F5FBFA); }
    .leader-detail-profile:before { position:absolute; top:20px; left:20px; width:78%; height:82%; border:1px solid rgba(255,255,255,.86); border-radius:46% 42% 28% 25%; content:""; }
    .leader-detail-photo { position:relative; z-index:1; display:grid; width:100%; height:100%; min-height:465px; place-items:center; color:var(--leader-accent); font-size:5rem; font-weight:850; }
    .leader-detail-photo img { position:absolute; bottom:0; width:100%; height:100%; object-fit:cover; object-position:center top; mask-image:linear-gradient(#000 77%,rgba(0,0,0,.84)); }
    .leader-detail-photo-fallback { position:relative; z-index:1; display:grid; width:200px; height:200px; margin-bottom:35px; place-items:center; border:8px solid rgba(255,255,255,.85); border-radius:50%; background:linear-gradient(145deg,var(--leader-soft),#fff); }
    .leader-detail-photo-note { position:absolute; z-index:2; bottom:16px; left:16px; display:flex; align-items:center; gap:12px; padding:12px 16px; border:1px solid rgba(255,255,255,.9); border-radius:17px; background:linear-gradient(110deg,color-mix(in srgb,var(--leader-accent),#fff 14%),color-mix(in srgb,var(--leader-accent),#087849 24%)); box-shadow:0 10px 26px rgba(17,83,68,.2); color:#fff; font-size:.88rem; font-weight:800; }
    .leader-detail-photo-note i { display:grid; width:38px; height:38px; place-items:center; border-radius:50%; background:rgba(255,255,255,.2); font-size:1.15rem; }
    .leader-detail-facts { display:grid; gap:15px; padding:20px; border-radius:22px; background:linear-gradient(145deg,#F5FAFE,#F0F8F6); }
    .leader-detail-fact { display:flex; align-items:center; gap:13px; min-width:0; }
    .leader-detail-fact-icon { display:grid; width:42px; height:42px; flex:0 0 42px; place-items:center; border:1px solid #fff; border-radius:50%; background:#fff; box-shadow:0 5px 14px rgba(30,75,101,.06); color:var(--leader-accent); font-size:1.05rem; }
    .leader-detail-fact-copy { display:grid; min-width:0; gap:2px; }
    .leader-detail-fact-copy span { color:#7787A0; font-size:.74rem; }
    .leader-detail-fact-copy strong { color:#142746; font-size:.86rem; font-weight:750; overflow-wrap:anywhere; }
    .leader-detail-message { position:relative; display:flex; min-width:0; flex-direction:column; justify-content:center; padding:22px clamp(8px,2vw,22px) 22px 0; }
    .leader-detail-role { position:relative; z-index:1; display:inline-flex; align-self:flex-start; padding:7px 14px; border-radius:999px; background:var(--leader-soft); color:var(--leader-accent); font-size:.82rem; font-weight:850; letter-spacing:.06em; text-transform:uppercase; }
    .leader-detail-name { position:relative; z-index:1; margin:12px 0 2px; color:#101F40; font-size:clamp(2rem,4.2vw,3.15rem); font-weight:850; letter-spacing:-.045em; line-height:1.1; overflow-wrap:anywhere; }
    .leader-detail-name span { color:var(--leader-accent); }
    .leader-detail-designation { margin:0 0 27px; color:#74839D; font-size:1.05rem; }
    .leader-detail-quote-mark { position:absolute; top:5px; right:14px; color:var(--leader-soft); font-family:Georgia,serif; font-size:8rem; font-weight:700; line-height:1; pointer-events:none; }
    .leader-detail-copy { position:relative; z-index:1; margin:0; color:#596A87; font-size:.99rem; line-height:1.75; white-space:pre-line; overflow-wrap:anywhere; }
    .leader-detail-pullquote { display:flex; gap:14px; margin-top:22px; padding:18px; border:1px solid color-mix(in srgb,var(--leader-accent),transparent 88%); border-radius:18px; background:linear-gradient(110deg,color-mix(in srgb,var(--leader-soft),#fff 48%),rgba(232,249,242,.82)); color:#243959; font-size:.96rem; font-style:italic; font-weight:650; line-height:1.6; }
    .leader-detail-pullquote i { display:grid; width:34px; height:34px; flex:0 0 34px; place-items:center; border-radius:50%; background:#fff; color:var(--leader-accent); font-size:1.2rem; font-style:normal; }
    .leader-detail-signoff { display:grid; gap:3px; margin-top:26px; color:#75839B; font-size:.92rem; }
    .leader-detail-signoff strong { color:#112141; font-family:cursive; font-size:clamp(1.7rem,3vw,2.4rem); font-weight:500; }
    .leader-detail-footer { display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:14px; margin-top:22px; padding-top:18px; border-top:1px solid #E8EDF2; }
    .leader-detail-footer span { color:#748196; font-size:.76rem; }
    .leader-contact-link { display:inline-flex; align-items:center; gap:9px; padding:12px 17px; border-radius:14px; background:linear-gradient(110deg,var(--leader-accent),color-mix(in srgb,var(--leader-accent),#087849 24%)); box-shadow:0 8px 20px color-mix(in srgb,var(--leader-accent),transparent 80%); color:#fff; font-size:.82rem; font-weight:800; text-decoration:none; transition:transform .2s ease; }
    .leader-contact-link:hover { transform:translateY(-2px); color:#fff; }
    .leader-team { margin-top:46px; }
    .leader-team-heading { margin-bottom:19px; }
    .leader-team-heading h2 { margin:0 0 5px; color:#122141; font-size:clamp(1.55rem,3vw,2.15rem); font-weight:850; letter-spacing:-.035em; }
    .leader-team-heading h2 span { color:#07985E; }
    .leader-team-heading p { margin:0; color:#74839D; font-size:.95rem; }
    .leader-team-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:16px; }
    .leader-team-card { --leader-team-accent:#07985E; --leader-team-soft:#DDF5EB; display:grid; grid-template-columns:130px minmax(0,1fr); align-items:center; gap:18px; min-width:0; padding:16px; border:1px solid color-mix(in srgb,var(--leader-team-accent),transparent 78%); border-radius:23px; background:rgba(255,255,255,.9); box-shadow:0 12px 32px rgba(25,77,91,.07); color:inherit; text-decoration:none; transition:transform .2s ease,box-shadow .2s ease; }
    .leader-team-card-ceo { --leader-team-accent:#1677E8; --leader-team-soft:#DCEBFF; }
    .leader-team-card:hover { transform:translateY(-3px); box-shadow:0 17px 38px rgba(25,77,91,.11); }
    .leader-team-photo { position:relative; display:grid; width:130px; height:142px; place-items:center; overflow:hidden; border-radius:17px; background:linear-gradient(145deg,var(--leader-team-soft),#F5FBFA); color:var(--leader-team-accent); font-size:2.5rem; font-weight:850; }
    .leader-team-photo img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center top; }
    .leader-team-copy { min-width:0; }
    .leader-team-role { display:inline-flex; padding:5px 10px; border-radius:999px; background:var(--leader-team-soft); color:var(--leader-team-accent); font-size:.66rem; font-weight:850; text-transform:uppercase; }
    .leader-team-copy h3 { margin:7px 0 1px; color:#122141; font-size:1.02rem; font-weight:850; overflow-wrap:anywhere; }
    .leader-team-copy p { margin:0; color:#75839B; font-size:.76rem; }
    .leader-team-excerpt { display:-webkit-box; overflow:hidden; margin-top:10px!important; color:#596A87!important; line-height:1.5; -webkit-box-orient:vertical; -webkit-line-clamp:2; }
    .leader-team-arrow { display:grid; width:36px; height:36px; flex:0 0 36px; place-items:center; justify-self:end; border-radius:50%; background:var(--leader-team-soft); color:var(--leader-team-accent); }
    @media (max-width:991.98px) { .leader-detail-card { grid-template-columns:minmax(240px,.72fr) minmax(0,1.28fr); gap:25px; } .leader-detail-profile,.leader-detail-photo { min-height:390px; } .leader-team-grid { grid-template-columns:1fr; } }
    @media (max-width:767.98px) { .leader-detail-page { padding:20px 0 52px; } .leader-breadcrumbs { margin-bottom:18px; font-size:.74rem; } .leader-detail-toolbar { align-items:flex-start; flex-direction:column; } .leader-switches { align-self:flex-end; } .leader-detail-card { grid-template-columns:1fr; gap:0; padding:10px; border-radius:23px; } .leader-detail-profile-column { gap:12px; } .leader-detail-profile,.leader-detail-photo { min-height:330px; max-height:440px; } .leader-detail-message { padding:27px 12px 15px; } .leader-detail-quote-mark { top:13px; right:8px; font-size:6rem; } .leader-detail-designation { margin-bottom:19px; } .leader-detail-copy { font-size:.9rem; line-height:1.7; } .leader-detail-footer { align-items:flex-start; flex-direction:column; } .leader-team { margin-top:35px; } .leader-team-card { grid-template-columns:88px minmax(0,1fr) 34px; gap:12px; padding:12px; } .leader-team-photo { width:88px; height:100px; border-radius:14px; } .leader-team-excerpt { font-size:.72rem!important; } }
    @media (max-width:420px) { .leader-team-card { grid-template-columns:72px minmax(0,1fr) 30px; gap:9px; } .leader-team-photo { width:72px; height:88px; } .leader-switch-link { padding:0 12px; font-size:.78rem; } .leader-detail-photo,.leader-detail-profile { min-height:290px; } }
</style>
@endpush

@section('content')
<section class="leader-detail-page">
    <div class="container leader-detail-wrap">
        <nav class="leader-breadcrumbs" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Home</a><i class="bi bi-chevron-right"></i>
            <a href="{{ route('about') }}">About Us</a><i class="bi bi-chevron-right"></i>
            <a href="{{ route('about') }}#leadershipMessages">Our Leadership</a><i class="bi bi-chevron-right"></i>
            <span>{{ ucfirst($leadershipMessage->role) }}'s Message</span>
        </nav>

        <div class="leader-detail-toolbar">
            <a href="{{ route('about') }}#leadershipMessages" class="leader-back-link">
                <i class="bi bi-arrow-left"></i> Back to Our Leadership
            </a>
            <div class="leader-switches" aria-label="Browse leadership messages">
                <a href="{{ $previousLeadershipMessage ? route('leadership-messages.show', $previousLeadershipMessage) : '#' }}" class="leader-switch-link{{ $previousLeadershipMessage ? '' : ' is-disabled' }}" @if(!$previousLeadershipMessage) aria-disabled="true" @endif>
                    <i class="bi bi-chevron-left"></i> Previous
                </a>
                <a href="{{ $nextLeadershipMessage ? route('leadership-messages.show', $nextLeadershipMessage) : '#' }}" class="leader-switch-link{{ $nextLeadershipMessage ? '' : ' is-disabled' }}" @if(!$nextLeadershipMessage) aria-disabled="true" @endif>
                    Next <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        </div>

        <article class="leader-detail-card leader-detail-card-{{ $leadershipMessage->role }}">
            <aside class="leader-detail-profile-column">
                <div class="leader-detail-profile">
                    <div class="leader-detail-photo">
                        @if($leadershipMessage->photo_url)
                            <img src="{{ $leadershipMessage->photo_url }}" alt="{{ $leadershipMessage->name }}" fetchpriority="high">
                        @else
                            <span class="leader-detail-photo-fallback">{{ mb_strtoupper(mb_substr($leadershipMessage->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div class="leader-detail-photo-note">
                        <i class="bi bi-mortarboard"></i>
                        <span>{{ $leadershipMessage->role === 'ceo' ? 'Empowering Every Student' : 'Building Better Futures' }}</span>
                    </div>
                </div>
                <div class="leader-detail-facts">
                    <div class="leader-detail-fact">
                        <span class="leader-detail-fact-icon"><i class="bi bi-mortarboard"></i></span>
                        <span class="leader-detail-fact-copy"><span>Designation</span><strong>{{ $leadershipMessage->designation }}</strong></span>
                    </div>
                    <div class="leader-detail-fact">
                        <span class="leader-detail-fact-icon"><i class="bi bi-building"></i></span>
                        <span class="leader-detail-fact-copy"><span>Organization</span><strong>GrowPec</strong></span>
                    </div>
                    <div class="leader-detail-fact">
                        <span class="leader-detail-fact-icon"><i class="bi bi-compass"></i></span>
                        <span class="leader-detail-fact-copy"><span>Focus Area</span><strong>Student Growth &amp; Education</strong></span>
                    </div>
                    <div class="leader-detail-fact">
                        <span class="leader-detail-fact-icon"><i class="bi bi-people"></i></span>
                        <span class="leader-detail-fact-copy"><span>Vision</span><strong>Guidance for every student</strong></span>
                    </div>
                </div>
            </aside>

            <div class="leader-detail-message">
                <span class="leader-detail-role">{{ ucfirst($leadershipMessage->role) }}</span>
                <h1 class="leader-detail-name">{{ $leadershipMessage->name }}</h1>
                <p class="leader-detail-designation">{{ $leadershipMessage->designation }}</p>
                <span class="leader-detail-quote-mark" aria-hidden="true">“</span>
                <p class="leader-detail-copy">{{ $leadershipMessage->message }}</p>
                <blockquote class="leader-detail-pullquote">
                    <i class="bi bi-quote" aria-hidden="true"></i>
                    <span>{{ \Illuminate\Support\Str::limit($leadershipMessage->message, 180) }}</span>
                </blockquote>
                <div class="leader-detail-signoff">
                    <strong>{{ $leadershipMessage->name }}</strong>
                    <span>{{ $leadershipMessage->designation }}</span>
                </div>
                <div class="leader-detail-footer">
                    <span>GrowPec · Discover. Compare. Move forward.</span>
                    <a href="{{ route('contact') }}" class="leader-contact-link">
                        Talk to our team <i class="bi bi-arrow-up-right"></i>
                    </a>
                </div>
            </div>
        </article>

        @if($leadershipMessages->count() > 1)
        <section class="leader-team" aria-labelledby="leaderTeamTitle">
            <div class="leader-team-heading">
                <h2 id="leaderTeamTitle">Our <span>Leadership</span> Team</h2>
                <p>Meet the people who are driving our vision forward.</p>
            </div>
            <div class="leader-team-grid">
                @foreach($leadershipMessages as $teamMember)
                    @if(!$teamMember->is($leadershipMessage))
                    <a href="{{ route('leadership-messages.show', $teamMember) }}" class="leader-team-card leader-team-card-{{ $teamMember->role }}">
                        <span class="leader-team-photo">
                            @if($teamMember->photo_url)
                                <img src="{{ $teamMember->photo_url }}" alt="{{ $teamMember->name }}" loading="lazy">
                            @else
                                {{ mb_strtoupper(mb_substr($teamMember->name, 0, 1)) }}
                            @endif
                        </span>
                        <span class="leader-team-copy">
                            <span class="leader-team-role">{{ ucfirst($teamMember->role) }}</span>
                            <h3>{{ $teamMember->name }}</h3>
                            <p>{{ $teamMember->designation }}</p>
                            <p class="leader-team-excerpt">{{ \Illuminate\Support\Str::limit($teamMember->message, 100) }}</p>
                        </span>
                        <span class="leader-team-arrow"><i class="bi bi-arrow-right"></i></span>
                    </a>
                    @endif
                @endforeach
            </div>
        </section>
        @endif
    </div>
</section>
@endsection
