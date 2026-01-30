<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Quản trị'); ?> - Admin Panel</title>

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        :root {
            --primary-color: #6366f1;
            --primary-hover: #4f46e5;
            --primary-light: rgba(99, 102, 241, 0.1);
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-active: #6366f1;
            --body-bg: #f8fafc;
            --card-bg: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--body-bg);
            color: var(--text-primary);
            min-height: 100vh;
        }

        /* Sidebar */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            background: var(--sidebar-bg);
            z-index: 1000;
            transition: transform 0.3s ease;
            overflow-y: auto;
        }

        .admin-sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .admin-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-decoration: none;
        }

        .sidebar-brand-icon {
            width: 42px;
            height: 42px;
            background: var(--primary-color);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }

        .sidebar-brand-text {
            color: white;
            font-size: 20px;
            font-weight: 700;
        }

        .sidebar-menu {
            list-style: none;
            padding: 16px 12px;
            margin: 0;
        }

        .sidebar-menu-header {
            color: #64748b;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 16px 16px 8px;
            margin-top: 8px;
        }

        .sidebar-menu-item {
            margin-bottom: 4px;
        }

        .sidebar-menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .sidebar-menu-link:hover {
            color: white;
            background: var(--sidebar-hover);
        }

        .sidebar-menu-link.active {
            color: white;
            background: var(--sidebar-active);
        }

        .sidebar-menu-link i {
            width: 20px;
            font-size: 16px;
        }

        .sidebar-menu-badge {
            margin-left: auto;
            background: rgba(255, 255, 255, 0.15);
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        /* Main Content */
        .admin-main {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Navbar */
        .admin-navbar {
            height: 64px;
            background: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 20px;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 8px;
        }

        .navbar-search {
            position: relative;
        }

        .navbar-search input {
            width: 300px;
            height: 40px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0 16px 0 40px;
            font-size: 14px;
            background: var(--body-bg);
            transition: all 0.2s;
        }

        .navbar-search input:focus {
            outline: none;
            border-color: var(--primary-color);
            background: white;
        }

        .navbar-search i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .navbar-icon-btn {
            position: relative;
            width: 40px;
            height: 40px;
            border: none;
            background: var(--body-bg);
            border-radius: 8px;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s;
        }

        .navbar-icon-btn:hover {
            background: var(--primary-light);
            color: var(--primary-color);
        }

        .navbar-icon-btn .badge {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 18px;
            height: 18px;
            background: #ef4444;
            color: white;
            font-size: 10px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: white;
            cursor: pointer;
            transition: all 0.2s;
        }

        .user-dropdown:hover {
            border-color: var(--primary-color);
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: var(--primary-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .user-info {
            text-align: left;
        }

        .user-name {
            font-weight: 600;
            font-size: 13px;
            color: var(--text-primary);
        }

        .user-role {
            font-size: 11px;
            color: var(--text-secondary);
        }

        /* Content Area */
        .admin-content {
            flex: 1;
            padding: 24px;
        }

        /* Page Header */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .page-subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin-top: 4px;
        }

        .breadcrumb {
            background: none;
            padding: 0;
            margin: 0 0 8px 0;
            font-size: 13px;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--text-secondary);
        }

        /* Cards */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border-color);
            padding: 16px 20px;
            font-weight: 600;
        }

        .card-body {
            padding: 20px;
        }

        /* Stats Cards */
        .stats-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            border: 1px solid var(--border-color);
            transition: all 0.2s;
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .stats-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stats-icon.primary {
            background: var(--primary-light);
            color: var(--primary-color);
        }

        .stats-icon.info {
            background: #dbeafe;
            color: #3b82f6;
        }

        .stats-icon.warning {
            background: #fef3c7;
            color: #f59e0b;
        }

        .stats-icon.danger {
            background: #fee2e2;
            color: #ef4444;
        }

        .stats-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
            margin-top: 12px;
        }

        .stats-label {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 4px;
        }

        /* Tables */
        .table {
            margin-bottom: 0;
        }

        .table th {
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
            background: var(--body-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 12px 16px;
        }

        .table td {
            padding: 16px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
        }

        .table tbody tr:hover {
            background: #f8fafc;
        }

        /* Buttons */
        .btn {
            font-weight: 500;
            font-size: 14px;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 13px;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Forms */
        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid var(--border-color);
            padding: 10px 14px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
        }

        .form-label {
            font-weight: 500;
            font-size: 14px;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        /* Badges */
        .badge {
            font-weight: 500;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 12px;
        }

        .badge.bg-success {
            background: #dcfce7 !important;
            color: #16a34a;
        }

        .badge.bg-warning {
            background: #fef3c7 !important;
            color: #d97706;
        }

        .badge.bg-danger {
            background: #fee2e2 !important;
            color: #dc2626;
        }

        .badge.bg-info {
            background: #dbeafe !important;
            color: #2563eb;
        }

        .badge.bg-secondary {
            background: #f1f5f9 !important;
            color: #64748b;
        }

        .badge.bg-primary {
            background: var(--primary-light) !important;
            color: var(--primary-color);
        }

        /* Alerts */
        .alert {
            border-radius: 10px;
            border: none;
            padding: 16px 20px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .alert-info {
            background: #dbeafe;
            color: #1e40af;
        }

        /* Pagination */
        .pagination {
            gap: 4px;
        }

        .page-link {
            border-radius: 8px;
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 8px 14px;
        }

        .page-link:hover {
            background: var(--primary-light);
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .page-item.active .page-link {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Dropdown */
        .dropdown-menu {
            border-radius: 10px;
            border: 1px solid var(--border-color);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 8px;
        }

        .dropdown-item {
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 14px;
        }

        .dropdown-item:hover {
            background: var(--body-bg);
        }

        .dropdown-divider {
            margin: 8px 0;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-sidebar.show {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: block;
            }

            .navbar-search input {
                width: 200px;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }

        @media (max-width: 576px) {
            .navbar-search {
                display: none;
            }

            .user-info {
                display: none;
            }

            .admin-content {
                padding: 16px;
            }
        }

        /* Animations */
        @keyframes fadeIn {
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
            animation: fadeIn 0.3s ease-out;
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-brand">
            <div class="sidebar-brand-icon" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                <i class="fas fa-atom"></i>
            </div>
            <span class="sidebar-brand-text" style="font-family: 'Outfit'; letter-spacing: 1px;">AURA <span
                    style="font-weight: 400; opacity: 0.7;">Admin</span></span>
        </a>

        <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
                <a href="<?php echo e(route('admin.dashboard')); ?>"
                    class="sidebar-menu-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                    <i class="fas fa-chart-pie"></i>
                    <span>Bảng điều khiển</span>
                </a>
            </li>

            <div class="sidebar-menu-header">Quản lý nội dung</div>

            <li class="sidebar-menu-item">
                <a href="<?php echo e(route('admin.categories.index')); ?>"
                    class="sidebar-menu-link <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>">
                    <i class="fas fa-folder"></i>
                    <span>Danh mục</span>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a href="<?php echo e(route('admin.courses.index')); ?>"
                    class="sidebar-menu-link <?php echo e(request()->routeIs('admin.courses.*') && !request()->routeIs('admin.courses.lessons.*') ? 'active' : ''); ?>">
                    <i class="fas fa-book"></i>
                    <span>Khóa học</span>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a href="<?php echo e(route('admin.sliders.index')); ?>"
                    class="sidebar-menu-link <?php echo e(request()->routeIs('admin.sliders.*') ? 'active' : ''); ?>">
                    <i class="fas fa-images"></i>
                    <span>Sliders</span>
                </a>
            </li>

            <div class="sidebar-menu-header">Quản lý hệ thống</div>

            <li class="sidebar-menu-item">
                <a href="<?php echo e(route('admin.users.index')); ?>"
                    class="sidebar-menu-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>">
                    <i class="fas fa-users"></i>
                    <span>Người dùng</span>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a href="<?php echo e(route('admin.orders.index')); ?>"
                    class="sidebar-menu-link <?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Đơn hàng</span>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a href="<?php echo e(route('admin.revenue.index')); ?>"
                    class="sidebar-menu-link <?php echo e(request()->routeIs('admin.revenue.*') ? 'active' : ''); ?>">
                    <i class="fas fa-chart-line"></i>
                    <span>Doanh thu</span>
                </a>
            </li>

            <div class="sidebar-menu-header">Khác</div>

            <li class="sidebar-menu-item">
                <a href="<?php echo e(url('/')); ?>" class="sidebar-menu-link">
                    <i class="fas fa-globe"></i>
                    <span>Xem Website</span>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Đăng xuất</span>
                </a>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                    <?php echo csrf_field(); ?>
                </form>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <div class="admin-main">
        <!-- Top Navbar -->
        <nav class="admin-navbar">
            <div class="navbar-left">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="navbar-search">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Tìm kiếm...">
                </div>
            </div>

            <div class="navbar-right">
                <button class="navbar-icon-btn">
                    <i class="fas fa-bell"></i>
                    <span class="badge">3</span>
                </button>

                <div class="dropdown">
                    <button class="user-dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar">
                            <?php echo e(strtoupper(substr(Auth::user()->name ?? 'A', 0, 1))); ?>

                        </div>
                        <div class="user-info">
                            <div class="user-name"><?php echo e(Auth::user()->name ?? 'Admin'); ?></div>
                            <div class="user-role">Quản trị viên</div>
                        </div>
                        <i class="fas fa-chevron-down ms-2" style="font-size: 10px; color: var(--text-secondary);"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?php echo e(route('profile.show')); ?>"><i
                                    class="fas fa-user me-2"></i>Hồ sơ</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Cài đặt</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="admin-content fade-in">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4">
                    <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
    <?php echo $__env->yieldContent('content_after'); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('adminSidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
        });

        sidebarOverlay.addEventListener('click', function () {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        });

        // Global Anti-Spam for Sidebar Links
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('adminSidebar');
            if (sidebar) {
                sidebar.addEventListener('click', function (e) {
                    const link = e.target.closest('.sidebar-menu-link');
                    // Only prevent spam on links that lead to navigation and aren't already active
                    if (link && !link.classList.contains('active') && link.getAttribute('href') !== '#') {
                        if (sidebar.classList.contains('sidebar-loading')) {
                            e.preventDefault();
                            return false;
                        }

                        sidebar.classList.add('sidebar-loading');
                        const originalHtml = link.innerHTML;
                        // Add spinner but keep the layout
                        link.style.pointerEvents = 'none';
                        link.innerHTML = `<i class="fas fa-circle-notch fa-spin"></i><span>${link.querySelector('span').innerText}</span>`;

                        // Safety timeout to re-enable (handles browser caching or navigation cancels)
                        setTimeout(() => {
                            sidebar.classList.remove('sidebar-loading');
                            link.style.pointerEvents = 'auto';
                        }, 5000);
                    }
                });
            }
        });

        // Global Form Submission Guard
        document.addEventListener('submit', function (e) {
            const form = e.target;
            if (form.tagName === 'FORM') {
                const submitButtons = form.querySelectorAll('button[type="submit"], input[type="submit"]');
                submitButtons.forEach(btn => {
                    if (btn.hasAttribute('data-no-loader')) return;
                    btn.setAttribute('data-original-html', btn.innerHTML);
                    const loadingText = btn.getAttribute('data-loading-text') || 'Đang xử lý...';
                    btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> ${loadingText}`;
                    btn.disabled = true;
                    btn.classList.add('loading');
                });
            }
        });

        // Re-enable on back button
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                document.querySelectorAll('button[disabled].loading').forEach(btn => {
                    btn.disabled = false;
                    btn.classList.remove('loading');
                    if (btn.hasAttribute('data-original-html')) btn.innerHTML = btn.getAttribute('data-original-html');
                });
                const sidebar = document.getElementById('adminSidebar');
                if (sidebar) sidebar.classList.remove('sidebar-loading');
            }
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH D:\xampp\htdocs\khoahoc\resources\views/layouts/admin.blade.php ENDPATH**/ ?>