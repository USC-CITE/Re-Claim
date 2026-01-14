<?php
// Entry point
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
