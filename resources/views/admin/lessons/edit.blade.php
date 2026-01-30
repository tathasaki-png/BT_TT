@extends('layouts.admin')

@section('title', 'Chỉnh sửa bài học')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Khóa học</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.courses.lessons.index', $course) }}">{{ $course->title }}</a></li>
                <li class="breadcrumb-item active">Chỉnh Sửa</li>
            </ol>
        </nav>
        <h1 class="page-title">Chỉnh Sửa Bài Học</h1>
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
                <form method="POST" action="{{ route('admin.courses.lessons.update', [$course, $lesson]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tiêu đề bài học <span class="text-danger">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $lesson->title) }}" class="form-control @error('title') is-invalid @enderror" placeholder="Nhập tiêu đề bài học" required>
                        @error('title')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Video bài học</label>
                        @if($lesson->video_path)
                            <div class="mb-3 p-3 border rounded bg-light">
                                <p class="small text-muted mb-2"><i class="fas fa-film me-2"></i>Video hiện tại:</p>
                                @if(str_contains($lesson->video_path, 'http'))
                                    <div class="p-2 border rounded bg-white small">
                                        <i class="fab fa-youtube text-danger me-2"></i>
                                        <a href="{{ $lesson->video_path }}" target="_blank" class="text-decoration-none">{{ Str::limit($lesson->video_path, 60) }}</a>
                                    </div>
                                @else
                                    <video width="100%" height="auto" controls class="rounded border">
                                        <source src="{{ asset('storage/' . $lesson->video_path) }}" type="video/mp4">
                                        Trình duyệt của bạn không hỗ trợ video tag.
                                    </video>
                                @endif
                            </div>
                        @endif

                        <label class="form-label fw-bold">Cập Nhật Video (Tùy Chọn)</label>
                        
                        <ul class="nav nav-pills mb-3 small" id="videoTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active py-2 px-3" id="upload-tab" data-bs-toggle="pill" data-bs-target="#upload" type="button" role="tab">
                                    <i class="fas fa-upload me-2"></i>Upload Video Mới
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link py-2 px-3" id="url-tab" data-bs-toggle="pill" data-bs-target="#url" type="button" role="tab">
                                    <i class="fab fa-youtube me-2"></i>Link YouTube Mới
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
                                <input type="url" name="video_url" class="form-control @error('video_url') is-invalid @enderror" placeholder="https://www.youtube.com/watch?v=..." value="{{ str_contains($lesson->video_path, 'http') ? $lesson->video_path : '' }}">
                                <small class="text-muted d-block mt-2"><i class="fas fa-info-circle me-1"></i>Nhập đường dẫn đầy đủ từ YouTube</small>
                                @error('video_url')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <small class="text-muted d-block mt-2"><i class="fas fa-info-circle me-1"></i>Để trống nếu không muốn thay đổi video.</small>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_free" value="1" id="isFree" {{ old('is_free', $lesson->is_free) ? 'checked' : '' }}>
                            <label class="form-check-label" for="isFree">Cho phép học thử miễn phí</label>
                        </div>
                        <small class="text-muted d-block mt-2">Học viên chưa mua khóa cũng có thể xem bài học này</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nội dung / Ghi chú bài học</label>
                        <textarea name="content" class="form-control" rows="5" placeholder="Nhập nội dung bài học (hỗ trợ HTML)">{{ old('content', $lesson->content) }}</textarea>
                        <small class="text-muted d-block mt-2">Có thể dùng HTML để định dạng nội dung</small>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="fas fa-save me-2"></i>Lưu Thay Đổi
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
                <h5 class="mb-0"><i class="fas fa-book me-2 text-info"></i>Thông Tin Bài Học</h5>
            </div>
            <div class="card-body text-muted small">
                <p class="mb-3">
                    <strong>Bài học:</strong><br>
                    <span class="text-dark">{{ $lesson->title }}</span>
                </p>
                <p class="mb-3">
                    <strong>Khóa học:</strong><br>
                    <span class="text-dark">{{ $course->title }}</span>
                </p>
                <p class="mb-3">
                    <strong>Giảng viên:</strong><br>
                    <span class="text-dark">{{ $course->instructor->name }}</span>
                </p>
                <p class="border-top pt-3">
                    <strong>Thứ tự:</strong><br>
                    <span class="badge bg-secondary">{{ $lesson->order }}</span>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
