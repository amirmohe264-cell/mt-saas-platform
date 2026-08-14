<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ShopEase</title>
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

        /* ========================================== */
        /* SIDEBAR COLLAPSED (ICONS ONLY) */
        /* ========================================== */
        .sidebar-wrapper.collapsed {
            width: 70px;
        }
        .sidebar-wrapper.collapsed .admin-name {
            display: none;
        }
        .sidebar-wrapper.collapsed .admin-role {
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
        .sidebar-wrapper.collapsed .admin-avatar {
            width: 45px;
            height: 45px;
            font-size: 1.2rem;
        }

        /* Body padding when collapsed */
        body.sidebar-collapsed {
            padding-left: 70px;
        }

        .sidebar-card .admin-avatar {
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
        .sidebar-card .admin-name {
            text-align: center;
            font-weight: 700;
            color: #1a2e1a;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .sidebar-card .admin-role {
            text-align: center;
            color: #888;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }

        /* ========================================== */
        /* TOGGLE BUTTON */
        /* ========================================== */
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

        .activity-item {
            background: #fff;
            border-radius: 12px;
            padding: 15px 20px;
            border: 1px solid #e8f0e8;
            margin-bottom: 12px;
            transition: 0.3s;
        }
        .activity-item:hover {
            border-color: #4caf50;
        }
        .activity-item .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }
        .activity-item .activity-icon.success {
            background: #e8f5e9;
            color: #4caf50;
        }
        .activity-item .activity-icon.warning {
            background: #fff3e0;
            color: #ff9800;
        }
        .activity-item .activity-icon.info {
            background: #e3f2fd;
            color: #2196f3;
        }
        .activity-item .activity-icon.danger {
            background: #fce4ec;
            color: #dc3545;
        }
        .activity-item .activity-text {
            color: #1a2e1a;
            font-weight: 500;
        }
        .activity-item .activity-time {
            color: #888;
            font-size: 0.85rem;
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
        .btn-add:hover {
            background: #388e3c;
            color: #fff;
        }

        .footer {
            background: #1a2e1a;
            color: #d4d4d4;
            padding: 40px 0 20px;
            margin-top: 40px;
        }
        .footer h5 {
            color: #fff;
            font-weight: 600;
        }
        .footer a {
            color: #aaa;
            text-decoration: none;
            transition: 0.3s;
        }
        .footer a:hover {
            color: #4caf50;
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
            .sidebar-wrapper.collapsed .admin-name {
                display: block;
            }
            .sidebar-wrapper.collapsed .admin-role {
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
                <li class="nav-item"><a class="nav-link active" href="#">Admin Dashboard</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <span class="text-white me-3 d-none d-md-inline"><i class="fas fa-shield-alt me-1"></i>Super Admin</span>
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
            <span id="toggleText">Collapse</span>
        </button>

        <div class="admin-avatar">
            <i class="fas fa-user-shield"></i>
        </div>
        <div class="admin-name"><?= session()->get('full_name') ?? 'Super Admin' ?></div>
        <div class="admin-role"><span class="badge bg-success">Super Admin</span></div>

        <!-- MANAGEMENT -->
        <div class="sidebar-category">Management</div>
        <ul class="sidebar-menu">
            <li class="active" onclick="showSection('dashboard')" data-tooltip="Dashboard">
                <i class="fas fa-tachometer-alt"></i>
                <span class="menu-text">Dashboard</span>
            </li>
            <li onclick="showSection('stores')" data-tooltip="Stores">
                <i class="fas fa-store"></i>
                <span class="menu-text">Stores</span>
            </li>
            <li onclick="showSection('store-requests')" data-tooltip="Store Requests">
                <i class="fas fa-store"></i>
                <span class="menu-text">Store Requests</span>
            </li>
            <li onclick="showSection('categories')" data-tooltip="Categories">
                <i class="fas fa-tags"></i>
                <span class="menu-text">Categories</span>
            </li>
            <li onclick="showSection('users')" data-tooltip="Users">
                <i class="fas fa-users"></i>
                <span class="menu-text">Users</span>
            </li>
        </ul>

        <!-- ORDERS & PRODUCTS -->
        <div class="sidebar-category">Orders & Products</div>
        <ul class="sidebar-menu">
            <li onclick="showSection('orders')" data-tooltip="Orders">
                <i class="fas fa-shopping-bag"></i>
                <span class="menu-text">Orders</span>
            </li>
            <li onclick="showSection('products')" data-tooltip="Products">
                <i class="fas fa-box"></i>
                <span class="menu-text">Products</span>
            </li>
        </ul>

        <!-- FINANCE -->
        <div class="sidebar-category">Finance</div>
        <ul class="sidebar-menu">
            <li onclick="showSection('payments')" data-tooltip="Payments">
                <i class="fas fa-credit-card"></i>
                <span class="menu-text">Payments</span>
            </li>
            <li onclick="showSection('analytics')" data-tooltip="Analytics">
                <i class="fas fa-chart-bar"></i>
                <span class="menu-text">Analytics</span>
            </li>
        </ul>

        <!-- SETTINGS -->
        <div class="sidebar-category">Settings</div>
        <ul class="sidebar-menu">
            <li onclick="showSection('settings')" data-tooltip="Settings">
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
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-shield-alt me-2 text-success"></i>Admin Dashboard</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2">/</span>
                    <span class="active">Admin Dashboard</span>
                </nav>
            </div>
            <div>
                <span class="text-muted">Welcome, <?= session()->get('full_name') ?? 'Super Admin' ?>!</span>
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
                        <i class="fas fa-store card-icon text-success"></i>
                        <div class="card-number">24</div>
                        <div class="card-label">Total Stores</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="dashboard-card">
                        <i class="fas fa-check-circle card-icon text-success"></i>
                        <div class="card-number">18</div>
                        <div class="card-label">Active Stores</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="dashboard-card">
                        <i class="fas fa-users card-icon text-primary"></i>
                        <div class="card-number">1,247</div>
                        <div class="card-label">Total Customers</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="dashboard-card">
                        <i class="fas fa-dollar-sign card-icon text-success"></i>
                        <div class="card-number">$45,230</div>
                        <div class="card-label">Platform Revenue</div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="dashboard-card">
                        <i class="fas fa-box card-icon text-warning"></i>
                        <div class="card-number">3,891</div>
                        <div class="card-label">Total Products</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="dashboard-card">
                        <i class="fas fa-shopping-bag card-icon text-primary"></i>
                        <div class="card-number">312</div>
                        <div class="card-label">Total Orders</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="dashboard-card">
                        <i class="fas fa-exclamation-triangle card-icon text-danger"></i>
                        <div class="card-number">3</div>
                        <div class="card-label">Suspended Stores</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="dashboard-card">
                        <i class="fas fa-user-plus card-icon text-success"></i>
                        <div class="card-number">87</div>
                        <div class="card-label">New Customers (This Month)</div>
                    </div>
                </div>
            </div>

            <h5 class="fw-bold mb-3"><i class="fas fa-clock me-2 text-success"></i>Recent Activity</h5>

            <div class="activity-item">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="activity-icon success"><i class="fas fa-store"></i></span>
                        <div>
                            <div class="activity-text">New store registered: "FashionHub"</div>
                            <div class="activity-time">2 hours ago</div>
                        </div>
                    </div>
                    <span class="badge bg-success">Approved</span>
                </div>
            </div>
            <div class="activity-item">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="activity-icon warning"><i class="fas fa-exclamation-triangle"></i></span>
                        <div>
                            <div class="activity-text">Store "GadgetWorld" flagged for review</div>
                            <div class="activity-time">5 hours ago</div>
                        </div>
                    </div>
                    <span class="badge bg-warning text-dark">Pending</span>
                </div>
            </div>
            <div class="activity-item">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="activity-icon info"><i class="fas fa-user"></i></span>
                        <div>
                            <div class="activity-text">New customer registered: james@example.com</div>
                            <div class="activity-time">12 hours ago</div>
                        </div>
                    </div>
                    <span class="badge bg-info text-white">New</span>
                </div>
            </div>
            <div class="activity-item">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="activity-icon danger"><i class="fas fa-ban"></i></span>
                        <div>
                            <div class="activity-text">Store "HomeDecor" suspended for policy violation</div>
                            <div class="activity-time">2 days ago</div>
                        </div>
                    </div>
                    <span class="badge bg-danger">Suspended</span>
                </div>
            </div>
        </div>

        <!-- Stores Section -->
        <div id="storesSection" class="sections">
            <div class="bg-white rounded-3 p-4 border">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold"><i class="fas fa-store me-2 text-success"></i>All Stores</h5>
                    <a href="/admin/store/create" class="btn-add"><i class="fas fa-plus me-2"></i>Add Store</a>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Store Name</th>
                                <th>Owner</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>TechHub Store</td>
                                <td>John Doe</td>
                                <td>john@techhub.com</td>
                                <td><span class="status-badge status-active">Active</span></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-success"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-warning"><i class="fas fa-ban"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>FashionHub</td>
                                <td>Sarah Smith</td>
                                <td>sarah@fashionhub.com</td>
                                <td><span class="status-badge status-pending">Pending</span></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-success"><i class="fas fa-check"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-danger"><i class="fas fa-times"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <a href="/admin/stores" class="btn btn-success btn-sm">View All Stores</a>
            </div>
        </div>

        <!-- Store Requests Section -->
        <div id="store-requestsSection" class="sections">
            <div class="bg-white rounded-3 p-4 border">
                <h5 class="fw-bold"><i class="fas fa-store me-2 text-success"></i>Store Requests</h5>
                <hr>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Store Name</th>
                                <th>Owner</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($pendingRequests) && !empty($pendingRequests)): ?>
                                <?php foreach ($pendingRequests as $request): ?>
                                    <tr>
                                        <td><?= esc($request['store_name']) ?></td>
                                        <td><?= esc($request['owner_name']) ?></td>
                                        <td><?= esc($request['owner_email']) ?></td>
                                        <td><span class="status-badge status-pending">Pending</span></td>
                                        <td>
                                            <a href="/admin/store-request/<?= $request['id'] ?>" class="btn btn-sm btn-outline-success">View</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No pending store requests.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <a href="/admin/store-requests" class="btn btn-success btn-sm">View All Requests</a>
            </div>
        </div>

        <!-- Categories Section -->
        <div id="categoriesSection" class="sections">
            <div class="bg-white rounded-3 p-4 border">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold"><i class="fas fa-tags me-2 text-success"></i>Global Categories</h5>
                    <a href="/admin/categories/create" class="btn-add"><i class="fas fa-plus me-2"></i>Add Category</a>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Products</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Electronics</td>
                                <td>Gadgets, computers & more</td>
                                <td>120</td>
                                <td><span class="status-badge status-active">Active</span></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-success"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-warning"><i class="fas fa-sync"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <a href="/admin/categories" class="btn btn-success btn-sm">View All Categories</a>
            </div>
        </div>

        <!-- Users Section -->
        <div id="usersSection" class="sections">
            <div class="bg-white rounded-3 p-4 border">
                <h5 class="fw-bold"><i class="fas fa-users me-2 text-success"></i>All Users</h5>
                <hr>
                <ul class="nav nav-tabs" id="userTabs">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#customers">Customers</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#storeOwners">Store Owners</a></li>
                </ul>
                <div class="tab-content mt-3">
                    <div class="tab-pane active" id="customers">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Orders</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>John Doe</td>
                                        <td>john@example.com</td>
                                        <td>12</td>
                                        <td><span class="status-badge status-active">Active</span></td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-warning"><i class="fas fa-ban"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="storeOwners">
                        <div class="table-responsive">
                            <table class="table">
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
                                    <tr>
                                        <td>John Doe</td>
                                        <td>john@techhub.com</td>
                                        <td>TechHub Store</td>
                                        <td><span class="status-badge status-active">Active</span></td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-warning"><i class="fas fa-ban"></i></a>
                                            <a href="#" class="btn btn-sm btn-outline-info"><i class="fas fa-key"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
                                <th>Customer</th>
                                <th>Store</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#ORD-2026-08-07-001</td>
                                <td>John Doe</td>
                                <td>TechHub Store</td>
                                <td>Aug 7, 2026</td>
                                <td>$317.11</td>
                                <td><span class="status-badge status-pending">Pending</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div id="productsSection" class="sections">
            <div class="bg-white rounded-3 p-4 border">
                <h5 class="fw-bold"><i class="fas fa-box me-2 text-success"></i>All Products</h5>
                <hr>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Store</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Wireless Earbuds Pro</td>
                                <td>TechHub Store</td>
                                <td>Electronics</td>
                                <td>$89.99</td>
                                <td><span class="status-badge status-active">Published</span></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Payments Section -->
        <div id="paymentsSection" class="sections">
            <div class="bg-white rounded-3 p-4 border">
                <h5 class="fw-bold"><i class="fas fa-credit-card me-2 text-success"></i>Payment Gateways</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="p-3 border rounded-3">
                            <h6><i class="fas fa-money-bill-wave text-success me-2"></i>Cash on Delivery</h6>
                            <p class="text-muted">Status: <span class="badge bg-success">Enabled</span></p>
                            <button class="btn btn-sm btn-outline-danger">Disable</button>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="p-3 border rounded-3">
                            <h6><i class="fas fa-credit-card text-primary me-2"></i>Stripe</h6>
                            <p class="text-muted">Status: <span class="badge bg-success">Enabled</span></p>
                            <button class="btn btn-sm btn-outline-danger">Disable</button>
                            <button class="btn btn-sm btn-outline-success">Configure</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics Section -->
        <div id="analyticsSection" class="sections">
            <div class="bg-white rounded-3 p-4 border">
                <h5 class="fw-bold"><i class="fas fa-chart-bar me-2 text-success"></i>Platform Analytics</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="dashboard-card">
                            <i class="fas fa-chart-line card-icon text-primary"></i>
                            <div class="card-number">+23%</div>
                            <div class="card-label">Customer Growth (This Month)</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="dashboard-card">
                            <i class="fas fa-chart-pie card-icon text-success"></i>
                            <div class="card-number">+15%</div>
                            <div class="card-label">Product Growth (This Month)</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="dashboard-card">
                            <i class="fas fa-dollar-sign card-icon text-warning"></i>
                            <div class="card-number">$45,230</div>
                            <div class="card-label">Total Platform Revenue</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="dashboard-card">
                            <i class="fas fa-shopping-cart card-icon text-danger"></i>
                            <div class="card-number">312</div>
                            <div class="card-label">Total Orders</div>
                        </div>
                    </div>
                </div>
                <h6 class="mt-4">Top Performing Stores</h6>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        TechHub Store
                        <span class="badge bg-success rounded-pill">$12,450 revenue</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        FashionHub
                        <span class="badge bg-success rounded-pill">$8,230 revenue</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Settings Section -->
        <div id="settingsSection" class="sections">
            <div class="bg-white rounded-3 p-4 border">
                <h5 class="fw-bold"><i class="fas fa-cog me-2 text-success"></i>System Settings</h5>
                <hr>
                <form>
                    <div class="mb-3">
                        <label>Platform Name</label>
                        <input type="text" class="form-control" value="ShopEase">
                    </div>
                    <div class="mb-3">
                        <label>Platform Email</label>
                        <input type="email" class="form-control" value="admin@shopease.com">
                    </div>
                    <div class="mb-3">
                        <label>Default Currency</label>
                        <select class="form-control">
                            <option value="USD">USD - US Dollar</option>
                            <option value="EUR">EUR - Euro</option>
                            <option value="GBP">GBP - British Pound</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Default Language</label>
                        <select class="form-control">
                            <option value="en">English</option>
                            <option value="es">Spanish</option>
                            <option value="fr">French</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-add"><i class="fas fa-save me-2"></i>Save Settings</button>
                </form>
            </div>
        </div>
    </div>
</section>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function showSection(section) {
        // Hide all sections
        document.querySelectorAll('.sections').forEach(function(el) {
            el.classList.remove('active');
        });

        // Show selected section
        var sectionMap = {
            'dashboard': 'dashboardSection',
            'stores': 'storesSection',
            'store-requests': 'store-requestsSection',
            'categories': 'categoriesSection',
            'users': 'usersSection',
            'orders': 'ordersSection',
            'products': 'productsSection',
            'payments': 'paymentsSection',
            'analytics': 'analyticsSection',
            'settings': 'settingsSection'
        };
        var element = document.getElementById(sectionMap[section]);
        if (element) {
            element.classList.add('active');
        }

        // Update sidebar active state
        document.querySelectorAll('.sidebar-menu li').forEach(function(item) {
            item.classList.remove('active');
        });
        var menuItems = document.querySelectorAll('.sidebar-menu li');
        var index = 0;
        if (section === 'dashboard') index = 0;
        else if (section === 'stores') index = 1;
        else if (section === 'store-requests') index = 2;
        else if (section === 'categories') index = 3;
        else if (section === 'users') index = 4;
        else if (section === 'orders') index = 5;
        else if (section === 'products') index = 6;
        else if (section === 'payments') index = 7;
        else if (section === 'analytics') index = 8;
        else if (section === 'settings') index = 9;
        menuItems[index].classList.add('active');
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
</script>
</body>
</html>