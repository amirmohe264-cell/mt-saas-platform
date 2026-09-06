<!-- app/Views/public/profile.php -->
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
    <title>My Profile - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #1a1a2e;
            --brand-mid: #16213e;
            --accent: #e94560;
            --accent-light: #ff6b6b;
            --gold: #f5a623;
            --text: #1a1a2e;
            --muted: #6b7280;
            --border: #e5e7eb;
            --surface: #f9fafb;
            --white: #ffffff;
            --radius: 12px;
            --radius-lg: 20px;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --font: 'Inter', sans-serif;
            --display: 'Sora', sans-serif;
        }

        * { box-sizing: border-box; }
        body {
            font-family: var(--font);
            background: var(--surface);
            padding-left: 180px;
            padding-top: 80px;
            transition: padding-left 0.3s ease;
            min-height: 100vh;
        }

        /* ========================================== */
        /* NAVBAR - Left: 180px to match sidebar */
        /* ========================================== */
        .navbar {
            background: var(--brand) !important;
            padding: 12px 0;
            box-shadow: 0 2px 20px rgba(26,26,46,0.3);
            position: fixed;
            top: 0;
            left: 180px;
            right: 0;
            z-index: 1050;
            height: 70px;
            transition: left 0.3s ease;
        }
        .navbar-brand {
            color: #fff !important;
            font-weight: 800;
            font-size: 1.4rem;
        }
        .navbar-brand span { color: var(--accent); }
        .navbar .nav-link {
            color: #d1d5db !important;
            font-weight: 500;
            transition: 0.3s;
            font-size: 0.95rem;
        }
        .navbar .nav-link:hover { color: var(--accent-light) !important; }
        .icon-btn {
            color: #d1d5db;
            font-size: 1.1rem;
            margin: 0 6px;
            transition: 0.3s;
            background: none;
            border: none;
        }
        .icon-btn:hover {
            color: var(--accent-light);
            transform: scale(1.1);
        }
        .navbar-toggler { border-color: var(--accent); }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(233, 69, 96, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* ========================================== */
        /* SIDEBAR - Full height, top: 0 */
        /* ========================================== */
        .sidebar-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 180px;
            height: 100vh;
            overflow-y: auto;
            background: #fff;
            border-right: 1px solid var(--border);
            padding: 20px 15px;
            z-index: 1000;
            transition: width 0.3s ease;
        }
        .sidebar-wrapper::-webkit-scrollbar { width: 4px; }
        .sidebar-wrapper::-webkit-scrollbar-thumb { background: var(--accent); border-radius: 4px; }
        .sidebar-wrapper::-webkit-scrollbar-track { background: var(--border); }

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
            background: var(--brand);
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

        /* Navbar follows sidebar collapsed state */
        body.sidebar-collapsed .navbar {
            left: 70px;
        }

        .sidebar-card .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--accent);
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
            color: var(--brand);
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        .sidebar-card .user-email {
            text-align: center;
            color: #888;
            font-size: 0.75rem;
            transition: all 0.3s ease;
        }

        /* Toggle button INSIDE sidebar */
        .toggle-sidebar-btn {
            background: var(--accent);
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
            background: #c73652;
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
            background: #fff5f5;
            color: var(--accent);
        }
        .sidebar-menu li.active {
            background: #fff5f5;
            color: var(--accent);
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
            background: var(--accent);
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

        /* ========================================== */
        /* PAGE HEADER */
        /* ========================================== */
        .page-header {
            background: var(--brand);
            padding: 44px 0 34px;
        }
        .page-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
            padding: 5px 14px;
            color: #e5e7eb;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .page-eyebrow span {
            width: 6px;
            height: 6px;
            background: var(--gold);
            border-radius: 50%;
        }
        .page-title {
            margin-bottom: 8px;
            color: white;
            font-family: var(--display);
            font-size: 2rem;
            font-weight: 800;
        }
        .page-crumb a {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.85rem;
        }
        .page-crumb a:hover { color: var(--accent-light); }
        .page-crumb .sep {
            margin: 0 8px;
            color: rgba(255, 255, 255, 0.3);
        }
        .page-crumb .active {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* ========================================== */
        /* PROFILE SECTION */
        /* ========================================== */
        .profile-section { padding: 64px 0; }
        .profile-card {
            max-width: 680px;
            margin: 0 auto;
            padding: 40px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
        }
        .profile-card h4,
        .profile-card h5 {
            color: var(--brand);
            font-family: var(--display);
            font-weight: 800;
        }
        .profile-card h4 i { color: var(--accent) !important; }
        .profile-card hr {
            margin: 28px 0;
            border-color: var(--border);
            opacity: 1;
        }
        .profile-card label {
            display: block;
            margin-bottom: 7px;
            color: var(--brand);
            font-size: 0.86rem;
            font-weight: 600;
        }
        .profile-card .form-control {
            min-height: 44px;
            padding: 10px 14px;
            color: var(--text);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 0.9rem;
        }
        .profile-card .form-control:focus {
            background: var(--white);
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.1);
        }
        .profile-card .form-control[readonly] {
            color: var(--muted);
            background: #f3f4f6;
        }
        .btn-save {
            color: #fff;
            background: var(--accent);
            border: none;
            border-radius: 50px;
            padding: 12px 24px;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-save:hover {
            color: #fff;
            background: #c73652;
            box-shadow: 0 8px 20px rgba(233, 69, 96, 0.22);
            transform: translateY(-1px);
        }
        .alert {
            border: none;
            border-radius: 10px;
            font-size: 0.9rem;
        }
        .alert-success { color: #047857; background: #ecfdf5; }
        .alert-danger { color: #be123c; background: #fff1f2; }

        /* ========================================== */
        /* FOOTER - UNCHANGED */
        /* ========================================== */
        .site-footer {
            padding: 60px 0 28px;
            background: #111827;
        }
        .footer-logo {
            color: white;
            font-family: var(--display);
            font-size: 1.4rem;
            font-weight: 800;
        }
        .footer-logo span { color: var(--accent); }
        .footer-tagline {
            max-width: 240px;
            margin-top: 8px;
            color: #6b7280;
            font-size: 0.85rem;
        }
        .footer-heading {
            margin-bottom: 16px;
            color: white;
            font-size: 0.88rem;
            font-weight: 700;
        }
        .footer-link {
            display: block;
            margin-bottom: 9px;
            color: #6b7280;
            font-size: 0.84rem;
            transition: color 0.2s;
        }
        .footer-link:hover { color: white; }
        .footer-divider { border-color: #1f2937; }
        .footer-bottom { color: #4b5563; font-size: 0.8rem; }
        .payment-lbl {
            margin-right: 6px;
            padding: 4px 10px;
            color: #9ca3af;
            background: #1f2937;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* ========================================== */
        /* MOBILE RESPONSIVE - Stacked like dashboard */
        /* ========================================== */
        @media (max-width: 992px) {
            body {
                padding-left: 0;
            }
            .navbar {
                left: 0 !important;
            }
            body.sidebar-collapsed .navbar {
                left: 0 !important;
            }
            .sidebar-wrapper {
                position: relative;
                top: 0;
                width: 100%;
                height: auto;
                border-right: none;
                border-bottom: 1px solid var(--border);
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
            .profile-section {
                padding: 30px 0;
            }
            .profile-card {
                padding: 20px;
                margin: 0 15px;
            }
            .page-title {
                font-size: 1.6rem;
            }
            .page-header {
                padding: 30px 0 24px;
            }
        }

        @media (max-width: 576px) {
            .profile-card { 
                padding: 18px 16px; 
                margin: 0 10px;
            }
            .page-title { 
                font-size: 1.4rem; 
            }
            .btn-save {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body id="mainBody">

<!-- Navbar - WITHOUT toggle button (toggle is inside sidebar) -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/">Shop<span>Ease</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/products">Shop</a></li>
                <li class="nav-item"><a class="nav-link" href="/store/apply">Sell With Us</a></li>
                <li class="nav-item"><a class="nav-link" href="/contact">Contact</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <a href="/dashboard" class="icon-btn" style="color:#d1d5db;text-decoration:none;">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <a href="/logout" class="icon-btn" style="color:#d1d5db;text-decoration:none;">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Sidebar - WITH toggle button INSIDE -->
<div class="sidebar-wrapper" id="sidebarWrapper">
    <div class="sidebar-card">
        <!-- Toggle Button INSIDE sidebar -->
        <button class="toggle-sidebar-btn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
            <span id="toggleText">Collapse</span>
        </button>

        <div class="user-avatar">
            <i class="fas fa-user"></i>
        </div>
        <div class="user-name"><?= session()->get('full_name') ?? session()->get('first_name') ?? 'Customer' ?></div>
        <div class="user-email"><?= session()->get('email') ?? 'customer@example.com' ?></div>

        <div class="sidebar-category">Account</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/dashboard'" data-tooltip="Dashboard">
                <i class="fas fa-tachometer-alt"></i>
                <span class="menu-text">Dashboard</span>
            </li>
            <li class="active" onclick="location.href='/profile'" data-tooltip="Profile">
                <i class="fas fa-user-cog"></i>
                <span class="menu-text">My Profile</span>
            </li>
            <li onclick="location.href='/dashboard#orders'" data-tooltip="Orders">
                <i class="fas fa-shopping-bag"></i>
                <span class="menu-text">My Orders</span>
            </li>
            <li onclick="location.href='/dashboard#wishlist'" data-tooltip="Wishlist">
                <i class="fas fa-heart" style="color: var(--accent);"></i>
                <span class="menu-text">Wishlist</span>
            </li>
        </ul>

        <div class="sidebar-category">Addresses</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/dashboard#addresses'" data-tooltip="Addresses">
                <i class="fas fa-address-book"></i>
                <span class="menu-text">Saved Addresses</span>
            </li>
        </ul>

        <div class="sidebar-category">Settings</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/dashboard#settings'" data-tooltip="Settings">
                <i class="fas fa-cog"></i>
                <span class="menu-text">Account Settings</span>
            </li>
            <li>
                <a href="/logout" data-tooltip="Logout">
                    <i class="fas fa-sign-out-alt" style="color: var(--accent);"></i>
                    <span class="menu-text">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<section class="page-header">
    <div class="container">
        <div class="page-eyebrow"><span></span> Account</div>
        <h2 class="page-title">My Profile</h2>
        <nav class="page-crumb">
            <a href="/">Home</a>
            <span class="sep">/</span>
            <span class="active">My Profile</span>
        </nav>
    </div>
</section>

<section class="profile-section">
    <div class="container">
        <div class="profile-card">
            <h4><i class="fas fa-user me-2"></i>My Profile</h4>
            <hr>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="/profile/update" method="post">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>First Name</label>
                        <input type="text" name="first_name" class="form-control" value="<?= $customer['first_name'] ?? '' ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="<?= $customer['last_name'] ?? '' ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Email Address</label>
                    <input type="email" class="form-control" value="<?= $customer['email'] ?? '' ?>" readonly>
                </div>
                <div class="mb-3">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" class="form-control" value="<?= $customer['phone'] ?? '' ?>">
                </div>
                <button type="submit" class="btn-save"><i class="fas fa-save me-2"></i>Update Profile</button>
            </form>

            <hr>
            <h5>Change Password</h5>
            <form action="/profile/change-password" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label>Current Password</label>
                    <input type="password" name="current_password" class="form-control" placeholder="Enter current password" required>
                </div>
                <div class="mb-3">
                    <label>New Password</label>
                    <input type="password" name="new_password" class="form-control" placeholder="Enter new password" required>
                </div>
                <div class="mb-3">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Confirm new password" required>
                </div>
                <button type="submit" class="btn-save"><i class="fas fa-save me-2"></i>Change Password</button>
            </form>
        </div>
    </div>
</section>

<footer class="site-footer">
    <div class="container">
        <div class="row g-4 pb-4">
            <div class="col-lg-4 col-md-6">
                <div class="footer-logo">Shop<span>Ease</span></div>
                <p class="footer-tagline">Your trusted multi-vendor marketplace for quality products and secure shopping.</p>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="footer-heading">Shop</h6>
                <a href="/products" class="footer-link">All Products</a>
                <a href="/store/apply" class="footer-link">Sell With Us</a>
                <a href="/track" class="footer-link">Track Order</a>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="footer-heading">Company</h6>
                <a href="/about" class="footer-link">About Us</a>
                <a href="/contact" class="footer-link">Contact</a>
                <a href="/privacy" class="footer-link">Privacy Policy</a>
                <a href="/terms" class="footer-link">Terms</a>
            </div>
            <div class="col-lg-4 col-md-6">
                <h6 class="footer-heading">Secure Shopping</h6>
                <p class="footer-link mb-3">Shop confidently with our trusted payment options.</p>
                <span class="payment-lbl">Telebirr</span>
                <span class="payment-lbl">CBE Bank</span>
                <span class="payment-lbl">Chapa</span>
            </div>
        </div>
        <hr class="footer-divider">
        <p class="footer-bottom mb-0">&copy; <?= date('Y') ?> ShopEase. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // ==========================================
    // TOGGLE SIDEBAR - Same as store dashboard
    // ==========================================
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