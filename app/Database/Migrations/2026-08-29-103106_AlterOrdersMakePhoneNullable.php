<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterOrdersMakePhoneNullable extends Migration
{
    public function up()
    {
        // Check if orders table exists
        if (!$this->db->tableExists('orders')) {
            return;
        }

        // Make phone columns nullable
        $this->forge->modifyColumn('orders', [
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'customer_phone' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'postal_code' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
        ]);

        // Add customer_name and customer_email if they don't exist
        $columns = $this->db->getFieldNames('orders');
        
        if (!in_array('customer_name', $columns)) {
            $this->forge->addColumn('orders', [
                'customer_name' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'null' => true,
                    'after' => 'customer_id',
                ],
            ]);
        }
        
        if (!in_array('customer_email', $columns)) {
            $this->forge->addColumn('orders', [
                'customer_email' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'null' => true,
                    'after' => 'customer_name',
                ],
            ]);
        }
        
        if (!in_array('customer_phone', $columns)) {
            $this->forge->addColumn('orders', [
                'customer_phone' => [
                    'type' => 'VARCHAR',
                    'constraint' => '20',
                    'null' => true,
                    'after' => 'customer_email',
                ],
            ]);
        }
    }

    public function down()
    {
        // Revert changes
        $this->forge->modifyColumn('orders', [
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false,
            ],
            'postal_code' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false,
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
        ]);
    }
}