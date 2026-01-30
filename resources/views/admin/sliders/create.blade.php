@extends('layouts.admin')

@section('title', 'Thêm slider mới')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.sliders.index') }}">Sliders</a></li>
                <li class="breadcrumb-item active">Thêm Mới</li>
            </ol>
        </nav>
        <h1 class="page-title">Thêm Slider Mới</h1>
    </div>
    <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Quay lại
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-images me-2 text-primary"></i>Thông Tin Slider</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tiêu đề (Tùy chọn)</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Nhập tiêu đề slider">
                        @error('title')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Mô tả (Tùy chọn)</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Nhập mô tả slider">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Hình ảnh <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" required>
                        <small class="text-muted">Kích thước khuyên dùng: 1200×400 pixels</small>
                        @error('image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Liên kết (Tùy chọn)</label>
                        <input type="text" name="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}" placeholder="https://example.com/course/...">
                        @error('link')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Thứ tự hiển thị</label>
                            <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}" min="0">
                            @error('order')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Trạng thái</label>
                            <div class="form-check form-switch pt-2">
                                <input class="form-check-input" type="checkbox" name="status" id="status" value="1" checked>
                                <label class="form-check-label" for="status">Hiển thị slider này</label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="fas fa-save me-2"></i>Lưu Slider
                        </button>
                        <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary">
                            Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-lightbulb me-2 text-warning"></i>Hướng Dẫn</h5>
            </div>
            <div class="card-body">
                <p class="text-muted small"><strong>Tiêu đề:</strong> Tiêu đề slider sẽ được hiển thị trên hình ảnh (tùy chọn)</p>
                <p class="text-muted small"><strong>Hình ảnh:</strong> Kích thước tối ưu là 1200×400 pixels để hiển thị tốt trên mọi thiết bị</p>
                <p class="text-muted small"><strong>Liên kết:</strong> Người dùng sẽ được chuyển hướng tới URL này khi click vào slider</p>
                <p class="text-muted small"><strong>Thứ tự:</strong> Số nhỏ hiển thị trước, số lớn hiển thị sau</p>
                <p class="text-muted small"><strong>Trạng thái:</strong> Slider phải được bật để hiển thị trên trang chủ</p>
            </div>
        </div>
    </div>
</div>
@endsection
