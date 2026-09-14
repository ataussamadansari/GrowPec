
<?php $__env->startSection('title', 'Admin Dashboard - GrowPec'); ?>
<?php $__env->startSection('header', 'Dashboard Overview'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card shadow-sm border-start border-primary border-4">
            <small class="text-muted fw-bold">TOTAL COLLEGES</small>
            <h2 class="fw-bold text-dark mt-1 mb-0"><?php echo e($stats['total_colleges']); ?></h2>
            <small class="text-primary"><?php echo e($stats['regular_colleges']); ?> Regular • <?php echo e($stats['online_colleges']); ?> Online</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card shadow-sm border-start border-warning border-4">
            <small class="text-muted fw-bold">TOTAL LEADS</small>
            <h2 class="fw-bold text-dark mt-1 mb-0"><?php echo e($stats['total_leads']); ?></h2>
            <small class="text-success">+<?php echo e($stats['new_leads_today']); ?> Today</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card shadow-sm border-start border-success border-4">
            <small class="text-muted fw-bold">TOTAL COURSES</small>
            <h2 class="fw-bold text-dark mt-1 mb-0"><?php echo e($stats['total_courses']); ?></h2>
            <small class="text-muted">UG, PG, Diplomas</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card shadow-sm border-start border-info border-4">
            <small class="text-muted fw-bold">QUICK ACTIONS</small>
            <div class="mt-2">
                <a href="<?php echo e(route('admin.colleges.create')); ?>" class="btn btn-warning btn-sm fw-bold w-100 mb-1">+ Add New College</a>
                <a href="<?php echo e(route('admin.leads.export')); ?>" class="btn btn-outline-dark btn-sm fw-bold w-100">📥 Export Leads CSV</a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Leads Table -->
<div class="bg-white p-4 rounded-4 shadow-sm border">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">🔥 Recent Student Inquiries</h5>
        <a href="<?php echo e(route('admin.leads.index')); ?>" class="btn btn-sm btn-outline-primary">View All Leads</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Student Name</th>
                    <th>Phone / WhatsApp</th>
                    <th>College / Course</th>
                    <th>City</th>
                    <th>Status</th>
                    <th>Received</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $recentLeads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="fw-bold"><?php echo e($lead->name); ?></td>
                        <td><a href="https://wa.me/91<?php echo e(preg_replace('/[^0-9]/', '', $lead->phone)); ?>" target="_blank" class="text-success text-decoration-none"><i class="bi bi-whatsapp me-1"></i><?php echo e($lead->phone); ?></a></td>
                        <td><?php echo e($lead->college->name ?? 'General'); ?> <small class="text-muted d-block"><?php echo e($lead->course->name ?? ''); ?></small></td>
                        <td><?php echo e($lead->city ?? 'N/A'); ?></td>
                        <td>
                            <span class="badge bg-<?php echo e($lead->status == 'new' ? 'danger' : ($lead->status == 'admitted' ? 'success' : 'warning')); ?>-subtle text-dark">
                                <?php echo e(strtoupper($lead->status)); ?>

                            </span>
                        </td>
                        <td><small class="text-muted"><?php echo e($lead->created_at->diffForHumans()); ?></small></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center py-3 text-muted">No student inquiries received yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\GrowPec\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>