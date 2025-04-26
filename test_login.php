<?php
define('BASEPATH', true);
define('BASE_PATH', dirname(__DIR__) . '/Final_Web-main/');

$config_path = BASE_PATH . 'database/config.php';
if (file_exists($config_path)) {
    require_once $config_path;
} else {
    die('Lỗi: Không tìm thấy file database/config.php');
}

require_once BASE_PATH . 'app/models/UserModel.php';

$userModel = new UserModel($conn);
$identifier = 'testuser';
$password = 'password123';
$user = $userModel->login($identifier, $password);

if ($user) {
    echo "Đăng nhập thành công! Thông tin user:\n<pre>";
    print_r($user);
    echo "</pre>";
} else {
    echo "Đăng nhập thất bại: Tên đăng nhập hoặc mật khẩu không đúng.";
}
?>