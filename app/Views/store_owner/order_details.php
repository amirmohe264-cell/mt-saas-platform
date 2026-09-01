

<!-- app/Views/store_owner/order_details.php -->
<?php
if (!session()->get('tenant_id')) {
    header('Location: /login');
    exit();
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details #<?= $order['order_number'] ?? '' ?> - ShopEase Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { padding-top: 80px; background: #f8f9fa; }
 
        .navbar { position: fixed; top: 0; left: 0; right: 0; z-index: 1000; background: #1a2e1a !important; padding: 15px 0; }
        .navbar-brand { color: #fff !important; font-weight: bold; font-size: 1.5rem; }
        .navbar-brand i { color: #4caf50; }
        .navbar .nav-link { color: #d4d4d4 !important; font-weight: 500; transition: 0.3s; }
        .navbar .nav-link:hover { color: #4caf50 !important; }
        .navbar .nav-link.active { color: #4caf50 !important; }
 
        .page-header { background: #1a2e1a; color: #fff; padding: 40px 0 30px; margin-bottom: 30px; }
        .page-header h2 { font-weight: 700; }
        .page-header .breadcrumb { background: none; padding: 0; margin: 0; }
        .page-header .breadcrumb a { color: #4caf50; text-decoration: none; }
        .page-header .breadcrumb .active { color: #aaa; }
 
        .detail-card { background: #fff; border-radius: 12px; padding: 25px; border: 1px solid #e8f0e8; margin-bottom: 20px; }
        .detail-card h5 { color: #1a2e1a; font-weight: 600; margin-bottom: 15px; }
 
        .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #cce5ff; color: #004085; }
        .status-processing { background: #d1ecf1; color: #0c5460; }
        .status-shipped { background: #d4edda; color: #155724; }
        .status-delivered { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .status-refunded { background: #e2e3e5; color: #383d41; }
 
        .order-info-row { border-bottom: 1px solid #f0f0f0; padding: 8px 0; }
        .order-info-row .label { color: #888; font-size: 0.85rem; }
        .order-info-row .value { color: #1a2e1a; font-weight: 600; }
    </style>
</head>
<body>
 
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="fas fa-store"></i> ShopEase</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/store/dashboard">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="/store/products">Products</a></li>
                <li class="nav-item"><a class="nav-link active" href="/store/orders">Orders</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">Store: <?= session()->get('store_name') ?? 'Store' ?></span>
                <a href="/logout" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
    </div>
</nav>
 
<section class="page-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2><i class="fas fa-box me-2"></i>Order #<?= $order['order_number'] ?? 'N/A' ?></h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2 text-white-50">/</span>
                    <a href="/store/dashboard">Dashboard</a>
                    <span class="mx-2 text-white-50">/</span>
                    <a href="/store/orders">Orders</a>
                    <span class="mx-2 text-white-50">/</span>
                    <span class="active">#<?= $order['order_number'] ?? 'N/A' ?></span>
                </nav>
            </div>
            <a href="/store/orders" class="btn btn-outline-light btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back to Orders
            </a>
        </div>
    </div>
</section>
 
<section class="py-2">
    <div class="container">
 
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
 
        <div class="row">
            <!-- Order Info -->
            <div class="col-lg-8">
                <div class="detail-card">
                    <h5><i class="fas fa-info-circle text-success me-2"></i>Order Information</h5>
                    <div class="order-info-row d-flex justify-content-between">
                        <span class="label">Order Number</span>
                        <span class="value">#<?= esc($order['order_number'] ?? 'N/A') ?></span>
                    </div>
                    <div class="order-info-row d-flex justify-content-between">
                        <span class="label">Date Placed</span>
                        <span class="value"><?= isset($order['created_at']) ? date('M d, Y h:i A', strtotime($order['created_at'])) : 'N/A' ?></span>
                    </div>
                    <div class="order-info-row d-flex justify-content-between">
                        <span class="label">Order Status</span>
                        <span class="status-badge status-<?= strtolower($order['order_status'] ?? 'pending') ?>">
                            <?= ucfirst($order['order_status'] ?? 'Pending') ?>
                        </span>
                    </div>
                    <div class="order-info-row d-flex justify-content-between">
                        <span class="label">Payment Method</span>
                        <span class="value"><?= esc(strtoupper($order['payment_method'] ?? 'N/A')) ?></span>
                    </div>
                    <div class="order-info-row d-flex justify-content-between">
                        <span class="label">Payment Status</span>
                        <span class="status-badge status-<?= strtolower($order['payment_status'] ?? 'pending') ?>">
                            <?= ucfirst($order['payment_status'] ?? 'Pending') ?>
                        </span>
                    </div>
                    <div class="order-info-row d-flex justify-content-between">
                        <span class="label">Total Amount</span>
                        <span class="value">$<?= number_format($order['total_amount'] ?? 0, 2) ?></span>
                    </div>
                </div>
 
                <div class="detail-card">
                    <h5><i class="fas fa-truck text-success me-2"></i>Shipping Details</h5>
                    <div class="order-info-row d-flex justify-content-between">
                        <span class="label">Phone</span>
                        <span class="value"><?= esc($order['phone'] ?? 'N/A') ?></span>
                    </div>
                    <div class="order-info-row d-flex justify-content-between">
                        <span class="label">City</span>
                        <span class="value"><?= esc($order['city'] ?? 'N/A') ?></span>
                    </div>
                    <div class="order-info-row d-flex justify-content-between">
                        <span class="label">Postal Code</span>
                        <span class="value"><?= esc($order['postal_code'] ?? 'N/A') ?></span>
                    </div>
                    <div class="order-info-row">
                        <div class="label mb-1">Delivery Address</div>
                        <div class="value"><?= esc($order['shipping_address'] ?? 'N/A') ?></div>
                    </div>
                </div>
 
                <div class="detail-card">
                    <h5><i class="fas fa-boxes text-success me-2"></i>Order Items</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($orderItems)): ?>
                                    <?php foreach ($orderItems as $item): ?>
                                        <tr>
                                            <td><?= esc($item['product_name'] ?? 'Product') ?></td>
                                            <td>$<?= number_format($item['price'] ?? 0, 2) ?></td>
                                            <td><?= $item['quantity'] ?? 1 ?></td>
                                            <td>$<?= number_format($item['total'] ?? 0, 2) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="text-center text-muted py-3">No items found.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
 
            <!-- Actions Sidebar -->
            <div class="col-lg-4">
                <div class="detail-card">
                    <h5><i class="fas fa-edit text-success me-2"></i>Update Status</h5>
                    <form action="/store/orders/update-status/<?= $order['id'] ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label">Order Status</label>
                            <select name="status" class="form-select">
                                <?php
                                $statuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'];
                                $current = $order['order_status'] ?? 'pending';
                                foreach ($statuses as $s):
                                ?>
                                    <option value="<?= $s ?>" <?= $current === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-save me-2"></i>Update Status
                        </button>
                    </form>
                </div>
 
                <div class="detail-card">
                    <h5><i class="fas fa-truck-loading text-success me-2"></i>Delivery</h5>
                    <?php if (!empty($delivery) && $delivery['status'] === 'delivered'): ?>
                        <p class="text-success mb-2">
                            <i class="fas fa-check-circle me-1"></i>
                            Marked delivered on <?= isset($delivery['delivered_at']) ? date('M d, Y', strtotime($delivery['delivered_at'])) : 'N/A' ?>
                        </p>
                        <?php if (!empty($delivery['confirmed_by_customer'])): ?>
                            <p class="text-success mb-0"><i class="fas fa-user-check me-1"></i>Customer confirmed receipt.</p>
                        <?php else: ?>
                            <p class="text-warning mb-0"><i class="fas fa-hourglass-half me-1"></i>Waiting for customer confirmation. Payment is held until then.</p>
                        <?php endif; ?>
                    <?php else: ?>
                        <p class="text-muted small">Once you've shipped and handed over this order to the customer, mark it as delivered. Payment stays in escrow until the customer confirms receipt.</p>
                        <form action="/store/orders/mark-delivered/<?= $order['id'] ?>" method="post" onsubmit="return confirm('Confirm this order has been delivered to the customer?');">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-outline-success w-100">
                                <i class="fas fa-check-circle me-2"></i>Mark as Delivered
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
 
