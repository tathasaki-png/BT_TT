

<?php $__env->startSection('title', 'Bảng điều khiển'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Bảng Điều Khiển</h1>
        <p class="page-subtitle">Chào mừng trở lại, <?php echo e(Auth::user()->name); ?>! Đây là tổng quan hệ thống của bạn.</p>
    </div>
    <div>
        <span class="text-muted"><i class="fas fa-calendar me-2"></i><?php echo e(now()->format('d/m/Y')); ?></span>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="stats-card">
            <div class="d-flex align-items-center justify-content-between">
                <div class="stats-icon primary">
                    <i class="fas fa-users"></i>
                </div>
                <span class="badge bg-success">+12%</span>
            </div>
            <div class="stats-value"><?php echo e(number_format($totalUsers)); ?></div>
            <div class="stats-label">Tổng Người Dùng</div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stats-card">
            <div class="d-flex align-items-center justify-content-between">
                <div class="stats-icon info">
                    <i class="fas fa-book"></i>
                </div>
                <span class="badge bg-info"><?php echo e($totalCourses > 0 ? '+'.rand(1,10).'%' : '0'); ?></span>
            </div>
            <div class="stats-value"><?php echo e(number_format($totalCourses)); ?></div>
            <div class="stats-label">Tổng Khóa Học</div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stats-card">
            <div class="d-flex align-items-center justify-content-between">
                <div class="stats-icon warning">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <span class="badge bg-warning"><?php echo e($totalOrders > 0 ? '+'.rand(5,20).'%' : '0'); ?></span>
            </div>
            <div class="stats-value"><?php echo e(number_format($totalOrders)); ?></div>
            <div class="stats-label">Tổng Đơn Hàng</div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stats-card">
            <div class="d-flex align-items-center justify-content-between">
                <div class="stats-icon danger">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <span class="badge bg-danger">+<?php echo e(rand(10,30)); ?>%</span>
            </div>
            <div class="stats-value"><?php echo e((int) $totalRevenue); ?> VND</div>
            <div class="stats-label">Doanh Thu</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Orders -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-receipt me-2 text-primary"></i>Đơn Hàng Gần Đây</h5>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-sm btn-outline-primary">
                    Xem tất cả <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mã ĐH</th>
                            <th>Khách Hàng</th>
                            <th>Số Lượng</th>
                            <th>Tổng Tiền</th>
                            <th>Trạng Thái</th>
                            <th>Ngày Đặt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <span class="fw-semibold">#<?php echo e(str_pad($order->id, 5, '0', STR_PAD_LEFT)); ?></span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-2" style="width: 32px; height: 32px; font-size: 12px;">
                                            <?php echo e(strtoupper(substr($order->user->name, 0, 1))); ?>

                                        </div>
                                        <span><?php echo e($order->user->name); ?></span>
                                    </div>
                                </td>
                                <td><?php echo e($order->items->count()); ?> khóa học</td>
                                <td class="fw-semibold"><?php echo e((int) $order->total_price); ?> VND</td>
                                <td>
                                    <?php if($order->status === 'completed'): ?>
                                        <span class="badge bg-success">Hoàn thành</span>
                                    <?php elseif($order->status === 'pending'): ?>
                                        <span class="badge bg-warning">Chờ xử lý</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Đã hủy</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($order->created_at->format('d/m/Y')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    Chưa có đơn hàng nào
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Top Courses & Quick Actions -->
    <div class="col-lg-4">
        <!-- Top Courses -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-fire me-2 text-danger"></i>Khóa Học Phổ Biến</h5>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <?php $__empty_1 = true; $__currentLoopData = $topCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-3 py-3">
                            <div class="d-flex align-items-center">
                                <img src="<?php echo e($course->thumbnail ? asset('storage/' . $course->thumbnail) : asset('products/course' . (($course->id % 5) + 1) . '.jpg')); ?>" 
                                     class="rounded me-3" width="45" height="45" style="object-fit: cover;" alt="">
                                <div>
                                    <div class="fw-semibold" style="font-size: 14px;"><?php echo e(Str::limit($course->title, 20)); ?></div>
                                    <small class="text-muted"><?php echo e($course->instructor->name ?? 'N/A'); ?></small>
                                </div>
                            </div>
                            <a href="<?php echo e(route('admin.courses.students', $course)); ?>" class="text-decoration-none">
                                <span class="badge bg-primary"><?php echo e($course->students_count); ?> HV</span>
                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li class="list-group-item text-center py-4 text-muted">
                            Chưa có dữ liệu
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="card-footer bg-transparent text-center">
                <a href="<?php echo e(route('admin.courses.index')); ?>" class="text-decoration-none fw-semibold" style="font-size: 14px;">
                    Quản lý khóa học <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bolt me-2 text-warning"></i>Thao Tác Nhanh</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?php echo e(route('admin.courses.create')); ?>" class="btn btn-outline-primary">
                        <i class="fas fa-plus me-2"></i>Thêm khóa học mới
                    </a>
                    <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-outline-primary">
                        <i class="fas fa-folder-plus me-2"></i>Thêm danh mục
                    </a>
                    <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-outline-primary">
                        <i class="fas fa-user-plus me-2"></i>Thêm người dùng
                    </a>
                    <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-list me-2"></i>Xem đơn hàng
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\TTS\khoahoc\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>