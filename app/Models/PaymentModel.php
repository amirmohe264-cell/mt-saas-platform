<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'order_id',
        'tenant_id',
        'customer_id',
        'amount',
        'platform_fee',
        'delivery_fee',
        'store_owner_amount',
        'payment_method',
        'transaction_id',
        'status',
        'escrow_held',
        'escrow_released_at',
        'paid_at',
        'confirmed_at',
        'released_at',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getEscrowPayments()
    {
        return $this->where('escrow_held', true)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getTotalEscrow()
    {
        return $this->selectSum('amount')
                    ->where('escrow_held', true)
                    ->first()['amount'] ?? 0;
    }
}