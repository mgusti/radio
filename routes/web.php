<?php

use App\Controllers\HomeController;
use App\Controllers\NewsController;

// Define Routes
/** @var Router $router */

$router->get('/', [HomeController::class, 'index']);
$router->get('/news', [NewsController::class, 'index']);
$router->get('/news/view', [NewsController::class, 'show']);
$router->get('/calendar', [\App\Controllers\CalendarController::class, 'index']);


// Admin Auth Routes
use App\Controllers\AuthController;
$router->get('/' . ADMIN_SLUG . '/login', [AuthController::class, 'loginForm']);
$router->post('/' . ADMIN_SLUG . '/login', [AuthController::class, 'login']);
$router->get('/' . ADMIN_SLUG . '/logout', [AuthController::class, 'logout']);

// Admin CRUD Routes
use App\Controllers\AdminController;
$router->get('/' . ADMIN_SLUG, [AdminController::class, 'dashboard']);
$router->get('/' . ADMIN_SLUG . '/news', [AdminController::class, 'allNews']);
$router->get('/' . ADMIN_SLUG . '/news/create', [AdminController::class, 'createNews']);
$router->post('/' . ADMIN_SLUG . '/news/create', [AdminController::class, 'createNews']);
$router->get('/' . ADMIN_SLUG . '/news/edit', [AdminController::class, 'editNews']);
$router->post('/' . ADMIN_SLUG . '/news/edit', [AdminController::class, 'editNews']);
$router->post('/' . ADMIN_SLUG . '/news/delete', [AdminController::class, 'deleteNews']);

// Admin User Routes
$router->get('/' . ADMIN_SLUG . '/users', [AdminController::class, 'users']);
$router->get('/' . ADMIN_SLUG . '/users/create', [AdminController::class, 'createUser']);
$router->post('/' . ADMIN_SLUG . '/users/create', [AdminController::class, 'createUser']);
$router->get('/' . ADMIN_SLUG . '/users/edit', [AdminController::class, 'editUser']);
$router->post('/' . ADMIN_SLUG . '/users/edit', [AdminController::class, 'editUser']);
$router->post('/' . ADMIN_SLUG . '/users/delete', [AdminController::class, 'deleteUser']);
$router->post('/' . ADMIN_SLUG . '/users/reset-password', [AdminController::class, 'resetUserPassword']);

// Admin Calendar Routes
$router->get('/' . ADMIN_SLUG . '/calendar', [AdminController::class, 'calendar']);
$router->get('/' . ADMIN_SLUG . '/calendar/create', [AdminController::class, 'createEvent']);
$router->post('/' . ADMIN_SLUG . '/calendar/create', [AdminController::class, 'createEvent']);
$router->get('/' . ADMIN_SLUG . '/calendar/edit', [AdminController::class, 'editEvent']);
$router->post('/' . ADMIN_SLUG . '/calendar/edit', [AdminController::class, 'editEvent']);
$router->post('/' . ADMIN_SLUG . '/calendar/delete', [AdminController::class, 'deleteEvent']);

// Admin Settings
$router->get('/' . ADMIN_SLUG . '/settings', [AdminController::class, 'settings']);
$router->post('/' . ADMIN_SLUG . '/settings', [AdminController::class, 'settings']);
$router->post('/' . ADMIN_SLUG . '/settings/slug', [AdminController::class, 'updateSlug']);
