<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ShopEase</title>
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
        }
        .navbar {
            background: #1a2e1a !important;
            padding: 15px 0;
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
        .navbar .nav-link.active {
            color: #4caf50 !important;
        }
        .search-box {
            background: #2a402a;
            border-radius: 30px;
            padding: 5px 15px;
            border: none;
            color: #fff;
        }
        .search-box::placeholder {
            color: #aaa;
        }
        .search-box:focus {
            outline: none;
            background: #2a402a;
        }
        .icon-btn {
            color: #d4d4d4;
            font-size: 1.2rem;
            margin: 0 10px;
            transition: 0.3s;
            background: none;
            border: none;
        }
        .icon-btn:hover {
            color: #4caf50;
        }
        .login-section {
            padding: 60px 0;
        }
        .login-box {
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            border: 1px solid #e8f0e8;
            max-width: 450px;
            margin: 0 auto;
        }
        .login-box h3 {
            color: #1a2e1a;
            font-weight: 700;
        }
        .login-box .subtitle {
            color: #888;
            font-size: 0.95rem;
        }
        .login-box label {
            font-weight: 600;
            color: #1a2e1a;
        }
        .login-box .form-control {
            border-radius: 8px;
            border: 2px solid #e8f0e8;
            padding: 10px 15px;
        }
        .login-box .form-control:focus {
            border-color: #4caf50;
            box-shadow: none;
        }
        .login-box .form-control.invalid {
            border-color: #dc3545;
        }
        .btn-login {
            background: #4caf50;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 12px 40px;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            transition: 0.3s;
        }
        .btn-login:hover {
            background: #388e3c;
        }
        .btn-login:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        .login-box .forgot-link {
            color: #4caf50;
            text-decoration: none;
            font-weight: 500;
        }
        .login-box .forgot-link:hover {
            text-decoration: underline;
        }
        .login-box .register-link {
            color: #4caf50;
            text-decoration: none;
            font-weight: 600;
        }
        .login-box .register-link:hover {
            text-decoration: underline;
        }
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
        }
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e8f0e8;
        }
        .divider span {
            padding: 0 15px;
            color: #888;
            font-size: 0.9rem;
        }
        .social-login .btn-social {
            border-radius: 30px;
            padding: 10px;
            font-weight: 500;
            width: 100%;
            border: 2px solid #e8f0e8;
            background: #fff;
            transition: 0.3s;
        }
        .social-login .btn-social:hover {
            border-color: #4caf50;
            background: #f0f8f0;
        }
        .social-login .btn-social i {
            margin-right: 10px;
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
        @media (max-width: 768px) {
            .login-box {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

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
                <li class="nav-item"><a class="nav-link" href="/products">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="/cart">Cart</a></li>
                <li class="nav-item"><a class="nav-link active" href="#">Login</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <input class="search-box me-2" type="search" placeholder="Search for products...">
                <button class="icon-btn"><i class="far fa-heart"></i></button>
                <a href="/cart" class="icon-btn" style="color:#d4d4d4;text-decoration:none;"><i class="fas fa-shopping-cart"></i></a>
                <button class="icon-btn"><i class="far fa-user"></i></button>
            </div>
        </div>
    </div>
</nav>

<!-- Login Section -->
<section class="login-section">
    <div class="container">
        <div class="login-box">
            <h3><i class="fas fa-user-circle text-success me-2"></i>Welcome Back</h3>
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
    <button class="btn-social" onclick="alert('Google login will be available soon. Please use email login.')"><i class="fab fa-google text-danger"></i>Continue with Google</button>
</div>

            <div class="text-center mt-4">
               <p class="text-muted">Don't have an account? <a href="/register" class="register-link">Register Now</a></p>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5><i class="fas fa-store text-success"></i> ShopEase</h5>
                <p class="text-muted">Your one-stop shop for everything you need. Quality products, unbeatable prices.</p>
            </div>
            <div class="col-md-2 mb-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Customer Service</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Returns</a></li>
                    <li><a href="#">Shipping Info</a></li>
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
</body>
</html>