<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ShopEase</title>
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
        .register-section {
            padding: 60px 0;
        }
        .register-box {
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            border: 1px solid #e8f0e8;
            max-width: 500px;
            margin: 0 auto;
        }
        .register-box h3 {
            color: #1a2e1a;
            font-weight: 700;
        }
        .register-box .subtitle {
            color: #888;
            font-size: 0.95rem;
        }
        .register-box label {
            font-weight: 600;
            color: #1a2e1a;
        }
        .register-box .form-control {
            border-radius: 8px;
            border: 2px solid #e8f0e8;
            padding: 10px 15px;
        }
        .register-box .form-control:focus {
            border-color: #4caf50;
            box-shadow: none;
        }
        .btn-register {
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
        .btn-register:hover {
            background: #388e3c;
        }
        .register-box .login-link {
            color: #4caf50;
            text-decoration: none;
            font-weight: 600;
        }
        .register-box .login-link:hover {
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
        .social-register .btn-social {
            border-radius: 30px;
            padding: 10px;
            font-weight: 500;
            width: 100%;
            border: 2px solid #e8f0e8;
            background: #fff;
            transition: 0.3s;
        }
        .social-register .btn-social:hover {
            border-color: #4caf50;
            background: #f0f8f0;
        }
        .social-register .btn-social i {
            margin-right: 10px;
        }
        .password-requirements {
            font-size: 0.8rem;
            color: #888;
            margin-top: 5px;
        }
        .password-requirements .valid {
            color: #4caf50;
        }
        .password-requirements .invalid {
            color: #dc3545;
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
            .register-box {
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
                <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                <li class="nav-item"><a class="nav-link active" href="#">Register</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <input class="search-box me-2" type="search" placeholder="Search for products...">
                <button class="icon-btn"><i class="far fa-heart"></i></button>
                <a href="/cart" class="icon-btn" style="color:#d4d4d4;text-decoration:none;"><i class="fas fa-shopping-cart"></i></a>
                <a href="/login" class="icon-btn" style="color:#d4d4d4;text-decoration:none;"><i class="far fa-user"></i></a>
            </div>
        </div>
    </div>
</nav>

<!-- Register Section -->
<section class="register-section">
    <div class="container">
        <div class="register-box">
            <h3><i class="fas fa-user-plus text-success me-2"></i>Create Account</h3>
            <p class="subtitle">Join ShopEase and start shopping today.</p>

           <form action="/register" method="post">
    <?= csrf_field() ?>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label>First Name <span class="text-danger">*</span></label>
            <input type="text" name="first_name" class="form-control" placeholder="John" required>
        </div>
        <div class="col-md-6 mb-3">
            <label>Last Name <span class="text-danger">*</span></label>
            <input type="text" name="last_name" class="form-control" placeholder="Doe" required>
        </div>
    </div>
    <div class="mb-3">
        <label>Email Address <span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
    </div>
    <div class="mb-3">
        <label>Phone Number</label>
        <input type="tel" name="phone" class="form-control" placeholder="+1 234 567 890">
    </div>
    <div class="mb-3">
        <label>Password <span class="text-danger">*</span></label>
        <input type="password" name="password" class="form-control" placeholder="Min 8 characters" required>
    </div>
    <div class="mb-3">
        <label>Confirm Password <span class="text-danger">*</span></label>
        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm your password" required>
    </div>
    <div class="mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
            <label class="form-check-label" for="terms">
                I agree to the <a href="#" class="text-success">Terms & Conditions</a> and <a href="#" class="text-success">Privacy Policy</a>
            </label>
        </div>
    </div>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <p class="mb-0"><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <button type="submit" class="btn-register"><i class="fas fa-user-plus me-2"></i>Create Account</button>
</form>

            <div class="divider">
                <span>OR</span>
            </div>

           <div class="social-register">
    <button class="btn-social" onclick="alert('Google registration will be available soon. Please use email registration.')"><i class="fab fa-google text-danger"></i>Continue with Google</button>
</div>

            <div class="text-center mt-4">
                <p class="text-muted">Already have an account? <a href="/login" class="login-link">Sign In</a></p>
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