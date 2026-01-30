@extends('layouts.admin')

@section('title', 'Quản lý khóa học')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Quản Lý Khóa Học</h1>
        <p class="page-subtitle">Quản lý tất cả khóa học trong hệ thống</p>
    </div>
    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Thêm Khóa Học
    </a>
</div>

<!-- Courses Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-book me-2 text-primary"></i>Danh Sách Khóa Học</h5>
        <span class="badge bg-primary">{{ $courses->total() ?? $courses->count() }} khóa học</span>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th width="60">ID</th>
                    <th style="min-width: 280px;">Khóa học</th>
                    <th>Giảng viên</th>
                    <th>Danh mục</th>
                    <th class="text-center">Học viên</th>
                    <th>Giá</th>
                    <th>Trạng thái</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                    <tr>
                        <td><span class="fw-semibold">#{{ $course->id }}</span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : asset('products/course' . (($course->id % 5) + 1) . '.jpg') }}" 
                                     class="rounded me-3" width="60" height="40" style="object-fit: cover;" alt="">
                                <div>
                                    <div class="fw-semibold">{{ Str::limit($course->title, 35) }}</div>
                                    <small class="text-muted">{{ $course->slug }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-2" style="width: 28px; height: 28px; font-size: 11px;">
                                    {{ strtoupper(substr(optional($course->instructor)->name ?? 'N', 0, 1)) }}
                                </div>
                                <span>{{ optional($course->instructor)->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ optional($course->category)->name ?? 'N/A' }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.courses.students', $course) }}" class="text-decoration-none">
                                <span class="badge bg-info">{{ $course->students_count }}</span>
                            </a>
                        </td>
                        <td>
                            @if($course->sale_price)
                                <div class="fw-semibold text-danger">{{ (int) $course->sale_price }} VND</div>
                                <small class="text-decoration-line-through text-muted">{{ (int) $course->price }} VND</small>
                            @else
                                <div class="fw-semibold">{{ (int) $course->price }} VND</div>
                            @endif
                        </td>
                        <td>
                            @if($course->status === 'published')
                                <span class="badge bg-success">Hiển thị</span>
                            @elseif($course->status === 'pending')
                                <span class="badge bg-warning">Chờ duyệt</span>
                            @else
                                <span class="badge bg-secondary">Bản nháp</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                @if($course->status === 'pending')
                                    <form action="{{ route('admin.courses.approve', $course) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success" title="Duyệt">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('admin.courses.students', $course) }}" class="btn btn-sm btn-outline-warning" title="Học viên">
                                    <i class="fas fa-users"></i>
                                </a>
                                <a href="{{ route('admin.courses.lessons.index', $course) }}" class="btn btn-sm btn-outline-info" title="Bài học">
                                    <i class="fas fa-list-ol"></i>
                                </a>
                                <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-outline-primary" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.courses.toggleStatus', $course) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-secondary" title="{{ $course->status === 'published' ? 'Gỡ xuống' : 'Xuất bản' }}">
                                        <i class="fas fa-{{ $course->status === 'published' ? 'eye-slash' : 'eye' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa khóa học này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-book-open fa-3x mb-3 d-block"></i>
                            <p class="mb-2">Chưa có khóa học nào</p>
                            <a href="{{ route('admin.courses.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>Thêm khóa học đầu tiên
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($courses->hasPages())
    <div class="card-footer bg-transparent d-flex justify-content-center">
        {{ $courses->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
