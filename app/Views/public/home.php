<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopEase &mdash; Premium Marketplace</title>
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
        body { font-family: var(--font); color: var(--text); background: var(--white); overflow-x: hidden; }
        a { text-decoration: none; color: inherit; }
        img { display: block; }

        /* ─── NAVBAR ────────────────────────────────── */
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
            padding: 6px 14px; border-radius: 8px;
            transition: all 0.2s;
        }
        .nav-link-item:hover { color: var(--accent); background: #fff5f5; }
        .nav-search {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 50px; padding: 9px 18px 9px 40px;
            font-size: 0.875rem; width: 260px; outline: none;
            transition: all 0.2s;
        }
        .nav-search:focus { border-color: var(--accent); background: var(--white); box-shadow: 0 0 0 3px rgba(233,69,96,0.1); }
        .search-wrap { position: relative; }
        .search-ico { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 0.82rem; }
        .nav-action {
            width: 38px; height: 38px; border-radius: 50%;
            border: 1px solid var(--border); background: var(--surface);
            display: flex; align-items: center; justify-content: center;
            color: #374151; font-size: 0.95rem; position: relative;
            transition: all 0.2s;
        }
        .nav-action:hover { border-color: var(--accent); color: var(--accent); background: #fff5f5; }
        .nav-badge {
            position: absolute; top: -4px; right: -4px;
            background: var(--accent); color: white; font-size: 0.6rem;
            font-weight: 700; width: 16px; height: 16px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
        }
        .btn-nav-signin {
            background: var(--brand); color: white; font-size: 0.875rem; font-weight: 600;
            padding: 9px 22px; border-radius: 50px; border: none;
            transition: all 0.2s;
        }
        .btn-nav-signin:hover { background: #2d2d4e; color: white; transform: translateY(-1px); }

        /* ─── HERO ──────────────────────────────────── */
        .hero {
            height: 100vh; min-height: 600px; max-height: 900px;
            position: relative; display: flex; align-items: center;
            overflow: hidden; margin-top: 0;
            padding-top: 72px;
        }
        /* Slideshow: each slide is stacked and cross-fades via opacity */
        .hero-slideshow { position: absolute; inset: 0; }
        .hero-bg-slide {
            position: absolute; inset: 0;
            background-size: cover; background-position: center 30%;
            opacity: 0;
            transition: opacity 1.2s ease-in-out;
        }
        .hero-bg-slide.active { opacity: 1; }
        .hero-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(105deg, rgba(26,26,46,0.90) 0%, rgba(26,26,46,0.65) 50%, rgba(26,26,46,0.25) 100%);
            z-index: 1;
        }
        .hero-content {
            position: relative; z-index: 2; max-width: 620px;
        }
        .hero-eyebrow {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2);
            color: #e5e7eb; font-size: 0.78rem; font-weight: 600;
            padding: 6px 16px; border-radius: 50px; margin-bottom: 20px;
            text-transform: uppercase; letter-spacing: 1px;
            backdrop-filter: blur(6px);
        }
        .hero-eyebrow span { width: 6px; height: 6px; border-radius: 50%; background: var(--gold); }
        .hero-title {
            font-family: var(--display); font-size: clamp(2.4rem, 5vw, 3.8rem);
            font-weight: 800; color: white; line-height: 1.1;
            letter-spacing: -1px; margin-bottom: 18px;
        }
        .hero-title em { font-style: normal; color: var(--accent-light); }
        .hero-subtitle {
            font-size: 1.05rem; color: rgba(255,255,255,0.78);
            line-height: 1.7; margin-bottom: 32px; max-width: 480px;
        }
        .btn-hero {
            background: var(--accent); color: white; font-size: 0.95rem; font-weight: 700;
            padding: 14px 34px; border-radius: 50px; border: none;
            display: inline-flex; align-items: center; gap: 10px;
            box-shadow: 0 8px 24px rgba(233,69,96,0.4);
            transition: all 0.02s;
        }
        .btn-hero:hover { background: #c73652; color: white; transform: translateY(-2px); box-shadow: 0 12px 28px rgba(233,69,96,0.5); }
        .btn-hero-ghost {
            background: transparent; color: white; font-size: 0.95rem; font-weight: 600;
            padding: 14px 28px; border-radius: 50px; border: 1.5px solid rgba(255,255,255,0.45);
            display: inline-flex; align-items: center; gap: 8px;
            transition: all 0.25s;
        }
        .btn-hero-ghost:hover { background: rgba(255,255,255,0.12); color: white; border-color: rgba(255,255,255,0.8); }
        .hero-stats {
            margin-top: 48px; padding-top: 32px;
            border-top: 1px solid rgba(255,255,255,0.15);
            display: flex; gap: 40px;
        }
        .hero-stat-num { font-family: var(--display); font-size: 1.75rem; font-weight: 800; color: white; }
        .hero-stat-label { font-size: 0.82rem; color: rgba(255,255,255,0.6); margin-top: 2px; }

        /* Slideshow dots */
        .hero-dots {
            position: absolute; z-index: 2; bottom: 28px; left: 50%; transform: translateX(-50%);
            display: flex; gap: 10px;
        }
        .hero-dot {
            width: 9px; height: 9px; border-radius: 50%;
            background: rgba(255,255,255,0.4); border: none; cursor: pointer;
            transition: all 0.02s;
        }
        .hero-dot.active { background: var(--accent); width: 24px; border-radius: 5px; }

        /* ─── TRUST BAR ─────────────────────────────── */
        .trust-bar { background: var(--white); border-bottom: 1px solid var(--border); padding: 18px 0; }
        .trust-item { display: flex; align-items: center; gap: 10px; }
        .trust-ico {
            width: 40px; height: 40px; border-radius: 10px;
            background: var(--surface); display: flex; align-items: center; justify-content: center;
            font-size: 1rem; color: var(--accent); flex-shrink: 0;
        }
        .trust-item h6 { font-size: 0.88rem; font-weight: 600; margin: 0; }
        .trust-item p { font-size: 0.76rem; color: var(--muted); margin: 0; }

        /* ─── SECTION COMMONS ───────────────────────── */
        section { padding: 80px 0; }
        .section-label { font-size: 0.75rem; font-weight: 700; color: var(--accent); text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 8px; }
        .section-title { font-family: var(--display); font-size: 2rem; font-weight: 800; color: var(--brand); margin: 0; }
        .btn-see-all {
            font-size: 0.875rem; font-weight: 600; color: var(--brand);
            border: 1.5px solid var(--border); padding: 9px 22px; border-radius: 50px;
            transition: all 0.2s;
        }
        .btn-see-all:hover { border-color: var(--accent); color: var(--accent); background: #fff5f5; }

        /* ─── CATEGORY PILLS ────────────────────────── */
        .cat-grid { display: grid; grid-template-columns: repeat(6, 1fr); gap: 16px; }
        .cat-card {
            background: var(--surface); border: 1.5px solid var(--border);
            border-radius: var(--radius-lg); padding: 24px 12px;
            text-align: center; cursor: pointer;
            transition: all 0.25s cubic-bezier(0.16,1,0.3,1);
        }
        .cat-card:hover { border-color: var(--accent); transform: translateY(-4px); box-shadow: var(--shadow-hover); background: white; }
        .cat-icon-wrap {
            width: 56px; height: 56px; border-radius: 50%; background: white;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 12px; font-size: 1.4rem; color: var(--accent);
            box-shadow: var(--shadow); transition: all 0.25s;
        }
        .cat-card:hover .cat-icon-wrap { background: var(--accent); color: white; }
        .cat-name { font-size: 0.875rem; font-weight: 600; color: var(--brand); }

        /* ─── PRODUCT CARDS ─────────────────────────── */
        .prod-card {
            background: white; border: 1px solid var(--border); border-radius: var(--radius);
            overflow: hidden; transition: all 0.25s cubic-bezier(0.16,1,0.3,1);
            display: flex; flex-direction: column; height: 100%;
        }
        .prod-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-hover); border-color: transparent; }
        .prod-img-wrap {
            aspect-ratio: 1/1; background: var(--surface);
            overflow: hidden; position: relative;
        }
        .prod-img-wrap img { width: 80%; height: 75%; object-fit: contain; margin: auto; position: absolute; inset: 0; transition: transform 0.4s ease; }
        .prod-card:hover .prod-img-wrap img { transform: scale(1.02); }
        .prod-badge {
            position: absolute; top: 12px; left: 12px;
            background: var(--accent); color: white; font-size: 0.65rem;
            font-weight: 800; padding: 3px 9px; border-radius: 6px; text-transform: uppercase;
        }
        .prod-badge.new { background: #10b981; }
        .prod-wish {
            position: absolute; top: 10px; right: 10px;
            width: 32px; height: 32px; border-radius: 50%;
            background: rgba(255,255,255,0.9); border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            color: #9ca3af; font-size: 0.85rem; cursor: pointer; transition: all 0.2s;
        }
        .prod-wish:hover { color: var(--accent); background: white; border-color: var(--accent); }
        .prod-body { padding: 16px; flex: 1; display: flex; flex-direction: column; }
        .prod-cat { font-size: 0.72rem; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px; }
        .prod-name {
            font-size: 0.95rem; font-weight: 600; color: var(--brand);
            margin-bottom: 8px; line-height: 1.4;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
            min-height: 2.8em;
        }
        .prod-stars { color: #f59e0b; font-size: 0.72rem; margin-bottom: 12px; }
        .prod-stars span { color: var(--muted); font-size: 0.7rem; margin-left: 4px; }
        .prod-price-row { display: flex; align-items: center; gap: 8px; margin-top: auto; margin-bottom: 14px; }
        .prod-price { font-family: var(--display); font-size: 1.15rem; font-weight: 700; color: var(--brand); }
        .btn-cart {
            width: 100%; padding: 10px; border-radius: 50px;
            border: 1.5px solid var(--border); background: var(--surface);
            font-size: 0.84rem; font-weight: 600; color: var(--brand);
            display: flex; align-items: center; justify-content: center; gap: 6px;
            cursor: pointer; transition: all 0.2s;
        }
        .btn-cart:hover { background: var(--accent); color: white; border-color: var(--accent); }

        /* ─── BANNER ────────────────────────────────── */
        .promo-banner {
            border-radius: var(--radius-lg); overflow: hidden;
            position: relative; min-height: 280px;
            display: flex; align-items: center;
        }
        .promo-bg {
            position: absolute; inset: 0;
            background-image: url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1600&q=85');
            background-size: cover; background-position: center;
        }
        .promo-overlay { position: absolute; inset: 0; background: linear-gradient(90deg, rgba(26,26,46,0.92) 0%, rgba(26,26,46,0.55) 60%, transparent 100%); }
        .promo-content { position: relative; z-index: 2; padding: 48px; max-width: 480px; }
        .promo-tag { font-size: 0.75rem; font-weight: 700; color: var(--gold); text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 10px; }
        .promo-title { font-family: var(--display); font-size: 1.9rem; font-weight: 800; color: white; margin-bottom: 10px; line-height: 1.2; }
        .promo-sub { font-size: 0.93rem; color: rgba(255,255,255,0.75); margin-bottom: 24px; }
        .btn-promo {
            background: white; color: var(--brand); font-size: 0.875rem; font-weight: 700;
            padding: 12px 28px; border-radius: 50px; border: none; display: inline-flex; align-items: center; gap: 8px;
            transition: all 0.2s;
        }
        .btn-promo:hover { background: var(--accent); color: white; transform: translateY(-2px); }
        .countdown-row { display: flex; gap: 12px; margin-bottom: 24px; }
        .cd-box { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 10px; padding: 10px 12px; text-align: center; min-width: 58px; }
        .cd-num { font-family: var(--display); font-size: 1.4rem; font-weight: 800; color: var(--gold); }
        .cd-lbl { font-size: 0.6rem; text-transform: uppercase; color: rgba(255,255,255,0.65); font-weight: 600; margin-top: 2px; }

        /* ─── SELLER CTA ────────────────────────────── */
        .seller-cta { background: var(--brand); border-radius: var(--radius-lg); padding: 56px 48px; }
        .seller-cta h2 { font-family: var(--display); font-size: 2rem; font-weight: 800; color: white; margin-bottom: 12px; }
        .seller-cta p { color: rgba(255,255,255,0.65); font-size: 1rem; max-width: 520px; margin-bottom: 28px; }
        .btn-seller { background: var(--accent); color: white; font-weight: 700; padding: 13px 32px; border-radius: 50px; border: none; font-size: 0.95rem; transition: all 0.2s; }
        .btn-seller:hover { background: #c73652; color: white; transform: translateY(-2px); }
        .btn-seller-outline { background: transparent; color: rgba(255,255,255,0.8); border: 1.5px solid rgba(255,255,255,0.3); font-weight: 600; padding: 13px 28px; border-radius: 50px; font-size: 0.9rem; transition: all 0.2s; }
        .btn-seller-outline:hover { border-color: white; color: white; }
        .seller-pill { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); border-radius: 12px; padding: 18px 20px; text-align: center; }
        .seller-pill-num { font-family: var(--display); font-size: 1.6rem; font-weight: 800; color: var(--gold); }
        .seller-pill-lbl { font-size: 0.78rem; color: rgba(255,255,255,0.55); margin-top: 3px; }

        /* ─── FOOTER ────────────────────────────────── */
        .site-footer { background: #111827; padding: 60px 0 28px; }
        .footer-logo { font-family: var(--display); font-size: 1.4rem; font-weight: 800; color: white; }
        .footer-logo span { color: var(--accent); }
        .footer-tagline { font-size: 0.85rem; color: #6b7280; margin-top: 8px; margin-bottom: 20px; max-width: 240px; }
        .footer-social { width: 34px; height: 34px; border-radius: 8px; background: #1f2937; color: #9ca3af; display: inline-flex; align-items: center; justify-content: center; font-size: 0.85rem; margin-right: 6px; transition: all 0.2s; }
        .footer-social:hover { background: var(--accent); color: white; }
        .footer-heading { color: white; font-size: 0.88rem; font-weight: 700; margin-bottom: 16px; }
        .footer-link { display: block; color: #6b7280; font-size: 0.84rem; margin-bottom: 9px; transition: color 0.2s; }
        .footer-link:hover { color: white; }
        .footer-news-input { background: #1f2937; border: 1px solid #374151; color: white; border-radius: 50px; padding: 10px 18px; font-size: 0.84rem; width: 100%; outline: none; transition: border 0.2s; }
        .footer-news-input:focus { border-color: var(--accent); }
        .btn-footer-sub { background: var(--accent); color: white; border: none; padding: 10px 20px; border-radius: 50px; font-size: 0.84rem; font-weight: 600; transition: background 0.2s; }
        .btn-footer-sub:hover { background: #c73652; }
        .footer-divider { border-color: #1f2937; margin: 32px 0 18px; }
        .footer-bottom { color: #4b5563; font-size: 0.8rem; }
        .payment-lbl { background: #1f2937; color: #9ca3af; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; margin-right: 6px; }

        /* ─── TOAST ─────────────────────────────────── */
        .toast-area { position: fixed; top: 80px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; pointer-events: none; width: 320px; }
        .toast-item { background: white; border-radius: var(--radius); padding: 14px 16px; box-shadow: 0 8px 30px rgba(0,0,0,0.14); border-left: 3px solid #10b981; display: flex; align-items: flex-start; gap: 10px; pointer-events: all; animation: toastIn 0.3s ease; }
        .toast-item.err { border-left-color: var(--accent); }
        .toast-item.warn { border-left-color: var(--gold); }
        .toast-ico { font-size: 1rem; flex-shrink: 0; color: #10b981; }
        .toast-item.err .toast-ico { color: var(--accent); }
        .toast-item.warn .toast-ico { color: var(--gold); }
        .toast-title { font-size: 0.85rem; font-weight: 700; color: var(--brand); margin: 0; }
        .toast-msg { font-size: 0.78rem; color: var(--muted); margin: 2px 0 0; }
        .toast-close { background: none; border: none; color: #9ca3af; cursor: pointer; margin-left: auto; font-size: 0.9rem; padding: 0; }
        @keyframes toastIn { from { transform: translateX(40px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        .toast-item.out { opacity: 0; transform: translateX(40px); transition: all 0.3s; }

        @media(max-width:991px) {
            .cat-grid { grid-template-columns: repeat(3,1fr); }
            .hero-title { font-size: 2.4rem; }
            .hero-stats { gap: 24px; }
            .promo-banner { min-height: 220px; }
            .promo-content { padding: 30px 24px; }
            .seller-cta { padding: 36px 24px; }
        }
        @media(max-width:576px) {
            .cat-grid { grid-template-columns: repeat(2,1fr); }
            section { padding: 56px 0; }
        }
    </style>
</head>
<body>

<div class="toast-area" id="toastArea"></div>

<!-- NAVBAR -->
<nav class="site-nav" id="siteNav">
    <div class="container">
        <div class="d-flex align-items-center gap-4">
            <a href="/" class="nav-logo">Shop<span>Ease</span></a>

            <ul class="navbar-nav flex-row gap-1 d-none d-lg-flex ms-2">
                <li><a href="/" class="nav-link-item">Home</a></li>
                <li><a href="/products" class="nav-link-item">Shop</a></li>
                <li><a href="/store/apply" class="nav-link-item">Sell With Us</a></li>
                <li><a href="/contact" class="nav-link-item">Contact</a></li>
            </ul>

            <div class="ms-auto d-flex align-items-center gap-2">
                <div class="search-wrap d-none d-md-block">
                    <i class="fas fa-search search-ico"></i>
                    <form action="/search" method="GET"><input type="search" name="q" class="nav-search" placeholder="Search products..."></form>
                </div>

                <a href="/wishlist" class="nav-action"><i class="far fa-heart"></i></a>

                <a href="/cart" class="nav-action">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="nav-badge" id="cartBadge"><?php echo session()->get("cart_count") ?? 0; ?></span>
                </a>

                <?php if(isset($is_logged_in) && $is_logged_in): ?>
                <div class="dropdown">
                    <button class="btn-nav-signin dropdown-toggle" data-bs-toggle="dropdown">
                        <?php echo esc(session()->get("first_name") ?? session()->get("full_name") ?? "Account"); ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="border-radius:12px; min-width:200px;">
                        <?php if(($user_role??"")==="super_admin"): ?>
                        <li><a class="dropdown-item py-2" href="/admin/dashboard"><i class="fas fa-crown text-warning me-2"></i>Admin Panel</a></li>
                        <?php elseif(($user_role??"")==="store_owner"): ?>
                        <li><a class="dropdown-item py-2" href="/store/dashboard"><i class="fas fa-store text-success me-2"></i>Store Dashboard</a></li>
                        <?php else: ?>
                        <li><a class="dropdown-item py-2" href="/dashboard"><i class="fas fa-gauge me-2 text-primary"></i>My Dashboard</a></li>
                        <li><a class="dropdown-item py-2" href="/orders"><i class="fas fa-box me-2 text-muted"></i>My Orders</a></li>
                        <?php endif; ?>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger py-2" href="/logout"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
                <?php else: ?>
                <a href="/login" class="btn-nav-signin">Sign In</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <!-- Slideshow: lady -> man -> children, auto-rotates, dots are clickable -->
    <div class="hero-slideshow" id="heroSlideshow">
        <<div
  class="hero-bg-slide active"
  style="background-image: url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1600&q=85');">
</div>

<div
  class="hero-bg-slide"
  style="background-image: url('https://images.unsplash.com/photo-1483985988355-763728e1935b?w=1800&q=90');">
</div>

<div
  class="hero-bg-slide"
  style="background-image: url(https://images.unsplash.com/photo-1593412578702-3332c86f3db3?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fG1hbiUyMHNob3BwaW5nfGVufDB8fDB8fHww);">
</div>


    </div>
    <div class="hero-overlay"></div>
    <div class="container position-relative z-2">
        <div class="hero-content">
            <div class="hero-eyebrow"><span></span> New Season, New Arrivals</div>
            <h1 class="hero-title">
                Discover <em>Premium</em><br>Products Near You
            </h1>
            <p class="hero-subtitle">
                Shop from thousands of curated items across verified local stores. Fast delivery, escrow-secured payments, and hassle-free returns.
            </p>
            <div class="d-flex flex-wrap gap-3">
                <a href="/products" class="btn-hero">
                    Browse Collection <i class="fas fa-arrow-right"></i>
                </a>
        
                
            </div>
            <div class="hero-stats">
                <div>
                    <div class="hero-stat-num"><?php echo (isset($totalProducts) && $totalProducts > 0) ? number_format($totalProducts) . "+" : "5,000+"; ?></div>
                    <div class="hero-stat-label">Products Listed</div>
                </div>
                <div>
                    <div class="hero-stat-num"><?php echo isset($totalStores) ? $totalStores . "+" : "200+"; ?></div>
                    <div class="hero-stat-label">Verified Stores</div>
                </div>
                <div>
                    <div class="hero-stat-num">50K+</div>
                    <div class="hero-stat-label">Happy Customers</div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-dots" id="heroDots">
        <button class="hero-dot active" data-slide="0" aria-label="Slide 1"></button>
        <button class="hero-dot" data-slide="1" aria-label="Slide 2"></button>
        <button class="hero-dot" data-slide="2" aria-label="Slide 3"></button>
    </div>
</section>

<!-- TRUST BAR -->
<div class="trust-bar">
    <div class="container">
        <div class="row g-3">
            <div class="col-lg-3 col-sm-6">
                <div class="trust-item">
                    <div class="trust-ico"><i class="fas fa-truck-fast"></i></div>
                    <div><h6>Fast Delivery</h6><p> On orders </p></div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="trust-item">
                    <div class="trust-ico" style="color:#10b981;"><i class="fas fa-shield-halved"></i></div>
                    <div><h6>Escrow Protected</h6><p>Pay only on delivery</p></div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="trust-item">
                    <div class="trust-ico" style="color:#6366f1;"><i class="fas fa-rotate-left"></i></div>
                    <div><h6>30-Day Returns</h6><p>Easy and hassle-free</p></div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="trust-item">
                    <div class="trust-ico" style="color:#f59e0b;"><i class="fas fa-headset"></i></div>
                    <div><h6>24/7 Support</h6><p>Always here to help</p></div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- FEATURED PRODUCTS -->
<section>
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <p class="section-label">Hand-picked for You</p>
                <h2 class="section-title">Featured Products</h2>
            </div>
            <a href="/products" class="btn-see-all">See All <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="row g-4">
            <?php if(!empty($featuredProducts)): ?>
                <?php foreach($featuredProducts as $p): ?>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="prod-card">
                        <div class="prod-img-wrap">
                            <?php if(!empty($p["discount"]) && $p["discount"] > 0): ?>
                            <span class="prod-badge">-<?php echo $p["discount"]; ?>%</span>
                            <?php else: ?>
                            <span class="prod-badge new">New</span>
                            <?php endif; ?>
                            <button class="prod-wish" onclick="toggleWish(this)"><i class="far fa-heart"></i></button>
                            <a href="/product/<?php echo esc($p["slug"]); ?>">
                                <img src="<?php echo esc($p["image"]); ?>" alt="<?php echo esc($p["name"]); ?>">
                            </a>
                        </div>
                        <div class="prod-body">
                            <div class="prod-cat"><?php echo esc($p["category"]); ?></div>
                            <a href="/product/<?php echo esc($p["slug"]); ?>" class="prod-name text-decoration-none"><?php echo esc($p["name"]); ?></a>
                            <div class="prod-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i>
                                <span>(4.8)</span>
                            </div>
                            <div class="prod-price-row">
                                <span class="prod-price"><?php echo number_format($p["price"],2); ?> ETB</span>
                                <?php if(!empty($p["old_price"])): ?><?php endif; ?>
                            </div>
                            <button class="btn-cart add-to-cart-btn" data-product-id="<?php echo $p["id"]; ?>" data-product-name="<?php echo esc($p["name"]); ?>" data-product-price="<?php echo $p["price"]; ?>">
                                <i class="fas fa-bag-shopping"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h5>No featured products yet</h5>
                <p class="text-muted mb-4">Products added by verified sellers will appear here.</p>
                <a href="/products" class="btn-see-all">Browse All Products</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- FLASH SALE BANNER -->
<section style="padding: 0 0 80px;">
    <div class="container">
        <div class="promo-banner">
            <div class="promo-bg"></div>
            <div class="promo-overlay"></div>
            <div class="promo-content">
                <p class="promo-tag"><i class="fas fa-bolt me-1"></i> Limited Time Deal</p>
                <h2 class="promo-title">Save Up to 40% Off on Top Picks</h2>
                <p class="promo-sub">Exclusive flash sale — ends in:</p>
                <div class="countdown-row">
                    <div class="cd-box"><div class="cd-num" id="cdH">08</div><div class="cd-lbl">Hours</div></div>
                    <div class="cd-box"><div class="cd-num" id="cdM">45</div><div class="cd-lbl">Mins</div></div>
                    <div class="cd-box"><div class="cd-num" id="cdS">00</div><div class="cd-lbl">Secs</div></div>
                </div>
                <a href="/products" class="btn-promo">Shop the Sale <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- SELLER CTA -->
<section style="padding: 0 0 80px;">
    <div class="container">
        <div class="seller-cta">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <span class="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill mb-3 fs-7">Seller Hub</span>
                    <h2>Start Selling on ShopEase Today</h2>
                    <p>Join over 200 entrepreneurs reaching thousands of customers. Zero setup fees, real-time analytics, and guaranteed escrow payouts.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="/store/apply" class="btn-seller">Open Your Store <i class="fas fa-arrow-right ms-1"></i></a>
                    
                    </div>
                </div>
                <div class="col-lg-4 d-none d-lg-block">
                    <div class="row g-3">
                        <div class="col-6"><div class="seller-pill"><div class="seller-pill-num">100+</div><div class="seller-pill-lbl">Active Stores</div></div></div>
                        <div class="col-6"><div class="seller-pill"><div class="seller-pill-num">2%</div><div class="seller-pill-lbl">Setup Fee</div></div></div>
                        <div class="col-6"><div class="seller-pill"><div class="seller-pill-num">24h</div><div class="seller-pill-lbl">Payout Speed</div></div></div>
                        <div class="col-6"><div class="seller-pill"><div class="seller-pill-num">99%</div><div class="seller-pill-lbl">Satisfaction</div></div></div>
                    </div>
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
                <p class="footer-tagline">Your trusted multi-vendor marketplace for quality products and secure shopping.</p>
                <div>
                    <a href="#" class="footer-social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="footer-social"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="footer-social"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="footer-social"><i class="fab fa-telegram"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="footer-heading">Shop</h6>
                <a href="/products" class="footer-link">All Products</a>
                <a href="/store/apply" class="footer-link">Sell With Us</a>
                <a href="/track" class="footer-link">Track Order</a>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="footer-heading">Company</h6>
                <a href="/about" class="footer-link">About Us</a>
                <a href="/contact" class="footer-link">Contact</a>
                <a href="/privacy" class="footer-link">Privacy Policy</a>
                <a href="/terms" class="footer-link">Terms</a>
            </div>
            <div class="col-lg-4 col-md-6">
                <h6 class="footer-heading">Stay Updated</h6>
                <p class="footer-link mb-3">Get notified about deals and new arrivals.</p>
                <form onsubmit="subNewsletter(event)" class="d-flex gap-2">
                    <input type="email" id="newsEmail" class="footer-news-input" placeholder="Your email address" required>
                    <button type="submit" class="btn-footer-sub">Join</button>
                </form>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <p class="footer-bottom mb-0">&copy; 2026 ShopEase. All rights reserved.</p>
            <div>
                <span class="payment-lbl">Telebirr</span>
                <span class="payment-lbl">CBE Bank</span>
                <span class="payment-lbl">Chapa</span>
                <span class="payment-lbl">Cash on Delivery</span>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Session flash messages
<?php if(session()->getFlashdata("success")): ?>
toast("success","<?php echo esc(session()->getFlashdata("success")); ?>");
<?php endif; ?>
<?php if(session()->getFlashdata("error")): ?>
toast("err","<?php echo esc(session()->getFlashdata("error")); ?>");
<?php endif; ?>

// Navbar scroll
window.addEventListener("scroll",()=>{
    document.getElementById("siteNav").classList.toggle("scrolled", window.scrollY > 40);
});

// Add to cart
document.querySelectorAll(".add-to-cart-btn").forEach(btn => {
    btn.addEventListener("click", function() {
        const id = this.dataset.productId, name = this.dataset.productName, price = this.dataset.productPrice;
        const orig = this.innerHTML;
        this.innerHTML = "<i class='fas fa-spinner fa-spin'></i> Adding...";
        this.disabled = true;
        fetch("/cart/add", {
            method:"POST",
            headers:{"Content-Type":"application/x-www-form-urlencoded","X-Requested-With":"XMLHttpRequest"},
            body:"product_id="+encodeURIComponent(id)+"&quantity=1"
        }).then(r=>r.json()).then(data=>{
            this.innerHTML = orig; this.disabled = false;
            if(data.success){
                toast("success", name + " added to cart! ($"+parseFloat(price).toFixed(2)+")");
                const b = document.getElementById("cartBadge");
                if(b) b.textContent = data.cart_count;
            } else {
                if(data.redirect) window.location.href = data.redirect;
                else toast("err", data.message || "Could not add to cart.");
            }
        }).catch(()=>{ this.innerHTML=orig; this.disabled=false; toast("err","Connection error."); });
    });
});

// Countdown
let h=8,m=45,s=0;
setInterval(()=>{
    if(s>0) s--; else { s=59; if(m>0) m--; else { m=59; if(h>0) h--; } }
    document.getElementById("cdH").textContent = String(h).padStart(2,"0");
    document.getElementById("cdM").textContent = String(m).padStart(2,"0");
    document.getElementById("cdS").textContent = String(s).padStart(2,"0");
},1000);

// Toast
function toast(type, msg) {
    const area = document.getElementById("toastArea");
    const icons = {success:"fa-circle-check", err:"fa-circle-xmark", warn:"fa-triangle-exclamation"};
    const labels = {success:"Added", err:"Notice", warn:"Warning"};
    const el = document.createElement("div");
    el.className = "toast-item " + (type !== "success" ? type : "");
    el.innerHTML = `<i class="fas ${icons[type]||icons.success} toast-ico"></i><div><p class="toast-title">${labels[type]||"Info"}</p><p class="toast-msg">${msg}</p></div><button class="toast-close" onclick="this.closest('.toast-item').remove()">&#x2715;</button>`;
    area.appendChild(el);
    setTimeout(()=>{ el.classList.add("out"); setTimeout(()=>el.remove(), 300); }, 4500);
}

// Wishlist toggle
function toggleWish(btn) {
    const i = btn.querySelector("i");
    const active = i.classList.contains("fas");
    i.className = active ? "far fa-heart" : "fas fa-heart";
    i.style.color = active ? "" : "var(--accent)";
    toast(active?"warn":"success", active?"Removed from wishlist":"Saved to wishlist");
}

// Newsletter
function subNewsletter(e) {
    e.preventDefault();
    toast("success","Subscribed! You will receive our latest deals.");
    document.getElementById("newsEmail").value = "";
}

// Hero slideshow: lady -> man -> children, auto-rotate every 5s, dots clickable, pauses on hover
(function() {
    const slides = document.querySelectorAll("#heroSlideshow .hero-bg-slide");
    const dots = document.querySelectorAll("#heroDots .hero-dot");
    const heroSection = document.querySelector(".hero");
    let current = 0;
    let timer = null;

    function goTo(index) {
        slides[current].classList.remove("active");
        dots[current].classList.remove("active");
        current = index;
        slides[current].classList.add("active");
        dots[current].classList.add("active");
    }

    function next() {
        goTo((current + 1) % slides.length);
    }

    function startAutoplay() {
        timer = setInterval(next, 5000);
    }

    function stopAutoplay() {
        clearInterval(timer);
    }

    dots.forEach((dot, i) => {
        dot.addEventListener("click", () => {
            stopAutoplay();
            goTo(i);
            startAutoplay();
        });
    });

    if (heroSection) {
        heroSection.addEventListener("mouseenter", stopAutoplay);
        heroSection.addEventListener("mouseleave", startAutoplay);
    }

    startAutoplay();
})();
</script>
</body>
</html>