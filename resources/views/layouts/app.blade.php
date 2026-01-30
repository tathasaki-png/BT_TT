<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Học trực tuyến') - {{ config('app.name', 'LMS PRO') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap');

        :root {
            --primary-color: #6366f1;
            --primary-hover: #4f46e5;
            --primary-glow: rgba(99, 102, 241, 0.5);
            --secondary-color: #1e1b4b;
            --bg-color: #0b0f1a;
            --sidebar-color: rgba(15, 23, 42, 0.8);
            --card-bg: rgba(30, 41, 59, 0.5);
            --text-main: #f8fafc;
            --text-muted: #cbd5e1;
            /* Much brighter for dark theme */
            --border-color: rgba(255, 255, 255, 0.08);
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.1);
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scrollbar-width: thin;
            scrollbar-color: var(--primary-color) transparent;
        }

        *::-webkit-scrollbar {
            width: 6px;
        }

        *::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 10px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            background-image:
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(139, 92, 246, 0.15) 0px, transparent 50%);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .sidebar-brand-text {
            font-family: 'Outfit', sans-serif;
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        .form-label,
        label,
        .small,
        small,
        .text-secondary {
            color: #f1f5f9 !important;
            font-weight: 600;
        }

        /* Specifically target very dark gray classes often used in themes */
        .text-gray-500,
        .text-slate-500,
        .text-slate-400 {
            color: var(--text-muted) !important;
        }

        ::placeholder {
            color: rgba(255, 255, 255, 0.4) !important;
        }

        /* Glassmorphism Utility */
        .glass {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
        }

        .glass-dropdown {
            background: rgba(15, 23, 42, 0.95) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border) !important;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            padding: 10px !important;
            border-radius: 20px !important;
        }

        .glass-dropdown .dropdown-item {
            color: #f1f5f9 !important;
            padding: 10px 16px !important;
            border-radius: 10px !important;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .glass-dropdown .dropdown-item:hover {
            background: rgba(99, 102, 241, 0.1) !important;
            color: var(--primary-color) !important;
        }

        .glass-dropdown .dropdown-item.text-danger:hover {
            background: rgba(239, 68, 68, 0.1) !important;
            color: #ef4444 !important;
        }

        .glass-dropdown .dropdown-divider {
            border-color: var(--glass-border);
            margin: 8px 0;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background: var(--sidebar-color);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-right: 1px solid var(--glass-border);
        }

        .sidebar-brand {
            padding: 40px 24px;
            display: flex;
            align-items: center;
            text-decoration: none;
            gap: 12px;
        }

        .sidebar-brand-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--primary-color), #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 22px;
            border-radius: 12px;
            box-shadow: 0 0 20px var(--primary-glow);
        }

        .sidebar-brand-text {
            color: white;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-nav {
            flex: 1;
            padding: 0 16px;
            list-style: none;
            overflow-y: auto;
        }

        .sidebar-nav-header {
            color: var(--text-muted);
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            padding: 32px 16px 12px;
            opacity: 1;
            /* Removed transparency for better readability */
        }

        .sidebar-nav-item {
            margin-bottom: 8px;
        }

        .sidebar-nav-link {
            display: flex;
            align-items: center;
            padding: 14px 16px;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            gap: 14px;
            font-size: 15px;
            border-radius: 12px;
        }

        .sidebar-nav-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.05);
            transform: translateX(4px);
        }

        .sidebar-nav-link.active {
            color: white;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            box-shadow: 0 4px 15px var(--primary-glow);
        }

        .sidebar-nav-link i {
            width: 20px;
            font-size: 18px;
            transition: all 0.3s;
        }

        .sidebar-nav-link:hover i {
            color: var(--primary-color);
        }

        .sidebar-nav-link.active i {
            color: white;
        }

        .sidebar-nav-badge {
            margin-left: auto;
            background: rgba(99, 102, 241, 0.2);
            color: var(--primary-color);
            padding: 2px 8px;
            font-size: 9px;
            font-weight: 800;
            border-radius: 6px;
            text-transform: uppercase;
        }

        /* Main Content */
        .main-wrapper {
            flex: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            position: relative;
        }

        /* Navbar */
        .top-navbar {
            height: 80px;
            background: rgba(11, 15, 26, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            position: sticky;
            top: 0;
            z-index: 900;
            border-bottom: 1px solid var(--glass-border);
        }

        .search-wrapper {
            max-width: 520px;
            width: 100%;
            position: relative;
        }

        .search-input {
            width: 100%;
            height: 48px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            padding: 0 20px 0 52px;
            font-size: 14px;
            color: white;
            transition: all 0.3s;
            border-radius: 14px;
        }

        .search-input:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--primary-color);
            box-shadow: 0 0 15px var(--primary-glow);
            outline: none;
        }

        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 16px;
        }

        /* Right Header Actions */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            border-radius: 12px;
            gap: 10px;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), #8b5cf6);
            color: white;
            box-shadow: 0 4px 15px var(--primary-glow);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px var(--primary-glow);
            filter: brightness(1.1);
        }

        .btn-outline {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            color: white;
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--text-muted);
            transform: translateY(-2px);
        }

        .user-menu-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            padding: 6px 12px 6px 6px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .user-menu-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary-color);
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--primary-color), #8b5cf6);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            border-radius: 10px;
        }

        /* Content Area */
        main {
            padding: 40px;
            flex: 1;
            transition: padding 0.3s;
        }

        @media (max-width: 1024px) {
            main {
                padding: 30px;
            }
        }

        @media (max-width: 768px) {
            main {
                padding: 24px;
            }
        }

        @media (max-width: 480px) {
            main {
                padding: 16px;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
                box-shadow: 20px 0 50px rgba(0, 0, 0, 0.5);
            }

            .main-wrapper {
                margin-left: 0;
            }

            .top-navbar {
                padding: 0 20px;
            }
        }

        /* Footer */
        footer {
            background: rgba(11, 15, 26, 0.8);
            backdrop-filter: blur(12px);
            border-top: 1px solid var(--glass-border);
            padding: 40px;
            margin-top: auto;
        }

        @media (max-width: 768px) {
            footer {
                padding: 30px 24px;
            }
        }

        footer a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.3s;
        }

        footer a:hover {
            color: var(--primary-color);
        }

        /* Mobile Toggle & Overlay */
        .sidebar-toggle {
            display: none;
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            border: none;
            box-shadow: 0 10px 30px var(--primary-glow);
            z-index: 1100;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-toggle:hover {
            transform: scale(1.1) rotate(90deg);
            background: var(--primary-hover);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(11, 15, 26, 0.6);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 950;
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
        }

        @media (max-width: 1024px) {
            .sidebar-toggle {
                display: flex;
            }

            .sidebar-overlay.active {
                display: block;
                opacity: 1;
                pointer-events: auto;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <a class="sidebar-brand" href="{{ url('/') }}">
            <div class="sidebar-brand-icon">
                <i class="fas fa-atom"></i>
            </div>
            <span class="sidebar-brand-text">AURA</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-nav-item">
                <a href="{{ url('/') }}" class="sidebar-nav-link {{ request()->is('/') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Trang chủ</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('explore') }}"
                    class="sidebar-nav-link {{ request()->routeIs('explore') ? 'active' : '' }}">
                    <i class="fas fa-compass"></i>
                    <span>Khám phá</span>
                    <span class="sidebar-nav-badge">Mới</span>
                </a>
            </li>

            <li class="sidebar-nav-header">Danh mục</li>
            @php
                $categoryIcons = ['code', 'database', 'mobile-alt', 'paint-brush', 'chart-line', 'camera', 'language', 'briefcase'];
            @endphp
            @foreach($sidebarCategories ?? [] as $category)
                @if($category)
                    <li class="sidebar-nav-item">
                        <a href="{{ route('explore', ['category' => $category->id]) }}"
                            class="sidebar-nav-link {{ request('category') == $category->id ? 'active' : '' }}">
                            <i class="fas fa-{{ $categoryIcons[$loop->index % count($categoryIcons)] }}"></i>
                            <span>{{ $category->name }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
            @if(empty($sidebarCategories))
                <li class="sidebar-nav-item">
                    <a href="#" class="sidebar-nav-link">
                        <i class="fas fa-folder-open"></i>
                        <span>Chưa có danh mục</span>
                    </a>
                </li>
            @endif

            @auth
                @if(auth()->user()->isAdmin())
                    {{-- Admin Menu --}}
                    <li class="sidebar-nav-header">Quản trị</li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                            class="sidebar-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-chart-pie"></i>
                            <span>Bảng điều khiển</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('admin.users.index') }}"
                            class="sidebar-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <span>Người dùng</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('admin.courses.index') }}"
                            class="sidebar-nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                            <i class="fas fa-book"></i>
                            <span>Khóa học</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('admin.categories.index') }}"
                            class="sidebar-nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <i class="fas fa-tags"></i>
                            <span>Danh mục</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('admin.sliders.index') }}"
                            class="sidebar-nav-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                            <i class="fas fa-photo-video"></i>
                            <span>Sliders</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('admin.orders.index') }}"
                            class="sidebar-nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Đơn hàng</span>
                        </a>
                    </li>
                @elseif(auth()->user()->isInstructor())
                    {{-- Instructor Menu --}}
                    <li class="sidebar-nav-header">Giảng viên</li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('instructor.courses.index') }}"
                            class="sidebar-nav-link {{ request()->routeIs('instructor.courses.*') ? 'active' : '' }}">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>Quản lý khóa học</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('profile.show') }}"
                            class="sidebar-nav-link {{ request()->routeIs('profile.show') ? 'active' : '' }}">
                            <i class="fas fa-user-circle"></i>
                            <span>Hồ sơ cá nhân</span>
                        </a>
                    </li>
                @else
                    {{-- Student/User Menu --}}
                    <li class="sidebar-nav-header">Tài khoản</li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('profile.show') }}"
                            class="sidebar-nav-link {{ request()->routeIs('profile.show') ? 'active' : '' }}">
                            <i class="fas fa-user-circle"></i>
                            <span>Hồ sơ cá nhân</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('profile.orders') }}"
                            class="sidebar-nav-link {{ request()->is('orders') ? 'active' : '' }}">
                            <i class="fas fa-book-open"></i>
                            <span>Khóa học của tôi</span>
                        </a>
                    </li>
                @endif
            @endauth
        </ul>
    </aside>

    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div class="search-wrapper">
                <form action="{{ url('/') }}" method="GET">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" name="q" class="search-input"
                        placeholder="Tìm kiếm khóa học, chủ đề, giảng viên..." value="{{ request('q') }}">
                </form>
            </div>

            <div class="header-actions">
                @guest
                    <a href="{{ route('login.form') }}" class="btn btn-outline">
                        Đăng nhập
                    </a>
                    <a href="{{ route('register.form') }}" class="btn btn-primary">
                        Đăng ký
                    </a>
                @else
                    <div class="dropdown">
                        <button class="glass" type="button" data-bs-toggle="dropdown"
                            style="width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; position: relative;">
                            <i class="fas fa-bell" style="color: white; font-size: 18px;"></i>
                            <span
                                style="position: absolute; top: 5px; right: 5px; background: var(--primary-color); color: white; font-size: 10px; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">3</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end p-0 shadow-lg border-0 glass-dropdown"
                            style="width: 320px; border-radius: 20px; overflow: hidden; background: var(--card-bg); backdrop-filter: blur(20px); border: 1px solid var(--glass-border) !important;">
                            <li
                                style="padding: 16px 20px; border-bottom: 1px solid var(--glass-border); display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-weight: 700; font-family: 'Outfit'; color: white;">Thông báo</span>
                                <span
                                    style="background: rgba(99, 102, 241, 0.1); color: var(--primary-color); padding: 4px 10px; border-radius: 8px; font-size: 10px; font-weight: 700; border: 1px solid var(--primary-glow);">3
                                    MỚI</span>
                            </li>
                            <li class="dropdown-item p-3"
                                style="cursor: pointer; border-bottom: 1px solid var(--glass-border);">
                                <div style="display: flex; gap: 14px;">
                                    <div class="glass"
                                        style="width: 38px; height: 38px; background: rgba(99, 102, 241, 0.1); color: var(--primary-color); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid var(--primary-glow);">
                                        <i class="fas fa-book-open"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 700; font-size: 14px; color: white;">Khóa học mới</div>
                                        <div style="font-size: 12px; color: var(--text-muted); line-height: 1.4;">"Mastering
                                            AI with Aura" vừa ra mắt.</div>
                                        <div
                                            style="color: var(--primary-color); margin-top: 6px; font-size: 10px; font-weight: 800; text-transform: uppercase;">
                                            2 phút trước</div>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown-item p-3" style="cursor: pointer;">
                                <div style="display: flex; gap: 14px;">
                                    <div class="glass"
                                        style="width: 38px; height: 38px; background: rgba(16, 185, 129, 0.1); color: #10b981; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid rgba(16, 185, 129, 0.2);">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 700; font-size: 14px; color: white;">Thanh toán thành công
                                        </div>
                                        <div style="font-size: 12px; color: var(--text-muted); line-height: 1.4;">Đơn hàng
                                            của bạn đã được xác nhận.</div>
                                        <div
                                            style="color: #10b981; margin-top: 6px; font-size: 10px; font-weight: 800; text-transform: uppercase;">
                                            1 giờ trước</div>
                                    </div>
                                </div>
                            </li>
                            <li style="padding: 12px;">
                                <a href="#"
                                    style="text-decoration: none; color: var(--primary-color); font-weight: 700; font-size: 13px; display: block; text-align: center; text-transform: uppercase; letter-spacing: 1px;">Xem
                                    tất cả</a>
                            </li>
                        </ul>
                    </div>

                    <div class="dropdown">
                        <button class="user-menu-btn" type="button" data-bs-toggle="dropdown"
                            style="border-radius: 12px; padding: 6px 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border);">
                            <div class="user-avatar" style="width:32px; height:32px;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <i class="fas fa-chevron-down ms-2" style="font-size: 10px; color: #9ca3af;"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end glass-dropdown">
                            <li
                                style="padding: 10px 16px; margin-bottom: 8px; background: rgba(99, 102, 241, 0.1); border-radius: 12px; border: 1px solid var(--primary-glow);">
                                <div style="font-weight: 700; color: white; font-family: 'Outfit';">
                                    {{ Auth::user()->name }}</div>
                                <div style="font-size: 12px; color: var(--text-muted);">{{ Auth::user()->email }}</div>
                            </li>

                            @if(auth()->user()->isAdmin())
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i
                                            class="fas fa-chart-pie me-2 text-primary"></i>Bảng điều khiển</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.users.index') }}"><i
                                            class="fas fa-users me-2 text-primary"></i>Quản lý người dùng</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.courses.index') }}"><i
                                            class="fas fa-book me-2 text-primary"></i>Quản lý khóa học</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}"><i
                                            class="fas fa-tags me-2 text-primary"></i>Danh mục</a></li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i
                                            class="fas fa-user-circle me-2 text-primary"></i>Hồ sơ cá nhân</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.orders') }}"><i
                                            class="fas fa-book-open me-2 text-primary"></i>Khóa học của tôi</a></li>
                            @endif

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">
                                        <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </nav>

        <!-- Main Content -->
        <main>
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4 fade-in-up">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                        <div>
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('success') || session('status'))
                <div class="alert alert-success alert-dismissible fade show mb-4 fade-in-up">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-3 fs-4"></i>
                        <div>{{ session('success') ?? session('status') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4 fade-in-up">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle me-3 fs-4"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer (compact single-row) -->
        <footer>
            <div class="container-fluid d-flex flex-wrap align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="sidebar-brand-icon" style="width:36px;height:36px;font-size:16px;">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div>
                        <div class="fw-bold">LMS PRO</div>
                        <div class="small" style="opacity:0.9">Nền tảng học trực tuyến hàng đầu Việt Nam</div>
                    </div>
                </div>

                <div class="d-none d-md-flex align-items-center gap-4">
                    <a href="#">Tất cả khóa học</a>
                    <a href="#">Giới thiệu</a>
                    <a href="#">Hợp tác</a>
                </div>

                <div class="small" style="opacity:0.85">&copy; {{ date('Y') }} LMS PRO</div>
            </div>
        </footer>
    </div>

    <!-- Sidebar Toggle Button -->
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Bootstrap JS for dropdown functionality -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sidebar Toggle for Mobile
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
        });

        sidebarOverlay.addEventListener('click', function () {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
        });

        // Shrink page header on scroll
        (function () {
            const header = document.querySelector('.page-header');
            if (!header) return;
            let lastScroll = 0;
            window.addEventListener('scroll', function () {
                const current = window.scrollY || window.pageYOffset;
                if (current > 80) {
                    header.classList.add('shrink');
                } else {
                    header.classList.remove('shrink');
                }
                lastScroll = current;
            }, { passive: true });
        })();
    </script>
    @stack('scripts')
</body>

</html>