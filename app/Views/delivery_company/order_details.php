<!-- app/Views/delivery_company/order_details.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - ShopEase Delivery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        <?php include 'dashboard_styles.php'; ?>
        .detail-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e8f0e8;
            margin-bottom: 20px;
        }
        .detail-card .label {
            color: #888;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .detail-card .value {
            font-weight: 600;
            color: #1a2e1a;
            font-size: 1rem;
        }
        .verification-code {
            background: #f0f8f0;
            padding: 10px 15px;
            border-radius: 8px;
            font-family: monospace;
            font-size: 1.2rem;
            font-weight: 700;
            color: #4caf50;
            display: inline-block;
        }
        .status-timeline {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            padding: 15px 0;
        }
        .status-timeline .step {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .status-timeline .step .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #ddd;
        }
        .status-timeline .step .dot.completed {
            background: #4caf50;
        }
        .status-timeline .step .dot.active {
            background: #ff9800;
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.3); opacity: 0.7; }
            100% { transform: scale(1); opacity: 1; }
        }
        .status-timeline .step .line {
            width: 30px;
            height: 2px;
            background: #ddd;
        }
        .status-timeline .step .line.completed {
            background: #4caf50;
        }
        .btn-update-status {
            border-radius: 20px;
            padding: 8px 20px;
            font-size: 0.85rem;
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
            <h4 class="fw-bold mb-0"><i class="fas fa-box me-2 text-success"></i>Order Details</h4>
            <small class="text-muted">Order #<?= $assignment['order_number'] ?? $assignment['order_id'] ?></small>
        </div>
        <a href="/delivery/orders" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Orders
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <!-- Status Timeline -->
    <div class="detail-card">
        <h6 class="fw-bold mb-3"><i class="fas fa-clock me-2 text-success"></i>Delivery Status</h6>
        <div class="status-timeline">
            <?php
            $statuses = ['pending', 'assigned', 'picked_up', 'in_transit', 'delivered', 'completed'];
            $currentStatus = $assignment['status'] ?? 'pending';
            $currentIndex = array_search($currentStatus, $statuses);
            ?>
            <?php foreach ($statuses as $index => $status): ?>
                <?php if ($index > 0): ?>
                    <div class="step">
                        <div class="line <?= $index <= $currentIndex ? 'completed' : '' ?>"></div>
                    </div>
                <?php endif; ?>
                <div class="step">
                    <div class="dot <?= $index < $currentIndex ? 'completed' : ($index === $currentIndex ? 'active' : '') ?>"></div>
                    <span class="small <?= $index <= $currentIndex ? 'fw-bold text-success' : 'text-muted' ?>">
                        <?= ucfirst(str_replace('_', ' ', $status)) ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="mt-2">
            <span class="status-badge status-<?= str_replace('_', '', $currentStatus) ?>">
                Current: <?= ucfirst(str_replace('_', ' ', $currentStatus)) ?>
            </span>
        </div>
    </div>

    <!-- Verification Codes -->
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <div class="detail-card">
                <div class="label">Pickup Verification Code</div>
                <div class="verification-code"><?= $assignment['pickup_verification_code'] ?? 'N/A' ?></div>
                <small class="text-muted d-block mt-1">Store owner gives this to delivery agent</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="detail-card">
                <div class="label">Delivery Verification Code</div>
                <div class="verification-code"><?= $assignment['delivery_verification_code'] ?? 'N/A' ?></div>
                <small class="text-muted d-block mt-1">Customer gives this to delivery agent</small>
            </div>
        </div>
    </div>

    <!-- Order Info -->
    <div class="row g-3">
        <div class="col-md-6">
            <div class="detail-card">
                <h6 class="fw-bold mb-3"><i class="fas fa-shopping-bag me-2 text-success"></i>Order Information</h6>
                <div class="row g-2">
                    <div class="col-6">
                        <div class="label">Order Number</div>
                        <div class="value">#<?= $assignment['order_number'] ?? $assignment['order_id'] ?></div>
                    </div>
                    <div class="col-6">
                        <div class="label">Order Total</div>
                        <div class="value">$<?= number_format($assignment['order_total'] ?? 0, 2) ?></div>
                    </div>
                    <div class="col-6">
                        <div class="label">Store</div>
                        <div class="value"><?= $assignment['store']['store_name'] ?? 'N/A' ?></div>
                    </div>
                    <div class="col-6">
                        <div class="label">Assigned Date</div>
                        <div class="value"><?= date('M d, Y H:i', strtotime($assignment['assigned_at'] ?? $assignment['created_at'])) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="detail-card">
                <h6 class="fw-bold mb-3"><i class="fas fa-user me-2 text-success"></i>Customer Information</h6>
                <?php if (isset($assignment['customer'])): ?>
                    <div class="row g-2">
                        <div class="col-12">
                            <div class="label">Name</div>
                            <div class="value"><?= $assignment['customer']['full_name'] ?? $assignment['customer']['name'] ?? 'N/A' ?></div>
                        </div>
                        <div class="col-12">
                            <div class="label">Email</div>
                            <div class="value"><?= $assignment['customer']['email'] ?? 'N/A' ?></div>
                        </div>
                        <div class="col-12">
                            <div class="label">Phone</div>
                            <div class="value"><?= $assignment['customer']['phone'] ?? 'N/A' ?></div>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Customer information not available</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="detail-card">
        <h6 class="fw-bold mb-3"><i class="fas fa-list me-2 text-success"></i>Order Items</h6>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($assignment['order_items']) && !empty($assignment['order_items'])): ?>
                        <?php foreach ($assignment['order_items'] as $item): ?>
                            <tr>
                                <td><?= $item['product_name'] ?? 'Product #' . $item['product_id'] ?></td>
                                <td><?= $item['quantity'] ?? 0 ?></td>
                                <td>$<?= number_format($item['price'] ?? 0, 2) ?></td>
                                <td>$<?= number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0), 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">No items found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Agent Info -->
    <div class="detail-card">
        <h6 class="fw-bold mb-3"><i class="fas fa-user-check me-2 text-success"></i>Delivery Agent</h6>
        <?php if (isset($assignment['agent']) && $assignment['agent']): ?>
            <div class="row g-2">
                <div class="col-md-4">
                    <div class="label">Agent Name</div>
                    <div class="value"><?= $assignment['agent']['name'] ?? 'N/A' ?></div>
                </div>
                <div class="col-md-4">
                    <div class="label">Email</div>
                    <div class="value"><?= $assignment['agent']['email'] ?? 'N/A' ?></div>
                </div>
                <div class="col-md-4">
                    <div class="label">Phone</div>
                    <div class="value"><?= $assignment['agent']['phone'] ?? 'N/A' ?></div>
                </div>
            </div>
        <?php else: ?>
            <p class="text-muted">No agent assigned yet.</p>
            <a href="/delivery/assign/<?= $assignment['id'] ?>" class="btn btn-warning btn-sm">
                <i class="fas fa-user-plus me-2"></i>Assign Agent
            </a>
        <?php endif; ?>
    </div>

    <!-- Update Status -->
    <div class="detail-card">
        <h6 class="fw-bold mb-3"><i class="fas fa-edit me-2 text-success"></i>Update Status</h6>
        <form id="statusForm" onsubmit="updateStatus(event, <?= $assignment['id'] ?>)">
            <div class="row g-3">
                <div class="col-md-4">
                    <select name="status" id="statusSelect" class="form-select">
                        <option value="">Select Status</option>
                        <option value="picked_up">Picked Up</option>
                        <option value="in_transit">In Transit</option>
                        <option value="delivered">Delivered</option>
                        <option value="completed">Completed</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <input type="text" name="notes" id="notesInput" class="form-control" placeholder="Add notes (optional)">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-success btn-update-status w-100">
                        <i class="fas fa-save me-2"></i>Update Status
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function updateStatus(event, assignmentId) {
    event.preventDefault();
    const status = document.getElementById('statusSelect').value;
    const notes = document.getElementById('notesInput').value;

    if (!status) {
        alert('Please select a status.');
        return;
    }

    const formData = new URLSearchParams();
    formData.append('status', status);
    formData.append('notes', notes);

    fetch('/delivery/update-delivery-status/' + assignmentId, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData.toString()
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to update status.');
    });
}
</script>
</body>
</html>