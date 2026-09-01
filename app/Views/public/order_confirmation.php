<!-- app/Views/public/order_confirmation.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            padding-top: 80px;
        }
        .navbar {
            background: #1a2e1a !important;
            padding: 12px 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.3);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            height: 70px;
        }
        .navbar-brand {
            color: #fff !important;
            font-weight: bold;
            font-size: 1.4rem;
        }
        .navbar-brand i { color: #4caf50; }
        .navbar .nav-link { color: #d4d4d4 !important; font-weight: 500; transition: 0.3s; }
        .navbar .nav-link:hover { color: #4caf50 !important; }
        .icon-btn {
            color: #d4d4d4;
            font-size: 1.1rem;
            margin: 0 6px;
            transition: 0.3s;
            background: none;
            border: none;
            text-decoration: none;
        }
        .icon-btn:hover { color: #4caf50; transform: scale(1.1); }
        
        .confirmation-card {
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.08);
            border: 1px solid #e8f0e8;
        }
        .confirmation-card .success-icon {
            font-size: 4rem;
            color: #4caf50;
            margin-bottom: 15px;
        }
        .confirmation-card h2 {
            color: #1a2e1a;
            font-weight: 700;
        }
        .confirmation-card .subtitle {
            color: #666;
            font-size: 1.1rem;
        }
        
        .order-details-table {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e8f0e8;
            overflow: hidden;
        }
        .order-details-table .table {
            margin-bottom: 0;
        }
        .order-details-table .table th {
            background: #f8f9fa;
            border-bottom: 2px solid #e8f0e8;
            color: #555;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            padding: 12px 15px;
        }
        .order-details-table .table td {
            padding: 12px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }
        .order-details-table .table tr:last-child td {
            border-bottom: none;
        }
        
        .order-summary-box {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e8f0e8;
        }
        .order-summary-box .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .order-summary-box .summary-row:last-child {
            border-bottom: none;
            font-weight: 700;
            font-size: 1.2rem;
            color: #1a2e1a;
        }
        .order-summary-box .summary-label {
            color: #666;
        }
        .order-summary-box .summary-value {
            font-weight: 600;
            color: #1a2e1a;
        }
        
        .status-badge {
            padding: 5px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #cce5ff; color: #004085; }
        .status-processing { background: #d1ecf1; color: #0c5460; }
        .status-shipped { background: #d4edda; color: #155724; }
        .status-delivered { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        
        .btn-order-action {
            background: #4caf50;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 10px 30px;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-order-action:hover {
            background: #388e3c;
            color: #fff;
            transform: translateY(-2px);
        }
        .btn-order-secondary {
            background: #f8f9fa;
            color: #1a2e1a;
            border: 1px solid #e8f0e8;
            border-radius: 30px;
            padding: 10px 30px;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-order-secondary:hover {
            background: #e8f0e8;
            color: #1a2e1a;
            transform: translateY(-2px);
        }
        
        .order-item-image {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border-radius: 8px;
            background: #f8f9fa;
            padding: 5px;
        }
        
        .footer {
            background: #1a2e1a;
            color: #d4d4d4;
            padding: 40px 0 20px;
            margin-top: 40px;
        }
        .footer h5 { color: #fff; font-weight: 600; }
        .footer a { color: #aaa; text-decoration: none; transition: 0.3s; }
        .footer a:hover { color: #4caf50; }
        
        @media (max-width: 768px) {
            .confirmation-card { padding: 20px; }
            .order-item-image { width: 40px; height: 40px; }
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
                <li class="nav-item"><a class="nav-link" href="/contact">Contact</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <a href="/cart" class="icon-btn"><i class="fas fa-shopping-cart"></i></a>
                <a href="/logout" class="icon-btn"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </div>
</nav>

<!-- Main Content -->
<section class="py-5">
    <div class="container">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="confirmation-card">
            <!-- Success Icon -->
            <div class="text-center">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h2>Order Placed Successfully! 🎉</h2>
                <p class="subtitle">Thank you for your order. We'll send you a confirmation email shortly.</p>
            </div>

            <hr>

            <!-- Order Header -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="fw-bold"><i class="fas fa-receipt me-2 text-success"></i>Order # <?= esc($order['order_number'] ?? 'N/A') ?></h5>
                </div>
                <div class="col-md-6 text-md-end">
                    <span class="status-badge status-<?= esc($order['order_status'] ?? 'pending') ?>">
                        <?= ucfirst(esc($order['order_status'] ?? 'Pending')) ?>
                    </span>
                </div>
            </div>

            <!-- Order Details -->
            <div class="row">
                <div class="col-lg-8">
                    <h6 class="fw-bold mb-3"><i class="fas fa-box me-2 text-success"></i>Order Items</h6>
                    <div class="order-details-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $subtotal = 0;
                                if (!empty($orderItems)): 
                                    foreach ($orderItems as $item): 
                                        $itemSubtotal = $item['price'] * $item['quantity'];
                                        $subtotal += $itemSubtotal;
                                ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <?php if (!empty($item['product_image'])): ?>
                                                    <img src="<?= esc($item['product_image']) ?>" alt="<?= esc($item['product_name'] ?? 'Product') ?>" class="order-item-image">
                                                <?php else: ?>
                                                    <div class="order-item-image d-flex align-items-center justify-content-center bg-light">
                                                        <i class="fas fa-box text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div>
                                                    <div class="fw-bold"><?= esc($item['product_name'] ?? 'Unknown Product') ?></div>
                                                    <small class="text-muted">SKU: #<?= str_pad($item['product_id'], 6, '0', STR_PAD_LEFT) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>$<?= number_format($item['price'], 2) ?></td>
                                        <td><?= $item['quantity'] ?></td>
                                        <td class="text-end fw-bold">$<?= number_format($itemSubtotal, 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No items found for this order.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <h6 class="fw-bold mb-3"><i class="fas fa-calculator me-2 text-success"></i>Order Summary</h6>
                    <div class="order-summary-box">
                        <div class="summary-row">
                            <span class="summary-label">Subtotal</span>
                            <span class="summary-value">$<?= number_format($subtotal, 2) ?></span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Shipping</span>
                            <span class="summary-value"><?= ($order['shipping_cost'] ?? 0) > 0 ? '$'.number_format($order['shipping_cost'] ?? 0, 2) : 'FREE' ?></span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Tax (8%)</span>
                            <span class="summary-value">$<?= number_format($order['tax'] ?? 0, 2) ?></span>
                        </div>
                        <div class="summary-row" style="border-bottom: 2px solid #4caf50; padding-bottom: 10px; margin-bottom: 5px;">
                            <span class="summary-label fw-bold">Total</span>
                            <span class="summary-value fw-bold text-success" style="font-size: 1.3rem;">
                                $<?= number_format($order['total_amount'] ?? 0, 2) ?>
                            </span>
                        </div>
                        
                        <div class="mt-3">
                            <div class="d-flex justify-content-between py-1">
                                <span class="text-muted small">Payment Method</span>
                                <span class="fw-bold small"><?= ucfirst(str_replace('_', ' ', $order['payment_method'] ?? 'Cash on Delivery')) ?></span>
                            </div>
                            <div class="d-flex justify-content-between py-1">
                                <span class="text-muted small">Order Date</span>
                                <span class="fw-bold small"><?= date('F j, Y \a\t g:i A', strtotime($order['created_at'] ?? 'now')) ?></span>
                            </div>
                            <div class="d-flex justify-content-between py-1">
                                <span class="text-muted small">Delivery Address</span>
                                <span class="fw-bold small"><?= esc($order['shipping_address'] ?? 'N/A') ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 mt-3">
                        <a href="/products" class="btn-order-action flex-grow-1 text-center">
                            <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                        </a>
                        <a href="/dashboard#orders" class="btn-order-secondary">
                            <i class="fas fa-list me-1"></i>View Orders
                        </a>
                    </div>

                    <div class="mt-3 text-center">
                        <small class="text-muted">
                            <i class="fas fa-envelope me-1"></i> 
                            A confirmation email has been sent to your registered email address.
                        </small>
                    </div>
                </div>
            </div>
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
                    <li><a href="/terms">Terms & Conditions</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Customer Service</h5>
                <ul class="list-unstyled">
                    <li><a href="/help">Help Center</a></li>
                    <li><a href="/returns">Returns</a></li>
                    <li><a href="/shipping">Shipping Info</a></li>
                    <li><a href="/track">Track Order</a></li>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>