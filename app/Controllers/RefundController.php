<?php

namespace App\Controllers;

use App\Models\OrderModel;

class RefundController extends BaseController
{
    public function request($orderId)
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');

        if (!$customerId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login first'
            ]);
        }

        $orderModel = new OrderModel();
        $order = $orderModel->where('id', $orderId)
                            ->where('customer_id', $customerId)
                            ->first();

        if (!$order) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Order not found'
            ]);
        }

        if (in_array($order['order_status'], ['delivered', 'cancelled'], true)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'This order can no longer be cancelled or refunded.'
            ]);
        }

        $db = \Config\Database::connect();

        $existing = $db->table('refund_requests')
            ->where('order_id', $orderId)
            ->where('status', 'pending')
            ->get()
            ->getRowArray();

        if ($existing) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You already have a pending request for this order.'
            ]);
        }

        $reason = $this->request->getJSON(true)['reason'] ?? '';

        if (empty(trim($reason))) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please provide a reason for your request.'
            ]);
        }

        $db->table('refund_requests')->insert([
            'order_id' => $orderId,
            'customer_id' => $customerId,
            'reason' => $reason,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Your request has been submitted. Our team will review it shortly.'
        ]);
    }
}