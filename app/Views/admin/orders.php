<!-- app/Views/admin/orders.php -->
<?php
// Check if user is logged in as admin
$isLoggedIn = session()->get('is_logged_in') || session()->get('user_id');
$isAdmin = session()->get('is_admin') || session()->get('role') === 'admin' || session()->get('role') === 'super_admin';

if (!$isLoggedIn || !$isAdmin) {
    header('Location: /login');
    exit();
}

$active_menu = 'orders';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Orders - ShopEase Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* ========================================== */
        /* GLOBAL STYLES */
        /* ========================================== */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            padding-left: 280px;
            padding-top: 80px;
            transition: padding-left 0.3s ease;
            min-height: 100vh;
        }

        /* ========================================== */
        /* NOTIFICATION STYLES */
        /* ========================================== */
        .notification-container {
            position: fixed;
            top: 90px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
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
        .notification-toast.error { border-left-color: #dc3545; }
        .notification-toast.warning { border-left-color: #ffc107; }
        .notification-toast.info { border-left-color: #17a2b8; }
        .notification-toast .notif-icon { font-size: 1.3rem; margin-top: 2px; }
        .notification-toast .notif-content { flex: 1; }
        .notification-toast .notif-title { font-weight: 600; color: #1a2e1a; font-size: 0.9rem; }
        .notification-toast .notif-message { color: #555; font-size: 0.85rem; }
        .notification-toast .notif-time { color: #aaa; font-size: 0.7rem; margin-top: 3px; }
        .notification-toast .notif-close { background: none; border: none; color: #aaa; cursor: pointer; font-size: 1rem; padding: 0 5px; }
        .notification-toast .notif-close:hover { color: #333; }
        .notification-toast.removing { animation: slideOutRight 0.3s ease forwards; }
        @keyframes slideInRight { from { transform: translateX(100px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes slideOutRight { from { transform: translateX(0); opacity: 1; } to { transform: translateX(100px); opacity: 0; } }

        /* ========================================== */
        /* NAVBAR - WITH LEFT OFFSET FOR SIDEBAR */
        /* ========================================== */
        .navbar {
            background: #1a2e1a !important;
            padding: 15px 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.3);
            position: fixed;
            top: 0;
            left: 280px;
            right: 0;
            z-index: 1050;
            transition: left 0.3s ease;
        }
        .navbar-brand { color: #fff !important; font-weight: bold; font-size: 1.5rem; }
        .navbar-brand i { color: #4caf50; }
        .navbar .nav-link { color: #d4d4d4 !important; font-weight: 500; transition: 0.3s; }
        .navbar .nav-link:hover { color: #4caf50 !important; }
        .icon-btn { color: #d4d4d4; font-size: 1.2rem; margin: 0 8px; background: none; border: none; text-decoration: none; }
        .icon-btn:hover { color: #4caf50; transform: scale(1.1); }

        body.sidebar-collapsed .navbar { left: 70px; }

        /* ========================================== */
        /* FIXED SIDEBAR - FULL HEIGHT */
        /* ========================================== */
        .sidebar-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100vh;
            overflow-y: auto;
            background: #fff;
            border-right: 1px solid #e8f0e8;
            padding: 20px 15px;
            z-index: 1000;
            transition: width 0.3s ease;
        }
        .sidebar-wrapper::-webkit-scrollbar { width: 4px; }
        .sidebar-wrapper::-webkit-scrollbar-thumb { background: #4caf50; border-radius: 4px; }
        .sidebar-wrapper::-webkit-scrollbar-track { background: #e8f0e8; }

        .sidebar-wrapper.collapsed { width: 70px; }
        .sidebar-wrapper.collapsed .admin-name,
        .sidebar-wrapper.collapsed .admin-role,
        .sidebar-wrapper.collapsed .sidebar-category { display: none; }
        .sidebar-wrapper.collapsed .sidebar-menu li { padding: 10px; justify-content: center; }
        .sidebar-wrapper.collapsed .sidebar-menu li .menu-text { display: none; }
        .sidebar-wrapper.collapsed .sidebar-menu li i { margin-right: 0; font-size: 1.2rem; }
        .sidebar-wrapper.collapsed .sidebar-menu li { position: relative; }
        .sidebar-wrapper.collapsed .sidebar-menu li:hover::after {
            content: attr(data-tooltip);
            position: absolute; left: 100%; top: 50%; transform: translateY(-50%);
            background: #1a2e1a; color: #fff; padding: 5px 12px; border-radius: 6px;
            font-size: 0.8rem; white-space: nowrap; z-index: 999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2); margin-left: 8px;
        }
        .sidebar-wrapper.collapsed .admin-avatar { width: 45px; height: 45px; font-size: 1.2rem; }

        body.sidebar-collapsed { padding-left: 70px; }

        .sidebar-card .admin-avatar {
            width: 70px; height: 70px; border-radius: 50%;
            background: #4caf50; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; margin: 0 auto 10px;
            transition: all 0.3s ease;
        }
        .sidebar-card .admin-name { text-align: center; font-weight: 700; color: #1a2e1a; font-size: 1rem; }
        .sidebar-card .admin-role { text-align: center; font-size: 0.8rem; }

        .toggle-sidebar-btn {
            background: #4caf50; color: #fff; border: none; border-radius: 8px;
            padding: 8px 12px; font-size: 1rem; cursor: pointer; width: 100%;
            margin-bottom: 10px; display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: 0.3s;
        }
        .toggle-sidebar-btn:hover { background: #388e3c; }

        .sidebar-category {
            font-size: 0.65rem; font-weight: 700; color: #aaa;
            text-transform: uppercase; letter-spacing: 0.5px;
            padding: 15px 10px 5px; border-top: 1px solid #f0f0f0; margin-top: 5px;
        }
        .sidebar-category:first-child { border-top: none; margin-top: 0; padding-top: 5px; }

        .sidebar-menu { list-style: none; padding: 0; margin: 0; }
        .sidebar-menu li {
            padding: 10px 12px; border-radius: 8px; cursor: pointer;
            color: #555; font-size: 0.9rem; display: flex; align-items: center;
            transition: all 0.3s ease;
        }
        .sidebar-menu li:hover { background: #f0f8f0; color: #4caf50; }
        .sidebar-menu li.active { background: #f0f8f0; color: #4caf50; font-weight: 600; }
        .sidebar-menu li i { margin-right: 12px; width: 20px; text-align: center; font-size: 1rem; }
        .sidebar-menu li .menu-text { flex: 1; }
        .sidebar-menu li a { color: inherit; text-decoration: none; display: flex; align-items: center; width: 100%; }

        /* ========================================== */
        /* PAGE HEADER */
        /* ========================================== */
        .page-header {
            background: #f8f9fa; color: #1a2e1a; padding: 20px 0;
            border-bottom: 1px solid #e8f0e8;
        }
        .page-header h2 { font-weight: 700; color: #1a2e1a; }
        .page-header .breadcrumb { background: none; padding: 0; margin: 0; }
        .page-header .breadcrumb a { color: #4caf50; text-decoration: none; }
        .page-header .breadcrumb a:hover { text-decoration: underline; }
        .page-header .breadcrumb .active { color: #888; }

        /* ========================================== */
        /* MAIN CONTENT */
        /* ========================================== */
        .main-content { padding: 20px 30px; }

        /* ========================================== */
        /* TABLE CARD */
        /* ========================================== */
        .table-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e8f0e8;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }
        .table-card .table th {
            border-top: none;
            color: #1a2e1a;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .table-card .table td {
            vertical-align: middle;
        }
        .table-card .table tr:hover {
            background-color: #f8fdf8;
        }

        /* ========================================== */
        /* STATUS BADGE */
        /* ========================================== */
        .status-badge {
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-pending i { color: #856404; }
        .status-confirmed { background: #cce5ff; color: #004085; }
        .status-confirmed i { color: #004085; }
        .status-processing { background: #d1ecf1; color: #0c5460; }
        .status-processing i { color: #0c5460; }
        .status-shipped { background: #d4edda; color: #155724; }
        .status-shipped i { color: #155724; }
        .status-delivered { background: #d4edda; color: #155724; }
        .status-delivered i { color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .status-cancelled i { color: #721c24; }
        .status-refunded { background: #e2e3e5; color: #383d41; }
        .status-refunded i { color: #383d41; }
        .status-paid { background: #d4edda; color: #155724; }
        .status-paid i { color: #155724; }
        .status-failed { background: #f8d7da; color: #721c24; }
        .status-failed i { color: #721c24; }
        .status-cod { background: #e2e3e5; color: #383d41; }
        .status-cod i { color: #383d41; }

        /* ========================================== */
        /* FILTER SECTION */
        /* ========================================== */
        .filter-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 15px;
        }
        .filter-section .order-count {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .filter-section .filter-actions {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }
        .filter-section .filter-actions .btn-filter {
            border-radius: 20px;
            padding: 5px 16px;
            font-size: 0.8rem;
            border: 1px solid #dee2e6;
            color: #6c757d;
            text-decoration: none;
            transition: 0.3s;
            background: #fff;
        }
        .filter-section .filter-actions .btn-filter:hover {
            background: #f0f8f0;
            border-color: #4caf50;
            color: #4caf50;
        }
        .filter-section .filter-actions .btn-filter.active {
            background: #4caf50;
            color: #fff;
            border-color: #4caf50;
        }
        .filter-section .filter-actions .btn-filter .badge {
            font-size: 0.65rem;
        }

        /* ========================================== */
        /* SEARCH BAR */
        /* ========================================== */
        .search-bar {
            border-radius: 30px;
            padding: 8px 18px;
            border: 2px solid #e8f0e8;
            transition: 0.3s;
            min-width: 200px;
        }
        .search-bar:focus {
            border-color: #4caf50;
            box-shadow: 0 0 0 0.2rem rgba(76,175,80,0.25);
        }

        /* ========================================== */
        /* EMPTY STATE */
        /* ========================================== */
        .empty-state {
            padding: 40px 0;
        }
        .empty-state i {
            color: #ddd;
        }

        /* ========================================== */
        /* BUTTONS */
        /* ========================================== */
        .btn-outline-success {
            border-radius: 30px;
            transition: 0.3s;
        }
        .btn-outline-success:hover {
            transform: translateY(-2px);
        }
        .btn-outline-warning {
            border-radius: 30px;
            transition: 0.3s;
        }
        .btn-outline-warning:hover {
            transform: translateY(-2px);
        }

        /* ========================================== */
        /* RESPONSIVE */
        /* ========================================== */
        @media (max-width: 992px) {
            body { padding-left: 0; }
            body.sidebar-collapsed { padding-left: 0; }
            .navbar { left: 0 !important; }
            .sidebar-wrapper {
                position: relative; top: 0; width: 100%; height: auto;
                border-right: none; border-bottom: 1px solid #e8f0e8;
            }
            .sidebar-wrapper.collapsed { width: 100%; }
            .sidebar-wrapper.collapsed .sidebar-menu li { justify-content: flex-start; }
            .sidebar-wrapper.collapsed .sidebar-menu li .menu-text { display: inline; }
            .sidebar-wrapper.collapsed .sidebar-menu li i { margin-right: 12px; }
            .sidebar-wrapper.collapsed .admin-name,
            .sidebar-wrapper.collapsed .admin-role,
            .sidebar-wrapper.collapsed .sidebar-category { display: block; }
            .main-content { padding: 15px; }
            .filter-section { flex-direction: column; align-items: stretch; }
            .filter-section .filter-actions { justify-content: center; }
            .search-bar { width: 100%; min-width: unset; }
        }

        @media (max-width: 576px) {
            .table-card .table th,
            .table-card .table td {
                font-size: 0.75rem;
                padding: 6px 4px;
            }
            .filter-section .filter-actions .btn-filter {
                font-size: 0.7rem;
                padding: 4px 10px;
            }
            .page-header h2 { font-size: 1.3rem; }
            .status-badge {
                font-size: 0.65rem;
                padding: 3px 10px;
            }
        }
    </style>
</head>
<body id="mainBody">

<!-- Notification Container -->
<div class="notification-container" id="notificationContainer"></div>

<!-- ========================================== -->
<!-- NAVBAR -->
<!-- ========================================== -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="fas fa-store"></i> ShopEase</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/dashboard">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active" href="#">Orders</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <span class="text-white me-3 d-none d-md-inline"><i class="fas fa-shield-alt me-1"></i>Super Admin</span>
                <a href="/logout" class="icon-btn" style="color:#d4d4d4;text-decoration:none;"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </div>
</nav>

<!-- ========================================== -->
<!-- FIXED SIDEBAR -->
<!-- ========================================== -->
<div class="sidebar-wrapper" id="sidebarWrapper">
    <div class="sidebar-card">
      <button class="toggle-sidebar-btn" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

        <div class="admin-avatar"><i class="fas fa-user-shield"></i></div>
        <div class="admin-name"><?= session()->get('full_name') ?? 'Super Admin' ?></div>
        <div class="admin-role"><span class="badge bg-success">Super Admin</span></div>

        <!-- MANAGEMENT -->
        <div class="sidebar-category">Management</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/admin/dashboard'" data-tooltip="Dashboard">
                <i class="fas fa-tachometer-alt"></i>
                <span class="menu-text">Dashboard</span>
            </li>
            <li onclick="location.href='/admin/stores'" data-tooltip="Stores">
                <i class="fas fa-store"></i>
                <span class="menu-text">Stores</span>
            </li>
            <li onclick="location.href='/admin/delivery-companies'" data-tooltip="Delivery Companies">
                <i class="fas fa-truck"></i>
                <span class="menu-text">Delivery Companies</span>
            </li>
            <li onclick="location.href='/admin/store-requests'" data-tooltip="Store Requests">
                <i class="fas fa-store"></i>
                <span class="menu-text">Store Requests</span>
            </li>
            <li onclick="location.href='/admin/categories'" data-tooltip="Categories">
                <i class="fas fa-tags"></i>
                <span class="menu-text">Categories</span>
            </li>
            <li onclick="location.href='/admin/users'" data-tooltip="Users">
                <i class="fas fa-users"></i>
                <span class="menu-text">Users</span>
            </li>
        </ul>

        <!-- FINANCE -->
        <div class="sidebar-category">Finance</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/admin/platform-fees'" data-tooltip="Platform Fees">
                <i class="fas fa-percentage"></i>
                <span class="menu-text">Platform Fees</span>
            </li>
            <li onclick="location.href='/admin/commissions'" data-tooltip="Commissions">
                <i class="fas fa-hand-holding-usd"></i>
                <span class="menu-text">Commissions</span>
            </li>
            <li onclick="location.href='/admin/seller-payouts'" data-tooltip="Seller Payouts">
                <i class="fas fa-money-bill-wave"></i>
                <span class="menu-text">Seller Payouts</span>
            </li>
            <li onclick="location.href='/admin/payment-gateways'" data-tooltip="Payments">
                <i class="fas fa-credit-card"></i>
                <span class="menu-text">Payments</span>
            </li>
            <li onclick="location.href='/admin/escrow-queue'" data-tooltip="Escrow Releases">
                <i class="fas fa-hand-holding-usd"></i>
                <span class="menu-text">Escrow Releases</span>
            </li>
            <li onclick="location.href='/admin/analytics'" data-tooltip="Analytics">
                <i class="fas fa-chart-bar"></i>
                <span class="menu-text">Analytics</span>
            </li>
        </ul>

        <!-- ORDERS & DELIVERY -->
        <div class="sidebar-category">Orders & Delivery</div>
        <ul class="sidebar-menu">
            <li class="active" onclick="location.href='/admin/orders'" data-tooltip="Orders">
                <i class="fas fa-shopping-bag"></i>
                <span class="menu-text">Orders</span>
            </li>
            <li onclick="location.href='/admin/delivery-assignments'" data-tooltip="Delivery Assignments">
                <i class="fas fa-tasks"></i>
                <span class="menu-text">Delivery Assignments</span>
            </li>
            <li onclick="location.href='/admin/delivery-status'" data-tooltip="Delivery Status">
                <i class="fas fa-truck"></i>
                <span class="menu-text">Delivery Status</span>
            </li>
            <li onclick="location.href='/admin/refunds'" data-tooltip="Refunds">
                <i class="fas fa-undo"></i>
                <span class="menu-text">Refunds & Disputes</span>
            </li>
            <li onclick="location.href='/admin/products'" data-tooltip="Products">
                <i class="fas fa-box"></i>
                <span class="menu-text">Products</span>
            </li>
        </ul>

        <!-- SETTINGS -->
        <div class="sidebar-category">Settings</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/admin/settings'" data-tooltip="Settings">
                <i class="fas fa-cog"></i>
                <span class="menu-text">System Settings</span>
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

<!-- ========================================== -->
<!-- PAGE HEADER -->
<!-- ========================================== -->
<section class="page-header">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2><i class="fas fa-shopping-bag me-2 text-success"></i>All Orders</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2">/</span>
                    <a href="/admin/dashboard">Dashboard</a>
                    <span class="mx-2">/</span>
                    <span class="active">Orders</span>
                </nav>
            </div>
            <div>
                <span class="text-muted"><i class="fas fa-clock me-1"></i>Last updated: <?= date('M d, Y H:i') ?></span>
            </div>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- MAIN CONTENT -->
<!-- ========================================== -->
<section class="main-content">
    <div class="container-fluid px-4">

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" id="successAlert">
                <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('warning')): ?>
            <div class="alert alert-warning alert-dismissible fade show">
                <i class="fas fa-exclamation-triangle me-2"></i><?= session()->getFlashdata('warning') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="table-card">
            <!-- Filter Section -->
            <div class="filter-section">
                <div class="order-count">
                    <i class="fas fa-shopping-bag me-1"></i>
                    <?= $totalOrders ?? count($orders ?? []) ?> orders found
                    <?php if (!empty($statusFilter)): ?>
                        <span class="text-muted">(filtered by: <strong><?= ucfirst($statusFilter) ?></strong>)</span>
                    <?php endif; ?>
                </div>
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <!-- Search -->
                    <input type="text" class="search-bar" id="searchOrder" placeholder="Search order # or customer..." onkeyup="filterTable()">
                    <!-- Filter Buttons -->
                    <div class="filter-actions">
                        <a href="/admin/orders" class="btn-filter <?= empty($statusFilter) ? 'active' : '' ?>">
                            <i class="fas fa-list me-1"></i>All
                            <span class="badge bg-secondary text-white"><?= $statusCounts['total'] ?? 0 ?></span>
                        </a>
                        <a href="/admin/orders?status=pending" class="btn-filter <?= $statusFilter === 'pending' ? 'active' : '' ?>">
                            <i class="fas fa-clock me-1"></i>Pending
                            <span class="badge bg-warning text-dark"><?= $statusCounts['pending'] ?? 0 ?></span>
                        </a>
                        <a href="/admin/orders?status=processing" class="btn-filter <?= $statusFilter === 'processing' ? 'active' : '' ?>">
                            <i class="fas fa-spinner me-1"></i>Processing
                            <span class="badge bg-info text-white"><?= $statusCounts['processing'] ?? 0 ?></span>
                        </a>
                        <a href="/admin/orders?status=shipped" class="btn-filter <?= $statusFilter === 'shipped' ? 'active' : '' ?>">
                            <i class="fas fa-truck me-1"></i>Shipped
                            <span class="badge bg-primary text-white"><?= $statusCounts['shipped'] ?? 0 ?></span>
                        </a>
                        <a href="/admin/orders?status=delivered" class="btn-filter <?= $statusFilter === 'delivered' ? 'active' : '' ?>">
                            <i class="fas fa-check-circle me-1"></i>Delivered
                            <span class="badge bg-success text-white"><?= $statusCounts['delivered'] ?? 0 ?></span>
                        </a>
                        <a href="/admin/orders?status=cancelled" class="btn-filter <?= $statusFilter === 'cancelled' ? 'active' : '' ?>">
                            <i class="fas fa-times-circle me-1"></i>Cancelled
                            <span class="badge bg-danger text-white"><?= $statusCounts['cancelled'] ?? 0 ?></span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover" id="orderTable">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag me-1"></i>Order #</th>
                            <th><i class="fas fa-user me-1"></i>Customer</th>
                            <th><i class="fas fa-store me-1"></i>Store</th>
                            <th><i class="fas fa-calendar me-1"></i>Date</th>
                            <th><i class="fas fa-dollar-sign me-1"></i>Total</th>
                            <th><i class="fas fa-credit-card me-1"></i>Payment</th>
                            <th><i class="fas fa-circle me-1"></i>Status</th>
                            <th><i class="fas fa-cog me-1"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($orders)): ?>
                            <?php foreach ($orders as $order): ?>
                                <tr data-status="<?= strtolower($order['order_status'] ?? 'pending') ?>">
                                    <td>
                                        <strong>#<?= esc($order['order_number']) ?></strong>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                                <i class="fas fa-user text-secondary"></i>
                                            </div>
                                            <div>
                                                <?= esc(trim(($order['first_name'] ?? '') . ' ' . ($order['last_name'] ?? '')) ?: 'N/A') ?>
                                                <br>
                                                <small class="text-muted"><?= esc($order['customer_email'] ?? '') ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= esc($order['store_name'] ?? 'N/A') ?></td>
                                    <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                                    <td><strong class="text-success">$<?= number_format($order['total_amount'], 2) ?></strong></td>
                                    <td>
                                        <span class="status-badge status-<?= strtolower($order['payment_status'] ?? 'pending') ?>">
                                            <i class="fas <?= strtolower($order['payment_status'] ?? 'pending') === 'paid' ? 'fa-check-circle' : 'fa-clock' ?> me-1"></i>
                                            <?= ucfirst($order['payment_status'] ?? 'Pending') ?>
                                        </span>
                                        <div class="text-muted small mt-1"><?= strtoupper($order['payment_method'] ?? '') ?></div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?= strtolower($order['order_status'] ?? 'pending') ?>">
                                            <i class="fas <?= strtolower($order['order_status'] ?? 'pending') === 'delivered' ? 'fa-check-circle' : (strtolower($order['order_status'] ?? 'pending') === 'cancelled' ? 'fa-times-circle' : 'fa-clock') ?> me-1"></i>
                                            <?= ucfirst($order['order_status'] ?? 'Pending') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="/admin/orders/view/<?= $order['id'] ?>" class="btn btn-sm btn-outline-success" title="View Order">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="/admin/orders/update-status/<?= $order['id'] ?>" class="btn btn-sm btn-outline-warning" title="Update Status" onclick="openStatusModal(<?= $order['id'] ?>, '<?= $order['order_status'] ?>')">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php if (strtolower($order['order_status'] ?? '') !== 'delivered' && strtolower($order['order_status'] ?? '') !== 'cancelled'): ?>
                                                <a href="/admin/orders/cancel/<?= $order['id'] ?>" class="btn btn-sm btn-outline-danger" title="Cancel Order" onclick="return confirm('Cancel this order? This action cannot be undone.')">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-shopping-bag fa-4x d-block mb-3 text-muted"></i>
                                        <h5 class="text-muted">No Orders Found</h5>
                                        <p class="text-muted">Orders will appear here once customers start making purchases.</p>
                                        <?php if (!empty($statusFilter)): ?>
                                            <a href="/admin/orders" class="btn btn-outline-success mt-2" style="border-radius: 30px;">
                                                <i class="fas fa-undo me-2"></i>Clear Filter
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if (isset($pager) && $pager->getPageCount() > 1): ?>
                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                    <div class="text-muted small">
                        Showing <?= $pager->getCurrentPage() ?> of <?= $pager->getPageCount() ?> pages
                    </div>
                    <?= $pager->links() ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2 text-warning"></i>Update Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="statusForm" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="order_id" id="statusOrderId">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Current Status</label>
                        <div id="currentStatusDisplay" class="p-2 bg-light rounded-3"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">New Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" id="statusSelect" required>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Notes (Optional)</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Add any notes about this status change..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-2"></i>Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- SCRIPTS -->
<!-- ========================================== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // ==========================================
    // SIDEBAR TOGGLE
    // ==========================================
    function toggleSidebar() {
        const wrapper = document.getElementById('sidebarWrapper');
        const body = document.getElementById('mainBody');
        const label = document.getElementById('toggleLabel');
        
        wrapper.classList.toggle('collapsed');
        body.classList.toggle('sidebar-collapsed');
        
        // Update toggle button text
        if (label) {
            label.textContent = wrapper.classList.contains('collapsed') ? 'Expand' : 'Collapse';
        }
        
        // Save state to localStorage
        const isCollapsed = wrapper.classList.contains('collapsed');
        localStorage.setItem('sidebarCollapsed', isCollapsed);
    }

    // ==========================================
    // RESTORE SIDEBAR STATE
    // ==========================================
    document.addEventListener('DOMContentLoaded', function() {
        const wrapper = document.getElementById('sidebarWrapper');
        const body = document.getElementById('mainBody');
        const label = document.getElementById('toggleLabel');
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        
        if (isCollapsed) {
            wrapper.classList.add('collapsed');
            body.classList.add('sidebar-collapsed');
            if (label) {
                label.textContent = 'Expand';
            }
        }

        // Auto-dismiss alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert:not(.alert-dismissible)');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            }, 5000);
        });

        // Dismiss success alert after 8 seconds
        const successAlert = document.getElementById('successAlert');
        if (successAlert) {
            setTimeout(function() {
                successAlert.style.transition = 'opacity 0.5s';
                successAlert.style.opacity = '0';
                setTimeout(function() {
                    successAlert.remove();
                }, 500);
            }, 8000);
        }
    });

    // ==========================================
    // STATUS MODAL
    // ==========================================
    let statusModal = null;

    function openStatusModal(orderId, currentStatus) {
        const modalElement = document.getElementById('statusModal');
        if (!modalElement) return;
        
        if (!statusModal) {
            statusModal = new bootstrap.Modal(modalElement);
        }
        
        document.getElementById('statusOrderId').value = orderId;
        document.getElementById('currentStatusDisplay').innerHTML = 
            `<span class="status-badge status-${currentStatus.toLowerCase()}">
                <i class="fas ${currentStatus.toLowerCase() === 'delivered' ? 'fa-check-circle' : currentStatus.toLowerCase() === 'cancelled' ? 'fa-times-circle' : 'fa-clock'} me-1"></i>
                ${currentStatus.charAt(0).toUpperCase() + currentStatus.slice(1)}
            </span>`;
        
        // Set form action
        document.getElementById('statusForm').action = `/admin/orders/update-status/${orderId}`;
        
        statusModal.show();
    }

    // ==========================================
    // FILTER TABLE (Client-side search)
    // ==========================================
    function filterTable() {
        const search = document.getElementById('searchOrder').value.toLowerCase();
        const rows = document.querySelectorAll('#orderTable tbody tr');
        
        rows.forEach(function(row) {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(search) ? '' : 'none';
        });
    }

    // ==========================================
    // NOTIFICATION SYSTEM
    // ==========================================
    function showNotification(message, type = 'info', title = '') {
        const container = document.getElementById('notificationContainer');
        if (!container) return;

        const iconMap = {
            success: 'fas fa-check-circle text-success',
            error: 'fas fa-exclamation-circle text-danger',
            warning: 'fas fa-exclamation-triangle text-warning',
            info: 'fas fa-info-circle text-info'
        };

        const icon = iconMap[type] || iconMap.info;

        const toast = document.createElement('div');
        toast.className = `notification-toast ${type}`;
        toast.innerHTML = `
            <div class="notif-icon"><i class="${icon}"></i></div>
            <div class="notif-content">
                ${title ? `<div class="notif-title">${title}</div>` : ''}
                <div class="notif-message">${message}</div>
                <div class="notif-time">${new Date().toLocaleTimeString()}</div>
            </div>
            <button class="notif-close" onclick="this.closest('.notification-toast').remove();">
                <i class="fas fa-times"></i>
            </button>
        `;

        container.appendChild(toast);

        // Auto remove after 5 seconds
        setTimeout(function() {
            if (toast.parentNode) {
                toast.classList.add('removing');
                setTimeout(function() {
                    if (toast.parentNode) {
                        toast.remove();
                    }
                }, 300);
            }
        }, 5000);
    }

    // ==========================================
    // KEYBOARD SHORTCUTS
    // ==========================================
    document.addEventListener('keydown', function(e) {
        // Ctrl + B to toggle sidebar
        if (e.ctrlKey && e.key === 'b') {
            e.preventDefault();
            toggleSidebar();
        }
        // Escape key to close notifications
        if (e.key === 'Escape') {
            const notifications = document.querySelectorAll('.notification-toast');
            notifications.forEach(function(notif) {
                notif.classList.add('removing');
                setTimeout(function() {
                    if (notif.parentNode) {
                        notif.remove();
                    }
                }, 300);
            });
        }
        // Ctrl + F to focus search
        if (e.ctrlKey && e.key === 'f') {
            e.preventDefault();
            document.getElementById('searchOrder')?.focus();
        }
    });

    console.log('ShopEase Admin - Orders Page Loaded');
    console.log('Shortcut: Ctrl+B to toggle sidebar');
    console.log('Shortcut: Ctrl+F to focus search');
    console.log('Press ESC to close all notifications');
</script>
</body>
</html>