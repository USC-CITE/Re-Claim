<?php
/**
 * PSR-4 Autoloader for mapping namespaces and class names to file paths
 * This is added to eliminate manual requires of every class file
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

spl_autoload_register(function ($class) {
    $prefix = 'App\\';          // Our root namespace
    $baseDir = __DIR__ . '/';   // Points to src/

    // Does the class use our namespace?
    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return; // Not our namespace
    }

    // Remove namespace prefix and convert namespace separators to directory separators
    $relativeClass = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    // Include the file if it exists
    if (file_exists($file)) {
        require $file;
    }
});
