<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDeliveryTrackingTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'order_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'tenant_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'delivery_person_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'delivery_person_phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'delivery_notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'delivery_photo' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => 'pending',
            ],
            'dispatched_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'delivered_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'confirmed_by_customer' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'confirmed_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'confirmation_method' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'manual',
            ],
            'disputed' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'dispute_reason' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'dispute_resolved' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'dispute_resolved_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'dispute_resolution_note' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('delivery_tracking');
    }

    public function down()
    {
        $this->forge->dropTable('delivery_tracking');
    }
}