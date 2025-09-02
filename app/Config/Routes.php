<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
<<<<<<< HEAD
$routes->get('about', 'Home::about');
$routes->get('contact', 'Home::contact');

// Authentication routes
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::register');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
$routes->get('/dashboard', 'Auth::dashboard');
=======
$routes->get('index.php', 'Home::index');
$routes->get('about.php', 'Home::about');
$routes->get('contact.php', 'Home::contact');
>>>>>>> 93a09e5307e0f02cc1dbf798a06b1a8fc5edd195
