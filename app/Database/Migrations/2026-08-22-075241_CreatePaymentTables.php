<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePaymentTables extends Migration
{
    public function up()
    {
        // Payments table (Escrow)
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'order_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tenant_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'customer_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'amount' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'platform_fee' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0],
            'delivery_fee' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0],
            'store_owner_amount' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'payment_method' => ['type' => 'VARCHAR', 'constraint' => 50],
            'transaction_id' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'pending'],
            'escrow_held' => ['type' => 'BOOLEAN', 'default' => true],
            'escrow_released_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'paid_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'confirmed_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'released_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('customer_id', 'customers', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('payments');

        // Delivery Tracking table
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'order_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tenant_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'delivery_person_name' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'delivery_person_phone' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'delivery_notes' => ['type' => 'TEXT', 'null' => true],
            'delivery_photo' => ['type' => 'TEXT', 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'pending'],
            'dispatched_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'delivered_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'confirmed_by_customer' => ['type' => 'BOOLEAN', 'default' => false],
            'confirmed_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'confirmation_method' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'manual'],
            'disputed' => ['type' => 'BOOLEAN', 'default' => false],
            'dispute_reason' => ['type' => 'TEXT', 'null' => true],
            'dispute_resolved' => ['type' => 'BOOLEAN', 'default' => false],
            'dispute_resolved_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'dispute_resolution_note' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('delivery_tracking');

        // Add payment_id to orders
        $this->forge->addColumn('orders', [
            'payment_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('orders', 'payment_id');
        $this->forge->dropTable('delivery_tracking');
        $this->forge->dropTable('payments');
    }
}