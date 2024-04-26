<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'UserController::index');
$routes->post('/connexion', 'UserController::connexion');
$routes->get('/inscription', 'UserController::inscriptionIndex');
$routes->post('/inscription', 'UserController::inscription');
