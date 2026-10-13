<?php

namespace App\Core;
/*
Title: PHP Router
Author: unknown
Date: <01/11/2026
Code version: n/a
Type: source code
Description: lightweight object-oriented router support
Availability: https://github.com/phprouter/main

 * HTTP router for the application.
 * Maps HTTP methods and URIs to callables.
 * Dispatches requests to controllers or closures.

*/

class Router
{
    private array $routes = [];
    private array $config = [];

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function get(string $route, $handler): void
    {
        $this->addRoute('GET', $route, $handler);
    }
    public function post(string $route, $handler): void
    {
        $this->addRoute('POST', $route, $handler);
    }
    public function put(string $route, $handler): void
    {
        $this->addRoute('PUT', $route, $handler);
    }
    public function patch(string $route, $handler): void
    {
        $this->addRoute('PATCH', $route, $handler);
    }
    public function delete(string $route, $handler): void
    {
        $this->addRoute('DELETE', $route, $handler);
    }
    public function any(string $route, $handler): void
    {
        foreach (['GET', 'POST', 'PUT', 'PATCH', 'DELETE'] as $method) {
            $this->addRoute($method, $route, $handler);
        }
    }

    private function addRoute(string $method, string $route, $handler): void
    {
        $normalizedRoute = \rtrim($route, '/');
        $normalizedRoute = $normalizedRoute === '' ? '/' : $normalizedRoute;

        $this->routes[$method][] = [
            'route' => $normalizedRoute,
            'handler' => $handler
        ];
    }

    public function dispatch(): void
    {
        if (\session_status() === PHP_SESSION_NONE) {
            \session_start();
        }

        $this->authenticateFromRememberCookie();

        $uri = \parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = \rtrim($uri, '/');
        $uri = $uri === '' ? '/' : $uri;

        $method = $_SERVER['REQUEST_METHOD'];

        // Security: CSRF Protection for all mutating requests
        if (\in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'], true)) {
            if (!self::isCsrfValid()) {
                \http_response_code(403);
                die('Error 403: Security token (CSRF) mismatch or missing. Action denied.');
            }
        }

        foreach ($this->routes[$method] ?? [] as $routeData) {
            $params = $this->match($routeData['route'], $uri);

            if ($params !== false) {
                $this->execute($routeData['handler'], $params);
                return;
            }
        }

        \http_response_code(404);
        echo "404 - Route not found";
    }

    private function match(string $route, string $uri)
    {
        $routeParts = \explode('/', \ltrim($route, '/'));
        $uriParts = \explode('/', \ltrim($uri, '/'));

        if ($route === '/' && $uri === '/') {
            return [];
        }

        if (\count($routeParts) !== \count($uriParts)) {
            return false;
        }

        $params = [];

        foreach ($routeParts as $i => $part) {
            if (\str_starts_with($part, '$')) {
                $params[] = $uriParts[$i];
            } elseif ($part !== $uriParts[$i]) {
                return false;
            }
        }

        return $params;
    }

    private function execute($handler, array $params): void
    {
        if (\is_callable($handler)) {
            \call_user_func_array($handler, $params);
            exit;
        }

        if (!\str_ends_with($handler, '.php')) {
            $handler .= '.php';
        }
        require $handler;
        exit;
    }

    public static function out(string $text): void
    {
        echo \htmlspecialchars($text, \ENT_QUOTES, 'UTF-8');
    }

    public static function setCsrf(): void
    {
        $_SESSION['csrf'] ??= \bin2hex(\random_bytes(50));

        echo '<input type="hidden" name="csrf" value="' . \htmlspecialchars($_SESSION['csrf'], \ENT_QUOTES, 'UTF-8') . '">';
    }

    public static function isCsrfValid(): bool
    {
        $token = $_POST['csrf'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        return isset($_SESSION['csrf']) &&
            !empty($token) &&
            \hash_equals($_SESSION['csrf'], $token);
    }

    private function authenticateFromRememberCookie(): void
    {
        if (!empty($_SESSION['user_id']) || empty($_COOKIE['remember_token'])) {
            return;
        }

        $parts = \explode(':', $_COOKIE['remember_token'], 2);
        if (\count($parts) !== 2) {
            $this->clearRememberCookie();
            return;
        }

        [$selector, $validator] = $parts;
        if (empty($selector) || empty($validator)) {
            $this->clearRememberCookie();
            return;
        }

        try {
            $userModel = new \App\Models\UserModel($this->config);
            $tokenRecord = $userModel->findRememberTokenBySelector($selector);

            if (!$tokenRecord) {
                $this->clearRememberCookie();
                return;
            }

            $calculatedHash = \hash('sha256', $validator);
            if (!\hash_equals($tokenRecord['validator_hash'], $calculatedHash)) {
                $userModel->deleteRememberTokenBySelector($selector);
                $this->clearRememberCookie();
                return;
            }

            $user = $userModel->findById((string)$tokenRecord['user_id']);
            if (!$user) {
                $userModel->deleteRememberTokenBySelector($selector);
                $this->clearRememberCookie();
                return;
            }

            // Restore user session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['phone_number'] = $user['phone_number'];
            $_SESSION['social_link'] = $user['social_link'];
            $_SESSION['wvsu_email'] = $user['wvsu_email'];
            $_SESSION['avatar'] = $user['avatar_path'];

            // Rotate validator for replay protection
            $newValidator = \bin2hex(\random_bytes(32));
            $newValidatorHash = \hash('sha256', $newValidator);
            $expiresAt = \date('Y-m-d H:i:s', \time() + (30 * 24 * 60 * 60));

            $userModel->deleteRememberTokenBySelector($selector);
            $newSelector = \bin2hex(\random_bytes(16));
            $userModel->storeRememberToken((int)$user['id'], $newSelector, $newValidatorHash, $expiresAt);

            $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
            \setcookie(
                'remember_token',
                $newSelector . ':' . $newValidator,
                [
                    'expires' => \time() + (30 * 24 * 60 * 60),
                    'path' => '/',
                    'domain' => '',
                    'secure' => $isSecure,
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]
            );
        } catch (\Throwable $e) {
            // If DB connection fails or table error, do not break the whole request
        }
    }

    private function clearRememberCookie(): void
    {
        $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
        \setcookie('remember_token', '', [
            'expires' => \time() - 3600,
            'path' => '/',
            'domain' => '',
            'secure' => $isSecure,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
    }
}
?>