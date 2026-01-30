

<?php $__env->startSection('title', 'Quản lý người dùng'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Quản Lý Người Dùng</h1>
        <p class="page-subtitle">Quản lý tài khoản học viên, giảng viên và quản trị viên</p>
    </div>
    <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Thêm Người Dùng
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form action="<?php echo e(route('admin.users.index')); ?>" method="GET" class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-transparent"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="q" class="form-control" placeholder="Tìm theo tên hoặc email..." value="<?php echo e(request('q')); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <select name="role" class="form-select">
                    <option value="">Tất cả vai trò</option>
                    <option value="student" <?php echo e(request('role') == 'student' ? 'selected' : ''); ?>>Học viên</option>
                    <option value="instructor" <?php echo e(request('role') == 'instructor' ? 'selected' : ''); ?>>Giảng viên</option>
                    <option value="admin" <?php echo e(request('role') == 'admin' ? 'selected' : ''); ?>>Quản trị viên</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Tất cả trạng thái</option>
                    <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Đang hoạt động</option>
                    <option value="blocked" <?php echo e(request('status') == 'blocked' ? 'selected' : ''); ?>>Bị khóa</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="fas fa-filter me-1"></i>Lọc
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-users me-2 text-primary"></i>Danh Sách Người Dùng</h5>
        <span class="badge bg-primary"><?php echo e($users->total() ?? $users->count()); ?> người dùng</span>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Người dùng</th>
                    <th>Vai trò</th>
                    <th>Trạng thái</th>
                    <th>Ngày tham gia</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3">
                                    <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                                </div>
                                <div>
                                    <div class="fw-semibold"><?php echo e($user->name); ?></div>
                                    <small class="text-muted"><?php echo e($user->email); ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php if($user->role === 'admin'): ?>
                                <span class="badge bg-danger">Quản trị viên</span>
                            <?php elseif($user->role === 'instructor'): ?>
                                <span class="badge bg-info">Giảng viên</span>
                            <?php else: ?>
                                <span class="badge bg-primary">Học viên</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($user->status === 'active'): ?>
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>Hoạt động
                                </span>
                            <?php else: ?>
                                <span class="badge bg-secondary">
                                    <i class="fas fa-ban me-1"></i>Bị khóa
                                </span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($user->created_at->format('d/m/Y')); ?></td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form action="<?php echo e(route('admin.users.toggleStatus', $user)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <button type="submit" class="btn btn-sm <?php echo e($user->status === 'active' ? 'btn-outline-warning' : 'btn-outline-success'); ?>" 
                                            title="<?php echo e($user->status === 'active' ? 'Khóa tài khoản' : 'Mở khóa'); ?>">
                                        <i class="fas fa-<?php echo e($user->status === 'active' ? 'lock' : 'lock-open'); ?>"></i>
                                    </button>
                                </form>

                                <?php if($user->id !== auth()->id()): ?>
                                <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-users fa-3x mb-3 d-block"></i>
                            <p class="mb-0">Không tìm thấy người dùng nào</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($users->hasPages()): ?>
    <div class="card-footer bg-transparent d-flex justify-content-center">
        <?php echo e($users->withQueryString()->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\khoahoc\resources\views/admin/users/index.blade.php ENDPATH**/ ?>