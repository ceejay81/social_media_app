<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::loginPost');
$routes->get('register', 'Register::index');
$routes->post('register/process', 'Register::process');
$routes->get('dashboard', 'Dashboard::index');  // Add this line for the dashboard route
$routes->get('profile', 'Dashboard::profile');
$routes->post('profile/update', 'Dashboard::updateProfile');
$routes->get('logout', 'Dashboard::logout');


