<!-- app/Views/delivery_company/agents_add.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Agent - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        <?php include 'dashboard_styles.php'; ?>
        .form-card {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            border: 1px solid #e8f0e8;
        }
        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e8f0e8;
        }
        .form-control:focus, .form-select:focus {
            border-color: #4caf50;
            box-shadow: 0 0 0 0.2rem rgba(76,175,80,0.25);
        }
        .btn-success {
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="/delivery/dashboard">
            <i class="fas fa-truck me-2"></i>ShopEase Delivery
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a href="/delivery/logout" class="icon-btn" style="color:#d4d4d4;">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidebar">
    <div class="company-info">
        <div class="avatar"><i class="fas fa-truck"></i></div>
        <div class="name"><?= session()->get('delivery_company_name') ?? 'Delivery Company' ?></div>
        <div class="email"><?= session()->get('delivery_company_email') ?? '' ?></div>
    </div>

    <div class="menu-category">Main</div>
    <a href="/delivery/dashboard" class="menu-item">
        <i class="fas fa-tachometer-alt"></i>Dashboard
    </a>
    <a href="/delivery/orders" class="menu-item">
        <i class="fas fa-list"></i>Delivery Orders
    </a>
      <a href="/delivery/assign" class="menu-item">
        <i class="fas fa-user-plus"></i>Assign Delivery
    </a>
    <a href="/delivery/active" class="menu-item">
        <i class="fas fa-spinner"></i>Active Deliveries
    </a>
    <a href="/delivery/completed" class="menu-item">
        <i class="fas fa-check-circle"></i>Completed Deliveries
    </a>

    <div class="menu-category">Management</div>
    <a href="/delivery/agents" class="menu-item active">
        <i class="fas fa-users"></i>Delivery Agents
    </a>
    <a href="/delivery/history" class="menu-item">
        <i class="fas fa-history"></i>Delivery History
    </a>

    <div class="menu-category">Account</div>
    <a href="/delivery/change-password" class="menu-item">
        <i class="fas fa-key"></i>Change Password
    </a>
    <a href="/delivery/logout" class="menu-item" style="color:#dc3545;">
        <i class="fas fa-sign-out-alt"></i>Logout
    </a>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0"><i class="fas fa-user-plus me-2 text-success"></i>Add Delivery Agent</h4>
            <small class="text-muted">Add a new agent to your delivery team</small>
        </div>
        <a href="/delivery/agents" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="form-card">
        <form action="/delivery/agents/store" method="POST">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="Enter full name" required value="<?= old('name') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" placeholder="agent@email.com" required value="<?= old('email') ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Phone <span class="text-danger">*</span></label>
                <input type="text" name="phone" class="form-control" placeholder="Enter phone number" required value="<?= old('phone') ?>">
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-2"></i>Add Agent
                </button>
                <a href="/delivery/agents" class="btn btn-outline-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>