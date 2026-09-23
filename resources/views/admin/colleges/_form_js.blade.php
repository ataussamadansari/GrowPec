@push('scripts')
<script>
// college_form.js — inline, no Blade inside JS
(function(){
'use strict';

var COURSES = JSON.parse(document.getElementById('cfCoursesJson').textContent||'[]');
var ICONS   = [
  {v:'bi-check-circle-fill',  l:'Check Circle'},
  {v:'bi-patch-check-fill',   l:'Verified Badge'},
  {v:'bi-award-fill',         l:'Award'},
  {v:'bi-star-fill',          l:'Star'},
  {v:'bi-trophy-fill',        l:'Trophy'},
  {v:'bi-briefcase-fill',     l:'Briefcase'},
  {v:'bi-mortarboard-fill',   l:'Graduation Cap'},
  {v:'bi-building-fill',      l:'Building'},
  {v:'bi-buildings-fill',     l:'Buildings'},
  {v:'bi-house-fill',         l:'House'},
  {v:'bi-house-heart-fill',   l:'House Heart'},
  {v:'bi-people-fill',        l:'People'},
  {v:'bi-person-workspace',   l:'Person at Desk'},
  {v:'bi-laptop',             l:'Laptop'},
  {v:'bi-phone-fill',         l:'Mobile'},
  {v:'bi-wifi',               l:'Wi-Fi'},
  {v:'bi-book-fill',          l:'Book'},
  {v:'bi-journal-text',       l:'Journal'},
  {v:'bi-flask-fill',         l:'Lab Flask'},
  {v:'bi-cpu-fill',           l:'CPU / Tech'},
  {v:'bi-globe2',             l:'Globe / International'},
  {v:'bi-airplane-fill',      l:'Airplane'},
  {v:'bi-geo-alt-fill',       l:'Location Pin'},
  {v:'bi-cash-coin',          l:'Cash / Coin'},
  {v:'bi-bank2',              l:'Bank'},
  {v:'bi-graph-up-arrow',     l:'Graph Up'},
  {v:'bi-bar-chart-fill',     l:'Bar Chart'},
  {v:'bi-camera-fill',        l:'Camera'},
  {v:'bi-camera-video-fill',  l:'Video Camera'},
  {v:'bi-mic-fill',           l:'Microphone'},
  {v:'bi-hospital-fill',      l:'Hospital'},
  {v:'bi-heart-pulse-fill',   l:'Health / Pulse'},
  {v:'bi-shield-check',       l:'Shield / Security'},
  {v:'bi-lightbulb-fill',     l:'Lightbulb / Idea'},
  {v:'bi-diagram-3-fill',     l:'Network / Diagram'},
  {v:'bi-dribbble',           l:'Sports Ball'},
  {v:'bi-bicycle',            l:'Bicycle'},
  {v:'bi-water',              l:'Swimming Pool'},
  {v:'bi-cup-hot-fill',       l:'Cafeteria'},
  {v:'bi-bus-front-fill',     l:'Bus / Transport'},
  {v:'bi-tools',              l:'Tools / Workshop'},
  {v:'bi-headset',            l:'Headset / Support'},
  {v:'bi-chat-dots-fill',     l:'Chat / Discussion'},
  {v:'bi-file-earmark-pdf',   l:'PDF File'},
  {v:'bi-calendar-check-fill',l:'Calendar / Events'},
  {v:'bi-clock-fill',         l:'Clock / Time'},
];

/* ─── HTML escape ─────────────────── */
function h(v){
  return String(v==null?'':v)
    .replace(/&/g,'&amp;').replace(/</g,'&lt;')
    .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

/* ─── Icon picker modal ───────────────────────────────── */
var pickerTarget = null;

function buildPicker(){
  if(document.getElementById('cfIconModal')) return;
  var m = document.createElement('div');
  m.id = 'cfIconModal';
  m.style.cssText = 'display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.45);align-items:center;justify-content:center;';
  var inner = '<div style="background:#fff;border-radius:14px;width:min(560px,94vw);max-height:80vh;display:flex;flex-direction:column;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.25);">';
  inner += '<div style="display:flex;align-items:center;justify-content:space-between;padding:14px 18px;border-bottom:1px solid #e2e8f0;">';
  inner += '<span style="font-size:.85rem;font-weight:800;color:#002B67;">Choose Icon</span>';
  inner += '<button type="button" id="cfIconClose" style="border:none;background:none;font-size:1.3rem;cursor:pointer;color:#64748B;">&times;</button>';
  inner += '</div>';
  inner += '<div style="padding:12px 18px;border-bottom:1px solid #e2e8f0;">';
  inner += '<input id="cfIconSearch" type="text" placeholder="Search icons..." style="width:100%;padding:7px 11px;border:1px solid #d8e0ea;border-radius:8px;font-size:.78rem;">';
  inner += '</div>';
  inner += '<div id="cfIconGrid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(90px,1fr));gap:6px;padding:14px 18px;overflow-y:auto;">';
  ICONS.forEach(function(ic){
    inner += '<button type="button" class="cf-ic-opt" data-val="'+h(ic.v)+'" style="display:flex;flex-direction:column;align-items:center;gap:5px;padding:10px 6px;border:1px solid #e2e8f0;border-radius:9px;background:#fafbfd;cursor:pointer;transition:all .15s;font-size:.62rem;color:#475569;" title="'+h(ic.l)+'">';
    inner += '<i class="bi '+h(ic.v)+'" style="font-size:1.3rem;color:#002B67;"></i>';
    inner += '<span>'+h(ic.l)+'</span></button>';
  });
  inner += '</div></div>';
  m.innerHTML = inner;
  document.body.appendChild(m);

  document.getElementById('cfIconClose').addEventListener('click', closePicker);
  m.addEventListener('click', function(e){ if(e.target===m) closePicker(); });

  document.getElementById('cfIconSearch').addEventListener('input', function(){
    var q = this.value.toLowerCase();
    m.querySelectorAll('.cf-ic-opt').forEach(function(btn){
      btn.style.display = btn.title.toLowerCase().includes(q)||btn.dataset.val.toLowerCase().includes(q) ? '' : 'none';
    });
  });

  m.querySelectorAll('.cf-ic-opt').forEach(function(btn){
    btn.addEventListener('mouseover', function(){this.style.background='#eef4f8';this.style.borderColor='#002B67';});
    btn.addEventListener('mouseout',  function(){this.style.background='#fafbfd';this.style.borderColor='#e2e8f0';});
    btn.addEventListener('click', function(){
      if(!pickerTarget) return;
      var val = this.dataset.val;
      pickerTarget.value = val;
      var row = pickerTarget.closest('.cf-row,.cf-card-body,div');
      if(row){
        var prev = row.querySelector('.cf-icon-preview');
        if(prev){ prev.className='bi '+val+' cf-icon-preview'; prev.style.cssText='font-size:1.4rem;color:#002B67;display:block;margin-top:4px;'; }
      }
      closePicker();
    });
  });
}

function openPicker(input){
  buildPicker();
  pickerTarget = input;
  var m = document.getElementById('cfIconModal');
  m.style.display = 'flex';
  document.getElementById('cfIconSearch').value = '';
  m.querySelectorAll('.cf-ic-opt').forEach(function(b){ b.style.display=''; });
}

function closePicker(){
  var m = document.getElementById('cfIconModal');
  if(m) m.style.display='none';
  pickerTarget = null;
}

/* Wire icon picker buttons */
function wireIconPickers(root){
  (root||document).querySelectorAll('.cf-icon-btn').forEach(function(btn){
    btn.addEventListener('click', function(){
      var input = this.previousElementSibling;
      if(input && input.classList.contains('cf-ctrl')) openPicker(input);
    });
  });
}

/* ─── TAB SWITCHING + PREV/NEXT ────────── */
function initTabs(){
  var btns   = Array.prototype.slice.call(document.querySelectorAll('.cf-tb'));
  var panels = Array.prototype.slice.call(document.querySelectorAll('.cf-panel'));
  var total  = btns.length;

  function activate(idx){
    if(idx<0||idx>=total) return;
    btns.forEach(function(b){ b.classList.remove('on'); });
    panels.forEach(function(p){ p.classList.remove('on'); });
    btns[idx].classList.add('on');
    var panel = document.getElementById('tab-'+btns[idx].dataset.tab);
    if(panel) panel.classList.add('on');
    refreshNavBars(idx);
    window.scrollTo({top:0,behavior:'smooth'});
  }

  function refreshNavBars(idx){
    document.querySelectorAll('.cf-tnb').forEach(function(bar){
      var prevBtn = bar.querySelector('[data-dir="prev"]');
      var nextBtn = bar.querySelector('[data-dir="next"]');
      var step    = bar.querySelector('.cf-tstep');
      if(prevBtn) prevBtn.disabled = (idx===0);
      if(nextBtn && !nextBtn.type==='submit') nextBtn.disabled = (idx===total-1);
      if(step) step.textContent = (idx+1)+' / '+total;
    });
  }

  /* Inject nav bar at bottom of each panel */
  panels.forEach(function(panel, idx){
    var isLast = idx===total-1;
    var bar = document.createElement('div');
    bar.className = 'cf-tnb';

    var prevHtml = '<button type="button" data-dir="prev" class="cf-btn-prev"'+(idx===0?' disabled':'')+'>'+
      '<i class="bi bi-arrow-left-circle-fill"></i> Previous</button>';
    var stepHtml = '<span class="cf-tstep">'+(idx+1)+' / '+total+'</span>';
    var nextHtml = isLast
      ? '<button type="submit" class="cf-btn-next cf-btn-save"><i class="bi bi-check2-circle"></i> Save &amp; Publish</button>'
      : '<button type="button" data-dir="next" class="cf-btn-next">Next <i class="bi bi-arrow-right-circle-fill"></i></button>';

    bar.innerHTML = prevHtml + stepHtml + nextHtml;

    bar.querySelector('[data-dir="prev"]').addEventListener('click', function(){
      var cur = btns.findIndex(function(b){return b.classList.contains('on');});
      activate(cur-1);
    });
    if(!isLast){
      bar.querySelector('[data-dir="next"]').addEventListener('click', function(){
        var cur = btns.findIndex(function(b){return b.classList.contains('on');});
        activate(cur+1);
      });
    }

    panel.appendChild(bar);
  });

  btns.forEach(function(btn,idx){
    btn.addEventListener('click', function(){ activate(idx); });
  });

  refreshNavBars(0);
}

/* ─── STATE → CITY CASCADE ─────────────── */
function initCityCascade(){
  var sel  = document.getElementById('cfStateSelect');
  var city = document.getElementById('cfCitySelect');
  if(!sel||!city) return;

  function load(stateId, cur){
    city.innerHTML = '<option value="">Loading...</option>';
    if(!stateId){ city.innerHTML='<option value="">Choose State First</option>'; return; }
    fetch('/api/states/'+stateId+'/cities')
      .then(function(r){ return r.ok?r.json():Promise.reject(); })
      .then(function(list){
        city.innerHTML = '<option value="">Choose City *</option>';
        list.forEach(function(c){
          var o = new Option(c.name, c.name, false, c.name===cur);
          city.add(o);
        });
      })
      .catch(function(){ city.innerHTML='<option value="">Error loading</option>'; });
  }

  sel.addEventListener('change', function(){
    var opt = this.options[this.selectedIndex];
    load(opt?opt.dataset.id:'', city.dataset.cur||'');
  });

  if(sel.value && city.dataset.cur){
    var opt = sel.options[sel.selectedIndex];
    load(opt?opt.dataset.id:'', city.dataset.cur);
  }
}

/* ─── COURSE ROWS ───────────────────────── */
function fillCourses(sel, streamId){
  var cur  = sel.value;
  var list = streamId ? COURSES.filter(function(c){return String(c.stream_id)===String(streamId);}) : COURSES;
  sel.innerHTML = '<option value="">-- Select Course --</option>';
  list.forEach(function(c){
    var o = new Option(c.name+' ('+( c.level||'')+' )', c.id);
    o.dataset.stream = c.stream_id;
    sel.add(o);
  });
  if(cur) sel.value = cur;
}

function fillSpecs(row, val){
  var cid  = (row.querySelector('.cf-course-dd')||{}).value;
  var spec = row.querySelector('.cf-spec-dd');
  if(!spec) return;
  var course = COURSES.find(function(c){return String(c.id)===String(cid);});
  spec.innerHTML = '<option value="">General / Core</option>';
  ((course&&course.specializations)||[]).filter(function(s){return s.status;}).forEach(function(s){
    spec.add(new Option(s.name, s.name));
  });
  if(val){
    if(!Array.prototype.some.call(spec.options, function(o){return o.value===val;})) spec.add(new Option(val,val));
    spec.value = val;
  }
}

function wireCourseRow(row){
  var streamDd = row.querySelector('.cf-stream-dd');
  var courseDd = row.querySelector('.cf-course-dd');
  if(!streamDd||!courseDd) return;
  streamDd.addEventListener('change', function(){
    fillCourses(courseDd, this.value);
    var s=row.querySelector('.cf-spec-dd');
    if(s) s.innerHTML='<option value="">General / Core</option>';
  });
  courseDd.addEventListener('change', function(){
    var c=COURSES.find(function(x){return String(x.id)===String(this.value);},this);
    if(c&&c.stream_id) streamDd.value=c.stream_id;
    fillSpecs(row,'');
  });
}

function bootCourseRow(row){
  wireCourseRow(row);
  var sid = row.dataset.sid||'';
  var cid = row.dataset.cid||'';
  var sv  = row.dataset.sv ||'';
  var cd  = row.querySelector('.cf-course-dd');
  if(cid&&cd){ if(sid) fillCourses(cd,sid); cd.value=cid; fillSpecs(row,sv); }
}

function initAddCourse(){
  var btn  = document.getElementById('cfAddCourse');
  var wrap = document.getElementById('cfCoursesWrap');
  if(!btn||!wrap) return;
  btn.addEventListener('click', function(){
    var rows = wrap.querySelectorAll('.cf-crow');
    var idx  = rows.length;
    var first = rows[0]; if(!first) return;
    var clone = first.cloneNode(true);
    clone.removeAttribute('data-sid');
    clone.removeAttribute('data-cid');
    clone.removeAttribute('data-sv');
    clone.querySelectorAll('[name]').forEach(function(el){
      el.name = el.name.replace(/\[\d+\]/, '['+idx+']');
      if(el.type!=='checkbox'&&el.type!=='hidden'&&el.tagName!=='SELECT') el.value='';
      if(el.tagName==='SELECT') el.selectedIndex=0;
      if(el.tagName==='TEXTAREA') el.value='';
    });
    var num=clone.querySelector('.cf-rn'); if(num) num.textContent='Course #'+(idx+1);
    var cd=clone.querySelector('.cf-course-dd'); if(cd) fillCourses(cd,'');
    var sp=clone.querySelector('.cf-spec-dd'); if(sp) sp.innerHTML='<option value="">General / Core</option>';
    wrap.appendChild(clone);
    wireCourseRow(clone);
    clone.scrollIntoView({behavior:'smooth',block:'nearest'});
  });
}

/* ─── GENERIC REPEATER ADD ──────────────── */
function initRepeaterAdd(){
  document.querySelectorAll('[data-add-list]').forEach(function(btn){
    btn.addEventListener('click', function(){
      var key  = this.dataset.addList;
      var list = document.querySelector('.cf-rlist[data-list="'+key+'"]');
      if(!list) return;
      var rows = list.querySelectorAll('.cf-row');
      var idx  = rows.length;
      var first= rows[0]; if(!first) return;
      var clone= first.cloneNode(true);
      clone.querySelectorAll('[name]').forEach(function(el){
        el.name=el.name.replace(/\[\d+\]/,'['+idx+']');
        if(el.type!=='checkbox'&&el.type!=='file'&&el.tagName!=='SELECT') el.value='';
        if(el.tagName==='SELECT') el.selectedIndex=0;
        if(el.tagName==='TEXTAREA') el.value='';
      });
      clone.querySelectorAll('img').forEach(function(i){i.remove();});
      var num=clone.querySelector('.cf-rn'); if(num) num.textContent='Entry #'+(idx+1);
      list.appendChild(clone);
      wireIconPickers(clone);
      clone.scrollIntoView({behavior:'smooth',block:'nearest'});
    });
  });
}

/* ─── GENERIC REPEATER REMOVE ─────────────── */
function reindex(container, rowSel, prefix){
  container.querySelectorAll(rowSel).forEach(function(r,i){
    r.querySelectorAll('[name]').forEach(function(el){
      el.name=el.name.replace(/\[\d+\]/,'['+i+']');
    });
    var num=r.querySelector('.cf-rn'); if(num) num.textContent=(prefix||'Entry')+' #'+(i+1);
  });
}

function initRepeaterRemove(){
  document.addEventListener('click', function(e){
    var rm = e.target.closest('.cf-rm');
    if(!rm) return;
    /* Course row */
    if(rm.closest('.cf-crow')){
      var wrap=document.getElementById('cfCoursesWrap');
      var rows=wrap?wrap.querySelectorAll('.cf-crow'):[];
      if(rows.length>1){ rm.closest('.cf-crow').remove(); reindex(wrap,'.cf-crow','Course'); }
      else alert('At least one course is required.');
      return;
    }
    /* Generic row */
    var row  = rm.closest('.cf-row');
    var list = row&&row.closest('.cf-rlist');
    if(!list) return;
    if(list.querySelectorAll('.cf-row').length>1){ row.remove(); reindex(list,'.cf-row','Entry'); }
    else alert('At least one entry is required.');
  });
}

/* ─── PREVENT DOUBLE SUBMIT ────────────── */
function initFormGuard(){
  var form=document.querySelector('form.cf-college-form');
  if(!form) return;
  form.addEventListener('submit', function(){
    if(this.checkValidity()){
      this.querySelectorAll('button[type="submit"]').forEach(function(b){
        b.disabled=true;
        b.innerHTML='<i class="bi bi-hourglass-split"></i> Saving...';
      });
    }
  });
}

/* ─── BOOT ───────────────────────────── */
document.addEventListener('DOMContentLoaded', function(){
  initTabs();
  initCityCascade();
  document.querySelectorAll('.cf-crow').forEach(bootCourseRow);
  initAddCourse();
  initRepeaterAdd();
  initRepeaterRemove();
  wireIconPickers();
  initFormGuard();
});

})();
</script>
@endpush
