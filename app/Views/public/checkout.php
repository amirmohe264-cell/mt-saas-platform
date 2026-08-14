<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - ShopEase</title>
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
        .page-header {
            background: #1a2e1a;
            color: #fff;
            padding: 40px 0 30px;
        }
        .page-header h2 {
            font-weight: 700;
        }
        .page-header .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
        }
        .page-header .breadcrumb a {
            color: #4caf50;
            text-decoration: none;
        }
        .page-header .breadcrumb .active {
            color: #aaa;
        }
        .checkout-form label {
            font-weight: 600;
            color: #1a2e1a;
        }
        .checkout-form .form-control {
            border-radius: 8px;
            border: 2px solid #e8f0e8;
            padding: 10px 15px;
        }
        .checkout-form .form-control:focus {
            border-color: #4caf50;
            box-shadow: none;
        }
        .checkout-form .form-control.invalid {
            border-color: #dc3545;
        }
        .order-summary {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            border: 1px solid #e8f0e8;
        }
        .order-summary h5 {
            color: #1a2e1a;
            font-weight: 700;
        }
        .order-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .order-item img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border-radius: 8px;
            background: #fff;
            padding: 5px;
            border: 1px solid #e8f0e8;
        }
        .order-item .item-details {
            flex: 1;
        }
        .order-item .item-name {
            font-weight: 600;
            color: #1a2e1a;
        }
        .order-item .item-price {
            color: #1a2e1a;
            font-weight: 700;
        }
        .order-item .item-qty {
            color: #888;
            font-size: 0.9rem;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .summary-row.total {
            border-bottom: none;
            font-weight: 700;
            font-size: 1.2rem;
            color: #1a2e1a;
        }
        .payment-method {
            padding: 12px 15px;
            border: 2px solid #e8f0e8;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
            margin-bottom: 10px;
        }
        .payment-method:hover {
            border-color: #4caf50;
        }
        .payment-method.active {
            border-color: #4caf50;
            background: #f0f8f0;
        }
        .payment-method input[type="radio"] {
            margin-right: 10px;
        }
        .btn-place-order {
            background: #4caf50;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 14px 40px;
            font-weight: 700;
            font-size: 1.1rem;
            width: 100%;
            transition: 0.3s;
        }
        .btn-place-order:hover {
            background: #388e3c;
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
            .order-item img {
                width: 50px;
                height: 50px;
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
                <li class="nav-item"><a class="nav-link active" href="#">Checkout</a></li>
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

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-credit-card me-2"></i>Checkout</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2 text-white-50">/</span>
                    <a href="/cart">Cart</a>
                    <span class="mx-2 text-white-50">/</span>
                    <span class="active">Checkout</span>
                </nav>
            </div>
            <div>
                <span class="text-white-50">Step 2 of 3</span>
            </div>
        </div>
    </div>
</section>

<!-- Checkout Section -->
<section class="py-4">
    <div class="container">
        <div class="row">
            <!-- Billing Details -->
            <div class="col-lg-8">
                <div class="bg-white rounded-3 p-4 border">
                    <h5 class="fw-bold mb-3"><i class="fas fa-user me-2 text-success"></i>Billing Details</h5>
                    <form class="checkout-form">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="John" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Doe" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" placeholder="john@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label>Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" placeholder="+1 234 567 890" required>
                        </div>
                        <div class="mb-3">
                            <label>Delivery Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="123 Main Street" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>City <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="New York" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Postal Code</label>
                                <input type="text" class="form-control" placeholder="10001">
                            </div>
                        </div>

                        <hr>

                        <!-- Payment Method -->
                        <h5 class="fw-bold mb-3"><i class="fas fa-credit-card me-2 text-success"></i>Payment Method</h5>
                        <div class="payment-method active">
                            <input type="radio" name="payment" value="cod" checked>
                            <i class="fas fa-money-bill-wave text-success me-2"></i>Cash on Delivery
                        </div>
                        <div class="payment-method">
                            <input type="radio" name="payment" value="online">
                            <i class="fas fa-credit-card text-primary me-2"></i>Online Payment (Coming Soon)
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="order-summary">
                    <h5>Order Summary</h5>
                    
                    <div class="order-item">
                        <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=200&h=200&fit=crop" alt="Product">
                        <div class="item-details">
                            <div class="item-name">Wireless Earbuds</div>
                            <div class="item-price">$89.99 <span class="item-qty">x 1</span></div>
                        </div>
                    </div>
                    
                    <div class="order-item">
                        <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200&h=200&fit=crop" alt="Product">
                        <div class="item-details">
                            <div class="item-name">Smartwatch Pro</div>
                            <div class="item-price">$199.00 <span class="item-qty">x 1</span></div>
                        </div>
                    </div>

                    <div class="summary-row mt-2">
                        <span>Subtotal</span>
                        <span>$288.99</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>$5.00</span>
                    </div>
                    <div class="summary-row">
                        <span>Tax</span>
                        <span>$23.12</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>$317.11</span>
                    </div>

                   <a href="/order-confirmation" class="btn-place-order mt-3" style="text-decoration:none;display:inline-block;text-align:center;"><i class="fas fa-check-circle me-2"></i>Place Order</a>
                    <div class="text-center mt-3">
                        <small class="text-muted"><i class="fas fa-lock me-1"></i>Secure checkout</small>
                    </div>
                </div>
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