@extends('layouts.admin')

@section('title', 'Quản lý câu hỏi')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Khóa học</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.courses.lessons.index', $lesson->course_id) }}">{{ $lesson->course->title }}</a></li>
                <li class="breadcrumb-item active">{{ $lesson->title }}</li>
            </ol>
        </nav>
        <h1 class="page-title">Quản Lý Câu Hỏi</h1>
        <p class="page-subtitle">{{ $lesson->title }}</p>
    </div>
    <a href="{{ route('admin.courses.lessons.index', $lesson->course_id) }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Quay lại
    </a>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-question-circle me-2 text-primary"></i>Thêm Câu Hỏi Mới</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.lessons.questions.store', $lesson) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nội dung câu hỏi <span class="text-danger">*</span></label>
                        <textarea name="question_text" class="form-control @error('question_text') is-invalid @enderror" rows="4" required placeholder="Nhập câu hỏi tại đây..."></textarea>
                        @error('question_text')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold d-block">Các lựa chọn <span class="text-danger">*</span></label>
                        <small class="text-muted d-block mb-2">Chọn (radio) câu trả lời đúng</small>
                        @for($i=0; $i<4; $i++)
                            <div class="input-group mb-2">
                                <div class="input-group-text" style="border-right: 0;">
                                    <input class="form-check-input mt-0" type="radio" name="correct_option" value="{{ $i }}" {{ $i == 0 ? 'checked' : '' }} required>
                                </div>
                                <input type="text" name="options[]" class="form-control" placeholder="Lựa chọn {{ $i + 1 }}" {{ $i < 2 ? 'required' : '' }}>
                            </div>
                        @endfor
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>Lưu Câu Hỏi
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-list me-2 text-primary"></i>Danh Sách Câu Hỏi</h5>
                <span class="badge bg-primary">{{ $lesson->questions->count() }} câu</span>
            </div>
            <div class="card-body p-0">
                @forelse($lesson->questions as $index => $question)
                    <div class="p-4 border-bottom {{ $loop->last ? 'border-bottom-0' : '' }}">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-0"><span class="badge bg-light text-dark me-2">{{ $index + 1 }}</span>{{ $question->question_text }}</h6>
                            </div>
                            <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" class="ms-2" onsubmit="return confirm('Bạn có chắc chắn muốn xóa câu hỏi này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                        <div class="row g-2 mt-2">
                            @foreach($question->options as $option)
                                <div class="col-md-6">
                                    <div class="p-2 border rounded small {{ $option->is_correct ? 'bg-success-subtle border-success text-success' : 'bg-light' }}">
                                        @if($option->is_correct)
                                            <i class="fas fa-check-circle me-2"></i><strong>{{ $option->option_text ?: '(Trống)' }}</strong>
                                        @else
                                            <i class="far fa-circle text-muted me-2"></i>{{ $option->option_text ?: '(Trống)' }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="p-5 text-center text-muted">
                        <i class="fas fa-question-circle fa-4x mb-3" style="opacity: 0.3;"></i>
                        <p>Chưa có câu hỏi nào cho bài học này.</p>
                        <small>Thêm câu hỏi đầu tiên bằng form bên trái</small>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
