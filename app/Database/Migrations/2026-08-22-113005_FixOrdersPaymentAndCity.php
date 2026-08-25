<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixOrdersPaymentAndCity extends Migration
{
    public function up()
    {
        // Drop the payment method constraint
        $this->db->query("ALTER TABLE orders DROP CONSTRAINT IF EXISTS orders_payment_method_check");
        
        // Make city nullable
        $this->db->query("ALTER TABLE orders ALTER COLUMN city DROP NOT NULL");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE orders ALTER COLUMN city SET NOT NULL");
        $this->db->query("ALTER TABLE orders ADD CONSTRAINT orders_payment_method_check CHECK (payment_method IN ('cod', 'online'))");
    }
}