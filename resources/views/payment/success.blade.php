@extends('layouts.user')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-8">
        <div class="card shadow border-0 text-center p-5">
            <div class="mb-4">
                <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
            </div>

            <h1 class="display-5 fw-bold text-dark mb-3">Thanh toán thành công!</h1>
            
            <p class="lead text-muted mb-5">
                Cảm ơn bạn đã mua hàng. Đơn hàng của bạn đã được xác nhận và đang được xử lý.
            </p>

            <div class="bg-light rounded-4 p-4 mb-5 text-start">
                <h5 class="fw-bold mb-4 border-bottom pb-2">Thông tin thanh toán</h5>
                <div class="row mb-3">
                    <div class="col-sm-5 text-muted">Mã đơn hàng:</div>
                    <div class="col-sm-7 fw-bold">#{{ $order->id }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-5 text-muted">Mã giao dịch VNPay:</div>
                    <div class="col-sm-7 fw-bold text-primary">{{ $order->vnp_transaction_no }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-5 text-muted">Ngân hàng:</div>
                    <div class="col-sm-7 fw-bold text-uppercase">{{ $order->vnp_bank_code }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-5 text-muted">Loại thẻ:</div>
                    <div class="col-sm-7 fw-bold text-uppercase">{{ $order->vnp_card_type }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-5 text-muted">Tổng tiền:</div>
                    <div class="col-sm-7 fw-bold text-danger fs-5">{{ number_format($order->total_amount) }}đ</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-5 text-muted">Thời gian thanh toán:</div>
                    <div class="col-sm-7 fw-bold">{{ $order->transaction_date }}</div>
                </div>
                <div class="row">
                    <div class="col-sm-5 text-muted">Trạng thái:</div>
                    <div class="col-sm-7">
                        <span class="badge bg-success">Đã thanh toán</span>
                    </div>
                </div>
            </div>

            <p class="text-secondary mb-5">
                Email xác nhận đã được gửi đến <span class="fw-bold text-dark">{{ $order->customer_email }}</span>
            </p>

            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-lg px-4 gap-3 rounded-pill">
                    <i class="fas fa-file-invoice me-2"></i>Chi tiết đơn hàng
                </a>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg px-4 rounded-pill">
                    <i class="fas fa-home me-2"></i>Trang chủ
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .card { border-radius: 1.5rem; }
    .bg-light { background-color: #f8f9fa !important; }
</style>
@endsection
