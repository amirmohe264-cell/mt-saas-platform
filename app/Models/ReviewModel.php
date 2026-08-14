<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table            = 'reviews';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['product_id', 'customer_id', 'rating', 'review_title', 'review_comment', 'is_approved'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public function getReviewsByProduct($productId)
    {
        return $this->select('reviews.*, customers.first_name, customers.last_name')
                    ->join('customers', 'customers.id = reviews.customer_id')
                    ->where('reviews.product_id', $productId)
                    ->where('reviews.is_approved', true)
                    ->orderBy('reviews.created_at', 'DESC')
                    ->get()
                    ->getResultArray();
    }

    public function getAverageRating($productId)
    {
        $result = $this->select('AVG(rating) as average, COUNT(*) as total')
                       ->where('product_id', $productId)
                       ->where('is_approved', true)
                       ->get()
                       ->getRowArray();
        
        return [
            'average' => round($result['average'] ?? 0, 1),
            'total' => $result['total'] ?? 0
        ];
    }

    public function hasPurchased($customerId, $productId)
    {
        return $this->db->table('order_items')
                        ->join('orders', 'orders.id = order_items.order_id')
                        ->where('orders.customer_id', $customerId)
                        ->where('order_items.product_id', $productId)
                        ->where('orders.order_status', 'delivered')
                        ->countAllResults() > 0;
    }
}