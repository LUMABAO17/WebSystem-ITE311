<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;


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
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Crisandy Gomez',
                'email' => 'Gomez@gmail.com',
                'password' => password_hash('2311600073', PASSWORD_DEFAULT),
                'role' => 'student',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Krishy game',
                'email' => 'krish@gmail.com',
                'password' => password_hash('kirsh123', PASSWORD_DEFAULT),
                'role' => 'instructor',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];
        // Insert all data in one go
        $this->db->table('users')->insertBatch($data);
    }
}
