<?php
class User {
    private $conn;
    private $table = 'users';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($username, $email, $password) {
        try {
            $check_query = "SELECT id FROM " . $this->table . " WHERE email = ?";
            $check_stmt = $this->conn->prepare($check_query);
            $check_stmt->execute([$email]);
            
            if ($check_stmt->rowCount() > 0) {
                return false;
            }

            $query = "INSERT INTO " . $this->table . " 
                    (username, email, password) 
                    VALUES (:username, :email, :password)";

            $stmt = $this->conn->prepare($query);
            
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $hashed_password);

            return $stmt->execute();
            
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function login($email, $password) {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE email = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$email]);

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $row['password'])) {
                    session_start();
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    return true;
                }
            }
            return false;
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
