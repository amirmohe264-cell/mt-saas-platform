<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Dashboard - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            padding-left: 280px;
            padding-top: 80px;
            transition: padding-left 0.3s ease;
            min-height: 100vh;
        }

        /* ========================================== */
        /* ✅ NOTIFICATION STYLES */
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
            left: 0;
            right: 0;
            z-index: 1050;
        }
        .navbar-brand {
            color: #fff !important;
            font-weight: bold;
            font-size: 1.5rem;
        }
        .navbar-brand i {
            color: #4caf50;
        }
        .navbar .nav-link {
            color: #d4d4d4 !important;
            font-weight: 500;
            transition: 0.3s;
        }
        .navbar .nav-link:hover {
            color: #4caf50 !important;
        }
        .icon-btn {
            color: #d4d4d4;
            font-size: 1.2rem;
            margin: 0 8px;
            transition: 0.3s;
            background: none;
            border: none;
        }
        .icon-btn:hover {
            color: #4caf50;
            transform: scale(1.1);
        }
        .navbar-toggler {
            border-color: #4caf50;
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(76, 175, 80, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* ========================================== */
        /* FIXED SIDEBAR */
        /* ========================================== */
        .sidebar-wrapper {
            position: fixed;
            top: 80px;
            left: 0;
            width: 280px;
            height: calc(100vh - 80px);
            overflow-y: auto;
            background: #fff;
            border-right: 1px solid #e8f0e8;
            padding: 20px 15px;
            z-index: 1000;
            transition: width 0.3s ease;
        }
        .sidebar-wrapper::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-wrapper::-webkit-scrollbar-thumb {
            background: #4caf50;
            border-radius: 4px;
        }
        .sidebar-wrapper::-webkit-scrollbar-track {
            background: #e8f0e8;
        }

        .sidebar-wrapper.collapsed {
            width: 70px;
        }
        .sidebar-wrapper.collapsed .store-name {
            display: none;
        }
        .sidebar-wrapper.collapsed .store-status {
            display: none;
        }
        .sidebar-wrapper.collapsed .sidebar-category {
            display: none;
        }
        .sidebar-wrapper.collapsed .sidebar-menu li {
            padding: 10px;
            justify-content: center;
        }
        .sidebar-wrapper.collapsed .sidebar-menu li .menu-text {
            display: none;
        }
        .sidebar-wrapper.collapsed .sidebar-menu li i {
            margin-right: 0;
            font-size: 1.2rem;
        }
        .sidebar-wrapper.collapsed .sidebar-menu li {
            position: relative;
        }
        .sidebar-wrapper.collapsed .sidebar-menu li:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: #1a2e1a;
            color: #fff;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            white-space: nowrap;
            z-index: 999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            margin-left: 8px;
        }
        .sidebar-wrapper.collapsed .store-avatar {
            width: 45px;
            height: 45px;
            font-size: 1.2rem;
        }

        body.sidebar-collapsed {
            padding-left: 70px;
        }

        .sidebar-card .store-avatar {
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
        .sidebar-card .store-name {
            text-align: center;
            font-weight: 700;
            color: #1a2e1a;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .sidebar-card .store-status {
            text-align: center;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }

        .toggle-sidebar-btn {
            background: #4caf50;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 1rem;
            transition: 0.3s;
            cursor: pointer;
            width: 100%;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .toggle-sidebar-btn:hover {
            background: #388e3c;
        }
        .toggle-sidebar-btn i {
            font-size: 1.1rem;
        }

        .sidebar-category {
            font-size: 0.65rem;
            font-weight: 700;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 15px 10px 5px;
            border-top: 1px solid #f0f0f0;
            margin-top: 5px;
            transition: all 0.3s ease;
        }
        .sidebar-category:first-child {
            border-top: none;
            margin-top: 0;
            padding-top: 5px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar-menu li {
            padding: 10px 12px;
            border-radius: 8px;
            transition: 0.3s;
            cursor: pointer;
            color: #555;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        .sidebar-menu li:hover {
            background: #f0f8f0;
            color: #4caf50;
        }
        .sidebar-menu li.active {
            background: #f0f8f0;
            color: #4caf50;
            font-weight: 600;
        }
        .sidebar-menu li i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .sidebar-menu li .menu-text {
            flex: 1;
            transition: all 0.3s ease;
        }
        .sidebar-menu li a {
            color: inherit;
            text-decoration: none;
            display: flex;
            align-items: center;
            width: 100%;
        }

        /* ========================================== */
        /* PAGE HEADER */
        /* ========================================== */
        .page-header {
            background: #f8f9fa;
            color: #1a2e1a;
            padding: 20px 0 20px;
            border-bottom: 1px solid #e8f0e8;
        }
        .page-header h2 {
            font-weight: 700;
            color: #1a2e1a;
        }
        .page-header .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
        }
        .page-header .breadcrumb a {
            color: #4caf50;
            text-decoration: none;
        }
        .page-header .breadcrumb .active {
            color: #888;
        }
        .page-header .text-muted {
            color: #888 !important;
        }

        /* ========================================== */
        /* MAIN CONTENT */
        /* ========================================== */
        .main-content {
            padding: 20px 30px;
            min-height: calc(100vh - 160px);
        }

        /* ========================================== */
        /* DASHBOARD CARDS */
        /* ========================================== */
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

        .order-item {
            background: #fff;
            border-radius: 12px;
            padding: 15px 20px;
            border: 1px solid #e8f0e8;
            margin-bottom: 12px;
            transition: 0.3s;
        }
        .order-item:hover {
            border-color: #4caf50;
        }
        .order-item .order-number {
            font-weight: 600;
            color: #1a2e1a;
        }
        .order-item .order-date {
            color: #888;
            font-size: 0.85rem;
        }
        .order-item .order-total {
            font-weight: 700;
            color: #1a2e1a;
        }

        .sections {
            display: none;
        }
        .sections.active {
            display: block;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #cce5ff; color: #004085; }
        .status-processing { background: #d1ecf1; color: #0c5460; }
        .status-shipped { background: #d4edda; color: #155724; }
        .status-delivered { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }

        .btn-add-product {
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
        .btn-add-product:hover {
            background: #388e3c;
            color: #fff;
        }

        /* ✅ Password Strength Indicator */
        .password-strength {
            height: 5px;
            border-radius: 5px;
            margin-top: 5px;
            transition: all 0.3s ease;
        }
        .password-strength.weak { background: #dc3545; width: 25%; }
        .password-strength.medium { background: #ffc107; width: 50%; }
        .password-strength.strong { background: #28a745; width: 75%; }
        .password-strength.very-strong { background: #17a2b8; width: 100%; }

        .password-requirements {
            font-size: 0.8rem;
            color: #888;
            margin-top: 5px;
        }
        .password-requirements .req-met {
            color: #28a745;
        }
        .password-requirements .req-unmet {
            color: #dc3545;
        }

        @media (max-width: 992px) {
            body {
                padding-left: 0;
            }
            .sidebar-wrapper {
                position: relative;
                top: 0;
                width: 100%;
                height: auto;
                border-right: none;
                border-bottom: 1px solid #e8f0e8;
            }
            .sidebar-wrapper.collapsed {
                width: 100%;
            }
            .sidebar-wrapper.collapsed .sidebar-menu li {
                justify-content: flex-start;
            }
            .sidebar-wrapper.collapsed .sidebar-menu li .menu-text {
                display: inline;
            }
            .sidebar-wrapper.collapsed .sidebar-menu li i {
                margin-right: 12px;
            }
            .sidebar-wrapper.collapsed .store-name {
                display: block;
            }
            .sidebar-wrapper.collapsed .store-status {
                display: block;
            }
            .sidebar-wrapper.collapsed .sidebar-category {
                display: block;
            }
            body.sidebar-collapsed {
                padding-left: 0;
            }
            .main-content {
                padding: 15px;
            }
        }
    </style>
</head>
<body id="mainBody">

<!-- ✅ Notification Container -->
<div class="notification-container" id="notificationContainer"></div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="fas fa-store"></i> ShopEase</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="#">Store Dashboard</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <span class="text-white me-3 d-none d-md-inline">Store: <?= session()->get('store_name') ?? 'Store' ?></span>
                <a href="/logout" class="icon-btn" style="color:#d4d4d4;text-decoration:none;"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </div>
</nav>

<!-- Fixed Sidebar -->
<div class="sidebar-wrapper" id="sidebarWrapper">
    <div class="sidebar-card">
        <!-- Toggle Button -->
        <button class="toggle-sidebar-btn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
            <span id="toggleText"></span>
        </button>

        <div class="store-avatar">
            <i class="fas fa-store"></i>
        </div>
        <div class="store-name"><?= session()->get('store_name') ?? 'Store' ?></div>
        <div class="store-status"><span class="badge bg-success">Active</span></div>

        <!-- MANAGEMENT -->
        <div class="sidebar-category">Management</div>
        <ul class="sidebar-menu">
            <li class="active" onclick="showSection('dashboard')" data-tooltip="Dashboard">
                <i class="fas fa-tachometer-alt"></i>
                <span class="menu-text">Dashboard</span>
            </li>
            <li onclick="showSection('products')" data-tooltip="Products">
                <i class="fas fa-box"></i>
                <span class="menu-text">Products</span>
            </li>
            <li onclick="location.href='/store/subcategories'" data-tooltip="Subcategories">
                <i class="fas fa-tags"></i>
                <span class="menu-text">Subcategories</span>
            </li>
            <li onclick="showSection('orders')" data-tooltip="Orders">
                <i class="fas fa-shopping-bag"></i>
                <span class="menu-text">Orders</span>
            </li>
        </ul>

        <!-- FINANCE & EARNINGS -->
        <div class="sidebar-category">Finance & Earnings</div>
        <ul class="sidebar-menu">
            <li onclick="showSection('reports')" data-tooltip="Reports">
                <i class="fas fa-chart-line"></i>
                <span class="menu-text">Reports</span>
            </li>
        </ul>

        <!-- SERVICES -->
        <div class="sidebar-category">Services</div>
        <ul class="sidebar-menu">
            <li onclick="showSection('settings')" data-tooltip="Settings">
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
                <h2><i class="fas fa-store me-2 text-success"></i>Dashboard</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2">/</span>
                    <span class="active">Dashboard</span>
                </nav>
            </div>
            <div>
                <span class="text-muted">Welcome, <?= session()->get('full_name') ?? 'Store Owner' ?>!</span>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="main-content">
    <div class="container-fluid px-4">
        <!-- Dashboard Section -->
        <div id="dashboardSection" class="sections active">
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="dashboard-card">
                        <i class="fas fa-box card-icon text-success"></i>
                        <div class="card-number"><?= $totalProducts ?? 0 ?></div>
                        <div class="card-label">Total Products</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="dashboard-card">
                        <i class="fas fa-check-circle card-icon text-success"></i>
                        <div class="card-number"><?= $publishedProducts ?? 0 ?></div>
                        <div class="card-label">Published Products</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="dashboard-card">
                        <i class="fas fa-shopping-bag card-icon text-primary"></i>
                        <div class="card-number"><?= $totalOrders ?? 0 ?></div>
                        <div class="card-label">Total Orders</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="dashboard-card">
                        <i class="fas fa-dollar-sign card-icon text-success"></i>
                        <div class="card-number">$<?= number_format($revenue ?? 0, 2) ?></div>
                        <div class="card-label">Total Revenue</div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="/store/products/create" class="btn-add-product"><i class="fas fa-plus me-2"></i>Add New Product</a>
                    </div>
                </div>
            </div>

            <h5 class="fw-bold mb-3"><i class="fas fa-clock me-2 text-success"></i>Recent Orders</h5>
            <?php if (isset($recentOrders) && !empty($recentOrders)): ?>
                <?php foreach ($recentOrders as $order): ?>
                    <div class="order-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="order-number">#<?= $order['order_number'] ?></div>
                                <div class="order-date"><?= date('M d, Y', strtotime($order['created_at'])) ?></div>
                            </div>
                            <div>
                                <span class="status-badge status-<?= $order['order_status'] ?>"><?= ucfirst($order['order_status']) ?></span>
                            </div>
                            <div>
                                <span class="order-total">$<?= number_format($order['total_amount'], 2) ?></span>
                            </div>
                            <div>
                                <a href="#" class="btn btn-sm btn-outline-success">View</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">No orders yet.</p>
            <?php endif; ?>
        </div>

        <!-- Products Section -->
        <div id="productsSection" class="sections">
            <div class="bg-white rounded-3 p-4 border">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold"><i class="fas fa-box me-2 text-success"></i>My Products</h5>
                    <a href="/store/products/create" class="btn-add-product"><i class="fas fa-plus me-2"></i>Add Product</a>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($products) && !empty($products)): ?>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><strong><?= esc($product['product_name']) ?></strong></td>
                                        <td>$<?= number_format($product['price'], 2) ?></td>
                                        <td><?= $product['quantity'] ?></td>
                                        <td>
                                            <span class="status-badge status-<?= $product['status'] ?? 'draft' ?>">
                                                <?= ucfirst($product['status'] ?? 'Draft') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="/store/products/edit/<?= $product['id'] ?>" class="btn btn-sm btn-outline-success"><i class="fas fa-edit"></i></a>
                                            <a href="/store/products/toggle/<?= $product['id'] ?>" class="btn btn-sm btn-outline-warning" onclick="return confirm('Toggle status?')"><i class="fas fa-sync"></i></a>
                                            <a href="/store/products/delete/<?= $product['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this product?')"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No products yet.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <a href="/store/products" class="btn btn-success btn-sm">View All Products</a>
            </div>
        </div>

        <!-- Orders Section -->
        <div id="ordersSection" class="sections">
            <div class="bg-white rounded-3 p-4 border">
                <h5 class="fw-bold"><i class="fas fa-shopping-bag me-2 text-success"></i>All Orders</h5>
                <hr>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($orders) && !empty($orders)): ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td>#<?= $order['order_number'] ?></td>
                                        <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                                        <td>$<?= number_format($order['total_amount'], 2) ?></td>
                                        <td>
                                            <span class="status-badge status-<?= $order['order_status'] ?>">
                                                <?= ucfirst($order['order_status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-success">View</a>
                                            <a href="#" class="btn btn-sm btn-outline-warning">Update</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No orders found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Reports Section -->
        <div id="reportsSection" class="sections">
            <div class="bg-white rounded-3 p-4 border">
                <h5 class="fw-bold"><i class="fas fa-chart-line me-2 text-success"></i>Sales Reports</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="dashboard-card">
                            <i class="fas fa-calendar-day card-icon text-info"></i>
                            <div class="card-number">$0.00</div>
                            <div class="card-label">Today's Sales</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="dashboard-card">
                            <i class="fas fa-calendar-week card-icon text-success"></i>
                            <div class="card-number">$0.00</div>
                            <div class="card-label">This Week</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="dashboard-card">
                            <i class="fas fa-calendar-alt card-icon text-warning"></i>
                            <div class="card-number">$<?= number_format($revenue ?? 0, 2) ?></div>
                            <div class="card-label">This Month</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="dashboard-card">
                            <i class="fas fa-calendar-alt card-icon text-danger"></i>
                            <div class="card-number">$<?= number_format($revenue ?? 0, 2) ?></div>
                            <div class="card-label">Total Revenue</div>
                        </div>
                    </div>
                </div>
                <h6 class="mt-4">Best Selling Products</h6>
                <?php if (isset($bestSellers) && !empty($bestSellers)): ?>
                    <ul class="list-group">
                        <?php foreach ($bestSellers as $product): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= $product['product_name'] ?? 'Product' ?>
                                <span class="badge bg-success rounded-pill"><?= $product['total_sold'] ?? 0 ?> sold</span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">No sales data available.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- ✅ Settings Section (ከPassword Update ጋር) -->
        <div id="settingsSection" class="sections">
            <div class="bg-white rounded-3 p-4 border">
                <h5 class="fw-bold"><i class="fas fa-store-alt me-2 text-success"></i>Store Settings</h5>
                <hr>
                
                <!-- Store Information -->
                <form id="storeSettingsForm" onsubmit="return false;">
                    <div class="mb-3">
                        <label>Store Name</label>
                        <input type="text" class="form-control" value="<?= session()->get('store_name') ?? '' ?>" id="storeName">
                    </div>
                    <div class="mb-3">
                        <label>Store Description</label>
                        <textarea class="form-control" rows="3" id="storeDescription"><?= $tenant['store_description'] ?? '' ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Contact Email</label>
                        <input type="email" class="form-control" value="<?= $tenant['contact_email'] ?? '' ?>" id="contactEmail">
                    </div>
                    <div class="mb-3">
                        <label>Contact Phone</label>
                        <input type="tel" class="form-control" value="<?= $tenant['contact_phone'] ?? '' ?>" id="contactPhone">
                    </div>
                    <div class="mb-3">
                        <label>Store Address</label>
                        <textarea class="form-control" rows="2" id="storeAddress"><?= $tenant['store_address'] ?? '' ?></textarea>
                    </div>
                    <button type="button" class="btn-add-product" onclick="saveStoreSettings()">
                        <i class="fas fa-save me-2"></i>Save Settings
                    </button>
                </form>

                <hr>

                <!-- ✅ Password Update Section -->
                <h5 class="fw-bold mt-4"><i class="fas fa-key me-2 text-warning"></i>Update Password</h5>
                <p class="text-muted small">Change your account password. Use a strong password for security.</p>
                
                <form id="passwordForm" onsubmit="return false;">
                    <!-- Current Password -->
                    <div class="mb-3">
                        <label>Current Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="currentPassword" placeholder="Enter current password" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('currentPassword')">
                                <i class="fas fa-eye" id="currentPasswordIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- New Password -->
                    <div class="mb-3">
                        <label>New Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="newPassword" placeholder="Enter new password" required onkeyup="checkPasswordStrength(this.value)">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('newPassword')">
                                <i class="fas fa-eye" id="newPasswordIcon"></i>
                            </button>
                        </div>
                        <!-- Password Strength Indicator -->
                        <div class="password-strength" id="passwordStrength"></div>
                        <!-- Password Requirements -->
                        <div class="password-requirements" id="passwordRequirements">
                            <span id="reqLength" class="req-unmet"><i class="fas fa-circle"></i> At least 8 characters</span><br>
                            <span id="reqUppercase" class="req-unmet"><i class="fas fa-circle"></i> At least 1 uppercase letter</span><br>
                            <span id="reqLowercase" class="req-unmet"><i class="fas fa-circle"></i> At least 1 lowercase letter</span><br>
                            <span id="reqNumber" class="req-unmet"><i class="fas fa-circle"></i> At least 1 number</span><br>
                            <span id="reqSpecial" class="req-unmet"><i class="fas fa-circle"></i> At least 1 special character</span>
                        </div>
                    </div>

                    <!-- Confirm New Password -->
                    <div class="mb-3">
                        <label>Confirm New Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password" required onkeyup="checkPasswordMatch()">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmPassword')">
                                <i class="fas fa-eye" id="confirmPasswordIcon"></i>
                            </button>
                        </div>
                        <small id="passwordMatchMsg" class="text-muted"></small>
                    </div>

                    <button type="button" class="btn-add-product" style="background: #ffc107; color: #1a2e1a;" onclick="updatePassword()">
                        <i class="fas fa-key me-2"></i>Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- ✅ JavaScript for Password Update -->
<script>
    // ==========================================
    // 1. NOTIFICATION FUNCTION
    // ==========================================
    function showNotification(type, title, message) {
        const container = document.getElementById('notificationContainer');
        if (!container) return;
        
        const icons = { success: '✅', error: '❌', warning: '⚠️', info: 'ℹ️' };
        const icon = icons[type] || 'ℹ️';
        
        const now = new Date();
        const timeString = now.toLocaleTimeString();
        
        const toast = document.createElement('div');
        toast.className = 'notification-toast ' + (type === 'error' ? 'error' : type === 'warning' ? 'warning' : type === 'info' ? 'info' : '');
        toast.innerHTML = `
            <div class="notif-icon">${icon}</div>
            <div class="notif-content">
                <div class="notif-title">${title}</div>
                <div class="notif-message">${message}</div>
                <div class="notif-time">${timeString}</div>
            </div>
            <button class="notif-close" onclick="this.closest('.notification-toast').remove()">
                <i class="fas fa-times"></i>
            </button>
        `;
        container.appendChild(toast);
        
        setTimeout(() => {
            if (toast.parentNode) {
                toast.classList.add('removing');
                setTimeout(() => { if (toast.parentNode) toast.remove(); }, 300);
            }
        }, 6000);
    }

    // ==========================================
    // 2. TOGGLE PASSWORD VISIBILITY
    // ==========================================
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + 'Icon');
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // ==========================================
    // 3. CHECK PASSWORD STRENGTH
    // ==========================================
    function checkPasswordStrength(password) {
        const strengthBar = document.getElementById('passwordStrength');
        const reqLength = document.getElementById('reqLength');
        const reqUppercase = document.getElementById('reqUppercase');
        const reqLowercase = document.getElementById('reqLowercase');
        const reqNumber = document.getElementById('reqNumber');
        const reqSpecial = document.getElementById('reqSpecial');
        
        const hasLength = password.length >= 8;
        const hasUppercase = /[A-Z]/.test(password);
        const hasLowercase = /[a-z]/.test(password);
        const hasNumber = /[0-9]/.test(password);
        const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);
        
        updateRequirement(reqLength, hasLength);
        updateRequirement(reqUppercase, hasUppercase);
        updateRequirement(reqLowercase, hasLowercase);
        updateRequirement(reqNumber, hasNumber);
        updateRequirement(reqSpecial, hasSpecial);
        
        let strength = 0;
        if (hasLength) strength++;
        if (hasUppercase) strength++;
        if (hasLowercase) strength++;
        if (hasNumber) strength++;
        if (hasSpecial) strength++;
        
        strengthBar.className = 'password-strength';
        if (password.length === 0) {
            strengthBar.style.width = '0%';
            strengthBar.style.background = 'transparent';
        } else if (strength <= 2) {
            strengthBar.classList.add('weak');
            strengthBar.textContent = 'Weak';
        } else if (strength <= 3) {
            strengthBar.classList.add('medium');
            strengthBar.textContent = 'Medium';
        } else if (strength <= 4) {
            strengthBar.classList.add('strong');
            strengthBar.textContent = 'Strong';
        } else {
            strengthBar.classList.add('very-strong');
            strengthBar.textContent = 'Very Strong';
        }
        
        checkPasswordMatch();
    }

    function updateRequirement(element, met) {
        if (met) {
            element.className = 'req-met';
            element.innerHTML = '<i class="fas fa-check-circle"></i> ' + element.textContent.replace(/[✓✗]/g, '').trim();
        } else {
            element.className = 'req-unmet';
            element.innerHTML = '<i class="fas fa-circle"></i> ' + element.textContent.replace(/[✓✗]/g, '').trim();
        }
    }

    // ==========================================
    // 4. CHECK PASSWORD MATCH
    // ==========================================
    function checkPasswordMatch() {
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        const msg = document.getElementById('passwordMatchMsg');
        
        if (confirmPassword.length === 0) {
            msg.textContent = '';
            msg.className = 'text-muted';
            return;
        }
        
        if (newPassword === confirmPassword) {
            msg.textContent = '✅ Passwords match!';
            msg.className = 'text-success';
        } else {
            msg.textContent = '❌ Passwords do not match!';
            msg.className = 'text-danger';
        }
    }

    // ==========================================
    // 5. UPDATE PASSWORD
    // ==========================================
    function updatePassword() {
        const currentPassword = document.getElementById('currentPassword').value;
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        
        if (!currentPassword) {
            showNotification('error', '❌ Error', 'Please enter your current password.');
            document.getElementById('currentPassword').focus();
            return;
        }
        
        if (!newPassword || newPassword.length < 8) {
            showNotification('error', '❌ Error', 'Password must be at least 8 characters.');
            document.getElementById('newPassword').focus();
            return;
        }
        
        if (newPassword !== confirmPassword) {
            showNotification('error', '❌ Error', 'New passwords do not match!');
            document.getElementById('confirmPassword').focus();
            return;
        }
        
        const hasUppercase = /[A-Z]/.test(newPassword);
        const hasLowercase = /[a-z]/.test(newPassword);
        const hasNumber = /[0-9]/.test(newPassword);
        const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(newPassword);
        
        if (!hasUppercase || !hasLowercase || !hasNumber || !hasSpecial) {
            showNotification('warning', '⚠️ Weak Password', 'Please use a stronger password with uppercase, lowercase, number and special character.');
            return;
        }
        
        showNotification('success', '✅ Password Updated', 'Your password has been updated successfully!');
        
        document.getElementById('currentPassword').value = '';
        document.getElementById('newPassword').value = '';
        document.getElementById('confirmPassword').value = '';
        document.getElementById('passwordStrength').className = 'password-strength';
        document.getElementById('passwordStrength').style.width = '0%';
        document.getElementById('passwordMatchMsg').textContent = '';
        
        document.querySelectorAll('.password-requirements span').forEach(el => {
            el.className = 'req-unmet';
            el.innerHTML = '<i class="fas fa-circle"></i> ' + el.textContent.replace(/[✓✗]/g, '').trim();
        });
    }

    // ==========================================
    // 6. SAVE STORE SETTINGS
    // ==========================================
    function saveStoreSettings() {
        const storeName = document.getElementById('storeName').value;
        
        if (!storeName) {
            showNotification('error', '❌ Error', 'Please enter store name.');
            return;
        }
        
        showNotification('success', '✅ Store Settings Saved', 'Your store settings have been updated successfully!');
    }

    // ==========================================
    // 7. SIDEBAR FUNCTIONS
    // ==========================================
    function showSection(section) {
        document.querySelectorAll('.sections').forEach(function(el) {
            el.classList.remove('active');
        });

        var sectionMap = {
            'dashboard': 'dashboardSection',
            'products': 'productsSection',
            'orders': 'ordersSection',
            'reports': 'reportsSection',
            'settings': 'settingsSection'
        };
        var element = document.getElementById(sectionMap[section]);
        if (element) {
            element.classList.add('active');
        }

        document.querySelectorAll('.sidebar-menu li').forEach(function(item) {
            item.classList.remove('active');
        });
        var menuItems = document.querySelectorAll('.sidebar-menu li');
        var index = 0;
        if (section === 'dashboard') index = 0;
        else if (section === 'products') index = 1;
        else if (section === 'orders') index = 2;
        else if (section === 'reports') index = 3;
        else if (section === 'settings') index = 4;
        if (menuItems[index]) {
            menuItems[index].classList.add('active');
        }
    }

    function toggleSidebar() {
        var wrapper = document.getElementById('sidebarWrapper');
        var body = document.getElementById('mainBody');
        var toggleText = document.getElementById('toggleText');
        
        wrapper.classList.toggle('collapsed');
        body.classList.toggle('sidebar-collapsed');
        
        if (wrapper.classList.contains('collapsed')) {
            toggleText.textContent = 'Expand';
        } else {
            toggleText.textContent = 'Collapse';
        }
    }

    // ==========================================
    // 8. FLASH MESSAGES
    // ==========================================
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (session()->getFlashdata('success')): ?>
            showNotification('success', '✅ Success', '<?= session()->getFlashdata('success') ?>');
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            showNotification('error', '❌ Error', '<?= session()->getFlashdata('error') ?>');
        <?php endif; ?>
        <?php if (session()->getFlashdata('warning')): ?>
            showNotification('warning', '⚠️ Warning', '<?= session()->getFlashdata('warning') ?>');
        <?php endif; ?>
        <?php if (session()->getFlashdata('info')): ?>
            showNotification('info', 'ℹ️ Info', '<?= session()->getFlashdata('info') ?>');
        <?php endif; ?>
    });
</script>

</body>
</html>