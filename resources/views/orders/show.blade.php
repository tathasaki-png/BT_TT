@extends('layouts.user')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Chi tiết đơn hàng #{{ $order->id }}</h2>
            <a href="{{ route('orders.history') }}" class="btn btn-outline-secondary rounded-pill"><i class="fas fa-arrow-left me-1"></i> Quay lại lịch sử</a>
        </div>
        
        <div class="row g-4">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white fw-bold py-3">Sản phẩm đã mua</div>
                    <div class="card-body p-0">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th class="text-end pe-4">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset($item->product->image) }}" width="50" class="rounded me-3">
                                            @endif
                                            <span>{{ $item->product_name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ number_format($item->price) }}đ</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end pe-4 fw-bold">{{ number_format($item->price * $item->quantity) }}đ</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold py-3">Tổng giá trị đơn hàng:</td>
                                    <td class="text-end pe-4 fw-bold py-3 text-primary h4">{{ number_format($order->total_amount) }}đ</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white fw-bold py-3">Trạng thái đơn hàng</div>
                    <div class="card-body text-center py-4">
                        @php
                            $statusMap = [
                                'pending' => ['class' => 'bg-warning text-dark', 'icon' => 'fa-clock', 'label' => 'Đang chờ'],
                                'completed' => ['class' => 'bg-success', 'icon' => 'fa-check-circle', 'label' => 'Hoàn tất'],
                                'processing' => ['class' => 'bg-info', 'icon' => 'fa-spinner fa-spin', 'label' => 'Đang xử lý'],
                                'shipped' => ['class' => 'bg-primary', 'icon' => 'fa-truck', 'label' => 'Đang giao'],
                                'delivered' => ['class' => 'bg-success', 'icon' => 'fa-check-circle', 'label' => 'Đã giao'],
                                'cancelled' => ['class' => 'bg-danger', 'icon' => 'fa-times-circle', 'label' => 'Đã hủy'],
                                'refunded' => ['class' => 'bg-secondary', 'icon' => 'fa-undo', 'label' => 'Đã hoàn tiền']
                            ];
                            $statusInfo = $statusMap[$order->status] ?? ['class' => 'bg-secondary', 'icon' => 'fa-question-circle', 'label' => $order->status];
                        @endphp
                        <div class="display-4 text-{{ str_replace('bg-', '', explode(' ', $statusInfo['class'])[0]) }} mb-2">
                            <i class="fas {{ $statusInfo['icon'] }}"></i>
                        </div>
                        <h4 class="fw-bold">{{ $statusInfo['label'] }}</h4>
                        <p class="text-muted small">Cập nhật lúc: {{ $order->updated_at->format('H:i, d/m/Y') }}</p>
                    </div>
                </div>

                <!-- Trạng thái thanh toán -->
                @if($order->payment_method)
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white fw-bold py-3">Thông tin thanh toán</div>
                        <div class="card-body">
                            <p class="mb-2">
                                <strong>Phương thức:</strong> 
                                <span class="badge bg-info">
                                    {{ $order->payment_method === 'vnpay' ? 'VNPay' : 'Thanh toán khi nhận hàng' }}
                                </span>
                            </p>
                            <p class="mb-2">
                                <strong>Trạng thái:</strong>
                                @php
                                    $paymentStatusMap = [
                                        'pending' => 'bg-warning',
                                        'completed' => 'bg-success',
                                        'failed' => 'bg-danger',
                                        'refunded' => 'bg-secondary'
                                    ];
                                @endphp
                                <span class="badge {{ $paymentStatusMap[$order->payment_status] ?? 'bg-secondary' }}">
                                    @switch($order->payment_status)
                                        @case('pending')
                                            Chưa thanh toán
                                            @break
                                        @case('completed')
                                            Đã thanh toán
                                            @break
                                        @case('failed')
                                            Thanh toán thất bại
                                            @break
                                        @case('refunded')
                                            Đã hoàn tiền
                                            @break
                                        @default
                                            {{ $order->payment_status }}
                                    @endswitch
                                </span>
                            </p>
                            @if($order->transaction_id)
                                <p class="mb-0">
                                    <strong>Mã giao dịch:</strong><br>
                                    <small class="text-muted">{{ $order->transaction_id }}</small>
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Nút thanh toán hoặc hoàn tiền -->
                    @if($order->payment_method === 'vnpay' && $order->payment_status === 'pending')
                        <form action="{{ route('payment.create') }}" method="POST" class="mb-4">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-credit-card me-2"></i>Thanh toán ngay
                            </button>
                        </form>
                    @elseif($order->payment_status === 'completed' && !in_array($order->status, ['shipped', 'delivered', 'cancelled', 'refunded']))
                        <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#refundModal">
                            <i class="fas fa-undo me-2"></i>Yêu cầu hoàn tiền
                        </button>
                    @endif
                @endif

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold py-3">Thông tin khách hàng</div>
                    <div class="card-body">
                        <p class="mb-1"><strong>Họ tên:</strong> {{ $order->user->name }}</p>
                        <p class="mb-0"><strong>Email:</strong> {{ $order->user->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hoàn tiền -->
<div class="modal fade" id="refundModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yêu cầu hoàn tiền</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc muốn yêu cầu hoàn tiền cho đơn hàng này?</p>
                <p><strong>Số tiền hoàn:</strong> {{ number_format($order->total_amount) }}đ</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="confirmRefundBtn">Xác nhận hoàn tiền</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('confirmRefundBtn')?.addEventListener('click', function() {
        fetch("{{ route('payment.refund') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                order_id: {{ $order->id }}
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Yêu cầu hoàn tiền đã được gửi thành công!');
                location.reload();
            } else {
                alert('Lỗi: ' + (data.error || 'Không xác định'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra. Vui lòng thử lại.');
        });
    });
</script>
@endsection
