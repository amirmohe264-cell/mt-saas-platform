<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { padding-top: 80px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8f9fa; }
        .navbar { position: fixed; top: 0; left: 0; right: 0; z-index: 1000; background: #1a2e1a !important; padding: 15px 0; }
        .navbar-brand { color: #fff !important; font-weight: bold; font-size: 1.5rem; }
        .navbar-brand i { color: #4caf50; }
        .navbar .nav-link { color: #d4d4d4 !important; }
        .navbar .nav-link:hover { color: #4caf50 !important; }
        .page-header { background: #1a2e1a; color: #fff; padding: 40px 0 30px; }
        .page-header h2 { font-weight: 700; }
        .page-header .breadcrumb { background: none; padding: 0; margin: 0; }
        .page-header .breadcrumb a { color: #4caf50; text-decoration: none; }
        .page-header .breadcrumb .active { color: #aaa; }
        .table-card { background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #e8f0e8; }
        .btn-add { background: #4caf50; color: #fff; border: none; border-radius: 30px; padding: 10px 25px; font-weight: 600; transition: 0.3s; text-decoration: none; display: inline-block; }
        .btn-add:hover { background: #388e3c; color: #fff; }
        .btn-edit { background: #ffc107; color: #000; border: none; border-radius: 30px; padding: 5px 15px; font-weight: 600; transition: 0.3s; text-decoration: none; display: inline-block; font-size: 0.8rem; }
        .btn-edit:hover { background: #e0a800; color: #000; }
        .btn-delete { background: #dc3545; color: #fff; border: none; border-radius: 30px; padding: 5px 15px; font-weight: 600; transition: 0.3s; text-decoration: none; display: inline-block; font-size: 0.8rem; }
        .btn-delete:hover { background: #c82333; color: #fff; }
        .btn-toggle { background: #17a2b8; color: #fff; border: none; border-radius: 30px; padding: 5px 15px; font-weight: 600; transition: 0.3s; text-decoration: none; display: inline-block; font-size: 0.8rem; }
        .btn-toggle:hover { background: #138496; color: #fff; }
        .badge-published { background: #4caf50; color: #fff; padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; }
        .badge-draft { background: #ffc107; color: #000; padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; }
        .badge-archived { background: #dc3545; color: #fff; padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; }
        .product-image-small { width: 50px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid #e8f0e8; }
        .footer { background: #1a2e1a; color: #d4d4d4; padding: 40px 0 20px; margin-top: 40px; }
        .footer h5 { color: #fff; }
        .footer a { color: #aaa; text-decoration: none; }
        .footer a:hover { color: #4caf50; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="fas fa-store"></i> ShopEase</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/store/dashboard">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active" href="#">Products</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">Store: <?= session()->get('store_name') ?? 'Store' ?></span>
                <a href="/logout" class="text-white" style="text-decoration:none;"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </div>
</nav>

<section class="page-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-boxes me-2"></i>Products</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2 text-white-50">/</span>
                    <a href="/store/dashboard">Dashboard</a>
                    <span class="mx-2 text-white-50">/</span>
                    <span class="active">Products</span>
                </nav>
            </div>
            <a href="/store/products/create" class="btn-add"><i class="fas fa-plus me-2"></i>Add Product</a>
        </div>
    </div>
</section>

<section class="py-4">
    <div class="container">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <div class="table-card">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?= $product['id'] ?></td>
                                    <td>
                                        <?php if (!empty($product['product_image'])): ?>
                                            <img src="/<?= $product['product_image'] ?>" class="product-image-small" alt="<?= esc($product['product_name']) ?>">
                                        <?php else: ?>
                                            <img src="https://via.placeholder.com/50" class="product-image-small" alt="No image">
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($product['product_name']) ?></td>
                                    <td>
                                        <?php 
                                        // ✅ FIXED: Use categories array instead of $this->categoryModel
                                        if (isset($categories) && isset($categories[$product['category_id']])) {
                                            echo esc($categories[$product['category_id']]['category_name'] ?? 'N/A');
                                        } else {
                                            echo 'N/A';
                                        }
                                        ?>
                                    </td>
                                    <td>$<?= number_format($product['price'], 2) ?></td>
                                    <td><?= $product['quantity'] ?></td>
                                    <td>
                                        <?php if ($product['status'] == 'published'): ?>
                                            <span class="badge-published">Published</span>
                                        <?php elseif ($product['status'] == 'draft'): ?>
                                            <span class="badge-draft">Draft</span>
                                        <?php else: ?>
                                            <span class="badge-archived">Archived</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="/store/products/edit/<?= $product['id'] ?>" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="/store/products/toggle/<?= $product['id'] ?>" class="btn-toggle"><i class="fas fa-sync"></i> Toggle</a>
                                        <a href="/store/products/delete/<?= $product['id'] ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this product?')"><i class="fas fa-trash"></i> Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3 d-block"></i>
                                    <p class="text-muted">No products found. <a href="/store/products/create">Add your first product</a></p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

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
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Customer Service</h5>
                <ul class="list-unstyled">
                    <li><a href="/help">Help Center</a></li>
                    <li><a href="/returns">Returns</a></li>
                    <li><a href="/shipping">Shipping Info</a></li>
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
</body>
</html>