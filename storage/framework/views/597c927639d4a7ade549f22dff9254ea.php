

<?php $__env->startSection('title', 'Quản lý danh mục'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Quản Lý Danh Mục</h1>
        <p class="page-subtitle">Quản lý tất cả danh mục khóa học trong hệ thống</p>
    </div>
    <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Thêm Danh Mục
    </a>
</div>

<!-- Categories Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-folder me-2 text-primary"></i>Danh Sách Danh Mục</h5>
        <span class="badge bg-primary"><?php echo e($categories->total() ?? $categories->count()); ?> danh mục</span>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th width="80">ID</th>
                    <th>Tên danh mục</th>
                    <th>Slug</th>
                    <th>Số khóa học</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><span class="fw-semibold">#<?php echo e($category->id); ?></span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="stats-icon primary me-3" style="width: 40px; height: 40px; font-size: 16px;">
                                    <i class="fas fa-folder"></i>
                                </div>
                                <span class="fw-semibold"><?php echo e($category->name); ?></span>
                            </div>
                        </td>
                        <td><code class="text-muted bg-light px-2 py-1 rounded"><?php echo e($category->slug); ?></code></td>
                        <td>
                            <span class="badge bg-info"><?php echo e($category->courses_count ?? 0); ?> khóa học</span>
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-sm btn-outline-danger" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-folder-open fa-3x mb-3 d-block"></i>
                            <p class="mb-2">Chưa có danh mục nào</p>
                            <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>Thêm danh mục đầu tiên
                            </a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($categories->hasPages()): ?>
    <div class="card-footer bg-transparent d-flex justify-content-center">
        <?php echo e($categories->withQueryString()->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\khoahoc\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>