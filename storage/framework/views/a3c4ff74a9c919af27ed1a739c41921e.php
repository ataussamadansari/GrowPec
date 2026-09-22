<?php $__env->startSection('title', 'Manage Streams - GrowPec Admin'); ?>
<?php $__env->startSection('header', 'Manage Academic Streams'); ?>

<?php $__env->startSection('content'); ?>

<style>
    .streams-page {
        --gp-navy: #002B67;
        --gp-navy-dark: #001B45;
        --gp-blue: #174B8F;
        --gp-green: #008A43;
        --gp-green-dark: #006B35;
        --gp-gold: #D9A400;
        --gp-border: #E5EAF0;
        --gp-text: #172033;
        --gp-muted: #718096;
    }

    .streams-hero {
        position: relative;
        overflow: hidden;
        margin-bottom: 18px;
        padding: 21px 23px;
        border-radius: 18px;
        color: #fff;
        background: linear-gradient(135deg, var(--gp-navy-dark), var(--gp-navy) 62%, var(--gp-blue));
        box-shadow: 0 10px 28px rgba(0,43,103,.11);
    }

    .streams-hero::after {
        content: "";
        position: absolute;
        width: 175px;
        height: 175px;
        right: -60px;
        top: -90px;
        border-radius: 50%;
        background: rgba(255,255,255,.07);
    }

    .streams-hero-content {
        position: relative;
        z-index: 1;
    }

    .streams-hero-icon {
        width: 45px;
        height: 45px;
        flex: 0 0 45px;
        margin-right: 12px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,.12);
        font-size: 1.15rem;
    }

    .streams-hero h3 {
        margin: 0 0 4px;
        font-size: 1.16rem;
        font-weight: 800;
    }

    .streams-hero p {
        margin: 0;
        color: rgba(255,255,255,.73);
        font-size: .79rem;
    }

    .streams-panel {
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--gp-border);
        border-radius: 18px;
        box-shadow: 0 5px 18px rgba(15,35,65,.05);
    }

    .streams-toolbar {
        padding: 15px 17px;
        background: #fff;
        border-bottom: 1px solid var(--gp-border);
    }

    .toolbar-form {
        min-width: 0;
    }

    .search-wrap {
        position: relative;
        min-width: 230px;
    }

    .search-wrap .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        z-index: 2;
        transform: translateY(-50%);
        color: #98A2B3;
        pointer-events: none;
    }

    .search-wrap input {
        width: 100%;
        height: 40px;
        padding: 0 12px 0 37px;
        border: 1px solid #D8DEE8;
        border-radius: 10px;
        color: var(--gp-text);
        font-size: .79rem;
        box-shadow: none;
    }

    .search-wrap input:focus {
        border-color: var(--gp-blue);
        box-shadow: 0 0 0 3px rgba(23,75,143,.09);
    }

    .stream-search-btn,
    .add-stream-btn {
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        white-space: nowrap;
        font-size: .76rem;
        font-weight: 800;
    }

    .stream-search-btn {
        min-width: 82px;
        padding: 0 13px;
    }

    .clear-search-btn {
        min-width: 40px;
        padding: 0 11px;
    }

    .add-stream-btn {
        min-width: 148px;
        padding: 0 15px;
        border: 0;
        background: var(--gp-gold);
        color: #1B1B1B;
        box-shadow: 0 5px 13px rgba(217,164,0,.16);
    }

    .add-stream-btn:hover {
        background: #C89400;
        color: #111;
    }

    .streams-table {
        min-width: 760px;
        margin: 0;
    }

    .streams-table thead th {
        padding: 12px 17px;
        background: #F8FAFC;
        border-bottom: 1px solid var(--gp-border);
        color: #667085;
        font-size: .66rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .045em;
        white-space: nowrap;
    }

    .streams-table tbody td {
        padding: 13px 17px;
        border-color: #EEF2F6;
        color: var(--gp-text);
        font-size: .8rem;
        vertical-align: middle;
    }

    .streams-table tbody tr {
        transition: background .16s ease;
    }

    .streams-table tbody tr:hover {
        background: #FBFCFE;
    }

    .stream-id {
        color: #98A2B3;
        font-size: .73rem;
        font-weight: 750;
    }

    .stream-name-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 210px;
    }

    .stream-avatar {
        width: 36px;
        height: 36px;
        flex: 0 0 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #EAF1FA;
        color: var(--gp-blue);
        font-size: .92rem;
    }

    .stream-name {
        color: var(--gp-text);
        font-weight: 750;
        line-height: 1.35;
    }

    .stream-slug {
        display: inline-block;
        max-width: 190px;
        overflow: hidden;
        padding: 5px 8px;
        border: 1px solid #E6EAF0;
        border-radius: 7px;
        background: #F6F8FA;
        color: #596579;
        font-size: .68rem;
        text-overflow: ellipsis;
        vertical-align: middle;
        white-space: nowrap;
    }


    .stream-icon-cell {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 5px 8px;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        background: #FAFBFC;
        color: var(--gp-blue);
        white-space: nowrap;
    }

    .stream-icon-cell i {
        font-size: .9rem;
    }

    .stream-icon-cell code {
        color: #667085;
        font-size: .62rem;
    }

    .course-count {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 9px;
        border: 1px solid #D9E7F7;
        border-radius: 999px;
        background: #EDF4FC;
        color: var(--gp-blue);
        font-size: .66rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .action-group {
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .action-btn {
        width: 35px;
        height: 35px;
        padding: 0;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: .78rem;
        transition: all .16s ease;
    }

    .edit-action {
        color: var(--gp-blue);
        border-color: #BFD2E8;
        background: #F7FAFE;
    }

    .edit-action:hover {
        color: #fff;
        border-color: var(--gp-blue);
        background: var(--gp-blue);
    }

    .delete-action {
        color: #C92A2A;
        border-color: #F0C5C5;
        background: #FFF9F9;
    }

    .delete-action:hover {
        color: #fff;
        border-color: #C92A2A;
        background: #C92A2A;
    }

    .pagination-wrap {
        padding: 14px 17px;
        border-top: 1px solid var(--gp-border);
        background: #fff;
    }

    .pagination-wrap .pagination {
        margin-bottom: 0;
    }

    .pagination-wrap .page-link {
        border-radius: 8px;
        margin: 0 2px;
        color: var(--gp-blue);
        border-color: #E0E6ED;
        font-size: .75rem;
    }

    .pagination-wrap .page-item.active .page-link {
        background: var(--gp-navy);
        border-color: var(--gp-navy);
        color: #fff;
    }

    .empty-streams {
        padding: 45px 20px !important;
        text-align: center;
        color: var(--gp-muted);
    }

    .empty-icon {
        width: 54px;
        height: 54px;
        margin: 0 auto 11px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #F1F5F9;
        color: #94A3B8;
        font-size: 1.2rem;
    }

    @media (max-width: 767.98px) {
        .streams-hero {
            margin-bottom: 14px;
            padding: 18px;
            border-radius: 15px;
        }

        .streams-hero-icon {
            width: 41px;
            height: 41px;
            flex-basis: 41px;
            margin-right: 10px;
        }

        .streams-hero h3 {
            font-size: 1.02rem;
        }

        .streams-hero p {
            font-size: .71rem;
            line-height: 1.45;
        }

        .streams-panel {
            border-radius: 15px;
        }

        .streams-toolbar {
            padding: 12px;
        }

        .toolbar-form {
            width: 100%;
            display: flex;
            gap: 7px !important;
        }

        .search-wrap {
            min-width: 0;
            flex: 1 1 auto;
        }

        .search-wrap input {
            height: 42px;
            font-size: .76rem;
        }

        .stream-search-btn {
            height: 42px;
            min-width: 43px;
            padding: 0 10px;
        }

        .stream-search-btn .search-text,
        .clear-search-btn .clear-text {
            display: none;
        }

        .stream-search-btn i,
        .clear-search-btn i {
            margin: 0 !important;
        }

        .add-stream-btn {
            width: 100%;
            height: 42px;
            margin-top: 8px;
        }

        .streams-table thead th,
        .streams-table tbody td {
            padding: 11px 12px;
        }

        .streams-table {
            min-width: 700px;
        }

        .action-btn {
            width: 34px;
            height: 34px;
        }

        .pagination-wrap {
            padding: 12px;
        }
    }
</style>

<div class="streams-page">

    <div class="streams-hero">
        <div class="streams-hero-content">
            <div class="d-flex align-items-center">
                <span class="streams-hero-icon">
                    <i class="bi bi-diagram-3-fill"></i>
                </span>
                <div>
                    <h3>Academic Streams</h3>
                    <p>Manage the academic categories used across GrowPec courses and colleges.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="streams-panel">

        <div class="streams-toolbar">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                <form action="<?php echo e(route('admin.streams.index')); ?>"
                      method="GET"
                      class="toolbar-form d-flex gap-2 flex-grow-1">

                    <div class="search-wrap flex-grow-1">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text"
                               name="search"
                               value="<?php echo e(request('search')); ?>"
                               class="form-control"
                               placeholder="Search stream name..."
                               aria-label="Search stream name">
                    </div>

                    <button type="submit" class="btn btn-dark stream-search-btn">
                        <i class="bi bi-search me-1"></i><span class="search-text">Search</span>
                    </button>

                    <?php if(request('search')): ?>
                        <a href="<?php echo e(route('admin.streams.index')); ?>"
                           class="btn btn-light border stream-search-btn d-flex align-items-center">
                            <i class="bi bi-x-lg me-1"></i><span class="clear-text">Clear</span>
                        </a>
                    <?php endif; ?>
                </form>

                <a href="<?php echo e(route('admin.streams.create')); ?>"
                   class="btn btn-warning add-stream-btn">
                    <i class="bi bi-plus-lg me-1"></i>
                    Add New Stream
                </a>

            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle streams-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Stream Name</th>
                        <th>Slug</th>
                        <th>Total Courses</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $streams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <span class="stream-id">#<?php echo e($st->id); ?></span>
                            </td>

                            <td>
                                <div class="stream-name-wrap">
                                    <div class="stream-avatar" title="<?php echo e($st->icon ?: 'bi-diagram-3-fill'); ?>">
                                        <i class="bi <?php echo e($st->icon ?: 'bi-diagram-3-fill'); ?>"></i>
                                    </div>
                                    <span class="stream-name"><?php echo e($st->name); ?></span>
                                </div>
                            </td>

                            <td>
                                <code class="stream-slug"><?php echo e($st->slug); ?></code>
                            </td>

                            <td>
                                <span class="course-count">
                                    <i class="bi bi-book-half"></i>
                                    <?php echo e($st->courses_count); ?> Courses
                                </span>
                            </td>

                            <td>
                                <div class="action-group">
                                    <a href="<?php echo e(route('admin.streams.edit', $st->id)); ?>"
                                       class="btn btn-sm action-btn edit-action"
                                       title="Edit Stream"
                                       aria-label="Edit Stream">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="<?php echo e(route('admin.streams.destroy', $st->id)); ?>"
                                          method="POST"
                                          class="m-0"
                                          onsubmit="return confirm('Delete this stream?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>

                                        <button type="submit"
                                                class="btn btn-sm action-btn delete-action"
                                                title="Delete Stream"
                                                aria-label="Delete Stream">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="empty-streams">
                                <div class="empty-icon">
                                    <i class="bi bi-diagram-3"></i>
                                </div>
                                <div class="fw-semibold">No streams found</div>
                                <small>
                                    <?php if(request('search')): ?>
                                        Try a different search term.
                                    <?php else: ?>
                                        Add your first academic stream to get started.
                                    <?php endif; ?>
                                </small>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($streams->hasPages()): ?>
            <div class="pagination-wrap d-flex justify-content-center">
                <?php echo e($streams->links('pagination::bootstrap-5')); ?>

            </div>
        <?php endif; ?>

    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\GrowPec Version Controll\growpec\resources\views/admin/streams/index.blade.php ENDPATH**/ ?>