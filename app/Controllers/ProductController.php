<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\SubcategoryModel;

class ProductController extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $subcategoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->subcategoryModel = new SubcategoryModel();
    }

    // ============ PUBLIC VIEWS ============

    public function index()
    {
        try {
            $products = $this->productModel->getPublishedProducts();
            $subcategories = $this->subcategoryModel->getActiveSubcategories();
            
            $formattedProducts = [];
            foreach ($products as $product) {
                $category = $this->categoryModel->find($product['category_id']);
                $subcategory = null;
                if ($product['subcategory_id']) {
                    $subcategory = $this->subcategoryModel->find($product['subcategory_id']);
                }
                
                $formattedProducts[] = [
                    'id' => $product['id'],
                    'name' => $product['product_name'],
                    'slug' => strtolower(str_replace(' ', '-', $product['product_name'])),
                    'price' => $product['price'],
                    'old_price' => $product['old_price'] ?? null,
                    'category' => $category ? $category['category_name'] : 'General',
                    'subcategory' => $subcategory ? $subcategory['subcategory_name'] : null,
                    'image' => $product['product_image'] ?? 'https://via.placeholder.com/200x200?text=Product',
                    'badges' => $this->getBadges($product),
                    'in_stock' => $product['quantity'] > 0,
                ];
            }
            
            $categories = $this->categoryModel->getActiveCategories();
            
            return view('public/products', [
                'products' => $formattedProducts,
                'categories' => $categories,
                'subcategories' => $subcategories,
            ]);
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function show($slug)
    {
        $productName = str_replace('-', ' ', $slug);
        $product = $this->productModel->where('product_name', $productName)
                                      ->where('status', 'published')
                                      ->first();
        
        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $category = $this->categoryModel->find($product['category_id']);
        $subcategory = null;
        if ($product['subcategory_id']) {
            $subcategory = $this->subcategoryModel->find($product['subcategory_id']);
        }
        
        $images = [];
        if ($product['product_image']) {
            $images[] = $product['product_image'];
        }
        if (empty($images)) {
            $images[] = 'https://via.placeholder.com/400x400?text=No+Image';
        }

        $productData = [
            'id' => $product['id'],
            'name' => $product['product_name'],
            'slug' => $slug,
            'price' => $product['price'],
            'old_price' => $product['old_price'] ?? null,
            'description' => $product['product_description'] ?? 'No description available.',
            'category' => $category ? $category['category_name'] : 'General',
            'subcategory' => $subcategory ? $subcategory['subcategory_name'] : 'N/A',
            'store' => 'ShopEase Store',
            'sku' => 'SKU-' . str_pad($product['id'], 6, '0', STR_PAD_LEFT),
            'image' => $product['product_image'] ?? 'https://via.placeholder.com/400x400?text=Product',
            'images' => $images,
            'badges' => $this->getBadges($product),
            'in_stock' => $product['quantity'] > 0,
            'quantity' => $product['quantity'] ?? 0,
            'rating' => 4.5,
            'reviews' => 0,
        ];

        return view('public/product_details', ['product' => $productData]);
    }

    public function getByCategory($categoryId)
    {
        $products = $this->productModel->getProductsByCategory($categoryId);
        $categories = $this->categoryModel->getActiveCategories();
        $category = $this->categoryModel->find($categoryId);

        $formattedProducts = [];
        foreach ($products as $product) {
            $subcategory = null;
            if ($product['subcategory_id']) {
                $subcategory = $this->subcategoryModel->find($product['subcategory_id']);
            }
            
            $formattedProducts[] = [
                'id' => $product['id'],
                'name' => $product['product_name'],
                'slug' => strtolower(str_replace(' ', '-', $product['product_name'])),
                'price' => $product['price'],
                'old_price' => $product['old_price'] ?? null,
                'category' => $category ? $category['category_name'] : 'General',
                'subcategory' => $subcategory ? $subcategory['subcategory_name'] : null,
                'image' => $product['product_image'] ?? 'https://via.placeholder.com/200x200?text=Product',
                'badges' => $this->getBadges($product),
                'in_stock' => $product['quantity'] > 0,
            ];
        }

        return view('public/products', [
            'products' => $formattedProducts,
            'categories' => $categories,
            'selectedCategory' => $category ? $category['category_name'] : 'All'
        ]);
    }

    public function search()
    {
        $keyword = $this->request->getGet('q');
        $products = $this->productModel->searchProducts($keyword);
        
        $formattedProducts = [];
        foreach ($products as $product) {
            $category = $this->categoryModel->find($product['category_id']);
            $subcategory = null;
            if ($product['subcategory_id']) {
                $subcategory = $this->subcategoryModel->find($product['subcategory_id']);
            }
            
            $formattedProducts[] = [
                'id' => $product['id'],
                'name' => $product['product_name'],
                'slug' => strtolower(str_replace(' ', '-', $product['product_name'])),
                'price' => $product['price'],
                'old_price' => $product['old_price'] ?? null,
                'category' => $category ? $category['category_name'] : 'General',
                'subcategory' => $subcategory ? $subcategory['subcategory_name'] : null,
                'image' => $product['product_image'] ?? 'https://via.placeholder.com/200x200?text=Product',
                'badges' => $this->getBadges($product),
                'in_stock' => $product['quantity'] > 0,
            ];
        }
        
        $categories = $this->categoryModel->getActiveCategories();

        return view('public/products', [
            'products' => $formattedProducts,
            'categories' => $categories,
            'searchKeyword' => $keyword,
        ]);
    }

    private function getBadges($product)
    {
        $badges = [];
        if ($product['old_price'] && $product['old_price'] > $product['price']) {
            $badges[] = 'Sale';
        }
        if (empty($badges)) {
            $badges[] = 'New';
        }
        return $badges;
    }

    // ============ STORE OWNER METHODS ============

    public function storeProducts()
    {
        $tenantId = session()->get('tenant_id');
        if (!$tenantId) {
            return redirect()->to('/login')->with('error', 'Please login to manage your products.');
        }

        $products = $this->productModel->where('tenant_id', $tenantId)->findAll();
        $categories = $this->categoryModel->getActiveCategories();

        return view('store_owner/products', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $tenantId = session()->get('tenant_id');
        if (!$tenantId) {
            return redirect()->to('/login')->with('error', 'Please login to add products.');
        }

        $categories = $this->categoryModel->getActiveCategories();
        $subcategories = $this->subcategoryModel->getSubcategoriesByTenant($tenantId);

        return view('store_owner/product_add', [
            'categories' => $categories,
            'subcategories' => $subcategories,
        ]);
    }

    public function store()
    {
        try {
            $tenantId = session()->get('tenant_id');
            if (!$tenantId) {
                return redirect()->to('/login')->with('error', 'Please login to add products.');
            }

            $rules = [
                'product_name' => 'required|min_length[3]|max_length[255]',
                'category_id' => 'required|numeric',
                'price' => 'required|numeric|greater_than[0]',
                'quantity' => 'required|numeric',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
            }

            if ($this->request->getPost('quantity') < 0) {
                return redirect()->back()->with('error', 'Quantity cannot be negative.')->withInput();
            }

            $file = $this->request->getFile('product_image');
            $imagePath = null;

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = 'product_' . time() . '_' . $file->getRandomName();
                $uploadPath = ROOTPATH . 'public/uploads/products/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $file->move('uploads/products', $newName);
                $imagePath = 'uploads/products/' . $newName;
            }

            $data = [
                'tenant_id' => $tenantId,
                'category_id' => $this->request->getPost('category_id'),
                'subcategory_id' => $this->request->getPost('subcategory_id') ?: null,
                'product_name' => $this->request->getPost('product_name'),
                'product_description' => $this->request->getPost('product_description'),
                'price' => $this->request->getPost('price'),
                'old_price' => $this->request->getPost('old_price') ?: null,
                'quantity' => $this->request->getPost('quantity'),
                'product_image' => $imagePath,
                'status' => $this->request->getPost('status') ?: 'published',
                'is_active' => true,
            ];

            if ($this->productModel->insert($data)) {
                return redirect()->to('/store/products')->with('success', '✅ Product added successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to add product.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $tenantId = session()->get('tenant_id');
        if (!$tenantId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $product = $this->productModel->where('tenant_id', $tenantId)->find($id);
        if (!$product) {
            return redirect()->to('/store/products')->with('error', 'Product not found.');
        }

        $categories = $this->categoryModel->getActiveCategories();
        $subcategories = $this->subcategoryModel->getSubcategoriesByTenant($tenantId);

        return view('store_owner/product_edit', [
            'product' => $product,
            'categories' => $categories,
            'subcategories' => $subcategories,
        ]);
    }

    public function update($id)
    {
        try {
            $tenantId = session()->get('tenant_id');
            if (!$tenantId) {
                return redirect()->to('/login')->with('error', 'Please login.');
            }

            $product = $this->productModel->where('tenant_id', $tenantId)->find($id);
            if (!$product) {
                return redirect()->to('/store/products')->with('error', 'Product not found.');
            }

            $rules = [
                'product_name' => 'required|min_length[3]|max_length[255]',
                'category_id' => 'required|numeric',
                'price' => 'required|numeric|greater_than[0]',
                'quantity' => 'required|numeric',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
            }

            if ($this->request->getPost('quantity') < 0) {
                return redirect()->back()->with('error', 'Quantity cannot be negative.')->withInput();
            }

            $file = $this->request->getFile('product_image');
            $imagePath = $product['product_image'];

            if ($file && $file->isValid() && !$file->hasMoved()) {
                if ($product['product_image'] && file_exists(ROOTPATH . 'public/' . $product['product_image'])) {
                    unlink(ROOTPATH . 'public/' . $product['product_image']);
                }
                $newName = 'product_' . time() . '_' . $file->getRandomName();
                $uploadPath = ROOTPATH . 'public/uploads/products/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $file->move('uploads/products', $newName);
                $imagePath = 'uploads/products/' . $newName;
            }

            $data = [
                'category_id' => $this->request->getPost('category_id'),
                'subcategory_id' => $this->request->getPost('subcategory_id') ?: null,
                'product_name' => $this->request->getPost('product_name'),
                'product_description' => $this->request->getPost('product_description'),
                'price' => $this->request->getPost('price'),
                'old_price' => $this->request->getPost('old_price') ?: null,
                'quantity' => $this->request->getPost('quantity'),
                'product_image' => $imagePath,
                'status' => $this->request->getPost('status'),
            ];

            if ($this->productModel->update($id, $data)) {
                return redirect()->to('/store/products')->with('success', '✅ Product updated successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to update product.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $tenantId = session()->get('tenant_id');
        if (!$tenantId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $product = $this->productModel->where('tenant_id', $tenantId)->find($id);
        if (!$product) {
            return redirect()->to('/store/products')->with('error', 'Product not found.');
        }

        if ($product['product_image'] && file_exists(ROOTPATH . 'public/' . $product['product_image'])) {
            unlink(ROOTPATH . 'public/' . $product['product_image']);
        }

        $this->productModel->delete($id);
        return redirect()->to('/store/products')->with('success', '✅ Product deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $tenantId = session()->get('tenant_id');
        if (!$tenantId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $product = $this->productModel->where('tenant_id', $tenantId)->find($id);
        if (!$product) {
            return redirect()->to('/store/products')->with('error', 'Product not found.');
        }

        $newStatus = $product['status'] === 'published' ? 'draft' : 'published';
        $this->productModel->update($id, ['status' => $newStatus]);

        $message = $newStatus === 'published' ? '✅ Product published successfully!' : '✅ Product unpublished successfully!';
        return redirect()->to('/store/products')->with('success', $message);
    }

    // ============ API METHODS ============

    public function apiGetProducts()
    {
        $products = $this->productModel->getPublishedProducts();
        return $this->response->setJSON([
            'success' => true,
            'data' => $products
        ]);
    }

    public function apiGetProduct($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product not found'
            ]);
        }
        return $this->response->setJSON([
            'success' => true,
            'data' => $product
        ]);
    }
}