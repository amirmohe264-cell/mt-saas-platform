<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\PayoutModel;
use App\Models\PaymentHistoryModel;
use App\Models\TenantModel;

class EarningsController extends BaseController
{
    protected $orderModel;
    protected $payoutModel;
    protected $paymentHistoryModel;
    protected $tenantModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->payoutModel = new PayoutModel();
        $this->paymentHistoryModel = new PaymentHistoryModel();
        $this->tenantModel = new TenantModel();
    }

    // ==========================================
    // EARNINGS & COMMISSION
    // ==========================================

    public function index()
    {
        $tenantId = session()->get('tenant_id');
        
        if (!$tenantId) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        // Get total sales
        $totalSales = $this->orderModel
            ->where('tenant_id', $tenantId)
            ->where('order_status', 'delivered')
            ->selectSum('total_amount')
            ->first();

        // Get total commission
        $totalCommission = $this->paymentHistoryModel
            ->where('tenant_id', $tenantId)
            ->where('payment_status', 'paid')
            ->selectSum('commission_amount')
            ->first();

        // Get total store owner amount
        $totalStoreOwnerAmount = $this->paymentHistoryModel
            ->where('tenant_id', $tenantId)
            ->where('payment_status', 'paid')
            ->selectSum('store_owner_amount')
            ->first();

        // Get pending payouts
        $pendingPayouts = $this->payoutModel
            ->where('tenant_id', $tenantId)
            ->whereIn('status', ['pending', 'processing'])
            ->selectSum('net_amount')
            ->first();

        // Get completed payouts
        $completedPayouts = $this->payoutModel
            ->where('tenant_id', $tenantId)
            ->where('status', 'paid')
            ->selectSum('net_amount')
            ->first();

        // Get monthly sales for chart
        $monthlySales = $this->orderModel
            ->where('tenant_id', $tenantId)
            ->where('order_status', 'delivered')
            ->select("DATE_TRUNC('month', created_at) as month, SUM(total_amount) as total")
            ->groupBy('month')
            ->orderBy('month', 'DESC')
            ->limit(12)
            ->findAll();

        $data = [
            'tenant_id' => $tenantId,
            'total_sales' => $totalSales['total_amount'] ?? 0,
            'total_commission' => $totalCommission['commission_amount'] ?? 0,
            'total_store_owner_amount' => $totalStoreOwnerAmount['store_owner_amount'] ?? 0,
            'pending_payouts' => $pendingPayouts['net_amount'] ?? 0,
            'completed_payouts' => $completedPayouts['net_amount'] ?? 0,
            'monthly_sales' => $monthlySales,
            'active_menu' => 'earnings'
        ];

        return view('store_owner/earnings', $data);
    }

    // ==========================================
    // PAYOUTS
    // ==========================================

    public function payouts()
    {
        $tenantId = session()->get('tenant_id');
        
        if (!$tenantId) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $payouts = $this->payoutModel
            ->where('tenant_id', $tenantId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $summary = [
            'pending' => $this->payoutModel->where('tenant_id', $tenantId)->where('status', 'pending')->countAllResults(),
            'processing' => $this->payoutModel->where('tenant_id', $tenantId)->where('status', 'processing')->countAllResults(),
            'paid' => $this->payoutModel->where('tenant_id', $tenantId)->where('status', 'paid')->countAllResults(),
            'failed' => $this->payoutModel->where('tenant_id', $tenantId)->where('status', 'failed')->countAllResults(),
            'total_pending_amount' => $this->payoutModel->where('tenant_id', $tenantId)->whereIn('status', ['pending', 'processing'])->selectSum('net_amount')->first()['net_amount'] ?? 0,
            'total_paid_amount' => $this->payoutModel->where('tenant_id', $tenantId)->where('status', 'paid')->selectSum('net_amount')->first()['net_amount'] ?? 0,
        ];

        $data = [
            'payouts' => $payouts,
            'summary' => $summary,
            'active_menu' => 'payouts'
        ];

        return view('store_owner/payouts', $data);
    }

    // ==========================================
    // PAYMENT HISTORY
    // ==========================================

    public function paymentHistory()
    {
        $tenantId = session()->get('tenant_id');
        
        if (!$tenantId) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $paymentHistory = $this->paymentHistoryModel
            ->where('tenant_id', $tenantId)
            ->orderBy('created_at', 'DESC')
            ->limit(100)
            ->findAll();

        $summary = [
            'total_sales' => $this->paymentHistoryModel->where('tenant_id', $tenantId)->where('payment_status', 'paid')->selectSum('order_total')->first()['order_total'] ?? 0,
            'total_commission' => $this->paymentHistoryModel->where('tenant_id', $tenantId)->where('payment_status', 'paid')->selectSum('commission_amount')->first()['commission_amount'] ?? 0,
            'total_earned' => $this->paymentHistoryModel->where('tenant_id', $tenantId)->where('payment_status', 'paid')->selectSum('store_owner_amount')->first()['store_owner_amount'] ?? 0,
            'total_orders' => $this->paymentHistoryModel->where('tenant_id', $tenantId)->where('payment_status', 'paid')->countAllResults(),
        ];

        $data = [
            'payment_history' => $paymentHistory,
            'summary' => $summary,
            'active_menu' => 'payment-history'
        ];

        return view('store_owner/payment_history', $data);
    }
}