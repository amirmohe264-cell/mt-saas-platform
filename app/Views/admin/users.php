<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { padding-top: 80px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8f9fa; }
        .navbar { position: fixed; top: 0; left: 0; right: 0; z-index: 1000; background: #1a2e1a !important; padding: 15px 0; transition: all 0.3s ease; box-shadow: 0 2px 20px rgba(0,0,0,0.3); }
        .navbar-scrolled { background: rgba(26, 46, 26, 0.88) !important; backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); box-shadow: 0 4px 30px rgba(0,0,0,0.5); padding: 8px 0; }
        .navbar-brand { color: #fff !important; font-weight: bold; font-size: 1.5rem; }
        .navbar-brand i { color: #4caf50; }
        .navbar .nav-link { color: #d4d4d4 !important; font-weight: 500; transition: 0.3s; }
        .navbar .nav-link:hover { color: #4caf50 !important; }
        .icon-btn { color: #d4d4d4; font-size: 1.2rem; margin: 0 8px; transition: 0.3s; background: none; border: none; }
        .icon-btn:hover { color: #4caf50; transform: scale(1.1); }
        .page-header { background: #1a2e1a; color: #fff; padding: 40px 0 30px; }
        .page-header h2 { font-weight: 700; }
        .page-header .breadcrumb { background: none; padding: 0; margin: 0; }
        .page-header .breadcrumb a { color: #4caf50; text-decoration: none; }
        .page-header .breadcrumb .active { color: #aaa; }
        .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .status-active { background: #d4edda; color: #155724; }
        .status-suspended { background: #f8d7da; color: #721c24; }
        .footer { background: #1a2e1a; color: #d4d4d4; padding: 40px 0 20px; margin-top: 40px; }
        .footer h5 { color: #fff; font-weight: 600; }
        .footer a { color: #aaa; text-decoration: none; transition: 0.3s; }
        .footer a:hover { color: #4caf50; }
        .nav-tabs .nav-link { color: #555; font-weight: 500; }
        .nav-tabs .nav-link.active { color: #4caf50; border-color: #4caf50 #4caf50 #fff; }
        .nav-tabs .nav-link:hover { border-color: #e8f0e8; }
        .action-btns .btn { margin: 2px; }
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
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="#">Manage Users</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <span class="text-white me-3"><i class="fas fa-shield-alt me-1"></i>Super Admin</span>
                <a href="/logout" class="icon-btn" style="color:#d4d4d4;text-decoration:none;"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </div>
</nav>

<section class="page-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-users me-2"></i>Manage Users</h2>
                <nav class="breadcrumb">
                    <a href="/admin/dashboard">Dashboard</a>
                    <span class="mx-2 text-white-50">/</span>
                    <span class="active">Users</span>
                </nav>
            </div>
            <div>
                <span class="text-white-50">Total Users: <?= (isset($customers) ? count($customers) : 0) + (isset($storeOwners) ? count($storeOwners) : 0) ?></span>
            </div>
        </div>
    </div>
</section>

<section class="py-4">
    <div class="container">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <div class="bg-white rounded-3 p-4 border">
            <ul class="nav nav-tabs mb-4" id="userTabs">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#customers">
                        <i class="fas fa-user me-1"></i>Customers
                        <span class="badge bg-secondary ms-1"><?= isset($customers) ? count($customers) : 0 ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#storeOwners">
                        <i class="fas fa-store me-1"></i>Store Owners
                        <span class="badge bg-secondary ms-1"><?= isset($storeOwners) ? count($storeOwners) : 0 ?></span>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Customers Tab -->
                <div class="tab-pane fade show active" id="customers">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Joined</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($customers) && !empty($customers)): ?>
                                    <?php foreach ($customers as $customer): ?>
                                        <tr>
                                            <td><strong><?= esc($customer['first_name'] . ' ' . $customer['last_name']) ?></strong></td>
                                            <td><?= esc($customer['email']) ?></td>
                                            <td><?= esc($customer['phone'] ?? 'N/A') ?></td>
                                            <td><?= date('M d, Y', strtotime($customer['created_at'])) ?></td>
                                            <td>
                                                <span class="status-badge <?= $customer['is_active'] ? 'status-active' : 'status-suspended' ?>">
                                                    <?= $customer['is_active'] ? 'Active' : 'Suspended' ?>
                                                </span>
                                            </td>
                                            <td class="action-btns">
                                                <a href="/admin/users/customer/toggle/<?= $customer['id'] ?>" class="btn btn-sm <?= $customer['is_active'] ? 'btn-outline-warning' : 'btn-outline-success' ?>" onclick="return confirm('Toggle customer status?')">
                                                    <i class="fas <?= $customer['is_active'] ? 'fa-ban' : 'fa-undo' ?>"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">No customers registered yet.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Store Owners Tab -->
                <div class="tab-pane fade" id="storeOwners">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Store Owner</th>
                                    <th>Email</th>
                                    <th>Store</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($storeOwners) && !empty($storeOwners)): ?>
                                    <?php foreach ($storeOwners as $owner): ?>
                                        <tr>
                                            <td><strong><?= esc($owner['full_name']) ?></strong></td>
                                            <td><?= esc($owner['email']) ?></td>
                                            <td><?= esc($owner['store_name'] ?? 'No store') ?></td>
                                            <td>
                                                <span class="status-badge <?= $owner['is_active'] ? 'status-active' : 'status-suspended' ?>">
                                                    <?= $owner['is_active'] ? 'Active' : 'Suspended' ?>
                                                </span>
                                            </td>
                                            <td class="action-btns">
                                                <a href="/admin/users/store-owner/toggle/<?= $owner['id'] ?>" class="btn btn-sm <?= $owner['is_active'] ? 'btn-outline-warning' : 'btn-outline-success' ?>" onclick="return confirm('Toggle store owner status?')">
                                                    <i class="fas <?= $owner['is_active'] ? 'fa-ban' : 'fa-undo' ?>"></i>
                                                </a>
                                                <a href="/admin/users/store-owner/reset-password/<?= $owner['id'] ?>" class="btn btn-sm btn-outline-info" onclick="return confirm('Reset password for this store owner?')">
                                                    <i class="fas fa-key"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">No store owners registered yet.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer">
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5><i class="fas fa-store text-success"></i> ShopEase</h5>
                <p class="text-muted">Multi-Tenant SaaS E-Commerce Platform.</p>
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
        <p class="text-center text-muted small">&copy; 2026 ShopEase. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.addEventListener('scroll', function() {
        var navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    });
</script>
</body>
</html>