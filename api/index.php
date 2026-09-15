<?php
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Accept, Origin");
header("Access-Control-Allow-Credentials: true"); // Added in case your frontend passes credentials

header("Content-Type: application/json");

// 3. Handle preflight early
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); // 204 No Content is standard for options
    exit();
}


require_once __DIR__ . "/database/Connection.php";
require_once __DIR__ . "/routes/routes.php";

require_once __DIR__ . "/middleware/AuthMiddleware.php";


$middlewareClasses = [
    "auth" => AuthMiddleware::class,
];


// HTTP method
$requestMethod = $_SERVER["REQUEST_METHOD"];

// Requested URL
$requestPath = parse_url(
    $_SERVER["REQUEST_URI"],
    PHP_URL_PATH
);

$config = new Config;
/*
|--------------------------------------------------------------------------
| Remove /tenant-management/api from URL
|--------------------------------------------------------------------------
|
| Example:
|
| /tenant-management/api/users/5
|
| becomes:
|
| /users/5
|
*/

$basePath = $config->envs()["baseUrl"];

$requestPath = str_replace(
    $basePath,
    "",
    $requestPath
);

$requestPath = rtrim($requestPath, "/");

if ($requestPath === "") {
    $requestPath = "/";
}

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$routeFound = false;

foreach ($routes as $route) {

    // Check HTTP method
    if ($route["method"] !== $requestMethod) {
        continue;
    }

    /*
    |--------------------------------------------------------------------------
    | Convert route path to regular expression
    |--------------------------------------------------------------------------
    |
    | /users/{id}
    |
    | becomes:
    |
    | /users/([^/]+)
    |
    */

    $pattern = preg_replace(
        "/\{([^}]+)\}/",
        "([^/]+)",
        $route["path"]
    );

    $pattern = "#^" . $pattern . "$#";


    /*
    |--------------------------------------------------------------------------
    | Check URL
    |--------------------------------------------------------------------------
    */

    if (preg_match($pattern, $requestPath, $matches)) {

        $routeFound = true;

        /*
        |--------------------------------------------------------------------------
        | Remove full URL from matches
        |--------------------------------------------------------------------------
        */

        array_shift($matches);
        $auth = null;
        // middleware
        foreach ($route["middleware"] ?? [] as $middleware) {

            $middlewareClass = $middlewareClasses[$middleware];

            $auth = $middlewareClass::handle();
        }

        $controllerFile = __DIR__ .
            "/controllers/" .
            $route["controller"] .
            ".php";

        $controllerClass = $route["controller"];


        if (!file_exists($controllerFile)) {

            http_response_code(500);

            echo json_encode([
                "success" => false,
                "message" => "Controller not found"
            ]);

            exit;
        }

        require_once $controllerFile;



        $controller = new $controllerClass();


        $action = $route["action"];

        if (!method_exists($controller, $action)) {

            http_response_code(500);

            echo json_encode([
                "success" => false,
                "message" => "Controller method not found"
            ]);

            exit;
        }

        if (!empty($matches)) {

            // Example:
            // /users/5
            //
            // calls:
            // show(5)

            $controller->$action(
                $data,
                $matches[0],
                $auth
            );
        } else {

            // Example:
            // /users
            //
            // calls:
            // index()

            $controller->$action($data, $auth);
        }

        exit;
    }
}



if (!$routeFound) {

    http_response_code(404);

    echo json_encode([
        "success" => false,
        "message" => "Route not found"
    ]);

    exit;
}
