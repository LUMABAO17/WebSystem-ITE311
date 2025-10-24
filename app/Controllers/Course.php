<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EnrollmentModel;

class Course extends BaseController
{
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
