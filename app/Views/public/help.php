<!-- app/Views/public/help.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Center - ShopEase</title>
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
        .nav-link-item:hover { color: var(--accent); background: #fff5f5; }
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

        /* ─── HELP CARDS ─────────────────────────────── */
        .content-section { padding: 56px 0; }
        .help-card {
            background: var(--white); border-radius: var(--radius-lg); padding: 28px;
            border: 1px solid var(--border); transition: all 0.25s cubic-bezier(0.16,1,0.3,1); height: 100%;
        }
        .help-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-hover); border-color: transparent; }
        .help-card i { font-size: 2rem; color: var(--accent); margin-bottom: 15px; }
        .help-card h5 { font-family: var(--display); color: var(--brand); font-weight: 700; }
        .help-card p { color: var(--muted); }
        .help-card a.learn-more { color: var(--accent); font-weight: 600; font-size: 0.9rem; }
        .help-card a.learn-more:hover { color: #c73652; }

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
        <h2><i class="fas fa-question-circle me-2"></i>Help Center</h2>
        <nav class="breadcrumb">
            <a href="/">Home</a>
            <span>/</span>
            <span class="active">Help Center</span>
        </nav>
    </div>
</section>

<!-- CONTENT -->
<section class="content-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="help-card">
                    <i class="fas fa-shopping-bag"></i>
                    <h5>Order Help</h5>
                    <p>Track your orders, modify or cancel orders.</p>
                    <a href="/returns" class="learn-more">Learn More →</a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="help-card">
                    <i class="fas fa-truck"></i>
                    <h5>Shipping & Delivery</h5>
                    <p>Check shipping times, tracking and delivery options.</p>
                    <a href="/shipping" class="learn-more">Learn More →</a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="help-card">
                    <i class="fas fa-undo-alt"></i>
                    <h5>Returns & Refunds</h5>
                    <p>Our return policy, refund process and exchanges.</p>
                    <a href="/returns" class="learn-more">Learn More →</a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="help-card">
                    <i class="fas fa-credit-card"></i>
                    <h5>Payments</h5>
                    <p>Payment methods, billing and security.</p>
                    <a href="#" class="learn-more">Learn More →</a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="help-card">
                    <i class="fas fa-user-cog"></i>
                    <h5>Account Help</h5>
                    <p>Manage your account, password and settings.</p>
                    <a href="/login" class="learn-more">Learn More →</a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="help-card">
                    <i class="fas fa-headset"></i>
                    <h5>Contact Support</h5>
                    <p>Get in touch with our support team.</p>
                    <a href="/contact" class="learn-more">Learn More →</a>
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
            </div>
            <div class="col-lg-3 col-6">
                <h6 class="footer-heading">Customer Service</h6>
                <a href="/help" class="footer-link">Help Center</a>
                <a href="/returns" class="footer-link">Returns</a>
                <a href="/shipping" class="footer-link">Shipping Info</a>
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