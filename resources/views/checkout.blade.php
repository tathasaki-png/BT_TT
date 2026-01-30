@extends('layouts.app')

@section('content')
    <style>
        .cart-item {
            display: flex;
            align-items: center;
            padding: 24px;
            background: rgba(255, 255, 255, 0.02);
            border-bottom: 1px solid var(--glass-border);
            transition: all 0.3s ease;
        }

        .cart-item:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .cart-item-image {
            width: 140px;
            height: 80px;
            object-fit: cover;
            border-radius: 12px;
            margin-right: 24px;
            border: 1px solid var(--glass-border);
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 18px;
            color: white;
            margin-bottom: 8px;
        }

        .cart-item-category {
            font-size: 14px;
            color: var(--text-muted);
        }

        .cart-item-price {
            font-size: 20px;
            font-weight: 800;
            color: var(--primary-color);
            margin-right: 24px;
            min-width: 120px;
            text-align: right;
        }

        .cart-remove-btn {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
            width: 42px;
            height: 42px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-remove-btn:hover {
            background: #ef4444;
            color: white;
            transform: scale(1.1);
        }

        .summary-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 32px;
            border: 1px solid var(--glass-border);
            position: sticky;
            top: 100px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 15px;
            color: var(--text-muted);
        }

        .summary-row.total {
            border-top: 1px solid var(--glass-border);
            padding-top: 24px;
            margin-top: 24px;
            font-size: 22px;
            font-weight: 800;
            color: white;
        }

        .summary-row.total .price {
            color: var(--primary-color);
            text-shadow: 0 0 15px var(--primary-glow);
        }

        .payment-option {
            display: flex;
            align-items: center;
            padding: 16px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--glass-border);
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 12px;
        }

        .payment-option:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--primary-color);
        }

        .payment-option input:checked+span {
            color: white;
            font-weight: 600;
        }

        .discount-section {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 16px;
            padding: 20px;
            margin-top: 24px;
            border: 1px solid var(--glass-border);
        }

        .discount-input input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            color: white;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 14px;
            outline: none;
        }

        .discount-input input:focus {
            border-color: var(--primary-color);
        }
    </style>

    <div class="glass p-5 mb-5 fade-in" style="background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.05));">
        <h1 style="font-family: 'Outfit'; font-size: 42px; font-weight: 800; margin: 0; color: white;">
            <i class="fas fa-shopping-cart me-3 text-primary"></i>Giỏ hàng <span style="color: var(--primary-color)">của bạn</span>
        </h1>
        <p class="text-muted mt-2 mb-0">Kiểm tra lại các khóa học trước khi bắt đầu hành trình học tập</p>
    </div>

    <div class="container-fluid px-lg-4" style="max-width: 1200px; margin: 0 auto;">
        <div class="row g-4">
            <!-- Cart Items -->
            <div class="col-lg-8">
                @if($courses->isEmpty())
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="empty-cart">
                            <i class="fas fa-shopping-bag"></i>
                            <h3 style="color: #334155; margin-bottom: 10px;">Giỏ hàng đang trống</h3>
                            <p style="color: #64748b; margin-bottom: 20px;">Hãy chọn cho mình một khóa học để bắt đầu học nhé!
                            </p>
                            <a href="{{ route('explore') }}" class="continue-shopping">
                                <i class="fas fa-arrow-left me-2"></i> Tiếp tục mua sắm
                            </a>
                        </div>
                    </div>
                @else
                    <div class="glass overflow-hidden">
                        <div style="padding: 24px; border-bottom: 1px solid var(--glass-border); background: rgba(255,255,255,0.02);">
                            <h5 style="margin: 0; font-family: 'Outfit'; font-weight: 700; color: white;">
                                <i class="fas fa-list-ul me-2"></i>{{ count($courses) }} khóa học trong giỏ
                            </h5>
                        </div>

                        @foreach($courses as $course)
                            <div class="cart-item">
                                <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : asset('products/course' . (($course->id % 5) + 1) . '.jpg') }}"
                                    alt="{{ $course->title }}" class="cart-item-image"
                                    onerror="this.src='https://placehold.co/120x70?text=Course'">

                                <div class="cart-item-details">
                                    <div class="cart-item-title">{{ $course->title }}</div>
                                    <div class="cart-item-category">
                                        <i class="fas fa-tag" style="margin-right: 6px;"></i>
                                        {{ $course->category->name ?? 'Uncategorized' }}
                                    </div>
                                    @if($course->sale_price && $course->sale_price < $course->price)
                                        <div style="margin-top: 8px; font-size: 12px;">
                                            <span style="color: #64748b; text-decoration: line-through;">{{ (int) $course->price }}
                                                VND</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="cart-item-price">
                                    <span>{{ (int) ($course->sale_price ?? $course->price) }} VND</span>
                                </div>

                                <form action="{{ route('cart.remove', $course->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cart-remove-btn" title="Xóa khỏi giỏ">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>

                    <div
                        style="margin-top: 20px; padding: 16px; background: #e0f2fe; border-radius: 12px; border-left: 4px solid #0284c7;">
                        <i class="fas fa-info-circle" style="color: #0284c7; margin-right: 12px;"></i>
                        <span style="color: #0c4a6e;">Bạn sẽ được truy cập khóa học ngay sau khi thanh toán thành công</span>
                    </div>
                @endif
            </div>

            <!-- Cart Summary -->
            @if(!$courses->isEmpty())
                <div class="col-lg-4">
                    <div class="summary-card">
                        <h5 style="font-weight: 600; margin-bottom: 20px; color: #0f172a;">
                            <i class="fas fa-receipt" style="margin-right: 10px; color: #6366f1;"></i> Tóm tắt đơn hàng
                        </h5>

                        <div class="summary-row">
                            <span>Số lượng khóa học:</span>
                            <span style="font-weight: 600;">{{ count($courses) }}</span>
                        </div>

                        <div class="summary-row">
                            <span>Tổng tiền hàng:</span>
                            <span style="font-weight: 600;">{{ (int) $total }} VND</span>
                        </div>

                        @php
                            $discount = 0;
                            $discountPercentage = 5;
                            if (count($courses) > 1) {
                                $discount = ($total * $discountPercentage) / 100;
                            }
                        @endphp

                        @if($discount > 0)
                            <div class="summary-row" style="color: #059669;">
                                <span>Giảm giá ({{ $discountPercentage }}%):</span>
                                <span style="font-weight: 600;">-{{ (int) $discount }} VND</span>
                            </div>
                        @endif

                        <div class="summary-row total">
                            <span>Tổng cộng:</span>
                            <span class="price">{{ (int) ($total - $discount) }} VND</span>
                        </div>

                        <!-- Payment Methods -->
                        <div style="background: white; border-radius: 12px; padding: 16px; margin-top: 20px;">
                            <h6 style="font-weight: 600; margin-bottom: 12px; color: #0f172a;">Phương thức thanh toán</h6>
                            <form method="POST" action="{{ route('checkout.process') }}">
                                @csrf

                                <div style="margin-bottom: 12px;">
                                    <label class="payment-option">
                                        <input type="radio" name="payment_method" value="cod" checked style="margin-right: 16px;">
                                        <span style="font-weight: 500;">Thanh toán khi nhận hàng (COD)</span>
                                    </label>
                                </div>

                                <div style="margin-bottom: 16px;">
                                    <label class="payment-option">
                                        <input type="radio" name="payment_method" value="vnpay" style="margin-right: 16px;">
                                        <span style="font-weight: 500;">Thanh toán online (VNPay)</span>
                                    </label>
                                </div>

                                <button type="submit" class="checkout-btn" id="checkoutBtn">
                                    <i class="fas fa-credit-card me-2"></i> Tiến hành thanh toán
                                </button>
                            </form>
                        </div>

                        <!-- Discount Code -->
                        <div class="discount-section">
                            <small style="color: #64748b;">Bạn có mã khuyến mãi?</small>
                            <div class="discount-input" style="margin-top: 8px;">
                                <input type="text" placeholder="Nhập mã khuyến mãi" id="couponCode" style="outline: none;">
                                <button onclick="applyCoupon()">Áp dụng</button>
                            </div>
                        </div>
                    </div>

                    <!-- Trust Badges -->
                    <div
                        style="margin-top: 20px; padding: 16px; background: white; border-radius: 12px; border: 1px solid #e2e8f0; text-align: center;">
                        <div style="display: flex; justify-content: space-around; margin-bottom: 12px;">
                            <div>
                                <i class="fas fa-lock" style="font-size: 24px; color: #6366f1; margin-bottom: 8px;"></i>
                                <small style="color: #64748b; display: block;">Thanh toán<br>an toàn</small>
                            </div>
                            <div>
                                <i class="fas fa-undo" style="font-size: 24px; color: #6366f1; margin-bottom: 8px;"></i>
                                <small style="color: #64748b; display: block;">Hoàn tiền<br>7 ngày</small>
                            </div>
                            <div>
                                <i class="fas fa-headset" style="font-size: 24px; color: #6366f1; margin-bottom: 8px;"></i>
                                <small style="color: #64748b; display: block;">Hỗ trợ<br>24/7</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function applyCoupon() {
            const code = document.getElementById('couponCode').value;
            if (code) {
                alert('Mã ' + code + ' sẽ được áp dụng khi thanh toán');
            }
        }
    </script>
@endsection