<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'     => 'Admin LUMABAO17',
                'email'    => 'almuhyilumabao2.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role'     => 'admin',
            ],
            [
                'name'     => 'Instructor Elle',
                'email'    => '3lleyyy@gmail.com',
                'password' => password_hash('instructor123', PASSWORD_DEFAULT),
                'role'     => 'instructor',
            ],
            [
                'name'     => 'Student Yunah',
                'email'    => 'handsomeyunah@gmail.com',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'role'     => 'student',
            ],
        ];

        // Insert multiple records
        $this->db->table('users')->insertBatch($data);
    }
}
