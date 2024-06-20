<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['filter' => 'role:user']);

$routes->group('', ['filter' => 'role:admin'], static function ($routes) {
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

    // Employees
    $routes->group('employees', static function ($routes) {
        $routes->get('', 'EmployeeController::index');
        $routes->get('create', 'EmployeeController::create');
        $routes->post('create', 'EmployeeController::store');
        $routes->get('(:num)', 'EmployeeController::show/$1');
        $routes->get('(:segment)/edit', 'EmployeeController::edit/$1');
        $routes->put('(:segment)/edit', 'EmployeeController::update');
        $routes->delete('delete/(:segment)', 'EmployeeController::destroy/$1');
        $routes->get('export-pdf', 'EmployeeController::exportPdf');
        $routes->get('export-excel', 'EmployeeController::exportExcel');
    });
});
