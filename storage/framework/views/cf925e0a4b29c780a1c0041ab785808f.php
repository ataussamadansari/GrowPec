
<?php $__env->startSection('title', 'Leads CRM - GrowPec'); ?>
<?php $__env->startSection('header', 'Student Leads Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white p-4 rounded-4 shadow-sm border">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <form action="<?php echo e(route('admin.leads.index')); ?>" method="GET" class="d-flex gap-2">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control form-control-sm" placeholder="Search by name, phone, city...">
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <?php $__currentLoopData = ['new', 'contacted', 'counseling', 'admitted', 'closed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($st); ?>" <?php echo e(request('status') == $st ? 'selected' : ''); ?>><?php echo e(ucfirst($st)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button type="submit" class="btn btn-sm btn-dark">Filter</button>
        </form>

        <a href="<?php echo e(route('admin.leads.export')); ?>" class="btn btn-sm btn-success fw-bold">
            <i class="bi bi-file-earmark-spreadsheet me-1"></i> Export to Excel (CSV)
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Phone / WhatsApp</th>
                    <th>City</th>
                    <th>Target College</th>
                    <th>Status</th>
                    <th>Update Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($lead->id); ?></td>
                        <td class="fw-bold"><?php echo e($lead->name); ?> <small class="text-muted d-block"><?php echo e($lead->email); ?></small></td>
                        <td>
                            <a href="https://wa.me/91<?php echo e(preg_replace('/[^0-9]/', '', $lead->phone)); ?>" target="_blank" class="btn btn-sm btn-outline-success py-0 px-2">
                                <i class="bi bi-whatsapp me-1"></i><?php echo e($lead->phone); ?>

                            </a>
                        </td>
                        <td><?php echo e($lead->city ?? 'N/A'); ?></td>
                        <td><?php echo e($lead->college->name ?? 'General Inquiry'); ?></td>
                        <td>
                            <span class="badge bg-<?php echo e($lead->status == 'new' ? 'danger' : ($lead->status == 'admitted' ? 'success' : 'warning')); ?>">
                                <?php echo e(strtoupper($lead->status)); ?>

                            </span>
                        </td>
                        <td>
                            <form action="<?php echo e(route('admin.leads.updateStatus', $lead->id)); ?>" method="POST" class="d-flex gap-1">
                                <?php echo csrf_field(); ?>
                                <select name="status" class="form-select form-select-sm" style="width: 120px;" onchange="this.form.submit()">
                                    <?php $__currentLoopData = ['new', 'contacted', 'counseling', 'admitted', 'closed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($st); ?>" <?php echo e($lead->status == $st ? 'selected' : ''); ?>><?php echo e(ucfirst($st)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No leads found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        <?php echo e($leads->links('pagination::bootstrap-5')); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\GrowPec\resources\views/admin/leads/index.blade.php ENDPATH**/ ?>