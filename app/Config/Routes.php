<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =========================================================================
// Kimlik Doğrulama Rotaları (HAFTA 1)
// Shield'in auth servisi arka planda kullanılır, ama controller bizim.
// =========================================================================
$routes->get('login',  'AuthController::login',       ['as' => 'login']);
$routes->post('login', 'AuthController::loginAction');
$routes->get('logout',  'AuthController::logout',     ['as' => 'logout']);
$routes->post('logout', 'AuthController::logout');

// =========================================================================
// Ana giriş: oturum varsa role göre yönlendir, yoksa /login'e gider.
// =========================================================================
$routes->get('/', 'Home::index');

// =========================================================================
// Oturum gerektiren alan — Custom auth filter ile korunur
// =========================================================================
$routes->group('', ['filter' => 'auth'], static function ($routes) {

    // ---------------------------------------------------------------------
    // ADMIN ALANI — sadece admin grubu
    // ---------------------------------------------------------------------
    $routes->group('admin', [
        'filter'    => 'admin',
        'namespace' => 'App\Controllers\Admin',
    ], static function ($routes) {

        // Dashboard (HAFTA 1 — aktif)
        $routes->get('/',         'DashboardController::index');
        $routes->get('dashboard', 'DashboardController::index');

        // =====================================================
        // HAFTA 2 — Öğrenci 2: Kategori ve Envanter
        // Modülü yazınca aşağıdaki satırları aç:
        // =====================================================
        // $routes->group('categories', static function ($routes) {
        //     $routes->get('/',              'CategoryController::index');
        //     $routes->get('create',         'CategoryController::create');
        //     $routes->post('/',             'CategoryController::store');
        //     $routes->get('(:num)/edit',    'CategoryController::edit/$1');
        //     $routes->post('(:num)',        'CategoryController::update/$1');
        //     $routes->post('(:num)/delete', 'CategoryController::delete/$1');
        // });
        //
        // $routes->group('inventory', static function ($routes) {
        //     $routes->get('/',                     'InventoryController::index');
        //     $routes->get('create',                'InventoryController::create');
        //     $routes->post('/',                    'InventoryController::store');
        //     $routes->get('(:num)',                'InventoryController::show/$1');
        //     $routes->get('(:num)/edit',           'InventoryController::edit/$1');
        //     $routes->post('(:num)',               'InventoryController::update/$1');
        //     $routes->post('(:num)/delete',        'InventoryController::delete/$1');
        //     $routes->post('(:num)/images',        'InventoryController::uploadImage/$1');
        //     $routes->post('images/(:num)/delete', 'InventoryController::deleteImage/$1');
        // });

        // =====================================================
        // HAFTA 4 — Öğrenci 4: Talep Onayı ve Zimmet
        // =====================================================
        // $routes->group('requests', static function ($routes) {
        //     $routes->get('/',               'RequestController::index');
        //     $routes->get('(:num)',          'RequestController::show/$1');
        //     $routes->post('(:num)/approve', 'RequestController::approve/$1');
        //     $routes->post('(:num)/reject',  'RequestController::reject/$1');
        // });
        //
        // $routes->group('assignments', static function ($routes) {
        //     $routes->get('/',              'AssignmentController::index');
        //     $routes->get('create',         'AssignmentController::create');
        //     $routes->post('/',             'AssignmentController::store');
        //     $routes->post('(:num)/return', 'AssignmentController::returnItem/$1');
        // });
    });

    // ---------------------------------------------------------------------
    // STAFF ALANI — sadece staff grubu
    // ---------------------------------------------------------------------
    $routes->group('staff', [
        'namespace' => 'App\Controllers\Staff',
    ], static function ($routes) {

        // Dashboard (HAFTA 1 — aktif)
        $routes->get('/',         'DashboardController::index');
        $routes->get('dashboard', 'DashboardController::index');

        // =====================================================
        // HAFTA 3 — Öğrenci 3: Talep oluşturma ve listeleme
        // =====================================================
        // $routes->group('requests', static function ($routes) {
        //     $routes->get('/',              'RequestController::index');        // taleplerim
        //     $routes->get('create',         'RequestController::create');       // form
        //     $routes->post('/',             'RequestController::store');
        //     $routes->get('(:num)',         'RequestController::show/$1');
        //     $routes->post('(:num)/cancel', 'RequestController::cancel/$1');
        // });
    });

    // ---------------------------------------------------------------------
    // API — JSON endpoint'ler (Hafta 5 grafikleri için)
    // ---------------------------------------------------------------------
    // =====================================================
    // HAFTA 5 — Öğrenci 5: Dashboard API
    // =====================================================
    // $routes->group('api', ['namespace' => 'App\Controllers\Api'], static function ($routes) {
    //     $routes->get('dashboard/stats',       'DashboardApi::stats');
    //     $routes->get('inventory/by-category', 'InventoryApi::byCategory');
    //     $routes->get('requests/by-status',    'DashboardApi::requestsByStatus');
    // });
});
