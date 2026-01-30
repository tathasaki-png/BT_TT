@extends('layouts.admin')

@section('title', 'Quản lý sliders')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Quản Lý Sliders</h1>
        <p class="page-subtitle">Quản lý các hình ảnh trình chiếu trên trang chủ</p>
    </div>
    <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Thêm Slider
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Sliders Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-images me-2 text-primary"></i>Danh Sách Sliders</h5>
        <span class="badge bg-primary">{{ $sliders->count() }} sliders</span>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th width="100">Hình ảnh</th>
                    <th>Thông tin slider</th>
                    <th>Thứ tự</th>
                    <th>Trạng thái</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sliders as $slider)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/' . $slider->image) }}" alt="Slider" class="rounded" style="width: 90px; height: 55px; object-fit: cover;">
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $slider->title ?? 'Không có tiêu đề' }}</div>
                            <small class="text-muted d-block">{{ Str::limit($slider->description, 60) }}</small>
                            @if($slider->link)
                                <small class="text-primary"><i class="fas fa-link me-1"></i>{{ $slider->link }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $slider->order }}</span>
                        </td>
                        <td>
                            @if($slider->status)
                                <span class="badge bg-success"><i class="fas fa-eye me-1"></i>Đang hiển thị</span>
                            @else
                                <span class="badge bg-secondary"><i class="fas fa-eye-slash me-1"></i>Đang ẩn</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa slider này?');">
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
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-image fa-3x mb-3 d-block"></i>
                            <p class="mb-2">Chưa có slider nào</p>
                            <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>Thêm slider đầu tiên
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
