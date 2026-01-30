

<?php $__env->startSection('title', 'Xác thực OTP'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-envelope-open-text fa-2x"></i>
                        </div>
                        <h2 class="fw-bold">Xác thực Email</h2>
                        <p class="text-muted">Chúng tôi đã gửi mã xác thực gồm 6 chữ số đến email: <br><strong><?php echo e($email); ?></strong></p>
                    </div>

                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('verify.otp')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="email" value="<?php echo e($email); ?>">
                        
                        <div class="mb-4">
                            <label for="otp" class="form-label fw-semibold">Mã OTP</label>
                            <input type="text" 
                                   name="otp" 
                                   class="form-control form-control-lg text-center fw-bold <?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="otp" 
                                   placeholder="000000" 
                                   maxlength="6" 
                                   autofocus
                                   required>
                            <?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="form-text mt-2 text-center">
                                Vui lòng nhập mã OTP để hoàn tất đăng ký.
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg py-3 fw-bold">
                                Xác thực tài khoản
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="mb-2 text-muted">Bạn không nhận được mã?</p>
                        <form action="<?php echo e(route('resend.otp')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="email" value="<?php echo e($email); ?>">
                            <button type="submit" class="btn btn-link link-primary p-0 text-decoration-none">
                                Gửi lại mã OTP
                            </button>
                        </form>
                    </div>

                    <div class="text-center mt-4 text-muted small">
                        <a href="<?php echo e(route('register.form')); ?>" class="text-decoration-none">
                            <i class="fas fa-arrow-left me-1"></i> Quay lại trang đăng ký
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #otp {
        letter-spacing: 0.5rem;
        font-size: 2rem;
    }
    #otp::placeholder {
        letter-spacing: normal;
        font-size: 1.25rem;
        opacity: 0.3;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\TTS\khoahoc\resources\views/auth/verify.blade.php ENDPATH**/ ?>