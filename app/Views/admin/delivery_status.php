<!-- app/Views/admin/delivery_status.php -->
<?php $active_menu = 'delivery_status'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Status - ShopEase Admin</title>
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
        /* NAVBAR */
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
        .icon-btn {
            color: #d4d4d4;
            font-size: 1.2rem;
            margin: 0 8px;
            transition: 0.3s;
            background: none;
            border: none;
            text-decoration: none;
        }
        .icon-btn:hover { color: #4caf50; transform: scale(1.1); }
        body.sidebar-collapsed .navbar { left: 70px; }

        /* ========================================== */
        /* SIDEBAR */
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
            padding: 20px 0 20px;
            border-bottom: 1px solid #e8f0e8;
        }
        .page-header h2 { font-weight: 700; color: #1a2e1a; }
        .page-header .breadcrumb { background: none; padding: 0; margin: 0; }
        .page-header .breadcrumb a { color: #4caf50; text-decoration: none; }
        .page-header .breadcrumb .active { color: #888; }

        /* ========================================== */
        /* MAIN CONTENT */
        /* ========================================== */
        .main-content {
            padding: 20px 30px;
            min-height: calc(100vh - 160px);
        }

        /* ========================================== */
        /* TABLE CARD */
        /* ========================================== */
        .table-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e8f0e8;
        }

        /* ========================================== */
        /* STATUS CARD */
        /* ========================================== */
        .status-card {
            background: #fff;
            border-radius: 12px;
            padding: 15px;
            border: 1px solid #e8f0e8;
            text-align: center;
        }
        .status-card .number {
            font-size: 1.8rem;
            font-weight: 700;
        }
        .status-card .label {
            color: #888;
            font-size: 0.85rem;
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
        /* ORDER ITEM */
        /* ========================================== */
        .order-item {
            background: #fff;
            border-radius: 12px;
            padding: 15px 20px;
            border: 1px solid #e8f0e8;
            margin-bottom: 12px;
        }

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
            body.sidebar-collapsed { padding-left: 0; }
            .main-content { padding: 15px; }
            .status-card { padding: 10px; }
            .order-item { padding: 12px 15px; }
            .table-card { padding: 15px; }
        }
    </style>
</head>
<body id="mainBody">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="fas fa-store"></i> ShopEase</a>
        <div class="d-flex align-items-center ms-auto">
            <span class="text-white me-3 d-none d-md-inline"><i class="fas fa-shield-alt me-1"></i>Super Admin</span>
            <a href="/logout" class="icon-btn"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidebar-wrapper" id="sidebarWrapper">
    <div class="sidebar-card">
      <button class="toggle-sidebar-btn" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>
        <div class="admin-avatar"><i class="fas fa-user-shield"></i></div>
        <div class="admin-name"><?= session()->get('full_name') ?? 'Super Admin' ?></div>
        <div class="admin-role"><span class="badge bg-success">Super Admin</span></div>

        <div class="sidebar-category">Management</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/admin/dashboard'" data-tooltip="Dashboard">
                <i class="fas fa-tachometer-alt"></i><span class="menu-text">Dashboard</span>
            </li>
            <li onclick="location.href='/admin/stores'" data-tooltip="Stores">
                <i class="fas fa-store"></i><span class="menu-text">Stores</span>
            </li>
            <li onclick="location.href='/admin/delivery-companies'" data-tooltip="Delivery Companies">
                <i class="fas fa-truck"></i><span class="menu-text">Delivery Companies</span>
            </li>
            <li onclick="location.href='/admin/store-requests'" data-tooltip="Store Requests">
                <i class="fas fa-store"></i><span class="menu-text">Store Requests</span>
            </li>
            <li onclick="location.href='/admin/categories'" data-tooltip="Categories">
                <i class="fas fa-tags"></i><span class="menu-text">Categories</span>
            </li>
            <li onclick="location.href='/admin/users'" data-tooltip="Users">
                <i class="fas fa-users"></i><span class="menu-text">Users</span>
            </li>
        </ul>

        <div class="sidebar-category">Finance</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/admin/platform-fees'" data-tooltip="Platform Fees">
                <i class="fas fa-percentage"></i><span class="menu-text">Platform Fees</span>
            </li>
            <li onclick="location.href='/admin/commissions'" data-tooltip="Commissions">
                <i class="fas fa-hand-holding-usd"></i><span class="menu-text">Commissions</span>
            </li>
            <li onclick="location.href='/admin/seller-payouts'" data-tooltip="Seller Payouts">
                <i class="fas fa-money-bill-wave"></i><span class="menu-text">Seller Payouts</span>
            </li>
            <li onclick="location.href='/admin/payment-gateways'" data-tooltip="Payments">
                <i class="fas fa-credit-card"></i><span class="menu-text">Payments</span>
            </li>
            <li onclick="location.href='/admin/escrow-queue'" data-tooltip="Escrow">
                <i class="fas fa-hand-holding-usd"></i><span class="menu-text">Escrow Releases</span>
            </li>
            <li onclick="location.href='/admin/analytics'" data-tooltip="Analytics">
                <i class="fas fa-chart-bar"></i><span class="menu-text">Analytics</span>
            </li>
        </ul>

        <div class="sidebar-category">Orders & Delivery</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/admin/orders'" data-tooltip="Orders">
                <i class="fas fa-shopping-bag"></i><span class="menu-text">Orders</span>
            </li>
            <li onclick="location.href='/admin/delivery-assignments'" data-tooltip="Delivery Assignments">
                <i class="fas fa-tasks"></i><span class="menu-text">Delivery Assignments</span>
            </li>
            <li class="active" onclick="location.href='/admin/delivery-status'" data-tooltip="Delivery Status">
                <i class="fas fa-truck"></i><span class="menu-text">Delivery Status</span>
            </li>
            <li onclick="location.href='/admin/refunds'" data-tooltip="Refunds">
                <i class="fas fa-undo"></i><span class="menu-text">Refunds & Disputes</span>
            </li>
            <li onclick="location.href='/admin/products'" data-tooltip="Products">
                <i class="fas fa-box"></i><span class="menu-text">Products</span>
            </li>
        </ul>

        <div class="sidebar-category">Settings</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/admin/settings'" data-tooltip="Settings">
                <i class="fas fa-cog"></i><span class="menu-text">System Settings</span>
            </li>
            <li><a href="/logout" data-tooltip="Logout"><i class="fas fa-sign-out-alt text-danger"></i><span class="menu-text">Logout</span></a></li>
        </ul>
    </div>
</div>

<!-- Page Header -->
<section class="page-header">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-truck me-2 text-success"></i>Delivery Status</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a><span class="mx-2">/</span>
                    <a href="/admin/dashboard">Dashboard</a><span class="mx-2">/</span>
                    <span class="active">Delivery Status</span>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="main-content">
    <div class="container-fluid px-4">

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
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

        <!-- Status Overview -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="status-card">
                    <div class="number text-warning"><?= $statusCounts['pending'] ?? 0 ?></div>
                    <div class="label">Pending</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="status-card">
                    <div class="number text-info"><?= $statusCounts['assigned'] ?? 0 ?></div>
                    <div class="label">Assigned</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="status-card">
                    <div class="number text-primary"><?= ($statusCounts['picked_up'] ?? 0) + ($statusCounts['in_transit'] ?? 0) ?></div>
                    <div class="label">In Progress</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="status-card">
                    <div class="number text-success"><?= ($statusCounts['delivered'] ?? 0) + ($statusCounts['completed'] ?? 0) ?></div>
                    <div class="label">Delivered</div>
                </div>
            </div>
        </div>

        <!-- Status Breakdown -->
        <div class="row g-3 mb-4">
            <div class="col-md-2">
                <div class="status-card">
                    <div class="number text-warning"><?= $statusCounts['pending'] ?? 0 ?></div>
                    <div class="label"><span class="status-badge status-pending">Pending</span></div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="status-card">
                    <div class="number text-info"><?= $statusCounts['assigned'] ?? 0 ?></div>
                    <div class="label"><span class="status-badge status-assigned">Assigned</span></div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="status-card">
                    <div class="number text-primary"><?= $statusCounts['picked_up'] ?? 0 ?></div>
                    <div class="label"><span class="status-badge status-picked_up">Picked Up</span></div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="status-card">
                    <div class="number text-primary"><?= $statusCounts['in_transit'] ?? 0 ?></div>
                    <div class="label"><span class="status-badge status-in_transit">In Transit</span></div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="status-card">
                    <div class="number text-success"><?= $statusCounts['delivered'] ?? 0 ?></div>
                    <div class="label"><span class="status-badge status-delivered">Delivered</span></div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="status-card">
                    <div class="number text-danger"><?= $statusCounts['failed'] ?? 0 ?></div>
                    <div class="label"><span class="status-badge status-failed">Failed</span></div>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        <?php if (isset($orders) && !empty($orders)): ?>
            <div class="table-card">
                <h5 class="fw-bold mb-3"><i class="fas fa-list me-2 text-success"></i>Recent Orders</h5>
                <?php foreach ($orders as $order): ?>
                    <div class="order-item">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div><strong>#<?= $order['order_number'] ?? $order['id'] ?></strong></div>
                                <div><small class="text-muted"><?= date('M d, Y', strtotime($order['created_at'])) ?></small></div>
                            </div>
                            <div class="col-md-3">
                                <div><strong>Pickup Code:</strong> <span class="verification-code"><?= $order['pickup_code'] ?? 'N/A' ?></span></div>
                                <div><strong>Delivery Code:</strong> <span class="verification-code"><?= $order['delivery_code'] ?? 'N/A' ?></span></div>
                            </div>
                            <div class="col-md-3">
                                <span class="status-badge status-<?= str_replace('_', '', $order['delivery_status'] ?? 'pending') ?>">
                                    <?= ucfirst(str_replace('_', ' ', $order['delivery_status'] ?? 'Pending')) ?>
                                </span>
                            </div>
                            <div class="col-md-2">
                                <div><strong>Company ID:</strong> <?= $order['company_id'] ?? 'N/A' ?></div>
                            </div>
                            <div class="col-md-2">
                              <a href="/admin/order-details/<?= $order['id'] ?>" class="btn btn-sm btn-outline-success btn-sm-custom">
    <i class="fas fa-eye"></i> View
</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>No delivery orders found.
            </div>
        <?php endif; ?>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
    const wrapper = document.getElementById('sidebarWrapper');
    const body = document.getElementById('mainBody');
    const label = document.getElementById('toggleLabel');

    wrapper.classList.toggle('collapsed');
    body.classList.toggle('sidebar-collapsed');

    if (label) {
        label.textContent = wrapper.classList.contains('collapsed') ? 'Expand' : 'Collapse';
    }

    localStorage.setItem(
        'sidebarCollapsed',
        wrapper.classList.contains('collapsed')
    );
}

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
});
</script>
</body>
</html>