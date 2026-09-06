<!-- app/Views/public/contact.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - ShopEase</title>
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
            padding: 6px 14px; border-radius: 8px;
            transition: all 0.2s; position: relative;
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

        /* ─── CONTACT INFO ───────────────────────────── */
        .contact-info-box {
            background: var(--white); border-radius: var(--radius-lg); padding: 28px;
            border: 1px solid var(--border); text-align: center; height: 100%; transition: all 0.25s;
        }
        .contact-info-box:hover { transform: translateY(-5px); box-shadow: var(--shadow-hover); border-color: transparent; }
        .contact-info-box i { font-size: 2.3rem; color: var(--accent); margin-bottom: 15px; }
        .contact-info-box h6 { font-family: var(--display); color: var(--brand); font-weight: 700; }
        .contact-info-box p { color: var(--muted); margin-bottom: 0; }

        /* ─── CONTACT FORM ───────────────────────────── */
        .contact-form { background: var(--white); border-radius: var(--radius-lg); padding: 34px; border: 1px solid var(--border); box-shadow: var(--shadow); }
        .contact-form h5 { font-family: var(--display); color: var(--brand); font-weight: 800; }
        .contact-form label { font-weight: 600; color: var(--brand); font-size: 0.88rem; margin-bottom: 6px; display: inline-block; }
        .contact-form .form-control { border-radius: 10px; border: 1.5px solid var(--border); padding: 10px 14px; }
        .contact-form .form-control:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(233,69,96,0.1); }
        .btn-send {
            background: var(--accent); color: #fff; border: none; border-radius: 50px;
            padding: 12px 40px; font-weight: 700; transition: all 0.2s;
            box-shadow: 0 8px 24px rgba(233,69,96,0.3);
        }
        .btn-send:hover { background: #c73652; color: #fff; transform: translateY(-2px); }

        /* ─── FOOTER (matches homepage) ─────────────── */
        .site-footer { background: #111827; padding: 60px 0 28px; margin-top: 40px; }
        .footer-logo { font-family: var(--display); font-size: 1.4rem; font-weight: 800; color: white; }
        .footer-logo span { color: var(--accent); }
        .footer-tagline { font-size: 0.85rem; color: #6b7280; margin-top: 8px; margin-bottom: 20px; max-width: 260px; }
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
                <li><a class="nav-link-item <?= (current_url() == base_url('/') || current_url() == base_url()) ? 'active' : '' ?>" href="/">Home</a></li>
                <li><a class="nav-link-item <?= strpos(current_url(), 'products') !== false ? 'active' : '' ?>" href="/products">Products</a></li>
                <li><a class="nav-link-item <?= strpos(current_url(), 'contact') !== false ? 'active' : '' ?>" href="/contact">Contact</a></li>
            </ul>

            <div class="ms-auto d-flex align-items-center gap-2">
                <div class="search-wrap d-none d-md-block">
                    <i class="fas fa-search search-ico"></i>
                    <input type="search" class="nav-search" placeholder="Search for products...">
                </div>
                <button class="nav-action" onclick="toggleWishlist(this)"><i class="far fa-heart"></i></button>
                <a href="/cart" class="nav-action"><i class="fas fa-shopping-cart"></i></a>
                <a href="/login" class="nav-action"><i class="far fa-user"></i></a>
            </div>
        </div>
    </div>
</nav>

<!-- PAGE HEADER -->
<section class="page-header">
    <div class="container">
        <h2><i class="fas fa-envelope me-2"></i>Contact Us</h2>
        <nav class="breadcrumb">
            <a href="/">Home</a>
            <span>/</span>
            <span class="active">Contact</span>
        </nav>
    </div>
</section>

<!-- CONTACT SECTION -->
<section class="py-4">
    <div class="container">
        <!-- Contact Info -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="contact-info-box">
                    <i class="fas fa-map-marker-alt"></i>
                    <h6>Visit Us</h6>
                    <p>123 Main Street, New York, NY 10001</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="contact-info-box">
                    <i class="fas fa-phone-alt"></i>
                    <h6>Call Us</h6>
                    <p>+1 (555) 123-4567</p>
                    <p class="small text-muted">Mon-Fri 9am-6pm</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="contact-info-box">
                    <i class="fas fa-envelope"></i>
                    <h6>Email Us</h6>
                    <p>support@shopease.com</p>
                    <p class="small text-muted">We reply within 24 hours</p>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="contact-form">
                    <h5 class="mb-3">Send Us a Message</h5>
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="John Doe" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" placeholder="john@example.com" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Subject <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Order inquiry, support, etc." required>
                        </div>
                        <div class="mb-3">
                            <label>Message <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="5" placeholder="Your message here..." required></textarea>
                        </div>
                        <button type="submit" class="btn-send"><i class="fas fa-paper-plane me-2"></i>Send Message</button>
                    </form>
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
                <p class="footer-tagline">Your one-stop shop for everything you need. Quality products, unbeatable prices.</p>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="footer-heading">Quick Links</h6>
                <a href="#" class="footer-link">About Us</a>
                <a href="#" class="footer-link">Contact</a>
                <a href="#" class="footer-link">Privacy Policy</a>
            </div>
            <div class="col-lg-3 col-6">
                <h6 class="footer-heading">Customer Service</h6>
                <a href="#" class="footer-link">Help Center</a>
                <a href="#" class="footer-link">Returns</a>
                <a href="#" class="footer-link">Shipping Info</a>
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
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        document.getElementById('siteNav').classList.toggle('scrolled', window.scrollY > 40);
    });

    // Wishlist toggle function
    function toggleWishlist(button) {
        var icon = button.querySelector('i');

        if (icon.classList.contains('far')) {
            icon.classList.remove('far');
            icon.classList.add('fas');
            icon.style.color = '#e94560';
            button.classList.add('wishlist-active');

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
            background: #1a1a2e;
            color: #fff;
            padding: 15px 25px;
            border-radius: 12px;
            z-index: 9999;
            box-shadow: 0 5px 25px rgba(0,0,0,0.3);
            font-size: 1rem;
            font-weight: 500;
            animation: slideIn 0.3s ease;
            border-left: 4px solid #e94560;
        `;
        document.body.appendChild(notification);

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
            color: #e94560 !important;
        }
    `;
    document.head.appendChild(style);
</script>
</body>
</html>