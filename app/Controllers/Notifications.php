<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Notifications extends BaseController
{
    public function index()
    {
        if (!session()->has('userID')) {
            return redirect()->to('/login');
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
}
