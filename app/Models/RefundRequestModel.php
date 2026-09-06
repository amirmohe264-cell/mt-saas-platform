<?php

namespace App\Models;

use CodeIgniter\Model;

class RefundRequestModel extends Model
{
    protected $table = 'refund_requests';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = [
        'order_id', 'customer_id', 'reason', 'status', 'admin_note'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'order_id' => 'required|integer',
        'customer_id' => 'required|integer',
        'reason' => 'required|min_length[10]|max_length[1000]',
        'status' => 'in_list[pending,approved,rejected]'
    ];
    
    public function getRequestsByCustomer($customerId)
    {
        return $this->where('customer_id', $customerId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
    
    public function getPendingRequests()
    {
        return $this->where('status', 'pending')
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }
    
    public function approveRequest($requestId, $adminNote = null)
    {
        $request = $this->find($requestId);
        if (!$request) return false;
        
        $this->update($requestId, [
            'status' => 'approved',
            'admin_note' => $adminNote
        ]);
        
        $orderModel = new OrderModel();
        $orderModel->update($request['order_id'], ['refund_status' => 'approved']);
        
        return true;
    }
    
    public function rejectRequest($requestId, $adminNote = null)
    {
        $request = $this->find($requestId);
        if (!$request) return false;
        
        $this->update($requestId, [
            'status' => 'rejected',
            'admin_note' => $adminNote
        ]);
        
        $orderModel = new OrderModel();
        $orderModel->update($request['order_id'], ['refund_status' => 'rejected']);
        
        return true;
    }
}