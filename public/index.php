<?php
/**
     * Entry point of the application.
     * Bootstraps config, autoloading, and routing.
     * All HTTP requests pass through this file.
     * Contains no business logic.
 */
require __DIR__ . '/../src/init.php';

// Declare as variable the dictionary that config.php returns
$config = require_once __DIR__ . '/../src/Config/config.php';

use App\Controllers\AuthController;
use App\Core\Router;
use App\Core\Database;

use App\Controllers\FoundItemController;  

$router = new Router();

// This passes the config variable as an argument to the connect() METHOD
$db = Database::connect($config['db']);

/* Routes */
$router->get('/', function () {
    echo "Hello from public!";
});
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', function () use ($config) {
    AuthController::register($config);
});







$router->get('/found', [FoundItemController::class, 'index']);      // List Page
$router->get('/found/post', [FoundItemController::class, 'showPostForm']); // Post Page
$router->post('/found/post', [FoundItemController::class, 'submitPostForm']); // Submit Action

$router->dispatch();
