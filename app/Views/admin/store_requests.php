<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Requests - ShopEase</title>
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
        .request-card { background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #e8f0e8; margin-bottom: 15px; transition: 0.3s; }
        .request-card:hover { border-color: #4caf50; box-shadow: 0 2px 15px rgba(0,0,0,0.05); }
        .request-card .store-name { font-size: 1.1rem; font-weight: 700; color: #1a2e1a; }
        .request-card .owner-info { color: #555; font-size: 0.95rem; }
        .request-card .request-date { color: #888; font-size: 0.85rem; }
        .badge-pending { background: #fff3cd; color: #856404; padding: 4px 12px; border-radius: 20px; font-weight: 600; font-size: 0.75rem; }
        .badge-approved { background: #d4edda; color: #155724; padding: 4px 12px; border-radius: 20px; font-weight: 600; font-size: 0.75rem; }
        .badge-rejected { background: #f8d7da; color: #721c24; padding: 4px 12px; border-radius: 20px; font-weight: 600; font-size: 0.75rem; }
        .btn-approve { background: #28a745; color: #fff; border: none; border-radius: 30px; padding: 6px 20px; font-weight: 600; transition: 0.3s; }
        .btn-approve:hover { background: #1e7e34; color: #fff; }
        .btn-reject { background: #dc3545; color: #fff; border: none; border-radius: 30px; padding: 6px 20px; font-weight: 600; transition: 0.3s; }
        .btn-reject:hover { background: #bd2130; color: #fff; }
        .btn-view { background: #17a2b8; color: #fff; border: none; border-radius: 30px; padding: 6px 20px; font-weight: 600; transition: 0.3s; }
        .btn-view:hover { background: #117a8b; color: #fff; }
        .footer { background: #1a2e1a; color: #d4d4d4; padding: 40px 0 20px; margin-top: 40px; }
        .footer h5 { color: #fff; font-weight: 600; }
        .footer a { color: #aaa; text-decoration: none; transition: 0.3s; }
        .footer a:hover { color: #4caf50; }
        .empty-state { text-align: center; padding: 60px 0; }
        .empty-state i { font-size: 4rem; color: #ddd; margin-bottom: 20px; }
        .empty-state h5 { color: #1a2e1a; }
        .empty-state p { color: #888; }
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
                <li class="nav-item"><a class="nav-link active" href="#">Store Requests</a></li>
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
                <h2><i class="fas fa-store me-2"></i>Store Requests</h2>
                <nav class="breadcrumb">
                    <a href="/admin/dashboard">Dashboard</a>
                    <span class="mx-2 text-white-50">/</span>
                    <span class="active">Store Requests</span>
                </nav>
            </div>
            <div>
                <span class="text-white-50">Manage store owner applications</span>
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

        <div class="bg-white rounded-3 p-4 border">
            <ul class="nav nav-tabs mb-4" id="requestTabs">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#pending">
                        <i class="fas fa-clock me-1"></i>Pending
                        <span class="badge bg-warning text-dark ms-1"><?= isset($pendingRequests) ? count($pendingRequests) : 0 ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#approved">
                        <i class="fas fa-check-circle me-1"></i>Approved
                        <span class="badge bg-success ms-1"><?= isset($approvedRequests) ? count($approvedRequests) : 0 ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#rejected">
                        <i class="fas fa-times-circle me-1"></i>Rejected
                        <span class="badge bg-danger ms-1"><?= isset($rejectedRequests) ? count($rejectedRequests) : 0 ?></span>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <!-- PENDING TAB -->
                <div class="tab-pane fade show active" id="pending">
                    <?php if (isset($pendingRequests) && !empty($pendingRequests)): ?>
                        <?php foreach ($pendingRequests as $request): ?>
                            <div class="request-card">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="store-name"><i class="fas fa-store text-success me-2"></i><?= esc($request['store_name']) ?></div>
                                        <div class="owner-info"><i class="fas fa-user me-2"></i><?= esc($request['owner_name']) ?></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="owner-info"><i class="fas fa-envelope me-2"></i><?= esc($request['owner_email']) ?></div>
                                        <div class="owner-info"><i class="fas fa-phone me-2"></i><?= esc($request['owner_phone']) ?></div>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="badge-pending"><i class="fas fa-clock me-1"></i>Pending</span>
                                        <div class="request-date mt-1"><?= date('M d, Y', strtotime($request['created_at'])) ?></div>
                                    </div>
                                    <div class="col-md-3 text-end action-btns">
                                        <a href="/admin/store-request/<?= $request['id'] ?>" class="btn-view btn-sm"><i class="fas fa-eye me-1"></i>View</a>
                                        <a href="/admin/store-request/approve/<?= $request['id'] ?>" class="btn-approve btn-sm" onclick="return confirm('Approve this store request?')">
    <i class="fas fa-check me-1"></i>Approve
</a>
                                        <a href="/admin/store-request/reject/<?= $request['id'] ?>" class="btn-reject btn-sm" onclick="return confirm('Reject this store request?')"><i class="fas fa-times me-1"></i>Reject</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-check-circle text-success"></i>
                            <h5>No Pending Requests</h5>
                            <p>All store owner applications have been reviewed.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- APPROVED TAB -->
                <div class="tab-pane fade" id="approved">
                    <?php if (isset($approvedRequests) && !empty($approvedRequests)): ?>
                        <?php foreach ($approvedRequests as $request): ?>
                            <div class="request-card">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="store-name"><i class="fas fa-store text-success me-2"></i><?= esc($request['store_name']) ?></div>
                                        <div class="owner-info"><i class="fas fa-user me-2"></i><?= esc($request['owner_name']) ?></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="owner-info"><i class="fas fa-envelope me-2"></i><?= esc($request['owner_email']) ?></div>
                                        <div class="owner-info"><i class="fas fa-phone me-2"></i><?= esc($request['owner_phone']) ?></div>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="badge-approved"><i class="fas fa-check-circle me-1"></i>Approved</span>
                                        <div class="request-date mt-1"><?= date('M d, Y', strtotime($request['updated_at'])) ?></div>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <a href="/admin/store-request/<?= $request['id'] ?>" class="btn-view btn-sm"><i class="fas fa-eye me-1"></i>View</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-store"></i>
                            <h5>No Approved Requests</h5>
                            <p>No store owner applications have been approved yet.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- REJECTED TAB -->
                <div class="tab-pane fade" id="rejected">
                    <?php if (isset($rejectedRequests) && !empty($rejectedRequests)): ?>
                        <?php foreach ($rejectedRequests as $request): ?>
                            <div class="request-card">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="store-name"><i class="fas fa-store text-danger me-2"></i><?= esc($request['store_name']) ?></div>
                                        <div class="owner-info"><i class="fas fa-user me-2"></i><?= esc($request['owner_name']) ?></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="owner-info"><i class="fas fa-envelope me-2"></i><?= esc($request['owner_email']) ?></div>
                                        <div class="owner-info"><i class="fas fa-phone me-2"></i><?= esc($request['owner_phone']) ?></div>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="badge-rejected"><i class="fas fa-times-circle me-1"></i>Rejected</span>
                                        <div class="request-date mt-1"><?= date('M d, Y', strtotime($request['updated_at'])) ?></div>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <a href="/admin/store-request/<?= $request['id'] ?>" class="btn-view btn-sm"><i class="fas fa-eye me-1"></i>View</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-store"></i>
                            <h5>No Rejected Requests</h5>
                            <p>No store owner applications have been rejected.</p>
                        </div>
                    <?php endif; ?>
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