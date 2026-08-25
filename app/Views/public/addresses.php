<!-- app/Views/public/addresses.php -->
<?php
if (!session()->get('customer_id') && !session()->get('user_id')) {
    header('Location: /login');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Addresses - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { padding-top: 80px; background: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .address-card { background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #e8f0e8; transition: 0.3s; height: 100%; }
        .address-card:hover { border-color: #4caf50; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        .address-card .default-badge { background: #4caf50; color: #fff; padding: 3px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; }
        .address-card .address-name { font-weight: 700; color: #1a2e1a; font-size: 1.1rem; }
        .address-card .address-detail { color: #555; font-size: 0.9rem; margin-bottom: 3px; }
        .btn-default { background: #4caf50; color: #fff; border: none; border-radius: 30px; padding: 5px 15px; font-size: 0.75rem; }
        .btn-default:hover { background: #388e3c; color: #fff; }
        .btn-default-outline { background: transparent; color: #4caf50; border: 2px solid #4caf50; border-radius: 30px; padding: 5px 15px; font-size: 0.75rem; }
        .btn-default-outline:hover { background: #4caf50; color: #fff; }
        .navbar { background: #1a2e1a !important; padding: 15px 0; position: fixed; top: 0; left: 0; right: 0; z-index: 1000; }
        .navbar-brand { color: #fff !important; font-weight: bold; font-size: 1.5rem; }
        .navbar-brand i { color: #4caf50; }
        .navbar .nav-link { color: #d4d4d4 !important; font-weight: 500; }
        .navbar .nav-link:hover { color: #4caf50 !important; }
        .icon-btn { color: #d4d4d4; font-size: 1.2rem; margin: 0 8px; transition: 0.3s; background: none; border: none; text-decoration: none; }
        .icon-btn:hover { color: #4caf50; transform: scale(1.1); }
        .btn-add-address { background: #4caf50; color: #fff; border: none; border-radius: 30px; padding: 10px 25px; font-weight: 600; transition: 0.3s; text-decoration: none; display: inline-block; }
        .btn-add-address:hover { background: #388e3c; color: #fff; }
        .empty-addresses { padding: 60px 0; }
        .empty-addresses i { font-size: 4rem; color: #ddd; }
        .empty-addresses h5 { color: #1a2e1a; }
        .empty-addresses p { color: #888; }
        .footer { background: #1a2e1a; color: #d4d4d4; padding: 40px 0 20px; margin-top: 40px; }
        .footer h5 { color: #fff; }
        .footer a { color: #aaa; text-decoration: none; }
        .footer a:hover { color: #4caf50; }
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
                <li class="nav-item"><a class="nav-link" href="/dashboard">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active" href="#">Addresses</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <a href="/logout" class="icon-btn"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </div>
</nav>

<section class="py-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-address-book me-2 text-success"></i>My Addresses</h2>
            <a href="/addresses/add" class="btn-add-address"><i class="fas fa-plus me-2"></i>Add New Address</a>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if (!empty($addresses)): ?>
            <div class="row">
                <?php foreach ($addresses as $address): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="address-card">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <?php if ($address['address_name']): ?>
                                        <div class="address-name">
                                            <i class="fas fa-tag me-1 text-success"></i><?= esc($address['address_name']) ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($address['is_default']): ?>
                                        <span class="default-badge"><i class="fas fa-check me-1"></i>Default</span>
                                    <?php endif; ?>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="/addresses/edit/<?= $address['id'] ?>"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                        <?php if (!$address['is_default']): ?>
                                            <li><a class="dropdown-item" href="/addresses/set-default/<?= $address['id'] ?>"><i class="fas fa-check-circle me-2"></i>Set as Default</a></li>
                                        <?php endif; ?>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="/addresses/delete/<?= $address['id'] ?>" onclick="return confirm('Are you sure you want to delete this address?')"><i class="fas fa-trash me-2"></i>Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="address-detail"><strong><?= esc($address['first_name']) ?> <?= esc($address['last_name']) ?></strong></div>
                                <div class="address-detail"><?= esc($address['address_line1']) ?></div>
                                <?php if (!empty($address['address_line2'])): ?>
                                    <div class="address-detail"><?= esc($address['address_line2']) ?></div>
                                <?php endif; ?>
                                <div class="address-detail"><?= esc($address['city']) ?>, <?= esc($address['state'] ?? '') ?> <?= esc($address['postal_code'] ?? '') ?></div>
                                <div class="address-detail"><?= esc($address['country']) ?></div>
                                <div class="address-detail"><i class="fas fa-phone me-1"></i><?= esc($address['phone']) ?></div>
                            </div>
                            <div class="mt-3">
                                <a href="/addresses/edit/<?= $address['id'] ?>" class="btn btn-sm btn-outline-success"><i class="fas fa-edit me-1"></i>Edit</a>
                                <?php if (!$address['is_default']): ?>
                                    <a href="/addresses/set-default/<?= $address['id'] ?>" class="btn btn-sm btn-default-outline"><i class="fas fa-check me-1"></i>Set Default</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-addresses text-center">
                <i class="fas fa-address-book"></i>
                <h5>No saved addresses</h5>
                <p>You haven't added any addresses yet.</p>
                <a href="/addresses/add" class="btn btn-success"><i class="fas fa-plus me-2"></i>Add Your First Address</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>