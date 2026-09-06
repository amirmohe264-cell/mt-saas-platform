<!-- app/Views/public/cart.php -->
<?php
if (!session()->get('customer_id')) {
    header('Location: /login');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - ShopEase</title>
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

        /* ─── NOTIFICATION TOAST ─────────────────────── */
        .notification-container {
            position: fixed; top: 90px; right: 20px; z-index: 9999;
            max-width: 360px; width: 100%;
        }
        .notification-toast {
            background: var(--white); border-radius: var(--radius);
            padding: 14px 16px; margin-bottom: 10px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.14);
            border-left: 3px solid #10b981;
            animation: slideInRight 0.3s ease;
            display: flex; align-items: flex-start; gap: 10px;
        }
        .notification-toast.error { border-left-color: var(--accent); }
        .notification-toast.warning { border-left-color: var(--gold); }
        .notification-toast.info { border-left-color: #6366f1; }
        .notification-toast .notif-icon { font-size: 1.1rem; margin-top: 1px; }
        .notification-toast .notif-content { flex: 1; }
        .notification-toast .notif-title { font-weight: 700; color: var(--brand); font-size: 0.85rem; }
        .notification-toast .notif-message { color: var(--muted); font-size: 0.78rem; }
        .notification-toast .notif-close { background: none; border: none; color: #9ca3af; cursor: pointer; font-size: 0.9rem; padding: 0; }
        .notification-toast .notif-close:hover { color: var(--brand); }
        .notification-toast.removing { animation: slideOutRight 0.3s ease forwards; }
        @keyframes slideInRight { from { transform: translateX(100px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes slideOutRight { from { transform: translateX(0); opacity: 1; } to { transform: translateX(100px); opacity: 0; } }

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
            color: #374151; font-size: 0.95rem; position: relative; transition: all 0.2s;
        }
        .nav-action:hover { border-color: var(--accent); color: var(--accent); background: #fff5f5; }
        .cart-badge {
            position: absolute; top: -4px; right: -4px;
            background: var(--accent); color: white; font-size: 0.6rem;
            font-weight: 700; width: 16px; height: 16px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
        }
        .btn-nav-signin {
            background: var(--brand); color: white; font-size: 0.875rem; font-weight: 600;
            padding: 9px 22px; border-radius: 50px; border: none; transition: all 0.2s;
        }
        .btn-nav-signin:hover { background: #2d2d4e; color: white; }

        /* ─── PAGE HEADER ────────────────────────────── */
        .page-header { background: var(--brand); color: #fff; padding: 44px 0 34px; }
        .page-header h2 { font-family: var(--display); font-weight: 800; font-size: 1.8rem; }
        .page-header .breadcrumb { display: flex; align-items: center; gap: 8px; margin-top: 6px; font-size: 0.85rem; }
        .page-header .breadcrumb a { color: var(--accent-light); }
        .page-header .breadcrumb .active { color: rgba(255,255,255,0.55); }

        /* ─── CART TABLE ─────────────────────────────── */
        .cart-panel { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 20px; box-shadow: var(--shadow); }
        .cart-table img { width: 76px; height: 76px; object-fit: contain; border-radius: 10px; background: var(--surface); padding: 6px; border: 1px solid var(--border); }
        .cart-table .product-name { color: var(--brand); font-weight: 600; font-size: 0.92rem; }
        .cart-table .product-price { color: var(--brand); font-weight: 700; }
        .cart-table thead th { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; color: var(--muted); border-bottom: 1px solid var(--border); font-weight: 700; }
        .cart-table td { border-bottom: 1px solid var(--border); vertical-align: middle; }
        .quantity-input { width: 60px; text-align: center; border: 1.5px solid var(--border); border-radius: 8px; padding: 6px; }
        .quantity-input:focus { border-color: var(--accent); outline: none; box-shadow: 0 0 0 3px rgba(233,69,96,0.1); }
        .btn-remove { color: var(--accent); background: none; border: none; transition: 0.2s; }
        .btn-remove:hover { color: #b3273f; transform: scale(1.1); }

        .btn-continue {
            background: transparent; color: var(--brand); border: 1.5px solid var(--border);
            border-radius: 50px; padding: 10px 24px; font-weight: 600; font-size: 0.88rem;
            display: inline-flex; align-items: center; transition: all 0.2s;
        }
        .btn-continue:hover { border-color: var(--accent); color: var(--accent); background: #fff5f5; }
        .btn-clear-cart {
            background: transparent; color: var(--accent); border: 1.5px solid var(--accent);
            border-radius: 50px; padding: 8px 20px; font-weight: 600; font-size: 0.82rem; transition: all 0.2s;
        }
        .btn-clear-cart:hover { background: var(--accent); color: white; }

        /* ─── CART SUMMARY ───────────────────────────── */
        .cart-summary { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 26px; box-shadow: var(--shadow); }
        .cart-summary h5 { font-family: var(--display); color: var(--brand); font-weight: 800; }
        .cart-summary .summary-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed var(--border); font-size: 0.9rem; color: var(--muted); }
        .cart-summary .summary-row.total { border-bottom: none; font-family: var(--display); font-weight: 800; font-size: 1.2rem; color: var(--brand); }
        .btn-checkout {
            background: var(--accent); color: #fff; border: none; border-radius: 50px;
            padding: 13px 40px; font-weight: 700; width: 100%;
            box-shadow: 0 8px 24px rgba(233,69,96,0.3); transition: all 0.2s;
            display: inline-flex; align-items: center; justify-content: center;
        }
        .btn-checkout:hover { background: #c73652; color: white; transform: translateY(-2px); }

        .alert-danger { background: #fff5f5; border: 1px solid #ffd6dc; color: #b3273f; border-radius: var(--radius); font-size: 0.88rem; }
        .alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #047857; border-radius: var(--radius); font-size: 0.88rem; }

        /* ─── EMPTY CART ─────────────────────────────── */
        .empty-cart { text-align: center; padding: 70px 0; }
        .empty-cart i { font-size: 4.5rem; color: var(--border); margin-bottom: 20px; }
        .empty-cart h4 { font-family: var(--display); color: var(--brand); font-weight: 800; }
        .empty-cart p { color: var(--muted); }
        .empty-cart .btn-success {
            background: var(--accent); border: none; border-radius: 50px; padding: 12px 30px; font-weight: 700;
        }
        .empty-cart .btn-success:hover { background: #c73652; }

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

        @media (max-width: 768px) { .cart-table img { width: 56px; height: 56px; } }
    </style>
</head>
<body>

<!-- Notification Container -->
<div class="notification-container" id="notificationContainer"></div>

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
                <a href="/cart" class="nav-action">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-badge" id="cartBadge"><?= $itemCount ?? 0 ?></span>
                </a>

                <?php if (session()->get('customer_id')): ?>
                    <div class="dropdown">
                        <button class="btn-nav-signin dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i> <?= session()->get('first_name') ?? 'Account' ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="border-radius:12px; min-width:200px;">
                            <li><a class="dropdown-item py-2" href="/dashboard"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                            <li><a class="dropdown-item py-2" href="/dashboard#profile"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item py-2" href="/dashboard#orders"><i class="fas fa-box me-2"></i>Orders</a></li>
                            <li><a class="dropdown-item py-2" href="/cart"><i class="fas fa-shopping-cart me-2"></i>Cart</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger py-2" href="/logout"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                <?php elseif (session()->get('tenant_id')): ?>
                    <a href="/store/dashboard" class="nav-action"><i class="fas fa-store"></i></a>
                    <a href="/logout" class="nav-action"><i class="fas fa-sign-out-alt"></i></a>
                <?php elseif (session()->get('admin_id')): ?>
                    <a href="/admin/dashboard" class="nav-action"><i class="fas fa-crown"></i></a>
                    <a href="/logout" class="nav-action"><i class="fas fa-sign-out-alt"></i></a>
                <?php else: ?>
                    <a href="/login" class="nav-action"><i class="fas fa-sign-in-alt"></i></a>
                    <a href="/register" class="btn-nav-signin">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- PAGE HEADER -->
<section class="page-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2><i class="fas fa-shopping-cart me-2"></i>Shopping Cart</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="text-white-50">/</span>
                    <span class="active">Cart</span>
                </nav>
            </div>
            <div>
                <span class="text-white-50" id="itemCount"><?= $itemCount ?? 0 ?> items in your cart</span>
            </div>
        </div>
    </div>
</section>

<!-- CART SECTION -->
<section class="py-4">
    <div class="container">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <?php if (isset($cartItems) && !empty($cartItems)): ?>
            <div class="row">
                <!-- Cart Items -->
                <div class="col-lg-8">
                    <div class="cart-panel">
                        <div class="table-responsive">
                            <table class="table cart-table align-middle">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="cartBody">
                                    <?php foreach ($cartItems as $item): ?>
                                        <tr id="cart-row-<?= $item['product_id'] ?>">
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <?php if (!empty($item['product_image'])): ?>
                                                        <img src="/<?= $item['product_image'] ?>" alt="<?= $item['product_name'] ?>">
                                                    <?php else: ?>
                                                        <img src="https://via.placeholder.com/80?text=<?= urlencode($item['product_name']) ?>" alt="<?= $item['product_name'] ?>">
                                                    <?php endif; ?>
                                                    <div>
                                                        <div class="product-name"><?= $item['product_name'] ?></div>
                                                        <small class="text-muted">SKU: <?= str_pad($item['product_id'], 6, '0', STR_PAD_LEFT) ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="product-price">$<?= number_format($item['price'], 2) ?></td>
                                            <td>
                                                <input type="number" class="quantity-input" value="<?= $item['quantity'] ?>" min="1" max="<?= $item['stock'] ?? 99 ?>" data-product-id="<?= $item['product_id'] ?>" onchange="updateCart(this)">
                                            </td>
                                            <td class="product-price">$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                            <td>
                                                <button class="btn-remove" onclick="removeFromCart(<?= $item['product_id'] ?>, '<?= addslashes($item['product_name']) ?>')"><i class="fas fa-trash-alt"></i></button>
                                                
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 d-flex align-items-center flex-wrap gap-2">
                            <a href="/products" class="btn-continue"><i class="fas fa-arrow-left me-2"></i>Continue Shopping</a>
                            <a href="/cart/clear" class="btn-clear-cart" onclick="return confirm('Clear all items?')"><i class="fas fa-trash me-1"></i>Clear Cart</a>
                        </div>
                    </div>
                </div>

                <!-- Cart Summary -->
                <div class="col-lg-4">
                    <div class="cart-summary">
                        <h5>Order Summary</h5>
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span id="subtotal">$<?= number_format($subtotal ?? 0, 2) ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Shipping</span>
                            <span id="shipping"><?= isset($shipping) && $shipping > 0 ? '$'.number_format($shipping, 2) : 'Free' ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Tax (8%)</span>
                            <span id="tax">$<?= number_format($tax ?? 0, 2) ?></span>
                        </div>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span id="grandTotal">$<?= number_format($grandTotal ?? 0, 2) ?></span>
                        </div>
                        <a href="/checkout" class="btn-checkout mt-3"><i class="fas fa-lock me-2"></i>Proceed to Checkout</a>
                        <div class="text-center mt-3">
                            <small class="text-muted"><i class="fas fa-lock me-1"></i>Secure checkout</small>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <h4>Your cart is empty</h4>
                <p>Looks like you haven't added any items to your cart yet.</p>
                <a href="/products" class="btn btn-success" style="border-radius:30px;"><i class="fas fa-shopping-bag me-2"></i>Start Shopping</a>
            </div>
        <?php endif; ?>
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
        <p class="text-center footer-bottom mb-0">&copy; <?= date('Y') ?> ShopEase. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ==========================================
// SHOW FLASH MESSAGES
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    <?php if (session()->getFlashdata('success')): ?>
        showNotification('success', '✅ Success', '<?= session()->getFlashdata('success') ?>');
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        showNotification('error', '❌ Error', '<?= session()->getFlashdata('error') ?>');
    <?php endif; ?>
});

// ==========================================
// NOTIFICATION FUNCTION
// ==========================================
function showNotification(type, title, message) {
    const container = document.getElementById('notificationContainer');
    if (!container) return;

    const icons = { success: '✅', error: '❌', warning: '⚠️', info: 'ℹ️' };
    const icon = icons[type] || 'ℹ️';

    const toast = document.createElement('div');
    toast.className = 'notification-toast ' + (type === 'error' ? 'error' : type === 'warning' ? 'warning' : type === 'info' ? 'info' : '');
    toast.innerHTML = `
        <div class="notif-icon">${icon}</div>
        <div class="notif-content">
            <div class="notif-title">${title}</div>
            <div class="notif-message">${message}</div>
        </div>
        <button class="notif-close" onclick="this.closest('.notification-toast').remove()">
            <i class="fas fa-times"></i>
        </button>
    `;

    container.appendChild(toast);

    setTimeout(() => {
        if (toast.parentNode) {
            toast.classList.add('removing');
            setTimeout(() => {
                if (toast.parentNode) toast.remove();
            }, 300);
        }
    }, 5000);
}

// ==========================================
// NAVBAR SCROLL
// ==========================================
window.addEventListener('scroll', function() {
    document.getElementById('siteNav').classList.toggle('scrolled', window.scrollY > 40);
});

// ==========================================
// CART FUNCTIONS
// ==========================================
function updateCart(input) {
    var productId = input.dataset.productId;
    var quantity = parseInt(input.value);
    var maxStock = parseInt(input.max);

    if (quantity < 1) {
        quantity = 1;
        input.value = 1;
    }

    if (quantity > maxStock) {
        showNotification('warning', '⚠️ Stock Limit', 'Not enough stock available. Max: ' + maxStock);
        input.value = maxStock;
        quantity = maxStock;
    }

    fetch('/cart/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: 'product_id=' + productId + '&quantity=' + quantity
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartTotals();
            showNotification('success', '🔄 Updated', 'Quantity updated successfully!');
        } else {
            showNotification('error', '❌ Error', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('error', '❌ Error', 'Something went wrong.');
    });
}

function removeFromCart(productId, productName) {
    if (!confirm('Are you sure you want to remove "' + productName + '" from your cart?')) {
        return;
    }

    fetch('/cart/remove', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: 'product_id=' + productId
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('cart-row-' + productId).remove();
            updateCartTotals();
            updateCartBadge(data.cart_count);
            showNotification('info', '🗑️ Removed', productName + ' removed from cart!');

            if (data.cart_count === 0) {
                setTimeout(() => location.reload(), 1000);
            }
        } else {
            showNotification('error', '❌ Error', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('error', '❌ Error', 'Something went wrong.');
    });
}

function updateCartTotals() {
    fetch('/cart/totals', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('subtotal').textContent = '$' + data.subtotal.toFixed(2);
            document.getElementById('shipping').textContent = data.shipping > 0 ? '$' + data.shipping.toFixed(2) : 'Free';
            document.getElementById('tax').textContent = '$' + data.tax.toFixed(2);
            document.getElementById('grandTotal').textContent = '$' + data.grandTotal.toFixed(2);
            document.getElementById('itemCount').textContent = data.itemCount + ' items in your cart';
            updateCartBadge(data.itemCount);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function updateCartBadge(count) {
    var badge = document.getElementById('cartBadge');
    if (badge) {
        if (count > 0) {
            badge.textContent = count;
            badge.style.display = 'inline';
        } else {
            badge.style.display = 'none';
        }
    }
}
</script>
</body>
</html>