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

    public function getSubcategoriesWithCategory($tenantId)
    {
        return $this->select('subcategories.*, categories.category_name')
                    ->join('categories', 'categories.id = subcategories.category_id')
                    ->where('subcategories.tenant_id', $tenantId)
                    ->where('subcategories.is_active', true)
                    ->orderBy('categories.category_name', 'ASC')
                    ->orderBy('subcategories.subcategory_name', 'ASC')
                    ->findAll();
    }
    public function getActiveSubcategories()
{
    return $this->where('is_active', true)
                ->orderBy('subcategory_name', 'ASC')
                ->findAll();
}

    public function getSubcategoryWithCategory($id)
    {
        return $this->select('subcategories.*, categories.category_name')
                    ->join('categories', 'categories.id = subcategories.category_id')
                    ->where('subcategories.id', $id)
                    ->first();
    }
}