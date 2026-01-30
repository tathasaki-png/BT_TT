

<?php $__env->startPush('styles'); ?>
    <style>
        /* Aura Home Slider */
        .home-slider {
            margin: -40px -40px 60px -40px;
            position: relative;
            overflow: hidden;
            border-radius: 0 0 40px 40px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        .carousel {
            position: relative;
        }

        .carousel-item {
            height: 520px;
            position: relative;
        }

        /* remove the heavy dark overlay so slides remain vivid */
        .carousel-item::before {
            display: none;
        }

        .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center center;
            filter: brightness(0.6) saturate(1.2);
        }

        .carousel-caption {
            text-align: left;
            left: 10%;
            right: 10%;
            bottom: auto;
            top: 50%;
            transform: translateY(-50%);
            max-width: 800px;
            z-index: 5;
            padding: 0;
        }

        .carousel-caption h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 56px;
            font-weight: 800;
            margin-bottom: 24px;
            color: white;
            letter-spacing: -2px;
            line-height: 1;
            text-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            animation: slideInDown 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .carousel-caption p {
            font-size: 20px;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 40px;
            line-height: 1.6;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            animation: slideInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.2s backwards;
        }

        .carousel-caption .btn {
            animation: slideInLeft 0.8s ease-out 0.4s backwards;
            box-shadow: 0 4px 14px rgba(22, 163, 74, 0.4);
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Carousel Controls - clear arrows on both sides */
        .carousel-control-prev,
        .carousel-control-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 50%;
            color: #fff;
            border: none;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
            transition: transform 0.18s ease, background 0.18s ease, opacity 0.18s ease;
            z-index: 12;
            backdrop-filter: blur(6px);
            cursor: pointer;
        }

        .carousel-control-prev {
            left: 18px;
        }

        .carousel-control-next {
            right: 18px;
        }

        .carousel-control-prev i,
        .carousel-control-next i {
            font-size: 20px;
            color: #fff;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            transform: translateY(-50%) scale(1.06);
            background: rgba(255, 255, 255, 0.18);
        }

        .carousel-indicators {
            bottom: 30px;
            margin-bottom: 0;
        }

        .carousel-indicators [data-bs-target] {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin: 0 6px;
            background-color: rgba(255, 255, 255, 0.5);
            border: 2px solid transparent;
            transition: all 0.3s;
        }

        .carousel-indicators .active {
            width: 32px;
            border-radius: 6px;
            background-color: var(--primary-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .home-slider {
                margin: -24px -24px 32px -24px;
            }

            .carousel-item {
                height: 360px;
            }

            .carousel-caption {
                left: 5%;
                right: 5%;
            }

            .carousel-caption h2 {
                font-size: 32px;
            }

            .carousel-caption p {
                font-size: 15px;
            }

            .carousel-control-prev,
            .carousel-control-next {
                display: none;
            }
        }

        /* Hero Section - Trang chủ (compact, responsive) */
        .home-hero {
            padding: 30px 20px;
            background-color: var(--sidebar-color);
            color: white;
            margin-bottom: 30px;
            overflow: hidden;
        }

        /* constrain inner content so banner stays visible but layout is compact */
        .home-hero .hero-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: block;
            padding: 0 8px;
        }

        .featured-label {
            display: inline-block;
            color: var(--primary-color);
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 16px;
        }

        .home-title {
            font-size: 36px;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 18px;
            letter-spacing: -0.5px;
        }

        .home-subtitle {
            font-size: 15px;
            color: #9ca3af;
            max-width: 640px;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        /* Larger screens: restore more prominent hero but keep compact spacing */
        @media (min-width: 1200px) {
            .home-hero {
                padding: 48px 40px;
                margin-bottom: 40px;
            }

            .home-title {
                font-size: 48px;
            }

            .home-subtitle {
                font-size: 17px;
                margin-bottom: 28px;
            }
        }

        /* Info Cards Redesign */
        .info-section {
            margin-bottom: 80px;
        }

        .info-card {
            padding: 40px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            height: 100%;
            transition: all 0.4s;
            text-align: center;
        }

        .info-card:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--primary-color);
            transform: translateY(-8px);
        }

        .info-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--primary-color), #8b5cf6);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 24px;
            border-radius: 20px;
            box-shadow: 0 10px 20px var(--primary-glow);
        }

        .info-card h4 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 12px;
            color: var(--secondary-color);
        }

        .info-card p {
            color: var(--text-muted);
            line-height: 1.6;
            font-size: 14px;
        }

        /* Course Card for Home */
        .featured-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 32px;
        }

        .featured-title {
            font-size: 24px;
            font-weight: 800;
            color: var(--secondary-color);
        }

        /* Course Card Redesign */
        .course-card {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .course-card:hover {
            transform: translateY(-10px) scale(1.02);
            border-color: var(--primary-color);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), 0 0 20px var(--primary-glow);
            background: rgba(255, 255, 255, 0.08);
        }

        .course-thumb-wrapper {
            position: relative;
            width: 100%;
            height: 180px;
            overflow: hidden;
        }

        .course-thumb {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .course-card:hover .course-thumb {
            transform: scale(1.1);
        }

        .course-content {
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .course-title {
            font-family: 'Outfit', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: white;
            line-height: 1.4;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .course-instructor {
            font-size: 14px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .course-price {
            margin-top: auto;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .course-price .current {
            font-size: 20px;
            font-weight: 800;
            color: var(--primary-color);
        }

        .course-price .original {
            font-size: 14px;
            text-decoration: line-through;
            color: var(--text-muted);
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Decorative Blobs -->
    <div
        style="position: fixed; top: 20%; left: 10%; width: 400px; height: 400px; background: var(--primary-color); filter: blur(150px); opacity: 0.1; z-index: -1;">
    </div>
    <div
        style="position: fixed; bottom: 10%; right: 10%; width: 500px; height: 500px; background: #8b5cf6; filter: blur(180px); opacity: 0.1; z-index: -1;">
    </div>

    <!-- Modern Banner Slider -->
    <?php if($sliders->count() > 0): ?>
        <div id="homeCarousel" class="carousel slide home-slider fade-in" data-bs-ride="true" data-bs-interval="5000"
            data-bs-pause="false">
            <!-- Indicators -->
            <div class="carousel-indicators">
                <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="<?php echo e($index); ?>"
                        class="<?php echo e($index == 0 ? 'active' : ''); ?>" aria-current="<?php echo e($index == 0 ? 'true' : 'false'); ?>"
                        aria-label="Slide <?php echo e($index + 1); ?>"></button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Slides -->
            <div class="carousel-inner">
                <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="carousel-item <?php echo e($index == 0 ? 'active' : ''); ?>" data-bs-interval="4000">
                        <img src="<?php echo e(asset('storage/' . $slider->image)); ?>" class="d-block w-100" alt="<?php echo e($slider->title); ?>">
                        <div class="carousel-caption">
                            <?php if($slider->title): ?>
                                <h2><?php echo e($slider->title); ?></h2>
                            <?php endif; ?>
                            <?php if($slider->description): ?>
                                <p><?php echo e($slider->description); ?></p>
                            <?php endif; ?>
                            <?php if($slider->link): ?>
                                <a href="<?php echo e($slider->link); ?>" class="btn btn-primary px-5 py-3"
                                    style="font-size: 16px; font-weight: 600; border-radius: 8px;">
                                    <i class="fas fa-play-circle me-2"></i>Bắt đầu học ngay
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('explore')); ?>" class="btn btn-primary px-5 py-3"
                                    style="font-size: 16px; font-weight: 600; border-radius: 8px;">
                                    <i class="fas fa-compass me-2"></i>Khám phá ngay
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
                <i class="fas fa-chevron-left" style="font-size: 24px;"></i>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
                <i class="fas fa-chevron-right" style="font-size: 24px;"></i>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    <?php else: ?>
        <!-- Default Hero Banner if no sliders -->
        <div class="home-slider" style="height: 480px; display: flex; align-items: center; justify-content: center;">
            <div style="text-align: center; max-width: 700px; padding: 40px;">
                <h2 style="font-size: 52px; font-weight: 800; color: white; margin-bottom: 20px; letter-spacing: -1.5px;">
                    E-LEARNING FUTURE
                </h2>
                <p style="font-size: 18px; color: rgba(255,255,255,0.95); margin-bottom: 32px;">
                    Discover. Learn. Grow.
                </p>
                <a href="<?php echo e(route('explore')); ?>" class="btn btn-primary px-5 py-3"
                    style="font-size: 16px; font-weight: 600; border-radius: 8px;">
                    <i class="fas fa-compass me-2"></i>Khám phá khóa học
                </a>
            </div>
        </div>
    <?php endif; ?>

    <!-- Hero Section -->
    <div class="glass p-5 mb-5 fade-in"
        style="background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.05)); border: 1px solid var(--glass-border);">
        <div class="hero-inner">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="featured-label"
                        style="color: var(--primary-color); font-weight: 800; text-transform: uppercase; letter-spacing: 3px; font-size: 12px; display: block; margin-bottom: 20px;">Nền
                        tảng học tập thế hệ mới</span>
                    <h1 class="home-title"
                        style="font-size: 52px; font-weight: 800; color: white; line-height: 1.1; margin-bottom: 24px;">Mở
                        khóa tiềm năng<br><span
                            style="background: linear-gradient(to right, var(--primary-color), #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">của
                            bạn mỗi ngày</span></h1>
                    <p class="home-subtitle" style="font-size: 18px; color: var(--text-muted); margin-bottom: 32px;">Học tập
                        không giới hạn với nền tảng giáo dục trực tuyến hàng đầu, mang đến trải nghiệm học tập đỉnh cao.</p>

                    <div class="d-flex gap-3">
                        <a href="<?php echo e(route('explore')); ?>" class="btn btn-primary px-5 py-3">
                            <i class="fas fa-rocket me-2"></i>Bắt đầu ngay
                        </a>
                        <a href="#about" class="btn btn-outline px-5 py-3">
                            Tìm hiểu thêm
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block">
                    <div style="position: relative;">
                        <div
                            style="position: absolute; inset: -20px; background: var(--primary-glow); filter: blur(40px); opacity: 0.3; border-radius: 40px;">
                        </div>
                        <img src="https://img.freepik.com/free-vector/gradient-ui-ux-background_23-2149024124.jpg" alt="Edu"
                            class="img-fluid"
                            style="border-radius: 30px; position: relative; border: 1px solid var(--glass-border); box-shadow: 0 30px 60px rgba(0,0,0,0.5);">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Section -->
    <div id="about" class="info-section">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-rocket"></i></div>
                    <h4>Tốc độ & Hiệu quả</h4>
                    <p>Lộ trình học tập tinh gọn, tập trung kiến thức trọng tâm.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-layer-group"></i></div>
                    <h4>Đa dạng chủ đề</h4>
                    <p>Từ lập trình, thiết kế đến kinh doanh.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-headset"></i></div>
                    <h4>Hỗ trợ 24/7</h4>
                    <p>Đội ngũ chuyên gia luôn sẵn sàng hỗ trợ.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Courses (Carousel) -->
    <div class="mb-5 pb-5">
        <div class="featured-header d-flex justify-content-between align-items-center mb-5">
            <h2 class="featured-title mb-0" style="font-size: 32px; font-weight: 800; color: white;">Khóa học <span
                    style="color: var(--primary-color)">tiêu biểu</span></h2>
            <a href="<?php echo e(route('explore')); ?>" class="btn btn-outline">
                Xem tất cả <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>

        <div id="featuredCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php $__currentLoopData = $featuredCourses->chunk(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunkIndex => $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="carousel-item <?php echo e($chunkIndex == 0 ? 'active' : ''); ?>">
                        <div class="row g-4">
                            <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $purchased = auth()->check() && auth()->user()->hasPurchased($course); ?>
                                <div class="col-md-3">
                                    <a href="<?php echo e($purchased ? route('learn.show', $course->slug) : route('courses.show', $course->slug)); ?>"
                                        class="text-decoration-none d-block h-100">
                                        <div class="course-card">
                                            <div class="course-thumb-wrapper">
                                                <?php if($purchased): ?>
                                                    <div
                                                        style="position: absolute; top: 12px; right: 12px; z-index: 10; background: #10b981; color: white; padding: 4px 12px; border-radius: 8px; font-size: 11px; font-weight: 800; box-shadow: 0 4px 10px rgba(16,185,129,0.3);">
                                                        ĐÃ MUA</div>
                                                <?php endif; ?>
                                                <img src="<?php echo e($course->thumbnail ? asset('storage/' . $course->thumbnail) : asset('products/course' . (($course->id % 5) + 1) . '.jpg')); ?>"
                                                    class="course-thumb" alt="<?php echo e($course->title); ?>"
                                                    onerror="this.src='https://placehold.co/480x270/1e293b/94a3b8?text=Course'">
                                                <div
                                                    style="position: absolute; bottom: 0; left: 0; right: 0; height: 50%; background: linear-gradient(to top, rgba(15,23,42,0.8), transparent); z-index: 2;">
                                                </div>
                                            </div>
                                            <div class="course-content">
                                                <div class="course-instructor">
                                                    <div class="user-avatar" style="width: 24px; height: 24px; font-size: 10px;">
                                                        <?php echo e(strtoupper(substr($course->instructor->name ?? 'G', 0, 1))); ?></div>
                                                    <?php echo e($course->instructor->name ?? 'Chuyên gia'); ?>

                                                </div>
                                                <div class="course-title"><?php echo e($course->title); ?></div>
                                                <div class="d-flex align-items-center gap-2"
                                                    style="font-size: 13px; color: #fbbf24;">
                                                    <div class="d-flex">
                                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                                            <i class="fas fa-star" style="font-size: 11px;"></i>
                                                        <?php endfor; ?>
                                                    </div>
                                                    <span style="color: var(--text-muted)">(2.4k học viên)</span>
                                                </div>
                                                <div class="course-price">
                                                    <?php if($course->price == 0): ?>
                                                        <span class="current" style="color:#10b981;">Miễn phí</span>
                                                    <?php else: ?>
                                                        <?php if($course->sale_price): ?>
                                                            <span
                                                                class="current"><?php echo e(number_format($course->sale_price, 0, ',', '.')); ?>đ</span>
                                                            <span class="original"><?php echo e(number_format($course->price, 0, ',', '.')); ?>đ</span>
                                                        <?php else: ?>
                                                            <span class="current"><?php echo e(number_format($course->price, 0, ',', '.')); ?>đ</span>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Custom Controls -->
            <div class="d-flex justify-content-center gap-3 mt-5">
                <button class="btn btn-outline p-0" style="width: 50px; height: 50px; border-radius: 50%;" type="button"
                    data-bs-target="#featuredCarousel" data-bs-slide="prev">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="btn btn-outline p-0" style="width: 50px; height: 50px; border-radius: 50%;" type="button"
                    data-bs-target="#featuredCarousel" data-bs-slide="next">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const carouselElement = document.querySelector('#homeCarousel');
            if (carouselElement) {
                const carousel = new bootstrap.Carousel(carouselElement, {
                    interval: 4000,
                    ride: 'carousel',
                    pause: false
                });
                carousel.cycle();
            }
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\khoahoc\resources\views/home.blade.php ENDPATH**/ ?>