<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['filter' => 'role:user']);
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'role:admin']);
