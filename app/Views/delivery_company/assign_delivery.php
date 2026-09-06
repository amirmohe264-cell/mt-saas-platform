<!-- app/Views/delivery_company/assign_delivery.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Delivery - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            padding-left: 280px;
            padding-top: 80px;
            transition: padding-left 0.3s ease;
            min-height: 100vh;
        }

        /* Navbar */
        .navbar {
            background: #1a2e1a !important;
            padding: 15px 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.3);
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1050;
        }
        .navbar-brand {
            color: #fff !important;
            font-weight: bold;
            font-size: 1.5rem;
        }
        .navbar-brand i { color: #4caf50; }
        .icon-btn {
            color: #d4d4d4;
            font-size: 1.2rem;
            margin: 0 8px;
            transition: 0.3s;
            background: none;
            border: none;
            text-decoration: none;
        }
        .icon-btn:hover { color: #4caf50; transform: scale(1.1); }

        /* Sidebar */
        .sidebar-wrapper {
            position: fixed;
            top: 80px;
            left: 0;
            width: 280px;
            height: calc(100vh - 80px);
            overflow-y: auto;
            background: #fff;
            border-right: 1px solid #e8f0e8;
            padding: 20px 15px;
            z-index: 1000;
            transition: width 0.3s ease;
        }
        .sidebar-wrapper::-webkit-scrollbar { width: 4px; }
        .sidebar-wrapper::-webkit-scrollbar-thumb { background: #4caf50; border-radius: 4px; }
        .sidebar-wrapper::-webkit-scrollbar-track { background: #e8f0e8; }

        .sidebar-wrapper.collapsed { width: 70px; }
        .sidebar-wrapper.collapsed .company-name,
        .sidebar-wrapper.collapsed .company-email,
        .sidebar-wrapper.collapsed .sidebar-category { display: none; }
        .sidebar-wrapper.collapsed .sidebar-menu li { padding: 10px; justify-content: center; }
        .sidebar-wrapper.collapsed .sidebar-menu li .menu-text { display: none; }
        .sidebar-wrapper.collapsed .sidebar-menu li i { margin-right: 0; font-size: 1.2rem; }
        .sidebar-wrapper.collapsed .sidebar-menu li { position: relative; }
        .sidebar-wrapper.collapsed .sidebar-menu li:hover::after {
            content: attr(data-tooltip);
            position: absolute; left: 100%; top: 50%; transform: translateY(-50%);
            background: #1a2e1a; color: #fff; padding: 5px 12px; border-radius: 6px;
            font-size: 0.8rem; white-space: nowrap; z-index: 999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2); margin-left: 8px;
        }
        .sidebar-wrapper.collapsed .company-avatar { width: 45px; height: 45px; font-size: 1.2rem; }

        body.sidebar-collapsed { padding-left: 70px; }

        .sidebar-card .company-avatar {
            width: 70px; height: 70px; border-radius: 50%;
            background: #4caf50; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; margin: 0 auto 10px;
            transition: all 0.3s ease;
        }
        .sidebar-card .company-name {
            text-align: center; font-weight: 700; color: #1a2e1a; font-size: 1rem;
        }
        .sidebar-card .company-email {
            text-align: center; font-size: 0.8rem; color: #888;
        }

        .toggle-sidebar-btn {
            background: #4caf50; color: #fff; border: none; border-radius: 8px;
            padding: 8px 12px; font-size: 1rem; cursor: pointer; width: 100%;
            margin-bottom: 10px; display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .toggle-sidebar-btn:hover { background: #388e3c; }

        .sidebar-category {
            font-size: 0.65rem; font-weight: 700; color: #aaa;
            text-transform: uppercase; letter-spacing: 0.5px;
            padding: 15px 10px 5px; border-top: 1px solid #f0f0f0; margin-top: 5px;
        }
        .sidebar-category:first-child { border-top: none; margin-top: 0; padding-top: 5px; }

        .sidebar-menu { list-style: none; padding: 0; margin: 0; }
        .sidebar-menu li {
            padding: 10px 12px; border-radius: 8px; cursor: pointer;
            color: #555; font-size: 0.9rem; display: flex; align-items: center;
            transition: all 0.3s ease;
        }
        .sidebar-menu li:hover { background: #f0f8f0; color: #4caf50; }
        .sidebar-menu li.active { background: #f0f8f0; color: #4caf50; font-weight: 600; }
        .sidebar-menu li i { margin-right: 12px; width: 20px; text-align: center; font-size: 1rem; }
        .sidebar-menu li .menu-text { flex: 1; }
        .sidebar-menu li a { color: inherit; text-decoration: none; display: flex; align-items: center; width: 100%; }

        /* Main Content */
        .main-content {
            padding: 20px 30px;
            min-height: calc(100vh - 160px);
        }

        /* Page Header */
        .page-header {
            background: #f8f9fa;
            color: #1a2e1a;
            padding: 20px 0 20px;
            border-bottom: 1px solid #e8f0e8;
        }
        .page-header h2 {
            font-weight: 700;
            color: #1a2e1a;
        }
        .page-header .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
        }
        .page-header .breadcrumb a {
            color: #4caf50;
            text-decoration: none;
        }
        .page-header .breadcrumb .active {
            color: #888;
        }

        /* Form Card */
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

        .assignment-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            border-left: 4px solid #4caf50;
        }
        .verification-code {
            background: #f0f8f0;
            padding: 8px 15px;
            border-radius: 8px;
            font-family: monospace;
            font-size: 1rem;
            font-weight: 700;
            color: #4caf50;
            display: inline-block;
        }
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-assigned { background: #cce5ff; color: #004085; }
        .status-picked_up { background: #d1ecf1; color: #0c5460; }
        .status-in_transit { background: #d4edda; color: #155724; }
        .status-delivered { background: #d4edda; color: #155724; }
        .status-completed { background: #c3e6cb; color: #155724; }
        .status-failed { background: #f8d7da; color: #721c24; }

        @media (max-width: 992px) {
            body { padding-left: 0; }
            .sidebar-wrapper {
                position: relative; top: 0; width: 100%; height: auto;
                border-right: none; border-bottom: 1px solid #e8f0e8;
            }
            .sidebar-wrapper.collapsed { width: 100%; }
            .sidebar-wrapper.collapsed .sidebar-menu li { justify-content: flex-start; }
            .sidebar-wrapper.collapsed .sidebar-menu li .menu-text { display: inline; }
            .sidebar-wrapper.collapsed .sidebar-menu li i { margin-right: 12px; }
            .sidebar-wrapper.collapsed .company-name,
            .sidebar-wrapper.collapsed .company-email,
            .sidebar-wrapper.collapsed .sidebar-category { display: block; }
            body.sidebar-collapsed { padding-left: 0; }
            .main-content { padding: 15px; }
        }
    </style>
</head>
<body id="mainBody">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/delivery/dashboard">
            <i class="fas fa-truck"></i> ShopEase Delivery
        </a>
        <div class="d-flex align-items-center ms-auto">
            <span class="text-white me-3 d-none d-md-inline">
                <i class="fas fa-store me-1"></i><?= session()->get('delivery_company_name') ?? 'Company' ?>
            </span>
            <a href="/delivery/logout" class="icon-btn">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidebar-wrapper" id="sidebarWrapper">
    <div class="sidebar-card">
        <button class="toggle-sidebar-btn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>

        <div class="company-avatar">
            <i class="fas fa-truck"></i>
        </div>
        <div class="company-name"><?= session()->get('delivery_company_name') ?? 'Delivery Company' ?></div>
        <div class="company-email"><?= session()->get('delivery_company_email') ?? '' ?></div>

        <!-- MAIN -->
        <div class="sidebar-category">Main</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/delivery/dashboard'" data-tooltip="Dashboard">
                <i class="fas fa-tachometer-alt"></i>
                <span class="menu-text">Dashboard</span>
            </li>
            <li class="active" onclick="location.href='/delivery/orders'" data-tooltip="Delivery Orders">
                <i class="fas fa-list"></i>
                <span class="menu-text">Delivery Orders</span>
            </li>
             <li class="<?= $active_menu == 'assign' ? 'active' : '' ?>" onclick="location.href='/delivery/assign'" data-tooltip="Assign Delivery">
                <i class="fas fa-user-plus"></i>
                <span class="menu-text">Assign Delivery</span>
            </li>
            <li onclick="location.href='/delivery/active'" data-tooltip="Active Deliveries">
                <i class="fas fa-spinner"></i>
                <span class="menu-text">Active Deliveries</span>
            </li>
            <li onclick="location.href='/delivery/completed'" data-tooltip="Completed Deliveries">
                <i class="fas fa-check-circle"></i>
                <span class="menu-text">Completed Deliveries</span>
            </li>
        </ul>

        <!-- MANAGEMENT -->
        <div class="sidebar-category">Management</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/delivery/agents'" data-tooltip="Delivery Agents">
                <i class="fas fa-users"></i>
                <span class="menu-text">Delivery Agents</span>
            </li>
            <li onclick="location.href='/delivery/history'" data-tooltip="Delivery History">
                <i class="fas fa-history"></i>
                <span class="menu-text">Delivery History</span>
            </li>
        </ul>

        <!-- ACCOUNT -->
        <div class="sidebar-category">Account</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/delivery/change-password'" data-tooltip="Change Password">
                <i class="fas fa-key"></i>
                <span class="menu-text">Change Password</span>
            </li>
            <li>
                <a href="/delivery/logout" data-tooltip="Logout">
                    <i class="fas fa-sign-out-alt text-danger"></i>
                    <span class="menu-text">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Page Header -->
<section class="page-header">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-user-plus me-2 text-success"></i>Assign Delivery</h2>
                <nav class="breadcrumb">
                    <a href="/delivery/dashboard">Dashboard</a>
                    <span class="mx-2">/</span>
                    <a href="/delivery/orders">Delivery Orders</a>
                    <span class="mx-2">/</span>
                    <span class="active">Assign Delivery</span>
                </nav>
            </div>
            <div>
                <a href="/delivery/orders" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="main-content">
    <div class="container-fluid px-4">

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <!-- Assignment Info -->
        <div class="assignment-info mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div><strong>Order #:</strong> <?= $assignment['order_id'] ?></div>
                    <div><strong>Status:</strong> <span class="status-badge status-<?= str_replace('_', '', $assignment['status']) ?>"><?= ucfirst(str_replace('_', ' ', $assignment['status'])) ?></span></div>
                </div>
                <div class="col-md-6">
                    <div><strong>Pickup Code:</strong> <span class="verification-code"><?= $assignment['pickup_verification_code'] ?></span></div>
                    <div><strong>Delivery Code:</strong> <span class="verification-code"><?= $assignment['delivery_verification_code'] ?></span></div>
                </div>
            </div>
        </div>

        <!-- Assign Form -->
        <div class="form-card">
            <form id="assignForm" onsubmit="assignDelivery(event, <?= $assignment['id'] ?>)">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Select Agent <span class="text-danger">*</span></label>
                    <select name="agent_id" id="agentSelect" class="form-select" required>
                        <option value="">-- Select an agent --</option>
                        <?php if (isset($agents) && !empty($agents)): ?>
                            <?php foreach ($agents as $agent): ?>
                                <option value="<?= $agent['id'] ?>">
                                    <?= esc($agent['name']) ?> (<?= esc($agent['email']) ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <?php if (empty($agents)): ?>
                        <small class="text-danger">No active agents available. <a href="/delivery/agents/add">Add an agent</a></small>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Notes (optional)</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Add any special instructions for the delivery agent"></textarea>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success" <?= empty($agents) ? 'disabled' : '' ?>>
                        <i class="fas fa-check me-2"></i>Assign Delivery
                    </button>
                    <a href="/delivery/orders" class="btn btn-outline-secondary ms-2">Cancel</a>
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

function assignDelivery(event, assignmentId) {
    event.preventDefault();
    
    const agentId = document.getElementById('agentSelect').value;
    
    if (!agentId) {
        alert('Please select a delivery agent.');
        return;
    }

    const formData = new URLSearchParams();
    formData.append('agent_id', agentId);
    formData.append('status', 'assigned');

    fetch('/delivery/assign/update/' + assignmentId, {
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
            window.location.href = '/delivery/orders';
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to assign delivery.');
    });
}
</script>
</body>
</html>