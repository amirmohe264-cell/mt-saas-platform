<!-- app/Views/admin/request_details.php -->
<?php
// ✅ Check for admin session
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
    <title>Request Details - ShopEase</title>
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

        .detail-card {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            border: 1px solid #e8f0e8;
        }
        .detail-card .label {
            color: #888;
            font-weight: 500;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .detail-card .value {
            color: #1a2e1a;
            font-weight: 600;
            font-size: 1rem;
            margin-top: 3px;
        }
        .detail-card .value a {
            color: #4caf50;
            text-decoration: none;
        }
        .detail-card .value a:hover {
            text-decoration: underline;
        }

        .status-badge {
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-approved { background: #d4edda; color: #155724; }
        .status-rejected { background: #f8d7da; color: #721c24; }

        .btn-approve {
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 10px 30px;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-approve:hover { background: #1e7e34; color: #fff; }

        .btn-reject {
            background: #dc3545;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 10px 30px;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-reject:hover { background: #bd2130; color: #fff; }

        .btn-back {
            background: #6c757d;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 10px 30px;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-back:hover { background: #5a6268; color: #fff; }

        .detail-row {
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .detail-row:last-child {
            border-bottom: none;
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
            .detail-card { padding: 20px; }
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
            <li class="active" onclick="location.href='/admin/store-requests'" data-tooltip="Store Requests">
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
                <h2><i class="fas fa-info-circle me-2 text-success"></i>Request Details</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2">/</span>
                    <a href="/admin/dashboard">Dashboard</a>
                    <span class="mx-2">/</span>
                    <a href="/admin/store-requests">Store Requests</a>
                    <span class="mx-2">/</span>
                    <span class="text-muted">Details</span>
                </nav>
            </div>
            <div>
                <span class="status-badge <?= $request['status'] === 'pending' ? 'status-pending' : ($request['status'] === 'approved' ? 'status-approved' : 'status-rejected') ?>">
                    <i class="fas <?= $request['status'] === 'pending' ? 'fa-clock' : ($request['status'] === 'approved' ? 'fa-check-circle' : 'fa-times-circle') ?> me-1"></i>
                    <?= ucfirst($request['status']) ?>
                </span>
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

        <div class="detail-card">
            <div class="row">
                <div class="col-md-6">
                    <div class="detail-row">
                        <div class="label"><i class="fas fa-store me-1"></i>Store Name</div>
                        <div class="value"><?= esc($request['store_name']) ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-row">
                        <div class="label"><i class="fas fa-briefcase me-1"></i>Business Type</div>
                        <div class="value"><?= esc(ucfirst($request['business_type'] ?? 'Not specified')) ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-row">
                        <div class="label"><i class="fas fa-user me-1"></i>Owner Name</div>
                        <div class="value"><?= esc($request['owner_name']) ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-row">
                        <div class="label"><i class="fas fa-envelope me-1"></i>Owner Email</div>
                        <div class="value"><?= esc($request['owner_email']) ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-row">
                        <div class="label"><i class="fas fa-phone me-1"></i>Phone Number</div>
                        <div class="value"><?= esc($request['owner_phone']) ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-row">
                        <div class="label"><i class="fas fa-calendar me-1"></i>Submitted On</div>
                        <div class="value"><?= date('F d, Y H:i A', strtotime($request['created_at'])) ?></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="detail-row">
                        <div class="label"><i class="fas fa-map-marker-alt me-1"></i>Store Address</div>
                        <div class="value"><?= esc($request['store_address']) ?></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="detail-row">
                        <div class="label"><i class="fas fa-align-left me-1"></i>Store Description</div>
                        <div class="value"><?= esc($request['store_description'] ?? 'No description provided.') ?></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="detail-row">
                        <div class="label"><i class="fas fa-file-alt me-1"></i>Legal Documents</div>
                        <div class="value">
                            <?php if (!empty($request['legal_documents'])): ?>
                                <a href="/<?= $request['legal_documents'] ?>" target="_blank" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-file-pdf me-1"></i>View Document
                                </a>
                            <?php else: ?>
                                <span class="text-muted"><i class="fas fa-times-circle me-1"></i>No document uploaded</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($request['status'] === 'pending'): ?>
                <hr>
                <div class="d-flex flex-wrap gap-3 mt-3">
                    <a href="/admin/store-request/approve/<?= $request['id'] ?>" class="btn-approve" onclick="return confirm('Are you sure you want to approve this store request?\n\nThis will create a new store and send a welcome email to the owner.')">
                        <i class="fas fa-check me-2"></i>Approve
                    </a>
                    <a href="/admin/store-request/reject/<?= $request['id'] ?>" class="btn-reject" onclick="return confirm('Are you sure you want to reject this store request?\n\nThe owner will be notified via email.')">
                        <i class="fas fa-times me-2"></i>Reject
                    </a>
                    <a href="/admin/store-requests" class="btn-back"><i class="fas fa-arrow-left me-2"></i>Back to Requests</a>
                </div>
            <?php else: ?>
                <hr>
                <div class="mt-3">
                    <a href="/admin/store-requests" class="btn-back"><i class="fas fa-arrow-left me-2"></i>Back to Requests</a>
                </div>
            <?php endif; ?>
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