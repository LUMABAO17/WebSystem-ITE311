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

// ✅ Custom route
$routes->get('/', 'Home::index');
