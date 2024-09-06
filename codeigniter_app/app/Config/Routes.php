<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('register', 'AuthController::register', ['as' => 'register']);
$routes->post('register', 'AuthController::attemptRegister');
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->match(['get', 'post'], 'reset-password', 'AuthController::resetPassword');
$routes->match(['get', 'post'], 'forgot', 'AuthController::forgotPassword');
