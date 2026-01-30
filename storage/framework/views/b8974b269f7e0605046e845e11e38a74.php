

<?php $__env->startSection('title', 'Quản lý sliders'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Quản Lý Sliders</h1>
        <p class="page-subtitle">Quản lý các hình ảnh trình chiếu trên trang chủ</p>
    </div>
    <a href="<?php echo e(route('admin.sliders.create')); ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Thêm Slider
    </a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4">
        <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Sliders Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-images me-2 text-primary"></i>Danh Sách Sliders</h5>
        <span class="badge bg-primary"><?php echo e($sliders->count()); ?> sliders</span>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th width="100">Hình ảnh</th>
                    <th>Thông tin slider</th>
                    <th>Thứ tự</th>
                    <th>Trạng thái</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <img src="<?php echo e(asset('storage/' . $slider->image)); ?>" alt="Slider" class="rounded" style="width: 90px; height: 55px; object-fit: cover;">
                        </td>
                        <td>
                            <div class="fw-semibold"><?php echo e($slider->title ?? 'Không có tiêu đề'); ?></div>
                            <small class="text-muted d-block"><?php echo e(Str::limit($slider->description, 60)); ?></small>
                            <?php if($slider->link): ?>
                                <small class="text-primary"><i class="fas fa-link me-1"></i><?php echo e($slider->link); ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge bg-secondary"><?php echo e($slider->order); ?></span>
                        </td>
                        <td>
                            <?php if($slider->status): ?>
                                <span class="badge bg-success"><i class="fas fa-eye me-1"></i>Đang hiển thị</span>
                            <?php else: ?>
                                <span class="badge bg-secondary"><i class="fas fa-eye-slash me-1"></i>Đang ẩn</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="<?php echo e(route('admin.sliders.edit', $slider)); ?>" class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?php echo e(route('admin.sliders.destroy', $slider)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa slider này?');">
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
                            <i class="fas fa-image fa-3x mb-3 d-block"></i>
                            <p class="mb-2">Chưa có slider nào</p>
                            <a href="<?php echo e(route('admin.sliders.create')); ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>Thêm slider đầu tiên
                            </a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\khoahoc\resources\views/admin/sliders/index.blade.php ENDPATH**/ ?>