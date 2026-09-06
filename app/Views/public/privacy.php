<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy &mdash; ShopEase</title>
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
        body { font-family: var(--font); color: var(--text); background: var(--white); overflow-x: hidden; padding-top: 82px; }
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
        .nav-link-item:hover, .nav-link-item.active { color: var(--accent); background: #fff5f5; }
        .nav-search {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 50px; padding: 9px 18px 9px 40px;
            font-size: 0.875rem; width: 240px; outline: none;
            transition: all 0.2s;
        }
        .nav-search:focus { border-color: var(--accent); background: var(--white); box-shadow: 0 0 0 3px rgba(233,69,96,0.1); }
        .search-wrap { position: relative; }
        .search-ico { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 0.82rem; }
        .nav-action {
            width: 38px; height: 38px; border-radius: 50%;
            border: 1px solid var(--border); background: var(--surface);
            display: flex; align-items: center; justify-content: center;
            color: #374151; font-size: 0.95rem;
            transition: all 0.2s;
        }
        .nav-action:hover { border-color: var(--accent); color: var(--accent); background: #fff5f5; }
        .btn-nav-signin {
            background: var(--brand); color: white; font-size: 0.875rem; font-weight: 600;
            padding: 9px 22px; border-radius: 50px; border: none;
            transition: all 0.2s;
        }
        .btn-nav-signin:hover { background: #2d2d4e; color: white; transform: translateY(-1px); }

        /* ─── PAGE HEADER ───────────────────────────── */
        .page-header { background: var(--brand); padding: 44px 0 34px; }
        .page-eyebrow {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.18);
            color: #e5e7eb; font-size: 0.75rem; font-weight: 600;
            padding: 5px 14px; border-radius: 50px; margin-bottom: 14px;
        }
        .page-eyebrow span { width: 6px; height: 6px; border-radius: 50%; background: var(--gold); }
        .page-title { font-family: var(--display); font-size: 2rem; font-weight: 800; color: white; margin-bottom: 8px; }
        .page-crumb a { color: rgba(255,255,255,0.6); font-size: 0.85rem; transition: color 0.2s; }
        .page-crumb a:hover { color: var(--accent-light); }
        .page-crumb .sep { color: rgba(255,255,255,0.3); margin: 0 8px; }
        .page-crumb .active { color: rgba(255,255,255,0.9); font-size: 0.85rem; font-weight: 500; }

        /* ─── CONTENT ───────────────────────────────── */
        .content-section { padding: 64px 0; }
        .content-card { background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 40px; box-shadow: var(--shadow); }
        .content-card h4 { font-family: var(--display); color: var(--brand); font-weight: 800; font-size: 1.35rem; margin-bottom: 14px; }
        .content-card h5 { font-family: var(--display); color: var(--brand); font-weight: 700; font-size: 1.05rem; }
        .content-card p { color: var(--muted); line-height: 1.8; }
        .content-card ul { color: var(--muted); line-height: 2; padding-left: 20px; }
        .content-card ul li::marker { color: var(--accent); }
        .updated-pill {
            display: inline-block; background: var(--surface); border: 1px solid var(--border);
            border-radius: 50px; padding: 8px 18px; font-size: 0.85rem; color: var(--brand); font-weight: 600;
        }

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
        .toast-ico { font-size: 1rem; flex-shrink: 0; color: #10b981; }
        .toast-item.err .toast-ico { color: var(--accent); }
        .toast-title { font-size: 0.85rem; font-weight: 700; color: var(--brand); margin: 0; }
        .toast-msg { font-size: 0.78rem; color: var(--muted); margin: 2px 0 0; }
        .toast-close { background: none; border: none; color: #9ca3af; cursor: pointer; margin-left: auto; font-size: 0.9rem; padding: 0; }
        @keyframes toastIn { from { transform: translateX(40px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        .toast-item.out { opacity: 0; transform: translateX(40px); transition: all 0.3s; }

        @media(max-width:576px) {
            .content-card { padding: 26px 20px; }
            .page-title { font-size: 1.6rem; }
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
                <a href="/cart" class="nav-action"><i class="fas fa-shopping-bag"></i></a>
                <a href="/login" class="btn-nav-signin">Sign In</a>
            </div>
        </div>
    </div>
</nav>

<!-- PAGE HEADER -->
<section class="page-header">
    <div class="container">
        <div class="page-eyebrow"><span></span> Legal</div>
        <h2 class="page-title">Privacy Policy</h2>
        <nav class="page-crumb">
            <a href="/">Home</a>
            <span class="sep">/</span>
            <span class="active">Privacy Policy</span>
        </nav>
    </div>
</section>

<!-- CONTENT -->
<section class="content-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="content-card">
                    <h4>Our Privacy Policy</h4>
                    <p>At ShopEase, we take your privacy seriously. This policy explains how we collect, use, and protect your personal information.</p>

                    <h5 class="mt-4 mb-2">Information We Collect</h5>
                    <ul>
                        <li>Name and contact information</li>
                        <li>Email address</li>
                        <li>Shipping and billing addresses</li>
                        <li>Payment information</li>
                        <li>Order history</li>
                    </ul>

                    <h5 class="mt-4 mb-2">How We Use Your Information</h5>
                    <ul>
                        <li>Process your orders and payments</li>
                        <li>Send order confirmations and updates</li>
                        <li>Provide customer support</li>
                        <li>Send promotional offers (with your consent)</li>
                        <li>Improve our services</li>
                    </ul>

                    <h5 class="mt-4 mb-2">Data Protection</h5>
                    <p>We implement security measures to protect your personal information. We never share your data with third parties without your consent.</p>

                    <h5 class="mt-4 mb-2">Your Rights</h5>
                    <ul>
                        <li>Access your personal data</li>
                        <li>Request corrections</li>
                        <li>Request deletion</li>
                        <li>Opt-out of marketing communications</li>
                    </ul>

                    <div class="mt-4">
                        <span class="updated-pill"><i class="far fa-clock me-2"></i>Last Updated: August 2026</span>
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
// Navbar scroll
window.addEventListener("scroll",()=>{
    document.getElementById("siteNav").classList.toggle("scrolled", window.scrollY > 40);
});

// Toast
function toast(type, msg) {
    const area = document.getElementById("toastArea");
    const icons = {success:"fa-circle-check", err:"fa-circle-xmark"};
    const labels = {success:"Success", err:"Notice"};
    const el = document.createElement("div");
    el.className = "toast-item " + (type !== "success" ? type : "");
    el.innerHTML = `<i class="fas ${icons[type]||icons.success} toast-ico"></i><div><p class="toast-title">${labels[type]||"Info"}</p><p class="toast-msg">${msg}</p></div><button class="toast-close" onclick="this.closest('.toast-item').remove()">&#x2715;</button>`;
    area.appendChild(el);
    setTimeout(()=>{ el.classList.add("out"); setTimeout(()=>el.remove(), 300); }, 4500);
}

// Newsletter
function subNewsletter(e) {
    e.preventDefault();
    toast("success","Subscribed! You will receive our latest deals.");
    document.getElementById("newsEmail").value = "";
}
</script>
</body>
</html>