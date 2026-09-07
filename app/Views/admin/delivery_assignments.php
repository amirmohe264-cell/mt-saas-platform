<!-- app/Views/admin/delivery_assignments.php -->
<?php
// ✅ Check for admin session
$isLoggedIn = session()->get('is_logged_in') || session()->get('user_id');
$isAdmin = session()->get('is_admin') || session()->get('role') === 'admin' || session()->get('role') === 'super_admin';

if (!$isLoggedIn || !$isAdmin) {
    header('Location: /login');
    exit();
}

$active_menu = 'delivery_assignments';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Assignments - ShopEase Admin</title>
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
            background: #f8f9fa;
            color: #1a2e1a;
            padding: 20px 0;
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
        .main-content {
            padding: 20px 30px;
            min-height: calc(100vh - 160px);
        }

        /* ========================================== */
        /* ASSIGNMENT ITEM */
        /* ========================================== */
        .assignment-item {
            background: #fff;
            border-radius: 12px;
            padding: 15px 20px;
            border: 1px solid #e8f0e8;
            margin-bottom: 12px;
            transition: 0.3s;
        }
        .assignment-item:hover {
            border-color: #4caf50;
        }

        /* ========================================== */
        /* STATUS BADGE */
        /* ========================================== */
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-assigned { background: #cce5ff; color: #004085; }
        .status-picked_up { background: #d1ecf1; color: #0c5460; }
        .status-in_transit { background: #d4edda; color: #155724; }
        .status-delivered { background: #d4edda; color: #155724; }
        .status-completed { background: #c3e6cb; color: #155724; }
        .status-failed { background: #f8d7da; color: #721c24; }

        /* ========================================== */
        /* VERIFICATION CODE */
        /* ========================================== */
        .verification-code {
            background: #f0f8f0;
            padding: 4px 10px;
            border-radius: 6px;
            font-family: monospace;
            font-size: 0.85rem;
            font-weight: 600;
            color: #4caf50;
            display: inline-block;
        }

        /* ========================================== */
        /* BUTTONS */
        /* ========================================== */
        .btn-sm-custom { padding: 4px 10px; font-size: 0.8rem; border-radius: 6px; }

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
            .assignment-item { padding: 12px 15px; }
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
                <li class="nav-item"><a class="nav-link active" href="#">Delivery Assignments</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <span class="text-white me-3 d-none d-md-inline"><i class="fas fa-shield-alt me-1"></i>Super Admin</span>
                <a href="/logout" class="icon-btn" style="color:#d4d4d4;text-decoration:none;"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </div>
</nav>

<!-- ========================================== -->
<!-- FIXED SIDEBAR - MATCHES ORDERS.PHP -->
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
            <li onclick="location.href='/admin/orders'" data-tooltip="Orders">
                <i class="fas fa-shopping-bag"></i>
                <span class="menu-text">Orders</span>
            </li>
            <li class="active" onclick="location.href='/admin/delivery-assignments'" data-tooltip="Delivery Assignments">
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
                <h2><i class="fas fa-tasks me-2 text-success"></i>Delivery Assignments</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a><span class="mx-2">/</span>
                    <a href="/admin/dashboard">Dashboard</a><span class="mx-2">/</span>
                    <span class="active">Delivery Assignments</span>
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

        <?php if (isset($assignments) && !empty($assignments)): ?>
            <?php foreach ($assignments as $assignment): ?>
                <div class="assignment-item">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <div><strong>Order:</strong> #<?= $assignment['order_number'] ?? $assignment['order_id'] ?></div>
                            <div><strong>Store:</strong> <?= $assignment['store_name'] ?? 'Unknown' ?></div>
                        </div>
                        <div class="col-md-2">
                            <div><strong>Company:</strong> <?= $assignment['company_name'] ?? 'Unassigned' ?></div>
                            <div><strong>Agent:</strong> <?= $assignment['agent_id'] ? 'ID: ' . $assignment['agent_id'] : 'Not assigned' ?></div>
                        </div>
                        <div class="col-md-2">
                            <div><strong>Pickup Code:</strong></div>
                            <span class="verification-code"><?= $assignment['pickup_verification_code'] ?? 'N/A' ?></span>
                        </div>
                        <div class="col-md-2">
                            <div><strong>Delivery Code:</strong></div>
                            <span class="verification-code"><?= $assignment['delivery_verification_code'] ?? 'N/A' ?></span>
                        </div>
                        <div class="col-md-2">
                            <span class="status-badge status-<?= str_replace('_', '', $assignment['status']) ?>">
                                <?= ucfirst(str_replace('_', ' ', $assignment['status'])) ?>
                            </span>
                            <div><small class="text-muted"><?= date('M d, Y H:i', strtotime($assignment['created_at'])) ?></small></div>
                        </div>
                        <div class="col-md-1">
                            <a href="/delivery/orders/<?= $assignment['id'] ?>" target="_blank" class="btn btn-sm btn-outline-success btn-sm-custom">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>No delivery assignments found.
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

    console.log('ShopEase Admin - Delivery Assignments Page Loaded');
    console.log('Shortcut: Ctrl+B to toggle sidebar');
    console.log('Press ESC to close all notifications');
</script>
</body>
</html>