<?php

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/vendor/autoload.php';

Dotenv\Dotenv::createImmutable(BASE_PATH)->load();

session_start();



// Minimal Fluent Router Definition
class Route {
    private static $routes = [];

    public static function get($uri, $action) {
        self::$routes['GET'][$uri] = $action;
    }

    public static function post($uri, $action) {
        self::$routes['POST'][$uri] = $action;
    }

    public static function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (isset(self::$routes[$method][$uri])) {
            $action = self::$routes[$method][$uri];
            
            // Handle Laravel-style array syntax: [Controller::class, 'method']
            if (is_array($action)) {
                $controllerName = $action[0];
                $methodName = $action[1];
                $controller = new $controllerName();
                return $controller->$methodName();
            }
            
            // Handle closure actions
            if (is_callable($action)) {
                return $action();
            }
        }

        // Catch-all 404 Route
        http_response_code(404);
        echo "404 Page Not Found";
    }
}

require BASE_PATH . '/routes/web.php';
