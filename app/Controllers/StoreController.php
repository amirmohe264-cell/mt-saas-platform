<?php

namespace App\Controllers;

use App\Models\StoreRequestModel;

class StoreController extends BaseController
{
    protected $storeRequestModel;

    public function __construct()
    {
        $this->storeRequestModel = new StoreRequestModel();
    }

    // Show the store application form
    public function apply()
    {
        return view('public/store_apply');
    }

    // Submit the store application
    public function submit()
    {
        $rules = [
            'store_name' => 'required|min_length[3]|max_length[255]',
            'owner_name' => 'required|min_length[3]|max_length[255]',
            'owner_email' => 'required|valid_email',
            'owner_email_password' => 'required|min_length[6]',
            'owner_phone' => 'required|min_length[10]|max_length[20]',
            'store_address' => 'required|min_length[5]',
            'legal_documents' => 'if_exist|max_size[legal_documents,5120]|ext_in[legal_documents,pdf,doc,docx,jpg,jpeg,png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        // Handle file upload
        $file = $this->request->getFile('legal_documents');
        $fileName = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = 'doc_' . time() . '_' . $file->getRandomName();
            $file->move('uploads/store_documents', $newName);
            $fileName = 'uploads/store_documents/' . $newName;
        }

        // Encrypt the email password before storing (two-way encryption)
        $encryptedPassword = $this->encryptPassword($this->request->getPost('owner_email_password'));

        $data = [
            'store_name' => $this->request->getPost('store_name'),
            'owner_name' => $this->request->getPost('owner_name'),
            'owner_email' => $this->request->getPost('owner_email'),
            'owner_email_password' => $encryptedPassword,
            'owner_phone' => $this->request->getPost('owner_phone'),
            'store_description' => $this->request->getPost('store_description'),
            'store_address' => $this->request->getPost('store_address'),
            'business_type' => $this->request->getPost('business_type'),
            'legal_documents' => $fileName,
            'status' => 'pending',
        ];

        if ($this->storeRequestModel->insert($data)) {
            return redirect()->to('/store/applied')->with('success', 'Your store application has been submitted successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to submit application. Please try again.');
        }
    }

    // Show application success page
    public function applied()
    {
        return view('public/store_applied');
    }

    // ============ ENCRYPTION METHODS ============
    
    // Two-way encryption for storing passwords
    private function encryptPassword($password)
    {
        $key = 'shopEaseSecureKey2024!!'; // Change this to a secure key
        $iv = substr($key, 0, 16);
        return openssl_encrypt($password, 'AES-256-CBC', $key, 0, $iv);
    }

    // Two-way decryption for retrieving passwords
    private function decryptPassword($encryptedPassword)
    {
        if (empty($encryptedPassword)) {
            return null;
        }
        $key = 'shopEaseSecureKey2024!!'; // Must match the encryption key
        $iv = substr($key, 0, 16);
        return openssl_decrypt($encryptedPassword, 'AES-256-CBC', $key, 0, $iv);
    }
}