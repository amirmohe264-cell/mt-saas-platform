<?php

namespace App\Models;

use CodeIgniter\Model;

class DeliveryAgentModel extends Model
{
    protected $table = 'delivery_agents';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = [
        'company_id', 'name', 'email', 'phone', 'status'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'company_id' => 'required|integer',
        'name' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|is_unique[delivery_agents.email,id,{id}]',
        'phone' => 'required|min_length[10]|max_length[20]',
        'status' => 'in_list[active,inactive]'
    ];
    
    public function getAgentsByCompany($companyId)
    {
        return $this->where('company_id', $companyId)->findAll();
    }
    
    public function getActiveAgentsByCompany($companyId)
    {
        return $this->where('company_id', $companyId)
                    ->where('status', 'active')
                    ->findAll();
    }
}