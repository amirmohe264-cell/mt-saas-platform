<!-- app/Views/delivery_company/active_deliveries.php -->
<?php
// ✅ Check for delivery company session
$isLoggedIn = session()->get('is_logged_in') || session()->get('delivery_company_id');
$isDeliveryCompany = session()->get('role') === 'delivery_company' || session()->get('delivery_company_id');

if (!$isLoggedIn || !$isDeliveryCompany) {
    header('Location: /delivery/login');
    exit();
}

$active_menu = 'active_deliveries';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active Deliveries - ShopEase</title>
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
        /* NAVBAR */
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
        /* SIDEBAR */
        /* ========================================== */
        .sidebar {
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
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: #4caf50; border-radius: 4px; }
        .sidebar::-webkit-scrollbar-track { background: #e8f0e8; }

        .sidebar.collapsed { width: 70px; }
        .sidebar.collapsed .company-info .name,
        .sidebar.collapsed .company-info .email,
        .sidebar.collapsed .menu-category,
        .sidebar.collapsed .menu-item .menu-text { display: none; }
        .sidebar.collapsed .menu-item { padding: 10px; justify-content: center; }
        .sidebar.collapsed .menu-item i { margin-right: 0; font-size: 1.2rem; }
        .sidebar.collapsed .menu-item { position: relative; }
        .sidebar.collapsed .menu-item:hover::after {
            content: attr(data-tooltip);
            position: absolute; left: 100%; top: 50%; transform: translateY(-50%);
            background: #1a2e1a; color: #fff; padding: 5px 12px; border-radius: 6px;
            font-size: 0.8rem; white-space: nowrap; z-index: 999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2); margin-left: 8px;
        }
        .sidebar.collapsed .company-info .avatar { width: 45px; height: 45px; font-size: 1.2rem; }

        body.sidebar-collapsed { padding-left: 70px; }

        .company-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .company-info .avatar {
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
        .company-info .name {
            font-weight: 700;
            color: #1a2e1a;
            font-size: 1rem;
        }
        .company-info .email {
            font-size: 0.8rem;
            color: #888;
        }

        .toggle-sidebar-btn {
            background: #4caf50;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: 0.3s;
        }
        .toggle-sidebar-btn:hover { background: #388e3c; }

        .menu-category {
            font-size: 0.65rem;
            font-weight: 700;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 15px 10px 5px;
            border-top: 1px solid #f0f0f0;
            margin-top: 5px;
        }
        .menu-category:first-child {
            border-top: none;
            margin-top: 0;
            padding-top: 5px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 10px 12px;
            border-radius: 8px;
            color: #555;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .menu-item:hover {
            background: #f0f8f0;
            color: #4caf50;
        }
        .menu-item.active {
            background: #f0f8f0;
            color: #4caf50;
            font-weight: 600;
        }
        .menu-item i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            font-size: 1rem;
        }
        .menu-item .menu-text {
            flex: 1;
        }

        /* ========================================== */
        /* MAIN CONTENT */
        /* ========================================== */
        .main-content {
            padding: 20px 30px;
            min-height: calc(100vh - 160px);
        }

        /* ========================================== */
        /* ACTIVE ITEM */
        /* ========================================== */
        .active-item {
            background: #fff;
            border-radius: 12px;
            padding: 15px 20px;
            border-left: 4px solid #ff9800;
            margin-bottom: 12px;
            transition: 0.3s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }
        .active-item:hover {
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            transform: translateX(5px);
        }
        .active-item .order-number {
            font-weight: 600;
            color: #1a2e1a;
            font-size: 1.05rem;
        }
        .active-item .order-date {
            color: #888;
            font-size: 0.85rem;
        }
        .active-item .agent-name {
            color: #4caf50;
            font-weight: 500;
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
        /* BUTTONS */
        /* ========================================== */
        .btn-sm-custom { 
            padding: 4px 12px; 
            font-size: 0.75rem; 
            border-radius: 6px; 
            transition: 0.3s;
        }
        .btn-sm-custom:hover {
            transform: translateY(-1px);
        }

        /* ========================================== */
        /* RESPONSIVE */
        /* ========================================== */
        @media (max-width: 992px) {
            body { padding-left: 0; }
            body.sidebar-collapsed { padding-left: 0; }
            .navbar { left: 0 !important; }
            .sidebar {
                position: relative;
                top: 0;
                width: 100%;
                height: auto;
                border-right: none;
                border-bottom: 1px solid #e8f0e8;
            }
            .sidebar.collapsed { width: 100%; }
            .sidebar.collapsed .menu-item { justify-content: flex-start; }
            .sidebar.collapsed .menu-item .menu-text { display: inline; }
            .sidebar.collapsed .menu-item i { margin-right: 12px; }
            .sidebar.collapsed .company-info .name,
            .sidebar.collapsed .company-info .email,
            .sidebar.collapsed .menu-category { display: block; }
            .main-content { padding: 15px; }
            .active-item { padding: 12px 15px; }
        }

        @media (max-width: 576px) {
            .active-item .order-number { font-size: 0.95rem; }
            .active-item .order-date { font-size: 0.75rem; }
            .page-header h2 { font-size: 1.3rem; }
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
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="/delivery/dashboard">
            <i class="fas fa-truck me-2"></i>ShopEase Delivery
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <span class="text-white me-3 d-none d-md-inline">
                        <i class="fas fa-building me-1"></i>
                        <?= session()->get('delivery_company_name') ?? 'Delivery Company' ?>
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
<!-- SIDEBAR -->
<!-- ========================================== -->
<div class="sidebar" id="sidebarWrapper">
    <div class="company-info">
       <button class="toggle-sidebar-btn" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>
        <div class="avatar"><i class="fas fa-truck"></i></div>
        <div class="name"><?= session()->get('delivery_company_name') ?? 'Delivery Company' ?></div>
        <div class="email"><?= session()->get('delivery_company_email') ?? '' ?></div>
    </div>

    <div class="menu-category">Main</div>
    <a href="/delivery/dashboard" class="menu-item" data-tooltip="Dashboard">
        <i class="fas fa-tachometer-alt"></i>
        <span class="menu-text">Dashboard</span>
    </a>
    <a href="/delivery/orders" class="menu-item" data-tooltip="Delivery Orders">
        <i class="fas fa-list"></i>
        <span class="menu-text">Delivery Orders</span>
    </a>
    <a href="/delivery/assign" class="menu-item" data-tooltip="Assign Delivery">
        <i class="fas fa-user-plus"></i>
        <span class="menu-text">Assign Delivery</span>
    </a>
    <a href="/delivery/active" class="menu-item active" data-tooltip="Active Deliveries">
        <i class="fas fa-spinner"></i>
        <span class="menu-text">Active Deliveries</span>
    </a>
    <a href="/delivery/completed" class="menu-item" data-tooltip="Completed Deliveries">
        <i class="fas fa-check-circle"></i>
        <span class="menu-text">Completed Deliveries</span>
    </a>

    <div class="menu-category">Management</div>
    <a href="/delivery/agents" class="menu-item" data-tooltip="Delivery Agents">
        <i class="fas fa-users"></i>
        <span class="menu-text">Delivery Agents</span>
    </a>
    <a href="/delivery/history" class="menu-item" data-tooltip="Delivery History">
        <i class="fas fa-history"></i>
        <span class="menu-text">Delivery History</span>
    </a>

    <div class="menu-category">Account</div>
    <a href="/delivery/change-password" class="menu-item" data-tooltip="Change Password">
        <i class="fas fa-key"></i>
        <span class="menu-text">Change Password</span>
    </a>
    <a href="/delivery/logout" class="menu-item" data-tooltip="Logout" style="color:#dc3545;">
        <i class="fas fa-sign-out-alt"></i>
        <span class="menu-text">Logout</span>
    </a>
</div>

<!-- ========================================== -->
<!-- MAIN CONTENT -->
<!-- ========================================== -->
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h4 class="fw-bold mb-0"><i class="fas fa-spinner me-2 text-warning"></i>Active Deliveries</h4>
            <small class="text-muted">Deliveries currently in progress</small>
        </div>
        <div>
            <span class="text-muted"><i class="fas fa-clock me-1"></i>Last updated: <?= date('M d, Y H:i') ?></span>
        </div>
    </div>

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

    <?php if (isset($assignments) && !empty($assignments)): ?>
        <?php foreach ($assignments as $assignment): ?>
            <div class="active-item">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <div class="order-number">
                            <i class="fas fa-hashtag text-muted me-1"></i>#<?= $assignment['order_number'] ?? $assignment['order_id'] ?>
                            <span class="status-badge status-<?= str_replace('_', '', $assignment['status']) ?> ms-2">
                                <i class="fas <?= $assignment['status'] === 'pending' ? 'fa-clock' : ($assignment['status'] === 'assigned' ? 'fa-user-check' : ($assignment['status'] === 'in_transit' ? 'fa-truck' : 'fa-check-circle')) ?> me-1"></i>
                                <?= ucfirst(str_replace('_', ' ', $assignment['status'])) ?>
                            </span>
                        </div>
                        <div class="order-date mt-1">
                            <i class="far fa-calendar-alt me-1"></i>
                            <?= date('M d, Y H:i', strtotime($assignment['created_at'])) ?>
                            <?php if (isset($assignment['agent_name']) || isset($assignment['agent']['name'])): ?>
                                <span class="ms-3">
                                    <i class="fas fa-user-check me-1 text-success"></i>
                                    <span class="agent-name"><?= $assignment['agent_name'] ?? $assignment['agent']['name'] ?? 'Unassigned' ?></span>
                                </span>
                            <?php endif; ?>
                            <?php if (isset($assignment['customer_name']) || isset($assignment['customer']['full_name'])): ?>
                                <span class="ms-3">
                                    <i class="fas fa-user me-1"></i>
                                    <?= $assignment['customer_name'] ?? $assignment['customer']['full_name'] ?? $assignment['customer']['name'] ?? 'Customer' ?>
                                </span>
                            <?php endif; ?>
                            <?php if (isset($assignment['store_name'])): ?>
                                <span class="ms-3">
                                    <i class="fas fa-store me-1 text-success"></i>
                                    <?= $assignment['store_name'] ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div>
                        <a href="/delivery/orders/<?= $assignment['id'] ?>" class="btn btn-sm btn-outline-success btn-sm-custom">
                            <i class="fas fa-eye me-1"></i> View
                        </a>
                        <?php if ($assignment['status'] === 'pending' || $assignment['status'] === 'assigned'): ?>
                            <a href="/delivery/orders/start/<?= $assignment['id'] ?>" class="btn btn-sm btn-primary btn-sm-custom" onclick="return confirm('Start this delivery?')">
                                <i class="fas fa-play me-1"></i> Start
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>No active deliveries. All deliveries are completed!
        </div>
    <?php endif; ?>
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

    console.log('ShopEase Delivery - Active Deliveries Page Loaded');
    console.log('Shortcut: Ctrl+B to toggle sidebar');
    console.log('Press ESC to close all notifications');
</script>
</body>
</html>