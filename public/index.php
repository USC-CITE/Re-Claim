<?php
/**
     * Entry point of the application.
     * Bootstraps config, autoloading, and routing.
     * All HTTP requests pass through this file.
     * Contains no business logic.
 */

require_once __DIR__ . "/../src/Core/Router.php";
require_once __DIR__ . "/../src/Controllers/AuthController.php";

use App\Controllers\AuthController;
use App\Core\Router;

$router = new Router();

/* Routes */
$router->get('/', function () {
    echo "Hello from public!";
});
$router->get('/login', [AuthController::class, 'showLogin']);


$router->dispatch();
