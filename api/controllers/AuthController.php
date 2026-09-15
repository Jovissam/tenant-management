<?php
require_once __DIR__ . "/../models/User.php";

use Firebase\JWT\JWT;

class AuthController
{
    public function jwt($user, $rememberMe = true)
{
    $configClass = new Config();
    $issuedAt = time();
    
    if ($rememberMe === true) {
        $expire = $issuedAt + (3600 * 24 * 30); // 30 days period
    } else {
        $expire = $issuedAt + $configClass->envs()["JWT_EXPIRY"]; // default 1 hour expiry
    }

    $payload = [
        'iss' => 'http://127.0.0.1:8000', 
        'aud' => 'http://localhost:8080',  
        'iat' => $issuedAt,                
        'exp' => $expire,                  
        'data' => [
            'userId' => $user['publicId'], 
            'role'   => $user['role']
        ]
    ];
    
    $jwtSecret = $configClass->envs()["JWT_SECRET"];
    $jwt = JWT::encode($payload, $jwtSecret, "HS256");

    header("Content-Type: application/json");
    echo json_encode([
        "success" => true,
        "message" => $user["message"] ?? "Authentication Successful",
        "data" => [
            "userId" => $user["publicId"],
            "token" => $jwt,
            'tokenExpiry' => $expire,
            'role' => $user["role"]
        ]
    ]);
    exit();
}

    public function register(array $params)
    {
        $firstName = $params["firstName"] ?? null;
        $lastName = $params["lastName"] ?? null;
        $email = $params["email"] ?? null;
        $password = $params["password"] ?? null;
        $role = "admin";
        // VERIFY INPUTS
        if (!$firstName || !$lastName || !$email || !$password) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "Please Input all fields"]);
            exit();
        }
        $userClass = new User();
        if (!$userClass->checkEmail($email)) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "Email already Exists. "]);
            exit();
        }
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $query = $userClass->register($firstName, $lastName, $email, $hashedPassword, $role);
        if (!$query["success"]) {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Failed To register User"]);
            exit();
        }
        $jwt = ["publicId" => $query['public_id'], "role" => $role, "message" => "registration successful"];
        $this->jwt($jwt);
        return;
    }
    public function login(array $params)
    {
        $email = $params["email"] ?? null;
        $password = $params["password"] ?? null;
        $remember = $params["remember"] ?? false;

        if (!$email || !$password) {
            http_response_code(401);
            echo json_encode(["success" => false, "message" => "Please Input all fields"]);
            exit();
        }

        $userClass = new User();
        $user = $userClass->login($email);
        if (!$user || !password_verify($password, $user["password"])) {
            http_response_code(401);
            echo json_encode(["success" => false, "message" => "Email or Password is Incorrect"]);
            exit();
        }
        $jwt = ["publicId" => $user['public_id'], "role" => $user["role"], "message" => "Login Successful"];
        $this->jwt($jwt, $remember);
        return;
    }
}
