<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class Auth extends BaseController
{
    public function register()
    {
        $db = \Config\Database::connect();
        
        if ($this->request->getMethod() === 'POST') {
            // Simple validation rules for now
            $rules = [
                'name' => 'required|min_length[3]|max_length[100]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]',
                'password_confirm' => 'matches[password]'
            ];

            if ($this->validate($rules)) {
                try {
                    // Get input
                    $name = $this->request->getPost('name');
                    $email = $this->request->getPost('email');
                    $password = $this->request->getPost('password');

                    // Hash password
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    // Prepare user data
                    $userData = [
                        'name' => $name,
                        'email' => $email,
                        'password' => $hashedPassword,
                        'role' => 'student',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    // Insert user
                    $db->table('users')->insert($userData);
                    
                    // Set success message
                    session()->flashdata('success', 'Registration successful! Please login.');
                    
                    // Redirect to login page
                    return redirect()->to('/login');

                } catch (\Exception $e) {
                    // Log error
                    log_message('error', 'Registration error: ' . $e->getMessage());
                    
                    // Set error message
                    session()->flashdata('error', 'An error occurred. Please try again.');
                }
            } else {
                // Validation failed, show errors
                $data['validation'] = $this->validator;
            }
        }

        // Load the registration view
        return view('auth/register');
    }

    public function login()
    {
        if ($this->request->getMethod() === 'POST') {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            
            $db = \Config\Database::connect();
            $user = $db->table('users')
                      ->where('email', $email)
                      ->get()
                      ->getRow();
            
            if ($user) {
                if (password_verify($password, $user->password)) {
                    // Set user session
                    $userData = [
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role,
                        'logged_in' => true
                    ];
                    
                    session()->set($userData);
                    
                    // Redirect to dashboard
                    return redirect()->to('/dashboard');
                }
            }
            
            // If we get here, login failed
            session()->flashdata('error', 'Invalid email or password');
        }
        
        return view('auth/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function dashboard()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        // Get user data from session
        $userData = [
            'user' => [
                'id' => session()->get('user_id'),
                'name' => session()->get('name'),
                'email' => session()->get('email'),
                'role' => session()->get('role')
            ]
        ];
        
        $role = strtolower(session()->get('role') ?? 'student');
        
        switch ($role) {
            case 'admin':
                return view('dashboard/admindashboard', $userData);
            case 'teacher':
                return view('dashboard/teacherdashboard', $userData);
            case 'student':
            default:
                return view('dashboard/studentdashboard', $userData);
        }
    }
}
