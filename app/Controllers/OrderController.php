<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\DeliveryTrackingModel;

class OrderController extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;
    protected $deliveryTrackingModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->deliveryTrackingModel = new DeliveryTrackingModel();
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
            return redirect()->to('/dashboard#orders')->with('error', 'Order not found.');
        }

        $orderItems = $this->orderItemModel->where('order_id', $id)
                                          ->join('products', 'products.id = order_items.product_id', 'left')
                                          ->findAll();

        return view('public/order_details', ['order' => $order, 'orderItems' => $orderItems]);
    }

    // ============================================
    // STORE OWNER ORDERS
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

        $delivery = $this->deliveryTrackingModel->where('order_id', $id)->first();

        return view('store_owner/order_details', [
            'order' => $order,
            'orderItems' => $orderItems,
            'delivery' => $delivery,
        ]);
    }

    public function updateOrderStatus($id)
    {
        $tenantId = session()->get('tenant_id');
        if (!$tenantId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        // Confirm this order actually belongs to this store owner's tenant
        $order = $this->orderModel->where('id', $id)
                                  ->where('tenant_id', $tenantId)
                                  ->first();

        if (!$order) {
            return redirect()->to('/store/orders')->with('error', 'Order not found.');
        }

        $status = $this->request->getPost('status');
        $allowedStatuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'];

        if (!in_array($status, $allowedStatuses, true)) {
            return redirect()->back()->with('error', 'Invalid status value.');
        }

        $this->orderModel->update($id, [
            'order_status' => $status,
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

    /**
     * Store owner marks an order as delivered. This does NOT release escrow -
     * it only flips the order/delivery status. Payment release requires
     * separate customer confirmation + admin approval.
     */
    public function markDeliveredByStore($id)
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

        $this->orderModel->update($id, [
            'order_status' => 'delivered',
        ]);

        $existingTracking = $this->deliveryTrackingModel->where('order_id', $id)->first();

        $trackingData = [
            'status' => 'delivered',
            'delivered_at' => date('Y-m-d H:i:s'),
        ];

        if ($existingTracking) {
            $this->deliveryTrackingModel->update($existingTracking['id'], $trackingData);
        } else {
            $trackingData['order_id'] = $id;
            $trackingData['tenant_id'] = $tenantId;
            $trackingData['confirmed_by_customer'] = false;
            $this->deliveryTrackingModel->insert($trackingData);
        }

        return redirect()->back()->with('success', 'Order marked as delivered! Waiting for customer confirmation before payment release.');
    }

    // ============================================
    // ORDER CONFIRMATION
    // ============================================

    public function confirmation()
    {
        return view('public/order_confirmation');
    }
}