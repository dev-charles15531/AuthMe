<?php


/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->post('auth-secure/login', 'MainController::login', ['namespace' => 'Modules\AuthMe\Controllers']);
$routes->post('auth-secure/login/(:segment)', 'MainController::login/$1', ['namespace' => 'Modules\AuthMe\Controllers']);
$routes->get('auth-secure/logout', 'MainController::logout', ['namespace' => 'Modules\AuthMe\Controllers']);
