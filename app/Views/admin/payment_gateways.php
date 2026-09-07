<!-- app/Views/admin/payments.php -->
<?php
// ✅ Check for admin session
$isLoggedIn = session()->get('is_logged_in') || session()->get('user_id');
$isAdmin = session()->get('is_admin') || session()->get('role') === 'admin' || session()->get('role') === 'super_admin';

if (!$isLoggedIn || !$isAdmin) {
    header('Location: /login');
    exit();
}

$active_menu = 'payment_gateways';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Gateways - ShopEase Admin</title>
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
        /* GATEWAY CARD */
        /* ========================================== */
        .gateway-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px 25px;
            border: 1px solid #e8f0e8;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: 0.3s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }
        .gateway-card:hover {
            border-color: #4caf50;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            transform: translateX(5px);
        }
        .gateway-card .gateway-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .gateway-card .gateway-icon {
            font-size: 1.8rem;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f0f8f0;
            border-radius: 12px;
            color: #4caf50;
        }
        .gateway-card .gateway-icon.paypal-icon {
            background: #e8f0fe;
            color: #1a73e8;
        }
        .gateway-card .gateway-icon.telebirr-icon {
            background: #fff3e0;
            color: #e65100;
        }
        .gateway-card .gateway-icon.cod-icon {
            background: #e8f5e9;
            color: #2e7d32;
        }
        .gateway-card h6 { 
            margin-bottom: 4px; 
            font-weight: 700; 
            color: #1a2e1a; 
            font-size: 1rem;
        }
        .gateway-card .gateway-desc {
            color: #888;
            font-size: 0.85rem;
            margin-bottom: 0;
        }
        .gateway-card .gateway-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* ========================================== */
        /* TOGGLE SWITCH */
        /* ========================================== */
        .form-check-input {
            width: 3.2em;
            height: 1.6em;
            cursor: pointer;
            transition: 0.3s;
        }
        .form-check-input:checked {
            background-color: #4caf50;
            border-color: #4caf50;
        }
        .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(76,175,80,0.25);
        }

        /* ========================================== */
        /* STATUS BADGE */
        /* ========================================== */
        .gateway-status {
            font-size: 0.75rem;
            padding: 4px 14px;
            border-radius: 20px;
            font-weight: 600;
            display: inline-block;
        }
        .status-enabled { background: #d4edda; color: #155724; }
        .status-enabled i { color: #155724; }
        .status-disabled { background: #f8d7da; color: #721c24; }
        .status-disabled i { color: #721c24; }

        /* ========================================== */
        /* BUTTONS */
        /* ========================================== */
        .btn-save {
            background: #4caf50;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 12px 40px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-save:hover {
            background: #388e3c;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(76,175,80,0.3);
        }
        .btn-reset {
            background: #6c757d;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 12px 30px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-reset:hover {
            background: #5a6268;
            color: #fff;
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
            .gateway-card {
                flex-wrap: wrap;
                gap: 10px;
                padding: 15px;
            }
            .gateway-card .gateway-left {
                width: 100%;
            }
            .gateway-card .gateway-right {
                width: 100%;
                justify-content: space-between;
            }
            .btn-save, .btn-reset {
                width: 100%;
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .page-header h2 { font-size: 1.3rem; }
            .gateway-card .gateway-icon {
                width: 40px;
                height: 40px;
                font-size: 1.3rem;
            }
            .gateway-card h6 { font-size: 0.9rem; }
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
                <li class="nav-item"><a class="nav-link active" href="#">Payments</a></li>
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
            <li class="active" onclick="location.href='/admin/payment-gateways'" data-tooltip="Payments">
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
                <h2><i class="fas fa-credit-card me-2 text-success"></i>Payment Gateways</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2">/</span>
                    <a href="/admin/dashboard">Dashboard</a>
                    <span class="mx-2">/</span>
                    <span class="active">Payments</span>
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

        <div class="bg-white rounded-3 p-3 p-md-4 mb-4 border">
            <p class="text-muted mb-0">
                <i class="fas fa-info-circle me-2 text-info"></i>
                Turn a payment method on or off to show/hide it on the checkout page platform-wide.
                <span class="d-none d-md-inline">Changes take effect immediately.</span>
            </p>
        </div>

        <form action="/admin/payment-gateways/update" method="post" id="gatewayForm">
            <?= csrf_field() ?>

            <!-- Chapa -->
            <div class="gateway-card">
                <div class="gateway-left">
                    <div class="gateway-icon"><i class="fas fa-university"></i></div>
                    <div>
                        <h6>Chapa</h6>
                        <p class="gateway-desc">Card payments, bank transfer</p>
                    </div>
                </div>
                <div class="gateway-right">
                    <span class="gateway-status <?= isset($gateways['chapa_enabled']) && $gateways['chapa_enabled'] ? 'status-enabled' : 'status-disabled' ?>">
                        <i class="fas <?= isset($gateways['chapa_enabled']) && $gateways['chapa_enabled'] ? 'fa-check-circle' : 'fa-times-circle' ?> me-1"></i>
                        <?= isset($gateways['chapa_enabled']) && $gateways['chapa_enabled'] ? 'Enabled' : 'Disabled' ?>
                    </span>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="chapa_enabled" 
                               <?= isset($gateways['chapa_enabled']) && $gateways['chapa_enabled'] ? 'checked' : '' ?>
                               data-gateway="chapa">
                    </div>
                </div>
            </div>

            <!-- Telebirr -->
            <div class="gateway-card">
                <div class="gateway-left">
                    <div class="gateway-icon telebirr-icon"><i class="fas fa-mobile-alt"></i></div>
                    <div>
                        <h6>Telebirr</h6>
                        <p class="gateway-desc">Mobile money</p>
                    </div>
                </div>
                <div class="gateway-right">
                    <span class="gateway-status <?= isset($gateways['telebirr_enabled']) && $gateways['telebirr_enabled'] ? 'status-enabled' : 'status-disabled' ?>">
                        <i class="fas <?= isset($gateways['telebirr_enabled']) && $gateways['telebirr_enabled'] ? 'fa-check-circle' : 'fa-times-circle' ?> me-1"></i>
                        <?= isset($gateways['telebirr_enabled']) && $gateways['telebirr_enabled'] ? 'Enabled' : 'Disabled' ?>
                    </span>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="telebirr_enabled" 
                               <?= isset($gateways['telebirr_enabled']) && $gateways['telebirr_enabled'] ? 'checked' : '' ?>
                               data-gateway="telebirr">
                    </div>
                </div>
            </div>

            <!-- Cash on Delivery -->
            <div class="gateway-card">
                <div class="gateway-left">
                    <div class="gateway-icon cod-icon"><i class="fas fa-money-bill-wave"></i></div>
                    <div>
                        <h6>Cash on Delivery</h6>
                        <p class="gateway-desc">Pay when the order arrives</p>
                    </div>
                </div>
                <div class="gateway-right">
                    <span class="gateway-status <?= isset($gateways['cod_enabled']) && $gateways['cod_enabled'] ? 'status-enabled' : 'status-disabled' ?>">
                        <i class="fas <?= isset($gateways['cod_enabled']) && $gateways['cod_enabled'] ? 'fa-check-circle' : 'fa-times-circle' ?> me-1"></i>
                        <?= isset($gateways['cod_enabled']) && $gateways['cod_enabled'] ? 'Enabled' : 'Disabled' ?>
                    </span>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="cod_enabled" 
                               <?= isset($gateways['cod_enabled']) && $gateways['cod_enabled'] ? 'checked' : '' ?>
                               data-gateway="cod">
                    </div>
                </div>
            </div>

            <!-- PayPal -->
            <div class="gateway-card">
                <div class="gateway-left">
                    <div class="gateway-icon paypal-icon"><i class="fab fa-paypal"></i></div>
                    <div>
                        <h6>PayPal</h6>
                        <p class="gateway-desc">International payments</p>
                    </div>
                </div>
                <div class="gateway-right">
                    <span class="gateway-status <?= isset($gateways['paypal_enabled']) && $gateways['paypal_enabled'] ? 'status-enabled' : 'status-disabled' ?>">
                        <i class="fas <?= isset($gateways['paypal_enabled']) && $gateways['paypal_enabled'] ? 'fa-check-circle' : 'fa-times-circle' ?> me-1"></i>
                        <?= isset($gateways['paypal_enabled']) && $gateways['paypal_enabled'] ? 'Enabled' : 'Disabled' ?>
                    </span>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="paypal_enabled" 
                               <?= isset($gateways['paypal_enabled']) && $gateways['paypal_enabled'] ? 'checked' : '' ?>
                               data-gateway="paypal">
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex flex-wrap gap-2">
                <button type="submit" class="btn-save">
                    <i class="fas fa-save me-2"></i>Save Changes
                </button>
                <button type="reset" class="btn-reset">
                    <i class="fas fa-undo me-2"></i>Reset
                </button>
                <a href="/admin/dashboard" class="btn btn-outline-secondary" style="border-radius: 30px; padding: 12px 30px;">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </form>
    </div>
</section>

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

        // Real-time status update when toggling switches
        const switches = document.querySelectorAll('.form-check-input');
        switches.forEach(function(switchEl) {
            switchEl.addEventListener('change', function() {
                const card = this.closest('.gateway-card');
                const statusSpan = card.querySelector('.gateway-status');
                const gateway = this.getAttribute('data-gateway');
                
                if (this.checked) {
                    statusSpan.innerHTML = '<i class="fas fa-check-circle me-1"></i>Enabled';
                    statusSpan.className = 'gateway-status status-enabled';
                } else {
                    statusSpan.innerHTML = '<i class="fas fa-times-circle me-1"></i>Disabled';
                    statusSpan.className = 'gateway-status status-disabled';
                }
                
                // Show notification for the change
                const gatewayName = gateway.charAt(0).toUpperCase() + gateway.slice(1);
                showNotification(
                    gatewayName + ' has been ' + (this.checked ? 'enabled' : 'disabled'),
                    'info',
                    'Gateway Updated'
                );
            });
        });

        // Form validation
        const form = document.getElementById('gatewayForm');
        if (form) {
            // At least one gateway should be enabled
            form.addEventListener('submit', function(e) {
                const switches = document.querySelectorAll('.form-check-input');
                let anyChecked = false;
                switches.forEach(function(s) {
                    if (s.checked) anyChecked = true;
                });
                
                if (!anyChecked) {
                    e.preventDefault();
                    showNotification(
                        'At least one payment gateway must be enabled for checkout to work.',
                        'warning',
                        'Validation Error'
                    );
                }
            });
        }
    });

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
        // Ctrl + S to save form
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            const form = document.getElementById('gatewayForm');
            if (form) {
                form.submit();
            }
        }
    });

    console.log('ShopEase Admin - Payment Gateways Page Loaded');
    console.log('Shortcut: Ctrl+B to toggle sidebar');
    console.log('Shortcut: Ctrl+S to save changes');
    console.log('Press ESC to close all notifications');
</script>
</body>
</html>