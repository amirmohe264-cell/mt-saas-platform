<?php
// ✅ Check for delivery company session
$isLoggedIn = session()->get('is_logged_in') || session()->get('delivery_company_id');
$isDeliveryCompany = session()->get('role') === 'delivery_company' || session()->get('delivery_company_id');

if (!$isLoggedIn || !$isDeliveryCompany) {
    header('Location: /delivery/login');
    exit();
}

$active_menu = 'dashboard';
$company_name = session()->get('delivery_company_name') ?? 'Delivery Company';
?>
<!-- app/Views/delivery_company/dashboard.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Dashboard - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
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
        .navbar-brand {
            color: #fff !important;
            font-weight: bold;
            font-size: 1.5rem;
        }
        .navbar-brand i { color: #4caf50; }
        .navbar .nav-link { color: #d4d4d4 !important; font-weight: 500; transition: 0.3s; }
        .navbar .nav-link:hover { color: #4caf50 !important; }
        .icon-btn {
            color: #d4d4d4;
            font-size: 1.2rem;
            margin: 0 8px;
            transition: 0.3s;
            background: none;
            border: none;
            text-decoration: none;
        }
        .icon-btn:hover {
            color: #4caf50;
            transform: scale(1.1);
        }

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

        .sidebar-wrapper.collapsed {
            width: 70px;
        }
        .sidebar-wrapper.collapsed .company-name,
        .sidebar-wrapper.collapsed .company-email,
        .sidebar-wrapper.collapsed .sidebar-category {
            display: none;
        }
        .sidebar-wrapper.collapsed .sidebar-menu li {
            padding: 10px;
            justify-content: center;
        }
        .sidebar-wrapper.collapsed .sidebar-menu li .menu-text {
            display: none;
        }
        .sidebar-wrapper.collapsed .sidebar-menu li i {
            margin-right: 0;
            font-size: 1.2rem;
        }
        .sidebar-wrapper.collapsed .sidebar-menu li {
            position: relative;
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
        .sidebar-wrapper.collapsed .company-avatar {
            width: 45px;
            height: 45px;
            font-size: 1.2rem;
        }

        body.sidebar-collapsed {
            padding-left: 70px;
        }

        .sidebar-card .company-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: #4caf50;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 10px;
            transition: all 0.3s ease;
        }
        .sidebar-card .company-name {
            text-align: center;
            font-weight: 700;
            color: #1a2e1a;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .sidebar-card .company-email {
            text-align: center;
            font-size: 0.8rem;
            color: #888;
            transition: all 0.3s ease;
        }

        .toggle-sidebar-btn {
            background: #4caf50;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 1rem;
            transition: 0.3s;
            cursor: pointer;
            width: 100%;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .toggle-sidebar-btn:hover {
            background: #388e3c;
        }
        .toggle-sidebar-btn i {
            font-size: 1.1rem;
        }

        .sidebar-category {
            font-size: 0.65rem;
            font-weight: 700;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 15px 10px 5px;
            border-top: 1px solid #f0f0f0;
            margin-top: 5px;
            transition: all 0.3s ease;
        }
        .sidebar-category:first-child {
            border-top: none;
            margin-top: 0;
            padding-top: 5px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar-menu li {
            padding: 10px 12px;
            border-radius: 8px;
            transition: 0.3s;
            cursor: pointer;
            color: #555;
            font-size: 0.9rem;
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
            width: 20px;
            text-align: center;
            font-size: 1rem;
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
            padding: 20px 0;
            border-bottom: 1px solid #e8f0e8;
        }
        .page-header h2 {
            font-weight: 700;
            color: #1a2e1a;
        }
        .page-header .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
        }
        .page-header .breadcrumb a {
            color: #4caf50;
            text-decoration: none;
        }
        .page-header .breadcrumb a:hover {
            text-decoration: underline;
        }
        .page-header .breadcrumb .active {
            color: #888;
        }

        /* ========================================== */
        /* MAIN CONTENT */
        /* ========================================== */
        .main-content {
            padding: 20px 30px;
            min-height: calc(100vh - 160px);
        }

        /* ========================================== */
        /* DASHBOARD CARDS */
        /* ========================================== */
        .dashboard-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e8f0e8;
            transition: 0.3s;
            height: 100%;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }
        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            border-color: #4caf50;
        }
        .dashboard-card .card-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1a2e1a;
        }
        .dashboard-card .card-label {
            color: #888;
            font-size: 0.85rem;
        }
        .dashboard-card .card-icon {
            font-size: 1.8rem;
            float: right;
            opacity: 0.7;
        }

        /* ========================================== */
        /* ORDER ITEMS */
        /* ========================================== */
        .order-item {
            background: #fff;
            border-radius: 12px;
            padding: 15px 20px;
            border: 1px solid #e8f0e8;
            margin-bottom: 12px;
            transition: 0.3s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }
        .order-item:hover {
            border-color: #4caf50;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            transform: translateX(5px);
        }
        .order-item .order-number {
            font-weight: 600;
            color: #1a2e1a;
        }
        .order-item .order-date {
            color: #888;
            font-size: 0.85rem;
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
        .status-assigned { background: #cce5ff; color: #004085; }
        .status-picked_up { background: #d1ecf1; color: #0c5460; }
        .status-in_transit { background: #d4edda; color: #155724; }
        .status-delivered { background: #d4edda; color: #155724; }
        .status-completed { background: #c3e6cb; color: #155724; }
        .status-failed { background: #f8d7da; color: #721c24; }

        /* ========================================== */
        /* RESPONSIVE */
        /* ========================================== */
        @media (max-width: 992px) {
            body {
                padding-left: 0;
            }
            body.sidebar-collapsed { padding-left: 0; }
            .navbar { left: 0 !important; }
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
            .sidebar-wrapper.collapsed .company-name,
            .sidebar-wrapper.collapsed .company-email,
            .sidebar-wrapper.collapsed .sidebar-category {
                display: block;
            }
            .main-content {
                padding: 15px;
            }
            .dashboard-card .card-number {
                font-size: 1.4rem;
            }
        }

        @media (max-width: 576px) {
            .page-header h2 { font-size: 1.3rem; }
            .dashboard-card .card-number { font-size: 1.2rem; }
            .dashboard-card .card-icon { font-size: 1.3rem; }
            .order-item .order-number { font-size: 0.95rem; }
            .status-badge { font-size: 0.65rem; padding: 3px 10px; }
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
        <a class="navbar-brand" href="/delivery/dashboard">
            <i class="fas fa-truck"></i> ShopEase Delivery
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <span class="text-white me-3 d-none d-md-inline">
                        <i class="fas fa-store me-1"></i><?= $company_name ?>
                    </span>
                </li>
                <li class="nav-item">
                    <a href="/delivery/logout" class="icon-btn" style="color:#d4d4d4;text-decoration:none;">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- ========================================== -->
<!-- FIXED SIDEBAR -->
<!-- ========================================== -->
<div class="sidebar-wrapper" id="sidebarWrapper">
    <div class="sidebar-card">
        <!-- Toggle Button with Label -->
      <button class="toggle-sidebar-btn" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

        <div class="company-avatar">
            <i class="fas fa-truck"></i>
        </div>
        <div class="company-name"><?= $company_name ?></div>
        <div class="company-email"><?= session()->get('delivery_company_email') ?? '' ?></div>

        <!-- MAIN -->
        <div class="sidebar-category">Main</div>
        <ul class="sidebar-menu">
            <li class="active" onclick="location.href='/delivery/dashboard'" data-tooltip="Dashboard">
                <i class="fas fa-tachometer-alt"></i>
                <span class="menu-text">Dashboard</span>
            </li>
            <li onclick="location.href='/delivery/orders'" data-tooltip="Delivery Orders">
                <i class="fas fa-list"></i>
                <span class="menu-text">Delivery Orders</span>
            </li>
            <li onclick="location.href='/delivery/assign'" data-tooltip="Assign Delivery">
                <i class="fas fa-user-plus"></i>
                <span class="menu-text">Assign Delivery</span>
            </li>
            <li onclick="location.href='/delivery/active'" data-tooltip="Active Deliveries">
                <i class="fas fa-spinner"></i>
                <span class="menu-text">Active Deliveries</span>
            </li>
            <li onclick="location.href='/delivery/completed'" data-tooltip="Completed Deliveries">
                <i class="fas fa-check-circle"></i>
                <span class="menu-text">Completed Deliveries</span>
            </li>
        </ul>

        <!-- MANAGEMENT -->
        <div class="sidebar-category">Management</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/delivery/agents'" data-tooltip="Delivery Agents">
                <i class="fas fa-users"></i>
                <span class="menu-text">Delivery Agents</span>
            </li>
            <li onclick="location.href='/delivery/history'" data-tooltip="Delivery History">
                <i class="fas fa-history"></i>
                <span class="menu-text">Delivery History</span>
            </li>
        </ul>

        <!-- ACCOUNT -->
        <div class="sidebar-category">Account</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/delivery/change-password'" data-tooltip="Change Password">
                <i class="fas fa-key"></i>
                <span class="menu-text">Change Password</span>
            </li>
            <li>
                <a href="/delivery/logout" data-tooltip="Logout">
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
                <h2><i class="fas fa-tachometer-alt me-2 text-success"></i>Dashboard</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2">/</span>
                    <span class="active">Delivery Dashboard</span>
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

        <!-- Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-6">
                <div class="dashboard-card">
                    <i class="fas fa-truck card-icon text-success"></i>
                    <div class="card-number"><?= $total_orders ?? 0 ?></div>
                    <div class="card-label">Total Orders</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="dashboard-card">
                    <i class="fas fa-spinner card-icon text-primary"></i>
                    <div class="card-number"><?= $active_deliveries ?? 0 ?></div>
                    <div class="card-label">Active Deliveries</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="dashboard-card">
                    <i class="fas fa-check-circle card-icon text-success"></i>
                    <div class="card-number"><?= $completed_deliveries ?? 0 ?></div>
                    <div class="card-label">Completed</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="dashboard-card">
                    <i class="fas fa-clock card-icon text-warning"></i>
                    <div class="card-number"><?= $pending_orders ?? 0 ?></div>
                    <div class="card-label">Pending</div>
                </div>
            </div>
        </div>

        <!-- Additional Stats -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="dashboard-card">
                    <i class="fas fa-users card-icon text-info"></i>
                    <div class="card-number"><?= $total_agents ?? 0 ?></div>
                    <div class="card-label">Active Agents</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="dashboard-card">
                    <i class="fas fa-percentage card-icon text-warning"></i>
                    <div class="card-number">
                        <?php 
                            $completionRate = 0;
                            if (isset($completed_deliveries) && isset($total_orders) && $total_orders > 0) {
                                $completionRate = round(($completed_deliveries / $total_orders) * 100);
                            }
                            echo $completionRate . '%';
                        ?>
                    </div>
                    <div class="card-label">Completion Rate</div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0"><i class="fas fa-clock me-2 text-success"></i>Recent Assignments</h5>
            <a href="/delivery/orders" class="btn btn-sm btn-outline-success" style="border-radius: 30px;">
                View All <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>

        <?php if (isset($recent_assignments) && !empty($recent_assignments)): ?>
            <?php foreach ($recent_assignments as $assignment): ?>
                <div class="order-item">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <div class="order-number">
                                <i class="fas fa-hashtag text-muted me-1"></i>#<?= $assignment['order_number'] ?? $assignment['order_id'] ?>
                                <small class="text-muted ms-2">
                                    <i class="fas fa-store me-1"></i><?= $assignment['store_name'] ?? 'Store' ?>
                                </small>
                            </div>
                            <div class="order-date mt-1">
                                <i class="far fa-calendar-alt me-1"></i>
                                <?= date('M d, Y H:i', strtotime($assignment['created_at'])) ?>
                                <?php if (isset($assignment['agent_name'])): ?>
                                    <span class="ms-3">
                                        <i class="fas fa-user-check me-1 text-success"></i>
                                        <?= $assignment['agent_name'] ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="status-badge status-<?= str_replace('_', '', $assignment['status']) ?>">
                                <i class="fas <?= $assignment['status'] === 'pending' ? 'fa-clock' : ($assignment['status'] === 'assigned' ? 'fa-user-check' : ($assignment['status'] === 'in_transit' ? 'fa-truck' : 'fa-check-circle')) ?> me-1"></i>
                                <?= ucfirst(str_replace('_', ' ', $assignment['status'])) ?>
                            </span>
                            <a href="/delivery/orders/<?= $assignment['id'] ?>" class="btn btn-sm btn-outline-success" style="border-radius: 30px;">
                                <i class="fas fa-eye me-1"></i> View
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>No deliveries assigned yet. Start by <a href="/delivery/assign" class="alert-link">assigning a delivery</a>.
            </div>
        <?php endif; ?>
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
        localStorage.setItem('deliverySidebarCollapsed', isCollapsed);
    }

    // ==========================================
    // RESTORE SIDEBAR STATE
    // ==========================================
    document.addEventListener('DOMContentLoaded', function() {
        const wrapper = document.getElementById('sidebarWrapper');
        const body = document.getElementById('mainBody');
        const label = document.getElementById('toggleLabel');
        const isCollapsed = localStorage.getItem('deliverySidebarCollapsed') === 'true';
        
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
    });

    console.log('ShopEase Delivery - Dashboard Page Loaded');
    console.log('Shortcut: Ctrl+B to toggle sidebar');
    console.log('Press ESC to close all notifications');
</script>

</body>
</html>