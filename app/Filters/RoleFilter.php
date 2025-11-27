<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // Check if user is logged in based on the actual session structure from Auth controller
        if (!$session->has('isLoggedIn') || $session->get('isLoggedIn') !== true) {
            // Store the intended URL before redirecting to login
            $session->set('redirect', current_url());
            return redirect()->to('/login')->with('error', 'Please login to access this page.');
        }

        // If no roles specified, just check if user is logged in
        if (empty($arguments)) {
            return;
        }

        // Get user role directly from session (not from user array)
        $userRole = $session->get('role');

        // Check if user has any of the required roles
        if (!in_array($userRole, $arguments)) {
            // Log unauthorized access attempt
            log_message('warning', 'Unauthorized access attempt by user ID: ' . session()->get('userID') . 
                        ' to route: ' . $request->uri->getPath());
            
            // Show access denied
            throw new \CodeIgniter\Exceptions\PageNotFoundException('You do not have permission to access this page.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after the request
    }
}
