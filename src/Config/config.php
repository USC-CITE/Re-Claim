<?php 
/**
 * ReClaim: Configuration Details File
 * Purpose: Returns database connection details
 * Rules: Hide sensitive information
 */

use Dotenv\Dotenv;

$envPath = dirname(__DIR__, 2);

// Handle error if file does not exist
if (!file_exists($envPath)) {
    var_dump($envPath);
    throw new Exception('.env file not found');
}

// Parse the fields inside the .env into an array
// $env = parse_ini_file($envPath);
Dotenv::createImmutable($envPath, '.env')->load();

return[
    'db' => [
        'host' => $_ENV['DB_HOST'] ?? 'localhost',
        'port' => $_ENV['DB_PORT'] ?? 3306,
        'name' => $_ENV['DB_NAME'] ?? null, // must comde from .env
        'user' => $_ENV['DB_USER'] ?? null, // must comde from .env
        'pass' => $_ENV['DB_PASS'] ?? null, // must comde from .env
        'charset' => $_ENV['DB_CHARSET'] ?? 'utf8mb4 ',
    ],
];