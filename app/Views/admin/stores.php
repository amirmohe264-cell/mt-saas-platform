<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Stores - ShopEase</title>
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
        .btn-add { background: #4caf50; color: #fff; border: none; border-radius: 30px; padding: 10px 25px; font-weight: 600; transition: 0.3s; text-decoration: none; display: inline-block; }
        .btn-add:hover { background: #388e3c; color: #fff; }
        .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .status-active { background: #d4edda; color: #155724; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-suspended { background: #f8d7da; color: #721c24; }
        .status-disabled { background: #e2e3e5; color: #383d41; }
        .footer { background: #1a2e1a; color: #d4d4d4; padding: 40px 0 20px; margin-top: 40px; }
        .footer h5 { color: #fff; font-weight: 600; }
        .footer a { color: #aaa; text-decoration: none; transition: 0.3s; }
        .footer a:hover { color: #4caf50; }
        .action-btns .btn { margin: 2px; }
        .store-card { background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #e8f0e8; transition: 0.3s; margin-bottom: 15px; }
        .store-card:hover { border-color: #4caf50; box-shadow: 0 2px 15px rgba(0,0,0,0.05); }
        .store-card .store-name { font-size: 1.1rem; font-weight: 700; color: #1a2e1a; }
        .store-card .store-owner { color: #555; font-size: 0.95rem; }
        .store-card .store-email { color: #888; font-size: 0.85rem; }
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
                <li class="nav-item"><a class="nav-link active" href="#">Manage Stores</a></li>
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
                <h2><i class="fas fa-store me-2"></i>Manage Stores</h2>
                <nav class="breadcrumb">
                    <a href="/admin/dashboard">Dashboard</a>
                    <span class="mx-2 text-white-50">/</span>
                    <span class="active">Stores</span>
                </nav>
            </div>
            <div>
                <a href="/admin/store/create" class="btn-add"><i class="fas fa-plus me-2"></i>Add Store</a>
            </div>
        </div>
    </div>
</section>

<section class="py-4">
    <div class="container">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success" id="successAlert">
                <?= session()->getFlashdata('success') ?>
                <?php if (strpos(session()->getFlashdata('success'), 'Password:') !== false): ?>
                    <br>
                    <button class="btn btn-sm btn-outline-success mt-2" onclick="copyPassword()">
                        <i class="fas fa-copy me-1"></i>Copy Password
                    </button>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('warning')): ?>
            <div class="alert alert-warning"><?= session()->getFlashdata('warning') ?></div>
        <?php endif; ?>

        <div class="bg-white rounded-3 p-4 border">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Store Name</th>
                            <th>Owner</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($tenants) && !empty($tenants)): ?>
                            <?php $count = 1; ?>
                            <?php foreach ($tenants as $tenant): ?>
                                <tr>
                                    <td><?= $count++ ?></td>
                                    <td><strong><?= esc($tenant['store_name']) ?></strong></td>
                                    <td><?= esc($tenant['owner_name'] ?? 'No owner') ?></td>
                                    <td><?= esc($tenant['owner_email'] ?? 'No email') ?></td>
                                    <td><?= esc($tenant['contact_phone'] ?? 'N/A') ?></td>
                                    <td>
                                        <span class="status-badge 
                                            <?= $tenant['status'] === 'active' ? 'status-active' : '' ?>
                                            <?= $tenant['status'] === 'pending' ? 'status-pending' : '' ?>
                                            <?= $tenant['status'] === 'suspended' ? 'status-suspended' : '' ?>
                                            <?= $tenant['status'] === 'disabled' ? 'status-disabled' : '' ?>">
                                            <?= ucfirst($tenant['status'] ?? 'Pending') ?>
                                        </span>
                                    </td>
                                    <td class="action-btns">
                                        <a href="/admin/store/edit/<?= $tenant['id'] ?>" class="btn btn-sm btn-outline-success" title="Edit Store">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/admin/store/suspend/<?= $tenant['id'] ?>" class="btn btn-sm btn-outline-warning" title="<?= $tenant['status'] === 'suspended' ? 'Activate' : 'Suspend' ?>" onclick="return confirm('Are you sure you want to toggle this store\'s status?')">
                                            <i class="fas <?= $tenant['status'] === 'suspended' ? 'fa-undo' : 'fa-ban' ?>"></i>
                                        </a>
                                        <a href="/admin/store/reset-password/<?= $tenant['id'] ?>" class="btn btn-sm btn-outline-info" title="Reset Password" onclick="return confirm('Are you sure you want to reset the password for this store owner?')">
                                            <i class="fas fa-key"></i>
                                        </a>
                                        <a href="/admin/store/delete/<?= $tenant['id'] ?>" class="btn btn-sm btn-outline-danger" title="Delete Store" onclick="return confirm('Are you sure you want to delete this store? This action cannot be undone!')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-store fa-3x mb-3 d-block"></i>
                                    No stores found. Click "Add Store" to create your first store.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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

    function copyPassword() {
        var alertText = document.getElementById('successAlert').innerText;
        var match = alertText.match(/Password:\s*([a-zA-Z0-9!@#$%^&*()]+)/);
        if (match) {
            var password = match[1];
            navigator.clipboard.writeText(password).then(function() {
                alert('✅ Password copied: ' + password);
            }, function() {
                var textarea = document.createElement('textarea');
                textarea.value = password;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
                alert('✅ Password copied: ' + password);
            });
        }
    }
</script>
</body>
</html>