<?php
/**
 * Helper for case 6 of remember_sessions_test.php.
 * With no authenticated session, ProfileController::showSessions() must
 * redirect-and-exit. If execution ever reaches the marker, the guard failed.
 */

declare(strict_types=1);

$root = dirname(__DIR__);
spl_autoload_register(function ($class) use ($root) {
    $prefix = 'App\\';
    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }
    $file = $root . '/src/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// Deliberately no $_SESSION['user_id'].
\App\Controllers\ProfileController::showSessions();

echo "MARKER_ALIVE\n";
