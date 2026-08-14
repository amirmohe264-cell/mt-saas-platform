<?php

namespace App\Models;

use CodeIgniter\Model;

class SubcategoryModel extends Model
{
    protected $table            = 'subcategories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['category_id', 'tenant_id', 'subcategory_name', 'is_active'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public function getSubcategoriesByCategory($categoryId)
    {
        return $this->where('category_id', $categoryId)
                    ->where('is_active', true)
                    ->findAll();
    }

    public function getSubcategoriesByTenant($tenantId)
    {
        return $this->where('tenant_id', $tenantId)
                    ->where('is_active', true)
                    ->findAll();
    }
}