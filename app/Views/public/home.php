<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopEase - Multi-Tenant E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
       * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f8f9fa;
    padding-top: 80px;
}

/* Fixed Navbar - Glass Morphism Effect */
.navbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    background: #1a2e1a !important;
    padding: 15px 0;
    transition: all 0.3s ease;
    box-shadow: 0 2px 20px rgba(0,0,0,0.3);
}
.navbar-scrolled {
    background: rgba(26, 46, 26, 0.88) !important;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    box-shadow: 0 4px 30px rgba(0,0,0,0.5);
    padding: 8px 0;
}
.navbar-brand {
    color: #fff !important;
    font-weight: bold;
    font-size: 1.5rem;
    transition: 0.3s;
}
.navbar-brand i {
    color: #4caf50;
}
.navbar .nav-link {
    color: #d4d4d4 !important;
    font-weight: 500;
    transition: 0.3s;
    position: relative;
}
.navbar .nav-link:hover {
    color: #4caf50 !important;
}
.navbar .nav-link.active {
    color: #4caf50 !important;
}
.navbar .nav-link::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 2px;
    background: #4caf50;
    transition: 0.3s;
}
.navbar .nav-link:hover::after,
.navbar .nav-link.active::after {
    width: 100%;
}
.navbar .btn-outline-light {
    border-color: #4caf50;
    color: #4caf50;
}
.navbar .btn-outline-light:hover {
    background: #4caf50;
    color: #fff;
}
.navbar-toggler {
    border-color: #4caf50;
}
.navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(76, 175, 80, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
}

/* Search box */
.search-box {
    background: #2a402a;
    border-radius: 30px;
    padding: 5px 15px;
    border: none;
    color: #fff;
    transition: 0.3s;
}
.search-box::placeholder {
    color: #aaa;
}
.search-box:focus {
    outline: none;
    background: #2a402a;
    box-shadow: 0 0 0 2px #4caf50;
}

/* Icon buttons */
.icon-btn {
    color: #d4d4d4;
    font-size: 1.2rem;
    margin: 0 8px;
    transition: 0.3s;
    background: none;
    border: none;
}
.icon-btn:hover {
    color: #4caf50;
    transform: scale(1.1);
}

/* Hero Section */
.hero {
    background: linear-gradient(rgba(26, 46, 26, 0.7), rgba(26, 46, 26, 0.8)), url('https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1920&q=80') center/cover no-repeat;
    min-height: 550px;
    display: flex;
    align-items: center;
    padding: 60px 0;
}
.hero h1 {
    color: #fff;
    font-size: 3.5rem;
    font-weight: 700;
}
.hero h1 span {
    color: #4caf50;
}
.hero p {
    color: #d4d4d4;
    font-size: 1.2rem;
    max-width: 500px;
}
.hero .btn-shop {
    background: #4caf50;
    color: #fff;
    padding: 12px 35px;
    border-radius: 30px;
    font-weight: 600;
    border: none;
    transition: 0.3s;
    text-decoration: none;
    display: inline-block;
}
.hero .btn-shop:hover {
    background: #388e3c;
    transform: translateY(-2px);
    color: #fff;
}
.hero .btn-outline-shop {
    background: transparent;
    color: #fff;
    padding: 12px 35px;
    border-radius: 30px;
    font-weight: 600;
    border: 2px solid #4caf50;
    transition: 0.3s;
    text-decoration: none;
    display: inline-block;
}
.hero .btn-outline-shop:hover {
    background: #4caf50;
    color: #fff;
}

/* Features */
.features {
    background: #fff;
    padding: 40px 0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}
.feature-item {
    text-align: center;
}
.feature-item i {
    font-size: 2rem;
    color: #4caf50;
    margin-bottom: 10px;
}
.feature-item h6 {
    color: #1a2e1a;
    font-weight: 600;
}
.feature-item p {
    color: #888;
    font-size: 0.9rem;
}

/* Section Title */
.section-title {
    color: #1a2e1a;
    font-weight: 700;
    position: relative;
    display: inline-block;
}
.section-title:after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 60px;
    height: 3px;
    background: #4caf50;
}

/* Category Cards */
.category-card {
    background: #fff;
    border-radius: 12px;
    padding: 30px 20px;
    text-align: center;
    box-shadow: 0 2px 15px rgba(0,0,0,0.06);
    transition: 0.3s;
    border: 1px solid #e8f0e8;
    cursor: pointer;
}
.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(76, 175, 80, 0.15);
    border-color: #4caf50;
}
.category-card i {
    font-size: 2.5rem;
    color: #4caf50;
    margin-bottom: 12px;
}
.category-card h6 {
    color: #1a2e1a;
    font-weight: 600;
}
.category-card .btn-explore {
    color: #4caf50;
    font-size: 0.85rem;
    font-weight: 600;
    background: none;
    border: none;
    transition: 0.3s;
    text-decoration: none;
    display: inline-block;
}
.category-card .btn-explore:hover {
    color: #388e3c;
    padding-left: 5px;
}

/* Custom 5-column grid for large screens (Bootstrap has no built-in 20% column) */
@media (min-width: 992px) {
    .col-lg-5th {
        flex: 0 0 20%;
        max-width: 20%;
    }
}

/* ========================================== */
/* HOME PAGE PRODUCT CARDS */
/* ========================================== */
.product-card-home {
    background: #fff;
    border-radius: 12px;
    padding: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border: 1px solid #e8f0e8;
    transition: 0.3s;
    height: 100%;
}
.product-card-home:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(76, 175, 80, 0.12);
    border-color: #4caf50;
}
.product-card-home .product-image-home {
    height: 110px;
    object-fit: contain;
    width: 100%;
    display: block;
    margin: 0 auto;
}
.product-card-home .product-name-home {
    color: #1a2e1a;
    font-weight: 600;
    font-size: 0.9rem;
    margin-top: 10px;
}
.product-card-home .product-category-home {
    color: #888;
    font-size: 0.8rem;
}
.product-card-home .price-home {
    color: #1a2e1a;
    font-weight: 700;
    font-size: 1rem;
}
.product-card-home .old-price-home {
    color: #aaa;
    font-size: 0.85rem;
    text-decoration: line-through;
    margin-left: 8px;
}
.product-card-home .btn-add-home {
    background: #4caf50;
    color: #fff;
    border: none;
    border-radius: 30px;
    padding: 7px 15px;
    font-weight: 600;
    font-size: 0.8rem;
    transition: 0.3s;
    width: 100%;
    text-decoration: none;
    display: inline-block;
    text-align: center;
}
.product-card-home .btn-add-home:hover {
    background: #388e3c;
    color: #fff;
}

/* ========================================== */
/* PRODUCTS PAGE PRODUCT CARDS */
/* ========================================== */
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
    font-size: 1.1rem;
}
.product-card .old-price {
    color: #aaa;
    font-size: 0.9rem;
    text-decoration: line-through;
    margin-left: 8px;
}
.product-card .btn-add {
    background: #4caf50;
    color: #fff;
    border: none;
    border-radius: 30px;
    padding: 8px 15px;
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

/* Footer */
.footer {
    background: #1a2e1a;
    color: #d4d4d4;
    padding: 50px 0 20px;
}
.footer h5 {
    color: #fff;
    font-weight: 600;
}
.footer a {
    color: #aaa;
    text-decoration: none;
    transition: 0.3s;
}
.footer a:hover {
    color: #4caf50;
}
.footer .social-icons a {
    display: inline-block;
    background: #2a402a;
    width: 40px;
    height: 40px;
    line-height: 40px;
    text-align: center;
    border-radius: 50%;
    color: #fff;
    margin-right: 8px;
    transition: 0.3s;
}
.footer .social-icons a:hover {
    background: #4caf50;
    transform: translateY(-3px);
}
.footer .border-top {
    border-color: #2a402a !important;
}
.badge-green {
    background: #4caf50;
    color: #fff;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.7rem;
}

/* Responsive */
@media (max-width: 768px) {
    .hero h1 {
        font-size: 2.2rem;
    }
    .hero {
        min-height: 400px;
        padding: 40px 0;
    }
}
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
                <li class="nav-item"><a class="nav-link <?= (current_url() == base_url('/') || current_url() == base_url()) ? 'active' : '' ?>" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link <?= strpos(current_url(), 'products') !== false ? 'active' : '' ?>" href="/products">Products</a></li>
                <li class="nav-item"><a class="nav-link <?= strpos(current_url(), 'contact') !== false ? 'active' : '' ?>" href="/contact">Contact</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <input class="search-box me-2" type="search" placeholder="Search for products...">
                <a href="/cart" class="icon-btn" style="color:#d4d4d4;text-decoration:none;"><i class="fas fa-shopping-cart"></i></a>
                <a href="/login" class="icon-btn" style="color:#d4d4d4;text-decoration:none;"><i class="far fa-user"></i></a>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <p class="text-uppercase text-white-50 fw-bold mb-2">Shop Smarter, Live Better</p>
                <h1>Discover Everything <br><span>You Need</span></h1>
                <p>From the latest tech to everyday essentials, find it all in one place with unbeatable deals.</p>
                <div class="mt-4">
    <a href="/products" class="btn btn-shop me-3">Shop Now</a>
    <a href="/store/apply" class="btn btn-outline-shop mt-2 mt-md-0" style="border-color: #4caf50; color: #4caf50; background: transparent;">Open Your Store</a>
</div>
            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section class="features">
    <div class="container">
        <div class="row">
            <div class="col-md-4 feature-item">
                <i class="fas fa-truck"></i>
                <h6>Free Delivery</h6>
                <p>On orders over $50</p>
            </div>
            <div class="col-md-4 feature-item">
                <i class="fas fa-lock"></i>
                <h6>Secure Payment</h6>
                <p>100% protected</p>
            </div>
            <div class="col-md-4 feature-item">
                <i class="fas fa-headset"></i>
                <h6>24/7 Support</h6>
                <p>We're here to help</p>
            </div>
        </div>
    </div>
</section>
<!-- Featured Products -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="section-title">Featured Products</h3>
            <a href="/products" class="text-decoration-none text-success">View All <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="row g-2">
            <?php if (isset($featuredProducts) && !empty($featuredProducts)): ?>
                <?php foreach ($featuredProducts as $product): ?>
                    <div class="col-lg-5th col-md-4 col-6 mb-4">
                     <div class="product-card-home">
    <div class="text-center">
        <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="product-image-home">
    </div>
    <div class="d-flex justify-content-between mt-2">
        <?php foreach ($product['badges'] as $badge): ?>
            <span class="badge <?= $badge === 'New' ? 'bg-success' : 'bg-danger' ?>"><?= $badge ?></span>
        <?php endforeach; ?>
    </div>
    <h6 class="product-name-home"><?= $product['name'] ?></h6>
    <p class="product-category-home"><?= $product['category'] ?></p>
    <div>
        <span class="price-home">$<?= number_format($product['price'], 2) ?></span>
        <?php if ($product['old_price']): ?>
            <span class="old-price-home">$<?= number_format($product['old_price'], 2) ?></span>
        <?php endif; ?>
    </div>
    <a href="/product/<?= $product['slug'] ?>" class="btn-add-home mt-2">View Details</a>
</div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">No featured products available.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
  
<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5><i class="fas fa-store text-success"></i> ShopEase</h5>
                <p class="text-muted">Your one-stop shop for everything you need. Quality products, unbeatable prices.</p>
                <div class="social-icons mt-3">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="col-md-2 mb-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="about">About Us</a></li>
                    <li><a href="contact">Contact</a></li>
                    <li><a href="privacy">Privacy Policy</a></li>
                    <li><a href="terms">Terms</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Customer Service</h5>
                <ul class="list-unstyled">
                    <li><a href="help">Help Center</a></li>
                    <li><a href="returns">Returns</a></li>
                    <li><a href="shipping">Shipping Info</a></li>
                    <li><a href="track">Track Order</a></li>
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
    // Navbar scroll effect - Glass Morphism
    window.addEventListener('scroll', function() {
        var navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    });
</script>
<script>
    // Wishlist toggle function
    function toggleWishlist(button) {
        var icon = button.querySelector('i');
        
        // Toggle between far (empty) and fas (filled)
        if (icon.classList.contains('far')) {
            icon.classList.remove('far');
            icon.classList.add('fas');
            icon.style.color = '#dc3545';
            button.classList.add('wishlist-active');
            
            // Show a quick notification
            showNotification('Added to wishlist! ❤️');
        } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
            icon.style.color = '';
            button.classList.remove('wishlist-active');
            
            showNotification('Removed from wishlist! 💔');
        }
    }
    
    // Notification function
    function showNotification(message) {
        // Check if notification already exists
        var existing = document.querySelector('.wishlist-notification');
        if (existing) {
            existing.remove();
        }
        
        var notification = document.createElement('div');
        notification.className = 'wishlist-notification';
        notification.innerHTML = message;
        notification.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #1a2e1a;
            color: #fff;
            padding: 15px 25px;
            border-radius: 12px;
            z-index: 9999;
            box-shadow: 0 5px 25px rgba(0,0,0,0.3);
            font-size: 1rem;
            font-weight: 500;
            animation: slideIn 0.3s ease;
            border-left: 4px solid #4caf50;
        `;
        document.body.appendChild(notification);
        
        // Auto remove after 3 seconds
        setTimeout(function() {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(function() {
                notification.remove();
            }, 300);
        }, 3000);
    }
    
    // Add CSS animations for notification
    var style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100px); opacity: 0; }
        }
        .wishlist-active i {
            color: #dc3545 !important;
        }
    `;
    document.head.appendChild(style);
</script>
</body>
</html>