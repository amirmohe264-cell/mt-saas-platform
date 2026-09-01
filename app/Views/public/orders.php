Orders fixed · PHP
<!-- app/Views/public/orders.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; overflow: hidden; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            padding-left: 280px;
            padding-top: 80px;
            transition: padding-left 0.3s ease;
            height: 100vh;
            overflow: hidden;
        }
 
        .notification-container { position: fixed; top: 90px; right: 20px; z-index: 9999; max-width: 380px; width: 100%; }
        .notification-toast { background: #fff; border-radius: 12px; padding: 15px 20px; margin-bottom: 10px; box-shadow: 0 5px 25px rgba(0,0,0,0.15); border-left: 4px solid #4caf50; animation: slideInRight 0.4s ease; display: flex; align-items: flex-start; gap: 12px; }
        .notification-toast.error { border-left-color: #dc3545; }
        .notification-toast.warning { border-left-color: #ffc107; }
        .notification-toast.info { border-left-color: #17a2b8; }
        .notification-toast .notif-icon { font-size: 1.3rem; margin-top: 2px; }
        .notification-toast .notif-content { flex: 1; }
        .notification-toast .notif-title { font-weight: 600; color: #1a2e1a; font-size: 0.9rem; }
        .notification-toast .notif-message { color: #555; font-size: 0.85rem; }
        .notification-toast .notif-close { background: none; border: none; color: #aaa; cursor: pointer; font-size: 1rem; padding: 0 5px; }
        .notification-toast .notif-close:hover { color: #333; }
        .notification-toast.removing { animation: slideOutRight 0.3s ease forwards; }
        @keyframes slideInRight { from { transform: translateX(100px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes slideOutRight { from { transform: translateX(0); opacity: 1; } to { transform: translateX(100px); opacity: 0; } }
 
        .navbar { background: #1a2e1a !important; padding: 12px 0; box-shadow: 0 2px 20px rgba(0,0,0,0.3); position: fixed; top: 0; left: 0; right: 0; z-index: 1050; height: 70px; }
        .navbar-brand { color: #fff !important; font-weight: bold; font-size: 1.4rem; }
        .navbar-brand i { color: #4caf50; }
        .navbar .nav-link { color: #d4d4d4 !important; font-weight: 500; transition: 0.3s; font-size: 0.95rem; }
        .navbar .nav-link:hover { color: #4caf50 !important; }
        .icon-btn { color: #d4d4d4; font-size: 1.1rem; margin: 0 6px; transition: 0.3s; background: none; border: none; }
        .icon-btn:hover { color: #4caf50; transform: scale(1.1); }
        .navbar-toggler { border-color: #4caf50; }
        .navbar-toggler-icon { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(76, 175, 80, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e"); }
 
        .sidebar-wrapper { position: fixed; top: 70px; left: 0; width: 280px; height: calc(100vh - 70px); overflow-y: auto; background: #fff; border-right: 1px solid #e8f0e8; padding: 15px 15px; z-index: 1000; transition: width 0.3s ease; }
        .sidebar-wrapper::-webkit-scrollbar { width: 4px; }
        .sidebar-wrapper::-webkit-scrollbar-thumb { background: #4caf50; border-radius: 4px; }
        .sidebar-wrapper::-webkit-scrollbar-track { background: #e8f0e8; }
        .sidebar-wrapper.collapsed { width: 70px; }
        .sidebar-wrapper.collapsed .user-name { display: none; }
        .sidebar-wrapper.collapsed .user-email { display: none; }
        .sidebar-wrapper.collapsed .sidebar-category { display: none; }
        .sidebar-wrapper.collapsed .sidebar-menu li { padding: 8px; justify-content: center; }
        .sidebar-wrapper.collapsed .sidebar-menu li .menu-text { display: none; }
        .sidebar-wrapper.collapsed .sidebar-menu li i { margin-right: 0; font-size: 1.1rem; }
        .sidebar-wrapper.collapsed .sidebar-menu li:hover::after { content: attr(data-tooltip); position: absolute; left: 100%; top: 50%; transform: translateY(-50%); background: #1a2e1a; color: #fff; padding: 5px 12px; border-radius: 6px; font-size: 0.8rem; white-space: nowrap; z-index: 999; box-shadow: 0 2px 10px rgba(0,0,0,0.2); margin-left: 8px; }
        .sidebar-wrapper.collapsed .user-avatar { width: 40px; height: 40px; font-size: 1rem; }
        body.sidebar-collapsed { padding-left: 70px; }
 
        .sidebar-card .user-avatar { width: 60px; height: 60px; border-radius: 50%; background: #4caf50; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 8px; transition: all 0.3s ease; }
        .sidebar-card .user-name { text-align: center; font-weight: 700; color: #1a2e1a; font-size: 0.95rem; transition: all 0.3s ease; }
        .sidebar-card .user-email { text-align: center; color: #888; font-size: 0.75rem; transition: all 0.3s ease; }
 
        .toggle-sidebar-btn { background: #4caf50; color: #fff; border: none; border-radius: 8px; padding: 6px 12px; font-size: 0.9rem; transition: 0.3s; cursor: pointer; width: 100%; margin-bottom: 8px; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .toggle-sidebar-btn:hover { background: #388e3c; }
 
        .sidebar-category { font-size: 0.6rem; font-weight: 700; color: #aaa; text-transform: uppercase; letter-spacing: 0.5px; padding: 10px 10px 3px; border-top: 1px solid #f0f0f0; margin-top: 5px; transition: all 0.3s ease; }
        .sidebar-category:first-child { border-top: none; margin-top: 0; padding-top: 3px; }
 
        .sidebar-menu { list-style: none; padding: 0; margin: 0; }
        .sidebar-menu li { padding: 8px 12px; border-radius: 8px; transition: 0.3s; cursor: pointer; color: #555; font-size: 0.85rem; display: flex; align-items: center; transition: all 0.3s ease; position: relative; }
        .sidebar-menu li:hover { background: #f0f8f0; color: #4caf50; }
        .sidebar-menu li.active { background: #f0f8f0; color: #4caf50; font-weight: 600; }
        .sidebar-menu li i { margin-right: 12px; width: 18px; text-align: center; font-size: 0.95rem; transition: all 0.3s ease; }
        .sidebar-menu li .menu-text { flex: 1; transition: all 0.3s ease; }
        .sidebar-menu li a { color: inherit; text-decoration: none; display: flex; align-items: center; width: 100%; }
 
        .page-header { background: #f8f9fa; color: #1a2e1a; padding: 12px 0 12px; border-bottom: 1px solid #e8f0e8; height: 70px; display: flex; align-items: center; }
        .page-header h2 { font-weight: 700; color: #1a2e1a; font-size: 1.4rem; }
        .page-header .breadcrumb { background: none; padding: 0; margin: 0; font-size: 0.85rem; }
        .page-header .breadcrumb a { color: #4caf50; text-decoration: none; }
        .page-header .breadcrumb .active { color: #888; }
        .page-header .text-muted { color: #888 !important; font-size: 0.9rem; }
 
        .main-content { padding: 15px 25px 15px 25px; height: calc(100vh - 140px); overflow: hidden; display: flex; flex-direction: column; }
        .section-content { height: 100%; overflow-y: auto; padding-bottom: 10px; }
        .section-content::-webkit-scrollbar { width: 4px; }
        .section-content::-webkit-scrollbar-thumb { background: #4caf50; border-radius: 4px; }
        .section-content::-webkit-scrollbar-track { background: #e8f0e8; }
 
        .order-card { background: #fff; border: 1px solid #e8f0e8; border-radius: 12px; padding: 18px 20px; margin-bottom: 15px; transition: all 0.3s ease; }
        .order-card:hover { border-color: #4caf50; box-shadow: 0 2px 12px rgba(76, 175, 80, 0.08); }
        .order-card .order-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; border-bottom: 1px solid #f0f0f0; padding-bottom: 10px; margin-bottom: 10px; }
        .order-card .order-number { font-weight: 700; color: #1a2e1a; font-size: 1rem; }
        .order-card .order-date { color: #888; font-size: 0.85rem; }
        .order-card .order-total { font-weight: 700; color: #1a2e1a; font-size: 1.1rem; }
        .order-card .order-items { display: flex; flex-wrap: wrap; gap: 10px; margin: 10px 0; }
        .order-card .order-item { background: #f8f9fa; padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; color: #555; display: inline-flex; align-items: center; gap: 6px; }
        .order-card .order-item img { width: 30px; height: 30px; object-fit: cover; border-radius: 4px; }
        .order-card .order-footer { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-top: 10px; padding-top: 10px; border-top: 1px solid #f0f0f0; }
 
        .status-badge { padding: 4px 14px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; display: inline-block; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #cce5ff; color: #004085; }
        .status-processing { background: #d1ecf1; color: #0c5460; }
        .status-shipped { background: #d4edda; color: #155724; }
        .status-delivered { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
 
        .btn-add-product { background: #4caf50; color: #fff; border: none; border-radius: 30px; padding: 8px 20px; font-weight: 600; font-size: 0.85rem; transition: 0.3s; text-decoration: none; display: inline-block; }
        .btn-add-product:hover { background: #388e3c; color: #fff; }
 
        .filter-bar { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px; }
        .filter-bar .form-select { width: auto; min-width: 150px; font-size: 0.85rem; border-color: #e8f0e8; border-radius: 8px; }
        .filter-bar .form-control { width: auto; min-width: 200px; font-size: 0.85rem; border-color: #e8f0e8; border-radius: 8px; }
        .filter-bar .btn { font-size: 0.85rem; border-radius: 8px; }
 
        .order-count { color: #888; font-size: 0.9rem; margin-bottom: 15px; }
        .order-count strong { color: #1a2e1a; }
 
        @media (max-width: 992px) {
            body { padding-left: 0; }
            .sidebar-wrapper { position: relative; top: 0; width: 100%; height: auto; border-right: none; border-bottom: 1px solid #e8f0e8; }
            .sidebar-wrapper.collapsed { width: 100%; }
            .sidebar-wrapper.collapsed .sidebar-menu li { justify-content: flex-start; }
            .sidebar-wrapper.collapsed .sidebar-menu li .menu-text { display: inline; }
            .sidebar-wrapper.collapsed .sidebar-menu li i { margin-right: 12px; }
            .sidebar-wrapper.collapsed .user-name { display: block; }
            .sidebar-wrapper.collapsed .user-email { display: block; }
            .sidebar-wrapper.collapsed .sidebar-category { display: block; }
            body.sidebar-collapsed { padding-left: 0; }
            .main-content { padding: 10px 15px; height: auto; overflow-y: auto; }
            html, body { overflow: auto; }
            .order-card .order-header { flex-direction: column; align-items: flex-start; gap: 5px; }
            .order-card .order-footer { flex-direction: column; align-items: flex-start; gap: 8px; }
            .filter-bar { flex-direction: column; }
            .filter-bar .form-select, .filter-bar .form-control, .filter-bar .btn { width: 100%; }
        }
    </style>
</head>
<body id="mainBody">
 
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
                <li class="nav-item"><a class="nav-link active" href="#">My Orders</a></li>
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
        <button class="toggle-sidebar-btn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
            <span id="toggleText">Collapse</span>
        </button>
 
        <div class="user-avatar"><i class="fas fa-user"></i></div>
        <div class="user-name"><?= esc(session()->get('full_name') ?? 'Customer') ?></div>
        <div class="user-email"><?= esc(session()->get('email') ?? 'customer@example.com') ?></div>
 
        <div class="sidebar-category">Account</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/dashboard'" data-tooltip="Dashboard">
                <i class="fas fa-tachometer-alt"></i><span class="menu-text">Dashboard</span>
            </li>
            <li onclick="location.href='/profile'" data-tooltip="Profile">
                <i class="fas fa-user-cog"></i><span class="menu-text">My Profile</span>
            </li>
            <li class="active" onclick="location.href='/orders'" data-tooltip="Orders">
                <i class="fas fa-shopping-bag"></i><span class="menu-text">My Orders</span>
                <span class="badge-count" id="orderBadge"><?= count($orders) ?></span>
            </li>
        </ul>
 
        <div class="sidebar-category">Addresses</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/addresses'" data-tooltip="Addresses">
                <i class="fas fa-address-book"></i><span class="menu-text">Saved Addresses</span>
            </li>
            <li onclick="location.href='/addresses/add'" data-tooltip="Add Address">
                <i class="fas fa-plus-circle text-success"></i><span class="menu-text">Add New Address</span>
            </li>
        </ul>
 
        <div class="sidebar-category">Settings</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/profile'" data-tooltip="Settings">
                <i class="fas fa-cog"></i><span class="menu-text">Account Settings</span>
            </li>
            <li>
                <a href="/logout" data-tooltip="Logout">
                    <i class="fas fa-sign-out-alt text-danger"></i><span class="menu-text">Logout</span>
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
                <h2><i class="fas fa-shopping-bag me-2 text-success"></i>My Orders</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2">/</span>
                    <a href="/dashboard">Dashboard</a>
                    <span class="mx-2">/</span>
                    <span class="active">Orders</span>
                </nav>
            </div>
            <div>
                <span class="text-muted">Welcome back, <?= esc(session()->get('full_name') ?? 'Customer') ?>!</span>
            </div>
        </div>
    </div>
</section>
 
<!-- Main Content -->
<section class="main-content">
    <div class="container-fluid px-4 h-100">
        <div class="section-content">
            <!-- Filter Bar -->
            <div class="filter-bar">
                <select class="form-select" id="statusFilter" onchange="filterOrders()">
                    <option value="all">All Orders</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="processing">Processing</option>
                    <option value="shipped">Shipped</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
                <input type="text" class="form-control" id="searchInput" placeholder="Search by order #..." onkeyup="filterOrders()">
                <button class="btn btn-success" onclick="filterOrders()">
                    <i class="fas fa-search me-1"></i>Search
                </button>
                <button class="btn btn-outline-secondary" onclick="resetFilters()">
                    <i class="fas fa-undo me-1"></i>Reset
                </button>
            </div>
 
            <!-- Order Count -->
            <div class="order-count">
                <strong id="orderCountDisplay"><?= count($orders) ?></strong> orders found
            </div>
 
            <!-- Orders List: rendered server-side from real data -->
            <div id="ordersList">
                <?php if (empty($orders)): ?>
    <div class="empty-state">
        <i class="fas fa-box-open"></i>
        <h5>No orders found</h5>
        <p class="text-muted">You haven't placed any orders yet.</p>
        <a href="/products" class="btn-add-product mt-3">
            <i class="fas fa-shopping-bag me-2"></i>Start Shopping
        </a>
    </div>
<?php else: ?>
    <?php foreach ($orders as $order): ?>
        <?php
            $status = $order['order_status'] ?? 'pending';
            $statusLabels = [
                'pending' => 'Pending',
                'confirmed' => 'Confirmed',
                'processing' => 'Processing',
                'shipped' => 'Shipped',
                'delivered' => 'Delivered',
                'cancelled' => 'Cancelled'
            ];
            $statusIcons = [
                'pending' => 'fa-clock',
                'confirmed' => 'fa-check-circle',
                'processing' => 'fa-spinner',
                'shipped' => 'fa-truck',
                'delivered' => 'fa-check-double',
                'cancelled' => 'fa-times-circle'
            ];
            $statusLabel = $statusLabels[$status] ?? ucfirst($status);
            $statusIcon = $statusIcons[$status] ?? 'fa-circle';
            
            // ✅ FIX: Check if items exists before looping
            $itemCount = 0;
            if (isset($order['items']) && is_array($order['items'])) {
                foreach ($order['items'] as $it) { 
                    $itemCount += (int) ($it['quantity'] ?? 0); 
                }
            }
        ?>
        <div class="order-card" 
             data-status="<?= esc($status) ?>"
             data-ordernumber="<?= esc(strtolower($order['order_number'])) ?>">
            <div class="order-header">
                <div>
                    <div class="order-number">
                        <i class="fas fa-hashtag me-1 text-muted"></i><?= esc($order['order_number']) ?>
                    </div>
                    <div class="order-date">
                        <i class="fas fa-calendar-alt me-1"></i><?= date('F j, Y', strtotime($order['created_at'])) ?>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="status-badge status-<?= esc($status) ?>">
                        <i class="fas <?= $statusIcon ?> me-1"></i><?= $statusLabel ?>
                    </span>
                    <span class="order-total">$<?= number_format($order['total_amount'] ?? 0, 2) ?></span>
                </div>
            </div>

            <div class="order-items">
                <?php if (isset($order['items']) && !empty($order['items'])): ?>
                    <?php foreach ($order['items'] as $item): ?>
                        <span class="order-item">
                            <?php if (!empty($item['product_image'])): ?>
                                <img src="<?= esc($item['product_image']) ?>" alt="">
                            <?php endif; ?>
                            <?= (int) ($item['quantity'] ?? 0) ?>&times; <?= esc($item['product_name'] ?? 'Product') ?>
                            <span class="text-muted">$<?= number_format($item['subtotal'] ?? ($item['price'] * $item['quantity']), 2) ?></span>
                        </span>
                    <?php endforeach; ?>
                <?php else: ?>
                    <span class="text-muted small">No items details available</span>
                <?php endif; ?>
            </div>

            <div class="order-footer">
                <div class="text-muted small">
                    <span>Items: <?= $itemCount ?></span>
                </div>
                <div>
                    <button class="btn btn-sm btn-outline-success" onclick="viewOrderDetail(<?= (int) $order['id'] ?>)">
                        <i class="fas fa-eye me-1"></i>View Details
                    </button>
                    <?php if ($status === 'pending'): ?>
                        <button class="btn btn-sm btn-outline-danger" onclick="cancelOrder(<?= (int) $order['id'] ?>, '<?= esc($order['order_number'], 'js') ?>')">
                            <i class="fas fa-times me-1"></i>Cancel
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
            </div>
        </div>
    </div>
</section>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 
<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php if (session()->getFlashdata('success')): ?>
        showNotification('success', 'Success', <?= json_encode(session()->getFlashdata('success')) ?>);
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        showNotification('error', 'Error', <?= json_encode(session()->getFlashdata('error')) ?>);
    <?php endif; ?>
    <?php if (session()->getFlashdata('warning')): ?>
        showNotification('warning', 'Warning', <?= json_encode(session()->getFlashdata('warning')) ?>);
    <?php endif; ?>
});
 
function showNotification(type, title, message) {
    const container = document.getElementById('notificationContainer');
    if (!container) return;
    const icons = { success: '✅', error: '❌', warning: '⚠️', info: 'ℹ️' };
    const icon = icons[type] || 'ℹ️';
    const toast = document.createElement('div');
    toast.className = 'notification-toast ' + (type === 'error' ? 'error' : type === 'warning' ? 'warning' : type === 'info' ? 'info' : '');
    toast.innerHTML = `
        <div class="notif-icon">${icon}</div>
        <div class="notif-content">
            <div class="notif-title">${title}</div>
            <div class="notif-message">${message}</div>
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
    }, 5000);
}
 
function toggleSidebar() {
    const wrapper = document.getElementById('sidebarWrapper');
    const body = document.getElementById('mainBody');
    const txt = document.getElementById('toggleText');
    wrapper.classList.toggle('collapsed');
    body.classList.toggle('sidebar-collapsed');
    txt.textContent = wrapper.classList.contains('collapsed') ? 'Expand' : 'Collapse';
}
 
// Client-side filtering over the SERVER-RENDERED order cards.
// No fake data, no localStorage — just show/hide real cards already in the DOM.
function filterOrders() {
    const statusFilter = document.getElementById('statusFilter').value;
    const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
    const cards = document.querySelectorAll('#ordersList .order-card');
    let visibleCount = 0;
 
    cards.forEach(card => {
        const matchesStatus = statusFilter === 'all' || card.dataset.status === statusFilter;
        const matchesSearch = !searchTerm || card.dataset.ordernumber.includes(searchTerm);
        const show = matchesStatus && matchesSearch;
        card.style.display = show ? '' : 'none';
        if (show) visibleCount++;
    });
 
    document.getElementById('orderCountDisplay').textContent = visibleCount;
}
 
function resetFilters() {
    document.getElementById('statusFilter').value = 'all';
    document.getElementById('searchInput').value = '';
    filterOrders();
}
 
// Cancels a real order via the real backend route, then removes the card.
function cancelOrder(id, orderNumber) {
    if (!confirm('Are you sure you want to cancel order ' + orderNumber + '?')) return;
 
    fetch('/orders/cancel/' + id, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json',
        },
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showNotification('warning', 'Order Cancelled', 'Order ' + orderNumber + ' has been cancelled.');
            // Reload so status badge, filters, and "Cancel" button all reflect the real DB state.
            setTimeout(() => window.location.reload(), 1200);
        } else {
            showNotification('error', 'Error', data.message || 'Could not cancel this order.');
        }
    })
    .catch(() => {
        showNotification('error', 'Error', 'Something went wrong. Please try again.');
    });
}
</script>
 
</body>
</html>  