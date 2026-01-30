@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Đơn hàng</a></li>
                <li class="breadcrumb-item active">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</li>
            </ol>
        </nav>
        <h1 class="page-title">Chi Tiết Đơn Hàng</h1>
    </div>
    <div class="d-flex gap-2">
        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này? Thao tác này không thể hoàn tác.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">
                <i class="fas fa-trash-alt me-2"></i>Xóa đơn hàng
            </button>
        </form>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Quay lại
        </a>
    </div>
</div>

<div class="row">
    <!-- Order Items -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-shopping-bag me-2 text-primary"></i>Khóa Học Trong Đơn Hàng</h5>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Khóa học</th>
                            <th>Giảng viên</th>
                            <th class="text-end">Giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $item->course->thumbnail ? asset('storage/' . $item->course->thumbnail) : asset('products/course' . (($item->course->id % 5) + 1) . '.jpg') }}" 
                                             class="rounded me-3" width="50" height="35" style="object-fit: cover;" alt="">
                                        <div class="fw-semibold">{{ $item->course->title }}</div>
                                    </div>
                                </td>
                                <td>{{ $item->course->instructor->name }}</td>
                                <td class="text-end fw-semibold">{{ (int) $item->price }} VND</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-light fw-bold">
                            <td colspan="2" class="text-end">Tổng cộng:</td>
                            <td class="text-end" style="font-size: 18px; color: var(--primary-color);">{{ (int) $order->total_price }} VND</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Order Info -->
    <div class="col-lg-4">
        <!-- Customer Info -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user me-2 text-primary"></i>Thông Tin Khách Hàng</h5>
            </div>
            <div class="card-body">
                <div class="mb-3 pb-3 border-bottom">
                    <small class="text-muted d-block mb-1">Họ tên</small>
                    <span class="fw-semibold">{{ $order->user->name }}</span>
                </div>
                <div class="mb-3 pb-3 border-bottom">
                    <small class="text-muted d-block mb-1">Email</small>
                    <a href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a>
                </div>
                <div class="mb-0">
                    <small class="text-muted d-block mb-1">Ngày tham gia</small>
                    <span class="fw-semibold">{{ $order->user->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Order Status -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2 text-primary"></i>Trạng Thái Đơn Hàng</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Mã đơn hàng</small>
                    <span class="fw-semibold">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Phương thức thanh toán</small>
                    @if($order->payment_method == 'vnpay')
                        <span class="badge bg-primary">VNPay</span>
                    @elseif($order->payment_method == 'bank_transfer')
                        <span class="badge bg-info">Chuyển khoản</span>
                    @else
                        <span class="badge bg-secondary">Tiền mặt (COD)</span>
                    @endif
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block mb-2">Trạng thái</small>
                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="awaiting" {{ $order->status == 'awaiting' ? 'selected' : '' }}>⏳ Chờ xác nhận</option>
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ Chờ xử lý</option>
                            <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>🚚 Đang giao hàng</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>📦 Đã giao hàng</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>✓ Hoàn thành</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>✗ Đã hủy</option>
                        </select>
                    </form>
                </div>
                <div class="mb-0">
                    <small class="text-muted d-block mb-1">Ngày đặt</small>
                    <span class="fw-semibold">{{ $order->created_at->format('d/m/Y H:i:s') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
