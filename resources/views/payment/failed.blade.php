@extends('layouts.user')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-8">
        <div class="card shadow border-0 text-center p-5">
            <div class="mb-4">
                <i class="fas fa-times-circle text-danger" style="font-size: 5rem;"></i>
            </div>

            <h1 class="display-5 fw-bold text-dark mb-3">Thanh toán thất bại!</h1>
            
            <p class="lead text-muted mb-4">
                Đã xảy ra lỗi trong quá trình xử lý giao dịch. Đừng lo lắng, tiền của bạn chưa được khấu trừ.
            </p>

            @if(session('error'))
                <div class="alert alert-danger mb-4">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                </div>
            @endif

            <div class="bg-light rounded-4 p-4 mb-5 text-start">
                <p class="text-secondary mb-0">
                    <strong>Thông báo:</strong> Đơn hàng của bạn vẫn được lưu ở trạng thái <strong>Chưa thanh toán</strong>. Bạn có thể quay lại lịch sử đơn hàng để thực hiện lại việc thanh toán bất kỳ lúc nào.
                </p>
            </div>

            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                <a href="{{ route('orders.history') }}" class="btn btn-primary btn-lg px-4 gap-3 rounded-pill">
                    <i class="fas fa-history me-2"></i>Lịch sử đơn hàng
                </a>
                <a href="{{ route('checkout') }}" class="btn btn-outline-danger btn-lg px-4 rounded-pill">
                    <i class="fas fa-shopping-cart me-2"></i>Quay lại thanh toán
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .card { border-radius: 1.5rem; }
    .bg-light { background-color: #fcf8e3 !important; border: 1px solid #faebcc; color: #8a6d3b; }
</style>
@endsection
