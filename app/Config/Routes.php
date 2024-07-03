<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

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

    // holidays
    $routes->group('holidays', static function ($routes) {
        $routes->get('', 'HolidayController::index');
        $routes->get('create', 'HolidayController::create');
        $routes->post('create', 'HolidayController::store');
        $routes->get('(:segment)/edit', 'HolidayController::edit/$1');
        $routes->put('(:segment)/edit', 'HolidayController::update');
        $routes->delete('delete/(:segment)', 'HolidayController::destroy/$1');
        $routes->get('export-pdf', 'HolidayController::exportPdf');
        $routes->get('export-excel', 'HolidayController::exportExcel');
    });

    // attendances
    $routes->group('attendances', static function ($routes) {
        $routes->get('', 'AttendanceController::index');
        $routes->get('create', 'AttendanceController::create');
        $routes->post('create', 'AttendanceController::store');
        $routes->get('(:segment)/edit', 'AttendanceController::edit/$1');
        $routes->put('(:segment)/edit', 'AttendanceController::update');
        $routes->delete('delete/(:segment)', 'AttendanceController::destroy/$1');
        $routes->get('export-pdf', 'AttendanceController::exportPdf');
        $routes->get('export-excel', 'AttendanceController::exportExcel');
    });

    // presences
    $routes->group('presences', static function ($routes) {
        $routes->get('', 'PresenceController::index');
        $routes->get('create', 'PresenceController::create');
        $routes->post('create', 'PresenceController::store');
        $routes->get('(:segment)/edit', 'PresenceController::edit/$1');
        $routes->put('(:segment)/edit', 'PresenceController::update');
        $routes->delete('delete/(:segment)', 'PresenceController::destroy/$1');
        $routes->get('export-pdf', 'PresenceController::exportPdf');
        $routes->get('export-excel', 'PresenceController::exportExcel');
    });
});
