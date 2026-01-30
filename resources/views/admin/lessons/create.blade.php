@extends('layouts.admin')

@section('title', 'Thêm bài học mới')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Khóa học</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.courses.lessons.index', $course) }}">{{ $course->title }}</a></li>
                <li class="breadcrumb-item active">Thêm Bài Học</li>
            </ol>
        </nav>
        <h1 class="page-title">Thêm Bài Học Mới</h1>
    </div>
    <a href="{{ route('admin.courses.lessons.index', $course) }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Quay lại
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-graduation-cap me-2 text-primary"></i>Thông Tin Bài Học</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.courses.lessons.store', $course) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tiêu đề bài học <span class="text-danger">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" placeholder="Nhập tiêu đề bài học" required>
                        @error('title')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Video bài học <span class="text-danger">*</span></label>
                        
                        <ul class="nav nav-pills mb-3 small" id="videoTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active py-2 px-3" id="upload-tab" data-bs-toggle="pill" data-bs-target="#upload" type="button" role="tab">
                                    <i class="fas fa-upload me-2"></i>Upload Video
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link py-2 px-3" id="url-tab" data-bs-toggle="pill" data-bs-target="#url" type="button" role="tab">
                                    <i class="fab fa-youtube me-2"></i>Link YouTube
                                </button>
                            </li>
                        </ul>
                        
                        <div class="tab-content" id="videoTabContent">
                            <div class="tab-pane fade show active" id="upload" role="tabpanel">
                                <input type="file" name="video" class="form-control @error('video') is-invalid @enderror" accept="video/*">
                                <small class="text-muted d-block mt-2"><i class="fas fa-info-circle me-1"></i>Định dạng hỗ trợ: mp4, mkv (Tối đa 500MB)</small>
                                @error('video')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="tab-pane fade" id="url" role="tabpanel">
                                <input type="url" name="video_url" class="form-control @error('video_url') is-invalid @enderror" placeholder="https://www.youtube.com/watch?v=...">
                                <small class="text-muted d-block mt-2"><i class="fas fa-info-circle me-1"></i>Nhập đường dẫn đầy đủ từ YouTube</small>
                                @error('video_url')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        @if($errors->has('video') || $errors->has('video_url'))
                            <div class="text-danger small mt-2"><i class="fas fa-exclamation-circle me-1"></i>Vui lòng cung cấp file video hoặc đường dẫn YouTube.</div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_free" value="1" id="isFree" {{ old('is_free') ? 'checked' : '' }}>
                            <label class="form-check-label" for="isFree">Cho phép học thử miễn phí</label>
                        </div>
                        <small class="text-muted d-block mt-2">Học viên chưa mua khóa cũng có thể xem bài học này</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nội dung / Ghi chú bài học</label>
                        <textarea name="content" class="form-control" rows="5" placeholder="Nhập nội dung bài học (hỗ trợ HTML)">{{ old('content') }}</textarea>
                        <small class="text-muted d-block mt-2">Có thể dùng HTML để định dạng nội dung</small>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="fas fa-plus me-2"></i>Thêm Bài Học
                        </button>
                        <a href="{{ route('admin.courses.lessons.index', $course) }}" class="btn btn-outline-secondary">
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
                <h5 class="mb-0"><i class="fas fa-book me-2 text-info"></i>Thông Tin Khóa Học</h5>
            </div>
            <div class="card-body text-muted small">
                <p class="mb-3">
                    <strong>Khóa học:</strong><br>
                    <span class="text-dark">{{ $course->title }}</span>
                </p>
                <p class="mb-3">
                    <strong>Giảng viên:</strong><br>
                    <span class="text-dark">{{ $course->instructor->name }}</span>
                </p>
                <p>
                    <strong>Danh mục:</strong><br>
                    <span class="badge bg-primary">{{ $course->category->name }}</span>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
