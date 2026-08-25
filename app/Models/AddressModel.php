<?php

namespace App\Models;

use CodeIgniter\Model;

class AddressModel extends Model
{
    protected $table = 'addresses';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'customer_id',
        'address_name',
        'first_name',
        'last_name',
        'phone',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'postal_code',
        'country',
        'is_default',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getCustomerAddresses($customerId)
    {
        return $this->where('customer_id', $customerId)
                    ->orderBy('is_default', 'DESC')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getDefaultAddress($customerId)
    {
        return $this->where('customer_id', $customerId)
                    ->where('is_default', true)
                    ->first();
    }

    public function setDefaultAddress($customerId, $addressId)
    {
        // Reset all addresses to non-default
        $this->where('customer_id', $customerId)
             ->set(['is_default' => false])
             ->update();
        
        // Set the selected address as default
        return $this->update($addressId, ['is_default' => true]);
    }

    public function getAddressCount($customerId)
    {
        return $this->where('customer_id', $customerId)->countAllResults();
    }
}