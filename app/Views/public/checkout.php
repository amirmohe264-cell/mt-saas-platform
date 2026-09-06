<!-- app/Views/public/checkout.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ============ RESET & BASE ============ */
        * { margin: 0; padding: 0; box-sizing: border-box; }

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

        body {
            font-family: var(--font);
            background: var(--surface);
            padding-top: 92px;
            color: var(--text);
        }
        a { text-decoration: none; color: inherit; }

        /* ============ NAVBAR (matches homepage) ============ */
        .site-nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            padding: 18px 0;
            background: rgba(255,255,255,0.98);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(12px);
            transition: padding 0.3s ease, box-shadow 0.3s ease;
        }
        .site-nav.scrolled { padding: 12px 0; box-shadow: 0 2px 16px rgba(0,0,0,0.08); }
        .nav-logo {
            font-family: var(--display); font-size: 1.5rem; font-weight: 800;
            color: var(--brand); letter-spacing: -0.5px;
        }
        .nav-logo span { color: var(--accent); }
        .nav-link-item {
            font-size: 0.9rem; font-weight: 500; color: #374151;
            padding: 8px 16px; border-radius: 8px; transition: all 0.2s;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .nav-link-item:hover { color: var(--accent); background: #fff5f5; }

        /* ============ PAGE HEADER ============ */
        .page-header { background: var(--brand); color: #fff; padding: 44px 0 34px; margin-bottom: 30px; }
        .page-header h2 { font-family: var(--display); font-weight: 800; margin: 0; font-size: 1.8rem; }
        .page-header .breadcrumb { background: none; padding: 0; margin: 8px 0 0 0; }
        .page-header .breadcrumb a { color: var(--accent-light); }
        .page-header .breadcrumb .active { color: rgba(255,255,255,0.55); }
        .page-header .breadcrumb-item + .breadcrumb-item::before { color: rgba(255,255,255,0.3); }
        .badge.bg-success {
            background: var(--gold) !important; color: var(--brand);
            border-radius: 50px; font-weight: 700;
        }

        /* ============ CHECKOUT CONTAINER ============ */
        .checkout-wrapper { max-width: 1200px; margin: 0 auto; padding: 0 15px; }

        /* ============ PROGRESS STEPS ============ */
        .checkout-steps {
            display: flex; justify-content: center; align-items: center;
            margin-bottom: 40px; background: var(--white);
            padding: 20px 30px; border-radius: var(--radius-lg); box-shadow: var(--shadow);
        }
        .step-item { display: flex; align-items: center; gap: 10px; color: #9ca3af; font-weight: 500; font-size: 0.9rem; }
        .step-item .step-number {
            display: inline-flex; align-items: center; justify-content: center;
            width: 32px; height: 32px; border-radius: 50%;
            background: var(--surface); color: #9ca3af; font-weight: 700;
            font-size: 0.8rem; transition: 0.3s; border: 1.5px solid var(--border);
        }
        .step-item.active .step-number, .step-item.completed .step-number {
            background: var(--accent); color: #fff; border-color: var(--accent);
        }
        .step-item.active { color: var(--brand); }
        .step-item.completed { color: var(--accent); }
        .step-line { width: 60px; height: 2px; background: var(--border); margin: 0 10px; }
        .step-line.completed { background: var(--accent); }

        /* ============ CARD STYLES ============ */
        .checkout-card {
            background: var(--white); border-radius: var(--radius-lg); padding: 30px;
            border: 1px solid var(--border); box-shadow: var(--shadow); margin-bottom: 20px;
        }
        .checkout-card .card-title {
            font-family: var(--display); font-size: 1.1rem; font-weight: 800;
            color: var(--brand); margin-bottom: 20px; padding-bottom: 15px;
            border-bottom: 2px solid var(--surface);
        }
        .checkout-card .card-title i { color: var(--accent); margin-right: 10px; }

        /* ============ FORM STYLES ============ */
        .form-label { font-weight: 600; color: var(--brand); font-size: 0.87rem; margin-bottom: 6px; }
        .form-label .required { color: var(--accent); margin-left: 2px; }
        .form-control {
            border-radius: 10px; border: 1.5px solid var(--border);
            padding: 10px 15px; transition: 0.2s; font-size: 0.92rem;
        }
        .form-control:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(233,69,96,0.1); }
        .form-control.is-invalid { border-color: var(--accent); }
        .form-control:disabled { background: var(--surface); cursor: not-allowed; }
        .form-text { font-size: 0.8rem; color: var(--muted); }

        /* ============ ORDER SUMMARY ============ */
        .order-summary { background: var(--surface); border-radius: var(--radius); padding: 18px; margin-bottom: 18px; }
        .order-item { display: flex; align-items: center; gap: 14px; padding: 10px 0; border-bottom: 1px solid var(--border); }
        .order-item:last-child { border-bottom: none; }
        .order-item img { width: 58px; height: 58px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border); background: var(--white); }
        .order-item .item-info { flex: 1; }
        .order-item .item-name { font-weight: 600; color: var(--brand); font-size: 0.92rem; }
        .order-item .item-meta { font-size: 0.78rem; color: var(--muted); }
        .order-item .item-price { font-weight: 700; color: var(--brand); font-size: 0.95rem; }

        /* ============ PRICE BREAKDOWN ============ */
        .price-row { display: flex; justify-content: space-between; padding: 8px 0; font-size: 0.92rem; color: var(--brand); }
        .price-row.total {
            font-family: var(--display); font-weight: 800; font-size: 1.2rem;
            border-top: 2px solid var(--border); padding-top: 15px; margin-top: 10px; color: var(--brand);
        }
        .price-row .label { color: var(--muted); }
        .price-row.total .label { color: var(--brand); }

        /* ============ PAYMENT METHODS ============ */
        .payment-methods { display: flex; flex-direction: column; gap: 10px; }
        .payment-option {
            display: flex; align-items: center; gap: 12px; padding: 13px 16px;
            border: 1.5px solid var(--border); border-radius: var(--radius);
            cursor: pointer; transition: 0.2s; background: var(--white);
        }
        .payment-option:hover { border-color: var(--accent); background: #fff5f5; }
        .payment-option.selected { border-color: var(--accent); background: #fff5f5; }
        .payment-option input[type="radio"] { accent-color: var(--accent); width: 18px; height: 18px; cursor: pointer; }
        .payment-option .payment-icon { font-size: 1.4rem; color: var(--accent); width: 30px; text-align: center; }
        .payment-option .payment-name { font-weight: 700; color: var(--brand); font-size: 0.92rem; }
        .payment-option .payment-desc { font-size: 0.78rem; color: var(--muted); }

        /* ============ BUTTONS ============ */
        .btn-place-order {
            background: var(--accent); color: #fff; border: none; border-radius: 50px;
            padding: 14px 40px; font-weight: 700; font-size: 1rem; transition: 0.2s;
            width: 100%; display: flex; align-items: center; justify-content: center; gap: 10px;
            box-shadow: 0 8px 24px rgba(233,69,96,0.3);
        }
        .btn-place-order:hover { background: #c73652; color: #fff; transform: translateY(-2px); }
        .btn-place-order:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
        .btn-back {
            background: var(--surface); color: var(--brand); border: 1.5px solid var(--border);
            border-radius: 50px; padding: 12px 30px; font-weight: 600; transition: 0.2s;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-back:hover { border-color: var(--brand); background: var(--white); }

        /* ============ ALERT MESSAGES ============ */
        .alert { border-radius: var(--radius); border: none; padding: 15px 20px; }
        .alert-danger { background: #fff5f5; color: #b3273f; }
        .alert-success { background: #ecfdf5; color: #047857; }
        .alert-info { background: #eef2ff; color: #3730a3; }

        /* ============ FOOTER (matches homepage) ============ */
        .site-footer { background: #111827; padding: 60px 0 28px; margin-top: 40px; }
        .footer-logo { font-family: var(--display); font-size: 1.4rem; font-weight: 800; color: white; }
        .footer-logo span { color: var(--accent); }
        .footer-tagline { font-size: 0.85rem; color: #6b7280; margin-top: 8px; margin-bottom: 20px; max-width: 260px; }
        .footer-heading { color: white; font-size: 0.88rem; font-weight: 700; margin-bottom: 16px; }
        .footer-link { display: block; color: #6b7280; font-size: 0.84rem; margin-bottom: 9px; transition: color 0.2s; }
        .footer-link:hover { color: white; }
        .footer-news-input { background: #1f2937; border: 1px solid #374151; color: white; border-radius: 50px; padding: 10px 18px; font-size: 0.84rem; width: 100%; outline: none; transition: border 0.2s; }
        .footer-news-input:focus { border-color: var(--accent); }
        .btn-footer-sub { background: var(--accent); color: white; border: none; padding: 10px 20px; border-radius: 50px; font-size: 0.84rem; font-weight: 600; transition: background 0.2s; }
        .btn-footer-sub:hover { background: #c73652; }
        .footer-divider { border-color: #1f2937; margin: 32px 0 18px; }
        .footer-bottom { color: #4b5563; font-size: 0.8rem; }

        /* ============ RESPONSIVE ============ */
        @media (max-width: 768px) {
            body { padding-top: 84px; }
            .checkout-steps { flex-wrap: wrap; padding: 15px; gap: 10px; }
            .step-item { font-size: 0.8rem; }
            .step-line { width: 30px; }
            .checkout-card { padding: 20px; }
            .page-header { padding: 25px 0 20px; }
            .page-header h2 { font-size: 1.3rem; }
            .btn-place-order { padding: 12px 25px; font-size: 0.9rem; }
            .order-item img { width: 50px; height: 50px; }
            .payment-option { padding: 10px 12px; }
        }
        @media (max-width: 576px) {
            .checkout-card { padding: 15px; }
            .step-item .step-number { width: 26px; height: 26px; font-size: 0.7rem; }
            .step-item .step-text { display: none; }
            .step-line { width: 20px; }
        }
    </style>
</head>
<body>

<!-- ============ NAVBAR ============ -->
<nav class="site-nav" id="siteNav">
    <div class="container">
        <div class="d-flex align-items-center">
            <a href="/" class="nav-logo">Shop<span>Ease</span></a>
            <ul class="navbar-nav flex-row ms-auto gap-1">
                <li><a class="nav-link-item" href="/cart"><i class="fas fa-shopping-cart"></i> Cart</a></li>
                <li><a class="nav-link-item" href="/logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
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
                                <i class="fas fa-shield-alt me-1" style="color: var(--accent);"></i>
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
<footer class="site-footer">
    <div class="container">
        <div class="row g-4 pb-4">
            <div class="col-lg-4 col-md-6">
                <div class="footer-logo">Shop<span>Ease</span></div>
                <p class="footer-tagline">Multi-Tenant SaaS E-Commerce Platform.</p>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="footer-heading">Quick Links</h6>
                <a href="/about" class="footer-link">About Us</a>
                <a href="/contact" class="footer-link">Contact</a>
                <a href="/privacy" class="footer-link">Privacy Policy</a>
            </div>
            <div class="col-lg-3 col-6">
                <h6 class="footer-heading">Customer Service</h6>
                <a href="/help" class="footer-link">Help Center</a>
                <a href="/returns" class="footer-link">Returns</a>
                <a href="/shipping" class="footer-link">Shipping Info</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h6 class="footer-heading">Newsletter</h6>
                <p class="footer-link mb-3">Get the latest deals & updates</p>
                <form class="d-flex gap-2">
                    <input type="email" class="footer-news-input" placeholder="Your email">
                    <button type="submit" class="btn-footer-sub">Join</button>
                </form>
            </div>
        </div>
        <hr class="footer-divider">
        <p class="text-center footer-bottom mb-0">&copy; <?= date('Y') ?> ShopEase. All rights reserved.</p>
    </div>
</footer>

<!-- ============ SCRIPTS ============ -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // =============================================
        // PAYMENT METHOD SELECTION
        // =============================================
        const paymentOptions = document.querySelectorAll('.payment-option');
        paymentOptions.forEach(option => {
            option.addEventListener('click', function() {
                paymentOptions.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
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
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            if (!paymentMethod) {
                e.preventDefault();
                alert('Please select a payment method.');
                return;
            }

            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Processing...';
            spinner.classList.remove('d-none');
        });

        // =============================================
        // NAVBAR SCROLL EFFECT
        // =============================================
        window.addEventListener('scroll', function() {
            document.getElementById('siteNav').classList.toggle('scrolled', window.scrollY > 40);
        });
    });
</script>
</body>
</html>