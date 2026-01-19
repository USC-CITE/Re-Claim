<?php 
/**
 * ReClaim: Configuration Details File
 * Purpose: Returns database connection details
 * Rules: Hide sensitive information
 */

return[
    'db' => [
        'host' => 'reclaim-database',
        'port' => '3306',
        'name' => 'reclaim_app',
        'user' => 'root',
        'pass' => '123',
        'charset' => 'utf8mb4',
    ],
];