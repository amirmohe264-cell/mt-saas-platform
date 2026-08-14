<?php

namespace App\Models;

use CodeIgniter\Model;

class StoreRequestModel extends Model
{
    protected $table            = 'store_requests';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields = ['store_name', 'owner_name', 'owner_email', 'owner_email_password', 'owner_phone', 'store_description', 'store_address', 'business_type', 'legal_documents', 'status', 'reviewed_by', 'reviewed_at'];
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public function getPendingRequests()
    {
        return $this->where('status', 'pending')
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }

    public function getApprovedRequests()
    {
        return $this->where('status', 'approved')
                    ->orderBy('updated_at', 'DESC')
                    ->findAll();
    }

    public function getRejectedRequests()
    {
        return $this->where('status', 'rejected')
                    ->orderBy('updated_at', 'DESC')
                    ->findAll();
    }

    public function approveRequest($id, $reviewedBy)
    {
        return $this->update($id, [
            'status' => 'approved',
            'reviewed_by' => $reviewedBy,
            'reviewed_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function rejectRequest($id, $reviewedBy)
    {
        return $this->update($id, [
            'status' => 'rejected',
            'reviewed_by' => $reviewedBy,
            'reviewed_at' => date('Y-m-d H:i:s')
        ]);
    }
    
}