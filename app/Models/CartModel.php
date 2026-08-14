<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table            = 'cart';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['customer_id', 'product_id', 'quantity'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public function getCartByCustomer($customerId)
    {
        return $this->select('cart.*, products.product_name, products.price, products.product_image, products.quantity as stock')
                    ->join('products', 'products.id = cart.product_id')
                    ->where('cart.customer_id', $customerId)
                    ->findAll();
    }

    public function getCartTotal($customerId)
    {
        $result = $this->select('SUM(cart.quantity * products.price) as total')
                       ->join('products', 'products.id = cart.product_id')
                       ->where('cart.customer_id', $customerId)
                       ->first();
        
        return $result['total'] ?? 0;
    }

    public function getCartItemCount($customerId)
    {
        $result = $this->select('SUM(quantity) as total')
                       ->where('customer_id', $customerId)
                       ->first();
        
        return $result['total'] ?? 0;
    }

    public function addOrUpdateItem($customerId, $productId, $quantity)
    {
        // Check if item already exists
        $existing = $this->where('customer_id', $customerId)
                         ->where('product_id', $productId)
                         ->first();
        
        if ($existing) {
            if ($quantity <= 0) {
                return $this->where('customer_id', $customerId)
                           ->where('product_id', $productId)
                           ->delete();
            }
            return $this->update($existing['id'], ['quantity' => $quantity]);
        }
        
        if ($quantity > 0) {
            return $this->insert([
                'customer_id' => $customerId,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }
        
        return false;
    }

    public function removeItem($customerId, $productId)
    {
        return $this->where('customer_id', $customerId)
                    ->where('product_id', $productId)
                    ->delete();
    }
}