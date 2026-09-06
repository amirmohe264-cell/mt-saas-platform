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

    /**
     * Builds a cart-items array (matching the DB cart's shape) from the
     * guest session cart, so the view doesn't need to know the difference.
     */
    private function buildGuestCartItems()
    {
        $guestCart = session()->get('guest_cart') ?? [];
        $items = [];

        foreach ($guestCart as $productId => $quantity) {
            $product = $this->productModel->find($productId);
            if (!$product) {
                continue;
            }

            $items[] = [
                'product_id' => $product['id'],
                'product_name' => $product['product_name'],
                'price' => $product['price'],
                'product_image' => $product['product_image'],
                'quantity' => $quantity,
                'stock' => $product['quantity'],
            ];
        }

        return $items;
    }

    private function getGuestCartCount()
    {
        $guestCart = session()->get('guest_cart') ?? [];
        return array_sum($guestCart);
    }

    public function index()
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');

        if ($customerId) {
            $cartItems = $this->cartModel->getCartByCustomer($customerId);
        } else {
            $cartItems = $this->buildGuestCartItems();
        }

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

        session()->set('cart_count', $itemCount);

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
        $customerId = session()->get('customer_id') ?? session()->get('user_id');

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

        if ($customerId) {
            $result = $this->cartModel->addOrUpdateItem($customerId, $productId, $quantity);

            if (!$result) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to add item to cart.'
                ]);
            }

            $cartCount = $this->cartModel->getCartItemCount($customerId);
        } else {
            $guestCart = session()->get('guest_cart') ?? [];
            $guestCart[$productId] = ($guestCart[$productId] ?? 0) + $quantity;
            session()->set('guest_cart', $guestCart);
            $cartCount = $this->getGuestCartCount();
        }

        session()->set('cart_count', $cartCount);

        return $this->response->setJSON([
            'success' => true,
            'message' => '✅ Product added to cart!',
            'cart_count' => $cartCount,
        ]);
    }

    public function update()
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');

        $productId = $this->request->getPost('product_id');
        $quantity = (int) $this->request->getPost('quantity');

        if ($quantity <= 0) {
            return $this->remove($productId);
        }

        if ($customerId) {
            $result = $this->cartModel->addOrUpdateItem($customerId, $productId, $quantity);

            if (!$result) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to update cart.'
                ]);
            }

            $cartCount = $this->cartModel->getCartItemCount($customerId);
        } else {
            $guestCart = session()->get('guest_cart') ?? [];
            $guestCart[$productId] = $quantity;
            session()->set('guest_cart', $guestCart);
            $cartCount = $this->getGuestCartCount();
        }

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

        $customerId = session()->get('customer_id') ?? session()->get('user_id');

        if ($customerId) {
            $result = $this->cartModel->removeItem($customerId, $productId);

            if (!$result) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to remove item.'
                ]);
            }

            $cartCount = $this->cartModel->getCartItemCount($customerId);
        } else {
            $guestCart = session()->get('guest_cart') ?? [];
            unset($guestCart[$productId]);
            session()->set('guest_cart', $guestCart);
            $cartCount = $this->getGuestCartCount();
        }

        session()->set('cart_count', $cartCount);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Item removed!',
            'cart_count' => $cartCount,
        ]);
    }

    public function count()
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');

        $count = $customerId
            ? $this->cartModel->getCartItemCount($customerId)
            : $this->getGuestCartCount();

        return $this->response->setJSON([
            'success' => true,
            'count' => $count
        ]);
    }

    public function getCartTotals()
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');

        $cartItems = $customerId
            ? $this->cartModel->getCartByCustomer($customerId)
            : $this->buildGuestCartItems();

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
        $customerId = session()->get('customer_id') ?? session()->get('user_id');

        if ($customerId) {
            $this->cartModel->where('customer_id', $customerId)->delete();
        } else {
            session()->remove('guest_cart');
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