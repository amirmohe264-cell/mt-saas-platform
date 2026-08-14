<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order - ShopEase</title>
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
        .navbar .nav-link.active { color: #4caf50 !important; }
        .search-box { background: #2a402a; border-radius: 30px; padding: 5px 15px; border: none; color: #fff; }
        .search-box::placeholder { color: #aaa; }
        .search-box:focus { outline: none; background: #2a402a; box-shadow: 0 0 0 2px #4caf50; }
        .icon-btn { color: #d4d4d4; font-size: 1.2rem; margin: 0 8px; transition: 0.3s; background: none; border: none; }
        .icon-btn:hover { color: #4caf50; transform: scale(1.1); }
        .navbar-toggler { border-color: #4caf50; }
        .navbar-toggler-icon { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(76, 175, 80, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e"); }
        .page-header { background: #1a2e1a; color: #fff; padding: 40px 0 30px; }
        .page-header h2 { font-weight: 700; }
        .page-header .breadcrumb { background: none; padding: 0; margin: 0; }
        .page-header .breadcrumb a { color: #4caf50; text-decoration: none; }
        .page-header .breadcrumb .active { color: #aaa; }
        .content-section { padding: 40px 0; }
        .track-card { background: #fff; border-radius: 12px; padding: 30px; border: 1px solid #e8f0e8; max-width: 600px; margin: 0 auto; }
        .track-card h4 { color: #1a2e1a; font-weight: 700; }
        .track-card .form-control { border-radius: 8px; border: 2px solid #e8f0e8; padding: 12px 15px; }
        .track-card .form-control:focus { border-color: #4caf50; box-shadow: none; }
        .btn-track { background: #4caf50; color: #fff; border: none; border-radius: 30px; padding: 12px 40px; font-weight: 600; transition: 0.3s; }
        .btn-track:hover { background: #388e3c; }
        .track-status { margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px; }
        .track-status .status-step { display: flex; align-items: center; padding: 10px 0; border-bottom: 1px solid #e8f0e8; }
        .track-status .status-step:last-child { border-bottom: none; }
        .track-status .step-icon { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; }
        .track-status .step-icon.completed { background: #4caf50; color: #fff; }
        .track-status .step-icon.pending { background: #ffc107; color: #fff; }
        .track-status .step-icon.future { background: #e8f0e8; color: #aaa; }
        .track-status .step-text { flex: 1; }
        .track-status .step-text h6 { margin: 0; color: #1a2e1a; }
        .track-status .step-text p { margin: 0; color: #888; font-size: 0.85rem; }
        .footer { background: #1a2e1a; color: #d4d4d4; padding: 40px 0 20px; margin-top: 40px; }
        .footer h5 { color: #fff; font-weight: 600; }
        .footer a { color: #aaa; text-decoration: none; transition: 0.3s; }
        .footer a:hover { color: #4caf50; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="fas fa-store"></i> ShopEase</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/categories">Categories</a></li>
                <li class="nav-item"><a class="nav-link" href="/products">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="/contact">Contact</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <input class="search-box me-2" type="search" placeholder="Search for products...">
                <button class="icon-btn"><i class="far fa-heart"></i></button>
                <a href="/cart" class="icon-btn" style="color:#d4d4d4;text-decoration:none;"><i class="fas fa-shopping-cart"></i></a>
                <a href="/login" class="icon-btn" style="color:#d4d4d4;text-decoration:none;"><i class="far fa-user"></i></a>
            </div>
        </div>
    </div>
</nav>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-search-location me-2"></i>Track Order</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2 text-white-50">/</span>
                    <span class="active">Track Order</span>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Content -->
<section class="content-section">
    <div class="container">
        <div class="track-card">
            <h4 class="text-center">Track Your Order</h4>
            <p class="text-muted text-center">Enter your order number to track your shipment.</p>
            
            <form>
                <div class="mb-3">
                    <label>Order Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="e.g. ORD-2026-08-07-001" required>
                </div>
                <div class="mb-3">
                    <label>Email Address <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" placeholder="john@example.com" required>
                </div>
                <button type="submit" class="btn-track w-100"><i class="fas fa-search me-2"></i>Track Order</button>
            </form>

            <!-- Example Track Status -->
            <div class="track-status">
                <h6 class="mb-3">Order Status: <span class="text-success">In Transit</span></h6>
                
                <div class="status-step">
                    <div class="step-icon completed"><i class="fas fa-check"></i></div>
                    <div class="step-text">
                        <h6>Order Placed</h6>
                        <p>August 7, 2026 - 10:30 AM</p>
                    </div>
                </div>
                
                <div class="status-step">
                    <div class="step-icon completed"><i class="fas fa-check"></i></div>
                    <div class="step-text">
                        <h6>Order Confirmed</h6>
                        <p>August 7, 2026 - 2:15 PM</p>
                    </div>
                </div>
                
                <div class="status-step">
                    <div class="step-icon completed"><i class="fas fa-check"></i></div>
                    <div class="step-text">
                        <h6>Shipped</h6>
                        <p>August 8, 2026 - 9:00 AM</p>
                    </div>
                </div>
                
                <div class="status-step">
                    <div class="step-icon pending"><i class="fas fa-clock"></i></div>
                    <div class="step-text">
                        <h6>In Transit</h6>
                        <p>Estimated delivery: August 12, 2026</p>
                    </div>
                </div>
                
                <div class="status-step">
                    <div class="step-icon future"><i class="fas fa-circle"></i></div>
                    <div class="step-text">
                        <h6>Delivered</h6>
                        <p>Pending</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5><i class="fas fa-store text-success"></i> ShopEase</h5>
                <p class="text-muted">Your one-stop shop for everything you need.</p>
            </div>
            <div class="col-md-2 mb-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="/about">About Us</a></li>
                    <li><a href="/contact">Contact</a></li>
                    <li><a href="/privacy">Privacy Policy</a></li>
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