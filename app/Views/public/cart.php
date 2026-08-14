<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - ShopEase</title>
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
        .cart-table img { width: 80px; height: 80px; object-fit: contain; border-radius: 8px; background: #fff; padding: 5px; border: 1px solid #e8f0e8; }
        .cart-table .product-name { color: #1a2e1a; font-weight: 600; }
        .cart-table .product-price { color: #1a2e1a; font-weight: 700; }
        .cart-table .quantity-input { width: 60px; text-align: center; border: 2px solid #e8f0e8; border-radius: 8px; padding: 5px; }
        .cart-table .quantity-input:focus { border-color: #4caf50; outline: none; }
        .cart-table .btn-remove { color: #dc3545; background: none; border: none; transition: 0.3s; }
        .cart-table .btn-remove:hover { color: #b02a37; transform: scale(1.1); }
        .cart-summary { background: #fff; border-radius: 12px; padding: 25px; border: 1px solid #e8f0e8; }
        .cart-summary h5 { color: #1a2e1a; font-weight: 700; }
        .cart-summary .summary-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f0f0f0; }
        .cart-summary .summary-row.total { border-bottom: none; font-weight: 700; font-size: 1.2rem; color: #1a2e1a; }
        .btn-checkout { background: #4caf50; color: #fff; border: none; border-radius: 30px; padding: 12px 40px; font-weight: 600; width: 100%; transition: 0.3s; }
        .btn-checkout:hover { background: #388e3c; }
        .btn-continue { background: transparent; color: #4caf50; border: 2px solid #4caf50; border-radius: 30px; padding: 10px 25px; font-weight: 600; transition: 0.3s; text-decoration: none; display: inline-block; }
        .btn-continue:hover { background: #4caf50; color: #fff; }
        .empty-cart { text-align: center; padding: 60px 0; }
        .empty-cart i { font-size: 5rem; color: #ddd; margin-bottom: 20px; }
        .empty-cart h4 { color: #1a2e1a; }
        .empty-cart p { color: #888; }
        .footer { background: #1a2e1a; color: #d4d4d4; padding: 40px 0 20px; margin-top: 40px; }
        .footer h5 { color: #fff; font-weight: 600; }
        .footer a { color: #aaa; text-decoration: none; transition: 0.3s; }
        .footer a:hover { color: #4caf50; }
        .cart-badge { background: #dc3545; color: #fff; border-radius: 50%; padding: 2px 8px; font-size: 0.7rem; position: absolute; top: -5px; right: -5px; }
        @media (max-width: 768px) { .cart-table img { width: 60px; height: 60px; } }
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
                <li class="nav-item"><a class="nav-link" href="/categories">Categories</a></li>
                <li class="nav-item"><a class="nav-link" href="/products">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="/contact">Contact</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <input class="search-box me-2" type="search" placeholder="Search for products...">
                <button class="icon-btn"><i class="far fa-heart"></i></button>
                <a href="/cart" class="icon-btn" style="color:#d4d4d4;text-decoration:none;position:relative;">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-badge" id="cartBadge"><?= isset($itemCount) && $itemCount > 0 ? $itemCount : 0 ?></span>
                </a>
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
                <h2><i class="fas fa-shopping-cart me-2"></i>Shopping Cart</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2 text-white-50">/</span>
                    <span class="active">Cart</span>
                </nav>
            </div>
            <div>
                <span class="text-white-50" id="itemCount"><?= isset($itemCount) ? $itemCount : 0 ?> items in your cart</span>
            </div>
        </div>
    </div>
</section>

<!-- Cart Section -->
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
                    <div class="bg-white rounded-3 p-3 border">
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
                                                    <img src="/<?= $item['product_image'] ?? 'uploads/default-product.jpg' ?>" alt="<?= $item['product_name'] ?>">
                                                    <div>
                                                        <div class="product-name"><?= $item['product_name'] ?></div>
                                                        <small class="text-muted">SKU: <?= str_pad($item['product_id'], 6, '0', STR_PAD_LEFT) ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="product-price" id="price-<?= $item['product_id'] ?>">$<?= number_format($item['price'], 2) ?></td>
                                            <td>
                                                <input type="number" class="quantity-input" value="<?= $item['quantity'] ?>" min="1" max="<?= $item['stock'] ?>" data-product-id="<?= $item['product_id'] ?>" onchange="updateCart(this)">
                                            </td>
                                            <td class="product-price" id="total-<?= $item['product_id'] ?>">$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                            <td>
                                                <button class="btn-remove" onclick="removeFromCart(<?= $item['product_id'] ?>)"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            <a href="/products" class="btn-continue"><i class="fas fa-arrow-left me-2"></i>Continue Shopping</a>
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

<!-- Footer -->
<footer class="footer">
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5><i class="fas fa-store text-success"></i> ShopEase</h5>
                <p class="text-muted">Your one-stop shop for everything you need.</p>
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

    function updateCart(input) {
        var productId = input.dataset.productId;
        var quantity = parseInt(input.value);
        var maxStock = parseInt(input.max);

        if (quantity < 1) {
            quantity = 1;
            input.value = 1;
        }

        if (quantity > maxStock) {
            alert('Not enough stock available. Max: ' + maxStock);
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
                // Update cart total
                updateCartTotals();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function removeFromCart(productId) {
        if (!confirm('Are you sure you want to remove this item from your cart?')) {
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
                
                // If cart is empty, reload to show empty message
                if (data.cart_count === 0) {
                    location.reload();
                }
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
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