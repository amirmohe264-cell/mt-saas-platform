<!-- app/Views/store_owner/payment_history.php -->
<?php
if (!session()->get('tenant_id')) {
    header('Location: /login');
    exit();
}
?>
<?php $active_menu = 'payment-history'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Same styles as earnings.php */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            padding-left: 280px;
            padding-top: 80px;
            transition: padding-left 0.3s ease;
            min-height: 100vh;
        }
        /* Copy all styles from earnings.php */

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
        }
        .stat-card .label {
            color: #888;
            font-size: 0.85rem;
        }
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
        }
        .status-paid { background: #d4edda; color: #155724; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-failed { background: #f8d7da; color: #721c24; }
        .status-refunded { background: #cce5ff; color: #004085; }

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
            .table-card { padding: 15px; }
        }
    </style>
</head>
<body id="mainBody">

<!-- Navbar - Same as earnings.php -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="fas fa-store"></i> ShopEase</a>
        <div class="d-flex align-items-center ms-auto">
            <span class="text-white me-3 d-none d-md-inline"><i class="fas fa-store me-1"></i><?= session()->get('store_name') ?? 'Store' ?></span>
            <a href="/logout" class="icon-btn"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </div>
</nav>

<!-- Sidebar - Same as earnings.php with active=payment-history -->
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
                <h2><i class="fas fa-history me-2 text-success"></i>Payment History</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a><span class="mx-2">/</span>
                    <a href="/store/dashboard">Dashboard</a><span class="mx-2">/</span>
                    <span class="active">Payment History</span>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="main-content">
    <div class="container-fluid px-4">

        <!-- Summary Stats -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="number text-success">$<?= number_format($summary['total_sales'] ?? 0, 2) ?></div>
                    <div class="label">Total Sales</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="number text-warning">$<?= number_format($summary['total_commission'] ?? 0, 2) ?></div>
                    <div class="label">Total Commission</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="number text-success">$<?= number_format($summary['total_earned'] ?? 0, 2) ?></div>
                    <div class="label">Total Earned</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="number text-info"><?= $summary['total_orders'] ?? 0 ?></div>
                    <div class="label">Total Orders</div>
                </div>
            </div>
        </div>

        <!-- Payment History Table -->
        <div class="table-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0"><i class="fas fa-list me-2 text-success"></i>All Payments</h5>
                <span class="text-muted">Last 100 transactions</span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Order Total</th>
                            <th>Platform Fee</th>
                            <th>Delivery Fee</th>
                            <th>Commission</th>
                            <th>Your Earnings</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($payment_history) && !empty($payment_history)): ?>
                            <?php foreach ($payment_history as $payment): ?>
                                <tr>
                                    <td>#<?= $payment['order_id'] ?></td>
                                    <td>$<?= number_format($payment['order_total'], 2) ?></td>
                                    <td>$<?= number_format($payment['platform_fee'], 2) ?></td>
                                    <td>$<?= number_format($payment['delivery_fee'], 2) ?></td>
                                    <td>$<?= number_format($payment['commission_amount'], 2) ?></td>
                                    <td><strong>$<?= number_format($payment['store_owner_amount'], 2) ?></strong></td>
                                    <td>
                                        <span class="status-badge status-<?= $payment['payment_status'] ?>">
                                            <?= ucfirst($payment['payment_status']) ?>
                                        </span>
                                    </td>
                                    <td><?= date('M d, Y', strtotime($payment['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">No payment history found.</td>
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
    wrapper.classList.toggle('collapsed');
    body.classList.toggle('sidebar-collapsed');
}
</script>
</body>
</html>