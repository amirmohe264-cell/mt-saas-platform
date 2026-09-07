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

        /* Notification Toast Styles */
        .notification-container {
            position: fixed;
            top: 90px;
            right: 20px;
            z-index: 9999;
            max-width: 380px;
            width: 100%;
        }
        .notification-toast {
            background: #fff;
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 10px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.15);
            border-left: 4px solid #4caf50;
            animation: slideInRight 0.4s ease;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        .notification-toast.error { border-left-color: #dc3545; }
        .notification-toast.warning { border-left-color: #ffc107; }
        .notification-toast.info { border-left-color: #17a2b8; }
        .notification-toast .notif-icon { font-size: 1.3rem; margin-top: 2px; }
        .notification-toast .notif-content { flex: 1; }
        .notification-toast .notif-title { font-weight: 600; color: #1a2e1a; font-size: 0.9rem; }
        .notification-toast .notif-message { color: #555; font-size: 0.85rem; }
        .notification-toast .notif-close {
            background: none;
            border: none;
            color: #aaa;
            cursor: pointer;
            font-size: 1rem;
            padding: 0 5px;
        }
        .notification-toast .notif-close:hover { color: #333; }
        .notification-toast.removing { animation: slideOutRight 0.3s ease forwards; }
        @keyframes slideInRight {
            from { transform: translateX(100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100px); opacity: 0; }
        }

        /* Navbar */
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
            position: relative;
            text-decoration: none;
        }
        .icon-btn:hover {
            color: #4caf50;
        }
        .icon-btn .badge-count {
            background: #dc3545;
            color: #fff;
            border-radius: 50%;
            padding: 2px 8px;
            font-size: 0.7rem;
            position: absolute;
            top: -8px;
            right: -8px;
            font-weight: 600;
            min-width: 18px;
            text-align: center;
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
        .btn-add-cart:disabled {
            opacity: 0.7;
            cursor: not-allowed;
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
        .btn-wishlist:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
        .btn-wishlist.in-wishlist {
            border-color: #dc3545;
            color: #dc3545;
            background: #fff5f5;
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

        /* ShopEase visual system — matched to the reference page */
        :root {
            --brand: #1a1a2e;
            --brand-mid: #16213e;
            --accent: #e94560;
            --accent-light: #ff6b6b;
            --gold: #f5a623;
            --text: #1a1a2e;
            --muted: #6b7280;
            --border: #e5e7eb;
            --surface: #f9fafb;
            --white: #ffffff;
            --radius: 12px;
            --radius-lg: 20px;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --shadow-hover: 0 12px 32px rgba(0, 0, 0, 0.14);
            --font: 'Inter', sans-serif;
            --display: 'Sora', sans-serif;
        }

        body {
            font-family: var(--font);
            color: var(--text);
            background: var(--white);
        }

        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            border-bottom: 1px solid var(--border);
            box-shadow: none;
            padding: 18px 0;
            backdrop-filter: blur(12px);
        }

        .navbar-scrolled {
            background: rgba(255, 255, 255, 0.98) !important;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.08);
            padding: 12px 0;
        }

        .navbar-brand {
            color: var(--brand) !important;
            font-family: var(--display);
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .navbar-brand i {
            color: var(--accent);
        }

        .navbar .nav-link {
            color: #374151 !important;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 6px 14px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link.active {
            color: var(--accent) !important;
            background: #fff5f5;
        }

        .navbar .nav-link::after {
            display: none;
        }

        .search-box {
            width: 240px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 50px;
            color: var(--text);
            padding: 9px 18px;
            font-size: 0.875rem;
        }

        .search-box::placeholder {
            color: #9ca3af;
        }

        .search-box:focus {
            background: var(--white);
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.1);
        }

        .icon-btn {
            width: 38px;
            height: 38px;
            margin: 0;
            border: 1px solid var(--border);
            border-radius: 50%;
            background: var(--surface);
            color: #374151;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
        }

        .icon-btn:hover {
            background: #fff5f5;
            border-color: var(--accent);
            color: var(--accent);
        }

        .icon-btn .badge-count {
            top: -5px;
            right: -5px;
            min-width: 18px;
            padding: 2px 5px;
            background: var(--accent);
            font-size: 0.68rem;
        }

        .navbar-toggler {
            border-color: var(--accent);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(233, 69, 96, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .breadcrumb-custom {
            padding: 0;
            margin: 0;
        }

        .breadcrumb-custom a {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.85rem;
        }

        .breadcrumb-custom a:hover {
            color: var(--accent-light);
        }

        .breadcrumb-custom .active {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.85rem;
        }

        .product-image-main {
            max-height: 460px;
            padding: 28px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
        }

        .product-thumbnails img {
            border-color: var(--border);
            border-radius: var(--radius);
        }

        .product-thumbnails img:hover,
        .product-thumbnails img.active {
            border-color: var(--accent);
        }

        .product-title {
            color: var(--brand);
            font-family: var(--display);
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .product-price {
            color: var(--accent);
            font-family: var(--display);
            font-size: 2rem;
            font-weight: 800;
        }

        .product-description {
            color: var(--muted);
        }

        .product-meta {
            color: var(--muted);
        }

        .product-meta strong {
            color: var(--brand);
        }

        .quantity-input {
            border: 1px solid var(--border);
            border-radius: 8px;
        }

        .quantity-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.1);
        }

        .btn-add-cart {
            background: var(--accent);
            border-radius: 50px;
            padding: 12px 30px;
            font-size: 0.95rem;
        }

        .btn-add-cart:hover {
            background: #c73652;
            box-shadow: 0 8px 20px rgba(233, 69, 96, 0.22);
        }

        .btn-wishlist {
            color: var(--brand);
            border: 1px solid var(--border);
            border-radius: 50px;
            background: var(--white);
            padding: 12px 20px;
        }

        .btn-wishlist:hover {
            border-color: var(--accent);
            color: var(--accent);
            background: #fff5f5;
        }

        .badge-stock-big {
            background: #ecfdf5;
            color: #047857;
        }

        .review-card,
        .product-section .mt-4.p-3 {
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
        }

        .review-card .reviewer-name {
            color: var(--brand);
        }

        .notification-container {
            top: 80px;
            right: 20px;
            width: 320px;
        }

        .notification-toast {
            border-left: 3px solid #10b981;
            border-radius: var(--radius);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.14);
        }

        .notification-toast.error {
            border-left-color: var(--accent);
        }

        .notification-toast .notif-title {
            color: var(--brand);
        }

        .footer {
            background: #111827;
            color: #d1d5db;
            padding: 60px 0 28px;
            margin-top: 64px;
        }

        .footer h5 {
            color: white;
            font-family: var(--display);
            font-size: 0.88rem;
            font-weight: 700;
        }

        .footer a {
            color: #6b7280;
            font-size: 0.84rem;
        }

        .footer a:hover {
            color: white;
        }

        .footer .text-muted {
            color: #6b7280 !important;
        }

        .footer hr {
            border-color: #1f2937;
        }

        .footer .form-control {
            background: #1f2937 !important;
            border: 1px solid #374151 !important;
            border-radius: 50px 0 0 50px;
            color: white;
        }

        .footer .btn-success {
            background: var(--accent) !important;
            border: none !important;
            border-radius: 0 50px 50px 0;
        }

        @media (max-width: 576px) {
            .search-box {
                width: 180px;
            }

            .product-title {
                font-size: 1.6rem;
            }

            .product-image-main {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<?php
/**
 * Normalizes an image path so it resolves correctly no matter what URL
 * the current page is served from (e.g. /product/123).
 */
function resolveImageUrl($path) {
    if (empty($path)) {
        return 'https://via.placeholder.com/400x400?text=No+Image';
    }
    if (preg_match('#^https?://#i', $path)) {
        return $path;
    }
    if (strpos($path, '/') === 0) {
        return $path;
    }
    return '/' . ltrim($path, './');
}
?>

<!-- Notification Container -->
<div class="notification-container" id="notificationContainer"></div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/">Shop<span style="color:var(--accent);">Ease</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/products">Shop</a></li>
                <li class="nav-item"><a class="nav-link" href="/store/apply">Sell With Us</a></li>
                <li class="nav-item"><a class="nav-link" href="/contact">Contact</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <input class="search-box me-2" type="search" placeholder="Search for products...">
                <a href="/wishlist" class="icon-btn" style="position:relative;">
                    <i class="fas fa-heart"></i>
                    <span class="badge-count" id="wishlistBadge" style="display:none;">0</span>
                </a>
                <a href="/cart" class="icon-btn" style="position:relative;">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="badge-count" id="cartBadge">0</span>
                </a>
                <?php if (session()->get('customer_id') || session()->get('user_id')): ?>
                    <a href="/logout" class="icon-btn"><i class="fas fa-sign-out-alt"></i></a>
                <?php else: ?>
                    <a href="/login" class="icon-btn"><i class="far fa-user"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Page Header -->
<section class="page-header" style="background:var(--brand);padding:44px 0 34px;">
    <div class="container">
        <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.18);color:#e5e7eb;font-size:.75rem;font-weight:600;padding:5px 14px;border-radius:50px;margin-bottom:14px;">
            <span style="width:6px;height:6px;border-radius:50%;background:var(--gold);"></span> Marketplace
        </div>
        <h2 style="font-family:var(--display);font-size:2rem;font-weight:800;color:white;margin-bottom:8px;">Product Details</h2>
        <nav class="breadcrumb-custom">
            <a href="/">Home</a> <span class="mx-2" style="color:rgba(255,255,255,.3);">/</span>
            <a href="/products">Products</a> <span class="mx-2" style="color:rgba(255,255,255,.3);">/</span>
            <span class="active"><?= $product['name'] ?? 'Product' ?></span>
        </nav>
    </div>
</section>

<!-- Product Details -->
<section class="py-5 product-section">
    <div class="container">
        <div class="row">
            <!-- Product Images -->
            <div class="col-lg-6">
                <?php
                $mainImage = resolveImageUrl($product['image'] ?? null);
                ?>
                <img src="<?= $mainImage ?>" alt="<?= $product['name'] ?? 'Product' ?>" class="product-image-main" id="mainImage">
                <div class="product-thumbnails mt-3 d-flex gap-2">
                    <?php 
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
                    <span class="product-price"><?= number_format($product['price'] ?? 0, 2) ?> ETB</span>
                    <?php if (isset($product['old_price']) && $product['old_price']): ?>
                        
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
                    <input type="number" class="quantity-input" id="quantityInput" value="1" min="1" max="10">
                </div>
                <div class="d-flex gap-3 flex-wrap">
                    <button class="btn-add-cart" onclick="addToCart()"><i class="fas fa-cart-plus me-2"></i>Add to Cart</button>
                    <button class="btn-wishlist" id="wishlistBtn" onclick="addToWishlist(<?= $product['id'] ?? 0 ?>)">
                        <i class="far fa-heart me-2"></i>Wishlist
                    </button>
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

            <div id="reviewFormContainer" class="mb-4"></div>

            <?php if (empty($product['reviewsList'])): ?>
                <p class="text-muted">No reviews yet. Be the first to review this product!</p>
            <?php else: ?>
                <?php foreach ($product['reviewsList'] as $review): ?>
                    <div class="review-card">
                        <div class="d-flex justify-content-between">
                            <span class="reviewer-name"><?= esc($review['first_name']) ?> <?= esc(substr($review['last_name'], 0, 1)) ?>.</span>
                            <span class="review-date"><?= date('F j, Y', strtotime($review['created_at'])) ?></span>
                        </div>
                        <div class="product-rating small">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="<?= $i <= $review['rating'] ? 'fas' : 'far' ?> fa-star"></i>
                            <?php endfor; ?>
                        </div>
                        <?php if ($review['review_title']): ?>
                            <p class="fw-bold mb-1 mt-2"><?= esc($review['review_title']) ?></p>
                        <?php endif; ?>
                        <p class="review-text"><?= esc($review['review_comment']) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
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
        <p class="text-center text-muted small">&copy; <?= date('Y') ?> ShopEase. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // ============================================
    // NAVBAR SCROLL EFFECT
    // ============================================
    window.addEventListener('scroll', function() {
        var navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    });

    // ============================================
    // CHANGE PRODUCT IMAGE
    // ============================================
    function changeImage(src, element) {
        document.getElementById('mainImage').src = src;
        document.querySelectorAll('.product-thumbnails img').forEach(function(img) {
            img.classList.remove('active');
        });
        element.classList.add('active');
    }

    // ============================================
    // NOTIFICATION FUNCTION
    // ============================================
    function showNotification(type, title, message) {
        var container = document.getElementById('notificationContainer');
        if (!container) return;
        
        var icons = { success: '✅', error: '❌', warning: '⚠️', info: 'ℹ️' };
        var icon = icons[type] || 'ℹ️';
        
        var toast = document.createElement('div');
        toast.className = 'notification-toast ' + (type === 'error' ? 'error' : type === 'warning' ? 'warning' : type === 'info' ? 'info' : '');
        toast.innerHTML = `
            <div class="notif-icon">${icon}</div>
            <div class="notif-content">
                <div class="notif-title">${title}</div>
                <div class="notif-message">${message}</div>
            </div>
            <button class="notif-close" onclick="this.closest('.notification-toast').remove()">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        container.appendChild(toast);
        
        setTimeout(function() {
            if (toast.parentNode) {
                toast.classList.add('removing');
                setTimeout(function() {
                    if (toast.parentNode) toast.remove();
                }, 300);
            }
        }, 5000);
    }

    // ============================================
    // ADD TO CART
    // ============================================
    function addToCart() {
        var qty = document.getElementById('quantityInput').value;
        var productId = <?= $product['id'] ?? 0 ?>;
        
        if (!productId) {
            showNotification('error', '❌ Error', 'Product ID not found.');
            return;
        }

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
                showNotification('success', '✅ Added to Cart', data.message);
                updateCartBadge(data.cart_count);
            } else {
                if (data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    showNotification('error', '❌ Error', data.message);
                }
            }
        })
        .catch(error => {
            btn.innerHTML = originalText;
            btn.disabled = false;
            console.error('Error:', error);
            showNotification('error', '❌ Error', 'Something went wrong. Please try again.');
        });
    }

    // ============================================
    // ADD TO WISHLIST - SAVES TO DATABASE
    // ============================================
    function addToWishlist(productId) {
        if (!productId) {
            showNotification('error', '❌ Error', 'Product ID not found.');
            return;
        }

        var btn = document.getElementById('wishlistBtn');
        var originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Adding...';
        btn.disabled = true;

        fetch('/wishlist/add', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId
            })
        })
        .then(response => response.json())
        .then(data => {
            btn.innerHTML = originalHtml;
            btn.disabled = false;
            
            if (data.success) {
                // Change button to show it's in wishlist
                btn.innerHTML = '<i class="fas fa-heart me-2" style="color:#dc3545;"></i>In Wishlist';
                btn.classList.add('in-wishlist');
                showNotification('success', '❤️ Added to Wishlist', data.message);
                updateWishlistBadge();
            } else {
                if (data.message === 'Item already in your wishlist') {
                    // Already in wishlist - show as added
                    btn.innerHTML = '<i class="fas fa-heart me-2" style="color:#dc3545;"></i>In Wishlist';
                    btn.classList.add('in-wishlist');
                    showNotification('info', 'ℹ️ Already Added', 'This item is already in your wishlist.');
                } else if (data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    showNotification('error', '❌ Error', data.message || 'Could not add to wishlist.');
                }
            }
        })
        .catch(error => {
            btn.innerHTML = originalHtml;
            btn.disabled = false;
            console.error('Error:', error);
            showNotification('error', '❌ Error', 'Could not add to wishlist. Please try again.');
        });
    }

    // ============================================
    // UPDATE CART BADGE
    // ============================================
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

    // ============================================
    // UPDATE WISHLIST BADGE
    // ============================================
    function updateWishlistBadge() {
        fetch('/wishlist/count', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                var badge = document.getElementById('wishlistBadge');
                if (badge) {
                    badge.textContent = data.count;
                    badge.style.display = data.count > 0 ? 'inline' : 'none';
                }
            }
        })
        .catch(error => console.error('Error updating wishlist badge:', error));
    }

    // ============================================
    // REVIEWS - LOAD FORM & SUBMIT
    // ============================================
    function loadReviewForm() {
        var productId = <?= $product['id'] ?? 0 ?>;
        fetch('/reviews/check/' + productId, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            var container = document.getElementById('reviewFormContainer');
            if (!data.logged_in) {
                container.innerHTML = '<p class="text-muted small">Please <a href="/login">login</a> to write a review.</p>';
                return;
            }
            if (!data.can_review) {
                container.innerHTML = '<p class="text-muted small">You can review this product after it has been delivered to you.</p>';
                return;
            }

            var existing = data.existing_review;
            var currentRating = existing ? existing.rating : 0;
            var currentTitle = existing ? existing.review_title || '' : '';
            var currentComment = existing ? existing.review_comment || '' : '';

            var starsHtml = '';
            for (var i = 1; i <= 5; i++) {
                starsHtml += '<i class="' + (i <= currentRating ? 'fas' : 'far') + ' fa-star review-star" data-star="' + i + '" style="cursor:pointer;font-size:1.5rem;color:#ffc107;"></i>';
            }

            container.innerHTML = `
                <div class="review-card">
                    <h6 class="fw-bold">${existing ? 'Update Your Review' : 'Write a Review'}</h6>
                    <div id="starRating" class="mb-2">${starsHtml}</div>
                    <input type="text" id="reviewTitle" class="form-control mb-2" placeholder="Review title (optional)" value="${currentTitle}">
                    <textarea id="reviewComment" class="form-control mb-2" rows="3" placeholder="Share your thoughts about this product...">${currentComment}</textarea>
                    <button class="btn-add-cart" onclick="submitReview(${productId})">Submit Review</button>
                </div>
            `;

            window.selectedRating = currentRating;
            document.querySelectorAll('.review-star').forEach(function(star) {
                star.addEventListener('click', function() {
                    window.selectedRating = parseInt(this.dataset.star);
                    document.querySelectorAll('.review-star').forEach(function(s) {
                        s.className = parseInt(s.dataset.star) <= window.selectedRating
                            ? 'fas fa-star review-star'
                            : 'far fa-star review-star';
                        s.style.cursor = 'pointer';
                        s.style.fontSize = '1.5rem';
                        s.style.color = '#ffc107';
                    });
                });
            });
        })
        .catch(error => console.error('Error loading review form:', error));
    }

    function submitReview(productId) {
        if (!window.selectedRating || window.selectedRating < 1) {
            showNotification('error', '❌ Error', 'Please select a star rating.');
            return;
        }

        fetch('/reviews/submit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                product_id: productId,
                rating: window.selectedRating,
                review_title: document.getElementById('reviewTitle').value,
                review_comment: document.getElementById('reviewComment').value
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('success', '✅ Thank You', data.message);
            } else {
                showNotification('error', '❌ Error', data.message);
            }
        })
        .catch(error => {
            console.error('Error submitting review:', error);
            showNotification('error', '❌ Error', 'Could not submit review.');
        });
    }

    // ============================================
    // PAGE LOAD - WISHLIST STATUS, CART BADGE, REVIEWS
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        // Check if product is in wishlist
        var productId = <?= $product['id'] ?? 0 ?>;
        if (productId) {
            fetch('/wishlist/check/' + productId, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.in_wishlist) {
                    var btn = document.getElementById('wishlistBtn');
                    btn.innerHTML = '<i class="fas fa-heart me-2" style="color:#dc3545;"></i>In Wishlist';
                    btn.classList.add('in-wishlist');
                }
            })
            .catch(error => console.error('Error checking wishlist:', error));
        }

        // Update cart badge on load
        <?php if (session()->get('cart_count')): ?>
            updateCartBadge(<?= session()->get('cart_count') ?>);
        <?php endif; ?>

        // Update wishlist badge on load
        updateWishlistBadge();

        // Load the review form
        loadReviewForm();
    });
</script>

</body>
</html>