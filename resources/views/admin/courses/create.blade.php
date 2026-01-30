@extends('layouts.admin')

@section('title', 'Thêm khóa học')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Khóa học</a></li>
                <li class="breadcrumb-item active">Thêm mới</li>
            </ol>
        </nav>
        <h1 class="page-title">Thêm Khóa Học Mới</h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-book me-2 text-primary"></i>Thông Tin Khóa Học</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label">Tên khóa học <span class="text-danger">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" 
                               class="form-control @error('title') is-invalid @enderror" 
                               placeholder="Nhập tên khóa học..." required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Slug sẽ được tự động tạo dựa trên tên khóa học</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Danh mục <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Giảng viên <span class="text-danger">*</span></label>
                            <select name="instructor_id" class="form-select @error('instructor_id') is-invalid @enderror" required>
                                <option value="">-- Chọn giảng viên --</option>
                                @foreach($instructors as $instr)
                                    <option value="{{ $instr->id }}" {{ old('instructor_id') == $instr->id ? 'selected' : '' }}>{{ $instr->name }}</option>
                                @endforeach
                            </select>
                            @error('instructor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Giá gốc (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" name="price" value="{{ old('price', 0) }}" 
                                   class="form-control @error('price') is-invalid @enderror" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Giảm giá (%)</label>
                            <input type="number" name="discount_percent" value="{{ old('discount_percent', 0) }}"
                                   class="form-control @error('discount_percent') is-invalid @enderror" min="0" max="100">
                            @error('discount_percent')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Bản nháp</option>
                                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Xuất bản</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Ảnh bìa (Thumbnail)</label>
                        <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
                        @error('thumbnail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Định dạng: JPG, PNG. Tối đa 2MB</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Mô tả ngắn</label>
                        <textarea name="short_description" class="form-control" rows="3" 
                                  placeholder="Mô tả ngắn gọn về khóa học...">{{ old('short_description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Nội dung chi tiết</label>
                        <textarea name="content" class="form-control" rows="6" 
                                  placeholder="Nội dung chi tiết về khóa học...">{{ old('content') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Hủy bỏ
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Thêm khóa học
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2 text-info"></i>Hướng Dẫn</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong>Tên khóa học:</strong> Nên ngắn gọn, rõ ràng và hấp dẫn
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong>Ảnh bìa:</strong> Kích thước khuyến nghị 1280x720px
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong>Mô tả ngắn:</strong> Tối đa 200 ký tự
                    </li>
                    <li class="mb-0">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong>Giá khuyến mãi:</strong> Để trống nếu không có khuyến mãi
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
