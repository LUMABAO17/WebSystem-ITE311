<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        // Get teacher user ID (assuming teacher is the 3rd user, index 2)
        $teacher = $this->db->table('users')->where('role', 'teacher')->get()->getRowArray();
        
        if (!$teacher) {
            return;
        }

        $teacherId = $teacher['id'];

        $data = [
            [
                'teacher_id' => $teacherId,
                'title' => 'Introduction to Web Development',
                'description' => 'Learn the fundamentals of HTML, CSS, and JavaScript to build modern websites.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'teacher_id' => $teacherId,
                'title' => 'Database Management Systems',
                'description' => 'Master SQL queries, database design, and management techniques.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'teacher_id' => $teacherId,
                'title' => 'Python Programming',
                'description' => 'Learn Python from basics to advanced concepts including data structures and algorithms.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'teacher_id' => $teacherId,
                'title' => 'Mobile App Development',
                'description' => 'Build mobile applications for iOS and Android platforms.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'teacher_id' => $teacherId,
                'title' => 'Machine Learning Fundamentals',
                'description' => 'Introduction to AI and machine learning concepts with practical examples.',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('courses')->insertBatch($data);
    }
}
