<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\OrderModel;
use App\Models\CartModel;
use App\Models\CartItemModel;

class CustomerController extends BaseController
{
    protected $customerModel;
    protected $orderModel;
    protected $cartModel;
    protected $cartItemModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        $this->orderModel = new OrderModel();
        $this->cartModel = new CartModel();
        $this->cartItemModel = new CartItemModel();
    }

    // ============================================
    // CUSTOMER DASHBOARD
    // ============================================

  // In CustomerController.php - Add to dashboard method

public function dashboard()
{
    $customerId = session()->get('customer_id') ?? session()->get('user_id');
    
    if (!$customerId) {
        return redirect()->to('/login')->with('error', 'Please login to access your dashboard.');
    }

    try {
        $customer = $this->customerModel->find($customerId);
        $totalOrders = $this->orderModel->where('customer_id', $customerId)->countAllResults();
        
        $cartItems = $this->cartModel->getCartByCustomer($customerId);
        $cartCount = 0;
        foreach ($cartItems as $item) {
            $cartCount += $item['quantity'];
        }
        
        $totalSpent = $this->orderModel->selectSum('total_amount')
                                      ->where('customer_id', $customerId)
                                      ->where('order_status', 'completed')
                                      ->first()['total_amount'] ?? 0;
        
        $recentOrders = $this->orderModel->where('customer_id', $customerId)
                                        ->orderBy('created_at', 'DESC')
                                        ->limit(5)
                                        ->findAll();

        // ✅ NEW: Get address count
        $addressModel = new \App\Models\AddressModel();
        $addressCount = $addressModel->getAddressCount($customerId);

        if ($customer) {
            session()->set('first_name', $customer['first_name']);
            session()->set('last_name', $customer['last_name']);
            session()->set('email', $customer['email']);
            session()->set('phone', $customer['phone'] ?? '');
        }

        return view('public/dashboard', [
            'customer' => $customer,
            'totalOrders' => $totalOrders,
            'cartCount' => $cartCount,
            'totalSpent' => $totalSpent,
            'recentOrders' => $recentOrders,
            'allOrders' => $recentOrders,
            'addresses' => [],
            'addressCount' => $addressCount,  // ✅ NEW
        ]);
    } catch (\Exception $e) {
        log_message('error', 'Dashboard error: ' . $e->getMessage());
        return view('public/dashboard', [
            'customer' => null,
            'totalOrders' => 0,
            'cartCount' => 0,
            'totalSpent' => 0,
            'recentOrders' => [],
            'allOrders' => [],
            'addresses' => [],
            'addressCount' => 0,
        ]);
    }
}

    // ============================================
    // CUSTOMER PROFILE
    // ============================================

    public function profile()
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');
        
        if (!$customerId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $customer = $this->customerModel->find($customerId);
        
        return view('public/profile', ['customer' => $customer]);
    }

    // ============================================
    // UPDATE PROFILE
    // ============================================

    public function updateProfile()
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');
        
        if (!$customerId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $rules = [
            'first_name' => 'required|min_length[2]|max_length[50]',
            'last_name' => 'required|min_length[2]|max_length[50]',
            'phone' => 'permit_empty|min_length[10]|max_length[20]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'phone' => $this->request->getPost('phone'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->customerModel->update($customerId, $data);
        
        // Update session
        session()->set('first_name', $data['first_name']);
        session()->set('last_name', $data['last_name']);
        session()->set('phone', $data['phone']);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    // ============================================
    // CHANGE PASSWORD
    // ============================================

    public function changePassword()
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');
        
        if (!$customerId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $rules = [
            'current_password' => 'required|min_length[8]',
            'new_password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[new_password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $customer = $this->customerModel->find($customerId);
        
        if (!password_verify($this->request->getPost('current_password'), $customer['password'])) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        $this->customerModel->update($customerId, [
            'password' => password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Password changed successfully!');
    }

    // ============================================
    // ADDRESSES
    // ============================================

    public function addresses()
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');
        
        if (!$customerId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        return view('public/addresses');
    }

    public function addAddress()
    {
        return view('public/address_add');
    }

    public function storeAddress()
    {
        return redirect()->to('/addresses')->with('success', 'Address added successfully!');
    }

    public function editAddress($id)
    {
        return view('public/address_edit', ['id' => $id]);
    }

    public function updateAddress($id)
    {
        return redirect()->to('/addresses')->with('success', 'Address updated successfully!');
    }

    public function deleteAddress($id)
    {
        return redirect()->to('/addresses')->with('success', 'Address deleted successfully!');
    }
}