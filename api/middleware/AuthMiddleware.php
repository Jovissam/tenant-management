<?php

class AuthMiddleware
{
    public static function handle()
    {
        $headers = getallheaders();

        $authorization = $headers["Authorization"] ?? null;

        if (!$authorization) {
            http_response_code(401);

            echo json_encode([
                "success" => false,
                "message" => "Authorization token required"
            ]);

            exit;
        }

        if (!str_starts_with($authorization, "Bearer ")) {
            http_response_code(401);

            echo json_encode([
                "success" => false,
                "message" => "Invalid authorization format"
            ]);

            exit;
        }

        $token = substr($authorization, 7);

        // JWT verification will go here

        return $token;
    }
}