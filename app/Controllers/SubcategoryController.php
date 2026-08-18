<?php

namespace App\Controllers;

use App\Models\SubcategoryModel;
use App\Models\CategoryModel;

class SubcategoryController extends BaseController
{
    protected $subcategoryModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->subcategoryModel = new SubcategoryModel();
        $this->categoryModel = new CategoryModel();
    }

    // ==========================================
    // STORE OWNER VIEWS
    // ==========================================

    public function index()
    {
        $tenantId = session()->get('tenant_id');
        if (!$tenantId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $subcategories = $this->subcategoryModel->getSubcategoriesWithCategory($tenantId);
        $categories = $this->categoryModel->getActiveCategories();

        return view('store_owner/subcategories', [
            'subcategories' => $subcategories,
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $tenantId = session()->get('tenant_id');
        if (!$tenantId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $categories = $this->categoryModel->getActiveCategories();
        return view('store_owner/subcategory_add', ['categories' => $categories]);
    }

    public function store()
    {
        $tenantId = session()->get('tenant_id');
        if (!$tenantId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $rules = [
            'category_id' => 'required|numeric',
            'subcategory_name' => 'required|min_length[2]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        // Check if subcategory already exists for this tenant and category
        $existing = $this->subcategoryModel
                        ->where('category_id', $this->request->getPost('category_id'))
                        ->where('tenant_id', $tenantId)
                        ->where('subcategory_name', $this->request->getPost('subcategory_name'))
                        ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'This subcategory already exists for your store.');
        }

        $data = [
            'category_id' => $this->request->getPost('category_id'),
            'tenant_id' => $tenantId,
            'subcategory_name' => $this->request->getPost('subcategory_name'),
            'is_active' => $this->request->getPost('is_active') ? true : false,
        ];

        if ($this->subcategoryModel->insert($data)) {
            return redirect()->to('/store/subcategories')->with('success', 'Subcategory created successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to create subcategory.');
        }
    }

    public function edit($id)
    {
        $tenantId = session()->get('tenant_id');
        if (!$tenantId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $subcategory = $this->subcategoryModel->where('tenant_id', $tenantId)->find($id);
        if (!$subcategory) {
            return redirect()->to('/store/subcategories')->with('error', 'Subcategory not found.');
        }

        $categories = $this->categoryModel->getActiveCategories();
        return view('store_owner/subcategory_edit', [
            'subcategory' => $subcategory,
            'categories' => $categories,
        ]);
    }

    public function update($id)
    {
        $tenantId = session()->get('tenant_id');
        if (!$tenantId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $subcategory = $this->subcategoryModel->where('tenant_id', $tenantId)->find($id);
        if (!$subcategory) {
            return redirect()->to('/store/subcategories')->with('error', 'Subcategory not found.');
        }

        $rules = [
            'category_id' => 'required|numeric',
            'subcategory_name' => 'required|min_length[2]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $data = [
            'category_id' => $this->request->getPost('category_id'),
            'subcategory_name' => $this->request->getPost('subcategory_name'),
            'is_active' => $this->request->getPost('is_active') ? true : false,
        ];

        if ($this->subcategoryModel->update($id, $data)) {
            return redirect()->to('/store/subcategories')->with('success', 'Subcategory updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to update subcategory.');
        }
    }

    public function delete($id)
    {
        $tenantId = session()->get('tenant_id');
        if (!$tenantId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $subcategory = $this->subcategoryModel->where('tenant_id', $tenantId)->find($id);
        if (!$subcategory) {
            return redirect()->to('/store/subcategories')->with('error', 'Subcategory not found.');
        }

        $this->subcategoryModel->delete($id);
        return redirect()->to('/store/subcategories')->with('success', 'Subcategory deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $tenantId = session()->get('tenant_id');
        if (!$tenantId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $subcategory = $this->subcategoryModel->where('tenant_id', $tenantId)->find($id);
        if (!$subcategory) {
            return redirect()->to('/store/subcategories')->with('error', 'Subcategory not found.');
        }

        $newStatus = $subcategory['is_active'] ? false : true;
        $this->subcategoryModel->update($id, ['is_active' => $newStatus]);

        $statusText = $newStatus ? 'activated' : 'deactivated';
        return redirect()->to('/store/subcategories')->with('success', "Subcategory $statusText successfully.");
    }

    // ==========================================
    // API METHODS
    // ==========================================

    public function getByCategory($categoryId)
    {
        $subcategories = $this->subcategoryModel->getSubcategoriesByCategory($categoryId);
        return $this->response->setJSON([
            'success' => true,
            'data' => $subcategories
        ]);
    }
    public function getActiveSubcategories()
{
    return $this->where('is_active', true)
                ->orderBy('subcategory_name', 'ASC')
                ->findAll();
}

    public function getByTenant()
    {
        $tenantId = session()->get('tenant_id');
        if (!$tenantId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login.'
            ]);
        }

        $subcategories = $this->subcategoryModel->getSubcategoriesWithCategory($tenantId);
        return $this->response->setJSON([
            'success' => true,
            'data' => $subcategories
        ]);
    }
}