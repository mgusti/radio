<?php
// 1. Aktifkan Error Reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); 


// 2. Autoloader
spl_autoload_register(function ($class) {
    // Base dir adalah folder tempat index.php berada (Root)
    $base_dir = __DIR__ . '/';
    
    // Ganti \ dengan / untuk path file
    $file = $base_dir . str_replace('\\', '/', $class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// 3. Helper View
function view($viewName, $data = []) {
    extract($data);
    // Pastikan folder resources ada di root
    $viewPath = __DIR__ . '/resources/views/pages/' . $viewName . '.php';
    if (file_exists($viewPath)) {
        require __DIR__ . '/resources/views/layouts/app.php';
    } else {
        echo "View {$viewName} not found.";
    }
}

// 4. Router
// 4. Router (REVISI)
class Router {
    private $routes = [];

    public function get($uri, $action) { 
        $this->routes['GET'][$uri] = $action; 
    }
    
    public function post($uri, $action) { 
        $this->routes['POST'][$uri] = $action; 
    }

    public function dispatch($uri, $method) {
        // Bersihkan URI dari query string
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);
        
        // Deteksi Base Path
        $scriptPath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        if ($scriptPath === '/') $scriptPath = '';

        // Cek path kosong sebelum strpos
        if ($scriptPath !== '' && strpos($uri, $scriptPath) === 0) {
            $uri = substr($uri, strlen($scriptPath));
        }
        
        if (empty($uri)) $uri = '/';

        // Eksekusi Route
        if (isset($this->routes[$method][$uri])) {
            $action = $this->routes[$method][$uri];
            
            // --- PERBAIKAN LOGIKA DISINI ---
            // 1. Cek Array (Controller) TERLEBIH DAHULU
            if (is_array($action)) {
                $controllerName = $action[0];
                $methodName = $action[1];
                
                if (class_exists($controllerName)) {
                    // Buat instance objek baru (Jangan panggil secara static)
                    $controller = new $controllerName();
                    // Panggil method dari instance tersebut
                    $controller->$methodName();
                } else {
                    die("Error: Controller class {$controllerName} tidak ditemukan.");
                }
            } 
            // 2. Baru cek Callable (Closure / Function) jika bukan array
            elseif (is_callable($action)) {
                call_user_func($action);
            }
        } else {
            http_response_code(404);
            echo "404 Not Found. URI: " . htmlspecialchars($uri) . " Method: " . $method;
        }
    }
}

// 5. Database Connection
try {
    // PERBAIKAN NAMESPACE:
    // Diubah dari 'config\database' menjadi 'Config\Database' (Huruf Besar).
    // PASTIKAN: Di folder root Anda ada folder bernama 'Config' (Huruf C Besar)
    //           dan di dalamnya ada file 'Database.php' (Huruf D Besar).
    if (class_exists('config\database')) {
        $db = \config\database::getInstance()->getConnection();
        
        $stmt = $db->prepare("SELECT setting_value FROM settings WHERE setting_key = 'admin_slug'");
        $stmt->execute();
        $slugResult = $stmt->fetch();
        define('ADMIN_SLUG', $slugResult ? $slugResult['setting_value'] : 'admin');
    } else {
        die("Error: Class Config\Database tidak ditemukan. Pastikan folder 'Config' (C besar) ada di root.");
    }
} catch (Exception $e) {
    die("Database Error: " . $e->getMessage());
}

 $router = new Router();

// 6. Load Routes
if (file_exists(__DIR__ . '/routes/web.php')) {
    require __DIR__ . '/routes/web.php';
} else {
    die("Error: File routes/web.php tidak ditemukan di root.");
}

// 7. Dispatch
 $router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);