<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->get('/admin/login', 'Admin\Login::index');
$routes->post('/admin/login', 'Admin\Login::login');
$routes->add('/admin/logout', 'Admin\Login::logout');

$routes->group('admin',['filter' => 'auth'] ,function ($routes) {
    // product route
    $routes->get('/','Admin/Product::index');
    $routes->get('product', 'Admin\Product::index');
    $routes->post('product', 'Admin\Product::store');
    $routes->post('product/edit/(:id)', 'Admin\Product::edit');
    $routes->get('product/delete/(:id)', 'Admin\Product::delete');

    $routes->get('category', 'Admin\Category::index');
    $routes->post('category', 'Admin\Category::store');
    $routes->post('category/edit/(:id)', 'Admin\Category::edit');
    $routes->get('category/delete/(:id)', 'Admin\Category::delete');

});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
