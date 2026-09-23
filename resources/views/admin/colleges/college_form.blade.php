{{-- ══════════════════════════════════════════════════════════════
     COLLEGE FORM — Multi-Tab (Create & Edit)
     CSS + HTML only. JS is in _form_js.blade.php
══════════════════════════════════════════════════════════════ --}}

@push('styles')
<style>
/* ── Root vars ─────────────────────────────── */
:root{
  --cn:#002B67; --cn2:#001B45; --cg:#008A43; --cg2:#005C32;
  --co:#D9A400; --co2:#B78300; --cb:#E2E8F0; --ct:#172033;
  --cm:#68758A; --cs:#F6F8FB;
}

/* ── Page wrapper ───────────────────────────── */
.cf-page{max-width:1600px;margin:0 auto;}

/* ── Hero banner ────────────────────────────── */
.cf-hero{
  position:relative;overflow:hidden;
  padding:22px 26px;margin-bottom:20px;border-radius:16px;
  color:#fff;
  background:radial-gradient(circle at 92% 15%,rgba(217,164,0,.18),transparent 28%),
             linear-gradient(135deg,var(--cn2),var(--cn) 55%,#174B8F);
  box-shadow:0 10px 28px rgba(0,43,103,.16);
}
.cf-hero::after{
  content:"";position:absolute;width:200px;height:200px;
  right:-70px;bottom:-120px;border-radius:50%;
  border:1px solid rgba(255,255,255,.1);
  box-shadow:0 0 0 35px rgba(255,255,255,.03);
}
.cf-hero-inner{position:relative;z-index:1;display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:14px;}
.cf-eyebrow{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:999px;font-size:.61rem;font-weight:800;letter-spacing:.07em;text-transform:uppercase;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.16);}
.cf-hero h2{margin:9px 0 3px;font-size:1.3rem;font-weight:800;letter-spacing:-.01em;}
.cf-hero p{margin:0;color:rgba(255,255,255,.72);font-size:.73rem;}
.cf-edit-pill{display:inline-flex;align-items:center;gap:5px;margin-top:8px;padding:4px 10px;border-radius:8px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.14);color:rgba(255,255,255,.88);font-size:.63rem;font-weight:700;}
.cf-back-btn{
  display:inline-flex;align-items:center;gap:7px;
  padding:9px 18px;border-radius:25px;
  background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.28);
  color:#fff;font-size:.76rem;font-weight:700;text-decoration:none;
  white-space:nowrap;transition:background .18s;flex-shrink:0;
}
.cf-back-btn:hover{background:rgba(255,255,255,.26);color:#fff;}

/* ── Tab strip ───────────────────────────────── */
.cf-tabstrip{
  display:flex;flex-wrap:wrap;gap:3px;
  padding:8px;background:#fff;
  border:1px solid var(--cb);border-radius:12px;
  margin-bottom:18px;box-shadow:0 2px 8px rgba(0,0,0,.04);
}
.cf-tb{
  display:inline-flex;align-items:center;gap:6px;
  padding:7px 14px;border-radius:8px;border:none;
  font-size:.72rem;font-weight:700;cursor:pointer;
  background:transparent;color:var(--cm);
  transition:all .18s;white-space:nowrap;
}
.cf-tb:hover{background:var(--cs);color:var(--cn);}
.cf-tb.on{background:linear-gradient(135deg,var(--cn),#174B8F);color:#fff;box-shadow:0 4px 12px rgba(0,43,103,.22);}
@media(max-width:767px){.cf-tb span{display:none;}.cf-tb{padding:7px 10px;}}

/* ── Tab panels ──────────────────────────────── */
.cf-panel{display:none;}
.cf-panel.on{display:block;}

/* ── Cards ───────────────────────────────────── */
.cf-card{
  background:#fff;border:1px solid var(--cb);border-radius:13px;
  margin-bottom:16px;box-shadow:0 3px 12px rgba(20,35,60,.05);overflow:hidden;
}
.cf-card:last-of-type{margin-bottom:0;}
.cf-ch{
  display:flex;align-items:center;justify-content:space-between;
  gap:10px;padding:12px 16px;border-bottom:1px solid var(--cb);background:#fcfdfe;
}
.cf-ch-left{display:flex;align-items:center;gap:10px;}
.cf-ci{
  width:34px;height:34px;flex:0 0 34px;display:inline-flex;
  align-items:center;justify-content:center;border-radius:9px;
  color:#174B8F;background:#eaf2fb;border:1px solid #d7e5f4;font-size:.9rem;
}
.cf-ct{margin:0;font-size:.79rem;font-weight:800;color:var(--ct);}
.cf-cs{display:block;font-size:.59rem;color:var(--cm);margin-top:1px;}
.cf-cb{padding:16px;}

/* ── Grids ───────────────────────────────────── */
.cg2{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
.cg3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;}
.cg4{display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:12px;}
@media(max-width:991px){.cg3,.cg4{grid-template-columns:1fr 1fr;}}
@media(max-width:575px){.cg2,.cg3,.cg4{grid-template-columns:1fr;}}

/* ── Fields ──────────────────────────────────── */
.cf-f{margin-bottom:12px;}
.cf-f:last-child{margin-bottom:0;}
.cf-l{display:flex;align-items:center;gap:4px;margin-bottom:4px;font-size:.65rem;font-weight:800;color:var(--ct);}
.req{color:#c0392b;}
.cf-hint{display:block;margin-top:3px;font-size:.58rem;color:var(--cm);}

/* ── Controls ────────────────────────────────── */
.cf-ctrl{
  width:100%;min-height:37px;padding:7px 11px;
  border:1.5px solid #d8e0ea!important;border-radius:8px!important;
  background:#fff!important;color:var(--ct)!important;
  font-size:.68rem!important;font-weight:600;
  box-shadow:none!important;transition:border-color .18s,box-shadow .18s;
}
.cf-ctrl:focus{border-color:#174B8F!important;box-shadow:0 0 0 3px rgba(23,75,143,.08)!important;outline:none!important;}
textarea.cf-ctrl{min-height:80px;resize:vertical;}
.cf-upload{padding:6px 9px;}
.cf-upload::file-selector-button{
  margin:-6px 9px -6px -9px;padding:6px 9px;
  border:0;border-right:1.5px solid #d8e0ea;
  background:#f3f6fa;color:#174B8F;font-size:.62rem;font-weight:800;
}

/* ── Icon field ───────────────────────────────── */
.cf-icon-row{display:flex;align-items:center;gap:6px;}
.cf-icon-row .cf-ctrl{flex:1;}
.cf-icon-btn{
  flex-shrink:0;height:37px;padding:0 10px;
  border:1.5px solid #d8e0ea;border-radius:8px;
  background:#f3f6fa;color:#174B8F;cursor:pointer;
  font-size:.65rem;font-weight:700;white-space:nowrap;
  transition:all .18s;
}
.cf-icon-btn:hover{background:var(--cn);border-color:var(--cn);color:#fff;}
.cf-icon-preview{font-size:1.3rem;color:var(--cn);display:block;margin-top:4px;}

/* ── Section divider ─────────────────────────── */
.cf-divider{
  display:flex;align-items:center;gap:8px;
  margin:16px 0 12px;
  font-size:.61rem;font-weight:800;color:var(--cm);
  text-transform:uppercase;letter-spacing:.08em;
}
.cf-divider::before,.cf-divider::after{content:"";flex:1;height:1px;background:var(--cb);}

/* ── Add row button ──────────────────────────── */
.cf-add-btn{
  min-height:31px;padding:0 11px;
  border:1px solid #b6e0ca;border-radius:8px;
  background:#f0fbf6;color:var(--cg2);
  display:inline-flex;align-items:center;gap:5px;
  font-size:.63rem;font-weight:800;white-space:nowrap;
  cursor:pointer;transition:all .18s;
}
.cf-add-btn:hover{background:var(--cg);border-color:var(--cg);color:#fff;}

/* ── Repeater rows ───────────────────────────── */
.cf-rlist{display:flex;flex-direction:column;gap:10px;}
.cf-row,.cf-crow{
  position:relative;padding:14px;
  border:1.5px solid #dfe6ee;border-radius:11px;
  background:#fafbfd;
}
.cf-rm{
  position:absolute;right:9px;top:9px;
  width:28px;height:28px;padding:0;
  border:1px solid #f0c9c5;border-radius:7px;
  background:#fff8f7;color:#c0392b;
  display:inline-flex;align-items:center;justify-content:center;
  cursor:pointer;transition:all .18s;z-index:2;
}
.cf-rm:hover{background:#c0392b;color:#fff;border-color:#c0392b;}
.cf-rn{font-size:.6rem;font-weight:800;color:var(--cm);margin-bottom:10px;padding-right:32px;}

/* ── Checkboxes ──────────────────────────────── */
.cf-ck .form-check-input{box-shadow:none!important;border-color:#bfc9d7;}
.cf-ck .form-check-input:checked{background-color:var(--cg);border-color:var(--cg);}
.cf-ck .form-check-label{font-size:.65rem;font-weight:650;color:#526176;}

/* ── Media preview ───────────────────────────── */
.cf-mprev{margin-top:7px;}
.cf-mprev img{max-width:100%;height:56px;object-fit:contain;border:1px solid var(--cb);border-radius:8px;background:#fff;}
.cf-mprev.banner img{width:100%;height:60px;object-fit:cover;}
.cf-mprev-lbl{display:block;margin-top:3px;font-size:.58rem;color:var(--cm);}

/* ── Sidebar (sticky) ────────────────────────── */
.cf-sidebar{position:sticky;top:76px;}
.cf-sidebar .cf-card{margin-bottom:12px;}
.cf-save-btn{
  width:100%;min-height:42px;
  border:1px solid var(--co);border-radius:9px;
  background:var(--co);color:#1a1000;
  font-size:.72rem;font-weight:850;
  display:flex;align-items:center;justify-content:center;gap:7px;
  cursor:pointer;transition:all .18s;
}
.cf-save-btn:hover{background:var(--co2);border-color:var(--co2);color:#fff;transform:translateY(-1px);}
.cf-sidebar-back{
  width:100%;min-height:38px;margin-top:8px;
  border:1.5px solid var(--cb);border-radius:9px;
  background:#fff;color:var(--cm);
  font-size:.7rem;font-weight:750;text-decoration:none;
  display:flex;align-items:center;justify-content:center;gap:7px;
  transition:all .18s;
}
.cf-sidebar-back:hover{background:var(--cs);color:var(--cn);border-color:#c0cdd8;}
.cf-note{
  display:flex;gap:7px;margin-top:10px;padding:9px;
  border-radius:8px;background:#f2fbf7;
  border:1px solid #d5eee3;color:#3d6451;font-size:.59rem;line-height:1.5;
}
.cf-note i{color:var(--cg);flex-shrink:0;}

/* ── Prev/Next nav bar ───────────────────────── */
.cf-tnb{
  display:flex;align-items:center;justify-content:space-between;
  gap:10px;margin-top:22px;padding:14px 18px;
  background:#fff;border:1px solid var(--cb);
  border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,.04);
}
.cf-btn-prev,.cf-btn-next{
  display:inline-flex;align-items:center;gap:7px;
  padding:9px 20px;border-radius:9px;border:none;
  font-size:.76rem;font-weight:700;cursor:pointer;transition:all .18s;
}
.cf-btn-prev{background:var(--cs);color:var(--cm);border:1.5px solid var(--cb);}
.cf-btn-prev:hover:not(:disabled){background:#e8edf3;color:var(--cn);}
.cf-btn-prev:disabled{opacity:.35;cursor:not-allowed;}
.cf-btn-next{background:var(--cn);color:#fff;}
.cf-btn-next:hover:not(:disabled){background:var(--cn2);}
.cf-btn-next:disabled{opacity:.35;cursor:not-allowed;}
.cf-btn-save{background:var(--cg2)!important;}
.cf-btn-save:hover{background:var(--cg)!important;}
.cf-tstep{
  font-size:.7rem;font-weight:700;color:var(--cm);
  background:var(--cs);padding:5px 12px;
  border-radius:999px;border:1px solid var(--cb);
}

@media(max-width:575px){
  .cf-btn-prev,.cf-btn-next{padding:8px 14px;font-size:.72rem;}
}
</style>
@endpush

<div class="cf-page">

{{-- ══ HERO ══════════════════════════════════════════════════════ --}}
<div class="cf-hero">
  <div class="cf-hero-inner">
    <div>
      <span class="cf-eyebrow"><i class="bi bi-building-add"></i> College Management</span>
      <h2>{{ isset($college) ? 'Edit College' : 'Add New College' }}</h2>
      <p>{{ isset($college) ? 'Update all sections below. All tabs save together.' : 'Fill each tab. Everything saves in one click.' }}</p>
      @if(isset($college))
        <div class="cf-edit-pill"><i class="bi bi-pencil-fill"></i> {{ $college->name }}</div>
      @endif
    </div>
    <a href="{{ route('admin.colleges.index') }}" class="cf-back-btn">
      <i class="bi bi-arrow-left"></i> Back to List
    </a>
  </div>
</div>

{{-- ══ TAB STRIP ══════════════════════════════════════════════════ --}}
@php
$tabs = [
  ['basic',      'bi-info-circle',      'Basic Info'],
  ['media',      'bi-images',           'Media'],
  ['courses',    'bi-mortarboard-fill', 'Courses'],
  ['accrdn',     'bi-shield-check',     'Accreditations'],
  ['admission',  'bi-card-checklist',   'Admission'],
  ['placements', 'bi-briefcase-fill',   'Placements'],
  ['campus',     'bi-buildings-fill',   'Campus'],
  ['learning',   'bi-laptop',           'Learning & FAQs'],
  ['gallery',    'bi-camera-fill',      'Gallery & Alumni'],
  ['reviews',    'bi-star-fill',        'Reviews'],
];
@endphp
<div class="cf-tabstrip" role="tablist">
  @foreach($tabs as $i => [$tid,$tico,$tlbl])
    <button type="button" class="cf-tb {{ $i===0?'on':'' }}" data-tab="{{ $tid }}"
            role="tab" aria-selected="{{ $i===0?'true':'false' }}">
      <i class="bi {{ $tico }}"></i><span> {{ $tlbl }}</span>
    </button>
  @endforeach
</div>

{{-- ══ MAIN LAYOUT ════════════════════════════════════════════════ --}}
<div class="row g-4 align-items-start">
<div class="col-lg-9">

{{-- ╔══════════════════════════════════════════════
     TAB 1 — BASIC INFO
══════════════════════════════════════════════╗ --}}
<div class="cf-panel on" id="tab-basic">

  {{-- Core Identity --}}
  <div class="cf-card">
    <div class="cf-ch">
      <div class="cf-ch-left">
        <span class="cf-ci"><i class="bi bi-building-fill"></i></span>
        <div><p class="cf-ct">Core Identity</p><small class="cf-cs">Name, mode, type, affiliation, website, overview</small></div>
      </div>
    </div>
    <div class="cf-cb">
      <div class="cg2">
        <div class="cf-f">
          <label class="cf-l">College Name <span class="req">*</span></label>
          <input type="text" name="name" class="cf-ctrl" required
                 value="{{ old('name', $college->name ?? '') }}"
                 placeholder="e.g. Amity University Online">
        </div>
        <div class="cf-f">
          <label class="cf-l">Short Name / Abbreviation</label>
          <input type="text" name="short_name" class="cf-ctrl"
                 value="{{ old('short_name', $college->short_name ?? '') }}"
                 placeholder="e.g. AMU, LPU, NMIMS">
          <small class="cf-hint">Shown in brackets below the title on public page</small>
        </div>
      </div>
      <div class="cg2">
        <div class="cf-f">
          <label class="cf-l">College Mode <span class="req">*</span></label>
          <select name="college_mode" class="cf-ctrl" required>
            <option value="regular" {{ old('college_mode', $college->college_mode ?? 'regular') === 'regular' ? 'selected' : '' }}>Regular Campus</option>
            <option value="online"  {{ old('college_mode', $college->college_mode ?? '') === 'online' ? 'selected' : '' }}>100% Online / Distance</option>
          </select>
        </div>
        <div class="cf-f">
          <label class="cf-l">Ownership / Type <span class="req">*</span></label>
          <select name="college_type" class="cf-ctrl" required>
            @foreach(['Private' => 'Private University', 'Govt' => 'Government University', 'Deemed' => 'Deemed University', 'Autonomous' => 'Autonomous Institute'] as $v => $l)
              <option value="{{ $v }}" {{ old('college_type', $college->college_type ?? 'Private') === $v ? 'selected' : '' }}>{{ $l }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="cg2">
        <div class="cf-f">
          <label class="cf-l">Affiliated / Parent University</label>
          <input type="text" name="university_name" class="cf-ctrl"
                 value="{{ old('university_name', $college->university_name ?? '') }}"
                 placeholder="e.g. UGC Recognized / AKTU Affiliated">
        </div>
        <div class="cf-f">
          <label class="cf-l">Official Website</label>
          <input type="url" name="website" class="cf-ctrl"
                 value="{{ old('website', $college->website ?? '') }}"
                 placeholder="https://www.university.edu.in">
        </div>
      </div>
      <div class="cf-f">
        <label class="cf-l">About / Overview</label>
        <textarea name="overview" rows="4" class="cf-ctrl"
                  placeholder="University background, vision, faculty strength, key achievements...">{{ old('overview', $college->overview ?? '') }}</textarea>
      </div>
    </div>
  </div>

  {{-- Location & Campus --}}
  <div class="cf-card">
    <div class="cf-ch">
      <div class="cf-ch-left">
        <span class="cf-ci"><i class="bi bi-geo-alt-fill"></i></span>
        <div><p class="cf-ct">Location &amp; Campus</p><small class="cf-cs">State, city, address, established year, campus size</small></div>
      </div>
    </div>
    <div class="cf-cb">
      <div class="cg2">
        <div class="cf-f">
          <label class="cf-l">State <span class="req">*</span></label>
          <select name="state" id="cfStateSelect" class="cf-ctrl" required>
            <option value="">Select State</option>
            @foreach($states as $st)
              <option value="{{ $st->name }}" data-id="{{ $st->id }}"
                {{ old('state', $college->state ?? '') === $st->name ? 'selected' : '' }}>
                {{ $st->name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="cf-f">
          <label class="cf-l">City <span class="req">*</span></label>
          <select name="city" id="cfCitySelect" class="cf-ctrl" required
                  data-cur="{{ old('city', $college->city ?? '') }}">
            @if(old('city', $college->city ?? ''))
              <option value="{{ old('city', $college->city ?? '') }}" selected>{{ old('city', $college->city ?? '') }}</option>
            @else
              <option value="">Choose State First</option>
            @endif
          </select>
        </div>
      </div>
      <div class="cf-f">
        <label class="cf-l">Full Address</label>
        <textarea name="address" rows="2" class="cf-ctrl"
                  placeholder="Street, area, landmark, pin code...">{{ old('address', $college->address ?? '') }}</textarea>
      </div>
      <div class="cg3">
        <div class="cf-f">
          <label class="cf-l">Established Year</label>
          <input type="text" name="established_year" class="cf-ctrl"
                 value="{{ old('established_year', $college->established_year ?? '') }}"
                 placeholder="2004">
        </div>
        <div class="cf-f">
          <label class="cf-l">Campus Size</label>
          <input type="text" name="campus_size" class="cf-ctrl"
                 value="{{ old('campus_size', $college->campus_size ?? '') }}"
                 placeholder="120 Acres">
        </div>
        <div class="cf-f">
          <label class="cf-l">Entrance Exams Accepted</label>
          <input type="text" name="entrance_exams" class="cf-ctrl"
                 value="{{ old('entrance_exams', $college->entrance_exams ?? '') }}"
                 placeholder="CAT, JEE Main, CUET">
        </div>
      </div>
      <div class="cg2">
        <div class="cf-ck">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="has_boys_hostel" value="1" id="cbBoys"
                   {{ old('has_boys_hostel', $college->has_boys_hostel ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="cbBoys">Boys Hostel Available</label>
          </div>
        </div>
        <div class="cf-ck">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="has_girls_hostel" value="1" id="cbGirls"
                   {{ old('has_girls_hostel', $college->has_girls_hostel ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="cbGirls">Girls Hostel Available</label>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Rankings & Ratings --}}
  <div class="cf-card">
    <div class="cf-ch">
      <div class="cf-ch-left">
        <span class="cf-ci"><i class="bi bi-award-fill"></i></span>
        <div><p class="cf-ct">Rankings &amp; Ratings</p><small class="cf-cs">NAAC, NIRF, UGC approval, star rating</small></div>
      </div>
    </div>
    <div class="cf-cb">
      <div class="cg3">
        <div class="cf-f">
          <label class="cf-l">NAAC Grade</label>
          <input type="text" name="naac_grade" class="cf-ctrl"
                 value="{{ old('naac_grade', $college->naac_grade ?? '') }}"
                 placeholder="A++, A+, A, B++">
        </div>
        <div class="cf-f">
          <label class="cf-l">NIRF Rank</label>
          <input type="text" name="nirf_rank" class="cf-ctrl"
                 value="{{ old('nirf_rank', $college->nirf_rank ?? '') }}"
                 placeholder="37">
        </div>
        <div class="cf-f">
          <label class="cf-l">NIRF Year</label>
          <input type="text" name="nirf_year" class="cf-ctrl"
                 value="{{ old('nirf_year', $college->nirf_year ?? '') }}"
                 placeholder="2024">
        </div>
      </div>
      <div class="cg4">
        <div class="cf-f">
          <label class="cf-l">Approvals Badge Text</label>
          <input type="text" name="approvals" class="cf-ctrl"
                 value="{{ old('approvals', $college->approvals ?? '') }}"
                 placeholder="UGC | AICTE | NAAC A+">
        </div>
        <div class="cf-f">
          <label class="cf-l">Rating (1–5)</label>
          <input type="number" name="rating" step="0.1" min="1" max="5" class="cf-ctrl"
                 value="{{ old('rating', $college->rating ?? '4.5') }}">
        </div>
        <div class="cf-f">
          <label class="cf-l">Total Reviews Count</label>
          <input type="number" name="reviews_count" min="0" class="cf-ctrl"
                 value="{{ old('reviews_count', $college->reviews_count ?? '150') }}">
        </div>
        <div class="cf-f" style="padding-top:20px;">
          <div class="form-check cf-ck">
            <input class="form-check-input" type="checkbox" name="ugc_approved" value="1" id="cbUgc"
                   {{ old('ugc_approved', $college->ugc_approved ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="cbUgc">UGC Approved</label>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- SEO --}}
  <div class="cf-card">
    <div class="cf-ch">
      <div class="cf-ch-left">
        <span class="cf-ci"><i class="bi bi-search"></i></span>
        <div><p class="cf-ct">SEO Settings</p><small class="cf-cs">Custom title &amp; meta description for search engines</small></div>
      </div>
    </div>
    <div class="cf-cb">
      <div class="cf-f">
        <label class="cf-l">SEO Title</label>
        <input type="text" name="seo_title" class="cf-ctrl"
               value="{{ old('seo_title', $college->seo_title ?? '') }}"
               placeholder="Leave blank to auto-generate from college name">
      </div>
      <div class="cf-f">
        <label class="cf-l">SEO Meta Description <small class="cf-hint d-inline">(max 160 chars)</small></label>
        <textarea name="seo_description" rows="2" class="cf-ctrl"
                  placeholder="Brief description shown in Google search results...">{{ old('seo_description', $college->seo_description ?? '') }}</textarea>
      </div>
    </div>
  </div>

</div>{{-- /tab-basic --}}

{{-- ╔══════════════════════════════════════════════
     TAB 2 — MEDIA
══════════════════════════════════════════════╗ --}}
<div class="cf-panel" id="tab-media">
  <div class="cf-card">
    <div class="cf-ch">
      <div class="cf-ch-left">
        <span class="cf-ci"><i class="bi bi-images"></i></span>
        <div><p class="cf-ct">Images &amp; Documents</p><small class="cf-cs">Banner, logo, sample certificate, brochure PDF</small></div>
      </div>
    </div>
    <div class="cf-cb">
      <div class="cg2">
        <div class="cf-f">
          <label class="cf-l">Banner / Hero Image</label>
          <input type="file" name="banner_image" class="cf-ctrl cf-upload" accept="image/*">
          @if(isset($college) && $college->banner_image)
            <div class="cf-mprev banner"><img src="{{ $college->banner_url }}" alt="Banner"><small class="cf-mprev-lbl">Current Banner</small></div>
          @endif
          <small class="cf-hint">Recommended: 1200×400px · Max 4MB · JPG/PNG/WebP</small>
        </div>
        <div class="cf-f">
          <label class="cf-l">College Logo</label>
          <input type="file" name="logo" class="cf-ctrl cf-upload" accept="image/*">
          @if(isset($college) && $college->logo)
            <div class="cf-mprev"><img src="{{ $college->logo_url }}" alt="Logo"><small class="cf-mprev-lbl">Current Logo</small></div>
          @endif
          <small class="cf-hint">Recommended: Square · Max 2MB · JPG/PNG/SVG</small>
        </div>
        <div class="cf-f">
          <label class="cf-l">Sample Degree / Certificate</label>
          <input type="file" name="sample_certificate_image" class="cf-ctrl cf-upload" accept="image/*">
          @if(isset($college) && $college->certificate_url)
            <div class="cf-mprev"><img src="{{ $college->certificate_url }}" alt="Certificate"><small class="cf-mprev-lbl">Current Certificate</small></div>
          @endif
        </div>
        <div class="cf-f">
          <label class="cf-l">Brochure PDF</label>
          <input type="file" name="brochure_pdf" class="cf-ctrl cf-upload" accept=".pdf">
          @if(isset($college) && $college->brochure_pdf)
            <div class="mt-2">
              <a href="{{ asset('storage/'.$college->brochure_pdf) }}" target="_blank"
                 class="btn btn-sm btn-outline-danger py-1">
                <i class="bi bi-file-earmark-pdf me-1"></i> View Current PDF
              </a>
            </div>
          @endif
          <small class="cf-hint">Max 10MB</small>
        </div>
      </div>
    </div>
  </div>
</div>{{-- /tab-media --}}

{{-- ╔══════════════════════════════════════════════
     TAB 3 — COURSES
══════════════════════════════════════════════╗ --}}
<div class="cf-panel" id="tab-courses">
  <div class="cf-card">
    <div class="cf-ch">
      <div class="cf-ch-left">
        <span class="cf-ci"><i class="bi bi-mortarboard-fill"></i></span>
        <div><p class="cf-ct">Courses, Fees &amp; Specializations</p><small class="cf-cs">Stream → Course → Specialization with fees, seats &amp; eligibility</small></div>
      </div>
      <button type="button" class="cf-add-btn" id="cfAddCourse">
        <i class="bi bi-plus-circle-fill"></i><span> Add Course Row</span>
      </button>
    </div>
    <div class="cf-cb">
      <div id="cfCoursesWrap" style="display:flex;flex-direction:column;gap:12px;">
        @php $existingCourses = isset($college) ? $college->collegeCourses : collect(); @endphp
        @forelse($existingCourses as $ci => $cc)
          @include('admin.colleges._course_row', ['ci' => $ci, 'cc' => $cc])
        @empty
          @include('admin.colleges._course_row', ['ci' => 0, 'cc' => null])
        @endforelse
      </div>
    </div>
  </div>
</div>{{-- /tab-courses --}}

{{-- ╔══════════════════════════════════════════════
     TAB 4 — ACCREDITATIONS
══════════════════════════════════════════════╗ --}}
<div class="cf-panel" id="tab-accrdn">

  @php
    $accrRows = isset($college) ? $college->accreditations : collect();
    $hlRows   = isset($college) ? $college->collegeHighlights : collect();
  @endphp

  {{-- Accreditations --}}
  <div class="cf-card">
    <div class="cf-ch">
      <div class="cf-ch-left">
        <span class="cf-ci"><i class="bi bi-shield-check"></i></span>
        <div><p class="cf-ct">Accreditations, Approvals &amp; Rankings</p><small class="cf-cs">UGC, NAAC, AICTE, NIRF, WES, QS etc.</small></div>
      </div>
      <button type="button" class="cf-add-btn" data-add-list="accreditations">
        <i class="bi bi-plus-circle-fill"></i><span> Add Row</span>
      </button>
    </div>
    <div class="cf-cb">
      <div class="cf-rlist" data-list="accreditations">
        @forelse($accrRows as $ri => $r)
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #{{ $ri+1 }}</div>
          <div class="cg3">
            <div class="cf-f"><label class="cf-l">Authority <span class="req">*</span></label>
              <input class="cf-ctrl" name="accreditations[{{ $ri }}][authority]" value="{{ $r->authority }}" placeholder="UGC / NAAC / NIRF"></div>
            <div class="cf-f"><label class="cf-l">Accreditation / Status</label>
              <input class="cf-ctrl" name="accreditations[{{ $ri }}][accreditation]" value="{{ $r->accreditation }}" placeholder="Recognized University..."></div>
            <div class="cf-f"><label class="cf-l">Grade</label>
              <input class="cf-ctrl" name="accreditations[{{ $ri }}][grade]" value="{{ $r->grade }}" placeholder="A++, A+, A..."></div>
            <div class="cf-f"><label class="cf-l">Rank</label>
              <input class="cf-ctrl" name="accreditations[{{ $ri }}][rank]" value="{{ $r->rank }}" placeholder="37"></div>
            <div class="cf-f"><label class="cf-l">Year</label>
              <input class="cf-ctrl" name="accreditations[{{ $ri }}][year]" value="{{ $r->year }}" placeholder="2024"></div>
            <div class="cf-f"><label class="cf-l">Sort Order</label>
              <input type="number" class="cf-ctrl" name="accreditations[{{ $ri }}][sort_order]" value="{{ $r->sort_order ?? $ri }}"></div>
          </div>
          <div class="cf-f mt-2"><label class="cf-l">Description</label>
            <textarea rows="2" class="cf-ctrl" name="accreditations[{{ $ri }}][description]">{{ $r->description }}</textarea></div>
          <div class="form-check cf-ck mt-2">
            <input class="form-check-input" type="checkbox" name="accreditations[{{ $ri }}][status]" value="1" {{ $r->status ? 'checked' : '' }}>
            <label class="form-check-label"> Active</label>
          </div>
        </div>
        @empty
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #1</div>
          <div class="cg3">
            <div class="cf-f"><label class="cf-l">Authority <span class="req">*</span></label><input class="cf-ctrl" name="accreditations[0][authority]" placeholder="UGC / NAAC / NIRF"></div>
            <div class="cf-f"><label class="cf-l">Accreditation / Status</label><input class="cf-ctrl" name="accreditations[0][accreditation]" placeholder="Recognized University..."></div>
            <div class="cf-f"><label class="cf-l">Grade</label><input class="cf-ctrl" name="accreditations[0][grade]" placeholder="A++, A+, A..."></div>
            <div class="cf-f"><label class="cf-l">Rank</label><input class="cf-ctrl" name="accreditations[0][rank]" placeholder="37"></div>
            <div class="cf-f"><label class="cf-l">Year</label><input class="cf-ctrl" name="accreditations[0][year]" placeholder="2024"></div>
            <div class="cf-f"><label class="cf-l">Sort Order</label><input type="number" class="cf-ctrl" name="accreditations[0][sort_order]" value="0"></div>
          </div>
          <div class="cf-f mt-2"><label class="cf-l">Description</label><textarea rows="2" class="cf-ctrl" name="accreditations[0][description]"></textarea></div>
          <div class="form-check cf-ck mt-2">
            <input class="form-check-input" type="checkbox" name="accreditations[0][status]" value="1" checked>
            <label class="form-check-label"> Active</label>
          </div>
        </div>
        @endforelse
      </div>
    </div>
  </div>

  {{-- Key Highlights --}}
  <div class="cf-card">
    <div class="cf-ch">
      <div class="cf-ch-left">
        <span class="cf-ci"><i class="bi bi-stars"></i></span>
        <div><p class="cf-ct">Key Highlights &amp; USPs</p><small class="cf-cs">Strongest reasons students should choose this college</small></div>
      </div>
      <button type="button" class="cf-add-btn" data-add-list="highlights">
        <i class="bi bi-plus-circle-fill"></i><span> Add Row</span>
      </button>
    </div>
    <div class="cf-cb">
      <div class="cf-rlist" data-list="highlights">
        @forelse($hlRows as $ri => $r)
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #{{ $ri+1 }}</div>
          <div class="cg3">
            <div class="cf-f"><label class="cf-l">Title <span class="req">*</span></label>
              <input class="cf-ctrl" name="highlights[{{ $ri }}][title]" value="{{ $r->title }}" placeholder="NAAC A+ Accredited"></div>
            <div class="cf-f"><label class="cf-l">Value / Sub-text</label>
              <input class="cf-ctrl" name="highlights[{{ $ri }}][value]" value="{{ $r->value }}" placeholder="2024 Batch"></div>
            <div class="cf-f"><label class="cf-l">Icon <span class="req">*</span></label>
              <div class="cf-icon-row">
                <input class="cf-ctrl" name="highlights[{{ $ri }}][icon]" value="{{ $r->icon ?? 'bi-check-circle-fill' }}" placeholder="bi-check-circle-fill">
                <button type="button" class="cf-icon-btn"><i class="bi bi-grid"></i> Pick</button>
              </div>
              <i class="bi {{ $r->icon ?? 'bi-check-circle-fill' }} cf-icon-preview"></i>
            </div>
          </div>
          <div class="cf-f mt-2"><label class="cf-l">Description</label>
            <textarea rows="2" class="cf-ctrl" name="highlights[{{ $ri }}][description]">{{ $r->description }}</textarea></div>
          <div class="form-check cf-ck mt-2">
            <input class="form-check-input" type="checkbox" name="highlights[{{ $ri }}][status]" value="1" {{ $r->status ? 'checked' : '' }}>
            <label class="form-check-label"> Active</label>
          </div>
        </div>
        @empty
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #1</div>
          <div class="cg3">
            <div class="cf-f"><label class="cf-l">Title <span class="req">*</span></label><input class="cf-ctrl" name="highlights[0][title]" placeholder="NAAC A+ Accredited"></div>
            <div class="cf-f"><label class="cf-l">Value / Sub-text</label><input class="cf-ctrl" name="highlights[0][value]" placeholder="2024 Batch"></div>
            <div class="cf-f"><label class="cf-l">Icon <span class="req">*</span></label>
              <div class="cf-icon-row">
                <input class="cf-ctrl" name="highlights[0][icon]" value="bi-check-circle-fill" placeholder="bi-check-circle-fill">
                <button type="button" class="cf-icon-btn"><i class="bi bi-grid"></i> Pick</button>
              </div>
              <i class="bi bi-check-circle-fill cf-icon-preview"></i>
            </div>
          </div>
          <div class="cf-f mt-2"><label class="cf-l">Description</label><textarea rows="2" class="cf-ctrl" name="highlights[0][description]"></textarea></div>
          <div class="form-check cf-ck mt-2">
            <input class="form-check-input" type="checkbox" name="highlights[0][status]" value="1" checked>
            <label class="form-check-label"> Active</label>
          </div>
        </div>
        @endforelse
      </div>
    </div>
  </div>

</div>{{-- /tab-accrdn --}}

{{-- ╔══════════════════════════════════════════════
     TAB 5 — ADMISSION
══════════════════════════════════════════════╗ --}}
<div class="cf-panel" id="tab-admission">

  @php
    $admRows = isset($college) ? $college->admissionSections : collect();
    $schRows = isset($college) ? $college->scholarships : collect();
  @endphp

  <div class="cf-card">
    <div class="cf-ch">
      <div class="cf-ch-left">
        <span class="cf-ci"><i class="bi bi-card-checklist"></i></span>
        <div><p class="cf-ct">Admission Process</p><small class="cf-cs">Eligibility, How to Apply, Documents etc.</small></div>
      </div>
      <button type="button" class="cf-add-btn" data-add-list="admission_sections">
        <i class="bi bi-plus-circle-fill"></i><span> Add Section</span>
      </button>
    </div>
    <div class="cf-cb">
      <div class="cf-f">
        <label class="cf-l">Admission Process (plain text fallback)</label>
        <textarea name="admission_process" rows="3" class="cf-ctrl"
                  placeholder="Used only if no structured sections added below...">{{ old('admission_process', $college->admission_process ?? '') }}</textarea>
      </div>
      <div class="cf-divider">Structured Admission Sections</div>
      <div class="cf-rlist" data-list="admission_sections">
        @forelse($admRows as $ri => $r)
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #{{ $ri+1 }}</div>
          <div class="cg3">
            <div class="cf-f"><label class="cf-l">Section Key</label>
              <input class="cf-ctrl" name="admission_sections[{{ $ri }}][section_key]" value="{{ $r->section_key }}" placeholder="eligibility / how_to_apply / documents"></div>
            <div class="cf-f"><label class="cf-l">Title <span class="req">*</span></label>
              <input class="cf-ctrl" name="admission_sections[{{ $ri }}][title]" value="{{ $r->title }}" placeholder="Eligibility Criteria"></div>
            <div class="cf-f"><label class="cf-l">Sort Order</label>
              <input type="number" class="cf-ctrl" name="admission_sections[{{ $ri }}][sort_order]" value="{{ $r->sort_order ?? $ri }}"></div>
          </div>
          <div class="cf-f mt-2"><label class="cf-l">Content</label>
            <textarea rows="3" class="cf-ctrl" name="admission_sections[{{ $ri }}][content]">{{ $r->content }}</textarea></div>
          <div class="cf-f mt-2">
            <label class="cf-l">Items <small class="cf-hint d-inline">(one item per line)</small></label>
            <textarea rows="5" class="cf-ctrl" name="admission_sections[{{ $ri }}][items]">{{ is_array($r->items) ? implode("\n", $r->items) : ($r->items ?? '') }}</textarea>
          </div>
          <div class="form-check cf-ck mt-2">
            <input class="form-check-input" type="checkbox" name="admission_sections[{{ $ri }}][status]" value="1" {{ $r->status ? 'checked' : '' }}>
            <label class="form-check-label"> Active</label>
          </div>
        </div>
        @empty
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #1</div>
          <div class="cg3">
            <div class="cf-f"><label class="cf-l">Section Key</label><input class="cf-ctrl" name="admission_sections[0][section_key]" placeholder="eligibility"></div>
            <div class="cf-f"><label class="cf-l">Title <span class="req">*</span></label><input class="cf-ctrl" name="admission_sections[0][title]" placeholder="Eligibility Criteria"></div>
            <div class="cf-f"><label class="cf-l">Sort Order</label><input type="number" class="cf-ctrl" name="admission_sections[0][sort_order]" value="0"></div>
          </div>
          <div class="cf-f mt-2"><label class="cf-l">Content</label><textarea rows="3" class="cf-ctrl" name="admission_sections[0][content]"></textarea></div>
          <div class="cf-f mt-2"><label class="cf-l">Items (one per line)</label><textarea rows="5" class="cf-ctrl" name="admission_sections[0][items]"></textarea></div>
          <div class="form-check cf-ck mt-2">
            <input class="form-check-input" type="checkbox" name="admission_sections[0][status]" value="1" checked>
            <label class="form-check-label"> Active</label>
          </div>
        </div>
        @endforelse
      </div>
    </div>
  </div>

  {{-- Scholarships --}}
  <div class="cf-card">
    <div class="cf-ch">
      <div class="cf-ch-left">
        <span class="cf-ci"><i class="bi bi-award-fill"></i></span>
        <div><p class="cf-ct">Scholarships &amp; Financial Support</p><small class="cf-cs">Merit, sports, EWS, loan tie-ups</small></div>
      </div>
      <button type="button" class="cf-add-btn" data-add-list="scholarships">
        <i class="bi bi-plus-circle-fill"></i><span> Add Row</span>
      </button>
    </div>
    <div class="cf-cb">
      <div class="cf-f">
        <label class="cf-l">Scholarship Info (plain text fallback)</label>
        <textarea name="scholarship_info" rows="2" class="cf-ctrl"
                  placeholder="Used only if no structured scholarships below...">{{ old('scholarship_info', $college->scholarship_info ?? '') }}</textarea>
      </div>
      <div class="cf-divider">Structured Scholarships</div>
      <div class="cf-rlist" data-list="scholarships">
        @forelse($schRows as $ri => $r)
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #{{ $ri+1 }}</div>
          <div class="cg3">
            <div class="cf-f"><label class="cf-l">Name <span class="req">*</span></label><input class="cf-ctrl" name="scholarships[{{ $ri }}][name]" value="{{ $r->name }}" placeholder="Merit Scholarship"></div>
            <div class="cf-f"><label class="cf-l">Eligibility</label><input class="cf-ctrl" name="scholarships[{{ $ri }}][eligibility]" value="{{ $r->eligibility }}" placeholder="90%+ in qualifying exam"></div>
            <div class="cf-f"><label class="cf-l">Criteria</label><input class="cf-ctrl" name="scholarships[{{ $ri }}][criteria]" value="{{ $r->criteria }}" placeholder="Academic Merit"></div>
            <div class="cf-f"><label class="cf-l">Amount (₹)</label><input type="number" class="cf-ctrl" name="scholarships[{{ $ri }}][amount]" value="{{ $r->amount }}" placeholder="150000"></div>
            <div class="cf-f"><label class="cf-l">Amount Label</label><input class="cf-ctrl" name="scholarships[{{ $ri }}][amount_label]" value="{{ $r->amount_label }}" placeholder="Up to 30% Fee Waiver"></div>
            <div class="cf-f"><label class="cf-l">Percentage</label><input class="cf-ctrl" name="scholarships[{{ $ri }}][percentage]" value="{{ $r->percentage }}" placeholder="30%"></div>
          </div>
          <div class="cf-f mt-2"><label class="cf-l">Description</label><textarea rows="2" class="cf-ctrl" name="scholarships[{{ $ri }}][description]">{{ $r->description }}</textarea></div>
          <div class="form-check cf-ck mt-2"><input class="form-check-input" type="checkbox" name="scholarships[{{ $ri }}][status]" value="1" {{ $r->status ? 'checked' : '' }}><label class="form-check-label"> Active</label></div>
        </div>
        @empty
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #1</div>
          <div class="cg3">
            <div class="cf-f"><label class="cf-l">Name <span class="req">*</span></label><input class="cf-ctrl" name="scholarships[0][name]" placeholder="Merit Scholarship"></div>
            <div class="cf-f"><label class="cf-l">Eligibility</label><input class="cf-ctrl" name="scholarships[0][eligibility]" placeholder="90%+ in qualifying exam"></div>
            <div class="cf-f"><label class="cf-l">Criteria</label><input class="cf-ctrl" name="scholarships[0][criteria]" placeholder="Academic Merit"></div>
            <div class="cf-f"><label class="cf-l">Amount (₹)</label><input type="number" class="cf-ctrl" name="scholarships[0][amount]" placeholder="150000"></div>
            <div class="cf-f"><label class="cf-l">Amount Label</label><input class="cf-ctrl" name="scholarships[0][amount_label]" placeholder="Up to 30% Fee Waiver"></div>
            <div class="cf-f"><label class="cf-l">Percentage</label><input class="cf-ctrl" name="scholarships[0][percentage]" placeholder="30%"></div>
          </div>
          <div class="cf-f mt-2"><label class="cf-l">Description</label><textarea rows="2" class="cf-ctrl" name="scholarships[0][description]"></textarea></div>
          <div class="form-check cf-ck mt-2"><input class="form-check-input" type="checkbox" name="scholarships[0][status]" value="1" checked><label class="form-check-label"> Active</label></div>
        </div>
        @endforelse
      </div>
    </div>
  </div>

</div>{{-- /tab-admission --}}

{{-- ╔══════════════════════════════════════════════
     TAB 6 — PLACEMENTS
══════════════════════════════════════════════╗ --}}
<div class="cf-panel" id="tab-placements">

  @php
    $psRows = isset($college) ? $college->placementStats : collect();
    $recRows= isset($college) ? $college->recruiters : collect();
    $coRows = isset($college) ? $college->careerOutcomes : collect();
  @endphp

  <div class="cf-card">
    <div class="cf-ch"><div class="cf-ch-left"><span class="cf-ci"><i class="bi bi-graph-up-arrow"></i></span><div><p class="cf-ct">Quick Placement Fields</p><small class="cf-cs">Top-line packages and recruiter text (displayed as fallback)</small></div></div></div>
    <div class="cf-cb">
      <div class="cg3">
        <div class="cf-f"><label class="cf-l">Highest Package</label><input type="text" name="highest_package" class="cf-ctrl" value="{{ old('highest_package', $college->highest_package ?? '') }}" placeholder="52 LPA"></div>
        <div class="cf-f"><label class="cf-l">Average Package</label><input type="text" name="average_package" class="cf-ctrl" value="{{ old('average_package', $college->average_package ?? '') }}" placeholder="7.5 LPA"></div>
        <div class="cf-f"><label class="cf-l">Top Recruiters (text)</label><input type="text" name="top_recruiters" class="cf-ctrl" value="{{ old('top_recruiters', $college->top_recruiters ?? '') }}" placeholder="TCS, Google, Amazon"></div>
      </div>
    </div>
  </div>

  {{-- Placement Stats --}}
  <div class="cf-card">
    <div class="cf-ch"><div class="cf-ch-left"><span class="cf-ci"><i class="bi bi-bar-chart-fill"></i></span><div><p class="cf-ct">Placement Statistics</p><small class="cf-cs">Stat cards shown on college detail page</small></div></div>
      <button type="button" class="cf-add-btn" data-add-list="placement_stats"><i class="bi bi-plus-circle-fill"></i><span> Add Stat</span></button></div>
    <div class="cf-cb">
      <div class="cf-rlist" data-list="placement_stats">
        @forelse($psRows as $ri => $r)
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #{{ $ri+1 }}</div>
          <div class="cg4">
            <div class="cf-f"><label class="cf-l">Label <span class="req">*</span></label><input class="cf-ctrl" name="placement_stats[{{ $ri }}][label]" value="{{ $r->label }}" placeholder="Highest Package"></div>
            <div class="cf-f"><label class="cf-l">Value <span class="req">*</span></label><input class="cf-ctrl" name="placement_stats[{{ $ri }}][value]" value="{{ $r->value }}" placeholder="52 LPA"></div>
            <div class="cf-f"><label class="cf-l">Year</label><input class="cf-ctrl" name="placement_stats[{{ $ri }}][year]" value="{{ $r->year }}" placeholder="2024"></div>
            <div class="cf-f"><label class="cf-l">Course</label><input class="cf-ctrl" name="placement_stats[{{ $ri }}][course]" value="{{ $r->course }}" placeholder="B.Tech CSE"></div>
          </div>
          <div class="form-check cf-ck mt-2"><input class="form-check-input" type="checkbox" name="placement_stats[{{ $ri }}][status]" value="1" {{ $r->status ? 'checked' : '' }}><label class="form-check-label"> Active</label></div>
        </div>
        @empty
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #1</div>
          <div class="cg4">
            <div class="cf-f"><label class="cf-l">Label <span class="req">*</span></label><input class="cf-ctrl" name="placement_stats[0][label]" placeholder="Highest Package"></div>
            <div class="cf-f"><label class="cf-l">Value <span class="req">*</span></label><input class="cf-ctrl" name="placement_stats[0][value]" placeholder="52 LPA"></div>
            <div class="cf-f"><label class="cf-l">Year</label><input class="cf-ctrl" name="placement_stats[0][year]" placeholder="2024"></div>
            <div class="cf-f"><label class="cf-l">Course</label><input class="cf-ctrl" name="placement_stats[0][course]" placeholder="B.Tech CSE"></div>
          </div>
          <div class="form-check cf-ck mt-2"><input class="form-check-input" type="checkbox" name="placement_stats[0][status]" value="1" checked><label class="form-check-label"> Active</label></div>
        </div>
        @endforelse
      </div>
    </div>
  </div>

  {{-- Recruiters --}}
  <div class="cf-card">
    <div class="cf-ch"><div class="cf-ch-left"><span class="cf-ci"><i class="bi bi-building-fill"></i></span><div><p class="cf-ct">Top Recruiters</p><small class="cf-cs">Company name with optional logo</small></div></div>
      <button type="button" class="cf-add-btn" data-add-list="recruiters"><i class="bi bi-plus-circle-fill"></i><span> Add Recruiter</span></button></div>
    <div class="cf-cb">
      <div class="cf-rlist" data-list="recruiters">
        @forelse($recRows as $ri => $r)
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #{{ $ri+1 }}</div>
          <div class="cg3">
            <div class="cf-f"><label class="cf-l">Company Name <span class="req">*</span></label><input class="cf-ctrl" name="recruiters[{{ $ri }}][name]" value="{{ $r->name }}" placeholder="Google / TCS / Amazon"></div>
            <div class="cf-f"><label class="cf-l">Logo (optional)</label>
              <input type="file" class="cf-ctrl cf-upload" name="recruiter_logos[{{ $ri }}]" accept="image/*">
              <input type="hidden" name="recruiters[{{ $ri }}][existing_logo]" value="{{ $r->logo }}">
              @if($r->logo_url)<img src="{{ $r->logo_url }}" style="height:24px;margin-top:5px;border-radius:4px;">@endif
            </div>
            <div class="cf-f"><label class="cf-l">Description</label><input class="cf-ctrl" name="recruiters[{{ $ri }}][description]" value="{{ $r->description }}" placeholder="Optional note"></div>
          </div>
          <div class="form-check cf-ck mt-2"><input class="form-check-input" type="checkbox" name="recruiters[{{ $ri }}][status]" value="1" {{ $r->status ? 'checked' : '' }}><label class="form-check-label"> Active</label></div>
        </div>
        @empty
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #1</div>
          <div class="cg3">
            <div class="cf-f"><label class="cf-l">Company Name <span class="req">*</span></label><input class="cf-ctrl" name="recruiters[0][name]" placeholder="Google / TCS / Amazon"></div>
            <div class="cf-f"><label class="cf-l">Logo (optional)</label><input type="file" class="cf-ctrl cf-upload" name="recruiter_logos[0]" accept="image/*"><input type="hidden" name="recruiters[0][existing_logo]" value=""></div>
            <div class="cf-f"><label class="cf-l">Description</label><input class="cf-ctrl" name="recruiters[0][description]" placeholder="Optional note"></div>
          </div>
          <div class="form-check cf-ck mt-2"><input class="form-check-input" type="checkbox" name="recruiters[0][status]" value="1" checked><label class="form-check-label"> Active</label></div>
        </div>
        @endforelse
      </div>
    </div>
  </div>

  {{-- Career Outcomes --}}
  <div class="cf-card">
    <div class="cf-ch"><div class="cf-ch-left"><span class="cf-ci"><i class="bi bi-person-workspace"></i></span><div><p class="cf-ct">Career Outcomes &amp; Job Roles</p><small class="cf-cs">Roles, industries, salary ranges</small></div></div>
      <button type="button" class="cf-add-btn" data-add-list="career_outcomes"><i class="bi bi-plus-circle-fill"></i><span> Add Row</span></button></div>
    <div class="cf-cb">
      <div class="cf-rlist" data-list="career_outcomes">
        @forelse($coRows as $ri => $r)
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #{{ $ri+1 }}</div>
          <div class="cg3">
            <div class="cf-f"><label class="cf-l">Career Role <span class="req">*</span></label><input class="cf-ctrl" name="career_outcomes[{{ $ri }}][career_role]" value="{{ $r->career_role }}" placeholder="Software Engineer"></div>
            <div class="cf-f"><label class="cf-l">Industry</label><input class="cf-ctrl" name="career_outcomes[{{ $ri }}][industry]" value="{{ $r->industry }}" placeholder="IT / Technology"></div>
            <div class="cf-f"><label class="cf-l">Average Salary</label><input class="cf-ctrl" name="career_outcomes[{{ $ri }}][average_salary]" value="{{ $r->average_salary }}" placeholder="6–12 LPA"></div>
            <div class="cf-f"><label class="cf-l">Salary Range</label><input class="cf-ctrl" name="career_outcomes[{{ $ri }}][salary_range]" value="{{ $r->salary_range }}" placeholder="4–20 LPA"></div>
            <div class="cf-f"><label class="cf-l">Job Scope</label><input class="cf-ctrl" name="career_outcomes[{{ $ri }}][job_scope]" value="{{ $r->job_scope }}" placeholder="Development, Testing..."></div>
          </div>
          <div class="form-check cf-ck mt-2"><input class="form-check-input" type="checkbox" name="career_outcomes[{{ $ri }}][status]" value="1" {{ $r->status ? 'checked' : '' }}><label class="form-check-label"> Active</label></div>
        </div>
        @empty
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #1</div>
          <div class="cg3">
            <div class="cf-f"><label class="cf-l">Career Role <span class="req">*</span></label><input class="cf-ctrl" name="career_outcomes[0][career_role]" placeholder="Software Engineer"></div>
            <div class="cf-f"><label class="cf-l">Industry</label><input class="cf-ctrl" name="career_outcomes[0][industry]" placeholder="IT / Technology"></div>
            <div class="cf-f"><label class="cf-l">Average Salary</label><input class="cf-ctrl" name="career_outcomes[0][average_salary]" placeholder="6–12 LPA"></div>
            <div class="cf-f"><label class="cf-l">Salary Range</label><input class="cf-ctrl" name="career_outcomes[0][salary_range]" placeholder="4–20 LPA"></div>
            <div class="cf-f"><label class="cf-l">Job Scope</label><input class="cf-ctrl" name="career_outcomes[0][job_scope]" placeholder="Development, Testing..."></div>
          </div>
          <div class="form-check cf-ck mt-2"><input class="form-check-input" type="checkbox" name="career_outcomes[0][status]" value="1" checked><label class="form-check-label"> Active</label></div>
        </div>
        @endforelse
      </div>
    </div>
  </div>

</div>{{-- /tab-placements --}}

{{-- ╔══════════════════════════════════════════════
     TAB 7 — CAMPUS
══════════════════════════════════════════════╗ --}}
<div class="cf-panel" id="tab-campus">

  @php
    $facRows  = isset($college) ? $college->collegeFacilities : collect();
    $loanRows = isset($college) ? $college->loanOptions : collect();
  @endphp

  <div class="cf-card">
    <div class="cf-ch"><div class="cf-ch-left"><span class="cf-ci"><i class="bi bi-buildings-fill"></i></span><div><p class="cf-ct">Campus Facilities</p><small class="cf-cs">Library, sports, labs, medical, hostel etc.</small></div></div>
      <button type="button" class="cf-add-btn" data-add-list="facilities_list"><i class="bi bi-plus-circle-fill"></i><span> Add Facility</span></button></div>
    <div class="cf-cb">
      <div class="cf-rlist" data-list="facilities_list">
        @forelse($facRows as $ri => $r)
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #{{ $ri+1 }}</div>
          <div class="cg3">
            <div class="cf-f"><label class="cf-l">Facility Name <span class="req">*</span></label><input class="cf-ctrl" name="facilities_list[{{ $ri }}][name]" value="{{ $r->name }}" placeholder="Digital Library"></div>
            <div class="cf-f"><label class="cf-l">Icon</label>
              <div class="cf-icon-row">
                <input class="cf-ctrl" name="facilities_list[{{ $ri }}][icon]" value="{{ $r->icon }}" placeholder="bi-book">
                <button type="button" class="cf-icon-btn"><i class="bi bi-grid"></i> Pick</button>
              </div>
              <i class="bi {{ $r->icon ?? 'bi-building' }} cf-icon-preview"></i>
            </div>
            <div class="cf-f"><label class="cf-l">Sort Order</label><input type="number" class="cf-ctrl" name="facilities_list[{{ $ri }}][sort_order]" value="{{ $r->sort_order ?? $ri }}"></div>
          </div>
          <div class="cf-f mt-2"><label class="cf-l">Description</label><textarea rows="2" class="cf-ctrl" name="facilities_list[{{ $ri }}][description]">{{ $r->description }}</textarea></div>
          <div class="form-check cf-ck mt-2"><input class="form-check-input" type="checkbox" name="facilities_list[{{ $ri }}][status]" value="1" {{ $r->status ? 'checked' : '' }}><label class="form-check-label"> Active</label></div>
        </div>
        @empty
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #1</div>
          <div class="cg3">
            <div class="cf-f"><label class="cf-l">Facility Name <span class="req">*</span></label><input class="cf-ctrl" name="facilities_list[0][name]" placeholder="Digital Library"></div>
            <div class="cf-f"><label class="cf-l">Icon</label>
              <div class="cf-icon-row">
                <input class="cf-ctrl" name="facilities_list[0][icon]" value="bi-building" placeholder="bi-book">
                <button type="button" class="cf-icon-btn"><i class="bi bi-grid"></i> Pick</button>
              </div>
              <i class="bi bi-building cf-icon-preview"></i>
            </div>
            <div class="cf-f"><label class="cf-l">Sort Order</label><input type="number" class="cf-ctrl" name="facilities_list[0][sort_order]" value="0"></div>
          </div>
          <div class="cf-f mt-2"><label class="cf-l">Description</label><textarea rows="2" class="cf-ctrl" name="facilities_list[0][description]"></textarea></div>
          <div class="form-check cf-ck mt-2"><input class="form-check-input" type="checkbox" name="facilities_list[0][status]" value="1" checked><label class="form-check-label"> Active</label></div>
        </div>
        @endforelse
      </div>
    </div>
  </div>

  <div class="cf-card">
    <div class="cf-ch"><div class="cf-ch-left"><span class="cf-ci"><i class="bi bi-cash-coin"></i></span><div><p class="cf-ct">Loan &amp; EMI Options</p><small class="cf-cs">Bank/NBFC education loan tie-ups</small></div></div>
      <button type="button" class="cf-add-btn" data-add-list="loan_options"><i class="bi bi-plus-circle-fill"></i><span> Add Loan</span></button></div>
    <div class="cf-cb">
      <div class="cf-rlist" data-list="loan_options">
        @forelse($loanRows as $ri => $r)
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #{{ $ri+1 }}</div>
          <div class="cg3">
            <div class="cf-f"><label class="cf-l">Provider <span class="req">*</span></label><input class="cf-ctrl" name="loan_options[{{ $ri }}][provider]" value="{{ $r->provider }}" placeholder="SBI / HDFC Credila"></div>
            <div class="cf-f"><label class="cf-l">Loan Type</label><input class="cf-ctrl" name="loan_options[{{ $ri }}][loan_type]" value="{{ $r->loan_type }}" placeholder="Education Loan / No-Cost EMI"></div>
            <div class="cf-f"><label class="cf-l">Max Amount (₹)</label><input type="number" class="cf-ctrl" name="loan_options[{{ $ri }}][amount]" value="{{ $r->amount }}" placeholder="1500000"></div>
            <div class="cf-f"><label class="cf-l">Interest Rate</label><input class="cf-ctrl" name="loan_options[{{ $ri }}][interest_rate]" value="{{ $r->interest_rate }}" placeholder="8.5% p.a."></div>
            <div class="cf-f"><label class="cf-l">Tenure</label><input class="cf-ctrl" name="loan_options[{{ $ri }}][tenure]" value="{{ $r->tenure }}" placeholder="5–10 years"></div>
            <div class="cf-f"><label class="cf-l">EMI From</label><input class="cf-ctrl" name="loan_options[{{ $ri }}][emi_from]" value="{{ $r->emi_from }}" placeholder="₹4,500/month"></div>
          </div>
          <div class="cf-f mt-2"><label class="cf-l">Description</label><textarea rows="2" class="cf-ctrl" name="loan_options[{{ $ri }}][description]">{{ $r->description }}</textarea></div>
          <div class="form-check cf-ck mt-2"><input class="form-check-input" type="checkbox" name="loan_options[{{ $ri }}][status]" value="1" {{ $r->status ? 'checked' : '' }}><label class="form-check-label"> Active</label></div>
        </div>
        @empty
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #1</div>
          <div class="cg3">
            <div class="cf-f"><label class="cf-l">Provider <span class="req">*</span></label><input class="cf-ctrl" name="loan_options[0][provider]" placeholder="SBI / HDFC Credila"></div>
            <div class="cf-f"><label class="cf-l">Loan Type</label><input class="cf-ctrl" name="loan_options[0][loan_type]" placeholder="Education Loan / No-Cost EMI"></div>
            <div class="cf-f"><label class="cf-l">Max Amount (₹)</label><input type="number" class="cf-ctrl" name="loan_options[0][amount]" placeholder="1500000"></div>
            <div class="cf-f"><label class="cf-l">Interest Rate</label><input class="cf-ctrl" name="loan_options[0][interest_rate]" placeholder="8.5% p.a."></div>
            <div class="cf-f"><label class="cf-l">Tenure</label><input class="cf-ctrl" name="loan_options[0][tenure]" placeholder="5–10 years"></div>
            <div class="cf-f"><label class="cf-l">EMI From</label><input class="cf-ctrl" name="loan_options[0][emi_from]" placeholder="₹4,500/month"></div>
          </div>
          <div class="cf-f mt-2"><label class="cf-l">Description</label><textarea rows="2" class="cf-ctrl" name="loan_options[0][description]"></textarea></div>
          <div class="form-check cf-ck mt-2"><input class="form-check-input" type="checkbox" name="loan_options[0][status]" value="1" checked><label class="form-check-label"> Active</label></div>
        </div>
        @endforelse
      </div>
    </div>
  </div>

</div>{{-- /tab-campus --}}

{{-- ╔══════════════════════════════════════════════
     TAB 8 — LEARNING & FAQs
══════════════════════════════════════════════╗ --}}
<div class="cf-panel" id="tab-learning">

  @php
    $leRows  = isset($college) ? $college->learningExperiences : collect();
    $faqRows = isset($college) ? $college->collegeFaqs : collect();
  @endphp

  <div class="cf-card">
    <div class="cf-ch"><div class="cf-ch-left"><span class="cf-ci"><i class="bi bi-laptop"></i></span><div><p class="cf-ct">Learning Experience &amp; LMS Features</p><small class="cf-cs">Live classes, recorded lectures, LMS tools</small></div></div>
      <button type="button" class="cf-add-btn" data-add-list="learning_experiences"><i class="bi bi-plus-circle-fill"></i><span> Add Row</span></button></div>
    <div class="cf-cb">
      <div class="cf-rlist" data-list="learning_experiences">
        @forelse($leRows as $ri => $r)
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #{{ $ri+1 }}</div>
          <div class="cg3">
            <div class="cf-f"><label class="cf-l">Title <span class="req">*</span></label><input class="cf-ctrl" name="learning_experiences[{{ $ri }}][title]" value="{{ $r->title }}" placeholder="Live Interactive Sessions"></div>
            <div class="cf-f"><label class="cf-l">Type</label><input class="cf-ctrl" name="learning_experiences[{{ $ri }}][type]" value="{{ $r->type }}" placeholder="Live / Recorded / Hybrid"></div>
            <div class="cf-f"><label class="cf-l">Icon</label>
              <div class="cf-icon-row">
                <input class="cf-ctrl" name="learning_experiences[{{ $ri }}][icon]" value="{{ $r->icon }}" placeholder="bi-camera-video">
                <button type="button" class="cf-icon-btn"><i class="bi bi-grid"></i> Pick</button>
              </div>
              <i class="bi {{ $r->icon ?? 'bi-laptop' }} cf-icon-preview"></i>
            </div>
          </div>
          <div class="cf-f mt-2"><label class="cf-l">Description</label><textarea rows="2" class="cf-ctrl" name="learning_experiences[{{ $ri }}][description]">{{ $r->description }}</textarea></div>
          <div class="form-check cf-ck mt-2"><input class="form-check-input" type="checkbox" name="learning_experiences[{{ $ri }}][status]" value="1" {{ $r->status ? 'checked' : '' }}><label class="form-check-label"> Active</label></div>
        </div>
        @empty
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #1</div>
          <div class="cg3">
            <div class="cf-f"><label class="cf-l">Title <span class="req">*</span></label><input class="cf-ctrl" name="learning_experiences[0][title]" placeholder="Live Interactive Sessions"></div>
            <div class="cf-f"><label class="cf-l">Type</label><input class="cf-ctrl" name="learning_experiences[0][type]" placeholder="Live / Recorded / Hybrid"></div>
            <div class="cf-f"><label class="cf-l">Icon</label>
              <div class="cf-icon-row">
                <input class="cf-ctrl" name="learning_experiences[0][icon]" value="bi-laptop" placeholder="bi-camera-video">
                <button type="button" class="cf-icon-btn"><i class="bi bi-grid"></i> Pick</button>
              </div>
              <i class="bi bi-laptop cf-icon-preview"></i>
            </div>
          </div>
          <div class="cf-f mt-2"><label class="cf-l">Description</label><textarea rows="2" class="cf-ctrl" name="learning_experiences[0][description]"></textarea></div>
          <div class="form-check cf-ck mt-2"><input class="form-check-input" type="checkbox" name="learning_experiences[0][status]" value="1" checked><label class="form-check-label"> Active</label></div>
        </div>
        @endforelse
      </div>
    </div>
  </div>

  <div class="cf-card">
    <div class="cf-ch"><div class="cf-ch-left"><span class="cf-ci"><i class="bi bi-question-circle-fill"></i></span><div><p class="cf-ct">Frequently Asked Questions</p><small class="cf-cs">Common student &amp; parent queries</small></div></div>
      <button type="button" class="cf-add-btn" data-add-list="faqs_list"><i class="bi bi-plus-circle-fill"></i><span> Add FAQ</span></button></div>
    <div class="cf-cb">
      <div class="cf-rlist" data-list="faqs_list">
        @forelse($faqRows as $ri => $r)
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #{{ $ri+1 }}</div>
          <div class="cf-f"><label class="cf-l">Question <span class="req">*</span></label><input class="cf-ctrl" name="faqs_list[{{ $ri }}][question]" value="{{ $r->question }}" placeholder="Is this degree UGC approved?"></div>
          <div class="cf-f mt-2"><label class="cf-l">Answer <span class="req">*</span></label><textarea rows="3" class="cf-ctrl" name="faqs_list[{{ $ri }}][answer]">{{ $r->answer }}</textarea></div>
          <div class="form-check cf-ck mt-2"><input class="form-check-input" type="checkbox" name="faqs_list[{{ $ri }}][status]" value="1" {{ $r->status ? 'checked' : '' }}><label class="form-check-label"> Active</label></div>
        </div>
        @empty
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #1</div>
          <div class="cf-f"><label class="cf-l">Question <span class="req">*</span></label><input class="cf-ctrl" name="faqs_list[0][question]" placeholder="Is this degree UGC approved?"></div>
          <div class="cf-f mt-2"><label class="cf-l">Answer <span class="req">*</span></label><textarea rows="3" class="cf-ctrl" name="faqs_list[0][answer]"></textarea></div>
          <div class="form-check cf-ck mt-2"><input class="form-check-input" type="checkbox" name="faqs_list[0][status]" value="1" checked><label class="form-check-label"> Active</label></div>
        </div>
        @endforelse
      </div>
    </div>
  </div>

</div>{{-- /tab-learning --}}

{{-- ╔══════════════════════════════════════════════
     TAB 9 — GALLERY & ALUMNI
══════════════════════════════════════════════╗ --}}
<div class="cf-panel" id="tab-gallery">

  @php
    $galRows = isset($college) ? $college->gallery : collect();
    $almRows = isset($college) ? $college->alumni : collect();
  @endphp

  <div class="cf-card">
    <div class="cf-ch"><div class="cf-ch-left"><span class="cf-ci"><i class="bi bi-camera-fill"></i></span><div><p class="cf-ct">College Gallery</p><small class="cf-cs">Campus photos, labs, events etc.</small></div></div>
      <button type="button" class="cf-add-btn" data-add-list="gallery_items"><i class="bi bi-plus-circle-fill"></i><span> Add Photo</span></button></div>
    <div class="cf-cb">
      <div class="cf-rlist" data-list="gallery_items">
        @forelse($galRows as $ri => $r)
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #{{ $ri+1 }}</div>
          <div class="cg3">
            <div class="cf-f"><label class="cf-l">Image</label>
              <input type="file" class="cf-ctrl cf-upload" name="gallery_files[{{ $ri }}]" accept="image/*">
              <input type="hidden" name="gallery_items[{{ $ri }}][existing_image]" value="{{ $r->image }}">
              @if($r->image)<img src="{{ $r->image_url }}" style="height:44px;margin-top:5px;border-radius:6px;">@endif
            </div>
            <div class="cf-f"><label class="cf-l">Title</label><input class="cf-ctrl" name="gallery_items[{{ $ri }}][title]" value="{{ $r->title }}" placeholder="Campus View"></div>
            <div class="cf-f"><label class="cf-l">Category</label><input class="cf-ctrl" name="gallery_items[{{ $ri }}][category]" value="{{ $r->category }}" placeholder="Campus / Lab / Event / Sports"></div>
          </div>
          <div class="cf-f mt-2"><label class="cf-l">Alt Text (for SEO)</label><input class="cf-ctrl" name="gallery_items[{{ $ri }}][alt_text]" value="{{ $r->alt_text }}"></div>
          <div class="form-check cf-ck mt-2"><input class="form-check-input" type="checkbox" name="gallery_items[{{ $ri }}][status]" value="1" {{ $r->status ? 'checked' : '' }}><label class="form-check-label"> Active</label></div>
        </div>
        @empty
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #1</div>
          <div class="cg3">
            <div class="cf-f"><label class="cf-l">Image</label><input type="file" class="cf-ctrl cf-upload" name="gallery_files[0]" accept="image/*"><input type="hidden" name="gallery_items[0][existing_image]" value=""></div>
            <div class="cf-f"><label class="cf-l">Title</label><input class="cf-ctrl" name="gallery_items[0][title]" placeholder="Campus View"></div>
            <div class="cf-f"><label class="cf-l">Category</label><input class="cf-ctrl" name="gallery_items[0][category]" placeholder="Campus / Lab / Event / Sports"></div>
          </div>
          <div class="cf-f mt-2"><label class="cf-l">Alt Text (for SEO)</label><input class="cf-ctrl" name="gallery_items[0][alt_text]"></div>
          <div class="form-check cf-ck mt-2"><input class="form-check-input" type="checkbox" name="gallery_items[0][status]" value="1" checked><label class="form-check-label"> Active</label></div>
        </div>
        @endforelse
      </div>
    </div>
  </div>

  <div class="cf-card">
    <div class="cf-ch"><div class="cf-ch-left"><span class="cf-ci"><i class="bi bi-people-fill"></i></span><div><p class="cf-ct">Notable Alumni</p><small class="cf-cs">Name, designation, company, batch, photo</small></div></div>
      <button type="button" class="cf-add-btn" data-add-list="alumni_list"><i class="bi bi-plus-circle-fill"></i><span> Add Alumni</span></button></div>
    <div class="cf-cb">
      <div class="cf-rlist" data-list="alumni_list">
        @forelse($almRows as $ri => $r)
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #{{ $ri+1 }}</div>
          <div class="cg3">
            <div class="cf-f"><label class="cf-l">Name <span class="req">*</span></label><input class="cf-ctrl" name="alumni_list[{{ $ri }}][name]" value="{{ $r->name }}" placeholder="Full Name"></div>
            <div class="cf-f"><label class="cf-l">Designation</label><input class="cf-ctrl" name="alumni_list[{{ $ri }}][designation]" value="{{ $r->designation }}" placeholder="CEO / VP / Director"></div>
            <div class="cf-f"><label class="cf-l">Company</label><input class="cf-ctrl" name="alumni_list[{{ $ri }}][company]" value="{{ $r->company }}" placeholder="Google / TCS"></div>
            <div class="cf-f"><label class="cf-l">Batch Year</label><input class="cf-ctrl" name="alumni_list[{{ $ri }}][batch]" value="{{ $r->batch }}" placeholder="2018"></div>
            <div class="cf-f"><label class="cf-l">Photo</label>
              <input type="file" class="cf-ctrl cf-upload" name="alumni_images[{{ $ri }}]" accept="image/*">
              <input type="hidden" name="alumni_list[{{ $ri }}][existing_image]" value="{{ $r->image }}">
              @if($r->image)<img src="{{ $r->image_url }}" style="height:36px;margin-top:4px;border-radius:50%;object-fit:cover;">@endif
            </div>
          </div>
          <div class="cf-f mt-2"><label class="cf-l">Description</label><textarea rows="2" class="cf-ctrl" name="alumni_list[{{ $ri }}][description]">{{ $r->description }}</textarea></div>
          <div class="form-check cf-ck mt-2"><input class="form-check-input" type="checkbox" name="alumni_list[{{ $ri }}][status]" value="1" {{ $r->status ? 'checked' : '' }}><label class="form-check-label"> Active</label></div>
        </div>
        @empty
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #1</div>
          <div class="cg3">
            <div class="cf-f"><label class="cf-l">Name <span class="req">*</span></label><input class="cf-ctrl" name="alumni_list[0][name]" placeholder="Full Name"></div>
            <div class="cf-f"><label class="cf-l">Designation</label><input class="cf-ctrl" name="alumni_list[0][designation]" placeholder="CEO / VP / Director"></div>
            <div class="cf-f"><label class="cf-l">Company</label><input class="cf-ctrl" name="alumni_list[0][company]" placeholder="Google / TCS"></div>
            <div class="cf-f"><label class="cf-l">Batch Year</label><input class="cf-ctrl" name="alumni_list[0][batch]" placeholder="2018"></div>
            <div class="cf-f"><label class="cf-l">Photo</label><input type="file" class="cf-ctrl cf-upload" name="alumni_images[0]" accept="image/*"><input type="hidden" name="alumni_list[0][existing_image]" value=""></div>
          </div>
          <div class="cf-f mt-2"><label class="cf-l">Description</label><textarea rows="2" class="cf-ctrl" name="alumni_list[0][description]"></textarea></div>
          <div class="form-check cf-ck mt-2"><input class="form-check-input" type="checkbox" name="alumni_list[0][status]" value="1" checked><label class="form-check-label"> Active</label></div>
        </div>
        @endforelse
      </div>
    </div>
  </div>

</div>{{-- /tab-gallery --}}

{{-- ╔══════════════════════════════════════════════
     TAB 10 — REVIEWS
══════════════════════════════════════════════╗ --}}
<div class="cf-panel" id="tab-reviews">

  @php
    $revRows = isset($college) ? $college->reviews()->withoutGlobalScopes()->get() : collect();
  @endphp

  <div class="cf-card">
    <div class="cf-ch"><div class="cf-ch-left"><span class="cf-ci"><i class="bi bi-star-fill"></i></span><div><p class="cf-ct">Student Reviews</p><small class="cf-cs">Add &amp; manage verified student reviews</small></div></div>
      <button type="button" class="cf-add-btn" data-add-list="reviews_list"><i class="bi bi-plus-circle-fill"></i><span> Add Review</span></button></div>
    <div class="cf-cb">
      <div class="cf-rlist" data-list="reviews_list">
        @forelse($revRows as $ri => $r)
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #{{ $ri+1 }}</div>
          <div class="cg3">
            <div class="cf-f"><label class="cf-l">Reviewer Name <span class="req">*</span></label><input class="cf-ctrl" name="reviews_list[{{ $ri }}][reviewer_name]" value="{{ $r->reviewer_name }}" placeholder="Student Name"></div>
            <div class="cf-f"><label class="cf-l">Course</label><input class="cf-ctrl" name="reviews_list[{{ $ri }}][course]" value="{{ $r->course }}" placeholder="MBA / B.Tech CSE"></div>
            <div class="cf-f"><label class="cf-l">Rating</label>
              <select class="cf-ctrl" name="reviews_list[{{ $ri }}][rating]">
                @for($s=5;$s>=1;$s--)
                  <option value="{{ $s }}" {{ $r->rating==$s ? 'selected' : '' }}>{{ $s }} Star{{ $s>1?'s':'' }}</option>
                @endfor
              </select>
            </div>
          </div>
          <div class="cf-f mt-2"><label class="cf-l">Review <span class="req">*</span></label><textarea rows="3" class="cf-ctrl" name="reviews_list[{{ $ri }}][review]">{{ $r->review }}</textarea></div>
          <div class="d-flex gap-3 mt-2 flex-wrap">
            <div class="form-check cf-ck"><input class="form-check-input" type="checkbox" name="reviews_list[{{ $ri }}][is_verified]" value="1" {{ $r->is_verified ? 'checked' : '' }}><label class="form-check-label"> Verified Review</label></div>
            <div class="form-check cf-ck"><input class="form-check-input" type="checkbox" name="reviews_list[{{ $ri }}][status]" value="1" {{ $r->status ? 'checked' : '' }}><label class="form-check-label"> Published</label></div>
          </div>
        </div>
        @empty
        <div class="cf-row">
          <button type="button" class="cf-rm"><i class="bi bi-trash3"></i></button>
          <div class="cf-rn">Entry #1</div>
          <div class="cg3">
            <div class="cf-f"><label class="cf-l">Reviewer Name <span class="req">*</span></label><input class="cf-ctrl" name="reviews_list[0][reviewer_name]" placeholder="Student Name"></div>
            <div class="cf-f"><label class="cf-l">Course</label><input class="cf-ctrl" name="reviews_list[0][course]" placeholder="MBA / B.Tech CSE"></div>
            <div class="cf-f"><label class="cf-l">Rating</label>
              <select class="cf-ctrl" name="reviews_list[0][rating]">
                @for($s=5;$s>=1;$s--)
                  <option value="{{ $s }}" {{ $s===5 ? 'selected' : '' }}>{{ $s }} Star{{ $s>1?'s':'' }}</option>
                @endfor
              </select>
            </div>
          </div>
          <div class="cf-f mt-2"><label class="cf-l">Review <span class="req">*</span></label><textarea rows="3" class="cf-ctrl" name="reviews_list[0][review]"></textarea></div>
          <div class="d-flex gap-3 mt-2 flex-wrap">
            <div class="form-check cf-ck"><input class="form-check-input" type="checkbox" name="reviews_list[0][is_verified]" value="1"><label class="form-check-label"> Verified Review</label></div>
            <div class="form-check cf-ck"><input class="form-check-input" type="checkbox" name="reviews_list[0][status]" value="1" checked><label class="form-check-label"> Published</label></div>
          </div>
        </div>
        @endforelse
      </div>
    </div>
  </div>

</div>{{-- /tab-reviews --}}

</div>{{-- col-lg-9 --}}

{{-- ══ SIDEBAR ════════════════════════════════════════════════════ --}}
<div class="col-lg-3">
  <div class="cf-sidebar">

    {{-- Publish Settings --}}
    <div class="cf-card">
      <div class="cf-ch">
        <div class="cf-ch-left">
          <span class="cf-ci"><i class="bi bi-rocket-takeoff-fill"></i></span>
          <div><p class="cf-ct">Publish Settings</p><small class="cf-cs">Status &amp; visibility controls</small></div>
        </div>
      </div>
      <div class="cf-cb">
        <div class="form-check cf-ck mb-2">
          <input type="hidden" name="status" value="0">
          <input class="form-check-input" type="checkbox" name="status" value="1" id="cbStatus"
                 {{ old('status', $college->status ?? true) ? 'checked' : '' }}>
          <label class="form-check-label" for="cbStatus"><strong>Publish</strong> — visible on website</label>
        </div>
        <div class="form-check cf-ck mb-3">
          <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="cbFeatured"
                 {{ old('is_featured', $college->is_featured ?? false) ? 'checked' : '' }}>
          <label class="form-check-label" for="cbFeatured"><strong>Featured</strong> — show on homepage</label>
        </div>

        <button type="submit" class="cf-save-btn">
          <i class="bi bi-check2-circle"></i>
          {{ isset($college) ? 'Update College' : 'Save & Publish' }}
        </button>

        <a href="{{ route('admin.colleges.index') }}" class="cf-sidebar-back">
          <i class="bi bi-arrow-left"></i> Back to Colleges List
        </a>

        <div class="cf-note">
          <i class="bi bi-info-circle-fill"></i>
          <span>All 10 tabs save together. Review before publishing.</span>
        </div>
      </div>
    </div>

    {{-- Quick Stats --}}
    @if(isset($college))
    <div class="cf-card">
      <div class="cf-ch">
        <div class="cf-ch-left">
          <span class="cf-ci"><i class="bi bi-graph-up"></i></span>
          <div><p class="cf-ct">Quick Stats</p><small class="cf-cs">Current data overview</small></div>
        </div>
      </div>
      <div class="cf-cb">
        @php
          $statItems = [
            ['Courses',      $college->collegeCourses->count(),       'bi-mortarboard'],
            ['Highlights',   $college->collegeHighlights->count(),    'bi-stars'],
            ['Accreditations',$college->accreditations->count(),      'bi-shield-check'],
            ['Scholarships', $college->scholarships->count(),         'bi-award'],
            ['Placement Stats',$college->placementStats->count(),     'bi-bar-chart'],
            ['Recruiters',   $college->recruiters->count(),           'bi-building'],
            ['Facilities',   $college->collegeFacilities->count(),    'bi-buildings'],
            ['FAQs',         $college->collegeFaqs->count(),          'bi-question-circle'],
            ['Gallery',      $college->gallery->count(),              'bi-camera'],
            ['Alumni',       $college->alumni->count(),               'bi-people'],
          ];
        @endphp
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px;">
          @foreach($statItems as [$label, $count, $icon])
          <div style="padding:8px;background:var(--cs);border-radius:8px;border:1px solid var(--cb);text-align:center;">
            <i class="bi {{ $icon }}" style="color:var(--cn);font-size:.9rem;"></i>
            <div style="font-size:1rem;font-weight:800;color:var(--ct);line-height:1.2;">{{ $count }}</div>
            <div style="font-size:.57rem;color:var(--cm);font-weight:700;">{{ $label }}</div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    @endif

  </div>
</div>{{-- col-lg-3 --}}

</div>{{-- row --}}
</div>{{-- cf-page --}}

{{-- JSON data for JS --}}
<script id="cfCoursesJson" type="application/json">@json($courses)</script>

@include('admin.colleges._form_js')
