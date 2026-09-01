<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escrow Release Queue - ShopEase Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { padding-top: 80px; background: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

        .navbar { position: fixed; top: 0; left: 0; right: 0; z-index: 1000; background: #1a2e1a !important; padding: 15px 0; }
        .navbar-brand { color: #fff !important; font-weight: bold; font-size: 1.5rem; }
        .navbar-brand i { color: #4caf50; }
        .navbar .nav-link { color: #d4d4d4 !important; font-weight: 500; }
        .navbar .nav-link.active { color: #4caf50 !important; }

        .page-header { background: #1a2e1a; color: #fff; padding: 40px 0 30px; margin-bottom: 30px; }
        .page-header h2 { font-weight: 700; }
        .page-header .breadcrumb { background: none; padding: 0; margin: 0; }
        .page-header .breadcrumb a { color: #4caf50; text-decoration: none; }
        .page-header .breadcrumb .active { color: #aaa; }

        .escrow-card { background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #e8f0e8; margin-bottom: 15px; }
        .escrow-card .order-number { font-weight: 700; color: #1a2e1a; }
        .escrow-card .store-name { color: #4caf50; font-weight: 600; }
        .escrow-card .amount-row { display: flex; justify-content: space-between; padding: 4px 0; font-size: 0.9rem; }
        .escrow-card .amount-row .label { color: #888; }
        .escrow-card .payout-amount { font-size: 1.3rem; font-weight: 700; color: #1a2e1a; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="fas fa-store"></i> ShopEase</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/admin/dashboard">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/stores">Stores</a></li>
                <li class="nav-item"><a class="nav-link active" href="/admin/escrow-queue">Escrow Releases</a></li>
            </ul>
            <a href="/logout" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<section class="page-header">
    <div class="container">
        <h2><i class="fas fa-hand-holding-usd me-2"></i>Escrow Release Queue</h2>
        <nav class="breadcrumb">
            <a href="/">Home</a>
            <span class="mx-2 text-white-50">/</span>
            <a href="/admin/dashboard">Dashboard</a>
            <span class="mx-2 text-white-50">/</span>
            <span class="active">Escrow Releases</span>
        </nav>
    </div>
</section>

<div class="container py-2">

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <p class="text-muted mb-4">
        These orders have been confirmed as received by the customer. Payment is held in escrow until you approve the release to the store owner.
    </p>

    <?php if (!empty($releasable)): ?>
        <?php foreach ($releasable as $item): ?>
            <div class="escrow-card">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="order-number">#<?= esc($item['order_number']) ?></div>
                        <div class="store-name"><?= esc($item['store_name']) ?></div>
                        <div class="text-muted small">
                            Customer: <?= esc($item['first_name'] . ' ' . $item['last_name']) ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-muted small">Confirmed by customer on</div>
                        <div><?= isset($item['confirmed_at']) ? date('M d, Y h:i A', strtotime($item['confirmed_at'])) : 'N/A' ?></div>
                    </div>
                    <div class="col-md-4">
                        <div class="amount-row">
                            <span class="label">Order Total</span>
                            <span>$<?= number_format($item['amount'], 2) ?></span>
                        </div>
                        <div class="amount-row">
                            <span class="label">Platform Fee</span>
                            <span>$<?= number_format($item['platform_fee'], 2) ?></span>
                        </div>
                        <div class="amount-row">
                            <span class="label">Payout to Store</span>
                            <span class="payout-amount">$<?= number_format($item['store_owner_amount'], 2) ?></span>
                        </div>
                    </div>
                    <div class="col-md-2 text-end">
                        <form action="/admin/escrow-release/<?= $item['payment_id'] ?>" method="post" onsubmit="return confirm('Release $<?= number_format($item['store_owner_amount'], 2) ?> to <?= esc($item['store_name']) ?>? This cannot be undone.');">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check-circle me-1"></i> Release
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
            <h5>All caught up</h5>
            <p class="text-muted">No payments are currently waiting for release.</p>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>