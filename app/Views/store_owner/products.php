<!-- app/Views/store_owner/products.php -->
<?php
if (!session()->get('tenant_id')) {
    header('Location: /login');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - ShopEase Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            padding-left: 280px;
            padding-top: 80px;
            transition: padding-left 0.3s ease;
            min-height: 100vh;
        }

        .navbar {
            background: #1a2e1a !important;
            padding: 15px 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.3);
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1050;
        }
        .navbar-brand { color: #fff !important; font-weight: bold; font-size: 1.5rem; }
        .navbar-brand i { color: #4caf50; }
        .icon-btn { color: #d4d4d4; font-size: 1.2rem; margin: 0 8px; background: none; border: none; text-decoration: none; }
        .icon-btn:hover { color: #4caf50; }

        .sidebar-wrapper {
            position: fixed;
            top: 80px; left: 0;
            width: 280px;
            height: calc(100vh - 80px);
            overflow-y: auto;
            background: #fff;
            border-right: 1px solid #e8f0e8;
            padding: 20px 15px;
            z-index: 1000;
            transition: width 0.3s ease;
        }
        .sidebar-wrapper::-webkit-scrollbar { width: 4px; }
        .sidebar-wrapper::-webkit-scrollbar-thumb { background: #4caf50; border-radius: 4px; }
        .sidebar-wrapper::-webkit-scrollbar-track { background: #e8f0e8; }

        .sidebar-wrapper.collapsed { width: 70px; }
        .sidebar-wrapper.collapsed .store-name,
        .sidebar-wrapper.collapsed .store-status,
        .sidebar-wrapper.collapsed .sidebar-category { display: none; }
        .sidebar-wrapper.collapsed .sidebar-menu li { padding: 10px; justify-content: center; }
        .sidebar-wrapper.collapsed .sidebar-menu li .menu-text { display: none; }
        .sidebar-wrapper.collapsed .sidebar-menu li i { margin-right: 0; font-size: 1.2rem; }
        .sidebar-wrapper.collapsed .sidebar-menu li { position: relative; }
        .sidebar-wrapper.collapsed .sidebar-menu li:hover::after {
            content: attr(data-tooltip);
            position: absolute; left: 100%; top: 50%; transform: translateY(-50%);
            background: #1a2e1a; color: #fff; padding: 5px 12px; border-radius: 6px;
            font-size: 0.8rem; white-space: nowrap; z-index: 999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2); margin-left: 8px;
        }
        .sidebar-wrapper.collapsed .store-avatar { width: 45px; height: 45px; font-size: 1.2rem; }

        body.sidebar-collapsed { padding-left: 70px; }

        .sidebar-card .store-avatar {
            width: 70px; height: 70px; border-radius: 50%;
            background: #4caf50; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; margin: 0 auto 10px;
            transition: all 0.3s ease;
        }
        .sidebar-card .store-name { text-align: center; font-weight: 700; color: #1a2e1a; font-size: 1rem; }
        .sidebar-card .store-status { text-align: center; font-size: 0.8rem; }

        .toggle-sidebar-btn {
            background: #4caf50; color: #fff; border: none; border-radius: 8px;
            padding: 8px 12px; font-size: 1rem; cursor: pointer; width: 100%;
            margin-bottom: 10px; display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .toggle-sidebar-btn:hover { background: #388e3c; }

        .sidebar-category {
            font-size: 0.65rem; font-weight: 700; color: #aaa;
            text-transform: uppercase; letter-spacing: 0.5px;
            padding: 15px 10px 5px; border-top: 1px solid #f0f0f0; margin-top: 5px;
        }
        .sidebar-category:first-child { border-top: none; margin-top: 0; padding-top: 5px; }

        .sidebar-menu { list-style: none; padding: 0; margin: 0; }
        .sidebar-menu li {
            padding: 10px 12px; border-radius: 8px; cursor: pointer;
            color: #555; font-size: 0.9rem; display: flex; align-items: center;
            transition: all 0.3s ease;
        }
        .sidebar-menu li:hover { background: #f0f8f0; color: #4caf50; }
        .sidebar-menu li.active { background: #f0f8f0; color: #4caf50; font-weight: 600; }
        .sidebar-menu li i { margin-right: 12px; width: 20px; text-align: center; font-size: 1rem; }
        .sidebar-menu li .menu-text { flex: 1; }
        .sidebar-menu li a { color: inherit; text-decoration: none; display: flex; align-items: center; width: 100%; }

        .page-header {
            background: #f8f9fa; color: #1a2e1a; padding: 20px 0;
            border-bottom: 1px solid #e8f0e8;
        }
        .page-header h2 { font-weight: 700; color: #1a2e1a; }
        .page-header .breadcrumb { background: none; padding: 0; margin: 0; }
        .page-header .breadcrumb a { color: #4caf50; text-decoration: none; }

        .main-content { padding: 20px 30px; }

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

        @media (max-width: 992px) {
            body { padding-left: 0; }
            .sidebar-wrapper { position: relative; top: 0; width: 100%; height: auto; border-right: none; border-bottom: 1px solid #e8f0e8; }
            .sidebar-wrapper.collapsed { width: 100%; }
            .sidebar-wrapper.collapsed .sidebar-menu li { justify-content: flex-start; }
            .sidebar-wrapper.collapsed .sidebar-menu li .menu-text { display: inline; }
            .sidebar-wrapper.collapsed .sidebar-menu li i { margin-right: 12px; }
            .sidebar-wrapper.collapsed .store-name,
            .sidebar-wrapper.collapsed .store-status,
            .sidebar-wrapper.collapsed .sidebar-category { display: block; }
            body.sidebar-collapsed { padding-left: 0; }
            .main-content { padding: 15px; }
        }
    </style>
</head>
<body id="mainBody">

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="fas fa-store"></i> ShopEase</a>
        <div class="d-flex align-items-center ms-auto">
            <span class="text-white me-3 d-none d-md-inline">Store: <?= session()->get('store_name') ?? 'Store' ?></span>
            <a href="/logout" class="icon-btn"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </div>
</nav>

<div class="sidebar-wrapper" id="sidebarWrapper">
    <div class="sidebar-card">
        <button class="toggle-sidebar-btn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
            <span id="toggleText">Collapse</span>
        </button>

        <div class="store-avatar"><i class="fas fa-store"></i></div>
        <div class="store-name"><?= session()->get('store_name') ?? 'Store' ?></div>
        <div class="store-status"><span class="badge bg-success">Active</span></div>

        <div class="sidebar-category">Management</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/store/dashboard'" data-tooltip="Dashboard">
                <i class="fas fa-tachometer-alt"></i>
                <span class="menu-text">Dashboard</span>
            </li>
            <li class="active" onclick="location.href='/store/products'" data-tooltip="Products">
                <i class="fas fa-box"></i>
                <span class="menu-text">Products</span>
            </li>
            <li onclick="location.href='/store/subcategories'" data-tooltip="Subcategories">
                <i class="fas fa-tags"></i>
                <span class="menu-text">Subcategories</span>
            </li>
            <li onclick="location.href='/store/orders'" data-tooltip="Orders">
                <i class="fas fa-shopping-bag"></i>
                <span class="menu-text">Orders</span>
            </li>
        </ul>

        <div class="sidebar-category">Finance & Earnings</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/store/dashboard#reports'" data-tooltip="Reports">
                <i class="fas fa-chart-line"></i>
                <span class="menu-text">Reports</span>
            </li>
        </ul>

        <div class="sidebar-category">Services</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/store/dashboard#settings'" data-tooltip="Settings">
                <i class="fas fa-store-alt"></i>
                <span class="menu-text">Store Settings</span>
            </li>
            <li>
                <a href="/logout" data-tooltip="Logout">
                    <i class="fas fa-sign-out-alt text-danger"></i>
                    <span class="menu-text">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<section class="page-header">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2><i class="fas fa-boxes me-2 text-success"></i>Products</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2">/</span>
                    <a href="/store/dashboard">Dashboard</a>
                    <span class="mx-2">/</span>
                    <span class="text-muted">Products</span>
                </nav>
            </div>
            <a href="/store/products/create" class="btn-add"><i class="fas fa-plus me-2"></i>Add Product</a>
        </div>
    </div>
</section>

<section class="main-content">
    <div class="container-fluid px-4">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        var wrapper = document.getElementById('sidebarWrapper');
        var body = document.getElementById('mainBody');
        var toggleText = document.getElementById('toggleText');
        wrapper.classList.toggle('collapsed');
        body.classList.toggle('sidebar-collapsed');
        toggleText.textContent = wrapper.classList.contains('collapsed') ? 'Expand' : 'Collapse';
    }
</script>
</body>
</html>