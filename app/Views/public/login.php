<!-- app/Views/public/login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
            --shadow: 0 4px 20px rgba(0,0,0,0.08);
            --font: 'Inter', sans-serif;
            --display: 'Sora', sans-serif;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font); color: var(--text); background: var(--surface); }
        a { text-decoration: none; }

        /* ─── NAVBAR (matches homepage) ─────────────── */
        .site-nav {
            padding: 18px 0;
            background: rgba(255,255,255,0.98);
            border-bottom: 1px solid var(--border);
        }
        .nav-logo {
            font-family: var(--display); font-size: 1.5rem; font-weight: 800;
            color: var(--brand); letter-spacing: -0.5px;
        }
        .nav-logo span { color: var(--accent); }
        .nav-link-item {
            font-size: 0.9rem; font-weight: 500; color: #374151;
            padding: 6px 14px; border-radius: 8px; transition: all 0.2s;
        }
        .nav-link-item:hover, .nav-link-item.active { color: var(--accent); background: #fff5f5; }
        .nav-search {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 50px; padding: 9px 18px 9px 40px;
            font-size: 0.875rem; width: 220px; outline: none; transition: all 0.2s;
        }
        .nav-search:focus { border-color: var(--accent); background: var(--white); box-shadow: 0 0 0 3px rgba(233,69,96,0.1); }
        .search-wrap { position: relative; }
        .search-ico { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 0.82rem; }
        .nav-action {
            width: 38px; height: 38px; border-radius: 50%;
            border: 1px solid var(--border); background: var(--surface);
            display: flex; align-items: center; justify-content: center;
            color: #374151; font-size: 0.95rem; transition: all 0.2s;
        }
        .nav-action:hover { border-color: var(--accent); color: var(--accent); background: #fff5f5; }

        /* ─── LOGIN BOX ───────────────────────────────── */
        .login-section { padding: 60px 0; }
        .login-box {
            background: var(--white); border-radius: var(--radius-lg); padding: 40px;
            border: 1px solid var(--border); box-shadow: var(--shadow);
            max-width: 450px; margin: 0 auto;
        }
        .login-box h3 { font-family: var(--display); color: var(--brand); font-weight: 800; }
        .login-box h3 i { color: var(--accent); }
        .login-box .subtitle { color: var(--muted); font-size: 0.95rem; }
        .login-box label { font-weight: 600; color: var(--brand); font-size: 0.88rem; }
        .login-box .form-control { border-radius: 10px; border: 1.5px solid var(--border); padding: 10px 15px; }
        .login-box .form-control:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(233,69,96,0.1); }
        .login-box .form-control.invalid { border-color: var(--accent); }
        .btn-login {
            background: var(--accent); color: #fff; border: none; border-radius: 50px;
            padding: 12px 40px; font-weight: 700; font-size: 1rem; width: 100%;
            box-shadow: 0 8px 24px rgba(233,69,96,0.3); transition: all 0.2s;
        }
        .btn-login:hover { background: #c73652; transform: translateY(-2px); }
        .btn-login:disabled { background: #ccc; cursor: not-allowed; transform: none; box-shadow: none; }
        .login-box .forgot-link { color: var(--accent); font-weight: 600; }
        .login-box .forgot-link:hover { text-decoration: underline; }
        .login-box .register-link { color: var(--accent); font-weight: 700; }
        .login-box .register-link:hover { text-decoration: underline; }

        .divider { display: flex; align-items: center; text-align: center; margin: 20px 0; }
        .divider::before, .divider::after { content: ''; flex: 1; border-bottom: 1px solid var(--border); }
        .divider span { padding: 0 15px; color: var(--muted); font-size: 0.9rem; }

        .social-login .btn-social {
            border-radius: 50px; padding: 10px; font-weight: 600; width: 100%;
            border: 1.5px solid var(--border); background: var(--white); transition: all 0.2s;
        }
        .social-login .btn-social:hover { border-color: var(--accent); background: #fff5f5; }
        .social-login .btn-social i { margin-right: 10px; }

        .alert-danger { background: #fff5f5; border: 1px solid #ffd6dc; color: #b3273f; border-radius: var(--radius); font-size: 0.88rem; }
        .alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #047857; border-radius: var(--radius); font-size: 0.88rem; }

        /* ─── FOOTER (matches homepage) ─────────────── */
        .site-footer { background: #111827; padding: 60px 0 28px; margin-top: 40px; }
        .footer-logo { font-family: var(--display); font-size: 1.4rem; font-weight: 800; color: white; }
        .footer-logo span { color: var(--accent); }
        .footer-tagline { font-size: 0.85rem; color: #6b7280; margin-top: 8px; }
        .footer-divider { border-color: #1f2937; margin: 32px 0 18px; }
        .footer-bottom { color: #4b5563; font-size: 0.8rem; }

        @media (max-width: 768px) { .login-box { padding: 30px 20px; } }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="site-nav">
    <div class="container">
        <div class="d-flex align-items-center gap-4">
            <a href="/" class="nav-logo">Shop<span>Ease</span></a>

            <ul class="navbar-nav flex-row gap-1 d-none d-lg-flex ms-2">
                <li><a href="/" class="nav-link-item">Home</a></li>
                <li><a href="/products" class="nav-link-item">Products</a></li>
                <li><a href="/cart" class="nav-link-item">Cart</a></li>
                <li><a href="#" class="nav-link-item active">Login</a></li>
            </ul>

            <div class="ms-auto d-flex align-items-center gap-2">
                <div class="search-wrap d-none d-md-block">
                    <i class="fas fa-search search-ico"></i>
                    <input type="search" class="nav-search" placeholder="Search for products...">
                </div>
                <button class="nav-action"><i class="far fa-heart"></i></button>
                <a href="/cart" class="nav-action"><i class="fas fa-shopping-cart"></i></a>
                <button class="nav-action"><i class="far fa-user"></i></button>
            </div>
        </div>
    </div>
</nav>

<!-- LOGIN SECTION -->
<section class="login-section">
    <div class="container">
        <div class="login-box">
            <h3><i class="fas fa-user-circle me-2"></i>Welcome Back</h3>
            <p class="subtitle">Sign in to your account to continue shopping.</p>

          <form action="/login" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label>Email Address <span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
    </div>
    <div class="mb-3">
        <label>Password <span class="text-danger">*</span></label>
        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remember" name="remember">
            <label class="form-check-label" for="remember">Remember me</label>
        </div>
        <a href="#" class="forgot-link">Forgot Password?</a>
    </div>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <button type="submit" class="btn-login"><i class="fas fa-sign-in-alt me-2"></i>Sign In</button>
</form>

            <div class="divider">
                <span>OR</span>
            </div>

           <div class="social-login">
    <button class="btn-social" onclick="alert('Google login will be available soon. Please use email login.')"><i class="fab fa-google" style="color: var(--accent);"></i>Continue with Google</button>
</div>

            <div class="text-center mt-4">
               <p class="text-muted">Don't have an account? <a href="/register" class="register-link">Register Now</a></p>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="site-footer">
    <div class="container">
        <div class="footer-logo">Shop<span>Ease</span></div>
        <p class="footer-tagline">Your one-stop shop for everything you need.</p>
        <hr class="footer-divider">
        <p class="text-center footer-bottom mb-0">&copy; 2026 ShopEase. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>