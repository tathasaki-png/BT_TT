@extends('layouts.app')

@push('styles')
<style>
    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.05));
        backdrop-filter: blur(10px);
        padding: 40px 0;
        margin: -40px -40px 40px -40px;
        border-bottom: 1px solid var(--glass-border);
        color: white;
    }

    .page-header h1 {
        font-family: 'Outfit', sans-serif;
        font-size: 32px;
        font-weight: 800;
        margin: 0;
        letter-spacing: -1px;
    }

    /* Sidebar */
    .filter-sidebar {
        width: 280px;
        flex-shrink: 0;
    }

    .filter-box {
        background: var(--card-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        margin-bottom: 24px;
        overflow: hidden;
    }

    .filter-header {
        padding: 20px 24px;
        font-weight: 700;
        font-size: 16px;
        color: white;
        border-bottom: 1px solid var(--glass-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .filter-body {
        padding: 16px 24px;
    }

    .filter-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        font-size: 14px;
        color: var(--text-muted);
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s;
    }

    .filter-item:hover {
        color: var(--primary-color);
        padding-left: 4px;
    }

    .filter-item.active {
        color: white;
        font-weight: 600;
    }

    .filter-item input {
        accent-color: var(--primary-color);
        width: 18px;
        height: 18px;
    }

    .filter-stars i {
        font-size: 13px;
        color: #fbbf24;
    }

    /* Course Grid */
    .courses-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    /* Reuse Course Card Styles from Home */
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
        text-decoration: none;
    }

    .course-card:hover {
        transform: translateY(-8px);
        border-color: var(--primary-color);
        box-shadow: 0 20px 40px rgba(0,0,0,0.4), 0 0 20px var(--primary-glow);
    }

    .course-image {
        width: 100%;
        aspect-ratio: 16/9;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .course-card:hover .course-image {
        transform: scale(1.1);
    }

    .course-info {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .course-title {
        font-family: 'Outfit', sans-serif;
        font-size: 16px;
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
        font-size: 13px;
        color: var(--text-muted);
    }

    .price-current {
        font-size: 18px;
        font-weight: 800;
        color: var(--primary-color);
    }

    /* Popular Topics */
    .topic-tag {
        padding: 10px 20px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-muted);
        text-decoration: none;
        transition: all 0.3s;
    }

    .topic-tag:hover, .topic-tag.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
        box-shadow: 0 4px 15px var(--primary-glow);
        transform: translateY(-2px);
    }

    .results-sort select {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--glass-border);
        color: white;
        padding: 10px 16px;
        border-radius: 12px;
        font-size: 14px;
        outline: none;
    }

    /* Missing Layout Styles */
    .course-page {
        display: flex;
        gap: 40px;
        margin-top: 40px;
    }

    .courses-main {
        flex: 1;
    }

    .popular-topics {
        margin-bottom: 40px;
        padding: 24px;
        background: rgba(255,255,255,0.02);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
    }

    .topics-title {
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        font-size: 14px;
        color: var(--primary-color);
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 16px;
    }

    .topics-list {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .results-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        padding: 16px 24px;
        background: rgba(255,255,255,0.03);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
    }

    .results-count {
        color: white;
        font-size: 15px;
    }

    .results-count strong {
        color: var(--primary-color);
    }

    /* Enhanced Readability */
    .page-header p {
        color: rgba(255,255,255,0.7) !important;
        font-size: 16px;
    }

    .course-instructor {
        color: #d1d5db !important; /* Brighter than muted */
    }

    .empty-state {
        text-align: center;
        padding: 80px 40px;
        background: rgba(255,255,255,0.02);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        grid-column: span 3;
    }

    .empty-icon {
        font-size: 64px;
        margin-bottom: 24px;
        display: block;
    }

    @media (max-width: 1200px) {
        .courses-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 992px) {
        .course-page {
            flex-direction: column;
        }
        .filter-sidebar {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
    }

    @media (max-width: 768px) {
        .courses-grid {
            grid-template-columns: 1fr;
        }
        .filter-sidebar {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="container-fluid px-4">
        <h1>
            @if($selectedCategory)
                Khóa học {{ $selectedCategory->name }}
            @elseif(request('q'))
                Kết quả tìm kiếm: "{{ request('q') }}"
            @else
                Tất cả khóa học
            @endif
        </h1>
        <p>Học từ các chuyên gia hàng đầu với hàng ngàn khóa học chất lượng cao</p>
    </div>
</div>

<!-- Popular Topics -->
<div class="popular-topics">
    <div class="topics-title">Chủ đề phổ biến</div>
    <div class="topics-list">
        <a href="{{ route('explore', request()->except('category')) }}" class="topic-tag {{ !request('category') ? 'active' : '' }}">Tất cả</a>
        @foreach($categories as $cat)
            <a href="{{ route('explore', array_merge(request()->query(), ['category' => $cat->id])) }}" 
               class="topic-tag {{ request('category') == $cat->id ? 'active' : '' }}">
                {{ $cat->name }}
            </a>
        @endforeach
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
                <form action="{{ route('explore') }}" method="GET">
                    @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    @if(request('price')) <input type="hidden" name="price" value="{{ request('price') }}"> @endif
                    @if(request('rating')) <input type="hidden" name="rating" value="{{ request('rating') }}"> @endif
                    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                    <div class="d-flex gap-2">
                        <input type="text" name="q" class="form-control form-control-sm" 
                               placeholder="Nhập từ khóa..." value="{{ request('q') }}">
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
                @for($s = 5; $s >= 1; $s--)
                <a href="{{ route('explore', array_merge(request()->query(), ['rating' => $s])) }}" 
                   class="filter-item {{ request('rating') == $s ? 'active' : '' }}">
                    <input type="radio" name="rating_fake" {{ request('rating') == $s ? 'checked' : '' }}>
                    <span class="filter-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= $s ? 'fas' : 'far' }} fa-star"></i>
                        @endfor
                    </span>
                    <span>{{ $s }} sao</span>
                </a>
                @endfor
                
                @if(request('rating'))
                    <a href="{{ route('explore', request()->except('rating')) }}" class="filter-item text-muted mt-2">
                        <i class="fas fa-times-circle"></i> Xóa lọc đánh giá
                    </a>
                @endif
            </div>
        </div>

        <!-- Price Filter -->
        <div class="filter-box">
            <div class="filter-header">
                <span>💰 Mức giá</span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="filter-body">
                <a href="{{ route('explore', request()->except('price')) }}" 
                   class="filter-item {{ !request('price') ? 'active' : '' }}">
                    <input type="radio" name="price_fake" {{ !request('price') ? 'checked' : '' }}>
                    Tất cả mức giá
                </a>
                <a href="{{ route('explore', array_merge(request()->query(), ['price' => 'free'])) }}" 
                   class="filter-item {{ request('price') == 'free' ? 'active' : '' }}">
                    <input type="radio" name="price_fake" {{ request('price') == 'free' ? 'checked' : '' }}>
                    Miễn phí
                </a>
                <a href="{{ route('explore', array_merge(request()->query(), ['price' => 'paid'])) }}" 
                   class="filter-item {{ request('price') == 'paid' ? 'active' : '' }}">
                    <input type="radio" name="price_fake" {{ request('price') == 'paid' ? 'checked' : '' }}>
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
                <strong>{{ $courses->total() }}</strong> kết quả
            </div>
            <div class="results-sort">
                <select onchange="window.location.href=this.value">
                    <option value="{{ route('explore', array_merge(request()->query(), ['sort' => 'popular'])) }}"
                            {{ request('sort') == 'popular' ? 'selected' : '' }}>
                        Phổ biến nhất
                    </option>
                    <option value="{{ route('explore', array_merge(request()->query(), ['sort' => 'newest'])) }}" 
                            {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>
                        Mới nhất
                    </option>
                    <option value="{{ route('explore', array_merge(request()->query(), ['sort' => 'rating'])) }}"
                            {{ request('sort') == 'rating' ? 'selected' : '' }}>
                        Đánh giá cao nhất
                    </option>
                    <option value="{{ route('explore', array_merge(request()->query(), ['sort' => 'price_asc'])) }}"
                            {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                        Giá: Thấp đến Cao
                    </option>
                    <option value="{{ route('explore', array_merge(request()->query(), ['sort' => 'price_desc'])) }}"
                            {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                        Giá: Cao đến Thấp
                    </option>
                </select>
            </div>
        </div>

        <!-- Courses Grid -->
        <div class="courses-grid">
            @forelse($courses as $index => $course)
                <a href="{{ route('courses.show', $course->slug) }}" class="course-card">
                    <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://placehold.co/480x270/1c1d1f/ffffff?text=' . urlencode(Str::limit($course->title, 20)) }}" 
                         class="course-image" 
                         alt="{{ $course->title }}"
                         onerror="this.src='https://placehold.co/480x270/e2e8f0/64748b?text=Course'">
                    
                    <div class="course-info">
                        <div class="course-title">{{ $course->title }}</div>
                        <div class="course-instructor">{{ $course->instructor->name ?? 'Giảng viên' }}</div>
                        
                        <div class="course-rating">
                            @if(($course->reviews_count ?? 0) > 0)
                                @php 
                                    $rating = $course->reviews_avg_rating ?? 0; 
                                    $count = $course->reviews_count ?? 0;
                                @endphp
                                <span class="rating-number">{{ number_format($rating, 1) }}</span>
                                <div class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($rating))
                                            <i class="fas fa-star"></i>
                                        @elseif($i - 0.5 <= $rating)
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="rating-count">({{ number_format($count) }})</span>
                            @else
                                <span class="text-muted small">Chưa có đánh giá</span>
                            @endif
                        </div>
                        
                        <div class="course-price mt-auto">
                            @if($course->price == 0)
                                <span class="price-current" style="color: #10b981;">Miễn phí</span>
                            @else
                                @if($course->sale_price)
                                    <span class="price-current">{{ number_format($course->sale_price, 0, ',', '.') }}đ</span>
                                    <span class="price-original" style="font-size: 13px; text-decoration: line-through; color: var(--text-muted); margin-left:8px;">{{ number_format($course->price, 0, ',', '.') }}đ</span>
                                @else
                                    <span class="price-current">{{ number_format($course->price, 0, ',', '.') }}đ</span>
                                @endif
                            @endif
                        </div>
                        
                        <div class="mt-2 d-flex gap-2">
                            @if($index % 5 == 0)
                                <span class="badge" style="background: rgba(251, 191, 36, 0.1); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.2); font-size: 10px;">Bestseller</span>
                            @elseif($index % 7 == 0)
                                <span class="badge" style="background: rgba(99, 102, 241, 0.1); color: var(--primary-color); border: 1px solid var(--primary-glow); font-size: 10px;">Mới</span>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">📚</div>
                    <h3>Không tìm thấy khóa học</h3>
                    <p>Hãy thử thay đổi bộ lọc hoặc tìm kiếm với từ khóa khác</p>
                    <a href="{{ route('explore') }}" class="btn btn-dark">Xem tất cả khóa học</a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($courses->hasPages())
            <div class="pagination-wrapper">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
