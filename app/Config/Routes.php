<?php

namespace Config;

use CodeIgniter\Routing\RouteCollection;
use CodeIgniter\Routing\Router;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);
$routes->get('/', 'Home::index');
$routes->get('/about', 'Home::about');
$routes->get('/contact', 'Home::contact');


// ✅ Custom route
$routes->get('/', 'Home::index');
