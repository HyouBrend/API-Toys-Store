<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

$routes = Services::routes();

$routes->get('/', 'Home::index');

// Routes for Toys Controller
$routes->get('toys', 'ToysController::index'); 
$routes->get('toys/(:num)', 'ToysController::show/$1'); 
$routes->post('toys', 'ToysController::create');
$routes->patch('toys/(:num)', 'ToysController::patch/$1'); 
$routes->delete('toys/(:num)', 'ToysController::delete/$1'); 

//Ruotes for Dolls Controller
$routes->get('dolls', 'DollsController::index');
$routes->get('dolls/(:num)', 'DollsController::get/$1');
$routes->post('dolls', 'DollsController::post');
$routes->patch('dolls/(:num)', 'DollsController::patch/$1');
$routes->delete('dolls/(:num)', 'DollsController::delete/$1');

// Routing untuk ElectronicToysController
$routes->get('electronictoys', 'ElectronicToysController::index');
$routes->get('electronictoys/(:num)', 'ElectronicToysController::get/$1');
$routes->post('electronictoys', 'ElectronicToysController::post');
$routes->patch('electronictoys/(:num)', 'ElectronicToysController::patch/$1');
$routes->delete('electronictoys/(:num)', 'ElectronicToysController::delete/$1');

// Routing untuk PlasticToysController
$routes->get('plastictoys', 'PlasticToysController::index');
$routes->get('plastictoys/(:num)', 'PlasticToysController::get/$1');
$routes->post('plastictoys', 'PlasticToysController::post');
$routes->patch('plastictoys/(:num)', 'PlasticToysController::patch/$1');
$routes->delete('plastictoys/(:num)', 'PlasticToysController::delete/$1');