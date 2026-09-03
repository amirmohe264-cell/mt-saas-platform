<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'category_name',
        'category_slug',
        'category_description',
        'category_image',
        'is_active',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getActiveCategories()
    {
        return $this->where('is_active', true)
                    ->orderBy('category_name', 'ASC')
                    ->findAll();
    }

  public function getCategoryWithProductCount()
{
    return $this->select(
        'categories.*, 
         COUNT(products.id) FILTER (WHERE products.is_active = TRUE) AS product_count',
        false
    )
    ->join(
        'products',
        'products.category_id = categories.id',
        'left'
    )
    ->groupBy('categories.id')
    ->orderBy('categories.category_name', 'ASC')
    ->findAll();
}
}