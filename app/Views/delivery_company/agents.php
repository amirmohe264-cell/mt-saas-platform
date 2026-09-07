<!-- app/Views/delivery_company/agents.php -->
<?php
// ✅ Check for delivery company session
$isLoggedIn = session()->get('is_logged_in') || session()->get('delivery_company_id');
$isDeliveryCompany = session()->get('role') === 'delivery_company' || session()->get('delivery_company_id');

if (!$isLoggedIn || !$isDeliveryCompany) {
    header('Location: /delivery/login');
    exit();
}

$active_menu = 'agents';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Agents - ShopEase</title>
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
        /* AGENT CARD */
        /* ========================================== */
        .agent-card {
            background: #fff;
            border-radius: 12px;
            padding: 15px 20px;
            border: 1px solid #e8f0e8;
            margin-bottom: 12px;
            transition: 0.3s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }
        .agent-card:hover {
            border-color: #4caf50;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            transform: translateX(5px);
        }
        .agent-card .agent-name {
            font-weight: 600;
            color: #1a2e1a;
            font-size: 1.05rem;
        }
        .agent-card .agent-details {
            color: #888;
            font-size: 0.85rem;
        }
        .agent-card .agent-stats {
            font-size: 0.8rem;
        }
        .agent-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #4caf50;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        .agent-avatar.inactive {
            background: #6c757d;
        }

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

        .btn-add {
            background: #4caf50;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 10px 25px;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-add:hover {
            background: #388e3c;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(76,175,80,0.3);
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
            .agent-card { padding: 12px 15px; }
            .agent-card .agent-stats .badge {
                font-size: 0.65rem;
            }
            .btn-add {
                padding: 8px 18px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .agent-card .agent-name { font-size: 0.95rem; }
            .agent-card .agent-details { font-size: 0.75rem; }
            .agent-card .agent-stats .badge { font-size: 0.6rem; }
            .page-header h2 { font-size: 1.3rem; }
            .btn-sm-custom { font-size: 0.65rem; padding: 3px 8px; }
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
    <a href="/delivery/active" class="menu-item" data-tooltip="Active Deliveries">
        <i class="fas fa-spinner"></i>
        <span class="menu-text">Active Deliveries</span>
    </a>
    <a href="/delivery/completed" class="menu-item" data-tooltip="Completed Deliveries">
        <i class="fas fa-check-circle"></i>
        <span class="menu-text">Completed Deliveries</span>
    </a>

    <div class="menu-category">Management</div>
    <a href="/delivery/agents" class="menu-item active" data-tooltip="Delivery Agents">
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
            <h4 class="fw-bold mb-0"><i class="fas fa-users me-2 text-success"></i>Delivery Agents</h4>
            <small class="text-muted">Manage your delivery team</small>
        </div>
        <div>
            <span class="text-muted me-3"><i class="fas fa-clock me-1"></i>Last updated: <?= date('M d, Y H:i') ?></span>
            <a href="/delivery/agents/add" class="btn-add">
                <i class="fas fa-plus me-2"></i>Add Agent
            </a>
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

    <?php if (session()->getFlashdata('warning')): ?>
        <div class="alert alert-warning alert-dismissible fade show">
            <i class="fas fa-exclamation-triangle me-2"></i><?= session()->getFlashdata('warning') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($agents) && !empty($agents)): ?>
        <?php foreach ($agents as $agent): ?>
            <div class="agent-card">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center">
                        <div class="agent-avatar <?= ($agent['status'] ?? 'active') !== 'active' ? 'inactive' : '' ?> me-3">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <div class="agent-name">
                                <?= esc($agent['name'] ?? $agent['full_name'] ?? 'N/A') ?>
                            </div>
                            <div class="agent-details">
                                <i class="fas fa-envelope me-1"></i><?= esc($agent['email'] ?? 'N/A') ?>
                                <span class="mx-2 d-none d-sm-inline">|</span>
                                <i class="fas fa-phone me-1 d-none d-sm-inline"></i>
                                <span class="d-none d-sm-inline"><?= esc($agent['phone'] ?? 'N/A') ?></span>
                            </div>
                            <?php if (!empty($agent['joined_at'])): ?>
                                <div class="agent-details">
                                    <i class="fas fa-calendar me-1"></i>Joined: <?= date('M d, Y', strtotime($agent['joined_at'])) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="agent-stats text-end">
                        <span class="badge bg-<?= ($agent['status'] ?? 'active') === 'active' ? 'success' : 'secondary' ?> me-1">
                            <i class="fas <?= ($agent['status'] ?? 'active') === 'active' ? 'fa-check-circle' : 'fa-times-circle' ?> me-1"></i>
                            <?= ucfirst($agent['status'] ?? 'Active') ?>
                        </span>
                        <span class="badge bg-info me-1">
                            <i class="fas fa-truck me-1"></i><?= $agent['active_assignments'] ?? 0 ?> Active
                        </span>
                        <span class="badge bg-secondary">
                            <i class="fas fa-history me-1"></i><?= $agent['total_assignments'] ?? 0 ?> Total
                        </span>
                    </div>
                    <div class="d-flex gap-1">
                        <a href="/delivery/agents/edit/<?= $agent['id'] ?>" class="btn btn-sm btn-primary btn-sm-custom" title="Edit Agent">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="/delivery/agents/toggle/<?= $agent['id'] ?>" class="btn btn-sm btn-warning btn-sm-custom" title="Toggle Status" onclick="return confirm('Toggle status for <?= esc($agent['name'] ?? 'this agent') ?>?')">
                            <i class="fas fa-sync"></i>
                        </a>
                        <a href="/delivery/agents/delete/<?= $agent['id'] ?>" class="btn btn-sm btn-danger btn-sm-custom" title="Delete Agent" onclick="return confirm('Delete <?= esc($agent['name'] ?? 'this agent') ?>? This action cannot be undone.')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center py-5">
            <div class="empty-state">
                <i class="fas fa-users fa-4x d-block mb-3 text-muted"></i>
                <h5 class="text-muted">No Delivery Agents Found</h5>
                <p class="text-muted">Add your first delivery agent to start assigning deliveries.</p>
                <a href="/delivery/agents/add" class="btn btn-success mt-2" style="border-radius: 30px; padding: 10px 30px;">
                    <i class="fas fa-plus me-2"></i>Add Your First Agent
                </a>
            </div>
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

    console.log('ShopEase Delivery - Agents Page Loaded');
    console.log('Shortcut: Ctrl+B to toggle sidebar');
    console.log('Press ESC to close all notifications');
</script>
</body>
</html>