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
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8f9fa; padding-top: 80px; }
        
        /* Navbar */
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

        /* ========================================== */
        /* FILTER SIDEBAR - WITH DROPDOWN */
        /* ========================================== */
        .filter-sidebar {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border: 1px solid #e8f0e8;
        }
        .filter-sidebar .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }
        .filter-sidebar .filter-header h6 {
            color: #1a2e1a;
            font-weight: 700;
            margin: 0;
        }
        .filter-sidebar .filter-header .clear-all {
            color: #dc3545;
            font-size: 0.8rem;
            cursor: pointer;
            text-decoration: none;
        }
        .filter-sidebar .filter-header .clear-all:hover {
            text-decoration: underline;
        }

        /* Category Accordion */
        .category-accordion {
            margin-bottom: 5px;
        }
        .category-accordion .category-header {
            display: flex;
            align-items: center;
            padding: 10px 14px;
            border: 2px solid #e8f0e8;
            border-radius: 30px;
            cursor: pointer;
            transition: 0.3s;
            background: #fff;
            user-select: none;
        }
        .category-accordion .category-header:hover {
            border-color: #4caf50;
        }
        .category-accordion .category-header.active {
            background: #4caf50;
            border-color: #4caf50;
            color: #fff;
        }
        .category-accordion .category-header .cat-name {
            font-size: 0.85rem;
            font-weight: 500;
            flex: 1;
        }
        .category-accordion .category-header .count {
            font-size: 0.7rem;
            color: #aaa;
            margin: 0 10px;
        }
        .category-accordion .category-header.active .count {
            color: #c8e6c9;
        }
        .category-accordion .category-header .arrow {
            font-size: 0.7rem;
            transition: transform 0.3s;
        }
        .category-accordion .category-header .arrow.open {
            transform: rotate(180deg);
        }
        .category-accordion .subcategory-list {
            padding-left: 25px;
            margin-top: 5px;
            margin-bottom: 5px;
            display: none;
            flex-wrap: wrap;
            gap: 4px;
        }
        .category-accordion .subcategory-list.show {
            display: flex;
        }
        .category-accordion .sub-filter-btn {
            background: #fafafa;
            border: 1.5px solid #e8f0e8;
            border-radius: 20px;
            padding: 3px 12px;
            font-size: 0.7rem;
            color: #777;
            cursor: pointer;
            transition: 0.3s;
        }
        .category-accordion .sub-filter-btn:hover {
            border-color: #4caf50;
            color: #4caf50;
        }
        .category-accordion .sub-filter-btn.active {
            background: #e8f5e9;
            border-color: #4caf50;
            color: #2e7d32;
        }

        /* Price Range */
        .price-section {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #f0f0f0;
        }
        .price-section .price-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        .price-section .price-inputs {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }
        .price-section .price-inputs input {
            width: 45%;
            padding: 6px 10px;
            border: 2px solid #e8f0e8;
            border-radius: 8px;
            font-size: 0.85rem;
            text-align: center;
        }
        .price-section .price-inputs input:focus {
            border-color: #4caf50;
            outline: none;
        }
        .price-section .price-inputs span {
            color: #888;
        }

        /* Filter Actions */
        .filter-actions {
            display: flex;
            gap: 8px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #f0f0f0;
        }
        .filter-actions .btn-apply {
            background: #4caf50;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 10px 20px;
            font-weight: 600;
            flex: 1;
            transition: 0.3s;
        }
        .filter-actions .btn-apply:hover {
            background: #388e3c;
        }
        .filter-actions .btn-reset {
            background: #f5f5f5;
            color: #555;
            border: none;
            border-radius: 30px;
            padding: 10px 20px;
            font-weight: 600;
            flex: 1;
            transition: 0.3s;
        }
        .filter-actions .btn-reset:hover {
            background: #e0e0e0;
        }

        /* Active Filters */
        .active-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 10px;
            min-height: 30px;
        }
        .active-filters .filter-tag {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .active-filters .filter-tag .remove {
            cursor: pointer;
            font-weight: 700;
        }
        .active-filters .filter-tag .remove:hover {
            color: #c62828;
        }

        /* ========================================== */
        /* PRODUCT CARDS */
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
        .product-card .product-subcategory {
            color: #aaa;
            font-size: 0.75rem;
        }
        .product-card .price {
            color: #1a2e1a;
            font-weight: 700;
            font-size: 1.2rem;
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

        .pagination .page-link { color: #1a2e1a; }
        .pagination .page-item.active .page-link { background: #4caf50; border-color: #4caf50; color: #fff; }
        .pagination .page-link:hover { color: #4caf50; }

        .footer { background: #1a2e1a; color: #d4d4d4; padding: 50px 0 20px; }
        .footer h5 { color: #fff; font-weight: 600; }
        .footer a { color: #aaa; text-decoration: none; transition: 0.3s; }
        .footer a:hover { color: #4caf50; }

        .navbar-toggler { border-color: #4caf50; }
        .navbar-toggler-icon { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(76, 175, 80, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e"); }

        .no-products-found { padding: 60px 0; }
        .no-products-found i { font-size: 4rem; color: #ddd; }
        .no-products-found h5 { color: #1a2e1a; }
        .no-products-found p { color: #888; }

        @media (max-width: 768px) {
            .filter-sidebar { margin-bottom: 20px; }
            .price-section .price-inputs input { width: 48%; }
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
                <h2>Products</h2>
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
        <div class="row">
            <!-- Filter Sidebar -->
            <div class="col-lg-3">
                <div class="filter-sidebar">
                    <!-- Header -->
                    <div class="filter-header">
                        <h6><i class="fas fa-filter me-2 text-success"></i>Filters</h6>
                        <a href="#" class="clear-all" onclick="clearAllFilters(event)">Clear All</a>
                    </div>

                    <!-- Active Filters -->
                    <div class="active-filters" id="activeFilters"></div>

                    <!-- Categories with Subcategories Dropdown -->
                    <div class="filter-section">
                        <?php if (isset($categories) && !empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <div class="category-accordion">
                                    <div class="category-header" data-category-id="<?= $cat['id'] ?>" onclick="toggleCategory(this)">
                                        <span class="cat-name"><?= $cat['category_name'] ?></span>
                                        <span class="count">(<?= isset($categoryCounts[$cat['id']]) ? $categoryCounts[$cat['id']] : 0 ?>)</span>
                                        <i class="fas fa-chevron-down arrow"></i>
                                    </div>
                                    <div class="subcategory-list" id="subcat_<?= $cat['id'] ?>">
                                        <?php 
                                        $hasSubs = false;
                                        if (isset($subcategories) && !empty($subcategories)): 
                                            foreach ($subcategories as $sub): 
                                                if ($sub['category_id'] == $cat['id']): 
                                                    $hasSubs = true;
                                        ?>
                                            <button class="sub-filter-btn" data-subcategory-id="<?= $sub['id'] ?>" data-category-id="<?= $cat['id'] ?>" onclick="selectSubcategory(this)">
                                                <?= $sub['subcategory_name'] ?>
                                            </button>
                                        <?php 
                                                endif; 
                                            endforeach; 
                                        endif; 
                                        ?>
                                        <?php if (!$hasSubs): ?>
                                            <span class="text-muted small" style="padding:4px 0;">No subcategories</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">No categories available</p>
                        <?php endif; ?>
                    </div>

                    <!-- Price Range -->
                    <div class="price-section">
                        <div class="price-title">Price Range</div>
                        <div class="price-inputs">
                            <input type="number" id="minPrice" placeholder="Min" value="0" onchange="applyFilters()">
                            <span>to</span>
                            <input type="number" id="maxPrice" placeholder="Max" value="1000" onchange="applyFilters()">
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="filter-actions">
                        <button class="btn-apply" onclick="applyFilters()"><i class="fas fa-check me-2"></i>Apply</button>
                        <button class="btn-reset" onclick="resetFilters()"><i class="fas fa-undo me-2"></i>Reset</button>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-lg-9">
                <div class="row" id="productGrid">
                    <?php if (isset($products) && !empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="col-md-4 mb-4 product-item" 
                                 data-category-id="<?= $product['category_id'] ?? 0 ?>" 
                                 data-category="<?= $product['category'] ?? '' ?>" 
                                 data-subcategory="<?= $product['subcategory'] ?? '' ?>"
                                 data-price="<?= $product['price'] ?>">
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
                                    <?php if (isset($product['subcategory']) && $product['subcategory']): ?>
                                        <p class="product-subcategory"><i class="fas fa-tag me-1"></i><?= $product['subcategory'] ?></p>
                                    <?php endif; ?>
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
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        var navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    });

    var allSubcategories = <?= isset($subcategories) ? json_encode($subcategories) : '[]' ?>;
    var selectedCategoryId = null;
    var selectedSubcategoryId = null;

    // Toggle category dropdown
    function toggleCategory(header) {
        var subList = header.nextElementSibling;
        var arrow = header.querySelector('.arrow');
        
        // Close all other categories
        document.querySelectorAll('.category-accordion .subcategory-list').forEach(function(list) {
            if (list !== subList) {
                list.classList.remove('show');
                var otherArrow = list.previousElementSibling.querySelector('.arrow');
                if (otherArrow) otherArrow.classList.remove('open');
            }
        });
        document.querySelectorAll('.category-accordion .category-header').forEach(function(h) {
            if (h !== header) {
                h.classList.remove('active');
            }
        });

        // Toggle this category
        subList.classList.toggle('show');
        arrow.classList.toggle('open');
        header.classList.toggle('active');
        
        // If opening, set as selected category
        if (subList.classList.contains('show')) {
            selectedCategoryId = header.dataset.categoryId;
            // Remove active from all subcategory buttons
            document.querySelectorAll('.sub-filter-btn').forEach(function(btn) {
                btn.classList.remove('active');
            });
            selectedSubcategoryId = null;
        } else {
            selectedCategoryId = null;
        }
        
        applyFilters();
    }

    // Select subcategory
    function selectSubcategory(button) {
        // Toggle active state
        button.classList.toggle('active');
        
        // Get the parent category header
        var parent = button.closest('.category-accordion');
        var header = parent.querySelector('.category-header');
        
        // If subcategory is selected, open the parent category
        if (button.classList.contains('active')) {
            // Open the parent category
            var subList = header.nextElementSibling;
            var arrow = header.querySelector('.arrow');
            subList.classList.add('show');
            arrow.classList.add('open');
            header.classList.add('active');
            selectedCategoryId = header.dataset.categoryId;
            selectedSubcategoryId = button.dataset.subcategoryId;
            
            // Close other categories
            document.querySelectorAll('.category-accordion .subcategory-list').forEach(function(list) {
                if (list !== subList) {
                    list.classList.remove('show');
                    var otherArrow = list.previousElementSibling.querySelector('.arrow');
                    if (otherArrow) otherArrow.classList.remove('open');
                }
            });
            document.querySelectorAll('.category-accordion .category-header').forEach(function(h) {
                if (h !== header) {
                    h.classList.remove('active');
                }
            });
        } else {
            selectedSubcategoryId = null;
        }
        
        applyFilters();
    }

    // Apply filters
    function applyFilters() {
        var minPrice = parseFloat(document.getElementById('minPrice').value) || 0;
        var maxPrice = parseFloat(document.getElementById('maxPrice').value) || Infinity;

        var products = document.querySelectorAll('.product-item');
        var visibleCount = 0;
        var grid = document.getElementById('productGrid');

        products.forEach(function(product) {
            var productCategoryId = product.dataset.categoryId;
            var productSubcategory = product.dataset.subcategory;
            var price = parseFloat(product.dataset.price);

            var categoryMatch = true;
            var subcategoryMatch = true;

            // Check category filter
            if (selectedCategoryId !== null) {
                categoryMatch = productCategoryId == selectedCategoryId;
            }

            // Check subcategory filter
            if (selectedSubcategoryId !== null) {
                subcategoryMatch = false;
                if (productSubcategory) {
                    for (var i = 0; i < allSubcategories.length; i++) {
                        if (allSubcategories[i].id == selectedSubcategoryId && 
                            allSubcategories[i].subcategory_name === productSubcategory) {
                            subcategoryMatch = true;
                            break;
                        }
                    }
                }
            }

            var priceMatch = price >= minPrice && price <= maxPrice;

            var productCol = product;
            if (categoryMatch && subcategoryMatch && priceMatch) {
                productCol.style.display = 'block';
                visibleCount++;
            } else {
                productCol.style.display = 'none';
            }
        });

        document.getElementById('productCount').textContent = 'Showing ' + visibleCount + ' products';
        updateActiveFilters();

        // Show/hide no products message
        var noProductsMsg = document.querySelector('.no-products-found');
        if (visibleCount === 0) {
            if (!noProductsMsg) {
                var msg = document.createElement('div');
                msg.className = 'no-products-found col-12 text-center py-5';
                msg.innerHTML = '<i class="fas fa-box-open fa-4x text-muted mb-3"></i><h5>No products found</h5><p class="text-muted">Try adjusting your filters.</p>';
                grid.appendChild(msg);
            }
        } else {
            if (noProductsMsg) {
                noProductsMsg.remove();
            }
        }
    }

    // Update active filters display
    function updateActiveFilters() {
        var container = document.getElementById('activeFilters');
        container.innerHTML = '';

        if (selectedCategoryId !== null) {
            var header = document.querySelector('.category-header[data-category-id="' + selectedCategoryId + '"]');
            if (header) {
                var name = header.querySelector('.cat-name').textContent;
                var tag = document.createElement('span');
                tag.className = 'filter-tag';
                tag.innerHTML = name + ' <span class="remove" onclick="clearCategoryFilter()">&times;</span>';
                container.appendChild(tag);
            }
        }

        if (selectedSubcategoryId !== null) {
            var btn = document.querySelector('.sub-filter-btn[data-subcategory-id="' + selectedSubcategoryId + '"]');
            if (btn) {
                var name = btn.textContent.trim();
                var tag = document.createElement('span');
                tag.className = 'filter-tag';
                tag.innerHTML = name + ' <span class="remove" onclick="clearSubcategoryFilter()">&times;</span>';
                container.appendChild(tag);
            }
        }

        var minPrice = document.getElementById('minPrice').value;
        var maxPrice = document.getElementById('maxPrice').value;
        if (minPrice > 0 || maxPrice < 1000) {
            var tag = document.createElement('span');
            tag.className = 'filter-tag';
            tag.innerHTML = '$' + minPrice + ' - $' + maxPrice + ' <span class="remove" onclick="resetPrice()">&times;</span>';
            container.appendChild(tag);
        }
    }

    function clearCategoryFilter() {
        // Close all categories
        document.querySelectorAll('.category-accordion .subcategory-list').forEach(function(list) {
            list.classList.remove('show');
        });
        document.querySelectorAll('.category-accordion .category-header').forEach(function(h) {
            h.classList.remove('active');
            var arrow = h.querySelector('.arrow');
            if (arrow) arrow.classList.remove('open');
        });
        document.querySelectorAll('.sub-filter-btn').forEach(function(btn) {
            btn.classList.remove('active');
        });
        selectedCategoryId = null;
        selectedSubcategoryId = null;
        applyFilters();
    }

    function clearSubcategoryFilter() {
        document.querySelectorAll('.sub-filter-btn').forEach(function(btn) {
            btn.classList.remove('active');
        });
        selectedSubcategoryId = null;
        applyFilters();
    }

    function resetPrice() {
        document.getElementById('minPrice').value = 0;
        document.getElementById('maxPrice').value = 1000;
        applyFilters();
    }

    function clearAllFilters(e) {
        if (e) e.preventDefault();
        document.querySelectorAll('.category-accordion .subcategory-list').forEach(function(list) {
            list.classList.remove('show');
        });
        document.querySelectorAll('.category-accordion .category-header').forEach(function(h) {
            h.classList.remove('active');
            var arrow = h.querySelector('.arrow');
            if (arrow) arrow.classList.remove('open');
        });
        document.querySelectorAll('.sub-filter-btn').forEach(function(btn) {
            btn.classList.remove('active');
        });
        document.getElementById('minPrice').value = 0;
        document.getElementById('maxPrice').value = 1000;
        selectedCategoryId = null;
        selectedSubcategoryId = null;
        applyFilters();
    }

    function resetFilters() {
        clearAllFilters(null);
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        updateActiveFilters();
    });
</script>
</body>
</html>