<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

$routes = Services::routes();

$routes->get('/', 'Home::index');

// Routes for ToysController
$routes->options('toys', 'ToysController::options');
$routes->options('toys/(:num)', 'ToysController::options');
$routes->options('toys/filter', 'ToyDetailController::options');
$routes->options('toys/detail/(:num)', 'ToyDetailController::options');
$routes->options('toys/detail/create', 'ToyDetailController::options');
$routes->options('toys/detail/delete/(:num)', 'ToyDetailController::options');
$routes->get('toys', 'ToysController::index');
$routes->get('toys/(:num)', 'ToysController::get/$1');
$routes->get('toys/detail/(:num)', 'ToyDetailController::getToyById/$1');
$routes->post('toys', 'ToysController::post');
$routes->patch('toys/update/(:num)', 'ToyDetailController::patch/$1');
$routes->patch('toys/(:num)', 'ToysController::patch/$1');
$routes->post('toys/filter', 'ToyDetailController::filter');
$routes->post('toys/detail/create', 'ToyDetailController::createToy');
$routes->delete('toys/(:num)', 'ToysController::delete/$1');
$routes->delete('toys/detail/delete/(:num)', 'ToyDetailController::deleteToy/$1');


// Routes for DollsController
$routes->options('dolls', 'DollsController::options');
$routes->options('dolls/(:num)', 'DollsController::options');
$routes->get('dolls', 'DollsController::index');
$routes->get('dolls/(:num)', 'DollsController::get/$1');
$routes->post('dolls', 'DollsController::post');
$routes->patch('dolls/(:num)', 'DollsController::patch/$1');
$routes->delete('dolls/(:num)', 'DollsController::delete/$1');

// Routes for ElectronicToysController
$routes->options('electronictoys', 'ElectronicToysController::options');
$routes->options('electronictoys/(:num)', 'ElectronicToysController::options');
$routes->get('electronictoys', 'ElectronicToysController::index');
$routes->get('electronictoys/(:num)', 'ElectronicToysController::get/$1');
$routes->post('electronictoys', 'ElectronicToysController::post');
$routes->patch('electronictoys/(:num)', 'ElectronicToysController::patch/$1');
$routes->delete('electronictoys/(:num)', 'ElectronicToysController::delete/$1');

// Routes for PlasticToysController
$routes->options('plastictoys', 'PlasticToysController::options');
$routes->options('plastictoys/(:num)', 'PlasticToysController::options');
$routes->get('plastictoys', 'PlasticToysController::index');
$routes->get('plastictoys/(:num)', 'PlasticToysController::get/$1');
$routes->post('plastictoys', 'PlasticToysController::post');
$routes->patch('plastictoys/(:num)', 'PlasticToysController::patch/$1');
$routes->delete('plastictoys/(:num)', 'PlasticToysController::delete/$1');