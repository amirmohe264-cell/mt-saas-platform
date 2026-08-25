<?php

namespace App\Controllers;

use App\Models\AddressModel;

class AddressController extends BaseController
{
    protected $addressModel;

    public function __construct()
    {
        $this->addressModel = new AddressModel();
    }

    // ============================================
    // LIST ADDRESSES
    // ============================================

    public function index()
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');
        
        if (!$customerId) {
            return redirect()->to('/login')->with('error', 'Please login to view your addresses.');
        }

        $addresses = $this->addressModel->getCustomerAddresses($customerId);
        $defaultAddress = $this->addressModel->getDefaultAddress($customerId);

        return view('public/addresses', [
            'addresses' => $addresses,
            'defaultAddress' => $defaultAddress,
        ]);
    }

    // ============================================
    // ADD ADDRESS
    // ============================================

    public function add()
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');
        
        if (!$customerId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        return view('public/address_add');
    }

    public function store()
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');
        
        if (!$customerId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $rules = [
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name' => 'required|min_length[2]|max_length[100]',
            'phone' => 'required|min_length[10]|max_length[20]',
            'address_line1' => 'required|min_length[5]|max_length[255]',
            'city' => 'required|min_length[2]|max_length[100]',
            'postal_code' => 'permit_empty|max_length[20]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        // Check if this is the first address - make it default
        $addressCount = $this->addressModel->getAddressCount($customerId);
        $isDefault = ($addressCount === 0) ? true : ($this->request->getPost('is_default') ? true : false);

        // If setting as default, reset other defaults
        if ($isDefault) {
            $this->addressModel->where('customer_id', $customerId)
                               ->set(['is_default' => false])
                               ->update();
        }

        $data = [
            'customer_id' => $customerId,
            'address_name' => $this->request->getPost('address_name'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'phone' => $this->request->getPost('phone'),
            'address_line1' => $this->request->getPost('address_line1'),
            'address_line2' => $this->request->getPost('address_line2'),
            'city' => $this->request->getPost('city'),
            'state' => $this->request->getPost('state'),
            'postal_code' => $this->request->getPost('postal_code'),
            'country' => $this->request->getPost('country') ?: 'Ethiopia',
            'is_default' => $isDefault,
        ];

        if ($this->addressModel->insert($data)) {
            return redirect()->to('/addresses')->with('success', '✅ Address added successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to add address. Please try again.');
        }
    }

    // ============================================
    // EDIT ADDRESS
    // ============================================

    public function edit($id)
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');
        
        if (!$customerId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $address = $this->addressModel->where('customer_id', $customerId)
                                      ->where('id', $id)
                                      ->first();

        if (!$address) {
            return redirect()->to('/addresses')->with('error', 'Address not found.');
        }

        return view('public/address_edit', ['address' => $address]);
    }

    public function update($id)
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');
        
        if (!$customerId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $address = $this->addressModel->where('customer_id', $customerId)
                                      ->where('id', $id)
                                      ->first();

        if (!$address) {
            return redirect()->to('/addresses')->with('error', 'Address not found.');
        }

        $rules = [
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name' => 'required|min_length[2]|max_length[100]',
            'phone' => 'required|min_length[10]|max_length[20]',
            'address_line1' => 'required|min_length[5]|max_length[255]',
            'city' => 'required|min_length[2]|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $isDefault = $this->request->getPost('is_default') ? true : false;

        // If setting as default, reset other defaults
        if ($isDefault && !$address['is_default']) {
            $this->addressModel->where('customer_id', $customerId)
                               ->set(['is_default' => false])
                               ->update();
        }

        $data = [
            'address_name' => $this->request->getPost('address_name'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'phone' => $this->request->getPost('phone'),
            'address_line1' => $this->request->getPost('address_line1'),
            'address_line2' => $this->request->getPost('address_line2'),
            'city' => $this->request->getPost('city'),
            'state' => $this->request->getPost('state'),
            'postal_code' => $this->request->getPost('postal_code'),
            'country' => $this->request->getPost('country') ?: 'Ethiopia',
            'is_default' => $isDefault,
        ];

        if ($this->addressModel->update($id, $data)) {
            return redirect()->to('/addresses')->with('success', '✅ Address updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to update address.');
        }
    }

    // ============================================
    // DELETE ADDRESS
    // ============================================

    public function delete($id)
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');
        
        if (!$customerId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $address = $this->addressModel->where('customer_id', $customerId)
                                      ->where('id', $id)
                                      ->first();

        if (!$address) {
            return redirect()->to('/addresses')->with('error', 'Address not found.');
        }

        // If deleting default address, set another address as default
        if ($address['is_default']) {
            $this->addressModel->where('customer_id', $customerId)
                               ->where('id !=', $id)
                               ->orderBy('id', 'ASC')
                               ->limit(1)
                               ->set(['is_default' => true])
                               ->update();
        }

        if ($this->addressModel->delete($id)) {
            return redirect()->to('/addresses')->with('success', '✅ Address deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to delete address.');
        }
    }

    // ============================================
    // SET DEFAULT ADDRESS
    // ============================================

    public function setDefault($id)
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');
        
        if (!$customerId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $address = $this->addressModel->where('customer_id', $customerId)
                                      ->where('id', $id)
                                      ->first();

        if (!$address) {
            return redirect()->to('/addresses')->with('error', 'Address not found.');
        }

        $this->addressModel->where('customer_id', $customerId)
                           ->set(['is_default' => false])
                           ->update();

        $this->addressModel->update($id, ['is_default' => true]);

        return redirect()->to('/addresses')->with('success', '✅ Default address updated successfully!');
    }

    // ============================================
    // GET ADDRESSES FOR CHECKOUT (AJAX)
    // ============================================

    public function getAddresses()
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');
        
        if (!$customerId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login.'
            ]);
        }

        $addresses = $this->addressModel->getCustomerAddresses($customerId);

        return $this->response->setJSON([
            'success' => true,
            'data' => $addresses
        ]);
    }
}