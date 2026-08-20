<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html, body {
            height: 100%;
            overflow: hidden;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            padding-left: 280px;
            padding-top: 80px;
            transition: padding-left 0.3s ease;
            height: 100vh;
            overflow: hidden;
        }

        /* ========================================== */
        /* ✅ NOTIFICATION TOAST STYLES */
        /* ========================================== */
        .notification-container {
            position: fixed;
            top: 90px;
            right: 20px;
            z-index: 9999;
            max-width: 380px;
            width: 100%;
        }
        .notification-toast {
            background: #fff;
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 10px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.15);
            border-left: 4px solid #4caf50;
            animation: slideInRight 0.4s ease;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        .notification-toast.error {
            border-left-color: #dc3545;
        }
        .notification-toast.warning {
            border-left-color: #ffc107;
        }
        .notification-toast.info {
            border-left-color: #17a2b8;
        }
        .notification-toast .notif-icon {
            font-size: 1.3rem;
            margin-top: 2px;
        }
        .notification-toast .notif-content {
            flex: 1;
        }
        .notification-toast .notif-title {
            font-weight: 600;
            color: #1a2e1a;
            font-size: 0.9rem;
        }
        .notification-toast .notif-message {
            color: #555;
            font-size: 0.85rem;
        }
        .notification-toast .notif-close {
            background: none;
            border: none;
            color: #aaa;
            cursor: pointer;
            font-size: 1rem;
            padding: 0 5px;
        }
        .notification-toast .notif-close:hover {
            color: #333;
        }
        .notification-toast.removing {
            animation: slideOutRight 0.3s ease forwards;
        }
        @keyframes slideInRight {
            from { transform: translateX(100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100px); opacity: 0; }
        }

        /* ========================================== */
        /* NAVBAR */
        /* ========================================== */
        .navbar {
            background: #1a2e1a !important;
            padding: 12px 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.3);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            height: 70px;
        }
        .navbar-brand {
            color: #fff !important;
            font-weight: bold;
            font-size: 1.4rem;
        }
        .navbar-brand i {
            color: #4caf50;
        }
        .navbar .nav-link {
            color: #d4d4d4 !important;
            font-weight: 500;
            transition: 0.3s;
            font-size: 0.95rem;
        }
        .navbar .nav-link:hover {
            color: #4caf50 !important;
        }
        .icon-btn {
            color: #d4d4d4;
            font-size: 1.1rem;
            margin: 0 6px;
            transition: 0.3s;
            background: none;
            border: none;
        }
        .icon-btn:hover {
            color: #4caf50;
            transform: scale(1.1);
        }
        .navbar-toggler {
            border-color: #4caf50;
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(76, 175, 80, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* ========================================== */
        /* FIXED SIDEBAR */
        /* ========================================== */
        .sidebar-wrapper {
            position: fixed;
            top: 70px;
            left: 0;
            width: 280px;
            height: calc(100vh - 70px);
            overflow-y: auto;
            background: #fff;
            border-right: 1px solid #e8f0e8;
            padding: 15px 15px;
            z-index: 1000;
            transition: width 0.3s ease;
        }
        .sidebar-wrapper::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-wrapper::-webkit-scrollbar-thumb {
            background: #4caf50;
            border-radius: 4px;
        }
        .sidebar-wrapper::-webkit-scrollbar-track {
            background: #e8f0e8;
        }

        /* ========================================== */
        /* SIDEBAR COLLAPSED */
        /* ========================================== */
        .sidebar-wrapper.collapsed {
            width: 70px;
        }
        .sidebar-wrapper.collapsed .user-name {
            display: none;
        }
        .sidebar-wrapper.collapsed .user-email {
            display: none;
        }
        .sidebar-wrapper.collapsed .sidebar-category {
            display: none;
        }
        .sidebar-wrapper.collapsed .sidebar-menu li {
            padding: 8px;
            justify-content: center;
        }
        .sidebar-wrapper.collapsed .sidebar-menu li .menu-text {
            display: none;
        }
        .sidebar-wrapper.collapsed .sidebar-menu li i {
            margin-right: 0;
            font-size: 1.1rem;
        }
        .sidebar-wrapper.collapsed .sidebar-menu li:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: #1a2e1a;
            color: #fff;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            white-space: nowrap;
            z-index: 999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            margin-left: 8px;
        }
        .sidebar-wrapper.collapsed .user-avatar {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        body.sidebar-collapsed {
            padding-left: 70px;
        }

        .sidebar-card .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #4caf50;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 8px;
            transition: all 0.3s ease;
        }
        .sidebar-card .user-name {
            text-align: center;
            font-weight: 700;
            color: #1a2e1a;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        .sidebar-card .user-email {
            text-align: center;
            color: #888;
            font-size: 0.75rem;
            transition: all 0.3s ease;
        }

        .toggle-sidebar-btn {
            background: #4caf50;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 0.9rem;
            transition: 0.3s;
            cursor: pointer;
            width: 100%;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .toggle-sidebar-btn:hover {
            background: #388e3c;
        }

        .sidebar-category {
            font-size: 0.6rem;
            font-weight: 700;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 10px 10px 3px;
            border-top: 1px solid #f0f0f0;
            margin-top: 5px;
            transition: all 0.3s ease;
        }
        .sidebar-category:first-child {
            border-top: none;
            margin-top: 0;
            padding-top: 3px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar-menu li {
            padding: 8px 12px;
            border-radius: 8px;
            transition: 0.3s;
            cursor: pointer;
            color: #555;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        .sidebar-menu li:hover {
            background: #f0f8f0;
            color: #4caf50;
        }
        .sidebar-menu li.active {
            background: #f0f8f0;
            color: #4caf50;
            font-weight: 600;
        }
        .sidebar-menu li i {
            margin-right: 12px;
            width: 18px;
            text-align: center;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        .sidebar-menu li .menu-text {
            flex: 1;
            transition: all 0.3s ease;
        }
        .sidebar-menu li a {
            color: inherit;
            text-decoration: none;
            display: flex;
            align-items: center;
            width: 100%;
        }

        /* ========================================== */
        /* PAGE HEADER */
        /* ========================================== */
        .page-header {
            background: #f8f9fa;
            color: #1a2e1a;
            padding: 12px 0 12px;
            border-bottom: 1px solid #e8f0e8;
            height: 70px;
            display: flex;
            align-items: center;
        }
        .page-header h2 {
            font-weight: 700;
            color: #1a2e1a;
            font-size: 1.4rem;
        }
        .page-header .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
            font-size: 0.85rem;
        }
        .page-header .breadcrumb a {
            color: #4caf50;
            text-decoration: none;
        }
        .page-header .breadcrumb .active {
            color: #888;
        }
        .page-header .text-muted {
            color: #888 !important;
            font-size: 0.9rem;
        }

        /* ========================================== */
        /* MAIN CONTENT - FULL HEIGHT NO SCROLL */
        /* ========================================== */
        .main-content {
            padding: 15px 25px 15px 25px;
            height: calc(100vh - 140px);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        /* ========================================== */
        /* DASHBOARD CARDS */
        /* ========================================== */
        .dashboard-card {
            background: #fff;
            border-radius: 12px;
            padding: 15px 18px;
            border: 1px solid #e8f0e8;
            transition: 0.3s;
            height: 100%;
        }
        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        .dashboard-card .card-number {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1a2e1a;
        }
        .dashboard-card .card-label {
            color: #888;
            font-size: 0.8rem;
        }
        .dashboard-card .card-icon {
            font-size: 1.5rem;
            float: right;
        }
        .dashboard-card .btn-sm {
            font-size: 0.7rem;
            padding: 3px 12px;
        }

        /* ========================================== */
        /* ORDERS - COMPACT */
        /* ========================================== */
        .order-item {
            background: #fff;
            border-radius: 10px;
            padding: 10px 15px;
            border: 1px solid #e8f0e8;
            margin-bottom: 8px;
            transition: 0.3s;
        }
        .order-item:hover {
            border-color: #4caf50;
        }
        .order-item .order-number {
            font-weight: 600;
            color: #1a2e1a;
            font-size: 0.85rem;
        }
        .order-item .order-date {
            color: #888;
            font-size: 0.75rem;
        }
        .order-item .order-total {
            font-weight: 700;
            color: #1a2e1a;
            font-size: 0.9rem;
        }

        .recent-orders-section {
            flex: 1;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .recent-orders-section .orders-list {
            flex: 1;
            overflow-y: auto;
            padding-right: 5px;
        }
        .recent-orders-section .orders-list::-webkit-scrollbar {
            width: 4px;
        }
        .recent-orders-section .orders-list::-webkit-scrollbar-thumb {
            background: #4caf50;
            border-radius: 4px;
        }
        .recent-orders-section .orders-list::-webkit-scrollbar-track {
            background: #e8f0e8;
        }

        .sections {
            display: none;
            height: 100%;
        }
        .sections.active {
            display: block;
        }

        .status-badge {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.65rem;
            font-weight: 600;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #cce5ff; color: #004085; }
        .status-processing { background: #d1ecf1; color: #0c5460; }
        .status-shipped { background: #d4edda; color: #155724; }
        .status-delivered { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }

        .btn-add-product {
            background: #4caf50;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-add-product:hover {
            background: #388e3c;
            color: #fff;
        }

        .section-content {
            height: 100%;
            overflow-y: auto;
            padding-bottom: 10px;
        }
        .section-content::-webkit-scrollbar {
            width: 4px;
        }
        .section-content::-webkit-scrollbar-thumb {
            background: #4caf50;
            border-radius: 4px;
        }
        .section-content::-webkit-scrollbar-track {
            background: #e8f0e8;
        }

        @media (max-width: 992px) {
            body {
                padding-left: 0;
            }
            .sidebar-wrapper {
                position: relative;
                top: 0;
                width: 100%;
                height: auto;
                border-right: none;
                border-bottom: 1px solid #e8f0e8;
            }
            .sidebar-wrapper.collapsed {
                width: 100%;
            }
            .sidebar-wrapper.collapsed .sidebar-menu li {
                justify-content: flex-start;
            }
            .sidebar-wrapper.collapsed .sidebar-menu li .menu-text {
                display: inline;
            }
            .sidebar-wrapper.collapsed .sidebar-menu li i {
                margin-right: 12px;
            }
            .sidebar-wrapper.collapsed .user-name {
                display: block;
            }
            .sidebar-wrapper.collapsed .user-email {
                display: block;
            }
            .sidebar-wrapper.collapsed .sidebar-category {
                display: block;
            }
            body.sidebar-collapsed {
                padding-left: 0;
            }
            .main-content {
                padding: 10px 15px;
                height: auto;
                overflow-y: auto;
            }
            html, body {
                overflow: auto;
            }
        }
    </style>
</head>
<body id="mainBody">

<!-- ✅ Notification Container -->
<div class="notification-container" id="notificationContainer"></div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="fas fa-store"></i> ShopEase</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="#">My Dashboard</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <a href="/cart" class="icon-btn" style="color:#d4d4d4;text-decoration:none;position:relative;">
                    <i class="fas fa-shopping-cart"></i>
                </a>
                <a href="/logout" class="icon-btn" style="color:#d4d4d4;text-decoration:none;"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </div>
</nav>

<!-- Fixed Sidebar -->
<div class="sidebar-wrapper" id="sidebarWrapper">
    <div class="sidebar-card">
        <button class="toggle-sidebar-btn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
            <span id="toggleText">Collapse</span>
        </button>

        <div class="user-avatar">
            <i class="fas fa-user"></i>
        </div>
        <div class="user-name"><?= session()->get('full_name') ?? 'Customer' ?></div>
        <div class="user-email"><?= session()->get('email') ?? 'customer@example.com' ?></div>

        <div class="sidebar-category">Account</div>
        <ul class="sidebar-menu">
            <li class="active" onclick="showSection('dashboard')" data-tooltip="Dashboard">
                <i class="fas fa-tachometer-alt"></i>
                <span class="menu-text">Dashboard</span>
            </li>
            <li onclick="showSection('profile')" data-tooltip="Profile">
                <i class="fas fa-user-cog"></i>
                <span class="menu-text">My Profile</span>
            </li>
            <li onclick="showSection('orders')" data-tooltip="Orders">
                <i class="fas fa-shopping-bag"></i>
                <span class="menu-text">My Orders</span>
            </li>
        </ul>

        <div class="sidebar-category">Addresses</div>
        <ul class="sidebar-menu">
            <li onclick="showSection('addresses')" data-tooltip="Addresses">
                <i class="fas fa-address-book"></i>
                <span class="menu-text">Saved Addresses</span>
            </li>
        </ul>

        <div class="sidebar-category">Settings</div>
        <ul class="sidebar-menu">
            <li onclick="showSection('settings')" data-tooltip="Settings">
                <i class="fas fa-cog"></i>
                <span class="menu-text">Account Settings</span>
            </li>
            <li>
                <a href="/logout" data-tooltip="Logout">
                    <i class="fas fa-sign-out-alt text-danger"></i>
                    <span class="menu-text">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Page Header -->
<section class="page-header">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-tachometer-alt me-2 text-success"></i>My Dashboard</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2">/</span>
                    <span class="active">Dashboard</span>
                </nav>
            </div>
            <div>
                <span class="text-muted">Welcome back, <?= session()->get('full_name') ?? 'Customer' ?>!</span>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="main-content">
    <div class="container-fluid px-4 h-100">
        <!-- Dashboard Section -->
        <div id="dashboardSection" class="sections active h-100">
            <div class="row mb-3" style="height: 30%;">
                <div class="col-md-3 mb-2">
                    <div class="dashboard-card" style="border-left: 4px solid #ffc107;">
                        <i class="fas fa-clock card-icon text-warning"></i>
                        <div class="card-number">2</div>
                        <div class="card-label">Pending Orders</div>
                        <button class="btn btn-sm btn-outline-warning mt-1" onclick="showNotification('warning', '⏳ Pending Orders', 'You have 2 pending orders.')">
                            View
                        </button>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="dashboard-card" style="border-left: 4px solid #17a2b8;">
                        <i class="fas fa-spinner card-icon text-info"></i>
                        <div class="card-number">1</div>
                        <div class="card-label">Processing Orders</div>
                        <button class="btn btn-sm btn-outline-info mt-1" onclick="showNotification('info', '⏳ Processing', 'Order #ORD-2026-08-03-003 is processing.')">
                            View
                        </button>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="dashboard-card" style="border-left: 4px solid #28a745;">
                        <i class="fas fa-check-circle card-icon text-success"></i>
                        <div class="card-number">8</div>
                        <div class="card-label">Delivered Orders</div>
                        <button class="btn btn-sm btn-outline-success mt-1" onclick="showNotification('success', '✅ Delivered', '8 orders delivered successfully!')">
                            View
                        </button>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="dashboard-card" style="border-left: 4px solid #dc3545;">
                        <i class="fas fa-heart card-icon text-danger"></i>
                        <div class="card-number">8</div>
                        <div class="card-label">Wishlist Items</div>
                        <button class="btn btn-sm btn-outline-danger mt-1" onclick="showNotification('info', '❤️ Wishlist', '8 items in your wishlist.')">
                            View
                        </button>
                    </div>
                </div>
            </div>

            <!-- Recent Orders - Takes remaining space -->
            <div class="recent-orders-section" style="height: 65%;">
                <h5 class="fw-bold mb-2" style="font-size: 1.1rem;"><i class="fas fa-clock me-2 text-success"></i>Recent Orders</h5>
                <div class="orders-list">
                    <div class="order-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="order-number">#ORD-2026-08-07-001</div>
                                <div class="order-date">August 7, 2026</div>
                            </div>
                            <div><span class="status-badge status-pending">Pending</span></div>
                            <div><span class="order-total">$317.11</span></div>
                            <div>
                                <button class="btn btn-sm btn-outline-warning" onclick="showNotification('warning', '⏳ Pending', 'Order #ORD-2026-08-07-001 is pending.')">
                                    <i class="fas fa-clock me-1"></i>View
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="order-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="order-number">#ORD-2026-08-05-002</div>
                                <div class="order-date">August 5, 2026</div>
                            </div>
                            <div><span class="status-badge status-delivered">Delivered</span></div>
                            <div><span class="order-total">$129.99</span></div>
                            <div>
                                <button class="btn btn-sm btn-outline-success" onclick="showNotification('success', '✅ Delivered', 'Order #ORD-2026-08-05-002 delivered!')">
                                    <i class="fas fa-check-circle me-1"></i>View
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="order-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="order-number">#ORD-2026-08-03-003</div>
                                <div class="order-date">August 3, 2026</div>
                            </div>
                            <div><span class="status-badge status-processing">Processing</span></div>
                            <div><span class="order-total">$199.00</span></div>
                            <div>
                                <button class="btn btn-sm btn-outline-info" onclick="showNotification('info', '⏳ Processing', 'Order #ORD-2026-08-03-003 is processing.')">
                                    <i class="fas fa-spinner me-1"></i>View
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Section -->
        <div id="profileSection" class="sections">
            <div class="section-content">
                <div class="bg-white rounded-3 p-4 border">
                    <h5 class="fw-bold"><i class="fas fa-user-cog me-2 text-success"></i>My Profile</h5>
                    <hr>
                    <form id="profileForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>First Name</label>
                                <input type="text" class="form-control" value="John">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Last Name</label>
                                <input type="text" class="form-control" value="Doe">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Email Address</label>
                            <input type="email" class="form-control" value="john@example.com">
                        </div>
                        <div class="mb-3">
                            <label>Phone Number</label>
                            <input type="tel" class="form-control" value="+1 234 567 890">
                        </div>
                        <button type="button" class="btn-add-product" onclick="updateProfile()">
                            <i class="fas fa-save me-2"></i>Update Profile
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Orders Section -->
        <div id="ordersSection" class="sections">
            <div class="section-content">
                <div class="bg-white rounded-3 p-4 border">
                    <h5 class="fw-bold"><i class="fas fa-shopping-bag me-2 text-success"></i>My Orders</h5>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#ORD-2026-08-07-001</td>
                                    <td>Aug 7, 2026</td>
                                    <td>$317.11</td>
                                    <td><span class="status-badge status-pending">Pending</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-warning" onclick="showNotification('warning', '⏳ Pending', 'Order is pending.')">
                                            <i class="fas fa-clock"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#ORD-2026-08-05-002</td>
                                    <td>Aug 5, 2026</td>
                                    <td>$129.99</td>
                                    <td><span class="status-badge status-delivered">Delivered</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-success" onclick="showNotification('success', '✅ Delivered', 'Order delivered successfully!')">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#ORD-2026-08-03-003</td>
                                    <td>Aug 3, 2026</td>
                                    <td>$199.00</td>
                                    <td><span class="status-badge status-processing">Processing</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info" onclick="showNotification('info', '⏳ Processing', 'Order is being processed.')">
                                            <i class="fas fa-spinner"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Addresses Section -->
        <div id="addressesSection" class="sections">
            <div class="section-content">
                <div class="bg-white rounded-3 p-4 border">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold"><i class="fas fa-address-book me-2 text-success"></i>Saved Addresses</h5>
                        <button class="btn-add-product" onclick="showNotification('success', '📍 Address', 'Add address form will open.')">
                            <i class="fas fa-plus me-2"></i>Add Address
                        </button>
                    </div>
                    <hr>
                    <div class="p-3 border rounded-3 mb-3">
                        <h6>Home Address</h6>
                        <p class="mb-1">123 Main Street, New York, NY 10001</p>
                        <p class="mb-1">Phone: +1 234 567 890</p>
                        <button class="btn btn-sm btn-outline-success" onclick="showNotification('success', '✏️ Edit', 'Edit address form.')"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-outline-danger" onclick="showNotification('error', '🗑️ Remove', 'Remove this address?')"><i class="fas fa-trash"></i></button>
                    </div>
                    <div class="p-3 border rounded-3">
                        <h6>Work Address</h6>
                        <p class="mb-1">456 Business Ave, New York, NY 10002</p>
                        <p class="mb-1">Phone: +1 987 654 321</p>
                        <button class="btn btn-sm btn-outline-success" onclick="showNotification('success', '✏️ Edit', 'Edit address form.')"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-outline-danger" onclick="showNotification('error', '🗑️ Remove', 'Remove this address?')"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Section -->
        <div id="settingsSection" class="sections">
            <div class="section-content">
                <div class="bg-white rounded-3 p-4 border">
                    <h5 class="fw-bold"><i class="fas fa-cog me-2 text-success"></i>Account Settings</h5>
                    <hr>
                    <form id="settingsForm">
                        <div class="mb-3">
                            <label>Current Password</label>
                            <input type="password" class="form-control" placeholder="Enter current password">
                        </div>
                        <div class="mb-3">
                            <label>New Password</label>
                            <input type="password" class="form-control" placeholder="Enter new password">
                        </div>
                        <div class="mb-3">
                            <label>Confirm New Password</label>
                            <input type="password" class="form-control" placeholder="Confirm new password">
                        </div>
                        <button type="button" class="btn-add-product" onclick="changePassword()">
                            <i class="fas fa-save me-2"></i>Change Password
                        </button>
                    </form>
                    <hr>
                    
                    <h6><i class="fas fa-bell me-2 text-warning"></i>Notification Preferences</h6>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="emailNotif" checked onchange="savePreference('emailNotif', this.checked)">
                        <label class="form-check-label" for="emailNotif">
                            <i class="fas fa-envelope me-1 text-primary"></i> Order Updates via Email
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="promoNotif" onchange="savePreference('promoNotif', this.checked)">
                        <label class="form-check-label" for="promoNotif">
                            <i class="fas fa-tag me-1 text-success"></i> Promotional Emails
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="smsNotif" checked onchange="savePreference('smsNotif', this.checked)">
                        <label class="form-check-label" for="smsNotif">
                            <i class="fas fa-sms me-1 text-info"></i> Order Updates via SMS
                        </label>
                    </div>
                    <button class="btn-add-product mt-3" onclick="savePreferences()">
                        <i class="fas fa-save me-2"></i>Save Preferences
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// ==========================================
// 1. FLASH MESSAGES
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    <?php if (session()->getFlashdata('success')): ?>
        showNotification('success', '✅ Success', '<?= session()->getFlashdata('success') ?>');
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        showNotification('error', '❌ Error', '<?= session()->getFlashdata('error') ?>');
    <?php endif; ?>
    <?php if (session()->getFlashdata('warning')): ?>
        showNotification('warning', '⚠️ Warning', '<?= session()->getFlashdata('warning') ?>');
    <?php endif; ?>
    <?php if (session()->getFlashdata('info')): ?>
        showNotification('info', 'ℹ️ Info', '<?= session()->getFlashdata('info') ?>');
    <?php endif; ?>
});

// ==========================================
// 2. NOTIFICATION
// ==========================================
function showNotification(type, title, message) {
    const container = document.getElementById('notificationContainer');
    if (!container) return;
    
    const icons = { success: '✅', error: '❌', warning: '⚠️', info: 'ℹ️' };
    const icon = icons[type] || 'ℹ️';
    
    const toast = document.createElement('div');
    toast.className = 'notification-toast ' + (type === 'error' ? 'error' : type === 'warning' ? 'warning' : type === 'info' ? 'info' : '');
    toast.innerHTML = `
        <div class="notif-icon">${icon}</div>
        <div class="notif-content">
            <div class="notif-title">${title}</div>
            <div class="notif-message">${message}</div>
        </div>
        <button class="notif-close" onclick="this.closest('.notification-toast').remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(toast);
    setTimeout(() => {
        if (toast.parentNode) {
            toast.classList.add('removing');
            setTimeout(() => { if (toast.parentNode) toast.remove(); }, 300);
        }
    }, 5000);
}

// ==========================================
// 3. SIDEBAR
// ==========================================
function showSection(section) {
    document.querySelectorAll('.sections').forEach(el => el.classList.remove('active'));
    const map = { 'dashboard': 'dashboardSection', 'profile': 'profileSection', 'orders': 'ordersSection', 'addresses': 'addressesSection', 'settings': 'settingsSection' };
    const el = document.getElementById(map[section]);
    if (el) el.classList.add('active');
    
    document.querySelectorAll('.sidebar-menu li').forEach(item => item.classList.remove('active'));
    const items = document.querySelectorAll('.sidebar-menu li');
    const idx = ['dashboard', 'profile', 'orders', 'addresses', 'settings'].indexOf(section);
    if (items[idx]) items[idx].classList.add('active');
}

function toggleSidebar() {
    const wrapper = document.getElementById('sidebarWrapper');
    const body = document.getElementById('mainBody');
    const txt = document.getElementById('toggleText');
    wrapper.classList.toggle('collapsed');
    body.classList.toggle('sidebar-collapsed');
    txt.textContent = wrapper.classList.contains('collapsed') ? 'Expand' : 'Collapse';
}

function updateProfile() { showNotification('success', '✅ Profile Updated', 'Profile updated successfully!'); }
function changePassword() { showNotification('success', '✅ Password Changed', 'Password changed successfully!'); }
function savePreference(id, checked) { console.log(id + ':', checked); }
function savePreferences() {
    const e = document.getElementById('emailNotif').checked;
    const p = document.getElementById('promoNotif').checked;
    const s = document.getElementById('smsNotif').checked;
    showNotification('success', '✅ Preferences Saved', 'Email: ' + (e ? '✅' : '❌') + ' | Promo: ' + (p ? '✅' : '❌') + ' | SMS: ' + (s ? '✅' : '❌'));
}
</script>

</body>
</html>