<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #8b5cf6;
            --primary-dark: #7c3aed;
            --primary-light: #a78bfa;
            --secondary-color: #ec4899;
            --success-color: #10b981;
            --danger-color: #f43f5e;
            --warning-color: #f59e0b;
            --light-bg: #fafafa;
            --border-color: #e5e7eb;
            --text-dark: #1f2937;
            --text-light: #6b7280;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom, #faf5ff 0%, var(--light-bg) 100%);
            color: var(--text-dark);
            min-height: 100vh;
        }
        
        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 4px 30px rgba(139, 92, 246, 0.1);
            padding: 1rem 0;
            border-bottom: 1px solid rgba(139, 92, 246, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.75rem;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -1px;
            transition: all 0.3s ease;
        }
        
        .navbar-brand:hover {
            transform: scale(1.05);
        }
        
        .navbar-brand i {
            margin-right: 10px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .navbar-nav .nav-link {
            font-weight: 600;
            padding: 0.65rem 1.3rem !important;
            color: var(--text-light) !important;
            transition: all 0.3s ease;
            position: relative;
            border-radius: 12px;
        }
        
        .navbar-nav .nav-link::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            opacity: 0;
            border-radius: 12px;
            transition: opacity 0.3s ease;
            z-index: -1;
        }
        
        .navbar-nav .nav-link:hover::before {
            opacity: 0.1;
        }
        
        .navbar-nav .nav-link:hover {
            color: var(--primary-color) !important;
            transform: translateY(-2px);
        }
        
        .cart-icon {
            position: relative;
            transition: transform 0.3s;
        }
        
        .cart-icon:hover {
            transform: scale(1.1);
        }
        
        .cart-badge {
            position: absolute;
            top: -10px;
            right: -10px;
            background: linear-gradient(135deg, var(--secondary-color), #f472b6);
            color: #fff;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4);
            animation: pulse 2s infinite;
            border: 2px solid #fff;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        /* Footer */
        .footer {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #1e1b4b 100%);
            color: #fff;
            padding: 60px 0 20px;
            margin-top: 80px;
            border-top: 3px solid;
            border-image: linear-gradient(90deg, var(--primary-color), var(--secondary-color)) 1;
            position: relative;
            overflow: hidden;
        }
        
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 200px;
            background: radial-gradient(circle at 50% 0%, rgba(139, 92, 246, 0.15), transparent);
            pointer-events: none;
        }
        
        .footer h5 {
            color: #fff;
            font-weight: 700;
            margin-bottom: 25px;
            font-size: 1.1rem;
            letter-spacing: -0.3px;
        }
        
        .footer a {
            color: #d1d5db;
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 500;
        }
        
        .footer a:hover {
            color: var(--primary-light);
            margin-left: 5px;
            text-shadow: 0 0 10px rgba(139, 92, 246, 0.5);
        }
        
        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            background: rgba(255,255,255,0.1);
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .social-links a::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .social-links a:hover::before {
            opacity: 1;
        }
        
        .social-links a:hover {
            transform: translateY(-5px) rotate(5deg);
            box-shadow: 0 8px 20px rgba(139, 92, 246, 0.4);
        }
        
        .social-links a i {
            position: relative;
            z-index: 1;
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 25px;
            margin-top: 40px;
            text-align: center;
            color: #9ca3af;
            font-weight: 500;
        }
        
        /* Product Card */
        .product-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(139, 92, 246, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            border: 2px solid transparent;
            position: relative;
            background-clip: padding-box;
        }
        
        .product-card::before {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 20px;
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: -1;
        }
        
        .product-card:hover::before {
            opacity: 1;
        }
        
        .product-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 50px rgba(139, 92, 246, 0.25);
        }
        
        .product-card .product-image {
            position: relative;
            overflow: hidden;
            background: var(--light-bg);
        }
        
        .product-card .product-image img {
            width: 100%;
            height: 240px;
            object-fit: cover;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .product-card:hover .product-image img {
            transform: scale(1.1) rotate(2deg);
        }
        
        .product-card .sale-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: linear-gradient(135deg, #ff6b6b, #ee5a6f);
            color: #fff;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 800;
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
            animation: bounce 2s ease-in-out infinite;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        
        .product-card .product-info {
            padding: 16px;
            display: flex;
            flex-direction: column;
            height: 140px;
        }
        
        .product-card .product-name {
            font-weight: 700;
            font-size: 0.95rem;
            margin-bottom: 8px;
            color: #1f2937;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
        }
        
        .product-card .product-price {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: auto;
        }
        
        .product-card .current-price {
            font-size: 1.3rem;
            font-weight: 900;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .product-card .original-price {
            font-size: 0.85rem;
            color: #9ca3af;
            text-decoration: line-through;
            font-weight: 500;
        }
        
        .product-card .btn {
            margin-top: auto;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 8px 12px;
            transition: all 0.3s;
        }
        
        /* Post Card */
        .post-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(139, 92, 246, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            border: 2px solid transparent;
            position: relative;
            background-clip: padding-box;
        }
        
        .post-card::before {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(135deg, var(--primary-light), var(--secondary-color));
            border-radius: 16px;
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: -1;
        }
        
        .post-card:hover::before {
            opacity: 1;
        }
        
        .post-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(139, 92, 246, 0.25);
        }
        
        .post-card .post-image img {
            width: 100%;
            height: 240px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .post-card:hover .post-image img {
            transform: scale(1.1) rotate(-2deg);
        }
        
        .post-card .post-info {
            padding: 16px;
        }
        
        .post-card .post-meta {
            font-size: 0.85rem;
            color: #9ca3af;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .post-card .post-title {
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 10px;
            color: #1f2937;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .post-card .post-excerpt {
            font-size: 0.9rem;
            color: #6b7280;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.5;
        }
        
        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--primary-dark), #d946ef);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .btn-primary:hover::before {
            opacity: 1;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(139, 92, 246, 0.5);
        }
        
        .btn-primary span {
            position: relative;
            z-index: 1;
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            font-weight: 700;
            border-radius: 12px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        
        .btn-outline-primary:hover::before {
            transform: translateX(0);
        }
        
        .btn-outline-primary:hover {
            color: #fff;
            border-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .btn-outline-primary span {
            position: relative;
            z-index: 1;
        }
        
        /* Section Title */
        .section-title {
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 50px;
            position: relative;
            padding-bottom: 20px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -1px;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100px;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(139, 92, 246, 0.4);
        }
        
        /* Breadcrumb */
        .breadcrumb-section {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.05), rgba(236, 72, 153, 0.05));
            padding: 25px 0;
            margin-bottom: 50px;
            border-bottom: 2px solid;
            border-image: linear-gradient(90deg, var(--primary-color), var(--secondary-color)) 1;
        }
        
        .breadcrumb {
            background: transparent;
        }
        
        .breadcrumb-item {
            font-weight: 500;
        }
        
        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 600;
        }
        
        .breadcrumb-item a:hover {
            color: var(--secondary-color);
            text-shadow: 0 0 10px rgba(139, 92, 246, 0.3);
        }
        
        /* Alert */
        .alert {
            border-radius: 16px;
            border: none;
            font-weight: 600;
            animation: slideDown 0.4s ease-out;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 16px 20px;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .alert-success {
            background: linear-gradient(135deg, #d1fae5, #6ee7b7);
            color: #065f46;
            border-left: 5px solid var(--success-color);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.2);
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #fecaca, #fca5a5);
            color: #7f1d1d;
            border-left: 5px solid var(--danger-color);
            box-shadow: 0 6px 20px rgba(244, 63, 94, 0.2);
        }
        
        /* Search Box */
        .search-box {
            position: relative;
        }
        
        .search-box input {
            padding-right: 50px;
            border-radius: 16px;
            border: 2px solid var(--border-color);
            font-weight: 600;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }
        
        .search-box input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.15);
            background: #fff;
            transform: translateY(-2px);
        }
        
        .search-box button {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            cursor: pointer;
            font-weight: 700;
            transition: transform 0.3s ease;
        }
        
        .search-box button:hover {
            transform: translateY(-50%) scale(1.2);
        }
    
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-store me-2"></i>{{ config('app.name', 'Laravel Shop') }}
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i> Trang chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">
                            <i class="fas fa-box me-1"></i> Sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('posts.index') }}">
                            <i class="fas fa-newspaper me-1"></i> Bài viết
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">
                            <i class="fas fa-envelope me-1"></i> Liên hệ
                        </a>
                    </li>
                </ul>
                
                <!-- Search -->
                <form class="d-flex me-3" action="{{ route('products.index') }}" method="GET">
                    <div class="search-box">
                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm..." value="{{ request('search') }}">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
                
                <ul class="navbar-nav">
                    <!-- Cart -->
                    <li class="nav-item">
                        <a class="nav-link cart-icon" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart fa-lg"></i>
                            <span class="cart-badge" id="cart-count">0</span>
                        </a>
                    </li>
                    
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Đăng nhập
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i> Đăng ký
                        </a>
                    </li>
                    @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('orders.history') }}">
                                    <i class="fas fa-list me-2"></i> Đơn hàng của tôi
                                </a>
                            </li>
                            @if(Auth::user()->isAdmin())
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-cog me-2"></i> Quản trị
                                </a>
                            </li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ url('/dang-xuat') }}">
                                    <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Alerts -->
    <div class="container mt-3">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
    </div>
    
    <!-- Content -->
    @yield('content')
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5><i class="fas fa-store me-2"></i>{{ config('app.name', 'Laravel Shop') }}</h5>
                    <p class="text-muted">Cung cấp sản phẩm chất lượng cao với giá cả hợp lý. Cam kết mang đến trải nghiệm mua sắm tốt nhất cho khách hàng.</p>
                    <div class="social-links">
                        <a href="#" class="me-3"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-youtube fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Liên kết</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li class="mb-2"><a href="{{ route('products.index') }}">Sản phẩm</a></li>
                        <li class="mb-2"><a href="{{ route('posts.index') }}">Bài viết</a></li>
                        <li class="mb-2"><a href="{{ route('contact') }}">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Hỗ trợ</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">Hướng dẫn mua hàng</a></li>
                        <li class="mb-2"><a href="#">Chính sách đổi trả</a></li>
                        <li class="mb-2"><a href="#">Chính sách bảo mật</a></li>
                        <li class="mb-2"><a href="#">Điều khoản sử dụng</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Liên hệ</h5>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Đường ABC, Quận XYZ, TP.HCM</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> 0123 456 789</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> support@example.com</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'Laravel Shop') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Update cart count
        function updateCartCount() {
            fetch('{{ route("cart.count") }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cart-count').textContent = data.count;
                })
                .catch(error => console.error('Error:', error));
        }
        
        // Load cart count on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
        });
        
        // Add to cart function
        function addToCart(productId, quantity = 1) {
            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    document.getElementById('cart-count').textContent = data.cart_count;
                    alert(data.message);
                } else {
                    alert(data.message || 'Có lỗi xảy ra');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (error.message) {
                    alert(error.message);
                } else if (error.errors) {
                    const firstError = Object.values(error.errors)[0][0];
                    alert(firstError);
                } else {
                    alert('Có lỗi xảy ra, vui lòng thử lại');
                }
            });
        }
    </script>
    
    @stack('scripts')
</body>
</html>

