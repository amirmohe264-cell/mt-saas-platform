<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\SystemUserModel;

class AuthController extends BaseController
{
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

        return view('public/login');
    }

    public function loginPost()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Check in system_users table first (Admin & Store Owners)
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

        // If not found in system_users, check customers table (Customers)
        $customerModel = new CustomerModel();
        $customer = $customerModel->findByEmail($email);

        if ($customer && password_verify($password, $customer['password'])) {
            // ✅ FIX: Set BOTH user_id AND customer_id
            session()->set([
                'user_id' => $customer['id'],
                'customer_id' => $customer['id'],  // ← CRITICAL: Add this!
                'first_name' => $customer['first_name'],
                'last_name' => $customer['last_name'],
                'full_name' => $customer['first_name'] . ' ' . $customer['last_name'],
                'email' => $customer['email'],
                'phone' => $customer['phone'] ?? '',
                'role' => 'customer',
                'tenant_id' => $customer['tenant_id'] ?? null,
                'is_logged_in' => true,
            ]);

            // ✅ Debug: Log to verify
            log_message('debug', '✅ Customer logged in. customer_id: ' . session()->get('customer_id'));

            return redirect()->to('/dashboard')->with('success', 'Welcome back, ' . $customer['first_name'] . '!');
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
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Logged out successfully.');
    }
}