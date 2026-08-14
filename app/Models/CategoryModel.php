<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['category_name', 'category_description', 'category_image', 'is_active'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public function getActiveCategories()
    {
        return $this->where('is_active', true)
                    ->orderBy('category_name', 'ASC')
                    ->findAll();
    }

    public function getCategoryWithProductCount()
    {
        return $this->select('categories.*, COUNT(products.id) as product_count')
                    ->join('products', 'products.category_id = categories.id', 'left')
                    ->where('categories.is_active', true)
                    ->groupBy('categories.id')
                    ->orderBy('category_name', 'ASC')
                    ->get()
                    ->getResultArray();
    }

    public function findBySlug($slug)
    {
        $categoryName = str_replace('-', ' ', $slug);
        return $this->where('category_name', $categoryName)
                    ->where('is_active', true)
                    ->first();
    }
}