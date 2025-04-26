<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once BASE_PATH . 'database/config.php';

class UserModel {
    private $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function createUser($username, $email, $phone, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, phone, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->error);
        }
        $stmt->bind_param("ssss", $username, $email, $phone, $hashedPassword);
        return $stmt->execute();
    }

    public function login($identifier, $password) {
        $sql = "SELECT * FROM users WHERE username = ? OR email = ? OR phone = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $identifier, $identifier, $identifier);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if ($user && $user['password'] === $password) {
            return $user;
        }
        return false;
    }

    public function getUserByIdentifier($identifier) {
        $sql = "SELECT * FROM users WHERE username = ? OR email = ? OR phone = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->error);
        }
        $stmt->bind_param("sss", $identifier, $identifier, $identifier);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}