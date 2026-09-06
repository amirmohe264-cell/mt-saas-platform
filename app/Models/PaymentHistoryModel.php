<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentHistoryModel extends Model
{
    protected $table = 'payment_history';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = [
        'order_id', 'customer_id', 'tenant_id', 'order_total',
        'platform_fee', 'delivery_fee', 'commission_amount',
        'store_owner_amount', 'payment_status', 'payment_method', 'transaction_id'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    
    protected $validationRules = [
        'order_id' => 'required|integer',
        'customer_id' => 'required|integer',
        'tenant_id' => 'required|integer',
        'order_total' => 'required|decimal',
        'platform_fee' => 'required|decimal',
        'delivery_fee' => 'required|decimal',
        'commission_amount' => 'required|decimal',
        'store_owner_amount' => 'required|decimal',
        'payment_status' => 'in_list[pending,paid,failed,refunded]'
    ];
    
    public function getHistoryByTenant($tenantId)
    {
        return $this->where('tenant_id', $tenantId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
    
    public function getHistoryByOrder($orderId)
    {
        return $this->where('order_id', $orderId)->first();
    }
}