<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/products', 'Products::index');
$routes->get('/products/create', 'Products::create');
$routes->post('/products/store', 'Products::store');
$routes->post('/products/update/(:num)', 'Products::update/$1');
$routes->get('/products/delete/(:num)', 'Products::delete/$1');
//
$routes->get('stockin', 'StockInController::index');
$routes->get('stockin/data', 'StockInController::data');
$routes->get('stockin/validateBarcode', 'StockInController::validateBarcode');
$routes->post('stockin/store', 'StockInController::store');
$routes->get('stockin/print/', 'StockInController::print');
//
$routes->get('stockout', to: 'StockOutController::index');
$routes->get('stockout/validateBarcode', 'StockOutController::validateBarcode');
$routes->post('stockout/store', 'StockOutController::store');
$routes->get('stockout/print/', 'StockoutController::print');
$routes->get( 'stockout/data', 'StockoutController::data');

$routes->get('/login', 'AuthController::login');
$routes->post('/auth/processLogin', 'AuthController::processLogin');
$routes->get('/logout', 'AuthController::logout');

$routes->get('/users', 'UserController::index');
$routes->get('/user/create', 'UserController::create');
$routes->post('/user/store', 'UserController::store');
$routes->get('/users/edit/(:num)', 'UserController::edit/$1');
$routes->post('/users/update/(:num)', 'UserController::update/$1');
$routes->get('/users/delete/(:num)', 'UserController::delete/$1');



