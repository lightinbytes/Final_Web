<?php
// Bật hiển thị lỗi để debug dễ dàng
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Định nghĩa BASEPATH để vượt qua kiểm tra bảo mật
define('BASEPATH', true);

// Định nghĩa đường dẫn gốc của dự án
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__) . '/');
}

// Khởi động session
session_start();

// Load file cấu hình database
if (file_exists(BASE_PATH . 'database/config.php')) {
    require_once BASE_PATH . 'database/config.php';
} else {
    die('Lỗi: Không tìm thấy file database/config.php');
}

// Load HomeController
if (file_exists(BASE_PATH . 'app/controllers/HomeController.php')) {
    require_once BASE_PATH . 'app/controllers/HomeController.php';
} else {
    die('Lỗi: Không tìm thấy file app/controllers/HomeController.php');
}

// Lấy tham số page từ URL
$page = isset($_GET['page']) ? $_GET['page'] : 'index';

// Khởi tạo controller với $conn
$controller = new HomeController($conn);

// Điều hướng đến phương thức tương ứng
switch ($page) {
    case 'contact':
        $controller->contact();
        break;
    case 'cart':
        $controller->cart();
        break;
    case 'checkout':
        $controller->checkout();
        break;
    case 'shop_grid':
        $controller->shop_grid();
        break;
    case 'shop_detail':
        $controller->shop_detail();
        break;
    case 'login':
        $controller = new HomeController($conn);
        $controller->login();
        break;
    case 'signup':
        $controller = new HomeController($conn);
        $controller->signup();
        break;
    case 'account':
        $controller->account();
        break;
    case 'logout':
        session_destroy();
        header("Location: index.php?page=index");
        exit();
    case 'index':
    default:
        $controller->index();
        break;
}
?>