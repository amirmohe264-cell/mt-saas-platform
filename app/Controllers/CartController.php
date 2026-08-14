<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\ProductModel;

class CartController extends BaseController
{
    protected $cartModel;
    protected $productModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $customerId = session()->get('user_id');
        
        if (!$customerId) {
            return redirect()->to('/login')->with('error', 'Please login to view your cart.');
        }

        $cartItems = $this->cartModel->getCartByCustomer($customerId);
        $cartTotal = $this->cartModel->getCartTotal($customerId);
        $itemCount = $this->cartModel->getCartItemCount($customerId);

        // Calculate subtotal, shipping, tax
        $subtotal = $cartTotal;
        $shipping = $subtotal > 50 ? 0 : 5.00;
        $tax = $subtotal * 0.08;
        $grandTotal = $subtotal + $shipping + $tax;

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
    try {
        $customerId = session()->get('user_id');
        
        if (!$customerId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login to add items to cart.'
            ]);
        }

        $productId = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity') ?? 1;

        if (!$productId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product ID is required.'
            ]);
        }

        // Check if product exists and has stock
        $productModel = new \App\Models\ProductModel();
        $product = $productModel->find($productId);
        
        if (!$product) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product not found.'
            ]);
        }

        if ($product['quantity'] < $quantity) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Not enough stock available. Only ' . $product['quantity'] . ' left.'
            ]);
        }

        // Debug: Log the data
        log_message('debug', 'Adding to cart - Customer: ' . $customerId . ', Product: ' . $productId . ', Quantity: ' . $quantity);

        $result = $this->cartModel->addOrUpdateItem($customerId, $productId, $quantity);

        if ($result) {
            $itemCount = $this->cartModel->getCartItemCount($customerId);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Product added to cart successfully!',
                'cart_count' => $itemCount
            ]);
        } else {
            // Get the error
            $error = $this->cartModel->errors();
            log_message('error', 'Cart insert failed: ' . print_r($error, true));
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to add product to cart. Error: ' . print_r($error, true)
            ]);
        }
    } catch (\Exception $e) {
        log_message('error', 'Cart exception: ' . $e->getMessage());
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
}

    public function update()
    {
        $customerId = session()->get('user_id');
        
        if (!$customerId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login to update your cart.'
            ]);
        }

        $productId = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity');

        if (!$productId || $quantity === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product ID and quantity are required.'
            ]);
        }

        $result = $this->cartModel->addOrUpdateItem($customerId, $productId, $quantity);

        if ($result) {
            $cartTotal = $this->cartModel->getCartTotal($customerId);
            $itemCount = $this->cartModel->getCartItemCount($customerId);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Cart updated successfully!',
                'cart_total' => $cartTotal,
                'cart_count' => $itemCount
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update cart.'
            ]);
        }
    }

    public function remove()
    {
        $customerId = session()->get('user_id');
        
        if (!$customerId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login to remove items from cart.'
            ]);
        }

        $productId = $this->request->getPost('product_id');

        if (!$productId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product ID is required.'
            ]);
        }

        $result = $this->cartModel->removeItem($customerId, $productId);

        if ($result) {
            $itemCount = $this->cartModel->getCartItemCount($customerId);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Item removed from cart!',
                'cart_count' => $itemCount
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to remove item from cart.'
            ]);
        }
    }
    public function getCartTotals()
{
    $customerId = session()->get('user_id');
    
    if (!$customerId) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Please login.'
        ]);
    }

    $cartItems = $this->cartModel->getCartByCustomer($customerId);
    $subtotal = $this->cartModel->getCartTotal($customerId);
    $itemCount = $this->cartModel->getCartItemCount($customerId);
    
    $shipping = $subtotal > 50 ? 0 : 5.00;
    $tax = $subtotal * 0.08;
    $grandTotal = $subtotal + $shipping + $tax;

    return $this->response->setJSON([
        'success' => true,
        'subtotal' => $subtotal,
        'shipping' => $shipping,
        'tax' => $tax,
        'grandTotal' => $grandTotal,
        'itemCount' => $itemCount
    ]);
}

    public function getCartCount()
    {
        $customerId = session()->get('user_id');
        
        if (!$customerId) {
            return $this->response->setJSON([
                'success' => true,
                'count' => 0
            ]);
        }

        $count = $this->cartModel->getCartItemCount($customerId);
        
        return $this->response->setJSON([
            'success' => true,
            'count' => $count
        ]);
    }
}