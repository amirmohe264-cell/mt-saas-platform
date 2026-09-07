<!-- app/Views/public/store_apply.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Your Store - ShopEase</title>
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
            --muted: #6b7280;
            --border: #e5e7eb;
            --surface: #f9fafb;
            --white: #ffffff;
            --radius: 12px;
            --radius-lg: 20px;
            --shadow: 0 4px 20px rgba(0,0,0,0.08);
            --font: 'Inter', sans-serif;
            --display: 'Sora', sans-serif;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font); color: #1a1a2e; background: var(--surface); padding-top: 92px; }
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

        /* ─── FORM CARD ──────────────────────────────── */
        .form-card {
            background: var(--white); border-radius: var(--radius-lg); padding: 40px;
            border: 1px solid var(--border); box-shadow: var(--shadow);
            max-width: 700px; margin: 0 auto;
        }
        .form-card label { font-weight: 600; color: var(--brand); font-size: 0.88rem; }
        .form-card .form-control { border-radius: 10px; border: 1.5px solid var(--border); padding: 10px 15px; transition: 0.2s; }
        .form-card .form-control:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(233,69,96,0.1); }
        .form-card .form-control.is-invalid { border-color: var(--accent); }
        .required { color: var(--accent); }

        .btn-submit {
            background: var(--accent); color: #fff; border: none; border-radius: 50px;
            padding: 12px 40px; font-weight: 700; transition: 0.2s;
            box-shadow: 0 8px 24px rgba(233,69,96,0.3);
        }
        .btn-submit:hover { background: #c73652; color: #fff; transform: translateY(-2px); }
        .btn-back {
            background: var(--surface); color: var(--brand); border: 1.5px solid var(--border);
            border-radius: 50px; padding: 12px 40px; font-weight: 600; transition: 0.2s;
            text-decoration: none; display: inline-block;
        }
        .btn-back:hover { background: var(--white); border-color: var(--brand); color: var(--brand); }

        .info-box { background: #fff5f5; border-left: 4px solid var(--accent); padding: 15px 20px; border-radius: var(--radius); }
        .info-box i { color: var(--accent); font-size: 1.2rem; }

        .alert-danger { background: #fff5f5; border: 1px solid #ffd6dc; color: #b3273f; border-radius: var(--radius); }

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
                <li><a href="/" class="nav-link-item">Home</a></li>
                <li><a href="/products" class="nav-link-item">Products</a></li>
                <li><a href="#" class="nav-link-item active">Open Your Store</a></li>
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
        <h2><i class="fas fa-store me-2"></i>Open Your Store</h2>
        <nav class="breadcrumb">
            <a href="/">Home</a>
            <span>/</span>
            <span class="active">Open Your Store</span>
        </nav>
    </div>
</section>

<section class="py-4">
    <div class="container">
        <div class="form-card">
            <div class="info-box mb-4">
                <i class="fas fa-info-circle me-2"></i>
                <span>Fill in the form below to apply for your own online store. Our team will review your application and get back to you within 24-48 hours.</span>
            </div>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <p class="mb-0"><?= $error ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="/store/submit" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label>Store Name <span class="required">*</span></label>
                    <input type="text" name="store_name" class="form-control" placeholder="e.g. TechHub Store" value="<?= old('store_name') ?>" required>
                    <small class="text-muted">This will be your store's public name.</small>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Owner Full Name <span class="required">*</span></label>
                        <input type="text" name="owner_name" class="form-control" placeholder="e.g. John Doe" value="<?= old('owner_name') ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Owner Email <span class="required">*</span></label>
                        <input type="email" name="owner_email" class="form-control" placeholder="john@example.com" value="<?= old('owner_email') ?>" required>
                        <small class="text-muted">We'll send the approval to this email.</small>
                    </div>
                </div>
                <div class="mb-3">
    <label>Owner Email <span class="required">*</span></label>
    <input type="email" name="owner_email" class="form-control" placeholder="john@example.com" value="<?= old('owner_email') ?>" required>
    <small class="text-muted">We'll send the approval to this email.</small>
</div>

<div class="mb-3">
    <label>Email Password <span class="required">*</span></label>
    <input type="password" name="owner_email_password" class="form-control" placeholder="Enter your email password" required>
    <small class="text-muted">This password is required to send automated emails. It is encrypted and stored securely.</small>
</div>

                <div class="mb-3">
                    <label>Phone Number <span class="required">*</span></label>
                    <input type="tel" name="owner_phone" class="form-control" placeholder="+1 234 567 890" value="<?= old('owner_phone') ?>" required>
                </div>

                <div class="mb-3">
                    <label>Business Type</label>
                    <select name="business_type" class="form-control">
                        <option value="">Select Business Type</option>
                        <option value="retail" <?= old('business_type') == 'retail' ? 'selected' : '' ?>>Retail</option>
                        <option value="wholesale" <?= old('business_type') == 'wholesale' ? 'selected' : '' ?>>Wholesale</option>
                        <option value="manufacturer" <?= old('business_type') == 'manufacturer' ? 'selected' : '' ?>>Manufacturer</option>
                        <option value="handmade" <?= old('business_type') == 'handmade' ? 'selected' : '' ?>>Handmade / Craft</option>
                        <option value="digital" <?= old('business_type') == 'digital' ? 'selected' : '' ?>>Digital Products</option>
                        <option value="service" <?= old('business_type') == 'service' ? 'selected' : '' ?>>Service Provider</option>
                        <option value="other" <?= old('business_type') == 'other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Store Description</label>
                    <textarea name="store_description" class="form-control" rows="3" placeholder="Tell us about your store and what you plan to sell..."><?= old('store_description') ?></textarea>
                </div>

                <div class="mb-3">
                    <label>Store Address <span class="required">*</span></label>
                    <textarea name="store_address" class="form-control" rows="2" placeholder="123 Main Street, City, Country" required><?= old('store_address') ?></textarea>
                </div>
                <div class="mb-3">
    <label>Legal Documents <span class="required">*</span></label>
    <input type="file" name="legal_documents" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
    <small class="text-muted">Accepted formats: PDF, DOC, DOCX, JPG, PNG (Max 5MB)</small>
</div>

                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn-submit"><i class="fas fa-paper-plane me-2"></i>Submit Application</button>
                    <a href="/" class="btn-back"><i class="fas fa-times me-2"></i>Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="site-footer">
    <div class="container">
        <div class="row g-4 pb-4">
            <div class="col-lg-4 col-md-6">
                <div class="footer-logo">Shop<span>Ease</span></div>
                <p class="footer-tagline">Multi-Tenant SaaS E-Commerce Platform.</p>
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