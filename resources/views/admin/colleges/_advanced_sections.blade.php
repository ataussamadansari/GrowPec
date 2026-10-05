@php
$isEdit=isset($college) && $college;
$sec=function($rel,$key) use($college,$isEdit){$old=old($key); if(is_array($old)) return collect($old); return $isEdit ? ($college->{$rel} ?? collect()) : collect();};
@endphp

@php
$sections = [
['key'=>'highlights','rel'=>'highlights','title'=>'Key Highlights & USPs','icon'=>'★','fields'=>[
['title','Title'],['description','Description'],['icon','Icon / Bootstrap class'],['sort_order','Order']
]],
['key'=>'admission_sections','rel'=>'admissionSections','title'=>'Admission Sections','icon'=>'A','fields'=>[
['section_key','Section Key'],['title','Title'],['content','Content'],['items','Items (JSON or one item per line)'],['sort_order','Order']
]],
['key'=>'scholarships','rel'=>'scholarships','title'=>'Scholarships','icon'=>'₹','fields'=>[
['name','Scholarship Name'],['eligibility','Eligibility'],['criteria','Criteria'],['amount','Amount'],['amount_label','Amount Label'],['percentage','Percentage'],['description','Description'],['sort_order','Order']
]],
['key'=>'accreditations','rel'=>'accreditations','title'=>'Accreditations, Approvals & Rankings','icon'=>'✓','fields'=>[
['authority','Authority'],['accreditation','Accreditation'],['grade','Grade'],['rank','Rank'],['year','Year'],['description','Description'],['sort_order','Order']
]],
['key'=>'placement_stats','rel'=>'placementStats','title'=>'Placement Statistics','icon'=>'P','fields'=>[
['label','Metric / Label'],['value','Value'],['year','Year'],['course','Course'],['description','Description'],['sort_order','Order']
]],
['key'=>'career_outcomes','rel'=>'careerOutcomes','title'=>'Career Outcomes / ROI','icon'=>'C','fields'=>[
['career_role','Career Role'],['industry','Industry'],['average_salary','Average Salary'],['salary_range','Salary Range'],['job_scope','Job Scope'],['description','Description'],['sort_order','Order']
]],
['key'=>'facilities','rel'=>'facilitiesList','title'=>'Campus Facilities','icon'=>'F','fields'=>[
['name','Facility Name'],['icon','Icon'],['description','Description'],['sort_order','Order']
]],
['key'=>'learning_experiences','rel'=>'learningExperiences','title'=>'Learning Experience & LMS','icon'=>'L','fields'=>[
['title','Title'],['description','Description'],['icon','Icon'],['type','Type'],['sort_order','Order']
]],
['key'=>'loan_options','rel'=>'loanOptions','title'=>'Loan & EMI Options','icon'=>'₹','fields'=>[
['provider','Provider'],['loan_type','Loan Type'],['amount','Amount'],['interest_rate','Interest Rate'],['tenure','Tenure'],['emi_from','EMI From'],['description','Description'],['sort_order','Order']
]],
['key'=>'faqs','rel'=>'faqItems','title'=>'Frequently Asked Questions','icon'=>'?','fields'=>[
['question','Question'],['answer','Answer'],['sort_order','Order']
]],
];
@endphp

@foreach($sections as $definition)
@php $items=$sec($definition['rel'],$definition['key']); @endphp
<section class="gp-card advanced-section" data-section="{{ $definition['key'] }}">
    <div class="gp-head">
        <div>
            <h3 class="gp-title">{{ $definition['icon'] }} {{ $definition['title'] }}</h3>
            <div class="gp-sub">Manage public college detail content</div>
        </div><button type="button" class="gp-btn gp-add" data-add-row="{{ $definition['key'] }}">+ Add</button>
    </div>
    <div class="gp-body">
        <div class="advanced-list" data-list="{{ $definition['key'] }}">
            @forelse($items as $i=>$item)
            <div class="gp-repeater advanced-item">
                <div class="gp-repeater-head"><strong style="font-size:.68rem">Entry #{{ $i+1 }}</strong><button type="button" class="gp-btn gp-remove" data-remove-advanced>Remove</button></div>
                <div class="gp-grid">
                    @foreach($definition['fields'] as [$name,$label])
                    @php $v=is_array($item)?($item[$name]??''):($item->{$name}??''); @endphp
                    <div class="gp-field {{ in_array($name,['description','content','items','answer']) ? 'gp-field-wide' : '' }}">
                        <label>{{ $label }}</label>
                        @if(in_array($name,['description','content','items','answer']))
                        <textarea class="gp-control" rows="3" name="{{ $definition['key'] }}[{{ $i }}][{{ $name }}]">{{ is_array($v) ? json_encode($v,JSON_UNESCAPED_UNICODE) : $v }}</textarea>
                        @else
                        <input class="gp-control" name="{{ $definition['key'] }}[{{ $i }}][{{ $name }}]" value="{{ $v }}">
                        @endif
                    </div>
                    @endforeach
                    <label class="gp-check"><input type="checkbox" name="{{ $definition['key'] }}[{{ $i }}][status]" value="1" {{ (!isset($item->status) || $item->status) ? 'checked':'' }}> Active</label>
                </div>
            </div>
            @empty
            <div class="gp-repeater advanced-item">
                <div class="gp-repeater-head"><strong style="font-size:.68rem">Entry #1</strong><button type="button" class="gp-btn gp-remove" data-remove-advanced>Remove</button></div>
                <div class="gp-grid">
                    @foreach($definition['fields'] as [$name,$label])
                    <div class="gp-field {{ in_array($name,['description','content','items','answer']) ? 'gp-field-wide' : '' }}"><label>{{ $label }}</label>@if(in_array($name,['description','content','items','answer']))<textarea class="gp-control" rows="3" name="{{ $definition['key'] }}[0][{{ $name }}]"></textarea>@else<input class="gp-control" name="{{ $definition['key'] }}[0][{{ $name }}]">@endif</div>
                    @endforeach
                    <label class="gp-check"><input type="checkbox" name="{{ $definition['key'] }}[0][status]" value="1" checked> Active</label>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endforeach

@foreach([
['gallery','galleryItems','College Gallery'],['recruiters','recruiters','Top Recruiters'],['alumni','alumni','Alumni'],['documents','documents','Documents']
] as [$key,$rel,$title])
@php $items=$sec($rel,$key); @endphp
<section class="gp-card advanced-section">
    <div class="gp-head">
        <div>
            <h3 class="gp-title">{{ $title }}</h3>
            <div class="gp-sub">Existing files stay attached until replaced</div>
        </div><button type="button" class="gp-btn gp-add" data-add-file-row="{{ $key }}">+ Add</button>
    </div>
    <div class="gp-body">
        <div class="advanced-file-list" data-file-list="{{ $key }}">
            @forelse($items as $i=>$item)
            <div class="gp-repeater file-item">
                <div class="gp-repeater-head"><strong style="font-size:.68rem">Entry #{{ $i+1 }}</strong><button type="button" class="gp-btn gp-remove" data-remove-advanced>Remove</button></div>
                @if($key==='gallery')
                <input type="hidden" name="gallery[{{ $i }}][image]" value="{{ $item->image }}">
                <div class="gp-grid3">
                    <div class="gp-field"><label>Title</label><input class="gp-control" name="gallery[{{ $i }}][title]" value="{{ $item->title }}"></div>
                    <div class="gp-field"><label>Category</label><input class="gp-control" name="gallery[{{ $i }}][category]" value="{{ $item->category }}"></div>
                    <div class="gp-field"><label>Alt Text</label><input class="gp-control" name="gallery[{{ $i }}][alt_text]" value="{{ $item->alt_text }}"></div>
                </div>
                <div class="gp-field" style="margin-top:8px"><label>Replace Image</label><input class="gp-control" type="file" name="gallery_files[{{ $i }}]" accept="image/*">@if($item->image)<img class="gp-preview" src="{{ asset('storage/'.$item->image) }}">@endif</div>
                @elseif($key==='recruiters')
                <input type="hidden" name="recruiters[{{ $i }}][logo]" value="{{ $item->logo }}">
                <div class="gp-grid">
                    <div class="gp-field"><label>Name</label><input class="gp-control" name="recruiters[{{ $i }}][name]" value="{{ $item->name }}"></div>
                    <div class="gp-field"><label>Description</label><input class="gp-control" name="recruiters[{{ $i }}][description]" value="{{ $item->description }}"></div>
                </div>
                <div class="gp-field" style="margin-top:8px"><label>Replace Logo</label><input class="gp-control" type="file" name="recruiter_logos[{{ $i }}]" accept="image/*">@if($item->logo)<img class="gp-preview" src="{{ asset('storage/'.$item->logo) }}">@endif</div>
                @elseif($key==='alumni')
                <input type="hidden" name="alumni[{{ $i }}][image]" value="{{ $item->image }}">
                <div class="gp-grid3">@foreach(['name'=>'Name','designation'=>'Designation','company'=>'Company','batch'=>'Batch'] as $n=>$l)<div class="gp-field"><label>{{ $l }}</label><input class="gp-control" name="alumni[{{ $i }}][{{ $n }}]" value="{{ $item->{$n} }}"></div>@endforeach</div>
                <div class="gp-field" style="margin-top:8px"><label>Description</label><textarea class="gp-control" name="alumni[{{ $i }}][description]" rows="2">{{ $item->description }}</textarea></div>
                <div class="gp-field" style="margin-top:8px"><label>Replace Photo</label><input class="gp-control" type="file" name="alumni_images[{{ $i }}]" accept="image/*">@if($item->image)<img class="gp-preview" src="{{ asset('storage/'.$item->image) }}">@endif</div>
                @else
                <input type="hidden" name="documents[{{ $i }}][file_path]" value="{{ $item->file_path }}">
                <div class="gp-grid">
                    <div class="gp-field"><label>Title</label><input class="gp-control" name="documents[{{ $i }}][title]" value="{{ $item->title }}"></div>
                    <div class="gp-field"><label>Document Type</label><input class="gp-control" name="documents[{{ $i }}][document_type]" value="{{ $item->document_type }}"></div>
                </div>
                <div class="gp-field" style="margin-top:8px"><label>Replace File</label><input class="gp-control" type="file" name="document_files[{{ $i }}]">@if($item->file_path)<div class="gp-help">{{ $item->file_name ?: basename($item->file_path) }}</div>@endif</div>
                @endif
            </div>
            @empty
            <div class="gp-repeater file-item">
                <div class="gp-grid">
                    <div class="gp-field"><label>Title / Name</label><input class="gp-control" name="{{ $key }}[0][{{ $key==='documents'?'title':'name' }}]"></div>
                    <div class="gp-field"><label>Upload File/Image</label><input class="gp-control" type="file" name="{{ $key==='gallery'?'gallery_files':($key==='recruiters'?'recruiter_logos':($key==='alumni'?'alumni_images':'document_files')) }}[0]" required></div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endforeach

<section class="gp-card">
    <div class="gp-head">
        <div>
            <h3 class="gp-title">Reviews</h3>
            <div class="gp-sub">Verified student/user reviews</div>
        </div><button type="button" class="gp-btn gp-add" data-add-row="reviews">+ Add Review</button>
    </div>
    <div class="gp-body">
        <div class="advanced-list" data-list="reviews">
            @forelse($sec('reviews','reviews') as $i=>$r)
            <div class="gp-repeater advanced-item">
                <div class="gp-repeater-head"><strong>Review #{{ $i+1 }}</strong><button type="button" class="gp-btn gp-remove" data-remove-advanced>Remove</button></div>
                <div class="gp-grid"><input class="gp-control" type="number" name="reviews[{{ $i }}][user_id]" placeholder="User ID (optional)" value="{{ $r->user_id }}"><input class="gp-control" name="reviews[{{ $i }}][reviewer_name]" placeholder="Reviewer Name" value="{{ $r->reviewer_name }}"><input class="gp-control" name="reviews[{{ $i }}][course]" placeholder="Course" value="{{ $r->course }}"><input class="gp-control" type="number" min="1" max="5" name="reviews[{{ $i }}][rating]" value="{{ $r->rating }}"><textarea class="gp-control" style="grid-column:1/-1" rows="3" name="reviews[{{ $i }}][review]">{{ $r->review }}</textarea><label class="gp-check"><input type="checkbox" name="reviews[{{ $i }}][is_verified]" value="1" {{ $r->is_verified?'checked':'' }}> Verified</label></div>
            </div>
            @empty
            <div class="gp-repeater advanced-item">
                <div class="gp-grid"><input class="gp-control" name="reviews[0][reviewer_name]" placeholder="Reviewer Name"><input class="gp-control" name="reviews[0][course]" placeholder="Course"><input class="gp-control" type="number" min="1" max="5" name="reviews[0][rating]" placeholder="Rating"><textarea class="gp-control" style="grid-column:1/-1" rows="3" name="reviews[0][review]"></textarea></div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<section class="gp-card">
    <div class="gp-head">
        <div>
            <h3 class="gp-title">College Comparison</h3>
            <div class="gp-sub">Compare this college with another college</div>
        </div><button type="button" class="gp-btn gp-add" data-add-row="comparisons">+ Add Comparison</button>
    </div>
    <div class="gp-body">
        <div class="advanced-list" data-list="comparisons">
            @forelse($sec('comparisons','comparisons') as $i=>$c)
            <div class="gp-repeater advanced-item">
                <div class="gp-repeater-head"><strong>Comparison #{{ $i+1 }}</strong><button type="button" class="gp-btn gp-remove" data-remove-advanced>Remove</button></div>
                <div class="gp-grid"><select class="gp-control" name="comparisons[{{ $i }}][compared_college_id]">
                        <option value="">Select College</option>@foreach($allColleges as $oc)<option value="{{ $oc->id }}" {{ $c->compared_college_id==$oc->id?'selected':'' }}>{{ $oc->name }} — {{ $oc->city }}</option>@endforeach
                    </select><input class="gp-control" name="comparisons[{{ $i }}][title]" value="{{ $c->title }}" placeholder="Comparison title"><textarea class="gp-control" style="grid-column:1/-1" rows="4" name="comparisons[{{ $i }}][comparison_data]">{{ is_array($c->comparison_data)?json_encode($c->comparison_data,JSON_UNESCAPED_UNICODE):$c->comparison_data }}</textarea></div>
            </div>
            @empty
            <div class="gp-repeater advanced-item">
                <div class="gp-grid"><select class="gp-control" name="comparisons[0][compared_college_id]">
                        <option value="">Select College</option>@foreach($allColleges as $oc)<option value="{{ $oc->id }}">{{ $oc->name }} — {{ $oc->city }}</option>@endforeach
                    </select><input class="gp-control" name="comparisons[0][title]" placeholder="Comparison title"><textarea class="gp-control" style="grid-column:1/-1" rows="4" name="comparisons[0][comparison_data]" placeholder='{"fees":"...","placement":"..."}'></textarea></div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<style>
    .gp-field-wide {
        grid-column: 1/-1
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.addEventListener('click', function (e) {
            var add = e.target.closest('[data-add-row]');

            if (add) {
                var key = add.getAttribute('data-add-row');
                var list = document.querySelector('[data-list="' + key + '"]');

                if (!list) return;

                var first = list.querySelector('.advanced-item');
                if (!first) return;

                var indexes = Array.prototype.map.call(
                    list.querySelectorAll('.advanced-item'),
                    function (item) {
                        var named = item.querySelector('[name]');
                        if (!named) return -1;

                        var match = named.name.match(/\[(\d+)\]/);
                        return match ? parseInt(match[1], 10) : -1;
                    }
                );

                var idx = indexes.length
                    ? Math.max.apply(null, indexes) + 1
                    : 0;

                var clone = first.cloneNode(true);

                clone.querySelectorAll('input, textarea, select').forEach(function (el) {
                    if (el.type === 'checkbox' || el.type === 'radio') {
                        el.checked = el.type === 'checkbox';
                    } else {
                        el.value = '';
                    }

                    if (el.name) {
                        el.name = el.name.replace(
                            /\[\d+\]/g,
                            '[' + idx + ']'
                        );
                    }
                });

                // Remove old file paths from cloned media rows.
                clone.querySelectorAll('input[type="hidden"]').forEach(function (el) {
                    if (
                        el.name.indexOf('[image]') !== -1 ||
                        el.name.indexOf('[logo]') !== -1 ||
                        el.name.indexOf('[file_path]') !== -1
                    ) {
                        el.value = '';
                    }
                });

                clone.querySelectorAll('img.gp-preview').forEach(function (img) {
                    img.remove();
                });

                var h = clone.querySelector('strong');
                if (h) h.textContent = 'Entry #' + (idx + 1);

                list.appendChild(clone);
            }

            var addf = e.target.closest('[data-add-file-row]');

            if (addf) {
                var fileKey = addf.getAttribute('data-add-file-row');
                var fileList = document.querySelector(
                    '[data-file-list="' + fileKey + '"]'
                );

                if (!fileList) return;

                var fileFirst = fileList.querySelector('.file-item');
                if (!fileFirst) return;

                var fileIndexes = Array.prototype.map.call(
                    fileList.querySelectorAll('.file-item'),
                    function (item) {
                        var named = item.querySelector('[name]');
                        if (!named) return -1;

                        var match = named.name.match(/\[(\d+)\]/);
                        return match ? parseInt(match[1], 10) : -1;
                    }
                );

                var fileIdx = fileIndexes.length
                    ? Math.max.apply(null, fileIndexes) + 1
                    : 0;

                var fileClone = fileFirst.cloneNode(true);

                fileClone.querySelectorAll('input').forEach(function (el) {
                    if (el.type === 'file') {
                        el.value = '';
                        el.removeAttribute('required');
                    } else {
                        el.value = '';
                    }

                    if (el.name) {
                        el.name = el.name.replace(
                            /\[\d+\]/g,
                            '[' + fileIdx + ']'
                        );
                    }
                });

                fileClone.querySelectorAll('img.gp-preview').forEach(function (img) {
                    img.remove();
                });

                var fileHeading = fileClone.querySelector('strong');
                if (fileHeading) {
                    fileHeading.textContent = 'Entry #' + (fileIdx + 1);
                }

                fileList.appendChild(fileClone);
            }

            var remove = e.target.closest('[data-remove-advanced]');

            if (remove) {
                var row = remove.closest('.gp-repeater');
                if (row) row.remove();
            }
        });
    });
</script>