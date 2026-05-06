<?php

use App\Controllers\HomeController;
use App\Controllers\NewsController;

// Define Routes
/** @var Router $router */

$router->get('/', [HomeController::class, 'index']);
$router->get('/news', [NewsController::class, 'index']);
$router->get('/news/view', [NewsController::class, 'show']);


// Admin Auth Routes
use App\Controllers\AuthController;
$router->get('/' . ADMIN_SLUG . '/login', [AuthController::class, 'loginForm']);
$router->post('/' . ADMIN_SLUG . '/login', [AuthController::class, 'login']);
$router->get('/' . ADMIN_SLUG . '/logout', [AuthController::class, 'logout']);

// Admin CRUD Routes
use App\Controllers\AdminController;
$router->get('/' . ADMIN_SLUG, [AdminController::class, 'dashboard']);
$router->get('/' . ADMIN_SLUG . '/news/create', [AdminController::class, 'createNews']);
$router->post('/' . ADMIN_SLUG . '/news/create', [AdminController::class, 'createNews']);
$router->get('/' . ADMIN_SLUG . '/news/edit', [AdminController::class, 'editNews']);
$router->post('/' . ADMIN_SLUG . '/news/edit', [AdminController::class, 'editNews']);
$router->post('/' . ADMIN_SLUG . '/news/delete', [AdminController::class, 'deleteNews']);

// Admin Settings
$router->get('/' . ADMIN_SLUG . '/settings', [AdminController::class, 'settings']);
$router->post('/' . ADMIN_SLUG . '/settings', [AdminController::class, 'settings']);
$router->post('/' . ADMIN_SLUG . '/settings/slug', [AdminController::class, 'updateSlug']);
