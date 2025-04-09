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
$routes->get('stockin/validateBarcode', 'StockInController::validateBarcode');
$routes->post('stockin/store', 'StockInController::store');
//
$routes->get('stockout', to: 'StockOutController::index');
$routes->get('stockout/validateBarcode', 'StockOutController::validateBarcode');
$routes->post('stockout/store', 'StockOutController::store');
