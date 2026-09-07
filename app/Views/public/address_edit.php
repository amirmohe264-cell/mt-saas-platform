<?php
if (!session()->get('customer_id') && !session()->get('user_id')) {
    header('Location: /login');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Address - ShopEase</title>
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
        }
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
        .nav-action {
            width: 38px; height: 38px; border-radius: 50%;
            border: 1px solid var(--border); background: var(--surface);
            display: flex; align-items: center; justify-content: center;
            color: #374151; font-size: 0.95rem; transition: all 0.2s;
        }
        .nav-action:hover { border-color: var(--accent); color: var(--accent); background: #fff5f5; }

        /* ─── FORM CARD ──────────────────────────────── */
        .form-card {
            background: var(--white); border: 1px solid var(--border);
            border-radius: var(--radius-lg); padding: 36px;
            max-width: 720px; margin: 0 auto; box-shadow: var(--shadow);
        }
        .form-card h4 {
            font-family: var(--display); font-weight: 800; color: var(--brand);
            display: flex; align-items: center; gap: 10px; font-size: 1.3rem;
        }
        .form-card h4 i { color: var(--accent); }
        .form-card hr { border-color: var(--border); margin: 18px 0 24px; }

        .form-card label { font-size: 0.85rem; font-weight: 600; color: var(--brand); margin-bottom: 6px; display: inline-block; }
        .required { color: var(--accent); }
        .form-control, select.form-control {
            border: 1.5px solid var(--border); border-radius: 10px;
            padding: 10px 14px; font-size: 0.9rem; transition: all 0.2s;
        }
        .form-control:focus {
            border-color: var(--accent); box-shadow: 0 0 0 3px rgba(233,69,96,0.1); outline: none;
        }
        .form-check-input:checked { background-color: var(--accent); border-color: var(--accent); }
        .form-check-input:focus { box-shadow: 0 0 0 3px rgba(233,69,96,0.1); }

        .alert-danger {
            background: #fff5f5; border: 1px solid #ffd6dc; color: #b3273f;
            border-radius: var(--radius); font-size: 0.88rem;
        }

        .btn-save {
            background: var(--accent); color: #fff; border: none;
            border-radius: 50px; padding: 12px 34px; font-weight: 700;
            font-size: 0.9rem; box-shadow: 0 8px 24px rgba(233,69,96,0.3);
            transition: all 0.2s;
        }
        .btn-save:hover { background: #c73652; color: #fff; transform: translateY(-2px); }
        .btn-cancel {
            background: var(--surface); color: var(--brand); border: 1.5px solid var(--border);
            border-radius: 50px; padding: 12px 34px; font-weight: 600;
            font-size: 0.9rem; display: inline-flex; align-items: center;
            transition: all 0.2s;
        }
        .btn-cancel:hover { border-color: var(--brand); color: var(--brand); background: white; }

        /* ─── FOOTER (matches homepage) ─────────────── */
        .site-footer { background: #111827; padding: 60px 0 28px; margin-top: 48px; }
        .footer-logo { font-family: var(--display); font-size: 1.4rem; font-weight: 800; color: white; }
        .footer-logo span { color: var(--accent); }
        .footer-tagline { font-size: 0.85rem; color: #6b7280; margin-top: 8px; }
        .footer-divider { border-color: #1f2937; margin: 32px 0 18px; }
        .footer-bottom { color: #4b5563; font-size: 0.8rem; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="site-nav">
    <div class="container">
        <div class="d-flex align-items-center gap-4">
            <a href="/" class="nav-logo">Shop<span>Ease</span></a>
            <ul class="navbar-nav flex-row gap-1 d-none d-lg-flex ms-2">
                <li><a href="/" class="nav-link-item">Home</a></li>
                <li><a href="/dashboard" class="nav-link-item">Dashboard</a></li>
                <li><a href="/addresses" class="nav-link-item">Addresses</a></li>
                <li><a href="#" class="nav-link-item active">Edit Address</a></li>
            </ul>
            <div class="ms-auto d-flex align-items-center gap-2">
                <a href="/logout" class="nav-action"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </div>
</nav>

<section class="py-4">
    <div class="container">
        <div class="form-card">
            <h4><i class="fas fa-edit"></i>Edit Address</h4>
            <hr>

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

            <form action="/addresses/update/<?= $address['id'] ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label>Address Name <small class="text-muted fw-normal">(e.g., Home, Work, Office)</small></label>
                    <input type="text" name="address_name" class="form-control" placeholder="Enter address name" value="<?= old('address_name', $address['address_name']) ?>">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>First Name <span class="required">*</span></label>
                        <input type="text" name="first_name" class="form-control" placeholder="First name" value="<?= old('first_name', $address['first_name']) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Last Name <span class="required">*</span></label>
                        <input type="text" name="last_name" class="form-control" placeholder="Last name" value="<?= old('last_name', $address['last_name']) ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Phone Number <span class="required">*</span></label>
                    <input type="tel" name="phone" class="form-control" placeholder="Enter phone number" value="<?= old('phone', $address['phone']) ?>" required>
                </div>

                <div class="mb-3">
                    <label>Address Line 1 <span class="required">*</span></label>
                    <input type="text" name="address_line1" class="form-control" placeholder="Street address, P.O. box" value="<?= old('address_line1', $address['address_line1']) ?>" required>
                </div>

                <div class="mb-3">
                    <label>Address Line 2 <small class="text-muted fw-normal">(Optional)</small></label>
                    <input type="text" name="address_line2" class="form-control" placeholder="Apartment, suite, unit, building, floor" value="<?= old('address_line2', $address['address_line2']) ?>">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>City <span class="required">*</span></label>
                        <input type="text" name="city" class="form-control" placeholder="Enter city" value="<?= old('city', $address['city']) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>State/Region <small class="text-muted fw-normal">(Optional)</small></label>
                        <input type="text" name="state" class="form-control" placeholder="Enter state/region" value="<?= old('state', $address['state']) ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Postal Code <small class="text-muted fw-normal">(Optional)</small></label>
                        <input type="text" name="postal_code" class="form-control" placeholder="Enter postal code" value="<?= old('postal_code', $address['postal_code']) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Country</label>
                        <select name="country" class="form-control">
                            <option value="Ethiopia" <?= old('country', $address['country']) == 'Ethiopia' ? 'selected' : '' ?>>Ethiopia</option>
                            <option value="Kenya" <?= old('country', $address['country']) == 'Kenya' ? 'selected' : '' ?>>Kenya</option>
                            <option value="Nigeria" <?= old('country', $address['country']) == 'Nigeria' ? 'selected' : '' ?>>Nigeria</option>
                            <option value="South Africa" <?= old('country', $address['country']) == 'South Africa' ? 'selected' : '' ?>>South Africa</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="is_default" id="isDefault" value="1" <?= old('is_default', $address['is_default']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="isDefault">Set as default address</label>
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn-save"><i class="fas fa-save me-2"></i>Update Address</button>
                    <a href="/addresses" class="btn-cancel"><i class="fas fa-times me-2"></i>Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="site-footer">
    <div class="container">
        <div class="footer-logo">Shop<span>Ease</span></div>
        <p class="footer-tagline">Your one-stop shop for everything you need.</p>
        <hr class="footer-divider">
        <p class="text-center footer-bottom mb-0">&copy; 2026 ShopEase. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>