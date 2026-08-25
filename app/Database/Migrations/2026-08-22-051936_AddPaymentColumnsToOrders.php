<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPaymentColumnsToOrders extends Migration
{
    public function up()
    {
        $this->forge->addColumn('orders', [
            'payment_id' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'payment_method',
            ],
            'payment_reference' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'payment_id',
            ],
            'payment_status' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => 'pending',
                'after' => 'payment_reference',
            ],
            'paid_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'after' => 'payment_status',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('orders', 'payment_id');
        $this->forge->dropColumn('orders', 'payment_reference');
        $this->forge->dropColumn('orders', 'payment_status');
        $this->forge->dropColumn('orders', 'paid_at');
    }
}