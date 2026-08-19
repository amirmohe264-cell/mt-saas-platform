<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tenant_id',
        'category_id',
        'subcategory_id',
        'product_name',
        'product_description',
        'price',
        'old_price',
        'quantity',
        'product_image',
        'status',
        'is_active',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // ✅ FIXED: Use true instead of 1
    public function getPublishedProducts()
    {
        return $this->where('status', 'published')
                    ->where('is_active', true)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    // ✅ FIXED: Use true instead of 1
    public function getProductsByCategory($categoryId)
    {
        return $this->where('category_id', $categoryId)
                    ->where('status', 'published')
                    ->where('is_active', true)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    // ✅ FIXED: Use true instead of 1
    public function searchProducts($keyword)
    {
        if (empty($keyword)) {
            return $this->getPublishedProducts();
        }
        
        return $this->like('product_name', $keyword)
                    ->orLike('product_description', $keyword)
                    ->where('status', 'published')
                    ->where('is_active', true)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    // ✅ NEW: Get best selling products (Fixes Dashboard 500 error)
    public function getBestSellingProducts($tenantId, $limit = 5)
    {
        // If you have an order_items table with quantity
        return $this->select('products.*, COALESCE(SUM(order_items.quantity), 0) as total_sold')
                    ->join('order_items', 'order_items.product_id = products.id', 'left')
                    ->where('products.tenant_id', $tenantId)
                    ->where('products.is_active', true)
                    ->where('products.status', 'published')
                    ->groupBy('products.id')
                    ->orderBy('total_sold', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    // ✅ NEW: Get total products count
    public function getTotalProducts($tenantId)
    {
        return $this->where('tenant_id', $tenantId)
                    ->where('is_active', true)
                    ->countAllResults();
    }

    // ✅ NEW: Get low stock products
    public function getLowStockProducts($tenantId, $threshold = 5)
    {
        return $this->where('tenant_id', $tenantId)
                    ->where('quantity <=', $threshold)
                    ->where('is_active', true)
                    ->where('status', 'published')
                    ->orderBy('quantity', 'ASC')
                    ->findAll();
    }

    // ✅ NEW: Get total revenue (if you have orders)
    public function getTotalRevenue($tenantId)
    {
        // If you have an orders table
        $result = $this->db->table('orders')
                           ->select('COALESCE(SUM(total_amount), 0) as total')
                           ->where('tenant_id', $tenantId)
                           ->where('status', 'completed')
                           ->get()
                           ->getRow();
        
        return $result->total ?? 0;
    }
}