<!-- app/Views/admin/order_details.php -->
<?php $active_menu = 'orders'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - ShopEase Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Same styles as other admin pages */
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

        .detail-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e8f0e8;
            margin-bottom: 20px;
        }
        .detail-card .label {
            color: #888;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .detail-card .value {
            font-weight: 600;
            color: #1a2e1a;
            font-size: 1rem;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-processing { background: #cce5ff; color: #004085; }
        .status-completed { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }

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
            .sidebar-wrapper.collapsed .admin-name,
            .sidebar-wrapper.collapsed .admin-role,
            .sidebar-wrapper.collapsed .sidebar-category { display: block; }
            body.sidebar-collapsed { padding-left: 0; }
            .main-content { padding: 15px; }
            .detail-card { padding: 15px; }
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
            <li class="active" onclick="location.href='/admin/orders'" data-tooltip="Orders">
                <i class="fas fa-shopping-bag"></i><span class="menu-text">Orders</span>
            </li>
            <li onclick="location.href='/admin/delivery-assignments'" data-tooltip="Delivery Assignments">
                <i class="fas fa-tasks"></i><span class="menu-text">Delivery Assignments</span>
            </li>
            <li onclick="location.href='/admin/delivery-status'" data-tooltip="Delivery Status">
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
                <h2><i class="fas fa-shopping-bag me-2 text-success"></i>Order Details</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a><span class="mx-2">/</span>
                    <a href="/admin/dashboard">Dashboard</a><span class="mx-2">/</span>
                    <a href="/admin/orders">Orders</a><span class="mx-2">/</span>
                    <span class="active">#<?= $order['order_number'] ?? $order['id'] ?></span>
                </nav>
            </div>
            <div>
                <a href="/admin/orders" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="main-content">
    <div class="container-fluid px-4">

        <div class="row">
            <!-- Order Info -->
            <div class="col-md-6">
                <div class="detail-card">
                    <h6 class="fw-bold mb-3"><i class="fas fa-shopping-bag me-2 text-success"></i>Order Information</h6>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="label">Order Number</div>
                            <div class="value">#<?= $order['order_number'] ?? $order['id'] ?></div>
                        </div>
                        <div class="col-6">
                            <div class="label">Order Status</div>
                            <div><span class="status-badge status-<?= strtolower($order['order_status'] ?? 'pending') ?>"><?= ucfirst($order['order_status'] ?? 'Pending') ?></span></div>
                        </div>
                        <div class="col-6">
                            <div class="label">Total Amount</div>
                            <div class="value">$<?= number_format($order['total_amount'] ?? 0, 2) ?></div>
                        </div>
                        <div class="col-6">
                            <div class="label">Payment Method</div>
                            <div class="value"><?= ucfirst($order['payment_method'] ?? 'N/A') ?></div>
                        </div>
                        <div class="col-12">
                            <div class="label">Created At</div>
                            <div class="value"><?= date('M d, Y H:i', strtotime($order['created_at'])) ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="col-md-6">
                <div class="detail-card">
                    <h6 class="fw-bold mb-3"><i class="fas fa-user me-2 text-success"></i>Customer Information</h6>
                    <div class="row g-2">
                        <div class="col-12">
                            <div class="label">Customer Name</div>
                            <div class="value"><?= $order['customer']['full_name'] ?? $order['customer']['first_name'] . ' ' . $order['customer']['last_name'] ?? 'N/A' ?></div>
                        </div>
                        <div class="col-12">
                            <div class="label">Email</div>
                            <div class="value"><?= $order['customer']['email'] ?? 'N/A' ?></div>
                        </div>
                        <div class="col-12">
                            <div class="label">Phone</div>
                            <div class="value"><?= $order['customer']['phone'] ?? 'N/A' ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delivery Info -->
        <div class="row">
            <div class="col-md-6">
                <div class="detail-card">
                    <h6 class="fw-bold mb-3"><i class="fas fa-truck me-2 text-success"></i>Delivery Information</h6>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="label">Pickup Code</div>
                            <div class="verification-code"><?= $order['pickup_code'] ?? 'N/A' ?></div>
                        </div>
                        <div class="col-6">
                            <div class="label">Delivery Code</div>
                            <div class="verification-code"><?= $order['delivery_code'] ?? 'N/A' ?></div>
                        </div>
                        <div class="col-12">
                            <div class="label">Delivery Status</div>
                            <div><span class="status-badge status-<?= str_replace('_', '', $order['delivery_status'] ?? 'pending') ?>"><?= ucfirst(str_replace('_', ' ', $order['delivery_status'] ?? 'Pending')) ?></span></div>
                        </div>
                        <div class="col-12">
                            <div class="label">Shipping Address</div>
                            <div class="value"><?= $order['shipping_address'] ?? 'N/A' ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Store Info -->
            <div class="col-md-6">
                <div class="detail-card">
                    <h6 class="fw-bold mb-3"><i class="fas fa-store me-2 text-success"></i>Store Information</h6>
                    <div class="row g-2">
                        <div class="col-12">
                            <div class="label">Store Name</div>
                            <div class="value"><?= $order['store']['store_name'] ?? 'N/A' ?></div>
                        </div>
                        <div class="col-12">
                            <div class="label">Store Email</div>
                            <div class="value"><?= $order['store']['contact_email'] ?? 'N/A' ?></div>
                        </div>
                        <div class="col-12">
                            <div class="label">Store Phone</div>
                            <div class="value"><?= $order['store']['contact_phone'] ?? 'N/A' ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="detail-card">
            <h6 class="fw-bold mb-3"><i class="fas fa-list me-2 text-success"></i>Order Items</h6>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($order['items']) && !empty($order['items'])): ?>
                            <?php foreach ($order['items'] as $item): ?>
                                <tr>
                                    <td><?= $item['product_name'] ?? 'Product #' . $item['product_id'] ?></td>
                                    <td><?= $item['quantity'] ?? 0 ?></td>
                                    <td>$<?= number_format($item['price'] ?? 0, 2) ?></td>
                                    <td>$<?= number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0), 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">No items found</td>
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