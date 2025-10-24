<?php

namespace App\Models;

use CodeIgniter\Model;

class EnrollmentModel extends Model
{
    protected $table = 'enrollments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'course_id', 'enrollment_date'];
    protected $useTimestamps = false;

    public function enrollUser(array $data)
    {
        // expects: ['user_id' => int, 'course_id' => int, 'enrollment_date' => 'Y-m-d H:i:s']
        return $this->insert($data, true) !== false;
    }

    public function getUserEnrollments(int $user_id)
    {
        return $this->select('courses.*, enrollments.enrollment_date')
            ->join('courses', 'courses.id = enrollments.course_id')
            ->where('enrollments.user_id', $user_id)
            ->orderBy('enrollments.enrollment_date', 'DESC')
            ->findAll();
    }

    public function isAlreadyEnrolled(int $user_id, int $course_id): bool
    {
        return $this->where('user_id', $user_id)
            ->where('course_id', $course_id)
            ->countAllResults() > 0;
    }
}
