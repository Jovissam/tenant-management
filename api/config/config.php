<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;
class Config
{
    public function __construct()
    {
        $this->loadEnv();
    }
    protected array $env;
    private function loadEnv()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $this->env = $_ENV;
    }
    public function envs(){
        return[
            "baseUrl" => $this->env["BASE_URL"],
            "JWT_SECRET" => $this->env["JWT_SECRET"],
            "JWT_EXPIRY" => $this->env["JWT_EXPIRY"],
        ];
    }
}
