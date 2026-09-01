<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUpdatedAtToWishlist extends Migration
{
    public function up()
    {
        // Add updated_at column to wishlist table
        $this->forge->addColumn('wishlist', [
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => null,
                'after' => 'created_at',
            ],
        ]);
    }

    public function down()
    {
        // Drop updated_at column from wishlist table
        $this->forge->dropColumn('wishlist', 'updated_at');
    }
}