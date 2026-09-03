<!-- app/Views/admin/users.php -->
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
    <title>Manage Users - ShopEase</title>
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

        .table-card { background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #e8f0e8; }
        .btn-add { background: #4caf50; color: #fff; border: none; border-radius: 30px; padding: 10px 25px; font-weight: 600; transition: 0.3s; text-decoration: none; display: inline-block; }
        .btn-add:hover { background: #388e3c; color: #fff; }
        .btn-edit { background: #ffc107; color: #000; border: none; border-radius: 30px; padding: 5px 15px; font-weight: 600; transition: 0.3s; text-decoration: none; display: inline-block; font-size: 0.8rem; }
        .btn-edit:hover { background: #e0a800; color: #000; }
        .btn-delete { background: #dc3545; color: #fff; border: none; border-radius: 30px; padding: 5px 15px; font-weight: 600; transition: 0.3s; text-decoration: none; display: inline-block; font-size: 0.8rem; }
        .btn-delete:hover { background: #c82333; color: #fff; }
        .btn-toggle { background: #17a2b8; color: #fff; border: none; border-radius: 30px; padding: 5px 15px; font-weight: 600; transition: 0.3s; text-decoration: none; display: inline-block; font-size: 0.8rem; }
        .btn-toggle:hover { background: #138496; color: #fff; }

        .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .status-active { background: #d4edda; color: #155724; }
        .status-inactive { background: #f8d7da; color: #721c24; }
        .status-suspended { background: #f8d7da; color: #721c24; }
        .status-pending { background: #fff3cd; color: #856404; }

        .nav-tabs .nav-link { color: #555; font-weight: 500; }
        .nav-tabs .nav-link.active { color: #4caf50; border-color: #4caf50 #4caf50 #fff; }
        .nav-tabs .nav-link:hover { border-color: #e8f0e8; }

        .action-btns .btn { margin: 2px; }

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
            <li class="active" onclick="location.href='/admin/users'" data-tooltip="Users">
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
            <li onclick="location.href='/admin/orders'" data-tooltip="Orders">
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
                <h2><i class="fas fa-users me-2 text-success"></i>Manage Users</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2">/</span>
                    <a href="/admin/dashboard">Dashboard</a>
                    <span class="mx-2">/</span>
                    <span class="text-muted">Users</span>
                </nav>
            </div>
            <div>
                <span class="text-muted">Total Users: <?= esc($totalUsers ?? 0) ?></span>
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
            <ul class="nav nav-tabs mb-4" id="userTabs">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#customers">
                        <i class="fas fa-user me-1"></i>Customers
                        <span class="badge bg-secondary ms-1"><?= isset($customers) ? count($customers) : 0 ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#storeOwners">
                        <i class="fas fa-store me-1"></i>Store Owners
                        <span class="badge bg-secondary ms-1"><?= isset($storeOwners) ? count($storeOwners) : 0 ?></span>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Customers Tab -->
                <div class="tab-pane fade show active" id="customers">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Joined</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($customers) && !empty($customers)): ?>
                                    <?php foreach ($customers as $customer): ?>
                                        <tr>
                                            <td><strong><?= esc($customer['first_name'] . ' ' . $customer['last_name']) ?></strong></td>
                                            <td><?= esc($customer['email']) ?></td>
                                            <td><?= esc($customer['phone'] ?? 'N/A') ?></td>
                                            <td><?= date('M d, Y', strtotime($customer['created_at'])) ?></td>
                                            <td>
                                                <span class="status-badge <?= ($customer['is_active'] ?? true) ? 'status-active' : 'status-inactive' ?>">
                                                    <?= ($customer['is_active'] ?? true) ? 'Active' : 'Inactive' ?>
                                                </span>
                                            </td>
                                            <td class="action-btns">
                                                <a href="/admin/users/customer/toggle/<?= $customer['id'] ?>" 
                                                   class="btn-toggle" 
                                                   onclick="return confirm('Toggle customer status?')">
                                                    <i class="fas <?= ($customer['is_active'] ?? true) ? 'fa-ban' : 'fa-undo' ?>"></i> Toggle
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="fas fa-users-slash fa-2x text-muted mb-2 d-block"></i>
                                            <p class="text-muted">No customers registered yet.</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Store Owners Tab -->
                <div class="tab-pane fade" id="storeOwners">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Store Owner</th>
                                    <th>Email</th>
                                    <th>Store</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($storeOwners) && !empty($storeOwners)): ?>
                                    <?php foreach ($storeOwners as $owner): ?>
                                        <tr>
                                            <td><strong><?= esc($owner['full_name']) ?></strong></td>
                                            <td><?= esc($owner['email']) ?></td>
                                            <td><?= esc($owner['store_name'] ?? 'No store') ?></td>
                                            <td>
                                                <span class="status-badge <?= ($owner['is_active'] ?? true) ? 'status-active' : 'status-inactive' ?>">
                                                    <?= ($owner['is_active'] ?? true) ? 'Active' : 'Inactive' ?>
                                                </span>
                                            </td>
                                            <td class="action-btns">
                                                <a href="/admin/users/store-owner/toggle/<?= $owner['id'] ?>" 
                                                   class="btn-toggle" 
                                                   onclick="return confirm('Toggle store owner status?')">
                                                    <i class="fas <?= ($owner['is_active'] ?? true) ? 'fa-ban' : 'fa-undo' ?>"></i> Toggle
                                                </a>
                                                <a href="/admin/users/store-owner/reset-password/<?= $owner['id'] ?>" 
                                                   class="btn-edit" 
                                                   onclick="return confirm('Reset password for this store owner?')">
                                                    <i class="fas fa-key"></i> Reset
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <i class="fas fa-store-slash fa-2x text-muted mb-2 d-block"></i>
                                            <p class="text-muted">No store owners registered yet.</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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