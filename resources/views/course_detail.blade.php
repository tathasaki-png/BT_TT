@extends('layouts.app')

@push('styles')
    <style>
        .course-header-section {
            background: linear-gradient(135deg, #0b0f1a, #1e1b4b);
            color: #fff;
            padding: 80px 0;
            margin-bottom: 60px;
            position: relative;
            overflow: hidden;
            border-bottom: 1px solid var(--glass-border);
        }

        .course-header-section::before {
            content: '';
            position: absolute;
            top: -10%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, var(--primary-color) 0%, transparent 70%);
            opacity: 0.15;
            filter: blur(100px);
        }

        .course-title-main {
            font-family: 'Outfit', sans-serif;
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 24px;
            letter-spacing: -1.5px;
            line-height: 1.1;
        }

        .sticky-course-card {
            position: sticky;
            top: 100px;
            z-index: 10;
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.5);
        }

        .lesson-item {
            padding: 16px 24px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--glass-border);
            margin-bottom: 12px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            cursor: pointer;
        }

        .lesson-item:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--primary-color);
            transform: translateX(6px);
        }

        .lesson-icon {
            width: 36px;
            height: 36px;
            background: rgba(99, 102, 241, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 16px;
            margin-right: 16px;
        }

        .review-avatar {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary-color), #8b5cf6);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            border-radius: 12px;
            margin-right: 20px;
        }

        .course-meta-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 500;
        }

        .section-headline {
            font-family: 'Outfit', sans-serif;
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 32px;
            color: white;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-headline::before {
            content: '';
            width: 4px;
            height: 24px;
            background: var(--primary-color);
            border-radius: 4px;
            box-shadow: 0 0 10px var(--primary-glow);
        }
    </style>
@endpush

@section('content')
    <div class="course-header-section fade-in">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">{{ optional($course->category)->name ?? 'Khóa học' }}</li>
                        </ol>
                    </nav>

                    <h1 class="course-title-main">{{ $course->title }}</h1>
                    <p class="mb-4 text-muted" style="max-width: 700px; color: #9ca3af !important; font-size: 15px;">
                        {{ $course->short_description ?? 'Khám phá kiến thức chuyên sâu và thực tiễn qua khóa học chất lượng cao này.' }}
                    </p>

                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <div class="course-meta-badge">
                            <div class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="text-white">4.{{ rand(5, 9) }}</span>
                        </div>
                        <div class="course-meta-badge">
                            <i class="fas fa-users"></i>
                            <span class="text-white">{{ $course->students->count() + rand(500, 1000) }} Học viên</span>
                        </div>
                        <div class="course-meta-badge">
                            <i class="fas fa-calendar-alt"></i>
                            <span class="text-white">04/2026</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <div class="user-avatar" style="width: 40px; height: 40px; font-size: 16px;">
                            {{ strtoupper(substr(optional($course->instructor)->name ?? 'G', 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-muted" style="font-size: 11px; text-transform: uppercase; font-weight: 700;">
                                Giảng viên</div>
                            <div class="fw-bold text-white small">{{ optional($course->instructor)->name ?? 'Chuyên gia' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row g-4">
            <div class="col-md-7 col-lg-8">
                <div class="mb-5">
                    <h4 class="section-headline">Nội dung khóa học</h4>
                    <div class="d-flex justify-content-between mb-3 px-2">
                        <span class="text-muted small"><i class="fas fa-list-ul me-2"></i>{{ $course->lessons->count() }}
                            bài học</span>
                    </div>

                    <div class="curriculum-list">
                        @forelse($course->lessons as $lesson)
                            <div class="lesson-item">
                                <div class="lesson-icon">
                                    <i class="fas fa-play"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="text-white fw-bold mb-1">{{ $lesson->title }}</div>
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="text-muted" style="font-size: 12px;"><i
                                                class="far fa-clock me-1"></i>10:00</span>
                                        @if($lesson->is_free)
                                            <span class="badge"
                                                style="background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); font-size: 10px;">Học
                                                thử</span>
                                        @endif
                                    </div>
                                </div>
                                <i class="fas fa-lock text-muted opacity-30"></i>
                            </div>
                        @empty
                            <div class="glass p-5 text-center text-muted">Chưa có bài học nào.</div>
                        @endforelse
                    </div>
                </div>

                <div class="mb-5">
                    <h4 class="section-headline">Mô tả khóa học</h4>
                    <div class="text-muted small" style="line-height: 1.6;">
                        {!! nl2br(e($course->description)) !!}
                        @if(empty($course->description))
                            <p>Khóa học này sẽ cung cấp cho bạn những kiến thức chi tiết và bài bản để làm chủ chủ đề này từ cấp
                                độ cơ bản đến nâng cao.</p>
                        @endif
                    </div>
                </div>

                <!-- Reviews Section -->
                <div class="mb-5 pt-4 border-top">
                    <h4 class="section-headline">Đánh giá</h4>

                    @auth
                        @if(auth()->user()->hasPurchased($course) && !$course->reviews()->where('user_id', auth()->id())->exists())
                            <div class="card p-4 border mb-4">
                                <h6 class="fw-bold mb-3 small">Viết nhận xét</h6>
                                <form action="{{ route('reviews.store', $course) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <textarea name="comment" class="form-control small" rows="3"
                                            placeholder="Nhận xét của bạn..."></textarea>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex gap-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <input type="radio" class="btn-check" name="rating" id="rating{{$i}}" value="{{$i}}"
                                                    {{$i == 5 ? 'checked' : ''}}>
                                                <label class="btn btn-sm btn-outline-secondary" for="rating{{$i}}">{{$i}}</label>
                                            @endfor
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm px-4">GỬI</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    @endauth

                    <div class="review-list">
                        @forelse($course->reviews()->with('user')->latest()->get() as $review)
                            <div class="d-flex mb-4 pb-4 border-bottom">
                                <div class="review-avatar">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between mb-1">
                                        <h6 class="fw-bold m-0 small">{{ $review->user->name }}</h6>
                                        <span class="text-muted"
                                            style="font-size: 10px;">{{ $review->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="rating-stars mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas{{ $i <= $review->rating ? ' fa-star' : '-star opacity-20' }}"></i>
                                        @endfor
                                    </div>
                                    <p class="text-muted small m-0">{{ $review->comment }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted small">Chưa có đánh giá nào.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-md-5 col-lg-4">
                <div class="card sticky-course-card border">
                    <div class="position-relative">
                        <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : asset('products/course' . (($course->id % 5) + 1) . '.jpg') }}"
                            class="w-100" alt="{{ $course->title }}" style="height: 180px; object-fit: cover;"
                            onerror="this.src='https://placehold.co/600x450/f1f5f9/64748b?text=Preview'">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <div
                                style="width: 48px; height: 48px; background: rgba(255,255,255,0.9); display: flex; align-items: center; justify-content: center; color: var(--primary-color); font-size: 18px;">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="mb-4 text-center">
                            @if($course->price == 0)
                                <h3 class="fw-bold text-success m-0">MIỄN PHÍ</h3>
                            @else
                                @if($course->sale_price)
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <h3 class="fw-bold m-0">{{ (int) $course->sale_price }} VND</h3>
                                        <span class="text-muted text-decoration-line-through small">{{ (int) $course->price }}
                                            VND</span>
                                    </div>
                                @else
                                    <h3 class="fw-bold m-0">{{ (int) $course->price }} VND</h3>
                                @endif
                            @endif
                        </div>

                        @php $isEnrolled = Auth::check() && Auth::user()->hasPurchased($course); @endphp
                        @if($isEnrolled)
                            <a href="{{ route('learn.show', $course->slug) }}"
                                class="btn btn-primary w-100 py-3 fw-bold mb-3 shadow-lg">
                                VÀO HỌC NGAY <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        @else
                            <form action="{{ route('cart.add', $course) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold mb-3 shadow-lg">
                                    MUA NGAY <i class="fas fa-shopping-cart ms-2"></i>
                                </button>
                            </form>
                        @endif

                        <div class="text-center text-muted x-small mb-4" style="font-size: 11px;">Đảm bảo hoàn tiền trong 30
                            ngày</div>

                        <div class="pt-3 border-top">
                            <h6 class="fw-bold mb-3 text-uppercase x-small letter-spacing-1">Bao gồm:</h6>
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex align-items-center gap-2 x-small text-muted" style="font-size: 12px;">
                                    <i class="fas fa-video text-primary"></i> 12.5 giờ video bài giảng
                                </div>
                                <div class="d-flex align-items-center gap-2 x-small text-muted" style="font-size: 12px;">
                                    <i class="fas fa-infinity text-primary"></i> Truy cập trọn đời
                                </div>
                                <div class="d-flex align-items-center gap-2 x-small text-muted" style="font-size: 12px;">
                                    <i class="fas fa-certificate text-primary"></i> Chứng chỉ hoàn thành
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection