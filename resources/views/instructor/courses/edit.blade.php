@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('instructor.courses.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="h3 mb-0">Chỉnh Sửa Khóa Học</h1>
            </div>

            <div class="card shadow-sm border-0" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('instructor.courses.update', $course) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-bold">Tên khóa học <span class="text-danger">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $course->title) }}" 
                                   class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                   placeholder="VD: Thành thạo ReactJS trong 30 ngày" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Danh mục <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id', $course->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Ảnh bìa (Thumbnail)</label>
                                @if($course->thumbnail)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="" class="img-thumbnail" style="max-height: 150px;">
                                    </div>
                                @endif
                                <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
                                @error('thumbnail')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Giá gốc (VNĐ) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="price" value="{{ old('price', $course->price) }}" class="form-control @error('price') is-invalid @enderror" required>
                                    <span class="input-group-text">VND</span>
                                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Giảm giá (%)</label>
                                <div class="input-group">
                                    <input type="number" name="discount_percent" value="{{ old('discount_percent') }}" min="0" max="100" class="form-control @error('discount_percent') is-invalid @enderror">
                                    <span class="input-group-text">%</span>
                                    @error('discount_percent')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <small class="text-muted">Nhập phần trăm giảm giá từ giá gốc (0-100). Để trống nếu không giảm giá.</small>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Mô tả ngắn <span class="text-danger">*</span></label>
                            <textarea name="short_description" class="form-control @error('short_description') is-invalid @enderror" 
                                      rows="3" placeholder="Tóm tắt nội dung khóa học..." required>{{ old('short_description', $course->short_description) }}</textarea>
                            @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Nội dung chi tiết <span class="text-danger">*</span></label>
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror" 
                                      rows="10" placeholder="Chi tiết khóa học..." required>{{ old('content', $course->content) }}</textarea>
                            @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="alert alert-warning border-0 shadow-sm" style="border-radius: 12px;">
                            <i class="fas fa-exclamation-triangle me-2"></i> Lưu ý: Khi bạn cập nhật khóa học, trạng thái sẽ chuyển về <strong>Chờ duyệt</strong> để admin kiểm tra lại nội dung trước khi xuất bản bản cập nhật.
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('instructor.courses.index') }}" class="btn btn-outline-secondary px-5 py-3 fw-bold" style="border-radius: 12px;">Hủy bỏ</a>
                            <button type="submit" class="btn btn-primary px-5 py-3 fw-bold" style="border-radius: 12px; background: linear-gradient(135deg, #6366f1, #a855f7); border: none;">
                                Cập nhật & Gửi duyệt lại
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
