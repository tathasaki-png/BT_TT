@php
    $statusColors = [
        'awaiting' => ['bg' => '#f1f5f9', 'text' => '#64748b', 'icon' => 'fa-hourglass-start'],
        'pending' => ['bg' => '#fef3c7', 'text' => '#d97706', 'icon' => 'fa-clock'],
        'shipping' => ['bg' => '#dbeafe', 'text' => '#2563eb', 'icon' => 'fa-truck'],
        'delivered' => ['bg' => '#dcfce7', 'text' => '#16a34a', 'icon' => 'fa-box-open'],
        'completed' => ['bg' => '#dcfce7', 'text' => '#16a34a', 'icon' => 'fa-check-circle'],
        'cancelled' => ['bg' => '#fee2e2', 'text' => '#dc2626', 'icon' => 'fa-times-circle'],
    ];
    $currentStatus = $statusColors[$order->status] ?? $statusColors['awaiting'];
@endphp

<div class="animate-fade-in p-lg-5 p-4">
    <!-- Header: Order Title and Actions -->
    <div class="d-flex flex-wrap justify-content-between align-items-start mb-5 gap-4">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <h2 class="fw-bold mb-0" style="font-family: 'Outfit', sans-serif; letter-spacing: -1px; color: #1e293b;">
                    Đơn hàng #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                </h2>
                <span class="badge" style="background: {{ $currentStatus['bg'] }}; color: {{ $currentStatus['text'] }}; font-size: 0.75rem; padding: 8px 14px;">
                    <i class="fas {{ $currentStatus['icon'] }} me-2"></i>{{ strtoupper($order->status) }}
                </span>
            </div>
            <p class="text-muted mb-0">Đặt lúc {{ $order->created_at->format('H:i, d \t\h\á\n\g m, Y') }}</p>
        </div>
        
        <div class="d-flex gap-2">
            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn border-0 text-danger bg-danger-subtle px-4 py-2" style="border-radius: 10px; font-weight: 600;">
                    <i class="fas fa-trash-alt me-2"></i>Xóa đơn
                </button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <!-- Column 1: Customer & Status -->
        <div class="col-xl-5">
            <!-- Customer Card -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px; background: rgba(255,255,255,0.7); backdrop-filter: blur(10px);">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px; color: #94a3b8;">Khách hàng</h6>
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="bg-primary text-white d-flex align-items-center justify-content-center fw-bold" 
                             style="width: 56px; height: 56px; border-radius: 16px; font-size: 1.25rem;">
                            {{ strtoupper(substr($order->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-bold fs-5 text-dark">{{ $order->user->name }}</div>
                            <div class="text-muted small">{{ $order->user->email }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Management Card -->
            <div class="card border-0 shadow-sm" style="border-radius: 20px; background: rgba(255,255,255,0.7); backdrop-filter: blur(10px);">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px; color: #94a3b8;">Xử lý đơn hàng</h6>
                    
                    <div class="mb-4">
                        <label class="form-label small text-muted">Phương thức thanh toán</label>
                        <div class="d-flex align-items-center p-3 rounded-4 bg-white border border-light shadow-sm">
                            <i class="fas {{ $order->payment_method == 'vnpay' ? 'fa-credit-card text-primary' : 'fa-money-bill-wave text-success' }} fs-4 me-3"></i>
                            <div>
                                <div class="fw-bold">{{ strtoupper($order->payment_method) }}</div>
                                <div class="text-muted x-small">Tự động kích hoạt khi BNPay thành công</div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <label class="form-label small text-muted">Cập nhật trạng thái</label>
                        <select name="status" class="form-select form-select-lg border-0 shadow-sm bg-white mb-3" 
                                style="border-radius: 12px; font-weight: 600; font-size: 0.95rem; height: 54px;" 
                                onchange="this.form.submit()">
                            <option value="awaiting" {{ $order->status == 'awaiting' ? 'selected' : '' }}>⏳ Chờ xác nhận</option>
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ Chờ xử lý</option>
                            <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>🚚 Đang giao hàng</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>📦 Đã giao hàng</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>✓ Hoàn thành</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>✗ Đã hủy</option>
                        </select>
                        <p class="small text-muted text-center"><i class="fas fa-info-circle me-1"></i> Hệ thống sẽ tự động cập nhật nếu thay đổi.</p>
                    </form>
                </div>
            </div>
        </div>

        <!-- Column 2: Items & Totals -->
        <div class="col-xl-7">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; background: #fff;">
                <div class="card-body p-4 d-flex flex-column">
                    <h6 class="fw-bold mb-4 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px; color: #94a3b8;">Chi tiết giỏ hàng</h6>
                    
                    <div class="flex-grow-1">
                        @foreach($order->items as $item)
                        <div class="d-flex align-items-center mb-4 p-3 rounded-4 border border-faded hover-light">
                            <img src="{{ $item->course->thumbnail ? asset('storage/' . $item->course->thumbnail) : asset('products/course' . (($item->course->id % 5) + 1) . '.jpg') }}" 
                                 class="rounded-3 shadow-sm me-4" width="90" height="60" style="object-fit: cover;" alt="">
                            <div class="flex-grow-1">
                                <div class="fw-bold text-dark mb-1">{{ $item->course->title }}</div>
                                <div class="text-muted small"><i class="fas fa-user-tie me-1"></i> {{ $item->course->instructor->name }}</div>
                            </div>
                            <div class="fw-bold fs-5 text-primary">{{ (int)$item->price }}đ</div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-auto pt-4 border-top">
                        <div class="d-flex justify-content-between align-items-center px-2">
                            <h4 class="fw-bold mb-0">Tổng cộng</h4>
                            <div class="text-end">
                                <div class="text-primary fw-bolder fs-2" style="font-family: 'Outfit'; letter-spacing: -1px;">
                                    {{ number_format($order->total_price) }}đ
                                </div>
                                <div class="text-muted small">Đã bao gồm các loại thuế phí</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .animate-fade-in {
        animation: fadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .hover-light:hover { background: #f8fafc; }
    .border-faded { border: 1px solid #f1f5f9; }
    .x-small { font-size: 0.65rem; }
</style>
