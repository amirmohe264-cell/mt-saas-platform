<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard - ShopEase</title>
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
        .sidebar-wrapper.collapsed .user-name {
            display: none;
        }
        .sidebar-wrapper.collapsed .user-email {
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
        .sidebar-wrapper.collapsed .user-avatar {
            width: 45px;
            height: 45px;
            font-size: 1.2rem;
        }

        /* Body padding when collapsed */
        body.sidebar-collapsed {
            padding-left: 70px;
        }

        .sidebar-card .user-avatar {
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
        .sidebar-card .user-name {
            text-align: center;
            font-weight: 700;
            color: #1a2e1a;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .sidebar-card .user-email {
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
            .sidebar-wrapper.collapsed .user-name {
                display: block;
            }
            .sidebar-wrapper.collapsed .user-email {
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
                <li class="nav-item"><a class="nav-link active" href="#">My Dashboard</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <a href="/cart" class="icon-btn" style="color:#d4d4d4;text-decoration:none;position:relative;">
                    <i class="fas fa-shopping-cart"></i>
                </a>
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

        <div class="user-avatar">
            <i class="fas fa-user"></i>
        </div>
        <div class="user-name"><?= session()->get('full_name') ?? 'Customer' ?></div>
        <div class="user-email"><?= session()->get('email') ?? 'customer@example.com' ?></div>

        <!-- ACCOUNT -->
        <div class="sidebar-category">Account</div>
        <ul class="sidebar-menu">
            <li class="active" onclick="showSection('dashboard')" data-tooltip="Dashboard">
                <i class="fas fa-tachometer-alt"></i>
                <span class="menu-text">Dashboard</span>
            </li>
            <li onclick="showSection('profile')" data-tooltip="Profile">
                <i class="fas fa-user-cog"></i>
                <span class="menu-text">My Profile</span>
            </li>
            <li onclick="showSection('orders')" data-tooltip="Orders">
                <i class="fas fa-shopping-bag"></i>
                <span class="menu-text">My Orders</span>
            </li>
        </ul>

        <!-- ADDRESSES -->
        <div class="sidebar-category">Addresses</div>
        <ul class="sidebar-menu">
            <li onclick="showSection('addresses')" data-tooltip="Addresses">
                <i class="fas fa-address-book"></i>
                <span class="menu-text">Saved Addresses</span>
            </li>
        </ul>

        <!-- SETTINGS -->
        <div class="sidebar-category">Settings</div>
        <ul class="sidebar-menu">
            <li onclick="showSection('settings')" data-tooltip="Settings">
                <i class="fas fa-cog"></i>
                <span class="menu-text">Account Settings</span>
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
                <h2><i class="fas fa-tachometer-alt me-2 text-success"></i>My Dashboard</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2">/</span>
                    <span class="active">Dashboard</span>
                </nav>
            </div>
            <div>
                <span class="text-muted">Welcome back, <?= session()->get('full_name') ?? 'Customer' ?>!</span>
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
                <div class="col-md-4 mb-3">
                    <div class="dashboard-card">
                        <i class="fas fa-shopping-bag card-icon text-primary"></i>
                        <div class="card-number">12</div>
                        <div class="card-label">Total Orders</div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="dashboard-card">
                        <i class="fas fa-dollar-sign card-icon text-success"></i>
                        <div class="card-number">$1,247</div>
                        <div class="card-label">Total Spent</div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="dashboard-card">
                        <i class="fas fa-heart card-icon text-danger"></i>
                        <div class="card-number">8</div>
                        <div class="card-label">Wishlist Items</div>
                    </div>
                </div>
            </div>

            <h5 class="fw-bold mb-3"><i class="fas fa-clock me-2 text-success"></i>Recent Orders</h5>
            
            <div class="order-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="order-number">#ORD-2026-08-07-001</div>
                        <div class="order-date">August 7, 2026</div>
                    </div>
                    <div><span class="status-badge status-pending">Pending</span></div>
                    <div><span class="order-total">$317.11</span></div>
                    <div><a href="#" class="btn btn-sm btn-outline-success">View Details</a></div>
                </div>
            </div>
            <div class="order-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="order-number">#ORD-2026-08-05-002</div>
                        <div class="order-date">August 5, 2026</div>
                    </div>
                    <div><span class="status-badge status-delivered">Delivered</span></div>
                    <div><span class="order-total">$129.99</span></div>
                    <div><a href="#" class="btn btn-sm btn-outline-success">View Details</a></div>
                </div>
            </div>
            <div class="order-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="order-number">#ORD-2026-08-03-003</div>
                        <div class="order-date">August 3, 2026</div>
                    </div>
                    <div><span class="status-badge status-processing">Processing</span></div>
                    <div><span class="order-total">$199.00</span></div>
                    <div><a href="#" class="btn btn-sm btn-outline-success">View Details</a></div>
                </div>
            </div>
        </div>

        <!-- Profile Section -->
        <div id="profileSection" class="sections">
            <div class="bg-white rounded-3 p-4 border">
                <h5 class="fw-bold"><i class="fas fa-user-cog me-2 text-success"></i>My Profile</h5>
                <hr>
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>First Name</label>
                            <input type="text" class="form-control" value="John">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Last Name</label>
                            <input type="text" class="form-control" value="Doe">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Email Address</label>
                        <input type="email" class="form-control" value="john@example.com">
                    </div>
                    <div class="mb-3">
                        <label>Phone Number</label>
                        <input type="tel" class="form-control" value="+1 234 567 890">
                    </div>
                    <button type="submit" class="btn-add-product"><i class="fas fa-save me-2"></i>Update Profile</button>
                </form>
            </div>
        </div>

        <!-- Orders Section -->
        <div id="ordersSection" class="sections">
            <div class="bg-white rounded-3 p-4 border">
                <h5 class="fw-bold"><i class="fas fa-shopping-bag me-2 text-success"></i>My Orders</h5>
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
                            <tr>
                                <td>#ORD-2026-08-07-001</td>
                                <td>Aug 7, 2026</td>
                                <td>$317.11</td>
                                <td><span class="status-badge status-pending">Pending</span></td>
                                <td><a href="#" class="btn btn-sm btn-outline-success">View</a></td>
                            </tr>
                            <tr>
                                <td>#ORD-2026-08-05-002</td>
                                <td>Aug 5, 2026</td>
                                <td>$129.99</td>
                                <td><span class="status-badge status-delivered">Delivered</span></td>
                                <td><a href="#" class="btn btn-sm btn-outline-success">View</a></td>
                            </tr>
                            <tr>
                                <td>#ORD-2026-08-03-003</td>
                                <td>Aug 3, 2026</td>
                                <td>$199.00</td>
                                <td><span class="status-badge status-processing">Processing</span></td>
                                <td><a href="#" class="btn btn-sm btn-outline-success">View</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Addresses Section -->
        <div id="addressesSection" class="sections">
            <div class="bg-white rounded-3 p-4 border">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold"><i class="fas fa-address-book me-2 text-success"></i>Saved Addresses</h5>
                    <button class="btn-add-product"><i class="fas fa-plus me-2"></i>Add Address</button>
                </div>
                <hr>
                <div class="p-3 border rounded-3 mb-3">
                    <h6>Home Address</h6>
                    <p class="mb-1">123 Main Street</p>
                    <p class="mb-1">New York, NY 10001</p>
                    <p class="mb-1">Phone: +1 234 567 890</p>
                    <button class="btn btn-sm btn-outline-success">Edit</button>
                    <button class="btn btn-sm btn-outline-danger">Remove</button>
                </div>
                <div class="p-3 border rounded-3">
                    <h6>Work Address</h6>
                    <p class="mb-1">456 Business Ave</p>
                    <p class="mb-1">New York, NY 10002</p>
                    <p class="mb-1">Phone: +1 987 654 321</p>
                    <button class="btn btn-sm btn-outline-success">Edit</button>
                    <button class="btn btn-sm btn-outline-danger">Remove</button>
                </div>
            </div>
        </div>

        <!-- Settings Section -->
        <div id="settingsSection" class="sections">
            <div class="bg-white rounded-3 p-4 border">
                <h5 class="fw-bold"><i class="fas fa-cog me-2 text-success"></i>Account Settings</h5>
                <hr>
                <form>
                    <div class="mb-3">
                        <label>Current Password</label>
                        <input type="password" class="form-control" placeholder="Enter current password">
                    </div>
                    <div class="mb-3">
                        <label>New Password</label>
                        <input type="password" class="form-control" placeholder="Enter new password">
                    </div>
                    <div class="mb-3">
                        <label>Confirm New Password</label>
                        <input type="password" class="form-control" placeholder="Confirm new password">
                    </div>
                    <button type="submit" class="btn-add-product"><i class="fas fa-save me-2"></i>Change Password</button>
                </form>
                <hr>
                <h6>Notification Preferences</h6>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="emailNotif" checked>
                    <label class="form-check-label" for="emailNotif">Order Updates via Email</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="promoNotif">
                    <label class="form-check-label" for="promoNotif">Promotional Emails</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="smsNotif" checked>
                    <label class="form-check-label" for="smsNotif">Order Updates via SMS</label>
                </div>
                <button class="btn-add-product mt-3"><i class="fas fa-save me-2"></i>Save Preferences</button>
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
            'profile': 'profileSection',
            'orders': 'ordersSection',
            'addresses': 'addressesSection',
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
        else if (section === 'profile') index = 1;
        else if (section === 'orders') index = 2;
        else if (section === 'addresses') index = 3;
        else if (section === 'settings') index = 4;
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