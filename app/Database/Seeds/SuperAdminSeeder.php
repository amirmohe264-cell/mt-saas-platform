<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        $password = password_hash('Admin@123', PASSWORD_DEFAULT);

        $data = [
            'full_name' => 'Super Admin',
            'email'     => 'admin@vendly.com',
            'password'  => $password,
            'role'      => 'super_admin',
            'is_active' => true,
        ];

        $this->db->table('system_users')->insert($data);
    }
}