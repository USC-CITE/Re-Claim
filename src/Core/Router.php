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

class Router{
    private array $routes = [];

    public function get(string $route, $handler): void{
        $this->addRoute('GET', $route, $handler);
    }
    public function post(string $route, $handler): void{
        $this->addRoute('POST', $route, $handler);
    }
    public function put(string $route, $handler): void{
        $this->addRoute('PUT', $route, $handler);
    }
    public function patch(string $route, $handler): void{
        $this->addRoute('PATCH', $route, $handler);
    }
    public function delete(string $route, $handler): void{
        $this->addRoute('DELETE', $route, $handler);
    }
    public function any(string $route, $handler): void{
        foreach(['GET', 'POST', 'PUT', 'PATCH', 'DELETE'] as $method){
            $this->addRoute($method, $route, $handler);
        }
    }

    private function addRoute(string $method, string $route, $handler): void
    {
        $this->routes[$method][] = [
            'route' => rtrim($route, '/'),
            'handler' => $handler
        ];
    }

    public function dispatch(): void{
        //Start session here
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = rtrim($uri, '/');
        $uri = $uri === '' ? '/' : $uri;

        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes[$method] ?? [] as $routeData) {

            $route = rtrim($routeData['route'], '/');
            $route = $route === '' ? '/' : $route;

            if ($route === $uri) {
                $handler = $routeData['handler'];
                call_user_func($handler);
                return;
            }
        }

        http_response_code(404);
        echo "404 - Route not found";
    }

    private function sanitizeUri(string $uri):string
    {
        $uri = filter_var($uri, FILTER_SANITIZE_URL);
        $uri = strtok($uri, '?');
        return rtrim($uri, '/') ?: '/';
    }

    private function match(string $route, string $uri){
        $routeParts = explode('/', ltrim($route, '/'));
        $uriParts = explode('/', ltrim($uri, '/'));

        if ($route === '/' && $uri === '/') {
            return [];
        }

        if (count($routeParts) !== count($uriParts)) {
            return false;
        }

        $params = [];

        foreach($routeParts as $i => $part){
            if(str_starts_with($part, '$')){
                $params[] = $uriParts[$i];
            }elseif($part !== $uriParts[$i]){
                return false;
            }
        }

        return $params;
    }

    private function execute($handler, array $params): void{
        if(is_callable($handler)){
            call_user_func_array($handler, $params);
            exit;
        }

        if(!str_ends_with($handler, '.php')){
            $handler .= '.php';
        }
        require $handler;
        exit;
    }

    public static function out(string $text): void
    {
        echo htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }

    public static function setCsrf(): void
    {
        $_SESSION['csrf'] ??= bin2hex(random_bytes(50));

        echo '<input type="hidden" name="csrf" value="' . $_SESSION['csrf'] . '">';
    }

    public static function isCsrfValid(): bool
    {
        return isset($_SESSION['csrf'], $_POST['csrf']) &&
               hash_equals($_SESSION['csrf'], $_POST['csrf']);
    }
}
?>