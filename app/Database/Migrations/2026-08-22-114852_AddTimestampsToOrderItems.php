<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTimestampsToOrderItems extends Migration
{
    public function up()
    {
        $this->forge->addColumn('order_items', [
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('order_items', 'created_at');
        $this->forge->dropColumn('order_items', 'updated_at');
    }
}