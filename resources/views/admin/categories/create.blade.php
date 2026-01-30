@extends('layouts.admin')

@section('title', 'Thêm danh mục')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Danh mục</a></li>
                <li class="breadcrumb-item active">Thêm mới</li>
            </ol>
        </nav>
        <h1 class="page-title">Thêm Danh Mục Mới</h1>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-folder-plus me-2 text-primary"></i>Thông Tin Danh Mục</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" 
                               class="form-control @error('name') is-invalid @enderror" 
                               placeholder="Nhập tên danh mục..." required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted mt-1 d-block">
                            <i class="fas fa-info-circle me-1"></i>Slug sẽ được tự động tạo dựa trên tên danh mục
                        </small>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Hủy bỏ
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Thêm danh mục
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

