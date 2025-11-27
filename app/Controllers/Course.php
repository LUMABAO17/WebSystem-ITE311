<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EnrollmentModel;
use App\Models\CourseModel;

class Course extends BaseController
{
    protected $courseModel;
    
    public function __construct()
    {
        $this->courseModel = new CourseModel();
        $this->materialModel = new \App\Models\MaterialModel();
        $this->enrollmentModel = new EnrollmentModel();
    }
    
    /**
     * List all courses for admin
     */
    /**
     * View a single course with its materials
     */
    public function view($id = null)
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to('/login');
        }

        $course = $this->courseModel->find($id);
        if (!$course) {
            return redirect()->back()->with('error', 'Course not found');
        }

        // Check if user is enrolled or is an admin/teacher
        $isEnrolled = $this->enrollmentModel->where([
            'user_id' => session()->get('userID'),
            'course_id' => $id
        ])->first();

        $isTeacherOrAdmin = in_array(session()->get('role'), ['admin', 'teacher']);

        if (!$isEnrolled && !$isTeacherOrAdmin) {
            return redirect()->back()->with('error', 'You are not enrolled in this course');
        }

        $data = [
            'title' => $course['title'],
            'course' => $course,
            'materials' => $this->materialModel->where('course_id', $id)->findAll(),
            'user' => $this->userData,
            'isEnrolled' => (bool)$isEnrolled,
            'isTeacherOrAdmin' => $isTeacherOrAdmin
        ];

        return view('course/view', $data);
    }
    
    /**
     * List all courses for admin
     */
    public function index()
    {
        if (!$this->isLoggedIn() || !$this->hasRole('admin')) {
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access');
        }
        
        // Get courses with teacher information
        $courseModel = new \App\Models\CourseModel();
        $courses = $courseModel->getAllCoursesWithTeacher();
        
        // Set default status for new courses
        foreach ($courses as &$course) {
            if (!isset($course['status'])) {
                $course['status'] = 'active'; // Set default status
            }
        }
        
        $data = [
            'title' => 'Manage Courses',
            'courses' => $courses,
            'user' => $this->userData
        ];
        
        return view('admin/courses/index', $data);
    }
    
    /**
     * Show create course form
     */
    public function create()
    {
        if (!$this->isLoggedIn() || !$this->hasRole('admin')) {
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access');
        }
        
        $data = [
            'title' => 'Create New Course',
            'user' => $this->userData
        ];
        
        return view('admin/courses/create', $data);
    }
    
    /**
     * Handle course creation
     */
    public function store()
    {
        if (!$this->isLoggedIn() || !$this->hasRole('admin')) {
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access');
        }
        
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'description' => 'required|min_length[10]',
            'teacher_id' => 'required|numeric',
            'status' => 'required|in_list[active,inactive]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'teacher_id' => $this->request->getPost('teacher_id'),
            'status' => $this->request->getPost('status'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        if ($this->courseModel->insert($data)) {
            return redirect()->to('/admin/courses')->with('success', 'Course created successfully');
        }
        
        return redirect()->back()->withInput()->with('error', 'Failed to create course');
    }
    
    /**
     * Show edit course form
     */
    public function edit($id)
    {
        if (!$this->isLoggedIn() || !$this->hasRole('admin')) {
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access');
        }
        
        $course = $this->courseModel->find($id);
        if (!$course) {
            return redirect()->to('/admin/courses')->with('error', 'Course not found');
        }
        
        $data = [
            'title' => 'Edit Course',
            'course' => $course,
            'user' => $this->userData
        ];
        
        return view('admin/courses/edit', $data);
    }
    
    /**
     * Handle course update
     */
    public function update($id)
    {
        if (!$this->isLoggedIn() || !$this->hasRole('admin')) {
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access');
        }
        
        $course = $this->courseModel->find($id);
        if (!$course) {
            return redirect()->to('/admin/courses')->with('error', 'Course not found');
        }
        
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'description' => 'required|min_length[10]',
            'teacher_id' => 'required|numeric',
            'status' => 'required|in_list[active,inactive]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'id' => $id,
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'teacher_id' => $this->request->getPost('teacher_id'),
            'status' => $this->request->getPost('status')
        ];
        
        if ($this->courseModel->save($data)) {
            return redirect()->to('/admin/courses')->with('success', 'Course updated successfully');
        }
        
        return redirect()->back()->withInput()->with('error', 'Failed to update course');
    }
    
    /**
     * Delete a course
     */
    public function delete($id)
    {
        if (!$this->isLoggedIn() || !$this->hasRole('admin')) {
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access');
        }
        
        $course = $this->courseModel->find($id);
        if (!$course) {
            return redirect()->to('/admin/courses')->with('error', 'Course not found');
        }
        
        if ($this->courseModel->delete($id)) {
            return redirect()->to('/admin/courses')->with('success', 'Course deleted successfully');
        }
        
        return redirect()->back()->with('error', 'Failed to delete course');
    }
    
    /**
     * Handle course enrollment
     */
    public function enroll()
    {
        // Require login
        if (!$this->isLoggedIn()) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
        }

        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setStatusCode(405)->setJSON([
                'status' => 'error',
                'message' => 'Method not allowed'
            ]);
        }

        // CSRF is expected to be enabled globally; CI will validate token automatically if enabled
        $courseId = (int) $this->request->getPost('course_id');
        if ($courseId <= 0) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'message' => 'Invalid course_id'
            ]);
        }

        $db = \Config\Database::connect();

        // Validate course exists
        $course = $db->table('courses')->where('id', $courseId)->get()->getRowArray();
        if (!$course) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Course not found'
            ]);
        }

        $userId = (int) $this->userData['id'];
        $enrollments = new EnrollmentModel();

        if ($enrollments->isAlreadyEnrolled($userId, $courseId)) {
            return $this->response->setJSON([
                'status' => 'exists',
                'message' => 'Already enrolled'
            ]);
        }

        $ok = $enrollments->enrollUser([
            'user_id' => $userId,
            'course_id' => $courseId,
            'enrollment_date' => date('Y-m-d H:i:s'),
        ]);

        if (!$ok) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => 'Failed to enroll'
            ]);
        }

        // Create a notification for the enrolled student
        try {
            $notificationModel = new \App\Models\NotificationModel();
            $notificationModel->insert([
                'user_id'    => $userId,
                'message'    => 'You have been enrolled in ' . ($course['title'] ?? 'a course'),
                'is_read'    => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Failed to create enrollment notification: ' . $e->getMessage());
        }

        // Return the enrolled course to update UI
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Enrolled successfully',
            'course' => [
                'id' => $course['id'],
                'title' => $course['title'] ?? 'Course',
                'description' => $course['description'] ?? '',
            ]
        ]);
    }
}
