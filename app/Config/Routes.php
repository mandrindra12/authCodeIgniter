<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
# get
$routes->get('/', 'UserController::index');
$routes->get('/inscription', 'UserController::inscriptionIndex');
$routes->get('/connexion', 'UserController::index');
$routes->get('/accueil', 'UserController::accueil');
$routes->get('/deconnexion', 'UserController::deconnexion');
$routes->get('/qrconnect', 'UserController::qrConnexion');
# post 
$routes->post('/connexion', 'UserController::connexion');
$routes->post('/inscription', 'UserController::inscription');
$routes->post('/', 'UserController::connexion');
