<?php
// Định nghĩa các hằng số
define('BASE_URL', 'http://localhost/Web_FinalProject_Group7-main/public/'); // Thay bằng tên thư mục thực tế
define('ENVIRONMENT', 'development');
define('HOST', 'localhost');
define('DATABASE', 'online_shopping');
define('USERNAME', 'root');
define('PASSWORD', '');

// Cố gắng kết nối đến cơ sở dữ liệu bằng PDO
try {
    $conn = new PDO("mysql:host=" . HOST . ";dbname=" . DATABASE . ";charset=utf8mb4", USERNAME, PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Dừng chương trình nếu kết nối thất bại
    die("Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage());
}

// Đảm bảo $conn tồn tại
if (!isset($conn)) {
    die("Lỗi: Biến \$conn không được khởi tạo.");
}
?>