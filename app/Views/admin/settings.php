<!-- app/Views/admin/settings.php -->
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
    <title>System Settings - ShopEase Admin</title>
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
            top: 0;
            left: 280px;
            right: 0;
            z-index: 1050;
            transition: left 0.3s ease;
        }
        .navbar-brand { color: #fff !important; font-weight: bold; font-size: 1.5rem; }
        .navbar-brand i { color: #4caf50; }
        .icon-btn { color: #d4d4d4; font-size: 1.2rem; margin: 0 8px; background: none; border: none; text-decoration: none; }
        .icon-btn:hover { color: #4caf50; }
        body.sidebar-collapsed .navbar { left: 70px; }

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

        .page-header {
            background: #f8f9fa; color: #1a2e1a; padding: 20px 0;
            border-bottom: 1px solid #e8f0e8;
        }
        .page-header h2 { font-weight: 700; color: #1a2e1a; }
        .page-header .breadcrumb { background: none; padding: 0; margin: 0; }
        .page-header .breadcrumb a { color: #4caf50; text-decoration: none; }
        .page-header .breadcrumb .active { color: #888; }

        .main-content { padding: 20px 30px; }

        .form-card {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            border: 1px solid #e8f0e8;
            max-width: 600px;
            margin: 0 auto;
        }
        .form-card label {
            font-weight: 600;
            color: #1a2e1a;
            font-size: 0.9rem;
        }
        .form-card .form-control,
        .form-card .form-select {
            border-radius: 8px;
            border: 2px solid #e8f0e8;
            padding: 10px 15px;
            transition: 0.3s;
        }
        .form-card .form-control:focus,
        .form-card .form-select:focus {
            border-color: #4caf50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.15);
        }
        .btn-save {
            background: #4caf50;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 12px 40px;
            font-weight: 600;
            transition: 0.3s;
            width: 100%;
        }
        .btn-save:hover {
            background: #388e3c;
            color: #fff;
        }
        .form-section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1a2e1a;
            padding-bottom: 10px;
            border-bottom: 2px solid #e8f0e8;
            margin-bottom: 20px;
        }
        .form-section-title i {
            color: #4caf50;
            margin-right: 8px;
        }
        .setting-help {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 4px;
        }

        @media (max-width: 992px) {
            body { padding-left: 0; }
            body.sidebar-collapsed { padding-left: 0; }
            .navbar { left: 0 !important; }
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
            .form-card { padding: 20px; }
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
            <li  onclick="location.href='/admin/platform-fees'" data-tooltip="Platform Fees">
                <i class="fas fa-percentage"></i>
                <span class="menu-text">Platform Fees</span>
            </li>
             <li class="active" onclick="location.href='/admin/commissions'" data-tooltip="Commissions">
                <i class="fas fa-hand-holding-usd"></i><span class="menu-text">Commissions</span>
            </li>
                        <li class="active" onclick="location.href='/admin/seller-payouts'" data-tooltip="Seller Payouts">
                <i class="fas fa-money-bill-wave"></i><span class="menu-text">Seller Payouts</span>
            </li>
              <li class="active" onclick="location.href='/admin/delivery-assignments'" data-tooltip="Delivery Assignments">
                <i class="fas fa-tasks"></i><span class="menu-text">Delivery Assignments</span>
            </li>
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
              <li class="active" onclick="location.href='/admin/delivery-status'" data-tooltip="Delivery Status">
                <i class="fas fa-truck"></i><span class="menu-text">Delivery Status</span>
            </li>
              <li class="active" onclick="location.href='/admin/refunds'" data-tooltip="Refunds">
                <i class="fas fa-undo"></i><span class="menu-text">Refunds & Disputes</span>
            </li>
            <li onclick="location.href='/admin/products'" data-tooltip="Products">
                <i class="fas fa-box"></i>
                <span class="menu-text">Products</span>
            </li>
        </ul>

        <!-- SETTINGS -->
        <div class="sidebar-category">Settings</div>
        <ul class="sidebar-menu">
            <li class="active" onclick="location.href='/admin/settings'" data-tooltip="Settings">
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
                <h2><i class="fas fa-cog me-2 text-success"></i>System Settings</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2">/</span>
                    <a href="/admin/dashboard">Dashboard</a>
                    <span class="mx-2">/</span>
                    <span class="text-muted">Settings</span>
                </nav>
            </div>
            <div>
                <span class="text-muted">Configure platform settings</span>
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

        <div class="form-card">
            <form action="/admin/settings/update" method="post">
                <?= csrf_field() ?>

                <!-- General Settings -->
                <div class="form-section-title">
                    <i class="fas fa-globe"></i>General Settings
                </div>

                <div class="mb-3">
                    <label for="platform_name">Platform Name</label>
                    <input type="text" name="platform_name" id="platform_name" 
                           class="form-control" 
                           value="<?= esc($settings['platform_name'] ?? 'ShopEase') ?>"
                           placeholder="Enter platform name">
                    <div class="setting-help">This name will appear across the platform.</div>
                </div>

                <div class="mb-3">
                    <label for="platform_email">Platform Email</label>
                    <input type="email" name="platform_email" id="platform_email" 
                           class="form-control" 
                           value="<?= esc($settings['platform_email'] ?? 'admin@shopease.com') ?>"
                           placeholder="Enter platform email">
                    <div class="setting-help">Used for system notifications and support.</div>
                </div>

                <div class="mb-3">
                    <label for="default_currency">Default Currency</label>
                    <select name="default_currency" id="default_currency" class="form-select">
                        <?php $currency = $settings['default_currency'] ?? 'USD'; ?>
                        <option value="USD" <?= $currency === 'USD' ? 'selected' : '' ?>>USD - US Dollar</option>
                        <option value="ETB" <?= $currency === 'ETB' ? 'selected' : '' ?>>ETB - Ethiopian Birr</option>
                        <option value="EUR" <?= $currency === 'EUR' ? 'selected' : '' ?>>EUR - Euro</option>
                        <option value="GBP" <?= $currency === 'GBP' ? 'selected' : '' ?>>GBP - British Pound</option>
                    </select>
                    <div class="setting-help">All prices will be displayed in this currency.</div>
                </div>

                <div class="mb-3">
                    <label for="default_language">Default Language</label>
                    <select name="default_language" id="default_language" class="form-select">
                        <?php $lang = $settings['default_language'] ?? 'en'; ?>
                        <option value="en" <?= $lang === 'en' ? 'selected' : '' ?>>English</option>
                        <option value="am" <?= $lang === 'am' ? 'selected' : '' ?>>Amharic</option>
                        <option value="es" <?= $lang === 'es' ? 'selected' : '' ?>>Spanish</option>
                        <option value="fr" <?= $lang === 'fr' ? 'selected' : '' ?>>French</option>
                    </select>
                    <div class="setting-help">Default language for the platform interface.</div>
                </div>

                <!-- Payment Settings -->
                <div class="form-section-title mt-4">
                    <i class="fas fa-credit-card"></i>Payment Settings
                </div>

                <div class="mb-3">
                    <label for="platform_fee">Platform Fee (%)</label>
                    <input type="number" name="platform_fee" id="platform_fee" 
                           class="form-control" 
                           value="<?= esc($settings['platform_fee'] ?? 10) ?>"
                           placeholder="Enter platform fee percentage"
                           min="0" max="100" step="0.1">
                    <div class="setting-help">Percentage charged on each order as platform fee.</div>
                </div>

                <div class="mb-3">
                    <label for="delivery_fee">Default Delivery Fee</label>
                    <input type="number" name="delivery_fee" id="delivery_fee" 
                           class="form-control" 
                           value="<?= esc($settings['delivery_fee'] ?? 5) ?>"
                           placeholder="Enter delivery fee"
                           min="0" step="0.5">
                    <div class="setting-help">Standard delivery fee for orders (overrides free shipping threshold).</div>
                </div>

                <div class="mb-3">
                    <label for="free_shipping_threshold">Free Shipping Threshold</label>
                    <input type="number" name="free_shipping_threshold" id="free_shipping_threshold" 
                           class="form-control" 
                           value="<?= esc($settings['free_shipping_threshold'] ?? 50) ?>"
                           placeholder="Enter free shipping threshold"
                           min="0">
                    <div class="setting-help">Orders above this amount get free delivery.</div>
                </div>

                <button type="submit" class="btn-save">
                    <i class="fas fa-save me-2"></i>Save Settings
                </button>
            </form>
        </div>
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