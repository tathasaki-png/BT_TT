

<?php $__env->startSection('content'); ?>
<?php $__env->startPush('styles'); ?>
<style>
    .orders-header {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.05));
        border-bottom: 1px solid var(--glass-border);
        padding: 40px 0;
        margin-bottom: 32px;
    }

    .table-aura {
        color: white;
        background: transparent;
    }

    .table-aura thead th {
        border-bottom: 2px solid var(--glass-border);
        color: var(--text-muted);
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1.5px;
        padding: 16px;
    }

    .table-aura tbody td {
        border-bottom: 1px solid var(--glass-border);
        padding: 20px 16px;
        vertical-align: middle;
    }

    .order-status-badge {
        font-size: 11px;
        padding: 6px 14px;
        border-radius: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>
<?php $__env->stopPush(); ?>

<div class="orders-header fade-in">
    <div class="container">
        <h2 style="font-family: 'Outfit'; font-weight: 800; color: white; margin: 0;">
            <i class="fas fa-history me-3 text-primary"></i>Lịch Sử <span style="color: var(--primary-color)">Đơn Hàng</span>
        </h2>
        <p class="text-muted mt-2 mb-0">Theo dõi toàn bộ các giao dịch và khóa học bạn đã đăng ký</p>
    </div>
</div>

<div class="container pb-5">
    <div class="glass p-0 overflow-hidden" style="border-radius: 24px;">
        <div class="table-responsive">
            <table class="table table-aura mb-0">
                <thead>
                    <tr>
                        <th>MÃ ĐƠN HÀNG</th>
                        <th>THỜI GIAN</th>
                        <th>CÁC KHÓA HỌC</th>
                        <th>TỔNG CỘNG</th>
                        <th>THANH TOÁN</th>
                        <th>TRẠNG THÁI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="fw-bold text-white">#<?php echo e(str_pad($order->id, 5, '0', STR_PAD_LEFT)); ?></td>
                            <td class="text-muted" style="font-size: 13px;"><?php echo e($order->created_at->format('d/m/Y H:i')); ?></td>
                            <td>
                                <div style="max-width: 300px;">
                                    <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="text-white small mb-1">
                                            <i class="fas fa-check-circle text-primary me-2" style="font-size: 10px;"></i><?php echo e($item->course->title); ?>

                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </td>
                            <td class="text-primary fw-bold"><?php echo e((int) $order->total_price); ?> VND</td>
                            <td>
                                <?php if($order->payment_method === 'cod' && in_array($order->status, ['awaiting', 'pending'])): ?>
                                    <form action="<?php echo e(route('orders.change-payment-method', $order->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-sm glass py-2 px-3" style="color: var(--primary-color); border-color: rgba(99, 102, 241, 0.3); font-size: 11px; font-weight: 700;">
                                            <i class="fas fa-credit-card me-2"></i>SANG VNPAY
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-muted small text-uppercase fw-bold"><?php echo e($order->payment_method); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php switch($order->status):
                                    case ('awaiting'): ?>
                                        <span class="badge glass" style="color: #94a3b8; border-color: rgba(148, 163, 184, 0.3);">CHỜ XÁC NHẬN</span>
                                        <?php break; ?>
                                    <?php case ('pending'): ?>
                                        <span class="badge glass" style="color: #f59e0b; border-color: rgba(245, 158, 11, 0.3);">ĐANG XỬ LÝ</span>
                                        <?php break; ?>
                                    <?php case ('shipping'): ?>
                                        <span class="badge glass" style="color: #3b82f6; border-color: rgba(59, 130, 246, 0.3);">ĐANG GIAO</span>
                                        <?php break; ?>
                                    <?php case ('completed'): ?>
                                        <span class="badge glass" style="color: #10b981; border-color: rgba(16, 185, 129, 0.3);">HOÀN TẤT</span>
                                        <?php break; ?>
                                    <?php default: ?>
                                        <span class="badge glass" style="color: #ef4444; border-color: rgba(239, 68, 68, 0.3);">HỦY BỎ</span>
                                <?php endswitch; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-4">
                                    <i class="fas fa-shopping-bag fa-3x text-muted mb-4 opacity-25"></i>
                                    <h5 class="text-white">Chưa có giao dịch nào</h5>
                                    <p class="text-muted mb-4">Bạn chưa thực hiện bất kỳ giao dịch nào trên hệ thống.</p>
                                    <a href="<?php echo e(route('home')); ?>" class="btn-aura px-4">BẮT ĐẦU HỌC TẬP</a>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if($orders->hasPages()): ?>
        <div class="mt-5">
            <?php echo e($orders->links()); ?>

        </div>
    <?php endif; ?>

    <div class="mt-5 text-center">
        <a href="<?php echo e(route('profile.show')); ?>" class="btn btn-link text-muted text-decoration-none small fw-bold">
            <i class="fas fa-arrow-left me-2"></i> QUAY LẠI TRANG CÁ NHÂN
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\khoahoc\resources\views/orders.blade.php ENDPATH**/ ?>