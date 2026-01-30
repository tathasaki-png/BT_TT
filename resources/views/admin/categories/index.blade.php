@extends('layouts.admin')

@section('title', 'Quản lý danh mục')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Quản Lý Danh Mục</h1>
        <p class="page-subtitle">Quản lý tất cả danh mục khóa học trong hệ thống</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Thêm Danh Mục
    </a>
</div>

<!-- Categories Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-folder me-2 text-primary"></i>Danh Sách Danh Mục</h5>
        <span class="badge bg-primary">{{ $categories->total() ?? $categories->count() }} danh mục</span>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th width="80">ID</th>
                    <th>Tên danh mục</th>
                    <th>Slug</th>
                    <th>Số khóa học</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td><span class="fw-semibold">#{{ $category->id }}</span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="stats-icon primary me-3" style="width: 40px; height: 40px; font-size: 16px;">
                                    <i class="fas fa-folder"></i>
                                </div>
                                <span class="fw-semibold">{{ $category->name }}</span>
                            </div>
                        </td>
                        <td><code class="text-muted bg-light px-2 py-1 rounded">{{ $category->slug }}</code></td>
                        <td>
                            <span class="badge bg-info">{{ $category->courses_count ?? 0 }} khóa học</span>
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
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
                            <i class="fas fa-folder-open fa-3x mb-3 d-block"></i>
                            <p class="mb-2">Chưa có danh mục nào</p>
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>Thêm danh mục đầu tiên
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($categories->hasPages())
    <div class="card-footer bg-transparent d-flex justify-content-center">
        {{ $categories->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
