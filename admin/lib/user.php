<?php
require_once __DIR__ . '/Database.php';

class User {
    private $conn;
    private $table_name = "users";

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function register($username, $email, $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO " . $this->table_name . " (full_name, email, password) VALUES (:full_name, :email, :password)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":full_name", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashed_password);
        
        return $stmt->execute();
    }

    public function login($email, $password) {
        $query = "SELECT user_id, full_name, email, password FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            error_log("User not found for email: $email"); // Debugging
            return false;
        }

        if (password_verify($password, $user['password'])) {
            return $user;
        } else {
            error_log("Password verification failed for user: " . $user['full_name']); // Debugging
        }

        return false;
    }
}
?>
