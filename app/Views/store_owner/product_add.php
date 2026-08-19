<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - ShopEase</title>
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
        .form-card { background: #fff; border-radius: 12px; padding: 30px; border: 1px solid #e8f0e8; max-width: 700px; margin: 0 auto; }
        .form-card label { font-weight: 600; color: #1a2e1a; }
        .form-card .form-control { border-radius: 8px; border: 2px solid #e8f0e8; padding: 10px 15px; }
        .form-card .form-control:focus { border-color: #4caf50; box-shadow: none; }
        .btn-save { background: #4caf50; color: #fff; border: none; border-radius: 30px; padding: 12px 40px; font-weight: 600; transition: 0.3s; }
        .btn-save:hover { background: #388e3c; color: #fff; }
        .btn-cancel { background: #6c757d; color: #fff; border: none; border-radius: 30px; padding: 12px 40px; font-weight: 600; transition: 0.3s; text-decoration: none; display: inline-block; }
        .btn-cancel:hover { background: #5a6268; color: #fff; }
        .footer { background: #1a2e1a; color: #d4d4d4; padding: 40px 0 20px; margin-top: 40px; }
        .footer h5 { color: #fff; font-weight: 600; }
        .footer a { color: #aaa; text-decoration: none; transition: 0.3s; }
        .footer a:hover { color: #4caf50; }
        .required { color: #dc3545; }
        .preview-image { max-width: 150px; max-height: 150px; border-radius: 8px; border: 1px solid #e8f0e8; padding: 5px; }
        .subcategory-field { margin-top: 5px; }
        .text-muted a { color: #4caf50; text-decoration: none; }
        .text-muted a:hover { text-decoration: underline; }
        .alert ul { margin-bottom: 0; padding-left: 20px; }
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
                <li class="nav-item"><a class="nav-link" href="/store/products">Products</a></li>
                <li class="nav-item"><a class="nav-link active" href="#">Add Product</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">Store: <?= session()->get('store_name') ?? 'Store' ?></span>
                <a href="/logout" class="icon-btn" style="color:#d4d4d4;text-decoration:none;"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </div>
</nav>

<section class="page-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-plus-circle me-2"></i>Add Product</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2 text-white-50">/</span>
                    <a href="/store/dashboard">Dashboard</a>
                    <span class="mx-2 text-white-50">/</span>
                    <a href="/store/products">Products</a>
                    <span class="mx-2 text-white-50">/</span>
                    <span class="active">Add Product</span>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="py-4">
    <div class="container">
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <?php if (is_array(session()->getFlashdata('errors'))): ?>
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="mb-0"><?= session()->getFlashdata('errors') ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <div class="form-card">
            <form action="/store/products" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label>Product Name <span class="required">*</span></label>
                    <input type="text" name="product_name" class="form-control" placeholder="Enter product name" value="<?= old('product_name') ?>" required>
                </div>
                
                <div class="mb-3">
                    <label>Category <span class="required">*</span></label>
                    <select name="category_id" id="categorySelect" class="form-control" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" <?= old('category_id') == $category['id'] ? 'selected' : '' ?>>
                                <?= esc($category['category_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- ✅ FIXED: No $product reference here -->
                <div class="mb-3 subcategory-field">
                    <label>Subcategory</label>
                    <select name="subcategory_id" id="subcategorySelect" class="form-control">
                        <option value="">Select Subcategory</option>
                        <?php if (isset($subcategories) && !empty($subcategories)): ?>
                            <?php foreach ($subcategories as $sub): ?>
                                <option value="<?= $sub['id'] ?>" data-category-id="<?= $sub['category_id'] ?>" <?= old('subcategory_id') == $sub['id'] ? 'selected' : '' ?>>
                                    <?= esc($sub['subcategory_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">No subcategories available</option>
                        <?php endif; ?>
                    </select>
                    <small class="text-muted">
                        <a href="/store/subcategories/create">+ Add new subcategory</a> 
                        (Select a category first to filter subcategories)
                    </small>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Price <span class="required">*</span></label>
                        <input type="number" step="0.01" name="price" class="form-control" placeholder="0.00" value="<?= old('price') ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Old Price (Optional)</label>
                        <input type="number" step="0.01" name="old_price" class="form-control" placeholder="0.00" value="<?= old('old_price') ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Quantity / Stock <span class="required">*</span></label>
                        <input type="number" name="quantity" class="form-control" placeholder="0" value="<?= old('quantity') ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="draft" <?= old('status') == 'draft' ? 'selected' : '' ?>>Draft</option>
                            <option value="published" <?= old('status') == 'published' ? 'selected' : '' ?>>Published</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Product Description</label>
                    <textarea name="product_description" class="form-control" rows="4" placeholder="Describe your product..."><?= old('product_description') ?></textarea>
                </div>

                <div class="mb-3">
                    <label>Product Image</label>
                    <input type="file" name="product_image" class="form-control" accept="image/*" onchange="previewImage(this)">
                    <small class="text-muted">Accepted formats: JPG, PNG, GIF (Max 2MB)</small>
                    <div class="mt-2">
                        <img id="imagePreview" class="preview-image" style="display:none;">
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn-save"><i class="fas fa-save me-2"></i>Save Product</button>
                    <a href="/store/products" class="btn-cancel"><i class="fas fa-times me-2"></i>Cancel</a>
                </div>
            </form>
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

    function previewImage(input) {
        var preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
        }
    }

    // Dynamic subcategories based on selected category
    document.addEventListener('DOMContentLoaded', function() {
        var categorySelect = document.getElementById('categorySelect');
        var subcategorySelect = document.getElementById('subcategorySelect');
        
        // Store all original subcategory options
        var allOptions = [];
        var defaultOption = null;
        
        subcategorySelect.querySelectorAll('option').forEach(function(opt) {
            if (opt.value === '') {
                defaultOption = opt.cloneNode(true);
            } else {
                allOptions.push(opt.cloneNode(true));
            }
        });

        function updateSubcategories() {
            var selectedCategory = categorySelect.value;
            
            // Clear subcategory select
            subcategorySelect.innerHTML = '';
            
            // Add default option
            if (defaultOption) {
                subcategorySelect.appendChild(defaultOption.cloneNode(true));
            } else {
                var defaultOpt = document.createElement('option');
                defaultOpt.value = '';
                defaultOpt.textContent = 'Select Subcategory';
                subcategorySelect.appendChild(defaultOpt);
            }
            
            // If no category selected, show a message
            if (selectedCategory === '') {
                var msgOpt = document.createElement('option');
                msgOpt.value = '';
                msgOpt.textContent = '-- Select a category first --';
                subcategorySelect.appendChild(msgOpt);
                return;
            }
            
            // Filter subcategories by selected category
            var hasSubcategories = false;
            allOptions.forEach(function(option) {
                var categoryId = option.getAttribute('data-category-id');
                if (categoryId == selectedCategory) {
                    var newOption = option.cloneNode(true);
                    subcategorySelect.appendChild(newOption);
                    hasSubcategories = true;
                }
            });
            
            // If no subcategories found for this category
            if (!hasSubcategories) {
                var msgOpt = document.createElement('option');
                msgOpt.value = '';
                msgOpt.textContent = '-- No subcategories available --';
                subcategorySelect.appendChild(msgOpt);
            }
        }

        categorySelect.addEventListener('change', updateSubcategories);
        updateSubcategories();
    });
</script>
</body>
</html>