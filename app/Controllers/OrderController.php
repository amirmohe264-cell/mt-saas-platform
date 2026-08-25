<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;

class OrderController extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
    }

    // ============================================
    // CUSTOMER ORDERS
    // ============================================

    public function index()
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');
        if (!$customerId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $orders = $this->orderModel->where('customer_id', $customerId)
                                  ->orderBy('created_at', 'DESC')
                                  ->findAll();

        return view('public/orders', ['orders' => $orders]);
    }

    public function show($id)
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');
        if (!$customerId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $order = $this->orderModel->where('id', $id)
                                 ->where('customer_id', $customerId)
                                 ->first();

        if (!$order) {
            return redirect()->to('/orders')->with('error', 'Order not found.');
        }

        $orderItems = $this->orderItemModel->where('order_id', $id)
                                          ->join('products', 'products.id = order_items.product_id', 'left')
                                          ->findAll();

        return view('public/order_details', ['order' => $order, 'orderItems' => $orderItems]);
    }

    // ============================================
    // STORE OWNER ORDERS (NEW)
    // ============================================

    public function storeOrders()
    {
        $tenantId = session()->get('tenant_id');
        if (!$tenantId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $orders = $this->orderModel->where('tenant_id', $tenantId)
                                  ->orderBy('created_at', 'DESC')
                                  ->findAll();

        return view('store_owner/orders', ['orders' => $orders]);
    }

    public function storeOrderDetails($id)
    {
        $tenantId = session()->get('tenant_id');
        if (!$tenantId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $order = $this->orderModel->where('id', $id)
                                 ->where('tenant_id', $tenantId)
                                 ->first();

        if (!$order) {
            return redirect()->to('/store/orders')->with('error', 'Order not found.');
        }

        $orderItems = $this->orderItemModel->where('order_id', $id)
                                          ->join('products', 'products.id = order_items.product_id', 'left')
                                          ->findAll();

        return view('store_owner/order_details', [
            'order' => $order,
            'orderItems' => $orderItems,
        ]);
    }

    public function updateOrderStatus($id)
    {
        $tenantId = session()->get('tenant_id');
        if (!$tenantId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $status = $this->request->getPost('status');
        
        $this->orderModel->update($id, [
            'order_status' => $status,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

    // ============================================
    // ORDER CONFIRMATION
    // ============================================

    public function confirmation()
    {
        return view('public/order_confirmation');
    }
}