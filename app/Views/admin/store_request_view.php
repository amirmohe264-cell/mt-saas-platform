<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Details - ShopEase</title>
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
        .detail-card { background: #fff; border-radius: 12px; padding: 30px; border: 1px solid #e8f0e8; }
        .detail-card .label { color: #888; font-weight: 500; font-size: 0.9rem; }
        .detail-card .value { color: #1a2e1a; font-weight: 600; font-size: 1rem; }
        .detail-card .value a { color: #4caf50; }
        .status-badge { padding: 6px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-approved { background: #d4edda; color: #155724; }
        .status-rejected { background: #f8d7da; color: #721c24; }
        .btn-approve { background: #28a745; color: #fff; border: none; border-radius: 30px; padding: 10px 30px; font-weight: 600; transition: 0.3s; }
        .btn-approve:hover { background: #1e7e34; color: #fff; }
        .btn-reject { background: #dc3545; color: #fff; border: none; border-radius: 30px; padding: 10px 30px; font-weight: 600; transition: 0.3s; }
        .btn-reject:hover { background: #bd2130; color: #fff; }
        .btn-back { background: #6c757d; color: #fff; border: none; border-radius: 30px; padding: 10px 30px; font-weight: 600; transition: 0.3s; text-decoration: none; display: inline-block; }
        .btn-back:hover { background: #5a6268; color: #fff; }
        .footer { background: #1a2e1a; color: #d4d4d4; padding: 40px 0 20px; margin-top: 40px; }
        .footer h5 { color: #fff; font-weight: 600; }
        .footer a { color: #aaa; text-decoration: none; transition: 0.3s; }
        .footer a:hover { color: #4caf50; }
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
                <li class="nav-item"><a class="nav-link active" href="#">Request Details</a></li>
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
                <h2><i class="fas fa-info-circle me-2"></i>Request Details</h2>
                <nav class="breadcrumb">
                    <a href="/admin/dashboard">Dashboard</a>
                    <span class="mx-2 text-white-50">/</span>
                    <a href="/admin/store-requests">Store Requests</a>
                    <span class="mx-2 text-white-50">/</span>
                    <span class="active">Details</span>
                </nav>
            </div>
            <div>
                <span class="status-badge <?= $request['status'] === 'pending' ? 'status-pending' : ($request['status'] === 'approved' ? 'status-approved' : 'status-rejected') ?>">
                    <?= ucfirst($request['status']) ?>
                </span>
            </div>
        </div>
    </div>
</section>

<section class="py-4">
    <div class="container">
        <div class="detail-card">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="label">Store Name</div>
                    <div class="value"><?= esc($request['store_name']) ?></div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="label">Business Type</div>
                    <div class="value"><?= esc(ucfirst($request['business_type'] ?? 'Not specified')) ?></div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="label">Owner Name</div>
                    <div class="value"><?= esc($request['owner_name']) ?></div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="label">Owner Email</div>
                    <div class="value"><?= esc($request['owner_email']) ?></div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="label">Phone Number</div>
                    <div class="value"><?= esc($request['owner_phone']) ?></div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="label">Submitted On</div>
                    <div class="value"><?= date('F d, Y H:i A', strtotime($request['created_at'])) ?></div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="label">Store Address</div>
                    <div class="value"><?= esc($request['store_address']) ?></div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="label">Store Description</div>
                    <div class="value"><?= esc($request['store_description'] ?? 'No description provided.') ?></div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="label">Legal Documents</div>
                    <div class="value">
                        <?php if ($request['legal_documents']): ?>
                            <a href="/<?= $request['legal_documents'] ?>" target="_blank" class="btn btn-sm btn-outline-success">
                                <i class="fas fa-file-pdf me-1"></i>View Document
                            </a>
                        <?php else: ?>
                            <span class="text-muted">No document uploaded</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if ($request['status'] === 'pending'): ?>
                <hr>
                <div class="d-flex gap-3 mt-3">
                    <a href="/admin/store-request/approve/<?= $request['id'] ?>" class="btn-approve" onclick="return confirm('Are you sure you want to approve this store request?')">
                        <i class="fas fa-check me-2"></i>Approve
                    </a>
                    <a href="/admin/store-request/reject/<?= $request['id'] ?>" class="btn-reject" onclick="return confirm('Are you sure you want to reject this store request?')">
                        <i class="fas fa-times me-2"></i>Reject
                    </a>
                    <a href="/admin/store-requests" class="btn-back"><i class="fas fa-arrow-left me-2"></i>Back</a>
                </div>
            <?php else: ?>
                <hr>
                <div class="mt-3">
                    <a href="/admin/store-requests" class="btn-back"><i class="fas fa-arrow-left me-2"></i>Back to Requests</a>
                </div>
            <?php endif; ?>
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