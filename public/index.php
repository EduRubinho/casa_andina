<?php
// public/index.php

// Start session if not already started.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load configuration
$config = require_once __DIR__.'/../config.php';

/**
 * PSR-4 compliant autoloader.
 * This function automatically loads classes from the 'App' namespace.
 * It maps the namespace prefix 'App\' to the base directory 'app/'.
 * For example, 'App\Controllers\HomeController' will be loaded from 'app/Controllers/HomeController.php'.
 */
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// Basic URL parsing and routing
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = trim($uri, '/');

// Routing table
switch (true) {
    case ($path === '' || $path === 'home'):
        (new App\Controllers\HomeController($config))->index();
        break;
    case ($path === 'register'):
        $c = new App\Controllers\AuthController($config);
        $_SERVER['REQUEST_METHOD'] === 'POST' ? $c->register() : $c->showRegister();
        break;
    case ($path === 'login'):
        $c = new App\Controllers\AuthController($config);
        $_SERVER['REQUEST_METHOD'] === 'POST' ? $c->login() : $c->showLogin();
        break;
    case ($path === 'logout'):
        (new App\Controllers\AuthController($config))->logout();
        break;
    case ($path === 'reservar/hotel'):
        $c = new App\Controllers\ReservationController($config);
        $_SERVER['REQUEST_METHOD'] === 'POST' ? $c->createHotelReservation() : $c->showHotelForm();
        break;
    case ($path === 'reservar/restaurante'):
        $c = new App\Controllers\ReservationController($config);
        $_SERVER['REQUEST_METHOD'] === 'POST' ? $c->createRestaurantReservation() : $c->showRestaurantForm();
        break;
    case (preg_match('#^reservar/finalizar/(\d+)$#', $path, $m)):
        (new App\Controllers\ReservationController($config))->finalize($m[1]);
        break;
    case ($path === 'life/dashboard'):
        (new App\Controllers\LifeController($config))->dashboard();
        break;
    case ($path === 'life/reservar_puntos'):
        (new App\Controllers\LifeController($config))->reservarConPuntos();
        break;
    default:
        http_response_code(404);
        include __DIR__.'/../app/Views/404.php';
}
