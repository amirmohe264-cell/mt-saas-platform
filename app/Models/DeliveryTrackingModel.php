<?php

namespace App\Models;

use CodeIgniter\Model;

class DeliveryTrackingModel extends Model
{
    protected $table = 'delivery_tracking';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'order_id',
        'tenant_id',
        'delivery_person_name',
        'delivery_person_phone',
        'delivery_notes',
        'delivery_photo',
        'status',
        'dispatched_at',
        'delivered_at',
        'confirmed_by_customer',
        'confirmed_at',
        'confirmation_method',
        'disputed',
        'dispute_reason',
        'dispute_resolved',
        'dispute_resolved_at',
        'dispute_resolution_note',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}