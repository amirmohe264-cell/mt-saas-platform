<!-- app/Views/public/dashboard.php -->
<?php
if (!session()->get('customer_id') && !session()->get('user_id')) {
    header('Location: /login');
    exit();
}
?>

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
        html, body {
            height: 100%;
            overflow: hidden;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            padding-left: 280px;
            padding-top: 80px;
            transition: padding-left 0.3s ease;
            height: 100vh;
            overflow: hidden;
        }

        .notification-container {
            position: fixed;
            top: 90px;
            right: 20px;
            z-index: 9999;
            max-width: 380px;
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
        .notification-toast .notif-close {
            background: none;
            border: none;
            color: #aaa;
            cursor: pointer;
            font-size: 1rem;
            padding: 0 5px;
        }
        .notification-toast .notif-close:hover { color: #333; }
        .notification-toast.removing {
            animation: slideOutRight 0.3s ease forwards;
        }
        @keyframes slideInRight {
            from { transform: translateX(100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100px); opacity: 0; }
        }

        .navbar {
            background: #1a2e1a !important;
            padding: 12px 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.3);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            height: 70px;
        }
        .navbar-brand {
            color: #fff !important;
            font-weight: bold;
            font-size: 1.4rem;
        }
        .navbar-brand i { color: #4caf50; }
        .navbar .nav-link {
            color: #d4d4d4 !important;
            font-weight: 500;
            transition: 0.3s;
            font-size: 0.95rem;
        }
        .navbar .nav-link:hover { color: #4caf50 !important; }
        .icon-btn {
            color: #d4d4d4;
            font-size: 1.1rem;
            margin: 0 6px;
            transition: 0.3s;
            background: none;
            border: none;
        }
        .icon-btn:hover {
            color: #4caf50;
            transform: scale(1.1);
        }
        .navbar-toggler { border-color: #4caf50; }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(76, 175, 80, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .sidebar-wrapper {
            position: fixed;
            top: 70px;
            left: 0;
            width: 280px;
            height: calc(100vh - 70px);
            overflow-y: auto;
            background: #fff;
            border-right: 1px solid #e8f0e8;
            padding: 15px 15px;
            z-index: 1000;
            transition: width 0.3s ease;
        }
        .sidebar-wrapper::-webkit-scrollbar { width: 4px; }
        .sidebar-wrapper::-webkit-scrollbar-thumb { background: #4caf50; border-radius: 4px; }
        .sidebar-wrapper::-webkit-scrollbar-track { background: #e8f0e8; }

        .sidebar-wrapper.collapsed {
            width: 70px;
        }
        .sidebar-wrapper.collapsed .user-name,
        .sidebar-wrapper.collapsed .user-email,
        .sidebar-wrapper.collapsed .sidebar-category {
            display: none;
        }
        .sidebar-wrapper.collapsed .sidebar-menu li {
            padding: 8px;
            justify-content: center;
        }
        .sidebar-wrapper.collapsed .sidebar-menu li .menu-text {
            display: none;
        }
        .sidebar-wrapper.collapsed .sidebar-menu li i {
            margin-right: 0;
            font-size: 1.1rem;
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
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        body.sidebar-collapsed {
            padding-left: 70px;
        }

        .sidebar-card .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #4caf50;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 8px;
            transition: all 0.3s ease;
        }
        .sidebar-card .user-name {
            text-align: center;
            font-weight: 700;
            color: #1a2e1a;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        .sidebar-card .user-email {
            text-align: center;
            color: #888;
            font-size: 0.75rem;
            transition: all 0.3s ease;
        }

        .toggle-sidebar-btn {
            background: #4caf50;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 0.9rem;
            transition: 0.3s;
            cursor: pointer;
            width: 100%;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .toggle-sidebar-btn:hover {
            background: #388e3c;
        }

        .sidebar-category {
            font-size: 0.6rem;
            font-weight: 700;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 10px 10px 3px;
            border-top: 1px solid #f0f0f0;
            margin-top: 5px;
            transition: all 0.3s ease;
        }
        .sidebar-category:first-child {
            border-top: none;
            margin-top: 0;
            padding-top: 3px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar-menu li {
            padding: 8px 12px;
            border-radius: 8px;
            transition: 0.3s;
            cursor: pointer;
            color: #555;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            position: relative;
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
            width: 18px;
            text-align: center;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        .sidebar-menu li .menu-text {
            flex: 1;
            transition: all 0.3s ease;
        }
        .sidebar-menu li .badge-count {
            background: #4caf50;
            color: #fff;
            border-radius: 20px;
            padding: 2px 8px;
            font-size: 0.6rem;
            font-weight: 600;
            margin-left: auto;
        }
        .sidebar-menu li a {
            color: inherit;
            text-decoration: none;
            display: flex;
            align-items: center;
            width: 100%;
        }

        .page-header {
            background: #f8f9fa;
            color: #1a2e1a;
            padding: 12px 0 12px;
            border-bottom: 1px solid #e8f0e8;
            height: 70px;
            display: flex;
            align-items: center;
        }
        .page-header h2 {
            font-weight: 700;
            color: #1a2e1a;
            font-size: 1.4rem;
        }
        .page-header .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
            font-size: 0.85rem;
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
            font-size: 0.9rem;
        }

        .main-content {
            padding: 15px 25px 15px 25px;
            height: calc(100vh - 140px);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .dashboard-card {
            background: #fff;
            border-radius: 12px;
            padding: 15px 18px;
            border: 1px solid #e8f0e8;
            transition: 0.3s;
            height: 100%;
        }
        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        .dashboard-card .card-number {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1a2e1a;
        }
        .dashboard-card .card-label {
            color: #888;
            font-size: 0.8rem;
        }
        .dashboard-card .card-icon {
            font-size: 1.5rem;
            float: right;
        }
        .dashboard-card .btn-sm {
            font-size: 0.7rem;
            padding: 3px 12px;
        }

        .order-item {
            background: #fff;
            border-radius: 10px;
            padding: 10px 15px;
            border: 1px solid #e8f0e8;
            margin-bottom: 8px;
            transition: 0.3s;
        }
        .order-item:hover {
            border-color: #4caf50;
        }
        .order-item .order-number {
            font-weight: 600;
            color: #1a2e1a;
            font-size: 0.85rem;
        }
        .order-item .order-date {
            color: #888;
            font-size: 0.75rem;
        }
        .order-item .order-total {
            font-weight: 700;
            color: #1a2e1a;
            font-size: 0.9rem;
        }

        .recent-orders-section {
            flex: 1;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .recent-orders-section .orders-list {
            flex: 1;
            overflow-y: auto;
            padding-right: 5px;
        }
        .recent-orders-section .orders-list::-webkit-scrollbar {
            width: 4px;
        }
        .recent-orders-section .orders-list::-webkit-scrollbar-thumb {
            background: #4caf50;
            border-radius: 4px;
        }
        .recent-orders-section .orders-list::-webkit-scrollbar-track {
            background: #e8f0e8;
        }

        .sections {
            display: none;
            height: 100%;
        }
        .sections.active {
            display: block;
        }

        .status-badge {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.65rem;
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
            padding: 8px 20px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-add-product:hover {
            background: #388e3c;
            color: #fff;
        }

        .section-content {
            height: 100%;
            overflow-y: auto;
            padding-bottom: 10px;
        }
        .section-content::-webkit-scrollbar {
            width: 4px;
        }
        .section-content::-webkit-scrollbar-thumb {
            background: #4caf50;
            border-radius: 4px;
        }
        .section-content::-webkit-scrollbar-track {
            background: #e8f0e8;
        }

        .address-item {
            background: #fff;
            border: 1px solid #e8f0e8;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 12px;
            transition: all 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .address-item:hover {
            border-color: #4caf50;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .address-item .address-info {
            flex: 1;
        }
        .address-item .address-type {
            font-weight: 600;
            color: #1a2e1a;
            font-size: 1rem;
        }
        .address-item .address-details {
            color: #555;
            font-size: 0.9rem;
            margin-top: 2px;
        }
        .address-item .address-details i {
            color: #888;
            width: 16px;
        }
        .address-item .address-actions {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-shrink: 0;
            margin-left: 15px;
        }
        .address-item .address-actions .btn {
            font-size: 0.75rem;
            padding: 4px 12px;
        }
        .address-item .default-badge {
            background: #4caf50;
            color: #fff;
            padding: 2px 12px;
            border-radius: 20px;
            font-size: 0.65rem;
            font-weight: 600;
            margin-right: 10px;
            display: inline-block;
        }
        .address-item .address-phone {
            color: #666;
            font-size: 0.85rem;
        }

        .order-card {
            background: #fff;
            border-radius: 10px;
            border: 1px solid #e8f0e8;
            padding: 15px 18px;
            margin-bottom: 12px;
            transition: all 0.3s ease;
        }
        .order-card:hover {
            border-color: #4caf50;
            box-shadow: 0 2px 12px rgba(76, 175, 80, 0.08);
        }
        .order-card .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        .order-card .order-number {
            font-weight: 700;
            color: #1a2e1a;
            font-size: 0.95rem;
        }
        .order-card .order-date {
            color: #888;
            font-size: 0.8rem;
        }
        .order-card .order-items {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin: 6px 0;
        }
        .order-card .order-item-tag {
            background: #f8f9fa;
            padding: 3px 10px;
            border-radius: 5px;
            font-size: 0.8rem;
            color: #555;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .order-card .order-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid #f0f0f0;
        }
        .order-card .order-summary {
            color: #666;
            font-size: 0.8rem;
        }
        .order-card .order-summary strong {
            color: #1a2e1a;
        }
        .order-card .order-total {
            font-weight: 700;
            color: #1a2e1a;
            font-size: 1rem;
        }
        .order-card .order-actions {
            display: flex;
            gap: 5px;
        }
        .order-card .order-actions .btn {
            font-size: 0.7rem;
            padding: 3px 10px;
        }
        .order-empty-state {
            text-align: center;
            padding: 40px 20px;
        }
        .order-empty-state i {
            font-size: 3rem;
            color: #ddd;
            margin-bottom: 10px;
        }
        .order-empty-state h6 {
            color: #888;
        }

        .wishlist-item {
            background: #fff;
            border: 1px solid #e8f0e8;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 12px;
            transition: all 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .wishlist-item:hover {
            border-color: #dc3545;
            box-shadow: 0 2px 12px rgba(220, 53, 69, 0.08);
        }
        .wishlist-item .product-info {
            flex: 1;
        }
        .wishlist-item .product-name {
            font-weight: 600;
            color: #1a2e1a;
            font-size: 1rem;
        }
        .wishlist-item .product-price {
            color: #4caf50;
            font-weight: 700;
            font-size: 1rem;
        }
        .wishlist-item .product-details {
            color: #666;
            font-size: 0.85rem;
            margin-top: 2px;
        }
        .wishlist-item .product-actions {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-shrink: 0;
            margin-left: 15px;
        }
        .wishlist-item .product-actions .btn {
            font-size: 0.75rem;
            padding: 4px 12px;
        }
        .wishlist-item .product-icon {
            font-size: 1.8rem;
            margin-right: 15px;
        }
        .wishlist-item .added-date {
            color: #888;
            font-size: 0.75rem;
        }
        .wishlist-empty {
            text-align: center;
            padding: 40px 20px;
        }
        .wishlist-empty i {
            font-size: 3rem;
            color: #ddd;
            margin-bottom: 10px;
        }
        .wishlist-empty h6 {
            color: #888;
        }
        .btn-add-to-cart {
            background: #4caf50;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 4px 14px;
            font-weight: 600;
            font-size: 0.75rem;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-add-to-cart:hover {
            background: #388e3c;
            color: #fff;
        }
        .btn-remove-wishlist {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            transition: 0.3s;
            font-size: 1.1rem;
            padding: 4px 8px;
            border-radius: 4px;
        }
        .btn-remove-wishlist:hover {
            background: #f8d7da;
            color: #c82333;
            transform: scale(1.1);
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
            .sidebar-wrapper.collapsed .user-name,
            .sidebar-wrapper.collapsed .user-email,
            .sidebar-wrapper.collapsed .sidebar-category {
                display: block;
            }
            body.sidebar-collapsed {
                padding-left: 0;
            }
            .main-content {
                padding: 10px 15px;
                height: auto;
                overflow-y: auto;
            }
            html, body {
                overflow: auto;
            }
            .address-item {
                flex-direction: column;
                align-items: flex-start;
            }
            .address-item .address-actions {
                margin-left: 0;
                margin-top: 10px;
                width: 100%;
            }
            .order-card .order-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
            .order-card .order-footer {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
            .wishlist-item {
                flex-direction: column;
                align-items: flex-start;
            }
            .wishlist-item .product-actions {
                margin-left: 0;
                margin-top: 10px;
                width: 100%;
            }
        }
    </style>
</head>
<body id="mainBody">

<div class="notification-container" id="notificationContainer"></div>

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

<div class="sidebar-wrapper" id="sidebarWrapper">
    <div class="sidebar-card">
      <button class="toggle-sidebar-btn" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

        <div class="user-avatar">
            <i class="fas fa-user"></i>
        </div>
        <div class="user-name"><?= session()->get('full_name') ?? session()->get('first_name') ?? 'Customer' ?></div>
        <div class="user-email"><?= session()->get('email') ?? 'customer@example.com' ?></div>

        <div class="sidebar-category">Account</div>
        <ul class="sidebar-menu">
            <li onclick="showSection('dashboard')" data-tooltip="Dashboard">
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
            <li onclick="showSection('wishlist')" data-tooltip="Wishlist">
                <i class="fas fa-heart text-danger"></i>
                <span class="menu-text">Wishlist</span>
                <span class="badge-count" id="wishlistBadge">0</span>
            </li>
        </ul>

        <div class="sidebar-category">Addresses</div>
        <ul class="sidebar-menu">
            <li onclick="showSection('addresses')" data-tooltip="Addresses">
                <i class="fas fa-address-book"></i>
                <span class="menu-text">Saved Addresses</span>
            </li>
            <li onclick="showSection('addAddress')" data-tooltip="Add Address">
                <i class="fas fa-plus-circle text-success"></i>
                <span class="menu-text">Add New Address</span>
            </li>
        </ul>

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
                <span class="text-muted">Welcome back, <?= session()->get('full_name') ?? session()->get('first_name') ?? 'Customer' ?>!</span>
            </div>
        </div>
    </div>
</section>

<section class="main-content">
    <div class="container-fluid px-4 h-100">
        <div id="dashboardSection" class="sections active h-100">
            <div class="row mb-3" style="height: 30%;">
                <div class="col-md-3 mb-2">
                    <div class="dashboard-card" style="border-left: 4px solid #ffc107;">
                        <i class="fas fa-clock card-icon text-warning"></i>
                        <div class="card-number" id="pendingOrdersCount">0</div>
                        <div class="card-label">Pending Orders</div>
                        <button class="btn btn-sm btn-outline-warning mt-1" onclick="showSection('orders')">
                            View
                        </button>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="dashboard-card" style="border-left: 4px solid #17a2b8;">
                        <i class="fas fa-spinner card-icon text-info"></i>
                        <div class="card-number" id="processingOrdersCount">0</div>
                        <div class="card-label">Processing Orders</div>
                        <button class="btn btn-sm btn-outline-info mt-1" onclick="showSection('orders')">
                            View
                        </button>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="dashboard-card" style="border-left: 4px solid #28a745;">
                        <i class="fas fa-check-circle card-icon text-success"></i>
                        <div class="card-number" id="deliveredOrdersCount">0</div>
                        <div class="card-label">Delivered Orders</div>
                        <button class="btn btn-sm btn-outline-success mt-1" onclick="showSection('orders')">
                            View
                        </button>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="dashboard-card" style="border-left: 4px solid #dc3545;">
                        <i class="fas fa-heart card-icon text-danger"></i>
                        <div class="card-number" id="wishlistCardCount">0</div>
                        <div class="card-label">Wishlist Items</div>
                        <button class="btn btn-sm btn-outline-danger mt-1" onclick="showSection('wishlist')">
                            View
                        </button>
                    </div>
                </div>
            </div>

            <div class="recent-orders-section" style="height: 65%;">
                <h5 class="fw-bold mb-2" style="font-size: 1.1rem;"><i class="fas fa-clock me-2 text-success"></i>Recent Orders</h5>
                <div class="orders-list" id="recentOrdersList"></div>
            </div>
        </div>

        <div id="profileSection" class="sections">
            <div class="section-content">
                <div class="bg-white rounded-3 p-4 border">
                    <h5 class="fw-bold"><i class="fas fa-user-cog me-2 text-success"></i>My Profile</h5>
                    <hr>
                    <form id="profileForm" onsubmit="return updateProfile(event)">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>First Name</label>
                                <input type="text" class="form-control" id="firstName" value="John" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Last Name</label>
                                <input type="text" class="form-control" id="lastName" value="Doe" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Email Address</label>
                            <input type="email" class="form-control" id="email" value="john@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label>Phone Number</label>
                            <input type="tel" class="form-control" id="phone" value="+1 234 567 890" required>
                        </div>
                        <button type="submit" class="btn-add-product">
                            <i class="fas fa-save me-2"></i>Update Profile
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div id="ordersSection" class="sections">
            <div class="section-content">
                <div class="bg-white rounded-3 p-4 border">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <h5 class="fw-bold"><i class="fas fa-shopping-bag me-2 text-success"></i>My Orders</h5>
                        <div class="d-flex gap-2 flex-wrap">
                            <select class="form-select form-select-sm" id="orderStatusFilter" style="width:auto;min-width:130px;" onchange="renderOrderList()">
                                <option value="all">All Orders</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="processing">Processing</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            <input type="text" class="form-control form-control-sm" id="orderSearchInput" placeholder="Search by order #..." style="width:180px;" onkeyup="renderOrderList()">
                            <button class="btn btn-sm btn-success" onclick="renderOrderList()"><i class="fas fa-search"></i></button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="resetOrderFilters()"><i class="fas fa-undo"></i></button>
                        </div>
                    </div>
                    <hr>
                    <div id="orderListContainer"></div>
                </div>
            </div>
        </div>

        <div id="wishlistSection" class="sections">
            <div class="section-content">
                <div class="bg-white rounded-3 p-4 border">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <h5 class="fw-bold"><i class="fas fa-heart me-2 text-danger"></i>My Wishlist</h5>
                    </div>
                    <hr>
                    <div id="wishlistContainer"></div>
                </div>
            </div>
        </div>

        <div id="addressesSection" class="sections">
            <div class="section-content">
                <div class="bg-white rounded-3 p-4 border">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold"><i class="fas fa-address-book me-2 text-success"></i>Saved Addresses</h5>
                        <button class="btn-add-product" onclick="showSection('addAddress')">
                            <i class="fas fa-plus me-2"></i>Add Address
                        </button>
                    </div>
                    <hr>
                    <div id="addressList"></div>
                </div>
            </div>
        </div>

        <div id="addAddressSection" class="sections">
            <div class="section-content">
                <div class="bg-white rounded-3 p-4 border">
                    <h5 class="fw-bold"><i class="fas fa-plus-circle me-2 text-success"></i>Add New Address</h5>
                    <hr>
                    <form id="addAddressForm" onsubmit="return saveAddress(event)">
                        <div class="mb-3">
                            <label>Address Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="addressType" required>
                                <option value="">Select address type</option>
                                <option value="Home">Home</option>
                                <option value="Work">Work</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Street Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="streetAddress" placeholder="Enter street address" required>
                        </div>
                        <div class="mb-3">
                            <label>Apartment / Suite / Unit (Optional)</label>
                            <input type="text" class="form-control" id="apartment" placeholder="Apartment, suite, unit, etc.">
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>City <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="city" placeholder="City" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>State <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="state" placeholder="State" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>ZIP Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="zipCode" placeholder="ZIP Code" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Country <span class="text-danger">*</span></label>
                            <select class="form-select" id="country" required>
                                <option value="">Select country</option>
                                <option value="United States">United States</option>
                                <option value="Canada">Canada</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="Australia">Australia</option>
                                <option value="Germany">Germany</option>
                                <option value="France">France</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="addressPhone" placeholder="Phone number" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="setDefault">
                            <label class="form-check-label" for="setDefault">
                                <i class="fas fa-check-circle text-success"></i> Set as default address
                            </label>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn-add-product">
                                <i class="fas fa-save me-2"></i>Save Address
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="showSection('addresses')">
                                <i class="fas fa-arrow-left me-1"></i>Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="settingsSection" class="sections">
            <div class="section-content">
                <div class="bg-white rounded-3 p-4 border">
                    <h5 class="fw-bold"><i class="fas fa-cog me-2 text-success"></i>Account Settings</h5>
                    <hr>
                    <form id="settingsForm" onsubmit="return changePassword(event)">
                        <div class="mb-3">
                            <label>Current Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="currentPassword" placeholder="Enter current password" required>
                        </div>
                        <div class="mb-3">
                            <label>New Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="newPassword" placeholder="Enter new password" required minlength="8">
                        </div>
                        <div class="mb-3">
                            <label>Confirm New Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password" required>
                        </div>
                        <button type="submit" class="btn-add-product">
                            <i class="fas fa-save me-2"></i>Change Password
                        </button>
                    </form>
                    <hr>
                    <h6><i class="fas fa-bell me-2 text-warning"></i>Notification Preferences</h6>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="emailNotif" checked>
                        <label class="form-check-label" for="emailNotif">
                            <i class="fas fa-envelope me-1 text-primary"></i> Order Updates via Email
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="promoNotif">
                        <label class="form-check-label" for="promoNotif">
                            <i class="fas fa-tag me-1 text-success"></i> Promotional Emails
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="smsNotif" checked>
                        <label class="form-check-label" for="smsNotif">
                            <i class="fas fa-sms me-1 text-info"></i> Order Updates via SMS
                        </label>
                    </div>
                    <button class="btn-add-product mt-3" onclick="savePreferences()">
                        <i class="fas fa-save me-2"></i>Save Preferences
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
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
    
    loadAddresses();
    loadOrders();
    loadWishlist();
  const hash = window.location.hash.replace('#', '');
    const validSections = ['dashboard', 'profile', 'orders', 'wishlist', 'addresses', 'addAddress', 'settings'];
    if (hash && validSections.includes(hash)) {
        showSection(hash);
    }  
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

function showSection(section) {
    document.querySelectorAll('.sections').forEach(el => el.classList.remove('active'));
    const map = { 
        'dashboard': 'dashboardSection', 
        'profile': 'profileSection', 
        'orders': 'ordersSection',
        'wishlist': 'wishlistSection', 
        'addresses': 'addressesSection',
        'addAddress': 'addAddressSection', 
        'settings': 'settingsSection' 
    };
    const el = document.getElementById(map[section]);
    if (el) el.classList.add('active');
    
    document.querySelectorAll('.sidebar-menu li').forEach(item => item.classList.remove('active'));
    const items = document.querySelectorAll('.sidebar-menu li');
    const idx = ['dashboard', 'profile', 'orders', 'wishlist', 'addresses', 'addAddress', 'settings'].indexOf(section);
    if (items[idx]) items[idx].classList.add('active');
    
    const breadcrumbActive = document.querySelector('.breadcrumb .active');
    if (breadcrumbActive) {
        const titles = {
            'dashboard': 'Dashboard',
            'profile': 'Profile',
            'orders': 'Orders',
            'wishlist': 'Wishlist',
            'addresses': 'Addresses',
            'addAddress': 'Add Address',
            'settings': 'Settings'
        };
        breadcrumbActive.textContent = titles[section] || 'Dashboard';
        
        const pageTitle = document.querySelector('.page-header h2');
        if (pageTitle) {
            const icons = {
                'dashboard': 'fa-tachometer-alt',
                'profile': 'fa-user-cog',
                'orders': 'fa-shopping-bag',
                'wishlist': 'fa-heart',
                'addresses': 'fa-address-book',
                'addAddress': 'fa-plus-circle',
                'settings': 'fa-cog'
            };
            pageTitle.innerHTML = `<i class="fas ${icons[section] || 'fa-tachometer-alt'} me-2 text-success"></i>${titles[section] || 'Dashboard'}`;
        }
    }
}

function toggleSidebar() {
    var wrapper = document.getElementById('sidebarWrapper');
    var body = document.getElementById('mainBody');
    wrapper.classList.toggle('collapsed');
    body.classList.toggle('sidebar-collapsed');
}

function updateProfile(event) {
    event.preventDefault();
    const firstName = document.getElementById('firstName').value;
    const lastName = document.getElementById('lastName').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    
    const profileData = { firstName, lastName, email, phone };
    localStorage.setItem('profileData', JSON.stringify(profileData));
    
    showNotification('success', '✅ Profile Updated', 
        `${firstName} ${lastName}'s profile updated successfully!`);
    return false;
}

// ==========================================
// ADDRESS MANAGEMENT
// ==========================================
let addresses = [];
let addressIdCounter = 1;

function loadAddresses() {
    const saved = localStorage.getItem('addresses');
    if (saved) {
        try {
            addresses = JSON.parse(saved);
            addressIdCounter = addresses.length > 0 ? Math.max(...addresses.map(a => a.id)) + 1 : 1;
        } catch(e) {
            setDefaultAddresses();
        }
    } else {
        setDefaultAddresses();
    }
    renderAddresses();
}

function setDefaultAddresses() {
    addresses = [
        { id: 1, type: 'Home', street: '123 Main Street', apartment: '', city: 'New York', state: 'NY', zipCode: '10001', country: 'United States', phone: '+1 234 567 890', isDefault: true },
        { id: 2, type: 'Work', street: '456 Business Ave', apartment: 'Suite 200', city: 'New York', state: 'NY', zipCode: '10002', country: 'United States', phone: '+1 987 654 321', isDefault: false }
    ];
    addressIdCounter = 3;
    saveAddressesToStorage();
}

function saveAddressesToStorage() {
    localStorage.setItem('addresses', JSON.stringify(addresses));
}

function renderAddresses() {
    const container = document.getElementById('addressList');
    if (!container) return;
    
    if (addresses.length === 0) {
        container.innerHTML = `
            <div class="text-center py-5">
                <i class="fas fa-map-marker-alt fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">No addresses saved yet</h5>
                <p class="text-muted">Add your first address for faster checkout</p>
                <button class="btn-add-product mt-2" onclick="showSection('addAddress')">
                    <i class="fas fa-plus me-2"></i>Add Address
                </button>
            </div>
        `;
        return;
    }
    
    let html = '';
    addresses.forEach((addr) => {
        const icon = addr.type === 'Home' ? 'fa-home' : addr.type === 'Work' ? 'fa-briefcase' : 'fa-map-pin';
        html += `
            <div class="address-item">
                <div class="address-info">
                    <div>
                        <span class="address-type"><i class="fas ${icon} me-2 text-success"></i>${addr.type} Address</span>
                        ${addr.isDefault ? '<span class="default-badge"><i class="fas fa-check-circle"></i> Default</span>' : ''}
                    </div>
                    <div class="address-details">
                        <div>${addr.street}${addr.apartment ? ', ' + addr.apartment : ''}</div>
                        <div>${addr.city}, ${addr.state} ${addr.zipCode}</div>
                        <div>${addr.country}</div>
                        <div class="address-phone"><i class="fas fa-phone me-1"></i>${addr.phone}</div>
                    </div>
                </div>
                <div class="address-actions">
                    ${!addr.isDefault ? `<button class="btn btn-sm btn-outline-success" onclick="setDefaultAddress(${addr.id})">
                        <i class="fas fa-check-circle"></i> Set Default
                    </button>` : ''}
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteAddress(${addr.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
    });
    container.innerHTML = html;
}

function saveAddress(event) {
    event.preventDefault();
    
    const type = document.getElementById('addressType').value;
    const street = document.getElementById('streetAddress').value.trim();
    const apartment = document.getElementById('apartment').value.trim();
    const city = document.getElementById('city').value.trim();
    const state = document.getElementById('state').value.trim();
    const zipCode = document.getElementById('zipCode').value.trim();
    const country = document.getElementById('country').value;
    const phone = document.getElementById('addressPhone').value.trim();
    const setDefault = document.getElementById('setDefault').checked;
    
    if (!type || !street || !city || !state || !zipCode || !country || !phone) {
        showNotification('error', '❌ Validation Error', 'Please fill in all required fields.');
        return false;
    }
    
    const newAddress = {
        id: addressIdCounter++,
        type: type,
        street: street,
        apartment: apartment,
        city: city,
        state: state,
        zipCode: zipCode,
        country: country,
        phone: phone,
        isDefault: setDefault
    };
    
    if (setDefault) {
        addresses.forEach(a => a.isDefault = false);
    }
    
    addresses.push(newAddress);
    saveAddressesToStorage();
    renderAddresses();
    
    document.getElementById('addAddressForm').reset();
    document.getElementById('setDefault').checked = false;
    
    showNotification('success', '✅ Address Added', `${type} address saved successfully!`);
    setTimeout(() => showSection('addresses'), 1000);
    return false;
}

function deleteAddress(id) {
    if (!confirm('Are you sure you want to delete this address?')) return;
    
    const address = addresses.find(a => a.id === id);
    addresses = addresses.filter(a => a.id !== id);
    
    if (address && address.isDefault && addresses.length > 0) {
        addresses[0].isDefault = true;
    }
    
    saveAddressesToStorage();
    renderAddresses();
    showNotification('success', '🗑️ Address Removed', 'Address deleted successfully!');
}

function setDefaultAddress(id) {
    addresses.forEach(a => a.isDefault = (a.id === id));
    saveAddressesToStorage();
    renderAddresses();
    showNotification('success', '✅ Default Set', 'Default address updated successfully!');
}

function changePassword(event) {
    event.preventDefault();
    const current = document.getElementById('currentPassword').value;
    const newPass = document.getElementById('newPassword').value;
    const confirm = document.getElementById('confirmPassword').value;
    
    if (newPass !== confirm) {
        showNotification('error', '❌ Password Mismatch', 'New password and confirm password do not match.');
        return false;
    }
    
    if (newPass.length < 8) {
        showNotification('error', '❌ Password Too Short', 'Password must be at least 8 characters long.');
        return false;
    }
    
    localStorage.setItem('userPassword', newPass);
    showNotification('success', '✅ Password Changed', 'Your password has been updated successfully!');
    document.getElementById('settingsForm').reset();
    return false;
}

function savePreferences() {
    const email = document.getElementById('emailNotif').checked;
    const promo = document.getElementById('promoNotif').checked;
    const sms = document.getElementById('smsNotif').checked;
    
    const prefs = { email, promo, sms };
    localStorage.setItem('preferences', JSON.stringify(prefs));
    showNotification('success', '✅ Preferences Saved', 
        'Email: ' + (email ? '✅' : '❌') + ' | Promo: ' + (promo ? '✅' : '❌') + ' | SMS: ' + (sms ? '✅' : '❌'));
}

// ==========================================
// ORDER MANAGEMENT - FETCH REAL ORDERS
// ==========================================
let ordersData = [];

function loadOrders() {
    fetch('/get-orders', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            ordersData = data.orders || [];
            updateDashboardStats(ordersData);
            renderRecentOrders(ordersData);
            renderOrderList();
        } else {
            ordersData = [];
            updateDashboardStats([]);
            renderRecentOrders([]);
            renderOrderList();
        }
    })
    .catch(error => {
        console.error('Error loading orders:', error);
        ordersData = [];
        updateDashboardStats([]);
        renderRecentOrders([]);
        renderOrderList();
    });
}

function updateDashboardStats(orders) {
    const pending = orders.filter(o => o.order_status === 'pending' || o.order_status === 'confirmed').length;
    const processing = orders.filter(o => o.order_status === 'processing' || o.order_status === 'shipped').length;
    const delivered = orders.filter(o => o.order_status === 'delivered').length;
    
    document.getElementById('pendingOrdersCount').textContent = pending;
    document.getElementById('processingOrdersCount').textContent = processing;
    document.getElementById('deliveredOrdersCount').textContent = delivered;
}

function renderRecentOrders(orders) {
    const container = document.getElementById('recentOrdersList');
    const recent = orders.slice(0, 5);
    
    if (!container) return;
    
    if (recent.length === 0) {
        container.innerHTML = `
            <div class="text-center py-4">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <p class="text-muted">No orders yet. Start shopping!</p>
                <a href="/products" class="btn btn-success btn-sm">Browse Products</a>
            </div>
        `;
        return;
    }
    
    let html = '';
    recent.forEach(order => {
        const status = order.order_status || 'pending';
        const statusClass = 'status-' + status;
        const statusLabel = order.status_label || ucfirst(status);
        const orderNumber = order.order_number || '#' + order.id;
        const total = order.total_amount || order.total || 0;
        const date = order.date_formatted || new Date(order.created_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
        
        html += `
            <div class="order-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="order-number">#${orderNumber}</div>
                        <div class="order-date">${date}</div>
                    </div>
                    <div>
                        <span class="status-badge ${statusClass}">
                            ${statusLabel}
                        </span>
                    </div>
                    <div><span class="order-total">$${parseFloat(total).toFixed(2)}</span></div>
                    <div>
                        <button class="btn btn-sm btn-outline-success" onclick="viewOrderDetail(${order.id})">
                            <i class="fas fa-eye"></i> View
                        </button>
                    </div>
                </div>
            </div>
        `;
    });
    container.innerHTML = html;
}

function renderOrderList() {
    const container = document.getElementById('orderListContainer');
    if (!container) return;
    
    const statusFilter = document.getElementById('orderStatusFilter').value;
    const searchTerm = document.getElementById('orderSearchInput').value.toLowerCase().trim();
    
    let filtered = ordersData.filter(order => {
        const orderStatus = order.order_status || 'pending';
        const orderNumber = order.order_number || '#' + order.id;
        if (statusFilter !== 'all' && orderStatus !== statusFilter) return false;
        if (searchTerm && !orderNumber.toLowerCase().includes(searchTerm)) return false;
        return true;
    });
    
    if (filtered.length === 0) {
        container.innerHTML = `
            <div class="order-empty-state">
                <i class="fas fa-box-open"></i>
                <h6>${ordersData.length === 0 ? 'No orders yet. Start shopping!' : 'No orders match your filters.'}</h6>
                ${ordersData.length === 0 ? '<a href="/products" class="btn-add-product mt-2" style="font-size:0.8rem;padding:6px 16px;"><i class="fas fa-shopping-bag me-2"></i>Start Shopping</a>' : ''}
            </div>
        `;
        return;
    }
    
    let html = `<div class="mb-2 text-muted small"><strong>${filtered.length}</strong> orders found</div>`;
    
    filtered.forEach(order => {
        const status = order.order_status || 'pending';
        const statusClass = 'status-' + status;
        const statusLabel = order.status_label || ucfirst(status);
        const statusIcon = order.status_icon || getStatusIcon(status);
        const orderNumber = order.order_number || '#' + order.id;
        const total = order.total_amount || order.total || 0;
        const subtotal = order.subtotal || (total - (order.shipping || 0));
        const shipping = order.shipping || 0;
        const date = order.date_formatted || new Date(order.created_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
        
        let itemsHtml = '';
        if (order.items && order.items.length > 0) {
            order.items.forEach(item => {
                const itemName = item.product_name || item.name || 'Product';
                const itemPrice = item.price || 0;
                const itemQty = item.quantity || 1;
                const itemSubtotal = itemPrice * itemQty;
                itemsHtml += `
                    <span class="order-item-tag">
                        ${itemQty}× ${itemName} $${itemSubtotal.toFixed(2)}
                    </span>
                `;
            });
        }
        
        html += `
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <span class="order-number"><i class="fas fa-hashtag me-1 text-muted" style="font-size:0.7rem;"></i>${orderNumber}</span>
                        <span class="order-date ms-2"><i class="far fa-calendar-alt me-1"></i>${date}</span>
                    </div>
                    <div>
                        <span class="status-badge ${statusClass}">
                            <i class="fas ${statusIcon} me-1"></i>${statusLabel}
                        </span>
                    </div>
                </div>
                
                <div class="order-items">
                    ${itemsHtml || '<span class="text-muted small">No items details available</span>'}
                </div>
                
                <div class="order-footer">
                    <div class="order-summary">
                        Items: <strong>${order.items ? order.items.reduce((sum, item) => sum + (item.quantity || 1), 0) : 0}</strong>
                        <span class="mx-2">|</span>
                        Subtotal: <strong>$${parseFloat(subtotal).toFixed(2)}</strong>
                        ${shipping > 0 ? `<span class="mx-2">|</span> Shipping: <strong>$${parseFloat(shipping).toFixed(2)}</strong>` : ''}
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="order-total">$${parseFloat(total).toFixed(2)}</span>
                       <div class="order-actions">
    <button class="btn btn-sm btn-outline-success" onclick="viewOrderDetail(${order.id})">
        <i class="fas fa-eye"></i>
    </button>
    ${status === 'pending' || status === 'confirmed' ? `
        <button class="btn btn-sm btn-outline-danger" onclick="cancelOrderItem(${order.id})">
            <i class="fas fa-times"></i>
        </button>
    ` : ''}
    ${status === 'delivered' && !order.delivery_confirmed ? `
        <button class="btn btn-sm btn-success" onclick="confirmDelivery(${order.id})">
            <i class="fas fa-check-circle"></i> Confirm Receipt
        </button>
    ` : ''}
    ${status === 'delivered' && order.delivery_confirmed ? `
        <span class="badge bg-success"><i class="fas fa-check-circle"></i> Confirmed</span>
    ` : ''}
</div>
                    </div>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

function resetOrderFilters() {
    document.getElementById('orderStatusFilter').value = 'all';
    document.getElementById('orderSearchInput').value = '';
    renderOrderList();
}

function viewOrderDetail(id) {
    fetch('/get-order-detail/' + id, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            showNotification('error', '❌ Error', data.message || 'Order not found!');
            return;
        }
        
        const order = data.order;
        const status = order.order_status || 'pending';
        const statusClass = 'status-' + status;
        const statusLabel = order.status_label || ucfirst(status);
        const orderNumber = order.order_number || '#' + order.id;
        const total = order.total_amount || order.total || 0;
        const subtotal = order.subtotal || (total - (order.shipping || 0));
        const shipping = order.shipping || 0;
        const date = order.date_formatted || new Date(order.created_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
        
        let itemsHtml = '';
        if (order.items && order.items.length > 0) {
            order.items.forEach(item => {
                const itemName = item.product_name || item.name || 'Product';
                const itemPrice = item.price || 0;
                const itemQty = item.quantity || 1;
                const itemSubtotal = itemPrice * itemQty;
                itemsHtml += `
                    <div class="d-flex justify-content-between border-bottom py-1">
                        <span>${itemQty} × ${itemName}</span>
                        <span class="fw-bold">$${itemSubtotal.toFixed(2)}</span>
                    </div>
                `;
            });
        }
        
        showNotification('info', `📦 Order ${orderNumber}`, `
            <div style="font-size:0.85rem;margin-top:5px;">
                <div class="d-flex justify-content-between border-bottom py-1">
                    <span>Status</span>
                    <span><span class="status-badge ${statusClass}">${statusLabel}</span></span>
                </div>
                <div class="d-flex justify-content-between border-bottom py-1">
                    <span>Date</span>
                    <span>${date}</span>
                </div>
                <div class="border-bottom py-1">
                    <strong>Items:</strong>
                    ${itemsHtml || '<div class="text-muted small">No items</div>'}
                </div>
                <div class="d-flex justify-content-between border-bottom py-1">
                    <span>Subtotal</span>
                    <span>$${parseFloat(subtotal).toFixed(2)}</span>
                </div>
                <div class="d-flex justify-content-between border-bottom py-1">
                    <span>Shipping</span>
                    <span>${shipping > 0 ? '$' + parseFloat(shipping).toFixed(2) : 'FREE'}</span>
                </div>
                <div class="d-flex justify-content-between py-1" style="font-size:1.1rem;">
                    <span class="fw-bold">Total</span>
                    <span class="fw-bold text-success">$${parseFloat(total).toFixed(2)}</span>
                </div>
            </div>
        `);
    })
    .catch(error => {
        console.error('Error fetching order details:', error);
        showNotification('error', '❌ Error', 'Could not load order details.');
    });
}

function cancelOrderItem(id) {
    if (!confirm('Are you sure you want to cancel this order?')) return;
    
    fetch('/cancel-order/' + id, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('warning', '❌ Order Cancelled', data.message || 'Order cancelled successfully.');
            loadOrders();
        } else {
            showNotification('error', '❌ Error', data.message || 'Could not cancel order.');
        }
    })
    .catch(error => {
        console.error('Error cancelling order:', error);
        showNotification('error', '❌ Error', 'Could not cancel order.');
    });
}
function confirmDelivery(orderId) {
    if (!confirm('Confirm that you have received this order? This lets us release payment to the seller.')) return;

    fetch('/orders/confirm-delivery/' + orderId, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('success', '✅ Delivery Confirmed', data.message);
            loadOrders();
        } else {
            showNotification('error', '❌ Error', data.message);
        }
    })
    .catch(error => {
        console.error('Error confirming delivery:', error);
        showNotification('error', '❌ Error', 'Could not confirm delivery.');
    });
}
function getStatusIcon(status) {
    const icons = {
        'pending': 'fa-clock',
        'confirmed': 'fa-check-circle',
        'processing': 'fa-spinner',
        'shipped': 'fa-truck',
        'delivered': 'fa-check-double',
        'cancelled': 'fa-times-circle'
    };
    return icons[status] || 'fa-circle';
}

function ucfirst(str) {
    if (!str) return '';
    return str.charAt(0).toUpperCase() + str.slice(1);
}

// ==========================================
// WISHLIST MANAGEMENT - FETCH REAL DATA
// ==========================================
let wishlistItems = [];

function loadWishlist() {
    fetch('/get-wishlist', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            wishlistItems = data.items || [];
            updateWishlistBadge();
            updateWishlistCardCount();
            renderWishlist();
        } else {
            wishlistItems = [];
            updateWishlistBadge();
            updateWishlistCardCount();
            renderWishlist();
        }
    })
    .catch(error => {
        console.error('Error loading wishlist:', error);
        wishlistItems = [];
        updateWishlistBadge();
        updateWishlistCardCount();
        renderWishlist();
    });
}

function renderWishlist() {
    const container = document.getElementById('wishlistContainer');
    if (!container) return;
    
    if (wishlistItems.length === 0) {
        container.innerHTML = `
            <div class="wishlist-empty">
                <i class="fas fa-heart"></i>
                <h6>Your wishlist is empty</h6>
                <p class="text-muted small">Start adding items you love!</p>
                <a href="/products" class="btn-add-product mt-2" style="font-size:0.8rem;padding:6px 16px;"><i class="fas fa-shopping-bag me-2"></i>Browse Products</a>
            </div>
        `;
        return;
    }
    
    let html = `<div class="mb-2 text-muted small"><strong>${wishlistItems.length}</strong> items in your wishlist</div>`;
    
    wishlistItems.forEach(item => {
        html += `
            <div class="wishlist-item">
                <div class="d-flex align-items-center">
                    <div class="product-icon">${item.icon || '📦'}</div>
                    <div class="product-info">
                        <div class="product-name">${item.name}</div>
                        <div class="product-details">
                            <span class="product-price">$${parseFloat(item.price).toFixed(2)}</span>
                            <span class="mx-2">|</span>
                            <span class="text-muted">${item.category || 'General'}</span>
                            <span class="mx-2">|</span>
                            <span class="added-date"><i class="far fa-calendar-alt me-1"></i>Added ${item.added_formatted || new Date(item.added_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}</span>
                        </div>
                    </div>
                </div>
                <div class="product-actions">
                    <button class="btn btn-sm btn-success" onclick="addToCartFromWishlist(${item.id})">
                        <i class="fas fa-shopping-cart me-1"></i>Add to Cart
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="removeFromWishlist(${item.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

function addToCartFromWishlist(wishlistId) {
    const item = wishlistItems.find(w => w.id == wishlistId);
    if (!item) {
        showNotification('error', '❌ Error', 'Item not found!');
        return;
    }
    
    fetch('/add-to-cart', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            product_id: item.product_id,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('success', '✅ Added to Cart', `${item.name} has been added to your cart!`);
            updateCartBadge();
        } else {
            showNotification('error', '❌ Error', data.message || 'Could not add to cart.');
        }
    })
    .catch(error => {
        console.error('Error adding to cart:', error);
        showNotification('error', '❌ Error', 'Could not add to cart.');
    });
}

function removeFromWishlist(wishlistId) {
    if (!confirm('Remove this item from your wishlist?')) return;
    
    fetch('/remove-from-wishlist/' + wishlistId, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const item = wishlistItems.find(w => w.id == wishlistId);
            wishlistItems = wishlistItems.filter(w => w.id != wishlistId);
            renderWishlist();
            updateWishlistBadge();
            updateWishlistCardCount();
            showNotification('warning', '🗑️ Removed', `${item ? item.name : 'Item'} removed from wishlist.`);
        } else {
            showNotification('error', '❌ Error', data.message || 'Could not remove item.');
        }
    })
    .catch(error => {
        console.error('Error removing from wishlist:', error);
        showNotification('error', '❌ Error', 'Could not remove item.');
    });
}

function updateWishlistBadge() {
    const badge = document.getElementById('wishlistBadge');
    if (badge) {
        badge.textContent = wishlistItems.length;
        badge.style.display = wishlistItems.length > 0 ? 'inline-block' : 'none';
    }
}

function updateWishlistCardCount() {
    const cardCount = document.getElementById('wishlistCardCount');
    if (cardCount) {
        cardCount.textContent = wishlistItems.length;
    }
}

function updateCartBadge() {
    fetch('/cart-count', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const badge = document.getElementById('cartBadge');
            if (badge) {
                badge.textContent = data.count || 0;
                badge.style.display = data.count > 0 ? 'inline-block' : 'none';
            }
        }
    })
    .catch(error => console.error('Error updating cart badge:', error));
}

// Load saved data
document.addEventListener('DOMContentLoaded', function() {
    const profileData = localStorage.getItem('profileData');
    if (profileData) {
        try {
            const p = JSON.parse(profileData);
            document.getElementById('firstName').value = p.firstName || 'John';
            document.getElementById('lastName').value = p.lastName || 'Doe';
            document.getElementById('email').value = p.email || 'john@example.com';
            document.getElementById('phone').value = p.phone || '+1 234 567 890';
        } catch(e) {}
    }
    
    const prefs = localStorage.getItem('preferences');
    if (prefs) {
        try {
            const p = JSON.parse(prefs);
            document.getElementById('emailNotif').checked = p.email !== undefined ? p.email : true;
            document.getElementById('promoNotif').checked = p.promo || false;
            document.getElementById('smsNotif').checked = p.sms !== undefined ? p.sms : true;
        } catch(e) {}
    }
});
</script>

</body>
</html>