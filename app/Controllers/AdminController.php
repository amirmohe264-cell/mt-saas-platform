<?php

namespace App\Controllers;

use App\Models\StoreRequestModel;
use App\Models\TenantModel;
use App\Models\SystemUserModel;
use App\Models\CustomerModel;

class AdminController extends BaseController
{
    protected $storeRequestModel;
    protected $tenantModel;
    protected $systemUserModel;

    public function __construct()
    {
        // Check if user is logged in as Super Admin
        if (!session()->get('is_logged_in') || session()->get('role') !== 'super_admin') {
            redirect()->to('/login')->with('error', 'Unauthorized access.')->send();
            exit();
        }

        $this->storeRequestModel = new StoreRequestModel();
        $this->tenantModel = new TenantModel();
        $this->systemUserModel = new SystemUserModel();
    }

    // ==========================================
    // DASHBOARD
    // ==========================================

    public function dashboard()
    {
        $tenants = $this->tenantModel->findAll();
        
        // Get store owner info for each tenant
        foreach ($tenants as &$tenant) {
            $owner = $this->systemUserModel->where('tenant_id', $tenant['id'])
                                          ->where('role', 'store_owner')
                                          ->first();
            $tenant['owner_name'] = $owner ? $owner['full_name'] : 'No owner';
            $tenant['owner_email'] = $owner ? $owner['email'] : 'No email';
        }
        
        $storeRequestModel = new StoreRequestModel();
        $data = [
            'tenants' => $tenants,
            'pendingRequests' => $storeRequestModel->getPendingRequests(),
        ];
        
        return view('admin/dashboard', $data);
    }

    // ==========================================
    // STORE REQUESTS
    // ==========================================

    public function storeRequests()
    {
        $data = [
            'pendingRequests' => $this->storeRequestModel->getPendingRequests(),
            'approvedRequests' => $this->storeRequestModel->getApprovedRequests(),
            'rejectedRequests' => $this->storeRequestModel->getRejectedRequests(),
        ];

        return view('admin/store_requests', $data);
    }

    public function viewRequest($id)
    {
        $request = $this->storeRequestModel->find($id);
        if (!$request) {
            return redirect()->to('/admin/store-requests')->with('error', 'Request not found.');
        }

        return view('admin/store_request_view', ['request' => $request]);
    }

    public function approveRequest($id)
    {
        $request = $this->storeRequestModel->find($id);
        if (!$request) {
            return redirect()->to('/admin/store-requests')->with('error', 'Request not found.');
        }

        if ($request['status'] !== 'pending') {
            return redirect()->to('/admin/store-requests')->with('error', 'This request has already been reviewed.');
        }

        // Step 1: Create the tenant
        $tenantData = [
            'store_name' => $request['store_name'],
            'store_description' => $request['store_description'],
            'contact_email' => $request['owner_email'],
            'contact_phone' => $request['owner_phone'],
            'store_address' => $request['store_address'],
            'status' => 'active',
        ];

        $tenantId = $this->tenantModel->insert($tenantData);

        if (!$tenantId) {
            return redirect()->to('/admin/store-requests')->with('error', 'Failed to create tenant.');
        }

        // Step 2: Generate plain text password
        $plainPassword = $this->generateRandomPassword();

        // Step 3: Hash the password for storage
        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

        // Step 4: Create the store owner account
        $userData = [
            'tenant_id' => $tenantId,
            'full_name' => $request['owner_name'],
            'email' => $request['owner_email'],
            'password' => $hashedPassword,
            'role' => 'store_owner',
            'store_name' => $request['store_name'],
            'is_active' => true,
        ];

        $userId = $this->systemUserModel->insert($userData);

        if (!$userId) {
            $this->tenantModel->delete($tenantId);
            return redirect()->to('/admin/store-requests')->with('error', 'Failed to create store owner account.');
        }

        // Step 5: Update the request status
        $this->storeRequestModel->approveRequest($id, session()->get('user_id'));

        // Step 6: Build success message
        $message = '✅ Store request approved successfully!<br><br>';
        $message .= '<strong>Store Details:</strong><br>';
        $message .= 'Store Name: <strong>' . $request['store_name'] . '</strong><br>';
        $message .= 'Owner: <strong>' . $request['owner_name'] . '</strong><br>';
        $message .= 'Email: <strong>' . $request['owner_email'] . '</strong><br><br>';
        $message .= '<strong>Login Credentials:</strong><br>';
        $message .= 'Password: <span style="background:#f0f8f0;padding:5px 15px;border-radius:5px;font-size:20px;font-weight:bold;color:#4caf50;">' . $plainPassword . '</span><br><br>';
        $message .= '📋 Please copy the password and send it to the store owner manually.';

        return redirect()->to('/admin/store-requests')->with('success', $message);
    }

    public function rejectRequest($id)
    {
        $request = $this->storeRequestModel->find($id);
        if (!$request) {
            return redirect()->to('/admin/store-requests')->with('error', 'Request not found.');
        }

        if ($request['status'] !== 'pending') {
            return redirect()->to('/admin/store-requests')->with('error', 'This request has already been reviewed.');
        }

        $this->storeRequestModel->rejectRequest($id, session()->get('user_id'));

        return redirect()->to('/admin/store-requests')->with('success', 'Store request has been rejected.');
    }

    // ==========================================
    // STORE MANAGEMENT (TENANTS)
    // ==========================================

    public function stores()
    {
        $tenants = $this->tenantModel->findAll();
        
        // Get store owner info for each tenant
        foreach ($tenants as &$tenant) {
            $owner = $this->systemUserModel->where('tenant_id', $tenant['id'])
                                          ->where('role', 'store_owner')
                                          ->first();
            $tenant['owner_name'] = $owner ? $owner['full_name'] : 'No owner';
            $tenant['owner_email'] = $owner ? $owner['email'] : 'No email';
        }
        
        return view('admin/stores', ['tenants' => $tenants]);
    }

    public function createStore()
    {
        return view('admin/store_add');
    }

    public function storeStore()
    {
        $rules = [
            'store_name' => 'required|min_length[3]|max_length[255]|is_unique[tenants.store_name]',
            'owner_name' => 'required|min_length[3]|max_length[255]',
            'owner_email' => 'required|valid_email|is_unique[system_users.email]',
            'contact_email' => 'required|valid_email',
            'contact_phone' => 'required|min_length[10]|max_length[20]',
            'store_address' => 'required|min_length[5]',
            'manual_password' => 'required|min_length[8]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        // Step 1: Create the tenant
        $tenantData = [
            'store_name' => $this->request->getPost('store_name'),
            'store_description' => $this->request->getPost('store_description'),
            'contact_email' => $this->request->getPost('contact_email'),
            'contact_phone' => $this->request->getPost('contact_phone'),
            'store_address' => $this->request->getPost('store_address'),
            'status' => $this->request->getPost('status') ?: 'pending',
        ];

        $tenantId = $this->tenantModel->insert($tenantData);

        if (!$tenantId) {
            return redirect()->back()->with('error', 'Failed to create store.');
        }

        // Step 2: Get the manual password from the form
        $plainPassword = $this->request->getPost('manual_password');

        // Step 3: Hash the password for storage
        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

        // Step 4: Create the store owner account
        $userData = [
            'tenant_id' => $tenantId,
            'full_name' => $this->request->getPost('owner_name'),
            'email' => $this->request->getPost('owner_email'),
            'password' => $hashedPassword,
            'role' => 'store_owner',
            'store_name' => $this->request->getPost('store_name'),
            'is_active' => true,
        ];

        $userId = $this->systemUserModel->insert($userData);

        if (!$userId) {
            $this->tenantModel->delete($tenantId);
            return redirect()->back()->with('error', 'Failed to create store owner account.');
        }

        $message = '✅ Store created successfully!<br><br>';
        $message .= '<strong>Store Owner Credentials:</strong><br>';
        $message .= 'Store Name: <strong>' . $this->request->getPost('store_name') . '</strong><br>';
        $message .= 'Email: <strong>' . $this->request->getPost('owner_email') . '</strong><br>';
        $message .= 'Password: <span style="background:#f0f8f0;padding:5px 15px;border-radius:5px;font-size:20px;font-weight:bold;color:#4caf50;">' . $plainPassword . '</span>';

        return redirect()->to('/admin/stores')->with('success', $message);
    }

    public function editStore($id)
    {
        $tenant = $this->tenantModel->find($id);
        if (!$tenant) {
            return redirect()->to('/admin/stores')->with('error', 'Store not found.');
        }

        $owner = $this->systemUserModel->where('tenant_id', $id)
                                      ->where('role', 'store_owner')
                                      ->first();

        return view('admin/store_edit', [
            'tenant' => $tenant,
            'owner' => $owner,
        ]);
    }

    public function updateStore($id)
    {
        $tenant = $this->tenantModel->find($id);
        if (!$tenant) {
            return redirect()->to('/admin/stores')->with('error', 'Store not found.');
        }

        $rules = [
            'store_name' => 'required|min_length[3]|max_length[255]',
            'contact_email' => 'required|valid_email',
            'contact_phone' => 'required|min_length[10]|max_length[20]',
            'store_address' => 'required|min_length[5]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $data = [
            'store_name' => $this->request->getPost('store_name'),
            'store_description' => $this->request->getPost('store_description'),
            'contact_email' => $this->request->getPost('contact_email'),
            'contact_phone' => $this->request->getPost('contact_phone'),
            'store_address' => $this->request->getPost('store_address'),
            'status' => $this->request->getPost('status'),
        ];

        $this->tenantModel->update($id, $data);

        // Update store owner name if changed
        $owner = $this->systemUserModel->where('tenant_id', $id)
                                      ->where('role', 'store_owner')
                                      ->first();
        
        if ($owner) {
            $this->systemUserModel->update($owner['id'], [
                'full_name' => $this->request->getPost('owner_name'),
                'store_name' => $this->request->getPost('store_name'),
            ]);
        }

        return redirect()->to('/admin/stores')->with('success', 'Store updated successfully!');
    }

    public function suspendStore($id)
    {
        $tenant = $this->tenantModel->find($id);
        if (!$tenant) {
            return redirect()->to('/admin/stores')->with('error', 'Store not found.');
        }

        $newStatus = $tenant['status'] === 'suspended' ? 'active' : 'suspended';
        $this->tenantModel->update($id, ['status' => $newStatus]);

        $message = $newStatus === 'suspended' ? 'Store suspended successfully!' : 'Store activated successfully!';
        return redirect()->to('/admin/stores')->with('success', $message);
    }

    public function deleteStore($id)
    {
        $tenant = $this->tenantModel->find($id);
        if (!$tenant) {
            return redirect()->to('/admin/stores')->with('error', 'Store not found.');
        }

        // Delete store owner first
        $this->systemUserModel->where('tenant_id', $id)->delete();
        
        // Delete the tenant
        $this->tenantModel->delete($id);

        return redirect()->to('/admin/stores')->with('success', 'Store deleted successfully!');
    }

    public function resetStorePassword($id)
    {
        $owner = $this->systemUserModel->where('tenant_id', $id)
                                      ->where('role', 'store_owner')
                                      ->first();
        
        if (!$owner) {
            return redirect()->to('/admin/stores')->with('error', 'Store owner not found.');
        }

        $newPassword = $this->generateRandomPassword();
        $this->systemUserModel->update($owner['id'], [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
        ]);

        $message = '✅ Password reset successfully!<br><br>';
        $message .= 'New Password: <span style="background:#f0f8f0;padding:5px 15px;border-radius:5px;font-size:20px;font-weight:bold;color:#4caf50;">' . $newPassword . '</span>';

        return redirect()->to('/admin/stores')->with('success', $message);
    }

    // ==========================================
    // USER MANAGEMENT
    // ==========================================

    public function users()
    {
        if (session()->get('role') !== 'super_admin') {
            return redirect()->to('/login')->with('error', 'Unauthorized access.');
        }

        // Get all customers
        $customerModel = new CustomerModel();
        $customers = $customerModel->findAll();

        // Get all store owners
        $storeOwners = $this->systemUserModel->where('role', 'store_owner')->findAll();

        return view('admin/users', [
            'customers' => $customers,
            'storeOwners' => $storeOwners,
        ]);
    }

    public function toggleCustomerStatus($id)
    {
        if (session()->get('role') !== 'super_admin') {
            return redirect()->to('/login')->with('error', 'Unauthorized access.');
        }

        $customerModel = new CustomerModel();
        $customer = $customerModel->find($id);
        if (!$customer) {
            return redirect()->to('/admin/users')->with('error', 'Customer not found.');
        }

        $newStatus = $customer['is_active'] ? false : true;
        $customerModel->update($id, ['is_active' => $newStatus]);

        $statusText = $newStatus ? 'activated' : 'suspended';
        return redirect()->to('/admin/users')->with('success', "Customer $statusText successfully.");
    }

    public function toggleStoreOwnerStatus($id)
    {
        if (session()->get('role') !== 'super_admin') {
            return redirect()->to('/login')->with('error', 'Unauthorized access.');
        }

        $user = $this->systemUserModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Store owner not found.');
        }

        $newStatus = $user['is_active'] ? false : true;
        $this->systemUserModel->update($id, ['is_active' => $newStatus]);

        $statusText = $newStatus ? 'activated' : 'suspended';
        return redirect()->to('/admin/users')->with('success', "Store owner $statusText successfully.");
    }

    public function resetStoreOwnerPassword($id)
    {
        if (session()->get('role') !== 'super_admin') {
            return redirect()->to('/login')->with('error', 'Unauthorized access.');
        }

        $user = $this->systemUserModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Store owner not found.');
        }

        $newPassword = $this->generateRandomPassword();
        $this->systemUserModel->update($id, [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
        ]);

        return redirect()->to('/admin/users')->with('success', "New password: <strong>$newPassword</strong> (Please send this to the store owner)");
    }

    // ==========================================
    // HELPER METHODS
    // ==========================================

    private function generateRandomPassword($length = 10)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $password;
    }

    private function encryptPassword($password)
    {
        $key = 'shopEaseSecureKey2024!!';
        $iv = substr($key, 0, 16);
        return openssl_encrypt($password, 'AES-256-CBC', $key, 0, $iv);
    }

    private function decryptPassword($encryptedPassword)
    {
        if (empty($encryptedPassword)) {
            return null;
        }
        $key = 'shopEaseSecureKey2024!!';
        $iv = substr($key, 0, 16);
        return openssl_decrypt($encryptedPassword, 'AES-256-CBC', $key, 0, $iv);
    }
}