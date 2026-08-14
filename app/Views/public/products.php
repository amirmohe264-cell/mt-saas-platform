<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8f9fa; }
        body { padding-top: 80px; }
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
        .page-header { background: #1a2e1a; color: #fff; padding: 40px 0 30px; }
        .page-header h2 { font-weight: 700; }
        .page-header .breadcrumb { background: none; padding: 0; margin: 0; }
        .page-header .breadcrumb a { color: #4caf50; text-decoration: none; }
        .page-header .breadcrumb .active { color: #aaa; }
        .filter-sidebar { background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid #e8f0e8; }
        .filter-sidebar h6 { color: #1a2e1a; font-weight: 600; margin-bottom: 15px; }
        .filter-sidebar .form-check-label { color: #555; font-size: 0.9rem; }
        .filter-sidebar .form-check-input:checked { background-color: #4caf50; border-color: #4caf50; }
        .product-card { background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid #e8f0e8; transition: 0.3s; height: 100%; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(76, 175, 80, 0.12); border-color: #4caf50; }
        .product-card .product-image { height: 150px; object-fit: contain; width: 100%; }
        .product-card .product-name { color: #1a2e1a; font-weight: 600; font-size: 1rem; margin-top: 10px; }
        .product-card .product-category { color: #888; font-size: 0.85rem; }
        .product-card .price { color: #1a2e1a; font-weight: 700; font-size: 1.2rem; }
        .product-card .old-price { color: #aaa; font-size: 0.9rem; text-decoration: line-through; margin-left: 8px; }
        .product-card .btn-add { background: #4caf50; color: #fff; border: none; border-radius: 30px; padding: 8px 20px; font-weight: 600; font-size: 0.85rem; transition: 0.3s; width: 100%; text-decoration: none; display: inline-block; text-align: center; }
        .product-card .btn-add:hover { background: #388e3c; color: #fff; }
        .pagination .page-link { color: #1a2e1a; }
        .pagination .page-item.active .page-link { background: #4caf50; border-color: #4caf50; color: #fff; }
        .pagination .page-link:hover { color: #4caf50; }
        .footer { background: #1a2e1a; color: #d4d4d4; padding: 50px 0 20px; }
        .footer h5 { color: #fff; font-weight: 600; }
        .footer a { color: #aaa; text-decoration: none; transition: 0.3s; }
        .footer a:hover { color: #4caf50; }
        .navbar-toggler { border-color: #4caf50; }
        .navbar-toggler-icon { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(76, 175, 80, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e"); }
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
                <li class="nav-item"><a class="nav-link active" href="/products">Products</a></li>
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
                <h2>All Products</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2 text-white-50">/</span>
                    <span class="active">Products</span>
                </nav>
            </div>
            <div>
                <span class="text-white-50" id="productCount">Showing <?= isset($products) ? count($products) : 0 ?> products</span>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="py-4">
    <div class="container">
        <div class="row product-grid">
            <!-- Filter Sidebar -->
            <div class="col-lg-3">
                <div class="filter-sidebar">
                    <h6><i class="fas fa-filter me-2"></i>Filters</h6>
                    <hr>
                    <h6 class="mt-3">Categories</h6>
                    <?php if (isset($categories) && !empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="cat_<?= $cat['id'] ?>" checked>
                                <label class="form-check-label" for="cat_<?= $cat['id'] ?>"><?= $cat['category_name'] ?></label>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted">No categories</p>
                    <?php endif; ?>
                    <hr>
                    <h6>Price Range</h6>
                    <div class="d-flex gap-2">
                        <input type="number" class="form-control form-control-sm" placeholder="Min" style="width:45%;">
                        <span class="text-muted">-</span>
                        <input type="number" class="form-control form-control-sm" placeholder="Max" style="width:45%;">
                    </div>
                    <button class="btn btn-success w-100 mt-3" style="background:#4caf50;border:none;">Apply Filters</button>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-lg-9">
                <div class="row product-grid">
                    <?php if (isset($products) && !empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="col-md-4 mb-4">
                                <div class="product-card">
                                    <div class="text-center">
                                        <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="product-image">
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <?php if (isset($product['badges']) && !empty($product['badges'])): ?>
                                            <?php foreach ($product['badges'] as $badge): ?>
                                                <span class="badge <?= $badge === 'New' ? 'bg-success' : 'bg-danger' ?>"><?= $badge ?></span>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span class="badge bg-success">New</span>
                                        <?php endif; ?>
                                    </div>
                                    <h6 class="product-name"><?= $product['name'] ?></h6>
                                    <p class="product-category"><?= $product['category'] ?? 'General' ?></p>
                                    <div>
                                        <span class="price">$<?= number_format($product['price'], 2) ?></span>
                                        <?php if (isset($product['old_price']) && $product['old_price']): ?>
                                            <span class="old-price">$<?= number_format($product['old_price'], 2) ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <a href="/product/<?= $product['slug'] ?>" class="btn-add mt-2"><i class="fas fa-eye me-2"></i>View Details</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                                <h5>No products found</h5>
                                <p class="text-muted">Check back later for new arrivals.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
                <nav class="mt-4">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
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
                <p class="text-muted">Your one-stop shop for everything you need. Quality products, unbeatable prices.</p>
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