<?php
require_once __DIR__ . "/../config/config.php";

class Connection extends Config
{
    public function __construct()
    {
        parent::__construct();

        $this->host = $this->env["DB_HOST"];
        $this->db = $this->env["DB_NAME"];
        $this->userName = $this->env["DB_USER"];
        $this->password = $this->env["DB_PASSWORD"];
        $this->getConnection();
    }
    private $host;
    private $userName;
    private $password;
    private $db;
    protected PDO $connection;

    private function getConnection(): void
    {
        // if ($conn->connect_error) {
        //     die("unable to connect to database");
        // } else {
        //     $this->connection = $conn;
        // }
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=utf8mb4";
        try {
            $conn = new PDO($dsn, $this->userName, $this->password);

            $conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            $conn->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );

            $this->connection = $conn;
        } catch (PDOException $e) {
            // error_log($e->getMessage());  // for prod
            // die("Database connection failed.");  
            die("Database connection failed: " . $e->getMessage());
        }
    }
}
