<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - ShopEase</title>
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
        .confirmation-section {
            padding: 60px 0;
        }
        .confirmation-box {
            background: #fff;
            border-radius: 16px;
            padding: 50px;
            text-align: center;
            border: 1px solid #e8f0e8;
            max-width: 700px;
            margin: 0 auto;
        }
        .confirmation-box .success-icon {
            font-size: 5rem;
            color: #4caf50;
            margin-bottom: 20px;
        }
        .confirmation-box h2 {
            color: #1a2e1a;
            font-weight: 700;
        }
        .confirmation-box .order-number {
            background: #f0f8f0;
            padding: 10px 25px;
            border-radius: 30px;
            display: inline-block;
            font-weight: 600;
            color: #1a2e1a;
            margin: 15px 0;
        }
        .confirmation-box .order-number span {
            color: #4caf50;
        }
        .confirmation-box p {
            color: #555;
        }
        .order-details {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            text-align: left;
            margin-top: 20px;
        }
        .order-details .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e8f0e8;
        }
        .order-details .detail-row:last-child {
            border-bottom: none;
        }
        .order-details .label {
            color: #888;
            font-weight: 500;
        }
        .order-details .value {
            color: #1a2e1a;
            font-weight: 600;
        }
        .btn-continue-shop {
            background: #4caf50;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 12px 40px;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-continue-shop:hover {
            background: #388e3c;
            color: #fff;
        }
        .btn-order-history {
            background: transparent;
            color: #4caf50;
            border: 2px solid #4caf50;
            border-radius: 30px;
            padding: 12px 40px;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-order-history:hover {
            background: #4caf50;
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
        @media (max-width: 768px) {
            .confirmation-box {
                padding: 30px 20px;
            }
            .confirmation-box .success-icon {
                font-size: 3.5rem;
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
                <li class="nav-item"><a class="nav-link active" href="#">Order Confirmation</a></li>
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

<!-- Confirmation Section -->
<section class="confirmation-section">
    <div class="container">
        <div class="confirmation-box">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2>Order Placed Successfully!</h2>
            <p>Thank you for your order. We'll send you a confirmation email shortly.</p>
            
            <div class="order-number">
                Order # <span>ORD-2026-08-07-001</span>
            </div>

            <div class="order-details">
                <div class="detail-row">
                    <span class="label">Order Date</span>
                    <span class="value">August 7, 2026</span>
                </div>
                <div class="detail-row">
                    <span class="label">Total Amount</span>
                    <span class="value">$317.11</span>
                </div>
                <div class="detail-row">
                    <span class="label">Payment Method</span>
                    <span class="value">Cash on Delivery</span>
                </div>
                <div class="detail-row">
                    <span class="label">Delivery Address</span>
                    <span class="value">123 Main Street, New York</span>
                </div>
                <div class="detail-row">
                    <span class="label">Order Status</span>
                    <span class="value"><span class="badge bg-warning text-dark">Pending</span></span>
                </div>
            </div>

            <div class="mt-4">
                <p class="text-muted small">A confirmation email has been sent to your registered email address.</p>
            </div>

            <div class="d-flex gap-3 justify-content-center flex-wrap mt-3">
                <a href="/" class="btn-continue-shop"><i class="fas fa-shopping-bag me-2"></i>Continue Shopping</a>
                <a href="#" class="btn-order-history"><i class="fas fa-history me-2"></i>View Orders</a>
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