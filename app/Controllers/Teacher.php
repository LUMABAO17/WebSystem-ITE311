<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CourseModel;

class Teacher extends BaseController
{
    /**
     * Redirect teacher dashboard route to the main dashboard.
     */
    public function dashboard()
    {
        return redirect()->to('/dashboard');
    }

    /**
     * List courses assigned to the logged-in teacher.
     */
    public function courses()
    {
        if (!$this->isLoggedIn() || !$this->hasRole('teacher')) {
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access');
        }

        $teacherId = $this->userData['id'];
        $courseModel = new CourseModel();
        $courses = $courseModel->getCoursesByTeacher($teacherId);

        $data = [
            'title'   => 'My Courses',
            'courses' => $courses,
            'user'    => $this->userData,
        ];

        return view('teacher/courses/index', $data);
    }

    /**
     * List students enrolled in the teacher's courses.
     */
    public function students()
    {
        if (!$this->isLoggedIn() || !$this->hasRole('teacher')) {
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access');
        }

        $teacherId = $this->userData['id'];
        $db = \Config\Database::connect();

        $students = $db->table('enrollments')
            ->select('enrollments.enrollment_date, users.id as student_id, users.name as student_name, users.email as student_email, courses.id as course_id, courses.title as course_title')
            ->join('courses', 'courses.id = enrollments.course_id')
            ->join('users', 'users.id = enrollments.user_id')
            ->where('courses.teacher_id', $teacherId)
            ->orderBy('courses.title', 'ASC')
            ->orderBy('users.name', 'ASC')
            ->get()
            ->getResultArray();

        $data = [
            'title'    => 'My Students',
            'students' => $students,
            'user'     => $this->userData,
        ];

        return view('teacher/students/index', $data);
    }
}
