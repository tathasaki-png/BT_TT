@extends('layouts.app')

@section('content')
@push('styles')
<style>
    .profile-header {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.05));
        border-bottom: 1px solid var(--glass-border);
        padding: 60px 0;
        margin-bottom: 40px;
        color: white; /* Ensure text is white */
    }

    .profile-card {
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        padding: 32px;
        height: 100%;
    }

    .nav-pills-aura {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 10px;
        gap: 8px;
    }

    .nav-pills-aura .nav-link {
        color: var(--text-muted);
        border-radius: 14px;
        padding: 12px 20px;
        font-family: 'Outfit';
        font-weight: 600;
        transition: all 0.3s;
        border: 1px solid transparent;
        text-align: left;
    }

    .nav-pills-aura .nav-link.active {
        background: rgba(99, 102, 241, 0.1);
        color: var(--primary-color);
        border-color: var(--primary-glow);
    }

    .nav-pills-aura .nav-link i {
        width: 24px;
        margin-right: 12px;
    }

    .stat-box {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 24px;
        text-align: center;
        transition: all 0.3s;
    }

    .stat-box:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: var(--primary-color);
        transform: translateY(-5px);
    }

    .stat-value {
        font-size: 28px;
        font-weight: 800;
        font-family: 'Outfit';
        color: white;
    }

    .stat-label {
        font-size: 13px;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 4px;
    }

    .course-card-aura {
        background: var(--card-bg);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .course-card-aura:hover {
        transform: translateY(-10px);
        border-color: var(--primary-color);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    }

    .course-image-wrapper {
        position: relative;
        height: 180px;
        overflow: hidden;
    }

    .course-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s;
    }

    .course-card-aura:hover .course-image-wrapper img {
        transform: scale(1.1);
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

    .form-control-aura {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--glass-border);
        color: white !important;
        border-radius: 14px;
        padding: 12px 18px;
        transition: all 0.3s;
    }

    .form-control-aura:focus {
        background: rgba(255, 255, 255, 0.06);
        border-color: var(--primary-color);
        box-shadow: 0 0 15px var(--primary-glow);
    }

    .btn-aura {
        background: linear-gradient(90deg, var(--primary-color), #8b5cf6);
        border: none;
        border-radius: 14px;
        padding: 12px 24px;
        font-weight: 700;
        font-family: 'Outfit';
        color: white;
        transition: all 0.3s;
    }

    .btn-aura:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(99, 102, 241, 0.4);
    }
</style>
@endpush

<div class="profile-header fade-in">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-auto mb-4 mb-md-0">
                <div class="glass d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; border-radius: 30px; background: rgba(99, 102, 241, 0.1); border: 2px solid var(--primary-glow); font-size: 48px; color: var(--primary-color); font-family: 'Outfit'; font-weight: 800;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            </div>
            <div class="col-md">
                <h1 style="font-family: 'Outfit'; font-weight: 800; color: white; margin: 0; font-size: 42px;">{{ $user->name }}</h1>
                <div class="d-flex flex-wrap gap-3 mt-3">
                    <span class="badge glass py-2 px-3" style="color: #6366f1; border-color: rgba(99, 102, 241, 0.3);">
                        <i class="fas fa-envelope me-2"></i>{{ $user->email }}
                    </span>
                    <span class="badge glass py-2 px-3" style="color: #10b981; border-color: rgba(16, 185, 129, 0.3);">
                        <i class="fas fa-shield-alt me-2"></i>
                        @if($user->isAdmin()) Quản Trị Viên
                        @elseif($user->isInstructor()) Giáo Viên
                        @else Học Sinh
                        @endif
                    </span>
                    <span class="badge glass py-2 px-3" style="color: #f59e0b; border-color: rgba(245, 158, 11, 0.3);">
                        <i class="fas fa-calendar-alt me-2"></i>Gia nhập: {{ $user->created_at->format('d/m/Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row">
        <!-- Sidebar Navigation -->
        <div class="col-lg-3 mb-4">
            <div class="nav flex-column nav-pills nav-pills-aura" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link active" id="profile-tab" data-bs-toggle="pill" data-bs-target="#profile-content" type="button" role="tab">
                    <i class="fas fa-user-circle"></i>Thông Tin Cá Nhân
                </button>
                <button class="nav-link" id="courses-tab" data-bs-toggle="pill" data-bs-target="#courses-content" type="button" role="tab">
                    <i class="fas fa-graduation-cap"></i>Khóa Học Của Tôi
                </button>
                <button class="nav-link" id="orders-tab" data-bs-toggle="pill" data-bs-target="#orders-content" type="button" role="tab">
                    <i class="fas fa-history"></i>Lịch Sử Đơn Hàng
                </button>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="nav-link text-danger w-100" style="background: transparent; border: none;">
                        <i class="fas fa-sign-out-alt"></i>Đăng Xuất
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-lg-9">
            <div class="tab-content" id="v-pills-tabContent">
                
                <!-- Profile Info Tab -->
                <div class="tab-pane fade show active" id="profile-content" role="tabpanel">
                    <div class="row g-4">
                        <div class="col-md-8">
                            <div class="profile-card">
                                <h4 style="font-family: 'Outfit'; font-weight: 700; color: white; margin-bottom: 24px;">Cập Nhật Hồ Sơ</h4>
                                <form action="{{ route('profile.update') }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="name" class="form-label small text-muted font-weight-bold">HỌ VÀ TÊN</label>
                                        <input type="text" class="form-control-aura @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="email" class="form-label small text-muted font-weight-bold">EMAIL</label>
                                        <input type="email" class="form-control-aura @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="form-label small text-muted font-weight-bold">MẬT KHẨU MỚI (để trống để giữ nguyên)</label>
                                        <input type="password" class="form-control-aura @error('password') is-invalid @enderror" id="password" name="password">
                                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="password_confirmation" class="form-label small text-muted font-weight-bold">XÁC NHẬN MẬT KHẨU</label>
                                        <input type="password" class="form-control-aura" id="password_confirmation" name="password_confirmation">
                                    </div>
                                    <button type="submit" class="btn-aura px-5">CẬP NHẬT NGAY</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="stat-box">
                                        <div class="stat-value">{{ $user->courses()->count() }}</div>
                                        <div class="stat-label">Khóa Học</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="stat-box">
                                        <div class="stat-value">{{ $user->orders()->where('status', 'completed')->count() }}</div>
                                        <div class="stat-label">Đơn Thành Công</div>
                                    </div>
                                </div>
                                <div class="col-12 text-center mt-4">
                                    <p class="small" style="color: var(--text-muted);">Trạng thái tài khoản</p>
                                    <span class="badge rounded-pill {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                                        {{ $user->status === 'active' ? 'Hoạt Động' : 'Bị Khóa' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Purchased Courses Tab -->
                <div class="tab-pane fade" id="courses-content" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 style="font-family: 'Outfit'; font-weight: 700; color: white; margin: 0;">Khóa Học Của Tôi</h4>
                        <a href="{{ route('home') }}" class="btn btn-sm glass" style="color: var(--primary-color);">Duyệt thêm</a>
                    </div>
                    <div class="row g-4">
                        @forelse($courses as $course)
                            <div class="col-md-6">
                                <div class="course-card-aura h-100">
                                    <div class="course-image-wrapper">
                                        <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : asset('products/course' . (($course->id % 5) + 1) . '.jpg') }}" 
                                             alt="{{ $course->title }}" 
                                             onerror="this.src='https://placehold.co/600x400?text=Course'">
                                        <div class="glass position-absolute top-0 end-0 m-3 px-2 py-1 rounded-3" style="font-size: 10px; font-weight: 700; color: #10b981; background: rgba(16, 185, 129, 0.1);">
                                            ĐÃ SỞ HỮU
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <h5 class="mb-2 text-white fw-bold" style="font-family: 'Outfit'; font-size: 18px;">{{ $course->title }}</h5>
                                        <p class="text-muted small mb-3">bởi <span class="text-primary">{{ $course->instructor->name }}</span></p>
                                        <div class="d-flex justify-content-between align-items-center mt-auto">
                                            <div class="small text-muted">
                                                <i class="fas fa-video me-2"></i>{{ $course->lessons()->count() }} bài học
                                            </div>
                                            <a href="{{ route('learn.show', ['course' => $course->slug]) }}" class="btn-aura btn-sm py-2 px-3" style="font-size: 12px;">HỌC TIẾP <i class="fas fa-arrow-right ms-2"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 py-5 text-center">
                                <div class="glass p-5 rounded-4 d-inline-block">
                                    <i class="fas fa-book-open fa-3x text-muted mb-4"></i>
                                    <h5 class="text-white">Chưa có khóa học nào</h5>
                                    <p class="text-muted mb-4">Bắt đầu hành trình kiến thức của bạn ngay hôm nay!</p>
                                    <a href="{{ route('home') }}" class="btn-aura">Khám phá khóa học</a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    @if($courses->hasPages())
                        <div class="mt-5">
                            {{ $courses->links() }}
                        </div>
                    @endif
                </div>

                <!-- Order History Tab -->
                <div class="tab-pane fade" id="orders-content" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 style="font-family: 'Outfit'; font-weight: 700; color: white; margin: 0;">Lịch Sử Đơn Hàng</h4>
                        <a href="{{ route('profile.orders') }}" class="btn btn-sm glass" style="color: var(--primary-color);">Xem tất cả</a>
                    </div>
                    
                    <div class="profile-card p-0 overflow-hidden">
                        <div class="table-responsive">
                            <table class="table table-aura mb-0">
                                <thead>
                                    <tr>
                                        <th>MÃ ĐƠN</th>
                                        <th>THỜI GIAN</th>
                                        <th>KHÓA HỌC</th>
                                        <th>TỔNG TIỀN</th>
                                        <th>TRẠNG THÁI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($user->orders()->latest()->limit(5)->get() as $order)
                                        <tr>
                                            <td class="fw-bold text-white">#{{ $order->id }}</td>
                                            <td class="text-muted" style="font-size: 13px;">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="text-white small">{{ $order->items()->count() }} sản phẩm</td>
                                            <td class="text-primary fw-bold">{{ (int) $order->total_price }} VND</td>
                                            <td>
                                                @switch($order->status)
                                                    @case('awaiting')
                                                        <span class="badge glass" style="color: #94a3b8; border-color: rgba(148, 163, 184, 0.3);">Chờ xác nhận</span>
                                                        @break
                                                    @case('pending')
                                                        <span class="badge glass" style="color: #f59e0b; border-color: rgba(245, 158, 11, 0.3);">Đang xử lý</span>
                                                        @break
                                                    @case('shipping')
                                                        <span class="badge glass" style="color: #3b82f6; border-color: rgba(59, 130, 246, 0.3);">Đang giao</span>
                                                        @break
                                                    @case('completed')
                                                        <span class="badge glass" style="color: #10b981; border-color: rgba(16, 185, 129, 0.3);">Hoàn tất</span>
                                                        @break
                                                    @default
                                                        <span class="badge glass" style="color: #ef4444; border-color: rgba(239, 68, 68, 0.3);">Thất bại</span>
                                                @endswitch
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">Không tìm thấy đơn hàng nào.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
