<!-- app/Views/store_owner/earnings.php -->
<?php
if (!session()->get('tenant_id')) {
    header('Location: /login');
    exit();
}
?>
<?php $active_menu = 'earnings'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Earnings & Commission - ShopEase</title>
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
        .sidebar-wrapper.collapsed .store-name,
        .sidebar-wrapper.collapsed .store-status,
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
        .sidebar-wrapper.collapsed .store-avatar { width: 45px; height: 45px; font-size: 1.2rem; }

        body.sidebar-collapsed { padding-left: 70px; }

        .sidebar-card .store-avatar {
            width: 70px; height: 70px; border-radius: 50%;
            background: #4caf50; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; margin: 0 auto 10px;
        }
        .sidebar-card .store-name { text-align: center; font-weight: 700; color: #1a2e1a; font-size: 1rem; }
        .sidebar-card .store-status { text-align: center; font-size: 0.8rem; }

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
            background: #f8f9fa;
            color: #1a2e1a;
            padding: 20px 0 20px;
            border-bottom: 1px solid #e8f0e8;
        }
        .page-header h2 { font-weight: 700; color: #1a2e1a; }
        .page-header .breadcrumb { background: none; padding: 0; margin: 0; }
        .page-header .breadcrumb a { color: #4caf50; text-decoration: none; }
        .page-header .breadcrumb .active { color: #888; }

        .main-content {
            padding: 20px 30px;
            min-height: calc(100vh - 160px);
        }

        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e8f0e8;
            text-align: center;
        }
        .stat-card .number {
            font-size: 2rem;
            font-weight: 700;
            color: #1a2e1a;
        }
        .stat-card .number.text-success { color: #28a745; }
        .stat-card .number.text-warning { color: #ffc107; }
        .stat-card .number.text-info { color: #17a2b8; }
        .stat-card .number.text-danger { color: #dc3545; }
        .stat-card .label {
            color: #888;
            font-size: 0.85rem;
        }

        .earnings-breakdown {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e8f0e8;
        }
        .breakdown-item {
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .breakdown-item:last-child { border-bottom: none; }
        .breakdown-item .label { color: #888; font-size: 0.9rem; }
        .breakdown-item .value { font-weight: 700; font-size: 1.2rem; color: #1a2e1a; }

        @media (max-width: 992px) {
            body { padding-left: 0; }
            .sidebar-wrapper {
                position: relative; top: 0; width: 100%; height: auto;
                border-right: none; border-bottom: 1px solid #e8f0e8;
            }
            .sidebar-wrapper.collapsed { width: 100%; }
            .sidebar-wrapper.collapsed .sidebar-menu li { justify-content: flex-start; }
            .sidebar-wrapper.collapsed .sidebar-menu li .menu-text { display: inline; }
            .sidebar-wrapper.collapsed .sidebar-menu li i { margin-right: 12px; }
            .sidebar-wrapper.collapsed .store-name,
            .sidebar-wrapper.collapsed .store-status,
            .sidebar-wrapper.collapsed .sidebar-category { display: block; }
            body.sidebar-collapsed { padding-left: 0; }
            .main-content { padding: 15px; }
            .stat-card { padding: 15px; }
        }
    </style>
</head>
<body id="mainBody">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="fas fa-store"></i> ShopEase</a>
        <div class="d-flex align-items-center ms-auto">
            <span class="text-white me-3 d-none d-md-inline"><i class="fas fa-store me-1"></i><?= session()->get('store_name') ?? 'Store' ?></span>
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
        <div class="store-avatar"><i class="fas fa-store"></i></div>
        <div class="store-name"><?= session()->get('store_name') ?? 'Store' ?></div>
        <div class="store-status"><span class="badge bg-success">Active</span></div>

        <div class="sidebar-category">Management</div>
        <ul class="sidebar-menu">
            <div class="sidebar-category">Management</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/store/dashboard'" data-tooltip="Dashboard">
                <i class="fas fa-tachometer-alt"></i>
                <span class="menu-text">Dashboard</span>
            </li>
            <li onclick="location.href='/store/products'" data-tooltip="Products">
                <i class="fas fa-box"></i>
                <span class="menu-text">Products</span>
            </li>
            <li onclick="location.href='/store/subcategories'" data-tooltip="Subcategories">
                <i class="fas fa-tags"></i>
                <span class="menu-text">Subcategories</span>
            </li>
            <li class="active" onclick="location.href='/store/orders'" data-tooltip="Orders">
                <i class="fas fa-shopping-bag"></i>
                <span class="menu-text">Orders</span>
            </li>
        </ul>

        <div class="sidebar-category">Finance & Earnings</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/store/dashboard#reports'" data-tooltip="Reports">
                <i class="fas fa-chart-line"></i>
                <span class="menu-text">Reports</span>
            </li>
        </ul>
        <ul class="sidebar-menu">
    <li onclick="location.href='/store/earnings'" data-tooltip="Earnings">
        <i class="fas fa-chart-line"></i>
        <span class="menu-text">Earnings & Commission</span>
    </li>
    <li onclick="location.href='/store/payouts'" data-tooltip="Payouts">
        <i class="fas fa-money-bill-wave"></i>
        <span class="menu-text">Payouts</span>
    </li>
    <li onclick="location.href='/store/payment-history'" data-tooltip="Payment History">
        <i class="fas fa-history"></i>
        <span class="menu-text">Payment History</span>
    </li>
</ul>


        <div class="sidebar-category">Services</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/store/dashboard#settings'" data-tooltip="Settings">
                <i class="fas fa-store-alt"></i>
                <span class="menu-text">Store Settings</span>
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
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-chart-line me-2 text-success"></i>Earnings & Commission</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a><span class="mx-2">/</span>
                    <a href="/store/dashboard">Dashboard</a><span class="mx-2">/</span>
                    <span class="active">Earnings</span>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="main-content">
    <div class="container-fluid px-4">

        <!-- Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="number text-success">$<?= number_format($total_sales ?? 0, 2) ?></div>
                    <div class="label">Total Sales</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="number text-warning">$<?= number_format($total_commission ?? 0, 2) ?></div>
                    <div class="label">Platform Commission</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="number text-success">$<?= number_format($total_store_owner_amount ?? 0, 2) ?></div>
                    <div class="label">Your Earnings</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="number text-info">$<?= number_format($pending_payouts ?? 0, 2) ?></div>
                    <div class="label">Pending Payouts</div>
                </div>
            </div>
        </div>

        <!-- Earnings Breakdown -->
        <div class="row g-3">
            <div class="col-md-6">
                <div class="earnings-breakdown">
                    <h6 class="fw-bold mb-3"><i class="fas fa-wallet me-2 text-success"></i>Earnings Breakdown</h6>
                    <div class="breakdown-item">
                        <div class="row">
                            <div class="col-8 label">Total Sales (Gross)</div>
                            <div class="col-4 value text-end">$<?= number_format($total_sales ?? 0, 2) ?></div>
                        </div>
                    </div>
                    <div class="breakdown-item">
                        <div class="row">
                            <div class="col-8 label">Platform Commission (<?= $commission_percentage ?? 10 ?>%)</div>
                            <div class="col-4 value text-end text-warning">-$<?= number_format($total_commission ?? 0, 2) ?></div>
                        </div>
                    </div>
                    <div class="breakdown-item">
                        <div class="row">
                            <div class="col-8 label"><strong>Net Earnings</strong></div>
                            <div class="col-4 value text-end text-success"><strong>$<?= number_format($total_store_owner_amount ?? 0, 2) ?></strong></div>
                        </div>
                    </div>
                    <div class="breakdown-item">
                        <div class="row">
                            <div class="col-8 label">Paid Out</div>
                            <div class="col-4 value text-end">$<?= number_format($completed_payouts ?? 0, 2) ?></div>
                        </div>
                    </div>
                    <div class="breakdown-item">
                        <div class="row">
                            <div class="col-8 label">Pending Payouts</div>
                            <div class="col-4 value text-end text-warning">$<?= number_format($pending_payouts ?? 0, 2) ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="earnings-breakdown">
                    <h6 class="fw-bold mb-3"><i class="fas fa-info-circle me-2 text-info"></i>How It Works</h6>
                    <div class="breakdown-item">
                        <p class="text-muted mb-0">
                            <i class="fas fa-arrow-right text-success me-2"></i>
                            <strong>Total Sales:</strong> All revenue from your store's completed orders.
                        </p>
                    </div>
                    <div class="breakdown-item">
                        <p class="text-muted mb-0">
                            <i class="fas fa-arrow-right text-warning me-2"></i>
                            <strong>Platform Commission:</strong> The platform fee charged on each sale (<?= $commission_percentage ?? 10 ?>%).
                        </p>
                    </div>
                    <div class="breakdown-item">
                        <p class="text-muted mb-0">
                            <i class="fas fa-arrow-right text-success me-2"></i>
                            <strong>Net Earnings:</strong> Your earnings after commission deduction.
                        </p>
                    </div>
                    <div class="breakdown-item">
                        <p class="text-muted mb-0">
                            <i class="fas fa-arrow-right text-info me-2"></i>
                            <strong>Payouts:</strong> When you request a payout, the net earnings are transferred to your account.
                        </p>
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
    wrapper.classList.toggle('collapsed');
    body.classList.toggle('sidebar-collapsed');
}
</script>
</body>
</html>