

<?php $__env->startPush('styles'); ?>
<style>
    /* Modern Banner Slider */
    .home-slider {
        margin: -24px -24px 40px -24px;
        /* subtle green tint but do not darken slides */
        background: linear-gradient(135deg, rgba(6,58,18,0.06) 0%, rgba(10,77,31,0.04) 100%);
        position: relative;
        overflow: hidden;
    }
    
    .carousel {
        position: relative;
    }
    
    .carousel-item {
        height: 440px;
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
        filter: none; /* do not dim images */
    }
    
    .carousel-caption {
        text-align: left;
        left: 8%;
        right: 8%;
        bottom: auto;
        top: 50%;
        transform: translateY(-50%);
        max-width: 650px;
        z-index: 5;
        padding: 0;
    }
    
    .carousel-caption h2 {
        font-size: 42px;
        font-weight: 800;
        margin-bottom: 18px;
        color: white;
        letter-spacing: -1.2px;
        line-height: 1.08;
        /* keep text readable over bright images */
        text-shadow: 0 6px 18px rgba(0,0,0,0.35);
        animation: slideInLeft 0.8s ease-out;
    }
    
    .carousel-caption p {
        font-size: 18px;
        color: rgba(255,255,255,0.95);
        margin-bottom: 32px;
        line-height: 1.7;
        text-shadow: 0 2px 8px rgba(0,0,0,0.2);
        animation: slideInLeft 0.8s ease-out 0.2s backwards;
    }
    
    .carousel-caption .btn {
        animation: slideInLeft 0.8s ease-out 0.4s backwards;
        box-shadow: 0 4px 14px rgba(22,163,74,0.4);
    }
    
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
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
        background: rgba(255,255,255,0.12);
        border-radius: 50%;
        color: #fff;
        border: none;
        box-shadow: 0 6px 18px rgba(0,0,0,0.25);
        transition: transform 0.18s ease, background 0.18s ease, opacity 0.18s ease;
        z-index: 12;
        backdrop-filter: blur(6px);
        cursor: pointer;
    }

    .carousel-control-prev { left: 18px; }
    .carousel-control-next { right: 18px; }

    .carousel-control-prev i,
    .carousel-control-next i { font-size: 20px; color: #fff; }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        transform: translateY(-50%) scale(1.06);
        background: rgba(255,255,255,0.18);
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
        background-color: rgba(255,255,255,0.5);
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

    /* Info Cards */
    .info-section {
        margin-bottom: 80px;
    }

    .info-card {
        padding: 32px;
        background: white;
        border: 1px solid var(--border-color);
        height: 100%;
        transition: all 0.3s;
    }

    .info-card:hover {
        border-color: var(--primary-color);
        transform: translateY(-5px);
    }

    .info-icon {
        width: 48px;
        height: 48px;
        background: var(--primary-color);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        margin-bottom: 24px;
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

    /* Compact Course Card for Home (fit more items per row) */
    .course-card {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: all 0.18s ease;
        border: none;
    }

    .course-card:hover { transform: translateY(-4px); box-shadow: 0 6px 18px rgba(0,0,0,0.06); }

    .course-thumb-wrapper { position: relative; width: 100%; height: 110px; overflow: hidden; border-radius: 6px; }

    .course-thumb { width: 100%; height: 100%; object-fit: cover; display:block; }

    .course-content { padding: 8px 6px; display:flex; flex-direction:column; gap:6px; }

    .course-title { font-size: 13px; font-weight: 700; color: #222; line-height:1.3; margin:0; display:-webkit-box; -webkit-line-clamp:2; line-clamp: 2; -webkit-box-orient:vertical; overflow:hidden; min-height:36px; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Modern Banner Slider -->
<?php if($sliders->count() > 0): ?>
<div id="homeCarousel" class="carousel slide home-slider fade-in" data-bs-ride="true" data-bs-interval="4000" data-bs-pause="false">
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
                        <a href="<?php echo e($slider->link); ?>" class="btn btn-primary px-5 py-3" style="font-size: 16px; font-weight: 600; border-radius: 8px;">
                            <i class="fas fa-play-circle me-2"></i>Bắt đầu học ngay
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('explore')); ?>" class="btn btn-primary px-5 py-3" style="font-size: 16px; font-weight: 600; border-radius: 8px;">
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
        <a href="<?php echo e(route('explore')); ?>" class="btn btn-primary px-5 py-3" style="font-size: 16px; font-weight: 600; border-radius: 8px;">
            <i class="fas fa-compass me-2"></i>Khám phá khóa học
        </a>
    </div>
</div>
<?php endif; ?>

<!-- Hero Section -->
<div class="home-hero fade-in">
    <div class="hero-inner">
    <div class="row align-items-center">
        <div class="col-lg-7">
            <span class="featured-label">Nền tảng học tập thế hệ mới</span>
            <h1 class="home-title">Mở khóa tiềm năng của bạn mỗi ngày</h1>
            <p class="home-subtitle">Học tập không giới hạn với nền tảng giáo dục trực tuyến hàng đầu.</p>
            
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('explore')); ?>" class="btn btn-primary px-4 py-2">
                    Khám phá ngay
                </a>
                <a href="#about" class="btn btn-outline btn-sm px-4 py-2" style="color: white; border-color: rgba(255,255,255,0.2)">
                    Tìm hiểu thêm
                </a>
            </div>
        </div>
        <div class="col-lg-5 d-none d-lg-block">
            <img src="https://img.freepik.com/free-vector/gradient-ui-ux-background_23-2149024124.jpg" alt="Edu" class="img-fluid" style="filter: none; max-height: 320px; object-fit: cover;">
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
    <div class="featured-header">
        <h2 class="featured-title">Khóa học tiêu biểu</h2>
        <a href="<?php echo e(route('explore')); ?>" class="btn btn-outline btn-sm">
            Xem tất cả
        </a>
    </div>

    <div id="featuredCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php $__currentLoopData = $featuredCourses->chunk(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunkIndex => $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="carousel-item <?php echo e($chunkIndex == 0 ? 'active' : ''); ?>">
                    <div class="d-flex" style="gap:16px;">
                        <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $purchased = auth()->check() && auth()->user()->hasPurchased($course); ?>
                            <div style="flex:1 1 0; min-width:0;">
                                <a href="<?php echo e($purchased ? route('learn.show', $course->slug) : route('courses.show', $course->slug)); ?>" class="text-decoration-none d-block h-100">
                                    <div class="course-card">
                                        <div class="course-thumb-wrapper" style="height:120px; position:relative;">
                                            <?php if($purchased): ?>
                                                <span class="badge bg-success" style="position:absolute; top:8px; right:8px; z-index:5; font-weight:700;">Đã mua</span>
                                            <?php endif; ?>
                                            <img src="<?php echo e($course->thumbnail ? asset('storage/' . $course->thumbnail) : asset('products/course' . (($course->id % 5) + 1) . '.jpg')); ?>"
                                                 class="course-thumb"
                                                 alt="<?php echo e($course->title); ?>"
                                                 onerror="this.src='https://placehold.co/480x270/e2e8f0/64748b?text=Course'">
                                        </div>
                                        <div class="course-content">
                                            <div class="course-title"><?php echo e(Str::limit($course->title, 60)); ?></div>
                                            <div class="course-instructor"><?php echo e($course->instructor->name ?? 'Giảng viên'); ?></div>
                                            <div class="course-rating">
                                                <?php $rating = $course->rating ?? (rand(40,49)/10); $count = $course->rating_count ?? rand(20,200); ?>
                                                <span class="rating-number"><?php echo e(number_format($rating,1)); ?></span>
                                                <div class="rating-stars">
                                                    <?php for($i=1;$i<=5;$i++): ?>
                                                        <?php if($i <= floor($rating)): ?><i class="fas fa-star"></i><?php else: ?><i class="far fa-star"></i><?php endif; ?>
                                                    <?php endfor; ?>
                                                </div>
                                                <span class="rating-count">(<?php echo e($count); ?>)</span>
                                            </div>
                                            <div class="course-price">
                                                <?php if($course->price == 0): ?>
                                                    <span class="current" style="color:#10b981;">Miễn phí</span>
                                                <?php else: ?>
                                                    <?php if($course->sale_price): ?>
                                                        <span class="current"><?php echo e((int) $course->sale_price); ?> VND</span>
                                                        <span class="original"><?php echo e((int) $course->price); ?> VND</span>
                                                    <?php else: ?>
                                                        <span class="current"><?php echo e((int) $course->price); ?> VND</span>
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

        <button class="carousel-control-prev" type="button" data-bs-target="#featuredCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#featuredCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\TTS\khoahoc\resources\views/home.blade.php ENDPATH**/ ?>