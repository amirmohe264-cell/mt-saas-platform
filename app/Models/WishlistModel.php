<?php

namespace App\Models;

use CodeIgniter\Model;

class WishlistModel extends Model
{
    protected $table            = 'wishlist';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['customer_id', 'product_id'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';

    public function getWishlistByCustomer($customerId)
    {
        return $this->select('wishlist.*, products.product_name, products.price, products.product_image')
                    ->join('products', 'products.id = wishlist.product_id')
                    ->where('wishlist.customer_id', $customerId)
                    ->get()
                    ->getResultArray();
    }

    public function isInWishlist($customerId, $productId)
    {
        return $this->where('customer_id', $customerId)
                    ->where('product_id', $productId)
                    ->countAllResults() > 0;
    }

    public function toggleWishlist($customerId, $productId)
    {
        $existing = $this->where('customer_id', $customerId)
                         ->where('product_id', $productId)
                         ->first();
        
        if ($existing) {
            $this->delete($existing['id']);
            return false; // Removed from wishlist
        } else {
            $this->insert(['customer_id' => $customerId, 'product_id' => $productId]);
            return true; // Added to wishlist
        }
    }
}