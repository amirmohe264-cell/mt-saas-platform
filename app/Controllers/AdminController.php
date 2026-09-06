<?php

namespace App\Controllers;

use App\Models\StoreRequestModel;
use App\Models\TenantModel;
use App\Models\SystemUserModel;
use App\Models\CustomerModel;
use App\Models\PaymentModel;
use App\Models\OrderModel;
use App\Models\DeliveryTrackingModel;

class AdminController extends BaseController
{
    protected $storeRequestModel;
    protected $tenantModel;
    protected $systemUserModel;
    protected $paymentModel;
    protected $orderModel;
    protected $deliveryTrackingModel;
    // ==========================================
// ESCROW / PAYMENT RELEASE
// ==========================================
// ==========================================
// ANALYTICS
// ==========================================
public function analytics()
{
    // Check admin access
    $isLoggedIn = session()->get('is_logged_in') || session()->get('user_id');
    $isAdmin = session()->get('is_admin') || session()->get('role') === 'admin' || session()->get('role') === 'super_admin';

    if (!$isLoggedIn || !$isAdmin) {
        return redirect()->to('/login')->with('error', 'Access denied. Admin only.');
    }

    $db = \Config\Database::connect();

    // Get total revenue
    $totalRevenue = $db->table('orders')
                       ->selectSum('total_amount')
                       ->where('payment_status', 'paid')
                       ->get()
                       ->getRow()
                       ->total_amount ?? 0;

    // Get total orders
    $totalOrders = $db->table('orders')->countAllResults();

    // Get total customers
    $totalCustomers = $db->table('customers')->countAllResults();

    // Get total products
    $totalProducts = $db->table('products')->countAllResults();

    // Get total stores
    $totalStores = $db->table('tenants')->countAllResults();

    // Get active stores
    $activeStores = $db->table('tenants')
                       ->where('status', 'active')
                       ->countAllResults();

    // Get pending orders
    $pendingOrders = $db->table('orders')
                        ->where('order_status', 'pending')
                        ->countAllResults();

    // Get total categories
    $totalCategories = $db->table('categories')->countAllResults();

    // Get customer growth (compare this month vs last month)
    $currentMonthCustomers = $db->table('customers')
                                ->where('created_at >=', date('Y-m-01 00:00:00'))
                                ->countAllResults();

    $lastMonthCustomers = $db->table('customers')
                             ->where('created_at >=', date('Y-m-01 00:00:00', strtotime('-1 month')))
                             ->where('created_at <', date('Y-m-01 00:00:00'))
                             ->countAllResults();

    $customerGrowth = 0;
    if ($lastMonthCustomers > 0) {
        $customerGrowth = (($currentMonthCustomers - $lastMonthCustomers) / $lastMonthCustomers) * 100;
    }

    // Get top stores by revenue
    $topStores = $db->table('orders o')
                    ->select('t.store_name, SUM(o.total_amount) as revenue')
                    ->join('tenants t', 't.id = o.tenant_id')
                    ->where('o.payment_status', 'paid')
                    ->groupBy('t.store_name')
                    ->orderBy('revenue', 'DESC')
                    ->limit(5)
                    ->get()
                    ->getResultArray();

    $data = [
        'totalRevenue' => $totalRevenue,
        'totalOrders' => $totalOrders,
        'totalCustomers' => $totalCustomers,
        'totalProducts' => $totalProducts,
        'totalStores' => $totalStores,
        'activeStores' => $activeStores,
        'pendingOrders' => $pendingOrders,
        'totalCategories' => $totalCategories,
        'customerGrowth' => $customerGrowth,
        'topStores' => $topStores,
    ];

    return view('admin/analytics', $data);
}

public function escrowQueue()
{
    $db = \Config\Database::connect();

    $releasable = $db->table('delivery_tracking dt')
        ->select('dt.id as tracking_id, dt.confirmed_at, o.id as order_id, o.order_number, o.total_amount, o.created_at as order_date, p.id as payment_id, p.amount, p.platform_fee, p.store_owner_amount, p.status as payment_status, p.escrow_held, t.store_name, c.first_name, c.last_name')
        ->join('orders o', 'o.id = dt.order_id')
        ->join('payments p', 'p.order_id = o.id')
        ->join('tenants t', 't.id = o.tenant_id')
        ->join('customers c', 'c.id = o.customer_id')
        ->where('dt.confirmed_by_customer', true)
        ->where('p.escrow_held', true)
        ->orderBy('dt.confirmed_at', 'ASC')
        ->get()
        ->getResultArray();

    return view('admin/escrow_queue', ['releasable' => $releasable]);
}

public function releasePayment($paymentId)
{
    $paymentModel = new PaymentModel();
    $payment = $paymentModel->find($paymentId);

    if (!$payment) {
        return redirect()->to('/admin/escrow-queue')->with('error', 'Payment not found.');
    }

    if (!$payment['escrow_held']) {
        return redirect()->to('/admin/escrow-queue')->with('error', 'This payment has already been released.');
    }

    $paymentModel->update($paymentId, [
        'status' => 'released',
        'escrow_held' => false,
        'escrow_released_at' => date('Y-m-d H:i:s'),
        'released_at' => date('Y-m-d H:i:s'),
    ]);

    return redirect()->to('/admin/escrow-queue')->with('success', 'Payment released to store owner successfully!');
}

    public function __construct()
    {
        // Check if user is logged in as Super Admin
        if (!session()->get('is_logged_in') || session()->get('role') !== 'super_admin') {
            redirect()->to('/login')->with('error', 'Unauthorized access.')->send();
            exit();
        }

        $this->storeRequestModel = new StoreRequestModel();
        $this->tenantModel = new TenantModel();
        $this->systemUserModel = new SystemUserModel();
        $this->paymentModel = new PaymentModel();
        $this->orderModel = new OrderModel();
        $this->deliveryTrackingModel = new DeliveryTrackingModel();
    }

    // ==========================================
    // DASHBOARD
    // ==========================================

   // ==========================================
// DASHBOARD
// ==========================================


// ==========================================
// DASHBOARD
// ==========================================
// ==========================================
// DELIVERY COMPANY MANAGEMENT
// ==========================================

public function deliveryCompanies()
{
    $deliveryCompanyModel = new \App\Models\DeliveryCompanyModel();
    $companies = $deliveryCompanyModel->orderBy('created_at', 'DESC')->findAll();
    
    $data = [
        'companies' => $companies,
        'title' => 'Delivery Companies'
    ];
    
    return view('admin/delivery_companies', $data);
}

public function addDeliveryCompany()
{
    return view('admin/delivery_companies_add');
}

public function storeDeliveryCompany()
{
    $rules = [
        'name' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|is_unique[delivery_companies.email]',
        'phone' => 'required|min_length[10]|max_length[20]',
        'password' => 'required|min_length[8]',
        'address' => 'permit_empty'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
    }

    $deliveryCompanyModel = new \App\Models\DeliveryCompanyModel();
    
    $data = [
        'name' => $this->request->getPost('name'),
        'email' => $this->request->getPost('email'),
        'phone' => $this->request->getPost('phone'),
        'address' => $this->request->getPost('address'),
        'password' => $this->request->getPost('password'),
        'status' => $this->request->getPost('status') ?? 'pending',
        'force_password_change' => true
    ];

    if ($deliveryCompanyModel->insert($data)) {
        return redirect()->to('/admin/delivery-companies')->with('success', 'Delivery company added successfully!');
    }

    return redirect()->back()->with('error', 'Failed to add delivery company.');
}

public function editDeliveryCompany($id)
{
    $deliveryCompanyModel = new \App\Models\DeliveryCompanyModel();
    $company = $deliveryCompanyModel->find($id);
    
    if (!$company) {
        return redirect()->to('/admin/delivery-companies')->with('error', 'Company not found.');
    }
    
    return view('admin/delivery_companies_edit', ['company' => $company]);
}

public function updateDeliveryCompany($id)
{
    $deliveryCompanyModel = new \App\Models\DeliveryCompanyModel();
    $company = $deliveryCompanyModel->find($id);
    
    if (!$company) {
        return redirect()->to('/admin/delivery-companies')->with('error', 'Company not found.');
    }

    $rules = [
        'name' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|is_unique[delivery_companies.email,id,' . $id . ']',
        'phone' => 'required|min_length[10]|max_length[20]',
        'address' => 'permit_empty',
        'status' => 'required|in_list[pending,active,inactive]'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
    }

    $data = [
        'name' => $this->request->getPost('name'),
        'email' => $this->request->getPost('email'),
        'phone' => $this->request->getPost('phone'),
        'address' => $this->request->getPost('address'),
        'status' => $this->request->getPost('status')
    ];

    // Update password only if provided
    $newPassword = $this->request->getPost('password');
    if (!empty($newPassword)) {
        if (strlen($newPassword) < 8) {
            return redirect()->back()->with('error', 'Password must be at least 8 characters.');
        }
        $data['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        $data['force_password_change'] = true;
    }

    if ($deliveryCompanyModel->update($id, $data)) {
        return redirect()->to('/admin/delivery-companies')->with('success', 'Company updated successfully!');
    }

    return redirect()->back()->with('error', 'Failed to update company.');
}

public function toggleDeliveryCompany($id)
{
    $deliveryCompanyModel = new \App\Models\DeliveryCompanyModel();
    $company = $deliveryCompanyModel->find($id);
    
    if (!$company) {
        return redirect()->to('/admin/delivery-companies')->with('error', 'Company not found.');
    }

    $newStatus = $company['status'] === 'active' ? 'inactive' : 'active';
    $deliveryCompanyModel->update($id, ['status' => $newStatus]);

    return redirect()->to('/admin/delivery-companies')->with('success', 'Company ' . $newStatus . ' successfully!');
}

public function deleteDeliveryCompany($id)
{
    $deliveryCompanyModel = new \App\Models\DeliveryCompanyModel();
    $company = $deliveryCompanyModel->find($id);
    
    if (!$company) {
        return redirect()->to('/admin/delivery-companies')->with('error', 'Company not found.');
    }

    // Check if company has active deliveries
    $assignmentModel = new \App\Models\DeliveryAssignmentModel();
    $activeAssignments = $assignmentModel->where('company_id', $id)
        ->whereIn('status', ['assigned', 'picked_up', 'in_transit'])
        ->countAllResults();

    if ($activeAssignments > 0) {
        return redirect()->back()->with('error', 'Cannot delete company with active deliveries.');
    }

    $deliveryCompanyModel->delete($id);
    return redirect()->to('/admin/delivery-companies')->with('success', 'Company deleted successfully.');
}

public function resetDeliveryCompanyPassword($id)
{
    $deliveryCompanyModel = new \App\Models\DeliveryCompanyModel();
    $company = $deliveryCompanyModel->find($id);
    
    if (!$company) {
        return redirect()->to('/admin/delivery-companies')->with('error', 'Company not found.');
    }

    // Generate a random password
    $newPassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%'), 0, 12);
    
    $deliveryCompanyModel->update($id, [
        'password' => password_hash($newPassword, PASSWORD_DEFAULT),
        'force_password_change' => true
    ]);

    return redirect()->back()->with('success', 'Password reset successfully! New password: ' . $newPassword);
}

// ==========================================
// PLATFORM FEES
// ==========================================
public function orderDetails($orderId)
{
    $orderModel = new \App\Models\OrderModel();
    $order = $orderModel->find($orderId);
    
    if (!$order) {
        return redirect()->to('/admin/orders')->with('error', 'Order not found.');
    }
    
    $customerModel = new \App\Models\CustomerModel();
    $tenantModel = new \App\Models\TenantModel();
    $orderItemModel = new \App\Models\OrderItemModel();
    $productModel = new \App\Models\ProductModel();
    $deliveryAssignmentModel = new \App\Models\DeliveryAssignmentModel();
    
    $order['customer'] = $customerModel->find($order['customer_id']);
    $order['store'] = $tenantModel->find($order['tenant_id']);
    $order['items'] = $orderItemModel->where('order_id', $orderId)->findAll();
    
    foreach ($order['items'] as &$item) {
        $product = $productModel->find($item['product_id']);
        $item['product_name'] = $product['product_name'] ?? 'Unknown Product';
    }
    
    $assignment = $deliveryAssignmentModel->where('order_id', $orderId)->first();
    $order['pickup_code'] = $assignment['pickup_verification_code'] ?? 'N/A';
    $order['delivery_code'] = $assignment['delivery_verification_code'] ?? 'N/A';
    $order['delivery_status'] = $assignment['status'] ?? $order['delivery_status'] ?? 'pending';
    
    $data = [
        'order' => $order,
        'title' => 'Order Details'
    ];
    
    return view('admin/order_details', $data);
}

public function platformFees()
{
    $platformSettingsModel = new \App\Models\PlatformSettingModel();
    $settings = $platformSettingsModel->findAll();
    
    // Convert to key-value array
    $feeData = [];
    foreach ($settings as $setting) {
        $feeData[$setting['setting_key']] = $setting['setting_value'];
    }
    
    $data = [
        'fees' => $feeData,
        'title' => 'Platform Fees'
    ];
    
    return view('admin/platform_fees', $data);
}

public function updatePlatformFees()
{
    $platformSettingsModel = new \App\Models\PlatformSettingModel();
    
    $feeKeys = [
        'platform_fee_percentage',
        'platform_fee_fixed',
        'delivery_fee_base',
        'delivery_fee_per_km',
        'refund_window_days',
        'max_refund_percentage'
    ];
    
    foreach ($feeKeys as $key) {
        $value = $this->request->getPost($key);
        if ($value !== null) {
            $platformSettingsModel->where('setting_key', $key)->set(['setting_value' => $value])->update();
        }
    }
    
    return redirect()->to('/admin/platform-fees')->with('success', 'Platform fees updated successfully!');
}
// ==========================================
// STORE OWNER COMMISSIONS
// ==========================================

public function commissions()
{
    $platformSettingsModel = new \App\Models\PlatformSettingModel();
    $settings = $platformSettingsModel->findAll();
    
    $commissionData = [];
    foreach ($settings as $setting) {
        $commissionData[$setting['setting_key']] = $setting['setting_value'];
    }
    
    $data = [
        'commissions' => $commissionData,
        'title' => 'Store Owner Commissions'
    ];
    
    return view('admin/commissions', $data);
}

public function updateCommissions()
{
    $platformSettingsModel = new \App\Models\PlatformSettingModel();
    
    $commissionKeys = [
        'store_commission_percentage',
        'store_commission_fixed'
    ];
    
    foreach ($commissionKeys as $key) {
        $value = $this->request->getPost($key);
        if ($value !== null) {
            $platformSettingsModel->where('setting_key', $key)->set(['setting_value' => $value])->update();
        }
    }
    
    return redirect()->to('/admin/commissions')->with('success', 'Commissions updated successfully!');
}
// ==========================================
// SELLER PAYOUTS
// ==========================================

public function sellerPayouts()
{
    $payoutModel = new \App\Models\PayoutModel();
    $tenantModel = new \App\Models\TenantModel();
    
    // Get all payouts with tenant details
    $payouts = $payoutModel->orderBy('created_at', 'DESC')->findAll();
    
    foreach ($payouts as &$payout) {
        $tenant = $tenantModel->find($payout['tenant_id']);
        $payout['store_name'] = $tenant['store_name'] ?? 'Unknown Store';
    }
    
    $summary = [
        'total_pending' => $payoutModel->where('status', 'pending')->countAllResults(),
        'total_processing' => $payoutModel->where('status', 'processing')->countAllResults(),
        'total_paid' => $payoutModel->where('status', 'paid')->countAllResults(),
        'total_amount_pending' => $payoutModel->where('status', 'pending')->selectSum('net_amount')->first()['net_amount'] ?? 0,
        'total_amount_paid' => $payoutModel->where('status', 'paid')->selectSum('net_amount')->first()['net_amount'] ?? 0,
    ];
    
    $data = [
        'payouts' => $payouts,
        'summary' => $summary,
        'title' => 'Seller Payouts'
    ];
    
    return view('admin/seller_payouts', $data);
}

public function processPayout($payoutId)
{
    $payoutModel = new \App\Models\PayoutModel();
    $payout = $payoutModel->find($payoutId);
    
    if (!$payout) {
        return redirect()->back()->with('error', 'Payout not found.');
    }
    
    $paymentMethod = $this->request->getPost('payment_method') ?? 'bank_transfer';
    $transactionId = $this->request->getPost('transaction_id') ?? 'TXN-' . time();
    
    $payoutModel->processPayout($payoutId, $paymentMethod, $transactionId);
    
    return redirect()->back()->with('success', 'Payout marked as processing.');
}

public function completePayout($payoutId)
{
    $payoutModel = new \App\Models\PayoutModel();
    $payout = $payoutModel->find($payoutId);
    
    if (!$payout) {
        return redirect()->back()->with('error', 'Payout not found.');
    }
    
    $payoutModel->completePayout($payoutId);
    
    return redirect()->back()->with('success', 'Payout marked as paid.');
}
// ==========================================
// DELIVERY ASSIGNMENTS
// ==========================================

public function deliveryAssignments()
{
    $assignmentModel = new \App\Models\DeliveryAssignmentModel();
    $companyModel = new \App\Models\DeliveryCompanyModel();
    $tenantModel = new \App\Models\TenantModel();
    $orderModel = new \App\Models\OrderModel();
    
    $assignments = $assignmentModel->orderBy('created_at', 'DESC')->findAll();
    
    foreach ($assignments as &$assignment) {
        $company = $companyModel->find($assignment['company_id']);
        $assignment['company_name'] = $company['name'] ?? 'Unknown';
        
        $order = $orderModel->find($assignment['order_id']);
        if ($order) {
            $tenant = $tenantModel->find($order['tenant_id']);
            $assignment['store_name'] = $tenant['store_name'] ?? 'Unknown Store';
            $assignment['order_number'] = $order['order_number'] ?? '#' . $order['id'];
        }
    }
    
    $data = [
        'assignments' => $assignments,
        'companies' => $companyModel->findAll(),
        'title' => 'Delivery Assignments'
    ];
    
    return view('admin/delivery_assignments', $data);
}

public function updateDeliveryAssignment($assignmentId)
{
    $assignmentModel = new \App\Models\DeliveryAssignmentModel();
    $assignment = $assignmentModel->find($assignmentId);
    
    if (!$assignment) {
        return redirect()->back()->with('error', 'Assignment not found.');
    }
    
    $companyId = $this->request->getPost('company_id');
    $status = $this->request->getPost('status');
    
    if ($companyId) {
        $assignmentModel->update($assignmentId, ['company_id' => $companyId]);
    }
    
    if ($status) {
        $assignmentModel->updateStatus($assignmentId, $status);
    }
    
    return redirect()->back()->with('success', 'Delivery assignment updated successfully!');
}
// ==========================================
// DELIVERY STATUS
// ==========================================

public function deliveryStatus()
{
    $orderModel = new \App\Models\OrderModel();
    $assignmentModel = new \App\Models\DeliveryAssignmentModel();
    
    $orders = $orderModel->where('delivery_status !=', '')->orderBy('created_at', 'DESC')->limit(100)->findAll();
    
    $statusCounts = [
        'pending' => $orderModel->where('delivery_status', 'pending')->countAllResults(),
        'assigned' => $orderModel->where('delivery_status', 'assigned')->countAllResults(),
        'picked_up' => $orderModel->where('delivery_status', 'picked_up')->countAllResults(),
        'in_transit' => $orderModel->where('delivery_status', 'in_transit')->countAllResults(),
        'delivered' => $orderModel->where('delivery_status', 'delivered')->countAllResults(),
        'completed' => $orderModel->where('delivery_status', 'completed')->countAllResults(),
        'failed' => $orderModel->where('delivery_status', 'failed')->countAllResults(),
    ];
    
    foreach ($orders as &$order) {
        $assignment = $assignmentModel->where('order_id', $order['id'])->first();
        $order['pickup_code'] = $assignment['pickup_verification_code'] ?? 'N/A';
        $order['delivery_code'] = $assignment['delivery_verification_code'] ?? 'N/A';
        $order['company_id'] = $assignment['company_id'] ?? null;
    }
    
    $data = [
        'orders' => $orders,
        'statusCounts' => $statusCounts,
        'title' => 'Delivery Status'
    ];
    
    return view('admin/delivery_status', $data);
}
// ==========================================
// REFUNDS & DISPUTES
// ==========================================

public function refunds()
{
    $refundModel = new \App\Models\RefundRequestModel();
    $orderModel = new \App\Models\OrderModel();
    $customerModel = new \App\Models\CustomerModel();
    
    $refunds = $refundModel->orderBy('created_at', 'DESC')->findAll();
    
    foreach ($refunds as &$refund) {
        $order = $orderModel->find($refund['order_id']);
        $refund['order_number'] = $order['order_number'] ?? '#' . $order['id'];
        $refund['order_total'] = $order['total_amount'] ?? 0;
        $customer = $customerModel->find($refund['customer_id']);
        $refund['customer_name'] = $customer['first_name'] . ' ' . $customer['last_name'] ?? 'Unknown';
    }
    
    $stats = [
        'total' => $refundModel->countAllResults(),
        'pending' => $refundModel->where('status', 'pending')->countAllResults(),
        'approved' => $refundModel->where('status', 'approved')->countAllResults(),
        'rejected' => $refundModel->where('status', 'rejected')->countAllResults(),
    ];
    
    $data = [
        'refunds' => $refunds,
        'stats' => $stats,
        'title' => 'Refunds & Disputes'
    ];
    
    return view('admin/refunds', $data);
}

public function refundDetails($refundId)
{
    $refundModel = new \App\Models\RefundRequestModel();
    $refund = $refundModel->find($refundId);
    
    if (!$refund) {
        return redirect()->to('/admin/refunds')->with('error', 'Refund not found.');
    }
    
    $orderModel = new \App\Models\OrderModel();
    $customerModel = new \App\Models\CustomerModel();
    
    $refund['order'] = $orderModel->find($refund['order_id']);
    $refund['customer'] = $customerModel->find($refund['customer_id']);
    
    $data = [
        'refund' => $refund,
        'title' => 'Refund Details'
    ];
    
    return view('admin/refund_details', $data);
}

public function updateRefund($refundId)
{
    $refundModel = new \App\Models\RefundRequestModel();
    $refund = $refundModel->find($refundId);
    
    if (!$refund) {
        return redirect()->back()->with('error', 'Refund not found.');
    }
    
    $status = $this->request->getPost('status');
    $adminNote = $this->request->getPost('admin_note');
    
    if ($status === 'approved') {
        $refundModel->approveRequest($refundId, $adminNote);
        return redirect()->to('/admin/refunds')->with('success', 'Refund approved successfully!');
    } elseif ($status === 'rejected') {
        $refundModel->rejectRequest($refundId, $adminNote);
        return redirect()->to('/admin/refunds')->with('success', 'Refund rejected.');
    }
    
    return redirect()->back()->with('error', 'Invalid action.');
}
public function dashboard()
{
    $db = \Config\Database::connect();

    $tenants = $this->tenantModel->findAll();

    foreach ($tenants as &$tenant) {
        $owner = $this->systemUserModel->where('tenant_id', $tenant['id'])
                                      ->where('role', 'store_owner')
                                      ->first();
        $tenant['owner_name'] = $owner ? $owner['full_name'] : 'No owner';
        $tenant['owner_email'] = $owner ? $owner['email'] : 'No email';
    }

    $totalStores = count($tenants);
    $activeStores = $this->tenantModel->where('status', 'active')->countAllResults();
    $suspendedStores = $this->tenantModel->where('status', 'suspended')->countAllResults();

    $totalCustomers = $db->table('customers')->countAllResults();
    $newCustomers = $db->table('customers')
        ->where('created_at >=', date('Y-m-01'))
        ->countAllResults();

    $totalProducts = $db->table('products')->countAllResults();
    $totalOrders = $db->table('orders')->countAllResults();

    $revenueRow = $db->table('orders')->selectSum('total_amount')->get()->getRow();
    $totalRevenue = $revenueRow->total_amount ?? 0;

    // Build recent activity from real store requests, newest first
    $recentActivities = [];
    $recentRequests = $this->storeRequestModel->orderBy('created_at', 'DESC')->limit(5)->findAll();
    foreach ($recentRequests as $req) {
        $iconType = 'info';
        $badgeClass = 'bg-secondary';
        $badgeText = ucfirst($req['status']);
        if ($req['status'] === 'approved') {
            $iconType = 'success';
            $badgeClass = 'bg-success';
        } elseif ($req['status'] === 'pending') {
            $iconType = 'warning';
            $badgeClass = 'bg-warning text-dark';
        } elseif ($req['status'] === 'rejected') {
            $iconType = 'danger';
            $badgeClass = 'bg-danger';
        }

        $recentActivities[] = [
            'message' => 'Store request: "' . $req['store_name'] . '" by ' . $req['owner_name'],
            'time' => date('M d, Y', strtotime($req['created_at'])),
            'icon' => 'fa-store',
            'icon_type' => $iconType,
            'badge_class' => $badgeClass,
            'badge_text' => $badgeText,
        ];
    }

    $storeRequestModel = new StoreRequestModel();
    $data = [
        'tenants' => $tenants,
        'pendingRequests' => $storeRequestModel->getPendingRequests(),
        'totalStores' => $totalStores,
        'activeStores' => $activeStores,
        'suspendedStores' => $suspendedStores,
        'totalCustomers' => $totalCustomers,
        'newCustomers' => $newCustomers,
        'totalProducts' => $totalProducts,
        'totalOrders' => $totalOrders,
        'totalRevenue' => $totalRevenue,
        'recentActivities' => $recentActivities,
    ];

    return view('admin/dashboard', $data);
}
// ==========================================
// GET RECENT ACTIVITIES
// ==========================================

private function getRecentActivities()
{
    $db = \Config\Database::connect();
    
    $activities = [];
    
    // Get recent store registrations
    $recentStores = $db->table('tenants')
                       ->orderBy('created_at', 'DESC')
                       ->limit(3)
                       ->get()
                       ->getResultArray();
    
    foreach ($recentStores as $store) {
        $activities[] = [
            'icon' => 'fa-store',
            'icon_type' => 'success',
            'message' => 'New store registered: "' . esc($store['store_name']) . '"',
            'time' => $this->timeAgo($store['created_at']),
            'badge_class' => 'bg-success',
            'badge_text' => 'Approved'
        ];
    }
    
    // Get recent orders
    $recentOrders = $db->table('orders')
                       ->orderBy('created_at', 'DESC')
                       ->limit(3)
                       ->get()
                       ->getResultArray();
    
    foreach ($recentOrders as $order) {
        $activities[] = [
            'icon' => 'fa-shopping-bag',
            'icon_type' => 'info',
            'message' => 'New order #' . esc($order['order_number']) . ' placed',
            'time' => $this->timeAgo($order['created_at']),
            'badge_class' => 'bg-info',
            'badge_text' => 'New'
        ];
    }
    
    // Get recent customer registrations
    $recentCustomers = $db->table('customers')
                          ->orderBy('created_at', 'DESC')
                          ->limit(2)
                          ->get()
                          ->getResultArray();
    
    foreach ($recentCustomers as $customer) {
        $activities[] = [
            'icon' => 'fa-user',
            'icon_type' => 'info',
            'message' => 'New customer registered: ' . esc($customer['email']),
            'time' => $this->timeAgo($customer['created_at']),
            'badge_class' => 'bg-info',
            'badge_text' => 'New'
        ];
    }
    
    // Sort by time (newest first)
    usort($activities, function($a, $b) {
        $timeA = strtotime($a['time'] ?? 'now');
        $timeB = strtotime($b['time'] ?? 'now');
        return $timeB - $timeA;
    });
    
    return array_slice($activities, 0, 6);
}

private function timeAgo($datetime)
{
    if (empty($datetime)) return 'Just now';
    
    $time = strtotime($datetime);
    $diff = time() - $time;
    
    if ($diff < 60) return 'Just now';
    if ($diff < 3600) return floor($diff / 60) . ' minutes ago';
    if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
    if ($diff < 2592000) return floor($diff / 86400) . ' days ago';
    if ($diff < 31536000) return floor($diff / 2592000) . ' months ago';
    return date('M d, Y', $time);
}
  // ==========================================
// ORDERS
// ==========================================
public function orders()
{
    // Check admin access
    $isLoggedIn = session()->get('is_logged_in') || session()->get('user_id');
    $isAdmin = session()->get('is_admin') || session()->get('role') === 'admin' || session()->get('role') === 'super_admin';

    if (!$isLoggedIn || !$isAdmin) {
        return redirect()->to('/login')->with('error', 'Access denied. Admin only.');
    }

    $db = \Config\Database::connect();
    
    // Get status filter from URL
    $statusFilter = $this->request->getGet('status') ?? '';
    
    // Build query
    $builder = $db->table('orders o')
                  ->select('o.*, c.first_name, c.last_name, c.email as customer_email, t.store_name')
                  ->join('customers c', 'c.id = o.customer_id', 'left')
                  ->join('tenants t', 't.id = o.tenant_id', 'left')
                  ->orderBy('o.created_at', 'DESC');
    
    if (!empty($statusFilter)) {
        $builder->where('o.order_status', $statusFilter);
    }
    
    $orders = $builder->get()->getResultArray();
    
    // Get status counts for filter badges
    $statusCounts = [];
    $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
    foreach ($statuses as $status) {
        $statusCounts[$status] = $db->table('orders')
                                    ->where('order_status', $status)
                                    ->countAllResults();
    }
    $totalOrders = $db->table('orders')->countAllResults();
    
    return view('admin/orders', [
        'orders' => $orders,
        'statusFilter' => $statusFilter,
        'statusCounts' => $statusCounts,
        'totalOrders' => $totalOrders,
    ]);
}
// ==========================================
// PRODUCTS
// ==========================================
public function products()
{
    // Check admin access
    $isLoggedIn = session()->get('is_logged_in') || session()->get('user_id');
    $isAdmin = session()->get('is_admin') || session()->get('role') === 'admin' || session()->get('role') === 'super_admin';

    if (!$isLoggedIn || !$isAdmin) {
        return redirect()->to('/login')->with('error', 'Access denied. Admin only.');
    }

    $db = \Config\Database::connect();
    
    // Get status filter from URL
    $statusFilter = $this->request->getGet('status') ?? '';
    
    // Build query
    $builder = $db->table('products p')
                  ->select('p.*, t.store_name, c.category_name')
                  ->join('tenants t', 't.id = p.tenant_id', 'left')
                  ->join('categories c', 'c.id = p.category_id', 'left')
                  ->orderBy('p.created_at', 'DESC');
    
    if (!empty($statusFilter)) {
        $builder->where('p.status', $statusFilter);
    }
    
    $products = $builder->get()->getResultArray();
    
    // Get status counts for filter badges
    $statusCounts = [];
    $statuses = ['published', 'draft', 'archived'];
    foreach ($statuses as $status) {
        $statusCounts[$status] = $db->table('products')
                                    ->where('status', $status)
                                    ->countAllResults();
    }
    $totalProducts = $db->table('products')->countAllResults();
    
    return view('admin/products', [
        'products' => $products,
        'statusFilter' => $statusFilter,
        'statusCounts' => $statusCounts,
        'totalProducts' => $totalProducts,
    ]);
}

// ==========================================
// DELETE PRODUCT (Admin)
// ==========================================
public function deleteProduct($id)
{
    // Check admin access
    $isLoggedIn = session()->get('is_logged_in') || session()->get('user_id');
    $isAdmin = session()->get('is_admin') || session()->get('role') === 'admin' || session()->get('role') === 'super_admin';

    if (!$isLoggedIn || !$isAdmin) {
        return redirect()->to('/login')->with('error', 'Access denied.');
    }

    $db = \Config\Database::connect();
    
    // Get product to delete image
    $product = $db->table('products')
                  ->where('id', $id)
                  ->get()
                  ->getRowArray();
    
    if (!$product) {
        return redirect()->back()->with('error', 'Product not found.');
    }
    
    // Delete product image if exists
    if (!empty($product['product_image']) && file_exists(ROOTPATH . 'public/' . $product['product_image'])) {
        unlink(ROOTPATH . 'public/' . $product['product_image']);
    }
    
    // Delete product
    $db->table('products')->where('id', $id)->delete();
    
    log_message('info', "Product #{$id} deleted by admin.");
    
    return redirect()->to('/admin/products')->with('success', '✅ Product deleted successfully.');
}
// ==========================================
// SYSTEM SETTINGS
// ==========================================
public function systemSettings()
{
    // Check admin access
    $isLoggedIn = session()->get('is_logged_in') || session()->get('user_id');
    $isAdmin = session()->get('is_admin') || session()->get('role') === 'admin' || session()->get('role') === 'super_admin';

    if (!$isLoggedIn || !$isAdmin) {
        return redirect()->to('/login')->with('error', 'Access denied. Admin only.');
    }

    // Get settings from session or config
    $settings = [
        'platform_name' => session()->get('platform_name') ?? 'ShopEase',
        'platform_email' => session()->get('platform_email') ?? 'admin@shopease.com',
        'default_currency' => session()->get('default_currency') ?? 'USD',
        'default_language' => session()->get('default_language') ?? 'en',
        'platform_fee' => session()->get('platform_fee') ?? 10,
        'delivery_fee' => session()->get('delivery_fee') ?? 5,
        'free_shipping_threshold' => session()->get('free_shipping_threshold') ?? 50,
    ];

    return view('admin/settings', ['settings' => $settings]);
}

// ==========================================
// UPDATE SYSTEM SETTINGS
// ==========================================
public function updateSystemSettings()
{
    // Check admin access
    $isLoggedIn = session()->get('is_logged_in') || session()->get('user_id');
    $isAdmin = session()->get('is_admin') || session()->get('role') === 'admin' || session()->get('role') === 'super_admin';

    if (!$isLoggedIn || !$isAdmin) {
        return redirect()->to('/login')->with('error', 'Access denied.');
    }

    // Get POST data
    $platformName = $this->request->getPost('platform_name');
    $platformEmail = $this->request->getPost('platform_email');
    $defaultCurrency = $this->request->getPost('default_currency');
    $defaultLanguage = $this->request->getPost('default_language');
    $platformFee = $this->request->getPost('platform_fee');
    $deliveryFee = $this->request->getPost('delivery_fee');
    $freeShippingThreshold = $this->request->getPost('free_shipping_threshold');

    // Validate
    if (empty($platformName) || empty($platformEmail)) {
        return redirect()->back()->with('error', 'Platform name and email are required.');
    }

    // Save to session (or database)
    session()->set([
        'platform_name' => $platformName,
        'platform_email' => $platformEmail,
        'default_currency' => $defaultCurrency,
        'default_language' => $defaultLanguage,
        'platform_fee' => $platformFee,
        'delivery_fee' => $deliveryFee,
        'free_shipping_threshold' => $freeShippingThreshold,
    ]);

    // You can also save to a database table
    // $this->settingsModel->updateSettings($data);

    log_message('info', "System settings updated by admin.");

    return redirect()->back()->with('success', '✅ Settings updated successfully!');
}
public function paymentGateways()
{
    $db = \Config\Database::connect();
    $rows = $db->table('settings')->get()->getResultArray();

    $settings = [];
    foreach ($rows as $row) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }

    $gateways = [
        'chapa_enabled' => $settings['chapa_enabled'] ?? '1',
        'telebirr_enabled' => $settings['telebirr_enabled'] ?? '1',
        'cod_enabled' => $settings['cod_enabled'] ?? '1',
    ];

    return view('admin/payment_gateways', ['gateways' => $gateways]);
}

public function updatePaymentGateways()
{
    $db = \Config\Database::connect();

    $fields = [
        'chapa_enabled' => $this->request->getPost('chapa_enabled') ? '1' : '0',
        'telebirr_enabled' => $this->request->getPost('telebirr_enabled') ? '1' : '0',
        'cod_enabled' => $this->request->getPost('cod_enabled') ? '1' : '0',
    ];

    foreach ($fields as $key => $value) {
        $existing = $db->table('settings')->where('setting_key', $key)->get()->getRowArray();

        if ($existing) {
            $db->table('settings')->where('setting_key', $key)->update([
                'setting_value' => $value,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            $db->table('settings')->insert([
                'setting_key' => $key,
                'setting_value' => $value,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    return redirect()->to('/admin/payment-gateways')->with('success', 'Payment gateway settings updated!');
}

    // ==========================================
    // STORE REQUESTS
    // ==========================================

   // ==========================================
// STORE REQUESTS
// ==========================================
public function storeRequests()
{
    // Check admin access
    $isLoggedIn = session()->get('is_logged_in') || session()->get('user_id');
    $isAdmin = session()->get('is_admin') || session()->get('role') === 'admin' || session()->get('role') === 'super_admin';

    if (!$isLoggedIn || !$isAdmin) {
        return redirect()->to('/login')->with('error', 'Access denied. Admin only.');
    }

    $db = \Config\Database::connect();
    
    // Get pending requests
    $pendingRequests = $db->table('store_requests')
                          ->where('status', 'pending')
                          ->orderBy('created_at', 'DESC')
                          ->get()
                          ->getResultArray();
    
    // Get approved requests
    $approvedRequests = $db->table('store_requests')
                           ->where('status', 'approved')
                           ->orderBy('updated_at', 'DESC')
                           ->get()
                           ->getResultArray();
    
    // Get rejected requests
    $rejectedRequests = $db->table('store_requests')
                           ->where('status', 'rejected')
                           ->orderBy('updated_at', 'DESC')
                           ->get()
                           ->getResultArray();

    return view('admin/store_requests', [
        'pendingRequests' => $pendingRequests,
        'approvedRequests' => $approvedRequests,
        'rejectedRequests' => $rejectedRequests,
    ]);
}

    public function viewRequest($id)
    {
        $request = $this->storeRequestModel->find($id);
        if (!$request) {
            return redirect()->to('/admin/store-requests')->with('error', 'Request not found.');
        }

        return view('admin/store_request_view', ['request' => $request]);
    }

    public function approveRequest($id)
    {
        $request = $this->storeRequestModel->find($id);
        if (!$request) {
            return redirect()->to('/admin/store-requests')->with('error', 'Request not found.');
        }

        if ($request['status'] !== 'pending') {
            return redirect()->to('/admin/store-requests')->with('error', 'This request has already been reviewed.');
        }

        // Step 1: Create the tenant
        $tenantData = [
            'store_name' => $request['store_name'],
            'store_description' => $request['store_description'],
            'contact_email' => $request['owner_email'],
            'contact_phone' => $request['owner_phone'],
            'store_address' => $request['store_address'],
            'status' => 'active',
        ];

        $tenantId = $this->tenantModel->insert($tenantData);

        if (!$tenantId) {
            return redirect()->to('/admin/store-requests')->with('error', 'Failed to create tenant.');
        }

        // Step 2: Generate plain text password
        $plainPassword = $this->generateRandomPassword();

        // Step 3: Hash the password for storage
        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

        // Step 4: Create the store owner account
        $userData = [
            'tenant_id' => $tenantId,
            'full_name' => $request['owner_name'],
            'email' => $request['owner_email'],
            'password' => $hashedPassword,
            'role' => 'store_owner',
            'store_name' => $request['store_name'],
            'is_active' => true,
        ];

        $userId = $this->systemUserModel->insert($userData);

        if (!$userId) {
            $this->tenantModel->delete($tenantId);
            return redirect()->to('/admin/store-requests')->with('error', 'Failed to create store owner account.');
        }

        // Step 5: Update the request status
        $this->storeRequestModel->approveRequest($id, session()->get('user_id'));

        // Step 6: Build success message
        $message = '✅ Store request approved successfully!<br><br>';
        $message .= '<strong>Store Details:</strong><br>';
        $message .= 'Store Name: <strong>' . $request['store_name'] . '</strong><br>';
        $message .= 'Owner: <strong>' . $request['owner_name'] . '</strong><br>';
        $message .= 'Email: <strong>' . $request['owner_email'] . '</strong><br><br>';
        $message .= '<strong>Login Credentials:</strong><br>';
        $message .= 'Password: <span style="background:#f0f8f0;padding:5px 15px;border-radius:5px;font-size:20px;font-weight:bold;color:#4caf50;">' . $plainPassword . '</span><br><br>';
        $message .= '📋 Please copy the password and send it to the store owner manually.';

        return redirect()->to('/admin/store-requests')->with('success', $message);
    }

    public function rejectRequest($id)
    {
        $request = $this->storeRequestModel->find($id);
        if (!$request) {
            return redirect()->to('/admin/store-requests')->with('error', 'Request not found.');
        }

        if ($request['status'] !== 'pending') {
            return redirect()->to('/admin/store-requests')->with('error', 'This request has already been reviewed.');
        }

        $this->storeRequestModel->rejectRequest($id, session()->get('user_id'));

        return redirect()->to('/admin/store-requests')->with('success', 'Store request has been rejected.');
    }

    // ==========================================
    // STORE MANAGEMENT (TENANTS)
    // ==========================================

 public function stores()
{
    $db = \Config\Database::connect();
    
    // ✅ Get status filter from URL
    $statusFilter = $this->request->getGet('status') ?? '';
    
    // ✅ Build query
    $builder = $db->table('tenants')
                  ->orderBy('created_at', 'DESC');
    
    if (!empty($statusFilter)) {
        $builder->where('status', $statusFilter);
    }
    
    $tenants = $builder->get()->getResultArray();
    
    // Get store owner info for each tenant
    foreach ($tenants as &$tenant) {
        $owner = $db->table('system_users')
                    ->where('tenant_id', $tenant['id'])
                    ->where('role', 'store_owner')
                    ->get()
                    ->getRowArray();
        $tenant['owner_name'] = $owner ? $owner['full_name'] : 'No owner';
        $tenant['owner_email'] = $owner ? $owner['email'] : 'No email';
    }
    
    // ✅ Get status counts for filter badges
    $statusCounts = [];
    $statuses = ['active', 'pending', 'suspended', 'disabled'];
    foreach ($statuses as $status) {
        $statusCounts[$status] = $db->table('tenants')
                                    ->where('status', $status)
                                    ->countAllResults();
    }
    $totalStores = $db->table('tenants')->countAllResults();
    
    // ✅ Pass ALL variables to the view
    return view('admin/stores', [
        'tenants' => $tenants,
        'statusFilter' => $statusFilter,
        'statusCounts' => $statusCounts,
        'totalStores' => $totalStores,
    ]);
}

    public function createStore()
    {
        return view('admin/store_add');
    }

    public function storeStore()
    {
        $rules = [
            'store_name' => 'required|min_length[3]|max_length[255]|is_unique[tenants.store_name]',
            'owner_name' => 'required|min_length[3]|max_length[255]',
            'owner_email' => 'required|valid_email|is_unique[system_users.email]',
            'contact_email' => 'required|valid_email',
            'contact_phone' => 'required|min_length[10]|max_length[20]',
            'store_address' => 'required|min_length[5]',
            'manual_password' => 'required|min_length[8]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        // Step 1: Create the tenant
        $tenantData = [
            'store_name' => $this->request->getPost('store_name'),
            'store_description' => $this->request->getPost('store_description'),
            'contact_email' => $this->request->getPost('contact_email'),
            'contact_phone' => $this->request->getPost('contact_phone'),
            'store_address' => $this->request->getPost('store_address'),
            'status' => $this->request->getPost('status') ?: 'pending',
        ];

        $tenantId = $this->tenantModel->insert($tenantData);

        if (!$tenantId) {
            return redirect()->back()->with('error', 'Failed to create store.');
        }

        // Step 2: Get the manual password from the form
        $plainPassword = $this->request->getPost('manual_password');

        // Step 3: Hash the password for storage
        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

        // Step 4: Create the store owner account
        $userData = [
            'tenant_id' => $tenantId,
            'full_name' => $this->request->getPost('owner_name'),
            'email' => $this->request->getPost('owner_email'),
            'password' => $hashedPassword,
            'role' => 'store_owner',
            'store_name' => $this->request->getPost('store_name'),
            'is_active' => true,
        ];

        $userId = $this->systemUserModel->insert($userData);

        if (!$userId) {
            $this->tenantModel->delete($tenantId);
            return redirect()->back()->with('error', 'Failed to create store owner account.');
        }

        $message = '✅ Store created successfully!<br><br>';
        $message .= '<strong>Store Owner Credentials:</strong><br>';
        $message .= 'Store Name: <strong>' . $this->request->getPost('store_name') . '</strong><br>';
        $message .= 'Email: <strong>' . $this->request->getPost('owner_email') . '</strong><br>';
        $message .= 'Password: <span style="background:#f0f8f0;padding:5px 15px;border-radius:5px;font-size:20px;font-weight:bold;color:#4caf50;">' . $plainPassword . '</span>';

        return redirect()->to('/admin/stores')->with('success', $message);
    }

    public function editStore($id)
    {
        $tenant = $this->tenantModel->find($id);
        if (!$tenant) {
            return redirect()->to('/admin/stores')->with('error', 'Store not found.');
        }

        $owner = $this->systemUserModel->where('tenant_id', $id)
                                      ->where('role', 'store_owner')
                                      ->first();

        return view('admin/store_edit', [
            'tenant' => $tenant,
            'owner' => $owner,
        ]);
    }

    public function updateStore($id)
    {
        $tenant = $this->tenantModel->find($id);
        if (!$tenant) {
            return redirect()->to('/admin/stores')->with('error', 'Store not found.');
        }

        $rules = [
            'store_name' => 'required|min_length[3]|max_length[255]',
            'contact_email' => 'required|valid_email',
            'contact_phone' => 'required|min_length[10]|max_length[20]',
            'store_address' => 'required|min_length[5]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $data = [
            'store_name' => $this->request->getPost('store_name'),
            'store_description' => $this->request->getPost('store_description'),
            'contact_email' => $this->request->getPost('contact_email'),
            'contact_phone' => $this->request->getPost('contact_phone'),
            'store_address' => $this->request->getPost('store_address'),
            'status' => $this->request->getPost('status'),
        ];

        $this->tenantModel->update($id, $data);

        // Update store owner name if changed
        $owner = $this->systemUserModel->where('tenant_id', $id)
                                      ->where('role', 'store_owner')
                                      ->first();
        
        if ($owner) {
            $this->systemUserModel->update($owner['id'], [
                'full_name' => $this->request->getPost('owner_name'),
                'store_name' => $this->request->getPost('store_name'),
            ]);
        }

        return redirect()->to('/admin/stores')->with('success', 'Store updated successfully!');
    }

    public function suspendStore($id)
    {
        $tenant = $this->tenantModel->find($id);
        if (!$tenant) {
            return redirect()->to('/admin/stores')->with('error', 'Store not found.');
        }

        $newStatus = $tenant['status'] === 'suspended' ? 'active' : 'suspended';
        $this->tenantModel->update($id, ['status' => $newStatus]);

        $message = $newStatus === 'suspended' ? 'Store suspended successfully!' : 'Store activated successfully!';
        return redirect()->to('/admin/stores')->with('success', $message);
    }

    public function deleteStore($id)
    {
        $tenant = $this->tenantModel->find($id);
        if (!$tenant) {
            return redirect()->to('/admin/stores')->with('error', 'Store not found.');
        }

        // Delete store owner first
        $this->systemUserModel->where('tenant_id', $id)->delete();
        
        // Delete the tenant
        $this->tenantModel->delete($id);

        return redirect()->to('/admin/stores')->with('success', 'Store deleted successfully!');
    }

    public function resetStorePassword($id)
    {
        $owner = $this->systemUserModel->where('tenant_id', $id)
                                      ->where('role', 'store_owner')
                                      ->first();
        
        if (!$owner) {
            return redirect()->to('/admin/stores')->with('error', 'Store owner not found.');
        }

        $newPassword = $this->generateRandomPassword();
        $this->systemUserModel->update($owner['id'], [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
        ]);

        $message = '✅ Password reset successfully!<br><br>';
        $message .= 'New Password: <span style="background:#f0f8f0;padding:5px 15px;border-radius:5px;font-size:20px;font-weight:bold;color:#4caf50;">' . $newPassword . '</span>';

        return redirect()->to('/admin/stores')->with('success', $message);
    }

    // ==========================================
    // USER MANAGEMENT
    // ==========================================

  public function users()
{
    if (session()->get('role') !== 'super_admin') {
        return redirect()->to('/login')->with('error', 'Unauthorized access.');
    }

    // ==========================================
    // GET ALL CUSTOMERS
    // ==========================================
    $customerModel = new CustomerModel();

    $customers = $customerModel
        ->orderBy('id', 'DESC')
        ->findAll();

    // ==========================================
    // GET ALL STORE OWNERS
    // ==========================================
    $storeOwners = $this->systemUserModel
        ->where('role', 'store_owner')
        ->orderBy('id', 'DESC')
        ->findAll();

    // ==========================================
    // TOTAL USERS
    // ==========================================
    $totalUsers = count($customers) + count($storeOwners);

    return view('admin/users', [
        'customers'   => $customers,
        'storeOwners' => $storeOwners,
        'totalUsers'  => $totalUsers,
    ]);
}

    public function toggleCustomerStatus($id)
    {
        if (session()->get('role') !== 'super_admin') {
            return redirect()->to('/login')->with('error', 'Unauthorized access.');
        }

        $customerModel = new CustomerModel();
        $customer = $customerModel->find($id);
        if (!$customer) {
            return redirect()->to('/admin/users')->with('error', 'Customer not found.');
        }

        $newStatus = $customer['is_active'] ? false : true;
        $customerModel->update($id, ['is_active' => $newStatus]);

        $statusText = $newStatus ? 'activated' : 'suspended';
        return redirect()->to('/admin/users')->with('success', "Customer $statusText successfully.");
    }

    public function toggleStoreOwnerStatus($id)
    {
        if (session()->get('role') !== 'super_admin') {
            return redirect()->to('/login')->with('error', 'Unauthorized access.');
        }

        $user = $this->systemUserModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Store owner not found.');
        }

        $newStatus = $user['is_active'] ? false : true;
        $this->systemUserModel->update($id, ['is_active' => $newStatus]);

        $statusText = $newStatus ? 'activated' : 'suspended';
        return redirect()->to('/admin/users')->with('success', "Store owner $statusText successfully.");
    }

    public function resetStoreOwnerPassword($id)
    {
        if (session()->get('role') !== 'super_admin') {
            return redirect()->to('/login')->with('error', 'Unauthorized access.');
        }

        $user = $this->systemUserModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Store owner not found.');
        }

        $newPassword = $this->generateRandomPassword();
        $this->systemUserModel->update($id, [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
        ]);

        return redirect()->to('/admin/users')->with('success', "New password: <strong>$newPassword</strong> (Please send this to the store owner)");
    }

    // ==========================================
    // HELPER METHODS
    // ==========================================

    private function generateRandomPassword($length = 10)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $password;
    }

    private function encryptPassword($password)
    {
        $key = 'shopEaseSecureKey2024!!';
        $iv = substr($key, 0, 16);
        return openssl_encrypt($password, 'AES-256-CBC', $key, 0, $iv);
    }

    private function decryptPassword($encryptedPassword)
    {
        if (empty($encryptedPassword)) {
            return null;
        }
        $key = 'shopEaseSecureKey2024!!';
        $iv = substr($key, 0, 16);
        return openssl_decrypt($encryptedPassword, 'AES-256-CBC', $key, 0, $iv);
    }
}