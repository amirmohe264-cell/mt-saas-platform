<?php

namespace App\Models;

use CodeIgniter\Model;

class DeliveryAssignmentModel extends Model
{
    protected $table = 'delivery_assignments';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = [
        'order_id', 'company_id', 'agent_id', 
        'pickup_verification_code', 'delivery_verification_code',
        'assigned_at', 'picked_up_at', 'delivered_at', 'completed_at',
        'status', 'notes'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'order_id' => 'required|integer',
        'company_id' => 'required|integer',
        'agent_id' => 'permit_empty|integer',
        'pickup_verification_code' => 'required|min_length[10]|max_length[50]',
        'delivery_verification_code' => 'required|min_length[10]|max_length[50]',
        'status' => 'in_list[pending,assigned,picked_up,in_transit,delivered,completed,failed]'
    ];
    
    public function generateVerificationCode($orderId)
    {
        $random = strtoupper(substr(uniqid(), -6));
        return "ORD-{$orderId}-{$random}";
    }
    
    public function assignDelivery($orderId, $companyId, $agentId = null)
    {
        $pickupCode = $this->generateVerificationCode($orderId);
        $deliveryCode = $this->generateVerificationCode($orderId);
        
        $data = [
            'order_id' => $orderId,
            'company_id' => $companyId,
            'agent_id' => $agentId,
            'pickup_verification_code' => $pickupCode,
            'delivery_verification_code' => $deliveryCode,
            'status' => $agentId ? 'assigned' : 'pending'
        ];
        
        $assignmentId = $this->insert($data);
        
        if ($assignmentId) {
            $orderModel = new OrderModel();
            $orderModel->update($orderId, [
                'delivery_assignment_id' => $assignmentId,
                'delivery_company_id' => $companyId,
                'delivery_agent_id' => $agentId,
                'pickup_verification_code' => $pickupCode,
                'delivery_verification_code' => $deliveryCode,
                'delivery_status' => $agentId ? 'assigned' : 'pending'
            ]);
        }
        
        return $assignmentId;
    }
    
    public function updateStatus($assignmentId, $status, $notes = null)
    {
        $data = ['status' => $status];
        
        if ($notes) {
            $data['notes'] = $notes;
        }
        
        switch ($status) {
            case 'picked_up':
                $data['picked_up_at'] = date('Y-m-d H:i:s');
                break;
            case 'delivered':
                $data['delivered_at'] = date('Y-m-d H:i:s');
                break;
            case 'completed':
                $data['completed_at'] = date('Y-m-d H:i:s');
                break;
        }
        
        $this->update($assignmentId, $data);
        
        $assignment = $this->find($assignmentId);
        if ($assignment) {
            $orderModel = new OrderModel();
            $orderModel->update($assignment['order_id'], [
                'delivery_status' => $status
            ]);
        }
        
        return true;
    }
    
    public function getAssignmentsByCompany($companyId, $status = null)
    {
        $this->where('company_id', $companyId);
        if ($status) {
            $this->where('status', $status);
        }
        return $this->orderBy('created_at', 'DESC')->findAll();
    }
}