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
        'host' => $env['DB_CONNECTION'] ?? 'localhost',
        'port' => $env['DB_PORT'] ?? 3306,
        'name' => $env['DB_NAME'] ?? null, // must comde from .env
        'user' => $env['DB_USER'] ?? null, // must comde from .env
        'pass' => $env['DB_PASS'] ?? null, // must comde from .env
        'charset' => $env['DB_CHARSET'] ?? 'utf8mb4 ',
    ],
];