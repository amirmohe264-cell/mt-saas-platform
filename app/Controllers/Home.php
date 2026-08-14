<?php

namespace App\Controllers;

class Home extends BaseController
{
public function index()
{
    $productModel = new \App\Models\ProductModel();
    $products = $productModel->getPublishedProducts();
    
    // Get only first 6 products for featured section
    $featuredProducts = array_slice($products, 0, 6);
    
    // Format products for the view
    $formattedProducts = [];
    foreach ($featuredProducts as $product) {
        $categoryModel = new \App\Models\CategoryModel();
        $category = $categoryModel->find($product['category_id']);
        
        // Get badges
        $badges = [];
        if ($product['old_price'] && $product['old_price'] > $product['price']) {
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
            'in_stock' => $product['quantity'] > 0,
        ];
    }
    
    return view('public/home', ['featuredProducts' => $formattedProducts]);
}

  public function products()
{
    // All 15 products data for the products page
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

    return view('public/products', ['products' => $allProducts]);
}

    public function categories($category = null)
    {
        // All 15 products with categories
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
            ],
        ];

        // Get unique categories for the sidebar with their slugs
        $categoryList = [];
        foreach ($allProducts as $product) {
            $categoryList[$product['category_slug']] = $product['category'];
        }

        // Handle category parameter
        if ($category) {
            // Check if category slug exists
            if (isset($categoryList[$category])) {
                $categoryName = $categoryList[$category];
                // Filter products by category slug
                $products = array_filter($allProducts, function($product) use ($category) {
                    return $product['category_slug'] === $category;
                });
                $selectedCategory = $categoryName;
                $selectedSlug = $category;
            } else {
                // If category not found, show all
                $products = $allProducts;
                $selectedCategory = 'All';
                $selectedSlug = 'all';
            }
        } else {
            $products = $allProducts;
            $selectedCategory = 'All';
            $selectedSlug = 'all';
        }

        return view('public/categories', [
            'products' => $products,
            'categories' => $categoryList,
            'selectedCategory' => $selectedCategory,
            'selectedSlug' => $selectedSlug ?? 'all',
        ]);
    }

    public function cart()
    {
        return view('public/cart');
    }

    public function checkout()
    {
        return view('public/checkout');
    }

    public function orderConfirmation()
    {
        return view('public/order_confirmation');
    }

    public function login()
    {
        return view('public/login');
    }

    public function register()
    {
        return view('public/register');
    }

  public function dashboard()
{
    // Check if user is logged in
    if (!session()->get('is_logged_in')) {
        return redirect()->to('/login')->with('error', 'Please login to access your dashboard.');
    }
    return view('public/dashboard');
}

public function storeDashboard()
{
    // Check if user is logged in as store owner
    if (!session()->get('is_logged_in')) {
        return redirect()->to('/login')->with('error', 'Please login to access your store dashboard.');
    }
    
    if (session()->get('role') !== 'store_owner') {
        return redirect()->to('/dashboard')->with('error', 'You do not have permission to access this page.');
    }
    
    $tenantId = session()->get('tenant_id');
    
    // Get store data
    $tenantModel = new \App\Models\TenantModel();
    $tenant = $tenantModel->find($tenantId);
    
    // Get products
    $productModel = new \App\Models\ProductModel();
    $products = $productModel->where('tenant_id', $tenantId)->findAll();
    $totalProducts = count($products);
    $publishedProducts = $productModel->where('tenant_id', $tenantId)->where('status', 'published')->countAllResults();
    
    // Get order counts
    $orderModel = new \App\Models\OrderModel();
    $totalOrders = $orderModel->where('tenant_id', $tenantId)->countAllResults();
    $pendingOrders = $orderModel->where('tenant_id', $tenantId)->where('order_status', 'pending')->countAllResults();
    
    // Get revenue
    $revenue = $orderModel->getRevenueByPeriod($tenantId, 'all');
    
    // Get recent orders
    $recentOrders = $orderModel->getOrdersByTenant($tenantId);
    $recentOrders = array_slice($recentOrders, 0, 5);
    
    // Get best selling products
    $bestSellers = $productModel->getBestSellingProducts($tenantId, 5);
    
    return view('store_owner/dashboard', [
        'tenant' => $tenant,
        'products' => $products,
        'totalProducts' => $totalProducts,
        'publishedProducts' => $publishedProducts,
        'totalOrders' => $totalOrders,
        'pendingOrders' => $pendingOrders,
        'revenue' => $revenue,
        'recentOrders' => $recentOrders,
        'bestSellers' => $bestSellers,
    ]);
}

   public function adminDashboard()
{
    // Check if user is logged in as super admin
    if (!session()->get('is_logged_in')) {
        return redirect()->to('/login')->with('error', 'Please login to access the admin dashboard.');
    }
    
    // Check if user has super_admin role
    if (session()->get('role') !== 'super_admin') {
        return redirect()->to('/dashboard')->with('error', 'You do not have permission to access this page.');
    }
    
    return view('admin/dashboard');
}

    public function contact()
    {
        return view('public/contact');
    }
    public function track()
{
    return view('public/track');
}

public function terms()
{
    return view('public/terms');
}
    public function about()
{
    return view('public/about');
}

public function privacy()
{
    return view('public/privacy');
}

public function help()
{
    return view('public/help');
}

public function returns()
{
    return view('public/returns');
}


public function shipping()
{
    return view('public/shipping');
}
    public function productDetails($slug = null)
{
    // If no slug provided, show 404
    if ($slug === null) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    // Complete product data array - ALL 15 products
    $allProducts = [
        // ELECTRONICS (6 products)
        'wireless-earbuds' => [
            'id' => 1,
            'name' => 'Wireless Earbuds Pro',
            'slug' => 'wireless-earbuds',
            'price' => 89.99,
            'old_price' => 129.99,
            'description' => 'Experience crystal-clear sound with our premium wireless earbuds. Featuring noise cancellation, 8-hour battery life, and comfortable fit for all-day wear. Perfect for music, calls, and workouts.',
            'category' => 'Electronics',
            'subcategory' => 'Audio',
            'store' => 'TechHub Store',
            'sku' => 'WH-1000XM5',
            'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&h=600&fit=crop',
            'images' => [
                'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1585386959984-a4155224a1ad?w=600&h=600&fit=crop'
            ],
            'rating' => 4.5,
            'reviews' => 124,
            'in_stock' => true,
            'badges' => ['New', 'Sale']
        ],
        'smartwatch-pro' => [
            'id' => 2,
            'name' => 'Smartwatch Pro',
            'slug' => 'smartwatch-pro',
            'price' => 199.00,
            'old_price' => 249.00,
            'description' => 'Stay connected and track your fitness with our premium smartwatch. Features heart rate monitor, GPS, and 7-day battery life. Perfect for active lifestyles.',
            'category' => 'Electronics',
            'subcategory' => 'Wearables',
            'store' => 'TechHub Store',
            'sku' => 'SW-2000',
            'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&h=600&fit=crop',
            'images' => [
                'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=600&h=600&fit=crop'
            ],
            'rating' => 5.0,
            'reviews' => 89,
            'in_stock' => true,
            'badges' => ['New', 'Sale']
        ],
        'bluetooth-speaker' => [
            'id' => 3,
            'name' => 'Bluetooth Speaker',
            'slug' => 'bluetooth-speaker',
            'price' => 129.00,
            'old_price' => 179.00,
            'description' => 'Powerful portable speaker with 360-degree sound, 20-hour battery life, and waterproof design. Perfect for outdoor adventures and parties.',
            'category' => 'Electronics',
            'subcategory' => 'Audio',
            'store' => 'TechHub Store',
            'sku' => 'BS-3000',
            'image' => 'https://images.unsplash.com/photo-1545454675-3531b543be5d?w=600&h=600&fit=crop',
            'images' => [
                'https://images.unsplash.com/photo-1545454675-3531b543be5d?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1585386959984-a4155224a1ad?w=600&h=600&fit=crop'
            ],
            'rating' => 4.0,
            'reviews' => 56,
            'in_stock' => true,
            'badges' => ['New', 'Sale']
        ],
        'gaming-mouse' => [
            'id' => 4,
            'name' => 'Gaming Mouse',
            'slug' => 'gaming-mouse',
            'price' => 49.99,
            'old_price' => 89.99,
            'description' => 'Precision gaming mouse with RGB lighting, 16000 DPI sensor, and 8 programmable buttons for ultimate gaming performance.',
            'category' => 'Electronics',
            'subcategory' => 'Gaming',
            'store' => 'TechHub Store',
            'sku' => 'GM-4000',
            'image' => 'https://images.unsplash.com/photo-1527814050087-3793815479db?w=600&h=600&fit=crop',
            'images' => [
                'https://images.unsplash.com/photo-1527814050087-3793815479db?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=600&h=600&fit=crop'
            ],
            'rating' => 4.5,
            'reviews' => 78,
            'in_stock' => true,
            'badges' => ['New']
        ],
        'ultrabook-pro' => [
            'id' => 5,
            'name' => 'Ultrabook Pro',
            'slug' => 'ultrabook-pro',
            'price' => 899.99,
            'old_price' => 1099.00,
            'description' => 'Lightweight and powerful ultrabook with 14-inch display, 16GB RAM, 512GB SSD, and all-day battery life. Perfect for professionals on the go.',
            'category' => 'Electronics',
            'subcategory' => 'Computers',
            'store' => 'TechHub Store',
            'sku' => 'UB-5000',
            'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=600&h=600&fit=crop',
            'images' => [
                'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=600&h=600&fit=crop'
            ],
            'rating' => 5.0,
            'reviews' => 201,
            'in_stock' => true,
            'badges' => ['Sale']
        ],
        'tablet-10' => [
            'id' => 6,
            'name' => 'Tablet 10"',
            'slug' => 'tablet-10',
            'price' => 299.99,
            'old_price' => 399.99,
            'description' => 'Versatile 10-inch tablet with high-resolution display, 8-core processor, and 128GB storage. Great for work, entertainment, and creative projects.',
            'category' => 'Electronics',
            'subcategory' => 'Tablets',
            'store' => 'TechHub Store',
            'sku' => 'TB-6000',
            'image' => 'https://images.unsplash.com/photo-1561154464-82e9adf32764?w=600&h=600&fit=crop',
            'images' => [
                'https://images.unsplash.com/photo-1561154464-82e9adf32764?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1585386959984-a4155224a1ad?w=600&h=600&fit=crop'
            ],
            'rating' => 4.0,
            'reviews' => 45,
            'in_stock' => true,
            'badges' => ['New']
        ],
        // FASHION (3 products)
        'blue-jeans' => [
            'id' => 7,
            'name' => 'Blue Jeans',
            'slug' => 'blue-jeans',
            'price' => 49.99,
            'old_price' => null,
            'description' => 'Classic blue jeans made from premium denim. Comfortable fit with a modern style. Perfect for everyday wear.',
            'category' => 'Fashion',
            'subcategory' => 'Men\'s Wear',
            'store' => 'FashionHub Store',
            'sku' => 'BJ-1001',
            'image' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?w=600&h=600&fit=crop',
            'images' => [
                'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=600&h=600&fit=crop'
            ],
            'rating' => 4.5,
            'reviews' => 67,
            'in_stock' => true,
            'badges' => ['New']
        ],
        'leather-jacket' => [
            'id' => 8,
            'name' => 'Leather Jacket',
            'slug' => 'leather-jacket',
            'price' => 149.99,
            'old_price' => 199.99,
            'description' => 'Premium genuine leather jacket with a classic design. Perfect for any occasion. Available in multiple sizes.',
            'category' => 'Fashion',
            'subcategory' => 'Men\'s Wear',
            'store' => 'FashionHub Store',
            'sku' => 'LJ-2002',
            'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=600&h=600&fit=crop',
            'images' => [
                'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=600&h=600&fit=crop'
            ],
            'rating' => 4.8,
            'reviews' => 94,
            'in_stock' => true,
            'badges' => ['Sale']
        ],
        'sneakers' => [
            'id' => 9,
            'name' => 'Running Sneakers',
            'slug' => 'sneakers',
            'price' => 79.99,
            'old_price' => null,
            'description' => 'Lightweight running sneakers with cushioned soles for maximum comfort. Ideal for running, walking, and daily activities.',
            'category' => 'Fashion',
            'subcategory' => 'Footwear',
            'store' => 'FashionHub Store',
            'sku' => 'RS-3003',
            'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&h=600&fit=crop',
            'images' => [
                'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1560769629-975ec94e6a86?w=600&h=600&fit=crop'
            ],
            'rating' => 4.6,
            'reviews' => 112,
            'in_stock' => true,
            'badges' => ['New']
        ],
        // HOME & LIVING (2 products)
        'sofa' => [
            'id' => 10,
            'name' => 'Modern Sofa',
            'slug' => 'sofa',
            'price' => 599.99,
            'old_price' => null,
            'description' => 'Elegant modern sofa with premium fabric upholstery. Comfortable seating for 3 people. Perfect for your living room.',
            'category' => 'Home & Living',
            'subcategory' => 'Furniture',
            'store' => 'HomeStyle Store',
            'sku' => 'MS-4004',
            'image' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600&h=600&fit=crop',
            'images' => [
                'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1493663284031-b7e3aefc1578?w=600&h=600&fit=crop'
            ],
            'rating' => 4.7,
            'reviews' => 156,
            'in_stock' => true,
            'badges' => ['New']
        ],
        'lamp' => [
            'id' => 11,
            'name' => 'Table Lamp',
            'slug' => 'lamp',
            'price' => 39.99,
            'old_price' => 59.99,
            'description' => 'Elegant table lamp with a modern design. Provides warm lighting for your bedroom or living room. Adjustable brightness.',
            'category' => 'Home & Living',
            'subcategory' => 'Lighting',
            'store' => 'HomeStyle Store',
            'sku' => 'TL-5005',
            'image' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=600&h=600&fit=crop',
            'images' => [
                'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1513506003901-1e6a229e2d15?w=600&h=600&fit=crop'
            ],
            'rating' => 4.3,
            'reviews' => 78,
            'in_stock' => true,
            'badges' => ['Sale']
        ],
        // BEAUTY (1 product)
        'skincare-set' => [
            'id' => 12,
            'name' => 'Skincare Set',
            'slug' => 'skincare-set',
            'price' => 89.99,
            'old_price' => null,
            'description' => 'Complete skincare set with cleanser, toner, serum, and moisturizer. Made with natural ingredients for healthy glowing skin.',
            'category' => 'Beauty',
            'subcategory' => 'Skincare',
            'store' => 'Glow Beauty Store',
            'sku' => 'SS-6006',
            'image' => 'https://images.unsplash.com/photo-1556228578-8c89e6adf883?w=600&h=600&fit=crop',
            'images' => [
                'https://images.unsplash.com/photo-1556228578-8c89e6adf883?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=600&h=600&fit=crop'
            ],
            'rating' => 4.9,
            'reviews' => 203,
            'in_stock' => true,
            'badges' => ['New']
        ],
        // SPORTS (3 products)
        'yoga-mat' => [
            'id' => 13,
            'name' => 'Yoga Mat',
            'slug' => 'yoga-mat',
            'price' => 29.99,
            'old_price' => null,
            'description' => 'Premium non-slip yoga mat with excellent cushioning. Perfect for yoga, pilates, and floor exercises. Eco-friendly material.',
            'category' => 'Sports',
            'subcategory' => 'Fitness',
            'store' => 'SportFit Store',
            'sku' => 'YM-7007',
            'image' => 'https://images.unsplash.com/photo-1592432678016-e910b452f9a2?w=600&h=600&fit=crop',
            'images' => [
                'https://images.unsplash.com/photo-1592432678016-e910b452f9a2?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=600&h=600&fit=crop'
            ],
            'rating' => 4.4,
            'reviews' => 89,
            'in_stock' => true,
            'badges' => ['New']
        ],
        'dumbbells' => [
            'id' => 14,
            'name' => 'Dumbbell Set',
            'slug' => 'dumbbells',
            'price' => 49.99,
            'old_price' => 69.99,
            'description' => 'Adjustable dumbbell set with rubber coating. Perfect for home workouts. Includes 5 different weight settings.',
            'category' => 'Sports',
            'subcategory' => 'Fitness',
            'store' => 'SportFit Store',
            'sku' => 'DS-8008',
            'image' => 'https://images.unsplash.com/photo-1586401100295-7a8096fd231a?w=600&h=600&fit=crop',
            'images' => [
                'https://images.unsplash.com/photo-1586401100295-7a8096fd231a?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=600&h=600&fit=crop'
            ],
            'rating' => 4.6,
            'reviews' => 134,
            'in_stock' => true,
            'badges' => ['Sale']
        ],
        'fitness-band' => [
            'id' => 15,
            'name' => 'Fitness Band',
            'slug' => 'fitness-band',
            'price' => 39.99,
            'old_price' => null,
            'description' => 'Track your fitness goals with this advanced fitness band. Features heart rate monitor, step counter, sleep tracker, and smartphone notifications.',
            'category' => 'Sports',
            'subcategory' => 'Wearables',
            'store' => 'SportFit Store',
            'sku' => 'FB-9009',
            'image' => 'https://images.unsplash.com/photo-1576243345690-4e4b79b63288?w=600&h=600&fit=crop',
            'images' => [
                'https://images.unsplash.com/photo-1576243345690-4e4b79b63288?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?w=600&h=600&fit=crop'
            ],
            'rating' => 4.2,
            'reviews' => 67,
            'in_stock' => true,
            'badges' => ['New']
        ]
    ];

    // Check if the product exists
    if (!isset($allProducts[$slug])) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    // Get the product data
    $product = $allProducts[$slug];

    // Pass the product data to the view
    return view('public/product_details', ['product' => $product]);
}
}