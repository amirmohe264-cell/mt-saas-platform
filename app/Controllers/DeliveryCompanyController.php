<?php

namespace App\Controllers;

use App\Models\DeliveryCompanyModel;
use App\Models\DeliveryAgentModel;
use App\Models\DeliveryAssignmentModel;
use App\Models\OrderModel;
use App\Models\CustomerModel;
use App\Models\TenantModel;

class DeliveryCompanyController extends BaseController
{
    protected $deliveryCompanyModel;
    protected $deliveryAgentModel;
    protected $deliveryAssignmentModel;
    protected $orderModel;
    protected $customerModel;
    protected $tenantModel;

    public function __construct()
    {
        $this->deliveryCompanyModel = new DeliveryCompanyModel();
        $this->deliveryAgentModel = new DeliveryAgentModel();
        $this->deliveryAssignmentModel = new DeliveryAssignmentModel();
        $this->orderModel = new OrderModel();
        $this->customerModel = new CustomerModel();
        $this->tenantModel = new TenantModel();
    }

    // ==========================================
    // AUTHENTICATION
    // ==========================================

    // Show login page
    public function login()
    {
        if (session()->get('delivery_company_id')) {
            return redirect()->to('/delivery/dashboard');
        }
        return view('delivery_company/login');
    }

    // Process login
    public function loginPost()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $company = $this->deliveryCompanyModel->where('email', $email)->first();

        if (!$company) {
            return redirect()->back()->with('error', 'Invalid email or password.');
        }

        if ($company['status'] !== 'active') {
            return redirect()->back()->with('error', 'Your account is not active. Please contact admin.');
        }

        if (!password_verify($password, $company['password'])) {
            return redirect()->back()->with('error', 'Invalid email or password.');
        }

        session()->set([
            'delivery_company_id' => $company['id'],
            'delivery_company_name' => $company['name'],
            'delivery_company_email' => $company['email'],
            'delivery_company_logo' => $company['logo'],
            'is_delivery_logged_in' => true
        ]);

        $this->deliveryCompanyModel->update($company['id'], [
            'last_login' => date('Y-m-d H:i:s')
        ]);

        if ($company['force_password_change']) {
            return redirect()->to('/delivery/change-password')->with('warning', 'Please change your password.');
        }

        return redirect()->to('/delivery/dashboard')->with('success', 'Welcome back, ' . $company['name'] . '!');
    }

    // ==========================================
    // LOGOUT
    // ==========================================

    public function logout()
    {
        session()->remove([
            'delivery_company_id',
            'delivery_company_name',
            'delivery_company_email',
            'delivery_company_logo',
            'is_delivery_logged_in'
        ]);
        return redirect()->to('/delivery/login')->with('success', 'Logged out successfully.');
    }

    // ==========================================
    // CHANGE PASSWORD
    // ==========================================

    // Show change password page
    public function changePassword()
    {
        if (!session()->get('delivery_company_id')) {
            return redirect()->to('/delivery/login')->with('error', 'Please login first.');
        }
        
        $data = [
            'active_menu' => 'change-password',
            'company_name' => session()->get('delivery_company_name')
        ];
        
        return view('delivery_company/change_password', $data);
    }

    // Process password change
    public function updatePassword()
    {
        $companyId = session()->get('delivery_company_id');
        
        if (!$companyId) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'You must be logged in.'
            ]);
        }

        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');

        $company = $this->deliveryCompanyModel->find($companyId);

        if (!$company) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Company not found.'
            ]);
        }

        if (!password_verify($currentPassword, $company['password'])) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Current password is incorrect.'
            ]);
        }

        if (strlen($newPassword) < 8) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Password must be at least 8 characters.'
            ]);
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        $db = \Config\Database::connect();
        $builder = $db->table('delivery_companies');
        $result = $builder->update(
            [
                'password' => $hashedPassword,
                'force_password_change' => false
            ],
            ['id' => $companyId]
        );

        if ($result) {
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Password updated successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Failed to update password. Please try again.'
            ]);
        }
    }

    // ==========================================
    // DASHBOARD
    // ==========================================

    public function dashboard()
    {
        $companyId = session()->get('delivery_company_id');
        
        $totalOrders = $this->deliveryAssignmentModel
            ->where('company_id', $companyId)
            ->countAllResults();

        $activeDeliveries = $this->deliveryAssignmentModel
            ->where('company_id', $companyId)
            ->whereIn('status', ['assigned', 'picked_up', 'in_transit'])
            ->countAllResults();

        $completedDeliveries = $this->deliveryAssignmentModel
            ->where('company_id', $companyId)
            ->whereIn('status', ['delivered', 'completed'])
            ->countAllResults();

        $pendingOrders = $this->deliveryAssignmentModel
            ->where('company_id', $companyId)
            ->where('status', 'pending')
            ->countAllResults();

        $totalAgents = $this->deliveryAgentModel
            ->where('company_id', $companyId)
            ->where('status', 'active')
            ->countAllResults();

        $recentAssignments = $this->deliveryAssignmentModel
            ->where('company_id', $companyId)
            ->orderBy('created_at', 'DESC')
            ->limit(10)
            ->findAll();

        foreach ($recentAssignments as &$assignment) {
            $order = $this->orderModel->find($assignment['order_id']);
            if ($order) {
                $assignment['order_number'] = $order['order_number'] ?? '#' . $order['id'];
                $assignment['customer'] = $this->customerModel->find($order['customer_id']);
                $tenant = $this->tenantModel->find($order['tenant_id']);
                $assignment['store_name'] = $tenant['store_name'] ?? 'Unknown Store';
            }
        }

        $data = [
            'total_orders' => $totalOrders,
            'active_deliveries' => $activeDeliveries,
            'completed_deliveries' => $completedDeliveries,
            'pending_orders' => $pendingOrders,
            'total_agents' => $totalAgents,
            'recent_assignments' => $recentAssignments,
            'company_name' => session()->get('delivery_company_name'),
            'active_menu' => 'dashboard'
        ];

        return view('delivery_company/dashboard', $data);
    }

    // ==========================================
    // ORDERS MANAGEMENT
    // ==========================================

    public function orders()
    {
        $companyId = session()->get('delivery_company_id');
        $status = $this->request->getGet('status');

        $assignments = $this->deliveryAssignmentModel
            ->where('company_id', $companyId);

        if ($status && $status !== 'all') {
            $assignments->where('status', $status);
        }

        $assignments = $assignments->orderBy('created_at', 'DESC')->findAll();

        foreach ($assignments as &$assignment) {
            $order = $this->orderModel->find($assignment['order_id']);
            if ($order) {
                $assignment['order_number'] = $order['order_number'] ?? '#' . $order['id'];
                $assignment['order_total'] = $order['total_amount'] ?? 0;
                $tenant = $this->tenantModel->find($order['tenant_id']);
                $assignment['store_name'] = $tenant['store_name'] ?? 'Unknown Store';
                $assignment['customer'] = $this->customerModel->find($order['customer_id']);
            }
        }

        $data = [
            'assignments' => $assignments,
            'current_status' => $status,
            'statuses' => ['all', 'pending', 'assigned', 'picked_up', 'in_transit', 'delivered', 'completed', 'failed'],
            'active_menu' => 'orders'
        ];

        return view('delivery_company/orders', $data);
    }

    // ==========================================
    // ASSIGN PAGE - List all pending orders
    // ==========================================

    public function assign()
    {
        $companyId = session()->get('delivery_company_id');
        
        $assignments = $this->deliveryAssignmentModel
            ->where('company_id', $companyId)
            ->whereIn('status', ['pending', 'assigned'])
            ->orderBy('created_at', 'DESC')
            ->findAll();
        
        foreach ($assignments as &$assignment) {
            $order = $this->orderModel->find($assignment['order_id']);
            if ($order) {
                $assignment['order_number'] = $order['order_number'] ?? '#' . $order['id'];
                $assignment['order_total'] = $order['total_amount'] ?? 0;
                $tenant = $this->tenantModel->find($order['tenant_id']);
                $assignment['store_name'] = $tenant['store_name'] ?? 'Unknown Store';
                $assignment['customer'] = $this->customerModel->find($order['customer_id']);
            }
        }
        
        $data = [
            'assignments' => $assignments,
            'active_menu' => 'assign'
        ];
        
        return view('delivery_company/assign', $data);
    }

    // ==========================================
    // ORDER DETAILS
    // ==========================================

    public function orderDetails($assignmentId)
    {
        $companyId = session()->get('delivery_company_id');

        $assignment = $this->deliveryAssignmentModel
            ->where('id', $assignmentId)
            ->where('company_id', $companyId)
            ->first();

        if (!$assignment) {
            return redirect()->to('/delivery/orders')->with('error', 'Order not found.');
        }

        $order = $this->orderModel->find($assignment['order_id']);
        if ($order) {
            $assignment['order_number'] = $order['order_number'] ?? '#' . $order['id'];
            $assignment['order_total'] = $order['total_amount'] ?? 0;
            $assignment['customer'] = $this->customerModel->find($order['customer_id']);
            $assignment['store'] = $this->tenantModel->find($order['tenant_id']);
            
            $orderItemModel = model('App\Models\OrderItemModel');
            $assignment['order_items'] = $orderItemModel->where('order_id', $order['id'])->findAll();
            
            $productModel = model('App\Models\ProductModel');
            foreach ($assignment['order_items'] as &$item) {
                $product = $productModel->find($item['product_id']);
                $item['product_name'] = $product['product_name'] ?? 'Unknown Product';
            }
        }

        $assignment['company'] = $this->deliveryCompanyModel->find($companyId);
        $assignment['agent'] = $this->deliveryAgentModel->find($assignment['agent_id']);

        $data = [
            'assignment' => $assignment,
            'statuses' => ['assigned', 'picked_up', 'in_transit', 'delivered', 'completed', 'failed'],
            'active_menu' => 'orders'
        ];

        return view('delivery_company/order_details', $data);
    }

    // ==========================================
    // AGENTS MANAGEMENT
    // ==========================================

    public function agents()
    {
        $companyId = session()->get('delivery_company_id');
        $agents = $this->deliveryAgentModel
            ->where('company_id', $companyId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        foreach ($agents as &$agent) {
            $agent['active_assignments'] = $this->deliveryAssignmentModel
                ->where('agent_id', $agent['id'])
                ->whereIn('status', ['assigned', 'picked_up', 'in_transit'])
                ->countAllResults();
            $agent['total_assignments'] = $this->deliveryAssignmentModel
                ->where('agent_id', $agent['id'])
                ->countAllResults();
        }

        $data = [
            'agents' => $agents,
            'active_menu' => 'agents'
        ];

        return view('delivery_company/agents', $data);
    }

    public function addAgent()
    {
        $data = ['active_menu' => 'agents'];
        return view('delivery_company/agents_add', $data);
    }

    public function storeAgent()
    {
        $companyId = session()->get('delivery_company_id');

        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[delivery_agents.email]',
            'phone' => 'required|min_length[10]|max_length[20]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $data = [
            'company_id' => $companyId,
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'status' => 'active'
        ];

        if ($this->deliveryAgentModel->insert($data)) {
            return redirect()->to('/delivery/agents')->with('success', 'Delivery agent added successfully!');
        }

        return redirect()->back()->with('error', 'Failed to add agent. Please try again.');
    }

    public function editAgent($agentId)
    {
        $companyId = session()->get('delivery_company_id');
        $agent = $this->deliveryAgentModel
            ->where('id', $agentId)
            ->where('company_id', $companyId)
            ->first();

        if (!$agent) {
            return redirect()->to('/delivery/agents')->with('error', 'Agent not found.');
        }

        $data = [
            'agent' => $agent,
            'active_menu' => 'agents'
        ];

        return view('delivery_company/agents_edit', $data);
    }

    public function updateAgent($agentId)
    {
        $companyId = session()->get('delivery_company_id');

        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[delivery_agents.email,id,' . $agentId . ']',
            'phone' => 'required|min_length[10]|max_length[20]',
            'status' => 'required|in_list[active,inactive]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'status' => $this->request->getPost('status')
        ];

        if ($this->deliveryAgentModel->update($agentId, $data)) {
            return redirect()->to('/delivery/agents')->with('success', 'Agent updated successfully!');
        }

        return redirect()->back()->with('error', 'Failed to update agent.');
    }

    public function deleteAgent($agentId)
    {
        $companyId = session()->get('delivery_company_id');
        $agent = $this->deliveryAgentModel
            ->where('id', $agentId)
            ->where('company_id', $companyId)
            ->first();

        if (!$agent) {
            return redirect()->to('/delivery/agents')->with('error', 'Agent not found.');
        }

        $activeAssignments = $this->deliveryAssignmentModel
            ->where('agent_id', $agentId)
            ->whereIn('status', ['assigned', 'picked_up', 'in_transit'])
            ->countAllResults();

        if ($activeAssignments > 0) {
            return redirect()->back()->with('error', 'Cannot delete agent with active deliveries.');
        }

        $this->deliveryAgentModel->delete($agentId);
        return redirect()->to('/delivery/agents')->with('success', 'Agent deleted successfully.');
    }

    public function toggleAgent($agentId)
    {
        $companyId = session()->get('delivery_company_id');
        $agent = $this->deliveryAgentModel
            ->where('id', $agentId)
            ->where('company_id', $companyId)
            ->first();

        if (!$agent) {
            return redirect()->to('/delivery/agents')->with('error', 'Agent not found.');
        }

        $newStatus = $agent['status'] === 'active' ? 'inactive' : 'active';
        $this->deliveryAgentModel->update($agentId, ['status' => $newStatus]);

        return redirect()->to('/delivery/agents')->with('success', 'Agent ' . $newStatus . ' successfully!');
    }

    // ==========================================
    // ASSIGN DELIVERY - Individual assignment
    // ==========================================

    public function assignDelivery($assignmentId)
    {
        $companyId = session()->get('delivery_company_id');

        $assignment = $this->deliveryAssignmentModel
            ->where('id', $assignmentId)
            ->where('company_id', $companyId)
            ->first();

        if (!$assignment) {
            return redirect()->to('/delivery/orders')->with('error', 'Assignment not found.');
        }

        $agents = $this->deliveryAgentModel
            ->where('company_id', $companyId)
            ->where('status', 'active')
            ->findAll();

        $data = [
            'assignment' => $assignment,
            'agents' => $agents,
            'active_menu' => 'assign'
        ];

        return view('delivery_company/assign_delivery', $data);
    }

    public function updateAssignment($assignmentId)
    {
        $companyId = session()->get('delivery_company_id');

        $assignment = $this->deliveryAssignmentModel
            ->where('id', $assignmentId)
            ->where('company_id', $companyId)
            ->first();

        if (!$assignment) {
            return $this->response->setJSON(['success' => false, 'message' => 'Assignment not found.']);
        }

        $agentId = $this->request->getPost('agent_id');
        $status = $this->request->getPost('status');

        $updateData = [];

        if ($agentId) {
            $updateData['agent_id'] = $agentId;
            $updateData['status'] = 'assigned';
            
            $this->orderModel->update($assignment['order_id'], [
                'delivery_agent_id' => $agentId,
                'delivery_status' => 'assigned'
            ]);
        }

        if ($status) {
            $this->deliveryAssignmentModel->updateStatus($assignmentId, $status);
            $updateData['status'] = $status;
        }

        if (empty($updateData)) {
            return $this->response->setJSON(['success' => false, 'message' => 'No changes made.']);
        }

        $this->deliveryAssignmentModel->update($assignmentId, $updateData);

        return $this->response->setJSON(['success' => true, 'message' => 'Assignment updated successfully!']);
    }

    // ==========================================
    // ACTIVE DELIVERIES
    // ==========================================

    public function activeDeliveries()
    {
        $companyId = session()->get('delivery_company_id');

        $assignments = $this->deliveryAssignmentModel
            ->where('company_id', $companyId)
            ->whereIn('status', ['assigned', 'picked_up', 'in_transit'])
            ->orderBy('created_at', 'DESC')
            ->findAll();

        foreach ($assignments as &$assignment) {
            $order = $this->orderModel->find($assignment['order_id']);
            if ($order) {
                $assignment['order_number'] = $order['order_number'] ?? '#' . $order['id'];
                $assignment['customer'] = $this->customerModel->find($order['customer_id']);
            }
            $assignment['agent'] = $this->deliveryAgentModel->find($assignment['agent_id']);
        }

        $data = [
            'assignments' => $assignments,
            'active_menu' => 'active'
        ];

        return view('delivery_company/active_deliveries', $data);
    }

    // ==========================================
    // COMPLETED DELIVERIES
    // ==========================================

    public function completedDeliveries()
    {
        $companyId = session()->get('delivery_company_id');

        $assignments = $this->deliveryAssignmentModel
            ->where('company_id', $companyId)
            ->whereIn('status', ['delivered', 'completed'])
            ->orderBy('updated_at', 'DESC')
            ->limit(50)
            ->findAll();

        foreach ($assignments as &$assignment) {
            $order = $this->orderModel->find($assignment['order_id']);
            if ($order) {
                $assignment['order_number'] = $order['order_number'] ?? '#' . $order['id'];
                $assignment['customer'] = $this->customerModel->find($order['customer_id']);
            }
            $assignment['agent'] = $this->deliveryAgentModel->find($assignment['agent_id']);
        }

        $data = [
            'assignments' => $assignments,
            'active_menu' => 'completed'
        ];

        return view('delivery_company/completed_deliveries', $data);
    }

    // ==========================================
    // DELIVERY HISTORY
    // ==========================================

    public function deliveryHistory()
    {
        $companyId = session()->get('delivery_company_id');
        $limit = $this->request->getGet('limit') ?? 100;

        $assignments = $this->deliveryAssignmentModel
            ->where('company_id', $companyId)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->findAll();

        foreach ($assignments as &$assignment) {
            $order = $this->orderModel->find($assignment['order_id']);
            if ($order) {
                $assignment['order_number'] = $order['order_number'] ?? '#' . $order['id'];
                $assignment['customer'] = $this->customerModel->find($order['customer_id']);
            }
            $assignment['agent'] = $this->deliveryAgentModel->find($assignment['agent_id']);
        }

        $data = [
            'assignments' => $assignments,
            'total_count' => count($assignments),
            'active_menu' => 'history'
        ];

        return view('delivery_company/delivery_history', $data);
    }

    // ==========================================
    // UPDATE DELIVERY STATUS (AJAX)
    // ==========================================

    public function updateDeliveryStatus($assignmentId)
    {
        $companyId = session()->get('delivery_company_id');

        $assignment = $this->deliveryAssignmentModel
            ->where('id', $assignmentId)
            ->where('company_id', $companyId)
            ->first();

        if (!$assignment) {
            return $this->response->setJSON(['success' => false, 'message' => 'Assignment not found.']);
        }

        $status = $this->request->getPost('status');
        $notes = $this->request->getPost('notes');

        if (!in_array($status, ['picked_up', 'in_transit', 'delivered', 'completed', 'failed'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid status.']);
        }

        $this->deliveryAssignmentModel->updateStatus($assignmentId, $status, $notes);

        $this->orderModel->update($assignment['order_id'], [
            'delivery_status' => $status
        ]);

        if ($status === 'delivered') {
            $this->orderModel->update($assignment['order_id'], [
                'delivered_at' => date('Y-m-d H:i:s')
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Delivery status updated to ' . ucfirst(str_replace('_', ' ', $status)) . '!'
        ]);
    }
}