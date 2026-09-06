<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\SystemUserModel;
use App\Models\CartModel;
use App\Models\DeliveryCompanyModel;

class AuthController extends BaseController
{
    protected $customerModel;
    protected $systemUserModel;
    protected $cartModel;
    protected $deliveryCompanyModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        $this->systemUserModel = new SystemUserModel();
        $this->cartModel = new CartModel();
        $this->deliveryCompanyModel = new DeliveryCompanyModel();
    }
  public function login()
{
    // If already logged in, redirect to appropriate dashboard
    if (session()->get('customer_id')) {
        return redirect()->to('/dashboard');
    }
    if (session()->get('tenant_id')) {
        return redirect()->to('/store/dashboard');
    }
    if (session()->get('admin_id')) {
        return redirect()->to('/admin/dashboard');
    }
    if (session()->get('delivery_company_id')) {
        return redirect()->to('/delivery/dashboard');
    }

    return view('public/login');
}

  public function loginPost()
{
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    // ==========================================
    // 1. CHECK: DELIVERY COMPANY (NEW)
    // ==========================================
    $deliveryCompany = $this->deliveryCompanyModel->where('email', $email)->first();
    
    if ($deliveryCompany && password_verify($password, $deliveryCompany['password'])) {
        if ($deliveryCompany['status'] !== 'active') {
            return redirect()->back()->with('error', 'Your account is not active. Please contact admin.');
        }
        
        session()->set([
            'delivery_company_id' => $deliveryCompany['id'],
            'delivery_company_name' => $deliveryCompany['name'],
            'delivery_company_email' => $deliveryCompany['email'],
            'is_delivery_logged_in' => true,
            'is_logged_in' => true,
        ]);
        
        // Update last login
        $this->deliveryCompanyModel->update($deliveryCompany['id'], [
            'last_login' => date('Y-m-d H:i:s')
        ]);
        
        // If force password change
        if ($deliveryCompany['force_password_change']) {
            return redirect()->to('/delivery/change-password')->with('warning', 'Please change your password.');
        }
        
        return redirect()->to('/delivery/dashboard')->with('success', 'Welcome back, ' . $deliveryCompany['name'] . '!');
    }

    // ==========================================
    // 2. CHECK: SYSTEM USERS (Admin & Store Owners)
    // ==========================================
    $systemUserModel = new SystemUserModel();
    $user = $systemUserModel->findByEmail($email);

    if ($user && password_verify($password, $user['password'])) {
        session()->set([
            'user_id' => $user['id'],
            'full_name' => $user['full_name'],
            'email' => $user['email'],
            'role' => $user['role'],
            'tenant_id' => $user['tenant_id'],
            'store_name' => $user['store_name'],
            'is_logged_in' => true,
        ]);

        if ($user['role'] === 'super_admin') {
            return redirect()->to('/admin/dashboard')->with('success', 'Welcome Admin!');
        } elseif ($user['role'] === 'store_owner') {
            return redirect()->to('/store/dashboard')->with('success', 'Welcome to your store!');
        }
    }

    // ==========================================
    // 3. CHECK: CUSTOMERS
    // ==========================================
    $customerModel = new CustomerModel();
    $customer = $customerModel->findByEmail($email);

    if ($customer && password_verify($password, $customer['password'])) {
        session()->set([
            'user_id' => $customer['id'],
            'customer_id' => $customer['id'],
            'first_name' => $customer['first_name'],
            'last_name' => $customer['last_name'],
            'full_name' => $customer['first_name'] . ' ' . $customer['last_name'],
            'email' => $customer['email'],
            'phone' => $customer['phone'] ?? '',
            'role' => 'customer',
            'tenant_id' => $customer['tenant_id'] ?? null,
            'is_logged_in' => true,
        ]);

        log_message('debug', '✅ Customer logged in. customer_id: ' . session()->get('customer_id'));

        return $this->mergeGuestCartAndRedirect(
            $customer['id'],
            '/dashboard',
            'Welcome back, ' . $customer['first_name'] . '!'
        );
    }

    return redirect()->back()->with('error', 'Invalid email or password.');
}

    public function register()
    {
        // If already logged in, redirect
        if (session()->get('customer_id')) {
            return redirect()->to('/dashboard');
        }
        if (session()->get('tenant_id')) {
            return redirect()->to('/store/dashboard');
        }
        if (session()->get('admin_id')) {
            return redirect()->to('/admin/dashboard');
        }

        return view('public/register');
    }

    public function registerPost()
    {
        $model = new CustomerModel();

        $existing = $model->findByEmail($this->request->getPost('email'));
        if ($existing) {
            return redirect()->back()->with('error', 'Email already registered. Please login.');
        }

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'is_active' => true,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if ($model->save($data)) {
            return redirect()->to('/login')->with('success', 'Registration successful! Please login.');
        } else {
            return redirect()->back()->with('errors', $model->errors());
        }
    }
    

    public function logout()
{
    // Check if delivery company is logged in
    if (session()->get('is_delivery_logged_in')) {
        session()->remove([
            'delivery_company_id',
            'delivery_company_name',
            'delivery_company_email',
            'is_delivery_logged_in',
            'is_logged_in'
        ]);
        return redirect()->to('/login')->with('success', 'Logged out successfully.');
    }
    
    // Existing logout for customers, admins, store owners
    session()->destroy();
    return redirect()->to('/login')->with('success', 'Logged out successfully.');
}

    /**
     * Moves any items from the guest (session-based) cart into the
     * customer's real database cart, then sends them either back to
     * wherever they were trying to go before logging in (e.g. checkout),
     * or to the given default page.
     */
    private function mergeGuestCartAndRedirect($customerId, $defaultUrl, $successMessage)
    {
        $guestCart = session()->get('guest_cart');

        if (!empty($guestCart)) {
            $cartModel = new CartModel();
            foreach ($guestCart as $productId => $quantity) {
                $cartModel->addOrUpdateItem($customerId, $productId, $quantity);
            }
            session()->remove('guest_cart');

            $cartCount = $cartModel->getCartItemCount($customerId);
            session()->set('cart_count', $cartCount);
        }

        $redirectTo = session()->get('redirect_after_login');
        if ($redirectTo) {
            session()->remove('redirect_after_login');
            return redirect()->to($redirectTo)->with('success', $successMessage);
        }

        return redirect()->to($defaultUrl)->with('success', $successMessage);
    }
}