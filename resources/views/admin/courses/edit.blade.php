@extends('layouts.admin')

@section('title', 'Chỉnh sửa khóa học')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Khóa học</a></li>
                <li class="breadcrumb-item active">Chỉnh sửa</li>
            </ol>
        </nav>
        <h1 class="page-title">Chỉnh Sửa Khóa Học</h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-edit me-2 text-primary"></i>Thông Tin Khóa Học</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.courses.update', $course) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="form-label">Tên khóa học <span class="text-danger">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $course->title) }}" 
                               class="form-control @error('title') is-invalid @enderror" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted"><i class="fas fa-link me-1"></i>Slug: <code>{{ $course->slug }}</code></small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Danh mục <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $course->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
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
                                    <option value="{{ $instr->id }}" {{ old('instructor_id', $course->instructor_id) == $instr->id ? 'selected' : '' }}>{{ $instr->name }}</option>
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
                            <input type="number" name="price" value="{{ old('price', (int) $course->price) }}"
                                   class="form-control @error('price') is-invalid @enderror" required min="0" step="1" inputmode="numeric" pattern="\d+">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Giảm giá (%)</label>
                            @php
                                $computedDiscount = 0;
                                $priceVal = (float) ($course->price ?? 0);
                                if ($priceVal > 0 && $course->sale_price !== null) {
                                    $computedDiscount = (int) round((1 - ((float) $course->sale_price / $priceVal)) * 100);
                                }
                            @endphp
                            <input type="number" name="discount_percent" value="{{ old('discount_percent', $computedDiscount) }}"
                                   class="form-control @error('discount_percent') is-invalid @enderror" min="0" max="100" step="1" inputmode="numeric" pattern="\d+">
                            @error('discount_percent')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="draft" {{ old('status', $course->status) === 'draft' ? 'selected' : '' }}>Bản nháp</option>
                                <option value="published" {{ old('status', $course->status) === 'published' ? 'selected' : '' }}>Xuất bản</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Ảnh bìa (Thumbnail)</label>
                        @if($course->thumbnail)
                            <div class="mb-3 p-3 bg-light rounded">
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="thumb" class="rounded" style="max-height: 150px;">
                                <p class="mb-0 mt-2 small text-muted">Ảnh hiện tại</p>
                            </div>
                        @endif
                        <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
                        @error('thumbnail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Để trống nếu không muốn thay đổi ảnh</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Mô tả ngắn</label>
                        <textarea name="short_description" class="form-control" rows="3" 
                                  placeholder="Mô tả ngắn gọn về khóa học...">{{ old('short_description', $course->short_description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Nội dung chi tiết</label>
                        <textarea name="content" class="form-control" rows="6" 
                                  placeholder="Nội dung chi tiết về khóa học...">{{ old('content', $course->content) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Hủy bỏ
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2 text-info"></i>Thông Tin</h5>
            </div>
            <div class="card-body">
                <div class="mb-3 pb-3 border-bottom">
                    <small class="text-muted d-block">ID Khóa học</small>
                    <span class="fw-semibold">#{{ $course->id }}</span>
                </div>
                <div class="mb-3 pb-3 border-bottom">
                    <small class="text-muted d-block">Ngày tạo</small>
                    <span class="fw-semibold">{{ $course->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="mb-0">
                    <small class="text-muted d-block">Cập nhật lần cuối</small>
                    <span class="fw-semibold">{{ $course->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-list me-2 text-warning"></i>Bài Học</h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">Quản lý các bài học của khóa học này</p>
                <a href="{{ route('admin.courses.lessons.index', $course) }}" class="btn btn-outline-primary w-100">
                    <i class="fas fa-list-ol me-2"></i>Quản lý bài học
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

