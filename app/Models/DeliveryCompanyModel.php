<?php

namespace App\Models;

use CodeIgniter\Model;

class DeliveryCompanyModel extends Model
{
    protected $table = 'delivery_companies';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = [
        'name', 'email', 'phone', 'address', 'logo', 
        'password', 'status', 'force_password_change', 'last_login'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|is_unique[delivery_companies.email,id,{id}]',
        'phone' => 'required|min_length[10]|max_length[20]',
        'password' => 'required|min_length[8]',
        'status' => 'in_list[pending,active,inactive]'
    ];
    
    protected $validationMessages = [
        'email' => [
            'is_unique' => 'This email is already registered as a delivery company.'
        ]
    ];
    
    // ✅ ONLY hash on insert - NOT on update
    protected $beforeInsert = ['hashPassword'];
    // protected $beforeUpdate = ['hashPassword'];  // ← COMMENT THIS OUT
    
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
    
    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
    
    public function getActiveCompanies()
    {
        return $this->where('status', 'active')->findAll();
    }
    
    public function getPendingCompanies()
    {
        return $this->where('status', 'pending')->findAll();
    }
    
    public function getCompanyWithStats($companyId)
    {
        $company = $this->find($companyId);
        if (!$company) return null;
        
        $assignmentModel = new DeliveryAssignmentModel();
        $company['total_orders'] = $assignmentModel->where('company_id', $companyId)->countAllResults();
        $company['active_deliveries'] = $assignmentModel->where('company_id', $companyId)
            ->whereIn('status', ['assigned', 'picked_up', 'in_transit'])
            ->countAllResults();
        $company['completed_deliveries'] = $assignmentModel->where('company_id', $companyId)
            ->whereIn('status', ['delivered', 'completed'])
            ->countAllResults();
        $company['pending_orders'] = $assignmentModel->where('company_id', $companyId)
            ->where('status', 'pending')
            ->countAllResults();
            
        return $company;
    }
}