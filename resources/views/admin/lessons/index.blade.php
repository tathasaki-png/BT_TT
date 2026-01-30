@extends('layouts.admin')

@section('title', 'Quản lý bài học')

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
            <h1 class="page-title">Danh Sách Bài Học</h1>
        </div>
        <a href="{{ route('admin.courses.lessons.create', $course) }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Thêm Bài Học Mới
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Lessons Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-list-ol me-2 text-primary"></i>Danh Sách Bài Học</h5>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width="80">STT</th>
                        <th>Tiêu đề bài học</th>
                        <th>Video</th>
                        <th width="150">Thứ tự</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lessons as $lesson)
                        <tr>
                            <td><span class="fw-semibold">#{{ $lesson->position }}</span></td>
                            <td>
                                <div>
                                    <div class="fw-semibold">{{ $lesson->title }}</div>
                                    @if($lesson->is_free)
                                        <span class="badge bg-success mt-1">Miễn phí</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($lesson->video_path)
                                    <a href="{{ str_starts_with($lesson->video_path, 'http') ? $lesson->video_path : asset('storage/' . $lesson->video_path) }}"
                                        target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-play-circle me-1"></i>Xem video
                                    </a>
                                @else
                                    <span class="text-muted small"><i class="fas fa-times me-1"></i>Chưa có video</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <form action="{{ route('admin.courses.lessons.moveUp', [$course, $lesson]) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button class="btn btn-outline-secondary" {{ $loop->first ? 'disabled' : '' }}
                                            title="Lên">
                                            <i class="fas fa-chevron-up"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.courses.lessons.moveDown', [$course, $lesson]) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-outline-secondary" {{ $loop->last ? 'disabled' : '' }}
                                            title="Xuống">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('admin.lessons.questions.index', $lesson) }}"
                                        class="btn btn-sm btn-outline-warning" title="Câu hỏi">
                                        <i class="fas fa-question-circle"></i>
                                    </a>
                                    <a href="{{ route('admin.courses.lessons.edit', [$course, $lesson]) }}"
                                        class="btn btn-sm btn-outline-primary" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.courses.lessons.destroy', [$course, $lesson]) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài học này?');">
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
                                <i class="fas fa-book-open fa-3x mb-3 d-block"></i>
                                <p class="mb-2">Chưa có bài học nào cho khóa học này</p>
                                <a href="{{ route('admin.courses.lessons.create', $course) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus me-1"></i>Thêm bài học đầu tiên
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection