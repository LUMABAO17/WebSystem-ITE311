<?php

use CodeIgniter\Router\RouteCollection;
use App\Filters\RoleFilter;

/**
 * @var RouteCollection $routes
 */

// Home routes
$routes->get('/', 'Home::index');
$routes->get('about', 'Home::about');
$routes->get('contact', 'Home::contact');

// Authentication routes
$routes->group('', ['namespace' => 'App\\Controllers'], function($routes) {
    // Public routes
    $routes->get('/register', 'Auth::register');
    $routes->post('/register', 'Auth::register');
    $routes->get('/login', 'Auth::login');
    $routes->post('/login', 'Auth::login');
    
    $routes->group('', ['filter' => 'auth'], function($routes) {
        $routes->get('/logout', 'Auth::logout');
        $routes->get('/dashboard', 'Auth::dashboard', ['as' => 'dashboard']);
        
        // Course Enrollment
        $routes->post('/course/enroll', 'Course::enroll');

        // Common materials routes
        $routes->get('materials/download/(:num)', 'Materials::download/$1');
        
        // Admin routes with role-based access control
        $routes->group('admin', ['filter' => 'role:admin'], function($routes) {
            // Course management
            $routes->get('courses', 'Course::index', ['as' => 'admin.courses']);
            $routes->get('courses/create', 'Course::create', ['as' => 'admin.courses.create']);
            $routes->post('courses/store', 'Course::store', ['as' => 'admin.courses.store']);
            $routes->get('courses/(:num)', 'Course::view/$1', ['as' => 'admin.courses.view']);
            $routes->get('courses/(:num)/edit', 'Course::edit/$1', ['as' => 'admin.courses.edit']);
            $routes->post('courses/(:num)/update', 'Course::update/$1', ['as' => 'admin.courses.update']);
            $routes->get('courses/(:num)/delete', 'Course::delete/$1', ['as' => 'admin.courses.delete']);
            
            // Course materials management
            $routes->get('courses/(:num)/upload', 'Materials::upload/$1', ['as' => 'admin.materials.upload']);
            $routes->post('courses/(:num)/upload', 'Materials::upload/$1');
            $routes->get('materials/delete/(:num)', 'Materials::delete/$1', ['as' => 'admin.materials.delete']);
            
            // Notifications
            $routes->get('notifications', 'Admin::notifications', ['as' => 'admin.notifications']);
        });
        
        // Teacher routes
        $routes->group('teacher', ['filter' => 'role:teacher'], function($routes) {
            $routes->get('dashboard', 'Teacher::dashboard', ['as' => 'teacher.dashboard']);
            $routes->get('courses', 'Teacher::courses', ['as' => 'teacher.courses']);
            $routes->get('students', 'Teacher::students', ['as' => 'teacher.students']);
            $routes->get('courses/(:num)', 'Course::view/$1', ['as' => 'teacher.courses.view']);
            $routes->get('courses/(:num)/upload', 'Materials::upload/$1', ['as' => 'teacher.materials.upload']);
            $routes->post('courses/(:num)/upload', 'Materials::upload/$1');
            $routes->get('materials/delete/(:num)', 'Materials::delete/$1', ['as' => 'teacher.materials.delete']);
        });
        
        // Student routes
        $routes->group('student', ['filter' => 'role:student'], function($routes) {
            $routes->get('dashboard', 'Student::dashboard');
            $routes->get('courses', 'Student::courses');
            $routes->get('courses/(:num)', 'Student::courseDetails/$1');
        });
    });
});
