

<?php $__env->startPush('styles'); ?>
<style>
    :root {
        --udemy-purple: var(--primary-color);
        --udemy-purple-light: var(--primary-hover);
        --text-dark: #1c1d1f;
        --text-gray: #6a6f73;
        --bg-light: #f7f9fa;
        --border-color: #d1d7dc;
        --star-color: #f69c08;
        --bestseller-bg: #eceb98;
        --bestseller-text: #3d3c0a;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, var(--udemy-purple) 0%, var(--udemy-purple-light) 100%);
        padding: 18px 0;
        margin: -20px -20px 20px -20px;
        color: white;
        transition: padding 200ms ease, margin 200ms ease;
    }

    .page-header h1 {
        font-size: 24px;
        font-weight: 700;
        margin: 0;
    }

    .page-header p {
        font-size: 14px;
        opacity: 0.9;
        margin: 4px 0 0;
    }

    /* Main Layout */
    .course-page {
        display: flex;
        gap: 24px;
    }

    /* Sidebar */
    .filter-sidebar {
        width: 240px;
        flex-shrink: 0;
    }

    .filter-box {
        background: #fff;
        border: 1px solid var(--border-color);
        margin-bottom: 16px;
    }

    .filter-header {
        padding: 12px 16px;
        font-weight: 700;
        font-size: 14px;
        color: var(--text-dark);
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
    }

    .filter-header i {
        font-size: 12px;
        color: var(--text-gray);
    }

    .filter-body {
        padding: 12px 16px;
    }

    .filter-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 0;
        font-size: 13px;
        color: var(--text-dark);
        cursor: pointer;
        text-decoration: none;
        transition: color 0.15s;
    }

    .filter-item:hover {
        color: var(--udemy-purple);
    }

    .filter-item.active {
        color: var(--udemy-purple);
        font-weight: 600;
    }

    .filter-item input {
        accent-color: var(--udemy-purple);
    }

    .filter-count {
        margin-left: auto;
        color: var(--text-gray);
        font-size: 12px;
    }

    .filter-stars {
        color: var(--star-color);
        font-size: 12px;
    }

    /* Main Content */
    .courses-main {
        flex: 1;
        min-width: 0;
    }

    /* Results Header */
    .results-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--border-color);
    }

    .results-count {
        font-size: 14px;
        color: var(--text-dark);
        font-weight: 600;
    }

    .results-sort select {
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        font-size: 13px;
        cursor: pointer;
        background: white;
    }

    /* Course Grid */
    .courses-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    @media (max-width: 1400px) {
        .courses-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (max-width: 1200px) {
        .courses-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 992px) {
        .course-page {
            flex-direction: column;
        }
        .filter-sidebar {
            width: 100%;
        }
        .courses-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .courses-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .courses-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Course Card - Udemy Style */
    .course-card {
        display: flex;
        flex-direction: column;
        text-decoration: none;
        color: inherit;
        transition: transform 0.2s;
    }

    .course-card:hover {
        transform: translateY(-4px);
    }

    .course-card:hover .course-title {
        color: var(--udemy-purple);
    }

    .course-image {
        width: 100%;
        aspect-ratio: 16/9;
        object-fit: cover;
        border: 1px solid var(--border-color);
        background: var(--bg-light);
    }

    .course-info {
        padding: 8px 0;
    }

    .course-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-dark);
        line-height: 1.4;
        margin-bottom: 4px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 40px;
    }

    .course-instructor {
        font-size: 11px;
        color: var(--text-gray);
        margin-bottom: 4px;
    }

    .course-rating {
        display: flex;
        align-items: center;
        gap: 4px;
        margin-bottom: 4px;
    }

    .rating-number {
        font-size: 12px;
        font-weight: 700;
        color: #b4690e;
    }

    .rating-stars {
        display: flex;
        gap: 1px;
    }

    .rating-stars i {
        font-size: 10px;
        color: var(--star-color);
    }

    .rating-count {
        font-size: 11px;
        color: var(--text-gray);
    }

    .course-price {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 4px;
    }

    .price-current {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-dark);
    }

    .price-original {
        font-size: 13px;
        color: var(--text-gray);
        text-decoration: line-through;
    }

    .course-badge {
        display: inline-block;
        padding: 2px 8px;
        font-size: 10px;
        font-weight: 700;
        border-radius: 2px;
    }

    .badge-bestseller {
        background: var(--bestseller-bg);
        color: var(--bestseller-text);
    }

    .badge-new {
        background: #acd2cc;
        color: #003b33;
    }

    .badge-hot {
        background: #f3ca8c;
        color: #3d3c0a;
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid var(--border-color);
    }

    .pagination {
        display: flex;
        gap: 4px;
    }

    .page-item .page-link {
        padding: 8px 14px;
        border: 1px solid var(--border-color);
        background: white;
        color: var(--text-dark);
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
    }

    .page-item.active .page-link {
        background: var(--text-dark);
        border-color: var(--text-dark);
        color: white;
    }

    .page-item:hover .page-link {
        background: var(--bg-light);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        grid-column: 1 / -1;
    }

    .empty-icon {
        font-size: 48px;
        color: var(--text-gray);
        margin-bottom: 16px;
    }

    .empty-state h3 {
        font-size: 18px;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .empty-state p {
        color: var(--text-gray);
        margin-bottom: 16px;
    }

    /* Topics Section */
    .popular-topics {
        margin-bottom: 24px;
    }

    .topics-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 12px;
    }

    .topics-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .topic-tag {
        padding: 8px 16px;
        background: var(--bg-light);
        border: 1px solid var(--border-color);
        font-size: 13px;
        font-weight: 600;
        color: var(--text-dark);
        text-decoration: none;
        transition: all 0.15s;
    }

    .topic-tag:hover {
        background: var(--text-dark);
        color: white;
        border-color: var(--text-dark);
    }

    .topic-tag.active {
        background: var(--text-dark);
        color: white;
        border-color: var(--text-dark);
    }

    /* Collapsed header when user scrolls */
    .page-header.shrink {
        padding: 8px 0;
        margin: 0 -20px 8px -20px;
    }

    .page-header.shrink h1 {
        font-size: 18px;
    }

    .page-header.shrink p { display: none; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="container-fluid px-4">
        <h1>
            <?php if($selectedCategory): ?>
                Khóa học <?php echo e($selectedCategory->name); ?>

            <?php elseif(request('q')): ?>
                Kết quả tìm kiếm: "<?php echo e(request('q')); ?>"
            <?php else: ?>
                Tất cả khóa học
            <?php endif; ?>
        </h1>
        <p>Học từ các chuyên gia hàng đầu với hàng ngàn khóa học chất lượng cao</p>
    </div>
</div>

<!-- Popular Topics -->
<div class="popular-topics">
    <div class="topics-title">Chủ đề phổ biến</div>
    <div class="topics-list">
        <a href="<?php echo e(route('explore', request()->except('category'))); ?>" class="topic-tag <?php echo e(!request('category') ? 'active' : ''); ?>">Tất cả</a>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('explore', array_merge(request()->query(), ['category' => $cat->id]))); ?>" 
               class="topic-tag <?php echo e(request('category') == $cat->id ? 'active' : ''); ?>">
                <?php echo e($cat->name); ?>

            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<div class="course-page">
    <!-- Sidebar Filter -->
    <div class="filter-sidebar">
        <!-- Search -->
        <div class="filter-box">
            <div class="filter-header">
                <span>🔍 Tìm kiếm</span>
            </div>
            <div class="filter-body">
                <form action="<?php echo e(route('explore')); ?>" method="GET">
                    <?php if(request('category')): ?> <input type="hidden" name="category" value="<?php echo e(request('category')); ?>"> <?php endif; ?>
                    <?php if(request('price')): ?> <input type="hidden" name="price" value="<?php echo e(request('price')); ?>"> <?php endif; ?>
                    <?php if(request('rating')): ?> <input type="hidden" name="rating" value="<?php echo e(request('rating')); ?>"> <?php endif; ?>
                    <?php if(request('sort')): ?> <input type="hidden" name="sort" value="<?php echo e(request('sort')); ?>"> <?php endif; ?>
                    <div class="d-flex gap-2">
                        <input type="text" name="q" class="form-control form-control-sm" 
                               placeholder="Nhập từ khóa..." value="<?php echo e(request('q')); ?>">
                        <button type="submit" class="btn btn-dark btn-sm">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Rating Filter -->
        <div class="filter-box">
            <div class="filter-header">
                <span>⭐ Đánh giá</span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="filter-body">
                <?php for($s = 5; $s >= 1; $s--): ?>
                <a href="<?php echo e(route('explore', array_merge(request()->query(), ['rating' => $s]))); ?>" 
                   class="filter-item <?php echo e(request('rating') == $s ? 'active' : ''); ?>">
                    <input type="radio" name="rating_fake" <?php echo e(request('rating') == $s ? 'checked' : ''); ?>>
                    <span class="filter-stars">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <i class="<?php echo e($i <= $s ? 'fas' : 'far'); ?> fa-star"></i>
                        <?php endfor; ?>
                    </span>
                    <span><?php echo e($s); ?> sao</span>
                </a>
                <?php endfor; ?>
                
                <?php if(request('rating')): ?>
                    <a href="<?php echo e(route('explore', request()->except('rating'))); ?>" class="filter-item text-muted mt-2">
                        <i class="fas fa-times-circle"></i> Xóa lọc đánh giá
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Price Filter -->
        <div class="filter-box">
            <div class="filter-header">
                <span>💰 Mức giá</span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="filter-body">
                <a href="<?php echo e(route('explore', request()->except('price'))); ?>" 
                   class="filter-item <?php echo e(!request('price') ? 'active' : ''); ?>">
                    <input type="radio" name="price_fake" <?php echo e(!request('price') ? 'checked' : ''); ?>>
                    Tất cả mức giá
                </a>
                <a href="<?php echo e(route('explore', array_merge(request()->query(), ['price' => 'free']))); ?>" 
                   class="filter-item <?php echo e(request('price') == 'free' ? 'active' : ''); ?>">
                    <input type="radio" name="price_fake" <?php echo e(request('price') == 'free' ? 'checked' : ''); ?>>
                    Miễn phí
                </a>
                <a href="<?php echo e(route('explore', array_merge(request()->query(), ['price' => 'paid']))); ?>" 
                   class="filter-item <?php echo e(request('price') == 'paid' ? 'active' : ''); ?>">
                    <input type="radio" name="price_fake" <?php echo e(request('price') == 'paid' ? 'checked' : ''); ?>>
                    Có phí
                </a>
            </div>
        </div>

    </div>

    <!-- Main Content -->
    <div class="courses-main">
        <!-- Results Header -->
        <div class="results-header">
            <div class="results-count">
                <strong><?php echo e($courses->total()); ?></strong> kết quả
            </div>
            <div class="results-sort">
                <select onchange="window.location.href=this.value">
                    <option value="<?php echo e(route('explore', array_merge(request()->query(), ['sort' => 'popular']))); ?>"
                            <?php echo e(request('sort') == 'popular' ? 'selected' : ''); ?>>
                        Phổ biến nhất
                    </option>
                    <option value="<?php echo e(route('explore', array_merge(request()->query(), ['sort' => 'newest']))); ?>" 
                            <?php echo e(request('sort') == 'newest' || !request('sort') ? 'selected' : ''); ?>>
                        Mới nhất
                    </option>
                    <option value="<?php echo e(route('explore', array_merge(request()->query(), ['sort' => 'rating']))); ?>"
                            <?php echo e(request('sort') == 'rating' ? 'selected' : ''); ?>>
                        Đánh giá cao nhất
                    </option>
                    <option value="<?php echo e(route('explore', array_merge(request()->query(), ['sort' => 'price_asc']))); ?>"
                            <?php echo e(request('sort') == 'price_asc' ? 'selected' : ''); ?>>
                        Giá: Thấp đến Cao
                    </option>
                    <option value="<?php echo e(route('explore', array_merge(request()->query(), ['sort' => 'price_desc']))); ?>"
                            <?php echo e(request('sort') == 'price_desc' ? 'selected' : ''); ?>>
                        Giá: Cao đến Thấp
                    </option>
                </select>
            </div>
        </div>

        <!-- Courses Grid -->
        <div class="courses-grid">
            <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('courses.show', $course->slug)); ?>" class="course-card">
                    <img src="<?php echo e($course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://placehold.co/480x270/1c1d1f/ffffff?text=' . urlencode(Str::limit($course->title, 20))); ?>" 
                         class="course-image" 
                         alt="<?php echo e($course->title); ?>"
                         onerror="this.src='https://placehold.co/480x270/e2e8f0/64748b?text=Course'">
                    
                    <div class="course-info">
                        <div class="course-title"><?php echo e($course->title); ?></div>
                        <div class="course-instructor"><?php echo e($course->instructor->name ?? 'Giảng viên'); ?></div>
                        
                        <div class="course-rating">
                            <?php if(($course->reviews_count ?? 0) > 0): ?>
                                <?php 
                                    $rating = $course->reviews_avg_rating ?? 0; 
                                    $count = $course->reviews_count ?? 0;
                                ?>
                                <span class="rating-number"><?php echo e(number_format($rating, 1)); ?></span>
                                <div class="rating-stars">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <?php if($i <= floor($rating)): ?>
                                            <i class="fas fa-star"></i>
                                        <?php elseif($i - 0.5 <= $rating): ?>
                                            <i class="fas fa-star-half-alt"></i>
                                        <?php else: ?>
                                            <i class="far fa-star"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <span class="rating-count">(<?php echo e(number_format($count)); ?>)</span>
                            <?php else: ?>
                                <span class="text-muted small">Chưa có đánh giá</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="course-price">
                            <?php if($course->price == 0): ?>
                                <span class="price-current" style="color: #1e7b34;">Miễn phí</span>
                            <?php else: ?>
                                <?php if($course->sale_price): ?>
                                    <span class="price-current"><?php echo e(number_format($course->sale_price, 0, ',', '.')); ?> VND</span>
                                    <span class="price-original"><?php echo e(number_format($course->price, 0, ',', '.')); ?> VND</span>
                                <?php else: ?>
                                    <span class="price-current"><?php echo e(number_format($course->price, 0, ',', '.')); ?> VND</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        
                        <?php if($index % 5 == 0): ?>
                            <span class="course-badge badge-bestseller">Bestseller</span>
                        <?php elseif($index % 7 == 0): ?>
                            <span class="course-badge badge-new">Mới</span>
                        <?php elseif($index % 11 == 0): ?>
                            <span class="course-badge badge-hot">Hot & New</span>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="empty-state">
                    <div class="empty-icon">📚</div>
                    <h3>Không tìm thấy khóa học</h3>
                    <p>Hãy thử thay đổi bộ lọc hoặc tìm kiếm với từ khóa khác</p>
                    <a href="<?php echo e(route('explore')); ?>" class="btn btn-dark">Xem tất cả khóa học</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if($courses->hasPages()): ?>
            <div class="pagination-wrapper">
                <?php echo e($courses->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\TTS\khoahoc\resources\views/explore.blade.php ENDPATH**/ ?>