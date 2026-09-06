<!-- app/Views/public/addresses.php -->
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
    <title>My Addresses - ShopEase</title>
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

        /* ─── PAGE TITLE ─────────────────────────────── */
        .page-title { font-family: var(--display); font-weight: 800; color: var(--brand); font-size: 1.6rem; display: flex; align-items: center; gap: 10px; }
        .page-title i { color: var(--accent); }
        .btn-add-address {
            background: var(--accent); color: #fff; border: none;
            border-radius: 50px; padding: 11px 26px; font-weight: 700;
            font-size: 0.88rem; box-shadow: 0 8px 24px rgba(233,69,96,0.3);
            display: inline-flex; align-items: center; transition: all 0.2s;
        }
        .btn-add-address:hover { background: #c73652; color: #fff; transform: translateY(-2px); }

        .alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #047857; border-radius: var(--radius); font-size: 0.88rem; }
        .alert-danger { background: #fff5f5; border: 1px solid #ffd6dc; color: #b3273f; border-radius: var(--radius); font-size: 0.88rem; }

        /* ─── ADDRESS CARD ───────────────────────────── */
        .address-card {
            background: var(--white); border: 1px solid var(--border);
            border-radius: var(--radius-lg); padding: 22px; height: 100%;
            transition: all 0.25s cubic-bezier(0.16,1,0.3,1);
        }
        .address-card:hover { border-color: var(--accent); box-shadow: var(--shadow-hover); transform: translateY(-3px); }
        .default-badge {
            background: var(--gold); color: #fff; padding: 3px 12px;
            border-radius: 20px; font-size: 0.68rem; font-weight: 700;
            display: inline-flex; align-items: center; gap: 4px;
        }
        .address-name { font-family: var(--display); font-weight: 700; color: var(--brand); font-size: 1.02rem; }
        .address-name i { color: var(--accent); }
        .address-detail { color: var(--muted); font-size: 0.87rem; margin-bottom: 3px; }
        .address-detail strong { color: var(--brand); }

        .btn-outline-success, .btn-default-outline {
            background: transparent; color: var(--accent); border: 1.5px solid var(--accent);
            border-radius: 30px; padding: 5px 15px; font-size: 0.76rem; font-weight: 600;
            transition: all 0.2s;
        }
        .btn-outline-success:hover, .btn-default-outline:hover { background: var(--accent); color: #fff; }
        .btn-outline-secondary {
            border: 1.5px solid var(--border); color: var(--muted); border-radius: 8px;
            background: var(--surface);
        }
        .btn-outline-secondary:hover { border-color: var(--accent); color: var(--accent); background: #fff5f5; }

        .empty-addresses { padding: 60px 0; }
        .empty-addresses i { font-size: 4rem; color: var(--border); }
        .empty-addresses h5 { font-family: var(--display); color: var(--brand); font-weight: 700; margin-top: 16px; }
        .empty-addresses p { color: var(--muted); }
        .empty-addresses .btn-success {
            background: var(--accent); border: none; border-radius: 50px; padding: 11px 26px;
            font-weight: 700; font-size: 0.88rem;
        }
        .empty-addresses .btn-success:hover { background: #c73652; }

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
                <li><a href="#" class="nav-link-item active">Addresses</a></li>
            </ul>
            <div class="ms-auto d-flex align-items-center gap-2">
                <a href="/logout" class="nav-action"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </div>
</nav>

<section class="py-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title"><i class="fas fa-address-book"></i>My Addresses</h2>
            <a href="/addresses/add" class="btn-add-address"><i class="fas fa-plus me-2"></i>Add New Address</a>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if (!empty($addresses)): ?>
            <div class="row">
                <?php foreach ($addresses as $address): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="address-card">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <?php if ($address['address_name']): ?>
                                        <div class="address-name">
                                            <i class="fas fa-tag me-1"></i><?= esc($address['address_name']) ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($address['is_default']): ?>
                                        <span class="default-badge"><i class="fas fa-check"></i>Default</span>
                                    <?php endif; ?>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius:12px;">
                                        <li><a class="dropdown-item" href="/addresses/edit/<?= $address['id'] ?>"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                        <?php if (!$address['is_default']): ?>
                                            <li><a class="dropdown-item" href="/addresses/set-default/<?= $address['id'] ?>"><i class="fas fa-check-circle me-2"></i>Set as Default</a></li>
                                        <?php endif; ?>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="/addresses/delete/<?= $address['id'] ?>" onclick="return confirm('Are you sure you want to delete this address?')"><i class="fas fa-trash me-2"></i>Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="address-detail"><strong><?= esc($address['first_name']) ?> <?= esc($address['last_name']) ?></strong></div>
                                <div class="address-detail"><?= esc($address['address_line1']) ?></div>
                                <?php if (!empty($address['address_line2'])): ?>
                                    <div class="address-detail"><?= esc($address['address_line2']) ?></div>
                                <?php endif; ?>
                                <div class="address-detail"><?= esc($address['city']) ?>, <?= esc($address['state'] ?? '') ?> <?= esc($address['postal_code'] ?? '') ?></div>
                                <div class="address-detail"><?= esc($address['country']) ?></div>
                                <div class="address-detail"><i class="fas fa-phone me-1"></i><?= esc($address['phone']) ?></div>
                            </div>
                            <div class="mt-3 d-flex gap-2">
                                <a href="/addresses/edit/<?= $address['id'] ?>" class="btn btn-sm btn-outline-success"><i class="fas fa-edit me-1"></i>Edit</a>
                                <?php if (!$address['is_default']): ?>
                                    <a href="/addresses/set-default/<?= $address['id'] ?>" class="btn btn-sm btn-default-outline"><i class="fas fa-check me-1"></i>Set Default</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-addresses text-center">
                <i class="fas fa-address-book"></i>
                <h5>No saved addresses</h5>
                <p>You haven't added any addresses yet.</p>
                <a href="/addresses/add" class="btn btn-success"><i class="fas fa-plus me-2"></i>Add Your First Address</a>
            </div>
        <?php endif; ?>
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