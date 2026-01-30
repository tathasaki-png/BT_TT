<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Học trực tuyến'); ?> - <?php echo e(config('app.name', 'LMS PRO')); ?></title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #16a34a;
            --primary-hover: #15803d;
            --secondary-color: #0f172a;
            --bg-color: #f6fff7;
            --sidebar-color: #063a12;
            --text-main: #0b3520;
            --text-muted: #4b6b57;
            --border-color: #dff5e6;
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
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 240px;
            background-color: var(--sidebar-color);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sidebar-brand {
            padding: 32px 24px;
            display: flex;
            align-items: center;
            text-decoration: none;
            gap: 12px;
        }

        .sidebar-brand-icon {
            width: 40px;
            height: 40px;
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            /* Keep it square as requested */
        }

        .sidebar-brand-text {
            color: white;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 0 16px;
            list-style: none;
            overflow-y: auto;
        }

        .sidebar-nav-header {
            color: #4b5563;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 24px 16px 8px;
        }

        .sidebar-nav-item {
            margin-bottom: 4px;
        }

        .sidebar-nav-link {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: #9ca3af;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
            gap: 12px;
            font-size: 14px;
        }

        .sidebar-nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.05);
        }

        .sidebar-nav-link.active {
            color: white;
            background-color: var(--primary-color);
        }

        .sidebar-nav-link i {
            width: 20px;
            font-size: 16px;
        }

        .sidebar-nav-badge {
            margin-left: auto;
            background-color: rgba(255, 255, 255, 0.1);
            padding: 2px 8px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }

        /* Main Content */
        .main-wrapper {
            flex: 1;
            margin-left: 240px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navbar */
        .top-navbar {
            height: 64px;
            background: var(--white);
            border-bottom: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: sticky;
            top: 0;
            z-index: 900;
            box-shadow: 0 6px 18px rgba(6, 58, 18, 0.04);
        }

        .search-wrapper {
            max-width: 480px;
            width: 100%;
            position: relative;
        }

        .search-input {
            width: 100%;
            height: 44px;
            background: #f1f5f9;
            border: 1px solid transparent;
            padding: 0 16px 0 44px;
            font-size: 14px;
            color: var(--text-main);
            transition: all 0.2s;
        }

        .search-input:focus {
            background: white;
            border-color: var(--primary-color);
            outline: none;
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        /* Right Header Actions */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            border: none;
            gap: 8px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        /* Ensure any .text-primary uses our theme */
        .text-primary {
            color: var(--primary-color) !important;
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-main);
        }

        .btn-outline:hover {
            background-color: #f1f5f9;
        }

        .user-menu-btn {
            background: none;
            border: none;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            border-radius: 50%;
        }

        /* Content Context */
        main {
            padding: 24px;
            flex: 1;
        }

        /* Dropdown Menu Styles */
        .dropdown-menu {
            display: none;
        }
        
        .dropdown-menu.show {
            display: block;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeInUp 0.4s ease-out;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .main-wrapper {
                margin-left: 0;
            }
            .sidebar.active {
                transform: translateX(0);
            }
        }

        /* Footer styles (green theme) - compact */
        footer {
            background: linear-gradient(180deg, rgba(6,58,18,0.98), rgba(6,58,18,0.98));
            color: rgba(255,255,255,0.95);
            padding: 20px 18px;
        }

        footer .container-fluid { padding-left: 8px; padding-right: 8px; }

        footer a {
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            line-height: 1.4;
        }

        footer .footer-heading {
            font-weight: 700;
            color: white;
            margin-bottom: 8px;
            font-size: 14px;
        }

        footer .social-icon {
            width: 30px;
            height: 30px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.05);
            color: white;
            margin-right: 6px;
            text-decoration: none;
            font-size: 14px;
        }

        footer p.small { color: rgba(255,255,255,0.75); margin-bottom: 6px; }

        hr.opacity-10 { border-color: rgba(255,255,255,0.06); margin: 12px 0; }

        @media (max-width: 992px) {
            footer { padding: 18px 12px; }
            footer .row > div { margin-bottom: 8px; }
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <a class="sidebar-brand" href="<?php echo e(url('/')); ?>">
            <div class="sidebar-brand-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <span class="sidebar-brand-text">LMS PRO</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-nav-item">
                <a href="<?php echo e(url('/')); ?>" class="sidebar-nav-link <?php echo e(request()->is('/') ? 'active' : ''); ?>">
                    <i class="fas fa-home"></i>
                    <span>Trang chủ</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="<?php echo e(route('explore')); ?>" class="sidebar-nav-link <?php echo e(request()->routeIs('explore') ? 'active' : ''); ?>">
                    <i class="fas fa-compass"></i>
                    <span>Khám phá</span>
                    <span class="sidebar-nav-badge">Mới</span>
                </a>
            </li>

            <li class="sidebar-nav-header">Danh mục</li>
            <?php
                $categoryIcons = ['code', 'database', 'mobile-alt', 'paint-brush', 'chart-line', 'camera', 'language', 'briefcase'];
            ?>
            <?php $__empty_1 = true; $__currentLoopData = $sidebarCategories ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li class="sidebar-nav-item">
                    <a href="<?php echo e(route('explore', ['category' => $category->id])); ?>" class="sidebar-nav-link <?php echo e(request('category') == $category->id ? 'active' : ''); ?>">
                        <i class="fas fa-<?php echo e($categoryIcons[$loop->index % count($categoryIcons)]); ?>"></i>
                        <span><?php echo e($category->name); ?></span>
                    </a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="sidebar-nav-item">
                    <a href="#" class="sidebar-nav-link">
                        <i class="fas fa-folder-open"></i>
                        <span>Chưa có danh mục</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->isAdmin()): ?>
                    
                    <li class="sidebar-nav-header">Quản trị</li>
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                            <i class="fas fa-chart-pie"></i>
                            <span>Bảng điều khiển</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="sidebar-nav-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>">
                            <i class="fas fa-users"></i>
                            <span>Người dùng</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('admin.courses.index')); ?>" class="sidebar-nav-link <?php echo e(request()->routeIs('admin.courses.*') ? 'active' : ''); ?>">
                            <i class="fas fa-book"></i>
                            <span>Khóa học</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('admin.categories.index')); ?>" class="sidebar-nav-link <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>">
                            <i class="fas fa-tags"></i>
                            <span>Danh mục</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('admin.sliders.index')); ?>" class="sidebar-nav-link <?php echo e(request()->routeIs('admin.sliders.*') ? 'active' : ''); ?>">
                            <i class="fas fa-photo-video"></i>
                            <span>Sliders</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('admin.orders.index')); ?>" class="sidebar-nav-link <?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Đơn hàng</span>
                        </a>
                    </li>
                <?php elseif(auth()->user()->isInstructor()): ?>
                    
                    <li class="sidebar-nav-header">Giảng viên</li>
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('instructor.courses.index')); ?>" class="sidebar-nav-link <?php echo e(request()->routeIs('instructor.courses.*') ? 'active' : ''); ?>">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>Quản lý khóa học</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('profile.show')); ?>" class="sidebar-nav-link <?php echo e(request()->routeIs('profile.show') ? 'active' : ''); ?>">
                            <i class="fas fa-user-circle"></i>
                            <span>Hồ sơ cá nhân</span>
                        </a>
                    </li>
                <?php else: ?>
                    
                    <li class="sidebar-nav-header">Tài khoản</li>
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('profile.show')); ?>" class="sidebar-nav-link <?php echo e(request()->routeIs('profile.show') ? 'active' : ''); ?>">
                            <i class="fas fa-user-circle"></i>
                            <span>Hồ sơ cá nhân</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('profile.orders')); ?>" class="sidebar-nav-link <?php echo e(request()->is('orders') ? 'active' : ''); ?>">
                            <i class="fas fa-book-open"></i>
                            <span>Khóa học của tôi</span>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
        </ul>
    </aside>

    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div class="search-wrapper">
                <form action="<?php echo e(url('/')); ?>" method="GET">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" name="q" class="search-input"
                        placeholder="Tìm kiếm khóa học, chủ đề, giảng viên..." value="<?php echo e(request('q')); ?>">
                </form>
            </div>

            <div class="header-actions">
                <?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('login.form')); ?>" class="btn btn-outline">
                        Đăng nhập
                    </a>
                    <a href="<?php echo e(route('register.form')); ?>" class="btn btn-primary">
                        Đăng ký
                    </a>
                <?php else: ?>
                    <div class="dropdown">
                        <button class="btn p-2" type="button" data-bs-toggle="dropdown"
                            style="background: #f1f5f9; border-radius: 8px; border: none; position: relative;">
                            <i class="fas fa-bell" style="color: #64748b; font-size: 18px;"></i>
                            <span style="position: absolute; top: 5px; right: 5px; background: var(--primary-color); color: white; font-size: 10px; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">3</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end p-0 shadow-lg border-0" style="width: 320px; border-radius: 8px; overflow: hidden;">
                            <li style="padding: 12px 16px; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-weight: 600; font-size: 16px;">Thông báo</span>
                                <span style="background: rgba(22,163,74,0.08); color: var(--primary-color); padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: 600;">3 mới</span>
                            </li>
                            <li class="dropdown-item" style="cursor: pointer;">
                                <div style="display: flex; gap: 12px;">
                                    <div>
                                        <div style="width: 32px; height: 32px; background: rgba(22,163,74,0.08); color: var(--primary-color); border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <i class="fas fa-book"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; font-size: 14px;">Khóa học mới</div>
                                        <div style="font-size: 12px; color: #64748b;">Khóa học "Master ReactJS" vừa được thêm vào hệ thống.</div>
                                        <div style="color: var(--primary-color); margin-top: 4px; font-size: 11px;">2 phút trước</div>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown-item" style="cursor: pointer;">
                                <div style="display: flex; gap: 12px;">
                                    <div>
                                        <div style="width: 32px; height: 32px; background: rgba(22,163,74,0.12); color: var(--primary-color); border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; font-size: 14px;">Thanh toán thành công</div>
                                        <div style="font-size: 12px; color: #64748b;">Bạn đã thanh toán thành công khóa học lập trình.</div>
                                        <div style="color: var(--primary-color); margin-top: 4px; font-size: 11px;">1 giờ trước</div>
                                    </div>
                                </div>
                            </li>
                            <li style="padding: 8px;">
                                <a href="#" style="text-decoration: none; color: var(--primary-color); font-weight: 600; font-size: 14px; display: block; text-align: center;">Xem tất cả thông báo</a>
                            </li>
                        </ul>
                    </div>

                    <div class="dropdown">
                        <button class="user-menu-btn" type="button" data-bs-toggle="dropdown">
                            <div class="user-avatar">
                                <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                            </div>
                            <span class="user-name" style="display: none;"><?php echo e(Auth::user()->name); ?></span>
                            <i class="fas fa-chevron-down" style="font-size: 10px; color: #64748b;"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" style="border-radius: 8px; overflow: hidden;">
                            <li style="padding: 8px 12px; margin-bottom: 8px; background: rgba(99, 102, 241, 0.1); border-radius: 6px;">
                                <div style="font-weight: 600;"><?php echo e(Auth::user()->name); ?></div>
                                <small style="color: #64748b;"><?php echo e(Auth::user()->email); ?></small>
                            </li>
                            
                            <?php if(auth()->user()->isAdmin()): ?>
                                <li><a class="dropdown-item" href="<?php echo e(route('admin.dashboard')); ?>"><i class="fas fa-chart-pie me-2 text-primary"></i>Bảng điều khiển</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('admin.users.index')); ?>"><i class="fas fa-users me-2 text-primary"></i>Quản lý người dùng</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('admin.courses.index')); ?>"><i class="fas fa-book me-2 text-primary"></i>Quản lý khóa học</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('admin.categories.index')); ?>"><i class="fas fa-tags me-2 text-primary"></i>Danh mục</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="<?php echo e(route('profile.show')); ?>"><i class="fas fa-user-circle me-2 text-primary"></i>Hồ sơ cá nhân</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('profile.orders')); ?>"><i class="fas fa-book-open me-2 text-primary"></i>Khóa học của tôi</a></li>
                            <?php endif; ?>
                            
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button class="dropdown-item text-danger" type="submit">
                                        <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </nav>

        <!-- Main Content -->
        <main>
            <?php if($errors->any()): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4 fade-in-up">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                        <div>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div><?php echo e($error); ?></div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('success') || session('status')): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4 fade-in-up">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-3 fs-4"></i>
                        <div><?php echo e(session('success') ?? session('status')); ?></div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4 fade-in-up">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle me-3 fs-4"></i>
                        <div><?php echo e(session('error')); ?></div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
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

                <div class="small" style="opacity:0.85">&copy; <?php echo e(date('Y')); ?> LMS PRO</div>
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
        (function() {
            const header = document.querySelector('.page-header');
            if (!header) return;
            let lastScroll = 0;
            window.addEventListener('scroll', function() {
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
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH C:\xampp\htdocs\TTS\khoahoc\resources\views/layouts/app.blade.php ENDPATH**/ ?>