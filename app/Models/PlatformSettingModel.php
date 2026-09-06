<?php

namespace App\Models;

use CodeIgniter\Model;

class PlatformSettingModel extends Model
{
    protected $table = 'platform_settings';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = [
        'setting_key', 'setting_value', 'description'
    ];
    
    protected $useTimestamps = false;
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'setting_key' => 'required|max_length[50]|is_unique[platform_settings.setting_key,id,{id}]',
        'setting_value' => 'required|max_length[255]'
    ];
    
    /**
     * Get a specific setting value by key
     */
    public function getSetting($key, $default = null)
    {
        $result = $this->where('setting_key', $key)->first();
        return $result ? $result['setting_value'] : $default;
    }
    
    /**
     * Update or create a setting
     */
    public function setSetting($key, $value, $description = null)
    {
        $existing = $this->where('setting_key', $key)->first();
        
        $data = [
            'setting_key' => $key,
            'setting_value' => $value
        ];
        
        if ($description !== null) {
            $data['description'] = $description;
        }
        
        if ($existing) {
            return $this->update($existing['id'], $data);
        } else {
            return $this->insert($data);
        }
    }
    
    /**
     * Get all settings as key-value array
     */
    public function getAllSettings()
    {
        $settings = $this->findAll();
        $result = [];
        foreach ($settings as $setting) {
            $result[$setting['setting_key']] = $setting['setting_value'];
        }
        return $result;
    }
    
    /**
     * Get all platform fees
     */
    
    public function getPlatformFees()
    {
        $keys = [
            'platform_fee_percentage',
            'platform_fee_fixed',
            'delivery_fee_base',
            'delivery_fee_per_km',
            'refund_window_days',
            'max_refund_percentage'
        ];
        
        $settings = $this->whereIn('setting_key', $keys)->findAll();
        $result = [];
        foreach ($settings as $setting) {
            $result[$setting['setting_key']] = $setting['setting_value'];
        }
        return $result;
    }
    
    /**
     * Get all commission settings
     */
    public function getCommissionSettings()
    {
        $keys = [
            'store_commission_percentage',
            'store_commission_fixed'
        ];
        
        $settings = $this->whereIn('setting_key', $keys)->findAll();
        $result = [];
        foreach ($settings as $setting) {
            $result[$setting['setting_key']] = $setting['setting_value'];
        }
        return $result;
    }
}