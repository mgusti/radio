<?php
session_start();

// Autoloader for App Controllers
spl_autoload_register(function ($class) {
    // Convert namespace to full file path
    $base_dir = __DIR__ . '/../';
    
    // Replace namespace prefix with base directory, replace namespace separators with directory separators
    $file = $base_dir . str_replace('\\', '/', $class) . '.php';

    // If the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

// Simple Helper for View Rendering
function view($viewName, $data = []) {
    extract($data);
    $viewPath = __DIR__ . '/../resources/views/pages/' . $viewName . '.php';
    if (file_exists($viewPath)) {
        require __DIR__ . '/../resources/views/layouts/app.php';
    } else {
        echo "View {$viewName} not found.";
    }
}

// Very basic Router
class Router {
    private $routes = [];

    public function get($uri, $action) {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action) {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch($uri, $method) {
        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);
        
        // Remove base path prefix to get a clean route
        // Order matters: check longer prefixes first
        foreach (['/radio/public', '/radio'] as $prefix) {
            if (strpos($uri, $prefix) === 0) {
                $uri = substr($uri, strlen($prefix));
                break;
            }
        }
        if ($uri == '' || $uri === false) $uri = '/';

        if (isset($this->routes[$method][$uri])) {
            $action = $this->routes[$method][$uri];
            if (is_callable($action)) {
                call_user_func($action);
            } elseif (is_array($action)) {
                $controllerName = $action[0];
                $methodName = $action[1];
                $controller = new $controllerName();
                $controller->$methodName();
            }
        } else {
            http_response_code(404);
            echo "404 Not Found. URI: " . htmlspecialchars($uri);
        }
    }
}

// Initialize Database and get Admin Slug
$db = \Config\Database::getInstance()->getConnection();
$stmt = $db->prepare("SELECT setting_value FROM settings WHERE setting_key = 'admin_slug'");
$stmt->execute();
$slugResult = $stmt->fetch();
define('ADMIN_SLUG', $slugResult ? $slugResult['setting_value'] : 'admin');


$router = new Router();

// Load routes
require __DIR__ . '/../routes/web.php';

// Dispatch
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
