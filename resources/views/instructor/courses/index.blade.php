@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Khóa Học Của Tôi</h1>
        <a href="{{ route('instructor.courses.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tạo Khóa Học Mới
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0" style="border-radius: 20px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 350px;">Khóa học</th>
                        <th>Danh mục</th>
                        <th>Giá</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : asset('products/course' . (($course->id % 5) + 1) . '.jpg') }}" 
                                         class="rounded me-3" width="80" height="45" style="object-fit: cover;" alt="">
                                    <div>
                                        <div class="fw-bold text-dark">{{ $course->title }}</div>
                                        <small class="text-muted">{{ $course->lessons->count() }} bài học</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2">
                                    {{ optional($course->category)->name }}
                                </span>
                            </td>
                            <td>
                                @if($course->sale_price)
                                    <div class="fw-bold text-danger">{{ (int) $course->sale_price }} VND</div>
                                    <small class="text-decoration-line-through text-muted small">{{ (int) $course->price }} VND</small>
                                @else
                                    <div class="fw-bold">{{ (int) $course->price }} VND</div>
                                @endif
                            </td>
                            <td>
                                @if($course->status === 'published')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">Công khai</span>
                                @elseif($course->status === 'pending')
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2">Chờ duyệt</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2">Bản nháp</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group gap-2">
                                    <a href="{{ route('instructor.courses.lessons.index', $course) }}" class="btn btn-sm btn-info text-white rounded-pill px-3" title="Quản lý bài học">
                                         Quản lý bài học
                                    </a>
                                    <a href="{{ route('instructor.courses.edit', $course) }}" class="btn btn-sm btn-outline-primary rounded-pill" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('instructor.courses.destroy', $course) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa khóa học này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger rounded-pill" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="mb-3">
                                    <i class="fas fa-book-open fa-3x opacity-25"></i>
                                </div>
                                Bạn chưa tạo khóa học nào. <a href="{{ route('instructor.courses.create') }}">Bắt đầu ngay!</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white text-center py-3">
            {{ $courses->links() }}
        </div>
    </div>
</div>
@endsection
