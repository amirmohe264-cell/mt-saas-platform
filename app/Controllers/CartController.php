<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CartModel;

class CartController extends BaseController
{
    protected $productModel;
    protected $cartModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->cartModel = new CartModel();
    }

    public function index()
    {
        // Get customer ID
        $customerId = session()->get('customer_id');
        
        if (!$customerId) {
            $customerId = session()->get('user_id');
        }
        
        if (!$customerId) {
            return redirect()->to('/login')->with('error', 'Please login to view your cart.');
        }

        // Get cart items
        $cartItems = $this->cartModel->getCartByCustomer($customerId);

        // Calculate totals
        $subtotal = 0;
        $itemCount = 0;
        
        if (!empty($cartItems)) {
            foreach ($cartItems as &$item) {
                $item['subtotal'] = $item['price'] * $item['quantity'];
                $subtotal += $item['subtotal'];
                $itemCount += $item['quantity'];
            }
        }

        $shipping = ($subtotal > 50) ? 0 : 5.00;
        $tax = $subtotal * 0.08;
        $grandTotal = $subtotal + $shipping + $tax;

        // Update session cart count
        session()->set('cart_count', $itemCount);

        // Debug: Log what's being sent to view
        log_message('debug', 'Cart Items count: ' . count($cartItems));
        log_message('debug', 'Item Count: ' . $itemCount);
        log_message('debug', 'Subtotal: ' . $subtotal);

        // Pass data to view
        return view('public/cart', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'grandTotal' => $grandTotal,
            'itemCount' => $itemCount,
        ]);
    }

    public function add()
    {
        $customerId = session()->get('customer_id');
        
        if (!$customerId) {
            $customerId = session()->get('user_id');
        }
        
        if (!$customerId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login to add items to cart.',
                'redirect' => '/login'
            ]);
        }

        $productId = $this->request->getPost('product_id');
        $quantity = (int) $this->request->getPost('quantity') ?: 1;

        $product = $this->productModel->find($productId);
        if (!$product) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product not found.'
            ]);
        }

        if ($product['quantity'] < $quantity) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Not enough stock. Available: ' . $product['quantity']
            ]);
        }

        $result = $this->cartModel->addOrUpdateItem($customerId, $productId, $quantity);

        if (!$result) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to add item to cart.'
            ]);
        }

        $cartCount = $this->cartModel->getCartItemCount($customerId);
        session()->set('cart_count', $cartCount);

        return $this->response->setJSON([
            'success' => true,
            'message' => '✅ Product added to cart!',
            'cart_count' => $cartCount,
        ]);
    }

    public function update()
    {
        $customerId = session()->get('customer_id');
        
        if (!$customerId) {
            $customerId = session()->get('user_id');
        }
        
        if (!$customerId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login.'
            ]);
        }

        $productId = $this->request->getPost('product_id');
        $quantity = (int) $this->request->getPost('quantity');

        if ($quantity <= 0) {
            return $this->remove($productId);
        }

        $result = $this->cartModel->addOrUpdateItem($customerId, $productId, $quantity);

        if (!$result) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update cart.'
            ]);
        }

        $cartCount = $this->cartModel->getCartItemCount($customerId);
        session()->set('cart_count', $cartCount);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Cart updated!',
            'cart_count' => $cartCount,
        ]);
    }

    public function remove($productId = null)
    {
        if (!$productId) {
            $productId = $this->request->getPost('product_id');
        }

        $customerId = session()->get('customer_id');
        
        if (!$customerId) {
            $customerId = session()->get('user_id');
        }
        
        if (!$customerId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login.'
            ]);
        }

        $result = $this->cartModel->removeItem($customerId, $productId);

        if (!$result) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to remove item.'
            ]);
        }

        $cartCount = $this->cartModel->getCartItemCount($customerId);
        session()->set('cart_count', $cartCount);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Item removed!',
            'cart_count' => $cartCount,
        ]);
    }

    public function count()
    {
        $customerId = session()->get('customer_id');
        
        if (!$customerId) {
            $customerId = session()->get('user_id');
        }
        
        $count = 0;

        if ($customerId) {
            $count = $this->cartModel->getCartItemCount($customerId);
        }

        return $this->response->setJSON([
            'success' => true,
            'count' => $count
        ]);
    }

    public function getCartTotals()
    {
        $customerId = session()->get('customer_id');
        
        if (!$customerId) {
            $customerId = session()->get('user_id');
        }
        
        if (!$customerId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login.'
            ]);
        }

        $cartItems = $this->cartModel->getCartByCustomer($customerId);
        $subtotal = 0;
        $itemCount = 0;

        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $itemCount += $item['quantity'];
        }

        $shipping = ($subtotal > 50) ? 0 : 5.00;
        $tax = $subtotal * 0.08;
        $grandTotal = $subtotal + $shipping + $tax;

        return $this->response->setJSON([
            'success' => true,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'grandTotal' => $grandTotal,
            'itemCount' => $itemCount,
        ]);
    }

    public function clear()
    {
        $customerId = session()->get('customer_id');
        
        if (!$customerId) {
            $customerId = session()->get('user_id');
        }
        
        if ($customerId) {
            $this->cartModel->where('customer_id', $customerId)->delete();
        }

        session()->set('cart_count', 0);

        return redirect()->to('/cart')->with('success', 'Cart cleared!');
    }

    public function updateSession()
    {
        $count = $this->request->getPost('cart_count');
        session()->set('cart_count', $count);
        
        return $this->response->setJSON([
            'success' => true
        ]);
    }
}