<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Moying',
                'email' => 'almuhyilumabao2@gmail.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'elleyyy',
                'email' => '3lleyyy@gmail.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'student',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'leah',
                'email' => 'leah@gmail.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'teacher',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
