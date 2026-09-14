

<?php $__env->startSection('title', 'Leads CRM - GrowPec'); ?>
<?php $__env->startSection('header', 'Student Leads Management'); ?>

<?php $__env->startSection('content'); ?>

<style>
    .leads-page{
        --gp-navy:#002B67;
        --gp-navy-dark:#001B45;
        --gp-blue:#174B8F;
        --gp-green:#008A43;
        --gp-green-dark:#006B35;
        --gp-gold:#D9A400;
        --gp-border:#E5EAF0;
        --gp-text:#172033;
        --gp-muted:#718096;
        width:100%;
        min-width:0;
    }

    .leads-page *{box-sizing:border-box}

    .leads-hero{
        position:relative;
        overflow:hidden;
        padding:22px 24px;
        margin-bottom:16px;
        border-radius:18px;
        background:linear-gradient(135deg,var(--gp-navy-dark),var(--gp-navy) 62%,var(--gp-blue));
        color:#fff;
        box-shadow:0 10px 28px rgba(0,43,103,.12);
    }
    .leads-hero:before,.leads-hero:after{
        content:"";
        position:absolute;
        border-radius:50%;
        pointer-events:none;
    }
    .leads-hero:before{
        width:210px;height:210px;right:-80px;top:-120px;
        background:rgba(255,255,255,.07);
    }
    .leads-hero:after{
        width:110px;height:110px;right:130px;bottom:-75px;
        background:rgba(0,138,67,.16);
    }
    .hero-content{
        position:relative;z-index:1;
        display:flex;align-items:center;justify-content:space-between;
        gap:18px;
    }
    .hero-left{display:flex;align-items:center;gap:13px;min-width:0}
    .hero-icon{
        width:50px;height:50px;flex:0 0 50px;
        display:inline-flex;align-items:center;justify-content:center;
        border-radius:14px;background:rgba(255,255,255,.12);
        border:1px solid rgba(255,255,255,.14);
        font-size:1.2rem;
    }
    .hero-title{margin:0 0 4px;font-size:1.18rem;font-weight:800}
    .hero-subtitle{margin:0;color:rgba(255,255,255,.72);font-size:.76rem}
    .hero-pill{
        display:inline-flex;align-items:center;gap:7px;
        padding:8px 12px;border-radius:999px;
        background:rgba(255,255,255,.10);
        border:1px solid rgba(255,255,255,.13);
        color:rgba(255,255,255,.9);
        font-size:.68rem;font-weight:800;white-space:nowrap;
    }

    .leads-card{
        overflow:hidden;background:#fff;border:1px solid var(--gp-border);
        border-radius:18px;box-shadow:0 8px 26px rgba(15,35,65,.055);
    }

    .crm-summary{
        display:grid;
        grid-template-columns:repeat(5,minmax(0,1fr));
        border-bottom:1px solid var(--gp-border);
    }
    .summary-item{
        padding:15px 17px;
        border-right:1px solid var(--gp-border);
        min-width:0;
    }
    .summary-item:last-child{border-right:0}
    .summary-label{
        display:flex;align-items:center;gap:6px;
        color:var(--gp-muted);font-size:.62rem;font-weight:800;
        text-transform:uppercase;letter-spacing:.04em;
    }
    .summary-value{
        margin-top:5px;color:var(--gp-navy);
        font-size:1.18rem;font-weight:900;line-height:1.1;
    }
    .summary-value.green{color:var(--gp-green)}
    .summary-value.gold{color:#9A7100}
    .summary-value.red{color:#B42318}

    .leads-toolbar{
        padding:16px 18px;border-bottom:1px solid var(--gp-border);
        background:#fff;
    }
    .filter-grid{
        display:grid;
        grid-template-columns:minmax(230px,1.7fr) repeat(3,minmax(130px,1fr)) auto auto;
        gap:9px;align-items:center;
    }
    .search-wrap{position:relative;min-width:0}
    .search-wrap>i{
        position:absolute;left:13px;top:50%;
        transform:translateY(-50%);z-index:2;
        color:var(--gp-blue);pointer-events:none;
    }
    .lead-search,.crm-filter{
        width:100%;height:42px;
        border:1px solid #D8DEE8;border-radius:10px;
        color:var(--gp-text);font-size:.74rem;
        box-shadow:none;background:#fff;
    }
    .lead-search{padding-left:38px}
    .lead-search:focus,.crm-filter:focus{
        border-color:var(--gp-blue);
        box-shadow:0 0 0 3px rgba(23,75,143,.09);
    }
    .filter-btn,.export-btn,.reset-btn{
        height:42px;border-radius:10px;
        display:inline-flex;align-items:center;justify-content:center;
        gap:7px;padding:0 14px;font-size:.71rem;font-weight:800;
        white-space:nowrap;text-decoration:none;
        transition:.18s ease;
    }
    .filter-btn{border:1px solid var(--gp-navy);background:var(--gp-navy);color:#fff}
    .filter-btn:hover{background:var(--gp-blue);color:#fff;transform:translateY(-1px)}
    .export-btn{border:1px solid var(--gp-green);background:var(--gp-green);color:#fff}
    .export-btn:hover{background:var(--gp-green-dark);color:#fff;transform:translateY(-1px)}
    .reset-btn{border:1px solid #D8DEE8;background:#fff;color:#667085}
    .reset-btn:hover{background:#F8FAFC;color:var(--gp-navy)}

    .active-filter{
        display:flex;align-items:center;flex-wrap:wrap;gap:7px;
        margin-top:10px;color:var(--gp-muted);font-size:.67rem;
    }
    .active-badge{
        display:inline-flex;align-items:center;gap:5px;
        padding:5px 9px;border-radius:999px;
        background:#F1F6FC;border:1px solid #D9E7F7;
        color:var(--gp-blue);font-weight:800;
    }

    .table-shell{width:100%;overflow-x:auto;overflow-y:visible}
    .leads-table{
        width:100%;min-width:1660px;margin:0;
        border-collapse:separate;border-spacing:0;
    }
    .leads-table thead th{
        padding:12px 13px;background:#F8FAFC;
        border-bottom:1px solid var(--gp-border);
        color:#667085;font-size:.61rem;font-weight:800;
        text-transform:uppercase;letter-spacing:.045em;
        white-space:nowrap;vertical-align:middle;
    }
    .leads-table tbody td{
        padding:12px 13px;border-color:#EEF1F5;
        color:#475467;font-size:.71rem;
        vertical-align:middle;white-space:nowrap;
    }
    .leads-table tbody tr{transition:background .15s ease}
    .leads-table tbody tr:hover{background:#FBFCFE}

    .lead-id{color:#98A2B3!important;font-weight:800}
    .student-cell{display:flex;align-items:center;gap:9px;min-width:190px}
    .student-avatar{
        width:38px;height:38px;flex:0 0 38px;
        display:inline-flex;align-items:center;justify-content:center;
        border-radius:11px;background:#EAF1FA;
        border:1px solid #D9E7F7;color:var(--gp-blue);
        font-size:.88rem;font-weight:800;
    }
    .student-info{min-width:0}
    .student-info strong{
        display:block;max-width:210px;overflow:hidden;text-overflow:ellipsis;
        color:var(--gp-text);font-size:.75rem;font-weight:800;
    }
    .student-info small{
        display:block;max-width:210px;margin-top:2px;
        overflow:hidden;text-overflow:ellipsis;color:var(--gp-muted);font-size:.60rem;
    }

    .contact-cell{display:flex;flex-direction:column;gap:5px}
    .phone-link,.email-link{
        text-decoration:none;font-weight:700;color:var(--gp-text);
    }
    .phone-link:hover,.email-link:hover{color:var(--gp-blue)}
    .phone-link i{color:var(--gp-green)}
    .email-link{font-size:.64rem;color:var(--gp-muted);max-width:190px;overflow:hidden;text-overflow:ellipsis}

    .whatsapp-btn{
        min-height:30px;display:inline-flex;align-items:center;justify-content:center;
        gap:5px;padding:0 9px;border:1px solid #BFE5CC;border-radius:8px;
        background:#F0FBF4;color:var(--gp-green-dark);
        font-size:.64rem;font-weight:800;text-decoration:none;
    }
    .whatsapp-btn:hover{background:var(--gp-green);border-color:var(--gp-green);color:#fff}

    .location-cell,.program-cell,.college-cell,.source-cell{
        display:flex;flex-direction:column;gap:3px;
    }
    .location-main,.college-main,.program-main{
        color:#344054;font-weight:750;max-width:210px;overflow:hidden;text-overflow:ellipsis;
    }
    .location-sub,.program-sub,.source-sub{
        color:var(--gp-muted);font-size:.60rem;
    }
    .location-cell i{color:var(--gp-blue)}
    .college-cell{max-width:220px}
    .college-main{max-width:220px}
    .program-cell{max-width:210px}
    .source-chip{
        display:inline-flex;width:max-content;max-width:180px;
        padding:4px 8px;border-radius:999px;
        background:#F1F6FC;border:1px solid #D9E7F7;
        color:var(--gp-blue);font-size:.60rem;font-weight:800;
        overflow:hidden;text-overflow:ellipsis;
    }

    .mode-badge,.type-badge{
        display:inline-flex;align-items:center;gap:5px;
        padding:5px 8px;border-radius:999px;font-size:.59rem;font-weight:900;
        width:max-content;
    }
    .mode-online{background:#ECFDF3;border:1px solid #CDEBD9;color:var(--gp-green-dark)}
    .mode-regular{background:#EEF4F8;border:1px solid #D6E4F1;color:var(--gp-navy)}
    .type-badge{background:#FFF8E7;border:1px solid #F4DE9C;color:#8A6200}

    .status-badge{
        display:inline-flex;align-items:center;gap:5px;
        padding:5px 9px;border-radius:999px;
        font-size:.59rem;font-weight:900;letter-spacing:.025em;
    }
    .status-new{background:#FEF3F2;border:1px solid #F5D0CC;color:#B42318}
    .status-contacted{background:#EFF8FF;border:1px solid #CDE5F7;color:#175CD3}
    .status-counseling{background:#FFF8E7;border:1px solid #F4DE9C;color:#8A6200}
    .status-admitted{background:#ECFDF3;border:1px solid #CDEBD9;color:var(--gp-green-dark)}
    .status-closed{background:#F2F4F7;border:1px solid #D9DDE3;color:#667085}

    .status-form{margin:0}
    .status-select{
        width:132px;height:34px;padding:0 27px 0 9px;
        border:1px solid #D8DEE8;border-radius:9px;
        background:#fff;color:var(--gp-text);
        font-size:.64rem;font-weight:700;box-shadow:none;cursor:pointer;
    }
    .status-select:focus{border-color:var(--gp-blue);box-shadow:0 0 0 3px rgba(23,75,143,.08)}

    .followup-cell{display:flex;flex-direction:column;gap:3px}
    .followup-date{font-weight:800;color:#344054}
    .followup-date.overdue{color:#B42318}
    .followup-date.today{color:#9A7100}
    .followup-empty{color:#98A2B3;font-style:italic}
    .followup-icon{color:var(--gp-blue)}

    .assigned-cell{display:flex;align-items:center;gap:7px}
    .assigned-avatar{
        width:28px;height:28px;border-radius:8px;
        display:inline-flex;align-items:center;justify-content:center;
        background:#EEF4F8;border:1px solid #D9E7F7;color:var(--gp-navy);
        font-size:.61rem;font-weight:900;
    }
    .assigned-name{font-size:.65rem;font-weight:800;color:#344054;max-width:125px;overflow:hidden;text-overflow:ellipsis}
    .unassigned{color:#98A2B3;font-style:italic;font-size:.65rem}

    .action-wrap{display:flex;align-items:center;gap:6px}
    .icon-action{
        width:33px;height:33px;display:inline-flex;align-items:center;justify-content:center;
        border-radius:9px;text-decoration:none;border:1px solid #DDE4EC;
        background:#fff;color:var(--gp-blue);cursor:pointer;transition:.18s ease;
    }
    .icon-action:hover{background:#EEF4F8;border-color:#C9D9ED;transform:translateY(-1px)}
    .icon-action.green{color:var(--gp-green-dark);border-color:#CBE8D5;background:#F4FBF6}
    .icon-action.green:hover{background:var(--gp-green);border-color:var(--gp-green);color:#fff}
    .icon-action.gold{color:#8A6200;border-color:#F1DDA3;background:#FFFDF5}
    .icon-action.gold:hover{background:var(--gp-gold);border-color:var(--gp-gold);color:#111}

    .empty-state{padding:55px 20px!important;text-align:center}
    .empty-icon{
        width:56px;height:56px;margin:0 auto 11px;
        display:inline-flex;align-items:center;justify-content:center;
        border-radius:15px;background:#F1F6FC;color:var(--gp-blue);font-size:1.25rem;
    }
    .empty-state strong{display:block;margin-bottom:3px;color:var(--gp-text);font-size:.82rem}
    .empty-state span{color:var(--gp-muted);font-size:.68rem}

    .pagination-wrap{
        display:flex;justify-content:center;padding:15px 18px 17px;
        border-top:1px solid var(--gp-border);
    }
    .pagination{margin:0}
    .pagination .page-link{
        min-width:34px;height:34px;margin:0 2px;border-radius:8px!important;
        border:1px solid #E0E6ED;display:inline-flex;align-items:center;
        justify-content:center;color:var(--gp-blue);font-size:.69rem;font-weight:700;
    }
    .pagination .page-item.active .page-link{background:var(--gp-navy);border-color:var(--gp-navy);color:#fff}
    .pagination .page-link:hover{background:#F1F6FC;border-color:#C9D9ED}

    .lead-modal .modal-content{border:0;border-radius:18px;overflow:hidden;box-shadow:0 25px 80px rgba(0,27,69,.20)}
    .lead-modal .modal-header{
        padding:18px 20px;background:linear-gradient(135deg,var(--gp-navy-dark),var(--gp-navy));
        color:#fff;border:0;
    }
    .lead-modal .modal-title{font-size:1rem;font-weight:800}
    .lead-modal .modal-body{padding:20px}
    .detail-grid{
        display:grid;grid-template-columns:repeat(2,minmax(0,1fr));
        gap:12px;
    }
    .detail-box{
        padding:12px;border:1px solid #E7ECF2;border-radius:11px;background:#F8FAFC;
        min-width:0;
    }
    .detail-box.full{grid-column:1/-1}
    .detail-label{display:block;margin-bottom:4px;color:#98A2B3;font-size:.59rem;font-weight:800;text-transform:uppercase}
    .detail-value{color:#344054;font-size:.73rem;font-weight:750;word-break:break-word}
    .detail-message{white-space:pre-wrap;line-height:1.6;font-weight:500}

    @media(max-width:1350px){
        .filter-grid{grid-template-columns:minmax(220px,1.5fr) repeat(3,minmax(120px,1fr)) auto auto}
    }
    @media(max-width:1199.98px){
        .crm-summary{grid-template-columns:repeat(3,minmax(0,1fr))}
        .summary-item:nth-child(3){border-right:0}
        .summary-item:nth-child(4),.summary-item:nth-child(5){border-top:1px solid var(--gp-border)}
        .filter-grid{grid-template-columns:1fr 1fr 1fr}
        .filter-grid .search-wrap{grid-column:1/-1}
        .filter-grid .filter-btn,.filter-grid .export-btn,.filter-grid .reset-btn{width:100%}
    }
    @media(max-width:767.98px){
        .leads-hero{padding:17px;border-radius:15px}
        .hero-icon{width:43px;height:43px;flex-basis:43px;border-radius:11px}
        .hero-title{font-size:1rem}
        .hero-subtitle{font-size:.66rem}
        .hero-pill{display:none}
        .crm-summary{grid-template-columns:repeat(2,minmax(0,1fr))}
        .summary-item:nth-child(2),.summary-item:nth-child(4){border-right:0}
        .summary-item:nth-child(3),.summary-item:nth-child(4),.summary-item:nth-child(5){border-top:1px solid var(--gp-border)}
        .summary-item:last-child{grid-column:1/-1}
        .leads-toolbar{padding:13px}
        .filter-grid{grid-template-columns:1fr 1fr;gap:8px}
        .filter-grid .search-wrap{grid-column:1/-1}
        .leads-card{border-radius:15px}
        .detail-grid{grid-template-columns:1fr}
        .detail-box.full{grid-column:auto}
    }
    @media(max-width:420px){
        .filter-grid{grid-template-columns:1fr}
        .filter-grid .search-wrap{grid-column:auto}
        .summary-value{font-size:1.02rem}
    }
</style>

<div class="leads-page">

    <div class="leads-hero">
        <div class="hero-content">
            <div class="hero-left">
                <span class="hero-icon"><i class="bi bi-people-fill"></i></span>
                <div>
                    <h3 class="hero-title">Student Leads Management</h3>
                    <p class="hero-subtitle">Manage enquiries, programmes, counselling, follow-ups and admissions from one CRM.</p>
                </div>
            </div>
            <span class="hero-pill"><i class="bi bi-kanban-fill"></i> Lead CRM</span>
        </div>
    </div>

    <div class="leads-card">

        <?php
            $allLeads = collect($leads->items());
            $totalCount = method_exists($leads, 'total') ? $leads->total() : $allLeads->count();
            $newCount = $allLeads->where('status', 'new')->count();
            $counselingCount = $allLeads->where('status', 'counseling')->count();
            $admittedCount = $allLeads->where('status', 'admitted')->count();
            $followupCount = $allLeads->filter(fn($l) => !empty($l->next_followup_at))->count();
        ?>

        <div class="crm-summary">
            <div class="summary-item">
                <span class="summary-label"><i class="bi bi-people"></i> Total Leads</span>
                <div class="summary-value"><?php echo e($totalCount); ?></div>
            </div>
            <div class="summary-item">
                <span class="summary-label"><i class="bi bi-stars"></i> New</span>
                <div class="summary-value red"><?php echo e($newCount); ?></div>
            </div>
            <div class="summary-item">
                <span class="summary-label"><i class="bi bi-chat-heart"></i> Counseling</span>
                <div class="summary-value gold"><?php echo e($counselingCount); ?></div>
            </div>
            <div class="summary-item">
                <span class="summary-label"><i class="bi bi-check-circle"></i> Admitted</span>
                <div class="summary-value green"><?php echo e($admittedCount); ?></div>
            </div>
            <div class="summary-item">
                <span class="summary-label"><i class="bi bi-calendar-check"></i> Follow-ups</span>
                <div class="summary-value"><?php echo e($followupCount); ?></div>
            </div>
        </div>

        <div class="leads-toolbar">
            <div class="filter-grid">

                <div class="search-wrap">
                    <i class="bi bi-search"></i>
                    <input type="text" id="leadSearch" class="form-control lead-search"
                           placeholder="Search name, phone, email, college, course, city..." autocomplete="off">
                </div>

                <select id="statusFilter" class="form-select crm-filter">
                    <option value="">All Statuses</option>
                    <?php $__currentLoopData = ['new','contacted','counseling','admitted','closed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($st); ?>"><?php echo e(ucfirst($st)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <select id="modeFilter" class="form-select crm-filter">
                    <option value="">All Modes</option>
                    <option value="online">Online</option>
                    <option value="regular">Regular</option>
                </select>

                <select id="sourceFilter" class="form-select crm-filter">
                    <option value="">All Sources</option>
                    <?php $__currentLoopData = $allLeads->pluck('source')->filter()->unique()->sort()->values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e(strtolower($source)); ?>"><?php echo e(ucwords(str_replace('_',' ', $source))); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <button type="button" class="btn filter-btn" id="applyLeadFilters">
                    <i class="bi bi-funnel-fill"></i> Filter
                </button>

                <a href="<?php echo e(route('admin.leads.export')); ?>?search=<?php echo e(urlencode(request('search',''))); ?>&status=<?php echo e(urlencode(request('status',''))); ?>" class="btn export-btn">
                    <i class="bi bi-file-earmark-spreadsheet-fill"></i> Export CSV
                </a>
            </div>

            <div class="active-filter" id="filterStatusText">
                <span>Live filters:</span>
                <span class="active-badge"><i class="bi bi-check2-circle"></i> Search & filters work on this page</span>
                <button type="button" id="clearLeadFilters" class="btn btn-link p-0 text-danger fw-bold text-decoration-none" style="font-size:.67rem;">Clear</button>
            </div>
        </div>

        <div class="table-shell">
            <table class="table leads-table align-middle mb-0" id="leadsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Contact</th>
                        <th>Location</th>
                        <th>College</th>
                        <th>Course</th>
                        <th>Specialization</th>
                        <th>Mode</th>
                        <th>Source</th>
                        <th>Status</th>
                        <th>Next Follow-up</th>
                        <th>Assigned Counselor</th>
                        <th>Update Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <?php
                        $statusClass = match($lead->status) {
                            'new' => 'status-new',
                            'contacted' => 'status-contacted',
                            'counseling' => 'status-counseling',
                            'admitted' => 'status-admitted',
                            'closed' => 'status-closed',
                            default => 'status-closed',
                        };

                        $statusIcon = match($lead->status) {
                            'new' => 'bi-stars',
                            'contacted' => 'bi-telephone-check-fill',
                            'counseling' => 'bi-chat-heart-fill',
                            'admitted' => 'bi-check-circle-fill',
                            'closed' => 'bi-x-circle-fill',
                            default => 'bi-circle-fill',
                        };

                        $phone = preg_replace('/[^0-9]/', '', (string) $lead->phone);
                        if (strlen($phone) === 10) $waPhone = '91'.$phone;
                        elseif (str_starts_with($phone, '91')) $waPhone = $phone;
                        else $waPhone = $phone;

                        $courseName = optional($lead->course)->name;
                        $specializationName = optional($lead->specialization)->name
                            ?? optional($lead->collegeCourse)->specialization
                            ?? $lead->specialization_id;
                        $collegeName = optional($lead->college)->name;

                        $mode = $lead->preferred_mode
                            ?? optional($lead->college)->college_mode;

                        $assignedName = optional($lead->assignedCounselor)->name
                            ?? optional($lead->assignedCounselor)->email;

                        $followup = $lead->next_followup_at ? \Illuminate\Support\Carbon::parse($lead->next_followup_at) : null;
                        $followupClass = '';
                        if ($followup) {
                            if ($followup->isPast()) $followupClass = 'overdue';
                            elseif ($followup->isToday()) $followupClass = 'today';
                        }

                        $message = $lead->message ?? $lead->notes;
                    ?>

                    <tr
                        class="lead-row"
                        data-search="<?php echo e(strtolower(trim(($lead->name ?? '').' '.($lead->phone ?? '').' '.($lead->email ?? '').' '.($lead->city ?? '').' '.($lead->state ?? '').' '.($collegeName ?? '').' '.($courseName ?? '').' '.($specializationName ?? '').' '.($lead->source ?? '')))); ?>"
                        data-status="<?php echo e(strtolower($lead->status ?? '')); ?>"
                        data-mode="<?php echo e(strtolower($mode ?? '')); ?>"
                        data-source="<?php echo e(strtolower($lead->source ?? '')); ?>"
                    >
                        <td class="lead-id"><?php echo e($lead->id); ?></td>

                        <td>
                            <div class="student-cell">
                                <span class="student-avatar">
                                    <?php echo e(strtoupper(substr(trim($lead->name ?: 'S'), 0, 1))); ?>

                                </span>
                                <div class="student-info">
                                    <strong title="<?php echo e($lead->name); ?>"><?php echo e($lead->name); ?></strong>
                                    <small title="<?php echo e($lead->email ?? ''); ?>">
                                        <?php echo e($lead->email ?: 'No email provided'); ?>

                                    </small>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="contact-cell">
                                <a href="tel:<?php echo e($lead->phone); ?>" class="phone-link">
                                    <i class="bi bi-telephone-fill me-1"></i><?php echo e($lead->phone); ?>

                                </a>
                                <?php if($lead->email): ?>
                                    <a href="mailto:<?php echo e($lead->email); ?>" class="email-link">
                                        <i class="bi bi-envelope me-1"></i><?php echo e($lead->email); ?>

                                    </a>
                                <?php endif; ?>
                                <?php if($waPhone): ?>
                                    <a href="https://wa.me/<?php echo e($waPhone); ?>" target="_blank" rel="noopener noreferrer" class="whatsapp-btn">
                                        <i class="bi bi-whatsapp"></i> WhatsApp
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>

                        <td>
                            <div class="location-cell">
                                <div class="location-main">
                                    <i class="bi bi-geo-alt-fill me-1"></i><?php echo e($lead->city ?: 'N/A'); ?>

                                </div>
                                <div class="location-sub">
                                    <?php echo e($lead->state ?: (optional($lead->stateRelation)->name ?? 'State not set')); ?>

                                </div>
                            </div>
                        </td>

                        <td>
                            <?php if($collegeName): ?>
                                <div class="college-cell" title="<?php echo e($collegeName); ?>">
                                    <div class="college-main"><?php echo e($collegeName); ?></div>
                                    <?php if(optional($lead->college)->college_type): ?>
                                        <div class="location-sub"><?php echo e(optional($lead->college)->college_type); ?> University</div>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <span class="general-inquiry text-muted fst-italic">General Inquiry</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <div class="program-cell">
                                <div class="program-main"><?php echo e($courseName ?: 'Not selected'); ?></div>
                                <?php if(optional($lead->course)->level): ?>
                                    <div class="program-sub"><?php echo e(optional($lead->course)->level); ?></div>
                                <?php endif; ?>
                            </div>
                        </td>

                        <td>
                            <?php if($specializationName): ?>
                                <span class="type-badge">
                                    <i class="bi bi-diagram-3-fill"></i>
                                    <?php echo e(is_numeric($specializationName) ? 'ID #'.$specializationName : $specializationName); ?>

                                </span>
                            <?php else: ?>
                                <span class="text-muted small">General / Core</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if($mode): ?>
                                <span class="mode-badge <?php echo e(strtolower($mode) === 'online' ? 'mode-online' : 'mode-regular'); ?>">
                                    <i class="bi <?php echo e(strtolower($mode) === 'online' ? 'bi-laptop' : 'bi-building'); ?>"></i>
                                    <?php echo e(ucfirst($mode)); ?>

                                </span>
                            <?php else: ?>
                                <span class="text-muted small">N/A</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <div class="source-cell">
                                <span class="source-chip" title="<?php echo e($lead->source); ?>">
                                    <i class="bi bi-bullseye me-1"></i>
                                    <?php echo e(ucwords(str_replace('_',' ', $lead->source ?: 'Unknown'))); ?>

                                </span>
                                <?php if($lead->utm_source): ?>
                                    <span class="source-sub">UTM: <?php echo e($lead->utm_source); ?></span>
                                <?php endif; ?>
                            </div>
                        </td>

                        <td>
                            <span class="status-badge <?php echo e($statusClass); ?>">
                                <i class="bi <?php echo e($statusIcon); ?>"></i>
                                <?php echo e(strtoupper($lead->status)); ?>

                            </span>
                        </td>

                        <td>
                            <?php if($followup): ?>
                                <div class="followup-cell">
                                    <span class="followup-date <?php echo e($followupClass); ?>">
                                        <i class="bi bi-calendar-event followup-icon me-1"></i>
                                        <?php echo e($followup->format('d M Y')); ?>

                                    </span>
                                    <span class="location-sub">
                                        <?php echo e($followup->format('h:i A')); ?>

                                        <?php if($followupClass === 'overdue'): ?> · Overdue <?php elseif($followupClass === 'today'): ?> · Today <?php endif; ?>
                                    </span>
                                </div>
                            <?php else: ?>
                                <span class="followup-empty">Not scheduled</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if($assignedName): ?>
                                <div class="assigned-cell">
                                    <span class="assigned-avatar"><?php echo e(strtoupper(substr($assignedName,0,1))); ?></span>
                                    <span class="assigned-name" title="<?php echo e($assignedName); ?>"><?php echo e($assignedName); ?></span>
                                </div>
                            <?php else: ?>
                                <span class="unassigned">Unassigned</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <form action="<?php echo e(route('admin.leads.updateStatus', $lead->id)); ?>" method="POST" class="status-form">
                                <?php echo csrf_field(); ?>
                                <select name="status" class="form-select status-select" onchange="this.form.submit()" aria-label="Update lead status">
                                    <?php $__currentLoopData = ['new','contacted','counseling','admitted','closed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($st); ?>" <?php echo e($lead->status == $st ? 'selected' : ''); ?>>
                                            <?php echo e(ucfirst($st)); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </form>
                        </td>

                        <td>
                            <div class="action-wrap">
                                <button
                                    type="button"
                                    class="icon-action"
                                    title="View Lead"
                                    data-bs-toggle="modal"
                                    data-bs-target="#leadDetailModal"
                                    data-lead-id="<?php echo e($lead->id); ?>"
                                    data-name="<?php echo e(e($lead->name)); ?>"
                                    data-phone="<?php echo e(e($lead->phone)); ?>"
                                    data-email="<?php echo e(e($lead->email ?? '')); ?>"
                                    data-city="<?php echo e(e($lead->city ?? '')); ?>"
                                    data-state="<?php echo e(e($lead->state ?? '')); ?>"
                                    data-college="<?php echo e(e($collegeName ?? 'General Inquiry')); ?>"
                                    data-course="<?php echo e(e($courseName ?? 'Not selected')); ?>"
                                    data-specialization="<?php echo e(e(is_numeric($specializationName ?? '') ? 'ID #'.$specializationName : ($specializationName ?? 'General / Core'))); ?>"
                                    data-mode="<?php echo e(e($mode ?? 'Not specified')); ?>"
                                    data-source="<?php echo e(e($lead->source ?? 'Unknown')); ?>"
                                    data-status="<?php echo e(e(ucfirst($lead->status ?? 'new'))); ?>"
                                    data-followup="<?php echo e(e($followup ? $followup->format('d M Y, h:i A') : 'Not scheduled')); ?>"
                                    data-assigned="<?php echo e(e($assignedName ?? 'Unassigned')); ?>"
                                    data-message="<?php echo e(e($message ?? 'No notes or message added.')); ?>"
                                >
                                    <i class="bi bi-eye"></i>
                                </button>

                                <?php if($waPhone): ?>
                                    <a href="https://wa.me/<?php echo e($waPhone); ?>" target="_blank" rel="noopener noreferrer"
                                       class="icon-action green" title="WhatsApp Lead">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                <?php endif; ?>

                                <a href="tel:<?php echo e($lead->phone); ?>" class="icon-action gold" title="Call Lead">
                                    <i class="bi bi-telephone-fill"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="14" class="empty-state">
                            <div class="empty-icon"><i class="bi bi-person-lines-fill"></i></div>
                            <strong>No leads found</strong>
                            <span>New enquiries will appear here automatically.</span>
                        </td>
                    </tr>
                <?php endif; ?>

                <tr id="noFilterResults" style="display:none">
                    <td colspan="14" class="empty-state">
                        <div class="empty-icon"><i class="bi bi-search"></i></div>
                        <strong>No matching leads</strong>
                        <span>Try another search or clear the filters.</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <?php if($leads->hasPages()): ?>
            <div class="pagination-wrap">
                <?php echo e($leads->links('pagination::bootstrap-5')); ?>

            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Lead Details Modal -->
<div class="modal fade lead-modal" id="leadDetailModal" tabindex="-1" aria-labelledby="leadDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="leadDetailModalLabel">Lead Details</h5>
                    <small class="opacity-75" id="modalLeadId"></small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="detail-grid">
                    <div class="detail-box">
                        <span class="detail-label">Student</span>
                        <div class="detail-value" id="modalName">—</div>
                    </div>
                    <div class="detail-box">
                        <span class="detail-label">Phone</span>
                        <div class="detail-value" id="modalPhone">—</div>
                    </div>
                    <div class="detail-box">
                        <span class="detail-label">Email</span>
                        <div class="detail-value" id="modalEmail">—</div>
                    </div>
                    <div class="detail-box">
                        <span class="detail-label">Location</span>
                        <div class="detail-value" id="modalLocation">—</div>
                    </div>
                    <div class="detail-box">
                        <span class="detail-label">College</span>
                        <div class="detail-value" id="modalCollege">—</div>
                    </div>
                    <div class="detail-box">
                        <span class="detail-label">Course</span>
                        <div class="detail-value" id="modalCourse">—</div>
                    </div>
                    <div class="detail-box">
                        <span class="detail-label">Specialization</span>
                        <div class="detail-value" id="modalSpecialization">—</div>
                    </div>
                    <div class="detail-box">
                        <span class="detail-label">Mode</span>
                        <div class="detail-value" id="modalMode">—</div>
                    </div>
                    <div class="detail-box">
                        <span class="detail-label">Source</span>
                        <div class="detail-value" id="modalSource">—</div>
                    </div>
                    <div class="detail-box">
                        <span class="detail-label">Status</span>
                        <div class="detail-value" id="modalStatus">—</div>
                    </div>
                    <div class="detail-box">
                        <span class="detail-label">Next Follow-up</span>
                        <div class="detail-value" id="modalFollowup">—</div>
                    </div>
                    <div class="detail-box">
                        <span class="detail-label">Assigned Counselor</span>
                        <div class="detail-value" id="modalAssigned">—</div>
                    </div>
                    <div class="detail-box full">
                        <span class="detail-label">Message / Notes</span>
                        <div class="detail-value detail-message" id="modalMessage">—</div>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light border fw-bold" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const search = document.getElementById('leadSearch');
    const status = document.getElementById('statusFilter');
    const mode = document.getElementById('modeFilter');
    const source = document.getElementById('sourceFilter');
    const apply = document.getElementById('applyLeadFilters');
    const clear = document.getElementById('clearLeadFilters');
    const rows = Array.from(document.querySelectorAll('.lead-row'));
    const noResults = document.getElementById('noFilterResults');
    const filterStatusText = document.getElementById('filterStatusText');

    function applyFilters() {
        const q = (search?.value || '').trim().toLowerCase();
        const selectedStatus = (status?.value || '').toLowerCase();
        const selectedMode = (mode?.value || '').toLowerCase();
        const selectedSource = (source?.value || '').toLowerCase();

        let visible = 0;

        rows.forEach(row => {
            const matchesSearch = !q || (row.dataset.search || '').includes(q);
            const matchesStatus = !selectedStatus || row.dataset.status === selectedStatus;
            const matchesMode = !selectedMode || row.dataset.mode === selectedMode;
            const matchesSource = !selectedSource || row.dataset.source === selectedSource;

            const show = matchesSearch && matchesStatus && matchesMode && matchesSource;
            row.style.display = show ? '' : 'table-row';

            if (show) visible++;
        });

        if (noResults) noResults.style.display = visible ? 'none' : 'table-row';

        const active = [];
        if (q) active.push('Search: ' + q);
        if (selectedStatus) active.push('Status: ' + selectedStatus);
        if (selectedMode) active.push('Mode: ' + selectedMode);
        if (selectedSource) active.push('Source: ' + selectedSource);

        if (filterStatusText) {
            filterStatusText.innerHTML = active.length
                ? '<span>Active:</span> ' + active.map(x => '<span class="active-badge"><i class="bi bi-funnel-fill"></i> ' + escapeHtml(x) + '</span>').join('') +
                  ' <button type="button" id="clearLeadFiltersDynamic" class="btn btn-link p-0 text-danger fw-bold text-decoration-none" style="font-size:.67rem;">Clear</button>'
                : '<span>Live filters:</span><span class="active-badge"><i class="bi bi-check2-circle"></i> Search & filters work on this page</span>' +
                  ' <button type="button" id="clearLeadFiltersDynamic" class="btn btn-link p-0 text-danger fw-bold text-decoration-none" style="font-size:.67rem;">Clear</button>';

            document.getElementById('clearLeadFiltersDynamic')?.addEventListener('click', clearFilters);
        }
    }

    function clearFilters() {
        if (search) search.value = '';
        if (status) status.value = '';
        if (mode) mode.value = '';
        if (source) source.value = '';
        applyFilters();
    }

    function escapeHtml(value) {
        return String(value).replace(/[&<>"']/g, function (char) {
            return ({
                '&':'&amp;',
                '<':'&lt;',
                '>':'&gt;',
                '"':'&quot;',
                "'":'&#039;'
            })[char];
        });
    }

    apply?.addEventListener('click', applyFilters);
    clear?.addEventListener('click', clearFilters);

    search?.addEventListener('input', function () {
        clearTimeout(window.__leadSearchTimer);
        window.__leadSearchTimer = setTimeout(applyFilters, 180);
    });

    [status, mode, source].forEach(select => {
        select?.addEventListener('change', applyFilters);
    });

    // Lead details modal
    const modal = document.getElementById('leadDetailModal');

    modal?.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        if (!button) return;

        const get = key => button.getAttribute('data-' + key) || '—';

        document.getElementById('modalLeadId').textContent = 'Lead #' + get('lead-id');
        document.getElementById('modalName').textContent = get('name');
        document.getElementById('modalPhone').textContent = get('phone');
        document.getElementById('modalEmail').textContent = get('email');
        document.getElementById('modalLocation').textContent =
            [get('city'), get('state')].filter(v => v && v !== '—').join(', ') || 'Not specified';
        document.getElementById('modalCollege').textContent = get('college');
        document.getElementById('modalCourse').textContent = get('course');
        document.getElementById('modalSpecialization').textContent = get('specialization');
        document.getElementById('modalMode').textContent = get('mode');
        document.getElementById('modalSource').textContent = get('source');
        document.getElementById('modalStatus').textContent = get('status');
        document.getElementById('modalFollowup').textContent = get('followup');
        document.getElementById('modalAssigned').textContent = get('assigned');
        document.getElementById('modalMessage').textContent = get('message');
    });
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\GrowPec\resources\views/admin/leads/index.blade.php ENDPATH**/ ?>