@extends('layouts.admin')

@section('title', 'Chỉnh sửa slider')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.sliders.index') }}">Sliders</a></li>
                <li class="breadcrumb-item active">Chỉnh Sửa</li>
            </ol>
        </nav>
        <h1 class="page-title">Chỉnh Sửa Slider</h1>
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
                <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tiêu đề (Tùy chọn)</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $slider->title) }}" placeholder="Nhập tiêu đề slider">
                        @error('title')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Mô tả (Tùy chọn)</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Nhập mô tả slider">{{ old('description', $slider->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Hình ảnh hiện tại</label>
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $slider->image) }}" alt="Slider" class="rounded" style="max-height: 200px; width: 100%; object-fit: cover;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Thay đổi hình ảnh</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        <small class="text-muted">Để trống nếu không muốn thay đổi. Kích thước khuyên dùng: 1200×400 pixels</small>
                        @error('image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Liên kết (Tùy chọn)</label>
                        <input type="text" name="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link', $slider->link) }}" placeholder="https://example.com/course/...">
                        @error('link')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Thứ tự hiển thị</label>
                            <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $slider->order) }}" min="0">
                            @error('order')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Trạng thái</label>
                            <div class="form-check form-switch pt-2">
                                <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ $slider->status ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">Hiển thị slider này</label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="fas fa-save me-2"></i>Cập Nhật Slider
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
                <h5 class="mb-0"><i class="fas fa-info-circle me-2 text-info"></i>Thông Tin Slider</h5>
            </div>
            <div class="card-body text-muted small">
                <p><strong>ID:</strong> {{ $slider->id }}</p>
                <p><strong>Tạo lúc:</strong> {{ $slider->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Cập nhật:</strong> {{ $slider->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
