<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EnrollmentModel;
use App\Models\MaterialModel;

class Student extends BaseController
{
    /**
     * Display student's enrolled courses
     */
    public function courses()
    {
        // Require authentication
        if (!$this->isLoggedIn()) {
            return redirect()->to('/login')->with('error', 'Please login to continue');
        }

        // Require student role
        if (!$this->hasRole('student')) {
            return redirect()->to('/dashboard')->with('error', 'You do not have access to this page');
        }

        $db = \Config\Database::connect();
        $userId = $this->userData['id'];
        
        // Get all enrolled courses
        $enrolledCourses = $db->table('enrollments')
            ->select('courses.*, enrollments.enrollment_date')
            ->join('courses', 'courses.id = enrollments.course_id')
            ->where('enrollments.user_id', $userId)
            ->orderBy('enrollments.enrollment_date', 'DESC')
            ->get()
            ->getResultArray();

        return view('student/courses', [
            'title' => 'My Courses',
            'courses' => $enrolledCourses,
        ]);
    }

    /**
     * Display course details
     */
    public function courseDetails($course_id)
    {
        // Require authentication
        if (!$this->isLoggedIn()) {
            return redirect()->to('/login')->with('error', 'Please login to continue');
        }

        // Require student role
        if (!$this->hasRole('student')) {
            return redirect()->to('/dashboard')->with('error', 'You do not have access to this page');
        }

        $db = \Config\Database::connect();
        $userId = $this->userData['id'];
        
        // Get course details
        $course = $db->table('courses')->where('id', $course_id)->get()->getRowArray();
        
        if (!$course) {
            return redirect()->to('/dashboard')->with('error', 'Course not found');
        }

        // Verify student is enrolled
        $enrollmentModel = new EnrollmentModel();
        if (!$enrollmentModel->isAlreadyEnrolled($userId, $course_id)) {
            return redirect()->to('/dashboard')->with('error', 'You are not enrolled in this course');
        }

        // Get course materials
        $materialModel = new MaterialModel();
        $materials = $materialModel->getMaterialsByCourse($course_id);

        // Get course lessons (if available)
        $lessons = $db->table('lessons')
            ->where('course_id', $course_id)
            ->orderBy('order', 'ASC')
            ->get()
            ->getResultArray();

        return view('student/course_details', [
            'title' => $course['title'],
            'course' => $course,
            'materials' => $materials,
            'lessons' => $lessons,
        ]);
    }
}
