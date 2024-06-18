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
        $routes->get('create', 'PositionController::create');
        $routes->post('create', 'PositionController::store');
        $routes->get('(:segment)/edit', 'PositionController::edit/$1');
        $routes->put('(:segment)/edit', 'PositionController::update');
        $routes->delete('delete/(:segment)', 'PositionController::destroy/$1');
        $routes->get('export-pdf', 'PositionController::exportPdf');
        $routes->get('export-excel', 'PositionController::exportExcel');
    });
});
