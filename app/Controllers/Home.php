<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $productModel = new \App\Models\ProductModel();
        $products = $productModel->getPublishedProducts();

        $featuredProducts = array_slice($products, 0, 6);

        $formattedProducts = [];

        $categoryModel = new \App\Models\CategoryModel();

        foreach ($featuredProducts as $product) {
            $category = $categoryModel->find($product['category_id']);

            $badges = [];

            if (!empty($product['old_price']) && $product['old_price'] > $product['price']) {
                $badges[] = 'Sale';
            }

            if (empty($badges)) {
                $badges[] = 'New';
            }

            $formattedProducts[] = [
                'id' => $product['id'],
                'name' => $product['product_name'],
                'slug' => strtolower(str_replace(' ', '-', $product['product_name'])),
                'price' => $product['price'],
                'old_price' => $product['old_price'] ?? null,
                'category' => $category ? $category['category_name'] : 'General',
                'image' => $product['product_image'] ?? 'https://via.placeholder.com/200x200?text=Product',
                'badges' => $badges,
                'in_stock' => ($product['quantity'] ?? 0) > 0,
            ];
        }

        return $this->view('public/home', [
            'featuredProducts' => $formattedProducts
        ]);
    }


    public function products()
    {
        $allProducts = [
            'wireless-earbuds' => [
                'name' => 'Wireless Earbuds',
                'slug' => 'wireless-earbuds',
                'price' => 89.99,
                'old_price' => 129.99,
                'category' => 'Electronics',
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=200&h=200&fit=crop',
                'badges' => ['New', 'Sale']
            ],

            'smartwatch-pro' => [
                'name' => 'Smartwatch Pro',
                'slug' => 'smartwatch-pro',
                'price' => 199.00,
                'old_price' => 249.00,
                'category' => 'Electronics',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200&h=200&fit=crop',
                'badges' => ['New', 'Sale']
            ],

            'bluetooth-speaker' => [
                'name' => 'Bluetooth Speaker',
                'slug' => 'bluetooth-speaker',
                'price' => 129.00,
                'old_price' => 179.00,
                'category' => 'Electronics',
                'image' => 'https://images.unsplash.com/photo-1545454675-3531b543be5d?w=200&h=200&fit=crop',
                'badges' => ['New', 'Sale']
            ],

            'gaming-mouse' => [
                'name' => 'Gaming Mouse',
                'slug' => 'gaming-mouse',
                'price' => 49.99,
                'old_price' => 89.99,
                'category' => 'Electronics',
                'image' => 'https://images.unsplash.com/photo-1527814050087-3793815479db?w=200&h=200&fit=crop',
                'badges' => ['New']
            ],

            'ultrabook-pro' => [
                'name' => 'Ultrabook Pro',
                'slug' => 'ultrabook-pro',
                'price' => 899.99,
                'old_price' => 1099.00,
                'category' => 'Electronics',
                'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=200&h=200&fit=crop',
                'badges' => ['Sale']
            ],

            'tablet-10' => [
                'name' => 'Tablet 10"',
                'slug' => 'tablet-10',
                'price' => 299.99,
                'old_price' => 399.99,
                'category' => 'Electronics',
                'image' => 'https://images.unsplash.com/photo-1561154464-82e9adf32764?w=200&h=200&fit=crop',
                'badges' => ['New']
            ],

            'blue-jeans' => [
                'name' => 'Blue Jeans',
                'slug' => 'blue-jeans',
                'price' => 49.99,
                'old_price' => null,
                'category' => 'Fashion',
                'image' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?w=200&h=200&fit=crop',
                'badges' => ['New']
            ],

            'leather-jacket' => [
                'name' => 'Leather Jacket',
                'slug' => 'leather-jacket',
                'price' => 149.99,
                'old_price' => 199.99,
                'category' => 'Fashion',
                'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=200&h=200&fit=crop',
                'badges' => ['Sale']
            ],

            'sneakers' => [
                'name' => 'Running Sneakers',
                'slug' => 'sneakers',
                'price' => 79.99,
                'old_price' => null,
                'category' => 'Fashion',
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=200&h=200&fit=crop',
                'badges' => ['New']
            ],

            'sofa' => [
                'name' => 'Modern Sofa',
                'slug' => 'sofa',
                'price' => 599.99,
                'old_price' => null,
                'category' => 'Home & Living',
                'image' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=200&h=200&fit=crop',
                'badges' => ['New']
            ],

            'lamp' => [
                'name' => 'Table Lamp',
                'slug' => 'lamp',
                'price' => 39.99,
                'old_price' => 59.99,
                'category' => 'Home & Living',
                'image' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=200&h=200&fit=crop',
                'badges' => ['Sale']
            ],

            'skincare-set' => [
                'name' => 'Skincare Set',
                'slug' => 'skincare-set',
                'price' => 89.99,
                'old_price' => null,
                'category' => 'Beauty',
                'image' => 'https://images.unsplash.com/photo-1556228578-8c89e6adf883?w=200&h=200&fit=crop',
                'badges' => ['New']
            ],

            'yoga-mat' => [
                'name' => 'Yoga Mat',
                'slug' => 'yoga-mat',
                'price' => 29.99,
                'old_price' => null,
                'category' => 'Sports',
                'image' => 'https://images.unsplash.com/photo-1592432678016-e910b452f9a2?w=200&h=200&fit=crop',
                'badges' => ['New']
            ],

            'dumbbells' => [
                'name' => 'Dumbbell Set',
                'slug' => 'dumbbells',
                'price' => 49.99,
                'old_price' => 69.99,
                'category' => 'Sports',
                'image' => 'https://images.unsplash.com/photo-1586401100295-7a8096fd231a?w=200&h=200&fit=crop',
                'badges' => ['Sale']
            ],

            'fitness-band' => [
                'name' => 'Fitness Band',
                'slug' => 'fitness-band',
                'price' => 39.99,
                'old_price' => null,
                'category' => 'Sports',
                'image' => 'https://images.unsplash.com/photo-1576243345690-4e4b79b63288?w=200&h=200&fit=crop',
                'badges' => ['New']
            ]
        ];

        return $this->view('public/products', [
            'products' => $allProducts
        ]);
    }


    public function categories($category = null)
    {
        $allProducts = [
            'wireless-earbuds' => [
                'name' => 'Wireless Earbuds Pro',
                'slug' => 'wireless-earbuds',
                'price' => 89.99,
                'category' => 'Electronics',
                'category_slug' => 'electronics',
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=200&h=200&fit=crop',
            ],

            'smartwatch-pro' => [
                'name' => 'Smartwatch Pro',
                'slug' => 'smartwatch-pro',
                'price' => 199.00,
                'category' => 'Electronics',
                'category_slug' => 'electronics',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200&h=200&fit=crop',
            ],

            'bluetooth-speaker' => [
                'name' => 'Bluetooth Speaker',
                'slug' => 'bluetooth-speaker',
                'price' => 129.00,
                'category' => 'Electronics',
                'category_slug' => 'electronics',
                'image' => 'https://images.unsplash.com/photo-1545454675-3531b543be5d?w=200&h=200&fit=crop',
            ],

            'gaming-mouse' => [
                'name' => 'Gaming Mouse',
                'slug' => 'gaming-mouse',
                'price' => 49.99,
                'category' => 'Electronics',
                'category_slug' => 'electronics',
                'image' => 'https://images.unsplash.com/photo-1527814050087-3793815479db?w=200&h=200&fit=crop',
            ],

            'ultrabook-pro' => [
                'name' => 'Ultrabook Pro',
                'slug' => 'ultrabook-pro',
                'price' => 899.99,
                'category' => 'Electronics',
                'category_slug' => 'electronics',
                'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=200&h=200&fit=crop',
            ],

            'tablet-10' => [
                'name' => 'Tablet 10"',
                'slug' => 'tablet-10',
                'price' => 299.99,
                'category' => 'Electronics',
                'category_slug' => 'electronics',
                'image' => 'https://images.unsplash.com/photo-1561154464-82e9adf32764?w=200&h=200&fit=crop',
            ],

            'blue-jeans' => [
                'name' => 'Blue Jeans',
                'slug' => 'blue-jeans',
                'price' => 49.99,
                'category' => 'Fashion',
                'category_slug' => 'fashion',
                'image' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?w=200&h=200&fit=crop',
            ],

            'leather-jacket' => [
                'name' => 'Leather Jacket',
                'slug' => 'leather-jacket',
                'price' => 149.99,
                'category' => 'Fashion',
                'category_slug' => 'fashion',
                'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=200&h=200&fit=crop',
            ],

            'sneakers' => [
                'name' => 'Running Sneakers',
                'slug' => 'sneakers',
                'price' => 79.99,
                'category' => 'Fashion',
                'category_slug' => 'fashion',
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=200&h=200&fit=crop',
            ],

            'sofa' => [
                'name' => 'Modern Sofa',
                'slug' => 'sofa',
                'price' => 599.99,
                'category' => 'Home & Living',
                'category_slug' => 'home-living',
                'image' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=200&h=200&fit=crop',
            ],

            'lamp' => [
                'name' => 'Table Lamp',
                'slug' => 'lamp',
                'price' => 39.99,
                'category' => 'Home & Living',
                'category_slug' => 'home-living',
                'image' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=200&h=200&fit=crop',
            ],

            'skincare-set' => [
                'name' => 'Skincare Set',
                'slug' => 'skincare-set',
                'price' => 89.99,
                'category' => 'Beauty',
                'category_slug' => 'beauty',
                'image' => 'https://images.unsplash.com/photo-1556228578-8c89e6adf883?w=200&h=200&fit=crop',
            ],

            'yoga-mat' => [
                'name' => 'Yoga Mat',
                'slug' => 'yoga-mat',
                'price' => 29.99,
                'category' => 'Sports',
                'category_slug' => 'sports',
                'image' => 'https://images.unsplash.com/photo-1592432678016-e910b452f9a2?w=200&h=200&fit=crop',
            ],

            'dumbbells' => [
                'name' => 'Dumbbell Set',
                'slug' => 'dumbbells',
                'price' => 49.99,
                'category' => 'Sports',
                'category_slug' => 'sports',
                'image' => 'https://images.unsplash.com/photo-1586401100295-7a8096fd231a?w=200&h=200&fit=crop',
            ],

            'fitness-band' => [
                'name' => 'Fitness Band',
                'slug' => 'fitness-band',
                'price' => 39.99,
                'category' => 'Sports',
                'category_slug' => 'sports',
                'image' => 'https://images.unsplash.com/photo-1576243345690-4e4b79b63288?w=200&h=200&fit=crop',
            ]
        ];

        $categoryList = [];

        foreach ($allProducts as $product) {
            $categoryList[$product['category_slug']] = $product['category'];
        }

        if ($category && isset($categoryList[$category])) {

            $categoryName = $categoryList[$category];

            $products = array_filter(
                $allProducts,
                function ($product) use ($category) {
                    return $product['category_slug'] === $category;
                }
            );

            $selectedCategory = $categoryName;
            $selectedSlug = $category;

        } else {

            $products = $allProducts;
            $selectedCategory = 'All';
            $selectedSlug = 'all';
        }

        return $this->view('public/categories', [
            'products' => $products,
            'categories' => $categoryList,
            'selectedCategory' => $selectedCategory,
            'selectedSlug' => $selectedSlug
        ]);
    }


    public function cart()
    {
        return $this->view('public/cart');
    }


    public function checkout()
    {
        return $this->view('public/checkout');
    }


    public function orderConfirmation()
    {
        return $this->view('public/order_confirmation');
    }


    public function login()
    {
        return $this->view('public/login');
    }


    public function register()
    {
        return $this->view('public/register');
    }


    public function dashboard()
    {
        if (!$this->isLoggedIn()) {
            return $this->redirectWithMessage(
                '/login',
                'Please login to access your dashboard.',
                'error'
            );
        }

        if (!$this->isCustomer()) {
            return $this->redirectWithMessage(
                '/' . $this->getUserRole() . '/dashboard',
                'You do not have permission to access this page.',
                'error'
            );
        }

        return $this->view('public/dashboard');
    }


    /*
    |--------------------------------------------------------------------------
    | Store / Subcategory
    |--------------------------------------------------------------------------
    */

    public function store()
    {
        $tenantId = $this->getTenantId();

        if (!$tenantId) {
            return $this->redirectWithMessage(
                '/login',
                'Please login.',
                'error'
            );
        }

        $rules = [
            'category_id' => 'required|numeric',
            'subcategory_name' => 'required|min_length[2]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $subcategoryModel = new \App\Models\SubcategoryModel();

        $existing = $subcategoryModel
            ->where('category_id', $this->request->getPost('category_id'))
            ->where('tenant_id', $tenantId)
            ->where(
                'subcategory_name',
                $this->request->getPost('subcategory_name')
            )
            ->first();

        if ($existing) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'This subcategory already exists for your store.'
                );
        }

        $data = [
            'category_id' => $this->request->getPost('category_id'),
            'tenant_id' => $tenantId,
            'subcategory_name' => $this->request->getPost('subcategory_name'),
            'is_active' => $this->request->getPost('is_active') ? true : false,
        ];

        if ($subcategoryModel->insert($data)) {
            return redirect()
                ->to('/store/subcategories')
                ->with(
                    'success',
                    'Subcategory created successfully!'
                );
        }

        return redirect()
            ->back()
            ->with('error', 'Failed to create subcategory.');
    }


    /*
    |--------------------------------------------------------------------------
    | Toggle Subcategory Status
    |--------------------------------------------------------------------------
    */

    public function toggleStatus($id)
    {
        $tenantId = $this->getTenantId();

        if (!$tenantId) {
            return $this->redirectWithMessage(
                '/login',
                'Please login.',
                'error'
            );
        }

        $subcategoryModel = new \App\Models\SubcategoryModel();

        $subcategory = $subcategoryModel
            ->where('tenant_id', $tenantId)
            ->find($id);

        if (!$subcategory) {
            return redirect()
                ->to('/store/subcategories')
                ->with('error', 'Subcategory not found.');
        }

        $newStatus = !((bool) $subcategory['is_active']);

        $subcategoryModel->update($id, [
            'is_active' => $newStatus
        ]);

        $statusText = $newStatus
            ? 'activated'
            : 'deactivated';

        return redirect()
            ->to('/store/subcategories')
            ->with(
                'success',
                "Subcategory {$statusText} successfully."
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Store Owner Dashboard
    |--------------------------------------------------------------------------
    */

    public function storeDashboard()
    {
        if (!$this->isLoggedIn()) {
            return $this->redirectWithMessage(
                '/login',
                'Please login to access your store dashboard.',
                'error'
            );
        }

        if ($this->getUserRole() !== 'store_owner') {
            return $this->redirectWithMessage(
                '/dashboard',
                'You do not have permission to access this page.',
                'error'
            );
        }

        $tenantId = $this->getTenantId();

        if (!$tenantId) {
            return $this->redirectWithMessage(
                '/login',
                'Store information not found.',
                'error'
            );
        }

        $tenantModel = new \App\Models\TenantModel();
        $productModel = new \App\Models\ProductModel();
        $orderModel = new \App\Models\OrderModel();

        $tenant = $tenantModel->find($tenantId);

        $products = $productModel
            ->where('tenant_id', $tenantId)
            ->findAll();

        $totalProducts = count($products);

        $publishedProducts = $productModel
            ->where('tenant_id', $tenantId)
            ->where('status', 'published')
            ->countAllResults();

        $totalOrders = $orderModel
            ->where('tenant_id', $tenantId)
            ->countAllResults();

        $pendingOrders = $orderModel
            ->where('tenant_id', $tenantId)
            ->where('order_status', 'pending')
            ->countAllResults();

        $revenue = $orderModel->getRevenueByPeriod(
            $tenantId,
            'all'
        );
        $todaySales = $orderModel->getRevenueByPeriod($tenantId, 'today');
$weekSales = $orderModel->getRevenueByPeriod($tenantId, 'week');
$monthSales = $orderModel->getRevenueByPeriod($tenantId, 'month');

        $recentOrders = $orderModel->getOrdersByTenant(
            $tenantId
        );

        $recentOrders = array_slice(
            $recentOrders,
            0,
            5
        );

        $bestSellers = $productModel->getBestSellingProducts(
            $tenantId,
            5
        );

        return $this->view(
            'store_owner/dashboard',
            [
                'tenant' => $tenant,
                'products' => $products,
                'totalProducts' => $totalProducts,
                'publishedProducts' => $publishedProducts,
                'totalOrders' => $totalOrders,
                'pendingOrders' => $pendingOrders,
                'revenue' => $revenue,
                'recentOrders' => $recentOrders,
                'bestSellers' => $bestSellers,
                'todaySales' => $todaySales,
                'weekSales' => $weekSales,
                'monthSales' => $monthSales,
            ]
        );
    }
    public function updateStoreSettings()
{
    $tenantId = $this->getTenantId();

    if (!$tenantId) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Please login.'
        ]);
    }

    $storeName = $this->request->getPost('store_name');
    $storeDescription = $this->request->getPost('store_description');
    $contactEmail = $this->request->getPost('contact_email');
    $contactPhone = $this->request->getPost('contact_phone');
    $storeAddress = $this->request->getPost('store_address');

    if (!$storeName || !$contactEmail) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Store name and contact email are required.'
        ]);
    }

    $tenantModel = new \App\Models\TenantModel();

    $tenantModel->update($tenantId, [
        'store_name' => $storeName,
        'store_description' => $storeDescription,
        'contact_email' => $contactEmail,
        'contact_phone' => $contactPhone,
        'store_address' => $storeAddress,
    ]);

    // Keep the store owner's own record and session in sync
    $systemUserModel = new \App\Models\SystemUserModel();
    $owner = $systemUserModel->where('tenant_id', $tenantId)
                              ->where('role', 'store_owner')
                              ->first();
    if ($owner) {
        $systemUserModel->update($owner['id'], ['store_name' => $storeName]);
    }
    session()->set('store_name', $storeName);

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Store settings updated successfully!'
    ]);
}

public function changeStoreOwnerPassword()
{
    $tenantId = $this->getTenantId();
    $userId = session()->get('user_id');

    if (!$tenantId || !$userId) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Please login.'
        ]);
    }

    $currentPassword = $this->request->getPost('current_password');
    $newPassword = $this->request->getPost('new_password');

    if (!$currentPassword || !$newPassword) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Both current and new password are required.'
        ]);
    }

    if (strlen($newPassword) < 8) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'New password must be at least 8 characters.'
        ]);
    }

    $systemUserModel = new \App\Models\SystemUserModel();
    $user = $systemUserModel->find($userId);

    if (!$user) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Account not found.'
        ]);
    }

    if (!password_verify($currentPassword, $user['password'])) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Current password is incorrect.'
        ]);
    }

    $systemUserModel->update($userId, [
        'password' => password_hash($newPassword, PASSWORD_DEFAULT),
    ]);

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Password updated successfully!'
    ]);
}


    /*
    |--------------------------------------------------------------------------
    | Super Admin Dashboard
    |--------------------------------------------------------------------------
    */

    public function adminDashboard()
    {
        if (!$this->isLoggedIn()) {
            return $this->redirectWithMessage(
                '/login',
                'Please login to access the admin dashboard.',
                'error'
            );
        }

        if ($this->getUserRole() !== 'super_admin') {
            return $this->redirectWithMessage(
                '/dashboard',
                'You do not have permission to access this page.',
                'error'
            );
        }

        return $this->view('admin/dashboard');
    }


    /*
    |--------------------------------------------------------------------------
    | Static Pages
    |--------------------------------------------------------------------------
    */

    public function contact()
    {
        return $this->view('public/contact');
    }

    public function track()
    {
        return $this->view('public/track');
    }

    public function terms()
    {
        return $this->view('public/terms');
    }

    public function about()
    {
        return $this->view('public/about');
    }

    public function privacy()
    {
        return $this->view('public/privacy');
    }

    public function help()
    {
        return $this->view('public/help');
    }

    public function returns()
    {
        return $this->view('public/returns');
    }

    public function shipping()
    {
        return $this->view('public/shipping');
    }


    /*
    |--------------------------------------------------------------------------
    | Product Details
    |--------------------------------------------------------------------------
    */

    public function productDetails($slug = null)
    {
        if ($slug === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        /*
         * IMPORTANT:
         * Keep your existing $allProducts array here.
         *
         * I am not changing your 15 product records.
         */

        $allProducts = [
            // YOUR EXISTING 15 PRODUCT RECORDS GO HERE
        ];

        if (!isset($allProducts[$slug])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $product = $allProducts[$slug];

        return $this->view(
            'public/product_details',
            [
                'product' => $product
            ]
        );
    }
}