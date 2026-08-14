<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;

class CategoryController extends BaseController
{
    protected $categoryModel;
    protected $productModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->productModel = new ProductModel();
    }

    // ==========================================
    // PUBLIC VIEWS
    // ==========================================

    public function index()
    {
        $categories = $this->categoryModel->getCategoryWithProductCount();
        
        $categoryList = [];
        foreach ($categories as $cat) {
            $slug = strtolower(str_replace([' ', '&'], ['-', 'and'], $cat['category_name']));
            $categoryList[$slug] = $cat['category_name'];
        }
        
        $allProducts = $this->productModel->getPublishedProducts();
        
        $products = [];
        foreach ($allProducts as $product) {
            $categoryName = '';
            foreach ($categories as $cat) {
                if ($cat['id'] == $product['category_id']) {
                    $categoryName = $cat['category_name'];
                    break;
                }
            }
            $products[] = [
                'id' => $product['id'],
                'name' => $product['product_name'],
                'slug' => strtolower(str_replace(' ', '-', $product['product_name'])),
                'price' => $product['price'],
                'category' => $categoryName,
                'category_id' => $product['category_id'],
                'image' => $product['product_image'] ?? 'https://via.placeholder.com/200x200?text=Product',
            ];
        }
        
        return view('public/categories', [
            'categories' => $categoryList,
            'products' => $products,
            'selectedCategory' => 'All',
            'selectedSlug' => 'all',
        ]);
    }

    public function show($slug)
    {
        $categoryName = str_replace('-', ' ', $slug);
        $category = $this->categoryModel->where('category_name', $categoryName)->first();
        
        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $allCategories = $this->categoryModel->getCategoryWithProductCount();
        $categoryList = [];
        foreach ($allCategories as $cat) {
            $catSlug = strtolower(str_replace([' ', '&'], ['-', 'and'], $cat['category_name']));
            $categoryList[$catSlug] = $cat['category_name'];
        }

        $categoryProducts = $this->productModel->getProductsByCategory($category['id']);
        
        $products = [];
        foreach ($categoryProducts as $product) {
            $products[] = [
                'id' => $product['id'],
                'name' => $product['product_name'],
                'slug' => strtolower(str_replace(' ', '-', $product['product_name'])),
                'price' => $product['price'],
                'category' => $category['category_name'],
                'category_id' => $category['id'],
                'image' => $product['product_image'] ?? 'https://via.placeholder.com/200x200?text=Product',
            ];
        }

        return view('public/categories', [
            'categories' => $categoryList,
            'products' => $products,
            'selectedCategory' => $category['category_name'],
            'selectedSlug' => $slug,
            'selectedCategoryId' => $category['id'],
        ]);
    }

    // ==========================================
    // SUPER ADMIN VIEWS
    // ==========================================

    public function adminIndex()
    {
        if (session()->get('role') !== 'super_admin') {
            return redirect()->to('/login')->with('error', 'Unauthorized access.');
        }

        $categories = $this->categoryModel->getCategoryWithProductCount();
        return view('admin/categories', ['categories' => $categories]);
    }

    public function create()
    {
        if (session()->get('role') !== 'super_admin') {
            return redirect()->to('/login')->with('error', 'Unauthorized access.');
        }

        return view('admin/category_add');
    }

    public function store()
    {
        if (session()->get('role') !== 'super_admin') {
            return redirect()->to('/login')->with('error', 'Unauthorized access.');
        }

        $rules = [
            'category_name' => 'required|min_length[2]|max_length[255]|is_unique[categories.category_name]',
            'category_image' => 'if_exist|max_size[category_image,2048]|ext_in[category_image,jpg,jpeg,png,gif,svg,webp]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        // Handle file upload
        $file = $this->request->getFile('category_image');
        $imagePath = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = 'category_' . time() . '_' . $file->getRandomName();
            $file->move('uploads/categories', $newName);
            $imagePath = 'uploads/categories/' . $newName;
        }

        $data = [
            'category_name' => $this->request->getPost('category_name'),
            'category_description' => $this->request->getPost('category_description'),
            'category_image' => $imagePath,
            'is_active' => $this->request->getPost('is_active') ? true : false,
        ];

        if ($this->categoryModel->insert($data)) {
            return redirect()->to('/admin/categories')->with('success', 'Category created successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to create category.');
        }
    }

    public function edit($id)
    {
        if (session()->get('role') !== 'super_admin') {
            return redirect()->to('/login')->with('error', 'Unauthorized access.');
        }

        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->to('/admin/categories')->with('error', 'Category not found.');
        }

        return view('admin/category_edit', ['category' => $category]);
    }

    public function update($id)
    {
        if (session()->get('role') !== 'super_admin') {
            return redirect()->to('/login')->with('error', 'Unauthorized access.');
        }

        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->to('/admin/categories')->with('error', 'Category not found.');
        }

        $rules = [
            'category_name' => 'required|min_length[2]|max_length[255]',
            'category_image' => 'if_exist|max_size[category_image,2048]|ext_in[category_image,jpg,jpeg,png,gif,svg,webp]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $data = [
            'category_name' => $this->request->getPost('category_name'),
            'category_description' => $this->request->getPost('category_description'),
            'is_active' => $this->request->getPost('is_active') ? true : false,
        ];

        // Handle file upload
        $file = $this->request->getFile('category_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Delete old image if exists
            if ($category['category_image'] && file_exists(FCPATH . $category['category_image'])) {
                unlink(FCPATH . $category['category_image']);
            }
            $newName = 'category_' . time() . '_' . $file->getRandomName();
            $file->move('uploads/categories', $newName);
            $data['category_image'] = 'uploads/categories/' . $newName;
        }

        if ($this->categoryModel->update($id, $data)) {
            return redirect()->to('/admin/categories')->with('success', 'Category updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to update category.');
        }
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'super_admin') {
            return redirect()->to('/login')->with('error', 'Unauthorized access.');
        }

        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->to('/admin/categories')->with('error', 'Category not found.');
        }

        // Check if category has products
        $productCount = $this->productModel->where('category_id', $id)->countAllResults();

        if ($productCount > 0) {
            // Instead of deleting, set as inactive
            $this->categoryModel->update($id, ['is_active' => false]);
            return redirect()->to('/admin/categories')->with('warning', 'Category has products. It has been set to inactive.');
        }

        $this->categoryModel->delete($id);
        return redirect()->to('/admin/categories')->with('success', 'Category deleted successfully.');
    }

    public function toggleStatus($id)
    {
        if (session()->get('role') !== 'super_admin') {
            return redirect()->to('/login')->with('error', 'Unauthorized access.');
        }

        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->to('/admin/categories')->with('error', 'Category not found.');
        }

        $newStatus = $category['is_active'] ? false : true;
        $this->categoryModel->update($id, ['is_active' => $newStatus]);

        $statusText = $newStatus ? 'activated' : 'deactivated';
        return redirect()->to('/admin/categories')->with('success', "Category $statusText successfully.");
    }

    // ==========================================
    // API METHODS
    // ==========================================

    public function apiGetCategories()
    {
        $categories = $this->categoryModel->getActiveCategories();
        return $this->response->setJSON([
            'success' => true,
            'data' => $categories
        ]);
    }

    public function apiGetCategory($id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Category not found'
            ]);
        }

        $products = $this->productModel->getProductsByCategory($id);

        return $this->response->setJSON([
            'success' => true,
            'data' => [
                'category' => $category,
                'products' => $products
            ]
        ]);
    }
}