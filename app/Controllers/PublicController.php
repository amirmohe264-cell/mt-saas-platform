<?php
namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\WishlistModel;
use App\Models\CartModel;
use App\Models\ProductModel;

class PublicController extends BaseController
{
    // ... your existing methods ...

    // ============================================
    // ORDER API METHODS FOR DASHBOARD
    // ============================================

    public function getOrders()
    {
        $customerId = session()->get('customer_id');
        $userId = session()->get('user_id');
        $id = $customerId ?: $userId;
        
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'orders' => []
            ]);
        }
        
        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();
        
        // Get orders for this customer
        $orders = $orderModel
            ->where('customer_id', $id)
            ->orderBy('created_at', 'DESC')
            ->findAll();
        
        if (empty($orders)) {
            return $this->response->setJSON([
                'success' => true,
                'orders' => []
            ]);
        }
        
        // Get order items for each order
    $deliveryTrackingModel = new \App\Models\DeliveryTrackingModel();

foreach ($orders as &$order) {
    $order['items'] = $orderItemModel
        ->where('order_id', $order['id'])
        ->findAll();
    
    $order['date_formatted'] = date('F j, Y', strtotime($order['created_at']));
    $order['status_label'] = ucfirst($order['order_status'] ?? 'pending');
    $order['status_icon'] = $this->getStatusIcon($order['order_status'] ?? 'pending');

    $tracking = $deliveryTrackingModel->where('order_id', $order['id'])->first();
    $order['delivery_confirmed'] = $tracking ? (bool) $tracking['confirmed_by_customer'] : false;
}
        
        return $this->response->setJSON([
            'success' => true,
            'orders' => $orders
        ]);
    }

    public function getOrderDetail($orderId)
    {
        $customerId = session()->get('customer_id');
        $userId = session()->get('user_id');
        $id = $customerId ?: $userId;
        
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User not logged in'
            ]);
        }
        
        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();
        
        $order = $orderModel
            ->where('id', $orderId)
            ->where('customer_id', $id)
            ->first();
        
        if (!$order) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Order not found'
            ]);
        }
        
        $order['items'] = $orderItemModel
            ->where('order_id', $orderId)
            ->findAll();
        
        $order['date_formatted'] = date('F j, Y', strtotime($order['created_at']));
        $order['status_label'] = ucfirst($order['order_status'] ?? 'pending');
        $order['status_icon'] = $this->getStatusIcon($order['order_status'] ?? 'pending');
        
        return $this->response->setJSON([
            'success' => true,
            'order' => $order
        ]);
    }

    public function cancelOrder($orderId)
    {
        $customerId = session()->get('customer_id');
        $userId = session()->get('user_id');
        $id = $customerId ?: $userId;
        
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User not logged in'
            ]);
        }
        
        $orderModel = new OrderModel();
        
        $order = $orderModel
            ->where('id', $orderId)
            ->where('customer_id', $id)
            ->first();
        
        if (!$order) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Order not found'
            ]);
        }
        
        // Only allow cancellation for pending orders
        if (!in_array($order['order_status'], ['pending', 'confirmed'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Only pending or confirmed orders can be cancelled'
            ]);
        }
        
        $orderModel->update($orderId, ['order_status' => 'cancelled']);
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Order cancelled successfully'
        ]);
    }

    // ============================================
    // WISHLIST API METHODS FOR DASHBOARD
    // ============================================

 public function getWishlist()
{
    $customerId = session()->get('customer_id');
    $userId = session()->get('user_id');
    $id = $customerId ?: $userId;
    
    if (!$id) {
        return $this->response->setJSON([
            'success' => false,
            'items' => []
        ]);
    }
    
    $wishlistModel = new WishlistModel();
    
    // Get wishlist items with product details
    try {
        $wishlistItems = $wishlistModel
            ->select('wishlist.*, products.product_name, products.price, products.product_image, products.category_id')
            ->join('products', 'products.id = wishlist.product_id')
            ->where('wishlist.customer_id', $id)
            ->orderBy('wishlist.created_at', 'DESC')
            ->findAll();
    } catch (\Exception $e) {
        log_message('error', 'Wishlist fetch error: ' . $e->getMessage());
        return $this->response->setJSON([
            'success' => false,
            'items' => [],
            'debug' => $e->getMessage()
        ]);
    }
    
    $formattedItems = [];
    foreach ($wishlistItems as $item) {
        $formattedItems[] = [
            'id' => $item['id'],
            'product_id' => $item['product_id'],
            'name' => $item['product_name'],
            'price' => $item['price'],
            'icon' => $this->getProductIcon($item['product_name']),
            'category' => $this->getCategoryName($item['category_id']),
            'image' => $item['product_image'],
            'added_date' => $item['created_at'],
            'added_formatted' => date('F j, Y', strtotime($item['created_at']))
        ];
    }
    
    return $this->response->setJSON([
        'success' => true,
        'items' => $formattedItems
    ]);
}
    public function removeFromWishlist($wishlistId)
    {
        $customerId = session()->get('customer_id');
        $userId = session()->get('user_id');
        $id = $customerId ?: $userId;
        
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User not logged in'
            ]);
        }
        
        $wishlistModel = new WishlistModel();
        
        $item = $wishlistModel
            ->where('id', $wishlistId)
            ->where('customer_id', $id)
            ->first();
        
        if (!$item) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Item not found in wishlist'
            ]);
        }
        
        $wishlistModel->delete($wishlistId);
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Removed from wishlist successfully'
        ]);
    }

    // ============================================
    // CART API METHODS
    // ============================================

    public function getCartCount()
    {
        $customerId = session()->get('customer_id');
        $userId = session()->get('user_id');
        $id = $customerId ?: $userId;
        
        if (!$id) {
            return $this->response->setJSON([
                'success' => true,
                'count' => 0
            ]);
        }
        
        $cartModel = new CartModel();
        $cartItems = $cartModel
            ->where('customer_id', $id)
            ->findAll();
        
        $count = 0;
        foreach ($cartItems as $item) {
            $count += $item['quantity'];
        }
        
        return $this->response->setJSON([
            'success' => true,
            'count' => $count
        ]);
    }
    public function confirmDelivery($orderId)
{
    $customerId = session()->get('customer_id');
    $userId = session()->get('user_id');
    $id = $customerId ?: $userId;

    if (!$id) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'User not logged in'
        ]);
    }

    $orderModel = new OrderModel();
    $deliveryTrackingModel = new \App\Models\DeliveryTrackingModel();

    $order = $orderModel
        ->where('id', $orderId)
        ->where('customer_id', $id)
        ->first();

    if (!$order) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Order not found'
        ]);
    }

    if ($order['order_status'] !== 'delivered') {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'This order has not been marked as delivered yet.'
        ]);
    }

    $tracking = $deliveryTrackingModel->where('order_id', $orderId)->first();

    if (!$tracking) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Delivery record not found for this order.'
        ]);
    }

    if ($tracking['confirmed_by_customer']) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'You have already confirmed this delivery.'
        ]);
    }

    $deliveryTrackingModel->update($tracking['id'], [
        'confirmed_by_customer' => true,
        'confirmed_at' => date('Y-m-d H:i:s'),
        'confirmation_method' => 'customer_dashboard',
    ]);

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Thank you! Delivery confirmed. The store owner will be paid once admin releases the payment.'
    ]);
}
public function addToCart()
{
    $customerId = session()->get('customer_id');
    $userId = session()->get('user_id');
    $id = $customerId ?: $userId;
    
    if (!$id) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Please login first'
        ]);
    }
    
    $input = $this->request->getJSON(true);
    $productId = $input['product_id'] ?? null;
    $quantity = $input['quantity'] ?? 1;
    
    if (!$productId) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Product ID is required'
        ]);
    }
    
    $cartModel = new CartModel();
    
    // Check if already in cart
    $existing = $cartModel
        ->where('customer_id', $id)
        ->where('product_id', $productId)
        ->first();
    
    if ($existing) {
        // Update quantity
        $cartModel->update($existing['id'], [
            'quantity' => $existing['quantity'] + $quantity
        ]);
    } else {
        // Insert new
        $cartModel->insert([
            'customer_id' => $id,
            'product_id' => $productId,
            'quantity' => $quantity
        ]);
    }
    
    // Get updated count
    $cartItems = $cartModel
        ->where('customer_id', $id)
        ->findAll();
    
    $count = 0;
    foreach ($cartItems as $item) {
        $count += $item['quantity'];
    }
    
    session()->set('cart_count', $count);
    
    return $this->response->setJSON([
        'success' => true,
        'message' => 'Added to cart successfully',
        'count' => $count
    ]);
}
  

    // ============================================
    // HELPER METHODS
    // ============================================

    private function getStatusIcon($status)
    {
        $icons = [
            'pending' => 'fa-clock',
            'confirmed' => 'fa-check-circle',
            'processing' => 'fa-spinner',
            'shipped' => 'fa-truck',
            'delivered' => 'fa-check-double',
            'cancelled' => 'fa-times-circle'
        ];
        return $icons[$status] ?? 'fa-circle';
    }

    private function getProductIcon($name)
    {
        $name = strtolower($name);
        if (strpos($name, 'headphone') !== false) return '🎧';
        if (strpos($name, 'watch') !== false) return '⌚';
        if (strpos($name, 'backpack') !== false) return '🎒';
        if (strpos($name, 'speaker') !== false) return '🔊';
        if (strpos($name, 'phone') !== false) return '📱';
        if (strpos($name, 'mouse') !== false) return '🖱️';
        if (strpos($name, 'keyboard') !== false) return '⌨️';
        if (strpos($name, 'lamp') !== false) return '💡';
        if (strpos($name, 'cable') !== false) return '🔌';
        if (strpos($name, 'monitor') !== false) return '🖥️';
        return '📦';
    }

    private function getCategoryName($categoryId)
{
    if (!$categoryId) return 'General';
    $categoryModel = new \App\Models\CategoryModel();
    $category = $categoryModel->find($categoryId);
    return $category['category_name'] ?? 'General';
}
}