<!-- app/Views/admin/orders.php -->
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
    <title>All Orders - ShopEase Admin</title>
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

        .navbar {
            background: #1a2e1a !important;
            padding: 15px 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.3);
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1050;
        }
        .navbar-brand { color: #fff !important; font-weight: bold; font-size: 1.5rem; }
        .navbar-brand i { color: #4caf50; }
        .icon-btn { color: #d4d4d4; font-size: 1.2rem; margin: 0 8px; background: none; border: none; text-decoration: none; }
        .icon-btn:hover { color: #4caf50; }

        .sidebar-wrapper {
            position: fixed;
            top: 80px; left: 0;
            width: 280px;
            height: calc(100vh - 80px);
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

        .page-header {
            background: #f8f9fa; color: #1a2e1a; padding: 20px 0;
            border-bottom: 1px solid #e8f0e8;
        }
        .page-header h2 { font-weight: 700; color: #1a2e1a; }
        .page-header .breadcrumb { background: none; padding: 0; margin: 0; }
        .page-header .breadcrumb a { color: #4caf50; text-decoration: none; }
        .page-header .breadcrumb .active { color: #888; }

        .main-content { padding: 20px 30px; }

        .table-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e8f0e8;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #cce5ff; color: #004085; }
        .status-processing { background: #d1ecf1; color: #0c5460; }
        .status-shipped { background: #d4edda; color: #155724; }
        .status-delivered { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .status-refunded { background: #e2e3e5; color: #383d41; }
        .status-paid { background: #d4edda; color: #155724; }
        .status-failed { background: #f8d7da; color: #721c24; }
        .status-cod { background: #e2e3e5; color: #383d41; }

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
            gap: 8px;
            flex-wrap: wrap;
        }
        .filter-section .filter-actions .btn-filter {
            border-radius: 20px;
            padding: 5px 15px;
            font-size: 0.8rem;
            border: 1px solid #dee2e6;
            color: #6c757d;
            text-decoration: none;
            transition: 0.3s;
        }
        .filter-section .filter-actions .btn-filter:hover {
            background: #f8f9fa;
        }
        .filter-section .filter-actions .btn-filter.active {
            background: #4caf50;
            color: #fff;
            border-color: #4caf50;
        }
        .filter-section .filter-actions .btn-filter .badge {
            font-size: 0.65rem;
        }

        @media (max-width: 992px) {
            body { padding-left: 0; }
            .sidebar-wrapper { position: relative; top: 0; width: 100%; height: auto; border-right: none; border-bottom: 1px solid #e8f0e8; }
            .sidebar-wrapper.collapsed { width: 100%; }
            .sidebar-wrapper.collapsed .sidebar-menu li { justify-content: flex-start; }
            .sidebar-wrapper.collapsed .sidebar-menu li .menu-text { display: inline; }
            .sidebar-wrapper.collapsed .sidebar-menu li i { margin-right: 12px; }
            .sidebar-wrapper.collapsed .admin-name,
            .sidebar-wrapper.collapsed .admin-role,
            .sidebar-wrapper.collapsed .sidebar-category { display: block; }
            body.sidebar-collapsed { padding-left: 0; }
            .main-content { padding: 15px; }
            .filter-section { flex-direction: column; align-items: stretch; }
            .filter-section .filter-actions { justify-content: center; }
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
            <span id="toggleText">Collapse</span>
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

        <!-- ORDERS & PRODUCTS -->
        <div class="sidebar-category">Orders & Products</div>
        <ul class="sidebar-menu">
            <li class="active" onclick="location.href='/admin/orders'" data-tooltip="Orders">
                <i class="fas fa-shopping-bag"></i>
                <span class="menu-text">Orders</span>
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

<!-- Page Header -->
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
                    <span class="text-muted">Orders</span>
                </nav>
            </div>
            <div>
                <span class="text-muted">Total Orders: <?= count($orders ?? []) ?></span>
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

        <div class="table-card">
            <!-- Filter Section -->
            <div class="filter-section">
                <div class="order-count">
                    <i class="fas fa-shopping-bag me-1"></i>
                    <?= count($orders ?? []) ?> orders found
                    <?php if (!empty($statusFilter)): ?>
                        <span class="text-muted">(filtered by: <strong><?= ucfirst($statusFilter) ?></strong>)</span>
                    <?php endif; ?>
                </div>
                <div class="filter-actions">
                    <a href="/admin/orders" class="btn-filter <?= empty($statusFilter) ? 'active' : '' ?>">
                        <i class="fas fa-list me-1"></i>All
                        <span class="badge bg-secondary text-white"><?= $totalOrders ?? 0 ?></span>
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

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Store</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($orders)): ?>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td>
                                        <strong>#<?= esc($order['order_number']) ?></strong>
                                    </td>
                                    <td>
                                        <?= esc(trim(($order['first_name'] ?? '') . ' ' . ($order['last_name'] ?? '')) ?: 'N/A') ?>
                                        <br>
                                        <small class="text-muted"><?= esc($order['customer_email'] ?? '') ?></small>
                                    </td>
                                    <td><?= esc($order['store_name'] ?? 'N/A') ?></td>
                                    <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                                    <td><strong>$<?= number_format($order['total_amount'], 2) ?></strong></td>
                                    <td>
                                        <span class="status-badge status-<?= strtolower($order['payment_status'] ?? 'pending') ?>">
                                            <?= ucfirst($order['payment_status'] ?? 'Pending') ?>
                                        </span>
                                        <div class="text-muted small mt-1"><?= strtoupper($order['payment_method'] ?? '') ?></div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?= strtolower($order['order_status'] ?? 'pending') ?>">
                                            <?= ucfirst($order['order_status'] ?? 'Pending') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="/admin/orders/view/<?= $order['id'] ?>" class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="/admin/orders/update-status/<?= $order['id'] ?>" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-shopping-bag fa-3x text-muted mb-3 d-block"></i>
                                    <p class="text-muted">No orders found.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        var wrapper = document.getElementById('sidebarWrapper');
        var body = document.getElementById('mainBody');
        var toggleText = document.getElementById('toggleText');
        wrapper.classList.toggle('collapsed');
        body.classList.toggle('sidebar-collapsed');
        toggleText.textContent = wrapper.classList.contains('collapsed') ? 'Expand' : 'Collapse';
    }
</script>
</body>
</html>