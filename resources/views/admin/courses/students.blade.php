@extends('layouts.admin')

@section('title', 'Học viên khóa học: ' . $course->title)

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Khóa học</a></li>
                <li class="breadcrumb-item active">{{ Str::limit($course->title, 40) }}</li>
            </ol>
        </nav>
        <h1 class="page-title">Quản Lý Học Viên</h1>
    </div>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Quay lại
    </a>
</div>

<!-- Course Info Card -->
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : asset('products/course' . (($course->id % 5) + 1) . '.jpg') }}" 
                 class="rounded me-3" width="100" height="60" style="object-fit: cover;" alt="">
            <div>
                <h4 class="mb-1">{{ $course->title }}</h4>
                <div class="text-muted small">
                    <span class="me-3"><i class="fas fa-user-tie me-1"></i>{{ optional($course->instructor)->name }}</span>
                    <span class="me-3"><i class="fas fa-users me-1"></i>{{ $students->total() }} học viên đăng ký</span>
                    <span><i class="fas fa-calendar-alt me-1"></i>Ngày tạo: {{ $course->created_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Students Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-users me-2 text-primary"></i>Danh Sách Học Viên</h5>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Người dùng</th>
                    <th>Email</th>
                    <th>Ngày đăng ký</th>
                    <th>Trạng thái</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3">
                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                </div>
                                <div class="fw-semibold">{{ $student->name }}</div>
                            </div>
                        </td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->pivot->created_at ? $student->pivot->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                        <td>
                            @if($student->status === 'active')
                                <span class="badge bg-success">Hoạt động</span>
                            @else
                                <span class="badge bg-secondary">Bị khóa</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="{{ route('admin.users.edit', $student) }}" class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                                {{-- Optionally add a button to remove student from course --}}
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-users fa-3x mb-3 d-block"></i>
                            <p class="mb-0">Chưa có học viên nào đăng ký khóa học này</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($students->hasPages())
    <div class="card-footer bg-transparent d-flex justify-content-center">
        {{ $students->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
