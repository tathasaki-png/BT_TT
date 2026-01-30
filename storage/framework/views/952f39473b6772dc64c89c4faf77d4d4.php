

<?php $__env->startSection('content'); ?>
<?php $__env->startPush('styles'); ?>
<style>
    .auth-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        background-color: #0b0f1a;
        position: relative;
        overflow: hidden;
    }

    .auth-page::before {
        content: "";
        position: absolute;
        top: -10%;
        left: -10%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, var(--primary-color) 0%, transparent 70%);
        opacity: 0.15;
        filter: blur(80px);
    }

    .register-card {
        display: flex;
        width: 100%;
        max-width: 900px;
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 32px;
        overflow: hidden;
        box-shadow: 0 40px 100px rgba(0, 0, 0, 0.5);
        z-index: 1;
        min-height: 600px;
    }

    .register-left {
        background: linear-gradient(135deg, #1e1b4b 0%, #0f172a 100%);
        color: white;
        padding: 48px;
        width: 40%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        border-right: 1px solid var(--glass-border);
        position: relative;
    }

    .register-left::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 200px;
        background: linear-gradient(to top, rgba(99, 102, 241, 0.05), transparent);
    }

    .register-left .icon {
        width: 56px;
        height: 56px;
        background: rgba(99, 102, 241, 0.1);
        border: 1px solid var(--primary-glow);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: var(--primary-color);
        margin-bottom: 24px;
    }

    .register-right {
        padding: 48px;
        width: 60%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .register-right .form-label {
        color: var(--text-muted);
        font-family: 'Outfit';
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .register-right .form-control {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--glass-border);
        color: white;
        height: 50px;
        border-radius: 12px;
        padding: 0 16px;
        transition: all 0.3s;
    }

    .register-right .form-control:focus {
        background: rgba(255, 255, 255, 0.06);
        border-color: var(--primary-color);
        box-shadow: 0 0 15px var(--primary-glow);
    }

    @media (max-width: 900px) {
        .register-card {
            flex-direction: column;
            max-width: 500px;
        }

        .register-left,
        .register-right {
            width: 100%;
            padding: 40px;
        }

        .register-left {
            border-right: none;
            border-bottom: 1px solid var(--glass-border);
            min-height: auto;
        }
    }
</style>

<div class="auth-page fade-in">
    <div class="register-card">
        <div class="register-left d-none d-md-flex">
            <div class="icon"><i class="fas fa-sparkles"></i></div>
            <h2 class="fw-bold" style="font-family: 'Outfit'; letter-spacing: -1px; line-height: 1.1;">Bắt đầu hành
                trình Aura</h2>
            <p class="text-muted mt-3 mb-4">Gia nhập cộng đồng học tập công nghệ hàng đầu và mở khóa tiềm năng của bạn.
            </p>
            <div class="d-flex flex-column gap-3 mt-2">
                <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-check-circle text-primary"></i>
                    <span class="small text-muted">Hơn 10,000 học viên tin tưởng</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-check-circle text-primary"></i>
                    <span class="small text-muted">Lộ trình học tập cá nhân hóa</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-check-circle text-primary"></i>
                    <span class="small text-muted">Hỗ trợ từ chuyên gia 24/7</span>
                </div>
            </div>
        </div>

        <div class="register-right">
            <h3 class="fw-bold mb-4 text-white" style="font-family: 'Outfit';">Đăng ký thành viên</h3>
            <form method="POST" action="<?php echo e(route('register')); ?>">
                <?php echo csrf_field(); ?>
                <div class="mb-4">
                    <label class="form-label small">HỌ VÀ TÊN</label>
                    <input type="text" name="name" value="<?php echo e(old('name')); ?>" class="form-control"
                        placeholder="Nhập tên đầy đủ" required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-2"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-4">
                    <label class="form-label small">ĐỊA CHỈ EMAIL</label>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" class="form-control"
                        placeholder="aura@learning.com" required>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-2"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label small">MẬT KHẨU</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-2"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label small">XÁC NHẬN</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••"
                            required>
                    </div>
                </div>

                <div class="mb-4 small text-muted" style="font-size: 11px;">Bằng cách đăng ký, bạn đồng ý với Điều khoản
                    và Chính sách của chúng tôi.</div>

                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow-lg"
                    style="font-family: 'Outfit'; letter-spacing: 1px;">ĐĂNG KÝ THAM GIA</button>
            </form>

            <div class="text-center mt-4 small text-muted">Đã có tài khoản? <a href="<?php echo e(route('login.form')); ?>"
                    class="fw-bold text-decoration-none" style="color: var(--primary-color);">Đăng nhập ngay</a></div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\khoahoc\resources\views/auth/register.blade.php ENDPATH**/ ?>