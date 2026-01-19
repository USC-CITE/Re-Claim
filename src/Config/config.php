<?php 
/**
 * ReClaim: Configuration File
 * Purpose: Returns database connection details
 * Rules: Hide sensitive information
 */

return[
    'db' => [
        'host' => 'reclaim-database',
        'port' => '3306',
        'name' => 'webuser',
        'user' => 'root',
        'pass' => '123',
        'charset' => 'utf8mb4',
    ],
];