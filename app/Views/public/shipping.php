<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Info - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        body { padding-top: 80px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8f9fa; }
        .navbar { position: fixed; top: 0; left: 0; right: 0; z-index: 1000; background: #1a2e1a !important; padding: 15px 0; transition: all 0.3s ease; box-shadow: 0 2px 20px rgba(0,0,0,0.3); }
        .navbar-scrolled { background: rgba(26, 46, 26, 0.88) !important; backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); box-shadow: 0 4px 30px rgba(0,0,0,0.5); padding: 8px 0; }
        .navbar-brand { color: #fff !important; font-weight: bold; font-size: 1.5rem; }
        .navbar-brand i { color: #4caf50; }
        .navbar .nav-link { color: #d4d4d4 !important; font-weight: 500; transition: 0.3s; }
        .navbar .nav-link:hover { color: #4caf50 !important; }
        .navbar .nav-link.active { color: #4caf50 !important; }
        .search-box { background: #2a402a; border-radius: 30px; padding: 5px 15px; border: none; color: #fff; }
        .search-box::placeholder { color: #aaa; }
        .search-box:focus { outline: none; background: #2a402a; box-shadow: 0 0 0 2px #4caf50; }
        .icon-btn { color: #d4d4d4; font-size: 1.2rem; margin: 0 8px; transition: 0.3s; background: none; border: none; }
        .icon-btn:hover { color: #4caf50; transform: scale(1.1); }
        .navbar-toggler { border-color: #4caf50; }
        .navbar-toggler-icon { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(76, 175, 80, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e"); }
        .page-header { background: #1a2e1a; color: #fff; padding: 40px 0 30px; }
        .page-header h2 { font-weight: 700; }
        .page-header .breadcrumb { background: none; padding: 0; margin: 0; }
        .page-header .breadcrumb a { color: #4caf50; text-decoration: none; }
        .page-header .breadcrumb .active { color: #aaa; }
        .content-section { padding: 40px 0; }
        .content-card { background: #fff; border-radius: 12px; padding: 30px; border: 1px solid #e8f0e8; }
        .content-card h4 { color: #1a2e1a; font-weight: 700; }
        .content-card p { color: #555; line-height: 1.8; }
        .shipping-method { background: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 10px; border-left: 3px solid #4caf50; }
        .shipping-method h6 { color: #1a2e1a; font-weight: 600; }
        .shipping-method p { margin-bottom: 0; color: #666; }
        .footer { background: #1a2e1a; color: #d4d4d4; padding: 40px 0 20px; margin-top: 40px; }
        .footer h5 { color: #fff; font-weight: 600; }
        .footer a { color: #aaa; text-decoration: none; transition: 0.3s; }
        .footer a:hover { color: #4caf50; }

        /* ShopEase visual system — matched to the reference page */
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
            --shadow: 0 4px 20px rgba(0,0,0,.08);
            --shadow-hover: 0 12px 32px rgba(0,0,0,.14);
            --font: 'Inter', sans-serif;
            --display: 'Sora', sans-serif;
        }

        body {
            font-family: var(--font);
            color: var(--text);
            background: var(--white);
        }

        .navbar {
            padding: 18px 0;
            background: rgba(255,255,255,.98) !important;
            border-bottom: 1px solid var(--border);
            box-shadow: none;
            backdrop-filter: blur(12px);
        }

        .navbar-scrolled {
            padding: 12px 0;
            background: rgba(255,255,255,.98) !important;
            box-shadow: 0 2px 16px rgba(0,0,0,.08);
        }

        .navbar-brand {
            color: var(--brand) !important;
            font-family: var(--display);
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .navbar-brand i { color: var(--accent); }

        .navbar .nav-link {
            color: #374151 !important;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: .9rem;
            font-weight: 500;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link.active {
            color: var(--accent) !important;
            background: #fff5f5;
        }

        .search-wrap { position: relative; }
        .search-ico {
            position: absolute;
            top: 50%;
            left: 14px;
            color: #9ca3af;
            font-size: .82rem;
            transform: translateY(-50%);
        }

        .search-box {
            width: 240px;
            padding: 9px 18px 9px 40px;
            color: var(--text);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 50px;
            font-size: .875rem;
        }

        .search-box::placeholder { color: #9ca3af; }

        .search-box:focus {
            background: var(--white);
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(233,69,96,.1);
        }

        .icon-btn {
            width: 38px;
            height: 38px;
            margin: 0 0 0 8px;
            color: #374151 !important;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: .95rem;
        }

        .icon-btn:hover {
            color: var(--accent) !important;
            background: #fff5f5;
            border-color: var(--accent);
            transform: none;
        }

        .btn-nav-signin {
            color: white;
            background: var(--brand);
            border-radius: 50px;
            padding: 9px 22px;
            font-size: .875rem;
            font-weight: 600;
            transition: all .2s;
        }

        .btn-nav-signin:hover {
            color: white;
            background: #2d2d4e;
            transform: translateY(-1px);
        }

        .page-header {
            padding: 44px 0 34px;
            background: var(--brand);
        }

        .page-header h2 {
            margin-bottom: 8px;
            color: white;
            font-family: var(--display);
            font-size: 2rem;
            font-weight: 800;
        }

        .page-header h2 i { color: var(--accent); }

        .page-header .breadcrumb a {
            color: rgba(255,255,255,.6);
            font-size: .85rem;
        }

        .page-header .breadcrumb a:hover { color: var(--accent-light); }

        .page-header .breadcrumb .active {
            color: rgba(255,255,255,.9);
            font-size: .85rem;
        }

        .content-section { padding: 64px 0; }

        .content-card {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
        }

        .content-card h4,
        .content-card h5 {
            color: var(--brand);
            font-family: var(--display);
            font-weight: 800;
        }

        .content-card h4 { font-size: 1.35rem; }
        .content-card h5 { font-size: 1.05rem; }

        .content-card p,
        .content-card ul {
            color: var(--muted);
            line-height: 1.8;
        }

        .content-card li::marker { color: var(--accent); }

        .shipping-method {
            padding: 18px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-left: 3px solid var(--accent);
            border-radius: var(--radius);
            box-shadow: 0 2px 10px rgba(0,0,0,.03);
        }

        .shipping-method h6 {
            color: var(--brand);
            font-family: var(--display);
            font-weight: 700;
        }

        .shipping-method h6 i { color: var(--accent) !important; }
        .shipping-method p { color: var(--muted); }

        .footer {
            padding: 60px 0 28px;
            background: #111827;
            margin-top: 0;
        }

        .footer h5 {
            color: white;
            font-family: var(--display);
            font-size: .88rem;
            font-weight: 700;
        }

        .footer a {
            color: #6b7280;
            font-size: .84rem;
        }

        .footer a:hover { color: white; }
        .footer .text-muted { color: #6b7280 !important; }
        .footer hr { border-color: #1f2937; }

        .footer .form-control {
            color: white;
            background: #1f2937 !important;
            border: 1px solid #374151 !important;
            border-radius: 50px 0 0 50px;
        }

        .footer .btn-success {
            background: var(--accent) !important;
            border: none !important;
            border-radius: 0 50px 50px 0;
        }

        @media (max-width: 576px) {
            .content-card { padding: 26px 20px; }
            .page-header h2 { font-size: 1.6rem; }
            .search-box { width: 180px; }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/">Shop<span style="color:var(--accent);">Ease</span></a>
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
            <div class="d-flex align-items-center gap-2">
                <div class="search-wrap d-none d-md-block">
                    <i class="fas fa-search search-ico"></i>
                    <input class="search-box" type="search" placeholder="Search products...">
                </div>
                <button class="icon-btn"><i class="far fa-heart"></i></button>
                <a href="/cart" class="icon-btn"><i class="fas fa-shopping-bag"></i></a>
                <a href="/login" class="btn-nav-signin">Sign In</a>
            </div>
        </div>
    </div>
</nav>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.18);color:#e5e7eb;font-size:.75rem;font-weight:600;padding:5px 14px;border-radius:50px;margin-bottom:14px;">
                    <span style="width:6px;height:6px;border-radius:50%;background:var(--gold);"></span> Support
                </div>
                <h2><i class="fas fa-truck me-2"></i>Shipping Information</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2 text-white-50">/</span>
                    <span class="active">Shipping Info</span>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Content -->
<section class="content-section">
    <div class="container">
        <div class="content-card">
            <h4>Shipping Information</h4>
            <p>We offer fast and reliable shipping options to ensure your orders arrive safely and on time.</p>

            <h5 class="mt-4">Shipping Methods</h5>
            
            <div class="shipping-method">
                <h6><i class="fas fa-clock text-success me-2"></i>Standard Shipping</h6>
                <p>Delivery within 5-7 business days. Free for orders over $50.</p>
            </div>
            
            <div class="shipping-method">
                <h6><i class="fas fa-bolt text-success me-2"></i>Express Shipping</h6>
                <p>Delivery within 2-3 business days. Cost: $15.00</p>
            </div>
            
            <div class="shipping-method">
                <h6><i class="fas fa-rocket text-success me-2"></i>Priority Shipping</h6>
                <p>Delivery within 1-2 business days. Cost: $25.00</p>
            </div>

            <h5 class="mt-4">Shipping Rates</h5>
            <ul>
                <li>Free Standard Shipping on orders over $50</li>
                <li>Standard Shipping: $5.00 for orders under $50</li>
                <li>Express Shipping: $15.00</li>
                <li>Priority Shipping: $25.00</li>
            </ul>

            <h5 class="mt-4">International Shipping</h5>
            <p>We currently ship to select international destinations. Shipping rates and delivery times vary by location. Please contact our support team for more information.</p>

            <h5 class="mt-4">Order Tracking</h5>
            <p>Once your order ships, you will receive a confirmation email with tracking information. You can also track your order in your account dashboard.</p>

            <p class="mt-4"><strong>Last Updated:</strong> August 2026</p>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5><i class="fas fa-store text-success"></i> ShopEase</h5>
                <p class="text-muted">Your one-stop shop for everything you need.</p>
            </div>
            <div class="col-md-2 mb-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="/about">About Us</a></li>
                    <li><a href="/contact">Contact</a></li>
                    <li><a href="/privacy">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Customer Service</h5>
                <ul class="list-unstyled">
                    <li><a href="/help">Help Center</a></li>
                    <li><a href="/returns">Returns</a></li>
                    <li><a href="/shipping">Shipping Info</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Newsletter</h5>
                <p class="text-muted">Get the latest deals & updates</p>
                <div class="input-group">
                    <input type="email" class="form-control" placeholder="Your email" style="background:#2a402a;border:none;color:#fff;">
                    <button class="btn btn-success" style="background:#4caf50;border:none;">Subscribe</button>
                </div>
            </div>
        </div>
        <hr class="border-top">
        <p class="text-center text-muted small">&copy; 2026 ShopEase. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.addEventListener('scroll', function() {
        var navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    });
</script>
</body>
</html>