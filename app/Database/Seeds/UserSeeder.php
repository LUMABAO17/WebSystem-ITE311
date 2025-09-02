<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'GOMEZ',
                'email' => 'GomezCrisandy@gmail.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Jerald Maca',
                'email' => 'JeraldMaca@gmail.com',
                'password' => password_hash('2311600073', PASSWORD_DEFAULT),
                'role' => 'student',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert multiple records
        $this->db->table('users')->insertBatch($data);
    }
}
