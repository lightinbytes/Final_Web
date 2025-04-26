<?php
// Định nghĩa BASEPATH để vượt qua kiểm tra bảo mật
define('BASEPATH', true);

// Định nghĩa BASE_PATH để đảm bảo đường dẫn đúng
define('BASE_PATH', dirname(__DIR__) . '/Final_Web-main/');

// Load config.php
$config_path = BASE_PATH . 'database/config.php';
if (file_exists($config_path)) {
    require_once $config_path;
} else {
    die('Lỗi: Không tìm thấy file database/config.php');
}

// Kiểm tra kết nối
if (isset($conn) && $conn instanceof mysqli && !$conn->connect_error) {
    echo "Kết nối database thành công!";
} else {
    echo "Kết nối database thất bại: " . ($conn ? $conn->connect_error : 'Không có kết nối');
}
?>