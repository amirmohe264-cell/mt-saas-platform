<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table            = 'customers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['tenant_id', 'first_name', 'last_name', 'email', 'phone', 'password', 'is_active'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // ✅ Fix: Make validation rules conditional
    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[customers.email]',
        'password' => 'permit_empty|min_length[8]',  // ✅ Changed from 'required' to 'permit_empty'
        'first_name' => 'permit_empty|min_length[2]|max_length[50]',
        'last_name' => 'permit_empty|min_length[2]|max_length[50]',
        'phone' => 'permit_empty|min_length[10]|max_length[20]',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'This email is already registered.',
        ],
        'password' => [
            'min_length' => 'Password must be at least 8 characters long.',
        ],
    ];

    public function findByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    // ✅ New: Get customer by ID with full name
    public function getCustomerWithName($id)
    {
        return $this->select('*, CONCAT(first_name, " ", last_name) as full_name')
                    ->where('id', $id)
                    ->first();
    }

    // ✅ New: Update customer profile without password
    public function updateProfile($id, $data)
    {
        // Remove password if empty
        if (empty($data['password'])) {
            unset($data['password']);
        }
        
        return $this->update($id, $data);
    }
}