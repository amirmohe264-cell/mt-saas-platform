<?php

namespace App\Models;

use CodeIgniter\Model;

class TenantModel extends Model
{
    protected $table            = 'tenants';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['store_name', 'store_logo', 'store_description', 'contact_email', 'contact_phone', 'store_address', 'status'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public function getActiveTenants()
    {
        return $this->where('status', 'active')->findAll();
    }

    public function getPendingTenants()
    {
        return $this->where('status', 'pending')->findAll();
    }

    public function getTenantByStoreName($storeName)
    {
        return $this->where('store_name', $storeName)->first();
    }
}