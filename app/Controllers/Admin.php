<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Admin extends BaseController
{
    public function notifications()
    {
        if (!session()->has('userID')) {
            return redirect()->to('/login');
        }

        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Access denied. Admin only.');
        }

        $data = [
            'title' => 'Notifications',
            'user' => [
                'name' => session()->get('name'),
                'role' => session()->get('role')
            ]
        ];

        return view('admin/notifications', $data);
    }

    public function users()
    {
        if (!session()->has('userID')) {
            return redirect()->to('/login');
        }

        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Access denied. Admin only.');
        }

        $db = \Config\Database::connect();
        $users = $db->table('users')->orderBy('created_at', 'DESC')->get()->getResultArray();

        $data = [
            'title' => 'Manage Users',
            'users' => $users,
            'currentUserId' => session()->get('userID'),
            'roles' => ['admin', 'teacher', 'student'],
        ];

        return view('admin/users', $data);
    }

    public function updateUserRole($id)
    {
        if (!session()->has('userID')) {
            return redirect()->to('/login');
        }

        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Access denied. Admin only.');
        }

        $method = $this->request->getMethod();
        if (strtolower($method) !== 'post') {
            log_message('debug', 'Admin::updateUserRole called with non-POST method: ' . $method);
            return redirect()->to('/admin/users');
        }

        $role = $this->request->getPost('role');
        $allowedRoles = ['admin', 'teacher', 'student'];

        if (!in_array($role, $allowedRoles, true)) {
            session()->setFlashdata('error', 'Invalid role selected.');
            return redirect()->back();
        }

        $currentUserId = (int) session()->get('userID');
        $targetUserId = (int) $id;

        if ($currentUserId === $targetUserId && $role !== 'admin') {
            session()->setFlashdata('error', 'You cannot change your own role.');
            return redirect()->back();
        }

        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $user = $builder->where('id', $targetUserId)->get()->getRowArray();

        if (!$user) {
            session()->setFlashdata('error', 'User not found.');
            return redirect()->back();
        }

        $builder->where('id', $targetUserId)->update([
            'role' => $role,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        session()->setFlashdata('success', 'User role updated successfully.');
        return redirect()->to('/admin/users');
    }

    public function createUser()
    {
        if (!session()->has('userID')) {
            return redirect()->to('/login');
        }

        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Access denied. Admin only.');
        }

        $data = [
            'title' => 'Create User',
            'roles' => ['admin', 'teacher', 'student'],
            'user' => [
                'id' => null,
                'name' => '',
                'email' => '',
                'role' => 'student',
                'is_active' => 1,
            ],
            'mode' => 'create',
        ];

        return view('admin/user_form', $data);
    }

    public function storeUser()
    {
        if (!session()->has('userID')) {
            return redirect()->to('/login');
        }

        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Access denied. Admin only.');
        }

        $method = $this->request->getMethod();
        if (strtolower($method) !== 'post') {
            log_message('debug', 'Admin::storeUser called with non-POST method: ' . $method);
            return redirect()->to('/admin/users');
        }

        log_message('debug', 'Admin::storeUser invoked');

        $validationRules = [
            'name' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email|max_length[100]|is_unique[users.email]',
            'password' => 'required|min_length[8]|max_length[255]',
            'role' => 'required|in_list[admin,teacher,student]',
            'is_active' => 'permit_empty|in_list[0,1]',
        ];

        if (!$this->validate($validationRules)) {
            $errors = $this->validator->getErrors();
            log_message('debug', 'Admin::storeUser validation failed', $errors);
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $db = \Config\Database::connect();

        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $role = $this->request->getPost('role');
        $isActive = $this->request->getPost('is_active') === '1' ? 1 : 0;

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $userData = [
            'name' => esc($name),
            'email' => filter_var($email, FILTER_SANITIZE_EMAIL),
            'password' => $hashedPassword,
            'role' => $role,
            'is_active' => $isActive,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $builder = $db->table('users');
        $result = $builder->insert($userData);

        if (!$result) {
            $dbError = $db->error();
            log_message('error', 'Admin::storeUser DB insert failed', $dbError);
            $message = !empty($dbError['message']) ? $dbError['message'] : 'Unknown database error while creating user.';
            session()->setFlashdata('error', 'Failed to create user: ' . $message);
            return redirect()->back()->withInput();
        }

        log_message('debug', 'Admin::storeUser created user successfully for email: ' . $email);

        session()->setFlashdata('success', 'User created successfully.');
        return redirect()->to('/admin/users');
    }

    public function editUser($id)
    {
        if (!session()->has('userID')) {
            return redirect()->to('/login');
        }

        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Access denied. Admin only.');
        }

        $db = \Config\Database::connect();
        $user = $db->table('users')->where('id', (int) $id)->get()->getRowArray();

        if (!$user) {
            session()->setFlashdata('error', 'User not found.');
            return redirect()->to('/admin/users');
        }

        $data = [
            'title' => 'Edit User',
            'roles' => ['admin', 'teacher', 'student'],
            'user' => $user,
            'mode' => 'edit',
        ];

        return view('admin/user_form', $data);
    }

    public function updateUser($id)
    {
        if (!session()->has('userID')) {
            return redirect()->to('/login');
        }

        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Access denied. Admin only.');
        }

        $method = $this->request->getMethod();
        if (strtolower($method) !== 'post') {
            log_message('debug', 'Admin::updateUser called with non-POST method: ' . $method);
            return redirect()->to('/admin/users');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $user = $builder->where('id', (int) $id)->get()->getRowArray();

        if (!$user) {
            session()->setFlashdata('error', 'User not found.');
            return redirect()->to('/admin/users');
        }

        $validationRules = [
            'name' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email|max_length[100]',
            'role' => 'required|in_list[admin,teacher,student]',
            'is_active' => 'permit_empty|in_list[0,1]',
            'password' => 'permit_empty|min_length[8]|max_length[255]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $duplicate = $db->table('users')
            ->where('email', $email)
            ->where('id !=', (int) $id)
            ->countAllResults();

        if ($duplicate > 0) {
            return redirect()->back()->withInput()->with('errors', ['email' => 'Email is already in use by another user.']);
        }

        $currentUserId = (int) session()->get('userID');
        $targetUserId = (int) $id;
        $newRole = $this->request->getPost('role');

        if ($currentUserId === $targetUserId && $newRole !== 'admin') {
            session()->setFlashdata('error', 'You cannot change your own role.');
            return redirect()->back();
        }

        $updateData = [
            'name' => esc($this->request->getPost('name')),
            'email' => filter_var($email, FILTER_SANITIZE_EMAIL),
            'role' => $newRole,
            'is_active' => $this->request->getPost('is_active') === '1' ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $updateData['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $builder->where('id', $targetUserId)->update($updateData);

        session()->setFlashdata('success', 'User updated successfully.');
        return redirect()->to('/admin/users');
    }

    public function deleteUser($id)
    {
        if (!session()->has('userID')) {
            return redirect()->to('/login');
        }

        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Access denied. Admin only.');
        }

        $currentUserId = (int) session()->get('userID');
        $targetUserId = (int) $id;

        if ($currentUserId === $targetUserId) {
            session()->setFlashdata('error', 'You cannot delete your own account.');
            return redirect()->to('/admin/users');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $user = $builder->where('id', $targetUserId)->get()->getRowArray();

        if (!$user) {
            session()->setFlashdata('error', 'User not found.');
            return redirect()->to('/admin/users');
        }

        $builder->where('id', $targetUserId)->delete();

        session()->setFlashdata('success', 'User deleted successfully.');
        return redirect()->to('/admin/users');
    }
}
