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
    <title>Order Details - ShopEase Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { padding-top: 80px; background: #f8f9fa; }
        .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-processing { background: #d1ecf1; color: #0c5460; }
        .status-shipped { background: #d4edda; color: #155724; }
        .status-delivered { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top" style="background: #1a2e1a !important;">
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
                <a href="/logout" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
    </div>
</nav>

<section class="py-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-box me-2 text-success"></i>Order #<?= $order['order_number'] ?></h2>
            <a href="/store/orders" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-2"></i>Back</a>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Order Items</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orderItems as $item): ?>
                                        <tr>
                                            <td><?= $item['product_name'] ?? 'Product' ?></td>
                                            <td><?= $item['quantity'] ?></td>
                                            <td>$<?= number_format($item['price'], 2) ?></td>
                                            <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end">Total:</th>
                                        <th>$<?= number_format($order['total_amount'], 2) ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Order Status</h5>
                    </div>
                    <div class="card-body">
                        <form action="/store/orders/update-status/<?= $order['id'] ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label>Current Status</label>
                                <select name="status" class="form-control">
                                    <option value="pending" <?= $order['order_status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="processing" <?= $order['order_status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
                                    <option value="shipped" <?= $order['order_status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                    <option value="delivered" <?= $order['order_status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                    <option value="cancelled" <?= $order['order_status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-save me-2"></i>Update Status
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Order Details</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Order #:</strong> <?= $order['order_number'] ?></p>
                        <p><strong>Date:</strong> <?= date('M d, Y H:i', strtotime($order['created_at'])) ?></p>
                        <p><strong>Payment Method:</strong> <?= ucfirst($order['payment_method'] ?? 'N/A') ?></p>
                        <p><strong>Payment Status:</strong> <?= ucfirst($order['payment_status'] ?? 'Pending') ?></p>
                        <hr>
                        <p><strong>Shipping Address:</strong><br>
                        <?= $order['shipping_address'] ?><br>
                        <?= $order['city'] ?? '' ?> <?= $order['postal_code'] ?? '' ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>