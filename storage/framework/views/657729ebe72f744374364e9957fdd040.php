

<?php $__env->startPush('styles'); ?>
<style>
    .auth-page { min-height:70vh; display:flex; align-items:center; justify-content:center; padding:32px 12px; background: linear-gradient(180deg, #f6fff7 0%, #eefef1 100%); background-attachment: fixed; }

    .auth-page::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'><g fill='%23124727' fill-opacity='0.03'><rect width='40' height='40'/><rect x='40' y='40' width='40' height='40'/></g></svg>");
        background-repeat: repeat;
        pointer-events: none;
    }

    .auth-page .login-card {
        width: 420px;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(9,38,20,0.12);
        background: #ffffff;
        margin: 0 auto;
    }

    .auth-page .auth-header {
        height: 160px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 8px;
        text-align: center;
        padding: 18px 16px;
    }

    .auth-header .brand-icon { width:64px; height:64px; display:flex; align-items:center; justify-content:center; background: rgba(255,255,255,0.12); border-radius:12px; }
    .auth-header h3 { margin:0; font-size:20px; font-weight:700; }
    .auth-header p { margin:0; font-size:13px; opacity:0.95; }

    .auth-page .auth-body { padding: 22px; }
    .auth-page .form-group { margin-bottom:14px; }
    .auth-page .input-with-icon { position:relative; }
    .auth-page .input-with-icon .icon { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94b99c; }
    .auth-page .input-with-icon input { padding-left:42px; height:46px; border-radius:10px; border:1px solid #eef5ec; background:#fbfffb; }

    .auth-page .form-check { display:flex; align-items:center; gap:8px; }

    .auth-page .btn-gradient { background: linear-gradient(90deg, var(--primary-color), var(--primary-hover)); color: white; border: none; border-radius:10px; padding:12px 18px; font-weight:700; }

    .auth-page .auth-footer { padding:14px 22px 22px; text-align:center; font-size:13px; }

    @media (max-width: 520px) {
        .auth-page .login-card { width: 92%; }
        .auth-page .auth-header { height:140px; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-page" style="position:relative;">
    <div style="display:flex; align-items:center; justify-content:center; padding:48px 12px;">
        <div class="login-card">
            <div class="auth-header">
                <div class="brand-icon"><i class="fas fa-book-open fa-lg"></i></div>
                <h3>Chào Mừng Trở Lại!</h3>
                <p>Đăng nhập để tiếp tục hành trình của bạn</p>
            </div>

            <div class="auth-body">
                <form method="POST" action="<?php echo e(route('login')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="form-group input-with-icon">
                        <span class="icon"><i class="fas fa-user"></i></span>
                        <input type="text" name="name" value="<?php echo e(old('name', 'admin')); ?>" class="form-control" placeholder="Email hoặc Tên đăng nhập" required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group input-with-icon">
                        <span class="icon"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label small" for="remember">Ghi nhớ đăng nhập</label>
                        </div>
                        <a href="#" class="small" style="color:var(--primary-color);">Quên mật khẩu?</a>
                    </div>

                    <button type="submit" class="btn-gradient w-100">Đăng Nhập</button>

                    <div class="auth-footer">
                        <div class="small">Chưa có tài khoản? <a href="<?php echo e(route('register.form')); ?>" class="fw-bold" style="color:var(--primary-color);">Đăng ký ngay</a></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\TTS\khoahoc\resources\views/auth/login.blade.php ENDPATH**/ ?>