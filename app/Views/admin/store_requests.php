<!-- app/Views/admin/store_requests.php -->
<?php
// Check if user is logged in as admin
$isLoggedIn = session()->get('is_logged_in') || session()->get('user_id');
$isAdmin = session()->get('is_admin') || session()->get('role') === 'admin' || session()->get('role') === 'super_admin';

if (!$isLoggedIn || !$isAdmin) {
    header('Location: /login');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Requests - ShopEase</title>
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
            padding-left: 180px;
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
            left: 180px;
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
        .navbar-toggler { border-color: #4caf50; }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(76, 175, 80, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* ========================================== */
        /* FIXED SIDEBAR - FULL HEIGHT */
        /* ========================================== */
        .sidebar-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 180px;
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
        body.sidebar-collapsed .navbar { left: 70px; }

        .sidebar-card .admin-avatar {
            width: 70px; height: 70px; border-radius: 50%;
            background: #4caf50; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; margin: 0 auto 10px;
            transition: all 0.3s ease;
        }
        .sidebar-card .admin-name {
            text-align: center; font-weight: 700; color: #1a2e1a; font-size: 1rem;
            transition: all 0.3s ease;
        }
        .sidebar-card .admin-role {
            text-align: center; font-size: 0.8rem;
            transition: all 0.3s ease;
        }

        .toggle-sidebar-btn {
            background: #4caf50; color: #fff; border: none; border-radius: 8px;
            padding: 8px 12px; font-size: 1rem; transition: 0.3s;
            cursor: pointer; width: 100%; margin-bottom: 10px;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .toggle-sidebar-btn:hover { background: #388e3c; }
        .toggle-sidebar-btn i { font-size: 1.1rem; }

        .sidebar-category {
            font-size: 0.65rem; font-weight: 700; color: #aaa;
            text-transform: uppercase; letter-spacing: 0.5px;
            padding: 15px 10px 5px; border-top: 1px solid #f0f0f0;
            margin-top: 5px; transition: all 0.3s ease;
        }
        .sidebar-category:first-child { border-top: none; margin-top: 0; padding-top: 5px; }

        .sidebar-menu { list-style: none; padding: 0; margin: 0; }
        .sidebar-menu li {
            padding: 10px 12px; border-radius: 8px; transition: 0.3s;
            cursor: pointer; color: #555; font-size: 0.9rem;
            display: flex; align-items: center; transition: all 0.3s ease;
        }
        .sidebar-menu li:hover { background: #f0f8f0; color: #4caf50; }
        .sidebar-menu li.active { background: #f0f8f0; color: #4caf50; font-weight: 600; }
        .sidebar-menu li i { margin-right: 12px; width: 20px; text-align: center; font-size: 1rem; transition: all 0.3s ease; }
        .sidebar-menu li .menu-text { flex: 1; transition: all 0.3s ease; }
        .sidebar-menu li a { color: inherit; text-decoration: none; display: flex; align-items: center; width: 100%; }

        /* ========================================== */
        /* PAGE HEADER */
        /* ========================================== */
        .page-header {
            background: #f8f9fa; color: #1a2e1a;
            padding: 20px 0 20px;
            border-bottom: 1px solid #e8f0e8;
        }
        .page-header h2 { font-weight: 700; color: #1a2e1a; }
        .page-header .breadcrumb { background: none; padding: 0; margin: 0; }
        .page-header .breadcrumb a { color: #4caf50; text-decoration: none; }
        .page-header .breadcrumb .active { color: #888; }
        .page-header .text-muted { color: #888 !important; }

        /* ========================================== */
        /* MAIN CONTENT */
        /* ========================================== */
        .main-content { padding: 20px 30px; min-height: calc(100vh - 160px); }

        /* ========================================== */
        /* REQUEST CARD */
        /* ========================================== */
        .request-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e8f0e8;
            margin-bottom: 15px;
            transition: 0.3s;
        }
        .request-card:hover {
            border-color: #4caf50;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        }
        .request-card .store-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1a2e1a;
        }
        .request-card .owner-info {
            color: #555;
            font-size: 0.95rem;
        }
        .request-card .request-date {
            color: #888;
            font-size: 0.85rem;
        }

        /* ========================================== */
        /* BADGES */
        /* ========================================== */
        .badge-pending {
            background: #fff3cd;
            color: #856404;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75rem;
            display: inline-block;
        }
        .badge-approved {
            background: #d4edda;
            color: #155724;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75rem;
            display: inline-block;
        }
        .badge-rejected {
            background: #f8d7da;
            color: #721c24;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75rem;
            display: inline-block;
        }

        /* ========================================== */
        /* BUTTONS */
        /* ========================================== */
        .btn-approve {
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 6px 20px;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
            font-size: 0.8rem;
        }
        .btn-approve:hover { background: #1e7e34; color: #fff; }

        .btn-reject {
            background: #dc3545;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 6px 20px;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
            font-size: 0.8rem;
        }
        .btn-reject:hover { background: #bd2130; color: #fff; }

        .btn-view {
            background: #17a2b8;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 6px 20px;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
            font-size: 0.8rem;
        }
        .btn-view:hover { background: #117a8b; color: #fff; }

        /* ========================================== */
        /* TABS */
        /* ========================================== */
        .nav-tabs .nav-link {
            color: #555;
            font-weight: 500;
        }
        .nav-tabs .nav-link.active {
            color: #4caf50;
            border-color: #4caf50 #4caf50 #fff;
        }
        .nav-tabs .nav-link:hover {
            border-color: #e8f0e8;
        }

        .action-btns .btn { margin: 2px; }

        /* ========================================== */
        /* EMPTY STATE */
        /* ========================================== */
        .empty-state {
            text-align: center;
            padding: 60px 0;
        }
        .empty-state i { font-size: 4rem; color: #ddd; margin-bottom: 20px; }
        .empty-state h5 { color: #1a2e1a; }
        .empty-state p { color: #888; }

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
        .filter-section .request-count {
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* ========================================== */
        /* RESPONSIVE */
        /* ========================================== */
        @media (max-width: 992px) {
            body { padding-left: 0; }
            .navbar { left: 0 !important; }
            body.sidebar-collapsed .navbar { left: 0 !important; }
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
            body.sidebar-collapsed { padding-left: 0; }
            .main-content { padding: 15px; }
            .request-card .row > div {
                margin-bottom: 8px;
            }
            .request-card .text-end {
                text-align: left !important;
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
                <li class="nav-item"><a class="nav-link active" href="#">Store Requests</a></li>
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
            <li class="active" onclick="location.href='/admin/store-requests'" data-tooltip="Store Requests">
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
            <li onclick="location.href='/admin/orders'" data-tooltip="Orders">
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
                <h2><i class="fas fa-store me-2 text-success"></i>Store Requests</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2">/</span>
                    <a href="/admin/dashboard">Dashboard</a>
                    <span class="mx-2">/</span>
                    <span class="active">Store Requests</span>
                </nav>
            </div>
            <div>
                <span class="text-muted">Manage store owner applications</span>
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
                <?php if (strpos(session()->getFlashdata('success'), 'Password:') !== false): ?>
                    <br>
                    <button class="btn btn-sm btn-outline-success mt-2" onclick="copyPassword()">
                        <i class="fas fa-copy me-1"></i>Copy Password
                    </button>
                <?php endif; ?>
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

        <!-- Requests Container -->
        <div class="bg-white rounded-3 p-4 border">
            <div class="filter-section">
                <div class="request-count">
                    <i class="fas fa-store me-1"></i>
                    Total Requests: <?= (isset($pendingRequests) ? count($pendingRequests) : 0) + (isset($approvedRequests) ? count($approvedRequests) : 0) + (isset($rejectedRequests) ? count($rejectedRequests) : 0) ?>
                </div>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs mb-4" id="requestTabs">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#pending">
                        <i class="fas fa-clock me-1"></i>Pending
                        <span class="badge bg-warning text-dark ms-1"><?= isset($pendingRequests) ? count($pendingRequests) : 0 ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#approved">
                        <i class="fas fa-check-circle me-1"></i>Approved
                        <span class="badge bg-success ms-1"><?= isset($approvedRequests) ? count($approvedRequests) : 0 ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#rejected">
                        <i class="fas fa-times-circle me-1"></i>Rejected
                        <span class="badge bg-danger ms-1"><?= isset($rejectedRequests) ? count($rejectedRequests) : 0 ?></span>
                    </a>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content">
                <!-- PENDING TAB -->
                <div class="tab-pane fade show active" id="pending">
                    <?php if (isset($pendingRequests) && !empty($pendingRequests)): ?>
                        <?php foreach ($pendingRequests as $request): ?>
                            <div class="request-card">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="store-name">
                                            <i class="fas fa-store text-success me-2"></i><?= esc($request['store_name']) ?>
                                        </div>
                                        <div class="owner-info">
                                            <i class="fas fa-user me-2"></i><?= esc($request['owner_name']) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="owner-info">
                                            <i class="fas fa-envelope me-2"></i><?= esc($request['owner_email']) ?>
                                        </div>
                                        <div class="owner-info">
                                            <i class="fas fa-phone me-2"></i><?= esc($request['owner_phone']) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="badge-pending"><i class="fas fa-clock me-1"></i>Pending</span>
                                        <div class="request-date mt-1">
                                            <i class="fas fa-calendar me-1"></i><?= date('M d, Y', strtotime($request['created_at'])) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-end action-btns">
                                        <a href="/admin/store-request/<?= $request['id'] ?>" class="btn-view">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>
                                        <a href="/admin/store-request/approve/<?= $request['id'] ?>" 
                                           class="btn-approve" 
                                           onclick="return confirm('Approve this store request? This will create a new store and send login credentials.')">
                                            <i class="fas fa-check me-1"></i>Approve
                                        </a>
                                        <a href="/admin/store-request/reject/<?= $request['id'] ?>" 
                                           class="btn-reject" 
                                           onclick="return confirm('Reject this store request? The owner will be notified.')">
                                            <i class="fas fa-times me-1"></i>Reject
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-check-circle text-success"></i>
                            <h5>No Pending Requests</h5>
                            <p>All store owner applications have been reviewed.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- APPROVED TAB -->
                <div class="tab-pane fade" id="approved">
                    <?php if (isset($approvedRequests) && !empty($approvedRequests)): ?>
                        <?php foreach ($approvedRequests as $request): ?>
                            <div class="request-card">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="store-name">
                                            <i class="fas fa-store text-success me-2"></i><?= esc($request['store_name']) ?>
                                        </div>
                                        <div class="owner-info">
                                            <i class="fas fa-user me-2"></i><?= esc($request['owner_name']) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="owner-info">
                                            <i class="fas fa-envelope me-2"></i><?= esc($request['owner_email']) ?>
                                        </div>
                                        <div class="owner-info">
                                            <i class="fas fa-phone me-2"></i><?= esc($request['owner_phone']) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="badge-approved"><i class="fas fa-check-circle me-1"></i>Approved</span>
                                        <div class="request-date mt-1">
                                            <i class="fas fa-calendar me-1"></i><?= date('M d, Y', strtotime($request['updated_at'] ?? $request['created_at'])) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <a href="/admin/store-request/<?= $request['id'] ?>" class="btn-view">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-store"></i>
                            <h5>No Approved Requests</h5>
                            <p>No store owner applications have been approved yet.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- REJECTED TAB -->
                <div class="tab-pane fade" id="rejected">
                    <?php if (isset($rejectedRequests) && !empty($rejectedRequests)): ?>
                        <?php foreach ($rejectedRequests as $request): ?>
                            <div class="request-card">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="store-name">
                                            <i class="fas fa-store text-danger me-2"></i><?= esc($request['store_name']) ?>
                                        </div>
                                        <div class="owner-info">
                                            <i class="fas fa-user me-2"></i><?= esc($request['owner_name']) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="owner-info">
                                            <i class="fas fa-envelope me-2"></i><?= esc($request['owner_email']) ?>
                                        </div>
                                        <div class="owner-info">
                                            <i class="fas fa-phone me-2"></i><?= esc($request['owner_phone']) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="badge-rejected"><i class="fas fa-times-circle me-1"></i>Rejected</span>
                                        <div class="request-date mt-1">
                                            <i class="fas fa-calendar me-1"></i><?= date('M d, Y', strtotime($request['updated_at'] ?? $request['created_at'])) ?>
                                        </div                                        </div>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <a href="/admin/store-request/<?= $request['id'] ?>" class="btn-view">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-times-circle"></i>
                            <h5>No Rejected Requests</h5>
                            <p>No store owner applications have been rejected.</p>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- /REJECTED TAB -->

            </div>
            <!-- /tab-content -->

        </div>
        <!-- /Requests Container -->

    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // ==========================================
    // TOGGLE SIDEBAR
    // ==========================================
    function toggleSidebar() {
        var wrapper = document.getElementById('sidebarWrapper');
        var body = document.getElementById('mainBody');
        wrapper.classList.toggle('collapsed');
        body.classList.toggle('sidebar-collapsed');
    }

    // ==========================================
    // NOTIFICATION FUNCTION
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
        }, 6000);
    }

    // ==========================================
    // COPY GENERATED PASSWORD FROM FLASH MESSAGE
    // ==========================================
    function copyPassword() {
        const alertEl = document.getElementById('successAlert');
        if (!alertEl) return;

        const text = alertEl.textContent;
        const match = text.match(/Password:\s*(\S+)/);

        if (!match) {
            showNotification('error', '❌ Error', 'Could not find a password to copy.');
            return;
        }

        navigator.clipboard.writeText(match[1]).then(() => {
            showNotification('success', '✅ Copied', 'Password copied to clipboard.');
        }).catch(() => {
            showNotification('error', '❌ Error', 'Could not copy password.');
        });
    }

    // ==========================================
    // FLASH MESSAGES
    // ==========================================
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (session()->getFlashdata('success')): ?>
            showNotification('success', '✅ Success', '<?= esc(session()->getFlashdata('success'), 'js') ?>');
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            showNotification('error', '❌ Error', '<?= esc(session()->getFlashdata('error'), 'js') ?>');
        <?php endif; ?>
        <?php if (session()->getFlashdata('warning')): ?>
            showNotification('warning', '⚠️ Warning', '<?= esc(session()->getFlashdata('warning'), 'js') ?>');
        <?php endif; ?>
    });
</script>
</body>
</html>