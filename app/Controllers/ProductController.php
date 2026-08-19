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
                    'category_id' => $product['category_id'],
                    'category' => $category ? $category['category_name'] : 'General',
                    'subcategory_id' => $product['subcategory_id'] ?? 0,
                    'subcategory' => $subcategory ? $subcategory['subcategory_name'] : null,
                    'image' => $product['product_image'] ?? 'https://via.placeholder.com/200x200?text=Product',
                    'badges' => $this->getBadges($product),
                    'in_stock' => $product['quantity'] > 0,
                ];
            }
            
            $categories = $this->categoryModel->getActiveCategories();
            
            // Get category counts for display
            $categoryCounts = [];
            foreach ($categories as $cat) {
                $categoryCounts[$cat['id']] = $this->productModel->where('category_id', $cat['id'])->where('status', 'published')->countAllResults();
            }
            
            return view('public/products', [
                'products' => $formattedProducts,
                'categories' => $categories,
                'subcategories' => $subcategories,
                'categoryCounts' => $categoryCounts,
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
        $subcategories = $this->subcategoryModel->getSubcategoriesByTenant($tenantId);

        return view('store_owner/products', [
            'products' => $products,
            'categories' => $categories,
            'subcategories' => $subcategories,
        ]);
    }

   public function create()
{
    $tenantId = session()->get('tenant_id');
    if (!$tenantId) {
        return redirect()->to('/login')->with('error', 'Please login to add products.');
    }

    $categories = $this->categoryModel->getActiveCategories();
    
    // ✅ FIX: Get ALL subcategories for this tenant
    $subcategories = $this->subcategoryModel->getSubcategoriesByTenant($tenantId);
    
    // ✅ OPTIONAL: Group subcategories by category for better organization
    $groupedSubcategories = [];
    foreach ($subcategories as $sub) {
        $catId = $sub['category_id'];
        if (!isset($groupedSubcategories[$catId])) {
            $groupedSubcategories[$catId] = [];
        }
        $groupedSubcategories[$catId][] = $sub;
    }

    return view('store_owner/product_add', [
        'categories' => $categories,
        'subcategories' => $subcategories,        // ✅ Pass to view
        'groupedSubcategories' => $groupedSubcategories, // ✅ Optional
    ]);
}

  public function store()
{
    try {
        $tenantId = session()->get('tenant_id');
        if (!$tenantId) {
            return redirect()->to('/login')->with('error', 'Please login to add products.');
        }

        // Validation rules
        $rules = [
            'product_name' => 'required|min_length[3]|max_length[255]',
            'category_id' => 'required|numeric',
            'price' => 'required|numeric|greater_than[0]',
            'quantity' => 'required|numeric|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        // Handle image upload
        $file = $this->request->getFile('product_image');
        $imagePath = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            try {
                $newName = 'product_' . time() . '_' . $file->getRandomName();
                $uploadPath = ROOTPATH . 'public/uploads/products/';
                
                // Create directory if it doesn't exist
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                
                $file->move('uploads/products', $newName);
                $imagePath = 'uploads/products/' . $newName;
            } catch (\Exception $e) {
                // Log error but continue
                log_message('error', 'Image upload failed: ' . $e->getMessage());
            }
        }

        // Prepare data
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
            'status' => $this->request->getPost('status') ?: 'draft',
            'is_active' => true,
        ];

        // Debug: Log the data
        log_message('debug', 'Product data being saved: ' . print_r($data, true));

        // Insert the product
        if ($this->productModel->insert($data)) {
            $productId = $this->productModel->getInsertID();
            log_message('debug', 'Product saved successfully with ID: ' . $productId);
            return redirect()->to('/store/products')
                ->with('success', '✅ Product added successfully!');
        } else {
            log_message('error', 'Failed to save product. Model errors: ' . print_r($this->productModel->errors(), true));
            return redirect()->back()
                ->with('error', 'Failed to save product. Please try again.')
                ->withInput();
        }
    } catch (\Exception $e) {
        log_message('error', 'Product save error: ' . $e->getMessage());
        log_message('error', 'Stack trace: ' . $e->getTraceAsString());
        
        return redirect()->back()
            ->with('error', 'Error: ' . $e->getMessage())
            ->withInput();
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
    
    // ✅ FIX: Get ALL subcategories for this tenant
    $subcategories = $this->subcategoryModel->getSubcategoriesByTenant($tenantId);
    
    // ✅ OPTIONAL: Group subcategories by category
    $groupedSubcategories = [];
    foreach ($subcategories as $sub) {
        $catId = $sub['category_id'];
        if (!isset($groupedSubcategories[$catId])) {
            $groupedSubcategories[$catId] = [];
        }
        $groupedSubcategories[$catId][] = $sub;
    }

    return view('store_owner/product_edit', [
        'product' => $product,
        'categories' => $categories,
        'subcategories' => $subcategories,        // ✅ Pass to view
        'groupedSubcategories' => $groupedSubcategories, // ✅ Optional
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
            'quantity' => 'required|numeric|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        // Handle image upload
        $file = $this->request->getFile('product_image');
        $imagePath = $product['product_image'];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            try {
                // Delete old image if exists
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
            } catch (\Exception $e) {
                log_message('error', 'Image upload failed: ' . $e->getMessage());
            }
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
            'status' => $this->request->getPost('status') ?: 'draft',
        ];

        log_message('debug', 'Product update data: ' . print_r($data, true));

        if ($this->productModel->update($id, $data)) {
            return redirect()->to('/store/products')
                ->with('success', '✅ Product updated successfully!');
        } else {
            return redirect()->back()
                ->with('error', 'Failed to update product.')
                ->withInput();
        }
    } catch (\Exception $e) {
        log_message('error', 'Product update error: ' . $e->getMessage());
        log_message('error', 'Stack trace: ' . $e->getTraceAsString());
        
        return redirect()->back()
            ->with('error', 'Error: ' . $e->getMessage())
            ->withInput();
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