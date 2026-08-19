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

    // ✅ FIXED: Use PostgreSQL boolean syntax
    public function getActiveCategories()
    {
        return $this->where('is_active', true)  // ✅ Changed from 1 to true
                    ->orderBy('category_name', 'ASC')
                    ->findAll();
    }
}