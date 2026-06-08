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
use App\Controllers\ItemController;
use App\Core\Router;
use App\Core\Database;
use App\Controllers\ProfileController;
use App\Controllers\ContactController;

$router = new Router();

// This passes the config variable as an argument to the connect() METHOD
$db = Database::connect($config['db']);

/* Routes */
/* [PUBLIC ROUTES] */
$router->get('/', function () {
    require __DIR__ . "/../src/Views/mainpages/view_index.php";
    
});
$router->get('/contact', [ContactController::class, 'showContactPage']);
$router->post('/contact/send', [ContactController::class, 'sendMessage']);
$router->get('/terms-of-service', function() {
    require __DIR__ . '/../src/Views/mainpages/terms-of-service.php';
});
$router->get('/privacy-policy', function() {
    require __DIR__ . '/../src/Views/mainpages/privacy-policy.php';
});
$router->get('/login', [AuthController::class, 'showLogin']);
$router->get('/forgot-password', [AuthController::class, 'showForgotPassword']);
$router->post('/login', function () use ($config) {
    AuthController::login($config);
});
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', function () use ($config) {
    AuthController::register($config);
});
$router->post('/forgot-password', function () use ($config) {
    AuthController::forgotPassword($config);
});
$router->get('/reset-password', function () use ($config) {
    AuthController::showResetPassword($config);
});
$router->post('/reset-password', function () use ($config) {
    AuthController::resetPassword($config);
});


/* [PROTECTED ROUTES] */
$router->get('/verify', [AuthController::class, 'showVerify']);
$router->post('/verify', function() use ($config) {
    AuthController::verify($config);
});
$router->post('/resend-otp', fn() => AuthController::resendOtp($config));
$router->post('/logout', [AuthController::class, 'logout']);

/* Lost Item */
$router->get('/lost', [ItemController::class, 'listLostItems']);
$router->post('/lost/recover', [ItemController::class, 'recover']);
$router->post('/lost/archive', [ItemController::class, 'archive']);
$router->post('/lost/delay-archive', [ItemController::class, 'delayArchive']);

/* User Profile Routes */
$router->get('/profile', [ProfileController::class, 'showProfile']);
$router->get('/profile/settings', [ProfileController::class, 'showProfileSettings']);
$router->post('/profile/archived/delete', [ProfileController::class, 'deleteArchivedItems']);
$router->post('/profile/edit', [ProfileController::class, 'updateProfile']);
$router->post('/profile/change-password', [ProfileController::class, 'changePassword']);
$router->post('/profile/change-password/verify', [ProfileController::class, 'verifyPassword']);
$router->post('/profile/delete', [ProfileController::class, 'deleteAccount']);

/* Found Item */
$router->get('/found', [ItemController::class, 'listFoundItems']);
$router->post('/found/recover', [ItemController::class, 'recover']);
$router->post('/found/archive', [ItemController::class, 'archive']);
$router->post('/found/delay-archive', [ItemController::class, 'delayArchive']);

/* Recovered Items */
$router->get('/recovered', [ItemController::class, 'listRecoveredItems']);

/* Unified Post Item */
$router->get('/post-item', [ItemController::class, 'showPostForm']);
$router->post('/post-item', [ItemController::class, 'submitPostForm']);

$router->dispatch();
