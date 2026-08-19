<?php

namespace App\Models;

use CodeIgniter\Model;

class SubcategoryModel extends Model
{
    protected $table = 'subcategories';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tenant_id', 
        'category_id', 
        'subcategory_name', 
        'subcategory_slug', 
        'subcategory_description',
        'is_active',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Get subcategories for a specific tenant
    public function getSubcategoriesByTenant($tenantId)
    {
        return $this->where('tenant_id', $tenantId)
                    ->where('is_active', true)
                    ->orderBy('subcategory_name', 'ASC')
                    ->findAll();
    }

    // Get active subcategories for public view
    public function getActiveSubcategories()
    {
        return $this->where('is_active', true)
                    ->orderBy('subcategory_name', 'ASC')
                    ->findAll();
    }

    // Get subcategories by category ID
    public function getSubcategoriesByCategory($categoryId, $tenantId = null)
    {
        $this->where('category_id', $categoryId)
             ->where('is_active', true);
        
        if ($tenantId) {
            $this->where('tenant_id', $tenantId);
        }
        
        return $this->orderBy('subcategory_name', 'ASC')
                    ->findAll();
    }

    // ✅ NEW: Get subcategories with category name (Fixes Subcategory page)
    public function getSubcategoriesWithCategory($tenantId)
    {
        return $this->select('subcategories.*, categories.category_name')
                    ->join('categories', 'categories.id = subcategories.category_id')
                    ->where('subcategories.tenant_id', $tenantId)
                    ->orderBy('subcategories.subcategory_name', 'ASC')
                    ->findAll();
    }

    // Check if subcategory exists
    public function subcategoryExists($name, $tenantId, $categoryId)
    {
        return $this->where('subcategory_name', $name)
                    ->where('tenant_id', $tenantId)
                    ->where('category_id', $categoryId)
                    ->first() ? true : false;
    }
}