{{-- Course Row Partial — used in TAB 3 Courses --}}
{{-- $ci = index (int), $cc = CollegeCourse|null --}}
<div class="cf-crow"
     data-sid="{{ $cc->course->stream_id ?? '' }}"
     data-cid="{{ $cc->course_id ?? '' }}"
     data-sv="{{ $cc->specialization ?? '' }}">

  <button type="button" class="cf-rm" title="Remove course row">
    <i class="bi bi-trash3"></i>
  </button>
  <div class="cf-rn">Course #{{ $ci + 1 }}</div>

  {{-- Row 1: Stream / Course / Spec --}}
  <div class="cg3 mb-2">
    <div class="cf-f">
      <label class="cf-l">1. Stream</label>
      <select class="cf-ctrl cf-stream-dd">
        <option value="">— All Streams —</option>
        @foreach($streams as $st)
          <option value="{{ $st->id }}"
            {{ ($cc && $cc->course && $cc->course->stream_id == $st->id) ? 'selected' : '' }}>
            {{ $st->name }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="cf-f">
      <label class="cf-l">2. Course <span class="req">*</span></label>
      <select name="course_ids[{{ $ci }}]" class="cf-ctrl cf-course-dd" required>
        <option value="">— Select Course —</option>
        @foreach($courses as $c)
          <option value="{{ $c->id }}"
                  data-stream="{{ $c->stream_id }}"
                  {{ ($cc && $cc->course_id == $c->id) ? 'selected' : '' }}>
            {{ $c->name }} ({{ $c->level }})
          </option>
        @endforeach
      </select>
    </div>
    <div class="cf-f">
      <label class="cf-l">3. Specialization</label>
      <select name="specializations[{{ $ci }}]" class="cf-ctrl cf-spec-dd">
        <option value="">General / Core</option>
        @if($cc && $cc->course && $cc->course->specializations)
          @foreach($cc->course->specializations as $sp)
            <option value="{{ $sp->name }}"
              {{ ($cc->specialization == $sp->name) ? 'selected' : '' }}>
              {{ $sp->name }}
            </option>
          @endforeach
        @endif
        @if($cc && $cc->specialization && $cc->course && !$cc->course->specializations->contains('name', $cc->specialization))
          <option value="{{ $cc->specialization }}" selected>{{ $cc->specialization }}</option>
        @endif
      </select>
    </div>
  </div>

  {{-- Row 2: Fee / Type / Eligibility / Seats --}}
  <div class="cg4 mb-2">
    <div class="cf-f">
      <label class="cf-l">Fee Amount (₹) <span class="req">*</span></label>
      <input type="number" name="fee_amounts[{{ $ci }}]" class="cf-ctrl"
             value="{{ old('fee_amounts.'.$ci, $cc ? (int)$cc->fee_amount : '') }}"
             placeholder="75000" required>
    </div>
    <div class="cf-f">
      <label class="cf-l">Fee Frequency</label>
      <select name="fee_types[{{ $ci }}]" class="cf-ctrl">
        @foreach(['per_year' => 'Per Year', 'per_semester' => 'Per Semester', 'total_course' => 'Total Course'] as $v => $l)
          <option value="{{ $v }}" {{ ($cc && $cc->fee_type === $v) ? 'selected' : '' }}>{{ $l }}</option>
        @endforeach
      </select>
    </div>
    <div class="cf-f">
      <label class="cf-l">Eligibility</label>
      <input type="text" name="eligibilities[{{ $ci }}]" class="cf-ctrl"
             value="{{ old('eligibilities.'.$ci, $cc?->eligibility ?? '') }}"
             placeholder="10+2 with 50% / Graduation">
    </div>
    <div class="cf-f">
      <label class="cf-l">Total Seats</label>
      <input type="number" name="seats[{{ $ci }}]" class="cf-ctrl"
             value="{{ old('seats.'.$ci, $cc?->seats ?? '') }}"
             placeholder="60">
    </div>
  </div>

  {{-- Row 3: Session / Entrance / Duration / Apply URL --}}
  <div class="cg4">
    <div class="cf-f">
      <label class="cf-l">Academic Session</label>
      <input type="text" name="academic_sessions[{{ $ci }}]" class="cf-ctrl"
             value="{{ old('academic_sessions.'.$ci, $cc?->academic_session ?? '') }}"
             placeholder="2025-26">
    </div>
    <div class="cf-f">
      <label class="cf-l">Entrance Exam</label>
      <input type="text" name="course_entrance_exams[{{ $ci }}]" class="cf-ctrl"
             value="{{ old('course_entrance_exams.'.$ci, $cc?->entrance_exam ?? '') }}"
             placeholder="CUET, CAT, Direct">
    </div>
    <div class="cf-f">
      <label class="cf-l">Duration Override</label>
      <input type="text" name="durations[{{ $ci }}]" class="cf-ctrl"
             value="{{ old('durations.'.$ci, $cc?->duration ?? '') }}"
             placeholder="Leave blank = course default">
    </div>
    <div class="cf-f">
      <label class="cf-l">Apply Now URL</label>
      <input type="url" name="application_urls[{{ $ci }}]" class="cf-ctrl"
             value="{{ old('application_urls.'.$ci, $cc?->application_url ?? '') }}"
             placeholder="https://apply.university.edu">
    </div>
  </div>

</div>
