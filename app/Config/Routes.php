<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ==========================================
// PUBLIC PAGES - Place these FIRST
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
// CUSTOMER PAGES
// ==========================================
$routes->get('cart', 'Home::cart');
$routes->get('checkout', 'Home::checkout');
$routes->get('order-confirmation', 'Home::orderConfirmation');
$routes->get('dashboard', 'Home::dashboard');
$routes->get('help', 'Home::help');
$routes->get('returns', 'Home::returns');
$routes->get('shipping', 'Home::shipping');
$routes->get('track', 'Home::track');

// ==========================================
// AUTH ROUTES
// ==========================================
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::loginPost');
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::registerPost');
$routes->get('logout', 'AuthController::logout');

// ==========================================
// STORE OWNER DASHBOARD
// ==========================================
$routes->get('store/dashboard', 'Home::storeDashboard');
$routes->get('store/products', 'ProductController::storeProducts');
$routes->get('store/products/create', 'ProductController::create');
$routes->post('store/products', 'ProductController::store');
$routes->get('store/products/edit/(:num)', 'ProductController::edit/$1');
$routes->post('store/products/update/(:num)', 'ProductController::update/$1');
$routes->get('store/products/delete/(:num)', 'ProductController::delete/$1');
$routes->get('store/products/toggle/(:num)', 'ProductController::toggleStatus/$1');

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
// Admin - Store Request Routes
$routes->get('admin/store-requests', 'AdminController::storeRequests');
$routes->get('admin/store-request/(:num)', 'AdminController::viewRequest/$1');
$routes->get('admin/store-request/approve/(:num)', 'AdminController::approveRequest/$1');
$routes->get('admin/store-request/reject/(:num)', 'AdminController::rejectRequest/$1');


// ==========================================
// STORE APPLICATION ROUTES
// ==========================================
$routes->get('store/apply', 'StoreController::apply');
$routes->post('store/submit', 'StoreController::submit');
$routes->get('store/applied', 'StoreController::applied');

// ==========================================
// API ROUTES
// ==========================================
$routes->get('api/products', 'ProductController::apiGetProducts');
$routes->get('api/product/(:num)', 'ProductController::apiGetProduct/$1');
$routes->get('api/categories', 'CategoryController::apiGetCategories');
$routes->get('api/category/(:num)', 'CategoryController::apiGetCategory/$1');
// Allow special characters in routes
$routes->setTranslateURIDashes(true);
// Admin - Store Management
$routes->get('admin/stores', 'AdminController::stores');
$routes->get('admin/store/create', 'AdminController::createStore');
$routes->post('admin/store/store', 'AdminController::storeStore');
$routes->get('admin/store/edit/(:num)', 'AdminController::editStore/$1');
$routes->post('admin/store/update/(:num)', 'AdminController::updateStore/$1');
$routes->get('admin/store/suspend/(:num)', 'AdminController::suspendStore/$1');
$routes->get('admin/store/delete/(:num)', 'AdminController::deleteStore/$1');
$routes->get('admin/store/reset-password/(:num)', 'AdminController::resetStorePassword/$1');
// Admin - User Management
$routes->get('admin/users', 'AdminController::users');
$routes->get('admin/users/customer/toggle/(:num)', 'AdminController::toggleCustomerStatus/$1');
$routes->get('admin/users/store-owner/toggle/(:num)', 'AdminController::toggleStoreOwnerStatus/$1');
$routes->get('admin/users/store-owner/reset-password/(:num)', 'AdminController::resetStoreOwnerPassword/$1');
$routes->get('test-product/(:any)', 'ProductController::testShow/$1');
// Cart Routes
$routes->get('cart', 'CartController::index');
$routes->post('cart/add', 'CartController::add');
$routes->post('cart/update', 'CartController::update');
$routes->post('cart/remove', 'CartController::remove');
$routes->get('cart/count', 'CartController::getCartCount');
$routes->get('cart/totals', 'CartController::getCartTotals');
$routes->get('test-cart-insert', function() {
    $customerId = session()->get('user_id');
    
    if (!$customerId) {
        return "Please login first. User ID: " . $customerId;
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