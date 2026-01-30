@extends('layouts.app')

@section('content')
    <style>
        .stat-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 16px;
        }

        .stat-icon.primary {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(168, 85, 247, 0.2));
            color: #6366f1;
        }

        .stat-icon.success {
            background: #d1fae5;
            color: #059669;
        }

        .stat-icon.warning {
            background: #fed7aa;
            color: #d97706;
        }

        .stat-icon.danger {
            background: #fecaca;
            color: #dc2626;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 14px;
            color: #64748b;
        }

        .chart-container {
            background: white;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
        }

        .order-item {
            display: flex;
            align-items: center;
            padding: 16px;
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.2s;
        }

        .order-item:hover {
            background: #f9fafb;
        }

        .course-badge {
            display: inline-block;
            background: #e0e7ff;
            color: #4338ca;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 8px;
        }
    </style>

    <div class="glass p-4 mb-4 fade-in"
        style="background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.05)); border: 1px solid var(--glass-border); border-radius: 24px;">
        <h1 style="font-family: 'Outfit'; font-size: 32px; font-weight: 800; margin: 0; color: white;">
            <i class="fas fa-chart-line me-3" style="color: var(--primary-color);"></i> Bảng Điều Khiển <span
                style="color: var(--primary-color)">Giảng Viên</span>
        </h1>
        <p class="text-muted mt-2 mb-0">Quản lý khóa học và theo dõi tiến độ sinh viên từ trung tâm điều khiển Aura</p>
    </div>

    <div class="container-fluid px-lg-4" style="max-width: 1400px; margin: 0 auto;">
        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon primary">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-number">{{ $totalCourses }}</div>
                    <div class="stat-label">Tổng Khóa Học</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon success">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number">{{ $totalStudents }}</div>
                    <div class="stat-label">Tổng Sinh Viên</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon warning">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-number">{{ (int) $totalRevenue }} VND</div>
                    <div class="stat-label">Tổng Doanh Thu</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon danger">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-number">{{ $recentOrders->count() }}</div>
                    <div class="stat-label">Đơn Hàng Gần Đây</div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="chart-container">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-chart-bar text-primary me-2"></i> Doanh Thu Theo Tháng
                    </h5>
                    <canvas id="revenueChart" height="80"></canvas>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="chart-container">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-pie-chart text-primary me-2"></i> Phân Bố Khóa Học
                    </h5>
                    <canvas id="courseChart" height="80"></canvas>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row g-4">
            <!-- Top Courses -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-star text-warning me-2"></i> Khóa Học Hàng Đầu
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @forelse($topCourses as $item)
                            <div class="order-item">
                                <div class="flex-grow-1">
                                    <div class="fw-bold" style="color: #0f172a;">{{ $item['course']->title }}</div>
                                    <div class="course-badge">{{ $item['students'] }} sinh viên</div>
                                    <div style="font-size: 13px; color: #6366f1; font-weight: 600;">
                                        {{ (int) $item['revenue'] }} VND doanh thu
                                    </div>
                                </div>
                                <div style="text-align: right; min-width: 80px;">
                                    <a href="{{ route('instructor.courses.edit', $item['course']) }}"
                                        class="btn btn-sm btn-outline-primary rounded-2" style="font-size: 12px;">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div style="padding: 40px; text-align: center; color: #94a3b8;">
                                <i class="fas fa-inbox" style="font-size: 32px; opacity: 0.5; margin-bottom: 12px;"></i>
                                <p>Chưa có khóa học nào</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-shopping-cart text-success me-2"></i> Đơn Hàng Gần Đây
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @forelse($recentOrders as $item)
                            <div class="order-item">
                                <div class="flex-grow-1">
                                    <div class="fw-bold" style="color: #0f172a;">{{ $item->course->title }}</div>
                                    <div class="course-badge">Từ {{ $item->order->user->name }}</div>
                                    <div style="font-size: 13px; color: #64748b;">
                                        {{ $item->order->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                <div style="text-align: right; font-weight: 700; color: #059669; min-width: 100px;">
                                    {{ (int) $item->price }} VND
                                </div>
                            </div>
                        @empty
                            <div style="padding: 40px; text-align: center; color: #94a3b8;">
                                <i class="fas fa-inbox" style="font-size: 32px; opacity: 0.5; margin-bottom: 12px;"></i>
                                <p>Chưa có đơn hàng nào</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div
            style="margin-top: 32px; padding: 24px; background: white; border-radius: 16px; border: 1px solid #e2e8f0; display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('instructor.courses.create') }}" class="btn btn-primary rounded-3">
                <i class="fas fa-plus me-2"></i> Tạo Khóa Học Mới
            </a>
            <a href="{{ route('instructor.courses.index') }}" class="btn btn-outline-primary rounded-3">
                <i class="fas fa-book me-2"></i> Quản Lý Khóa Học
            </a>
            <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary rounded-3">
                <i class="fas fa-user me-2"></i> Hồ Sơ Cá Nhân
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart');
            if (revenueCtx) {
                const data = @json($monthlyRevenue);
                new Chart(revenueCtx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(data),
                        datasets: [{
                            label: 'Doanh Thu',
                            data: Object.values(data),
                            backgroundColor: 'rgba(99, 102, 241, 0.8)',
                            borderColor: '#6366f1',
                            borderWidth: 0,
                            borderRadius: 8,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function (value) {
                                        return (value / 1000000).toFixed(1) + 'M';
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Course Distribution Chart
            const courseCtx = document.getElementById('courseChart');
            if (courseCtx) {
                const colors = ['#6366f1', '#a855f7', '#ec4899', '#f59e0b', '#10b981'];
                new Chart(courseCtx, {
                    type: 'doughnut',
                    data: {
                        labels: @json($topCourses->pluck('course.title')),
                        datasets: [{
                            data: @json($topCourses->pluck('students')),
                            backgroundColor: colors.slice(0, @json($topCourses->count()))
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection