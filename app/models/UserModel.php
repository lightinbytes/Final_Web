<?php
   if (!defined('BASEPATH')) {
       exit('No direct script access allowed');
   }

   require_once BASE_PATH . 'database/config.php';

   class UserModel {
       private $conn;

       public function __construct(PDO $conn) {
           $this->conn = $conn;
       }

       public function createUser($username, $email, $phone, $password) {
           $sql = "INSERT INTO users (username, email, phone, password) VALUES (?, ?, ?, ?)";
           $stmt = $this->conn->prepare($sql);
           if (!$stmt) {
               throw new Exception("Prepare statement failed: " . $this->conn->errorInfo()[2]);
           }
           return $stmt->execute([$username, $email, $phone, $password]);
       }

       public function login($identifier, $password) {
           $sql = "SELECT * FROM users WHERE username = ? OR email = ? OR phone = ?";
           $stmt = $this->conn->prepare($sql);
           $stmt->execute([$identifier, $identifier, $identifier]);
           $user = $stmt->fetch(PDO::FETCH_ASSOC);

           if ($user && $user['password'] === $password) {
               return $user;
           }
           return false;
       }

       public function signup($fullname, $email, $phone, $password, $repeat_password) {
           if ($password !== $repeat_password) {
               return ['success' => false, 'error' => 'Mật khẩu và xác nhận mật khẩu không khớp!'];
           }

           $username = strtolower(str_replace(' ', '_', trim($fullname)));

           $sql = "SELECT id FROM users WHERE email = ? OR username = ?";
           $stmt = $this->conn->prepare($sql);
           $stmt->execute([$email, $username]);
           $result = $stmt->fetch(PDO::FETCH_ASSOC);

           if ($result) {
               return ['success' => false, 'error' => 'Email hoặc username đã được sử dụng!'];
           }

           $sql = "INSERT INTO users (username, email, phone, password, name) VALUES (?, ?, ?, ?, ?)";
           $stmt = $this->conn->prepare($sql);
           if ($stmt->execute([$username, $email, $phone, $password, $fullname])) {
               return ['success' => true, 'message' => 'Đăng ký thành công!'];
           } else {
               return ['success' => false, 'error' => 'Lỗi khi đăng ký. Vui lòng thử lại!'];
           }
       }

       public function getUserByIdentifier($identifier) {
           $sql = "SELECT * FROM users WHERE username = ? OR email = ? OR phone = ?";
           $stmt = $this->conn->prepare($sql);
           if (!$stmt) {
               throw new Exception("Prepare statement failed: " . $this->conn->errorInfo()[2]);
           }
           $stmt->execute([$identifier, $identifier, $identifier]);
           return $stmt->fetch(PDO::FETCH_ASSOC);
       }
   }