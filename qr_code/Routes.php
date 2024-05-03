<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
# get
$routes->get('/', 'UserController::index');
$routes->get('/inscription', 'UserController::inscriptisonIndex');
$routes->get('/connexion', 'UserController::index');
$routes->get('/connect', 'UserController::connexion');
$routes->get('/accueil', 'UserController::accueil');
# post 
$routes->post('/connexion', 'UserController::connexion');
$routes->post('/inscription', 'UserController::inscription');
$routes->post('/', 'UserController::connexion');
