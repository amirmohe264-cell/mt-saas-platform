<!-- app/Views/delivery_company/agents.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Agents - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        <?php include 'dashboard_styles.php'; ?>
        .agent-card {
            background: #fff;
            border-radius: 12px;
            padding: 15px 20px;
            border: 1px solid #e8f0e8;
            margin-bottom: 12px;
            transition: 0.3s;
        }
        .agent-card:hover {
            border-color: #4caf50;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .agent-card .agent-name {
            font-weight: 600;
            color: #1a2e1a;
        }
        .agent-card .agent-details {
            color: #888;
            font-size: 0.85rem;
        }
        .agent-card .agent-stats {
            font-size: 0.8rem;
        }
        .agent-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #4caf50;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
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
            <h4 class="fw-bold mb-0"><i class="fas fa-users me-2 text-success"></i>Delivery Agents</h4>
            <small class="text-muted">Manage your delivery team</small>
        </div>
        <a href="/delivery/agents/add" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Add Agent
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if (isset($agents) && !empty($agents)): ?>
        <?php foreach ($agents as $agent): ?>
            <div class="agent-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="agent-avatar me-3">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <div class="agent-name"><?= esc($agent['name']) ?></div>
                            <div class="agent-details">
                                <i class="fas fa-envelope me-1"></i><?= esc($agent['email']) ?>
                                <span class="mx-2">|</span>
                                <i class="fas fa-phone me-1"></i><?= esc($agent['phone']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="agent-stats">
                        <span class="badge bg-<?= $agent['status'] === 'active' ? 'success' : 'secondary' ?> me-2">
                            <?= ucfirst($agent['status']) ?>
                        </span>
                        <span class="badge bg-info me-2">
                            <i class="fas fa-truck me-1"></i><?= $agent['active_assignments'] ?? 0 ?> Active
                        </span>
                        <span class="badge bg-secondary">
                            <i class="fas fa-history me-1"></i><?= $agent['total_assignments'] ?? 0 ?> Total
                        </span>
                    </div>
                    <div>
                        <a href="/delivery/agents/edit/<?= $agent['id'] ?>" class="btn btn-sm btn-primary btn-sm-custom">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="/delivery/agents/toggle/<?= $agent['id'] ?>" class="btn btn-sm btn-warning btn-sm-custom" onclick="return confirm('Toggle status?')">
                            <i class="fas fa-sync"></i>
                        </a>
                        <a href="/delivery/agents/delete/<?= $agent['id'] ?>" class="btn btn-sm btn-danger btn-sm-custom" onclick="return confirm('Delete this agent?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>No delivery agents found. <a href="/delivery/agents/add" class="alert-link">Add your first agent</a>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>