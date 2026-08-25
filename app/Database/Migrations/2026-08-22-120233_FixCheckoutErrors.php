<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixCheckoutErrors extends Migration
{
    public function up()
    {
        // 1. Drop payment method constraint
        $this->db->query("ALTER TABLE orders DROP CONSTRAINT IF EXISTS orders_payment_method_check");
        
        // 2. Make city nullable
        $this->db->query("ALTER TABLE orders ALTER COLUMN city DROP NOT NULL");
        
        // 3. Add timestamps to order_items
        $this->db->query("ALTER TABLE order_items ADD COLUMN IF NOT EXISTS created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
        $this->db->query("ALTER TABLE order_items ADD COLUMN IF NOT EXISTS updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
        
        // 4. Remove product_name from order_items
        $this->db->query("ALTER TABLE order_items DROP COLUMN IF EXISTS product_name");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE orders ALTER COLUMN city SET NOT NULL");
        $this->db->query("ALTER TABLE order_items DROP COLUMN created_at");
        $this->db->query("ALTER TABLE order_items DROP COLUMN updated_at");
    }
}