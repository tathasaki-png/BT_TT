@extends('layouts.admin')

@section('title', 'Quản lý người dùng')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Quản Lý Người Dùng</h1>
        <p class="page-subtitle">Quản lý tài khoản học viên, giảng viên và quản trị viên</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Thêm Người Dùng
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-transparent"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="q" class="form-control" placeholder="Tìm theo tên hoặc email..." value="{{ request('q') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="role" class="form-select">
                    <option value="">Tất cả vai trò</option>
                    <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Học viên</option>
                    <option value="instructor" {{ request('role') == 'instructor' ? 'selected' : '' }}>Giảng viên</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Tất cả trạng thái</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Đang hoạt động</option>
                    <option value="blocked" {{ request('status') == 'blocked' ? 'selected' : '' }}>Bị khóa</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="fas fa-filter me-1"></i>Lọc
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-users me-2 text-primary"></i>Danh Sách Người Dùng</h5>
        <span class="badge bg-primary">{{ $users->total() ?? $users->count() }} người dùng</span>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Người dùng</th>
                    <th>Vai trò</th>
                    <th>Trạng thái</th>
                    <th>Ngày tham gia</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $user->name }}</div>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-danger">Quản trị viên</span>
                            @elseif($user->role === 'instructor')
                                <span class="badge bg-info">Giảng viên</span>
                            @else
                                <span class="badge bg-primary">Học viên</span>
                            @endif
                        </td>
                        <td>
                            @if($user->status === 'active')
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>Hoạt động
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="fas fa-ban me-1"></i>Bị khóa
                                </span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form action="{{ route('admin.users.toggleStatus', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $user->status === 'active' ? 'btn-outline-warning' : 'btn-outline-success' }}" 
                                            title="{{ $user->status === 'active' ? 'Khóa tài khoản' : 'Mở khóa' }}">
                                        <i class="fas fa-{{ $user->status === 'active' ? 'lock' : 'lock-open' }}"></i>
                                    </button>
                                </form>

                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-users fa-3x mb-3 d-block"></i>
                            <p class="mb-0">Không tìm thấy người dùng nào</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="card-footer bg-transparent d-flex justify-content-center">
        {{ $users->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
