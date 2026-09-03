
<!-- app/Views/admin/dashboard.php -->
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
    <title>Admin Dashboard - ShopEase</title>
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
        .navbar .nav-link { color: #d4d4d4 !important; font-weight: 500; transition: 0.3s; }
        .navbar .nav-link:hover { color: #4caf50 !important; }
        .navbar .nav-link.active { color: #4caf50 !important; }
        .icon-btn { color: #d4d4d4; font-size: 1.2rem; margin: 0 8px; background: none; border: none; text-decoration: none; }
        .icon-btn:hover { color: #4caf50; }
        .navbar-toggler { border-color: #4caf50; }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(76, 175, 80, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

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

        .dashboard-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e8f0e8;
            transition: 0.3s;
            height: 100%;
        }
        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
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
        }

        .activity-item {
            background: #fff;
            border-radius: 12px;
            padding: 15px 20px;
            border: 1px solid #e8f0e8;
            margin-bottom: 12px;
            transition: 0.3s;
        }
        .activity-item:hover { border-color: #4caf50; }
        .activity-item .activity-icon {
            width: 40px; height: 40px; border-radius: 50%;
            display: inline-flex; align-items: center; justify-content: center;
            margin-right: 12px;
        }
        .activity-icon.success { background: #e8f5e9; color: #4caf50; }
        .activity-icon.warning { background: #fff3e0; color: #ff9800; }
        .activity-icon.info { background: #e3f2fd; color: #2196f3; }
        .activity-icon.danger { background: #fce4ec; color: #dc3545; }

        .sections { display: none; }
        .sections.active { display: block; }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-active { background: #d4edda; color: #155724; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-suspended { background: #f8d7da; color: #721c24; }
        .status-disabled { background: #e2e3e5; color: #383d41; }

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
        .btn-add:hover { background: #388e3c; color: #fff; }

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
        }
    </style>
</head>
<body id="mainBody">

<!-- ========================================== -->
<!-- NAVBAR WITH TOP BUTTONS -->
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
                <li class="nav-item"><a class="nav-link active" href="#">Admin Dashboard</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <span class="text-white me-3 d-none d-md-inline"><i class="fas fa-shield-alt me-1"></i>Super Admin</span>
                <a href="/logout" class="icon-btn"><i class="fas fa-sign-out-alt"></i></a>
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
            <span id="toggleText">Collapse</span>
        </button>

        <div class="admin-avatar"><i class="fas fa-user-shield"></i></div>
        <div class="admin-name"><?= session()->get('full_name') ?? 'Super Admin' ?></div>
        <div class="admin-role"><span class="badge bg-success">Super Admin</span></div>

        <div class="sidebar-category">Management</div>
        <ul class="sidebar-menu">
            <li class="active" onclick="location.href='/admin/dashboard'" data-tooltip="Dashboard">
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

        <div class="sidebar-category">Orders & Products</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/admin/orders'" data-tooltip="Orders">
                <i class="fas fa-shopping-bag"></i>
                <span class="menu-text">Orders</span>
            </li>
            <li onclick="location.href='/admin/products'" data-tooltip="Products">
                <i class="fas fa-box"></i>
                <span class="menu-text">Products</span>
            </li>
        </ul>

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
                <h2><i class="fas fa-shield-alt me-2 text-success"></i>Admin Dashboard</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2">/</span>
                    <span class="text-muted">Admin Dashboard</span>
                </nav>
            </div>
            <div>
                <span class="text-muted">Welcome, <?= session()->get('full_name') ?? 'Super Admin' ?>!</span>
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

        <!-- Dashboard Cards with REAL DATA -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="dashboard-card">
                    <i class="fas fa-store card-icon text-success"></i>
                    <div class="card-number"><?= number_format($totalStores ?? 0) ?></div>
                    <div class="card-label">Total Stores</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="dashboard-card">
                    <i class="fas fa-check-circle card-icon text-success"></i>
                    <div class="card-number"><?= number_format($activeStores ?? 0) ?></div>
                    <div class="card-label">Active Stores</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="dashboard-card">
                    <i class="fas fa-users card-icon text-primary"></i>
                    <div class="card-number"><?= number_format($totalCustomers ?? 0) ?></div>
                    <div class="card-label">Total Customers</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="dashboard-card">
                    <i class="fas fa-dollar-sign card-icon text-success"></i>
                    <div class="card-number">$<?= number_format($totalRevenue ?? 0, 2) ?></div>
                    <div class="card-label">Platform Revenue</div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="dashboard-card">
                    <i class="fas fa-box card-icon text-warning"></i>
                    <div class="card-number"><?= number_format($totalProducts ?? 0) ?></div>
                    <div class="card-label">Total Products</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="dashboard-card">
                    <i class="fas fa-shopping-bag card-icon text-primary"></i>
                    <div class="card-number"><?= number_format($totalOrders ?? 0) ?></div>
                    <div class="card-label">Total Orders</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="dashboard-card">
                    <i class="fas fa-exclamation-triangle card-icon text-danger"></i>
                    <div class="card-number"><?= number_format($suspendedStores ?? 0) ?></div>
                    <div class="card-label">Suspended Stores</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="dashboard-card">
                    <i class="fas fa-user-plus card-icon text-success"></i>
                    <div class="card-number"><?= number_format($newCustomers ?? 0) ?></div>
                    <div class="card-label">New Customers (This Month)</div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <h5 class="fw-bold mb-3"><i class="fas fa-clock me-2 text-success"></i>Recent Activity</h5>
        
        <?php if (isset($recentActivities) && !empty($recentActivities)): ?>
            <?php foreach ($recentActivities as $activity): ?>
                <div class="activity-item">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <span class="activity-icon <?= $activity['icon_type'] ?? 'info' ?>">
                                <i class="fas <?= $activity['icon'] ?? 'fa-info-circle' ?>"></i>
                            </span>
                            <div>
                                <div class="activity-text"><?= esc($activity['message']) ?></div>
                                <div class="activity-time"><?= $activity['time'] ?? 'Just now' ?></div>
                            </div>
                        </div>
                        <span class="badge <?= $activity['badge_class'] ?? 'bg-secondary' ?>">
                            <?= $activity['badge_text'] ?? 'New' ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">No recent activity.</p>
        <?php endif; ?>
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