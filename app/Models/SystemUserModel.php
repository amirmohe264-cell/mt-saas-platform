<?php

namespace App\Models;

use CodeIgniter\Model;

class SystemUserModel extends Model
{
    protected $table            = 'system_users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['tenant_id', 'full_name', 'email', 'password', 'role', 'store_name', 'is_active'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public function findByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
}