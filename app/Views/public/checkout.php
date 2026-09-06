<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* ============ RESET & BASE ============ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            padding-top: 80px;
            color: #1a2e1a;
        }

        /* ============ NAVBAR ============ */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: #1a2e1a !important;
            padding: 15px 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.3);
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

        /* ============ PAGE HEADER ============ */
        .page-header {
            background: #1a2e1a;
            color: #fff;
            padding: 40px 0 30px;
            margin-bottom: 30px;
        }
        .page-header h2 {
            font-weight: 700;
            margin: 0;
        }
        .page-header .breadcrumb {
            background: none;
            padding: 0;
            margin: 5px 0 0 0;
        }
        .page-header .breadcrumb a {
            color: #4caf50;
            text-decoration: none;
        }
        .page-header .breadcrumb .active {
            color: #aaa;
        }
        .page-header .breadcrumb-item+.breadcrumb-item::before {
            color: #666;
        }

        /* ============ CHECKOUT CONTAINER ============ */
        .checkout-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* ============ PROGRESS STEPS ============ */
        .checkout-steps {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0;
            margin-bottom: 40px;
            background: #fff;
            padding: 20px 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .step-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #999;
            font-weight: 500;
            font-size: 0.9rem;
        }
        .step-item .step-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #e0e0e0;
            color: #999;
            font-weight: 700;
            font-size: 0.8rem;
            transition: 0.3s;
        }
        .step-item.active .step-number {
            background: #4caf50;
            color: #fff;
        }
        .step-item.completed .step-number {
            background: #4caf50;
            color: #fff;
        }
        .step-item.active {
            color: #1a2e1a;
        }
        .step-item.completed {
            color: #4caf50;
        }
        .step-line {
            width: 60px;
            height: 2px;
            background: #e0e0e0;
            margin: 0 10px;
        }
        .step-line.completed {
            background: #4caf50;
        }

        /* ============ CARD STYLES ============ */
        .checkout-card {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            border: 1px solid #e8f0e8;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        .checkout-card .card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1a2e1a;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f2f5;
        }
        .checkout-card .card-title i {
            color: #4caf50;
            margin-right: 10px;
        }

        /* ============ FORM STYLES ============ */
        .form-label {
            font-weight: 600;
            color: #1a2e1a;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        .form-label .required {
            color: #dc3545;
            margin-left: 2px;
        }
        .form-control {
            border-radius: 8px;
            border: 2px solid #e8f0e8;
            padding: 10px 15px;
            transition: 0.3s;
            font-size: 0.95rem;
        }
        .form-control:focus {
            border-color: #4caf50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.15);
        }
        .form-control.is-invalid {
            border-color: #dc3545;
        }
        .form-control:disabled {
            background: #f8f9fa;
            cursor: not-allowed;
        }
        .form-text {
            font-size: 0.8rem;
            color: #6c757d;
        }
        .form-text i {
            margin-right: 4px;
        }

        /* ============ ORDER SUMMARY ============ */
        .order-summary {
            background: #f8faf8;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .order-summary .summary-title {
            font-weight: 700;
            color: #1a2e1a;
            font-size: 1rem;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e8f0e8;
        }
        .order-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 10px 0;
            border-bottom: 1px solid #e8f0e8;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .order-item img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e8f0e8;
        }
        .order-item .item-info {
            flex: 1;
        }
        .order-item .item-name {
            font-weight: 600;
            color: #1a2e1a;
            font-size: 0.95rem;
        }
        .order-item .item-meta {
            font-size: 0.8rem;
            color: #6c757d;
        }
        .order-item .item-price {
            font-weight: 700;
            color: #1a2e1a;
            font-size: 1rem;
        }

        /* ============ PRICE BREAKDOWN ============ */
        .price-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 0.95rem;
            color: #1a2e1a;
        }
        .price-row.total {
            font-weight: 700;
            font-size: 1.2rem;
            border-top: 2px solid #e8f0e8;
            padding-top: 15px;
            margin-top: 10px;
            color: #1a2e1a;
        }
        .price-row .label {
            color: #6c757d;
        }
        .price-row.total .label {
            color: #1a2e1a;
        }

        /* ============ PAYMENT METHODS ============ */
        .payment-methods {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .payment-option {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            border: 2px solid #e8f0e8;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
            background: #fff;
        }
        .payment-option:hover {
            border-color: #4caf50;
            background: #f8faf8;
        }
        .payment-option.selected {
            border-color: #4caf50;
            background: #e8f5e9;
        }
        .payment-option input[type="radio"] {
            accent-color: #4caf50;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        .payment-option .payment-icon {
            font-size: 1.5rem;
            color: #4caf50;
            width: 30px;
            text-align: center;
        }
        .payment-option .payment-name {
            font-weight: 600;
            color: #1a2e1a;
        }
        .payment-option .payment-desc {
            font-size: 0.8rem;
            color: #6c757d;
        }

        /* ============ BUTTONS ============ */
        .btn-place-order {
            background: #4caf50;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 14px 40px;
            font-weight: 700;
            font-size: 1rem;
            transition: 0.3s;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn-place-order:hover {
            background: #388e3c;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(76, 175, 80, 0.3);
        }
        .btn-place-order:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        .btn-back {
            background: #6c757d;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 12px 30px;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-back:hover {
            background: #5a6268;
            color: #fff;
        }

        /* ============ ALERT MESSAGES ============ */
        .alert {
            border-radius: 8px;
            border: none;
            padding: 15px 20px;
        }
        .alert-danger {
            background: #fde8e8;
            color: #721c24;
        }
        .alert-success {
            background: #e8f5e9;
            color: #155724;
        }
        .alert-info {
            background: #e3f2fd;
            color: #0c5460;
        }

        /* ============ RESPONSIVE ============ */
        @media (max-width: 768px) {
            body {
                padding-top: 70px;
            }
            .checkout-steps {
                flex-wrap: wrap;
                padding: 15px;
                gap: 10px;
            }
            .step-item {
                font-size: 0.8rem;
            }
            .step-line {
                width: 30px;
            }
            .checkout-card {
                padding: 20px;
            }
            .page-header {
                padding: 25px 0 20px;
            }
            .page-header h2 {
                font-size: 1.3rem;
            }
            .btn-place-order {
                padding: 12px 25px;
                font-size: 0.9rem;
            }
            .order-item img {
                width: 50px;
                height: 50px;
            }
            .payment-option {
                padding: 10px 12px;
            }
        }

        @media (max-width: 576px) {
            .checkout-card {
                padding: 15px;
            }
            .step-item .step-number {
                width: 26px;
                height: 26px;
                font-size: 0.7rem;
            }
            .step-item .step-text {
                display: none;
            }
            .step-line {
                width: 20px;
            }
            .row.gap-3 {
                gap: 15px !important;
            }
        }

        /* ============ UTILITY ============ */
        .text-muted-2 {
            color: #6c757d;
        }
        .text-success-2 {
            color: #4caf50;
        }
        .gap-3 {
            gap: 1rem;
        }
        .mt-20 {
            margin-top: 20px;
        }
        .mb-20 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<!-- ============ NAVBAR ============ -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="fas fa-store"></i> ShopEase
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/cart">
                        <i class="fas fa-shopping-cart"></i> Cart
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- ============ PAGE HEADER ============ -->
<section class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2><i class="fas fa-shopping-bag me-2"></i>Checkout</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/cart">Cart</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4 text-md-end">
                <span class="badge bg-success fs-6 px-3 py-2">
                    <i class="fas fa-lock me-1"></i> Secure Checkout
                </span>
            </div>
        </div>
    </div>
</section>

<!-- ============ CHECKOUT CONTENT ============ -->
<section class="py-4">
    <div class="container">
        
        <!-- Alert Messages -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- ============ CHECKOUT STEPS ============ -->
        <div class="checkout-steps">
            <div class="step-item completed">
                <span class="step-number"><i class="fas fa-check"></i></span>
                <span class="step-text">Cart</span>
            </div>
            <div class="step-line completed"></div>
            <div class="step-item active">
                <span class="step-number">2</span>
                <span class="step-text">Checkout</span>
            </div>
            <div class="step-line"></div>
            <div class="step-item">
                <span class="step-number">3</span>
                <span class="step-text">Confirmation</span>
            </div>
        </div>

        <!-- ============ CHECKOUT FORM ============ -->
        <form action="/checkout/process" method="post" id="checkoutForm">
            <?= csrf_field() ?>
            
            <div class="row g-4">
                <!-- ============ LEFT COLUMN - BILLING DETAILS ============ -->
                <div class="col-lg-8">
                    
                    <!-- Shipping Information -->
                    <div class="checkout-card">
                        <h5 class="card-title">
                            <i class="fas fa-truck"></i> Shipping Information
                        </h5>
                        
                        <div class="row g-3">
                            <!-- First Name -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    First Name <span class="required">*</span>
                                </label>
                                <input type="text" 
                                       name="first_name" 
                                       class="form-control <?= session('errors.first_name') ? 'is-invalid' : '' ?>" 
                                       placeholder="Enter first name" 
                                       value="<?= old('first_name', $user['first_name'] ?? '') ?>" 
                                       required>
                                <?php if (session('errors.first_name')): ?>
                                    <div class="invalid-feedback"><?= session('errors.first_name') ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Last Name -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    Last Name <span class="required">*</span>
                                </label>
                                <input type="text" 
                                       name="last_name" 
                                       class="form-control <?= session('errors.last_name') ? 'is-invalid' : '' ?>" 
                                       placeholder="Enter last name" 
                                       value="<?= old('last_name', $user['last_name'] ?? '') ?>" 
                                       required>
                                <?php if (session('errors.last_name')): ?>
                                    <div class="invalid-feedback"><?= session('errors.last_name') ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label">Email Address</label>
                                <input type="email" 
                                       name="email" 
                                       class="form-control" 
                                       value="<?= old('email', $user['email'] ?? '') ?>" 
                                       readonly 
                                       disabled>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i> Email cannot be changed
                                </small>
                            </div>
                            
                            <!-- Phone -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    Phone Number <span class="required">*</span>
                                </label>
                                <input type="tel" 
                                       name="phone" 
                                       class="form-control <?= session('errors.phone') ? 'is-invalid' : '' ?>" 
                                       placeholder="Enter phone number" 
                                       value="<?= old('phone', $user['phone'] ?? '') ?>" 
                                       required>
                                <?php if (session('errors.phone')): ?>
                                    <div class="invalid-feedback"><?= session('errors.phone') ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Delivery Address -->
                            <div class="col-12">
                                <label class="form-label">
                                    Delivery Address <span class="required">*</span>
                                </label>
                                <textarea name="address" 
                                          class="form-control <?= session('errors.address') ? 'is-invalid' : '' ?>" 
                                          rows="3" 
                                          placeholder="Enter your full delivery address" 
                                          required><?= old('address', $user['address'] ?? '') ?></textarea>
                                <?php if (session('errors.address')): ?>
                                    <div class="invalid-feedback"><?= session('errors.address') ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- City -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    City <span class="required">*</span>
                                </label>
                                <input type="text" 
                                       name="city" 
                                       class="form-control <?= session('errors.city') ? 'is-invalid' : '' ?>" 
                                       placeholder="Enter city" 
                                       value="<?= old('city', $user['city'] ?? '') ?>" 
                                       required>
                                <?php if (session('errors.city')): ?>
                                    <div class="invalid-feedback"><?= session('errors.city') ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Postal Code -->
                            <div class="col-md-6">
                                <label class="form-label">Postal Code</label>
                                <input type="text" 
                                       name="postal_code" 
                                       class="form-control <?= session('errors.postal_code') ? 'is-invalid' : '' ?>" 
                                       placeholder="Enter postal code" 
                                       value="<?= old('postal_code', $user['postal_code'] ?? '') ?>">
                                <?php if (session('errors.postal_code')): ?>
                                    <div class="invalid-feedback"><?= session('errors.postal_code') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="checkout-card">
                        <h5 class="card-title">
                            <i class="fas fa-credit-card"></i> Payment Method
                        </h5>
                        
                        <div class="payment-methods">
                            <!-- Chapa -->
                          <?php if (($gatewaySettings['chapa_enabled'] ?? '1') === '1'): ?>
<label class="payment-option <?= old('payment_method', 'chapa') == 'chapa' ? 'selected' : '' ?>">
    <input type="radio" 
           name="payment_method" 
           value="chapa" 
           <?= old('payment_method', 'chapa') == 'chapa' ? 'checked' : '' ?>>
    <span class="payment-icon">
        <i class="fas fa-university"></i>
    </span>
    <div>
        <div class="payment-name">Chapa</div>
        <div class="payment-desc">Pay with Chapa (Credit/Debit Card, Bank Transfer)</div>
    </div>
</label>
<?php endif; ?>
                            
                            <!-- Telebirr -->
                            <label class="payment-option <?= old('payment_method') == 'telebirr' ? 'selected' : '' ?>">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="telebirr" 
                                       <?= old('payment_method') == 'telebirr' ? 'checked' : '' ?>>
                                <span class="payment-icon">
                                    <i class="fas fa-mobile-alt"></i>
                                </span>
                                <div>
                                    <div class="payment-name">Telebirr</div>
                                    <div class="payment-desc">Pay with Telebirr mobile money</div>
                                </div>
                            </label>
                            
                            <!-- Cash on Delivery -->
                            <label class="payment-option <?= old('payment_method') == 'cod' ? 'selected' : '' ?>">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="cod" 
                                       <?= old('payment_method') == 'cod' ? 'checked' : '' ?>>
                                <span class="payment-icon">
                                    <i class="fas fa-money-bill-wave"></i>
                                </span>
                                <div>
                                    <div class="payment-name">Cash on Delivery</div>
                                    <div class="payment-desc">Pay when you receive your order</div>
                                </div>
                            </label>
                        </div>
                        <?php if (session('errors.payment_method')): ?>
                            <div class="text-danger mt-2 small"><?= session('errors.payment_method') ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap gap-3">
                        <a href="/cart" class="btn-back">
                            <i class="fas fa-arrow-left"></i> Back to Cart
                        </a>
                        <button type="submit" class="btn-place-order" id="placeOrderBtn">
                            <i class="fas fa-lock"></i> Place Order
                            <span class="spinner-border spinner-border-sm d-none" id="orderSpinner"></span>
                        </button>
                    </div>
                </div>

                <!-- ============ RIGHT COLUMN - ORDER SUMMARY ============ -->
                <div class="col-lg-4">
                    <div class="checkout-card">
                        <h5 class="card-title">
                            <i class="fas fa-receipt"></i> Order Summary
                        </h5>

                        <!-- Order Items -->
                        <div class="order-summary">
                            <?php if (!empty($cartItems)): ?>
                                <?php foreach ($cartItems as $item): ?>
                                    <div class="order-item">
                                        <img src="<?= $item['image'] ?? 'https://via.placeholder.com/60x60?text=Product' ?>" 
                                             alt="<?= $item['name'] ?? 'Product' ?>">
                                        <div class="item-info">
                                            <div class="item-name"><?= $item['name'] ?? 'Product' ?></div>
                                            <div class="item-meta">Qty: <?= $item['quantity'] ?? 1 ?></div>
                                        </div>
                                        <div class="item-price">
                                            $<?= number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center text-muted py-3">
                                    <i class="fas fa-shopping-cart fa-2x mb-2 d-block"></i>
                                    Your cart is empty
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="price-breakdown">
                            <div class="price-row">
                                <span class="label">Subtotal</span>
                                <span>$<?= number_format($subtotal ?? 0, 2) ?></span>
                            </div>
                            <div class="price-row">
                                <span class="label">Shipping</span>
                                <span>$<?= number_format($shipping ?? 5.00, 2) ?></span>
                            </div>
                            <div class="price-breakdown">
    
    <div class="price-row">
        <span class="label">Platform Fee <small class="text-muted">(paid to store owner's platform cut)</small></span>
        <span>$<?= number_format($platformFee ?? 0, 2) ?></span>
    </div>
    
                            <div class="price-row">
                                <span class="label">Tax (8%)</span>
                                <span>$<?= number_format($tax ?? 0, 2) ?></span>
                            </div>
                            <div class="price-row total">
                                <span class="label">Total</span>
                                <span>$<?= number_format($total ?? 0, 2) ?></span>
                            </div>
                        </div>

                        <!-- Secure Checkout Note -->
                        <div class="mt-3 pt-3 border-top text-center">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt text-success me-1"></i>
                                Your payment information is secure
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- ============ FOOTER ============ -->
<footer class="footer mt-5" style="background: #1a2e1a; color: #d4d4d4; padding: 40px 0 20px;">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5><i class="fas fa-store text-success"></i> ShopEase</h5>
                <p class="text-muted">Multi-Tenant SaaS E-Commerce Platform.</p>
            </div>
            <div class="col-md-2 mb-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="/about" style="color:#aaa;text-decoration:none;">About Us</a></li>
                    <li><a href="/contact" style="color:#aaa;text-decoration:none;">Contact</a></li>
                    <li><a href="/privacy" style="color:#aaa;text-decoration:none;">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Customer Service</h5>
                <ul class="list-unstyled">
                    <li><a href="/help" style="color:#aaa;text-decoration:none;">Help Center</a></li>
                    <li><a href="/returns" style="color:#aaa;text-decoration:none;">Returns</a></li>
                    <li><a href="/shipping" style="color:#aaa;text-decoration:none;">Shipping Info</a></li>
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
        <p class="text-center text-muted small">&copy; <?= date('Y') ?> ShopEase. All rights reserved.</p>
    </div>
</footer>

<!-- ============ SCRIPTS ============ -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // =============================================
        // PAYMENT METHOD SELECTION
        // =============================================
        const paymentOptions = document.querySelectorAll('.payment-option');
        paymentOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Remove selected class from all
                paymentOptions.forEach(opt => opt.classList.remove('selected'));
                // Add selected class to clicked
                this.classList.add('selected');
                // Check the radio button
                const radio = this.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                }
            });
        });

        // =============================================
        // FORM SUBMISSION
        // =============================================
        const form = document.getElementById('checkoutForm');
        const submitBtn = document.getElementById('placeOrderBtn');
        const spinner = document.getElementById('orderSpinner');

        form.addEventListener('submit', function(e) {
            // Validate payment method
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            if (!paymentMethod) {
                e.preventDefault();
                alert('Please select a payment method.');
                return;
            }

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Processing...';
            spinner.classList.remove('d-none');
        });

        // =============================================
        // NAVBAR SCROLL EFFECT
        // =============================================
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.padding = '8px 0';
                navbar.style.background = 'rgba(26, 46, 26, 0.88) !important';
                navbar.style.backdropFilter = 'blur(12px)';
            } else {
                navbar.style.padding = '15px 0';
                navbar.style.background = '#1a2e1a !important';
                navbar.style.backdropFilter = 'none';
            }
        });
    });
</script>
</body>
</html>