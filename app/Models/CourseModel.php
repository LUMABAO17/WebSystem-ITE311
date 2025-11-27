<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'title',
        'description',
        'teacher_id',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[255]',
        'description' => 'permit_empty|max_length[1000]',
        'teacher_id' => 'required|is_natural_no_zero',
        'status' => 'permit_empty|in_list[active,inactive]'
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Get course by ID with teacher information
     */
    public function getCourseWithTeacher($id)
    {
        return $this->select('courses.*, users.name as teacher_name, users.email as teacher_email')
                   ->join('users', 'users.id = courses.teacher_id')
                   ->where('courses.id', $id)
                   ->first();
    }

    /**
     * Get all courses with teacher information
     */
    public function getAllCoursesWithTeacher()
    {
        return $this->select('courses.*, users.name as teacher_name')
                   ->join('users', 'users.id = courses.teacher_id')
                   ->orderBy('courses.created_at', 'DESC')
                   ->findAll();
    }

    /**
     * Get courses by teacher ID
     */
    public function getCoursesByTeacher($teacherId)
    {
        return $this->where('teacher_id', $teacherId)
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    /**
     * Check if user is enrolled in course
     */
    public function isEnrolled($courseId, $userId)
    {
        $enrollmentModel = new \App\Models\EnrollmentModel();
        return $enrollmentModel->where([
            'course_id' => $courseId,
            'user_id' => $userId
        ])->countAllResults() > 0;
    }
}
