<?php

use Akhenaton\Library\Router;
use Akhenaton\Library\Dispatcher;
use Akhenaton\Controllers\NewsController;
use Akhenaton\Controllers\AdminController;
use Akhenaton\Controllers\LoginController;


try {
    $dispatcher = new Dispatcher();
    $router = new Router($dispatcher);

    $router->get('/', [NewsController::class, 'index']);
    $router->get('/news', [NewsController::class, 'show']);
    $router->get('/news/{id}', [NewsController::class, 'show']);
    $router->get('/login', [LoginController::class, 'index']);
    // $router->get('/category/{id}', [CategoryController::class, 'show']);
    // $router->get('/author/{id}', [AuthorController::class, 'show']);

    // Admin routes
    $router->get('/admin', [AdminController::class, 'index', 'auth']);
    // $router->get('/admin/news', [AdminNewsController::class, 'index', 'auth']);
    // $router->post('/admin/news', [AdminNewsController::class, 'store', 'auth']);
    // $router->get('/admin/news/{id}/edit', [AdminNewsController::class, 'edit', 'auth']);
    // $router->post('/admin/news/{id}', [AdminNewsController::class, 'update', 'auth']);
    // $router->post('/admin/news/{id}/delete', [AdminNewsController::class, 'delete', 'auth']);

} catch (\Throwable $th) {
    echo $th->getMessage();
}
