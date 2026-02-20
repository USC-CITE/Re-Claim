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
use App\Controllers\LostItemController;
use App\Core\Router;
use App\Core\Database;

use App\Controllers\FoundItemController;  
use App\Controllers\ProfileController;

$router = new Router();

// This passes the config variable as an argument to the connect() METHOD
$db = Database::connect($config['db']);

/* Routes */
$router->get('/', function () {
    require __DIR__ . "/../src/Views/mainpages/view_index.php";
    
});
$router->get('/contact',function (){
    require __DIR__ . "/../src/Views/mainpages/contact.php";
});
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', function () use ($config) {
    AuthController::login($config);
});
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', function () use ($config) {
    AuthController::register($config);
});

$router->get('/verify', [AuthController::class, 'showVerify']);
$router->post('/verify', function() use ($config) {
    AuthController::verify($config);
});
$router->post('/resend-otp', fn() => AuthController::resendOtp($config));
$router->post('/logout', [AuthController::class, 'logout']);

/* Lost Item */
$router->get('/lost', [LostItemController::class, 'index']);
$router->get('/lost/post', [LostItemController::class, 'showPostForm']);
$router->post('/lost/post', [LostItemController::class, 'submitPostForm']);
$router->post('/lost/recover', [LostItemController::class, 'recover']);

/* User Profile Routes */
$router->get('/profile', [ProfileController::class, 'showProfile']);
$router->get('/profile/edit', [ProfileController::class, 'showEditProfile']);

/* Found Item */
$router->get('/found', [FoundItemController::class, 'index']);      // List Page
$router->get('/found/post', [FoundItemController::class, 'showPostForm']); // Post Page
$router->post('/found/post', [FoundItemController::class, 'submitPostForm']); // Submit Action
$router->post('/found/recover', [FoundItemController::class, 'recover']); // Mark found item as recovered

$router->dispatch();
