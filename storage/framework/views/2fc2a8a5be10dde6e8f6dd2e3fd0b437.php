

<?php $__env->startSection('title', 'Manage Banners - GrowPec Admin'); ?>
<?php $__env->startSection('header', 'Homepage Banners'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white p-4 rounded-4 shadow-sm border">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-images me-1"></i> Banners List</h5>
            <small class="text-muted">Manage background images, display order (index), and active status.</small>
        </div>
        <a href="<?php echo e(route('admin.banners.create')); ?>" class="btn btn-warning btn-sm fw-bold">
            <i class="bi bi-plus-circle-fill me-1"></i> + Upload Banner
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Image Preview</th>
                    <th>Banner Name / Title</th>
                    <th>Order Index</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="width: 180px;">
                        <img src="<?php echo e($banner->image_url); ?>" class="rounded-3 border shadow-sm w-100" style="height: 75px; object-fit: cover;" alt="Banner Preview">
                    </td>
                    <td>
                        <div class="fw-bold text-dark"><?php echo e($banner->title ?: 'Hero Banner #' . $banner->id); ?></div>
                        <small class="text-muted"><?php echo e($banner->created_at->format('d M Y')); ?></small>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border px-3 py-2 fw-bold">
                            Index: <?php echo e($banner->sort_order); ?>

                        </span>
                    </td>
                    <td>
                        <span class="badge bg-<?php echo e($banner->status ? 'success' : 'secondary'); ?>-subtle text-dark">
                            <?php echo e($banner->status ? 'Active' : 'Inactive'); ?>

                        </span>
                    </td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?php echo e(route('admin.banners.edit', $banner->id)); ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="<?php echo e(route('admin.banners.destroy', $banner->id)); ?>" method="POST" onsubmit="return confirm('Delete this banner?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        No banners uploaded yet. Default theme image is active.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        <?php echo e($banners->links('pagination::bootstrap-5')); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\GrowPec\resources\views/admin/banners/index.blade.php ENDPATH**/ ?>