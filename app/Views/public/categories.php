<!-- app/Views/public/categories.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
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
            --shadow: 0 4px 20px rgba(0,0,0,0.08);
            --shadow-hover: 0 12px 32px rgba(0,0,0,0.14);
            --font: 'Inter', sans-serif;
            --display: 'Sora', sans-serif;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font); color: var(--text); background: var(--surface); padding-top: 92px; }
        a { text-decoration: none; color: inherit; }

        /* ─── NAVBAR (matches homepage) ─────────────── */
        .site-nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            padding: 18px 0;
            background: rgba(255,255,255,0.98);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(12px);
            transition: padding 0.3s ease, box-shadow 0.3s ease;
        }
        .site-nav.scrolled { padding: 12px 0; box-shadow: 0 2px 16px rgba(0,0,0,0.08); }
        .nav-logo {
            font-family: var(--display); font-size: 1.5rem; font-weight: 800;
            color: var(--brand); letter-spacing: -0.5px;
        }
        .nav-logo span { color: var(--accent); }
        .nav-link-item {
            font-size: 0.9rem; font-weight: 500; color: #374151;
            padding: 6px 14px; border-radius: 8px; transition: all 0.2s;
        }
        .nav-link-item:hover, .nav-link-item.active { color: var(--accent); background: #fff5f5; }
        .nav-search {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 50px; padding: 9px 18px 9px 40px;
            font-size: 0.875rem; width: 220px; outline: none; transition: all 0.2s;
        }
        .nav-search:focus { border-color: var(--accent); background: var(--white); box-shadow: 0 0 0 3px rgba(233,69,96,0.1); }
        .search-wrap { position: relative; }
        .search-ico { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 0.82rem; }
        .nav-action {
            width: 38px; height: 38px; border-radius: 50%;
            border: 1px solid var(--border); background: var(--surface);
            display: flex; align-items: center; justify-content: center;
            color: #374151; font-size: 0.95rem; transition: all 0.2s;
        }
        .nav-action:hover { border-color: var(--accent); color: var(--accent); background: #fff5f5; }

        /* ─── PAGE HEADER ────────────────────────────── */
        .page-header { background: var(--brand); color: #fff; padding: 44px 0 34px; }
        .page-header h2 { font-family: var(--display); font-weight: 800; font-size: 1.8rem; }
        .page-header .breadcrumb { display: flex; align-items: center; gap: 8px; margin-top: 6px; font-size: 0.85rem; }
        .page-header .breadcrumb a { color: var(--accent-light); }
        .page-header .breadcrumb .active { color: rgba(255,255,255,0.55); }

        /* ─── SIDEBAR ─────────────────────────────────── */
        .sidebar-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 22px; box-shadow: var(--shadow); }
        .sidebar-card h6 { font-family: var(--display); color: var(--brand); font-weight: 700; }
        .sidebar-card hr { border-color: var(--border); }
        .sidebar-card .category-link { display: block; padding: 9px 12px; color: var(--muted); border-radius: 8px; font-size: 0.9rem; transition: all 0.2s; }
        .sidebar-card .category-link:hover { background: #fff5f5; color: var(--accent); }
        .sidebar-card .category-link.active { background: #fff5f5; color: var(--accent); font-weight: 700; }

        /* ─── MAIN CONTENT ───────────────────────────── */
        .content-panel { background: var(--white); border-radius: var(--radius-lg); padding: 28px; border: 1px solid var(--border); box-shadow: var(--shadow); }
        .content-panel h4 { font-family: var(--display); color: var(--brand); font-weight: 800; }
        .content-panel hr { border-color: var(--border); }

        /* ─── PRODUCT CARD ───────────────────────────── */
        .product-card { background: var(--white); border-radius: var(--radius); padding: 20px; box-shadow: var(--shadow); border: 1px solid var(--border); transition: all 0.25s cubic-bezier(0.16,1,0.3,1); height: 100%; }
        .product-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-hover); border-color: transparent; }
        .product-card .product-image { height: 150px; object-fit: contain; width: 100%; }
        .product-card .product-name { color: var(--brand); font-weight: 600; font-size: 1rem; margin-top: 10px; }
        .product-card .product-category { color: var(--muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.4px; }
        .product-card .price { font-family: var(--display); color: var(--brand); font-weight: 800; font-size: 1.2rem; }
        .product-card .btn-add {
            background: var(--accent); color: #fff; border: none; border-radius: 30px;
            padding: 9px 20px; font-weight: 600; font-size: 0.85rem; transition: all 0.2s;
            width: 100%; display: inline-block; text-align: center;
        }
        .product-card .btn-add:hover { background: #c73652; color: #fff; }

        /* ─── FOOTER (matches homepage) ─────────────── */
        .site-footer { background: #111827; padding: 60px 0 28px; margin-top: 40px; }
        .footer-logo { font-family: var(--display); font-size: 1.4rem; font-weight: 800; color: white; }
        .footer-logo span { color: var(--accent); }
        .footer-tagline { font-size: 0.85rem; color: #6b7280; margin-top: 8px; margin-bottom: 20px; max-width: 240px; }
        .footer-heading { color: white; font-size: 0.88rem; font-weight: 700; margin-bottom: 16px; }
        .footer-link { display: block; color: #6b7280; font-size: 0.84rem; margin-bottom: 9px; transition: color 0.2s; }
        .footer-link:hover { color: white; }
        .footer-news-input { background: #1f2937; border: 1px solid #374151; color: white; border-radius: 50px; padding: 10px 18px; font-size: 0.84rem; width: 100%; outline: none; transition: border 0.2s; }
        .footer-news-input:focus { border-color: var(--accent); }
        .btn-footer-sub { background: var(--accent); color: white; border: none; padding: 10px 20px; border-radius: 50px; font-size: 0.84rem; font-weight: 600; transition: background 0.2s; }
        .btn-footer-sub:hover { background: #c73652; }
        .footer-divider { border-color: #1f2937; margin: 32px 0 18px; }
        .footer-bottom { color: #4b5563; font-size: 0.8rem; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="site-nav" id="siteNav">
    <div class="container">
        <div class="d-flex align-items-center gap-4">
            <a href="/" class="nav-logo">Shop<span>Ease</span></a>

            <ul class="navbar-nav flex-row gap-1 d-none d-lg-flex ms-2">
                <li><a href="/" class="nav-link-item">Home</a></li>
                <li><a href="/categories" class="nav-link-item active">Categories</a></li>
                <li><a href="/products" class="nav-link-item">Products</a></li>
                <li><a href="/contact" class="nav-link-item">Contact</a></li>
            </ul>

            <div class="ms-auto d-flex align-items-center gap-2">
                <div class="search-wrap d-none d-md-block">
                    <i class="fas fa-search search-ico"></i>
                    <input type="search" class="nav-search" placeholder="Search for products...">
                </div>
                <button class="nav-action"><i class="far fa-heart"></i></button>
                <a href="/cart" class="nav-action"><i class="fas fa-shopping-cart"></i></a>
                <a href="/login" class="nav-action"><i class="far fa-user"></i></a>
            </div>
        </div>
    </div>
</nav>

<!-- PAGE HEADER -->
<section class="page-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2><i class="fas fa-tags me-2"></i><?= isset($selectedCategory) ? ucfirst($selectedCategory) : 'Categories' ?></h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="text-white-50">/</span>
                    <span class="active"><?= isset($selectedCategory) ? ucfirst($selectedCategory) : 'Categories' ?></span>
                </nav>
            </div>
            <div>
                <span class="text-white-50"><?= isset($products) ? count($products) : 0 ?> products</span>
            </div>
        </div>
    </div>
</section>

<!-- CATEGORIES SECTION -->
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
                <div class="content-panel">
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

<!-- FOOTER -->
<footer class="site-footer">
    <div class="container">
        <div class="row g-4 pb-4">
            <div class="col-lg-4 col-md-6">
                <div class="footer-logo">Shop<span>Ease</span></div>
                <p class="footer-tagline">Your one-stop shop for everything you need.</p>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="footer-heading">Quick Links</h6>
                <a href="/about" class="footer-link">About Us</a>
                <a href="/contact" class="footer-link">Contact</a>
                <a href="/privacy" class="footer-link">Privacy Policy</a>
                <a href="/terms" class="footer-link">Terms & Conditions</a>
            </div>
            <div class="col-lg-3 col-6">
                <h6 class="footer-heading">Customer Service</h6>
                <a href="/help" class="footer-link">Help Center</a>
                <a href="/returns" class="footer-link">Returns</a>
                <a href="/shipping" class="footer-link">Shipping Info</a>
                <a href="/track" class="footer-link">Track Order</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h6 class="footer-heading">Newsletter</h6>
                <p class="footer-link mb-3">Get the latest deals & updates</p>
                <form class="d-flex gap-2">
                    <input type="email" class="footer-news-input" placeholder="Your email">
                    <button type="submit" class="btn-footer-sub">Join</button>
                </form>
            </div>
        </div>
        <hr class="footer-divider">
        <p class="text-center footer-bottom mb-0">&copy; 2026 ShopEase. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.addEventListener('scroll', function() {
        document.getElementById('siteNav').classList.toggle('scrolled', window.scrollY > 40);
    });
</script>
</body>
</html>