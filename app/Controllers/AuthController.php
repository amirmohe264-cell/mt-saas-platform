<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\SystemUserModel;

class AuthController extends BaseController
{
    public function login()
    {
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
                return redirect()->to('/admin/dashboard');
            } elseif ($user['role'] === 'store_owner') {
                return redirect()->to('/store/dashboard');
            }
        }

        // If not found in system_users, check customers table (Customers)
        $customerModel = new CustomerModel();
        $customer = $customerModel->findByEmail($email);

        if ($customer && password_verify($password, $customer['password'])) {
            session()->set([
                'user_id' => $customer['id'],
                'full_name' => $customer['first_name'] . ' ' . $customer['last_name'],
                'email' => $customer['email'],
                'role' => 'customer',
                'tenant_id' => $customer['tenant_id'],
                'is_logged_in' => true,
            ]);
            return redirect()->to('/dashboard');
        }

        return redirect()->back()->with('error', 'Invalid email or password.');
    }

    public function register()
    {
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