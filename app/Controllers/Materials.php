<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MaterialModel;
use App\Models\EnrollmentModel;
use CodeIgniter\Files\File;

class Materials extends BaseController
{
    protected $uploadPath = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'materials' . DIRECTORY_SEPARATOR;
    protected $allowedTypes = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'gif', 'txt', 'zip'];
    protected $maxSize = 102400; // 100MB (in KB for CI validation)

    public function __construct()
    {
        // Create upload directory if it doesn't exist
        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0755, true);
        }
    }

    /**
     * Handle material upload form display and file upload
     * 
     * @param int $course_id Course ID
     * @return mixed
     */
    public function upload($course_id = null)
    {
        // Debug: Log start of upload process
        log_message('debug', '=== Starting file upload process ===');
        log_message('debug', 'Upload path: ' . $this->uploadPath);
        log_message('debug', 'Allowed file types: ' . implode(', ', $this->allowedTypes));
        log_message('debug', 'Max file size: ' . $this->maxSize . ' KB');

        // Check if user is logged in using BaseController helper
        if (!$this->isLoggedIn()) {
            log_message('error', 'Upload failed: User not logged in');
            return redirect()->to('/login')->with('error', 'Please login to upload materials.');
        }

        // User data is initialized in BaseController::initController
        log_message('debug', 'User data: ' . json_encode($this->userData));

        // Load necessary models
        $materialModel = new MaterialModel();
        $courseModel = new \App\Models\CourseModel();

        // Get course details
        $course = $courseModel->find($course_id);
        if (!$course) {
            log_message('error', 'Upload failed: Course not found with ID ' . $course_id);
            return redirect()->back()->with('error', 'Course not found.');
        }

        // Check if user has permission to upload materials
        if (!in_array($this->userData['role'], ['admin', 'teacher'])) {
            log_message('error', 'Upload failed: User does not have permission to upload');
            return redirect()->back()->with('error', 'You do not have permission to upload materials.');
        }

        // Check if the user is the course teacher or admin
        if ($this->userData['role'] === 'teacher' && $course['teacher_id'] != $this->userData['id']) {
            log_message('error', 'Upload failed: User is not authorized to upload for this course');
            return redirect()->back()->with('error', 'You are not authorized to upload materials for this course.');
        }

        // If it's a GET request, show the upload form
        if ($this->request->getMethod() === 'GET') {
            // Get existing materials for this course
            $materials = $materialModel->where('course_id', $course_id)
                                     ->orderBy('created_at', 'DESC')
                                     ->findAll();
            
            $data = [
                'title' => 'Upload Material - ' . ($course['title'] ?? 'Course'),
                'course_id' => $course_id,
                'course' => $course,
                'user' => $this->userData,
                'materials' => $materials
            ];
            
            log_message('debug', 'Rendering upload form view for course ID: ' . $course_id);
            log_message('debug', 'Number of existing materials: ' . count($materials));
            
            // Debug: Check if the view file exists
            $viewPath = APPPATH . 'Views/admin/materials/upload.php';
            log_message('debug', 'View path: ' . $viewPath);
            log_message('debug', 'View exists: ' . (file_exists($viewPath) ? 'Yes' : 'No'));
            
            return view('admin/materials/upload', $data);
        }
        
        // Handle form submission for POST requests
        if ($this->request->getMethod() === 'POST') {
            log_message('debug', 'Processing POST request');
            log_message('debug', 'POST data: ' . json_encode($this->request->getPost()));
            log_message('debug', 'FILES data: ' . json_encode($this->request->getFiles()));

            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'material' => [
                    'uploaded[material]',
                    'mime_in[material,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,image/jpeg,image/png,image/gif,text/plain,application/zip]',
                    'ext_in[material,' . implode(',', $this->allowedTypes) . ']',
                    'max_size[material,' . $this->maxSize . ']'
                ]
            ];

            log_message('debug', 'Validation rules: ' . json_encode($rules));

            if ($this->validate($rules)) {
                log_message('debug', 'Form validation passed');
                $file = $this->request->getFile('material');
                
                if (!$file->isValid()) {
                    log_message('error', 'File upload error: ' . $file->getErrorString() . ' [' . $file->getError() . ']');
                    return redirect()->back()->with('error', 'File upload failed: ' . $file->getErrorString());
                }

                log_message('debug', 'File info: ' . json_encode([
                    'name' => $file->getName(),
                    'originalName' => $file->getClientName(),
                    'mimeType' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'extension' => $file->guessExtension(),
                    'isValid' => $file->isValid(),
                    'hasMoved' => $file->hasMoved(),
                    'error' => $file->getErrorString()
                ]));

                if ($file->isValid() && !$file->hasMoved()) {
                    // Generate a unique filename
                    $newName = $file->getRandomName();
                    log_message('debug', 'Generated new filename: ' . $newName);

                    // Ensure upload directory exists and is writable
                    if (!is_dir($this->uploadPath)) {
                        log_message('debug', 'Creating upload directory: ' . $this->uploadPath);
                    }
                    
                    log_message('debug', 'Upload directory permissions: ' . substr(sprintf('%o', fileperms($this->uploadPath)), -4));
                    log_message('debug', 'Is upload directory writable: ' . (is_writable($this->uploadPath) ? 'yes' : 'no'));

                    // Move the file to the uploads directory
                    if ($file->move($this->uploadPath, $newName)) {
                        log_message('debug', 'File moved successfully to: ' . $this->uploadPath . $newName);
                        
                        // Prepare data for database
                        $data = [
                            'course_id' => $course_id,
                            'title' => $this->request->getPost('title'),
                            'description' => $this->request->getPost('description') ?? '',
                            'file_name' => $file->getClientName(),
                            'stored_name' => $newName,
                            'file_type' => $file->getClientMimeType(),
                            'file_size' => $file->getSize(),
                            'uploaded_by' => $this->userData['id'],
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        log_message('debug', 'Attempting to save to database: ' . json_encode($data));
                        
                        // Save to database
                        if ($materialModel->insert($data)) {
                            $materialId = $materialModel->getInsertID();
                            log_message('debug', 'File uploaded and saved to database with ID: ' . $materialId);
                            
                            // Redirect to course view after successful upload
                            $redirectUrl = $this->userData['role'] === 'admin' 
                                ? 'admin/courses/' . $course_id 
                                : 'teacher/courses/' . $course_id;
                                
                            return redirect()->to(site_url($redirectUrl))
                                ->with('success', 'File uploaded successfully!');
                        } else {
                            $error = $materialModel->errors() ? implode(' ', $materialModel->errors()) : 'Unknown database error';
                            log_message('error', 'Database save failed: ' . $error);
                            
                            $db = \Config\Database::connect();
                            $lastQuery = method_exists($db, 'getLastQuery') ? (string)$db->getLastQuery() : 'N/A';
                            log_message('error', 'Last DB query: ' . $lastQuery);
                            
                            // If database save fails, delete the uploaded file
                            if (file_exists($this->uploadPath . $newName)) {
                                unlink($this->uploadPath . $newName);
                            }
                            return redirect()->back()->with('error', 'Failed to save file information to database. ' . $error)->withInput();
                        }
                    } else {
                        $error = 'Failed to move uploaded file. ';
                        $error .= 'Error: ' . $file->getErrorString() . '. ';
                        $error .= 'Upload path: ' . $this->uploadPath . '. ';
                        $error .= 'Writable: ' . (is_writable($this->uploadPath) ? 'yes' : 'no');
                        log_message('error', $error);
                        return redirect()->back()
                            ->withInput()
                            ->with('error', 'Failed to upload file. The server could not save the file. Please try again.');
                    }
                } else {
                    $error = 'File upload validation failed. ';
                    $error .= 'Error: ' . $file->getErrorString() . '. ';
                    $error .= 'File: ' . $file->getName() . '. ';
                    $error .= 'Size: ' . $file->getSize() . ' bytes. ';
                    $error .= 'Type: ' . $file->getMimeType();
                    log_message('error', $error);
                    
                    return redirect()->back()
                        ->withInput()
                        ->with('error', $file->getErrorString() ?: 'The file upload failed. Please check the file and try again.');
                }
            } else {
                $validationErrors = $this->validator->getErrors();
                log_message('error', 'Form validation failed: ' . json_encode($validationErrors));
                log_message('debug', 'Validation rules that failed: ' . json_encode($this->validator->getErrors()));
                
                // Log detailed file upload errors if any
                if (isset($_FILES['material'])) {
                    log_message('debug', 'File upload error code: ' . $_FILES['material']['error']);
                    log_message('debug', 'File upload details: ' . json_encode($_FILES['material']));
                }
                
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $validationErrors);
            }
        }

        // Get existing materials for this course
        $materials = $materialModel->where('course_id', $course_id)->findAll();

        // Display upload form
        $data = [
            'title' => 'Upload Material - ' . $course['title'],
            'course' => $course,
            'course_id' => $course_id,
            'user' => $this->userData,
            'materials' => $materials,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/materials/upload', $data);
    }


    /**
     * Delete a material
     * 
     * @param int $material_id Material ID
     * @return mixed
     */
    public function delete($material_id)
    {
        // Require authentication
        if (!$this->isLoggedIn()) {
            return redirect()->to(site_url('login'))->with('error', 'Please login to continue');
        }

        // Require admin or teacher role
        if (!$this->hasRole(['admin', 'teacher'])) {
            return redirect()->to(site_url('admin/courses'))->with('error', 'You do not have permission to delete materials');
        }

        $materialModel = new MaterialModel();
        $material = $materialModel->getMaterialById($material_id);

        if (!$material) {
            return redirect()->to(site_url('admin/courses'))->with('error', 'Material not found');
        }

        // If user is teacher, verify they own the course
        $db = \Config\Database::connect();
        $course = $db->table('courses')->where('id', $material['course_id'])->get()->getRowArray();
        if ($this->userData['role'] === 'teacher' && $course['teacher_id'] != $this->userData['id']) {
            return redirect()->to(site_url('admin/courses'))->with('error', 'You do not have permission to delete this material');
        }

        // Delete file from server
        $filePath = $this->uploadPath . $material['stored_name'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete from database
        if ($materialModel->deleteMaterial($material_id)) {
            return redirect()->back()->with('success', 'Material deleted successfully');
        }

        return redirect()->back()->with('error', 'Failed to delete material');
    }

    /**
     * Download a material file
     * 
     * @param int $material_id Material ID
     * @return mixed
     */
    public function download($material_id)
    {
        // Require authentication
        if (!$this->isLoggedIn()) {
            return redirect()->to(site_url('login'))->with('error', 'Please login to continue');
        }

        $materialModel = new MaterialModel();
        $material = $materialModel->getMaterialById($material_id);

        if (!$material) {
            return redirect()->to(site_url('admin/courses'))->with('error', 'Material not found');
        }

        // Verify user is enrolled in the course (for students)
        if ($this->userData['role'] === 'student') {
            $enrollmentModel = new EnrollmentModel();
            if (!$enrollmentModel->isAlreadyEnrolled($this->userData['id'], $material['course_id'])) {
                return redirect()->to(site_url('admin/courses'))->with('error', 'You must be enrolled in this course to download materials');
            }
        }

        // Verify file exists
        $filePath = $this->uploadPath . $material['stored_name'];
        if (!file_exists($filePath)) {
            return redirect()->to(site_url('admin/courses'))->with('error', 'File not found on server');
        }

        // Serve the file for download
        return $this->response->download($filePath, null);
    }
}
