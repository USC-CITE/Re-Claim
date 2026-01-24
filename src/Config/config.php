<?php 
/**
 * ReClaim: Configuration Details File
 * Purpose: Returns database connection details
 * Rules: Hide sensitive information
 */

$envPath = dirname(__DIR__, 2) .'/.env';

// Handle error if file does not exist
if (!file_exists($envPath)) {
    var_dump($envPath);
    throw new Exception('.env file not found');
}

// Parse the fields inside the .env into an array
$env = parse_ini_file($envPath);

return[
    'db' => [
        'host' => $env['DB_CONNECTION'],
        'port' => $env['DB_PORT'],
        'name' => $env['DB_NAME'],
        'user' => $env['DB_USER'],
        'pass' => $env['DB_PASS'],
        'charset' => $env['DB_CHARSET'],
    ],
];