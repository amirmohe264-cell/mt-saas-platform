<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Products - ShopEase</title>
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
        .icon-btn { color: #d4d4d4; font-size: 1.2rem; margin: 0 8px; transition: 0.3s; background: none; border: none; }
        .icon-btn:hover { color: #4caf50; transform: scale(1.1); }
        .page-header { background: #1a2e1a; color: #fff; padding: 40px 0 30px; }
        .page-header h2 { font-weight: 700; }
        .page-header .breadcrumb { background: none; padding: 0; margin: 0; }
        .page-header .breadcrumb a { color: #4caf50; text-decoration: none; }
        .page-header .breadcrumb .active { color: #aaa; }
        .btn-add { background: #4caf50; color: #fff; border: none; border-radius: 30px; padding: 10px 25px; font-weight: 600; transition: 0.3s; text-decoration: none; display: inline-block; }
        .btn-add:hover { background: #388e3c; color: #fff; }
        .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .status-published { background: #d4edda; color: #155724; }
        .status-draft { background: #fff3cd; color: #856404; }
        .status-archived { background: #e2e3e5; color: #383d41; }
        .footer { background: #1a2e1a; color: #d4d4d4; padding: 40px 0 20px; margin-top: 40px; }
        .footer h5 { color: #fff; font-weight: 600; }
        .footer a { color: #aaa; text-decoration: none; transition: 0.3s; }
        .footer a:hover { color: #4caf50; }
        .action-btns .btn { margin: 2px; }
        .product-image-thumb { width: 50px; height: 50px; object-fit: contain; border-radius: 8px; border: 1px solid #e8f0e8; padding: 3px; background: #fff; }
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
                <li class="nav-item"><a class="nav-link active" href="#">My Products</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">Store: <?= session()->get('store_name') ?? 'Store' ?></span>
                <a href="/logout" class="icon-btn" style="color:#d4d4d4;text-decoration:none;"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </div>
</nav>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-box me-2"></i>My Products</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2 text-white-50">/</span>
                    <a href="/store/dashboard">Dashboard</a>
                    <span class="mx-2 text-white-50">/</span>
                    <span class="active">Products</span>
                </nav>
            </div>
            <div>
                <a href="/store/products/create" class="btn-add"><i class="fas fa-plus me-2"></i>Add Product</a>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="py-4">
    <div class="container">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <p class="mb-0"><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-3 p-4 border">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <thead>
    <tr>
        <th>Image</th>
        <th>Product</th>
        <th>Category</th>
        <th>Subcategory</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
</thead>
<tbody>
    <?php if (isset($products) && !empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <tr>
                <td>
                    <?php if ($product['product_image']): ?>
                        <img src="/<?= $product['product_image'] ?>" alt="<?= $product['product_name'] ?>" class="product-image-thumb">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/50x50?text=No+Image" alt="No Image" class="product-image-thumb">
                    <?php endif; ?>
                </td>
                <td><strong><?= esc($product['product_name']) ?></strong></td>
                <td>
                    <?php 
                    $category = $this->categoryModel->find($product['category_id']);
                    echo esc($category ? $category['category_name'] : 'Uncategorized');
                    ?>
                </td>
                <td>
                    <?php 
                    if ($product['subcategory_id']) {
                        $subcategory = $this->subcategoryModel->find($product['subcategory_id']);
                        echo esc($subcategory ? $subcategory['subcategory_name'] : 'N/A');
                    } else {
                        echo 'N/A';
                    }
                    ?>
                </td>
                <td>$<?= number_format($product['price'], 2) ?></td>
                <td><?= $product['quantity'] ?></td>
                <td>
                    <span class="status-badge status-<?= $product['status'] ?? 'draft' ?>">
                        <?= ucfirst($product['status'] ?? 'Draft') ?>
                    </span>
                </td>
                <td class="action-btns">
                    <a href="/store/products/edit/<?= $product['id'] ?>" class="btn btn-sm btn-outline-success" title="Edit"><i class="fas fa-edit"></i></a>
                    <a href="/store/products/toggle/<?= $product['id'] ?>" class="btn btn-sm btn-outline-warning" title="<?= $product['status'] === 'published' ? 'Unpublish' : 'Publish' ?>" onclick="return confirm('Toggle product status?')">
                        <i class="fas <?= $product['status'] === 'published' ? 'fa-eye-slash' : 'fa-eye' ?>"></i>
                    </a>
                    <a href="/store/products/delete/<?= $product['id'] ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete this product? This action cannot be undone.')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="8" class="text-center text-muted py-4">
                <i class="fas fa-box-open fa-3x mb-3 d-block"></i>
                No products yet. Click "Add Product" to create your first product.
            </td>
        </tr>
    <?php endif; ?>
</tbody>
                <tbody>
    <?php if (isset($products) && !empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <tr>
                <td>
                    <?php if ($product['product_image']): ?>
                        <img src="/<?= $product['product_image'] ?>" alt="<?= $product['product_name'] ?>" class="product-image-thumb">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/50x50?text=No+Image" alt="No Image" class="product-image-thumb">
                    <?php endif; ?>
                </td>
                <td><strong><?= esc($product['product_name']) ?></strong></td>
                <td>
                    <?php 
                    $categoryName = '';
                    if (isset($categories) && !empty($categories)) {
                        foreach ($categories as $cat) {
                            if ($cat['id'] == $product['category_id']) {
                                $categoryName = $cat['category_name'];
                                break;
                            }
                        }
                    }
                    echo esc($categoryName ?: 'Uncategorized');
                    ?>
                </td>
                <td>$<?= number_format($product['price'], 2) ?></td>
                <td><?= $product['quantity'] ?></td>
                <td>
                    <span class="status-badge status-<?= $product['status'] ?? 'draft' ?>">
                        <?= ucfirst($product['status'] ?? 'Draft') ?>
                    </span>
                </td>
                <td class="action-btns">
                    <a href="/store/products/edit/<?= $product['id'] ?>" class="btn btn-sm btn-outline-success" title="Edit"><i class="fas fa-edit"></i></a>
                    <a href="/store/products/toggle/<?= $product['id'] ?>" class="btn btn-sm btn-outline-warning" title="<?= $product['status'] === 'published' ? 'Unpublish' : 'Publish' ?>" onclick="return confirm('Toggle product status?')">
                        <i class="fas <?= $product['status'] === 'published' ? 'fa-eye-slash' : 'fa-eye' ?>"></i>
                    </a>
                    <a href="/store/products/delete/<?= $product['id'] ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete this product? This action cannot be undone.')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="7" class="text-center text-muted py-4">
                <i class="fas fa-box-open fa-3x mb-3 d-block"></i>
                No products yet. Click "Add Product" to create your first product.
            </td>
        </tr>
    <?php endif; ?>
</tbody>
                </table>
            </div>
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