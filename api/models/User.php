<?php
require_once __DIR__ . "/../database/connection.php";
class User extends connection
{
    public function login($email)
    {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE email= :email");
        $stmt->execute([
            ":email" => $email,
        ]);
        return $stmt->fetch();
    }
    public function register($firstName, $lastName, $email, $password, $role)
    {
        try {
            $this->connection->beginTransaction();
            $stmt = $this->connection->prepare("INSERT INTO users (first_name, last_name, email, password, role)
             VALUES (:fname, :lname, :email, :password, :role)");
            $stmt->execute([
                ":fname" => $firstName,
                ":lname" => $lastName,
                ":email" => $email,
                ":password" => $password,
                ":role" => $role,
            ]);
            $internalId = $this->connection->lastInsertId();
            // GET PUBLIC ID
            $selectStmt = $this->connection->prepare("SELECT public_id FROM users WHERE id = :id");
            $selectStmt->execute([":id" => $internalId]);

            $row = $selectStmt->fetch();
            $uuid = $row["public_id"];

            $this->connection->commit();
            return ["success" => true, "public_id" => $uuid,];

        } catch (Exception $e) {
            $this->connection->rollBack();
            return ["success" => false, "result" => $e->getMessage()];
            exit;
        }
    }
    public function checkEmail($email){
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([":email" => $email]);

        $user = $stmt->fetch();
        if (!$user) {
            return true;
        }else{
            return false;
        }
    }
}
