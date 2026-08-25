<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixOrdersCityColumn extends Migration
{
    public function up()
    {
        // 1. Add shipping_city if it doesn't exist
        $this->db->query("
            DO $$ 
            BEGIN 
                IF NOT EXISTS (
                    SELECT 1 
                    FROM information_schema.columns 
                    WHERE table_name = 'orders' 
                    AND column_name = 'shipping_city'
                ) THEN
                    ALTER TABLE orders ADD COLUMN shipping_city VARCHAR(100) NOT NULL DEFAULT 'Unknown';
                END IF;
            END $$;
        ");

        // 2. Drop the old 'city' column if it exists and is different
        $this->db->query("
            DO $$ 
            BEGIN 
                IF EXISTS (
                    SELECT 1 
                    FROM information_schema.columns 
                    WHERE table_name = 'orders' 
                    AND column_name = 'city'
                ) THEN
                    ALTER TABLE orders DROP COLUMN city;
                END IF;
            END $$;
        ");

        // 3. Add shipping_postal_code if it doesn't exist
        $this->db->query("
            DO $$ 
            BEGIN 
                IF NOT EXISTS (
                    SELECT 1 
                    FROM information_schema.columns 
                    WHERE table_name = 'orders' 
                    AND column_name = 'shipping_postal_code'
                ) THEN
                    ALTER TABLE orders ADD COLUMN shipping_postal_code VARCHAR(20) NULL;
                END IF;
            END $$;
        ");
    }

    public function down()
    {
        // Rollback: Add city back and remove shipping_city
        $this->db->query("
            DO $$ 
            BEGIN 
                IF NOT EXISTS (
                    SELECT 1 
                    FROM information_schema.columns 
                    WHERE table_name = 'orders' 
                    AND column_name = 'city'
                ) THEN
                    ALTER TABLE orders ADD COLUMN city VARCHAR(100) NULL;
                END IF;
            END $$;
        ");

        $this->db->query("
            DO $$ 
            BEGIN 
                IF EXISTS (
                    SELECT 1 
                    FROM information_schema.columns 
                    WHERE table_name = 'orders' 
                    AND column_name = 'shipping_city'
                ) THEN
                    ALTER TABLE orders DROP COLUMN shipping_city;
                END IF;
            END $$;
        ");
    }
}