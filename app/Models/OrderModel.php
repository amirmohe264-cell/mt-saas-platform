<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['tenant_id', 'customer_id', 'order_number', 'total_amount', 'shipping_address', 'city', 'postal_code', 'phone', 'payment_method', 'payment_status', 'order_status', 'notes'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public function getOrdersByTenant($tenantId)
    {
        return $this->where('tenant_id', $tenantId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getOrdersByCustomer($customerId)
    {
        return $this->where('customer_id', $customerId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getOrderWithDetails($orderId)
    {
        return $this->select('orders.*, customers.first_name, customers.last_name, customers.email')
                    ->join('customers', 'customers.id = orders.customer_id')
                    ->where('orders.id', $orderId)
                    ->first();
    }

    public function getOrderItems($orderId)
    {
        return $this->db->table('order_items')
                        ->where('order_id', $orderId)
                        ->get()
                        ->getResultArray();
    }

    public function getOrderStatusCounts($tenantId = null)
    {
        $builder = $this->select('order_status, COUNT(*) as count')
                        ->groupBy('order_status');
        
        if ($tenantId) {
            $builder->where('tenant_id', $tenantId);
        }
        
        return $builder->get()->getResultArray();
    }

    public function getRevenueByPeriod($tenantId = null, $period = 'month')
    {
        $builder = $this->select('SUM(total_amount) as revenue');
        
        if ($tenantId) {
            $builder->where('tenant_id', $tenantId);
        }
        
        if ($period === 'today') {
            $builder->where('DATE(created_at)', date('Y-m-d'));
        } elseif ($period === 'week') {
            $builder->where('created_at >=', date('Y-m-d', strtotime('-7 days')));
        } elseif ($period === 'month') {
            $builder->where('created_at >=', date('Y-m-d', strtotime('-30 days')));
        } elseif ($period === 'year') {
            $builder->where('created_at >=', date('Y-m-d', strtotime('-365 days')));
        }
        
        return $builder->get()->getRowArray()['revenue'] ?? 0;
    }
}