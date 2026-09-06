<?php

namespace App\Models;

use CodeIgniter\Model;

class PayoutModel extends Model
{
    protected $table = 'payouts';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = [
        'tenant_id', 'order_ids', 'gross_amount', 
        'commission_amount', 'net_amount', 'status',
        'payment_method', 'transaction_id', 'notes', 'paid_at'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'tenant_id' => 'required|integer',
        'gross_amount' => 'required|decimal',
        'commission_amount' => 'required|decimal',
        'net_amount' => 'required|decimal',
        'status' => 'in_list[pending,processing,paid,failed]'
    ];
    
    public function getPayoutsByTenant($tenantId)
    {
        return $this->where('tenant_id', $tenantId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
    
    public function getPendingPayouts()
    {
        return $this->where('status', 'pending')
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }
    
    public function processPayout($payoutId, $paymentMethod, $transactionId = null)
    {
        $this->update($payoutId, [
            'status' => 'processing',
            'payment_method' => $paymentMethod,
            'transaction_id' => $transactionId
        ]);
        
        return true;
    }
    
    public function completePayout($payoutId)
    {
        $this->update($payoutId, [
            'status' => 'paid',
            'paid_at' => date('Y-m-d H:i:s')
        ]);
        
        return true;
    }
}