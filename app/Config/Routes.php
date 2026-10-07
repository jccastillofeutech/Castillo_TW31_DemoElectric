<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/health', 'Health::index');
$routes->get('/about', 'About::index');
$routes->get('/services', 'Services::index');

$routes->match(['get', 'post'], '/contact', 'Contact::index');

$routes->get('/register', 'Register::index');
$routes->post('/register', 'Register::create');
$routes->get('/dashboard', 'Dashboard::index');

// Additive unified login and customer-account portal.
$routes->match(['get', 'post'], '/login', 'Auth::login');
$routes->post('/logout', 'Auth::logout');
$routes->get('/account-dashboard', 'Dashboard::index');
$routes->get('/accounts/create', 'Dashboard::create');
$routes->post('/accounts/store', 'Dashboard::store');
$routes->get('/account/(:num)', 'Dashboard::viewAccount/$1');
$routes->get('/account/(:num)/edit', 'Dashboard::edit/$1');
$routes->post('/account/(:num)/update', 'Dashboard::update/$1');
$routes->post('/account/(:num)/delete', 'Dashboard::delete/$1');
$routes->post('/accounts/bulk-delete', 'Dashboard::bulkDelete');

