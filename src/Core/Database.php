<?php
/**
 * Purpose:
 * Handles database connection setup and reuse.
 *
 * Why we need this:
 * Prevents opening new DB connections in every model and controller.
 * Keeps credentials and PDO logic centralized.
 *
 * Where it's applied:
 * Instantiated by models or a bootstrap file (index.php).
 */
class Database{
    private static $pdo;

    public static function connect(array $config){
        if(!self::$pdo){
            $dsn = sprintf(
                "mysql:host=%s;port=%s;dbname=%s;charset=%s",
                // Insert values from config.php
                $config['host'],
                $config['port'],
                $config['name'],
                $config['charset']
            );

            self::$pdo = new PDO($dsn, $config['user'], $config['pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }
        return self::$pdo;
    }
}