<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'ALL::index');

// User Routes
$routes->get('/user', 'User::index');
$routes->get('/user/create', 'User::create');
$routes->post('/user/store', 'User::store');
$routes->get('/user/edit/(:num)', 'User::edit/$1');
$routes->post('/user/update/(:num)', 'User::update/$1');
$routes->get('/user/delete/(:num)', 'User::delete/$1');

// Personal Admin Routes
$routes->get('/personal-admin', 'PersonalAdmin::index');
$routes->get('/personal-admin/create', 'PersonalAdmin::create');
$routes->post('/personal-admin/store', 'PersonalAdmin::store');
$routes->get('/personal-admin/edit/(:num)', 'PersonalAdmin::edit/$1');
$routes->post('/personal-admin/update/(:num)', 'PersonalAdmin::update/$1');
$routes->get('/personal-admin/delete/(:num)', 'PersonalAdmin::delete/$1');

// Purchase Requisition Routes
$routes->get('/purchase-requisition', 'PurchaseRequisition::index');
$routes->get('/purchase-requisition/create', 'PurchaseRequisition::create');
$routes->post('/purchase-requisition/store', 'PurchaseRequisition::store');
$routes->get('/purchase-requisition/edit/(:num)', 'PurchaseRequisition::edit/$1');
$routes->post('/purchase-requisition/update/(:num)', 'PurchaseRequisition::update/$1');
$routes->get('/purchase-requisition/delete/(:num)', 'PurchaseRequisition::delete/$1');

// Training Dev Routes
$routes->get('/training-dev', 'TrainingDev::index');
$routes->get('/training-dev/create', 'TrainingDev::create');
$routes->post('/training-dev/store', 'TrainingDev::store');
$routes->get('/training-dev/edit/(:num)', 'TrainingDev::edit/$1');
$routes->post('/training-dev/update/(:num)', 'TrainingDev::update/$1');
$routes->get('/training-dev/delete/(:num)', 'TrainingDev::delete/$1');

// Performance Routes
$routes->get('/performance', 'Performance::index');
$routes->get('/performance/create', 'Performance::create');
$routes->post('/performance/store', 'Performance::store');
$routes->get('/performance/edit/(:num)', 'Performance::edit/$1');
$routes->post('/performance/update/(:num)', 'Performance::update/$1');
$routes->get('/performance/delete/(:num)', 'Performance::delete/$1');

// Data Validation Routes
$routes->get('/data-validation', 'DataValidation::index');
$routes->get('/data-validation/create', 'DataValidation::create');
$routes->post('/data-validation/store', 'DataValidation::store');
$routes->get('/data-validation/edit/(:num)', 'DataValidation::edit/$1');
$routes->post('/data-validation/update/(:num)', 'DataValidation::update/$1');
$routes->get('/data-validation/delete/(:num)', 'DataValidation::delete/$1');

// System Setting Routes
$routes->get('/system-setting', 'SystemSetting::index');
$routes->get('/system-setting/create', 'SystemSetting::create');
$routes->post('/system-setting/store', 'SystemSetting::store');
$routes->get('/system-setting/edit/(:num)', 'SystemSetting::edit/$1');
$routes->post('/system-setting/update/(:num)', 'SystemSetting::update/$1');
$routes->get('/system-setting/delete/(:num)', 'SystemSetting::delete/$1');

