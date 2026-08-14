<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - ShopEase</title>
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
        .page-header { background: #1a2e1a; color: #fff; padding: 40px 0 30px; }
        .page-header h2 { font-weight: 700; }
        .page-header .breadcrumb { background: none; padding: 0; margin: 0; }
        .page-header .breadcrumb a { color: #4caf50; text-decoration: none; }
        .page-header .breadcrumb .active { color: #aaa; }
        .sidebar-card { background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #e8f0e8; }
        .sidebar-card h6 { color: #1a2e1a; font-weight: 600; }
        .sidebar-card .category-link { display: block; padding: 8px 12px; color: #555; text-decoration: none; border-radius: 8px; transition: 0.3s; }
        .sidebar-card .category-link:hover { background: #f0f8f0; color: #4caf50; }
        .sidebar-card .category-link.active { background: #f0f8f0; color: #4caf50; font-weight: 600; }
        .footer { background: #1a2e1a; color: #d4d4d4; padding: 40px 0 20px; margin-top: 40px; }
        .footer h5 { color: #fff; font-weight: 600; }
        .footer a { color: #aaa; text-decoration: none; transition: 0.3s; }
        .footer a:hover { color: #4caf50; }
        .category-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; }
        .category-item { background: #fff; border-radius: 12px; padding: 30px 20px; text-align: center; box-shadow: 0 2px 15px rgba(0,0,0,0.06); transition: 0.3s; border: 1px solid #e8f0e8; cursor: pointer; text-decoration: none; display: block; color: inherit; }
        .category-item:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(76, 175, 80, 0.15); border-color: #4caf50; }
        .category-item i { font-size: 2.5rem; color: #4caf50; margin-bottom: 10px; }
        .category-item h5 { color: #1a2e1a; font-weight: 600; margin: 0; }
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
                <li class="nav-item"><a class="nav-link active" href="/categories">Categories</a></li>
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
                <h2><i class="fas fa-tags me-2"></i><?= isset($selectedCategory) ? ucfirst($selectedCategory) : 'Categories' ?></h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2 text-white-50">/</span>
                    <span class="active"><?= isset($selectedCategory) ? ucfirst($selectedCategory) : 'Categories' ?></span>
                </nav>
            </div>
            <div>
                <span class="text-white-50"><?= isset($products) ? count($products) : 0 ?> products</span>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-4">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="sidebar-card">
                    <h6><i class="fas fa-list me-2"></i>Categories</h6>
                    <hr>
                    <a href="/categories" class="category-link <?= (isset($selectedCategory) && $selectedCategory === 'All') ? 'active' : '' ?>">
                        All Categories
                    </a>
                    <?php if (isset($categories) && is_array($categories) && !empty($categories)): ?>
                        <?php foreach ($categories as $slug => $name): ?>
                            <a href="/categories/<?= $slug ?>" class="category-link <?= (isset($selectedSlug) && $selectedSlug === $slug) ? 'active' : '' ?>">
                                <?= $name ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="bg-white rounded-3 p-4 border">
                    <h4><?= isset($selectedCategory) ? ucfirst($selectedCategory) : 'All Categories' ?></h4>
                    <hr>
                    
                    <?php if (isset($products) && !empty($products)): ?>
                        <div class="row">
                            <?php foreach ($products as $product): ?>
                                <div class="col-md-4 mb-4">
                                    <div class="product-card">
                                        <div class="text-center">
                                            <img src="<?= $product['image'] ?? 'https://via.placeholder.com/200x200?text=Product' ?>" alt="<?= $product['name'] ?? 'Product' ?>" class="product-image">
                                        </div>
                                        <h6 class="product-name"><?= $product['name'] ?? 'Product' ?></h6>
                                        <p class="product-category"><?= $product['category'] ?? 'General' ?></p>
                                        <div>
                                            <span class="price">$<?= isset($product['price']) ? number_format($product['price'], 2) : '0.00' ?></span>
                                        </div>
                                        <a href="/product/<?= $product['slug'] ?? 'product' ?>" class="btn-add mt-2"><i class="fas fa-eye me-2"></i>View Details</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No products found in this category.</p>
                    <?php endif; ?>
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

<!-- Add product-card styles -->
<style>
.product-card {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border: 1px solid #e8f0e8;
    transition: 0.3s;
    height: 100%;
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(76, 175, 80, 0.12);
    border-color: #4caf50;
}
.product-card .product-image {
    height: 150px;
    object-fit: contain;
    width: 100%;
}
.product-card .product-name {
    color: #1a2e1a;
    font-weight: 600;
    font-size: 1rem;
    margin-top: 10px;
}
.product-card .product-category {
    color: #888;
    font-size: 0.85rem;
}
.product-card .price {
    color: #1a2e1a;
    font-weight: 700;
    font-size: 1.2rem;
}
.product-card .btn-add {
    background: #4caf50;
    color: #fff;
    border: none;
    border-radius: 30px;
    padding: 8px 20px;
    font-weight: 600;
    font-size: 0.85rem;
    transition: 0.3s;
    width: 100%;
    text-decoration: none;
    display: inline-block;
    text-align: center;
}
.product-card .btn-add:hover {
    background: #388e3c;
    color: #fff;
}
</style>

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