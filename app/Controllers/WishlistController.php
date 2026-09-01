<?php
namespace App\Controllers;

use App\Models\WishlistModel;
use App\Models\ProductModel;

class WishlistController extends BaseController
{
    protected $wishlistModel;
    protected $productModel;

    public function __construct()
    {
        $this->wishlistModel = new WishlistModel();
        $this->productModel = new ProductModel();
    }

    // ============================================
    // VIEW WISHLIST PAGE
    // ============================================

    public function index()
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');
        
        if (!$customerId) {
            return redirect()->to('/login')->with('error', 'Please login to view your wishlist.');
        }

        $wishlistItems = $this->wishlistModel
            ->select('wishlist.*, products.product_name, products.price, products.product_image, products.category_id')
            ->join('products', 'products.id = wishlist.product_id')
            ->where('wishlist.customer_id', $customerId)
            ->orderBy('wishlist.created_at', 'DESC')
            ->findAll();

   return redirect()->to('/dashboard#wishlist');
    }

    // ============================================
    // ADD TO WISHLIST (API)
    // ============================================

    public function add()
    {
        // Get customer ID from session
        $customerId = session()->get('customer_id') ?? session()->get('user_id');

        // Check if user is logged in
        if (!$customerId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login to add items to wishlist',
                'redirect' => '/login'
            ]);
        }

        // Try every common way product_id might arrive
        $productId = $this->request->getPost('product_id');

        if (!$productId) {
            $json = $this->request->getJSON(true); // true = return as array
            $productId = $json['product_id'] ?? null;
        }

        if (!$productId) {
            $productId = $this->request->getVar('product_id');
        }

        // Debug log so we can see exactly what arrived if this ever fails again
        log_message('debug', 'Wishlist add() received: ' . json_encode([
            'post' => $this->request->getPost(),
            'raw_body' => $this->request->getBody(),
            'content_type' => $this->request->getHeaderLine('Content-Type'),
            'product_id_found' => $productId
        ]));

        if (!$productId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product ID is required'
            ]);
        }

        // Check if product exists
        $product = $this->productModel->find($productId);
        if (!$product) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product not found'
            ]);
        }

        // Check if already in wishlist
        $existing = $this->wishlistModel
            ->where('customer_id', $customerId)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Item already in your wishlist'
            ]);
        }

        // Add to wishlist (no user_id column exists on this table, so it's omitted)
        $data = [
            'customer_id' => $customerId,
            'product_id' => $productId,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $inserted = $this->wishlistModel->insert($data);

        if ($inserted) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Added to wishlist successfully'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to add to wishlist. Please try again.',
                'errors' => $this->wishlistModel->errors()
            ]);
        }
    }

    // ============================================
    // REMOVE FROM WISHLIST (API)
    // ============================================

    public function remove($wishlistId)
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');
        
        if (!$customerId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login'
            ]);
        }

        $item = $this->wishlistModel
            ->where('id', $wishlistId)
            ->where('customer_id', $customerId)
            ->first();

        if (!$item) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Item not found in wishlist'
            ]);
        }

        $deleted = $this->wishlistModel->delete($wishlistId);

        if ($deleted) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Removed from wishlist'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to remove from wishlist'
            ]);
        }
    }

    // ============================================
    // GET WISHLIST COUNT (API)
    // ============================================

    public function count()
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');
        
        if (!$customerId) {
            return $this->response->setJSON([
                'success' => true,
                'count' => 0
            ]);
        }

        $count = $this->wishlistModel
            ->where('customer_id', $customerId)
            ->countAllResults();

        return $this->response->setJSON([
            'success' => true,
            'count' => $count
        ]);
    }

    // ============================================
    // CHECK IF PRODUCT IS IN WISHLIST (API)
    // ============================================

    public function check($productId)
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');
        
        if (!$customerId) {
            return $this->response->setJSON([
                'success' => true,
                'in_wishlist' => false
            ]);
        }

        $exists = $this->wishlistModel
            ->where('customer_id', $customerId)
            ->where('product_id', $productId)
            ->first();

        return $this->response->setJSON([
            'success' => true,
            'in_wishlist' => $exists !== null
        ]);
    }
}