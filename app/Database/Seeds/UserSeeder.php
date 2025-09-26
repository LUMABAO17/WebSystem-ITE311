<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Jeraldzz',
                'email' => 'JeraldMaca@gmail.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Crisandy Gomez',
                'email' => 'Gomez@gmail.com',
                'password' => password_hash('2311600073', PASSWORD_DEFAULT),
                'role' => 'student',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Krishy Talino',
                'email' => 'Krish@gmail.com',
                'password' => password_hash('2311600074', PASSWORD_DEFAULT),
                'role' => 'teacher',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
