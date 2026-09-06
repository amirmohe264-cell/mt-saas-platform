<!-- app/Views/admin/refund_details.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Details - ShopEase Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        <?php include 'admin_styles.php'; ?>
        .detail-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e8f0e8;
            margin-bottom: 20px;
        }
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-approved { background: #d4edda; color: #155724; }
        .status-rejected { background: #f8d7da; color: #721c24; }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e8f0e8;
        }
        .form-control:focus {
            border-color: #4caf50;
            box-shadow: 0 0 0 0.2rem rgba(76,175,80,0.25);
        }
    </style>
</head>
<body id="mainBody">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="fas fa-store"></i> ShopEase</a>
        <div class="d-flex align-items-center ms-auto">
            <span class="text-white me-3 d-none d-md-inline"><i class="fas fa-shield-alt me-1"></i>Super Admin</span>
            <a href="/logout" class="icon-btn"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidebar-wrapper" id="sidebarWrapper">
    <div class="sidebar-card">
        <button class="toggle-sidebar-btn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <div class="admin-avatar"><i class="fas fa-user-shield"></i></div>
        <div class="admin-name"><?= session()->get('full_name') ?? 'Super Admin' ?></div>
        <div class="admin-role"><span class="badge bg-success">Super Admin</span></div>

        <div class="sidebar-category">Management</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/admin/dashboard'" data-tooltip="Dashboard">
                <i class="fas fa-tachometer-alt"></i><span class="menu-text">Dashboard</span>
            </li>
            <li onclick="location.href='/admin/stores'" data-tooltip="Stores">
                <i class="fas fa-store"></i><span class="menu-text">Stores</span>
            </li>
            <li onclick="location.href='/admin/delivery-companies'" data-tooltip="Delivery Companies">
                <i class="fas fa-truck"></i><span class="menu-text">Delivery Companies</span>
            </li>
            <li onclick="location.href='/admin/store-requests'" data-tooltip="Store Requests">
                <i class="fas fa-store"></i><span class="menu-text">Store Requests</span>
            </li>
            <li onclick="location.href='/admin/categories'" data-tooltip="Categories">
                <i class="fas fa-tags"></i><span class="menu-text">Categories</span>
            </li>
            <li onclick="location.href='/admin/users'" data-tooltip="Users">
                <i class="fas fa-users"></i><span class="menu-text">Users</span>
            </li>
        </ul>

        <div class="sidebar-category">Finance</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/admin/platform-fees'" data-tooltip="Platform Fees">
                <i class="fas fa-percentage"></i><span class="menu-text">Platform Fees</span>
            </li>
            <li onclick="location.href='/admin/commissions'" data-tooltip="Commissions">
                <i class="fas fa-hand-holding-usd"></i><span class="menu-text">Commissions</span>
            </li>
            <li onclick="location.href='/admin/seller-payouts'" data-tooltip="Seller Payouts">
                <i class="fas fa-money-bill-wave"></i><span class="menu-text">Seller Payouts</span>
            </li>
            <li onclick="location.href='/admin/payment-gateways'" data-tooltip="Payments">
                <i class="fas fa-credit-card"></i><span class="menu-text">Payments</span>
            </li>
            <li onclick="location.href='/admin/escrow-queue'" data-tooltip="Escrow">
                <i class="fas fa-hand-holding-usd"></i><span class="menu-text">Escrow Releases</span>
            </li>
            <li onclick="location.href='/admin/analytics'" data-tooltip="Analytics">
                <i class="fas fa-chart-bar"></i><span class="menu-text">Analytics</span>
            </li>
        </ul>

        <div class="sidebar-category">Orders & Delivery</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/admin/orders'" data-tooltip="Orders">
                <i class="fas fa-shopping-bag"></i><span class="menu-text">Orders</span>
            </li>
            <li onclick="location.href='/admin/delivery-assignments'" data-tooltip="Delivery Assignments">
                <i class="fas fa-tasks"></i><span class="menu-text">Delivery Assignments</span>
            </li>
            <li onclick="location.href='/admin/delivery-status'" data-tooltip="Delivery Status">
                <i class="fas fa-truck"></i><span class="menu-text">Delivery Status</span>
            </li>
            <li class="active" onclick="location.href='/admin/refunds'" data-tooltip="Refunds">
                <i class="fas fa-undo"></i><span class="menu-text">Refunds & Disputes</span>
            </li>
            <li onclick="location.href='/admin/products'" data-tooltip="Products">
                <i class="fas fa-box"></i><span class="menu-text">Products</span>
            </li>
        </ul>

        <div class="sidebar-category">Settings</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/admin/settings'" data-tooltip="Settings">
                <i class="fas fa-cog"></i><span class="menu-text">System Settings</span>
            </li>
            <li><a href="/logout" data-tooltip="Logout"><i class="fas fa-sign-out-alt text-danger"></i><span class="menu-text">Logout</span></a></li>
        </ul>
    </div>
</div>

<!-- Main Content -->
<section class="page-header">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-search me-2 text-success"></i>Refund Details</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a><span class="mx-2">/</span>
                    <a href="/admin/dashboard">Dashboard</a><span class="mx-2">/</span>
                    <a href="/admin/refunds">Refunds</a><span class="mx-2">/</span>
                    <span class="active">Details</span>
                </nav>
            </div>
            <div>
                <a href="/admin/refunds" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>
    </div>
</section>

<section class="main-content">
    <div class="container-fluid px-4">

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-6">
                <div class="detail-card">
                    <h6 class="fw-bold mb-3"><i class="fas fa-info-circle me-2 text-success"></i>Refund Information</h6>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="label text-muted">Order Number</div>
                            <div class="value fw-bold">#<?= $refund['order']['order_number'] ?? $refund['order_id'] ?></div>
                        </div>
                        <div class="col-6">
                            <div class="label text-muted">Refund Status</div>
                            <div><span class="status-badge status-<?= $refund['status'] ?>"><?= ucfirst($refund['status']) ?></span></div>
                        </div>
                        <div class="col-12">
                            <div class="label text-muted">Refund Reason</div>
                            <div class="value"><?= nl2br(esc($refund['reason'])) ?></div>
                        </div>
                        <div class="col-6">
                            <div class="label text-muted">Created At</div>
                            <div class="value"><?= date('M d, Y H:i', strtotime($refund['created_at'])) ?></div>
                        </div>
                        <?php if ($refund['updated_at']): ?>
                            <div class="col-6">
                                <div class="label text-muted">Updated At</div>
                                <div class="value"><?= date('M d, Y H:i', strtotime($refund['updated_at'])) ?></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="detail-card">
                    <h6 class="fw-bold mb-3"><i class="fas fa-user me-2 text-success"></i>Customer Information</h6>
                    <?php if (isset($refund['customer'])): ?>
                        <div class="row g-2">
                            <div class="col-12">
                                <div class="label text-muted">Customer Name</div>
                                <div class="value fw-bold"><?= $refund['customer']['first_name'] . ' ' . $refund['customer']['last_name'] ?></div>
                            </div>
                            <div class="col-12">
                                <div class="label text-muted">Email</div>
                                <div class="value"><?= $refund['customer']['email'] ?></div>
                            </div>
                            <div class="col-12">
                                <div class="label text-muted">Phone</div>
                                <div class="value"><?= $refund['customer']['phone'] ?? 'N/A' ?></div>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Customer information not available.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Order Details -->
        <div class="detail-card">
            <h6 class="fw-bold mb-3"><i class="fas fa-shopping-bag me-2 text-success"></i>Order Details</h6>
            <div class="row g-2">
                <div class="col-md-3">
                    <div class="label text-muted">Order Total</div>
                    <div class="value fw-bold">$<?= number_format($refund['order']['total_amount'] ?? 0, 2) ?></div>
                </div>
                <div class="col-md-3">
                    <div class="label text-muted">Payment Method</div>
                    <div class="value"><?= $refund['order']['payment_method'] ?? 'N/A' ?></div>
                </div>
                <div class="col-md-3">
                    <div class="label text-muted">Payment Status</div>
                    <div class="value"><?= ucfirst($refund['order']['payment_status'] ?? 'N/A') ?></div>
                </div>
                <div class="col-md-3">
                    <div class="label text-muted">Order Status</div>
                    <div class="value"><?= ucfirst($refund['order']['order_status'] ?? 'N/A') ?></div>
                </div>
            </div>
        </div>

        <!-- Admin Note -->
        <div class="detail-card">
            <h6 class="fw-bold mb-3"><i class="fas fa-sticky-note me-2 text-success"></i>Admin Action</h6>
            <form action="/admin/refunds/update/<?= $refund['id'] ?>" method="POST">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Admin Note</label>
                    <textarea name="admin_note" class="form-control" rows="3" placeholder="Add your decision notes here..."><?= $refund['admin_note'] ?? '' ?></textarea>
                </div>
                
                <div class="d-flex gap-2">
                    <?php if ($refund['status'] === 'pending'): ?>
                        <button type="submit" name="status" value="approved" class="btn btn-success" onclick="return confirm('Approve this refund request?')">
                            <i class="fas fa-check me-2"></i>Approve Refund
                        </button>
                        <button type="submit" name="status" value="rejected" class="btn btn-danger" onclick="return confirm('Reject this refund request?')">
                            <i class="fas fa-times me-2"></i>Reject Refund
                        </button>
                    <?php else: ?>
                        <span class="badge bg-secondary">Already <?= $refund['status'] ?></span>
                        <a href="/admin/refunds" class="btn btn-outline-secondary">Back to List</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
    var wrapper = document.getElementById('sidebarWrapper');
    var body = document.getElementById('mainBody');
    wrapper.classList.toggle('collapsed');
    body.classList.toggle('sidebar-collapsed');
}
</script>
</body>
</html>