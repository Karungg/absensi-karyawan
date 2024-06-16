<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['filter' => 'role:user']);

$routes->group('', ['filter' => 'role:operator'], static function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'DashboardController::index');

    // Positions
    $routes->group('positions', static function ($routes) {
        $routes->get('', 'PositionController::index');
    });
});
