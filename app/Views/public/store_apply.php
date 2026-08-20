<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Your Store - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { padding-top: 80px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8f9fa; }
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
        .form-card { background: #fff; border-radius: 16px; padding: 40px; border: 1px solid #e8f0e8; max-width: 700px; margin: 0 auto; }
        .form-card label { font-weight: 600; color: #1a2e1a; }
        .form-card .form-control { border-radius: 8px; border: 2px solid #e8f0e8; padding: 10px 15px; transition: 0.3s; }
        .form-card .form-control:focus { border-color: #4caf50; box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1); }
        .form-card .form-control.is-invalid { border-color: #dc3545; }
        .btn-submit { background: #4caf50; color: #fff; border: none; border-radius: 30px; padding: 12px 40px; font-weight: 600; transition: 0.3s; }
        .btn-submit:hover { background: #388e3c; color: #fff; transform: translateY(-2px); }
        .btn-back { background: #6c757d; color: #fff; border: none; border-radius: 30px; padding: 12px 40px; font-weight: 600; transition: 0.3s; text-decoration: none; display: inline-block; }
        .btn-back:hover { background: #5a6268; color: #fff; }
        .footer { background: #1a2e1a; color: #d4d4d4; padding: 40px 0 20px; margin-top: 40px; }
        .footer h5 { color: #fff; font-weight: 600; }
        .footer a { color: #aaa; text-decoration: none; transition: 0.3s; }
        .footer a:hover { color: #4caf50; }
        .info-box { background: #e8f5e9; border-left: 4px solid #4caf50; padding: 15px 20px; border-radius: 8px; }
        .info-box i { color: #4caf50; font-size: 1.2rem; }
        .required { color: #dc3545; }
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
                <li class="nav-item"><a class="nav-link" href="/products">Products</a></li>
                <li class="nav-item"><a class="nav-link active" href="#">Open Your Store</a></li>
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
                <h2><i class="fas fa-store me-2"></i>Open Your Store</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2 text-white-50">/</span>
                    <span class="active">Open Your Store</span>
                </nav>
            </div>
        </div>
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

<!-- Footer -->
<footer class="footer">
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5><i class="fas fa-store text-success"></i> ShopEase</h5>
                <p class="text-muted">Multi-Tenant SaaS E-Commerce Platform.</p>
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
</script>
</body>
</html>