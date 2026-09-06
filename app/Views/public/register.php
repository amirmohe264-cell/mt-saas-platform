<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
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
        body {
            font-family: var(--font);
            color: var(--text);
            background: var(--white);
        }
        a { text-decoration: none; }
        .site-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 18px 0;
            background: rgba(255, 255, 255, 0.98);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(12px);
        }
        .nav-logo {
            color: var(--brand);
            font-family: var(--display);
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .nav-logo span { color: var(--accent); }
        .nav-link-item {
            color: #374151;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 6px 14px;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .nav-link-item:hover,
        .nav-link-item.active {
            color: var(--accent);
            background: #fff5f5;
        }
        .btn-nav-signin {
            color: white;
            background: var(--brand);
            border-radius: 50px;
            padding: 9px 22px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-nav-signin:hover {
            color: white;
            background: #2d2d4e;
            transform: translateY(-1px);
        }
        .search-wrap { position: relative; }
        .search-ico {
            position: absolute;
            top: 50%;
            left: 14px;
            color: #9ca3af;
            font-size: 0.82rem;
            transform: translateY(-50%);
        }
        .search-box {
            width: 240px;
            padding: 9px 18px 9px 40px;
            color: var(--text);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 30px;
            font-size: 0.875rem;
        }
        .search-box:focus {
            outline: none;
            background: var(--white);
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.1);
        }
        .icon-btn {
            width: 38px;
            height: 38px;
            margin-left: 8px;
            color: #374151;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.2s;
        }
        .icon-btn:hover {
            color: var(--accent);
            background: #fff5f5;
            border-color: var(--accent);
        }
        .page-header {
            padding: 44px 0 34px;
            background: var(--brand);
        }
        .page-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
            padding: 5px 14px;
            color: #e5e7eb;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.18);
            border-radius: 50px;
            font-size: .75rem;
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
            color: rgba(255,255,255,.6);
            font-size: .85rem;
        }
        .page-crumb a:hover { color: var(--accent-light); }
        .page-crumb .sep {
            margin: 0 8px;
            color: rgba(255,255,255,.3);
        }
        .page-crumb .active {
            color: rgba(255,255,255,.9);
            font-size: .85rem;
            font-weight: 500;
        }
        .register-section {
            padding: 64px 0;
        }
        .register-box {
            max-width: 560px;
            margin: 0 auto;
            padding: 40px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
        }
        .register-box h3 {
            color: var(--brand);
            font-family: var(--display);
            font-size: 1.45rem;
            font-weight: 800;
        }
        .register-box h3 i { color: var(--accent) !important; }
        .register-box .subtitle {
            color: var(--muted);
            font-size: 0.9rem;
        }
        .register-box label {
            color: var(--brand);
            font-size: 0.86rem;
            font-weight: 600;
        }
        .register-box .form-control {
            padding: 10px 14px;
            color: var(--text);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
        }
        .register-box .form-control:focus {
            background: var(--white);
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.1);
        }
        .register-box .form-check-input:checked {
            background-color: var(--accent);
            border-color: var(--accent);
        }
        .register-box .text-success,
        .register-box .login-link {
            color: var(--accent) !important;
        }
        .btn-register {
            width: 100%;
            padding: 12px 40px;
            color: #fff;
            background: var(--accent);
            border: none;
            border-radius: 50px;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-register:hover {
            color: #fff;
            background: #c73652;
            box-shadow: 0 8px 20px rgba(233, 69, 96, .22);
            transform: translateY(-1px);
        }
        .divider {
            display: flex;
            align-items: center;
            margin: 24px 0;
            text-align: center;
        }
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--border);
        }
        .divider span {
            padding: 0 15px;
            color: var(--muted);
            font-size: .8rem;
            font-weight: 600;
        }
        .social-register .btn-social {
            width: 100%;
            padding: 10px;
            color: var(--brand);
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 50px;
            font-weight: 500;
            transition: all .2s;
        }
        .social-register .btn-social:hover {
            background: #fff5f5;
            border-color: var(--accent);
        }
        .register-box .login-link {
            text-decoration: none;
            font-weight: 600;
        }
        .register-box .login-link:hover { text-decoration: underline; }
        .alert {
            border: none;
            border-radius: 10px;
            font-size: .88rem;
        }
        .alert-danger { color: #be123c; background: #fff1f2; }
        .alert-success { color: #047857; background: #ecfdf5; }
        .alert-danger p { margin-bottom: 0; }
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
            font-size: .85rem;
        }
        .footer-heading {
            margin-bottom: 16px;
            color: white;
            font-size: .88rem;
            font-weight: 700;
        }
        .footer-link {
            display: block;
            margin-bottom: 9px;
            color: #6b7280;
            font-size: .84rem;
            transition: color .2s;
        }
        .footer-link:hover { color: white; }
        .footer-divider { border-color: #1f2937; }
        .footer-bottom { color: #4b5563; font-size: .8rem; }
        .payment-lbl {
            margin-right: 6px;
            padding: 4px 10px;
            color: #9ca3af;
            background: #1f2937;
            border-radius: 6px;
            font-size: .75rem;
            font-weight: 600;
        }
        @media (max-width: 576px) {
            .register-box { padding: 26px 20px; }
            .page-title { font-size: 1.6rem; }
            .search-box { width: 180px; }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg site-nav" id="siteNav">
    <div class="container">
        <a href="/" class="nav-logo">Shop<span>Ease</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li><a class="nav-link-item" href="/">Home</a></li>
                <li><a class="nav-link-item" href="/products">Shop</a></li>
                <li><a class="nav-link-item" href="/store/apply">Sell With Us</a></li>
                <li><a class="nav-link-item" href="/contact">Contact</a></li>
            </ul>
            <div class="ms-auto d-flex align-items-center gap-2">
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

<section class="page-header">
    <div class="container">
        <div class="page-eyebrow"><span></span> Account</div>
        <h2 class="page-title">Create Account</h2>
        <nav class="page-crumb">
            <a href="/">Home</a>
            <span class="sep">/</span>
            <span class="active">Register</span>
        </nav>
    </div>
</section>

<!-- Register Section -->
<section class="register-section">
    <div class="container">
        <div class="register-box">
            <h3><i class="fas fa-user-plus text-success me-2"></i>Create Account</h3>
            <p class="subtitle">Join ShopEase and start shopping today.</p>

            <!-- ✅ ማሳወቂያዎች -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <!-- ✅ የተስተካከለ ፎርም - ከ customers ሰንጠረዥ ጋር የሚዛመድ -->
            <form action="/register" method="post">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="first_name">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="John" value="<?= old('first_name') ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="last_name">Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Doe" value="<?= old('last_name') ?>" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="email">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="john@example.com" value="<?= old('email') ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="phone">Phone Number</label>
                    <input type="tel" name="phone" id="phone" class="form-control" placeholder="+1 234 567 890" value="<?= old('phone') ?>">
                </div>
                
                <div class="mb-3">
                    <label for="password">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Min 6 characters" required>
                    <small class="text-muted">Password must be at least 6 characters long.</small>
                </div>
                
                <div class="mb-3">
                    <label for="password_confirm">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Confirm your password" required>
                </div>
                
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">
                            I agree to the <a href="#" class="text-success">Terms & Conditions</a> and <a href="#" class="text-success">Privacy Policy</a> <span class="text-danger">*</span>
                        </label>
                    </div>
                </div>
                
                <!-- ✅ የማረጋገጫ ስህተቶች -->
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <p class="mb-0">• <?= $error ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <button type="submit" class="btn-register"><i class="fas fa-user-plus me-2"></i>Create Account</button>
            </form>

            <div class="divider">
                <span>OR</span>
            </div>

            <div class="social-register">
                <button class="btn-social" onclick="alert('Google registration will be available soon. Please use email registration.')">
                    <i class="fab fa-google text-danger"></i>Continue with Google
                </button>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted">Already have an account? <a href="/login" class="login-link">Sign In</a></p>
            </div>
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
</body>
</html>