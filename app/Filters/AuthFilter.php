<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // Check if user is not logged in
        if (!$session->get('isLoggedIn')) {
            // Store the intended URL for redirecting after login
            $session->set('redirect', current_url());
            
            // Set error message
            $session->setFlashdata('error', 'Please login to access this page.');
            
            // Redirect to login page
            return redirect()->to('/login');
        }
        
        // User is logged in, continue with the request
        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here after the controller runs
        return $response;
    }
}
