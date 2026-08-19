<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $product['name'] ?? 'Product' ?> - ShopEase</title>
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
        .search-box {
            background: #2a402a;
            border-radius: 30px;
            padding: 5px 15px;
            border: none;
            color: #fff;
        }
        .search-box::placeholder {
            color: #aaa;
        }
        .search-box:focus {
            outline: none;
            background: #2a402a;
        }
        .icon-btn {
            color: #d4d4d4;
            font-size: 1.2rem;
            margin: 0 10px;
            transition: 0.3s;
            background: none;
            border: none;
        }
        .icon-btn:hover {
            color: #4caf50;
        }
        .navbar-toggler {
            border-color: #4caf50;
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(76, 175, 80, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        .breadcrumb-custom {
            background: none;
            padding: 20px 0 0;
            margin: 0;
        }
        .breadcrumb-custom a {
            color: #4caf50;
            text-decoration: none;
        }
        .breadcrumb-custom .active {
            color: #888;
        }
        .product-image-main {
            width: 100%;
            max-height: 400px;
            object-fit: contain;
            border-radius: 12px;
            background: #fff;
            padding: 20px;
            border: 1px solid #e8f0e8;
        }
        .product-thumbnails img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            border-radius: 8px;
            border: 2px solid #e8f0e8;
            cursor: pointer;
            transition: 0.3s;
            padding: 5px;
            background: #fff;
        }
        .product-thumbnails img:hover {
            border-color: #4caf50;
        }
        .product-thumbnails img.active {
            border-color: #4caf50;
        }
        .product-title {
            color: #1a2e1a;
            font-weight: 700;
            font-size: 1.8rem;
        }
        .product-price {
            color: #1a2e1a;
            font-weight: 700;
            font-size: 2rem;
        }
        .product-old-price {
            color: #aaa;
            font-size: 1.2rem;
            text-decoration: line-through;
            margin-left: 10px;
        }
        .product-rating {
            color: #ffc107;
            font-size: 1.1rem;
        }
        .product-rating-count {
            color: #888;
            font-size: 0.9rem;
            margin-left: 8px;
        }
        .product-description {
            color: #555;
            line-height: 1.8;
        }
        .product-meta {
            color: #888;
            font-size: 0.95rem;
        }
        .product-meta strong {
            color: #1a2e1a;
        }
        .btn-add-cart {
            background: #4caf50;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 12px 40px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: 0.3s;
        }
        .btn-add-cart:hover {
            background: #388e3c;
            transform: translateY(-2px);
        }
        .btn-wishlist {
            background: #fff;
            color: #1a2e1a;
            border: 2px solid #e8f0e8;
            border-radius: 30px;
            padding: 12px 20px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-wishlist:hover {
            border-color: #4caf50;
            color: #4caf50;
        }
        .quantity-input {
            width: 60px;
            text-align: center;
            border: 2px solid #e8f0e8;
            border-radius: 8px;
            padding: 8px;
        }
        .quantity-input:focus {
            border-color: #4caf50;
            outline: none;
        }
        .badge-stock-big {
            background: #e8f5e9;
            color: #2e7d32;
            font-weight: 600;
            padding: 6px 18px;
            border-radius: 20px;
        }
        .badge-outofstock-big {
            background: #ffebee;
            color: #c62828;
            font-weight: 600;
            padding: 6px 18px;
            border-radius: 20px;
        }
        .review-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e8f0e8;
            margin-bottom: 15px;
        }
        .review-card .reviewer-name {
            font-weight: 600;
            color: #1a2e1a;
        }
        .review-card .review-date {
            color: #888;
            font-size: 0.85rem;
        }
        .review-card .review-text {
            color: #555;
            margin-top: 8px;
        }
        .footer {
            background: #1a2e1a;
            color: #d4d4d4;
            padding: 40px 0 20px;
            margin-top: 40px;
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
        @media (max-width: 768px) {
            .product-title {
                font-size: 1.4rem;
            }
            .product-price {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

<?php
/**
 * Normalizes an image path so it resolves correctly no matter what URL
 * the current page is served from (e.g. /product/123).
 *
 * Without this, a relative path like "uploads/products/x.jpg" gets resolved
 * by the browser against the CURRENT page URL's directory, turning it into
 * "/product/uploads/products/x.jpg" -> 404.
 *
 * This forces the path to be root-relative ("/uploads/products/x.jpg")
 * or leaves it alone if it's already absolute / a full URL.
 */
function resolveImageUrl($path) {
    if (empty($path)) {
        return 'https://via.placeholder.com/400x400?text=No+Image';
    }
    // Already a full URL (http:// or https://)
    if (preg_match('#^https?://#i', $path)) {
        return $path;
    }
    // Already root-relative (starts with /)
    if (strpos($path, '/') === 0) {
        return $path;
    }
    // Otherwise treat it as relative to the site root
    return '/' . ltrim($path, './');
}
?>

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

<!-- Breadcrumb -->
<div class="container">
    <nav class="breadcrumb-custom">
        <a href="/">Home</a> <span class="mx-2">/</span>
        <a href="/products">Products</a> <span class="mx-2">/</span>
        <span class="active"><?= $product['name'] ?? 'Product' ?></span>
    </nav>
</div>

<!-- Product Details -->
<section class="py-4">
    <div class="container">
        <div class="row">
<!-- Product Images -->
<div class="col-lg-6">
    <?php
    // Get the main image (normalized so it always resolves from site root)
    $mainImage = resolveImageUrl($product['image'] ?? null);
    ?>
    <img src="<?= $mainImage ?>" alt="<?= $product['name'] ?? 'Product' ?>" class="product-image-main" id="mainImage">
    <div class="product-thumbnails mt-3 d-flex gap-2">
        <?php 
        // Safely handle images array
        $images = $product['images'] ?? [];
        if (empty($images)) {
            $images = ['https://via.placeholder.com/400x400?text=No+Image'];
        }
        foreach ($images as $index => $image):
            $thumbSrc = resolveImageUrl($image);
        ?>
            <img src="<?= $thumbSrc ?>" alt="Thumb <?= $index + 1 ?>" class="<?= $index === 0 ? 'active' : '' ?>" onclick="changeImage(this.src, this)">
        <?php endforeach; ?>
    </div>
</div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <?php 
                $badges = $product['badges'] ?? ['New'];
                foreach ($badges as $badge): 
                ?>
                    <span class="badge <?= $badge === 'New' ? 'bg-success' : 'bg-danger' ?> mb-2 me-1"><?= $badge ?></span>
                <?php endforeach; ?>
                <h1 class="product-title"><?= $product['name'] ?? 'Product' ?></h1>
                <div class="mb-2">
                    <span class="product-rating">
                        <?php
                        $rating = $product['rating'] ?? 0;
                        $fullStars = floor($rating);
                        $halfStar = ($rating - $fullStars) >= 0.5;
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $fullStars) {
                                echo '<i class="fas fa-star"></i>';
                            } elseif ($halfStar && $i == $fullStars + 1) {
                                echo '<i class="fas fa-star-half-alt"></i>';
                            } else {
                                echo '<i class="far fa-star"></i>';
                            }
                        }
                        ?>
                    </span>
                    <span class="product-rating-count">(<?= $product['reviews'] ?? 0 ?> reviews)</span>
                </div>
                <div>
                    <span class="product-price">$<?= number_format($product['price'] ?? 0, 2) ?></span>
                    <?php if (isset($product['old_price']) && $product['old_price']): ?>
                        <span class="product-old-price">$<?= number_format($product['old_price'], 2) ?></span>
                    <?php endif; ?>
                </div>
                <div class="mt-2">
                    <?php if ($product['in_stock'] ?? false): ?>
                        <span class="badge-stock-big"><i class="fas fa-check-circle me-1"></i> In Stock</span>
                    <?php else: ?>
                        <span class="badge-outofstock-big"><i class="fas fa-times-circle me-1"></i> Out of Stock</span>
                    <?php endif; ?>
                </div>
                <hr>
                <p class="product-description"><?= $product['description'] ?? 'No description available.' ?></p>
                <div class="product-meta mb-3">
                    <p><strong>Category:</strong> <?= $product['category'] ?? 'General' ?></p>
                    <p><strong>Subcategory:</strong> <?= $product['subcategory'] ?? 'N/A' ?></p>
                    <p><strong>Store:</strong> <?= $product['store'] ?? 'ShopEase' ?></p>
                    <p><strong>SKU:</strong> <?= $product['sku'] ?? 'N/A' ?></p>
                </div>

                <!-- Quantity & Add to Cart -->
                <div class="d-flex align-items-center gap-3 mb-3">
                    <label class="fw-bold">Quantity:</label>
                    <input type="number" class="quantity-input" value="1" min="1" max="10">
                </div>
                <div class="d-flex gap-3">
                    <button class="btn-add-cart" onclick="addToCart()"><i class="fas fa-cart-plus me-2"></i>Add to Cart</button>
                    <button class="btn-wishlist" onclick="toggleWishlist(this)"><i class="far fa-heart me-2"></i>Wishlist</button>
                </div>

                <!-- Store Info -->
                <div class="mt-4 p-3 bg-white rounded-3 border">
                    <h6><i class="fas fa-store text-success me-2"></i>Sold by: <?= $product['store'] ?? 'ShopEase' ?></h6>
                    <p class="text-muted small mb-0">⭐ 4.8 (2,340 ratings) | 98% positive feedback</p>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-5">
            <h4 class="fw-bold">Customer Reviews</h4>
            <div class="review-card">
                <div class="d-flex justify-content-between">
                    <span class="reviewer-name">John D.</span>
                    <span class="review-date">August 5, 2026</span>
                </div>
                <div class="product-rating small">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="review-text">Amazing product! Highly recommend to everyone.</p>
            </div>
            <div class="review-card">
                <div class="d-flex justify-content-between">
                    <span class="reviewer-name">Sarah M.</span>
                    <span class="review-date">August 3, 2026</span>
                </div>
                <div class="product-rating small">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
                <p class="review-text">Good quality and fast delivery. Very satisfied.</p>
            </div>
            <div class="review-card">
                <div class="d-flex justify-content-between">
                    <span class="reviewer-name">Mike R.</span>
                    <span class="review-date">August 1, 2026</span>
                </div>
                <div class="product-rating small">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <p class="review-text">Great product for the price. Would buy again.</p>
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

    function changeImage(src, element) {
        document.getElementById('mainImage').src = src;
        document.querySelectorAll('.product-thumbnails img').forEach(function(img) {
            img.classList.remove('active');
        });
        element.classList.add('active');
    }

    function toggleWishlist(button) {
        var icon = button.querySelector('i');
        if (icon.classList.contains('far')) {
            icon.classList.remove('far');
            icon.classList.add('fas');
            icon.style.color = '#dc3545';
            button.innerHTML = '<i class="fas fa-heart me-2" style="color:#dc3545;"></i>Added to Wishlist';
        } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
            icon.style.color = '';
            button.innerHTML = '<i class="far fa-heart me-2"></i>Wishlist';
        }
    }

   function addToCart() {
    var qty = document.querySelector('.quantity-input').value;
    var productId = <?= $product['id'] ?? 0 ?>;
    
    if (!productId) {
        alert('Product ID not found.');
        return;
    }

    // Show loading state
    var btn = document.querySelector('.btn-add-cart');
    var originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Adding...';
    btn.disabled = true;

    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: 'product_id=' + productId + '&quantity=' + qty
    })
    .then(response => response.json())
    .then(data => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        
        if (data.success) {
            alert('✅ ' + data.message);
            updateCartBadge(data.cart_count);
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        console.error('Error:', error);
        alert('Something went wrong. Please try again.');
    });
}

function updateCartBadge(count) {
    var badge = document.getElementById('cartBadge');
    if (badge) {
        if (count > 0) {
            badge.textContent = count;
            badge.style.display = 'inline';
        } else {
            badge.style.display = 'none';
        }
    }
}
</script>
</body>
</html>