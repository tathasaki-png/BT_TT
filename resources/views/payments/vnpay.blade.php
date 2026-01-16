@extends('layouts.user')

@section('title', 'Thanh toán VNPay')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0"><i class="fas fa-credit-card me-2"></i>Thanh toán VNPay</h4>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <img src="https://stc-developers.vnpay.vn/images/logo-vnpay.png" alt="VNPay Logo" class="img-fluid" style="max-height: 60px;">
                    </div>

                    <h5 class="text-center mb-4">Thông tin đơn hàng #{{ $order->id }}</h5>
                    
                    <div class="order-summary bg-light p-3 rounded mb-4">
                        <div class="row">
                            <div class="col-6"><strong>Khách hàng:</strong></div>
                            <div class="col-6">{{ $order->customer_name }}</div>
                        </div>
                        <div class="row">
                            <div class="col-6"><strong>Email:</strong></div>
                            <div class="col-6">{{ $order->customer_email }}</div>
                        </div>
                        <div class="row">
                            <div class="col-6"><strong>Tổng tiền:</strong></div>
                            <div class="col-6"><span class="text-danger fw-bold">{{ number_format($order->total_amount) }}đ</span></div>
                        </div>
                    </div>

                    <form action="{{ route('payment.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-credit-card me-2"></i>Tiến hành thanh toán
                            </button>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại đơn hàng
                            </a>
                        </div>
                    </form>

                    <div class="mt-4 text-center">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt me-1"></i>
                            Thanh toán được bảo mật bởi VNPay
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .order-summary .row {
        margin-bottom: 0.5rem;
    }
    .card {
        border: none;
        border-radius: 10px;
    }
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
</style>
@endsection