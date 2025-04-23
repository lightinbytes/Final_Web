<?php
require_once 'config/Database.php'; // Vẫn giữ như cũ, nhưng không cần gọi getConnection() nữa

class UserModel {
    private $conn;

    public function __construct() {
        // Lấy kết nối từ Database.php sử dụng mysqli
        $this->conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        // Đặt charset để tránh vấn đề mã hóa
        mysqli_set_charset($this->conn, 'utf8mb4');
    }

    // Kiểm tra email đã tồn tại trong cơ sở dữ liệu
    public function emailExists($email) {
        // Sử dụng chuẩn bị câu lệnh SQL để tránh SQL injection
        $stmt = mysqli_prepare($this->conn, "SELECT * FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);  // "s" là kiểu dữ liệu string
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        return $user;
    }

    // Đăng ký người dùng mới
    public function register($email, $password) {
        // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($this->conn, "INSERT INTO users (email, password) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ss", $email, $hashedPassword);  // "ss" là kiểu dữ liệu cho email và password
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }

    // Đăng nhập người dùng
    public function login($email, $password) {
        $stmt = mysqli_prepare($this->conn, "SELECT * FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);  // "s" là kiểu dữ liệu string
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

        // Kiểm tra mật khẩu
        if ($user && password_verify($password, $user['password'])) {
            mysqli_stmt_close($stmt);
            return $user;
        }
        mysqli_stmt_close($stmt);
        return false;
    }

    // Đảm bảo đóng kết nối khi không còn sử dụng
    public function closeConnection() {
        mysqli_close($this->conn);
    }
}
?>
