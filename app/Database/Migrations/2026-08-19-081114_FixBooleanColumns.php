<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixBooleanColumns extends Migration
{
    public function up()
    {
        // Fix subcategories table - ensure is_active is boolean
        $this->db->query("
            ALTER TABLE subcategories 
            ALTER COLUMN is_active TYPE boolean 
            USING is_active::boolean
        ");
        
        // Fix categories table - ensure is_active is boolean
        $this->db->query("
            ALTER TABLE categories 
            ALTER COLUMN is_active TYPE boolean 
            USING is_active::boolean
        ");
        
        // Fix products table - ensure is_active is boolean
        $this->db->query("
            ALTER TABLE products 
            ALTER COLUMN is_active TYPE boolean 
            USING is_active::boolean
        ");
        
        // Set default values to true
        $this->db->query("
            ALTER TABLE subcategories 
            ALTER COLUMN is_active SET DEFAULT true
        ");
        
        $this->db->query("
            ALTER TABLE categories 
            ALTER COLUMN is_active SET DEFAULT true
        ");
        
        $this->db->query("
            ALTER TABLE products 
            ALTER COLUMN is_active SET DEFAULT true
        ");
        
        // Update any NULL values to true
        $this->db->query("
            UPDATE subcategories 
            SET is_active = true 
            WHERE is_active IS NULL
        ");
        
        $this->db->query("
            UPDATE categories 
            SET is_active = true 
            WHERE is_active IS NULL
        ");
        
        $this->db->query("
            UPDATE products 
            SET is_active = true 
            WHERE is_active IS NULL
        ");
    }

    public function down()
    {
        // Rollback - change back to integer (if needed)
        $this->db->query("
            ALTER TABLE subcategories 
            ALTER COLUMN is_active TYPE integer 
            USING is_active::integer
        ");
        
        $this->db->query("
            ALTER TABLE categories 
            ALTER COLUMN is_active TYPE integer 
            USING is_active::integer
        ");
        
        $this->db->query("
            ALTER TABLE products 
            ALTER COLUMN is_active TYPE integer 
            USING is_active::integer
        ");
    }
}