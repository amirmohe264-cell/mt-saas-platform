<!-- app/Views/delivery_company/delivery_history.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery History - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        <?php include 'dashboard_styles.php'; ?>
        .history-item {
            background: #fff;
            border-radius: 12px;
            padding: 15px 20px;
            border: 1px solid #e8f0e8;
            margin-bottom: 12px;
            transition: 0.3s;
        }
        .history-item:hover {
            border-color: #4caf50;
        }
        .history-item .order-number {
            font-weight: 600;
            color: #1a2e1a;
        }
        .history-item .order-date {
            color: #888;
            font-size: 0.85rem;
        }
        .history-filter {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .history-filter .filter-btn {
            border-radius: 20px;
            padding: 5px 15px;
            font-size: 0.8rem;
            border: 1px solid #dee2e6;
            background: #fff;
            color: #6c757d;
            text-decoration: none;
            transition: 0.3s;
        }
        .history-filter .filter-btn:hover,
        .history-filter .filter-btn.active {
            background: #4caf50;
            color: #fff;
            border-color: #4caf50;
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
    <a href="/delivery/agents" class="menu-item">
        <i class="fas fa-users"></i>Delivery Agents
    </a>
    <a href="/delivery/history" class="menu-item active">
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
            <h4 class="fw-bold mb-0"><i class="fas fa-history me-2 text-success"></i>Delivery History</h4>
            <small class="text-muted">Complete delivery records</small>
        </div>
        <div>
            <span class="text-muted">Total: <?= $total_count ?? 0 ?> records</span>
        </div>
    </div>

    <?php if (isset($assignments) && !empty($assignments)): ?>
        <?php foreach ($assignments as $assignment): ?>
            <div class="history-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="order-number">
                            #<?= $assignment['order_number'] ?? $assignment['order_id'] ?>
                            <span class="status-badge status-<?= str_replace('_', '', $assignment['status']) ?> ms-2">
                                <?= ucfirst(str_replace('_', ' ', $assignment['status'])) ?>
                            </span>
                        </div>
                        <div class="order-date">
                            <i class="far fa-calendar-alt me-1"></i>
                            <?= date('M d, Y H:i', strtotime($assignment['created_at'])) ?>
                            <?php if (isset($assignment['agent'])): ?>
                                <span class="ms-3">
                                    <i class="fas fa-user-check me-1 text-success"></i>
                                    <?= $assignment['agent']['name'] ?? 'Unassigned' ?>
                                </span>
                            <?php endif; ?>
                            <?php if (isset($assignment['customer'])): ?>
                                <span class="ms-3">
                                    <i class="fas fa-user me-1"></i>
                                    <?= $assignment['customer']['full_name'] ?? $assignment['customer']['name'] ?? 'Customer' ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div>
                        <a href="/delivery/orders/<?= $assignment['id'] ?>" class="btn btn-sm btn-outline-success btn-sm-custom">
                            <i class="fas fa-eye"></i> View
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>No delivery history found.
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>