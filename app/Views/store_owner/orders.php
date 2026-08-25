<!-- app/Views/store_owner/orders.php -->
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
    <title>Orders - ShopEase Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { padding-top: 80px; background: #f8f9fa; }
        .order-card { background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #e8f0e8; margin-bottom: 15px; }
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
            <h2><i class="fas fa-box me-2 text-success"></i>Orders</h2>
            <span class="badge bg-primary"><?= count($orders) ?> orders</span>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
                <div class="order-card">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <strong>#<?= $order['order_number'] ?></strong>
                            <br>
                            <small class="text-muted"><?= date('M d, Y H:i', strtotime($order['created_at'])) ?></small>
                        </div>
                        <div class="col-md-2">
                            <span class="status-badge status-<?= strtolower($order['order_status']) ?>">
                                <?= ucfirst($order['order_status'] ?? 'Pending') ?>
                            </span>
                        </div>
                        <div class="col-md-2">
                            <strong>$<?= number_format($order['total_amount'], 2) ?></strong>
                        </div>
                        <div class="col-md-2">
                            <small class="text-muted">Customer ID: <?= $order['customer_id'] ?></small>
                        </div>
                        <div class="col-md-3 text-end">
                            <a href="/store/orders/<?= $order['id'] ?>" class="btn btn-sm btn-success">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                <h5>No orders yet</h5>
                <p class="text-muted">Orders will appear here once customers place them.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>