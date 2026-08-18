<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['tenant_id', 'category_id', 'subcategory_id', 'product_name', 'product_description', 'price', 'old_price', 'quantity', 'product_image', 'status', 'is_active'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public function getPublishedProducts()
    {
        return $this->where('is_active', true)
                    ->where('status', 'published')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getProductsByCategory($categoryId)
    {
        return $this->where('category_id', $categoryId)
                    ->where('is_active', true)
                    ->where('status', 'published')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getProductsBySubcategory($subcategoryId)
    {
        return $this->where('subcategory_id', $subcategoryId)
                    ->where('is_active', true)
                    ->where('status', 'published')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getProductsByTenant($tenantId)
    {
        return $this->where('tenant_id', $tenantId)
                    ->where('is_active', true)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function searchProducts($keyword)
    {
        return $this->like('product_name', $keyword)
                    ->orLike('product_description', $keyword)
                    ->where('is_active', true)
                    ->where('status', 'published')
                    ->findAll();
    }

    public function getProductWithDetails($id)
    {
        return $this->select('products.*, categories.category_name, subcategories.subcategory_name, tenants.store_name')
                    ->join('categories', 'categories.id = products.category_id')
                    ->join('subcategories', 'subcategories.id = products.subcategory_id', 'left')
                    ->join('tenants', 'tenants.id = products.tenant_id')
                    ->where('products.id', $id)
                    ->first();
    }

    public function getBestSellingProducts($tenantId = null, $limit = 10)
    {
        $builder = $this->db->table('order_items')
                           ->select('products.id, products.product_name, products.product_image, products.price, SUM(order_items.quantity) as total_sold')
                           ->join('products', 'products.id = order_items.product_id')
                           ->groupBy('products.id, products.product_name, products.product_image, products.price')
                           ->orderBy('total_sold', 'DESC')
                           ->limit($limit);
        
        if ($tenantId) {
            $builder->where('products.tenant_id', $tenantId);
        }
        
        return $builder->get()->getResultArray();
    }
}