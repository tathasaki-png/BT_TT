@extends('layouts.admin')

@section('title', 'Quản lý đơn hàng')

@push('styles')
<style>
    /* Premium Split View */
    .orders-split-view {
        display: flex;
        height: calc(100vh - 84px); /* Full height minus top navbar */
        margin: -24px; /* Counter main padding */
        background: #f8fafc;
        overflow: hidden;
    }

    /* Masters Sidebar (Fixed List) */
    .orders-list-sidebar {
        width: 380px;
        background: #fff;
        border-right: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        flex-shrink: 0;
        box-shadow: 10px 0 15px -15px rgba(0,0,0,0.05);
        z-index: 10;
    }

    .sidebar-header {
        padding: 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .sidebar-header h5 {
        font-family: 'Outfit', 'Inter', sans-serif;
        font-weight: 700;
        font-size: 1.25rem;
        margin: 0;
        color: #1e293b;
    }

    .orders-scroll-area {
        flex: 1;
        overflow-y: auto;
        padding: 12px;
    }

    /* Premium Order Item Card */
    .order-item-card {
        padding: 16px;
        margin-bottom: 8px;
        border-radius: 12px;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        background: #fff;
    }

    .order-item-card:hover {
        background: #f1f5f9;
        transform: translateY(-2px);
    }

    .order-item-card.active {
        background: #fff;
        border-color: var(--primary-color);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .order-item-card .order-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }

    .order-item-card .order-id {
        font-weight: 700;
        font-size: 0.75rem;
        color: #64748b;
        letter-spacing: 0.5px;
    }

    .order-item-card .order-date {
        font-size: 0.75rem;
        color: #94a3b8;
    }

    .order-item-card .customer-name {
        font-weight: 600;
        font-size: 0.95rem;
        color: #1e293b;
        margin-bottom: 10px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .order-item-card .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .order-item-card .order-price {
        font-weight: 800;
        color: var(--primary-color);
        font-size: 1rem;
    }

    /* Custom Scrollbar */
    .orders-scroll-area::-webkit-scrollbar {
        width: 5px;
    }
    .orders-scroll-area::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }

    /* Detail Content Area */
    .order-detail-container {
        flex: 1;
        overflow-y: auto;
        background: #f8fafc;
        position: relative;
    }

    .empty-detail-state {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: #94a3b8;
    }

    .empty-detail-state i {
        font-size: 80px;
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 24px;
    }

    /* Badges Modern Style */
    .badge {
        padding: 6px 10px;
        font-weight: 600;
        border-radius: 6px;
        font-size: 0.7rem;
        text-transform: uppercase;
    }
</style>
@endpush

@section('content')
<div class="orders-split-view">
    <!-- Left Sidebar: Fixed List -->
    <div class="orders-list-sidebar">
        <div class="sidebar-header">
            <h5 class="mb-0 fw-bold">Đơn hàng <span class="badge bg-primary ms-2">{{ $orders->total() }}</span></h5>
        </div>
        
        <div class="orders-scroll-area">
            @forelse($orders as $order)
                <div class="order-item-card {{ request('order_id') == $order->id ? 'active' : '' }}" 
                     id="order-card-{{ $order->id }}"
                     onclick="loadOrderDetail('{{ route('admin.orders.show', $order) }}', {{ $order->id }})">
                    <div class="order-meta">
                        <span class="order-id">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                        <small class="text-muted">{{ $order->created_at->format('d/m H:i') }}</small>
                    </div>
                    <div class="customer-name mb-1">{{ $order->user->name }}</div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="order-price small">{{ (int) $order->total_price }}đ</span>
                        @switch($order->status)
                            @case('awaiting') <span class="badge bg-secondary">Chờ duyệt</span> @break
                            @case('pending') <span class="badge bg-warning">Xử lý</span> @break
                            @case('shipping') <span class="badge bg-info">Giao hàng</span> @break
                            @case('delivered') <span class="badge bg-success">Đã giao</span> @break
                            @case('completed') <span class="badge bg-success">Xong</span> @break
                            @case('cancelled') <span class="badge bg-danger">Hủy</span> @break
                        @endswitch
                    </div>
                </div>
            @empty
                <div class="p-4 text-center text-muted">Chưa có đơn hàng nào</div>
            @endforelse
        </div>

        @if($orders->hasPages())
            <div class="p-2 border-top bg-white">
                {{ $orders->withQueryString()->links('pagination::simple-bootstrap-5') }}
            </div>
        @endif
    </div>

    <!-- Right Content: Order Detail -->
    <div class="order-detail-container" id="orderDetailContent">
        <div class="empty-detail-state">
            <i class="fas fa-receipt fa-4x mb-4 opacity-25"></i>
            <h3>Chọn một đơn hàng</h3>
            <p>Nhấn vào đơn hàng ở danh sách bên trái để xem chi tiết và xử lý.</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const detailContainer = document.getElementById('orderDetailContent');

        window.loadOrderDetail = function(url, orderId) {
            // Highlight active side card
            document.querySelectorAll('.order-item-card').forEach(el => el.classList.remove('active'));
            document.getElementById('order-card-' + orderId).classList.add('active');

            // Show loading state
            detailContainer.innerHTML = `
                <div class="d-flex justify-content-center align-items-center h-100 w-100">
                    <div class="text-center">
                        <div class="spinner-border text-primary mb-3" role="status"></div>
                        <p class="text-muted">Đang tải...</p>
                    </div>
                </div>`;

            // Update URL without refreshing (optional but good for UX)
            const newUrl = new URL(window.location);
            newUrl.searchParams.set('order_id', orderId);
            window.history.pushState({}, '', newUrl);

            // Fetch detail view
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                detailContainer.innerHTML = html;
            })
            .catch(error => {
                detailContainer.innerHTML = '<div class="p-4 text-danger text-center">Lỗi tải dữ liệu.</div>';
            });
        };

        // Auto load first order or from URL
        const urlParams = new URLSearchParams(window.location.search);
        const activeOrderId = urlParams.get('order_id');
        if (activeOrderId) {
            const card = document.getElementById('order-card-' + activeOrderId);
            if (card) card.click();
        } else {
            const firstCard = document.querySelector('.order-item-card');
            if (firstCard) firstCard.click();
        }
    });
</script>
@endpush
