<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ==========================================
// PUBLIC PAGES
// ==========================================
$routes->get('/', 'Home::index');
$routes->get('categories', 'CategoryController::index');
$routes->get('categories/(:any)', 'CategoryController::show/$1');
$routes->get('products', 'ProductController::index');
$routes->get('product/(:any)', 'ProductController::show/$1');
$routes->get('search', 'ProductController::search');
$routes->get('contact', 'Home::contact');
$routes->get('about', 'Home::about');
$routes->get('privacy', 'Home::privacy');
$routes->get('terms', 'Home::terms');

// ==========================================
// AUTH ROUTES
// ==========================================
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::loginPost');
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::registerPost');
$routes->get('logout', 'AuthController::logout');

// ==========================================
// CUSTOMER PAGES
// ==========================================
$routes->get('checkout', 'CheckoutController::index');
$routes->post('checkout/process', 'CheckoutController::process');
$routes->get('order-confirmation', 'OrderController::confirmation');
$routes->get('order-confirmation/(:num)', 'CheckoutController::confirmation/$1');
$routes->get('dashboard', 'CustomerController::dashboard');
$routes->get('profile', 'CustomerController::profile');
$routes->post('profile/update', 'CustomerController::updateProfile');
$routes->post('profile/change-password', 'CustomerController::changePassword');
$routes->get('addresses', 'CustomerController::addresses');
$routes->get('addresses/add', 'CustomerController::addAddress');
$routes->post('addresses/store', 'CustomerController::storeAddress');
$routes->get('addresses/edit/(:num)', 'CustomerController::editAddress/$1');
$routes->post('addresses/update/(:num)', 'CustomerController::updateAddress/$1');
$routes->get('addresses/delete/(:num)', 'CustomerController::deleteAddress/$1');
$routes->get('help', 'Home::help');
$routes->get('returns', 'Home::returns');
$routes->get('shipping', 'Home::shipping');
$routes->get('track', 'Home::track');

// ==========================================
// CART ROUTES (ALL IN ONE PLACE)
// ==========================================
$routes->get('cart', 'CartController::index');
$routes->post('cart/add', 'CartController::add');
$routes->post('cart/update', 'CartController::update');
$routes->post('cart/remove', 'CartController::remove');
$routes->get('cart/clear', 'CartController::clear');
$routes->get('cart/count', 'CartController::count');
$routes->get('cart/totals', 'CartController::getCartTotals');
$routes->post('cart/update-session', 'CartController::updateSession');

// ==========================================
// STORE OWNER DASHBOARD
// ==========================================
$routes->get('store/dashboard', 'Home::storeDashboard');
$routes->get('store/products', 'ProductController::storeProducts');
$routes->get('store/products/create', 'ProductController::create');
$routes->post('store/products', 'ProductController::store');
$routes->get('store/products/edit/(:num)', 'ProductController::edit/$1');

// ✅ FIXED: Uppercase HTTP methods
$routes->match(['POST', 'PUT'], 'store/products/update/(:num)', 'ProductController::update/$1');

$routes->get('store/products/delete/(:num)', 'ProductController::delete/$1');
$routes->get('store/products/toggle/(:num)', 'ProductController::toggleStatus/$1');

// Store Owner - Subcategories
$routes->get('store/subcategories', 'SubcategoryController::index');
$routes->get('store/subcategories/create', 'SubcategoryController::create');
$routes->post('store/subcategories', 'SubcategoryController::store');
$routes->get('store/subcategories/edit/(:num)', 'SubcategoryController::edit/$1');
$routes->post('store/subcategories/update/(:num)', 'SubcategoryController::update/$1');
$routes->get('store/subcategories/delete/(:num)', 'SubcategoryController::delete/$1');
$routes->get('store/subcategories/toggle/(:num)', 'SubcategoryController::toggleStatus/$1');

// ==========================================
// SUPER ADMIN DASHBOARD
// ==========================================
$routes->get('admin/dashboard', 'Home::adminDashboard');

// Admin - Category CRUD
$routes->get('admin/categories', 'CategoryController::adminIndex');
$routes->get('admin/categories/create', 'CategoryController::create');
$routes->post('admin/categories/store', 'CategoryController::store');
$routes->get('admin/categories/edit/(:num)', 'CategoryController::edit/$1');
$routes->post('admin/categories/update/(:num)', 'CategoryController::update/$1');
$routes->get('admin/categories/delete/(:num)', 'CategoryController::delete/$1');
$routes->get('admin/categories/toggle/(:num)', 'CategoryController::toggleStatus/$1');

// Admin - Store Management
$routes->get('admin/stores', 'AdminController::stores');
$routes->get('admin/store/create', 'AdminController::createStore');
$routes->post('admin/store/store', 'AdminController::storeStore');
$routes->get('admin/store/edit/(:num)', 'AdminController::editStore/$1');
$routes->post('admin/store/update/(:num)', 'AdminController::updateStore/$1');
$routes->get('admin/store/suspend/(:num)', 'AdminController::suspendStore/$1');
$routes->get('admin/store/delete/(:num)', 'AdminController::deleteStore/$1');
$routes->get('admin/store/reset-password/(:num)', 'AdminController::resetStorePassword/$1');

// Admin - Store Request Routes
$routes->get('admin/store-requests', 'AdminController::storeRequests');
$routes->get('admin/store-request/(:num)', 'AdminController::viewRequest/$1');
$routes->get('admin/store-request/approve/(:num)', 'AdminController::approveRequest/$1');
$routes->get('admin/store-request/reject/(:num)', 'AdminController::rejectRequest/$1');

// Admin - User Management
$routes->get('admin/users', 'AdminController::users');
$routes->get('admin/users/customer/toggle/(:num)', 'AdminController::toggleCustomerStatus/$1');
$routes->get('admin/users/store-owner/toggle/(:num)', 'AdminController::toggleStoreOwnerStatus/$1');
$routes->get('admin/users/store-owner/reset-password/(:num)', 'AdminController::resetStoreOwnerPassword/$1');

// ==========================================
// STORE APPLICATION ROUTES
// ==========================================
$routes->get('store/apply', 'StoreController::apply');
$routes->post('store/submit', 'StoreController::submit');
$routes->get('store/applied', 'StoreController::applied');

// ==========================================
// PAYMENT ROUTES
// ==========================================
$routes->get('payment/telebirr/confirm/(:num)', 'CheckoutController::telebirrConfirm/$1');
$routes->post('payment/chapa/callback', 'CheckoutController::chapaCallback');
$routes->get('payment/chapa/success', 'CheckoutController::chapaSuccess');

// ==========================================
// TEST ROUTES
// ==========================================
$routes->get('test-product/(:any)', 'ProductController::testShow/$1');
$routes->get('test-cart-insert', function() {
    $customerId = session()->get('customer_id') ?? session()->get('user_id');

    if (!$customerId) {
        return "Please login first. Customer ID: " . $customerId;
    }

    $cartModel = new \App\Models\CartModel();
    $result = $cartModel->insert([
        'customer_id' => $customerId,
        'product_id' => 1,
        'quantity' => 1
    ]);

    if ($result) {
        return "Cart insert successful!";
    } else {
        return "Cart insert failed. Error: " . print_r($cartModel->errors(), true);
    }
});

// ==========================================
// API ROUTES
// ==========================================
$routes->get('api/products', 'ProductController::apiGetProducts');
$routes->get('api/product/(:num)', 'ProductController::apiGetProduct/$1');
$routes->get('api/categories', 'CategoryController::apiGetCategories');
$routes->get('api/category/(:num)', 'CategoryController::apiGetCategory/$1');
$routes->get('api/subcategories/category/(:num)', 'SubcategoryController::getByCategory/$1');
$routes->get('api/subcategories/tenant', 'SubcategoryController::getByTenant');

// ==========================================
// STORE OWNER ORDERS ROUTES
// ==========================================
$routes->get('store/orders', 'OrderController::storeOrders');
$routes->get('store/orders/(:num)', 'OrderController::storeOrderDetails/$1');
$routes->post('store/orders/update-status/(:num)', 'OrderController::updateOrderStatus/$1');

// ==========================================
// ADDRESS ROUTES
// ==========================================
$routes->group('', ['filter' => 'customer'], function($routes) {
    $routes->get('addresses', 'AddressController::index');
    $routes->get('addresses/add', 'AddressController::add');
    $routes->post('addresses/store', 'AddressController::store');
    $routes->get('addresses/edit/(:num)', 'AddressController::edit/$1');
    $routes->post('addresses/update/(:num)', 'AddressController::update/$1');
    $routes->get('addresses/delete/(:num)', 'AddressController::delete/$1');
    $routes->get('addresses/set-default/(:num)', 'AddressController::setDefault/$1');
    $routes->get('addresses/get-addresses', 'AddressController::getAddresses');
});

// ==========================================
// 🆕 CUSTOMER DASHBOARD - ORDER & WISHLIST API ROUTES
// ==========================================
// Order routes - Fetch real orders from database
$routes->get('get-orders', 'PublicController::getOrders');
$routes->get('get-order-detail/(:num)', 'PublicController::getOrderDetail/$1');
$routes->post('cancel-order/(:num)', 'PublicController::cancelOrder/$1');

// Wishlist routes - Fetch real wishlist from database
$routes->get('get-wishlist', 'PublicController::getWishlist');
$routes->post('remove-from-wishlist/(:num)', 'PublicController::removeFromWishlist/$1');

// Cart routes
$routes->get('cart-count', 'PublicController::getCartCount');
$routes->post('add-to-cart', 'PublicController::addToCart');

// ==========================================
// WISHLIST ROUTES
// ==========================================
$routes->post('wishlist/add', 'WishlistController::add');
$routes->get('wishlist/check/(:num)', 'WishlistController::check/$1');
$routes->get('wishlist/count', 'WishlistController::count');
$routes->get('wishlist', 'WishlistController::index');
$routes->post('wishlist/remove/(:num)', 'WishlistController::remove/$1');
// ==========================================
// ROUTE SETTINGS
// ==========================================
$routes->setTranslateURIDashes(true);
$routes->setAutoRoute(false);
// ==========================================
// CUSTOMER DASHBOARD - API ROUTES
// ==========================================
$routes->get('get-orders', 'PublicController::getOrders');
$routes->get('get-order-detail/(:num)', 'PublicController::getOrderDetail/$1');
$routes->post('cancel-order/(:num)', 'PublicController::cancelOrder/$1');
$routes->get('get-wishlist', 'PublicController::getWishlist');
$routes->post('remove-from-wishlist/(:num)', 'PublicController::removeFromWishlist/$1');
$routes->get('cart-count', 'PublicController::getCartCount');
$routes->post('add-to-cart', 'PublicController::addToCart');
$routes->get('wishlist/check/(:num)', 'WishlistController::check/$1');
$routes->post('store/orders/mark-delivered/(:num)', 'OrderController::markDeliveredByStore/$1');
$routes->get('orders', 'OrderController::index');
$routes->get('orders/(:num)', 'OrderController::show/$1');

$routes->get('reviews/check/(:num)', 'ReviewController::check/$1');
$routes->post('reviews/submit', 'ReviewController::submit');
$routes->post('orders/confirm-delivery/(:num)', 'PublicController::confirmDelivery/$1');
$routes->get('admin/escrow-queue', 'AdminController::escrowQueue');
$routes->post('admin/escrow-release/(:num)', 'AdminController::releasePayment/$1');
$routes->post('store/settings/update', 'Home::updateStoreSettings');
$routes->post('store/settings/change-password', 'Home::changeStoreOwnerPassword');